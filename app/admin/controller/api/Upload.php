<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
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
use think\exception\HttpResponseException;
use think\file\UploadedFile;
use think\Response;

/**
 * 文件上传接口
 * Class Upload
 * @package app\admin\controller\api
 */
class Upload extends Controller
{

    /**
     * 文件上传脚本
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index(): Response
    {
        $data = ['exts' => []];
        foreach (str2arr(sysconf('storage.allow_exts')) as $ext) {
            $data['exts'][$ext] = Storage::mime($ext);
        }
        $template = realpath(__DIR__ . '/../../view/api/upload.js');
        $data['exts'] = json_encode($data['exts'], JSON_UNESCAPED_UNICODE);
        $data['nameType'] = sysconf('storage.name_type') ?: 'xmd5';
        return view($template, $data)->contentType('application/x-javascript');
    }

    /**
     * 文件上传检查
     * @login true
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function state()
    {
        [$name, $safe] = [input('name'), $this->getSafe()];
        $data = ['uptype' => $this->getType(), 'safe' => intval($safe), 'key' => input('key')];
        if ($info = Storage::instance($data['uptype'])->info($data['key'], $safe, $name)) {
            $data['url'] = $info['url'];
            $data['key'] = $info['key'];
            $this->success('文件已经上传', $data, 200);
        } elseif ('local' === $data['uptype']) {
            $data['url'] = LocalStorage::instance()->url($data['key'], $safe, $name);
            $data['server'] = LocalStorage::instance()->upload();
        } elseif ('qiniu' === $data['uptype']) {
            $data['url'] = QiniuStorage::instance()->url($data['key'], $safe, $name);
            $data['token'] = QiniuStorage::instance()->buildUploadToken($data['key'], 3600, $name);
            $data['server'] = QiniuStorage::instance()->upload();
        } elseif ('alioss' === $data['uptype']) {
            $token = AliossStorage::instance()->buildUploadToken($data['key'], 3600, $name);
            $data['url'] = $token['siteurl'];
            $data['policy'] = $token['policy'];
            $data['signature'] = $token['signature'];
            $data['OSSAccessKeyId'] = $token['keyid'];
            $data['server'] = AliossStorage::instance()->upload();
        } elseif ('txcos' === $data['uptype']) {
            $token = TxcosStorage::instance()->buildUploadToken($data['key'], 3600, $name);
            $data['url'] = $token['siteurl'];
            $data['q-ak'] = $token['q-ak'];
            $data['policy'] = $token['policy'];
            $data['q-key-time'] = $token['q-key-time'];
            $data['q-signature'] = $token['q-signature'];
            $data['q-sign-algorithm'] = $token['q-sign-algorithm'];
            $data['server'] = TxcosStorage::instance()->upload();
        }
        $this->success('获取上传授权参数', $data, 404);
    }

    /**
     * 文件上传入口
     * @login true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function file()
    {
        if (!($file = $this->getFile())->isValid()) {
            $this->error('文件上传异常，文件过大或未上传！');
        }
        $safeMode = $this->getSafe();
        $extension = strtolower($file->getOriginalExtension());
        $saveName = input('key') ?: Storage::name($file->getPathname(), $extension, '', 'md5_file');
        // 检查文件名称是否合法
        if (strpos($saveName, '../') !== false) {
            $this->error('文件路径不能出现跳级操作！');
        }
        // 检查文件后缀是否被恶意修改
        if (pathinfo(parse_url($saveName, PHP_URL_PATH), PATHINFO_EXTENSION) !== $extension) {
            $this->error('文件后缀异常，请重新上传文件！');
        }
        // 屏蔽禁止上传指定后缀的文件
        if (!in_array($extension, str2arr(sysconf('storage.allow_exts')))) {
            $this->error('文件类型受限，请在后台配置规则！');
        }
        if (in_array($extension, ['sh', 'asp', 'bat', 'cmd', 'exe', 'php'])) {
            $this->error('文件安全保护，禁止上传可执行文件！');
        }
        try {
            if ($this->getType() === 'local') {
                $local = LocalStorage::instance();
                $distName = $local->path($saveName, $safeMode);
                $file->move(dirname($distName), basename($distName));
                $info = $local->info($saveName, $safeMode, $file->getOriginalName());
                if (in_array($extension, ['jpg', 'gif', 'png', 'bmp', 'jpeg', 'wbmp'])) {
                    if ($this->imgNotSafe($distName) && $local->del($saveName)) {
                        $this->error('图片未通过安全检查！');
                    }
                    [$width, $height] = getimagesize($distName);
                    if (($width < 1 || $height < 1) && $local->del($saveName)) {
                        $this->error('读取图片的尺寸失败！');
                    }
                }
            } else {
                $bina = file_get_contents($file->getPathname());
                $info = Storage::instance($this->getType())->set($saveName, $bina, $safeMode, $file->getOriginalName());
            }
            if (isset($info['url'])) {
                $this->success('文件上传成功！', ['url' => $safeMode ? $saveName : $info['url']]);
            } else {
                $this->error('文件处理失败，请稍候再试！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 获取文件上传类型
     * @return boolean
     */
    private function getSafe(): bool
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
    private function getType(): string
    {
        $type = strtolower(input('uptype', ''));
        if (in_array($type, ['local', 'qiniu', 'alioss', 'txcos'])) {
            return $type;
        } else {
            return strtolower(sysconf('storage.type'));
        }
    }

    /**
     * 获取本地文件对象
     * @return UploadedFile|void
     */
    private function getFile(): UploadedFile
    {
        try {
            $file = $this->request->file('file');
            if ($file instanceof UploadedFile) {
                return $file;
            } else {
                $this->error('未获取到上传的文件对象！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error(lang($exception->getMessage()));
        }
    }

    /**
     * 检查图片是否安全
     * @param string $filename
     * @return boolean
     */
    private function imgNotSafe(string $filename): bool
    {
        $source = fopen($filename, 'rb');
        if (($size = filesize($filename)) > 512) {
            $hexs = bin2hex(fread($source, 512));
            fseek($source, $size - 512);
            $hexs .= bin2hex(fread($source, 512));
        } else {
            $hexs = bin2hex(fread($source, $size));
        }
        if (is_resource($source)) fclose($source);
        $bins = hex2bin($hexs);
        /* 匹配十六进制中的 <% ( ) %> 或 <? ( ) ?> 或 <script | /script> */
        foreach (['<?php ', '<% ', '<script '] as $key) if (stripos($bins, $key) !== false) return true;
        return preg_match("/(3c25.*?28.*?29.*?253e)|(3c3f.*?28.*?29.*?3f3e)|(3C534352495054)|(2F5343524950543E)|(3C736372697074)|(2F7363726970743E)/is", $hexs);
    }
}
