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

namespace app\company\controller;

use library\Controller;

/**
 * 仓库权限管理
 * Class Auth
 * @package app\company\controller
 */
class Auth extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'CompanyUserAuth';

    /**
     * 仓库权限管理
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
        $this->title = '仓库权限管理';
        $query = $this->_query($this->table)->like('title,path')->equal('status');
        $query->dateBetween('create_at')->where(['is_deleted' => '0'])->page();
    }

    /**
     * 添加SVN权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        $this->title = '添加SVN权限';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑SVN权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 修改SVN权限状态
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function state()
    {
        $this->_save($this->table, ['status' => input('status')]);
    }

    /**
     * 删除SVN权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
