<?php

namespace app\data\controller\api;

use think\admin\Controller;

/**
 * 基础数据接口
 * Class Data
 * @package app\data\controller\api
 */
class Data extends Controller
{
    /**
     * 获取轮播图片数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSlider()
    {
        $data = sysdata(input('keys', 'slider'));
        $this->success('获取轮播图片数据', $data);
    }

    /**
     * 获取系统通知数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNotify()
    {
        $query = $this->_query('DataBaseMessage')->where(['status' => 1, 'deleted' => 0]);
        $result = $query->equal('id')->order('sort desc,id desc')->page(true, false, false, 20);
        if (($id = input('id')) > 0) {
            $this->app->db->name('DataBaseMessage')->where(['id' => $id])->inc('num_read')->update();
        }
        $this->success('获取系统通知数据', $result);
    }
}