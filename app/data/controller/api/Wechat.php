<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\controller\api;

use app\data\service\UserAdminService;
use app\wechat\service\WechatService;
use think\admin\Controller;
use think\Response;

/**
 * 微信服务号入口
 * Class Wechat
 * @package app\data\controller\api
 * @example 域名请修改为自己的地址，放到网页代码合适位置
 * <meta name="referrer" content="always">
 * <script referrerpolicy="unsafe-url" src="https://your.domain.com/data/api.wechat/oauth?mode=1"></script>
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
    private $type = UserAdminService::API_TYPE_WECHAT;

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
        if (empty(UserAdminService::TYPES[$this->type]['auth'])) {
            $this->error("接口类型[{$this->type}]没有定义规则");
        } else {
            $this->field = UserAdminService::TYPES[$this->type]['auth'];
        }
        return $this;
    }

    /**
     * 获取 JSSDK 签名
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
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
     * @return Response
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function oauth(): Response
    {
        $source = input('source') ?: $this->request->server('http_referer');
        [$mode, $script, $wechat] = [input('mode', 1), [], WechatService::instance()];
        $result = $wechat->getWebOauthInfo($source ?: $this->request->url(true), $mode, false);
        if (empty($result['openid'])) {
            $script[] = 'alert("Wechat WebOauth failed.")';
        } else {
            $data = $result['fansinfo'] ?? [];
            $data[$this->field] = $data['openid'];
            $data['base_sex'] = ['未知', '男', '女'][$data['sex']] ?? '未知';
            if (isset($result['unionid'])) $data['unionid'] = $result['unionid'];
            if (isset($data['headimgurl'])) $data['headimg'] = $data['headimgurl'];
            $map = UserAdminService::getUserUniMap($this->field, $data[$this->field], $data['unionid'] ?? '');
            $result['userinfo'] = UserAdminService::set($map, array_merge($map, $data), $this->type, true);
            $script[] = "window.WeChatOpenid='{$result['openid']}'";
            $script[] = 'window.WeChatFansInfo=' . json_encode($result['fansinfo'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $script[] = 'window.WeChatUserInfo=' . json_encode($result['userinfo'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $script[] = '';
        return Response::create(join(";\n", $script))->contentType('application/x-javascript');
    }

    /**
     * 网页授权测试
     * 使用网页直接访问此链接
     * @return string
     */
    public function otest(): string
    {
        return <<<EOL
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>微信网页授权测试</title>
        <meta name="referrer" content="always">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <style>pre{padding:20px;overflow:auto;margin-top:10px;background:#ccc;border-radius:6px;}</style>
    </head>
    <body>
        <div>当前链接</div>
        <pre>{$this->request->scheme()}://{$this->request->host()}/data/api.wechat/oauth?mode=1</pre>
        
        <div style="margin-top:30px">粉丝数据</div>
        <pre id="fansdata">待网页授权，加载粉丝数据...</pre>
        
        <div style="margin-top:30px">用户数据</div>
        <pre id="userdata">待网页授权，加载用户数据...</pre>
        
        <script referrerpolicy="unsafe-url" src="//{$this->request->host()}/data/api.wechat/oauth?mode=1"></script>
        <script>
            if(typeof window.WeChatFansInfo === 'object'){   
                document.getElementById('fansdata').innerText = JSON.stringify(window.WeChatFansInfo, null, 2);
            }
            if(typeof window.WeChatUserInfo === 'object'){
                document.getElementById('userdata').innerText = JSON.stringify(window.WeChatUserInfo, null, 2);
            }
        </script>
    </body>
</html>
EOL;
    }
}