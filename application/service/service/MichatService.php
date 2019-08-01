<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\service\service;

use library\tools\Http;
use think\Exception;

/**
 * 小米消息服务
 * Class MichatService
 * @package app\service\service
 */
class MichatService
{
    const URI = 'https://mimc.chat.xiaomi.net';

    const BIZ_TYPE_PING = 'PING';
    const BIZ_TYPE_POND = 'PONG';
    const BIZ_TYPE_TEXT = 'TEXT';
    const BIZ_TYPE_PIC_FILE = 'PIC_FILE';
    const BIZ_TYPE_BIN_FILE = 'BIN_FILE';
    const BIZ_TYPE_AUDIO_FILE = 'AUDIO_FILE';
    const MSG_TYPE_BASE64 = 'base64';

    /**
     * 给指定账号推送消息内容
     * @param string $from 消息来源
     * @param string $to 消息目标
     * @param string $message 消息内容
     * @return bool|string
     * @throws Exception
     * @throws \think\exception\PDOException
     */
    public static function push($from, $to, $message)
    {
        return self::post('/api/push/p2p/', [
            'appId'        => sysconf('michat_appid'),
            'appKey'       => sysconf('michat_appkey'),
            'appSecret'    => sysconf('michat_appsecert'),
            'fromAccount'  => $from,
            'fromResource' => $from,
            'toAccount'    => $to,
            'msg'          => base64_encode($message),
            'msgType'      => 'base64',
            'bizType'      => '',
            'isStore'      => false,
        ]);
    }

    /**
     * POST提交消息数据
     * @param string $api 接口地址
     * @param array $data 接口数据
     * @return bool|string
     * @throws Exception
     */
    private static function post($api, array $data)
    {
        $result = json_decode(Http::request('post', self::URI . $api, [
            'data'    => json_encode($data, JSON_UNESCAPED_UNICODE),
            'headers' => ['Content-Type: application/json'],
        ]), true);
        if (isset($result['code']) && intval($result['code']) === 200) {
            return $result['data'];
        } else {
            throw new Exception($result['message'], $result['code']);
        }
    }

}
