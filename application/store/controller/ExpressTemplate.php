<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\controller;

use library\Controller;
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
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->title = '邮费模板管理';
        $filename = env('root_path') . 'public/static/plugs/jquery/area/area.json';
        $this->provinces = array_column(json_decode(file_get_contents($filename), true), 'name');
        $this->list = Db::name($this->table)->where(['is_default' => '0'])->select();
        foreach ($this->list as &$item) $item['rule'] = explode(',', $item['rule']);
        $this->default = Db::name($this->table)->where(['is_default' => '1'])->find();
        $this->fetch();
    }

    /**
     * 保存邮费模板
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function save()
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
