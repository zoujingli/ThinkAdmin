<?php

namespace app\data\service;

use think\admin\Service;
use think\admin\service\InterfaceService;

/**
 * 订单数据服务
 * Class OrderService
 * @package app\data\service
 */
class OrderService extends Service
{
    /**
     * 同步订单支付状态
     * @param string $orderno
     * @return bool
     */
    public function syncAmount(string $orderno): bool
    {
        //@todo 处理订单支付完成的动作
        return true;
    }

    /**
     * 获取随机减免金额
     * @return float
     */
    public function getReduct()
    {
        return rand(1, 100) / 100;
    }

    /**
     * 同步订单关联商品的库存
     * @param string $order_no 订单编号
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncStock(string $order_no)
    {
        $map = ['order_no' => $order_no];
        $codes = $this->app->db->name('ShopOrderItem')->where($map)->column('goods_code');
        foreach (array_unique($codes) as $code) GoodsService::instance()->syncStock($code);
        return true;
    }

    /**
     * 楚才开放平台快递查询
     * @param string $code 快递公司编号
     * @param string $number 快递配送单号
     * @return array
     * @throws \think\admin\Exception
     */
    public function trackExpress($code, $number)
    {
        $service = InterfaceService::instance();
        // 测试的账号及密钥，随时可能会变更，请联系客服获取自己的账号和密钥
        $service->setAuth('6998081316132228', '193fc1d9a2aac78475bc8dbeb9a5feb1');
        return $service->doRequest('https://open.cuci.cc/user/api.auth.express/query', [
            'type' => 'free', 'express' => $code, 'number' => $number,
        ]);
    }

    /**
     * 绑定订单详情数据
     * @param array $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function buildItemData(array &$data = []): array
    {
        $mids = array_unique(array_merge(array_column($data, 'mid'), array_column($data, 'from')));
        $members = $this->app->db->name('DataMember')->whereIn('id', $mids)->column('*', 'id');
        // 商品详情管理
        $query = $this->app->db->name('ShopOrderItem')->where(['status' => 1, 'deleted' => 0]);
        $items = $query->whereIn('order_no', array_unique(array_column($data, 'order_no')))->select()->toArray();
        foreach ($data as &$vo) {
            [$vo['count'], $vo['items']] = [0, []];
            $vo['member'] = $members[$vo['mid']] ?? [];
            $vo['fromer'] = $members[$vo['from']] ?? [];
            foreach ($items as $item) {
                if ($vo['order_no'] === $item['order_no']) {
                    $vo['count'] += $item['stock_sales'];
                    $vo['items'][] = $item;
                }
            }
        }
        return $data;
    }

}