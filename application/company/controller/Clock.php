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

namespace app\company\controller;

use library\Controller;

/**
 * 网络打卡管理
 * Class Clock
 * @package app\company\controller
 */
class Clock extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'CompanyUserClock';

    /**
     * 网络打卡管理
     * @auth true
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '网络打卡管理';
        $this->_query($this->table)->like('name')->equal('date')->order('id asc')->page();
    }

}
