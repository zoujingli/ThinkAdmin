<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think\mongo;

use MongoDB\BSON\ObjectID;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\AuthenticationException;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\ConnectionException;
use MongoDB\Driver\Exception\InvalidArgumentException;
use MongoDB\Driver\Exception\RuntimeException;
use MongoDB\Driver\Query as MongoQuery;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\WriteConcern;
use think\Cache;
use think\Collection;
use think\Config;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Loader;
use think\Model;
use think\mongo\Builder;
use think\mongo\Connection;
use think\Paginator;

class Query
{
    // 数据库Connection对象实例
    protected $connection;
    // 数据库驱动类型
    protected $driver;
    // 当前模型类名称
    protected $model;
    // 当前数据表名称（含前缀）
    protected $table = '';
    // 当前数据表名称（不含前缀）
    protected $name = '';
    // 当前数据表主键
    protected $pk;
    // 当前数据表前缀
    protected $prefix = '';
    // 查询参数
    protected $options = [];
    // 数据表信息
    protected static $info = [];

    /**
     * 架构函数
     * @access public
     * @param Connection    $connection 数据库对象实例
     * @param string        $model 模型名
     */
    public function __construct(Connection $connection = null, $model = '')
    {
        $this->connection = $connection ?: Db::connect([], true);
        $this->prefix     = $this->connection->getConfig('prefix');
        $this->model      = $model;
        $this->builder    = new Builder($this->connection, $this);
    }

    /**
     * 利用__call方法实现一些特殊的Model方法
     * @access public
     * @param string    $method 方法名称
     * @param array     $args 调用参数
     * @return mixed
     * @throws DbException
     * @throws Exception
     */
    public function __call($method, $args)
    {
        if (strtolower(substr($method, 0, 5)) == 'getby') {
            // 根据某个字段获取记录
            $field         = Loader::parseName(substr($method, 5));
            $where[$field] = $args[0];
            return $this->where($where)->find();
        } elseif (strtolower(substr($method, 0, 10)) == 'getfieldby') {
            // 根据某个字段获取记录的某个值
            $name         = Loader::parseName(substr($method, 10));
            $where[$name] = $args[0];
            return $this->where($where)->value($args[1]);
        } else {
            throw new Exception('method not exists:' . __CLASS__ . '->' . $method);
        }
    }

    /**
     * 获取当前的数据库Connection对象
     * @access public
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * 切换当前的数据库连接
     * @access public
     * @param mixed $config
     * @return $this
     */
    public function connect($config)
    {
        $this->connection = Db::connect($config);
        return $this;
    }

    /**
     * 指定默认的数据表名（不含前缀）
     * @access public
     * @param string $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 指定默认数据表名（含前缀）
     * @access public
     * @param string $table 表名
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * 得到当前或者指定名称的数据表
     * @access public
     * @param string $name
     * @return string
     */
    public function getTable($name = '')
    {
        if ($name || empty($this->table)) {
            $name      = $name ?: $this->name;
            $tableName = $this->prefix;
            if ($name) {
                $tableName .= Loader::parseName($name);
            }
        } else {
            $tableName = $this->table;
        }
        return $tableName;
    }

    /**
     * 指定数据表主键
     * @access public
     * @param string $pk 主键
     * @return $this
     */
    public function pk($pk)
    {
        $this->pk = $pk;
        return $this;
    }

    /**
     * 将SQL语句中的__TABLE_NAME__字符串替换成带前缀的表名（小写）
     * @access public
     * @param string $sql sql语句
     * @return string
     */
    public function parseSqlTable($sql)
    {
        if (false !== strpos($sql, '__')) {
            $prefix = $this->prefix;
            $sql    = preg_replace_callback("/__([A-Z0-9_-]+)__/sU", function ($match) use ($prefix) {
                return $prefix . strtolower($match[1]);
            }, $sql);
        }
        return $sql;
    }

    /**
     * 执行查询 返回数据集
     * @access public
     * @param string $namespace
     * @param MongoQuery        $query 查询对象
     * @param ReadPreference    $readPreference readPreference
     * @param bool|string       $class 指定返回的数据集对象
     * @param string|array      $typeMap 指定返回的typeMap
     * @return mixed
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function query($namespace, MongoQuery $query, ReadPreference $readPreference = null, $class = false, $typeMap = null)
    {
        return $this->connection->query($namespace, $query, $readPreference, $class, $typeMap);
    }

    /**
     * 执行指令 返回数据集
     * @access public
     * @param Command           $command 指令
     * @param string            $dbName
     * @param ReadPreference    $readPreference readPreference
     * @param bool|string       $class 指定返回的数据集对象
     * @param string|array      $typeMap 指定返回的typeMap
     * @return mixed
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function command(Command $command, $dbName = '', ReadPreference $readPreference = null, $class = false, $typeMap = null)
    {
        return $this->connection->command($command, $dbName, $readPreference, $class, $typeMap);
    }

    /**
     * 执行语句
     * @access public
     * @param string        $namespace
     * @param BulkWrite     $bulk
     * @param WriteConcern  $writeConcern
     * @return int
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     * @throws BulkWriteException
     */
    public function execute($namespace, BulkWrite $bulk, WriteConcern $writeConcern = null)
    {
        return $this->connection->execute($namespace, $bulk, $writeConcern);
    }

