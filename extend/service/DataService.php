<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace service;

use think\Db;
use think\Request;

/**
 * 基础数据服务
 * Class DataService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/22 15:32
 */
class DataService
{

    /**
     * 删除指定序号
     * @param string $sequence
     * @param string $type
     * @return bool
     */
    public static function deleteSequence($sequence, $type = 'SYSTEM')
    {
        $data = ['sequence' => $sequence, 'type' => strtoupper($type)];
        return Db::name('SystemSequence')->where($data)->delete();
    }

    /**
     * 生成唯一序号 (失败返回 NULL )
     * @param int $length 序号长度
     * @param string $type 序号顾类型
     * @return string
     */
    public static function createSequence($length = 10, $type = 'SYSTEM')
    {
        $times = 0;
        while ($times++ < 10) {
            $i = 0;
            $sequence = '';
            while ($i++ < $length) {
                $sequence .= ($i <= 1 ? rand(1, 9) : rand(0, 9));
            }
            $data = ['sequence' => $sequence, 'type' => strtoupper($type)];
            if (Db::name('SystemSequence')->where($data)->count() < 1) {
                if (Db::name('SystemSequence')->insert($data) !== false) {
                    return $sequence;
                }
            }
        }
        return null;
    }

    /**
     * 数据增量保存
     * @param \think\db\Query|string $dbQuery 数据查询对象
     * @param array $data 需要保存或更新的数据
     * @param string $key 条件主键限制
     * @param array $where 其它的where条件
     * @return bool
     */
    public static function save($dbQuery, $data, $key = 'id', $where = [])
    {
        $db = is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
        $where[$key] = isset($data[$key]) ? $data[$key] : '';
        if ($db->where($where)->count() > 0) {
            return $db->where($where)->update($data) !== false;
        }
        return $db->insert($data) !== false;
    }

    /**
     * 更新数据表内容
     * @param \think\db\Query|string $dbQuery 数据查询对象
     * @param array $where 额外查询条件
     * @return bool|null
     */
    public static function update(&$dbQuery, $where = [])
    {
        $request = Request::instance();
        $db = is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
        $ids = explode(',', $request->post('id', ''));
        $field = $request->post('field', '');
        $value = $request->post('value', '');
        $pk = $db->getPk(['table' => $db->getTable()]);
        $where[empty($pk) ? 'id' : $pk] = ['in', $ids];
        // 删除模式，如果存在 is_deleted 字段使用软删除
        if ($field === 'delete') {
            if (method_exists($db, 'getTableFields')) {
                if (in_array('is_deleted', $db->getTableFields($db->getTable()))) {
                    return false !== $db->where($where)->update(['is_deleted' => 1]);
                }
            }
            return false !== $db->where($where)->delete();
        }
        // 更新模式，更新指定字段内容
        return false !== $db->where($where)->update([$field => $value]);
    }

}
