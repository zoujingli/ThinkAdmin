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

namespace app\wechat\model;

use app\wechat\service\PaymentService;
use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 微信支付行为模型.
 *
 * @property float $order_amount 原订单金额
 * @property float $payment_amount 实际到账金额
 * @property float $refund_amount 退款金额
 * @property int $id
 * @property int $payment_status 支付状态(0未付,1已付,2取消)
 * @property int $refund_status 退款状态(0未退,1已退)
 * @property string $appid 发起APPID
 * @property string $code 发起支付号
 * @property string $create_time 创建时间
 * @property string $openid 用户OPENID
 * @property string $order_code 原订单编号
 * @property string $order_name 原订单标题
 * @property string $payment_bank 支付银行类型
 * @property string $payment_notify 支付结果通知
 * @property string $payment_remark 支付状态备注
 * @property string $payment_time 支付完成时间
 * @property string $payment_trade 平台交易编号
 * @property string $type 交易方式
 * @property string $update_time 更新时间
 * @property WechatFans $bind_fans
 * @property WechatFans $fans
 * @class WechatPaymentRecord
 */
class WechatPaymentRecord extends Model
{
    /**
     * 关联用户粉丝数据.
     */
    public function fans(): HasOne
    {
        return $this->hasOne(WechatFans::class, 'openid', 'openid');
    }

    /**
     * 绑定用户粉丝数据.
     */
    public function bindFans(): HasOne
    {
        return $this->fans()->bind([
            'fans_headimg' => 'headimgurl',
            'fans_nickname' => 'nickname',
        ]);
    }

    /**
     * 格式化输出时间格式.
     * @param mixed $value
     */
    public function getCreateTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }

    /**
     * 格式化输出时间格式.
     * @param mixed $value
     */
    public function getUpdateTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }

    /**
     * 格式化输出时间格式.
     * @param mixed $value
     */
    public function getPaymentTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }

    /**
     * 转换数据类型.
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['type_name'] = PaymentService::tradeTypeNames[$data['type']] ?? $data['type'];
        return $data;
    }
}
