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

namespace app\service\service;

/**
 * 授权数据处理
 * Class Build
 * @package app\service\service
 */
class BuildService
{

    /**
     * 授权数据过滤转换处理
     * @param array $info
     * @return mixed
     */
    public static function filter(array $info)
    {
        if (isset($info['func_info'])) $info['func_info'] = join(',', array_map(function ($tmp) {
            return $tmp['funcscope_category']['id'];
        }, $info['func_info']));
        $info['verify_type_info'] = join(',', $info['verify_type_info']);
        $info['service_type_info'] = join(',', $info['service_type_info']);
        $info['business_info'] = json_encode($info['business_info'], JSON_UNESCAPED_UNICODE);
        // 微信类型:  0 代表订阅号, 2 代表服务号, 3 代表小程序
        $info['service_type'] = intval($info['service_type_info']) === 2 ? 2 : 0;
        if (!empty($info['MiniProgramInfo'])) {
            // 微信类型:  0 代表订阅号, 2 代表服务号, 3 代表小程序
            $info['service_type'] = 3;
            // 小程序信息
            $info['miniprograminfo'] = json_encode($info['MiniProgramInfo'], JSON_UNESCAPED_UNICODE);
        }
        unset($info['MiniProgramInfo']);
        // 微信认证: -1 代表未认证, 0 代表微信认证
        $info['verify_type'] = intval($info['verify_type_info']) !== 0 ? -1 : 0;
        return $info;
    }

}
