<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace library;

use Exception;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Log;

/**
 * 文件处理库
 *
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/03/19 13:40
 */
class File {

    /**
     * 获取文件MINE信息
     * @param string $exts
     * @return string
     */
    static public function getMine($exts) {
        $_exts = is_string($exts) ? explode(',', $exts) : $exts;
        $_mines = [];
        $mines = require(__DIR__ . DS . 'resource' . DS . 'mines.php');
        foreach ($_exts as $_e) {
            if (isset($mines[strtolower($_e)])) {
                $_exinfo = $mines[strtolower($_e)];
                $_mines[] = is_array($_exinfo) ? join(',', $_exinfo) : $_exinfo;
            }
        }
        return join(',', $_mines);
    }

    /**
     * 存储微信上传的文件
     * @param string $appid 公众号APPID
     * @param string $medias MediaID列表
     * @param string $ext 文件后缀
     * @param string $method 获取素材接口方法（getForeverMedia|getMedia）
     * @param string $split 多项分割符
     * @param array $list 文件URL列表
     * @return string
     */
    static public function wechat($appid, $medias, $ext = '.png', $method = 'getMedia', $split = ',', $list = array()) {
        $wechat = &load_wechat('Media', $appid);
        if (is_string($medias)) {
            $medias = explode($split, $medias);
        }
        foreach ($medias as $media_id) {
            if (stripos($media_id, 'http') === 0) {
                $list[] = $media_id;
                continue;
            }
            $filename = 'wechat/' . join('/', str_split(md5($media_id), 16)) . $ext;
            $content = $wechat->$method($media_id, (strtolower($ext) === '.mp4'));
            if ($content === FALSE) {
                Log::record("获取微信素材失败，{$wechat->errMsg}" . var_export(func_get_args(), TRUE), Log::ERROR);
                continue;
            }
            // 视频需要处理
            if (strtolower($ext) === '.mp4' && is_array($content) && isset($content['down_url'])) {
                $content = file_get_contents($content['down_url']);
                // 半个小时就失效了
                // $list[] = $content['down_url'];
                // continue;
            }
            $result = self::save($filename, $content, 'qiniu');
            if ($result !== false && isset($result['url'])) {
                $list[] = $result['url'];
            }
        }
        return join($split, $list);
    }

    /**
     * 根据Key读取文件内容
     * @param type $filename
     * @param type $file_storage
     * @return type
     */
    static public function get($filename, $file_storage = NULL) {
        switch (empty($file_storage) ? sysconf('file_storage') : $file_storage) {
            case 'local':
                if (file_exists(ROOT_PATH . 'public/upload/' . $filename)) {
                    return file_get_contents(ROOT_PATH . 'public/upload/' . $filename);
                }
            case 'qiniu':
                $auth = new Auth(sysconf('qiniu_accesskey'), sysconf('qiniu_secretkey'));
                return file_get_contents($auth->privateDownloadUrl(sysconf('qiniu_protocol') . '://' . sysconf('qiniu_domain') . '/' . $filename));
        }
        return null;
    }

    /**
     * 根据当前配置存储文件
     * @param string $filename
     * @param string $bodycontent
     * @param string|null $file_storage
     * @return array|null
     */
    static public function save($filename, $bodycontent, $file_storage = NULL) {
        $type = empty($file_storage) ? sysconf('file_storage') : $file_storage;
        if (!method_exists(__CLASS__, $type)) {
            Log::record("保存存储失败，调用{$type}存储引擎不存在！", Log::ERROR);
            return null;
        }
        return self::$type($filename, $bodycontent);
    }

    /**
     * 文件储存在本地
     * @param string $filename
     * @param string $bodycontent
     * @return string
     */
    static public function local($filename, $bodycontent) {
        $filepath = ROOT_PATH . 'public/upload/' . $filename;
        try {
            !is_dir(dirname($filepath)) && mkdir(dirname($filepath), '0755', true);
            if (file_put_contents($filepath, $bodycontent)) {
                return array(
                    'hash' => md5_file($filepath),
                    'key'  => "upload/{$filename}",
                    'url'  => pathinfo(request()->baseFile(true), PATHINFO_DIRNAME) . '/upload/' . $filename
                );
            }
        } catch (Exception $err) {
            Log::record('本地文件存储失败, ' . var_export($err, true), Log::ERROR);
        }
        return null;
    }

    /**
     * 七牛云存储
     * @param string $filename
     * @param string $bodycontent
     * @return string
     */
    static public function qiniu($filename, $bodycontent) {
        $auth = new Auth(sysconf('qiniu_accesskey'), sysconf('qiniu_secretkey'));
        $token = $auth->uploadToken(sysconf('qiniu_bucket'));
        $uploadMgr = new UploadManager();
        list($result, $err) = $uploadMgr->put($token, $filename, $bodycontent);
        if ($err !== null) {
            Log::record('七牛云文件上传失败, ' . var_export($err, true), Log::ERROR);
            return null;
        } else {
            $result['url'] = sysconf('qiniu_protocol') . '://' . sysconf('qiniu_domain') . '/' . $filename;
            return $result;
        }
    }

}
