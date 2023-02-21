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

use app\data\model\DataUser;
use app\data\model\ShopOrder;
use app\data\model\ShopOrderSend;
use app\data\service\OrderService;
use app\data\service\PaymentService;
use app\data\service\UserAdminService;
use Exception;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\exception\HttpResponseException;

/**
 * 订单数据管理
 * Class Order
 * @package app\data\controller\shop
 */
class Order extends Controller
{
    /**
     * 支付方式
     * @var array
     */
    protected $payments = [];

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        parent::initialize();
        $this->payments = PaymentService::getTypeAll();
    }

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
        $this->total = ['t0' => 0, 't1' => 0, 't2' => 0, 't3' => 0, 't4' => 0, 't5' => 0, 't6' => 0, 'ta' => 0];
        foreach (ShopOrder::mk()->field('status,count(1) total')->group('status')->cursor() as $vo) {
            [$this->total["t{$vo['status']}"] = $vo['total'], $this->total["ta"] += $vo['total']];
        }

        // 订单列表查询
        $query = ShopOrder::mQuery();
        $query->like('order_no,truck_name,truck_phone,truck_province|truck_area|truck_address#address,truck_send_no,truck_send_name');
        $query->equal('status,payment_type,payment_status')->dateBetween('create_at,payment_datetime,cancel_datetime,truck_datetime,truck_send_datetime');

        // 发货信息搜索
        $db = ShopOrderSend::mQuery()->like('address_name#truck_address_name,address_phone#truck_address_phone,address_province|address_city|address_area|address_content#truck_address_content')->db();
        if ($db->getOptions('where')) $query->whereRaw("order_no in {$db->field('order_no')->buildSql()}");

        // 用户搜索查询
        $db = DataUser::mQuery()->like('phone|nickname#user_keys')->db();
        if ($db->getOptions('where')) $query->whereRaw("uuid in {$db->field('id')->buildSql()}");

        // 代理搜索查询
        $db = DataUser::mQuery()->like('phone|nickname#from_keys')->db();
        if ($db->getOptions('where')) $query->whereRaw("puid1 in {$db->field('id')->buildSql()}");

        // 列表选项卡
        if (is_numeric($this->type = trim(input('type', 'ta'), 't'))) {
            $query->where(['status' => $this->type]);
        }

        // 分页排序处理
        $query->where(['deleted_status' => 0])->order('id desc')->page();
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
        UserAdminService::buildByUid($data);
        UserAdminService::buildByUid($data, 'puid1', 'from');
        OrderService::buildData($data);
        foreach ($data as &$vo) {
            if (!is_null($vo['payment_type']) and '' != $vo['payment_type']) {
                $vo['payment_name'] = PaymentService::name($vo['payment_type']);
            }
        }
    }

    /**
     * 单据凭证支付审核
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function audit()
    {
        if ($this->request->isGet()) {
            ShopOrder::mForm('', 'order_no');
        } else {
            $data = $this->_vali([
                'order_no.require' => '订单单号不能为空！',
                'status.in:0,1'    => '审核状态数值异常！',
                'status.require'   => '审核状态不能为空！',
                'remark.default'   => '',
            ]);
            if (empty($data['status'])) {
                $data['status'] = 0;
                $data['cancel_status'] = 1;
                $data['cancel_remark'] = $data['remark'] ?: '后台审核驳回并取消订单';
                $data['cancel_datetime'] = date('Y-m-d H:i:s');
            } else {
                $data['status'] = 4;
                $data['payment_code'] = CodeExtend::uniqidDate(20, 'T');
                $data['payment_status'] = 1;
                $data['payment_remark'] = $data['remark'] ?: '后台审核支付凭证通过';
                $data['payment_datetime'] = date('Y-m-d H:i:s');
            }
            $order = ShopOrder::mk()->where(['order_no' => $data['order_no']])->find();
            if (empty($order) || $order['status'] !== 3) $this->error('不允许操作审核！');
            // 无需发货时的处理
            if ($data['status'] === 4 && empty($order['truck_type'])) $data['status'] = 6;
            // 更新订单支付状态
            $map = ['status' => 3, 'order_no' => $data['order_no']];
            if (ShopOrder::mk()->strict(false)->where($map)->update($data) !== false) {
                if (in_array($data['status'], [4, 5, 6])) {
                    $this->app->event->trigger('ShopOrderPayment', $data['order_no']);
                    $this->success('订单审核通过成功！');
                } else {
                    $this->app->event->trigger('ShopOrderCancel');
                    OrderService::stock($data['order_no']);
                    $this->success('审核驳回并取消成功！');
                }
            } else {
                $this->error('订单审核失败！');
            }
        }
    }

    /**
     * 清理订单数据
     * @auth true
     */
    public function clean()
    {
        $this->_queue('定时清理无效订单数据', "xdata:OrderClean", 0, [], 0, 60);
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
        $map = $this->_vali(['order_no.require' => '订单号不能为空！',]);
        $order = ShopOrder::mk()->where($map)->find();
        if (empty($order)) $this->error('订单查询异常！');
        if (!in_array($order['status'], [1, 2, 3])) $this->error('订单不能取消！');
        try {
            $result = $order->save([
                'status'          => 0,
                'cancel_status'   => 1,
                'cancel_remark'   => '后台取消未支付的订单',
                'cancel_datetime' => date('Y-m-d H:i:s'),
            ]);
            if ($result !== false) {
                OrderService::stock($order['order_no']);
                $this->app->event->trigger('ShopOrderCancel', $order['order_no']);
                $this->success('取消未支付的订单成功！');
            } else {
                $this->error('取消支付的订单失败！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}