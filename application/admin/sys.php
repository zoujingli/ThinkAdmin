<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

if (!function_exists('auth')) {
    /**
     * 节点访问权限检查
     * @param string $node
     * @return boolean
     */
    function auth($node)
    {
        return \app\admin\service\Auth::checkAuthNode($node);
    }
}

if (!function_exists('sysdata')) {
    /**
     * JSON 数据读取与存储
     * @param string $name 数据名称
     * @param array|null $value 数据内容
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    function sysdata($name, array $value = null)
    {
        if (is_null($value)) {
            $data = json_decode(\think\Db::name('SystemData')->where('name', $name)->value('value'), true);
            return empty($data) ? [] : $data;
        }
        return data_save('SystemData', ['name' => $name, 'value' => json_encode($value, 256)], 'name');
    }
}

if (!function_exists('_sysmsg')) {
    /**
     * 增加系统消息
     * @param string $title 消息标题
     * @param string $desc 消息描述
     * @param string $url 访问链接
     * @param string $node 权限节点
     * @return boolean
     */
    function _sysmsg($title, $desc, $url, $node)
    {
        return \app\admin\service\Message::add($title, $desc, $url, $node);
    }
}

if (!function_exists('_syslog')) {
    /**
     * 写入系统日志
     * @param string $action 日志行为
     * @param string $content 日志内容
     * @return boolean
     */
    function _syslog($action, $content)
    {
        return \app\admin\service\Log::write($action, $content);
    }
}

if (!function_exists('local_image')) {
    /**
     * 下载远程文件到本地
     * @param string $url 远程图片地址
     * @return string
     */
    function local_image($url)
    {
        $result = \library\File::down($url);
        if (isset($result['url'])) return $result['url'];
        return $url;
    }
}

if (!function_exists('base64_image')) {
    /**
     * base64 图片上传接口
     * @param string $content
     * @param string $predir
     * @return string
     */
    function base64_image($content, $predir = 'base64/')
    {
        try {
            if (preg_match('|^data:image/(.*?);base64,|i', $content)) {
                list($ext, $base) = explode('|||', preg_replace('|^data:image/(.*?);base64,|i', '$1|||', $content));
                $info = \library\File::save($predir . md5($base) . '.' . (empty($ext) ? 'tmp' : $ext), base64_decode($base));
                return $info['url'];
            }
            return $content;
        } catch (\Exception $e) {
            return $content;
        }
    }
}

// 系统权限检查中间键
\think\facade\Middleware::add(function (\think\Request $request, \Closure $next) {
    // 系统消息处理
    if (($code = $request->get('messagecode')) > 0) \app\admin\service\Message::set($code);
    // 节点忽略跳过
    $node = \library\tools\Node::current();
    foreach (\app\admin\service\Auth::getIgnore() as $str) if (stripos($node, $str) === 0) return $next($request);
    // 节点权限查询
    $auth = \think\Db::name('SystemNode')->cache(true, 60)->field('is_auth,is_login')->where(['node' => $node])->find();
    $info = ['is_auth' => $auth['is_auth'], 'is_login' => $auth['is_auth'] ? 1 : $auth['is_login']];
    // 登录状态检查
    if (!empty($info['is_login']) && !\app\admin\service\Auth::isLogin()) {
        $message = ['code' => 0, 'msg' => '抱歉，您还没有登录获取访问权限！', 'url' => url('@admin/login')];
        return $request->isAjax() ? json($message) : redirect($message['url']);
    }
    // 访问权限检查
    if (!empty($info['is_auth']) && !\app\admin\service\Auth::checkAuthNode($node)) {
        return json(['code' => 0, 'msg' => '抱歉，您没有访问该模块的权限！']);
    }
    return $next($request);
});