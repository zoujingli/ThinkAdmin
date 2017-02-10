<?php

namespace controller;

use think\Controller;

class BasicAdmin extends Controller {

    public function _initialize() {
        parent::_initialize();
        if (!$this->isLogin()) {
            $this->redirect('@admin/login');
        }
    }

    public function isLogin() {
        return false;
    }
}