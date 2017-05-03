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
    protected $table = 'WechatFansTags';

    /**
     * 显示粉丝标签列表
     * @return array|string
     */
    public function index() {
        $this->title = '微信粉丝标签管理';
        $db = Db::name($this->table)->order('id asc');
        $get = $this->request->get();
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
        
    }

    /**
     * 编辑粉丝标签
     */
    public function edit() {
        
    }

    /**
     * 同步粉丝标签列表
     */
    public function sync() {
        Db::name($this->table)->where('1=1')->delete();
        if (WechatService::syncFansTags()) {
            LogService::write('微信管理', '同步全部微信粉丝标签成功');
            $this->success('同步获取所有粉丝标签成功！', '');
        }
        $this->error('同步获取粉丝标签失败，请稍候再试！');
    }

}
