<?php

namespace app\data\model;

use think\admin\Model;
use think\model\relation\HasMany;

/**
 * 商城订单主模型
 * Class ShopOrder
 * @package app\data\model
 */
class ShopOrder extends Model
{
    /**
     * 关联订单商品
     * @return \think\model\relation\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany('order_no', 'order_no')->where(['deleted' => 0]);
    }

    /**
     * 关联物码数据
     * @return \think\model\relation\HasMany
     */
    public function sends(): HasMany
    {
        return $this->hasMany('order_no', 'order_no')->where(['deleted' => 0]);
    }
}