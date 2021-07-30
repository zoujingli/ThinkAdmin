<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\SystemBase;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 数据字典管理
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemBase';

    /**
     * 数据字典管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->_query(SystemBase::class)->layTable(function () {
            $this->applyTypes();
            $this->title = '数据字典管理';
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0])->equal('type')->like('code,name,status')->dateBetween('create_at');
        });
    }

    /**
     * 添加数据字典
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑数据字典
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isGet()) {
            $this->applyTypes(true);
        } else {
            $map = [['type', '=', $data['type']], ['code', '=', $data['code']], ['deleted', '=', 0]];
            if (isset($data['id'])) $map[] = ['id', '<>', $data['id']];
            if ($this->app->db->name($this->table)->where($map)->count() > 0) {
                $this->error("同类型的数据编码已经存在！");
            }
        }
    }

    /**
     * 修改数据状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table);
    }

    /**
     * 删除数据记录
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

    /**
     * 初始化数据类型
     * @param false $add
     */
    private function applyTypes(bool $add = false)
    {
        $query = $this->app->db->name($this->table)->where(['deleted' => 0]);
        $this->types = $query->distinct(true)->order('id asc')->column('type');
        if (empty($this->types)) $this->types = ['身份权限'];
        $this->type = input('get.type') ?: ($this->types[0] ?? '-');
        if ($add) $this->types[] = '--- 新增类型 ---';
    }
}