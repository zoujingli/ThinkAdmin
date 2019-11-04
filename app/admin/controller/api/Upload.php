<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use app\admin\service\AuthService;
use think\admin\Controller;
use think\admin\Storage;

/**
 * 文件上传接口
 * Class Upload
 * @package app\admin\controller\api
 */
class Upload extends Controller
{
    /**
     * 上传安全检查
     * @login true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function check()
    {
        $diff1 = explode(',', strtolower(input('exts', '')));
        $diff2 = explode(',', strtolower(sysconf('storage.allow_exts')));
        $exts = array_intersect($diff1, $diff2);
        $this->success('获取文件上传参数', [
            'type' => $this->getType(), 'data' => $this->getData(),
            'exts' => join('|', $exts), 'mine' => Storage::mime($exts),
        ]);
    }

    /**
     * 文件上传入口
     * @login true
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function file()
    {
        if (!AuthService::isLogin()) {
            $this->error('访问授权失败，请重新登录授权再试！');
        }
        if (!($file = $this->getFile()) || empty($file)) {
            return json(['uploaded' => false, 'error' => ['message' => '文件上传异常，文件可能过大或未上传']]);
        }
        $this->extension = $file->getOriginalExtension();
        if (!in_array($this->extension, explode(',', sysconf('storage.allow_exts')))) {
            return json(['uploaded' => false, 'error' => ['message' => '文件上传类型受限，请在后台配置']]);
        }
        if (in_array($this->extension, ['php', 'sh'])) {
            return json(['uploaded' => false, 'error' => ['message' => '可执行文件禁止上传到本地服务器']]);
        }
        $this->safe = boolval(input('safe'));
        $this->uptype = $this->getType();
        $name = Storage::name($file->getPathname(), $this->extension, '', 'md5_file');
        $info = Storage::instance($this->uptype)->set($name, file_get_contents($file->getRealPath()), $this->safe);
        if (is_array($info) && isset($info['url'])) {
            return json(['uploaded' => true, 'filename' => $name, 'url' => $this->safe ? $name : $info['url']]);
        } else {
            return json(['uploaded' => false, 'error' => ['message' => '文件处理失败，请稍候再试！']]);
        }
    }

    /**
     * 获取文件上传参数
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getData()
    {
        if ($this->getType() === 'qiniu') {
            $file = Storage::instance('qiniu');
            return ['url' => $file->upload(), 'token' => $file->buildUploadToken(), 'uptype' => $this->getType()];
        } else {
            $file = Storage::instance('local');
            return ['url' => $file->upload(), 'token' => uniqid('local_upload_'), 'uptype' => $this->getType()];
        }
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
        $this->uptype = input('uptype');
        if (!in_array($this->uptype, ['local', 'qiniu'])) {
            $this->uptype = sysconf('storage.type');
        }
        return $this->uptype;
    }

    /**
     * 获取本地文件对象
     * @return \think\file\UploadedFile
     */
    private function getFile()
    {
        try {
            return $this->request->file('file');
        } catch (\Exception $e) {
            $this->error(lang($e->getMessage()));
        }
    }
}