<?php

namespace app\data\controller;

use think\admin\Controller;
use think\admin\storage\LocalStorage;

/**
 * 应用参数配置
 * Class Config
 * @package app\data\controller
 */
class Config extends Controller
{
    /**
     * 微信小程序配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function wxapp()
    {
        if ($this->request->isGet()) {
            $this->title = '微信小程序配置';
            $this->fetch();
        } else {
            $this->__save();
        }
    }

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
        $this->skey = 'slider';
        if ($this->request->isGet()) {
            $this->title = '轮播图片管理';
            $this->data = sysdata($this->skey);
            $this->fetch();
        } else {
            if (sysdata($this->skey, json_decode(input('data'), true))) {
                $this->success('轮播图保存成功！', '');
            } else {
                $this->error('轮播图保存失败，请稍候再试!');
            }
        }
    }

    /**
     * 保存配置参数
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function __save()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            foreach ($data as $k => $v) sysconf($k, $v);
            $this->success('配置保存成功！');
        }
    }
}