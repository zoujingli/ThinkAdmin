<?php

namespace app\data\controller;

use think\admin\Controller;
use think\admin\extend\DataExtend;

/**
 * 快递配送区域管理
 * Class ShopTruckRegion
 * @package app\data\controller
 */
class ShopTruckRegion extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopTruckRegion';

    /**
     * 配送区域管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '配送区域管理';
        $query = $this->_query($this->table);
        $query->field('id,pid,name')->page(false);
    }

    /**
     * 数据列表处理
     * @param $data
     */
    protected function _page_filter(&$data)
    {
        $data = DataExtend::arr2tree($data);
    }

}