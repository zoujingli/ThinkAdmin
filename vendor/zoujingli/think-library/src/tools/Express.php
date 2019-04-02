<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

/**
 * 快递100查询接口
 * Class Express
 * @package library\tools
 */
class Express
{
    /**
     * 通用物流单查询
     * @param string $code 快递物流编号
     * @return array
     */
    public static function auto($code)
    {
        list($result, $client_ip) = [[], request()->ip()];
        $header = ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $client_ip, 'X-FORWARDED-FOR' => $client_ip];
        $autoResult = Http::get("http://www.kuaidi100.com/autonumber/autoComNum?text={$code}", [], ['header' => $header, 'timeout' => 30]);
        foreach (json_decode($autoResult)->auto as $vo) {
            $item = self::query($vo->comCode, $code);
            if (!empty($item) && $item['message'] === 'ok') $result[$vo->comCode] = $item;
        }
        return $result;
    }

    /**
     * 查询物流信息
     * @param string $express_code 快递公司编辑
     * @param string $express_no 快递物流编号
     * @return array
     */
    public static function query($express_code, $express_no)
    {
        list($microtime, $client_ip) = [microtime(true), request()->ip()];
        $header = ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $client_ip, 'X-FORWARDED-FOR' => $client_ip];
        $location = "http://www.kuaidi100.com/query?type={$express_code}&postid={$express_no}&phone=&temp={$microtime}";
        return json_decode(Http::get($location, [], ['header' => $header, 'timeout' => 30]), true);
    }

}