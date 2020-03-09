<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\helper;

use library\Helper;
use think\db\Query;

/**
 * Class SaveHelper
 * @package library\helper
 */
class SaveHelper extends Helper
{
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
    protected $field;

    /**
     * 数据对象主键值
     * @var string
     */
    protected $value;

    /**
     * 逻辑器初始化
     * @param Query|string $dbQuery
     * @param array $data 表单扩展数据
     * @param string $field 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function init($dbQuery, $data = [], $field = '', $where = [])
    {
        $this->where = $where;
        $this->query = $this->buildQuery($dbQuery);
        $this->data = empty($data) ? $this->app->request->post() : $data;
        $this->field = empty($field) ? $this->query->getPk() : $field;
        $this->value = $this->app->request->post($this->field, null);
        // 主键限制处理
        if (!isset($this->where[$this->field]) && is_string($this->value)) {
            $this->query->whereIn($this->field, explode(',', $this->value));
            if (isset($this->data)) unset($this->data[$this->field]);
        }
        // 前置回调处理
        if (false === $this->controller->callback('_save_filter', $this->query, $this->data)) {
            return false;
        }
        // 执行更新操作
        $result = $this->query->where($this->where)->update($this->data) !== false;
        // 结果回调处理
        if (false === $this->controller->callback('_save_result', $result)) {
            return $result;
        }
        // 回复前端结果
        if ($result !== false) {
            $this->controller->success(lang('think_library_save_success'), '');
        } else {
            $this->controller->error(lang('think_library_save_error'));
        }
    }
}