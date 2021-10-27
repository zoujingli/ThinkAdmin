<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\service;

use stdClass;
use think\admin\Exception;
use think\admin\extend\HttpExtend;
use think\admin\helper\ValidateHelper;
use think\admin\Service;
use think\App;
use think\exception\HttpResponseException;

/**
 * 通用接口基础服务
 * Class InterfaceService
 * @package think\admin\service
 */
class InterfaceService extends Service
{
    /**
     * 输出格式
     * @var string
     */
    private $type = 'json';

    /**
     * 接口认证账号
     * @var string
     */
    private $appid;

    /**
     * 接口认证密钥
     * @var string
     */
    private $appkey;

    /**
     * 接口请求地址
     * @var string
     */
    private $getway;

    /**
     * 接口服务初始化
     * InterfaceService constructor.
     * @param App $app
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->appid = sysconf('data.interface_appid') ?: '';
        $this->appkey = sysconf('data.interface_appkey') ?: '';
        $this->getway = sysconf('data.interface_getway') ?: '';
    }

    /**
     * 设置接口网关
     * @param string $getway 接口网关
     * @return $this
     */
    public function getway(string $getway): InterfaceService
    {
        $this->getway = $getway;
        return $this;
    }

    /**
     * 设置授权账号
     * @param string $appid 接口账号
     * @param string $appkey 接口密钥
     * @return $this
     */
    public function setAuth(string $appid, string $appkey): InterfaceService
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
        return $this;
    }

    /**
     * 设置输出类型为 JSON
     * @return $this
     */
    public function setOutTypeJson(): InterfaceService
    {
        $this->type = 'json';
        return $this;
    }

    /**
     * 设置输出类型为 Array
     * @return $this
     */
    public function setOutTypeArray(): InterfaceService
    {
        $this->type = 'array';
        return $this;
    }

    /**
     * 获取当前APPID
     * @return string
     */
    public function getAppid(): string
    {
        return $this->appid ?: '';
    }

    /**
     * 获取请求参数
     * @return array
     */
    public function getData(): array
    {
        // 基础参数获取
        $input = ValidateHelper::instance()->init([
            'time.require'  => lang('think_library_params_failed_empty', ['time']),
            'sign.require'  => lang('think_library_params_failed_empty', ['sign']),
            'data.require'  => lang('think_library_params_failed_empty', ['data']),
            'appid.require' => lang('think_library_params_failed_empty', ['appid']),
            'nostr.require' => lang('think_library_params_failed_empty', ['nostr']),
        ], 'post', [$this, 'baseError']);

        // 检查请求签名，使用通用签名方式
        $build = $this->signString($input['data'], $input['time'], $input['nostr']);
        if ($build['sign'] !== $input['sign']) {
            $this->baseError(lang('think_library_params_failed_sign'));
        }

        // 检查请求时间，与服务差不能超过 30 秒
        if (intval($input['time']) - time() > 30) {
            $this->baseError(lang('think_library_params_failed_time'));
        }

        // 返回并解析数据内容，如果解析失败返回空数组
        return json_decode($input['data'], true) ?: [];
    }

    /**
     * 回复业务处理失败的消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回状态码
     */
    public function error($info, $data = '{-null-}', $code = 0): void
    {
        if ($data === '{-null-}') $data = new stdClass();
        $this->baseResponse(lang('think_library_response_failed'), [
            'code' => $code, 'info' => $info, 'data' => $data,
        ]);
    }

    /**
     * 回复业务处理成功的消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回状态码
     */
    public function success($info, $data = '{-null-}', $code = 1): void
    {
        if ($data === '{-null-}') $data = new stdClass();
        $this->baseResponse(lang('think_library_response_success'), [
            'code' => $code, 'info' => $info, 'data' => $data,
        ]);
    }

    /**
     * 回复根失败消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 根状态码
     */
    public function baseError($info, $data = [], $code = 0): void
    {
        $this->baseResponse($info, $data, $code);
    }

    /**
     * 回复根成功消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 根状态码
     */
    public function baseSuccess($info, $data = [], $code = 1): void
    {
        $this->baseResponse($info, $data, $code);
    }

    /**
     * 回复根签名消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 根状态码
     */
    public function baseResponse($info, $data = [], $code = 1): void
    {
        $array = $this->signData($data);
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'time' => $array['time'],
            'sign' => $array['sign'], 'appid' => $array['appid'], 'nostr' => $array['nostr'],
            'data' => $this->type !== 'json' ? json_decode($array['data'], true) : $array['data'],
        ]));
    }

    /**
     * 接口数据模拟请求
     * @param string $uri 接口地址
     * @param array $data 请求数据
     * @param boolean $check 验证结果
     * @return array
     * @throws Exception
     */
    public function doRequest(string $uri, array $data = [], bool $check = true): array
    {
        $url = rtrim($this->getway, '/') . '/' . ltrim($uri, '/');
        $content = HttpExtend::post($url, $this->signData($data)) ?: '';
        // 解析返回的结果
        if (!($result = json_decode($content, true)) || empty($result)) {
            throw new Exception('接口请求异常，请检查地址是否正确！');
        }
        // 返回业务异常结果
        if (empty($result['code'])) throw new Exception($result['info']);
        $array = is_array($result['data']) ? $result['data'] : json_decode($result['data'], true);
        // 无需验证直接返回
        if (empty($check)) return $array;
        // 返回结果签名验证
        $json = is_string($result['data']) ? $result['data'] : json_encode($result['data'], JSON_UNESCAPED_UNICODE);
        $build = $this->signString($json, $result['time'], $result['nostr']);
        if ($build['sign'] === $result['sign']) return $array ?: [];
        throw new Exception('返回结果签名验证失败！');
    }

    /**
     * 接口响应数据签名
     * @param array $data ['appid','nostr','time','sign','data']
     * @return array
     */
    private function signData(array $data): array
    {
        return $this->signString(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 数据字符串数据签名
     * @param string $json 待签名的数据
     * @param mixed $time 签名的时间戳
     * @param mixed $rand 签名随机字符
     * @return array
     */
    private function signString(string $json, $time = null, $rand = null): array
    {
        $time = strval($time ?: time());
        $rand = strval($rand ?: md5(uniqid('', true)));
        $sign = md5("{$this->appid}#{$json}#{$time}#{$this->appkey}#{$rand}");
        return ['appid' => $this->appid, 'nostr' => $rand, 'time' => $time, 'sign' => $sign, 'data' => $json];
    }
}