<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 应用参数配置
 * Class Config
 * @package app\data\controller
 */
class Config extends Controller
{
    /**
     * 首页轮播图片
     * @menu true
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function slider()
    {
        if ($this->request->isGet()) {
            $this->title = '轮播图管理';
            $this->data = sysdata('slider');
            $this->fetch();
        } else {
            if (sysdata('slider', json_decode(input('data'), true))) {
                $this->success('轮播图保存成功！', '');
            } else {
                $this->error('轮播图保存失败，请稍候再试!');
            }
        }
    }
}