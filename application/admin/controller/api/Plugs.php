<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use library\Controller;
use library\File;
use think\Db;

/**
 * 后台插件管理
 * Class Plugs
 * @package app\admin\controller\api
 */
class Plugs extends Controller
{

    /**
     * Plugs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!\app\admin\service\Auth::isLogin()) {
            $this->error('访问授权失败，请重新登录授权再试！');
        }
    }

    /**
     * 文件状态检查
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function upstate()
    {
        $ext = strtolower(pathinfo($this->request->post('filename', ''), PATHINFO_EXTENSION));
        $name = File::name($this->request->post('md5'), $ext, '', 'strtolower');
        // 检查文件是否已上传
        $this->safe = $this->getUploadSafe();
        if (is_string($siteUrl = File::url($name))) {
            $this->success('检测到该文件已经存在，无需再次上传！', [
                'site_url' => $this->safe ? $name : $siteUrl,
            ]);
        }
        // 文件驱动
        $file = File::instance($this->getUploadType());
        // 生成上传授权参数
        $param = [
            'file_url' => $name, 'uptype' => $this->uptype, 'token' => md5($name . session_id()),
            'site_url' => $file->base($name), 'server' => $file->upload(), 'safe' => $this->safe,
        ];
        if (strtolower($this->uptype) === 'qiniu') {
            $auth = new \Qiniu\Auth(sysconf('storage_qiniu_access_key'), sysconf('storage_qiniu_secret_key'));
            $param['token'] = $auth->uploadToken(sysconf('storage_qiniu_bucket'), $name, 3600, [
                'returnBody' => json_encode(['code' => 1, 'data' => ['site_url' => $file->base($name)]], JSON_UNESCAPED_UNICODE),
            ]);
        } elseif (strtolower($this->uptype) === 'oss') {
            $param['OSSAccessKeyId'] = sysconf('storage_oss_keyid');
            $param['policy'] = base64_encode(json_encode(['conditions' => [['content-length-range', 0, 1048576000]], 'expiration' => gmdate("Y-m-d\TH:i:s\Z", time() + 3600)]));
            $param['signature'] = base64_encode(hash_hmac('sha1', $param['policy'], sysconf('storage_oss_secret'), true));
        }
        $this->error('未检测到文件，需要上传完整的文件！', $param);
    }

    /**
     * 文件上传
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function upfile()
    {
        $this->safe = $this->getUploadSafe();
        $this->uptype = $this->getUploadType();
        $this->mode = $this->request->get('mode', 'one');
        $this->field = $this->request->get('field', 'file');
        $this->types = $this->request->get('type', 'jpg,png');
        $this->mimes = File::mine($this->types);
        $this->fetch();
    }

    /**
     * WebUpload 文件上传
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function upload()
    {
        // 文件接收
        if (!($file = $this->getUploadFile()) || empty($file)) {
            $this->error('文件上传异常，文件可能过大或未上传！');
        }
        if (!$file->checkExt(strtolower(sysconf('storage_local_exts')))) {
            $this->error('文件上传类型受限，请在后台配置！');
        }
        if ($file->checkExt('php')) {
            $this->error('可执行文件禁止上传到本地服务器！');
        }
        // 唯一名称
        $ext = strtolower(pathinfo($file->getInfo('name'), PATHINFO_EXTENSION));
        $name = File::name($this->request->post('md5'), $ext, '', 'strtolower');
        // Token 验证
        if ($this->request->post('token') !== md5($name . session_id())) {
            $this->error('文件上传验证失败，请刷新页面重新上传！');
        }
        $this->safe = $this->getUploadSafe();
        $pathinfo = pathinfo(File::instance('local')->path($name, $this->safe));
        if ($file->move($pathinfo['dirname'], $pathinfo['basename'], true)) {
            if (is_array($info = File::instance('local')->info($name, $this->safe)) && isset($info['url'])) {
                $this->success('文件上传成功！', ['site_url' => $this->safe ? $name : $info['url']]);
            }
        }
        $this->error('文件上传失败，请稍候再试！');
    }

    /**
     * Plupload 插件上传文件
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function plupload()
    {
        if (!($file = $this->getUploadFile()) || empty($file)) {
            return json(['uploaded' => false, 'error' => ['message' => '文件上传异常，文件可能过大或未上传']]);
        }
        if (!$file->checkExt(strtolower(sysconf('storage_local_exts')))) {
            return json(['uploaded' => false, 'error' => ['message' => '文件上传类型受限，请在后台配置']]);
        }
        if ($file->checkExt('php')) {
            return json(['uploaded' => false, 'error' => ['message' => '可执行文件禁止上传到本地服务器']]);
        }
        $this->safe = $this->getUploadSafe();
        $this->uptype = $this->getUploadType();
        $this->ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
        $name = File::name($file->getPathname(), $this->ext, '', 'md5_file');
        $info = File::instance($this->uptype)->save($name, file_get_contents($file->getRealPath()), $this->safe);
        if (is_array($info) && isset($info['url'])) {
            return json(['uploaded' => true, 'filename' => $name, 'url' => $this->safe ? $name : $info['url']]);
        }
        return json(['uploaded' => false, 'error' => ['message' => '文件处理失败，请稍候再试！']]);
    }

    /**
     * 获取文件上传方式
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function getUploadType()
    {
        $this->uptype = input('uptype');
        if (!in_array($this->uptype, ['local', 'oss', 'qiniu'])) {
            $this->uptype = sysconf('storage_type');
        }
        return $this->uptype;
    }

    /**
     * 获取上传安全模式
     * @return boolean
     */
    private function getUploadSafe()
    {
        return $this->safe = boolval(input('safe'));
    }

    /**
     * 获取本地文件对象
     * @return \think\File
     */
    private function getUploadFile()
    {
        try {
            return $this->request->file('file');
        } catch (\Exception $e) {
            $this->error(lang($e->getMessage()));
        }
    }

    /**
     * 系统选择器图标
     * @return mixed
     */
    public function icon()
    {
        $this->title = '图标选择器';
        $this->field = input('field', 'icon');
        $this->fetch();
    }

    /**
     * 系统消息展示
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function message()
    {
        $this->title = '系统消息';
        $this->list = Db::name('SystemMessage')->where(['read_state' => '0'])->order('id desc')->select();
        $this->fetch();
    }

}