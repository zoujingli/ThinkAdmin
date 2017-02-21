<?php

namespace app\admin\controller;

use controller\BasicAdmin;

/**
 * 插件助手控制器
 * Class Plugs
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/21
 */
class Plugs extends BasicAdmin {

    /**
     * 默认检查用户登录状态
     * @var bool
     */
    protected $checkLogin = false;

    /**
     * 默认检查节点访问权限
     * @var bool
     */
    protected $checkAuth = false;

    /**
     * 文件上传
     */
    public function upfile() {
        $this->assign('field', $this->request->get('field', 'file'));
        $this->assign('types', '');
        $this->assign('mimes', '');
        $this->assign('uptype', '');
        return view();
    }
    
    public function upload(){
        
    }

    /**
     * 字体图标
     */
    public function icon() {
        return view();
    }

}
