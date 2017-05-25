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

use service\DataService;
use service\WechatService;
use think\Controller;
use think\Db;
use think\Log;
use Wechat\WechatReceive;

/**
 * 微信接口控制器
 * Class Api
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 */
class Api extends Controller {

    /**
     * 微信openid
     * @var string
     */
    protected $openid;

    /**
     * 微信消息对象
     * @var WechatReceive
     */
    protected $wechat;

    /**
     * 微信消息接口
     * @return string
     */
    public function index() {
        // 实例接口对象
        $this->wechat = &load_wechat('Receive');
        // 验证接口请求
        if ($this->wechat->valid() === false) {
            $msg = "{$this->wechat->errMsg}[{$this->wechat->errCode}]";
            Log::error($msg);
            return $msg;
        }
        // 获取消息来源用户OPENID
        $this->openid = $this->wechat->getRev()->getRevFrom();
        // 获取并同步粉丝信息到数据库
        $this->_updateFansInfo(true);
        // 分别执行对应类型的操作
        switch ($this->wechat->getRev()->getRevType()) {
            case WechatReceive::MSGTYPE_TEXT:
                return $this->_keys("WechatKeys#keys#" . $this->wechat->getRevContent());
            case WechatReceive::MSGTYPE_EVENT:
                return $this->_event();
            case WechatReceive::MSGTYPE_IMAGE:
                return $this->_image();
            case WechatReceive::MSGTYPE_LOCATION:
                return $this->_location();
            default:
                return 'success';
        }
    }

    /**
     * 关键字处理
     * @param string $keys
     * @param bool $isForce
     * @return string
     */
    private function _keys($keys, $isForce = false) {
        list($table, $field, $value) = explode('#', $keys . '##');
        if (is_array($info = Db::name($table)->where($field, $value)->find()) && isset($info['type'])) {
            // 数据状态检查
            if (array_key_exists('status', $info) && empty($info['status'])) {
                return 'success';
            }
            switch ($info['type']) {
                case 'customservice': // 多客服
                    $this->wechat->sendCustomMessage(['touser' => $this->openid, 'msgtype' => 'text', 'text' => ['content' => $info['content']]]);
                    return $this->wechat->transfer_customer_service()->reply(false, true);
                case 'keys': // 关键字
                    if (empty($info['content']) && empty($info['name'])) {
                        return 'success';
                    }
                    return $this->_keys('wechat_keys#keys#' . (empty($info['content']) ? $info['name'] : $info['content']));
                case 'text': // 文本消息
                    if (empty($info['content']) && empty($info['name'])) {
                        return 'success';
                    }
                    return $this->wechat->text($info['content'])->reply(false, true);
                case 'news': // 图文消息
                    if (empty($info['news_id'])) {
                        return 'success';
                    }
                    return $this->_news($info['news_id']);
                case 'music': // 音频消息
                    if (empty($info['music_url']) || empty($info['music_title']) || empty($info['music_desc'])) {
                        return 'success';
                    }
                    $media_id = empty($info['music_image']) ? '' : WechatService::uploadForeverMedia($info['music_image'], 'image');
                    if (empty($media_id)) {
                        return 'success';
                    }
                    return $this->wechat->music($info['music_title'], $info['music_desc'], $info['music_url'], $info['music_url'], $media_id)->reply(false, true);
                case 'voice': // 语音消息
                    if (empty($info['voice_url'])) {
                        return 'success';
                    }
                    $media_id = WechatService::uploadForeverMedia($info['voice_url'], 'voice');
                    if (empty($media_id)) {
                        return 'success';
                    }
                    return $this->wechat->voice($media_id)->reply(false, true);
                case 'image': // 图文消息
                    if (empty($info['image_url'])) {
                        return 'success';
                    }
                    $media_id = WechatService::uploadForeverMedia($info['image_url'], 'image');
                    if (empty($media_id)) {
                        return 'success';
                    }
                    return $this->wechat->image($media_id)->reply(false, true);
                case 'video': // 视频消息
                    if (empty($info['video_url']) || empty($info['video_desc']) || empty($info['video_title'])) {
                        return 'success';
                    }
                    $data = ['title' => $info['video_title'], 'introduction' => $info['video_desc']];
                    $media_id = WechatService::uploadForeverMedia($info['video_url'], 'video', true, $data);
                    return $this->wechat->video($media_id, $info['video_title'], $info['video_desc'])->reply(false, true);
            }
        }
        if ($isForce) {
            return 'success';
        }
        return $this->_keys('wechat_keys#keys#default', true);
    }

