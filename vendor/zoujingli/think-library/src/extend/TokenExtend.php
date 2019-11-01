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
 * 令牌数据扩展
 * Class TokenExtend
 * @package think\admin\extend
 */
class TokenExtend
{


    /**
     * 验证表单令牌是否有效
     * @param string $token 表单令牌
     * @return boolean
     */
    public static function checkFormToken($token)
    {
        list($node, $cache) = [NodeExtend::getCurrent(), app()->session->get($token, [])];
        if (empty($cache['node']) || empty($cache['time']) || empty($cache['token'])) return false;
        if ($cache['token'] !== $token || $cache['time'] + 600 < time() || $cache['node'] !== $node) return false;
        return true;
    }

    /**
     * 清理表单CSRF信息
     * @param string $name
     */
    public static function clearFormToken($name = null)
    {
        app()->session->delete($name);
    }

    /**
     * 生成表单CSRF信息
     * @param null|string $node
     * @return array
     */
    public static function buildFormToken($node = null)
    {
        list($token, $time) = [uniqid('csrf'), time()];
        foreach (app()->session->all() as $key => $item) {
            if (stripos($key, 'csrf') === 0 && isset($item['time'])) {
                if ($item['time'] + 600 < $time) self::clearFormToken($key);
            }
        }
        $data = ['node' => NodeExtend::fullnode($node), 'token' => $token, 'time' => $time];
        app()->session->set($token, $data);
        return $data;
    }
}