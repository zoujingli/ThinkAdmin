<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

$extra = [];
$extra['请选择微信对接方式，其中微信开放平台授权模式需要微信开放平台支持，还需要搭建第三方服务平台托管系统！'] = 'Please select WeChat docking mode, of which WeChat Open platform authorization mode needs WeChat Open platform support, and a third-party service platform hosting system needs to be built!';
$extra['使用微信开放平台授权模式时，微信将授权给第三方服务平台托管系统，消息数据使用 %s 通信协议转发。'] = 'When using WeChat Open platform authorization mode, WeChat will authorize the third-party service platform hosting system, and the message data will be forwarded using %s communication protocol.';
$extra['使用微信公众平台直接模式时，需要在微信公众号平台配置授权IP及网页授权域名，将公众号平台获取到的参数填写到下面。'] = 'When using the direct mode of the WeChat public platform, you need to configure the authorized IP and web page authorized domain name on the WeChat official account platform, and fill in the parameters obtained by the official account platform below.';

return array_merge($extra, [
    '微信公众平台直接模式' => 'WeChat public platform direct mode',
    '微信开放平台授权模式' => 'WeChat Open platform authorization mode'
]);