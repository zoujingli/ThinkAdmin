<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemFile;
use think\admin\service\AdminService;
use think\admin\Storage;
use think\admin\storage\AliossStorage;
use think\admin\storage\AlistStorage;
use think\admin\storage\LocalStorage;
use think\admin\storage\QiniuStorage;
use think\admin\storage\TxcosStorage;
use think\admin\storage\UpyunStorage;
use think\exception\HttpResponseException;
use think\file\UploadedFile;
use think\Response;

/**
 * 文件上传接口
 * @class Upload
 * @package app\admin\controller\api
 */
class Upload extends Controller
{
    /**
     * 文件上传脚本
     * @return Response
     * @throws \think\admin\Exception
     */
    public function index(): Response
    {
        $data = ['exts' => []];
        [$uuid, $unid, $exts] = $this->initUnid(false);
        $allows = str2arr(sysconf('storage.allow_exts|raw'));
        if (empty($uuid) && $unid > 0) $allows = array_intersect($exts, $allows);
        foreach ($allows as $ext) $data['exts'][$ext] = Storage::mime($ext);
        $template = realpath(__DIR__ . '/../../view/api/upload.js');
        $data['exts'] = json_encode($data['exts'], JSON_UNESCAPED_UNICODE);
        $data['nameType'] = sysconf('storage.name_type|raw') ?: 'xmd5';
        return view($template, $data)->contentType('application/x-javascript');
    }

