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
use service\LogService;
use service\WechatService;
use think\Db;

/**
 * 微信粉丝标签管理
 * Class Tags
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Tags extends BasicAdmin {

    /**
     * 定义当前默认数据表
     * @var string
     */
    public $table = 'WechatFansTags';

    /**
     * 显示粉丝标签列表
     * @return array|string
     */
    public function index() {
        $this->title = '微信粉丝标签管理';
        $get = $this->request->get();
        $db = Db::name($this->table)->order('id asc');
        foreach (['name'] as $key) {
            if (isset($get[$key]) && $get[$key] !== '') {
                $db->where($key, 'like', "%{$get[$key]}%");
            }
        }
        return parent::_list($db);
    }

    /**
     * 添加粉丝标签
     */
    public function add() {
        if ($this->request->isGet()) {
            return parent::_form($this->table, 'form', 'id');
        }
        $name = $this->request->post('name', '');
        empty($name) && $this->error('粉丝标签名不能为空!');
        (Db::name($this->table)->where('name', $name)->count() > 0) && $this->error('粉丝标签标签名已经存在, 请使用其它标签名!');
        $wechat = & load_wechat('User');
        if (false === ($result = $wechat->createTags($name)) && isset($result['tag'])) {
            $this->error("添加粉丝标签失败. {$wechat->errMsg}[{$wechat->errCode}]");
        }
        $result['tag']['count'] = 0;
        DataService::save($this->table, $result['tag'], 'id') && $this->success('添加粉丝标签成功!', '');
        $this->error('粉丝标签添加失败, 请稍候再试!');
    }

    /**
     * 编辑粉丝标签
     */
    public function edit() {
        // 显示编辑界面
        if ($this->request->isGet()) {
            return parent::_form($this->table, 'form', 'id');
        }
        // 接收提交的数据
        list($name, $id) = [$this->request->post('name', ''), $this->request->post('id', '0')];
        $info = Db::name($this->table)->where('name', $name)->find();
        if (!empty($info)) {
            if (intval($info['id']) === intval($id)) {
                $this->error('粉丝标签名没有改变, 无需修改!');
            }
            $this->error('标签已经存在, 使用其它名称再试!');
        }
        $wechat = &load_wechat('User');
        $data = ['id' => $id, 'name' => $name];
        if (false !== $wechat->updateTag($id, $name) && false !== DataService::save($this->table, $data, 'id')) {
            $this->success('编辑标签成功!', '');
        }
        $this->error('编辑标签失败, 请稍后再试!' . $wechat->errMsg);
    }

    /**
     * 同步粉丝标签列表
     */
    public function sync() {
        Db::name($this->table)->where('1=1')->delete();
        if (WechatService::syncFansTags()) {
            LogService::write('微信管理', '同步全部微信粉丝标签成功');
            $this->success('同步获取所有粉丝标签成功!', '');
        }
        $this->error('同步获取粉丝标签失败, 请稍候再!');
    }

}
