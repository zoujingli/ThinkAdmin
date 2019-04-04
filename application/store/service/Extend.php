<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\store\service;

use library\tools\Http;
use think\Db;

/**
 * 业务扩展服务
 * Class Extend
 * @package app\store\service
 */
class Extend
{

    /**
     * 发送短信验证码
     * @param string $mid 会员ID
     * @param string $phone 手机号
     * @param string $content 短信内容
     * @param string $productid 短信通道ID
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function sendSms($mid, $phone, $content, $productid = '676767')
    {
        $tkey = date("YmdHis");
        $data = [
            'tkey'      => $tkey,
            'mobile'    => $phone,
            'content'   => $content,
            'username'  => sysconf('sms_zt_username'),
            'productid' => $productid,
            'password'  => md5(md5(sysconf('sms_zt_password')) . $tkey),
        ];
        $result = Http::post('http://www.ztsms.cn/sendNSms.do', $data);
        list($code, $msg) = explode(',', $result . ',');
        $insert = ['mid' => $mid, 'phone' => $phone, 'content' => $content, 'result' => $result];
        Db::name('StoreMemberSmsHistory')->insert($insert);
        return intval($code) === 1;
    }

    /**
     * 查询短信余额
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function querySmsBalance()
    {
        $tkey = date("YmdHis");
        $data = [
            'tkey'     => $tkey,
            'username' => sysconf('sms_zt_username'),
            'password' => md5(md5(sysconf('sms_zt_password')) . $tkey),
        ];
        $result = Http::post('http://www.ztsms.cn/balanceN.do', $data);
        if ($result > -1) {
            return ['code' => 1, 'num' => $result, 'msg' => '获取短信剩余条数成功！'];
        } elseif ($result > -2) {
            return ['code' => 0, 'num' => '0', 'msg' => '用户名或者密码不正确！'];
        } elseif ($result > -3) {
            return ['code' => 0, 'num' => '0', 'msg' => 'tkey不正确！'];
        } elseif ($result > -4) {
            return ['code' => 0, 'num' => '0', 'msg' => '用户不存在或用户停用！'];
        }
    }

}