    /**
     * 文件选择器
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function image()
    {
        [$uuid, $unid] = $this->initUnid();
        SystemFile::mQuery()->layTable(function () {
            $this->title = '文件选择器';
        }, function (QueryHelper $query) use ($unid, $uuid) {
            if ($unid && $uuid) $query->where(function ($query) use ($uuid, $unid) {
                /** @var \think\db\Query $query */
                $query->whereOr([['uuid', '=', $uuid], ['unid', '=', $unid]]);
            }); else {
                $query->where($unid ? ['unid' => $unid] : ['uuid' => $uuid]);
            }
            $query->where(['status' => 2, 'issafe' => 0])->in('xext#type');
            $query->like('name,hash')->dateBetween('create_at')->order('id desc');
        });
    }

    /**
     * 文件上传检查
     */
    public function state()
    {
        try {
            [$uuid, $unid] = $this->initUnid();
            [$name, $safe] = [input('name'), $this->getSafe()];
            $data = ['uptype' => $this->getType(), 'safe' => intval($safe), 'key' => input('key')];
            $file = SystemFile::mk()->data($this->_vali([
                'xkey.value'   => $data['key'],
                'type.value'   => $this->getType(),
                'uuid.value'   => $uuid,
                'unid.value'   => $unid,
                'name.require' => '名称不能为空！',
                'hash.require' => '哈希不能为空！',
                'xext.require' => '后缀不能为空！',
                'size.require' => '大小不能为空！',
                'mime.default' => '',
                'status.value' => 1,
            ]));
            $mime = $file->getAttr('mime');
            if (empty($mime)) $file->setAttr('mime', Storage::mime($file->getAttr('xext')));
            $info = Storage::instance($data['uptype'])->info($data['key'], $safe, $name);
            if (isset($info['url']) && isset($info['key'])) {
                $file->save(['xurl' => $info['url'], 'isfast' => 1, 'issafe' => $data['safe']]);
                $extr = ['id' => $file->id ?? 0, 'url' => $info['url'], 'key' => $info['key']];
                $this->success('文件已经上传', array_merge($data, $extr), 200);
            } elseif ('local' === $data['uptype']) {
                $local = LocalStorage::instance();
                $data['url'] = $local->url($data['key'], $safe, $name);
                $data['server'] = $local->upload();
            } elseif ('qiniu' === $data['uptype']) {
                $qiniu = QiniuStorage::instance();
                $data['url'] = $qiniu->url($data['key'], $safe, $name);
                $data['token'] = $qiniu->token($data['key'], 3600, $name);
                $data['server'] = $qiniu->upload();
            } elseif ('alioss' === $data['uptype']) {
                $alioss = AliossStorage::instance();
                $token = $alioss->token($data['key'], 3600, $name);
                $data['url'] = $token['siteurl'];
                $data['policy'] = $token['policy'];
                $data['signature'] = $token['signature'];
                $data['OSSAccessKeyId'] = $token['keyid'];
                $data['server'] = $alioss->upload();
            } elseif ('txcos' === $data['uptype']) {
                $txcos = TxcosStorage::instance();
                $token = $txcos->token($data['key'], 3600, $name);
                $data['url'] = $token['siteurl'];
                $data['q-ak'] = $token['q-ak'];
                $data['policy'] = $token['policy'];
                $data['q-key-time'] = $token['q-key-time'];
                $data['q-signature'] = $token['q-signature'];
                $data['q-sign-algorithm'] = $token['q-sign-algorithm'];
                $data['server'] = $txcos->upload();
            } elseif ('upyun' === $data['uptype']) {
                $upyun = UpyunStorage::instance();
                $token = $upyun->token($data['key'], 3600, $name, input('hash', ''));
                $data['url'] = $token['siteurl'];
                $data['policy'] = $token['policy'];
                $data['server'] = $upyun->upload();
                $data['authorization'] = $token['authorization'];
            } elseif ('alist' === $data['uptype']) {
                $alist = AlistStorage::instance();
                $data['url'] = $alist->url($data['key']);
                $data['server'] = $alist->upload();
                $data['filepath'] = $alist->real($data['key'], true);
                $data['authorization'] = $alist->token();
            } else {
                $this->error('未知的存储引擎！');
            }
            $file->save(['xurl' => $data['url'], 'isfast' => 0, 'issafe' => $data['safe']]);
            $this->success('获取上传授权参数', array_merge($data, ['id' => $file->id ?? 0]), 404);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 更新文件状态
     * @return void
     */
    public function done()
    {
        [$uuid, $unid] = $this->initUnid();
        $data = $this->_vali([
            'id.require'   => '编号不能为空！',
            'hash.require' => '哈希不能为空！',
            'uuid.value'   => $uuid,
            'unid.value'   => $unid,
        ]);
        $file = SystemFile::mk()->where($data)->findOrEmpty();
        if ($file->isEmpty()) $this->error('文件不存在！');
        if ($file->save(['status' => 2])) {
            $this->success('更新成功！');
        } else {
            $this->error('更新失败！');
        }
    }

    /**
     * 文件上传入口
     * @throws \think\admin\Exception
     */
    public function file()
    {
        [$uuid, $unid, $unexts] = $this->initUnid();
        // 开始处理文件上传
        $file = $this->getFile();
        $extension = strtolower($file->getOriginalExtension());
        $saveFileName = input('key') ?: Storage::name($file->getPathname(), $extension, '', 'md5_file');
        // 检查文件名称是否合法
        if (strpos($saveFileName, '../') !== false) {
            $this->error('文件路径不能出现跳级操作！');
        }
        // 检查文件后缀是否被恶意修改
        if (strtolower(pathinfo(parse_url($saveFileName, PHP_URL_PATH), PATHINFO_EXTENSION)) !== $extension) {
            $this->error('文件后缀异常，请重新上传文件！');
        }
        // 屏蔽禁止上传指定后缀的文件
        if (!in_array($extension, str2arr(sysconf('storage.allow_exts|raw')))) {
            $this->error('文件类型受限，请在后台配置规则！');
        }
        // 前端用户上传后缀检查处理
        if (empty($uuid) && $unid > 0 && !in_array($extension, $unexts)) {
            $this->error('文件类型受限，请上传允许的文件类型！');
        }
        if (in_array($extension, ['sh', 'asp', 'bat', 'cmd', 'exe', 'php'])) {
            $this->error('文件安全保护，禁止上传可执行文件！');
        }
        try {
            $safeMode = $this->getSafe();
            if (($type = $this->getType()) === 'local') {
                $local = LocalStorage::instance();
                $distName = $local->path($saveFileName, $safeMode);
                if (PHP_SAPI === 'cli') {
                    is_dir(dirname($distName)) || mkdir(dirname($distName), 0777, true);
                    rename($file->getPathname(), $distName);
                } else {
                    $file->move(dirname($distName), basename($distName));
                }
                $info = $local->info($saveFileName, $safeMode, $file->getOriginalName());
                if (in_array($extension, ['jpg', 'gif', 'png', 'bmp', 'jpeg', 'wbmp'])) {
                    if ($this->imgNotSafe($distName) && $local->del($saveFileName)) {
                        $this->error('图片未通过安全检查！');
                    }
                    [$width, $height] = getimagesize($distName);
                    if (($width < 1 || $height < 1) && $local->del($saveFileName)) {
                        $this->error('读取图片的尺寸失败！');
                    }
                }
            } else {
                $bina = file_get_contents($file->getPathname());
                $info = Storage::instance($type)->set($saveFileName, $bina, $safeMode, $file->getOriginalName());
            }
            if (isset($info['url'])) {
                $this->success('文件上传成功！', ['url' => $safeMode ? $saveFileName : $info['url']]);
            } else {
                $this->error('文件处理失败，请稍候再试！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        }
    }

    /**
     * 获取上传类型
     * @return boolean
     */
    private function getSafe(): bool
    {
        return boolval(input('safe', '0'));
    }

    /**
     * 获取上传方式
     * @return string
     * @throws \think\admin\Exception
     */
    private function getType(): string
    {
        $type = strtolower(input('uptype', ''));
        if (in_array($type, ['local', 'qiniu', 'alioss', 'txcos', 'uptype'])) {
            return $type;
        } else {
            return strtolower(sysconf('storage.type|raw'));
        }
    }

    /**
     * 获取文件对象
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
            trace_file($exception);
            $this->error(lang($exception->getMessage()));
        }
    }

    /**
     * 初始化用户状态
     * @param boolean $check
     * @return array
     */
    private function initUnid(bool $check = true): array
    {
        $uuid = AdminService::getUserId();
        [$unid, $exts] = AdminService::withUploadUnid();
        if ($check && empty($uuid) && empty($unid)) {
            $this->error('未登录，禁止使用文件上传！');
        } else {
            return [$uuid, $unid, $exts];
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
