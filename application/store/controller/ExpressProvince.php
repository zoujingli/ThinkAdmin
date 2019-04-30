<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\store\controller;

use library\Controller;

/**
 * 配送省份管理
 * Class Area
 * @package app\store\controller
 */
class ExpressProvince extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'StoreExpressProvince';

    /**
     * 配送省份管理
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '配送省份管理';
        $this->_query($this->table)->like('title')->equal('status')->dateBetween('create_at')->order('sort asc,id desc')->page();
    }


    /**
     * 添加配送省份
     */
    public function add()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑配送省份
     */
    public function edit()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 启用配送省份
     */
    public function resume()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 禁用配送省份
     */
    public function forbid()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 删除配送省份
     */
    public function del()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

}