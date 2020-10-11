<?php

namespace app\data\controller;

use think\admin\Controller;
use think\admin\extend\CodeExtend;

/**
 * 活动奖品管理
 * Class LuckdrawPrize
 * @package app\data\controller
 */
class LuckdrawPrize extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'ActivityLuckdrawPrize';

    /**
     * 活动奖品管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '活动奖品管理';
        $query = $this->_query($this->table)->like('code,name');
        $query->equal('status')->dateBetween('create_at')->page();
    }

    /**
     * 添加活动奖品
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 编辑活动奖品
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        $data['code'] = $data['code'] ?? CodeExtend::uniqidNumber(16, 'P');
    }

    /**
     * 修改奖品状态
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
     * 删除活动奖品
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}