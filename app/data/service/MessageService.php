<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 短信支持服务
 * Class MessageService
 * @package app\data\service
 */
class MessageService extends Service
{
    /**
     * 平台授权账号
     * @var string
     */
    protected $username;

    /**
     * 平台授权密码
     * @var string
     */
    protected $password;

    /**
     * 短信服务初始化
     * @return MessageService
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize(): MessageService
    {
        $this->username = sysconf('zt.username');
        $this->password = sysconf('zt.password');
        return $this;
    }

    /**
     * 发送自定义短信内容
     * @param string $phone
     * @param string $content
     * @return array
     */
    public function send(string $phone, string $content): array
    {
        [$state, $message, $record] = $this->_request('v2/sendSms', ['mobile' => $phone, 'content' => $content]);
        $this->app->db->name('DataUserMessage')->insert([
            'phone' => $phone, 'content' => $content, 'result' => $message, 'status' => $state ? 1 : 0,
        ]);
        return [$state, $message, $record];
    }

    /**
     * 短信条数查询
     */
    public function balance(): array
    {
        [$state, $message, $result] = $this->_request('v2/balance', []);
        return [$state, $message, $state ? $result['sumSms'] : 0];
    }

    /**
     * 验证手机短信验证码
     * @param string $code 验证码
     * @param string $phone 手机号验证
     * @param string $tplcode
     * @return boolean
     */
    public function checkVerifyCode(string $code, string $phone, string $tplcode = 'zt.tplcode_register'): bool
    {
        $cache = $this->app->cache->get($ckey = md5("code-{$tplcode}-{$phone}"), []);
        return is_array($cache) && isset($cache['code']) && $cache['code'] == $code;
    }

    /**
     * 验证手机短信验证码
     * @param string $phone 手机号码
     * @param integer $wait 等待时间
     * @param string $tplcode 模板编号
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sendVerifyCode(string $phone, int $wait = 120, string $tplcode = 'zt.tplcode_register'): array
    {
        $content = sysconf($tplcode) ?: '您的短信验证码为{code}，请在十分钟内完成操作！';
        $cache = $this->app->cache->get($ckey = md5("code-{$tplcode}-{$phone}"), []);
        // 检查是否已经发送
        if (is_array($cache) && isset($cache['time']) && $cache['time'] > time() - $wait) {
            $dtime = ($cache['time'] + $wait < time()) ? 0 : ($wait - time() + $cache['time']);
            return [1, '短信验证码已经发送！', ['time' => $dtime]];
        }
        // 生成新的验证码
        [$code, $time] = [rand(100000, 999999), time()];
        $this->app->cache->set($ckey, ['code' => $code, 'time' => $time], 600);
        // 尝试发送短信内容
        [$state] = $this->send($phone, preg_replace_callback("|{(.*?)}|", function ($matches) use ($code) {
            return $matches[1] === 'code' ? $code : $matches[1];
        }, $content));
        if ($state) return [1, '短信验证码发送成功！', [
            'time' => ($time + $wait < time()) ? 0 : ($wait - time() + $time)],
        ]; else {
            $this->app->cache->delete($ckey);
            return [0, '短信发送失败，请稍候再试！', []];
        }
    }

    /**
     * 执行网络请求
     * @param string $url 接口请求地址
     * @param array $data 接口请求参数
     * @return array
     */
    private function _request(string $url, array $data): array
    {
        $encode = md5(md5($this->password) . ($tkey = time()));
        $option = ['headers' => ['Content-Type:application/json;charset=UTF-8']];
        $request = json_encode(array_merge($data, ['username' => $this->username, 'password' => $encode, 'tKey' => $tkey]));
        $result = json_decode(http_post("https://api.mix2.zthysms.com/{$url}", $request, $option), true);
        if (empty($result['code'])) {
            return [0, '接口请求网络异常', []];
        } elseif (intval($result['code']) === 200) {
            return [1, $this->_error($result['code']), $result];
        } else {
            return [0, $this->_error($result['code']), $result];
        }
    }

    /**
     * 获取状态描述
     * @param integer $code
     * @return string
     */
    private function _error(int $code): string
    {
        $arrs = [
            200  => '提交成功',
            4001 => '用户名错误',
            4002 => '密码不能为空',
            4003 => '短信内容不能为空',
            4004 => '手机号码错误',
            4006 => 'IP鉴权错误',
            4007 => '用户禁用',
            4008 => 'tKey错误',
            4009 => '密码错误',
            4011 => '请求错误',
            4013 => '定时时间错误',
            4014 => '模板错误',
            4015 => '扩展号错误',
            4019 => '用户类型错误',
            4023 => '签名错误',
            4025 => '模板变量内容为空',
            4026 => '手机号码数最大2000个',
            4027 => '模板变量内容最大200组',
            4029 => '请使用 POST 请求',
            4030 => 'Content-Type 请使用 application/json',
            4031 => '模板名称不能为空',
            4032 => '模板类型不正确',
            4034 => '模板内容不能为空',
            4035 => '模板名称已经存在',
            4036 => '添加模板信息失败',
            4037 => '模板名称最大20字符',
            4038 => '模板内容超过最大字符数',
            4040 => '模板内容缺少变量值或规则错误',
            4041 => '模板内容中变量规范错误',
            4042 => '模板变量个数超限',
            4044 => '接口24小时限制提交次数超限',
            9998 => 'JSON解析错误',
            9999 => '非法请求',
        ];
        return $arrs[$code] ?? $code;
    }

}