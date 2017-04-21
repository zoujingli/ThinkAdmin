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
use think\Db;

/**
 * 微信文章管理
 * Class Article
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Keys extends BasicAdmin {

    protected $table = 'WechatKeys';

    /**
     * 显示关键字列表
     */
    public function index() {
        $this->assign('title', '微信关键字');
        $db = Db::name($this->table)->where('keys', 'not in', ['subscribe', 'default']);
        $this->_list($db);
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
        $this->assign('title', '添加关键字规则');
        return $this->_form($this->table, 'form', 'id');
    }

    /**
     * 编辑关键字
     * @return string
     */
    public function edit() {
        $this->assign('title', '编辑关键字规则');
        return $this->_form($this->table, 'form', 'id');
    }

    public function subscribe() {

    }

    public function defaults() {

    }
}
