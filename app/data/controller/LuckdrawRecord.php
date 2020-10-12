<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 奖品领取记录
 * Class LuckdrawRecord
 * @package app\activity\controller
 */
class LuckdrawRecord extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'ActivityLuckdrawRecord';

    /**
     * 中奖记录管理
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
        $this->title = '中奖记录管理';
        $query = $this->_query($this->table)->like('phone,username,prize_name,prize_level');
        $query->equal('uncode_status,code')->dateBetween('create_at,uncode_datetime')->order('id desc');
        if (input('output') === 'json') {
            $result = $query->page(true, false);
            $this->success('获取数据列表成功', $result);
        } else {
            $query->page();
        }
    }

    /**
     * 页面数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _page_filter(array &$data)
    {
        $this->prizes = $this->app->db->name('ActivityLuckdrawConfig')->where(['deleted' => 0])->order('id desc')->select()->toArray();
        $members = $this->app->db->name('ActivityLuckdrawMember')->whereIn('id', array_unique(array_column($data, 'mid')))->column('*', 'mid');
        $acitves = $this->app->db->name('ActivityLuckdrawConfig')->whereIn('code', array_unique(array_column($data, 'code')))->column('*', 'code');
        foreach ($data as &$vo) {
            $vo['info'] = $acitves[$vo['code']] ?? [];
            $vo['member'] = $members[$vo['mid']] ?? [];
        }
    }

}