    /**
     * 获取最近插入的ID
     * @access public
     * @return string
     */
    public function getLastInsID()
    {
        $id = $this->builder->getLastInsID();
        if ($id instanceof ObjectID) {
            $id = $id->__toString();
        }
        return $id;
    }

    /**
     * 获取最近一次执行的指令
     * @access public
     * @return string
     */
    public function getLastSql()
    {
        return $this->connection->getQueryStr();
    }

    /**
     * 获取数据库的配置参数
     * @access public
     * @param string $name 参数名称
     * @return boolean
     */
    public function getConfig($name = '')
    {
        return $this->connection->getConfig($name);
    }

    /**
     * 得到某个字段的值
     * @access public
     * @param string    $field 字段名
     * @param mixed     $default 默认值
     * @return mixed
     */
    public function value($field, $default = null)
    {
        $result = null;
        if (!empty($this->options['cache'])) {
            // 判断查询缓存
            $cache = $this->options['cache'];
            if (empty($this->options['table'])) {
                $this->options['table'] = $this->getTable();
            }
            $key    = is_string($cache['key']) ? $cache['key'] : md5($field . serialize($this->options));
            $result = Cache::get($key);
        }
        if (!$result) {
            if (isset($this->options['field'])) {
                unset($this->options['field']);
            }
            $cursor = $this->field($field)->fetchCursor(true)->find();
            $cursor->setTypeMap(['root' => 'array']);
            $resultSet = $cursor->toArray();
            $data      = isset($resultSet[0]) ? $resultSet[0] : null;
            $result    = $data[$field];
            if (isset($cache)) {
                // 缓存数据
                Cache::set($key, $result, $cache['expire']);
            }
        } else {
            // 清空查询条件
            $this->options = [];
        }
        return !is_null($result) ? $result : $default;
    }

    /**
     * 得到某个列的数组
     * @access public
     * @param string $field 字段名 多个字段用逗号分隔
     * @param string $key 索引
     * @return array
     */
    public function column($field, $key = '')
    {
        $result = false;
        if (!empty($this->options['cache'])) {
            // 判断查询缓存
            $cache = $this->options['cache'];
            if (empty($this->options['table'])) {
                $this->options['table'] = $this->getTable();
            }
            $guid   = is_string($cache['key']) ? $cache['key'] : md5($field . serialize($this->options));
            $result = Cache::get($guid);
        }
        if (!$result) {
            if (isset($this->options['field'])) {
                unset($this->options['field']);
            }
            if ($key && '*' != $field) {
                $field = $key . ',' . $field;
            }
            $cursor = $this->field($field)->fetchCursor(true)->select();
            $cursor->setTypeMap(['root' => 'array']);
            $resultSet = $cursor->toArray();
            if ($resultSet) {
                $fields = array_keys($resultSet[0]);
                $count  = count($fields);
                $key1   = array_shift($fields);
                $key2   = $fields ? array_shift($fields) : '';
                $key    = $key ?: $key1;
                foreach ($resultSet as $val) {
                    $name = $val[$key];
                    if ($name instanceof ObjectID) {
                        $name = $name->__toString();
                    }
                    if (2 == $count) {
                        $result[$name] = $val[$key2];
                    } elseif (1 == $count) {
                        $result[$name] = $val[$key1];
                    } else {
                        $result[$name] = $val;
                    }
                }
            } else {
                $result = [];
            }

            if (isset($cache) && isset($guid)) {
                // 缓存数据
                Cache::set($guid, $result, $cache['expire']);
            }
        } else {
            // 清空查询条件
            $this->options = [];
        }
        return $result;
    }

    /**
     * 执行command
     * @access public
     * @param string|array|object   $command 指令
     * @param mixed                 $extra 额外参数
     * @param string                $db 数据库名
     * @return array
     */
    public function cmd($command, $extra = null, $db = null)
    {
        if (is_array($command) || is_object($command)) {
            if ($this->connection->getConfig('debug')) {
                $this->connection->log('cmd', 'cmd', $command);
            }
            // 直接创建Command对象
            $command = new Command($command);
        } else {
            // 调用Builder封装的Command对象
            $options = $this->parseExpress();
            $command = $this->builder->$command($options, $extra);
        }
        return $this->command($command, $db);
    }

    /**
     * 指定distinct查询
     * @access public
     * @param string $field 字段名
     * @return array
     */
    public function distinct($field)
    {
        $result = $this->cmd('distinct', $field);
        return $result[0]['values'];
    }

    /**
     * 获取数据库的所有collection
     * @access public
     * @param string  $db 数据库名称 留空为当前数据库
     * @throws Exception
     */
    public function listCollections($db = '')
    {
        $cursor = $this->cmd('listCollections', null, $db);
        $result = [];
        foreach ($cursor as $collection) {
            $result[] = $collection['name'];
        }
        return $result;
    }

