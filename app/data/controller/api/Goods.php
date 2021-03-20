<?php

namespace app\data\controller\api;

use app\data\service\GoodsService;
use app\data\service\ExpressService;
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
        $this->success('获取分类成功', GoodsService::instance()->getCateTree());
    }

    /**
     * 获取标签数据
     */
    public function getMark()
    {
        $this->success('获取标签成功', GoodsService::instance()->getMarkData());
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
        $query = $this->_query('ShopGoods')->like('name,cateids,marks,payment')->equal('code');
        $result = $query->where(['deleted' => 0, 'status' => 1])->order('sort desc,id desc')->page(true, false, false, 10);
        if (count($result['list']) > 0) GoodsService::instance()->bindData($result['list']);
        $this->success('获取商品数据', $result);
    }

    /**
     *  获取配送区域
     */
    public function getRegion()
    {
        $this->success('获取区域成功', ExpressService::instance()->region(3, 1));
    }

}