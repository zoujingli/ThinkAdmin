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

namespace service;

use think\Request;

/**
 * 系统工具服务
 * Class ToolsService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/25 14:49
 */
class ToolsService
{

    /**
     * Cors Options 授权处理
     */
    public static function corsOptionsHandler()
    {
        if (request()->isOptions()) {
            header('Access-Control-Allow-Origin:*');
            header('Access-Control-Allow-Headers:Accept,Referer,Host,Keep-Alive,User-Agent,X-Requested-With,Cache-Control,Content-Type,Cookie,token');
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
            header('Access-Control-Max-Age:1728000');
            header('Content-Type:text/plain charset=UTF-8');
            header('Content-Length: 0', true);
            header('status: 204');
            header('HTTP/1.0 204 No Content');
            exit;
        }
    }

    /**
     * Cors Request Header信息
     * @return array
     */
    public static function corsRequestHander()
    {
        return [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Allow-Methods'     => 'GET,POST,OPTIONS',
            'Access-Defined-X-Support'         => 'service@cuci.cc',
            'Access-Defined-X-Servers'         => 'Guangzhou Cuci Technology Co. Ltd',
        ];
    }

    /**
     * Emoji原形转换为String
     * @param string $content
     * @return string
     */
    public static function emojiEncode($content)
    {
        return json_decode(preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($str) {
            return addslashes($str[0]);
        }, json_encode($content)));
    }

    /**
     * Emoji字符串转换为原形
     * @param string $content
     * @return string
     */
    public static function emojiDecode($content)
    {
        return json_decode(preg_replace_callback('/\\\\\\\\/i', function () {
            return '\\';
        }, json_encode($content)));
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) {
            $map[$item[$id]] = $item;
        }
        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            }
        }
        unset($map);
        return $tree;
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id ID Key
     * @param string $pid 父ID Key
     * @param string $path
     * @param string $ppath
     * @return array
     */
    public static function arr2table(array $list, $id = 'id', $pid = 'pid', $path = 'path', $ppath = '')
    {
        $tree = [];
        foreach (self::arr2tree($list, $id, $pid) as $attr) {
            $attr[$path] = "{$ppath}-{$attr[$id]}";
            $attr['sub'] = isset($attr['sub']) ? $attr['sub'] : [];
            $attr['spl'] = str_repeat("&nbsp;&nbsp;&nbsp;├&nbsp;&nbsp;", substr_count($ppath, '-'));
            $sub = $attr['sub'];
            unset($attr['sub']);
            $tree[] = $attr;
            if (!empty($sub)) {
                $tree = array_merge($tree, (array)self::arr2table($sub, $id, $pid, $path, $attr[$path]));
            }
        }
        return $tree;
    }

    /**
     * 获取数据树子ID
     * @param array $list 数据列表
     * @param int $id 起始ID
     * @param string $key 子Key
     * @param string $pkey 父Key
     * @return array
     */
    public static function getArrSubIds($list, $id = 0, $key = 'id', $pkey = 'pid')
    {
        $ids = [intval($id)];
        foreach ($list as $vo) {
            if (intval($vo[$pkey]) > 0 && intval($vo[$pkey]) === intval($id)) {
                $ids = array_merge($ids, self::getArrSubIds($list, intval($vo[$key]), $key, $pkey));
            }
        }
        return $ids;
    }

    /**
     * 物流单查询
     * @param $code
     * @return array
     */
    public static function express($code)
    {
        list($result, $client_ip) = [[], Request::instance()->ip()];
        $header = ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $client_ip, 'X-FORWARDED-FOR' => $client_ip];
        $autoResult = HttpService::get("http://www.kuaidi100.com/autonumber/autoComNum?text={$code}", [], 30, $header);
        foreach (json_decode($autoResult)->auto as $vo) {
            $microtime = microtime(true);
            $location = "http://www.kuaidi100.com/query?type={$vo->comCode}&postid={$code}&id=1&valicode=&temp={$microtime}";
            $result[$vo->comCode] = json_decode(HttpService::get($location, [], 30, $header), true);
        }
        return $result;
    }
}
