<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 Anyon <zoujingli@qq.com>
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

namespace app\wechat\service;

use app\wechat\model\WechatPaymentRecord;
use app\wechat\model\WechatPaymentRefund;
use think\admin\Exception;
use think\admin\extend\CodeExtend;
use think\admin\Library;
use think\Response;
use WePayV3\Order;

/**
 * 微信V3支付服务
 * @class PaymentService
 * @package app\wechat\service
 */
class PaymentService
{
    // 微信支付类型
    public const WECHAT_APP = 'wechat_app';
    public const WECHAT_GZH = 'wechat_gzh';
    public const WECHAT_XCX = 'wechat_xcx';
    public const WECHAT_WAP = 'wechat_wap';
    public const WECHAT_QRC = 'wechat_qrc';

    // 微信支付类型转换
    private const tradeTypes = [
        self::WECHAT_APP => 'APP',
        self::WECHAT_WAP => 'MWEB',
        self::WECHAT_GZH => 'JSAPI',
        self::WECHAT_XCX => 'JSAPI',
        self::WECHAT_QRC => 'NATIVE',
    ];

    // 微信支付类型名称
    public const tradeTypeNames = [
        self::WECHAT_APP => '微信APP支付',
        self::WECHAT_WAP => '微信H5支付',
        self::WECHAT_GZH => '服务号支付',
        self::WECHAT_XCX => '小程序支付',
        self::WECHAT_QRC => '二维码支付',
    ];