    /**
     * COUNT查询
     * @access public
     * @return integer
     */
    public function count()
    {
        $result = $this->cmd('count');
        return $result[0]['n'];
    }

    /**
     * 设置记录的某个字段值
     * 支持使用数据库字段和方法
     * @access public
     * @param string|array  $field 字段名
     * @param mixed         $value 字段值
     * @return integer
     */
    public function setField($field, $value = '')
    {
        if (is_array($field)) {
            $data = $field;
        } else {
            $data[$field] = $value;
        }
        return $this->update($data);
    }

    /**
     * 字段值(延迟)增长
     * @access public
     * @param string    $field 字段名
     * @param integer   $step 增长值
     * @param integer   $lazyTime 延时时间(s)
     * @return integer|true
     * @throws Exception
     */
    public function setInc($field, $step = 1, $lazyTime = 0)
    {
        $condition = !empty($this->options['where']) ? $this->options['where'] : [];
        if (empty($condition)) {
            // 没有条件不做任何更新
            throw new Exception('no data to update');
        }
        if ($lazyTime > 0) {
            // 延迟写入
            $guid = md5($this->getTable() . '_' . $field . '_' . serialize($condition));
            $step = $this->lazyWrite($guid, $step, $lazyTime);
            if (empty($step)) {
                return true; // 等待下次写入
            }
        }
        return $this->setField($field, ['$inc', $step]);
    }

    /**
     * 字段值（延迟）减少
     * @access public
     * @param string    $field 字段名
     * @param integer   $step 减少值
     * @param integer   $lazyTime 延时时间(s)
     * @return integer|true
     * @throws Exception
     */
    public function setDec($field, $step = 1, $lazyTime = 0)
    {
        $condition = !empty($this->options['where']) ? $this->options['where'] : [];
        if (empty($condition)) {
            // 没有条件不做任何更新
            throw new Exception('no data to update');
        }
        if ($lazyTime > 0) {
            // 延迟写入
            $guid = md5($this->getTable() . '_' . $field . '_' . serialize($condition));
            $step = $this->lazyWrite($guid, -$step, $lazyTime);
            if (empty($step)) {
                return true; // 等待下次写入
            }
        }
        return $this->setField($field, ['$inc', -1 * $step]);
    }

    /**
     * 延时更新检查 返回false表示需要延时
     * 否则返回实际写入的数值
     * @access public
     * @param string    $guid 写入标识
     * @param integer   $step 写入步进值
     * @param integer   $lazyTime 延时时间(s)
     * @return false|integer
     */
    protected function lazyWrite($guid, $step, $lazyTime)
    {
        if (false !== ($value = Cache::get($guid))) {
            // 存在缓存写入数据
            if ($_SERVER['REQUEST_TIME'] > Cache::get($guid . '_time') + $lazyTime) {
                // 延时更新时间到了，删除缓存数据 并实际写入数据库
                Cache::rm($guid);
                Cache::rm($guid . '_time');
                return $value + $step;
            } else {
                // 追加数据到缓存
                Cache::set($guid, $value + $step, 0);
                return false;
            }
        } else {
            // 没有缓存数据
            Cache::set($guid, $step, 0);
            // 计时开始
            Cache::set($guid . '_time', $_SERVER['REQUEST_TIME'], 0);
            return false;
        }
    }

    /**
     * 指定AND查询条件
     * @access public
     * @param mixed $field 查询字段
     * @param mixed $op 查询表达式
     * @param mixed $condition 查询条件
     * @return $this
     */
    public function where($field, $op = null, $condition = null)
    {
        $param = func_get_args();
        array_shift($param);
        $this->parseWhereExp('$and', $field, $op, $condition, $param);
        return $this;
    }

    /**
     * 指定OR查询条件
     * @access public
     * @param mixed $field 查询字段
     * @param mixed $op 查询表达式
     * @param mixed $condition 查询条件
     * @return $this
     */
    public function whereOr($field, $op = null, $condition = null)
    {
        $param = func_get_args();
        array_shift($param);
        $this->parseWhereExp('$or', $field, $op, $condition, $param);
        return $this;
    }

    /**
     * 指定NOR查询条件
     * @access public
     * @param mixed $field 查询字段
     * @param mixed $op 查询表达式
     * @param mixed $condition 查询条件
     * @return $this
     */
    public function whereNor($field, $op = null, $condition = null)
    {
        $param = func_get_args();
        array_shift($param);
        $this->parseWhereExp('$nor', $field, $op, $condition, $param);
        return $this;
    }

