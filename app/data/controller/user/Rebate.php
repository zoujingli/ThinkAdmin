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

namespace app\data\controller\user;

use app\data\model\BaseUserUpgrade;
use app\data\model\DataUser;
use app\data\model\DataUserRebate;
use app\data\model\ShopOrderItem;
use app\data\service\RebateService;
use app\data\service\UserRebateService;
use think\admin\Controller;

/**
 * 用户返利管理
 * Class Rebate
 * @package app\data\controller\user
 */
class Rebate extends Controller
{
    /**
     * 用户返利管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '用户返利管理';
        // 统计所有返利
        $this->types = RebateService::PRIZES;
        $this->rebate = UserRebateService::amount(0);
        // 创建查询对象
        $query = DataUserRebate::mQuery()->equal('type')->like('name,order_no');
        // 会员条件查询
        $db = $this->_query('DataUser')->like('nickname#order_nickname,phone#order_phone')->db();
        if ($db->getOptions('where')) $query->whereRaw("order_uuid in {$db->field('id')->buildSql()}");
        // 代理条件查询
        $db = $this->_query('DataUser')->like('nickname#agent_nickname,phone#agent_phone')->db();
        if ($db->getOptions('where')) $query->whereRaw("uuid in {$db->field('id')->buildSql()}");
        // 查询分页
        $query->dateBetween('create_at')->order('id desc')->page();
    }

    /**
     * 商城订单列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _index_page_filter(array &$data)
    {
        $uids = array_merge(array_column($data, 'uuid'), array_column($data, 'order_uuid'));
        $userItem = DataUser::mk()->whereIn('id', array_unique($uids))->select();
        $goodsItem = ShopOrderItem::mk()->whereIn('order_no', array_unique(array_column($data, 'order_no')))->select();
        foreach ($data as &$vo) {
            $vo['type'] = RebateService::name($vo['type']);
            [$vo['user'], $vo['agent'], $vo['list']] = [[], [], []];
            foreach ($userItem as $user) {
                if ($user['id'] === $vo['uuid']) $vo['agent'] = $user;
                if ($user['id'] === $vo['order_uuid']) $vo['user'] = $user;
            }
            foreach ($goodsItem as $goods) {
                if ($goods['order_no'] === $vo['order_no']) {
                    $vo['list'][] = $goods;
                }
            }
        }
    }

    /**
     * 用户返利配置
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        $this->skey = 'RebateRule';
        $this->title = '用户返利配置';
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->levels = BaseUserUpgrade::items();
            $this->fetch();
        } else {
            sysdata($this->skey, $this->request->post());
            $this->success('奖励修改成功');
        }
    }
}