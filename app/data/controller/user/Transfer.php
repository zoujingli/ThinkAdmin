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

use app\data\model\DataUser;
use app\data\model\DataUserTransfer;
use app\data\service\UserAdminService;
use app\data\service\UserTransferService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\service\AdminService;

/**
 * 用户提现管理
 * Class Transfer
 * @package app\data\controller\user
 */
class Transfer extends Controller
{
    /**
     * 提现转账方案
     * @var array
     */
    protected $types = [];

    protected function initialize()
    {
        $this->types = UserTransferService::instance()->types();
    }

    /**
     * 用户提现配置
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        $this->skey = 'TransferRule';
        $this->title = '用户提现配置';
        $this->_sysdata();
    }

    /**
     * 微信转账配置
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function payment()
    {
        $this->skey = 'TransferWxpay';
        $this->title = '微信提现配置';
        $this->_sysdata();
    }

    /**
     * 配置数据处理
     * @param string $tpl 模板文件
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _sysdata(string $tpl = '')
    {
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->fetch($tpl);
        } else {
            sysdata($this->skey, $this->request->post());
            $this->success('配置修改成功');
        }
    }

    /**
     * 用户提现管理
     * @menu true
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '用户提现管理';
        $this->transfer = UserTransferService::amount(0);
        // 创建查询对象
        $query = DataUserTransfer::mQuery()->order('id desc');
        // 用户条件搜索
        $db = DataUser::mQuery()->like('phone,username|nickname#nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uuid in {$db->field('id')->buildSql()}");
        // 数据列表处理
        $query->equal('type,status')->dateBetween('create_at')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        UserAdminService::buildByUid($data);
        foreach ($data as &$vo) {
            $vo['type_name'] = UserTransferService::instance()->types($vo['type']);
        }
    }

    /**
     * 提现审核操作
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function auditStatus()
    {
        $this->_audit();
    }

    /**
     * 提现打款操作
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function auditPayment()
    {
        $this->_audit();
    }

    /**
     * 提现审核打款
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _audit()
    {
        if ($this->request->isGet()) {
            DataUserTransfer::mForm('audit', 'code');
        } else {
            $data = $this->_vali([
                'code.require'        => '打款单号不能为空！',
                'status.require'      => '交易审核操作类型！',
                'status.in:0,1,2,3,4' => '交易审核操作类型！',
                'remark.default'      => '',
            ]);
            $map = ['code' => $data['code']];
            $find = DataUserTransfer::mk()->where($map)->find();
            if (empty($find)) $this->error('不允许操作审核！');
            // 提现状态(0已拒绝, 1待审核, 2已审核, 3打款中, 4已打款, 5已收款)
            if (in_array($data['status'], [0, 1, 2, 3])) {
                $data['last_at'] = date('Y-m-d H:i:s');
            } elseif ($data['status'] == 4) {
                $data['trade_no'] = CodeExtend::uniqidDate(20);
                $data['trade_time'] = date('Y-m-d H:i:s');
                $data['change_time'] = date('Y-m-d H:i:s');
                $data['change_desc'] = ($data['remark'] ?: '线下打款成功') . ' By ' . AdminService::getUserName();
            }
            if (DataUserTransfer::mk()->strict(false)->where($map)->update($data) !== false) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败！');
            }
        }
    }

    /**
     * 后台打款服务
     * @auth true
     */
    public function sync()
    {
        $this->_queue('提现到微信余额定时处理', 'xdata:UserTransfer', 0, [], 0, 50);
    }
}