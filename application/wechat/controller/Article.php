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

namespace app\wechat\controller;

use controller\BasicAdmin;

/**
 * 微信文章管理
 * Class Article
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Article extends BasicAdmin {

    public function index($p1Str, $p2Str, $p3Str, $dStr) {
        list($x1, $y1) = explode(',', $p1Str);
        list($x2, $y2) = explode(',', $p2Str);
        list($x3, $y3) = explode(',', $p3Str);
        list($d1, $d2, $d3) = explode(',', $dStr);
        $va = (($d2 * $d2 - $d3 * $d3) - ($x2 * $x2 - $x3 * $x3) - ($y2 * $y2 - $y3 * $y3)) / 2;
        $vb = (($d2 * $d2 - $d1 * $d1) - ($x2 * $x2 - $x1 * $x1) - ($y2 * $y2 - $y1 * $y1)) / 2;
        $y_point = ($vb * ($x3 - $x2) - $va * ($x1 - $x2)) / (($y1 - $y2) * ($x3 - $x2) - ($y3 - $y2) * ($x1 - $x2));
        $x_point = ($va - $y_point * ($y3 - $y2)) / ($x3 - $x2);
        return ['x' => $x_point, 'y' => $y_point];
    }
}
