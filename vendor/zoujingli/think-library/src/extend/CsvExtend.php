<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace think\admin\extend;

/**
 * 转出CSV文件扩展
 * Class CsvExtend
 * @package think\admin\extend
 */
class CsvExtend
{

    /**
     * 设置写入CSV文件头部
     * @param string $name 导出文件名称
     * @param array $headers 表格头部(一维数组)
     */
    public static function header($name, array $headers)
    {
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=" . iconv('utf-8', 'gbk//TRANSLIT', $name));
        $handle = fopen('php://output', 'w');
        foreach ($headers as $key => $value) $headers[$key] = iconv("utf-8", "gbk//TRANSLIT", $value);
        fputcsv($handle, $headers);
        if (is_resource($handle)) fclose($handle);
    }

    /**
     * 设置写入CSV文件内容
     * @param array $list 数据列表(二维数组)
     * @param array $rules 数据规则(一维数组)
     */
    public static function body(array $list, array $rules)
    {
        $handle = fopen('php://output', 'w');
        foreach ($list as $data) {
            $rows = [];
            foreach ($rules as $rule) {
                $rows[] = self::parseKeyDotValue($data, $rule);
            }
            fputcsv($handle, $rows);
        }
        if (is_resource($handle)) fclose($handle);
    }

    /**
     * 根据数组key查询(可带点规则)
     * @param array $data 数据
     * @param string $rule 规则，如: order.order_no
     * @return mixed
     */
    public static function parseKeyDotValue(array $data, $rule)
    {
        list($temp, $attr) = [$data, explode('.', trim($rule, '.'))];
        while ($key = array_shift($attr)) $temp = isset($temp[$key]) ? $temp[$key] : $temp;
        return (is_string($temp) || is_numeric($temp)) ? @iconv('utf-8', 'gbk//TRANSLIT', "{$temp}") : '';
    }
}