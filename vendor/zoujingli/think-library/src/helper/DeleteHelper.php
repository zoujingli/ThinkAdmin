<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\helper;

use think\admin\Helper;
use think\db\Query;

/**
 * 通用删除管理器
 * Class DeleteHelper
 * @package think\admin\helper
 */
class DeleteHelper extends Helper
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
    protected $field;

    /**
     * 数据对象主键值
     * @var string
     */
    protected $value;

    /**
     * 逻辑器初始化
     * @param string|Query $dbQuery
     * @param string $field 操作数据主键
     * @param array $where 额外更新条件
     * @return boolean|null|void
     * @throws \think\db\exception\DbException
     */
    public function init($dbQuery, $field = '', $where = [])
    {
        $this->where = $where;
        $this->query = $this->buildQuery($dbQuery);
        $this->field = $field ?: $this->query->getPk();
        $this->value = $this->app->request->post($this->field, null);
        // 主键限制处理
        if (!isset($this->where[$this->field]) && is_string($this->value)) {
            $this->query->whereIn($this->field, explode(',', $this->value));
        }
        // 前置回调处理
        if (false === $this->controller->callback('_delete_filter', $this->query, $this->where)) {
            return null;
        }
        // 组装执行数据
        $data = [];
        if (method_exists($this->query, 'getTableFields')) {
            $fields = $this->query->getTableFields();
            if (in_array('deleted', $fields)) $data['deleted'] = 1;
            if (in_array('is_deleted', $fields)) $data['is_deleted'] = 1;
        }
        if (!empty($this->where)) $this->query->where($this->where);
        // 阻止危险操作
        if (!$this->query->getOptions('where')) {
            $this->controller->error(lang('think_library_delete_error'));
        }
        // 执行删除操作
        $result = empty($data) ? $this->query->delete() : $this->query->update($data);
        // 结果回调处理
        if (false === $this->controller->callback('_delete_result', $result)) {
            return $result;
        }
        // 回复前端结果
        if ($result !== false) {
            $this->controller->success(lang('think_library_delete_success'), '');
        } else {
            $this->controller->error(lang('think_library_delete_error'));
        }
    }

}
