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

namespace app\service\controller;

use think\admin\Controller;

/**
 * 开放平台参数配置
 * Class Config
 * @package app\service\controller
 */
class Config extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'WechatServiceConfig';

    /**
     * 开放平台配置
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '开放平台参数配置';
        $this->fetch();
    }

    /**
     * 修改开放平台参数
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->fetch('form');
        } else {
            $post = $this->request->post();
            foreach ($post as $k => $v) sysconf($k, $v);
            $this->success('参数修改成功！');
        }
    }

}