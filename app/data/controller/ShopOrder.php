<?php

namespace app\data\controller;

use app\data\service\OrderService;
use app\data\service\TruckService;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 订单数据管理
 * Class ShopOrder
 * @package app\data\controller
 */
class ShopOrder extends Controller
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
        // 发货信息搜索
        $db = $this->_query('ShopOrderSend')->like('address_name#truck_address_name,address_phone#truck_address_phone,address_province|address_city|address_area|address_content#truck_address_content')->db();
        if ($db->getOptions('where')) $query->whereRaw("order_no in {$db->field('order_no')->buildSql()}");
        // 用户搜索查询
        $db = $this->_query('DataUser')->like('phone#member_phone,nickname#member_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uid in {$db->field('id')->buildSql()}");
        // 推荐人搜索查询
        $db = $this->_query('DataUser')->like('phone#from_phone,nickname#from_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("from in {$db->field('id')->buildSql()}");
        // 列表选项卡
        if (is_numeric($this->type = trim(input('type', 'ta'), 't'))) $query->where(['status' => $this->type]);
        // 分页排序处理
        $query->order('id desc');
        if (input('output') === 'json') {
            $this->success('获取数据成功', $query->page(true, false));
        } else {
            $query->page();
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

    /**
     * 修改快递管理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function truck()
    {
        if ($this->request->isGet()) {
            $map = ['deleted' => 0, 'status' => 1];
            $query = $this->app->db->name('ShopTruckCompany')->where($map);
            $this->items = $query->order('sort desc,id desc')->select()->toArray();
        }
        $this->_form('ShopOrderSend', '', 'order_no');
    }

    /**
     * 快递表单处理
     * @param array $vo
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _truck_form_filter(array &$vo)
    {
        if ($this->request->isPost()) {
            $map = ['order_no' => $vo['order_no']];
            $order = $this->app->db->name('ShopOrder')->where($map)->find();
            if (empty($order)) $this->error('订单查询异常，请稍候再试！');
            // 配送快递公司信息填写
            $map = ['code_1|code_2|code_3' => $vo['company_code']];
            $company = $this->app->db->name('ShopTruckCompany')->where($map)->find();
            if (empty($company)) $this->error('配送快递公司异常，请重新选择快递公司！');
            $vo['status'] = 2;
            $vo['company_name'] = $company['name'];
            $vo['send_datetime'] = $vo['send_datetime'] ?? date('Y-m-d H:i:s');
            // 更新订单发货状态
            if ($order['status'] === 3) {
                $map = ['order_no' => $vo['order_no']];
                $this->app->db->name('ShopOrder')->where($map)->update(['status' => 4]);
            }
        }
    }

    /**
     * 快递追踪查询
     * @auth true
     */
    public function truckQuery()
    {
        try {
            $data = $this->_vali([
                'code.require'   => '快递编号不能为空！',
                'number.require' => '配送单号不能为空！',
            ]);
            $this->result = TruckService::instance()->query($data['code'], $data['number']);
            if (empty($this->result['code'])) $this->error($this->result['info']);
            $this->fetch('truck_query');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 取消未支付的订单
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cancel()
    {
        $map = $this->_vali([
            'deleted.value'    => 0,
            'order_no.require' => '订单编号不能为空！',
        ]);
        $order = $this->app->db->name($this->table)->where($map)->find();
        if (empty($order)) $this->error('订单查询异常');
        if (!in_array($order['status'], [1, 2])) $this->error('订单不能取消！');
        try {
            $result = $this->app->db->name($this->table)->where($map)->update([
                'status'          => 0,
                'cancel_status'   => 1,
                'cancel_remark'   => '后台未支付的取消',
                'cancel_datetime' => date('Y-m-d H:i:s'),
            ]);
            if ($result !== false) {
                $this->success('取消未支付的订单成功！');
            } else {
                $this->error('取消支付的订单失败！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}