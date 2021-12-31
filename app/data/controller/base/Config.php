<?php

namespace app\data\controller\base;

use think\admin\Controller;

/**
 * 应用参数配置
 * Class Config
 * @package app\data\controller\base
 */
class Config extends Controller
{
    /**
     * 页面类型
     * @var array
     */
    protected $pageTypes = [
        '关于我们' => '关于我们',
        '用户协议' => '用户协议',
    ];

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
     * 邀请二维码设置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cropper()
    {
        $this->title = '邀请二维码设置';
        $this->skey = 'cropper';
        $this->__sysdata('cropper');
    }

    /**
     * 内容页面管理
     * @auth true
     * @menu true
     */
    public function pageHome()
    {
        $this->title = '内容页面管理';
        $this->fetch('page_home');
    }

    /**
     * 内容页面编辑
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pageEdit()
    {
        $this->skey = input('type') ?: $this->pageTypes[0];
        $this->title = '编辑' . $this->pageTypes[$this->skey] ?? '';
        $this->__sysdata('page_form', 'javascript:history.back()');
    }

    /**
     * 首页推荐位管理
     * @menu true
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function iconHome()
    {
        $this->skey = 'IconHome';
        $this->title = '首页推荐位管理';
        $this->__sysdata('slider');
    }

    /**
     * 首页轮播图片
     * @menu true
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sliderHome()
    {
        $this->skey = 'SliderHome';
        $this->title = '首页轮播图片';
        $this->__sysdata('slider');
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
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            foreach ($data as $k => $v) sysconf($k, $v);
            $this->success('配置保存成功！');
        }
    }

    /**
     * 显示并保存数据
     * @param string $template 模板文件
     * @param string $history 跳转处理
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function __sysdata(string $template, string $history = '')
    {
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->fetch($template);
        }
        if ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = $this->request->post();
            }
            if (sysdata($this->skey, $data) !== false) {
                $this->success('内容保存成功！', $history);
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }
    }
}