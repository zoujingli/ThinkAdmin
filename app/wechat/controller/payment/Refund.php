<?php

declare(strict_types=1);
/**
 * +----------------------------------------------------------------------
 * | ThinkAdmin Plugin for ThinkAdmin
 * +----------------------------------------------------------------------
 * | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * +----------------------------------------------------------------------
 * | 官方网站: https://thinkadmin.top
 * +----------------------------------------------------------------------
 * | 开源协议 ( https://mit-license.org )
 * | 免责声明 ( https://thinkadmin.top/disclaimer )
 * | 会员特权 ( https://thinkadmin.top/vip-introduce )
 * +----------------------------------------------------------------------
 * | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * +----------------------------------------------------------------------
 */

namespace app\wechat\controller\payment;

use app\wechat\model\WechatFans;
use app\wechat\model\WechatPaymentRecord;
use app\wechat\model\WechatPaymentRefund;
use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;

/**
 * 支付退款管理.
 * @class Refund
 */
class Refund extends Controller
{
    /**
     * 支付退款管理.
     * @auth true
     * @menu true
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function index()
    {
        WechatPaymentRefund::mQuery()->layTable(function () {
            $this->title = '支付退款管理';
        }, function (QueryHelper $query) {
            $query->like('code|refund_trade#refund')->withoutField('refund_notify');
            $query->with(['record' => function (Query $query) {
                $query->withoutField('payment_notify');
            }]);
            if (($this->get['order'] ?? '') . ($this->get['nickname'] ?? '') . ($this->get['payment'] ?? '') . ($this->get['refund'] ?? '') !== '') {
                $db1 = WechatFans::mQuery()->field('openid')->like('openid|nickname#nickname')->db();
                $db2 = WechatPaymentRecord::mQuery()->like('order_code|order_name#order,code|payment_trade#payment');
                $db2->whereRaw("openid in {$db1->buildSql()}");
                $query->whereRaw("record_code in {$db2->field('code')->db()->buildSql()}");
            }
        });
    }
}
