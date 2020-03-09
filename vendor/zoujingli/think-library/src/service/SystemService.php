<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace library\service;

use library\Service;
use think\Db;
use think\db\Query;

/**
 * 系统参数管理服务
 * Class SystemService
 * @package think\admin\service
 */
class SystemService extends Service
{

    /**
     * 配置数据缓存
     * @var array
     */
    protected $data = [];


    /**
     * 数据增量保存
     * @param Query|string $dbQuery 数据查询对象
     * @param array $data 需要保存或更新的数据
     * @param string $key 条件主键限制
     * @param array $where 其它的where条件
     * @return bool|int|mixed|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function save($dbQuery, $data, $key = 'id', $where = [])
    {
        $db = is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
        list($table, $value) = [$db->getTable(), isset($data[$key]) ? $data[$key] : null];
        $map = isset($where[$key]) ? [] : (is_string($value) ? [[$key, 'in', explode(',', $value)]] : [$key => $value]);
        if (is_array($info = Db::table($table)->master()->where($where)->where($map)->find()) && !empty($info)) {
            if (Db::table($table)->strict(false)->where($where)->where($map)->update($data) !== false) {
                return isset($info[$key]) ? $info[$key] : true;
            } else {
                return false;
            }
        } else {
            return Db::table($table)->strict(false)->insertGetId($data);
        }
    }

    /**
     * 保存数据内容
     * @param string $name 数据名称
     * @param mixed $value 数据内容
     * @return boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function setData($name, $value)
    {
        $data = ['name' => $name, 'value' => serialize($value)];
        return $this->save('SystemData', $data, 'name');
    }

    /**
     * 读取数据内容
     * @param string $name 数据名称
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getData($name, $default = [])
    {
        try {
            $value = Db::name('SystemData')->where(['name' => $name])->value('value');
            return empty($value) ? $default : unserialize($value);
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * 写入系统日志
     * @param string $action
     * @param string $content
     * @return integer
     */
    public function setOplog($action, $content)
    {
        return Db::name('SystemLog')->insert([
            'node'     => NodeService::instance()->getCurrent(),
            'action'   => $action, 'content' => $content,
            'geoip'    => $this->app->request->isCli() ? '127.0.0.1' : $this->app->request->ip(),
            'username' => $this->app->request->isCli() ? 'cli' : $this->app->session->get('user.username'),
        ]);
    }

    /**
     * 打印输出数据到文件
     * @param mixed $data 输出的数据
     * @param boolean $new 强制替换文件
     * @param string|null $file 文件名称
     */
    public function putDebug($data, $new = false, $file = null)
    {
        if (is_null($file)) $file = $this->app->getRuntimePath() . date('Ymd') . '.txt';
        $str = (is_string($data) ? $data : ((is_array($data) || is_object($data)) ? print_r($data, true) : var_export($data, true))) . PHP_EOL;
        $new ? file_put_contents($file, $str) : file_put_contents($file, $str, FILE_APPEND);
    }

    /**
     * 判断运行环境
     * @param string $type 运行模式（dev|demo|local）
     * @return boolean
     */
    public function checkRunMode($type = 'dev')
    {
        $domain = $this->app->request->host(true);
        $isDemo = is_numeric(stripos($domain, 'thinkadmin.top'));
        $isLocal = in_array($domain, ['127.0.0.1', 'localhost']);
        if ($type === 'dev') return $isLocal || $isDemo;
        if ($type === 'demo') return $isDemo;
        if ($type === 'local') return $isLocal;
        return true;
    }

}