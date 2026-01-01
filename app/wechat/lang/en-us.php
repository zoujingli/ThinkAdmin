<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

declare (strict_types=1);

$extra = [];
$extra['请选择微信对接方式，其中微信开放平台授权模式需要微信开放平台支持，还需要搭建第三方服务平台托管系统！'] = 'Please select WeChat docking mode, of which WeChat Open platform authorization mode needs WeChat Open platform support, and a third-party service platform hosting system needs to be built!';
$extra['使用微信开放平台授权模式时，微信将授权给第三方服务平台托管系统，消息数据使用 %s 通信协议转发。'] = 'When using WeChat Open platform authorization mode, WeChat will authorize the third-party service platform hosting system, and the message data will be forwarded using %s communication protocol.';
$extra['使用微信公众平台直接模式时，需要在微信公众号平台配置授权IP及网页授权域名，将公众号平台获取到的参数填写到下面。'] = 'When using the direct mode of the WeChat public platform, you need to configure the authorized IP and web page authorized domain name on the WeChat official account platform, and fill in the parameters obtained by the official account platform below.';

return array_merge($extra, [
    '微信公众平台直接模式' => 'WeChat public platform direct mode',
    '微信开放平台授权模式' => 'WeChat Open platform authorization mode',
    
    // 粉丝管理
    '拉入黑名单'            => 'Add to Blacklist',
    '移出黑名单'            => 'Remove from Blacklist',
    '清空用户数据'          => 'Clear User Data',
    '同步用户数据'          => 'Sync User Data',
    '确定要清空所有用户数据吗？' => 'Are you sure you want to clear all user data?',
    '确定要创建同步用户数据的后台任务？' => 'Are you sure you want to create a background task to sync user data?',
    '微信昵称'              => 'WeChat Nickname',
    '所在区域'              => 'Location',
    '性别'                  => 'Gender',
    '使用语言'              => 'Language',
    '订阅状态'              => 'Subscription Status',
    '订阅时间'              => 'Subscription Time',
    '是否黑名单'            => 'Blacklist Status',
    '已订阅'                => 'Subscribed',
    '未订阅'                => 'Unsubscribed',
    '男'                    => 'Male',
    '女'                    => 'Female',
    '未知'                  => 'Unknown',
    '操作面板'              => 'Actions',
    '头像'                  => 'Avatar',
    '请输入微信昵称'        => 'Please enter WeChat nickname',
    '显示未订阅的粉丝'      => 'Show Unsubscribed Fans',
    '显示已订阅的粉丝'      => 'Show Subscribed Fans',
    '拉黑状态'              => 'Blacklist Status',
    '显示未拉黑的粉丝'      => 'Show Non-Blacklisted Fans',
    '显示已拉黑的粉丝'      => 'Show Blacklisted Fans',
    '请选择订阅时间'        => 'Please select subscription time',
    '微信粉丝数据'          => 'WeChat Fans Data',
    '所在国家'              => 'Country',
    '所在省份'              => 'Province',
    '所在城市'              => 'City',
    '是否拉黑'              => 'Is Blacklisted',
    '已拉黑'                => 'Blacklisted',
    '未拉黑'                => 'Not Blacklisted',
    
    // 配置
    '绑定小程序'            => 'Bind Mini Program',
    '开放平台接口配置'      => 'Open Platform Interface Configuration',
    '开放平台接口'          => 'Open Platform Interface',
    '微信授权测试（ 扫码 ）' => 'WeChat Authorization Test (Scan Code)',
    '微信授权测试'          => 'WeChat Authorization Test',
    '微信支付测试'          => 'WeChat Payment Test',
    '温馨提示：'            => 'Tips: ',
    '微信商户参数配置，此处交易的商户号需要与微信公众号对接的公众号 APPID 匹配。' => 'WeChat merchant parameter configuration. The merchant number used here needs to match the official account APPID connected to the WeChat official account.',
    '微信商户账号'          => 'WeChat Merchant Account',
    '请输入微信商户账号（必填）' => 'Please enter WeChat merchant account (required)',
    '微信商户账号，需要在微信商户平台获取' => 'WeChat merchant account needs to be obtained from WeChat merchant platform',
    '微信 V2 接口密钥'      => 'WeChat V2 Interface Key',
    '微信商户V2密钥'        => 'WeChat Merchant V2 Key',
    '请输入微信商户V2密钥（必填）' => 'Please enter WeChat merchant V2 key (required)',
    '微信商户 V2 密钥，需要在微信商户平台获取商户接口密钥' => 'WeChat merchant V2 key needs to be obtained from WeChat merchant platform',
    '微信 V3 接口密钥'       => 'WeChat V3 Interface Key',
    '微信商户V3密钥'         => 'WeChat Merchant V3 Key',
    '请输入微信商户V3密钥（必填）' => 'Please enter WeChat merchant V3 key (required)',
    '微信商户 V3 密钥，需要在微信商户平台获取商户接口密钥' => 'WeChat merchant V3 key needs to be obtained from WeChat merchant platform',
    '微信 V3 支付公钥ID'     => 'WeChat V3 Payment Public Key ID',
    '微信商户V3支付公钥ID'   => 'WeChat Merchant V3 Payment Public Key ID',
    '请输入微信商户V3支付公钥ID（必填）' => 'Please enter WeChat merchant V3 payment public key ID (required)',
    '微信商户 V3 支付证书ID，需要在微信商户平台操作设置操作密码并获取商户接口密钥' => 'WeChat merchant V3 payment certificate ID needs to be set in WeChat merchant platform and merchant interface key needs to be obtained',
    '微信 V3 支付公钥文件'   => 'WeChat V3 Payment Public Key File',
    '上传微信支付公钥'      => 'Upload WeChat Payment Public Key',
    '微信商户证书文件'       => 'WeChat Merchant Certificate File',
    '请选择需要上传证书类型，上传 P12 证书会自动转换为 PEM 证书。' => 'Please select the certificate type to upload. Uploading P12 certificate will automatically convert to PEM certificate.',
    '保存配置'              => 'Save Configuration',
    '微信商户支付测试配置'   => 'WeChat Merchant Payment Test Configuration',
    'JSAPI 支付测试需要在微信商户平台配置支付目录：' => 'JSAPI payment test requires configuring payment directory in WeChat merchant platform: ',
    '扫码支付①需要在微信商户平台配置支付通知地址：' => 'Scan code payment ① requires configuring payment notification address in WeChat merchant platform: ',
    
    // 菜单管理
    '公众号'                => 'Official Account',
    '菜单编辑'              => 'Menu Editor',
    '请在左侧创建菜单...'   => 'Please create menu on the left...',
    '菜单名称'              => 'Menu Name',
    '请输入菜单名称'        => 'Please enter menu name',
    '字数不超过13个汉字或40个字母' => 'No more than 13 Chinese characters or 40 letters',
    '菜单类型'              => 'Menu Type',
]);