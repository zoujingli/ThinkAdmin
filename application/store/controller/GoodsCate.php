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
 * 商品分类管理
 * Class GoodsCate
 * @package app\store\controller
 */
class GoodsCate extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'StoreGoodsCate';

    /**
     * 商品分类管理
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '商品分类管理';
        $where = ['is_deleted' => '0'];
        $this->_query($this->table)->like('title')->equal('status')->where($where)->order('sort asc,id desc')->page();
    }

    /**
     * 添加商品分类
     * @return mixed
     */
    public function add()
    {
        $this->title = '添加商品分类';
        return $this->_form($this->table, 'form');
    }

    /**
     * 编辑添加商品分类
     * @return mixed
     */
    public function edit()
    {
        $this->title = '编辑商品分类';
        return $this->_form($this->table, 'form');
    }

    /**
     * 禁用添加商品分类
     */
    public function forbid()
    {
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用商品分类
     */
    public function resume()
    {
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 删除商品分类
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}