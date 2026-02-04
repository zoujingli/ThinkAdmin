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

use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 微信支付退款模型.
 *
 * @property float $refund_amount 实际到账金额
 * @property int $id
 * @property int $refund_status 支付状态(0未付,1已付,2取消)
 * @property string $code 发起支付号
 * @property string $create_time 创建时间
 * @property string $record_code 子支付编号
 * @property string $refund_account 退款目标账号
 * @property string $refund_notify 退款交易通知
 * @property string $refund_remark 支付状态备注
 * @property string $refund_scode 退款状态码
 * @property string $refund_time 支付完成时间
 * @property string $refund_trade 平台交易编号
 * @property string $update_time 更新时间
 * @property WechatPaymentRecord $record
 * @class WechatPaymentRefund
 */
class WechatPaymentRefund extends Model
{
    /**
     * 关联支付订单.
     */
    public function record(): HasOne
    {
        return $this->hasOne(WechatPaymentRecord::class, 'code', 'record_code')->with('bindfans');
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
    public function getRefundTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }
}
