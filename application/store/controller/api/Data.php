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

namespace app\store\controller\api;

use library\Controller;

/**
 * 数据商城基础数据
 * Class Data
 * @package app\store\controller\api
 */
class Data extends Controller
{
    /**
     * 获取轮播图片数据
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function getSlider()
    {
        $this->keys = input('keys', 'slider_home');
        $this->success('获取轮播图片数据！', sysdata($this->keys));
    }

}