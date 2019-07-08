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

namespace app\service\handler;

use app\service\service\WechatService as WechatLogic;
use think\Db;

/**
 * 微信网页授权接口
 * Class WechatHandler
 * @package app\wechat\handler
 * @author Anyon <zoujingli@qq.com>
 */
class WechatHandler
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
     * 错误消息
     * @var string
     */
    protected $message;

    /**
     * Wechat constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->appid = isset($config['authorizer_appid']) ? $config['authorizer_appid'] : '';
    }

    /**
     * 检查微信配置服务初始化状态
     * @return boolean
     * @throws \think\Exception
     */
    private function checkInit()
    {
        if (!empty($this->config)) return true;
        throw new \think\Exception('Wechat Please bind Wechat first');
    }

    /**
     * 获取当前公众号配置
     * @return array|boolean
     * @throws \think\Exception
     */
    public function getConfig()
    {
        $this->checkInit();
        $info = Db::name('WechatServiceConfig')->where(['authorizer_appid' => $this->appid])->find();
        if (empty($info)) return false;
        if (isset($info['id'])) unset($info['id']);
        return $info;
    }

    /**
     * 设置微信接口通知URL地址
     * @param string $notifyUri 接口通知URL地址
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function setApiNotifyUri($notifyUri)
    {
        $this->checkInit();
        if (empty($notifyUri)) throw new \think\Exception('请传入微信通知URL');
        list($where, $data) = [['authorizer_appid' => $this->appid], ['appuri' => $notifyUri]];
        return Db::name('WechatServiceConfig')->where($where)->update($data) !== false;
    }

    /**
     * 更新接口Appkey(成功返回新的Appkey)
     * @return bool|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateApiAppkey()
    {
        $this->checkInit();
        $data = ['appkey' => md5(uniqid())];
        Db::name('WechatServiceConfig')->where(['authorizer_appid' => $this->appid])->update($data);
        return $data['appkey'];
    }

    /**
     * 获取公众号的配置参数
     * @param string $name 参数名称
     * @return array|string
     * @throws \think\Exception
     */
    public function config($name = null)
    {
        $this->checkInit();
        return WechatLogic::WeChatScript($this->appid)->config->get($name);
    }

    /**
     * 微信网页授权
     * @param string $sessid 当前会话id(可用session_id()获取)
     * @param string $selfUrl 当前会话URL地址(需包含域名的完整URL地址)
     * @param int $fullMode 网页授权模式(0静默模式,1高级授权)
     * @return array|bool
     * @throws \think\Exception
     */
    public function oauth($sessid, $selfUrl, $fullMode = 0)
    {
        $this->checkInit();
        $fans = cache("{$this->appid}_{$sessid}_fans");
        $openid = cache("{$this->appid}_{$sessid}_openid");
        if (!empty($openid) && (empty($fullMode) || !empty($fans))) {
            return ['openid' => $openid, 'fans' => $fans, 'url' => ''];
        }
        $service = WechatLogic::service();
        $mode = empty($fullMode) ? 'snsapi_base' : 'snsapi_userinfo';
        $url = url('@service/api.push/oauth', '', true, true);
        $params = ['mode' => $fullMode, 'sessid' => $sessid, 'enurl' => encode($selfUrl)];
        $authurl = $service->getOauthRedirect($this->appid, $url . '?' . http_build_query($params), $mode);
        return ['openid' => $openid, 'fans' => $fans, 'url' => $authurl];
    }

    /**
     * 微信网页JS签名
     * @param string $url 当前会话URL地址(需包含域名的完整URL地址)
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     */
    public function jsSign($url)
    {
        $this->checkInit();
        return WechatLogic::WeChatScript($this->appid)->getJsSign($url);
    }

}
