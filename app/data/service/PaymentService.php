<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\service;

use app\data\model\BaseUserPayment;
use app\data\model\DataUserPayment;
use app\data\model\ShopOrder;
use app\data\service\payment\AlipayPaymentService;
use app\data\service\payment\BalancePaymentService;
use app\data\service\payment\EmptyPaymentService;
use app\data\service\payment\JoinpayPaymentService;
use app\data\service\payment\VoucherPaymentService;
use app\data\service\payment\WechatPaymentService;
use think\admin\Exception;
use think\admin\Library;
use think\App;

/**
 * 支付基础服务
 * Class PaymentService
 * @package app\data\service
 */
abstract class PaymentService
{

    // 用户余额支付
    const PAYMENT_EMPTY = 'empty';
    const PAYMENT_BALANCE = 'balance';
    const PAYMENT_VOUCHER = 'voucher';

    // 汇聚支付参数
    const PAYMENT_JOINPAY_GZH = 'joinpay_gzh';
    const PAYMENT_JOINPAY_XCX = 'joinpay_xcx';

    // 微信商户支付
    const PAYMENT_WECHAT_APP = 'wechat_app';
    const PAYMENT_WECHAT_GZH = 'wechat_gzh';
    const PAYMENT_WECHAT_XCX = 'wechat_xcx';
    const PAYMENT_WECHAT_WAP = 'wechat_wap';
    const PAYMENT_WECHAT_QRC = 'wechat_qrc';

    // 支付宝支付参数
    const PAYMENT_ALIAPY_APP = 'alipay_app';
    const PAYMENT_ALIPAY_WAP = 'alipay_wap';
    const PAYMENT_ALIPAY_WEB = 'alipay_web';

    // 支付通道配置，不需要的可以注释
    const TYPES = [
        // 空支付，金额为零时自动完成支付
        self::PAYMENT_EMPTY       => [
            'type' => 'EMPTY',
            'name' => '订单无需支付',
            'bind' => [],
        ],
        // 余额支付，使用账号余额完成支付
        self::PAYMENT_BALANCE     => [
            'type' => 'BALANCE',
            'name' => '账号余额支付',
            'bind' => [
                UserAdminService::API_TYPE_WAP, UserAdminService::API_TYPE_WEB,
                UserAdminService::API_TYPE_WXAPP, UserAdminService::API_TYPE_WECHAT,
                UserAdminService::API_TYPE_IOSAPP, UserAdminService::API_TYPE_ANDROID,
            ],
        ],
        // 凭证支付，上传凭证后台审核支付
        self::PAYMENT_VOUCHER     => [
            'type' => 'VOUCHER',
            'name' => '单据凭证支付',
            'bind' => [
                UserAdminService::API_TYPE_WAP, UserAdminService::API_TYPE_WEB,
                UserAdminService::API_TYPE_WXAPP, UserAdminService::API_TYPE_WECHAT,
                UserAdminService::API_TYPE_IOSAPP, UserAdminService::API_TYPE_ANDROID,
            ],
        ],
        // 微信支付配置（不需要的直接注释）
        self::PAYMENT_WECHAT_WAP  => [
            'type' => 'MWEB',
            'name' => '微信WAP支付',
            'bind' => [UserAdminService::API_TYPE_WAP],
        ],
        self::PAYMENT_WECHAT_APP  => [
            'type' => 'APP',
            'name' => '微信APP支付',
            'bind' => [UserAdminService::API_TYPE_IOSAPP, UserAdminService::API_TYPE_ANDROID],
        ],
        self::PAYMENT_WECHAT_XCX  => [
            'type' => 'JSAPI',
            'name' => '微信小程序支付',
            'bind' => [UserAdminService::API_TYPE_WXAPP],
        ],
        self::PAYMENT_WECHAT_GZH  => [
            'type' => 'JSAPI',
            'name' => '微信公众号支付',
            'bind' => [UserAdminService::API_TYPE_WECHAT],
        ],
        self::PAYMENT_WECHAT_QRC  => [
            'type' => 'NATIVE',
            'name' => '微信二维码支付',
            'bind' => [UserAdminService::API_TYPE_WEB],
        ],
        // 支付宝支持配置（不需要的直接注释）
        self::PAYMENT_ALIPAY_WAP  => [
            'type' => '',
            'name' => '支付宝WAP支付',
            'bind' => [UserAdminService::API_TYPE_WAP],
        ],
        self::PAYMENT_ALIPAY_WEB  => [
            'type' => '',
            'name' => '支付宝WEB支付',
            'bind' => [UserAdminService::API_TYPE_WEB],
        ],
        self::PAYMENT_ALIAPY_APP  => [
            'type' => '',
            'name' => '支付宝APP支付',
            'bind' => [UserAdminService::API_TYPE_ANDROID, UserAdminService::API_TYPE_IOSAPP],
        ],
        // 汇聚支持配置（不需要的直接注释）
        self::PAYMENT_JOINPAY_XCX => [
            'type' => 'WEIXIN_XCX',
            'name' => '汇聚小程序支付',
            'bind' => [UserAdminService::API_TYPE_WXAPP],
        ],
        self::PAYMENT_JOINPAY_GZH => [
            'type' => 'WEIXIN_GZH',
            'name' => '汇聚公众号支付',
            'bind' => [UserAdminService::API_TYPE_WECHAT],
        ],
    ];
    /**
     * 支付服务对象
     * @var array
     */
    protected static $driver = [];
    /**
     * 当前应用
     * @var App
     */
    protected $app;
    /**
     * 支付参数编号
     * @var string
     */
    protected $code;
    /**
     * 默认支付类型
     * @var string
     */
    protected $type;
    /**
     * 当前支付参数
     * @var array
     */
    protected $params;

