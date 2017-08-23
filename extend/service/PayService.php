<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

use Endroid\QrCode\QrCode;
use Wechat\WechatPay;
use think\Log;
use think\Db;

/**
 * 支付数据服务
 * Class PayService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/25 14:49
 */
class PayService
{

    /**
     * 查询订单是否已经支付
     * @param string $order_no
     * @return bool
     */
    public static function isPay($order_no)
    {
        $map = ['order_no' => $order_no, 'is_pay' => '1'];
        return Db::name('WechatPayPrepayid')->where($map)->count() > 0;
    }

    /**
     *  创建微信二维码支付(扫码支付模式二)
     * @param WechatPay $pay 支付SDK
     * @param string $order_no 系统订单号
     * @param int $fee 支付金额
     * @param string $title 订单标题
     * @param string $from 订单来源
     * @return false|string
     */
    public static function createWechatPayQrc(WechatPay $pay, $order_no, $fee, $title, $from = 'wechat')
    {
        $prepayid = self::createWechatPrepayid($pay, null, $order_no, $fee, $title, 'NATIVE', $from);
        if ($prepayid === false) {
            return false;
        }
        $filename = FileService::getFileName($prepayid, 'png', 'qrc/');
        if (!FileService::hasFile($filename, 'local')) {
            $qrCode = new QrCode($prepayid);
            if (null === FileService::save($filename, $qrCode->get(), 'local')) {
                return false;
            }
        }
        return FileService::getFileUrl($filename, 'local');
    }

    /**
     * 创建微信JSAPI支付签名包
     * @param WechatPay $pay 支付SDK
     * @param string $openid 微信用户openid
     * @param string $order_no 系统订单号
     * @param int $fee 支付金额
     * @param string $title 订单标题
     * @return bool|array
     */
    public static function createWechatPayJsPicker(WechatPay $pay, $openid, $order_no, $fee, $title)
    {
        if (($prepayid = self::createWechatPrepayid($pay, $openid, $order_no, $fee, $title, 'JSAPI')) === false) {
            return false;
        }
        return $pay->createMchPay($prepayid);
    }

    /**
     * 微信退款操作
     * @param WechatPay $pay 支付SDK
     * @param string $order_no 系统订单号
     * @param int $fee 退款金额
     * @param string|null $refund_no 退款订单号
     * @param string $refund_account
     * @return bool
     */
    public static function putWechatRefund(WechatPay $pay, $order_no, $fee = 0, $refund_no = null, $refund_account = '')
    {
        $map = ['order_no' => $order_no, 'is_pay' => '1', 'appid' => $pay->appid];
        $notify = Db::name('WechatPayPrepayid')->where($map)->find();
        if (empty($notify)) {
            Log::error("内部订单号{$order_no}验证退款失败");
            return false;
        }
        if (false !== $pay->refund($notify['out_trade_no'], $notify['transaction_id'], is_null($refund_no) ? "T{$order_no}" : $refund_no, $notify['fee'], empty($fee) ? $notify['fee'] : $fee, '', $refund_account)) {
            $data = ['out_trade_no' => $notify['out_trade_no'], 'is_refund' => "1", 'refund_at' => date('Y-m-d H:i:s'), 'expires_in' => time() + 7000];
            if (DataService::save('wechat_pay_prepayid', $data, 'out_trade_no')) {
                return true;
            }
            Log::error("内部订单号{$order_no}退款成功，系统更新异常");
            return false;
        }
        Log::error("内部订单号{$order_no}退款失败，{$pay->errMsg}");
        return false;
    }

    /**
     * 创建微信预支付码
     * @param WechatPay $pay 支付SDK
     * @param string $openid 支付者Openid
     * @param string $order_no 实际订单号
     * @param int $fee 实际订单支付费用
     * @param string $title 订单标题
     * @param string $trade_type 付款方式
     * @param string $from 订单来源
     * @return bool|string
     */
    public static function createWechatPrepayid(WechatPay $pay, $openid, $order_no, $fee, $title, $trade_type = 'JSAPI', $from = 'wechat')
    {
        $map = ['order_no' => $order_no, 'is_pay' => '1', 'expires_in' => time(), 'appid' => $pay->appid, 'trade_type' => $trade_type];
        $where = 'appid=:appid and order_no=:order_no and (is_pay=:is_pay or expires_in>:expires_in) and trade_type=:trade_type';
        $prepayinfo = Db::name('WechatPayPrepayid')->where($where, $map)->find();
        if (empty($prepayinfo) || empty($prepayinfo['prepayid'])) {
            $out_trade_no = DataService::createSequence(18, 'WXPAY-OUTER-NO');
            if (!($prepayid = $pay->getPrepayId($openid, $title, $out_trade_no, $fee, url("@wechat/notify", '', true, true), $trade_type))) {
                Log::error("内部订单号{$order_no}生成预支付失败，{$pay->errMsg}");
                return false;
            }
            $data = ['prepayid' => $prepayid, 'order_no' => $order_no, 'out_trade_no' => $out_trade_no, 'fee' => $fee, 'trade_type' => $trade_type];
            list($data['from'], $data['appid'], $data['expires_in']) = [$from, $pay->getAppid(), time() + 5400];
            if (Db::name('WechatPayPrepayid')->insert($data) > 0) {
                Log::notice("内部订单号{$order_no}生成预支付成功,{$prepayid}");
                return $prepayid;
            }
        }
        return $prepayinfo['prepayid'];
    }

}
