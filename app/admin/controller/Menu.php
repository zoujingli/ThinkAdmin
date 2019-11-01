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

use app\admin\service\MenuService;
use think\admin\Controller;
use think\admin\extend\DataExtend;

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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
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
                $vo['url'] = url($vo['url']) . (empty($vo['params']) ? '' : "?{$vo['params']}");
            }
            $vo['ids'] = join(',', DataExtend::getArrSubIds($data, $vo['id']));
        }
        $data = DataExtend::arr2table($data);
    }

    /**
     * 添加系统菜单
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统菜单
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(&$vo)
    {
        if ($this->request->isGet()) {
            $menus = $this->app->db->name($this->table)->where(['status' => '1'])->order('sort desc,id asc')->select()->toArray();
            $menus[] = ['title' => '顶级菜单', 'id' => '0', 'pid' => '-1'];
            foreach ($this->menus = DataExtend::arr2table($menus) as $key => &$menu) {
                if (substr_count($menu['path'], '-') > 3) unset($this->menus[$key]); # 移除三级以下的菜单
                elseif (isset($vo['pid']) && $vo['pid'] !== '' && $cur = "-{$vo['pid']}-{$vo['id']}") {
                    if (stripos("{$menu['path']}-", "{$cur}-") !== false || $menu['path'] === $cur) unset($this->menus[$key]); # 移除与自己相关联的菜单
                }
            }
            // 选择自己的上级菜单
            if (empty($vo['pid']) && $this->request->get('pid', '0')) {
                $vo['pid'] = $this->request->get('pid', '0');
            }
            // 读取系统功能节点
            $this->nodes = MenuService::getList();
        }
    }

    /**
     * 修改系统菜单状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_applyFormToken();
        $this->_save($this->table, ['status' => intval(input('status'))]);
    }

    /**
     * 删除系统菜单
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }
}