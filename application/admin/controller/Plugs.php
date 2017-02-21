<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\File;

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
    public function upfile() {
        $types = $this->request->get('type', 'jpg,png');
        $field = $this->request->get('field', 'file');
        $this->assign('field', $field);
        $this->assign('types', $types);
        $this->assign('mimes', File::getMine($types));
        $this->assign('uptype', '');
        return view();
    }

    /**
     * 检查文件上传状态
     */
    public function upstate() {
        $data = $this->request->post();

        $this->result($data, 'IS_UPLOADED');
        $this->result($data, 'NOT_FOUND');
    }

    /**
     * 生成七牛文件上传Token
     * @param string $key
     * @return string
     */
    protected function _getToken($key) {
        $accessKey = sysconf('qiniu_accesskey');
        $secretKey = sysconf('qiniu_secretkey');
        $bucket = sysconf('qiniu_bucket');
        $host = sysconf('qiniu_domain');
        $protocol = sysconf('qiniu_protocol');
        $time = time() + 3600;
        if (empty($key)) {
            exit('param error');
        } else {
            $data = array(
                "scope"      => "{$bucket}:{$key}",
                "deadline"   => $time,
                "returnBody" => "{\"data\":{\"site_url\":\"{$protocol}://{$host}/$(key)\",\"file_url\":\"$(key)\"}, \"code\": \"SUCCESS\"}",
            );
        }
        $find = array('+', '/');
        $replace = array('-', '_');
        $data = str_replace($find, $replace, base64_encode(json_encode($data)));
        $sign = hash_hmac('sha1', $data, $secretKey, true);
        return $accessKey . ':' . str_replace($find, $replace, base64_encode($sign)) . ':' . $data;
    }

    /**
     * 文件上传
     * @return string
     */
    public function upload() {
        if (request()->isPost()) {
            $filepath = 'upload/' . date('Y/md');
            $file = request()->file('file');
            $info = $file->move($filepath);
            if ($info) {
                $data = [];
                $data['uptype'] = 'local';
                $data['md5'] = input('post.md5', $info->md5());
                $data['file_name'] = $info->getFilename();
//                $data['file_type'] = $info->getInfo('type');
                $data['file_path'] = $info->getPathname();
                $data['full_path'] = $info->getRealPath();
                $data['orig_name'] = $info->getInfo('name');
                $data['client_name'] = $info->getInfo('name');
                $data['file_ext'] = $info->getExtension();
                $data['file_url'] = $filepath . '/' . $info->getSaveName();
                $data['site_url'] = pathinfo(request()->baseFile(true), PATHINFO_DIRNAME) . '/' . $data['file_url'];
                $data['file_size'] = $info->getSize();
                $data['create_by'] = get_user_id();
                Db::table('system_file')->insert($data);
                return json(['code' => 'SUCCESS', 'data' => $data]);
            }
        }
        return json([]);
    }

    public function upload() {
        
    }

    /**
     * 字体图标
     */
    public function icon() {
        return view();
    }

}
