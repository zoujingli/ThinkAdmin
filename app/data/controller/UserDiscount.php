<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 折扣方案管理
 * Class UserDiscount
 * @package app\data\controller
 */
class UserDiscount extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserDiscount';

    /**
     * 折扣方案管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '折扣方案管理';
        $query = $this->_query($this->table);
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['items'] = json_decode($vo['items'], true);
        }
    }

    /**
     * 添加折扣方案
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
     * 编辑折扣方案
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
     * 表单数据处理
     * @param array $vo
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$vo)
    {
        if ($this->request->isPost()) {
            $rule = [];
            foreach ($vo as $k => $v) if (stripos($k, '_level_') !== false) {
                [, $level] = explode('_level_', $k);
                $rule[] = ['level' => $level, 'discount' => $v];
            }
            $vo['items'] = json_encode($rule, JSON_UNESCAPED_UNICODE);
        } else {
            $query = $this->app->db->name('DataUserLevel');
            $this->levels = $query->where(['status' => 1])->order('number asc')->select()->toArray();
            if (empty($this->levels)) $this->error('未配置用户等级！');
            if (!empty($vo['items'])) foreach (json_decode($vo['items'], true) as $item) {
                $vo["_level_{$item['level']}"] = $item['discount'];
            }
        }
    }

    /**
     * 修改折扣方案状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table);
    }

    /**
     * 删除折扣方案配置
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}