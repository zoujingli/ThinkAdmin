<?php

namespace app\data\controller\shop;

use app\data\model\ShopGoodsMark;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 商品标签管理
 * Class Mark
 * @package app\data\controller\shop
 */
class Mark extends Controller
{
    /**
     * 商品标签管理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        ShopGoodsMark::mQuery()->layTable(function () {
            $this->title = '商品标签管理';
        }, function (QueryHelper $query) {
            $query->like('name')->equal('status')->dateBetween('create_at');
        });
    }

    /**
     * 添加商品标签
     * @auth true
     */
    public function add()
    {
        ShopGoodsMark::mForm('form');
    }

    /**
     * 编辑商品标签
     * @auth true
     */
    public function edit()
    {
        ShopGoodsMark::mForm('form');
    }

    /**
     * 修改商品标签状态
     * @auth true
     */
    public function state()
    {
        ShopGoodsMark::mSave();
    }

    /**
     * 删除商品标签
     * @auth true
     */
    public function remove()
    {
        ShopGoodsMark::mDelete();
    }
}