    /**
     * PaymentService constructor.
     * @param App $app 当前应用对象
     * @param string $code 支付参数编号
     * @param string $type 支付类型代码
     * @param array $params 支付参数配置
     */
    public function __construct(App $app, string $code, string $type, array $params)
    {
        [$this->app, $this->code, $this->type, $this->params] = [$app, $code, $type, $params];
        if (method_exists($this, 'initialize')) $this->initialize();
    }

    /**
     * 根据配置实例支付服务
     * @param string $code 支付配置编号
     * @return PaymentService
     * @throws \think\admin\Exception
     */
    public static function instance(string $code): PaymentService
    {
        if ($code === 'empty') {
            $vars = ['code' => 'empty', 'type' => 'empty', 'params' => []];
            return static::$driver[$code] = Library::$sapp->make(EmptyPaymentService::class, $vars);
        }
        [, $type, $params] = self::config($code);
        if (isset(static::$driver[$code])) return static::$driver[$code];
        $vars = ['code' => $code, 'type' => $type, 'params' => $params];
        // 实例化具体支付参数类型
        if (stripos($type, 'balance') === 0) {
            return static::$driver[$code] = Library::$sapp->make(BalancePaymentService::class, $vars);
        } elseif (stripos($type, 'voucher') === 0) {
            return static::$driver[$code] = Library::$sapp->make(VoucherPaymentService::class, $vars);
        } elseif (stripos($type, 'alipay_') === 0) {
            return static::$driver[$code] = Library::$sapp->make(AlipayPaymentService::class, $vars);
        } elseif (stripos($type, 'wechat_') === 0) {
            return static::$driver[$code] = Library::$sapp->make(WechatPaymentService::class, $vars);
        } elseif (stripos($type, 'joinpay_') === 0) {
            return static::$driver[$code] = Library::$sapp->make(JoinpayPaymentService::class, $vars);
        } else {
            throw new Exception(sprintf('支付驱动[%s]未定义', $type));
        }
    }

