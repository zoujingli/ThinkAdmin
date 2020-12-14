<?php

namespace app\data\service;

use app\data\service\payment\JoinPaymentService;
use app\data\service\payment\WechatPaymentService;
use think\admin\Service;

/**
 * 支付基础服务
 * Class PaymentService
 * @package app\data\service
 */
abstract class PaymentService extends Service
{

    // 汇聚支付通道
    const PAYMENT_JOINPAY_GZH = 'joinpay_gzh';
    const PAYMENT_JOINPAY_XCX = 'joinpay_xcx';

    // 微信商户通道
    const PAYMENT_WECHAT_APP = 'wechat_app';
    const PAYMENT_WECHAT_MWEB = 'wechat_mweb';
    const PAYMENT_WECHAT_JSAPI = 'wechat_jsapi';
    const PAYMENT_WECHAT_NATIVE = 'wechat_native';

    // 支付宝支付通道
    const PAYMENT_ALIAPY_APP = 'alipay_app';
    const PAYMENT_ALIPAY_WAP = 'alipay_wap';
    const PAYMENT_ALIPAY_WEB = 'alipay_web';

    // 支付通道配置
    const TYPES = [
        PaymentService::PAYMENT_WECHAT_APP    => [
            'type' => 'APP',
            'name' => '微信商户 APP 支付',
            'bind' => [UserService::APITYPE_IOSAPP, UserService::APITYPE_ANDROID],
        ],
        PaymentService::PAYMENT_WECHAT_MWEB   => [
            'type' => 'MWEB',
            'name' => '微信商户 H5 支付',
            'bind' => [UserService::APITYPE_WAP],
        ],
        PaymentService::PAYMENT_WECHAT_NATIVE => [
            'type' => 'NATIVE',
            'name' => '微信商户 NATIVE 支付',
            'bind' => [UserService::APITYPE_WEB],
        ],
        PaymentService::PAYMENT_WECHAT_JSAPI  => [
            'type' => 'JSAPI',
            'name' => '微信商户 JSAPI 支付',
            'bind' => [UserService::APITYPE_WXAPP, UserService::APITYPE_WECHAT],
        ],
        PaymentService::PAYMENT_ALIAPY_APP    => [
            'type' => '',
            'name' => '支付宝 APP 支付',
            'bind' => [UserService::APITYPE_ANDROID, UserService::APITYPE_IOSAPP],
        ],
        PaymentService::PAYMENT_ALIPAY_WAP    => [
            'type' => '',
            'name' => '支付宝 WAP 支付',
            'bind' => [UserService::APITYPE_WAP],
        ],
        PaymentService::PAYMENT_ALIPAY_WEB    => [
            'type' => '',
            'name' => '支付宝 WEB 支付',
            'bind' => [UserService::APITYPE_WEB],
        ],
        PaymentService::PAYMENT_JOINPAY_XCX   => [
            'type' => 'WEIXIN_XCX',
            'name' => '汇聚小程序 JSAPI 支付',
            'bind' => [UserService::APITYPE_WXAPP],
        ],
        PaymentService::PAYMENT_JOINPAY_GZH   => [
            'type' => 'WEIXIN_GZH',
            'name' => '汇聚服务号 JSAPI 支付',
            'bind' => [UserService::APITYPE_WECHAT],
        ],
    ];

    /**
     * 支付通道编号
     * @var integer
     */
    protected static $id;

    /**
     * 默认支付类型
     * @var string
     */
    protected static $type;

    /**
     * 当前支付通道
     * @var array
     */
    protected static $config;

    /**
     * 支付服务对象
     * @var JoinPaymentService|WechatPaymentService
     */
    protected static $driver = [];


    /**
     * 根据配置实例支付服务
     * @param string $payid 支付通道编号
     * @return JoinPaymentService|WechatPaymentService
     * @throws \think\Exception
     */
    public static function build(string $payid): PaymentService
    {
        static::$id = $payid;
        if (isset(static::$driver[$payid])) {
            return static::$driver[$payid];
        }
        // 支付通道配置验证
        $map = ['id' => $payid, 'status' => 1, 'deleted' => 0];
        $payment = app()->db->name('DataPayment')->where($map)->find();
        if (empty($payment)) {
            throw new \think\Exception("支付通道[#{$payid}]已关闭");
        }
        static::$config = json_decode(static::$config['content'], true);
        if (empty(static::$config)) {
            throw new \think\Exception("支付通道[#{$payid}]配置无效");
        }
        // 支付通道类型验证
        if (empty(static::TYPES[$payment['type']])) {
            throw new \think\Exception("支付通道[{$payment['type']}]未定义");
        }
        // 实例化具体支付通道类型
        static::$type = $payment['type'];
        if (stripos(static::$type, 'wechat_') === 0) {
            return static::$driver[$payid] = WechatPaymentService::instance();
        } else {
            return static::$driver[$payid] = JoinPaymentService::instance();
        }
    }

    /**
     * 订单更新操作
     * @param string $code 订单单号
     * @param string $payno 交易单号
     * @param string $amount 支付金额
     * @param string $paytype 支付类型
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function updateOrder(string $code, string $payno, string $amount, string $paytype): bool
    {
        // 检查订单支付状态
        $map = ['order_no' => $code, 'payment_status' => 0, 'status' => 2];
        $order = $this->app->db->name('StoreOrder')->where($map)->find();
        if (empty($order)) return false;
        // 更新订单支付状态
        $this->app->db->name('StoreOrder')->where($map)->update([
            'status'           => 3,
            'payment_code'     => $payno,
            'payment_type'     => $paytype,
            'payment_status'   => 1,
            'payment_amount'   => $amount,
            'payment_remark'   => '微信在线支付',
            'payment_datetime' => date('Y-m-d H:i:s'),
        ]);
        // 调用用户升级机制
        return OrderService::instance()->syncAmount($order['order_no']);
    }

    /**
     * 支付通知处理
     * @param string $param 支付通道-支付编号
     * @return string
     */
    abstract public function notify(string $param = ''): string;

    /**
     * 订单主动查询
     * @param string $orderNo
     * @return array
     */
    abstract public function query(string $orderNo): array;

    /**
     * 创建支付订单
     * @param string $openid 会员OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payRemark 订单订单描述
     * @param string $returnUrl 支付回跳地址
     * @return array
     */
    abstract public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payRemark, string $returnUrl = ''): array;
}