<?php

namespace app\data\controller\base;

use app\data\service\RebateService;
use think\admin\Controller;

/**
 * 用户等级管理
 * Class Upgrade
 * @package app\data\controller\base
 */
class Upgrade extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'BaseUserUpgrade';

    /**
     * 用户等级管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '用户等级管理';
        $this->_query($this->table)->order('number asc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['rebate_rule'] = str2arr($vo['rebate_rule']);
            foreach ($vo['rebate_rule'] as &$v) {
                $v = RebateService::instance()->name($v);
            }
        }
    }

    /**
     * 添加用户等级
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
     * 编辑用户等级
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
     */
    protected function _form_filter(array &$vo)
    {
        if ($this->request->isGet()) {
            $this->prizes = RebateService::PRIZES;
            if (!isset($vo['number'])) {
                $vo['number'] = $this->app->db->name($this->table)->order('number desc')->value('number', -1) + 1;
            }
            $vo['rebate_rule'] = str2arr($vo['rebate_rule'] ?? '');
        } else {
            $vo['utime'] = time();
            $vo['rebate_rule'] = arr2str($vo['rebate_rule'] ?? []);
            // 用户升级条件开关
            $vo['goods_vip_status'] = isset($vo['goods_vip_status']) ? 1 : 0;
            $vo['teams_users_status'] = isset($vo['teams_users_status']) ? 1 : 0;
            $vo['teams_direct_status'] = isset($vo['teams_direct_status']) ? 1 : 0;
            $vo['teams_indirect_status'] = isset($vo['teams_indirect_status']) ? 1 : 0;
            $vo['order_amount_status'] = isset($vo['order_amount_status']) ? 1 : 0;
            // 根据数量判断状态
            $vo['teams_users_status'] = intval($vo['teams_users_status'] && $vo['teams_users_number'] > 0);
            $vo['teams_direct_status'] = intval($vo['teams_direct_status'] && $vo['teams_direct_number'] > 0);
            $vo['teams_indirect_status'] = intval($vo['teams_indirect_status'] && $vo['teams_indirect_number'] > 0);
            $vo['order_amount_status'] = intval($vo['order_amount_status'] && $vo['order_amount_number'] > 0);
            // 检查升级条件配置
            $count = 0;
            foreach ($vo as $k => $v) if (is_numeric(stripos($k, '_status'))) $count += $v;
            if (empty($count) && $vo['number'] > 0) $this->error('升级条件不能为空！');
        }
    }

    /**
     * 表单结果处理
     * @param boolean $state
     * @throws \think\db\exception\DbException
     */
    public function _form_result(bool $state)
    {
        if ($state) {
            $order = 'number asc,utime desc';
            if (input('old_number', 100) <= input('number', 0)) $order = 'number asc,utime asc';
            foreach ($this->app->db->name($this->table)->order($order)->cursor() as $k => $vo) {
                $this->app->db->name($this->table)->where(['id' => $vo['id']])->update(['number' => $k]);
            }
        }
    }

    /**
     * 重算用户等级
     * @auth true
     */
    public function sync()
    {
        $this->_queue('重新计算所有用户等级', 'xdata:UserUpgrade');
    }

    /**
     * 修改等级状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table);
    }

    /**
     * 删除用户等级
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

    /**
     * 状态变更处理
     * @auth true
     * @throws \think\db\exception\DbException
     */
    protected function _save_result()
    {
        $this->_form_result(true);
    }

    /**
     * 删除结果处理
     * @throws \think\db\exception\DbException
     */
    protected function _delete_result()
    {
        $this->_form_result(true);
    }

}