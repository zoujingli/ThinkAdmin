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
        $db = Db::name($this->table)->where('is_back', '0')->order('id desc');
        $get = $this->request->get();
        foreach (['nickname'] as $key) {
            if (isset($get[$key]) && $get[$key] !== '') {
                $db->where($key, 'like', "%{$get[$key]}%");
            }
        }
        return parent::_list($db);
    }

    /**
     * 黑名单列表
     */
    public function back() {
        $this->title = '微信粉丝黑名单管理';
        $db = Db::name($this->table)->where('is_back', '1')->order('id desc');
        $get = $this->request->get();
        foreach (['nickname'] as $key) {
            if (isset($get[$key]) && $get[$key] !== '') {
                $db->where($key, 'like', "%{$get[$key]}%");
            }
        }
        return parent::_list($db);
    }

    /**
     * 设置黑名单
     */
    public function backadd() {
        $ids = $this->request->post('id', '');
        empty($ids) && $this->error('没有需要操作的数据!');
        $openids = Db::name($this->table)->where('id', 'in', explode(',', $ids))->column('openid');
        empty($openids) && $this->error('没有需要操作的数据!');
        $wechat = & load_wechat('User');
        if (false !== $wechat->addBacklist($openids)) {
            Db::name($this->table)->where('openid', 'in', $openids)->setField('is_back', '1');
            $this->success("已成功将 " . count($openids) . " 名粉丝移到黑名单!", '');
        }
        $this->error("设备黑名单失败，请稍候再试！{$wechat->errMsg}[{$wechat->errCode}]");
    }

    /**
     * 取消黑名
     */
    public function backdel() {
        $ids = $this->request->post('id', '');
        empty($ids) && $this->error('没有需要操作的数据!');
        $openids = Db::name($this->table)->where('id', 'in', explode(',', $ids))->column('openid');
        empty($openids) && $this->error('没有需要操作的数据!');
        $wechat = & load_wechat('User');
        if (false !== $wechat->delBacklist($openids)) {
            Db::name($this->table)->where('openid', 'in', $openids)->setField('is_back', '0');
            $this->success("已成功将 " . count($openids) . " 名粉丝从黑名单中移除!", '');
        }
        $this->error("设备黑名单失败，请稍候再试！{$wechat->errMsg}[{$wechat->errCode}]");
    }

    /**
     * 同步粉丝列表
     */
    public function sync() {
        Db::name($this->table)->where('1=1')->delete();
        if (WechatService::syncAllFans('')) {
            WechatService::syncBlackFans('');
            LogService::write('微信管理', '同步全部微信粉丝成功');
            $this->success('同步获取所有粉丝成功！', '');
        }
        $this->error('同步获取粉丝失败，请稍候再试！');
    }

}
