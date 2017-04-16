<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
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
use Wechat\WechatReceive;
use think\Controller;
use think\Db;
use think\Log;

/**
 * 微信接口控制器
 * Class Api
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 */
class Api extends Controller {

    /**
     * 微信消息对象
     * @var \Wechat\WechatReceive
     */
    protected $wechat;

    /**
     * 微信openid
     * @var string
     */
    protected $openid;

    public function index() {
        /* 实例接口对象 */
        $this->wechat = &load_wechat('Receive');
        /* 验证接口请求 */
        if ($this->wechat->valid() === false) {
            $msg = "{$this->wechat->errMsg}[{$this->wechat->errCode}]";
            Log::error($msg);
            exit($msg);
        }
        /* 获取消息openid */
        $this->openid = $this->wechat->getRev()->getRevFrom();
        /* 同步粉丝数据 */
        $this->_syncFans(true);
        /* 分别执行对应类型的操作 */
        switch ($this->wechat->getRev()->getRevType()) {
            case WechatReceive::MSGTYPE_TEXT:
                $keys = $this->wechat->getRevContent();
                exit($this->_keys("wechat_keys#keys#{$keys}"));
            case WechatReceive::MSGTYPE_EVENT:
                exit($this->_event());
            case WechatReceive::MSGTYPE_IMAGE:
                exit($this->_image());
            case WechatReceive::MSGTYPE_LOCATION:
                exit($this->_location());
            default:
                exit('success');
        }
    }

    /**
     * 关键字处理
     * @param string $keys 关键字（常规或规格关键字）
     * @param bool $default 是否启用默认模式
     * @return string
     */
    private function _keys($keys, $default = false) {
        list($table, $field, $value) = explode('#', $keys . '##');
        $info = Db::name($table)->where($field, $value)->find();
        if ($info && is_array($info) && isset($info['type'])) {
            // 转发给多客服
            if (!empty($info['type']) && $info['type'] === 'customservice') {
                $this->wechat->sendCustomMessage(['touser' => $this->openid, 'msgtype' => 'text', 'text' => ['content' => $info['content']]]);
                return $this->wechat->transfer_customer_service()->reply();
            }
            // 无法给出回复时调用默认回复机制
            array_key_exists('status', $info) && empty($info['status']) && exit('success');
            switch ($info['type']) {
                case 'keys': /* 关键字 */
                    empty($info['content']) && empty($info['name']) && exit('success');
                    return $this->_keys('wechat_keys#keys#' . (empty($info['content']) ? $info['name'] : $info['content']));
                case 'text': /* 文本消息 */
                    empty($info['content']) && exit('success');
                    return $this->wechat->text($info['content'])->reply();
                case 'news': /* 图文消息 */
                    empty($info['news_id']) && exit('success');
                    return $this->_news($info['news_id']);
                case 'music': /* 音频消息 */
                    (empty($info['music_url']) || empty($info['music_title']) || empty($info['music_desc'])) && exit('success');
                    $media_id = empty($info['music_image']) ? '' : WechatService::uploadForeverMedia($info['music_image'], 'image');
                    empty($media_id) && exit('success');
                    return $this->wechat->music($info['music_title'], $info['music_desc'], $info['music_url'], $info['music_url'], $media_id)->reply();
                case 'voice': /* 语音消息 */
                    empty($info['voice_url']) && exit('success');
                    $media_id = WechatService::uploadForeverMedia($info['voice_url'], 'voice')->reply();
                    empty($media_id) && exit('success');
                    return $this->wechat->voice($media_id)->reply();
                case 'image': /* 图文消息 */
                    empty($info['image_url']) && exit('success');
                    $media_id = WechatService::uploadForeverMedia($info['image_url'], 'image');
                    empty($media_id) && exit('success');
                    return $this->wechat->image($media_id)->reply();
                case 'video': /* 视频消息 */
                    (empty($info['video_url']) || empty($info['video_desc']) || empty($info['video_title'])) && exit('success');
                    $data = ['title' => $info['video_title'], 'introduction' => $info['video_desc']];
                    $media_id = WechatService::uploadForeverMedia($info['video_url'], 'video', true, $data);
                    return $this->wechat->video($media_id, $info['video_title'], $info['video_desc'])->reply();
            }
        }
        $default && exit('success');
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
                    'Url'         => url("@wechat/view/news/id/{$vo['id']}", '', true, true)
                ];
            }
            return $this->wechat->news($newsdata)->reply();
        }
        exit('success');
    }

    /**
     * 事件处理
     */
    protected function _event() {
        $event = $this->wechat->getRevEvent();
        switch (strtolower($event['event'])) {
            /* 关注事件 */
            case 'subscribe':
                $this->_syncFans(true);
                if (!empty($event['key']) && stripos($event['key'], 'qrscene_') !== false) {
                    $this->_spread(preg_replace('|^.*?(\d+).*?$|', '$1', $event['key']));
                }
                return $this->_keys('wechat_keys#keys#subscribe');
            /* 取消关注 */
            case 'unsubscribe':
                $this->_syncFans(false);
                exit('success');
            /* 点击菜单 */
            case 'click':
                return $this->_keys($event['key']);
            /* 扫码推事件 */
            case 'scancode_push':
            case 'scancode_waitmsg':
                $scanInfo = $this->wechat->getRev()->getRevScanInfo();
                if (isset($scanInfo['ScanResult'])) {
                    return $this->_keys($scanInfo['ScanResult']);
                }
                exit('success');
            case 'scan':
                if (!empty($event['key'])) {
                    return $this->_spread($event['key']);
                }
                exit('success');
        }
    }

    /**
     * 推荐好友扫码关注
     * @param string $key
     * @return mixed
     */
    private function _spread($key) {
        // 检测推荐是否有效
        $fans = Db::name('WechatFans')->where('id', $key)->find();
        if (!is_array($fans) || !isset($fans['openid']) || $fans['openid'] === $this->openid) {
            return false;
        }
        // 标识推荐关系
        Db::name('WechatFans')
            ->where('openid', $this->openid)
            ->where('(spread_openid is null or spread_openid="")')
            ->setField(['spread_by' => $fans['openid'], 'spread_at' => date('Y-m-d H:i:s')]);
        // @todo 推荐成功的奖励
    }

    /**
     * 位置事情回复
     * @return string
     */
    private function _location() {
        exit('success');
    }

    /**
     * 图片事件处理
     */
    private function _image() {
        exit('success');
    }

    /**
     * 同步粉丝状态
     * @param bool $subscribe 关注状态
     */
    protected function _syncFans($subscribe = true) {
        if ($subscribe) {
            $fans = WechatService::getFansInfo($this->openid);
            if (empty($fans) || empty($fans['subscribe'])) {
                $wechat = &load_wechat('User');
                $userInfo = $wechat->getUserInfo($this->openid);
                $userInfo['subscribe'] = intval($subscribe);
                WechatService::setFansInfo($userInfo, $wechat->appid);
            }
        } else {
            $data = ['subscribe' => '0', 'appid' => $this->appid, 'openid' => $this->openid];
            DataService::save('wechat_fans', $data, ['appid', 'openid']);
        }
    }

}
