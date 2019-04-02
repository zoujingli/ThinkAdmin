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
use think\db\Query;

/**
 * 通用删除管理器
 * Class Delete
 * @package library\logic
 */
class Delete extends Logic
{

    /**
     * 表单额外更新条件
     * @var array
     */
    protected $where;

    /**
     * 数据对象主键名称
     * @var string
     */
    protected $pkField;

    /**
     * 数据对象主键值
     * @var string
     */
    protected $pkValue;

    /**
     * Delete constructor.
     * @param string|Query $dbQuery
     * @param string $pkField 数据对象主键
     * @param array $where 额外更新条件
     */
    public function __construct($dbQuery, $pkField = '', $where = [])
    {
        $this->where = $where;
        $this->query = $this->buildQuery($dbQuery);
        $this->pkField = empty($pkField) ? $this->query->getPk() : $pkField;
        $this->pkValue = request()->post($this->pkField, null);
    }

    /**
     * 逻辑器初始化
     * @param Controller $controller
     * @return boolean|null
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function init(Controller $controller)
    {
        $this->controller = $controller;
        // 主键限制处理
        if (!isset($this->where[$this->pkField]) && is_string($this->pkValue)) {
            $this->query->whereIn($this->pkField, explode(',', $this->pkValue));
        }
        // 前置回调处理
        if (false === $this->controller->callback('_delete_filter', $this->query, $where)) {
            return null;
        }
        // 执行删除操作
        if (method_exists($this->query, 'getTableFields') && in_array('is_deleted', $this->query->getTableFields())) {
            $result = $this->query->where($this->where)->update(['is_deleted' => '1']);
        } else {
            $result = $this->query->where($this->where)->delete();
        }
        // 结果回调处理
        if (false === $this->controller->callback('_delete_result', $result)) {
            return $result;
        }
        // 回复前端结果
        if ($result !== false) {
            $this->controller->success('数据删除成功！', '');
        } else {
            $this->controller->error('数据删除失败, 请稍候再试！');
        }
    }

}