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

namespace service;

use library\Sms;
use think\Cache;

/**
 * 短信服务
 *
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/12/14 16:50
 */
class SmsService extends BasicService {

    /**
     * 给手机发送短信
     * @param string $phone 手机号码
     * @param string $content 短信内容
     * @param array $data 短信内容模板数据
     * @return bool
     */
    static public function send($phone, $content, $data = []) {
        $sms = new Sms();
        return $sms->render($content, $data)->send($phone);
    }

    /**
     * 给指定手机号码发送验证码
     * @param string $phone 手机号码
     * @param int $length 验证码长度
     * @param string $string 验证码可选字符
     * @param string $code
     * @return array
     */
    static public function verify($phone, $length = 4, $string = "0123456789", $code = '') {
        $max = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string[rand(0, $max)];
        }
        $cache_key = "sms_verify_{$phone}";
        $cache = Cache::get($cache_key);
        if ($cache && !empty($cache['time']) && $cache['time'] + 60 > time()) {
            return self::_data('同一手机号码60秒内只能发送一条短信哦！', 'SMS_60S_ONLY_SEND_A_SMS');
        }
        $result = self::send($phone, 'sms_tpl_register', ['code' => $code]);
        if ($result) {
            $cache = ['phone' => $phone, 'code' => $code, 'time' => time()];
            Cache::set($cache_key, $cache, 180);
            return self::_data('验证码发送成功，请查看手机短信！', 'SUCCESS');
        }
        return self::_data('验证码发送失败，请稍候再试！', 'ERROR');
    }

    /**
     * 获取再次发送短信的等待时间
     * @param string $phone
     * @return int
     */
    static public function getVerifyWaitTime($phone) {
        $cache_key = "sms_verify_{$phone}";
        $cache = Cache::get($cache_key);
        if (empty($cache) || empty($cache['time']) || $cache['time'] + 60 < time()) {
            return 0;
        }
        return time() - $cache['time'] - 60;
    }

    /**
     * 统一验证码验证
     * @param string $phone
     * @param string $code
     * @return array
     */
    static public function checkVerify($phone, $code) {
        $cache_key = "sms_verify_{$phone}";
        $cache = Cache::get($cache_key);
        if (empty($cache) || empty($cache['code']) || $cache['code'] !== $code) {
            return self::_data('验证码验证失败，请输入正确的验证码！', 'SMS_VERIFY_FAILD');
        }
        Cache::rm($cache_key);
        return self::_data('验证码验证成功！', 'SUCCESS');
    }

}
