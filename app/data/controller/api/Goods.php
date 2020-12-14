<?php

namespace app\data\controller\api;

use app\data\service\GoodsService;
use app\data\service\TruckService;
use think\admin\Controller;

/**
 * 商品数据接口
 * Class Goods
 * @package app\data\controller\api
 */
class Goods extends Controller
{
    /**
     * 获取分类数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCate()
    {
        $this->success('获取分类成功', GoodsService::instance()->getCateList());
    }

    /**
     * 获取标签数据
     */
    public function getMark()
    {
        $this->success('获取标签成功', GoodsService::instance()->getMarkList());
    }

    /**
     * 获取商品数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGoods()
    {
        if ($code = input('code', '')) {
            $this->app->db->name('ShopGoods')->where(['code' => $code])->update([
                'num_read' => $this->app->db->raw('num_read+1'),
            ]);
        }
        $map = ['deleted' => 0, 'status' => 1];
        $query = $this->_query('ShopGoods')->like('name,mark')->equal('code,cate');
        $result = $query->where($map)->order('sort desc,id desc')->page(true, false, false, 10);
        GoodsService::instance()->buildItemData($result['list']);
        $this->success('获取商品成功', $result);
    }

    /**
     *  获取配送区域
     */
    public function getRegion()
    {
        $this->success('获取区域成功', TruckService::instance()->region(3, 1));
    }

}