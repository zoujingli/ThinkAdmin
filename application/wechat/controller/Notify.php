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

namespace app\wechat\controller;

use think\Controller;

/**
 * 微信支付通知处理控制器
 * Class Notify
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/04/05 14:02
 */
class Notify extends Controller {

    public function index() {
        // 实例支付接口
        $pay = &load_wechat('Pay');

        // 获取支付通知
        $notifyInfo = $pay->getNotify();
        p($notifyInfo);

        // 支付通知数据获取失败
        if ($notifyInfo === FALSE) {
            // 接口失败的处理
            echo $pay->errMsg;
        } else {
            //支付通知数据获取成功
            if ($notifyInfo['result_code'] == 'SUCCESS' && $notifyInfo['return_code'] == 'SUCCESS') {
                // 支付状态完全成功，可以更新订单的支付状态了
                // @todo 这里去完成你的订单状态修改操作
                // 回复xml，replyXml方法是终态方法
                $pay->replyXml(['return_code' => 'SUCCESS', 'return_msg' => 'DEAL WITH SUCCESS']);
            }
        }
    }

}
