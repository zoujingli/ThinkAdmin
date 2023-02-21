<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\controller\base;

use app\data\model\BaseUserUpgrade;
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
        BaseUserUpgrade::mQuery()->like('name')->equal('status')->dateBetween('create_at')->layTable();
    }

    /**
     * 添加用户等级
     * @auth true
     * @return void
     * @throws \think\db\exception\DbException
     */
    public function add()
    {
        $this->max = BaseUserUpgrade::maxNumber() + 1;
        BaseUserUpgrade::mForm('form');
    }

    /**
     * 编辑用户等级
     * @auth true
     * @return void
     * @throws \think\db\exception\DbException
     */
    public function edit()
    {
        $this->max = BaseUserUpgrade::maxNumber();
        BaseUserUpgrade::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     * @throws \think\db\exception\DbException
     */
    protected function _form_filter(array &$vo)
    {
        if ($this->request->isGet()) {
            $this->prizes = RebateService::PRIZES;
            $vo['number'] = $vo['number'] ?? BaseUserUpgrade::maxNumber();
        } else {
            $vo['utime'] = time();
            // 用户升级条件开关
            $vo['goods_vip_status'] = isset($vo['goods_vip_status']) ? 1 : 0;
            $vo['teams_users_status'] = isset($vo['teams_users_status']) ? 1 : 0;
            $vo['teams_direct_status'] = isset($vo['teams_direct_status']) ? 1 : 0;
            $vo['teams_indirect_status'] = isset($vo['teams_indirect_status']) ? 1 : 0;
            $vo['order_amount_status'] = isset($vo['order_amount_status']) ? 1 : 0;
            // 默认等级去除条件
            if (empty($vo['number'])) {
                $vo['rebate_rule'] = [];
                foreach ($vo as $k => &$v) if (is_numeric(stripos($k, '_status'))) $v = 0;
            }
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function _form_result(bool $state)
    {
        if ($state) {
            $isasc = input('old_number', 0) <= input('number', 0);
            $order = $isasc ? 'number asc,utime asc' : 'number asc,utime desc';
            foreach (BaseUserUpgrade::mk()->order($order)->select() as $number => $upgrade) {
                $upgrade->save(['number' => $number]);
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
     */
    public function state()
    {
        BaseUserUpgrade::mSave();
    }

    /**
     * 删除用户等级
     * @auth true
     */
    public function remove()
    {
        BaseUserUpgrade::mDelete();
    }

    /**
     * 状态变更处理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _save_result()
    {
        $this->_form_result(true);
    }

    /**
     * 删除结果处理
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _delete_result()
    {
        $this->_form_result(true);
    }
}