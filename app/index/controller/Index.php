<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\admin\Controller;

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        $this->redirect(sysuri('admin/login/index'));
    }

    /**
     * 重置系统数据
     */
    public function reset()
    {
        exit();
        $this->_query('data_user')->empty();
        $this->_query('data_user_token')->empty();
        $this->_query('data_user_address')->empty();

        $this->_query('data_user_rebate')->empty();
        $this->_query('data_user_balance')->empty();
        $this->_query('data_user_transfer')->empty();

        $this->_query('shop_order')->empty();
        $this->_query('shop_order_item')->empty();
        $this->_query('shop_order_send')->empty();
        $this->_query('shop_payment_item')->empty();
    }
}