    /**
     * 分析查询表达式
     * @access public
     * @param string                $logic 查询逻辑    and or xor
     * @param string|array|\Closure $field 查询字段
     * @param mixed                 $op 查询表达式
     * @param mixed                 $condition 查询条件
     * @param array                 $param 查询参数
     * @return void
     */
    protected function parseWhereExp($logic, $field, $op, $condition, $param = [])
    {
        if ($field instanceof \Closure) {
            $this->options['where'][$logic][] = is_string($op) ? [$op, $field] : $field;
            return;
        }
        $where = [];
        if (is_null($op) && is_null($condition)) {
            if (is_array($field)) {
                // 数组批量查询
                $where = $field;
            } elseif ($field) {
                // 字符串查询
                $where[] = ['exp', $field];
            } else {
                $where = '';
            }
        } elseif (is_array($op)) {
            $where[$field] = $param;
        } elseif (is_null($condition)) {
            // 字段相等查询
            $where[$field] = ['=', $op];
        } else {
            $where[$field] = [$op, $condition];
        }

        if (!empty($where)) {
            if (!isset($this->options['where'][$logic])) {
                $this->options['where'][$logic] = [];
            }
            $this->options['where'][$logic] = array_merge($this->options['where'][$logic], $where);
        }
    }

    /**
     * 查询日期或者时间
     * @access public
     * @param string        $field 日期字段名
     * @param string        $op 比较运算符或者表达式
     * @param string|array  $range 比较范围
     * @return $this
     */
    public function whereTime($field, $op, $range = null)
    {
        if (is_null($range)) {
            // 使用日期表达式
            $date = getdate();
            switch (strtolower($op)) {
                case 'today':
                case 'd':
                    $range = 'today';
                    break;
                case 'week':
                case 'w':
                    $range = 'this week 00:00:00';
                    break;
                case 'month':
                case 'm':
                    $range = mktime(0, 0, 0, $date['mon'], 1, $date['year']);
                    break;
                case 'year':
                case 'y':
                    $range = mktime(0, 0, 0, 1, 1, $date['year']);
                    break;
                case 'yesterday':
                    $range = ['yesterday', 'today'];
                    break;
                case 'last week':
                    $range = ['last week 00:00:00', 'this week 00:00:00'];
                    break;
                case 'last month':
                    $range = [date('y-m-01', strtotime('-1 month')), mktime(0, 0, 0, $date['mon'], 1, $date['year'])];
                    break;
                case 'last year':
                    $range = [mktime(0, 0, 0, 1, 1, $date['year'] - 1), mktime(0, 0, 0, 1, 1, $date['year'])];
                    break;
            }
            $op = is_array($range) ? 'between' : '>';
        }
        $this->where($field, strtolower($op) . ' time', $range);
        return $this;
    }

    /**
     * 分页查询
     * @param int|null  $listRows 每页数量
     * @param bool      $simple 简洁模式
     * @param array     $config 配置参数
     *                      page:当前页,
     *                      path:url路径,
     *                      query:url额外参数,
     *                      fragment:url锚点,
     *                      var_page:分页变量,
     *                      list_rows:每页数量
     *                      type:分页类名,
     *                      namespace:分页类命名空间
     * @return \think\paginator\Collection
     * @throws DbException
     */
    public function paginate($listRows = null, $simple = false, $config = [])
    {
        $config   = array_merge(Config::get('paginate'), $config);
        $listRows = $listRows ?: $config['list_rows'];
        $class    = strpos($config['type'], '\\') ? $config['type'] : '\\think\\paginator\\driver\\' . ucwords($config['type']);
        $page     = isset($config['page']) ? (int) $config['page'] : call_user_func([
            $class,
            'getCurrentPage',
        ], $config['var_page']);

        $page = $page < 1 ? 1 : $page;

        $config['path'] = isset($config['path']) ? $config['path'] : call_user_func([$class, 'getCurrentPath']);

        /** @var Paginator $paginator */
        if (!$simple) {
            $options = $this->getOptions();
            $total   = $this->count();
            $results = $this->options($options)->page($page, $listRows)->select();
        } else {
            $results = $this->limit(($page - 1) * $listRows, $listRows + 1)->select();
            $total   = null;
        }
        return $class::make($results, $listRows, $page, $total, $simple, $config);
    }

    /**
     * 指定当前操作的数据表
     * @access public
     * @param string $table 表名
     * @return $this
     */
    public function table($table)
    {
        $this->options['table'] = $table;
        return $this;
    }

    /**
     * 查询缓存
     * @access public
     * @param mixed     $key
     * @param integer   $expire
     * @return $this
     */
    public function cache($key = true, $expire = null)
    {
        // 增加快捷调用方式 cache(10) 等同于 cache(true, 10)
        if (is_numeric($key) && is_null($expire)) {
            $expire = $key;
            $key    = true;
        }
        if (false !== $key) {
            $this->options['cache'] = ['key' => $key, 'expire' => $expire];
        }
        return $this;
    }

    /**
     * 不主动获取数据集
     * @access public
     * @param bool $cursor 是否返回 Cursor 对象
     * @return $this
     */
    public function fetchCursor($cursor = true)
    {
        $this->options['fetch_class'] = $cursor;
        return $this;
    }

    /**
     * 指定数据集返回对象
     * @access public
     * @param string $class 指定返回的数据集对象类名
     * @return $this
     */
    public function fetchClass($class)
    {
        $this->options['fetch_class'] = $class;
        return $this;
    }

    /**
     * 设置typeMap
     * @access public
     * @param string|array $typeMap
     * @return $this
     */
    public function typeMap($typeMap)
    {
        $this->options['typeMap'] = $typeMap;
        return $this;
    }

