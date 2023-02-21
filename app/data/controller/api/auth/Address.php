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

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\model\DataUserAddress;
use think\admin\extend\CodeExtend;

/**
 * 用户收货地址管理
 * Class Address
 * @package app\data\controller\api\auth
 */
class Address extends Auth
{
    /**
     * 添加收货地址
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function set()
    {
        $data = $this->_vali([
            'uuid.value'       => $this->uuid,
            'type.default'     => 0,
            'code.default'     => '',
            'idcode.default'   => '', // 身份证号码
            'idimg1.default'   => '', // 身份证正面
            'idimg2.default'   => '', // 身份证反面
            'type.in:0,1'      => '地址状态不在范围！',
            'name.require'     => '收货姓名不能为空！',
            'phone.mobile'     => '收货手机格式错误！',
            'phone.require'    => '收货手机不能为空！',
            'province.require' => '地址省份不能为空！',
            'city.require'     => '地址城市不能为空！',
            'area.require'     => '地址区域不能为空！',
            'address.require'  => '详情地址不能为空！',
            'deleted.value'    => 0,
        ]);
        if (empty($data['code'])) {
            unset($data['code']);
            $count = DataUserAddress::mk()->where($data)->count();
            if ($count > 0) $this->error('抱歉，该地址已经存在！');
            $data['code'] = CodeExtend::uniqidDate(20, 'A');
            if (DataUserAddress::mk()->insert($data) === false) {
                $this->error('添加地址失败！');
            }
        } else {
            $map = ['uuid' => $this->uuid, 'code' => $data['code']];
            $addr = DataUserAddress::mk()->where($map)->find();
            if (empty($addr)) $this->error('修改地址不存在！');
            DataUserAddress::mk()->where($map)->update($data);
        }
        // 去除其它默认选项
        if (isset($data['type']) && $data['type'] > 0) {
            $map = [['uuid', '=', $this->uuid], ['code', '<>', $data['code']]];
            DataUserAddress::mk()->where($map)->update(['type' => 0]);
        }
        $this->success('地址保存成功！', $this->getAddress($data['code']));
    }

    /**
     * 获取收货地址
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $query = DataUserAddress::mQuery()->withoutField('deleted');
        $query->equal('code')->where(['uuid' => $this->uuid, 'deleted' => 0]);
        $result = $query->order('type desc,id desc')->page(false, false, false, 15);
        $this->success('获取地址数据！', $result);
    }

    /**
     * 修改地址状态
     * @return void
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.in:0,1'  => '地址状态不在范围！',
            'type.require' => '地址状态不能为空！',
            'code.require' => '地址编号不能为空！',
        ]);
        // 检查地址是否存在
        $map = ['uuid' => $data['uuid'], 'code' => $data['code']];
        if (DataUserAddress::mk()->where($map)->count() < 1) {
            $this->error('修改的地址不存在！');
        }
        // 更新默认地址状态
        $data['type'] = intval($data['type']);
        DataUserAddress::mk()->where($map)->update(['type' => $data['type']]);
        // 去除其它默认选项
        if ($data['type'] > 0) {
            $map = [['uuid', '=', $this->uuid], ['code', '<>', $data['code']]];
            DataUserAddress::mk()->where($map)->update(['type' => 0]);
        }
        $this->success('默认设置成功！', $this->getAddress($data['code']));
    }

    /**
     * 删除收货地址
     */
    public function remove()
    {
        $map = $this->_vali([
            'uuid.value'   => $this->uuid,
            'code.require' => '地址不能为空！',
        ]);
        $item = DataUserAddress::mk()->where($map)->findOrEmpty();
        if ($item->isEmpty()) $this->error('需要删除的地址不存在！');
        if ($item->save(['deleted' => 1]) !== false) {
            $this->success('删除地址成功！');
        } else {
            $this->error('删除地址失败！');
        }
    }

    /**
     * 获取指定的地址
     * @param string $code
     * @return null|array
     */
    private function getAddress(string $code): array
    {
        $map = ['code' => $code, 'uuid' => $this->uuid, 'deleted' => 0];
        return DataUserAddress::mk()->withoutField('deleted')->where($map)->findOrEmpty()->toArray();
    }
}