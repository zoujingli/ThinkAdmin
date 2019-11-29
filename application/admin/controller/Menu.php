<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use library\Controller;
use library\service\MenuService;
use library\tools\Data;
use think\Db;

/**
 * 系统菜单管理
 * Class Menu
 * @package app\admin\controller
 */
class Menu extends Controller
{

    /**
     * 当前操作数据库
     * @var string
     */
    protected $table = 'SystemMenu';

    /**
     * 系统菜单管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '系统菜单管理';
        $this->_page($this->table, false);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(&$data)
    {
        foreach ($data as &$vo) {
            if ($vo['url'] !== '#') {
                $vo['url'] = trim(url($vo['url']) . (empty($vo['params']) ? '' : "?{$vo['params']}"), '/\\');
            }
            $vo['ids'] = join(',', Data::getArrSubIds($data, $vo['id']));
        }
        $data = Data::arr2table($data);
    }

    /**
     * 添加系统菜单
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统菜单
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _form_filter(&$vo)
    {
        if ($this->request->isGet()) {
            // 读取系统功能节点
            $this->nodes = MenuService::instance()->getList();
            // 选择自己的上级菜单
            if (empty($vo['pid']) && $this->request->get('pid', '0')) $vo['pid'] = $this->request->get('pid', '0');
            // 列出可选上级菜单
            $menus = Db::name($this->table)->where(['status' => '1'])->order('sort desc,id asc')->column('id,pid,url,title');
            $this->menus = Data::arr2table(array_merge($menus, [['id' => '0', 'pid' => '-1', 'url' => '#', 'title' => '顶部菜单']]));
            if (isset($vo['id'])) foreach ($this->menus as $key => $menu) if ($menu['id'] === $vo['id']) $vo = $menu;
            foreach ($this->menus as $key => &$menu) {
                if ($menu['spt'] >= 3 || $menu['url'] !== '#') unset($this->menus[$key]);
                if (isset($vo['spt']) && $vo['spt'] <= $menu['spt']) unset($this->menus[$key]);
            }
        }
    }

    /**
     * 启用系统菜单
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 禁用系统菜单
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 删除系统菜单
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

}
