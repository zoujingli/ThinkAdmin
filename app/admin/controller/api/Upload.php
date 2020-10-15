<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\Storage;
use think\admin\storage\AliossStorage;
use think\admin\storage\LocalStorage;
use think\admin\storage\QiniuStorage;
use think\admin\storage\TxcosStorage;

/**
 * 文件上传接口
 * Class Upload
 * @package app\admin\controller\api
 */
class Upload extends Controller
{

    /**
     * 文件上传JS支持
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $data = ['exts' => []];
        foreach (explode(',', sysconf('storage.allow_exts')) as $ext) {
            $data['exts'][$ext] = Storage::mime($ext);
        }
        $template = realpath(__DIR__ . '/../../view/api/upload.js');
        $data['exts'] = json_encode($data['exts'], JSON_UNESCAPED_UNICODE);
        return view($template, $data)->contentType('application/x-javascript');
    }

    /**
     * 检查文件上传已经上传
     * @login true
     * @throws \think\Exception
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function state()
    {
        [$this->name, $this->safe] = [input('name', null), $this->getSafe()];
        $data = ['uptype' => $this->getType(), 'xkey' => input('xkey'), 'safe' => intval($this->safe)];
        if ($info = Storage::instance($data['uptype'])->info($data['xkey'], $this->safe, $this->name)) {
            $data['url'] = $info['url'];
            $this->success('文件已经上传', $data, 200);
        } elseif ('local' === $data['uptype']) {
            $data['url'] = LocalStorage::instance()->url($data['xkey'], $this->safe, $this->name);
            $data['server'] = LocalStorage::instance()->upload();
        } elseif ('qiniu' === $data['uptype']) {
            $data['url'] = QiniuStorage::instance()->url($data['xkey'], $this->safe, $this->name);
            $data['token'] = QiniuStorage::instance()->buildUploadToken($data['xkey'], 3600, $this->name);
            $data['server'] = QiniuStorage::instance()->upload();
        } elseif ('alioss' === $data['uptype']) {
            $token = AliossStorage::instance()->buildUploadToken($data['xkey'], 3600, $this->name);
            $data['url'] = $token['siteurl'];
            $data['policy'] = $token['policy'];
            $data['signature'] = $token['signature'];
            $data['OSSAccessKeyId'] = $token['keyid'];
            $data['server'] = AliossStorage::instance()->upload();
        } elseif ('txcos' === $data['uptype']) {
            $token = TxcosStorage::instance()->buildUploadToken($data['xkey'], 3600, $this->name);
            $data['url'] = $token['siteurl'];
            $data['q-ak'] = $token['q-ak'];
            $data['policy'] = $token['policy'];
            $data['q-key-time'] = $token['q-key-time'];
            $data['q-sign-algorithm'] = $token['q-sign-algorithm'];
            $data['server'] = TxcosStorage::instance()->upload();
        }
        $this->success('获取授权参数', $data, 404);
    }

    /**
     * 文件上传入口
     * @login true
     * @return \think\response\Json
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function file()
    {
        if (!($file = $this->getFile()) || empty($file)) {
            return json(['uploaded' => false, 'error' => ['message' => '文件上传异常，文件可能过大或未上传']]);
        }
        $this->extension = strtolower($file->getOriginalExtension());
        if (!in_array($this->extension, explode(',', strtolower(sysconf('storage.allow_exts'))))) {
            return json(['uploaded' => false, 'error' => ['message' => '文件上传类型受限，请在后台配置']]);
        }
        if (in_array($this->extension, ['php', 'sh'])) {
            return json(['uploaded' => false, 'error' => ['message' => '可执行文件禁止上传到本地服务器']]);
        }
        [$this->safe, $this->uptype, $this->name] = [$this->getSafe(), $this->getType(), input('xkey')];
        if (empty($this->name)) $this->name = Storage::name($file->getPathname(), $this->extension, '', 'md5_file');
        if ($this->uptype === 'local') {
            $local = LocalStorage::instance();
            $realpath = dirname($realname = $local->path($this->name, $this->safe));
            file_exists($realpath) && is_dir($realpath) || mkdir($realpath, 0755, true);
            @rename($file->getPathname(), $realname);
            $info = $local->info($this->name, $this->safe, $file->getOriginalName());
        } else {
            $bina = file_get_contents($file->getRealPath());
            $info = Storage::instance($this->uptype)->set($this->name, $bina, $this->safe, $file->getOriginalName());
        }
        if (is_array($info) && isset($info['url'])) {
            return json(['uploaded' => true, 'filename' => $this->name, 'url' => $this->safe ? $this->name : $info['url']]);
        } else {
            return json(['uploaded' => false, 'error' => ['message' => '文件处理失败，请稍候再试！']]);
        }
    }

    /**
     * 获取文件上传类型
     * @return boolean
     */
    private function getSafe()
    {
        return boolval(input('safe', '0'));
    }

    /**
     * 获取文件上传方式
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getType()
    {
        $this->uptype = strtolower(input('uptype', ''));
        if (!in_array($this->uptype, ['local', 'qiniu', 'alioss', 'txcos'])) {
            $this->uptype = strtolower(sysconf('storage.type'));
        }
        return strtolower($this->uptype);
    }

    /**
     * 获取本地文件对象
     * @return \think\file\UploadedFile
     */
    private function getFile()
    {
        try {
            return $this->request->file('file');
        } catch (\Exception $exception) {
            $this->error(lang($exception->getMessage()));
        }
    }

}
