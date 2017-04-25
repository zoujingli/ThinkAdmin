<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace hook;

use think\Request;

/**
 * 视图输出过滤
 * Class FilterView
 * @package hook
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/04/25 11:59
 */
class FilterView {

    /**
     * 行为入口
     * @param $params
     */
    public function run(&$params) {
        $app = Request::instance()->root(true);
        $replace = [
            '__APP__'    => $app,
            '__SELF__'   => Request::instance()->url(true),
            '__PUBLIC__' => strpos($app, EXT) ? ltrim(dirname($app), DS) : $app,
        ];
        $params = str_replace(array_keys($replace), array_values($replace), $params);
        $this->baidu($params);
        $this->cnzz($params);
    }

    /**
     * 百度统计实现代码
     * @param $params
     */
    public function baidu(&$params) {
        // @todo 百度统计
    }

    /**
     * CNZZ统计实现代码
     * @param $params
     */
    public function cnzz(&$params) {
        // @todo CNZZ统计
    }

}
