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

namespace app\store\controller\api\member;

use app\store\controller\api\Member;
use think\Db;

/**
 * 会员收货地址管理
 * Class Address
 * @package app\store\controller\api\member
 */
class Address extends Member
{

    /**
     * 获取会员收货地址信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function gets()
    {
        $this->success('获取会员收货地址成功！', [
            'list' => Db::name('StoreMemberAddress')
                ->where(['mid' => $this->member['id']])
                ->order('is_default desc,id desc')
                ->select(),
        ]);
    }

    /**
     * 更新收货地址
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function set()
    {
        $data = $this->_input([
            'mid'        => $this->request->post('mid'),
            'openid'     => $this->request->post('openid'),
            'name'       => $this->request->post('name'),
            'phone'      => $this->request->post('phone'),
            'province'   => $this->request->post('province'),
            'city'       => $this->request->post('city'),
            'area'       => $this->request->post('area'),
            'address'    => $this->request->post('address'),
            'is_default' => $this->request->post('is_default'),
        ], [
            'name'     => 'require',
            'phone'    => 'require|mobile',
            'province' => 'require',
            'city'     => 'require',
            'area'     => 'require',
            'address'  => 'require',
        ], [
            'name.require'     => '收货人姓名不能为空！',
            'phone.require'    => '收货人联系手机不能为空！',
            'phone.mobile'     => '收货人联系手机格式不对！',
            'province.require' => '收货地址省份不能为空！',
            'city.require'     => '收货地址城市不能为空！',
            'area.require'     => '收货地址区域不能为空！',
            'address.require'  => '收货详情地址不能为空！',
        ]);
        if (!empty($data['is_default'])) {
            Db::name('StoreMemberAddress')->where(['mid' => $this->member['id']])->setField('is_default', '0');
        }
        if ($this->request->has('id', 'post', true)) {
            $data['id'] = $this->request->post('id');
        }
        if (data_save('StoreMemberAddress', $data, 'id')) {
            $this->success('收货地址更新成功！');
        }
        $this->error('收货地址更新失败，请稍候再试！');
    }

    /**
     * 删除收货地址
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        $id = $this->request->post('address_id');
        if (empty($id)) $this->error('待处理的收货地址ID不能为空！');
        $where = ['id' => $id, 'mid' => $this->member['id']];
        if (Db::name('StoreMemberAddress')->where($where)->delete() !== false) {
            $this->success('删除收货地址成功！');
        }
        $this->error('删除收货地址失败，请稍候再试！');
    }

    /**
     * 设置默认收货地址
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function setDefault()
    {
        $id = $this->request->post('address_id');
        if (empty($id)) $this->error('待处理的收货地址ID不存在！');
        $where = ['id' => $id, 'mid' => $this->member['id']];
        $address = Db::name('StoreMemberAddress')->where($where)->find();
        if (empty($address)) $this->error('待处理的收货地址获取失败，请稍候再试！');
        Db::name('StoreMemberAddress')->where(['mid' => $this->member['id']])->update(['is_default' => '0']);
        if (Db::name('StoreMemberAddress')->where($where)->update(['is_default' => '1']) !== false) {
            $this->success('设置默认收货地址成功！');
        }
        $this->error('设置默认收货地址失败！');
    }

}
