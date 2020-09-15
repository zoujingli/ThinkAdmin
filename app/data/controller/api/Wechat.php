<?php

namespace app\data\controller\api;

use app\data\service\UserService;
use app\wechat\service\WechatService;
use think\admin\Controller;
use think\Response;

/**
 * 微信服务号入口
 * Class Wechat
 * @package app\data\controller\api
 * @example 域名请修改为自己的地址，放到网页代码合适位置
 * <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
 * <script src="https://v6.thinkadmin.top/data/api.wechat/jssdk?mode=1"></script>
 * 授权模式支持两种模块，参数 mode=0 时为静默授权，mode=1 时为完整授权
 * 注意：回跳地址默认从 Header 中的 http_referer 获取，也可以传 source 参数
 */
class Wechat extends Controller
{
    /**
     * 授权模式
     * @var int
     */
    protected $mode;

    /**
     * 来源地址
     * @var string
     */
    protected $source;

    /**
     * 粉丝OPNEID
     * @var string
     */
    protected $openid;

    /**
     * 网页授权配置
     * @var array
     */
    protected $config;

    /**
     * 微信粉丝数据
     * @var array
     */
    protected $fansInfo;
    /**
     * 会员用户数据
     * @var array
     */
    protected $userInfo;

    /**
     * 加载对应JSSDK数据
     * @return \think\Response
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function jssdk()
    {
        $wechat = WechatService::instance();
        $this->mode = $this->request->get('mode', 1);
        $this->source = $this->request->server('http_referer', $this->request->get('source', ''));
        $user = $wechat->getWebOauthInfo($this->source ?: $this->request->url(true), $this->mode, false);
        if (empty($user['openid'])) {
            $content = 'alert("Wechat WebOauth failed.")';
        } else {
            $this->openid = $user['openid'];
            $this->config = $wechat->getWebJssdkSign($this->source);
            $this->fansInfo = $user['fansinfo'] ?? [];
            // 会员注册并登录生成接口令牌
            $data = $this->fansInfo;
            $data['openid2'] = $data['openid'];
            $data['base_sex'] = ['未知', '男', '女'][$data['sex']] ?? '未知';
            if (isset($data['headimgurl'])) $data['headimg'] = $data['headimgurl'];
            $map = isset($data['unionid']) ? ['unionid' => $data['unionid']] : ['openid2' => $this->openid];
            $this->userInfo = UserService::instance()->save($map, array_merge($map, $data), true);
            $content = $this->_buildContent();
        }
        return Response::create($content)->contentType('application/x-javascript');
    }

    /**
     * 生成JOSN数据
     * @param mixed $data
     * @return false|string
     */
    private function _jsonEncode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * 生成授权内容
     * @return string
     */
    private function _buildContent()
    {
        return <<<EOF
if (typeof wx === 'object') {
    wx.openid="{$this->openid}";
    wx.config({$this->_jsonEncode($this->config)});
    wx.fansinfo={$this->_jsonEncode($this->fansInfo)};
    wx.userinfo={$this->_jsonEncode($this->userInfo)};
    wx.ready(function(){
        wx.hideOptionMenu();
        wx.hideAllNonBaseMenuItem();
    });
}
EOF;
    }

}