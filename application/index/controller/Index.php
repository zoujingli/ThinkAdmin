<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\index\controller;

use library\Http;
use think\Controller;
use think\Db;

class Index extends Controller {

    public function index() {
        $this->redirect('@admin');
        $version = Db::query('select version() as ver');
        $version = array_pop($version);
        $this->assign('mysql_ver', $version['ver']);
        return view();
    }

    public function test() {
        $DEVICE_NO = 'kdt1080126';
        $key = '20585';
        $content = "";
        $content .= "^Q +http://weixin.qq.com/r/2Eg2LkzEKRFWrQhN9123";
        $result = $this->sendSelfFormatOrderInfo($DEVICE_NO, $key, 1, $content);
        var_dump($result);
    }

    function sendSelfFormatOrderInfo($device_no, $key, $times, $orderInfo) { // $times打印次数
        $selfMessage = array(
            'deviceNo'     => $device_no,
            'printContent' => $orderInfo,
            'key'          => $key,
            'times'        => $times
        );
        $url = "http://open.printcenter.cn:8080/addOrder";
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded ",
                'method'  => 'POST',
                'content' => http_build_query($selfMessage),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

}
