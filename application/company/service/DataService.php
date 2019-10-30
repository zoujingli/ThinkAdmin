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

namespace app\company\service;

/**
 * 企业数据处理服务
 * Class DataService
 * @package app\company\service
 */
class DataService
{
    /**
     * 格式化MAC地址信息
     * @param string $mac
     * @return string
     */
    public static function applyMacValue(&$mac)
    {
        $mac = strtoupper(str_replace('-', ':', $mac));
        if (preg_match('/([A-F0-9]{2}:){5}[A-F0-9]{2}/', $mac)) {
            return $mac;
        } else {
            return false;
        }
    }

}
