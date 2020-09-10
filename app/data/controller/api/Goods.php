<?php

namespace app\data\controller\api;

use app\data\service\GoodsService;
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
        $this->success('获取商品分类数据成功', GoodsService::instance()->getCateList());
    }

    /**
     * 获取标签数据
     */
    public function getMark()
    {
        $this->success('获取商品标签数据成功', GoodsService::instance()->getMarkList());
    }

    /**
     * 获取商品数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGoods()
    {
        $query = $this->_query('ShopGoods')->like('name')->equal('cate');
        $query->where(['deleted' => 0, 'status' => 1])->order('sort desc,id desc');
        $result = $query->page(true, false, false, 10);
        // @todo 处理商品列表 
        $this->success('获取商品数据成功', $result);
    }

}