<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 订单发货管理
 * Class ShopOrderSend
 * @package app\data\controller
 */
class ShopOrderSend extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopOrderSend';

    /**
     * 订单发货管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '订单发货管理';
        // 状态数据统计
        $this->total = ['t0' => 0, 't1' => 0, 't2' => 0, 'ta' => 0];
        $this->app->db->name($this->table)->fieldRaw('status,count(1) total')->group('status')->select()->map(function ($vo) {
            $this->total["t{$vo['status']}"] = $vo['total'];
            $this->total["ta"] += $vo['total'];
        });
        // 订单列表查询
        $query = $this->_query($this->table)->order('id desc');
        $query->dateBetween('address_datetime,send_datetime')->equal('status')->like('send_number#truck_number');
        $query->like('address_phone,address_name,address_province|address_city|address_area|address_content#address_content');
        // 用户搜索查询
        $db = $this->_query('DataUser')->like('phone#member_phone,nickname#member_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uid in {$db->field('id')->buildSql()}");
        // 订单搜索查询
        $db = $this->_query('ShopOrder')->whereIn('status', [3, 4, 5])->db();
        if ($db->getOptions('where')) $query->whereRaw("order_no in {$db->field('order_no')->buildSql()}");
        // 列表选项卡状态
        if (is_numeric($this->type = trim(input('type', 'ta'), 't'))) {
            $query->where(['status' => $this->type]);
        }
        // 分页排序处理
        if (input('output') === 'json') {
            $result = $query->page(true, false);
            $this->success('获取数据成功', $result);
        } else {
            $query->page();
        }
    }

    /**
     * 订单列表处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        $uids = array_unique(array_column($data, 'uid'));
        $users = $this->app->db->name('DataUser')->whereIn('id', $uids)->column('*', 'id');
        foreach ($data as &$vo) $vo['member'] = $users[$vo['uid']] ?? [];
    }

}