<?php

namespace app\data\controller\api;

use app\data\model\BaseUserMessage;
use think\admin\Controller;
use think\admin\model\SystemBase;

/**
 * 基础数据接口
 * Class Data
 * @package app\data\controller\api
 */
class Data extends Controller
{

    /**
     * 获取指定数据对象
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getData()
    {
        $data = $this->_vali(['name.require' => '数据名称不能为空！']);
        if (isset(SystemBase::items('页面内容')[$data['name']])) {
            $this->success('获取数据对象', sysdata($data['name']));
        } else {
            $this->success('获取数据失败', []);
        }
    }

    /**
     * 获取图片内容数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSlider()
    {
        $keys = input('keys', 'slider');
        if (isset(SystemBase::items('图片内容')[$keys])) {
            $this->success('获取图片内容', sysdata($keys));
        } else {
            $this->success('获取数据失败', []);
        }
    }

    /**
     * 获取系统通知数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNotify()
    {
        $model = BaseUserMessage::mQuery()->where(['status' => 1, 'deleted' => 0]);
        $result = $model->equal('id')->order('sort desc,id desc')->page(true, false, false, 20);
        if (($id = input('id')) > 0) BaseUserMessage::mk()->where(['id' => $id])->inc('num_read')->update([]);
        $this->success('获取系统通知', $result);
    }
}