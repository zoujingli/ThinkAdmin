<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\model;

use think\admin\Model;

/**
 * 数据字典模型
 * Class SystemBase
 * @package think\admin\model
 */
class SystemBase extends Model
{
    /**
     * 日志名称
     * @var string
     */
    protected $oplogName = '数据字典';

    /**
     * 日志类型
     * @var string
     */
    protected $oplogType = '数据字典管理';

    /**
     * 获取指定数据列表
     * @param string $type 数据类型
     * @param array $data 外围数据
     * @param string $field 外链字段
     * @param string $bind 绑定字段
     * @return array
     */
    public function items(string $type, array &$data = [], string $field = 'base_code', string $bind = 'base_info'): array
    {
        $map = ['type' => $type, 'status' => 1, 'deleted' => 0];
        $bases = $this->where($map)->order('sort desc,id asc')->column('code,name,content', 'code');
        if (count($data) > 0) foreach ($data as &$vo) $vo[$bind] = $bases[$vo[$field]] ?? [];
        return $bases;
    }

    /**
     * 获取所有数据类型
     * @param boolean $simple
     * @return array
     */
    public function types(bool $simple = false): array
    {
        $types = $this->where(['deleted' => 0])->distinct(true)->column('type');
        if (empty($types) && empty($simple)) $types = ['身份权限'];
        return $types;
    }

    /**
     * 格式化创建时间
     * @param string $value
     * @return string
     */
    public function getCreateAtAttr(string $value): string
    {
        return format_datetime($value);
    }
}