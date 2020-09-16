<?php

namespace app\data\controller;

use app\data\service\TruckService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\extend\DataExtend;

/**
 * 配送运费模板管理
 * Class ShopTruckTemplate
 * @package app\data\controller
 */
class ShopTruckTemplate extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopTruckTemplate';

    /**
     * 快递邮费配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '快递邮费配置';
        $query = $this->_query($this->table)->like('name');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 添加配送邮费模板
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->title = '添加配送邮费模板';
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidDate(12, 'T');
        }
        if ($this->request->isGet()) {
            $this->citys = TruckService::instance()->region(2);
        }
    }

    public function region()
    {
        $this->citys = TruckService::instance()->region(2);
        $this->fetch('form_region');
    }

    /**
     * 修改快递模板
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function edit()
    {
        [$list, $idxs, $post] = [[], [], $this->request->post()];
        foreach (array_keys($post) as $key) if (stripos($key, 'order_reduction_state_') !== false) {
            $idxs[] = str_replace('order_reduction_state_', '', $key);
        }
        foreach (array_unique($idxs) as $index) if (!empty($post["rule_{$index}"])) $list[] = [
            'rule'                  => ',' . join(',', $post["rule_{$index}"]) . ',',
            // 订单满减配置
            'order_reduction_state' => $post["order_reduction_state_{$index}"],
            'order_reduction_price' => $post["order_reduction_price_{$index}"],
            // 首件邮费配置
            'first_number'          => $post["first_number_{$index}"],
            'first_price'           => $post["first_price_{$index}"],
            // 首件邮费配置
            'next_number'           => $post["next_number_{$index}"],
            'next_price'            => $post["next_price_{$index}"],
            // 默认邮费规则
            'is_default'            => $post["is_default_{$index}"],
        ];
        if (empty($list)) $this->error('请配置有效的邮费规则');
        $this->app->db->name($this->table)->where('1=1')->delete();
        $this->app->db->name($this->table)->insertAll($list);
        $this->success('邮费规则配置成功！');
    }

}