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
 * <script src="https://your.domain.com/data/api.wechat/oauth?mode=1"></script>
 *
 * 授权模式支持两种模块，参数 mode=0 时为静默授权，mode=1 时为完整授权
 * 注意：回跳地址默认从 Header 中的 http_referer 获取，也可以传 source 参数
 */
class Wechat extends Controller
{

    /**
     * 接口认证类型
     * @var string
     */
    private $type = UserService::APITYPE_WECHAT;

    /**
     * 唯一绑定字段
     * @var string
     */
    private $field;

    /**
     * 控制器初始化
     * @return $this
     */
    protected function initialize(): Wechat
    {
        if (empty(UserService::TYPES[$this->type]['auth'])) {
            $this->error("接口类型[{$this->type}]没有定义规则");
        } else {
            $this->field = UserService::TYPES[$this->type]['auth'];
        }
        return $this;
    }

    /**
     * 获取 JSSDK 签名
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function jssdk()
    {
        $url = input('source') ?: $this->request->server('http_referer');
        $this->success('获取签名参数', WechatService::instance()->getWebJssdkSign($url));
    }

    /**
     * 加载网页授权数据
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function oauth(): Response
    {
        [$script, $wechat] = [[], WechatService::instance()];
        $source = input('source') ?: $this->request->server('http_referer');
        $result = $wechat->getWebOauthInfo($source ?: $this->request->url(true), input('mode', 1), false);
        if (empty($result['openid'])) {
            $script[] = 'alert("Wechat WebOauth failed.")';
        } else {
            $data = $result['fansinfo'] ?? [];
            $data['openid2'] = $data['openid'];
            $data['base_sex'] = ['未知', '男', '女'][$data['sex']] ?? '未知';
            if (isset($data['headimgurl'])) $data['headimg'] = $data['headimgurl'];
            $map = isset($data['unionid']) ? ['unionid' => $data['unionid']] : [$this->field => $result['openid']];
            $result['userinfo'] = UserService::instance()->set($map, array_merge($map, $data), $this->type, true);
            $script[] = "window.WeChatOpenid='{$result['openid']}'";
            $script[] = 'window.WeChatFansInfo=' . json_encode($result['fansinfo'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $script[] = 'window.WeChatUserInfo=' . json_encode($result['userinfo'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $script[] = '';
        return Response::create(join(";\n", $script))->contentType('application/x-javascript');
    }
}