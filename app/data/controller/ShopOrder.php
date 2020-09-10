<?php

namespace app\data\controller;

use app\data\service\OrderService;
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
     * @return \think\admin\helper\QueryHelper
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '订单数据管理';
        // 各状态数据统计
        $this->totals = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 'all' => 0];
        $this->app->db->name($this->table)->fieldRaw('status,count(1) total')->group('status')->select()->map(function ($vo) {
            $this->totals[$vo['status']] = $vo['total'];
            $this->totals["all"] += $vo['total'];
        });
        // 订单列表查询
        $query = $this->_query($this->table)->dateBetween('create_at,payment_datetime')->equal('status,payment_status');
        $query->like('order_no,express_send_no,express_name,express_phone,express_province,express_city,express_area,express_address');
        $query->dateBetween('create_at,pay_datetime')->equal('status,pay_state');
        // 会员搜索查询
        $db = $this->_query('DataMember')->like('phone#member_phone,nickname#member_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("mid in {$db->fieldRaw('id')->buildSql()}");
        // 推荐人搜索查询
        $db = $this->_query('DataMember')->like('phone#agent_phone,nickname#agent_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("from in {$db->fieldRaw('id')->buildSql()}");
        // 列表选项卡
        if (is_numeric($this->type = input('type', 'all'))) {
            $query->equal('status#type');
        }
        // 分页排序处理
        if (defined('_ACTION_') && _ACTION_ === 'export') {
            return $query;
        } else {
            $query->order('id desc')->page();
        }
    }

    /**
     * 导出订单数据
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function export()
    {
        define('_ACTION_', 'export');
        $options = ['serialize' => serialize($this->index()->db()->getOptions())];
        $this->_queue('导出订单数据', OrderQueue::class, 0, $options, 0);
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
        $mids = array_unique(array_merge(array_column($data, 'mid'), array_column($data, 'from_mid')));
        $members = $this->app->db->name('DataMember')->whereIn('id', $mids)->column('*', 'id');
        $orderNos = array_unique(array_column($data, 'order_no'));
        $goodsList = $this->app->db->name('ShopOrderItem')->whereIn('order_no', $orderNos)->select()->toArray();
        foreach ($data as &$vo) {
            [$vo['member'], $vo['from_member'], $vo['list']] = [[], [], []];
            $vo['member'] = isset($members[$vo['mid']]) ? $members[$vo['mid']] : [];
            $vo['from_member'] = isset($members[$vo['from_mid']]) ? $members[$vo['from_mid']] : [];
            foreach ($goodsList as $goods) if ($goods['order_no'] === $vo['order_no']) $vo['list'][] = $goods;
        }
    }

    /**
     * 修改快递管理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function express()
    {
        if ($this->request->isGet()) {
            $where = ['is_deleted' => '0', 'status' => '1'];
            $query = $this->app->db->name('ShopExpressCompany')->where($where);
            $this->expressList = $query->order('sort desc,id desc')->select()->toArray();
        }
        $this->_form($this->table);
    }

    /**
     * 快递追踪查询
     * @auth true
     */
    public function expressQuery()
    {
        try {
            $data = $this->_vali([
                'code.require'   => '快递公司不能为空！',
                'number.require' => '配送单号不能为空！',
            ]);
            $this->result = OpenCuciService::instance()->track($data['code'], $data['number']);
            if (empty($this->result['code'])) $this->error($this->result['info']);
            $this->fetch();
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 快递表单处理
     * @param array $vo
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _express_form_filter(&$vo)
    {
        if ($this->request->isPost()) {
            $order = $this->app->db->name($this->table)->where(['id' => $vo['id']])->find();
            if (empty($order)) $this->error('订单查询异常，请稍候再试！');
            $map = ['code_1|code_2|code_3' => $vo['express_company_code']];
            $express = $this->app->db->name('ShopExpressCompany')->where($map)->find();
            if (empty($express)) $this->error('配送快递公司异常，请重新选择快递公司！');
            $vo['express_company_title'] = $express['title'];
            $vo['express_send_at'] = empty($order['express_send_at']) ? date('Y-m-d H:i:s') : $order['express_send_at'];
            $vo['express_state'] = '1';
            $vo['status'] = '4';
        }
    }

    /**
     * 取消订单并创建售后单
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cancel()
    {
        $map = $this->_vali(['order_no.require' => '订单编号不能为空！']);
        $order = $this->app->db->name($this->table)->where($map)->find();
        if (empty($order)) $this->error('订单查询异常');
        if (intval($order['status']) !== 3) $this->error('该订单不能发货！');
        [$rules, $data] = [[], ['type' => 3, 'refund_content' => '后台操作取消订单并申请退款', 'refund_images' => '']];
        foreach ($this->app->db->name("{$this->table}List")->where($map)->select()->toArray() as $item) {
            $rules[] = ['goods_id' => $item['goods_id'], 'goods_spec' => $item['goods_spec'], 'refund_number' => $item['number_goods']];
        }
        try {
            if (OrderService::instance()->refund($order['order_no'], $data, $rules)) {
                $this->app->db->name($this->table)->where($map)->update([
                    'status'             => 0,
                    'cancel_state'       => 1,
                    'cancel_datetime'    => date('Y-m-d H:i:s'),
                    'cancel_description' => '后台操作取消并创建退款申请',
                ]);
                $this->success('取消订单并创建退款申请成功！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}