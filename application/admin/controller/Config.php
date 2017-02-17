<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Data;

/**
 * 后台参数配置控制器
 * Class Config
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:05
 */
class Config extends BasicAdmin {

    protected $table = 'SystemConfig';

    public function index() {
        if (!$this->request->isPost()) {
            $this->title = '系统参数配置';
            parent::_list($this->table);
        } else {
            $data = $this->request->post();
            foreach ($data as $key => $vo) {
                $_data = ['name' => $key, 'value' => $vo];
                Data::save($this->table, $_data, 'name');
            }
            $this->success('数据修改成功！', '');
        }
    }

}
