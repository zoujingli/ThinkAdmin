<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemBase;

/**
 * 数据字典管理
 * @class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
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
        SystemBase::mQuery()->layTable(function () {
            $this->title = '数据字典管理';
            $this->types = SystemBase::types();
            $this->type = $this->get['type'] ?? ($this->types[0] ?? '-');
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0])->equal('type');
            $query->like('code,name,status')->dateBetween('create_at');
        });
    }

    /**
     * 添加数据字典
     * @auth true
     */
    public function add()
    {
        SystemBase::mForm('form');
    }

    /**
     * 编辑数据字典
     * @auth true
     */
    public function edit()
    {
        SystemBase::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DbException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isGet()) {
            $this->types = SystemBase::types();
            $this->types[] = '--- 新增类型 ---';
            $this->type = $this->get['type'] ?? ($this->types[0] ?? '-');
        } else {
            $map = [];
            $map[] = ['deleted', '=', 0];
            $map[] = ['code', '=', $data['code']];
            $map[] = ['type', '=', $data['type']];
            $map[] = ['id', '<>', $data['id'] ?? 0];
            if (SystemBase::mk()->where($map)->count() > 0) {
                $this->error("同类型的数据编码已经存在！");
            }
        }
    }

    /**
     * 修改数据状态
     * @auth true
     */
    public function state()
    {
        SystemBase::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除数据记录
     * @auth true
     */
    public function remove()
    {
        SystemBase::mDelete();
    }
}