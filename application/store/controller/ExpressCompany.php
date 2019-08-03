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

namespace app\store\controller;

use library\Controller;
use think\Db;

/**
 * 快递公司管理
 * Class Express
 * @package app\store\controller
 */
class ExpressCompany extends Controller
{
    /**
     * 指定数据表
     * @var string
     */
    protected $table = 'StoreExpressCompany';

    /**
     * 快递公司管理
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
        $this->title = '快递公司管理';
        $query = $this->_query($this->table)->equal('status')->like('express_title,express_code');
        $query->dateBetween('create_at')->order('status desc,sort desc,id desc')->where(['is_deleted' => '0'])->page();
    }

    /**
     * 添加快递公司
     * @auth true
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑快递公司
     * @auth true
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @auth true
     */
    protected function _form_filter(array $data)
    {
        if ($this->request->isPost()) {
            $where = [['express_code', 'eq', $data['express_code']], ['is_deleted', 'eq', '0']];
            if (!empty($data['id'])) $where[] = ['id ', 'neq', $data['id']];
            if (Db::name($this->table)->where($where)->count() > 0) {
                $this->error('该快递编码已经存在，请使用其它编码！');
            }
        }
    }

    /**
     * 禁用快递公司
     * @auth true
     */
    public function forbid()
    {
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用快递公司
     * @auth true
     */
    public function resume()
    {
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 删除快递公司
     * @auth true
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
