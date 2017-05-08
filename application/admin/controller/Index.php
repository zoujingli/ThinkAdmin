<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use service\NodeService;
use service\ToolsService;
use think\Db;
use think\View;

/**
 * 后台入口
 * Class Index
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 10:41
 */
class Index extends BasicAdmin {

    /**
     * 后台框架布局
     * @return View
     */
    public function index() {
        NodeService::applyAuthNode();
        $list = Db::name('SystemMenu')->where('status', '1')->order('sort asc,id asc')->select();
        $menus = $this->_filterMenu(ToolsService::arr2tree($list));
        $this->assign('title', '系统管理');
        $this->assign('menus', $menus);
        return view();
    }

    /**
     * 后台主菜单权限过滤
     * @param array $menus
     * @return array
     */
    private function _filterMenu($menus) {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) {
                $menu['sub'] = $this->_filterMenu($menu['sub']);
            }
            if (!empty($menu['sub'])) {
                $menu['url'] = '#';
            } elseif (stripos($menu['url'], 'http') === 0) {
                continue;
            } elseif ($menu['url'] !== '#' && auth(join('/', array_slice(explode('/', $menu['url']), 0, 3)))) {
                $menu['url'] = url($menu['url']);
            } else {
                unset($menus[$key]);
            }
        }
        return $menus;
    }

    /**
     * 主机信息显示
     * @return View
     */
    public function main() {
        $_version = Db::query('select version() as ver');
        $version = array_pop($_version);
        $this->assign('mysql_ver', $version['ver']);
        if (session('user.username') === 'admin' && session('user.password') === '21232f297a57a5a743894a0e4a801fc3') {
            $url = url('admin/index/pass') . '?id=' . session('user.id');
            $alert = [
                'type'    => 'danger',
                'title'   => '安全提示',
                'content' => "超级管理员默认密码未修改，建议马上<a href='javascript:void(0)' data-modal='{$url}'>修改</a>！"
            ];
            $this->assign('alert', $alert);
            $this->assign('title', '后台首页');
        }
        return view();
    }

    /**
     * 修改密码
     */
    public function pass() {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止操作！');
        }
        if (intval($this->request->request('id')) !== intval(session('user.id'))) {
            $this->error('访问异常！');
        }
        if ($this->request->isGet()) {
            $this->assign('verify', true);
            return $this->_form('SystemUser', 'user/pass');
        } else {
            $data = $this->request->post();
            if ($data['password'] !== $data['repassword']) {
                $this->error('两次输入的密码不一致，请重新输入！');
            }
            $user = Db::name('SystemUser')->where('id', session('user.id'))->find();
            if (md5($data['oldpassword']) !== $user['password']) {
                $this->error('旧密码验证失败，请重新输入！');
            }
            if (DataService::save('SystemUser', ['id' => session('user.id'), 'password' => md5($data['password'])])) {
                $this->success('密码修改成功，下次请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }

    /**
     * 修改资料
     */
    public function info() {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止操作！');
        }
        if (intval($this->request->request('id')) === intval(session('user.id'))) {
            return $this->_form('SystemUser', 'user/form');
        }
        $this->error('访问异常！');
    }

}
