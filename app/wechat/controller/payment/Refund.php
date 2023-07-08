<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\wechat\controller\payment;

use app\wechat\model\WechatFans;
use app\wechat\model\WechatPaymentRecord;
use app\wechat\model\WechatPaymentRefund;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 支付退款管理
 * @class Refund
 * @package app\wechat\controller
 */
class Refund extends Controller
{
    /**
     * 支付退款管理
     * @auth true
     * @menu true
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        WechatPaymentRefund::mQuery()->layTable(function () {
            $this->title = '支付退款管理';
        }, function (QueryHelper $query) {
            $query->with(['record'])->like('code|refund_trade#refund');
            if (($this->get['order'] ?? '') . ($this->get['nickname'] ?? '') . ($this->get['payment'] ?? '') . ($this->get['refund'] ?? '') !== '') {
                $db1 = WechatFans::mQuery()->field('openid')->like('openid|nickname#nickname')->db();
                $db2 = WechatPaymentRecord::mQuery()->like('order_code|order_name#order,code|payment_trade#payment');
                $db2->whereRaw("openid in {$db1->buildSql()}");
                $query->whereRaw("record_code in {$db2->field('code')->db()->buildSql()}");
            }
        });
    }
}