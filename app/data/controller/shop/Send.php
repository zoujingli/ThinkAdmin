<?php

namespace app\data\controller\shop;

use app\data\service\OrderService;
use think\admin\Controller;

/**
 * 订单发货管理
 * Class Send
 * @package app\data\controller\shop
 */
class Send extends Controller
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
        // 发货地址数据
        $this->address = sysdata('ordersend');
        // 状态数据统计
        $this->total = ['t0' => 0, 't1' => 0, 't2' => 0, 'ta' => 0];
        $db = $this->app->db->name('ShopOrder')->whereIn('status', [4, 5, 6])->where(['truck_type' => 1]);
        $query = $this->app->db->name($this->table)->whereRaw("order_no in {$db->field('order_no')->buildSql()}");
        foreach ($query->fieldRaw('status,count(1) total')->group('status')->cursor() as $vo) {
            $this->total["t{$vo['status']}"] = $vo['total'];
            $this->total["ta"] += $vo['total'];
        }
        // 订单列表查询
        $query = $this->_query($this->table);
        $query->dateBetween('address_datetime,send_datetime')->equal('status')->like('send_number#truck_number,order_no');
        $query->like('address_phone,address_name,address_province|address_city|address_area|address_content#address_content');
        // 用户搜索查询
        $db = $this->_query('DataUser')->like('phone#user_phone,nickname#user_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uid in {$db->field('id')->buildSql()}");
        // 订单搜索查询
        $db = $this->app->db->name('ShopOrder')->whereIn('status', [4, 5, 6])->where(['truck_type' => 1]);
        $query->whereRaw("order_no in {$db->field('order_no')->buildSql()}");
        // 列表选项卡状态
        if (is_numeric($this->type = trim(input('type', 'ta'), 't'))) {
            $query->where(['status' => $this->type]);
        }
        // 列表排序显示
        $query->order('id desc')->page();
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
        OrderService::instance()->buildData($data, false);
        $orders = array_unique(array_column($data, 'order_no'));
        $orderList = $this->app->db->name('ShopOrder')->whereIn('order_no', $orders)->column('*', 'order_no');
        foreach ($data as &$vo) $vo['order'] = $orderList[$vo['order_no']] ?? [];
    }

    /**
     * 修改发货地址
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        if ($this->request->isGet()) {
            $this->vo = sysdata('ordersend');
            $this->fetch();
        } else {
            sysdata('ordersend', $this->request->post());
            $this->success('发货地址保存成功');
        }
    }

}