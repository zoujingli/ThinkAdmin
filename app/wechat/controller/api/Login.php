<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\WechatService;
use think\admin\Controller;

/**
 * 微信扫码授权登录
 * Class Login
 * @package app\wechat\controller\api
 */
class Login extends Controller
{
    /**
     * 数据缓存时间
     * @var integer
     */
    protected $expire = 3600;

    /**
     * 授权码前缀
     * @var string
     */
    protected $prefix = 'wxlogin';


    /**
     * 扫描显示二维码
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     * @throws \think\exception\HttpResponseException
     */
    public function qrc()
    {
        $mode = intval(input('mode', '0'));
        $code = $this->prefix . md5(uniqid('t', true) . rand(10000, 99999));
        $text = url('wechat/api.login/oauth', [], false, true) . "?code={$code}&mode={$mode}";
        // 生成二维码并返回结果
        $qrcode = new \Endroid\QrCode\QrCode();
        $qrcode->setText($text)->setSize(300)->setPadding(20);
        $content = base64_encode($qrcode->setImageType('png')->get());
        $this->success('获取二维码成功', ['code' => $code, 'image' => "data:image/png;base64,{$content}"]);
    }

    /**
     * 微信授权结果处理
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function oauth()
    {
        $this->code = input('code', '');
        $this->mode = input('mode', '0');
        if (stripos($this->code, $this->prefix) === 0) {
            $this->url = $this->request->url(true);
            $this->fans = WechatService::instance()->getWebOauthInfo($this->url, $this->mode);
            if (is_array($this->fans) && isset($this->fans['openid'])) {
                $this->fans['token'] = md5(uniqid('t', true) . rand(10000, 99999));
                $this->app->cache->set("wxlog_{$this->code}", $this->fans, $this->expire);
                $this->app->cache->set($this->fans['openid'], $this->fans['token'], $this->expire);
                $this->message = '授权成功';
                $this->fetch('success');
            } else {
                $this->message = '授权失败';
                $this->fetch('failed');
            }
        } else {
            $this->message = '授权失败';
            $this->fetch('failed');
        }
    }

    /**
     * 获取授权信息
     * 用定时器请求这个接口
     * @throws \think\exception\HttpResponseException
     */
    public function query()
    {
        $this->code = input('code', '');
        if (stripos($this->code, $this->prefix) === 0) {
            $this->ckey = "wxlog_{$this->code}";
            $this->fans = $this->app->cache->get($this->ckey, new \stdClass());
            $this->success('获取授权信息', $this->fans);
        } else {
            $this->error("授权CODE不能为空！");
        }
    }
}