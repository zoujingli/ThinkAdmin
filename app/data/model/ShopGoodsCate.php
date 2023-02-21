<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 商城商品分类模型
 * Class ShopGoodsCate
 * @package app\data\model
 */
class ShopGoodsCate extends Model
{
    /**
     * 获取上级可用选项
     * @param int $max 最大级别
     * @param array $data 表单数据
     * @param array $parent 上级分类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getParentData(int $max, array &$data, array $parent = []): array
    {
        $items = static::mk()->where(['deleted' => 0])->order('sort desc,id asc')->select()->toArray();
        $cates = DataExtend::arr2table(empty($parent) ? $items : array_merge([$parent], $items));
        if (isset($data['id'])) foreach ($cates as $cate) if ($cate['id'] === $data['id']) $data = $cate;
        foreach ($cates as $key => $cate) {
            $isSelf = isset($data['spt']) && isset($data['spc']) && $data['spt'] <= $cate['spt'] && $data['spc'] > 0;
            if ($cate['spt'] >= $max || $isSelf) unset($cates[$key]);
        }
        return $cates;
    }

    /**
     * 获取数据树
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function treeData(): array
    {
        $query = static::mk()->where(['status' => 1, 'deleted' => 0])->order('sort desc,id desc');
        return DataExtend::arr2tree($query->withoutField('sort,status,deleted,create_at')->select()->toArray());
    }

    /**
     * 获取列表数据
     * @param bool $simple 仅子级别
     * @return array
     */
    public static function treeTable(bool $simple = false): array
    {
        $query = static::mk()->where(['status' => 1, 'deleted' => 0])->order('sort desc,id asc');
        $cates = array_column(DataExtend::arr2table($query->column('id,pid,name', 'id')), null, 'id');
        foreach ($cates as $cate) isset($cates[$cate['pid']]) && $cates[$cate['id']]['parent'] =& $cates[$cate['pid']];
        foreach ($cates as $key => $cate) {
            $id = $cate['id'];
            $cates[$id]['ids'][] = $cate['id'];
            $cates[$id]['names'][] = $cate['name'];
            while (isset($cate['parent']) && ($cate = $cate['parent'])) {
                $cates[$id]['ids'][] = $cate['id'];
                $cates[$id]['names'][] = $cate['name'];
            }
            $cates[$id]['ids'] = array_reverse($cates[$id]['ids']);
            $cates[$id]['names'] = array_reverse($cates[$id]['names']);
            if (isset($pky) && $simple && in_array($cates[$pky]['name'], $cates[$id]['names'])) {
                unset($cates[$pky]);
            }
            $pky = $key;
        }
        foreach ($cates as &$cate) unset($cate['parent']);
        return array_values($cates);
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