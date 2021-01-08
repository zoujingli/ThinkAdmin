<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 文章标签管理
 * Class NewsMark
 * @package app\data\controller
 */
class NewsMark extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataNewsMark';

    /**
     * 文章标签管理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '文章标签管理';
        $query = $this->_query($this->table);
        $query->like('name')->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 添加文章标签
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
     * 编辑文章标签
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
     * 修改文章标签状态
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
     * 删除文章标签
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}