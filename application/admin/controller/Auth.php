<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Data;

/**
 * 系统权限管理控制器
 * Class Auth
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Auth extends BasicAdmin {

    /**
     * 默认数据模型
     * @var string
     */
    protected $table = 'SystemAuth';

    /**
     * 权限列表
     */
    public function index() {
        $this->title = '系统权限管理';
        parent::_list($this->table);
    }

    /**
     * 权限授权
     */
    public function apply() {
        return $this->_form($this->table, 'apply');
    }

    /**
     * 权限添加
     */
    public function add() {
        return $this->_form($this->table, 'form');
    }

    /**
     * 权限编辑
     */
    public function edit() {
        return $this->add();
    }

    /**
     * 权限禁用
     */
    public function forbid() {
        if (Data::update($this->table)) {
            $this->success("权限禁用成功！", '');
        } else {
            $this->error("权限禁用失败，请稍候再试！");
        }
    }

    /**
     * 权限恢复
     */
    public function resume() {
        if (Data::update($this->table)) {
            $this->success("权限启用成功！", '');
        } else {
            $this->error("权限启用失败，请稍候再试！");
        }
    }

    /**
     * 权限删除
     */
    public function del() {
        if (Data::update($this->table)) {
            $this->success("权限删除成功！", '');
        } else {
            $this->error("权限删除失败，请稍候再试！");
        }
    }

}
