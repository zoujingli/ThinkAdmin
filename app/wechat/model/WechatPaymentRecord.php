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

use app\wechat\service\PaymentService;
use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 微信支付行为模型
 * @class WechatPaymentRecord
 * @package app\wechat\model
 */
class WechatPaymentRecord extends Model
{
    /**
     * 关联用户粉丝数据
     * @return \think\model\relation\HasOne
     */
    public function fans(): HasOne
    {
        return $this->hasOne(WechatFans::class, 'openid', 'openid');
    }

    /**
     * 绑定用户粉丝数据
     * @return \think\model\relation\HasOne
     */
    public function bindFans(): HasOne
    {
        return $this->fans()->bind([
            'fans_headimg'  => 'headimgurl',
            'fans_nickname' => 'nickname',
        ]);
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
    public function getPaymentTimeAttr($value): string
    {
        return $value ? format_datetime($value) : '';
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['type_name'] = PaymentService::tradeTypeNames[$data['type']] ?? $data['type'];
        return $data;
    }
}