    /**
     * 回复图文
     * @param int $news_id
     * @return bool|string
     */
    protected function _news($news_id = 0) {
        if (is_array($newsinfo = WechatService::getNewsById($news_id)) && !empty($newsinfo['articles'])) {
            $newsdata = array();
            foreach ($newsinfo['articles'] as $vo) {
                $newsdata[] = [
                    'Title'       => $vo['title'],
                    'Description' => $vo['digest'],
                    'PicUrl'      => $vo['local_url'],
                    'Url'         => url("@wechat/review", '', true, true) . "?content={$vo['id']}&type=article",
                ];
            }
            return $this->wechat->news($newsdata)->reply(false, true);
        }
        return 'success';
    }

    /**
     * 事件处理
     */
    protected function _event() {
        $event = $this->wechat->getRevEvent();
        switch (strtolower($event['event'])) {
            case 'subscribe': // 粉丝关注事件
                $this->_updateFansInfo(true);
                $this->_spread($event['key']);
                return $this->_keys('wechat_keys#keys#subscribe', true);
            case 'unsubscribe':// 粉丝取消关注
                $this->_updateFansInfo(false);
                return 'success';
            case 'click': // 点击菜单事件
                return $this->_keys($event['key']);
            case 'scancode_push':
            case 'scancode_waitmsg': // 扫码推事件
                $scanInfo = $this->wechat->getRev()->getRevScanInfo();
                if (isset($scanInfo['ScanResult'])) {
                    return $this->_keys($scanInfo['ScanResult']);
                }
                return 'success';
            case 'scan':
                if (!empty($event['key'])) {
                    return $this->_spread($event['key']);
                }
                return 'success';
        }
        return 'success';
    }

    /**
     * 推荐好友扫码关注
     * @param string $event
     * @return mixed
     */
    private function _spread($event) {
        $key = preg_replace('|^.*?(\d+).*?$|', '$1', "{$event}");
        // 检测推荐是否有效
        $fans = Db::name('WechatFans')->where('id', $key)->find();
        if (!is_array($fans) || !isset($fans['openid']) || $fans['openid'] === $this->openid) {
            return false;
        }
        // 标识推荐关系
        $data = ['spread_by' => $fans['openid'], 'spread_at' => date('Y-m-d H:i:s')];
        Db::name('WechatFans')->where("openid='{$this->openid}' and (spread_openid is null or spread_openid='')")->setField($data);
        // @todo 推荐成功的奖励
    }

    /**
     * 位置事情回复
     * @return string
     */
    private function _location() {
        return 'success';
    }

    /**
     * 图片事件处理
     */
    private function _image() {
        return 'success';
    }

    /**
     * 同步粉丝状态
     * @param bool $subscribe 关注状态
     */
    protected function _updateFansInfo($subscribe = true) {
        if ($subscribe) {
            $fans = WechatService::getFansInfo($this->openid);
            if (empty($fans) || empty($fans['subscribe'])) {
                $wechat = &load_wechat('User');
                $userInfo = $wechat->getUserInfo($this->openid);
                $userInfo['subscribe'] = intval($subscribe);
                WechatService::setFansInfo($userInfo, $wechat->appid);
            }
        } else {
            $data = ['subscribe' => '0', 'appid' => $this->wechat->appid, 'openid' => $this->openid];
            DataService::save('wechat_fans', $data, ['appid', 'openid']);
        }
    }

}
