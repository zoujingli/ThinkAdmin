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
use app\data\service\UserAdminService;
use app\data\service\UserUpgradeService;
use think\admin\Controller;

/**
 * 普通用户管理
 * Class Admin
 * @package app\data\controller\user
 */
class Admin extends Controller
{
    /**
     * 普通用户管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        // 用户等级分组
        [$ts, $ls] = [[], BaseUserUpgrade::items()];
        $ts['ta'] = ['vip' => '', 'name' => '全部用户', 'count' => 0];
        foreach ($ls as $k => $v) $ts["t{$k}"] = ['vip' => $k, 'name' => $v['name'], 'count' => 0,];
        $ts['to'] = ['vip' => '', 'name' => '其他用户', 'count' => 0];
        // 等级分组统计
        foreach (DataUser::mk()->field('vip_code vip,count(1) count')->group('vip_code')->cursor() as $v) {
            [$name, $count] = ["t{$v['vip']}", $v['count'], $ts['ta']['count'] += $v['count']];
            isset($ts[$name]) ? $ts[$name]['count'] += $count : $ts['to']['count'] += $count;
        }
        if (empty($ts['to']['count'])) unset($ts['to']);
        $this->total = $ts;

        // 设置页面标题
        $this->title = '普通用户管理';

        // 创建查询对象
        $query = DataUser::mQuery()->order('id desc');

        // 数据筛选选项
        $this->type = ltrim(input('type', 'ta'), 't');
        if (is_numeric($this->type)) $query->where(['vip_code' => $this->type]);
        elseif ($this->type === 'o') $query->whereNotIn('vip_code', array_keys($ls));

        // 用户搜索查询
        $db = DataUser::mQuery()->equal('vip_code#from_vipcode')->like('phone|username|nickname#from_keys')->db();
        if ($db->getOptions('where')) $query->whereRaw("pid1 in {$db->field('id')->buildSql()}");

        // 数据查询分页
        $query->like('phone|username|nickname#username')->equal('status,vip_code')->dateBetween('create_at')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        $this->upgrades = BaseUserUpgrade::items();
        UserAdminService::buildByUid($data, 'pid1', 'from');
    }

    /**
     * 用户团队关系
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function teams()
    {
        $this->title = '用户团队关系';
        $map = ['pid1' => input('from', 0)];
        DataUser::mQuery()->where($map)->page(false);
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _teams_page_filter(array &$data)
    {
        $uids = array_unique(array_column($data, 'id'));
        $subCount = DataUser::mk()->whereIn('pid1', $uids)->group('pid1')->column('count(1) count', 'pid1');
        foreach ($data as &$vo) $vo['subCount'] = $subCount[$vo['id']] ?? 0;
    }

    /**
     * 永久绑定代理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function forever()
    {
        $map = $this->_vali(['id.require' => '用户ID不能为空！']);
        $user = DataUser::mk()->where($map)->find();
        if (empty($user) || empty($user['pid0'])) $this->error('用户不符合操作要求！');
        [$status, $message] = UserUpgradeService::bindAgent($user['id'], $user['pid0']);
        $status && sysoplog('前端用户管理', "修改用户[{$map['id']}]的代理为永久状态");
        empty($status) ? $this->error($message) : $this->success($message);
    }

    /**
     * 设为总部用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function unbind()
    {
        $map = $this->_vali(['id.require' => '用户ID不能为空！']);
        $user = DataUser::mk()->where($map)->findOrEmpty();
        if ($user->isEmpty()) $this->error('用户不符合操作要求！');
        // 修改指定用户代理数据
        $user->save(['pid0' => 0, 'pid1' => 0, 'pid2' => 0, 'pids' => 1, 'path' => '-', 'layer' => 1]);
        // 刷新用户等级及上级等级
        UserUpgradeService::upgrade($user['id'], true);
        sysoplog('前端用户管理', "设置用户[{$map['id']}]为总部用户");
        $this->success('设为总部用户成功！');
    }

    /**
     * 绑定上级代理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function parent()
    {
        if ($this->request->isGet()) {
            $this->upgrades = BaseUserUpgrade::items();
            $data = $this->_vali(['uuid.require' => '待操作UID不能为空！']);

            // 排除下级用户
            $path = DataUser::mk()->where(['id' => $data['uuid']])->value('path', '-');
            $subids = DataUser::mk()->whereLike('path', "{$path}{$data['uuid']}-%")->column('id');
            $query = DataUser::mQuery()->order('id desc')->whereNotIn('id', array_merge($subids, array_values($data)));

            // 用户搜索查询
            $db = DataUser::mQuery()->equal('vip_code#from_vipcode')->like('phone#from_phone,username|nickname#from_username')->db();
            if ($db->getOptions('where')) $query->whereRaw("pid1 in {$db->field('id')->buildSql()}");

            // 数据查询分页
            $query->like('phone,username|nickname#username')->whereRaw('vip_code>0')->equal('status,vip_code')->dateBetween('create_at')->page();
        } else {
            $data = $this->_vali(['pid.require' => '待绑定代理不能为空！', 'uuid.require' => '待操作用户不能为空！']);
            [$status, $message] = UserUpgradeService::bindAgent($data['uuid'], $data['pid'], 2);
            $status && sysoplog('前端用户管理', "修改用户[{$data['uuid']}]的代理为用户[{$data['pid']}]");
            empty($status) ? $this->error($message) : $this->success($message);
        }
    }

    /**
     * 重算用户余额返利
     * @auth true
     */
    public function sync()
    {
        $this->_queue('重新计算用户余额返利', 'xdata:UserAmount');
    }

    /**
     * 修改用户状态
     * @auth true
     */
    public function state()
    {
        DataUser::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }
}