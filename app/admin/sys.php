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

use app\admin\service\AuthService;
use think\admin\extend\NodeExtend;

if (!function_exists('auth')) {
    /**
     * 访问权限检查
     * @param string $node
     * @return boolean
     * @throws ReflectionException
     */
    function auth($node)
    {
        return AuthService::check($node);
    }
}

if (!function_exists('sysdata')) {
    /**
     * JSON 数据读取与存储
     * @param string $name 数据名称
     * @param array|null $value 数据内容
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function sysdata($name, array $value = null)
    {
        if (is_null($value)) {
            $data = json_decode(app()->db->name('SystemData')->where(['name' => $name])->value('value'), true);
            return empty($data) ? [] : $data;
        } else {
            return data_save('SystemData', ['name' => $name, 'value' => json_encode($value, JSON_UNESCAPED_UNICODE)], 'name');
        }
    }
}

if (!function_exists('sysoplog')) {
    /**
     * 写入系统日志
     * @param string $action 日志行为
     * @param string $content 日志内容
     * @return boolean
     */
    function sysoplog($action, $content)
    {
        return app()->db->name('SystemOplog')->insert([
            'node'     => NodeExtend::getCurrent(),
            'action'   => $action, 'content' => $content,
            'geoip'    => PHP_SAPI === 'cli' ? '127.0.0.1' : app()->request->ip(),
            'username' => PHP_SAPI === 'cli' ? 'cli' : app()->session->get('user.username'),
        ]);
    }
}
