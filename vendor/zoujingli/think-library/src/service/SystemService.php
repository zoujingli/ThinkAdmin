<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\service;

use think\admin\Service;
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
     * 设置配置数据
     * @param string $name 配置名称
     * @param string $value 配置内容
     * @return static
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function set($name, $value = '')
    {
        [$type, $field] = $this->parse($name);
        if (is_array($value)) {
            foreach ($value as $k => $v) $this->set("{$field}.{$k}", $v);
        } else {
            $this->data = [];
            $data = ['name' => $field, 'value' => $value, 'type' => $type];
            $this->save('SystemConfig', $data, 'name', ['type' => $type]);
        }
        return $this;
    }

    /**
     * 读取配置数据
     * @param string $name
     * @return array|mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get($name)
    {
        [$type, $field, $outer] = $this->parse($name);
        if (empty($this->data)) foreach ($this->app->db->name('SystemConfig')->select() as $vo) {
            $this->data[$vo['type']][$vo['name']] = $vo['value'];
        }
        if (empty($name)) {
            return empty($this->data[$type]) ? [] : ($outer === 'raw' ? $this->data[$type] : array_map(function ($value) {
                return htmlspecialchars($value);
            }, $this->data[$type]));
        } else {
            if (isset($this->data[$type])) {
                if ($field) {
                    if (isset($this->data[$type][$field])) {
                        return $outer === 'raw' ? $this->data[$type][$field] : htmlspecialchars($this->data[$type][$field]);
                    }
                } else {
                    if ($outer === 'raw') foreach ($this->data[$type] as $key => $vo) {
                        $this->data[$type][$key] = htmlspecialchars($vo);
                    }
                    return $this->data[$type];
                }
            }
            return '';
        }
    }

    /**
     * 数据增量保存
     * @param Query|string $dbQuery 数据查询对象
     * @param array $data 需要保存或更新的数据
     * @param string $key 条件主键限制
     * @param array $where 其它的where条件
     * @return boolean|integer
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save($dbQuery, $data, $key = 'id', $where = [])
    {
        $db = is_string($dbQuery) ? $this->app->db->name($dbQuery) : $dbQuery;
        [$table, $value] = [$db->getTable(), isset($data[$key]) ? $data[$key] : null];
        $map = isset($where[$key]) ? [] : (is_string($value) ? [[$key, 'in', explode(',', $value)]] : [$key => $value]);
        if (is_array($info = $this->app->db->table($table)->master()->where($where)->where($map)->find()) && !empty($info)) {
            if ($this->app->db->table($table)->strict(false)->where($where)->where($map)->update($data) !== false) {
                return $info[$key] ?? true;
            } else {
                return false;
            }
        } else {
            return $this->app->db->table($table)->strict(false)->insertGetId($data);
        }
    }

    /**
     * 解析缓存名称
     * @param string $rule 配置名称
     * @param string $type 配置类型
     * @return array
     */
    private function parse($rule, $type = 'base')
    {
        if (stripos($rule, '.') !== false) {
            [$type, $rule] = explode('.', $rule);
        }
        [$field, $outer] = explode('|', "{$rule}|");
        return [$type, $field, strtolower($outer)];
    }

    /**
     * 生成最短URL地址
     * @param string $url 路由地址
     * @param array $vars PATH 变量
     * @param boolean|string $suffix 后缀
     * @param boolean|string $domain 域名
     * @return string
     */
    public function sysuri($url = '', array $vars = [], $suffix = true, $domain = false)
    {
        $d1 = $this->app->config->get('app.default_app');
        $d3 = $this->app->config->get('route.default_action');
        $d2 = $this->app->config->get('route.default_controller');
        $location = $this->app->route->buildUrl($url, $vars)->suffix($suffix)->domain($domain)->build();
        return preg_replace('|/\.html$|', '', preg_replace(["|^/{$d1}/{$d2}/{$d3}(\.html)?$|i", "|/{$d2}/{$d3}(\.html)?$|i", "|/{$d3}(\.html)?$|i"], ['$1', '$1', '$1'], $location));
    }

    /**
     * 保存数据内容
     * @param string $name
     * @param mixed $value
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function setData($name, $value)
    {
        $data = ['name' => $name, 'value' => serialize($value)];
        return $this->save('SystemData', $data, 'name');
    }

    /**
     * 读取数据内容
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getData($name, $default = [])
    {
        try {
            $value = $this->app->db->name('SystemData')->where(['name' => $name])->value('value', null);
            return is_null($value) ? $default : unserialize($value);
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
        return $this->app->db->name('SystemOplog')->insert([
            'node'     => NodeService::instance()->getCurrent(),
            'action'   => $action, 'content' => $content,
            'geoip'    => $this->app->request->ip() ?: '127.0.0.1',
            'username' => AdminService::instance()->getUserName() ?: '-',
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
        if (is_null($file)) $file = $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . date('Ymd') . '.log';
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

    /**
     * 判断实时运行模式
     * @return boolean
     */
    public function isDebug()
    {
        return $this->getRuntime('run') !== 'product';
    }

    /**
     * 设置运行环境模式
     * @param null|boolean $state
     * @return boolean
     */
    public function productMode($state = null)
    {
        if (is_null($state)) {
            return $this->bindRuntime();
        } else {
            return $this->setRuntime([], $state ? 'product' : 'developoer');
        }
    }

    /**
     * 设置实时运行配置
     * @param array|null $map 应用映射
     * @param string|null $run 支持模式
     * @param array|null $uri 域名映射
     * @return boolean 是否调试模式
     */
    public function setRuntime($map = [], $run = null, $uri = [])
    {
        $data = $this->getRuntime();
        if (is_array($map) && count($map) > 0 && count($data['map']) > 0) {
            foreach ($data['map'] as $kk => $vv) if (in_array($vv, $map)) unset($data['map'][$kk]);
        }
        if (is_array($uri) && count($uri) > 0 && count($data['uri']) > 0) {
            foreach ($data['uri'] as $kk => $vv) if (in_array($vv, $uri)) unset($data['uri'][$kk]);
        }
        $file = "{$this->app->getRootPath()}runtime/config.json";
        $data['run'] = is_null($run) ? $data['run'] : $run;
        $data['map'] = is_null($map) ? [] : array_merge($data['map'], $map);
        $data['uri'] = is_null($uri) ? [] : array_merge($data['uri'], $uri);
        file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $this->bindRuntime($data);
    }

    /**
     * 获取实时运行配置
     * @param null|string $key
     * @return array
     */
    public function getRuntime($key = null)
    {
        $file = "{$this->app->getRootPath()}runtime/config.json";
        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        if (empty($data) || !is_array($data)) $data = [];
        if (empty($data['map']) || !is_array($data['map'])) $data['map'] = [];
        if (empty($data['uri']) || !is_array($data['uri'])) $data['uri'] = [];
        if (empty($data['run']) || !is_string($data['run'])) $data['run'] = 'developer';
        return is_null($key) ? $data : ($data[$key] ?? null);
    }

    /**
     * 绑定应用实时配置
     * @param array $data 配置数据
     * @return boolean 是否调试模式
     */
    public function bindRuntime($data = [])
    {
        if (empty($data)) $data = $this->getRuntime();
        // 动态设置应用绑定
        if (!empty($data['map'])) {
            $maps = $this->app->config->get('app.app_map', []);
            if (is_array($maps) && count($maps) > 0 && count($data['map']) > 0) {
                foreach ($maps as $kk => $vv) if (in_array($vv, $data['map'])) unset($maps[$kk]);
            }
            $this->app->config->set(['app_map' => array_merge($maps, $data['map'])], 'app');
        }
        // 动态设置域名绑定
        if (!empty($data['uri'])) {
            $uris = $this->app->config->get('app.domain_bind', []);
            if (is_array($uris) && count($uris) > 0 && count($data['uri']) > 0) {
                foreach ($uris as $kk => $vv) if (in_array($vv, $data['uri'])) unset($uris[$kk]);
            }
            $this->app->config->set(['domain_bind' => array_merge($uris, $data['uri'])], 'app');
        }
        // 动态设置运行模式
        return $this->app->debug($data['run'] !== 'product')->isDebug();
    }

    /**
     * 压缩发布项目
     */
    public function pushRuntime()
    {
        $dbname = $this->app->db->getConnection()->getConfig('database');
        $this->app->console->call("optimize:schema", ["--db={$dbname}"]);
        foreach (NodeService::instance()->getModules() as $module) {
            $path = $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . $module;
            file_exists($path) && is_dir($path) or mkdir($path, 0755, true);
            $this->app->console->call("optimize:route", [$module]);
        }
    }

    /**
     * 清理运行缓存
     */
    public function clearRuntime()
    {
        $data = $this->getRuntime();
        $this->app->console->call('clear');
        $this->setRuntime($data['map'], $data['run']);
    }

    /**
     * 初始化并运行应用
     * @param \think\App $app
     */
    public function doInit(\think\App $app)
    {
        $app->debug($this->isDebug());
        $response = $app->http->run();
        $response->send();
        $app->http->end($response);
    }
}