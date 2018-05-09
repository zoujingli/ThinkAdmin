<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\service;

use service\DataService;

/**
 * 会员数据初始化
 * Class MemberService
 * @package app\store\service
 */
class MemberService
{
    /**
     * 创建会员数据
     * @param array $data 会员数据
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function create($data)
    {
        return DataService::save('StoreMember', $data, 'id');
    }
}