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

namespace app\wechat\controller;

use controller\BasicAdmin;
use service\LogService;
use service\WechatService;
use think\Exception;

/**
 * 微信配置管理
 * Class Config
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Config extends BasicAdmin
{

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'SystemConfig';

    /**
     * 微信基础参数配置
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $thrNotifyUrl = url('@wechat/api.push', '', true, true);
        if ($this->request->isGet()) {
            $code = encode(url('@admin', '', true, true) . '#' . $this->request->url());
            $data = [
                'title'   => '微信接口配置',
                'appid'   => $this->request->get('appid', sysconf('wechat_thr_appid')),
                'appkey'  => $this->request->get('appkey', sysconf('wechat_thr_appkey')),
                'authurl' => config('wechat.service_url') . "/wechat/api.push/auth/{$code}.html",
            ];
            if ($this->request->get('appid', false)) {
                sysconf('wechat_thr_appid', $data['appid']);
                sysconf('wechat_thr_appkey', $data['appkey']);
                sysconf('wechat_type', 'thr');
                WechatService::config()->setApiNotifyUri($thrNotifyUrl);
            }
            try {
                $data['wechat'] = WechatService::config()->getConfig();
            } catch (Exception $e) {
                $data['wechat'] = [];
            }
            return $this->fetch('', $data);
        }
        try {
            // 接口对接类型
            sysconf('wechat_type', $this->request->post('wechat_type'));
            // 直接参数对应
            sysconf('wechat_token', $this->request->post('wechat_token'));
            sysconf('wechat_appid', $this->request->post('wechat_appid'));
            sysconf('wechat_appsecret', $this->request->post('wechat_appsecret'));
            sysconf('wechat_encodingaeskey', $this->request->post('wechat_encodingaeskey'));
            // 第三方平台配置
            sysconf('wechat_thr_appid', $this->request->post('wechat_thr_appid'));
            sysconf('wechat_thr_appkey', $this->request->post('wechat_thr_appkey'));
            // 第三方平台时设置远程平台通知接口
            if ($this->request->post('wechat_type') === 'thr') {
                if (!WechatService::config()->setApiNotifyUri($thrNotifyUrl)) {
                    $this->error('远程服务端接口更新失败，请稍候再试！');
                }
            }
            LogService::write('微信管理', '修改微信接口参数成功');
        } catch (\Exception $e) {
            $this->error('微信授权保存成功, 但授权验证失败 ! <br>' . $e->getMessage());
        }
        $this->success('微信授权数据修改成功！', url('@admin') . "#" . url('@wechat/config/index'));
    }

}