    /**
     * 设置从主服务器读取数据
     * @access public
     * @return $this
     */
    public function master()
    {
        $this->options['master'] = true;
        return $this;
    }

    /**
     * 设置查询数据不存在是否抛出异常
     * @access public
     * @param bool $fail 是否严格检查字段
     * @return $this
     */
    public function failException($fail = true)
    {
        $this->options['fail'] = $fail;
        return $this;
    }

    /**
     * 设置查询数据不存在是否抛出异常
     * @access public
     * @param bool $awaitData
     * @return $this
     */
    public function awaitData($awaitData)
    {
        $this->options['awaitData'] = $awaitData;
        return $this;
    }

    /**
     * batchSize
     * @access public
     * @param integer $batchSize
     * @return $this
     */
    public function batchSize($batchSize)
    {
        $this->options['batchSize'] = $batchSize;
        return $this;
    }

    /**
     * exhaust
     * @access public
     * @param bool $exhaust
     * @return $this
     */
    public function exhaust($exhaust)
    {
        $this->options['exhaust'] = $exhaust;
        return $this;
    }

    /**
     * 设置modifiers
     * @access public
     * @param array $modifiers
     * @return $this
     */
    public function modifiers($modifiers)
    {
        $this->options['modifiers'] = $modifiers;
        return $this;
    }

    /**
     * 设置noCursorTimeout
     * @access public
     * @param bool $noCursorTimeout
     * @return $this
     */
    public function noCursorTimeout($noCursorTimeout)
    {
        $this->options['noCursorTimeout'] = $noCursorTimeout;
        return $this;
    }

    /**
     * 设置oplogReplay
     * @access public
     * @param bool $oplogReplay
     * @return $this
     */
    public function oplogReplay($oplogReplay)
    {
        $this->options['oplogReplay'] = $oplogReplay;
        return $this;
    }

    /**
     * 设置partial
     * @access public
     * @param bool $partial
     * @return $this
     */
    public function partial($partial)
    {
        $this->options['partial'] = $partial;
        return $this;
    }

    /**
     * 查询注释
     * @access public
     * @param string $comment 注释
     * @return $this
     */
    public function comment($comment)
    {
        $this->options['comment'] = $comment;
        return $this;
    }

    /**
     * maxTimeMS
     * @access public
     * @param string $maxTimeMS
     * @return $this
     */
    public function maxTimeMS($maxTimeMS)
    {
        $this->options['maxTimeMS'] = $maxTimeMS;
        return $this;
    }

    /**
     * 设置返回字段
     * @access public
     * @param array     $field
     * @param boolean   $except 是否排除
     * @return $this
     */
    public function field($field, $except = false)
    {
        if (is_string($field)) {
            $field = array_map('trim', explode(',', $field));
        }
        $projection = [];
        foreach ($field as $key => $val) {
            if (is_numeric($key)) {
                $projection[$val] = $except ? 0 : 1;
            } else {
                $projection[$key] = $val;
            }
        }
        $this->options['projection'] = $projection;
        return $this;
    }

    /**
     * 设置skip
     * @access public
     * @param integer $skip
     * @return $this
     */
    public function skip($skip)
    {
        $this->options['skip'] = $skip;
        return $this;
    }

    /**
     * 设置slaveOk
     * @access public
     * @param bool $slaveOk
     * @return $this
     */
    public function slaveOk($slaveOk)
    {
        $this->options['slaveOk'] = $slaveOk;
        return $this;
    }

    /**
     * 关联预载入查询
     * @access public
     * @param mixed $with
     * @return $this
     */
    public function with($with)
    {
        return $this;
    }

    /**
     * 指定查询数量
     * @access public
     * @param mixed $offset 起始位置
     * @param mixed $length 查询数量
     * @return $this
     */
    public function limit($offset, $length = null)
    {
        if (is_null($length)) {
            if (is_numeric($offset)) {
                $length = $offset;
                $offset = 0;
            } else {
                list($offset, $length) = explode(',', $offset);
            }
        }
        $this->options['skip']  = intval($offset);
        $this->options['limit'] = intval($length);

        return $this;
    }

    /**
     * 指定分页
     * @access public
     * @param mixed $page 页数
     * @param mixed $listRows 每页数量
     * @return $this
     */
    public function page($page, $listRows = null)
    {
        if (is_null($listRows) && strpos($page, ',')) {
            list($page, $listRows) = explode(',', $page);
        }
        $this->options['page'] = [intval($page), intval($listRows)];
        return $this;
    }

    /**
     * 设置sort
     * @access public
     * @param array|string|object   $field
     * @param string                $order
     * @return $this
     */
    public function order($field, $order = '')
    {
        if (is_array($field)) {
            $this->options['sort'] = $field;
        } else {
            $this->options['sort'][$field] = 'asc' == strtolower($order) ? 1 : -1;
        }
        return $this;
    }

    /**
     * 设置tailable
     * @access public
     * @param bool $tailable
     * @return $this
     */
    public function tailable($tailable)
    {
        $this->options['tailable'] = $tailable;
        return $this;
    }

