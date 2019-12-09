<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\service\service;

use think\admin\Service;

/**
 * 公众号授权配置
 * Class ConfigService
 * @package app\service\service
 */
class ConfigService extends Service
{
    /**
     * 当前微信APPID
     * @var string
     */
    protected $appid;

    /**
     * 当前微信配置
     * @var array
     */
    protected $config;

    /**
     * 授权配置初始化
     * @param string $appid
     * @return $this
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function initialize(string $appid): Service
    {
        $this->appid = $appid;
        $this->config = $this->app->db->name('wechatServiceConfig')->where(['authorizer_appid' => $appid])->find();
        if (empty($this->config)) {
            throw new \think\Exception("公众号{$appid}还没有授权！");
        }
        return $this;
    }

    /**
     * 获取当前公众号配置
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 设置微信接口通知URL地址
     * @param string $notifyUri 接口通知URL地址
     * @return boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DbException
     */
    public function setApiNotifyUri($notifyUri)
    {
        if (empty($notifyUri)) throw new \think\Exception('请传入微信通知URL');
        list($where, $data) = [['authorizer_appid' => $this->appid], ['appuri' => $notifyUri]];
        return $this->app->db->name('WechatServiceConfig')->where($where)->update($data) !== false;
    }

    /**
     * 更新接口Appkey(成功返回新的Appkey)
     * @return bool|string
     * @throws \think\db\exception\DbException
     */
    public function updateApiAppkey()
    {
        $data = ['appkey' => md5(uniqid())];
        $this->app->db->name('WechatServiceConfig')->where(['authorizer_appid' => $this->appid])->update($data);
        return $data['appkey'];
    }

    /**
     * 获取公众号的配置参数
     * @param string $name 参数名称
     * @return array|string
     */
    public function config($name = null)
    {
        return WechatService::WeChatScript($this->appid)->config->get($name);
    }

    /**
     * 微信网页授权
     * @param string $sessid 当前会话id(可用session_id()获取)
     * @param string $source 当前会话URL地址(需包含域名的完整URL地址)
     * @param integer $type 网页授权模式(0静默模式,1高级授权)
     * @return array|boolean
     */
    public function oauth($sessid, $source, $type = 0)
    {
        $fans = $this->app->cache->get("{$this->appid}_{$sessid}_fans");
        $openid = $this->app->cache->get("{$this->appid}_{$sessid}_openid");
        if (!empty($openid) && (empty($type) || !empty($fans))) {
            return ['openid' => $openid, 'fans' => $fans, 'url' => ''];
        }
        $mode = empty($type) ? 'snsapi_base' : 'snsapi_userinfo';
        $url = url('@service/api.push/oauth', [], true, true);
        $params = ['mode' => $type, 'sessid' => $sessid, 'enurl' => enbase64url($source)];
        $authurl = WechatService::WeOpenService()->getOauthRedirect($this->appid, $url . '?' . http_build_query($params), $mode);
        return ['openid' => $openid, 'fans' => $fans, 'url' => $authurl];
    }

    /**
     * 微信网页JS签名
     * @param string $url 当前会话URL地址(需包含域名的完整URL地址)
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function jsSign($url)
    {
        return WechatService::WeChatScript($this->appid)->getJsSign($url);
    }
}