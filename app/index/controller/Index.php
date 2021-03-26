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
        exit('Disable Reset.');

        $this->_query('DataUser')->empty();
        $this->_query('DataUserToken')->empty();
        $this->_query('DataUserAddress')->empty();

        $this->_query('DataUserRebate')->empty();
        $this->_query('DataUserBalance')->empty();
        $this->_query('DataUserTransfer')->empty();

        $this->_query('ShopOrder')->empty();
        $this->_query('ShopOrderItem')->empty();
        $this->_query('ShopOrderSend')->empty();
        $this->_query('DataUserPayment')->empty();
    }
}