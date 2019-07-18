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
use library\tools\Express;
use think\Db;

/**
 * 订单记录管理
 * Class Order
 * @package app\store\controller
 */
class Order extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'StoreOrder';

    /**
     * 订单记录管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '订单记录管理';
        $this->_query($this->table)->order('id desc')->page();
    }

    /**
     * 订单列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _index_page_filter(array &$data)
    {
        $goodsList = Db::name('StoreOrderList')->whereIn('order_no', array_unique(array_column($data, 'order_no')))->select();
        $mids = array_unique(array_merge(array_column($data, 'mid'), array_column($data, 'from_mid')));
        $memberList = Db::name('StoreMember')->whereIn('id', $mids)->select();
        foreach ($data as &$vo) {
            list($vo['member'], $vo['from_member'], $vo['list']) = [[], [], []];
            foreach ($goodsList as $goods) if ($goods['order_no'] === $vo['order_no']) {
                $vo['list'][] = $goods;
            }
            foreach ($memberList as $member) if ($member['id'] === $vo['mid']) {
                $vo['member'] = $member;
            }
        }
    }

    /**
     * 修改快递管理
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function express()
    {
        if ($this->request->isGet()) {
            $where = ['is_deleted' => '0', 'status' => '1'];
            $this->expressList = Db::name('StoreExpress')->where($where)->order('sort desc,id desc')->select();
        }
        $this->_form($this->table);
    }

    /**
     * 快递追踪查询
     * @auth true
     */
    public function expressQuery()
    {
        list($code, $no) = [input('code', ''), input('no', '')];
        if (empty($no)) $this->error('快递编号不能为空！');
        if (empty($code)) $this->error('快递公司编码不能为空！');
        $this->result = Express::query($code, $no);
        $this->fetch();
    }

    /**
     * 快递表单处理
     * @param array $vo
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _express_form_filter(&$vo)
    {
        if ($this->request->isPost()) {
            $order = Db::name($this->table)->where(['id' => $vo['id']])->find();
            if (empty($order)) $this->error('订单查询异常，请稍候再试！');
            $express = Db::name('StoreExpress')->where(['express_code' => $vo['express_company_code']])->find();
            if (empty($express)) $this->error('发货快递公司异常，请重新选择快递公司！');
            $vo['express_company_title'] = $express['express_title'];
            $vo['express_send_at'] = empty($order['express_send_at']) ? date('Y-m-d H:i:s') : $order['express_send_at'];
            $vo['express_state'] = '1';
            $vo['status'] = '4';
        }
    }

}
