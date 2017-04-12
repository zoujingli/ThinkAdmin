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

namespace controller;

use service\DataService;
use think\Controller;
use think\db\Query;
use think\Db;

/**
 * 后台权限基础控制器
 *
 * @package controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/13 14:24
 */
class BasicAdmin extends Controller {

    /**
     * 页面标题
     * @var string
     */
    protected $title;

    /**
     * 默认操作数据表
     * @var string
     */
    protected $table;

    /**
     * 默认检查用户登录状态
     * @var bool
     */
    protected $checkLogin = true;

    /**
     * 默认检查节点访问权限
     * @var bool
     */
    protected $checkAuth = true;

    /**
     * 后台权限控制初始化方法
     */
    public function _initialize() {
        # 用户登录状态检查
        if (($this->checkLogin || $this->checkAuth) && !$this->_isLogin()) {
            $this->redirect('@admin/login');
        }
        # 节点访问权限检查
        if ($this->checkLogin && $this->checkAuth) {
            if (!auth(join('/', [$this->request->module(), $this->request->controller(), $this->request->action()]))) {
                $this->error('抱歉，您没有访问该模块的权限！');
            }
        }
        # 初始化赋值常用变量
        if ($this->request->isGet()) {
            $class_uri = strtolower($this->request->module() . '/' . $this->request->controller());
            $this->assign('classuri', $class_uri);
        }
    }

    /**
     * 判断用户是否登录
     * @return bool
     */
    protected function _isLogin() {
        $user = session('user');
        if (empty($user) || empty($user['id'])) {
            return false;
        }
        return true;
    }

    /**
     * 列表集成处理方法
     * @param Query $db 数据库查询对象
     * @param bool $is_page 是启用分页
     * @param bool $is_display 是否直接输出显示
     * @param bool $total 总记录数
     * @return array|string
     */
    protected function _list($db = null, $is_page = true, $is_display = true, $total = false) {
        if (is_null($db)) {
            $db = Db::name($this->table);
        } elseif (is_string($db)) {
            $db = Db::name($db);
        }
        # 列表排序默认处理
        if ($this->request->isPost() && $this->request->post('action') === 'resort') {
            $data = $this->request->post();
            unset($data['action']);
            foreach ($data as $key => &$value) {
                if (false === $db->where('id', intval(ltrim($key, '_')))->update(['sort' => $value])) {
                    $this->error('列表排序失败，请稍候再试！');
                }
            }
            $this->success('列表排序成功，正在刷新列表！', '');
        }
        # 列表显示
        $result = array();
        # 默认排序
        $options = $db->getOptions();
        if (empty($options['order'])) {
            $fields = $db->getTableFields(['table' => $db->getTable()]);
            in_array('sort', $fields) && $db->order('sort asc');
        }
        if ($is_page) {
            $row_page = $this->request->get('rows', cookie('rows'), 'intval');
            cookie('rows', $row_page >= 10 ? $row_page : 20);
            $page = $db->paginate($row_page, $total, ['query' => $this->request->get()]);
            $result['list'] = $page->all();
            $result['page'] = preg_replace(['|href="(.*?)"|', '|pagination|'], ['data-open="$1" href="javascript:void(0);"', 'pagination pull-right'], $page->render());
        } else {
            $result['list'] = $db->select();
        }
        if ($this->_callback('_data_filter', $result['list']) === false) {
            return $result;
        }
        !empty($this->title) && $this->assign('title', $this->title);
        $is_display && exit($this->fetch('', $result));
        return $result;
    }

    /**
     * 表单默认操作
     * @param Query $db 数据库查询对象
     * @param string $tpl 显示模板名字
     * @param string $pk 更新主键规则
     * @param array $where 查询规则
     * @param array $data 扩展数据
     * @return array|string
     */
    protected function _form($db = null, $tpl = null, $pk = null, $where = [], $data = []) {
        if (is_null($db)) {
            $db = Db::name($this->table);
        } elseif (is_string($db)) {
            $db = Db::name($db);
        }
        if (is_null($pk)) {
            $pk = $db->getPk();
        }
        $pk_value = input($pk, isset($where[$pk]) ? $where[$pk] : (isset($data[$pk]) ? $data[$pk] : ''));
        $vo = $data;
        if ($this->request->isPost()) { // Save Options
            $vo = array_merge(input('post.'), $data);
            $this->_callback('_form_filter', $vo);
            $result = DataService::save($db, $vo, $pk, $where);
            if (false !== $this->_callback('_form_result', $result)) {
                $result !== false ? $this->success('恭喜，保存成功哦！', '') : $this->error('保存失败，请稍候再试！');
            }
            return $result;
        }
        if ($pk_value !== '') { // Edit Options
            !empty($pk_value) && $db->where($pk, $pk_value);
            !empty($where) && $db->where($where);
            $vo = array_merge($data, (array)$db->find());
        }
        $this->_callback('_form_filter', $vo);
        $this->assign('vo', $vo);
        empty($this->title) or $this->assign('title', $this->title);
        return is_null($tpl) ? $vo : $this->fetch($tpl);
    }

    /**
     * 当前对象回调成员方法
     * @param string $method
     * @param array $data
     * @return bool
     */
    protected function _callback($method, &$data) {
        foreach ([$method, "_" . $this->request->action() . "{$method}"] as $method) {
            if (method_exists($this, $method) && false === $this->$method($data)) {
                return false;
            }
        }
        return true;
    }

}
