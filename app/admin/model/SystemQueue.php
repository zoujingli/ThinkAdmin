<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;

/**
 * 系统任务数据模型
 * Class SystemQueue
 * @package app\admin\model
 */
class SystemQueue extends Model
{

    /**
     * 格式化计划时间
     * @param float $value
     * @return string
     */
    public function getExecTimeAttr(float $value): string
    {
        return format_datetime($value);
    }

    /**
     * 执行开始时间处理
     * @param mixed $value
     * @return string
     */
    public function getEnterTimeAttr($value): string
    {
        return floatval($value) > 0 ? format_datetime($value) : '';
    }

    /**
     * 执行结束时间处理
     * @param mixed $value
     * @param array $data
     * @return string
     */
    public function getOuterTimeAttr($value, array $data): string
    {
        if ($value > 0 && $value > $data['enter_time']) {
            return '<b class="color-blue">' . sprintf("%.4f", $data['outer_time'] - $data['enter_time']) . '</b> 秒';
        } else {
            return '<b class="color-desc">-</b>';
        }
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