<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

use library\Data;
use PHPQRCode\Constants;
use PHPQRCode\QRcode;
use think\Db;
use think\Log;
use Wechat\WechatPay;

/**
 * 支付数据处理
 *
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/25 14:49
 */
class PayService {

    /**
     * 查询订单是否已经支付
     * @param string $order_no
     * @return bool
     */
    static public function isPay($order_no) {
        return Db::table('wechat_pay_prepayid')->where('order_no', $order_no)->where('is_pay', '1')->count() > 0;
    }

    /**
     *  创建微信二维码支付(扫码支付模式二)
     * @param WechatPay $pay 支付SDK
     * @param string $order_no 系统订单号
     * @param int $fee 支付金额
     * @param string $title 订单标题
     * @param string $from 订单来源
     * @return bool
     */
    static public function createQrc($pay, $order_no, $fee, $title, $from = 'wechat') {
        $prepayid = self::_createPrepayid($pay, null, $order_no, $fee, $title, 'NATIVE', $from);
        if ($prepayid === false) {
            return false;
        }
        $filename = ROOT_PATH . "public/upload/{$pay->appid}/payqrc/" . join('/', str_split(md5($prepayid), 16)) . '.png';
        !is_dir(dirname($filename)) && mkdir(dirname($filename), 0755, true);
        !file_exists($filename) && QRcode::png($prepayid, $filename, Constants::QR_ECLEVEL_L, 8);
        ob_clean();
        header("Content-type: image/png");
        exit(readfile($filename));
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
    static protected function _createPrepayid($pay, $openid, $order_no, $fee, $title, $trade_type = 'JSAPI', $from = 'shop') {
        $map = ['order_no' => $order_no, 'is_pay' => '1', 'expires_in' => time(), 'appid' => $pay->appid];
        $prepayinfo = Db::table('wechat_pay_prepayid')->where('appid=:appid and order_no=:order_no and (is_pay=:is_pay or expires_in>:expires_in)', $map)->find();
        if (empty($prepayinfo) || empty($prepayinfo['prepayid'])) {
            $out_trade_no = Data::createSequence(18, 'WXPAY-OUTER-NO');
            $prepayid = $pay->getPrepayId($openid, $title, $out_trade_no, $fee, url("@push/wechat/notify/{$pay->appid}", '', true, true), $trade_type);
            if (empty($prepayid)) {
                Log::error("内部订单号{$order_no}生成预支付失败，{$pay->errMsg}");
                return false;
            }
            $data = [
                'appid'        => $pay->appid, // 对应公众号APPID
                'prepayid'     => $prepayid, // 微信支付预支付码
                'order_no'     => $order_no, // 内部订单号
                'out_trade_no' => $out_trade_no, // 微信商户订单号
                'fee'          => $fee, // 需要支付费用（单位为分）
                'trade_type'   => $trade_type, // 发起支付类型
                'expires_in'   => time() + 5400, // 微信预支付码有效时间1.5小时（最长为2小时）
                'from'         => $from // 订单来源
            ];
            if (Db::table('wechat_pay_prepayid')->insert($data) > 0) {
                Log::notice("内部订单号{$order_no}生成预支付成功,{$prepayid}");
                return $prepayid;
            }
        }
        return $prepayinfo['prepayid'];
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
    static public function createJs($pay, $openid, $order_no, $fee, $title) {
        if (($prepayid = self::_createPrepayid($pay, $openid, $order_no, $fee, $title, 'JSAPI')) === false) {
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
     * @return bool
     */
    static public function refund($pay, $order_no, $fee = 0, $refund_no = NULL, $refund_account = '') {
        $map = array('order_no' => $order_no, 'is_pay' => '1', 'appid' => $pay->appid);
        $notify = Db::table('wechat_pay_prepayid')->where($map)->find();
        if (empty($notify)) {
            Log::error("内部订单号{$order_no}验证退款失败");
            return false;
        }
        if (false !== $pay->refund($notify['out_trade_no'], $notify['transaction_id'], is_null($refund_no) ? "T{$order_no}" : $refund_no, $notify['fee'], empty($fee) ? $notify['fee'] : $fee, '', $refund_account)) {
            $data = ['out_trade_no' => $notify['out_trade_no'], 'is_refund' => "1", 'refund_at' => date('Y-m-d H:i:s'), 'expires_in' => time() + 7000];
            if (Data::save('wechat_pay_prepayid', $data, 'out_trade_no')) {
                return true;
            }
            Log::error("内部订单号{$order_no}退款成功，系统更新异常");
            return false;
        }
        Log::error("内部订单号{$order_no}退款失败，{$pay->errMsg}");
        return false;
    }

}
