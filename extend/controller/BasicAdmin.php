<?php

namespace controller;

use think\Controller;

/**
 * 后台权限基础控制器
 *
 * @package controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/13 14:24
 */
class BasicAdmin extends Controller {

    /**
     * 后台权限控制初始化方法
     */
    public function _initialize() {
        if (!$this->isLogin()) {
            $this->redirect('@admin/login');
        }
    }

    /**
     * 判断用户是否登录
     * @return bool
     */
    public function isLogin() {
        $user = session('user');
        if (empty($user) || empty($user['id'])) {
            return false;
        }
        return true;
    }
}