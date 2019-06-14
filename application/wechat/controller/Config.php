<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\WechatService;
use library\Controller;
use library\File;

/**
 * 模板配置
 * Class Config
 * @package app\wechat\controller
 */
class Config extends Controller
{
    /**
     * 公众号授权绑定
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function options()
    {
        $this->applyCsrfToken();
        $this->thrNotify = url('@wechat/api.push', '', false, true);
        if ($this->request->isGet()) {
            $this->title = '公众号授权绑定';
            if (!($this->geoip = cache('mygeoip'))) {
                cache('mygeoip', $this->geoip = gethostbyname($this->request->host()), 360);
            }
            $code = encode(url('@admin', '', true, true) . '#' . $this->request->url());
            $this->authurl = config('wechat.service_url') . "/service/api.push/auth/{$code}";
            if ($this->request->has('appid', 'get', true) && $this->request->has('appkey', 'get', true)) {
                sysconf('wechat_type', 'thr');
                sysconf('wechat_thr_appid', input('appid'));
                sysconf('wechat_thr_appkey', input('appkey'));
                WechatService::wechat()->setApiNotifyUri($this->thrNotify);
            }
            try {
                $this->wechat = WechatService::wechat()->getConfig();
            } catch (\Exception $e) {
                $this->wechat = [];
            }
            $this->fetch();
        } else {
            foreach ($this->request->post() as $k => $v) sysconf($k, $v);
            if ($this->request->post('wechat_type') === 'thr') {
                WechatService::wechat()->setApiNotifyUri($this->thrNotify);
            }
            $uri = url('wechat/config/options');
            $this->success('公众号参数获取成功！', url('@admin') . "#{$uri}");
        }
    }

    /**
     * 公众号支付配置
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function payment()
    {
        $this->applyCsrfToken();
        if ($this->request->isGet()) {
            $this->title = '公众号支付配置';
            $file = File::instance('local');
            $this->wechat_mch_ssl_cer = sysconf('wechat_mch_ssl_cer');
            $this->wechat_mch_ssl_key = sysconf('wechat_mch_ssl_key');
            $this->wechat_mch_ssl_p12 = sysconf('wechat_mch_ssl_p12');
            if (!$file->has($this->wechat_mch_ssl_cer, true)) $this->wechat_mch_ssl_cer = '';
            if (!$file->has($this->wechat_mch_ssl_key, true)) $this->wechat_mch_ssl_key = '';
            if (!$file->has($this->wechat_mch_ssl_p12, true)) $this->wechat_mch_ssl_p12 = '';
            $this->fetch();
        } else {
            if ($this->request->post('wechat_mch_ssl_type') === 'p12') {
                if (!($sslp12 = $this->request->post('wechat_mch_ssl_p12'))) {
                    $mchid = $this->request->post('wechat_mch_id');
                    $content = File::instance('local')->get($sslp12, true);
                    if (!openssl_pkcs12_read($content, $certs, $mchid)) {
                        $this->error('商户MCH_ID与支付P12证书不匹配！');
                    }
                }
            }
            foreach ($this->request->post() as $k => $v) sysconf($k, $v);
            $this->success('公众号支付配置成功！');
        }
    }

}