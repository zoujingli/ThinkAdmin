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

namespace app\wechat\command\fans;

use app\wechat\command\Fans;

/**
 * 粉丝黑名单指令
 * Class FansBlack
 * @package app\wechat\command\fans
 */
class FansBlack extends Fans
{
    /**
     * 配置入口
     */
    protected function configure()
    {
        $this->module = ['black'];
        $this->setName('xfans:black')->setDescription('[同步]微信黑名单粉丝数据');
    }
}
