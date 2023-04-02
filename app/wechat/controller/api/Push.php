<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\FansService;
use app\wechat\service\MediaService;
use app\wechat\service\WechatService;
use think\admin\Controller;

/**
 * 微信消息推送处理
 * @class Push
 * @package app\wechat\controller\api
 */
class Push extends Controller
{

    /**
     * 公众号 APPID
     * @var string
     */
    protected $appid;

    /**
     * 微信用户 OPENID
     * @var string
     */
    protected $openid;

    /**
     * 消息是否加密码
     * @var boolean
     */
    protected $encrypt;

    /**
     * 请求微信 OPENID
     * @var string
     */
    protected $fromOpenid;

    /**
     * 微信消息对象
     * @var array
     */
    protected $receive;

    /**
     * 微信实例对象
     * @var \WeChat\Receive
     */
    protected $wechat;

    /**
     * 强制返回JSON消息
     * @var boolean
     */
    protected $forceJson = false;

    /**
     * 强制客服消息回复
     * @var boolean
     */
    protected $forceCustom = false;

    /**
     * 获取网络出口IP
     * @return string
     */
    public function geoip(): string
    {
        return $this->request->ip();
    }

    /**
     * 消息推送处理接口
     * @return string
     */
    public function index(): string
    {
        try {
            if (WechatService::getType() === 'thr') {
                $this->forceJson = true; // 直接返回JSON数据到SERVICE
                $this->forceCustom = false; // 直接使用客服消息模式推送
                $this->appid = $this->request->post('appid', '', null);
                $this->openid = $this->request->post('openid', '', null);
                $this->encrypt = boolval($this->request->post('encrypt', 0));
                $this->receive = $this->_arrayChangeKeyCase(json_decode(input('params', '[]'), true));
                if (empty($this->appid) || empty($this->openid) || empty($this->receive)) {
                    throw new \think\admin\Exception('微信API实例缺失必要参数[appid,openid,receive]');
                }
            } else {
                $this->forceJson = false; // 直接返回JSON对象数据
                $this->forceCustom = false; // 直接使用客服消息推送
                $this->appid = WechatService::getAppid();
                $this->wechat = WechatService::WeChatReceive();
                $this->openid = $this->wechat->getOpenid();
                $this->encrypt = $this->wechat->isEncrypt();
                $this->receive = $this->_arrayChangeKeyCase($this->wechat->getReceive());
            }
            $this->fromOpenid = $this->receive['tousername'];
            // 消息类型：text, event, image, voice, shortvideo, location, link
            if (method_exists($this, ($method = $this->receive['msgtype']))) {
                if (is_string($result = $this->$method())) return $result;
            } else {
                $this->app->log->notice("The {$method} event pushed by wechat was not handled. from {$this->openid}");
            }
        } catch (\Exception $exception) {
            $this->app->log->error("{$exception->getFile()}:{$exception->getLine()} [{$exception->getCode()}] {$exception->getMessage()}");
        }
        return 'success';
    }

