<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\extend;

/**
 * 物流信息查询扩展
 * Class ExpressExtend
 * @package think\admin\extend
 */
class ExpressExtend
{
    /**
     * 通过百度快递100应用查询物流信息
     * @param string $code 快递公司编辑
     * @param string $number 快递物流编号
     * @return array
     */
    public static function express($code, $number)
    {
        $list = [];
        for ($i = 0; $i < 6; $i++) if (is_array($result = self::doExpress($code, $number))) {
            if (!empty($result['data']['info']['context'])) {
                foreach ($result['data']['info']['context'] as $vo) $list[] = [
                    'time' => date('Y-m-d H:i:s', $vo['time']), 'context' => $vo['desc'],
                ];
                return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $list];
            }
        }
        return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $list];
    }

    /**
     * 执行百度快递100应用查询请求
     * @param string $code 快递公司编号
     * @param string $number 快递单单号
     * @return mixed
     */
    private static function doExpress($code, $number)
    {
        list($microtime, $clientIp) = [time(), app()->request->ip()];
        $url = "https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?cb=callback&appid=4001&com={$code}&nu={$number}&vcode=&token=&_={$microtime}";
        $options = ['cookie_file' => app()->getRuntimePath() . 'temp/cookie', 'headers' => ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $clientIp, 'X-FORWARDED-FOR' => $clientIp],];
        return json_decode(str_replace('/**/callback(', '', trim(http_get($url, [], $options), ')')), true);
    }
}