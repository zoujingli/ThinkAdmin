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

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Data;
use library\File;
use think\Db;

/**
 * 插件助手控制器
 * Class Plugs
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/21
 */
class Plugs extends BasicAdmin {

    /**
     * 默认检查用户登录状态
     * @var bool
     */
    protected $checkLogin = false;

    /**
     * 默认检查节点访问权限
     * @var bool
     */
    protected $checkAuth = false;

    /**
     * 文件上传
     */
    public function upfile($mode = 'one') {
        $types = $this->request->get('type', 'jpg,png');
        $field = $this->request->get('field', 'file');
        $this->assign('field', $field);
        $this->assign('types', $types);
        $this->assign('mimes', File::getMine($types));
        $this->assign('uptype', sysconf('storage_type'));
        $this->assign('mode', $mode);
        return view();
    }

    /**
     * 检查文件上传状态
     */
    public function upstate() {
        $post = $this->request->post();
        // 组装返回数据
        $data = [];
        $data['uptype'] = $post['uptype'];
        $ext = pathinfo($post['filename'], PATHINFO_EXTENSION);
        $data['file_url'] = join('/', str_split($post['md5'], 16)) . ".{$ext}";
        $data['token'] = $this->_getQiniuToken($data['file_url']);
        $data['server'] = url('admin/plugs/upload');
        // 检查文件是否已经上传
        $fileinfo = Db::name('SystemFile')->where(['uptype' => $post['uptype'], 'md5' => $post['md5']])->find();
        // 七牛云文件写入处理
        if (sysconf('storage_type') === 'qiniu') {
            $data['server'] = sysconf('storage_qiniu_is_https') ? 'https://up.qbox.me' : 'http://upload.qiniu.com';
            if (empty($fileinfo)) {
                $file = [];
                $file['uptype'] = 'qiniu';
                $file['md5'] = $post['md5'];
                $file['real_name'] = $post['filename'];
                $file['file_name'] = pathinfo($data['file_url'], PATHINFO_BASENAME);
                $file['file_path'] = $data['file_url'];
                $file['full_path'] = $data['file_url'];
                $file['file_ext'] = $ext;
                $file['file_url'] = $data['file_url'];
                $file['site_url'] = (sysconf('storage_qiniu_is_https') ? 'https' : 'http') . '://' . sysconf('storage_qiniu_domain') . '/' . $data['file_url'];
                $file['create_by'] = session('user.id');
                Data::save('SystemFile', $file, 'md5', ['uptype' => $post['uptype']]);
            }
        }
        // 本地上传或文件不存在
        if (empty($fileinfo) || ($fileinfo['uptype'] === 'local' && !file_exists($fileinfo['full_path']))) {
            return $this->result($data, 'NOT_FOUND');
        }
        return $this->result($fileinfo, 'IS_FOUND');
    }

    /**
     * 生成七牛文件上传Token
     * @param string $key
     * @return string
     */
    protected function _getQiniuToken($key) {
        $accessKey = sysconf('storage_qiniu_access_key');
        $secretKey = sysconf('storage_qiniu_secret_key');
        $bucket = sysconf('storage_qiniu_bucket');
        $host = sysconf('storage_qiniu_domain');
        $protocol = sysconf('storage_qiniu_is_https') ? 'https' : 'http';
        $time = time() + 3600;
        empty($key) && exit('param error');
        $params = [
            "scope"      => "{$bucket}:{$key}",
            "deadline"   => $time,
            "returnBody" => "{\"data\":{\"site_url\":\"{$protocol}://{$host}/$(key)\",\"file_url\":\"$(key)\"}, \"code\": \"SUCCESS\"}",
        ];
        $find = array('+', '/');
        $replace = array('-', '_');
        $data = str_replace($find, $replace, base64_encode(json_encode($params)));
        $sign = hash_hmac('sha1', $data, $secretKey, true);
        return $accessKey . ':' . str_replace($find, $replace, base64_encode($sign)) . ':' . $data;
    }

    /**
     * 通用文件上传
     * @return string
     */
    public function upload() {
        if ($this->request->isPost()) {
            $md5s = str_split($this->request->post('md5'), 16);
            $filepath = 'upload' . DS . array_shift($md5s);
            $savename = array_shift($md5s);
            if (($info = $this->request->file('file')->move($filepath, $savename, true))) {
                $data = [];
                $data['uptype'] = 'local';
                $data['md5'] = $this->request->post('md5', $info->md5());
                $data['real_name'] = $this->replacePath($info->getInfo('name'));
                $data['file_name'] = $this->replacePath($info->getFilename());
                $data['file_path'] = $this->replacePath($info->getPathname());
                $data['full_path'] = $this->replacePath($info->getRealPath());
                $data['file_ext'] = $info->getExtension();
                $data['file_size'] = $info->getSize();
                $data['file_url'] = $this->replacePath($filepath . '/' . $info->getSaveName());
                $data['site_url'] = $this->replacePath(pathinfo($this->request->baseFile(true), PATHINFO_DIRNAME) . '/' . $data['file_url']);
                $data['create_by'] = session('user.id');
                Data::save('SystemFile', $data, 'md5', ['uptype' => 'local']);
                return json(['data' => $data, 'code' => 'SUCCESS']);
            }
        }
        return json(['code' => 'ERROR']);
    }

    /**
     * 路径替换
     * @param type $path
     * @return type
     */
    protected function replacePath($path) {
        return str_replace('\\', '/', $path);
    }

    /**
     * 字体图标
     */
    public function icon() {
        $this->assign('field', $this->request->get('field', 'icon'));
        return view();
    }

}
