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
use library\tools\Data;
use think\db\Query;

/**
 * 表单视图管理器
 * Class Form
 * @package library\logic
 */
class Form extends Logic
{
    /**
     * 表单模板文件
     * @var string
     */
    protected $tpl;

    /**
     * 表单扩展数据
     * @var array
     */
    protected $data;

    /**
     * 表单额外更新条件
     * @var array
     */
    protected $where;

    /**
     * 数据对象主键名称
     * @var array|string
     */
    protected $pkField;

    /**
     * 数据对象主键值
     * @var string
     */
    protected $pkValue;

    /**
     * Form constructor.
     * @param string|Query $dbQuery
     * @param string $tpl 模板名称
     * @param string $pkField 指定数据对象主键
     * @param array $where 额外更新条件
     * @param array $data 表单扩展数据
     */
    public function __construct($dbQuery, $tpl = '', $pkField = '', $where = [], $data = [])
    {
        $this->query = $this->buildQuery($dbQuery);
        list($this->tpl, $this->where, $this->data) = [$tpl, $where, $data];
        $this->pkField = empty($pkField) ? ($this->query->getPk() ? $this->query->getPk() : 'id') : $pkField;;
        $this->pkValue = input($this->pkField, isset($data[$this->pkField]) ? $data[$this->pkField] : null);
    }

    /**
     * 逻辑器初始化
     * @param Controller $controller
     * @param array $data
     * @return array|boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function init(Controller $controller, $data = [])
    {
        $this->controller = $controller;
        // GET请求, 获取数据并显示表单页面
        if ($this->controller->request->isGet()) {
            if ($this->pkValue !== null) {
                $where = [$this->pkField => $this->pkValue];
                $data = (array)$this->query->where($where)->where($this->where)->find();
            }
            $data = array_merge($data, $this->data);
            if (false !== $this->controller->callback('_form_filter', $data)) {
                return $this->controller->fetch($this->tpl, ['vo' => $data]);
            }
            return $data;
        }
        // POST请求, 数据自动存库处理
        if ($this->controller->request->isPost()) {
            $data = array_merge($this->controller->request->post(), $this->data);
            if (false !== $this->controller->callback('_form_filter', $data, $this->where)) {
                $result = Data::save($this->query, $data, $this->pkField, $this->where);
                if (false !== $this->controller->callback('_form_result', $result, $data)) {
                    if ($result !== false) $this->controller->success('恭喜, 数据保存成功!', '');
                    $this->controller->error('数据保存失败, 请稍候再试!');
                }
                return $result;
            }
        }
    }

}