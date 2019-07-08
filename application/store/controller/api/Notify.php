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

namespace app\store\controller\api;

use app\store\service\OrderService;
use think\Db;

/**
 * 支付通知处理
 * Class Notify
 * @package app\store\controller\api
 */
class Notify
{
    /**
     * 微信支付通知处理
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function wxpay()
    {
        $wechat = \We::WePayOrder(config('wechat.miniapp'));
        $notify = $wechat->getNotify();
        if ($notify['result_code'] == 'SUCCESS' && $notify['return_code'] == 'SUCCESS') {
            if ($this->update($notify['out_trade_no'], $notify['transaction_id'], $notify['cash_fee'] / 100, 'wechat')) {
                return $wechat->getNotifySuccessReply();
            }
        } else {
            return $wechat->getNotifySuccessReply();
        }
    }

    /**
     * 订单状态更新
     * @param string $order_no 订单号
     * @param string $pay_no 交易号
     * @param string $pay_price 交易金额
     * @param string $type 支付类型
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function update($order_no, $pay_no, $pay_price, $type = 'wechat')
    {
        // 检查订单支付状态
        $where = ['order_no' => $order_no, 'pay_state' => '0', 'status' => '2'];
        $order = Db::name('StoreOrder')->where($where)->find();
        if (empty($order)) return false;
        // 更新订单支付状态
        $result = Db::name('StoreOrder')->where($where)->update([
            'pay_type'  => $type, 'pay_no' => $pay_no, 'status' => '3',
            'pay_price' => $pay_price, 'pay_state' => '1', 'pay_at' => date('Y-m-d H:i:s'),
        ]);
        // 调用会员升级机制
        OrderService::update($order['order_no']);
        return $result !== false;
    }

}
