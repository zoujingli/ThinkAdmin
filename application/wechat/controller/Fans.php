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
use service\WechatService;
use think\Db;

/**
 * 微信粉丝管理
 * Class Fans
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Fans extends BasicAdmin {

    /**
     * 定义当前默认数据表
     * @var string
     */
    protected $table = 'WechatFans';

    /**
     * 显示粉丝列表
     * @return array|string
     */
    public function index() {
        $this->title = '微信粉丝管理';
        $db = Db::name($this->table);
        $get = $this->request->get();
        if (isset($get['nickname']) && $get['nickname'] !== '') {
            $db->where('nickname', 'like', "%{$get['nickname']}%");
        }
        return parent::_list($db);
    }

    /**
     * 同步粉丝列表
     */
    public function sync() {
        Db::name($this->table)->where('1=1')->delete();
        if (WechatService::syncAllFans('')) {
            $this->success('同步获取所有粉丝成功！', '');
        }
        $this->error('同步获取粉丝失败，请稍候再试！');
    }

}
