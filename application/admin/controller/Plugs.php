<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use service\FileService;
use think\View;

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
    public $checkLogin = false;

    /**
     * 默认检查节点访问权限
     * @var bool
     */
    public $checkAuth = false;

    /**
     * 文件上传
     * @return View
     */
    public function upfile() {
        $types = $this->request->get('type', 'jpg,png');
        $mode = $this->request->get('mode', 'one');
        $this->assign('mode', $mode);
        $this->assign('types', $types);
        if (!in_array(($uptype = $this->request->get('uptype')), ['local', 'qiniu'])) {
            $uptype = sysconf('storage_type');
        }
        $this->assign('uptype', $uptype);
        $this->assign('mimes', FileService::getFileMine($types));
        $this->assign('field', $this->request->get('field', 'file'));
        return view();
    }

    /**
     * 通用文件上传
     * @return string
     */
    public function upload() {
        if ($this->request->isPost()) {
            $md5s = str_split($this->request->post('md5'), 16);
            if (($info = $this->request->file('file')->move('static' . DS . 'upload' . DS . $md5s[0], $md5s[1], true))) {
                $filename = join('/', $md5s) . '.' . $info->getExtension();
                $site_url = FileService::getFileUrl($filename, 'local');
                if ($site_url) {
                    return json(['data' => ['site_url' => $site_url], 'code' => 'SUCCESS']);
                }
            }
        }
        return json(['code' => 'ERROR']);
    }

    /**
     * 文件状态检查
     */
    public function upstate() {
        $post = $this->request->post();
        $filename = join('/', str_split($post['md5'], 16)) . '.' . pathinfo($post['filename'], PATHINFO_EXTENSION);
        // 检查文件是否已上传
        if (($site_url = FileService::getFileUrl($filename))) {
            $this->result(['site_url' => $site_url], 'IS_FOUND');
        }
        // 需要上传文件，生成上传配置参数
        $config = ['uptype' => $post['uptype'], 'file_url' => $filename];
        switch (strtolower($post['uptype'])) {
            case 'qiniu':
                $config['server'] = FileService::getUploadQiniuUrl(true);
                $config['token'] = $this->_getQiniuToken($filename);
                break;
            case 'local':
                $config['server'] = FileService::getUploadLocalUrl();
                break;
            case 'oss':
                $time = time() + 3600;
                $policyText = [
                    'expiration' => date('Y-m-d', $time) . 'T' . date('H:i:s', $time) . '.000Z',
                    'conditions' => [
                        ['content-length-range', 0, 1048576000]
                    ]
                ];
                $config['policy'] = base64_encode(json_encode($policyText));
                $config['server'] = FileService::getUploadOssUrl();
                $config['site_url'] = FileService::getBaseUriOss() . $filename;
                $config['signature'] = base64_encode(hash_hmac('sha1', $config['policy'], sysconf('storage_oss_secret'), true));
                $config['OSSAccessKeyId'] = sysconf('storage_oss_keyid');
        }
        $this->result($config, 'NOT_FOUND');
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
        $params = [
            "scope"      => "{$bucket}:{$key}",
            "deadline"   => 3600 + time(),
            "returnBody" => "{\"data\":{\"site_url\":\"{$protocol}://{$host}/$(key)\",\"file_url\":\"$(key)\"}, \"code\": \"SUCCESS\"}",
        ];
        $data = str_replace(['+', '/'], ['-', '_'], base64_encode(json_encode($params)));
        return $accessKey . ':' . str_replace(['+', '/'], ['-', '_'], base64_encode(hash_hmac('sha1', $data, $secretKey, true))) . ':' . $data;
    }

    /**
     * 字体图标
     */
    public function icon() {
        $this->assign('field', $this->request->get('field', 'icon'));
        return view();
    }

}
