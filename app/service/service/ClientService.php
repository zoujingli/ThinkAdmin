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

/**
 * Class ClientService
 * @package app\service\serivce
 */
class ClientService extends WechatService
{
    /**
     * 静态调用对象
     * @param string $name 请求的类名
     * @param array $arguments 调用参数
     * @return mixed
     * @throws \think\Exception
     * @throws \SoapFault
     */
    public static function __callStatic($name, $arguments)
    {
        if (count($arguments) !== 2) {
            throw new \think\Exception('请按顺序传入APPID及APPKEY两个参数！');
        }
        list($appid, $appkey) = $arguments;
        $data = ['class' => $name, 'appid' => $appid, 'time' => time(), 'nostr' => uniqid()];
        $data['sign'] = md5("{$data['class']}#{$appid}#{$appkey}#{$data['time']}#{$data['nostr']}");
        $token = enbase64url(json_encode($data, JSON_UNESCAPED_UNICODE));
        if (class_exists('Yar_Client')) {
            $url = "http://127.0.0.1:1231/service/api.client/yar?not_init_session=1&token={$token}";
            $client = new \Yar_Client($url);
        } else {
            $url = "http://127.0.0.1:1231/service/api.client/soap?not_init_session=1&token={$token}";
            $client = new \SoapClient(null, ['location' => $url, 'uri' => "thinkadmin"]);
        }
        try {
            $exception = new \think\Exception($client->getMessage(), $client->getCode());
        } catch (\Exception $exception) {
            $exception = null;
        }
        if ($exception instanceof \Exception) {
            throw $exception;
        }
        return $client;
    }

}