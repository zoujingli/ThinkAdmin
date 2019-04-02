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

namespace library\logic;

use library\Controller;

/**
 * 搜索条件处理器
 * Class Query
 * @package library\logic
 * @see \think\Db\Query
 * @mixin \think\Db\Query
 */
class Query extends Logic
{

    /**
     * Query constructor.
     * @param \think\db\Query|string $dbQuery
     */
    public function __construct($dbQuery)
    {
        $this->query = $this->buildQuery($dbQuery);
    }

    /**
     * 逻辑器初始化
     * @param Controller $controller
     * @return $this
     */
    public function init(Controller $controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * 获取当前Db操作对象
     * @return \think\db\Query
     */
    public function db()
    {
        return $this->query;
    }

    /**
     * 设置Like查询条件
     * @param string|array $fields 查询字段
     * @param string $inputType 输入类型 get|post
     * @return $this
     */
    public function like($fields, $inputType = 'request')
    {
        $data = $this->controller->request->$inputType();
        foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
            list($dk, $qk) = [$field, $field];
            if (stripos($field, '|') !== false) list($dk, $qk) = explode('|', $field);
            if (isset($data[$qk]) && $data[$qk] !== '') $this->query->whereLike($dk, "%{$data[$qk]}%");
        }
        return $this;
    }

    /**
     * 设置Equal查询条件
     * @param string|array $fields 查询字段
     * @param string $inputType 输入类型 get|post
     * @return $this
     */
    public function equal($fields, $inputType = 'request')
    {
        $data = $this->controller->request->$inputType();
        foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
            list($dk, $qk) = [$field, $field];
            if (stripos($field, '|') !== false) list($dk, $qk) = explode('|', $field);
            if (isset($data[$qk]) && $data[$qk] !== '') $this->query->where($dk, "{$data[$qk]}");
        }
        return $this;
    }

    /**
     * 设置IN区间查询
     * @param string $fields 查询字段
     * @param string $split 输入分隔符
     * @param string $inputType 输入类型 get|post
     * @return $this
     */
    public function in($fields, $split = ',', $inputType = 'request')
    {
        $data = $this->controller->request->$inputType();
        foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
            list($dk, $qk) = [$field, $field];
            if (stripos($field, '|') !== false) list($dk, $qk) = explode('|', $field);
            if (isset($data[$qk]) && $data[$qk] !== '') $this->query->whereIn($dk, explode($split, $data[$qk]));
        }
        return $this;
    }


    /**
     * 设置DateTime区间查询
     * @param string|array $fields 查询字段
     * @param string $split 输入分隔符
     * @param string $inputType 输入类型 get|post
     * @return $this
     */
    public function dateBetween($fields, $split = ' - ', $inputType = 'request')
    {
        $data = $this->controller->request->$inputType();
        foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
            list($dk, $qk) = [$field, $field];
            if (stripos($field, '|') !== false) list($dk, $qk) = explode('|', $field);
            if (isset($data[$qk]) && $data[$qk] !== '') {
                list($start, $end) = explode($split, $data[$qk]);
                $this->query->whereBetween($dk, ["{$start} 00:00:00", "{$end} 23:59:59"]);
            }
        }
        return $this;
    }

    /**
     * 设置区间查询
     * @param string|array $fields 查询字段
     * @param string $split 输入分隔符
     * @param string $inputType 输入类型 get|post
     * @return $this
     */
    public function valueBetween($fields, $split = ' ', $inputType = 'request')
    {
        $data = $this->controller->request->$inputType();
        foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
            list($dk, $qk) = [$field, $field];
            if (stripos($field, '|') !== false) list($dk, $qk) = explode('|', $field);
            if (isset($data[$qk]) && $data[$qk] !== '') {
                list($start, $end) = explode($split, $data[$field]);
                $this->query->whereBetween($dk, ["{$start}", "{$end}"]);
            }
        }
        return $this;
    }

    /**
     * 魔术调用方法
     * @param string $name 调用方法名称
     * @param array $arguments 调用参数
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->query, $name)) {
            call_user_func_array([$this->query, $name], $arguments);
        }
        return $this;
    }

    /**
     * 实例化分页管理器
     * @param boolean $isPage 是否启用分页
     * @param boolean $isDisplay 是否渲染模板
     * @param boolean $total 集合分页记录数
     * @param integer $limit 集合每页记录数
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function page($isPage = true, $isDisplay = true, $total = false, $limit = 0)
    {
        return (new Page($this->query, $isPage, $isDisplay, $total, $limit))->init($this->controller);
    }

}