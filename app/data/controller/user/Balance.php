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
use app\data\model\DataUserBalance;
use app\data\service\UserAdminService;
use app\data\service\UserBalanceService;
use app\data\service\UserUpgradeService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;

/**
 * 余额充值记录
 * Class Balance
 * @package app\data\controller\user
 */
class Balance extends Controller
{
    /**
     * 余额充值管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '余额充值记录';
        // 统计用户余额
        $this->balance = UserBalanceService::amount(0);
        // 现有余额类型
        $this->names = DataUserBalance::mk()->group('name')->column('name');
        // 创建查询对象
        $query = DataUserBalance::mQuery()->equal('name,upgrade');
        // 用户搜索查询
        $db = DataUser::mQuery()->like('phone|nickname#user_keys')->db();
        if ($db->getOptions('where')) $query->whereRaw("uuid in {$db->field('id')->buildSql()}");
        // 数据查询分页
        $query->where(['deleted' => 0])->like('code,remark')->dateBetween('create_at')->order('id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        UserAdminService::buildByUid($data);
        $uids = array_unique(array_column($data, 'create_by'));
        $users = SystemUser::mk()->whereIn('id', $uids)->column('username', 'id');
        $this->upgrades = BaseUserUpgrade::items();
        foreach ($data as &$vo) {
            $vo['upgradeinfo'] = $this->upgrades[$vo['upgrade']] ?? [];
            $vo['create_byname'] = $users[$vo['create_by']] ?? '';
        }
    }

    /**
     * 添加余额充值
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $data = $this->_vali(['uuid.require' => '用户UID不能为空！']);
        $this->user = DataUser::mk()->where(['id' => $data['uuid']])->find();
        if (empty($this->user)) $this->error('待充值的用户不存在！');
        DataUserBalance::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidDate('20', 'B');
        }
        if ($this->request->isGet()) {
            $this->upgrades = BaseUserUpgrade::items();
        }
        if ($this->request->isPost()) {
            $data['create_by'] = AdminService::getUserId();
            if (empty(floatval($data['amount'])) && empty($data['upgrade'])) {
                $this->error('金额为零并且没有升级行为！');
            }
        }
    }

    /**
     * 表单结果处理
     * @param bool $state
     * @param array $data
     * @throws \think\db\exception\DbException
     */
    protected function _form_result(bool $state, array $data)
    {
        if ($state && isset($data['uuid'])) {
            UserBalanceService::amount($data['uuid']);
            UserUpgradeService::upgrade($data['uuid']);
        }
    }

    /**
     * 删除充值记录
     * @auth true
     */
    public function remove()
    {
        DataUserBalance::mDelete('', [['code', 'like', 'B%']]);
    }

    /**
     * 删除结果处理
     * @param bool $state
     * @throws \think\db\exception\DbException
     */
    protected function _delete_result(bool $state)
    {
        if ($state) {
            $map = [['id', 'in', str2arr(input('id', ''))]];
            foreach (DataUserBalance::mk()->where($map)->cursor() as $vo) {
                UserBalanceService::amount($vo['uuid']);
                UserUpgradeService::upgrade($vo['uuid']);
            }
        }
    }
}