    /**
     * 获取支付配置参数
     * @param string $code
     * @param array $payment
     * @return array [code, type, params]
     * @throws Exception
     */
    public static function config(string $code, array $payment = []): array
    {
        try {
            if (empty($payment)) {
                $map = ['code' => $code, 'status' => 1, 'deleted' => 0];
                $payment = BaseUserPayment::mk()->where($map)->find();
            }
            if (empty($payment)) {
                throw new Exception("支付参数[#{$code}]禁用关闭");
            }
            $params = @json_decode($payment['content'], true);
            if (empty($params)) {
                throw new Exception("支付参数[#{$code}]配置无效");
            }
            if (empty(static::TYPES[$payment['type']])) {
                throw new Exception("支付参数[@{$payment['type']}]匹配失败");
            }
            return [$payment['code'], $payment['type'], $params];
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 获取支付支付名称
     * @param string $type
     * @return string
     */
    public static function name(string $type): string
    {
        return static::TYPES[$type]['name'] ?? $type;
    }

    /**
     * 获取支付类型
     * @param array $types 默认返回支付
     * @return array
     */
    public static function getTypeAll(array $types = []): array
    {
        $binds = array_keys(UserAdminService::TYPES);
        foreach (static::TYPES as $k => $v) if (isset($v['bind'])) {
            if (array_intersect($v['bind'], $binds)) $types[$k] = $v;
        }
        return $types;
    }

    /**
     * 筛选可用的支付类型
     * @param string $api 指定接口类型
     * @param array $types 默认返回支付
     * @return array
     */
    public static function getTypeApi(string $api = '', array $types = []): array
    {
        foreach (self::TYPES as $type => $attr) {
            if (in_array($api, $attr['bind'])) $types[] = $type;
        }
        return array_unique($types);
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
     * @param string $openid 用户OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payRemark 交易订单描述
     * @param string $payReturn 支付回跳地址
     * @param string $payImage 支付凭证图片
     * @return array
     */
    abstract public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payRemark, string $payReturn = '', string $payImage = ''): array;

    /**
     * 创建支付行为
     * @param string $orderNo 商户订单单号
     * @param string $payTitle 商户订单标题
     * @param string $payAmount 需要支付金额
     */
    protected function createPaymentAction(string $orderNo, string $payTitle, string $payAmount)
    {
        DataUserPayment::mk()->insert([
            'payment_code' => $this->code,
            'payment_type' => $this->type,
            'order_no'     => $orderNo,
            'order_name'   => $payTitle,
            'order_amount' => $payAmount,
        ]);
    }

    /**
     * 更新支付记录并更新订单
     * @param string $orderNo 商户订单单号
     * @param string $payTrade 平台交易单号
     * @param string $payAmount 实际到账金额
     * @param string $payRemark 平台支付备注
     * @return boolean
     */
    protected function updatePaymentAction(string $orderNo, string $payTrade, string $payAmount, string $payRemark = '在线支付'): bool
    {
        // 更新支付记录
        DataUserPayment::mUpdate([
            'order_no'         => $orderNo,
            'payment_code'     => $this->code,
            'payment_type'     => $this->type,
            'payment_trade'    => $payTrade,
            'payment_amount'   => $payAmount,
            'payment_status'   => 1,
            'payment_datetime' => date('Y-m-d H:i:s'),
        ], 'order_no', [
            'payment_code' => $this->code,
            'payment_type' => $this->type,
        ]);
        // 更新记录状态
        return $this->updatePaymentOrder($orderNo, $payTrade, $payAmount, $payRemark);
    }

    /**
     * 订单支付更新操作
     * @param string $orderNo 订单单号
     * @param string $payTrade 交易单号
     * @param string $payAmount 支付金额
     * @param string $payRemark 支付描述
     * @param string $payImage 支付凭证
     * @return boolean
     */
    protected function updatePaymentOrder(string $orderNo, string $payTrade, string $payAmount, string $payRemark = '在线支付', string $payImage = ''): bool
    {
        $map = ['status' => 2, 'order_no' => $orderNo, 'payment_status' => 0];
        $order = ShopOrder::mk()->where($map)->findOrEmpty();
        if ($order->isEmpty()) return false;
        // 检查订单支付状态
        if ($this->type === self::PAYMENT_VOUCHER) {
            $status = 3; # 凭证支付需要审核
        } elseif (empty($order['truck_type'])) {
            $status = 6; # 虚拟订单直接完成
        } else {
            $status = 4; # 实物订单需要发货
        }
        // 更新订单支付状态
        $order['status'] = $status;
        $order['payment_code'] = $this->code;
        $order['payment_type'] = $this->type;
        $order['payment_trade'] = $payTrade;
        $order['payment_image'] = $payImage;
        $order['payment_amount'] = $payAmount;
        $order['payment_remark'] = $payRemark;
        $order['payment_status'] = 1;
        $order['payment_datetime'] = date('Y-m-d H:i:s');
        $order->save();
        // 触发订单更新事件
        if ($status >= 4) {
            $this->app->event->trigger('ShopOrderPayment', $orderNo);
        }
        return true;
    }
}