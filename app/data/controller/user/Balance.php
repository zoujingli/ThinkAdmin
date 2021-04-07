<?php

namespace app\data\controller\user;

use app\data\service\UserAdminService;
use app\data\service\UserBalanceService;
use app\data\service\UserUpgradeService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\service\AdminService;

/**
 * 余额充值记录
 * Class Balance
 * @package app\data\controller\user
 */
class Balance extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserBalance';

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
        $this->balance = UserBalanceService::instance()->amount(0);
        // 现有余额类型
        $this->names = $this->app->db->name($this->table)->group('name')->column('name');
        // 创建查询对象
        $query = $this->_query($this->table)->equal('name,upgrade');
        // 用户搜索查询
        $db = $this->_query('DataUser')->like('phone#user_phone,nickname#user_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uid in {$db->field('id')->buildSql()}");
        // 数据查询分页
        $query->where(['deleted' => 0])->like('code,remark')->dateBetween('create_at')->order('id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        UserAdminService::instance()->buildByUid($data);
        $uids = array_unique(array_column($data, 'create_by'));
        $users = $this->app->db->name('SystemUser')->whereIn('id', $uids)->column('username', 'id');
        $this->upgrades = UserUpgradeService::instance()->levels();
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
        $data = $this->_vali(['uid.require' => '用户UID不能为空！']);
        $this->user = $this->app->db->name('DataUser')->where(['id' => $data['uid']])->find();
        if (empty($this->user)) $this->error('待充值的用户不存在！');
        $this->_form($this->table, 'form');
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
            $this->upgrades = UserUpgradeService::instance()->levels();
        }
        if ($this->request->isPost()) {
            $data['create_by'] = AdminService::instance()->getUserId();
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
        if ($state && isset($data['uid'])) {
            UserBalanceService::instance()->amount($data['uid']);
            UserUpgradeService::instance()->upgrade($data['uid']);
        }
    }

    /**
     * 删除充值记录
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $db = $this->app->db->name($this->table);
        $this->_delete($db->whereLike('code', "B%"));
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
            foreach ($this->app->db->name($this->table)->where($map)->cursor() as $vo) {
                UserBalanceService::instance()->amount($vo['uid']);
                UserUpgradeService::instance()->upgrade($vo['uid']);
            }
        }
    }
}