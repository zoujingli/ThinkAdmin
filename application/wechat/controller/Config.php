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
        if ($this->request->isGet()) {
            $code = encode(url('@admin', '', true, true) . '#' . $this->request->url());
            $assign = [
                'title'   => '微信接口配置',
                'appuri'  => url("@wechat/api.push", '', true, true),
                'appid'   => $this->request->get('appid', sysconf('wechat_appid')),
                'appkey'  => $this->request->get('appkey', sysconf('wechat_appkey')),
                'authurl' => "http://wm.cuci.cc/wechat/api.push/auth/{$code}.html",
                'wechat'  => WechatService::instance('config')->getConfig(),
            ];
            return $this->fetch('', $assign);
        }
        try {
            sysconf('wechat_appid', $this->request->post('wechat_appid'));
            sysconf('wechat_appkey', $this->request->post('wechat_appkey'));
            $apiurl = $this->request->post('wechat_appurl');
            if (!empty($apiurl)) {
                if (!WechatService::instance('config')->setApiNotifyUri($apiurl)) {
                    $this->error('远程服务端接口更新失败，请稍候再试！');
                }
            }
            LogService::write('微信管理', '修改微信接口参数成功');
        } catch (\Exception $e) {
            $this->error('微信授权保存失败 , 请稍候重试 ! ' . $e->getMessage());
        }
        $this->success('微信授权数据修改成功！', '');
    }

}
