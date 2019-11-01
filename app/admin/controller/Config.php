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

namespace app\admin\controller;

use think\admin\Controller;

/**
 * 系统参数配置
 * Class Config
 * @package app\admin\controller
 */
class Config extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemConfig';

    /**
     * 绑定数据表
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '系统参数配置';
        $this->fetch();
    }

    /**
     * 修改系统能数配置
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->title = '系统参数配置';
            $this->fetch();
        }
        foreach ($this->request->post() as $key => $value) {
            sysconf($key, $value);
        }
        $this->success('系统参数配置成功！');
    }

    /**
     * 文件存储引擎
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function storage()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->type = input('type', 'local');
            $this->fetch("storage-{$this->type}");
        }
        $post = $this->request->post();
        if (!empty($post['storage']['allow_exts'])) {
            $exts = array_unique(explode(',', strtolower($post['storage']['allow_exts'])));
            sort($exts);
            if (in_array('php', $exts)) $this->error('禁止上传可执行文件到本地服务器！');
            $post['storage']['allow_exts'] = join(',', $exts);
        }
        foreach ($post as $key => $value) sysconf($key, $value);
        $this->success('文件存储配置成功！');
    }

}