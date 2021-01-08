<?php

namespace app\data\controller;

use app\data\service\NewsService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;

/**
 * 文章内容管理
 * Class NewsItem
 * @package app\data\controller
 */
class NewsItem extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataNewsItem';

    /**
     * 文章内容管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '文章内容管理';
        $query = $this->_query($this->table);
        $query->like('mark,name')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 文章内容选择器
     * @login true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $query = $this->_query($this->table);
        $query->equal('status')->like('name')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        NewsService::instance()->buildListState($data);
    }

    /**
     * 添加文章内容
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->title = '添加文章内容';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑文章内容
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->title = '编辑文章内容';
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidNumber(14, 'A');
        }
        if ($this->request->isGet()) {
            $map = ['deleted' => 0, 'status' => 1];
            $query = $this->app->db->name('DataNewsMark')->where($map);
            $this->marks = $query->order('sort desc,id desc')->select()->toArray();
            $data['mark'] = str2arr($data['mark'] ?? '');
        } else {
            $data['mark'] = arr2str($data['mark'] ?? []);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $state
     */
    protected function _form_result(bool $state)
    {
        if ($state) {
            $this->success('文章内容保存成功！', 'javascript:history.back()');
        }
    }

    /**
     * 修改文章状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除文章内容
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}