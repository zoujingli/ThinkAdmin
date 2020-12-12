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
     * 获取支付通道数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getPayment()
    {
        $map = ['status' => 1, 'deleted' => 0];
        $query = $this->app->db->name('DataPayment')->where($map);
        $result = $query->order('sort desc,id desc')->field('id,name,type')->select();
        $this->success('获取支付通道数据', $result->toArray());
    }

}