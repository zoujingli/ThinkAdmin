<?php

namespace app\data\model;

use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 商城订单详情模型
 * Class ShopOrderItem
 * @package app\data\model
 */
class ShopOrderItem extends Model
{
    /**
     * 关联商品数据
     * @return \think\model\relation\HasOne
     */
    public function goods(): HasOne
    {
        return $this->hasOne(ShopGoods::class, 'code', 'goods_code');
    }

    /**
     * 绑定商品数据
     * @return void
     */
    public function bindGoods()
    {
        $this->goods()->bind([
            'goods_name'  => 'name',
            'goods_cover' => 'cover',
        ]);
    }
}