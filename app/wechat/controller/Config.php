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

namespace app\wechat\controller;

use app\wechat\service\WechatService;
use think\admin\Controller;
use think\admin\storage\LocalStorage;

/**
 * 微信授权绑定
 * Class Config
 * @package app\wechat\controller
 */
class Config extends Controller
{
    /**
     * 微信授权配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function options()
    {
        $this->_applyFormToken();
        $this->thrNotify = sysuri('wechat/api.push/index', [], false, true);
        if ($this->request->isGet()) {
            try {
                $source = enbase64url(sysuri('admin/index/index', [], false, true) . '#' . $this->request->url());
                $this->authurl = "https://open.cuci.cc/service/api.push/auth?source={$source}";
                if (input('?appid') && input('?appkey')) {
                    sysconf('wechat.type', 'thr');
                    sysconf('wechat.thr_appid', input('appid'));
                    sysconf('wechat.thr_appkey', input('appkey'));
                    WechatService::ThinkServiceConfig()->setApiNotifyUri($this->thrNotify);
                }
                $this->wechat = WechatService::ThinkServiceConfig()->getConfig();
            } catch (\Exception $exception) {
                $this->wechat = [];
                $this->message = $exception->getMessage();
            }
            $this->geoip = $this->app->cache->get('mygeoip', '');
            if (empty($this->geoip)) {
                $this->geoip = gethostbyname($this->request->host());
                $this->app->cache->set('mygeoip', $this->geoip, 360);
            }
            $this->title = '微信授权配置';
            $this->fetch();
        } else {
            foreach ($this->request->post() as $k => $v) sysconf($k, $v);
            if ($this->request->post('wechat.type') === 'thr') {
                try {
                    WechatService::ThinkServiceConfig()->setApiNotifyUri($this->thrNotify);
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }
            sysoplog('微信授权配置', '修改微信授权配置成功');
            $location = url('wechat/config/options')->build() . '?uniqid=' . uniqid();
            $this->success('微信参数修改成功！', sysuri('admin/index/index') . "#{$location}");
        }
    }

    /**
     * 微信授权测试
     * @auth true
     */
    public function options_test()
    {
        $this->fetch();
    }

    /**
     * 微信支付配置
     * @auth true
     * @menu true
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function payment()
    {
        if ($this->request->isGet()) {
            $this->title = '微信支付配置';
            $local = LocalStorage::instance();
            $this->mch_ssl_cer = sysconf('wechat.mch_ssl_cer');
            $this->mch_ssl_key = sysconf('wechat.mch_ssl_key');
            $this->mch_ssl_p12 = sysconf('wechat.mch_ssl_p12');
            if (!$local->has($this->mch_ssl_cer, true)) $this->mch_ssl_cer = '';
            if (!$local->has($this->mch_ssl_key, true)) $this->mch_ssl_key = '';
            if (!$local->has($this->mch_ssl_p12, true)) $this->mch_ssl_p12 = '';
            $this->fetch();
        } else {
            $this->error('抱歉，数据提交地址错误！');
        }
    }

    /**
     * 微信支付测试
     * @auth true
     */
    public function payment_test()
    {
        $this->fetch();
    }

    /**
     * 微信支付修改
     * @auth true
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function payment_save()
    {
        if ($this->request->isPost()) {
            if ($this->request->post('wechat.mch_ssl_type') === 'p12') {
                if (!LocalStorage::instance()->has(input('wechat.mch_ssl_p12', '-'), true)) {
                    $this->error('商户证书 P12 证书不能为空！');
                }
                $content = LocalStorage::instance()->get(input('wechat.mch_ssl_p12', '-'), true);
                if (!openssl_pkcs12_read($content, $certs, input('wechat.mch_id'))) {
                    $this->error('商户账号与 P12 证书不匹配！');
                }
            } elseif ($this->request->post('wechat.mch_ssl_type') === 'pem') {
                if (!LocalStorage::instance()->has(input('wechat.mch_ssl_key', '-'), true)) {
                    $this->error('商户证书 KEY 不能为空！');
                }
                if (!LocalStorage::instance()->has(input('wechat.mch_ssl_cer', '-'), true)) {
                    $this->error('商户证书 CERT 不能为空！');
                }
            }
            foreach ($this->request->post() as $k => $v) sysconf($k, $v);
            sysoplog('微信授权配置', '修改微信支付配置成功');
            $this->success('微信支付配置成功！');
        } else {
            $this->error('抱歉，访问方式错误！');
        }
    }

}
