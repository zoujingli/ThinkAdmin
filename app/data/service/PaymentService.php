<?php

namespace app\data\service;

use app\data\service\payment\AlipayPaymentService;
use app\data\service\payment\JoinPaymentService;
use app\data\service\payment\WechatPaymentService;
use think\App;
use think\Container;
use think\Exception;

/**
 * 支付基础服务
 * Class PaymentService
 * @package app\data\service
 */
abstract class PaymentService
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
     * 当前应用
     * @var App
     */
    protected $app;

    /**
     * 支付通道编号
     * @var string
     */
    protected $code;

    /**
     * 默认支付类型
     * @var string
     */
    protected $type;

    /**
     * 当前支付通道
     * @var array
     */
    protected $params;

    /**
     * 支付服务对象
     * @var array
     */
    protected static $driver = [];

    /**
     * PaymentService constructor.
     * @param App $app 当前应用对象
     * @param string $code 支付通道编号
     * @param string $type 支付类型代码
     * @param array $params 支付通道配置
     */
    public function __construct(App $app, string $code, string $type, array $params)
    {
        $this->app = $app;
        $this->code = $code;
        $this->type = $type;
        $this->params = $params;
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
    }

    /**
     * 根据配置实例支付服务
     * @param string $code 支付通道编号
     * @return JoinPaymentService|WechatPaymentService|AlipayPaymentService
     * @throws Exception
     */
    public static function instance(string $code): PaymentService
    {
        [, $type, $params] = self::config($code);
        if (isset(static::$driver[$code])) return static::$driver[$code];
        $vars = ['code' => $code, 'type' => $type, 'params' => $params];
        // 实例化具体支付通道类型
        if (stripos($type, 'alipay_') === 0) {
            return static::$driver[$code] = Container::getInstance()->make(AlipayPaymentService::class, $vars);
        } elseif (stripos($type, 'wechat_') === 0) {
            return static::$driver[$code] = Container::getInstance()->make(WechatPaymentService::class, $vars);
        } elseif (stripos($type, 'joinpay_') === 0) {
            return static::$driver[$code] = Container::getInstance()->make(JoinPaymentService::class, $vars);
        } else {
            throw new Exception(sprintf('支付驱动[%s]未定义', $type));
        }
    }

    /**
     * 获取通道配置参数
     * @param string $code
     * @param array $payment
     * @return array [code,type,params]
     * @throws Exception
     */
    public static function config(string $code, array $payment = []): array
    {
        try {
            if (empty($payment)) {
                $map = ['code' => $code, 'status' => 1, 'deleted' => 0];
                $payment = app()->db->name('DataPayment')->where($map)->find();
            }
            if (empty($payment)) {
                throw new Exception("支付通道[#{$code}]禁用关闭");
            }
            $params = @json_decode($payment['content'], true);
            if (empty($params)) {
                throw new Exception("支付通道[#{$code}]配置无效");
            }
            if (empty(static::TYPES[$payment['type']])) {
                throw new Exception("支付通道[@{$payment['type']}]匹配失败");
            }
            return [$payment['code'], $payment['type'], $params];
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 订单更新操作
     * @param string $orderNo 订单单号
     * @param string $paymentTrade 交易单号
     * @param string $paymentAmount 支付金额
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function updateOrder(string $orderNo, string $paymentTrade, string $paymentAmount): bool
    {
        // 检查订单支付状态
        $map = ['order_no' => $orderNo, 'payment_status' => 0, 'status' => 2];
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) return false;
        // 更新订单支付状态
        $data = [
            'status'           => 3,
            'payment_type'     => $this->type,
            'payment_code'     => $this->code,
            'payment_trade'    => $paymentTrade,
            'payment_amount'   => $paymentAmount,
            'payment_status'   => 1,
            'payment_remark'   => '在线支付',
            'payment_datetime' => date('Y-m-d H:i:s'),
        ];
        if (empty($data['payment_type'])) unset($data['payment_type']);
        $this->app->db->name('ShopOrder')->where($map)->update($data);
        // 调用用户升级机制
        OrderService::instance()->syncAmount($order['order_no']);
        // 触发订单更新事件
        $this->app->event->trigger('ShopOrderPayment', $orderNo);
        return true;
    }

    /**
     * 创建支付行为
     * @param string $orderNo 商户订单单号
     * @param string $paymentTitle 商户订单标题
     * @param string $paymentAmount 需要支付金额
     */
    protected function createPaymentAction(string $orderNo, string $paymentTitle, string $paymentAmount)
    {
        $this->app->db->name('DataPaymentItem')->insert([
            'payment_code' => $this->code, 'payment_type' => $this->type,
            'order_amount' => $paymentAmount, 'order_name' => $paymentTitle, 'order_no' => $orderNo,
        ]);
    }

    /**
     * 更新支付记录并更新订单
     * @param string $orderNo 商户订单单号
     * @param string $paymentTrade 平台交易单号
     * @param string $paymentAmount 实际到账金额
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function updatePaymentAction(string $orderNo, string $paymentTrade, string $paymentAmount): bool
    {
        // 更新支付记录
        data_save('DataPaymentItem', [
            'order_no'         => $orderNo,
            'payment_code'     => $this->code,
            'payment_type'     => $this->type,
            'payment_trade'    => $paymentTrade,
            'payment_amount'   => $paymentAmount,
            'payment_status'   => 1,
            'payment_datatime' => date('Y-m-d H:i:s'),
        ], 'order_no', [
            'payment_code' => $this->code,
            'payment_type' => $this->type,
        ]);
        // 更新记录状态
        return $this->updateOrder($orderNo, $paymentTrade, $paymentAmount);
    }

    /**
     * 订单主动查询
     * @param string $orderNo
     * @return array
     */
    abstract public function query(string $orderNo): array;

    /**
     * 支付通知处理
     * @return string
     */
    abstract public function notify(): string;

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