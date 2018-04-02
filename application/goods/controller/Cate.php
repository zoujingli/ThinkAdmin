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
use service\ToolsService;
use think\Db;

/**
 * 商店产品分类管理
 * Class Cate
 * @package app\store\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Cate extends BasicAdmin
{

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'GoodsCate';

    /**
     * 产品分类列表
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->title = '产品分类';
        $db = Db::name($this->table)->where(['is_deleted' => '0']);
        return parent::_list($db->order('sort asc,id asc'), false);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_data_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo['ids'] = join(',', ToolsService::getArrSubIds($data, $vo['id']));
        }
        $data = ToolsService::arr2table($data);
    }

    /**
     * 添加菜单
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        return $this->_form($this->table, 'form');
    }

    /**
     * 编辑菜单
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        return $this->_form($this->table, 'form');
    }

    /**
     * 表单数据前缀方法
     * @param array $vo
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _form_filter(&$vo)
    {
        if ($this->request->isGet()) {
            // 读取上级分类
            $where = ['status' => '1', 'is_deleted' => '0'];
            $_cates = (array)Db::name($this->table)->where($where)->order('sort desc,id desc')->select();
            array_unshift($_cates, ['id' => 0, 'pid' => -1, 'cate_title' => '--- 顶级分类 ---']);
            $cates = ToolsService::arr2table($_cates);
            foreach ($cates as $key => &$cate) {
                if (isset($vo['pid'])) {
                    $path = "-{$vo['pid']}-{$vo['id']}";
                    if ($vo['pid'] !== '' && (stripos("{$cate['path']}-", "{$path}-") !== false || $cate['path'] === $path)) {
                        unset($cates[$key]);
                    }
                }
            }
            $this->assign('cates', $cates);
        }
    }

    /**
     * 删除产品分类
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        if (DataService::update($this->table)) {
            $this->success("产品分类删除成功！", '');
        }
        $this->error("产品分类删除失败，请稍候再试！");
    }

    /**
     * 产品分类禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        if (DataService::update($this->table)) {
            $this->success("产品分类禁用成功！", '');
        }
        $this->error("产品分类禁用失败，请稍候再试！");
    }

    /**
     * 产品分类禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        if (DataService::update($this->table)) {
            $this->success("产品分类启用成功！", '');
        }
        $this->error("产品分类启用失败，请稍候再试！");
    }

}
