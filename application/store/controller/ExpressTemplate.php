<?php

namespace app\store\controller;

use library\Controller;
use library\tools\Data;
use think\Db;

/**
 * 邮费模板管理
 * Class ExpressTemplate
 * @package app\store\controller
 */
class ExpressTemplate extends Controller
{
    /**
     * 指定数据表
     * @var string
     */
    protected $table = 'StoreExpressTemplate';

    /**
     * 邮费模板管理
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '邮费模板管理';
    }

    /**
     * 显示邮费模板
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _index_get()
    {
        $this->provinces = Db::name('StoreExpressProvince')->where(['status' => '1'])->order('sort asc,id desc')->column('title');
        $this->list = Db::name($this->table)->where(['is_default' => '0'])->select();
        foreach ($this->list as &$item) $item['rule'] = explode(',', $item['rule']);
        $this->default = Db::name($this->table)->where(['is_default' => '1'])->find();
        $this->fetch();
    }

    /**
     * 保存邮费模板
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _index_post()
    {
        list($list, $idxs, $post) = [[], [], $this->request->post()];
        foreach (array_keys($post) as $key) if (stripos($key, 'order_reduction_state_') !== false) {
            $idxs[] = str_replace('order_reduction_state_', '', $key);
        }
        foreach (array_unique($idxs) as $index) if (!empty($post["rule_{$index}"])) $list[] = [
            'rule'                  => join(',', $post["rule_{$index}"]),
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
        Db::name($this->table)->where('1=1')->delete();
        Db::name($this->table)->insertAll($list);
        $this->success('邮费规则配置成功！');
    }

}