    /**
     * 设置writeConcern对象
     * @access public
     * @param WriteConcern $writeConcern
     * @return $this
     */
    public function writeConcern($writeConcern)
    {
        $this->options['writeConcern'] = $writeConcern;
        return $this;
    }

    /**
     * 获取当前数据表的主键
     * @access public
     * @return string|array
     */
    public function getPk()
    {
        return !empty($this->pk) ? $this->pk : $this->getConfig('pk');
    }

    /**
     * 查询参数赋值
     * @access protected
     * @param array $options 表达式参数
     * @return $this
     */
    protected function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * 获取当前的查询参数
     * @access public
     * @param string $name 参数名
     * @return mixed
     */
    public function getOptions($name = '')
    {
        return isset($this->options[$name]) ? $this->options[$name] : $this->options;
    }

    /**
     * 设置关联查询
     * @access public
     * @param string $relation 关联名称
     * @return $this
     */
    public function relation($relation)
    {
        $this->options['relation'] = $relation;
        return $this;
    }

    /**
     * 把主键值转换为查询条件 支持复合主键
     * @access public
     * @param array|string  $data 主键数据
     * @param mixed         $options 表达式参数
     * @return void
     * @throws Exception
     */
    protected function parsePkWhere($data, &$options)
    {
        $pk = $this->getPk();

        if (is_string($pk)) {
            // 根据主键查询
            if (is_array($data)) {
                $where[$pk] = isset($data[$pk]) ? $data[$pk] : ['in', $data];
            } else {
                $where[$pk] = strpos($data, ',') ? ['in', $data] : $data;
            }
        }

        if (!empty($where)) {
            if (isset($options['where']['$and'])) {
                $options['where']['$and'] = array_merge($options['where']['$and'], $where);
            } else {
                $options['where']['$and'] = $where;
            }
        }
        return;
    }

    /**
     * 插入记录
     * @access public
     * @param mixed $data 数据
     * @return WriteResult
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     * @throws BulkWriteException
     */
    public function insert(array $data)
    {
        if (empty($data)) {
            throw new Exception('miss data to insert');
        }
        // 分析查询表达式
        $options = $this->parseExpress();
        // 生成bulk对象
        $bulk         = $this->builder->insert($data, $options);
        $writeConcern = isset($options['writeConcern']) ? $options['writeConcern'] : null;
        $writeResult  = $this->execute($options['table'], $bulk, $writeConcern);
        return $writeResult->getInsertedCount();
    }

    /**
     * 插入记录并获取自增ID
     * @access public
     * @param mixed $data 数据
     * @return integer
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     * @throws BulkWriteException
     */
    public function insertGetId(array $data)
    {
        $this->insert($data);
        return $this->getLastInsID();
    }

    /**
     * 批量插入记录
     * @access public
     * @param mixed $dataSet 数据集
     * @return integer
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     * @throws BulkWriteException
     */
    public function insertAll(array $dataSet)
    {
        // 分析查询表达式
        $options = $this->parseExpress();
        if (!is_array(reset($dataSet))) {
            return false;
        }

        // 生成bulkWrite对象
        $bulk         = $this->builder->insertAll($dataSet, $options);
        $writeConcern = isset($options['writeConcern']) ? $options['writeConcern'] : null;
        $writeResult  = $this->execute($options['table'], $bulk, $writeConcern);
        return $writeResult->getInsertedCount();
    }

    /**
     * 更新记录
     * @access public
     * @param mixed $data 数据
     * @return int
     * @throws Exception
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     * @throws BulkWriteException
     */
    public function update(array $data)
    {
        $options = $this->parseExpress();
        if (empty($options['where'])) {
            $pk = $this->getPk();
            // 如果存在主键数据 则自动作为更新条件
            if (is_string($pk) && isset($data[$pk])) {
                $where[$pk] = $data[$pk];
                $key        = 'mongo:' . $options['table'] . '|' . $data[$pk];
                unset($data[$pk]);
            } elseif (is_array($pk)) {
                // 增加复合主键支持
                foreach ($pk as $field) {
                    if (isset($data[$field])) {
                        $where[$field] = $data[$field];
                    } else {
                        // 如果缺少复合主键数据则不执行
                        throw new Exception('miss complex primary data');
                    }
                    unset($data[$field]);
                }
            }
            if (!isset($where)) {
                // 如果没有任何更新条件则不执行
                throw new Exception('miss update condition');
            } else {
                $options['where']['$and'] = $where;
            }
        }

        // 生成bulkWrite对象
        $bulk         = $this->builder->update($data, $options);
        $writeConcern = isset($options['writeConcern']) ? $options['writeConcern'] : null;
        $writeResult  = $this->execute($options['table'], $bulk, $writeConcern);
        // 检测缓存
        if (isset($key) && Cache::get($key)) {
            // 删除缓存
            Cache::rm($key);
        }
        return $writeResult->getModifiedCount();
    }

