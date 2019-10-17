<?php


namespace app\store\controller;


use library\Controller;

/**
 * 轮播图片管理
 * Class Slider
 * @package app\store\controller
 */
class Slider extends Controller
{
    /**
     * 轮播图片管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function home()
    {
        $this->size = '600 * 350';
        $this->keys = 'slider_home';
        $this->title = '轮播图片管理';
        $this->desc = "建议上传图片尺寸 {$this->size}";
        $this->_apply('index');
    }

    /**
     * 显示与管理
     * @param string $tpl 模板名称
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function _apply($tpl)
    {
        if ($this->request->isGet()) {
            $this->list = sysdata($this->keys);
            $this->fetch($tpl);
        } else {
            if (sysdata($this->keys, json_decode($this->request->post('data'), true))) {
                $this->success('数据保存成功！', '');
            } else {
                $this->error('数据保存失败，请稍候再试!');
            }
        }
    }

}
