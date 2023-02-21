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

namespace app\data\controller\shop;

use app\data\model\BasePostageCompany;
use app\data\model\DataUser;
use app\data\model\ShopOrder;
use app\data\model\ShopOrderSend;
use app\data\service\ExpressService;
use app\data\service\OrderService;
use Exception;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 订单发货管理
 * Class Send
 * @package app\data\controller\shop
 */
class Send extends Controller
{
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
        $db = ShopOrder::mk()->whereIn('status', [4, 5, 6])->where(['truck_type' => 1]);
        $query = ShopOrderSend::mk()->whereRaw("order_no in {$db->field('order_no')->buildSql()}");
        foreach ($query->fieldRaw('status,count(1) total')->group('status')->cursor() as $vo) {
            $this->total["t{$vo['status']}"] = $vo['total'];
            $this->total["ta"] += $vo['total'];
        }

        // 订单列表查询
        $query = ShopOrderSend::mQuery();
        $query->dateBetween('address_datetime,send_datetime')->equal('status')->like('send_number#truck_number,order_no');
        $query->like('address_phone,address_name,address_province|address_city|address_area|address_content#address_content');

        // 用户搜索查询
        $db = DataUser::mQuery()->like('phone|nickname#user_keys')->db();
        if ($db->getOptions('where')) $query->whereRaw("uuid in {$db->field('id')->buildSql()}");

        // 订单搜索查询
        $db = ShopOrder::mk()->whereIn('status', [4, 5, 6])->where(['truck_type' => 1]);
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
        OrderService::buildData($data, false);
        $orders = array_unique(array_column($data, 'order_no'));
        $orderList = ShopOrder::mk()->whereIn('order_no', $orders)->column('*', 'order_no');
        foreach ($data as &$vo) $vo['order'] = $orderList[$vo['order_no']] ?? [];
    }

    /**
     * 快递发货地址
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
            $query = BasePostageCompany::mk()->where(['deleted' => 0, 'status' => 1]);
            $this->items = $query->order('sort desc,id desc')->select()->toArray();
        }
        ShopOrderSend::mForm('truck_form', 'order_no');
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
            $order = ShopOrder::mk()->where($map)->find();
            if (empty($order)) $this->error('订单查询异常，请稍候再试！');

            // 配送快递公司填写
            $map = ['code_1|code_2|code_3' => $vo['company_code']];
            $company = BasePostageCompany::mk()->where($map)->find();
            if (empty($company)) $this->error('配送快递公司异常，请重新选择快递公司！');

            $vo['status'] = 2;
            $vo['company_name'] = $company['name'];
            $vo['send_datetime'] = $vo['send_datetime'] ?? date('Y-m-d H:i:s');
            if ($order['status'] === 4) {
                // 更新订单发货状态
                $map = ['order_no' => $vo['order_no']];
                ShopOrder::mk()->where($map)->update(['status' => 5]);
            }
        }
    }

    /**
     * 快递追踪查询
     * @auth true
     */
    public function query()
    {
        try {
            $data = $this->_vali(['code.require' => '快递不能为空！', 'number.require' => '单号不能为空！']);
            $this->result = ExpressService::query($data['code'], $data['number']);
            if (empty($this->result['code'])) $this->error($this->result['info']);
            $this->fetch('truck_query');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}