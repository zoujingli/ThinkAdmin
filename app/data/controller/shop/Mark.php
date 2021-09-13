<?php

namespace app\data\controller\shop;

use app\data\model\ShopGoodsMark;
use think\admin\Controller;

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
        $this->title = '商品标签管理';
        $query = $this->_query(ShopGoodsMark::mk());
        $query->like('name')->dateBetween('create_at');
        $query->equal('status')->order('sort desc,id desc')->page();
    }

    /**
     * 商品标签选择
     * @login true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $this->_query(ShopGoodsMark::mk())->order('sort desc,id desc')->page();
    }

    /**
     * 添加商品标签
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form(ShopGoodsMark::mk(), 'form');
    }

    /**
     * 编辑商品标签
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form(ShopGoodsMark::mk(), 'form');
    }

    /**
     * 修改商品标签状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save(ShopGoodsMark::mk());
    }

    /**
     * 删除商品标签
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete(ShopGoodsMark::mk());
    }

}