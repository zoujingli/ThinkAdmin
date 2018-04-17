<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\goods\controller;

use controller\BasicAdmin;
use service\DataService;
use think\Db;

/**
 * 商店规格管理
 * Class Spec
 * @package app\store\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Spec extends BasicAdmin
{

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'GoodsSpec';

    /**
     * 产品列表
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->title = '规格管理（请勿随意修改或删除）';
        $get = $this->request->get();
        $db = Db::name($this->table)->where(['is_deleted' => '0']);
        if (isset($get['spec_title']) && $get['spec_title'] !== '') {
            $db->whereLike('spec_title', "%{$get['spec_title']}%");
        }
        if (isset($get['date']) && $get['date'] !== '') {
            list($start, $end) = explode(' - ', $get['date']);
            $db->whereBetween('create_at', ["{$start} 00:00:00", "{$end} 23:59:59"]);
        }
        return parent::_list($db->order('sort asc,id desc'));
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_data_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo['spec_param'] = json_decode($vo['spec_param'], true);
            $vo['spec_param'] = is_array($vo['spec_param']) ? $vo['spec_param'] : [];
        }
    }

    /**
     * 添加产品
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function add()
    {
        $this->title = '添加规格';
        return $this->_form($this->table, 'form');
    }

    /**
     * 编辑产品
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function edit()
    {
        $this->title = '编辑规格';
        return $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     */
    protected function _form_filter(&$vo)
    {
        if ($this->request->isPost()) {
            $param = json_decode($this->request->post('spec_param', '[]', null), true);
            foreach ($param as &$v) {
                $count = 1;
                while ($count) {
                    $v['value'] = trim(str_replace(['  ', '_', ',', '，', ';', '；'], ' ', $v['value'], $count));
                }
            }
            $vo['spec_param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 删除产品规格
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        if (DataService::update($this->table)) {
            $this->success("产品规格删除成功！", '');
        }
        $this->error("产品规格删除失败，请稍候再试！");
    }

    /**
     * 产品规格禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        if (DataService::update($this->table)) {
            $this->success("产品规格禁用成功！", '');
        }
        $this->error("产品规格禁用失败，请稍候再试！");
    }

    /**
     * 产品规格禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        if (DataService::update($this->table)) {
            $this->success("产品规格启用成功！", '');
        }
        $this->error("产品规格启用失败，请稍候再试！");
    }

}
