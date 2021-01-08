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
     * 微信小程序配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function wxapp()
    {
        $this->title = '微信小程序配置';
        $this->__sysconf('wxapp');
    }

    /**
     * 关于我们描述
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function about()
    {
        $this->skey = 'about';
        $this->title = '关于我们描述';
        $this->__sysdata('content');
    }

    /**
     * 应用轮播图片
     * @menu true
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function slider()
    {
        $this->skey = 'slider';
        $this->title = '应用轮播图片';
        $this->__sysdata($this->skey);
    }

    /**
     * 用户服务协议
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function agreement()
    {
        $this->skey = 'agreement';
        $this->title = '用户服务协议';
        $this->__sysdata('content');
    }

    /**
     * 显示并保存数据
     * @param string $template 模板文件
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function __sysdata(string $template)
    {
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->fetch($template);
        } elseif ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = $this->request->post();
            }
            if (sysdata($this->skey, $data) !== false) {
                $this->success('内容保存成功！', '');
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }
    }

    /**
     * 显示并保存配置
     * @param string $template 模板文件名称
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function __sysconf(string $template)
    {
        if ($this->request->isGet()) {
            $this->fetch($template);
        } elseif ($this->request->isPost()) {
            $data = $this->request->post();
            foreach ($data as $k => $v) sysconf($k, $v);
            $this->success('配置保存成功！');
        }
    }
}