<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use handler\WechatHandler;
use think\Controller;

/**
 * 微信接口控制器
 * Class Api
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 */
class Api extends Controller
{

    /**
     * 微信消息接口
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        if (!extension_loaded('soap')) {
            throw new \Exception('Not support soap.');
        }
        $handler = new WechatHandler();
        $service = new \SoapServer(null, ['uri' => 'api', 'trace' => 0]);
        $service->setObject($handler);
        $service->handle();
    }


}
