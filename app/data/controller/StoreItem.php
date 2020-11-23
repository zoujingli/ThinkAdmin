<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 实体门店管理
 * Class StoreItem
 * @package app\data\controller
 */
class StoreItem extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataStoreItem';

    /**
     * 实体门店管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '实体门店管理';
        $query = $this->_query($this->table);
        // code,name,cover,slider,username,phone,remark,sort,type,status,deleted,business_hours_start,business_hours_after
        ### 地理位置标志
        // region_province,region_city,region_area,region_address,region_longitude,region_latitude
        ### 字段描述
        // type 0 支持自提，1 不支持自提
        // status 0 禁用，0 启用
        // business_weeks_works // 每周工作
        // business_hours_start // 开始时间
        // business_hours_after // 结束时间
        $query->like('name')->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 添加实体门店
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑实体门店
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 修改实体门店状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除实体门店
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}