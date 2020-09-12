<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use think\admin\extend\CodeExtend;

/**
 * 会员收货地址管理
 * Class Address
 * @package app\data\controller\api\auth
 */
class Address extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataMemberAddress';

    /**
     * 添加收货地址
     * @throws \think\db\exception\DbException
     */
    public function set()
    {
        $data = $this->_vali([
            'mid.value'        => $this->mid,
            'code.default'     => '',
            'type.default'     => 0,
            'type.in:0,1'      => '地址状态不在范围！',
            'name.require'     => '收货人姓名不能为空！',
            'phone.mobile'     => '收货人手机格式错误！',
            'phone.require'    => '收货人手机不能为空！',
            'province.require' => '地址省份不能为空！',
            'city.require'     => '地址城市不能为空！',
            'area.require'     => '地址区域不能为空！',
            'address.require'  => '详情地址不能为空！',
            'deleted.value'    => 0,
        ]);
        if (empty($data['code'])) {
            unset($data['code']);
            $count = $this->app->db->name($this->table)->where($data)->count();
            if ($count > 0) $this->error('抱歉，该地址已经存在！');
            $data['code'] = CodeExtend::uniqidDate(12, 'A');
            if ($this->app->db->name($this->table)->insert($data) === false) {
                $this->error('添加收货地址失败！');
            }
        } else {
            $map = ['mid' => $this->mid, 'code' => $data['code']];
            $address = $this->app->db->name($this->table)->where($map)->find();
            if (empty($address)) $this->error('修改收货地址不存在！');
            $this->app->db->name($this->table)->where($map)->update($data);
        }
        // 去除其它默认选项
        if (isset($data['type']) && $data['type'] > 0) {
            $map = [['mid', '=', $this->mid], ['code', '<>', $data['code']]];
            $this->app->db->name($this->table)->where($map)->update(['type' => 0]);
        }
        $this->success('添加收货地址成功！', $this->_getAddress($data['code']));
    }

    /**
     * 获取收货地址
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $query = $this->_query($this->table)->withoutField('deleted');
        $query->equal('code')->where(['mid' => $this->mid, 'deleted' => 0]);
        $result = $query->order('type desc,id desc')->page(false, false, false, 15);
        $this->success('获取收货地址数据！', $result);
    }

    /**
     * 修改收货地址状态
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $data = $this->_vali([
            'mid.value'    => $this->mid,
            'type.in:0,1'  => '地址状态不在范围！',
            'type.require' => '地址状态不能为空！',
            'code.require' => '地址编号不能为空！',
        ]);
        // 检查地址是否存在
        $map = ['mid' => $data['mid'], 'code' => $data['code']];
        if ($this->app->db->name($this->table)->where($map)->count() < 1) {
            $this->error('修改的地址不存在！');
        }
        // 更新默认地址状态
        $data['type'] = intval($data['type']);
        $this->app->db->name($this->table)->where($map)->update(['type' => $data['type']]);
        // 去除其它默认选项
        if ($data['type'] > 0) {
            $map = [['mid', '=', $this->mid], ['code', '<>', $data['code']]];
            $this->app->db->name($this->table)->where($map)->update(['type' => 0]);
        }
        $this->success('默认设置成功！', $this->_getAddress($data['code']));
    }

    /**
     * 删除收货地址
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $map = $this->_vali([
            'mid.value'    => $this->mid,
            'code.require' => '地址编号不能为空！',
        ]);
        $address = $this->app->db->name($this->table)->where($map)->find();
        if (empty($address)) $this->error('需要删除的地址不存在！');
        if ($this->app->db->name($this->table)->where($map)->update(['deleted' => 1]) !== false) {
            $this->success('删除地址成功！');
        } else {
            $this->error('删除地址失败！');
        }
    }

    /**
     * 获取指定的收货地址
     * @param string $code
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _getAddress($code)
    {
        $map = ['code' => $code, 'mid' => $this->mid, 'deleted' => 0];
        return $this->app->db->name($this->table)->withoutField('deleted')->where($map)->find();
    }

}