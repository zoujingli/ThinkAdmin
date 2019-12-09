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

namespace app\service\controller\api;

use app\service\service\WechatService;
use think\admin\Controller;
use think\Exception;

/**
 * 接口获取实例化
 * Class Client
 * @package app\service\controller\api
 */
class Client extends Controller
{
    /**
     * YAR 接口标准对接
     * @return string
     */
    public function yar()
    {
        try {
            $service = new \Yar_Server($this->instance());
            $service->handle();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * SOAP 接口标准对接
     * @return string
     */
    public function soap()
    {
        try {
            $service = new \SoapServer(null, ['uri' => 'thinkadmin']);
            $service->setObject($this->instance());
            $service->handle();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * 远程获取实例对象
     * @return mixed|\Exception
     */
    private function instance()
    {
        try {
            $data = json_decode(debase64url(input('token', '')), true);
            list($class, $appid, $time, $nostr, $sign) = [$data['class'], $data['appid'], $data['time'], $data['nostr'], $data['sign']];
            $wechat = $this->app->db->name('WechatServiceConfig')->where(['authorizer_appid' => $appid])->find();
            if (empty($wechat)) throw new Exception("抱歉，该公众号{$appid}未授权！");
            if (abs(time() - $data['time']) > 10) throw new Exception('抱歉，接口调用时差过大！');
            if (md5("{$class}#{$appid}#{$wechat['appkey']}#{$time}#{$nostr}") !== $sign) {
                throw new Exception("抱歉，该公众号{$appid}签名异常！");
            }
            return WechatService::__callStatic($class, [$appid]);
        } catch (\Exception $exception) {
            return new \Exception($exception->getMessage(), 404);
        }
    }
}