    /**
     * 删除记录
     * @access public
     * @param array $data 表达式 true 表示强制删除
     * @return int
     * @throws Exception
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     * @throws BulkWriteException
     */
    public function delete($data = null)
    {
        // 分析查询表达式
        $options = $this->parseExpress();

        if (!is_null($data) && true !== $data) {
            if (!is_array($data)) {
                // 缓存标识
                $key = 'mongo:' . $options['table'] . '|' . $data;
            }
            // AR模式分析主键条件
            $this->parsePkWhere($data, $options);
        }

        if (true !== $data && empty($options['where'])) {
            // 如果不是强制删除且条件为空 不进行删除操作
            throw new Exception('delete without condition');
        }

        // 生成bulkWrite对象
        $bulk         = $this->builder->delete($options);
        $writeConcern = isset($options['writeConcern']) ? $options['writeConcern'] : null;
        // 执行操作
        $writeResult = $this->execute($options['table'], $bulk, $writeConcern);
        // 检测缓存
        if (isset($key) && Cache::get($key)) {
            // 删除缓存
            Cache::rm($key);
        }
        return $writeResult->getDeletedCount();
    }

    /**
     * 查找记录
     * @access public
     * @param array|string|Query|\Closure $data
     * @return Collection|false|Cursor|string
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function select($data = null)
    {
        if ($data instanceof Query) {
            return $data->select();
        } elseif ($data instanceof \Closure) {
            call_user_func_array($data, [ & $this]);
            $data = null;
        }
        // 分析查询表达式
        $options = $this->parseExpress();

        if (!is_null($data)) {
            // 主键条件分析
            $this->parsePkWhere($data, $options);
        }

        $resultSet = false;
        if (!empty($options['cache'])) {
            // 判断查询缓存
            $cache     = $options['cache'];
            $key       = is_string($cache['key']) ? $cache['key'] : md5(serialize($options));
            $resultSet = Cache::get($key);
        }
        if (!$resultSet) {
            // 生成MongoQuery对象
            $query = $this->builder->select($options);
            // 执行查询操作
            $readPreference = isset($options['readPreference']) ? $options['readPreference'] : null;
            $resultSet      = $this->query($options['table'], $query, $readPreference, $options['fetch_class'], $options['typeMap']);

            if ($resultSet instanceof Cursor) {
                // 返回MongoDB\Driver\Cursor对象
                return $resultSet;
            }

            if (isset($cache)) {
                // 缓存数据集
                Cache::set($key, $resultSet, $cache['expire']);
            }
        }

        // 返回结果处理
        if ($resultSet) {
            // 数据列表读取后的处理
            if (!empty($this->model)) {
                // 生成模型对象
                $model = $this->model;
                foreach ($resultSet as $key => $result) {
                    /** @var Model $result */
                    $result = new $model($result);
                    $result->isUpdate(true);
                    // 关联查询
                    if (!empty($options['relation'])) {
                        $result->relationQuery($options['relation']);
                    }
                    $resultSet[$key] = $result;
                }
                if (!empty($options['with'])) {
                    // 预载入
                    $resultSet = $result->eagerlyResultSet($resultSet, $options['with'], is_object($resultSet) ? get_class($resultSet) : '');
                }
            }
        } elseif (!empty($options['fail'])) {
            $this->throwNotFound($options);
        }
        return $resultSet;
    }

    /**
     * 查找单条记录
     * @access public
     * @param array|string|Query|\Closure $data
     * @return array|false|Cursor|string|Model
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function find($data = null)
    {
        if ($data instanceof Query) {
            return $data->find();
        } elseif ($data instanceof \Closure) {
            call_user_func_array($data, [ & $this]);
            $data = null;
        }
        // 分析查询表达式
        $options = $this->parseExpress();

        if (!is_null($data)) {
            // AR模式分析主键条件
            $this->parsePkWhere($data, $options);
        }

        $options['limit'] = 1;
        $result           = false;
        if (!empty($options['cache'])) {
            // 判断查询缓存
            $cache = $options['cache'];
            if (true === $cache['key'] && !is_null($data) && !is_array($data)) {
                $key = 'mongo:' . $options['table'] . '|' . $data;
            } else {
                $key = is_string($cache['key']) ? $cache['key'] : md5(serialize($options));
            }
            $result = Cache::get($key);
        }
        if (!$result) {
            // 生成查询SQL
            $query = $this->builder->select($options);
            // 执行查询
            $readPreference = isset($options['readPreference']) ? $options['readPreference'] : null;
            $result         = $this->query($options['table'], $query, $readPreference, $options['fetch_class'], $options['typeMap']);

            if ($result instanceof Cursor) {
                // 返回MongoDB\Driver\Cursor对象
                return $result;
            }

            if (isset($cache)) {
                // 缓存数据
                Cache::set($key, $result, $cache['expire']);
            }
        }

        // 数据处理
        if (!empty($result[0])) {
            $data = $result[0];
            if (!empty($this->model)) {
                // 返回模型对象
                $model = $this->model;
                $data  = new $model($data);
                $data->isUpdate(true, isset($options['where']['$and']) ? $options['where']['$and'] : null);
                // 关联查询
                if (!empty($options['relation'])) {
                    $data->relationQuery($options['relation']);
                }
                if (!empty($options['with'])) {
                    // 预载入
                    $data->eagerlyResult($data, $options['with'], is_object($result) ? get_class($result) : '');
                }
            }
        } elseif (!empty($options['fail'])) {
            $this->throwNotFound($options);
        } else {
            $data = null;
        }
        return $data;
    }

    /**
     * 查询失败 抛出异常
     * @access public
     * @param array $options 查询参数
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     */
    protected function throwNotFound($options = [])
    {
        if (!empty($this->model)) {
            throw new ModelNotFoundException('model data Not Found:' . $this->model, $this->model, $options);
        } else {
            throw new DataNotFoundException('table data not Found:' . $options['table'], $options['table'], $options);
        }
    }

    /**
     * 查找多条记录 如果不存在则抛出异常
     * @access public
     * @param array|string|Query|\Closure $data
     * @return array|\PDOStatement|string|Model
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function selectOrFail($data = null)
    {
        return $this->failException(true)->select($data);
    }

    /**
     * 查找单条记录 如果不存在则抛出异常
     * @access public
     * @param array|string|Query|\Closure $data
     * @return array|\PDOStatement|string|Model
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws AuthenticationException
     * @throws InvalidArgumentException
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function findOrFail($data = null)
    {
        return $this->failException(true)->find($data);
    }

    /**
     * 分批数据返回处理
     * @access public
     * @param integer   $count 每次处理的数据数量
     * @param callable  $callback 处理回调方法
     * @param string    $column 分批处理的字段名
     * @return boolean
     */
    public function chunk($count, $callback, $column = null)
    {
        $column    = $column ?: $this->getPk();
        $options   = $this->getOptions();
        $resultSet = $this->limit($count)->order($column, 'asc')->select();

        while (!empty($resultSet)) {
            if (false === call_user_func($callback, $resultSet)) {
                return false;
            }
            $end       = end($resultSet);
            $lastId    = is_array($end) ? $end[$column] : $end->$column;
            $resultSet = $this->options($options)
                ->limit($count)
                ->where($column, '>', $lastId)
                ->order($column, 'asc')
                ->select();
        }
        return true;
    }

    /**
     * 获取数据表信息
     * @access public
     * @param string $tableName 数据表名 留空自动获取
     * @param string $fetch 获取信息类型 包括 fields type pk
     * @return mixed
     */
    public function getTableInfo($tableName = '', $fetch = '')
    {
        if (!$tableName) {
            $tableName = $this->getTable();
        }
        if (is_array($tableName)) {
            $tableName = key($tableName) ?: current($tableName);
        }

        if (strpos($tableName, ',')) {
            // 多表不获取字段信息
            return false;
        } else {
            $tableName = $this->parseSqlTable($tableName);
        }

        $guid = md5($tableName);
        if (!isset(self::$info[$guid])) {
            $result = $this->table($tableName)->find();
            $fields = array_keys($result);
            $type   = [];
            foreach ($result as $key => $val) {
                // 记录字段类型
                $type[$key] = getType($val);
                if ('_id' == $key) {
                    $pk = $key;
                }
            }
            if (!isset($pk)) {
                // 设置主键
                $pk = null;
            }
            $result            = ['fields' => $fields, 'type' => $type, 'pk' => $pk];
            self::$info[$guid] = $result;
        }
        return $fetch ? self::$info[$guid][$fetch] : self::$info[$guid];
    }

    /**
     * 分析表达式（可用于查询或者写入操作）
     * @access protected
     * @return array
     */
    protected function parseExpress()
    {
        $options = $this->options;

        // 获取数据表
        if (empty($options['table'])) {
            $options['table'] = $this->getTable();
        }

        if (!isset($options['where'])) {
            $options['where'] = [];
        }

        $modifiers = empty($options['modifiers']) ? [] : $options['modifiers'];
        if (isset($options['comment'])) {
            $modifiers['$comment'] = $options['comment'];
        }

        if (isset($options['maxTimeMS'])) {
            $modifiers['$maxTimeMS'] = $options['maxTimeMS'];
        }

        if (!empty($modifiers)) {
            $options['modifiers'] = $modifiers;
        }

        if (!isset($options['projection']) || '*' == $options['projection']) {
            $options['projection'] = [];
        }

        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->getConfig('type_map');
        }

        if (!isset($options['limit'])) {
            $options['limit'] = 0;
        }

        foreach (['master', 'fetch_class'] as $name) {
            if (!isset($options[$name])) {
                $options[$name] = false;
            }
        }

        if (isset($options['page'])) {
            // 根据页数计算limit
            list($page, $listRows) = $options['page'];
            $page                  = $page > 0 ? $page : 1;
            $listRows              = $listRows > 0 ? $listRows : (is_numeric($options['limit']) ? $options['limit'] : 20);
            $offset                = $listRows * ($page - 1);
            $options['skip']       = intval($offset);
            $options['limit']      = intval($listRows);
        }

        $this->options = [];
        return $options;
    }

}
