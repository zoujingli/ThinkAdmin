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

namespace app\wechat\controller;

use controller\BasicAdmin;
use service\DataService;
use think\Db;

/**
 * 微信文章管理
 * Class Article
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Keys extends BasicAdmin {

    /**
     * 指定当前数据表
     * @var string
     */
    public $table = 'WechatKeys';

    /**
     * 显示关键字列表
     */
    public function index() {
        $this->assign('title', '微信关键字');
        $db = Db::name($this->table)->where('keys', 'not in', ['subscribe', 'default']);
        return $this->_list($db);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_data_filter(&$data) {
        $types = ['keys' => '关键字', 'image' => '图片', 'news' => '图文', 'music' => '音乐', 'text' => '文字', 'video' => '视频', 'voice' => '语音'];
        foreach ($data as &$vo) {
            $vo['type'] = isset($types[$vo['type']]) ? $types[$vo['type']] : $vo['type'];
        }
    }

    /**
     * 添加关键字
     * @return string
     */
    public function add() {
        $this->title = '添加关键字规则';
        return $this->_form($this->table, 'form');
    }

    /**
     * 编辑关键字
     * @return string
     */
    public function edit() {
        $this->title = '编辑关键字规则';
        return $this->_form($this->table, 'form');
    }


    /**
     * 表单处理
     * @param $data
     */
    protected function _form_filter($data) {
        if ($this->request->isPost() && isset($data['keys'])) {
            $db = Db::name($this->table)->where('keys', $data['keys']);
            !empty($data['id']) && $db->where('id', 'neq', $data['id']);
            $db->count() > 0 && $this->error('关键字已经存在，请使用其它关键字！');
        }
    }

    /**
     * 删除关键字
     */
    public function del() {
        if (DataService::update($this->table)) {
            $this->success("关键字删除成功！", '');
        }
        $this->error("关键字删除失败，请稍候再试！");
    }


    /**
     * 关键字禁用
     */
    public function forbid() {
        if (DataService::update($this->table)) {
            $this->success("关键字禁用成功！", '');
        }
        $this->error("关键字禁用失败，请稍候再试！");
    }

    /**
     * 关键字禁用
     */
    public function resume() {
        if (DataService::update($this->table)) {
            $this->success("关键字启用成功！", '');
        }
        $this->error("关键字启用失败，请稍候再试！");
    }

    /**
     * 关注默认回复
     */
    public function subscribe() {
        $this->assign('title', '编辑默认回复');
        return $this->_form($this->table, 'form');
    }

    /**
     * 关注默认回复表单处理
     * @param $data
     */
    protected function _subscribe_form_filter(&$data) {
        if ($this->request->isGet()) {
            $data = Db::name($this->table)->where('keys', 'subscribe')->find();
        }
        $data['keys'] = 'subscribe';
    }


    /**
     * 无配置默认回复
     */
    public function defaults() {
        $this->assign('title', '编辑无配置默认回复');
        return $this->_form($this->table, 'form');
    }


    /**
     * 无配置默认回复表单处理
     * @param $data
     */
    protected function _defaults_form_filter(&$data) {
        if ($this->request->isGet()) {
            $data = Db::name($this->table)->where('keys', 'default')->find();
        }
        $data['keys'] = 'default';
    }
}
