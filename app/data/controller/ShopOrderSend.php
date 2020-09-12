<?php

namespace app\data\controller;

use app\data\service\OrderService;
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
    private $table = 'ShopOrder';

    /**
     * 订单数据管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '订单数据管理';
        // 状态数据统计
        $this->total = ['t0' => 0, 't1' => 0, 't2' => 0, 't3' => 0, 't4' => 0, 't5' => 0, 'ta' => 0];
        $this->app->db->name($this->table)->fieldRaw('status,count(1) total')->group('status')->select()->map(function ($vo) {
            $this->total["t{$vo['status']}"] = $vo['total'];
            $this->total["ta"] += $vo['total'];
        });
        // 订单列表查询
        $query = $this->_query($this->table);
        $query->equal('status,payment_type,payment_status');
        $query->dateBetween('create_at,payment_datetime,cancel_datetime,truck_datetime,truck_send_datetime');
        $query->like('order_no,truck_name,truck_phone,truck_province|truck_area|truck_address#address,truck_send_no,truck_send_name');
        // 会员搜索查询
        $db = $this->_query('DataMember')->like('phone#member_phone,nickname#member_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("mid in {$db->fieldRaw('id')->buildSql()}");
        // 推荐人搜索查询
        $db = $this->_query('DataMember')->like('phone#from_phone,nickname#from_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("from in {$db->fieldRaw('id')->buildSql()}");
        // 列表选项卡
        if (is_numeric($this->type = trim(input('type', 'ta'), 't'))) {
            $query->where(['status' => $this->type]);
        }
        // 分页排序处理
        if (input('output') === 'json') {
            $result = $query->order('id desc')->page(true, false);
            $this->success('获取数据列表成功', $result);
        } else {
            $query->order('id desc')->page();
        }
    }

    /**
     * 订单列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _index_page_filter(array &$data)
    {
        OrderService::instance()->buildItemData($data);
    }

}