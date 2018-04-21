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

namespace app\store\controller;

use controller\BasicAdmin;
use service\DataService;
use think\Db;

/**
 * 商城快递公司管理
 * Class Express
 * @package app\store\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Express extends BasicAdmin
{

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'StoreExpress';

    /**
     * 快递公司列表
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->title = '快递公司管理';
        list($get, $db) = [$this->request->get(), Db::name($this->table)];
        foreach (['express_title', 'express_code'] as $field) {
            (isset($get[$field]) && $get[$field] !== '') && $db->whereLike($field, "%{$get[$field]}%");
        }
        if (isset($get['date']) && $get['date'] !== '') {
            list($start, $end) = explode(' - ', $get['date']);
            $db->whereBetween('create_at', ["{$start} 00:00:00", "{$end} 23:59:59"]);
        }
        return parent::_list($db->where(['is_deleted' => '0'])->order('status desc,sort asc,id desc'));
    }

    /**
     * 添加快递公司
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $this->title = '添加快递公司';
        return $this->_form($this->table, 'form');
    }

    /**
     * 编辑快递公司
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        $this->title = '编辑快递公司';
        return $this->_form($this->table, 'form');
    }

    /**
     * 删除快递公司
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        if (DataService::update($this->table)) {
            $this->success("快递公司删除成功！", '');
        }
        $this->error("快递公司删除失败，请稍候再试！");
    }

    /**
     * 快递公司禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        if (DataService::update($this->table)) {
            $this->success("快递公司禁用成功！", '');
        }
        $this->error("快递公司禁用失败，请稍候再试！");
    }

    /**
     * 快递公司禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        if (DataService::update($this->table)) {
            $this->success("快递公司启用成功！", '');
        }
        $this->error("快递公司启用失败，请稍候再试！");
    }

}
