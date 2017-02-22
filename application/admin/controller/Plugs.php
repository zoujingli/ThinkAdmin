<?php

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
        $data = array();
        $data['uptype'] = $post['uptype'];
        $data['file_url'] = date('Y/md') . "/{$post['md5']}." . pathinfo($post['filename'], 4);
        $data['token'] = $this->_getQiniuToken($data['file_url']);
        $data['server'] = url('admin/plugs/upload');
        $file = Db::name('SystemFile')->where(['uptype' => $post['uptype'], 'md5' => $post['md5']])->find();
        // 本地上传或文件不存在
        if (empty($file) || ($file['uptype'] === 'local' && !file_exists($file['full_path']))) {
            return $this->result($data, 'NOT_FOUND');
        }
        return $this->result($file, 'IS_FOUND');
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
            $filepath = 'upload' . DS . date('Y/md');
            $file = $this->request->file('file');
            if (($info = $file->move($filepath))) {
                $data = [];
                $data['uptype'] = 'local';
                $data['md5'] = $this->request->post('md5', $info->md5());
                $data['real_name'] = $info->getInfo('name');
                $data['file_name'] = $info->getFilename();
                $data['file_path'] = $info->getPathname();
                $data['full_path'] = $info->getRealPath();
                $data['file_ext'] = $info->getExtension();
                $data['file_size'] = $info->getSize();
                $data['file_url'] = str_replace('\\', '/', $filepath . '/' . $info->getSaveName());
                $data['site_url'] = pathinfo($this->request->baseFile(true), PATHINFO_DIRNAME) . '/' . $data['file_url'];
                $data['create_by'] = session('user.id');
                Data::save('SystemFile', $data, 'md5', ['uptype' => 'local']);
                return json(['data' => $data, 'code' => 'SUCCESS']);
            }
        }
        return json(['code' => 'ERROR']);
    }

    /**
     * 字体图标
     */
    public function icon() {
        return view();
    }

}
