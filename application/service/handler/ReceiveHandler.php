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

namespace app\service\handler;

use app\service\service\WechatService;
use think\Db;

/**
 * 微信推送消息处理
 *
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/27 14:14
 */
class ReceiveHandler
{

    /**
     * 事件初始化
     * @param string $appid
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public static function handler($appid)
    {
        try {
            $wechat = WechatService::WeChatReceive($appid);
        } catch (\Exception $e) {
            return "Wechat message handling failed, {$e->getMessage()}";
        }
        // 验证微信配置信息
        $config = Db::name('WechatServiceConfig')->where(['authorizer_appid' => $appid])->find();
        if (empty($config) || empty($config['appuri'])) {
            \think\facade\Log::error(($message = "微信{$appid}授权配置验证无效"));
            return $message;
        }
        try {
            list($data, $openid) = [$wechat->getReceive(), $wechat->getOpenid()];
            if (isset($data['EventKey']) && is_object($data['EventKey'])) $data['EventKey'] = (array)$data['EventKey'];
            $input = ['openid' => $openid, 'appid' => $appid, 'receive' => serialize($data), 'encrypt' => intval($wechat->isEncrypt())];
            if (is_string($result = http_post($config['appuri'], $input, ['timeout' => 30]))) {
                if (is_array($json = json_decode($result, true))) {
                    return $wechat->reply($json, true, $wechat->isEncrypt());
                } else {
                    return $result;
                }
            }
        } catch (\Exception $e) {
            \think\facade\Log::error("微信{$appid}接口调用异常，{$e->getMessage()}");
        }
        return 'success';
    }

}
