<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\FansService;
use app\wechat\service\MediaService;
use service\DataService;
use service\WechatService;
use think\Db;
use think\Exception;

/**
 * 微信接口控制器
 * Class Api
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 */
class Push
{

    /**
     * 当前公众号APPID
     * @var string
     */
    protected $appid;

    /**
     * 当前微信用户openid
     * @var string
     */
    protected $openid;

    /**
     * 当前微信消息对象
     * @var array
     */
    protected $receive;

    /**
     * 微信消息接口（通过ThinkService推送）
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $request = app('request');
        $this->appid = $request->post('appid', '', null);
        $this->openid = $request->post('openid', '', null);
        $this->receive = unserialize($request->post('receive', '', null));
        if (empty($this->appid) || empty($this->openid) || empty($this->receive)) {
            throw new Exception('微信API实例缺失必要参数[appid,openid,event].');
        }
        return $this->call($this->appid, $this->openid, $this->receive);
    }

    /**
     * 公众号直接对接（通过参数对接推送）
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function notify()
    {
        $wechat = WechatService::receive();
        return $this->call(WechatService::getAppid(), $wechat->getOpenid(), $wechat->getReceive());
    }

    /**
     * 初始化接口
     * @param string $appid 公众号APPID
     * @param string $openid 公众号OPENID
     * @param array $revice 消息对象
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function call($appid, $openid, $revice)
    {
        list($this->appid, $this->openid, $this->receive) = [$appid, $openid, $revice];
        if ($this->appid !== WechatService::getAppid()) {
            throw new Exception('微信API实例APPID验证失败.');
        }
        // text,event,image,location
        if (method_exists($this, ($method = $this->receive['MsgType']))) {
            if (is_string(($result = $this->$method()))) {
                return $result;
            }
        }
        return 'success';
    }

    /**
     * 文件消息处理
     * @return bool
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function text()
    {
        return $this->keys("wechat_keys#keys#{$this->receive['Content']}");
    }

    /**
     * 事件消息处理
     * @return bool|string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function event()
    {
        switch (strtolower($this->receive['Event'])) {
            case 'subscribe':
                $this->updateFansinfo(true);
                if (isset($this->receive['EventKey']) && is_string($this->receive['EventKey'])) {
                    if (($key = preg_replace('/^qrscene_/i', '', $this->receive['EventKey']))) {
                        [$this->updateSpread($key), $this->keys("wechat_keys#keys#{$key}")];
                    }
                }
                return $this->keys('wechat_keys#keys#subscribe', true);
            case 'unsubscribe':
                return $this->updateFansinfo(false);
            case 'click':
                return $this->keys($this->receive['EventKey']);
            case 'scancode_push':
            case 'scancode_waitmsg':
                if (isset($this->receive['ScanCodeInfo'])) {
                    $this->receive['ScanCodeInfo'] = (array)$this->receive['ScanCodeInfo'];
                    if (!empty($this->receive['ScanCodeInfo']['ScanResult'])) {
                        return $this->keys("wechat_keys#keys#{$this->receive['ScanCodeInfo']['ScanResult']}");
                    }
                }
                return false;
            case 'scan':
                if (!empty($this->receive['EventKey'])) {
                    return $this->keys("wechat_keys#keys#{$this->receive['EventKey']}");
                }
                return false;
        }
        return false;
    }

    /**
     * 关键字处理
     * @param string $rule 关键字规则
     * @param bool $isLastReply 强制结束
     * @return bool|string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function keys($rule, $isLastReply = false)
    {
        list($table, $field, $value) = explode('#', $rule . '##');
        $info = Db::name($table)->where($field, $value)->find();
        if (empty($info['type']) || (array_key_exists('status', $info) && empty($info['status']))) {
            // 切换默认回复
            return $isLastReply ? false : $this->keys('wechat_keys#keys#default', true);
        }
        switch ($info['type']) {
            case 'customservice':
                return $this->sendMessage('customservice', ['content' => $info['content']]);
            case 'keys':
                $content = empty($info['content']) ? $info['name'] : $info['content'];
                return $this->keys("wechat_keys#keys#{$content}");
            case 'text':
                return $this->sendMessage('text', ['content' => $info['content']]);
            case 'news':
                list($news, $data) = [MediaService::getNewsById($info['news_id']), []];
                if (empty($news['articles'])) {
                    return false;
                }
                foreach ($news['articles'] as $vo) {
                    $url = url("@wechat/review", '', true, true) . "?content={$vo['id']}&type=article";
                    $data[] = ['url' => $url, 'title' => $vo['title'], 'picurl' => $vo['local_url'], 'description' => $vo['digest']];
                }
                return $this->sendMessage('news', ['articles' => $data]);
            case 'music':
                if (empty($info['music_url']) || empty($info['music_title']) || empty($info['music_desc'])) {
                    return false;
                }
                $media_id = empty($info['music_image']) ? '' : MediaService::uploadForeverMedia($info['music_image'], 'image');
                $data = ['title' => $info['music_title'], 'description' => $info['music_desc'], 'musicurl' => $info['music_url'], 'hqmusicurl' => $info['music_url'], 'thumb_media_id' => $media_id];
                return $this->sendMessage('music', $data);
            case 'voice':
                if (empty($info['voice_url']) || !($media_id = MediaService::uploadForeverMedia($info['voice_url'], 'voice'))) {
                    return false;
                }
                return $this->sendMessage('voice', ['media_id' => $media_id]);
            case 'image':
                if (empty($info['image_url']) || !($media_id = MediaService::uploadForeverMedia($info['image_url'], 'image'))) {
                    return false;
                }
                return $this->sendMessage('image', ['media_id' => $media_id]);
            case 'video':
                if (empty($info['video_url']) || empty($info['video_desc']) || empty($info['video_title'])) {
                    return false;
                }
                $videoData = ['title' => $info['video_title'], 'introduction' => $info['video_desc']];
                if (!($media_id = MediaService::uploadForeverMedia($info['video_url'], 'video', $videoData))) {
                    return false;
                }
                $data = ['media_id' => $media_id, 'title' => $info['video_title'], 'description' => $info['video_desc']];
                return $this->sendMessage('video', $data);
            default:
                return false;
        }
    }

    /**
     * 发送消息到公众号
     * @param string $type 消息类型（text|image|voice|video|music|news|mpnews|wxcard）
     * @param array $data 消息内容
     * @return array|bool
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function sendMessage($type, $data)
    {
        $msgData = ['touser' => $this->openid, 'msgtype' => $type, "{$type}" => $data];
        switch (strtolower(sysconf('wechat_type'))) {
            case 'api': // 参数对接，直接回复XML来实现消息回复
                $wechat = WechatService::receive();
                switch (strtolower($type)) {
                    case 'text':
                        return $wechat->text($data['content'])->reply([], true);
                    case 'image':
                        return $wechat->image($data['media_id'])->reply([], true);
                    case 'video':
                        return $wechat->video($data['media_id'], $data['title'], $data['description'])->reply([], true);
                    case 'voice':
                        return $wechat->voice($data['media_id'])->reply([], true);
                    case 'music':
                        return $wechat->music($data['title'], $data['description'], $data['musicurl'], $data['hqmusicurl'], $data['thumb_media_id'])->reply([], true);
                    case 'news':
                        return $wechat->news($data['articles'])->reply([], true);
                    case 'customservice':
                        WechatService::custom()->send(['touser' => $this->openid, 'msgtype' => 'text', "text" => $data['content']]);
                        return $wechat->transferCustomerService()->reply([], true);
                    default:
                        return 'success';
                }
            case 'thr': // 第三方平台，使用客服消息来实现
                return WechatService::custom()->send($msgData);
            default:
                return 'success';
        }
    }

    /**
     * 更新推荐二维码关系
     * @param string $key
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function updateSpread($key)
    {
        // 检测推荐是否有效
        $fans = Db::name('WechatFans')->where(['openid' => $key])->find();
        if (empty($fans['openid']) || $fans['openid'] === $this->openid) {
            return false;
        }
        // 标识推荐关系
        $data = ['spread_openid' => $fans['openid'], 'spread_at' => date('Y-m-d H:i:s')];
        $where = "openid='{$this->openid}' and (spread_openid is null or spread_openid='')";
        return Db::name('WechatFans')->where($where)->update($data) !== false;
    }

    /**
     * 同步粉丝状态
     * @param bool $subscribe 关注状态
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function updateFansinfo($subscribe = true)
    {
        if ($subscribe) {
            $userInfo = WechatService::user()->getUserInfo($this->openid);
            $userInfo['subscribe'] = intval($subscribe);
            FansService::set($userInfo);
        } else {
            $fans = ['subscribe' => '0', 'openid' => $this->openid, 'appid' => $this->appid];
            DataService::save('WechatFans', $fans, 'openid', ['appid' => $this->appid]);
        }
    }

}
