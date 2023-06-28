<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\model;

use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 微信支付退款模型
 * @class WechatPaymentRefund
 * @package app\wechat\model
 */
class WechatPaymentRefund extends Model
{
    /**
     * 关联支付订单
     * @return \think\model\relation\HasOne
     */
    public function record(): HasOne
    {
        return $this->hasOne(WechatPaymentRecord::class, 'code', 'record_code')->with('bindfans');
    }

    /**
     * 格式化输出时间格式
     * @param mixed $value
     * @return string
     */
    public function getCreateTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }

    /**
     * 格式化输出时间格式
     * @param mixed $value
     * @return string
     */
    public function getUpdateTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }

    /**
     * 格式化输出时间格式
     * @param mixed $value
     * @return string
     */
    public function getRefundTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }
}