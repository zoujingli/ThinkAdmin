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
 * 表单CSRF表单令牌
 * Class Csrf
 * @package library\tools
 */
class Csrf
{

    /**
     * 获取当前CSRF值
     * @return string
     */
    public static function getToken()
    {
        return request()->header('User-Token-Csrf', input('_csrf_', ''));
    }

    /**
     * 检查表单CSRF验证
     * @return boolean
     */
    public static function checkFormToken()
    {
        $token = self::getToken();
        $cache = session($token, '', 'csrf');
        if (empty($cache['node'])) return false;
        if (empty($cache['time'])) return false;
        if (empty($cache['token'])) return false;
        if ($cache['token'] !== $token) return false;
        if ($cache['time'] + 600 < time()) return false;
        if ($cache['node'] !== Node::current()) return false;
        return true;
    }

    /**
     * 清理表单CSRF信息
     * @param string $name
     */
    public static function clearFormToken($name = null)
    {
        is_null($name) ? session(null, 'csrf') : session($name, null, 'csrf');
    }

    /**
     * 生成表单CSRF信息
     * @param null|string $node
     * @return array
     */
    public static function buildFormToken($node = null)
    {
        list($token, $time) = [uniqid(), time()];
        if (is_null($node)) $node = Node::current();
        session($token, ['node' => $node, 'token' => $token, 'time' => $time], 'csrf');
        foreach (session('', '', 'csrf') as $key => $item) if (isset($item['time'])) {
            if ($item['time'] + 600 < $time) self::clearFormToken($key);
        }
        return ['token' => $token, 'node' => $node, 'time' => $time];
    }

    /**
     * 返回视图内容
     * @param string $tpl 模板名称
     * @param array $vars 模板变量
     * @param string $node CSRF授权节点
     */
    public static function fetchTemplate($tpl = '', $vars = [], $node = null)
    {
        throw new \think\exception\HttpResponseException(view($tpl, $vars, 200, function ($html) use ($node) {
            return preg_replace_callback('/<\/form>/i', function () use ($node) {
                $csrf = self::buildFormToken($node);
                return "<input type='hidden' name='_csrf_' value='{$csrf['token']}'></form>";
            }, $html);
        }));
    }
}