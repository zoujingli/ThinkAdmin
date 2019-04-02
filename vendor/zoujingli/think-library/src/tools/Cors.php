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

use think\Request;

/**
 * 请求跨域支持
 * Class Cors
 * @package library\tools
 */
class Cors
{

    /**
     * Option请求处理
     * @param Request $request
     */
    public static function setOptionHandler(Request $request)
    {
        if ($request->isOptions()) {
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
            header('Access-Control-Allow-Origin:' . self::getOrigin($request));
            header('Access-Control-Allow-Headers:' . self::getAllows($request));
            header('Access-Control-Expose-Headers: User-Token-Csrf');
            header('Content-Type:text/plain charset=UTF-8');
            header('Access-Control-Max-Age:1728000');
            header('HTTP/1.0 204 No Content');
            header('Content-Length:0');
            header('status:204');
            exit;
        }
    }

    /**
     * 获取返回Header信息
     * @param Request $request
     * @return array
     */
    public static function getRequestHeader(Request $request)
    {
        return [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Methods'     => 'GET,POST,OPTIONS',
            'Access-Control-Allow-Origin'      => self::getOrigin($request),
            'Access-Control-Allow-Headers'     => self::getAllows($request),
            'Access-Control-Expose-Headers'    => 'User-Token-Csrf',
        ];
    }

    /**
     * 获取Origin信息
     * @param Request $request
     * @return string
     */
    private static function getOrigin(Request $request)
    {
        return $request->header('origin', '*');
    }

    /**
     * 获取Allow信息
     * @param Request $request
     * @return string
     */
    private static function getAllows(Request $request)
    {
        return 'Host,Accept,Cookie,Origin,Pragma,Expires,Referer,User-Agent,Keep-Alive,Content-Type,Cache-Control,Last-Event-ID,Last-Modified,Content-Language,X-Requested-With,If-Modified-Since';
    }

}