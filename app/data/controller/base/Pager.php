<?php

namespace app\data\controller\base;

use think\admin\Controller;
use think\admin\model\SystemBase;

/**
 * 页面内容管理
 * Class Pager
 * @package app\data\controller\base
 */
class Pager extends Controller
{
    /**
     * 字典类型
     * @var string
     */
    protected $type = '页面内容';

    /**
     * 页面类型
     * @var array
     */
    protected $types = [];

    /**
     * 控制器初始化
     * @return void
     */
    protected function initialize()
    {
        $this->types = SystemBase::mk()->items($this->type);
    }

    /**
     * 内容页面管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '内容页面管理';
        $this->fetch();
    }

    /**
     * 内容页面编辑
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->skey = input('get.type', '');
        $this->base = $this->types[$this->skey] ?? [];
        if (empty($this->base)) $this->error('未配置基础数据！');
        $this->title = "编辑{$this->base['name']}";
        $this->sysdata();
    }

    /**
     * 显示并保存数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function sysdata()
    {
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->fetch('form');
        } elseif ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = $this->request->post();
            }
            if (sysdata($this->skey, $data) !== false) {
                $this->success('内容保存成功！', 'javascript:history.back()');
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }
    }
}