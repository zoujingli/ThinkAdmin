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
        $app = app();
        return $app->db->name('SystemOplog')->insert([
            'node'     => \think\admin\service\NodeService::instance()->getCurrent(),
            'geoip'    => $app->request->isCli() ? '127.0.0.1' : $app->request->ip(),
            'action'   => $action, 'content' => $content,
            'username' => $app->request->isCli() ? 'cli' : $app->session->get('user.username', ''),
        ]);
    }
}
