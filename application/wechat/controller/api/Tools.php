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

namespace app\wechat\controller\api;

use controller\BasicAdmin;
use service\WechatService;

/**
 * 公众号测试工具
 * Class Tools
 * @package app\wechat\controller\api
 */
class Tools extends BasicAdmin
{
    /**
     * 网页授权测试
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function oauth()
    {
        $fans = WechatService::webOauth(1);
        return $this->fetch('', ['fans' => $fans]);
    }

}