<?php

namespace app\data\service;

use app\data\service\payment\AlipayPaymentService;
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
    const PAYMENT_WECHAT_GZH = 'wechat_gzh';
    const PAYMENT_WECHAT_XCX = 'wechat_xcx';
    const PAYMENT_WECHAT_WAP = 'wechat_wap';
    const PAYMENT_WECHAT_QRC = 'wechat_qrc';

    // 支付宝支付通道
    const PAYMENT_ALIAPY_APP = 'alipay_app';
    const PAYMENT_ALIPAY_WAP = 'alipay_wap';
    const PAYMENT_ALIPAY_WEB = 'alipay_web';

    // 支付通道配置
    const TYPES = [
        // 微信支付配置（不需要的直接注释）
        PaymentService::PAYMENT_WECHAT_WAP  => [
            'type' => 'MWEB',
            'name' => '微信商户 H5 支付',
            'bind' => [UserService::APITYPE_WAP],
        ],
        PaymentService::PAYMENT_WECHAT_APP  => [
            'type' => 'APP',
            'name' => '微信商户 APP 支付',
            'bind' => [UserService::APITYPE_IOSAPP, UserService::APITYPE_ANDROID],
        ],
        PaymentService::PAYMENT_WECHAT_XCX  => [
            'type' => 'JSAPI',
            'name' => '微信商户 小程序 支付',
            'bind' => [UserService::APITYPE_WXAPP],
        ],
        PaymentService::PAYMENT_WECHAT_GZH  => [
            'type' => 'JSAPI',
            'name' => '微信商户 公众号 支付',
            'bind' => [UserService::APITYPE_WECHAT],
        ],
        PaymentService::PAYMENT_WECHAT_QRC  => [
            'type' => 'NATIVE',
            'name' => '微信商户 二维码 支付',
            'bind' => [UserService::APITYPE_WEB],
        ],
        // 支付宝支持配置（不需要的直接注释）
        PaymentService::PAYMENT_ALIPAY_WAP  => [
            'type' => '',
            'name' => '支付宝 WAP 支付',
            'bind' => [UserService::APITYPE_WAP],
        ],
        PaymentService::PAYMENT_ALIPAY_WEB  => [
            'type' => '',
            'name' => '支付宝 WEB 支付',
            'bind' => [UserService::APITYPE_WEB],
        ],
        PaymentService::PAYMENT_ALIAPY_APP  => [
            'type' => '',
            'name' => '支付宝 APP 支付',
            'bind' => [UserService::APITYPE_ANDROID, UserService::APITYPE_IOSAPP],
        ],
        // 汇聚支持配置（不需要的直接注释）
        PaymentService::PAYMENT_JOINPAY_XCX => [
            'type' => 'WEIXIN_XCX',
            'name' => '汇聚 小程序 支付',
            'bind' => [UserService::APITYPE_WXAPP],
        ],
        PaymentService::PAYMENT_JOINPAY_GZH => [
            'type' => 'WEIXIN_GZH',
            'name' => '汇聚 公众号 支付',
            'bind' => [UserService::APITYPE_WECHAT],
        ],
    ];

    /**
     * 支付通道编号
     * @var string
     */
    protected static $code;

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
     * @var array
     */
    protected static $driver = [];

    /**
     * 根据配置实例支付服务
     * @param string $paycode 支付通道编号
     * @return JoinPaymentService|WechatPaymentService|AlipayPaymentService
     * @throws \think\Exception
     */
    public static function build(string $paycode): PaymentService
    {
        static::$code = $paycode;
        if (isset(static::$driver[$paycode])) {
            return static::$driver[$paycode];
        }
        // 支付通道配置验证
        $map = ['code' => $paycode, 'status' => 1, 'deleted' => 0];
        $payment = app()->db->name('DataPayment')->where($map)->find();
        if (empty($payment)) {
            throw new \think\Exception("支付通道[#{$paycode}]已关闭");
        }
        static::$config = @json_decode($payment['content'], true);
        if (empty(static::$config)) {
            throw new \think\Exception("支付通道[#{$paycode}]配置无效");
        }
        // 支付通道类型验证
        if (empty(static::TYPES[$payment['type']])) {
            throw new \think\Exception("支付通道[{$payment['type']}]未定义");
        }
        // 实例化具体支付通道类型
        static::$type = $payment['type'];
        if (stripos(static::$type, 'alipay_') === 0) {
            return static::$driver[$paycode] = AlipayPaymentService::instance();
        } elseif (stripos(static::$type, 'wechat_') === 0) {
            return static::$driver[$paycode] = WechatPaymentService::instance();
        } elseif (stripos(static::$type, 'joinpay_') === 0) {
            return static::$driver[$paycode] = JoinPaymentService::instance();
        } else {
            throw new \think\Exception("支付驱动[{$payment['type']}]未定义");
        }
    }

    /**
     * 订单更新操作
     * @param string $orderNo 订单单号
     * @param string $paymentTrade 交易单号
     * @param string $paymentAmount 支付金额
     * @param null|string $paymentType 支付类型
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function updateOrder(string $orderNo, string $paymentTrade, string $paymentAmount, ?string $paymentType = null): bool
    {
        // 检查订单支付状态
        $map = ['order_no' => $orderNo, 'payment_status' => 0, 'status' => 2];
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) return false;
        // 更新订单支付状态
        $data = [
            'status'           => 3,
            'payment_type'     => $paymentType,
            'payment_trade'    => $paymentTrade,
            'payment_status'   => 1,
            'payment_amount'   => $paymentAmount,
            'payment_remark'   => '在线支付',
            'payment_datetime' => date('Y-m-d H:i:s'),
        ];
        if (empty($data['payment_type'])) unset($data['payment_type']);
        $this->app->db->name('ShopOrder')->where($map)->update($data);
        // 调用用户升级机制
        return OrderService::instance()->syncAmount($order['order_no']);
    }

    /**
     * 创建支付行为
     * @param string $param 通道-编号
     * @param string $orderNo 商户订单单号
     * @param string $paymentTitle 商户订单标题
     * @param string $paymentAmount 需要支付金额
     */
    protected function createPaymentAction(string $param, string $orderNo, string $paymentTitle, string $paymentAmount)
    {
        if (is_numeric(stripos($param, '-'))) {
            [$paymentType, $paymentCode] = explode('-', $param);
        } else {
            [$paymentType, $paymentCode] = [$param ?: static::$type, static::$code];
        }
        // 创建支付记录
        $this->app->db->name('DataPaymentItem')->insert([
            'payment_code' => $paymentCode, 'payment_type' => $paymentType,
            'order_name'   => $paymentTitle, 'order_amount' => $paymentAmount, 'order_no' => $orderNo,
        ]);
    }

    /**
     * 更新支付记录并更新订单
     * @param string $param 通道-编号
     * @param string $orderNo 商户订单单号
     * @param string $paymentTrade 平台交易单号
     * @param string $paymentAmount 实际到账金额
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function updatePaymentAction(string $param, string $orderNo, string $paymentTrade, string $paymentAmount): bool
    {
        if (is_numeric(stripos($param, '-'))) {
            [$paymentType, $paymentCode] = explode('-', $param);
        } else {
            [$paymentType, $paymentCode] = [$param ?: static::$type, static::$code];
        }
        // 更新支付记录
        data_save('DataPaymentItem', [
            'order_no'         => $orderNo,
            'payment_code'     => $paymentCode,
            'payment_type'     => $paymentType,
            'payment_trade'    => $paymentTrade,
            'payment_amount'   => $paymentAmount,
            'payment_status'   => 1,
            'payment_datatime' => date('Y-m-d H:i:s'),
        ], 'order_no', [
            'payment_code' => $paymentCode,
            'payment_type' => $paymentType,
        ]);
        // 更新记录状态
        return $this->updateOrder($orderNo, $paymentTrade, $paymentAmount, $paymentType);
    }

    /**
     * 订单主动查询
     * @param string $orderNo
     * @return array
     */
    abstract public function query(string $orderNo): array;

    /**
     * 支付通知处理
     * @param string $param 支付通道-支付编号
     * @return string
     */
    abstract public function notify(string $param = ''): string;

    /**
     * 创建支付订单
     * @param string $openid 会员OPENID
     * @param string $orderNo 交易订单单号
     * @param string $paymentAmount 交易订单金额（元）
     * @param string $paymentTitle 交易订单名称
     * @param string $paymentRemark 交易订单描述
     * @param string $paymentReturn 支付回跳地址
     * @return array
     */
    abstract public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = ''): array;
}