    /**
     * 创建微信支付订单
     * @param string $openid 用户标识
     * @param string $oCode 订单单号
     * @param string $oName 订单标题
     * @param string $oAmount 订单金额（元）
     * @param string $pType 支付类型
     * @param ?string $pAmount 支付金额（元）
     * @param ?string $pRemark 支付描述
     * @return array
     * @throws \think\admin\Exception
     */
    public static function create(string $openid, string $oCode, string $oName, string $oAmount, string $pType, ?string $pAmount = null, ?string $pRemark = null): array
    {
        try {
            // 检查订单是否完成
            if (self::isPayed($oCode, $oAmount, $oPayed)) {
                return ['code' => 1, 'info' => '已完成支付！', 'data' => [], 'params' => []];
            }
            // 检查剩余支付金额
            $pAmount = floatval(is_null($pAmount) ? (floatval($oAmount) - $oPayed) : $pAmount);
            if ($oPayed + $pAmount > floatval($oAmount)) {
                return ['code' => 0, 'info' => '支付总额超出！', 'data' => [], 'params' => []];
            }
            $config = WechatService::getConfig(true);
            do $pCode = CodeExtend::uniqidNumber(16, 'P');
            while (WechatPaymentRecord::mk()->master()->where(['code' => $pCode])->findOrEmpty()->isExists());
            $data = [
                'appid'        => $config['appid'],
                'mchid'        => $config['mch_id'],
                'payer'        => ['openid' => $openid],
                'amount'       => ['total' => intval($pAmount * 100), 'currency' => 'CNY'],
                'notify_url'   => static::withNotifyUrl($pCode),
                'description'  => empty($pRemark) ? $oName : ($oName . '-' . $pRemark),
                'out_trade_no' => $pCode,
            ];
            $tradeType = static::tradeTypes[$pType] ?? '';
            if (in_array($pType, [static::WECHAT_WAP, static::WECHAT_QRC])) {
                unset($data['payer']);
            }
            if ($pType === static::WECHAT_WAP) {
                $tradeType = 'h5';
                $data['scene_info'] = ['h5_info' => ['type' => 'Wap'], 'payer_client_ip' => request()->ip()];
            }
            $params = static::withPayment($config)->create(strtolower($tradeType), $data);
            // 创建支付记录
            static::createPaymentAction($openid, $oCode, $oName, $oAmount, $pType, $pCode, strval($pAmount));
            // 返回支付参数
            return ['code' => 1, 'info' => '创建支付成功', 'data' => $data, 'params' => $params];
        } catch (Exception $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 查询微信支付订单
     * @param string $pCode 订单单号
     * @return array
     */
    public static function query(string $pCode): array
    {
        try {
            $result = static::withPayment()->query($pCode);
            if (isset($result['trade_state']) && $result['trade_state'] === 'SUCCESS') {
                $extra = [
                    'openid'         => $result['payer']['openid'] ?? null,
                    'payment_bank'   => $result['bank_type'],
                    'payment_time'   => date('Y-m-d H:i:s', strtotime($result['success_time'])),
                    'payment_remark' => $result['trade_state_desc'] ?? null,
                    'payment_notify' => json_encode($result, 64 | 256),
                ];
                $pAmount = strval($result['amount']['total'] / 100);
                static::updatePaymentAction($result['out_trade_no'], $result['transaction_id'], $pAmount, $extra);
            }
            return $result;
        } catch (\Exception $exception) {
            return ['trade_state' => 'ERROR', 'trade_state_desc' => $exception->getMessage()];
        }
    }

    /**
     * 支付结果处理
     * @param array|null $data
     * @return \think\Response
     */
    public static function notify(?array $data = null): Response
    {
        try {
            p(Library::$sapp->request->post(), false, 'wechat_pay_notify');
            $notify = static::withPayment()->notify(Library::$sapp->request->post());
            $result = empty($notify['result']) ? [] : json_decode($notify['result'], true);
            p($result, false, 'wechat_pay_notify');
            p('------------------', false, 'wechat_pay_notify');
            if (empty($result) || !is_array($result)) {
                empty($data['order']) || self::query($data['order']);
                return response('error', 500);
            }
            //订单支付通知处理
            if ($data['scen'] === 'order' && isset($result['trade_state']) && $result['trade_state'] == 'SUCCESS') {
                if ($data['order'] !== $result['out_trade_no']) return response('error', 500);
                $extra = [
                    'openid'         => $result['payer']['openid'] ?? null,
                    'payment_bank'   => $result['bank_type'],
                    'payment_time'   => date('Y-m-d H:i:s', strtotime($result['success_time'])),
                    'payment_remark' => $result['trade_state_desc'] ?? null,
                    'payment_notify' => json_encode($result, 64 | 256),
                ];
                $pAmount = strval($result['amount']['payer_total'] / 100);
                if (!static::updatePaymentAction($result['out_trade_no'], $result['transaction_id'], $pAmount, $extra)) {
                    return response('error', 500);
                }
            } elseif ($data['scen'] === 'refund' && isset($result['refund_status']) && $result['refund_status'] == 'SUCCESS') {
                if ($data['order'] !== $result['out_refund_no']) return response('error', 500);
                $refund = WechatPaymentRefund::mk()->where(['code' => $result['out_refund_no']])->findOrEmpty();
                if ($refund->isEmpty()) return response('error', 500);
                $refund->save([
                    'refund_time'    => date('Y-m-d H:i:s', strtotime($result['success_time'])),
                    'refund_trade'   => $result['refund_id'],
                    'refund_scode'   => $result['refund_status'],
                    'refund_status'  => 1,
                    'refund_notify'  => json_encode($result, 64 | 256),
                    'refund_account' => $result['user_received_account'] ?? '',
                ]);
                static::refundSync($refund->getAttr('record_code'));
            }
            return response('success');
        } catch (\Exception $exception) {
            empty($data['order']) || self::query($data['order']);
            return json(['code' => 'FAIL', 'message' => $exception->getMessage()])->code(500);
        }
    }

    /**
     * 创建支付单退款
     * @param string $pcode 支付单号
     * @param string $amount 退款金额
     * @param string $reason 退款原因
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public static function refund(string $pcode, string $amount, string $reason = ''): array
    {
        // 同步已退款状态
        $record = static::refundSync($pcode);
        if ($record->getAttr('refund_amount') >= $record->getAttr('payment_amount')) {
            return [1, '该订单已完成退款！'];
        }
        if ($record->getAttr('refund_amount') + floatval($amount) > $record->getAttr('payment_amount')) {
            return [0, '退款大于支付金额！'];
        }
        // 创建支付退款申请
        do $check = ['code' => $rcode = CodeExtend::uniqidNumber(16, 'R')];
        while (($model = WechatPaymentRefund::mk()->master()->where($check)->findOrEmpty())->isExists());
        // 初始化退款申请记录
        $model->save(['code' => $rcode, 'record_code' => $pcode, 'refund_amount' => $amount, 'refund_remark' => $reason]);
        $options = [
            'out_trade_no'  => $pcode,
            'out_refund_no' => $rcode,
            'notify_url'    => static::withNotifyUrl($rcode, 'refund'),
            'amount'        => [
                'refund'   => intval(floatval($amount) * 100),
                'total'    => intval($record->getAttr('payment_amount') * 100),
                'currency' => 'CNY'
            ]
        ];
        if (strlen($reason) > 0) $options['reason'] = $reason;
        $result = static::withPayment()->createRefund($options);
        if (in_array($result['code'] ?? $result['status'], ['SUCCESS', 'PROCESSING'])) {
            return self::refundSyncByQuery($rcode);
        } else {
            return [0, $result['message'] ?? $result['status']];
        }
    }

    /**
     * 同步退款统计状态
     * @param string $pCode
     * @return \app\wechat\model\WechatPaymentRecord
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public static function refundSync(string $pCode): WechatPaymentRecord
    {
        $record = WechatPaymentRecord::mk()->where(['code' => $pCode])->findOrEmpty();
        if ($record->isEmpty()) throw new Exception('支付单不存在！');
        if ($record->getAttr('payment_status') < 1) throw new Exception("支付未完成！");
        // 最近一条记录，同步查询刷新
        $map = ['record_code' => $pCode];
        $last = WechatPaymentRefund::mk()->where($map)->order('id desc')->findOrEmpty();
        if ($last->isExists() && $last->getAttr('refund_status') === 0) {
            static::refundSyncByQuery($last->getAttr('code'));
        }
        // 统计刷新退款金额
        $where = ['record_code' => $pCode, 'refund_status' => 1];
        $amount = WechatPaymentRefund::mk()->where($where)->sum('refund_amount');
        $record->save(['refund_amount' => $amount, 'refund_status' => intval($amount > 0)]);
        return $record;
    }

    /**
     * 同步退款状态
     * @param string $rCode
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public static function refundSyncByQuery(string $rCode): array
    {
        $refund = WechatPaymentRefund::mk()->where(['code' => $rCode])->findOrEmpty();
        if ($refund->isEmpty()) return [0, '退款不存在！'];
        if ($refund->getAttr('refund_status')) return [1, '退款已完成！'];
        $result = static::withPayment()->queryRefund($rCode);
        $extra = [
            'refund_trade'   => $result['refund_id'],
            'refund_scode'   => $result['status'],
            'refund_status'  => intval($result['status'] === 'SUCCESS'),
            'refund_notify'  => json_encode($result, 64 | 256),
            'refund_account' => $result['user_received_account'] ?? '',
        ];
        if (isset($result['success_time'])) {
            $extra['refund_time'] = date('Y-m-d H:i:s', strtotime($result['success_time']));
        }
        $refund->save($extra);
        // 同步支付订单
        static::refundSync($refund->getAttr('record_code'));
        if ($result['status'] === 'SUCCESS') return [1, '退款已完成！'];
        if ($result['status'] === 'PROCESSING') return [1, '退款处理中！'];
        return [0, $result['message'] ?? $result['status']];
    }

    /**
     * 判断是否完成支付
     * @param string $oCode 原订单单号
     * @param string $oAmount 需支付金额
     * @param ?float $oPayed 已支付金额[赋值]
     * @return boolean
     */
    public static function isPayed(string $oCode, string $oAmount, ?float &$oPayed = null): bool
    {
        return self::withPayed($oCode, $oPayed) >= $oAmount;
    }

    /**
     * 获取已支付金额
     * @param string $oCode 原订单单号
     * @param ?float $oPayed 已支付金额[赋值]
     * @return float
     */
    public static function withPayed(string $oCode, ?float &$oPayed = null): float
    {
        $where = ['order_code' => $oCode, 'payment_status' => 1];
        return $oPayed = WechatPaymentRecord::mk()->where($where)->sum('payment_amount');
    }

    /**
     * 初始化支付实现
     * @param array|null $config
     * @return \WePayV3\Order
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    protected static function withPayment(?array $config = null): Order
    {
        return Order::instance($config ?: WechatService::getConfig(true));
    }

    /**
     * 获取支付通知地址
     * @param string $order 订单单号
     * @param string $scene 支付场景
     * @param array $extra
     * @return string
     */
    protected static function withNotifyUrl(string $order, string $scene = 'order', array $extra = []): string
    {
        $data = ['scen' => $scene, 'order' => $order];
        $vars = CodeExtend::enSafe64(json_encode($extra + $data, 64 | 256));
        return sysuri('@plugin-wxpay-notify', [], false, true) . "/{$vars}";
    }

    /**
     * 创建支付行为
     * @param string $openid 用户编号
     * @param string $oCode 订单单号
     * @param string $oName 订单标题
     * @param string $oAmount 订单总金额
     * @param string $pType 支付平台
     * @param string $pCode 子支付单号
     * @param string $pAmount 子支付金额
     * @return array
     * @throws \think\admin\Exception
     */
    protected static function createPaymentAction(string $openid, string $oCode, string $oName, string $oAmount, string $pType, string $pCode, string $pAmount): array
    {
        // 检查是否已经支付
        if (static::withPayed($oCode, $oPayed) >= floatval($oAmount)) {
            throw new Exception("已经完成支付", 1);
        }
        if ($oPayed + floatval($pAmount) > floatval($oAmount)) {
            throw new Exception('总支付超出金额', 0);
        }
        $map = ['order_code' => $oCode, 'payment_status' => 1];
        $model = WechatPaymentRecord::mk()->where($map)->findOrEmpty();
        if ($model->isExists()) throw new Exception("已经完成支付", 1);
        // 写入订单支付行为
        $model->save([
            'type'         => $pType,
            'code'         => $pCode,
            'appid'        => WechatService::getAppid(),
            'openid'       => $openid,
            'order_code'   => $oCode,
            'order_name'   => $oName,
            'order_amount' => $oAmount,
        ]);
        return $model->toArray();
    }

    /**
     * 更新创建支付行为
     * @param string $pCode 商户订单单号
     * @param string $pTrade 平台交易单号
     * @param string $pAmount 实际到账金额
     * @param array $extra 订单扩展数据
     * @return boolean|array
     */
    protected static function updatePaymentAction(string $pCode, string $pTrade, string $pAmount, array $extra = [])
    {
        // 更新支付记录
        $model = WechatPaymentRecord::mk()->where(['code' => $pCode])->findOrEmpty();
        if ($model->isEmpty()) return false;
        // 更新支付行为
        foreach ($extra as $k => $v) if (is_null($v)) unset($extra[$k]);
        $model->save($extra + ['payment_trade' => $pTrade, 'payment_status' => 1, 'payment_amount' => $pAmount]);
        // 触发支付成功事件
        Library::$sapp->event->trigger('WechatPaymentSuccess', $model->refresh()->toArray());
        // 返回支付行为数据
        return $model->toArray();
    }
}