    /**
     * 文件消息处理
     * @return boolean|string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function text()
    {
        return $this->_keys("WechatKeys#keys#{$this->receive['content']}", false, $this->forceCustom);
    }

    /**
     * 事件消息处理
     * @return boolean|string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function event()
    {
        switch (strtolower($this->receive['event'])) {
            case 'unsubscribe':
                $this->app->event->trigger('WechatFansUnSubscribe', $this->openid);
                return $this->_setUserInfo(false);
            case 'subscribe':
                [$this->app->event->trigger('WechatFansSubscribe', $this->openid), $this->_setUserInfo(true)];
                if (isset($this->receive['eventkey']) && is_string($this->receive['eventkey'])) {
                    if (($key = preg_replace('/^qrscene_/i', '', $this->receive['eventkey']))) {
                        return $this->_keys("WechatKeys#keys#{$key}", false, true);
                    }
                }
                return $this->_keys('WechatKeys#keys#subscribe', true, $this->forceCustom);
            case 'scan':
            case 'click':
                if (empty($this->receive['eventkey'])) return false;
                return $this->_keys("WechatKeys#keys#{$this->receive['eventkey']}", false, $this->forceCustom);
            case 'scancode_push':
            case 'scancode_waitmsg':
                if (empty($this->receive['scancodeinfo']['scanresult'])) return false;
                return $this->_keys("WechatKeys#keys#{$this->receive['scancodeinfo']['scanresult']}", false, $this->forceCustom);
            case 'view':
            case 'location':
            default:
                return false;
        }
    }

    /**
     * 关键字处理
     * @param string $rule 关键字规则
     * @param boolean $last 重复回复消息处理
     * @param boolean $custom 是否使用客服消息发送
     * @return boolean|string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _keys(string $rule, bool $last = false, bool $custom = false)
    {
        if (is_numeric(stripos($rule, '#reply#text:'))) {
            [, $content] = explode('#reply#text:', $rule);
            return $this->_buildMessage('text', ['Content' => $content]);
        }
        [$table, $field, $value] = explode('#', $rule . '##');
        $data = $this->app->db->name($table)->where([$field => $value])->find();
        if (empty($data['type']) || (array_key_exists('status', $data) && empty($data['status']))) {
            return $last ? false : $this->_keys('WechatKeys#keys#default', true, $custom);
        }
        switch (strtolower($data['type'])) {
            case 'keys':
                $content = empty($data['content']) ? $data['name'] : $data['content'];
                return $this->_keys("WechatKeys#keys#{$content}", $last, $custom);
            case 'text':
                return $this->_sendMessage('text', ['content' => $data['content']], $custom);
            case 'customservice':
                return $this->_sendMessage('customservice', ['content' => $data['content']]);
            case 'voice':
                if (empty($data['voice_url']) || !($mediaId = MediaService::upload($data['voice_url'], 'voice'))) return false;
                return $this->_sendMessage('voice', ['media_id' => $mediaId], $custom);
            case 'image':
                if (empty($data['image_url']) || !($mediaId = MediaService::upload($data['image_url']))) return false;
                return $this->_sendMessage('image', ['media_id' => $mediaId], $custom);
            case 'news':
                [$news, $articles] = [MediaService::news($data['news_id']), []];
                if (empty($news['articles'])) return false;
                foreach ($news['articles'] as $vo) $articles[] = [
                    'url'   => url("@wechat/api.view/item/id/{$vo['id']}", [], false, true)->build(),
                    'title' => $vo['title'], 'picurl' => $vo['local_url'], 'description' => $vo['digest'],
                ];
                return $this->_sendMessage('news', ['articles' => $articles], $custom);
            case 'music':
                if (empty($data['music_url']) || empty($data['music_title']) || empty($data['music_desc'])) return false;
                $mediaId = $data['music_image'] ? MediaService::upload($data['music_image']) : '';
                return $this->_sendMessage('music', [
                    'hqmusicurl'  => $data['music_url'], 'musicurl' => $data['music_url'],
                    'description' => $data['music_desc'], 'title' => $data['music_title'], 'thumb_media_id' => $mediaId,
                ], $custom);
            case 'video':
                if (empty($data['video_url']) || empty($data['video_desc']) || empty($data['video_title'])) return false;
                $video = ['title' => $data['video_title'], 'introduction' => $data['video_desc']];
                if (!($mediaId = MediaService::upload($data['video_url'], 'video', $video))) return false;
                return $this->_sendMessage('video', ['media_id' => $mediaId, 'title' => $data['video_title'], 'description' => $data['video_desc']], $custom);
            default:
                return false;
        }
    }

    /**
     * 发送消息到微信
     * @param string $type 消息类型（text|image|voice|video|music|news|mpnews|wxcard）
     * @param array $data 消息内容数据对象
     * @param boolean $custom 是否使用客服消息发送
     * @return string|void
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    private function _sendMessage(string $type, array $data, bool $custom = false)
    {
        if ($custom) {
            WechatService::WeChatCustom()->send(['touser' => $this->openid, 'msgtype' => $type, $type => $data]);
        } else switch (strtolower($type)) {
            case 'text': // 发送文本消息
                return $this->_buildMessage($type, ['Content' => $data['content']]);
            case 'news': // 发送图文消息
                foreach ($data['articles'] as &$v) {
                    $v = ['PicUrl' => $v['picurl'], 'Title' => $v['title'], 'Description' => $v['description'], 'Url' => $v['url']];
                }
                return $this->_buildMessage($type, ['Articles' => $data['articles'], 'ArticleCount' => count($data['articles'])]);
            case 'image': // 发送图片消息
                return $this->_buildMessage($type, ['Image' => ['MediaId' => $data['media_id']]]);
            case 'voice': // 发送语言消息
                return $this->_buildMessage($type, ['Voice' => ['MediaId' => $data['media_id']]]);
            case 'video': // 发送视频消息
                return $this->_buildMessage($type, ['Video' => ['Title' => $data['title'], 'Description' => $data['description'], 'MediaId' => $data['media_id']]]);
            case 'music': // 发送音乐消息
                return $this->_buildMessage($type, ['Music' => ['Title' => $data['title'], 'Description' => $data['description'], 'MusicUrl' => $data['musicurl'], 'HQMusicUrl' => $data['musicurl'], 'ThumbMediaId' => $data['thumb_media_id']]]);
            case 'customservice': // 转交客服消息
                if ($data['content']) $this->_sendMessage('text', $data, true);
                return $this->_buildMessage('transfer_customer_service');
            default:
                return 'success';
        }
    }

    /**
     * 消息数据生成
     * @param mixed $type 消息类型
     * @param array $data 消息内容
     * @return string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     */
    private function _buildMessage(string $type, array $data = []): string
    {
        $data = array_merge($data, ['ToUserName' => $this->openid, 'FromUserName' => $this->fromOpenid, 'CreateTime' => time(), 'MsgType' => $type]);
        return $this->forceJson ? json_encode($data, JSON_UNESCAPED_UNICODE) : WechatService::WeChatReceive()->reply($data, true, $this->encrypt);
    }

    /**
     * 同步粉丝状态
     * @param boolean $state 订阅状态
     * @return boolean
     */
    private function _setUserInfo(bool $state): bool
    {
        if ($state) {
            try {
                $user = WechatService::WeChatUser()->getUserInfo($this->openid);
                return FansService::set(array_merge($user, ['subscribe' => 1, 'appid' => $this->appid]));
            } catch (\Exception $exception) {
                $this->app->log->error(__METHOD__ . " {$this->openid} get userinfo faild. {$exception->getMessage()}");
                return false;
            }
        } else {
            return FansService::set(['subscribe' => 0, 'openid' => $this->openid, 'appid' => $this->appid]);
        }
    }

    /**
     * 数组健值全部转小写
     * @param array $data
     * @return array
     */
    private function _arrayChangeKeyCase(array $data): array
    {
        $data = array_change_key_case($data);
        foreach ($data as $key => $vo) if (is_array($vo)) {
            $data[$key] = $this->_arrayChangeKeyCase($vo);
        }
        return $data;
    }

}
