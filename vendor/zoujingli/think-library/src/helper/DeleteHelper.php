<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

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
     * 逻辑器初始化
     * @param string|Query $dbQuery
     * @param string $field 操作数据主键
     * @param array $where 额外更新条件
     * @return boolean|null|void
     * @throws \think\db\exception\DbException
     */
    public function init($dbQuery, string $field = '', array $where = [])
    {
        $query = $this->buildQuery($dbQuery);
        $field = $field ?: ($query->getPk() ?: 'id');
        $value = $this->app->request->post($field, null);
        // 查询限制处理
        if (!empty($where)) $query->where($where);
        if (!isset($where[$field]) && is_string($value)) {
            $query->whereIn($field, explode(',', $value));
        }
        // 前置回调处理
        if (false === $this->class->callback('_delete_filter', $query, $where)) {
            return null;
        }
        // 阻止危险操作
        if (!$query->getOptions('where')) {
            $this->class->error(lang('think_library_delete_error'));
        }
        // 组装执行数据
        $data = [];
        if (method_exists($query, 'getTableFields')) {
            $fields = $query->getTableFields();
            if (in_array('deleted', $fields)) $data['deleted'] = 1;
            if (in_array('is_deleted', $fields)) $data['is_deleted'] = 1;
        }
        // 执行删除操作
        $result = (empty($data) ? $query->delete() : $query->update($data)) !== false;
        // 结果回调处理
        if (false === $this->class->callback('_delete_result', $result)) {
            return $result;
        }
        // 回复返回结果
        if ($result !== false) {
            $this->class->success(lang('think_library_delete_success'), '');
        } else {
            $this->class->error(lang('think_library_delete_error'));
        }
    }
}
