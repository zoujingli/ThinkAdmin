<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 文章内容管理
 * Class ArticleContent
 * @package app\data\controller
 */
class ArticleContent extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataArticleContent';

    /**
     * 平台标签配置
     * @var array
     */
    protected $types = ['video' => '视频', 'article' => '文章', 'audio' => '音频'];

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
        $query->like('title,tags')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 文章内容管理
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $query = $this->_query($this->table)->equal('status')->like('title');
        $query->where(['deleted' => '0'])->dateBetween('create_at')->order('sort desc,id desc')->page();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _page_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo['tags'] = explode(',', trim($vo['tags'], ','));
        }
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
    protected function _form_filter(&$data)
    {
        if ($this->request->isGet()) {
            [$map, $sort] = [['deleted' => 0, 'status' => 1], 'sort desc,id desc'];
            $this->tags = $this->app->db->name('DataArticleTags')->where($map)->order($sort)->select()->toArray();
            $data['tags'] = isset($data['tags']) && $data['tags'] ? explode(',', trim($data['tags'], ',')) : [];
        } else {
            $data['tags'] = ',' . join(',', isset($data['tags']) && is_array($data['tags']) ? $data['tags'] : []) . ',';
        }
    }

    /**
     * 表单结果处理
     * @param boolean $state
     */
    protected function _form_result($state)
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