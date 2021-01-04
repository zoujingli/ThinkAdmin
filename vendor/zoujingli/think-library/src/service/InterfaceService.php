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
     * 调试模式
     * @var bool
     */
    private $debug;

    /**
     * 请求数据
     * @var array
     */
    private $input;

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
    private $baseurl;

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
        $this->baseurl = sysconf('data.interface_baseapi') ?: '';
    }

    /**
     * 设置调试模式
     * @param boolean $debug
     * @return $this
     */
    public function debug(bool $debug): InterfaceService
    {
        $this->debug = boolval($debug);
        return $this;
    }

    /**
     * 获取接口账号
     * @return string
     */
    public function getAppid(): string
    {
        return $this->appid;
    }

    /**
     * 获取接口地址
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseurl;
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
     * 设置接口网关地址
     * @param string $getway 网关地址
     * @return $this
     */
    public function getway(string $getway): InterfaceService
    {
        $this->baseurl = $getway;
        return $this;
    }

    /**
     * 获取请求数据
     * @param boolean $check 验证数据
     * @return mixed
     */
    public function getInput(bool $check = true)
    {
        // 基础参数获取
        $this->input = ValidateHelper::instance()->init([
            'appid.require' => lang('think_library_params_failed_empty', ['appid']),
            'nostr.require' => lang('think_library_params_failed_empty', ['nostr']),
            'time.require'  => lang('think_library_params_failed_empty', ['time']),
            'sign.require'  => lang('think_library_params_failed_empty', ['sign']),
            'data.require'  => lang('think_library_params_failed_empty', ['data']),
        ], 'post', [$this, 'baseError']);
        // 请求时间检查
        if (abs($this->input['time'] - time()) > 30) {
            $this->baseError(lang('think_library_params_failed_time'));
        }
        return $check ? $this->showCheck() : $this->input;
    }

    /**
     * 请求数据签名验证
     * @return bool|null
     */
    public function checkInput()
    {
        if ($this->debug) return true;
        if (empty($this->input)) $this->getInput(false);
        if ($this->input['appid'] !== $this->appid) return null;
        return md5("{$this->appid}#{$this->input['data']}#{$this->input['time']}#{$this->appkey}#{$this->input['nostr']}") === $this->input['sign'];
    }

    /**
     * 显示检查结果
     * @return $this
     */
    public function showCheck(): InterfaceService
    {
        if ($this->debug) return $this;
        if (is_null($check = $this->checkInput())) {
            $this->baseError(lang('think_library_params_failed_auth'));
        } elseif ($check === false) {
            $this->baseError(lang('think_library_params_failed_sign'));
        }
        return $this;
    }

    /**
     * 获取请求参数
     * @return array
     */
    public function getData(): array
    {
        if ($this->debug) {
            return $this->app->request->request();
        } else {
            if (empty($this->input)) $this->getInput(true);
            return json_decode($this->input['data'], true) ?: [];
        }
    }

    /**
     * 回复业务处理失败的消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回状态码
     */
    public function error($info, $data = '{-null-}', $code = 0): void
    {
        if ($data === '{-null-}') $data = new \stdClass();
        $this->baseResponse(lang('think_library_response_success'), ['code' => $code, 'info' => $info, 'data' => $data], 1);
    }

    /**
     * 回复业务处理成功的消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回状态码
     */
    public function success($info, $data = '{-null-}', $code = 1): void
    {
        if ($data === '{-null-}') $data = new \stdClass();
        $this->baseResponse(lang('think_library_response_success'), ['code' => $code, 'info' => $info, 'data' => $data], 1);
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
        $array = $this->_buildSign($data);
        throw new HttpResponseException(json([
            'code'  => $code, 'info' => $info, 'time' => $array['time'], 'sign' => $array['sign'],
            'appid' => input('appid', null), 'nostr' => $array['nostr'], 'data' => $data,
        ]));
    }

    /**
     * 接口数据模拟请求
     * @param string $uri 接口地址
     * @param array $data 请求数据
     * @return array
     * @throws \think\admin\Exception
     */
    public function doRequest(string $uri, array $data = []): array
    {
        $result = json_decode(HttpExtend::post($this->baseurl . $uri, $this->_buildSign($data)), true);
        if (empty($result)) throw new \think\admin\Exception(lang('think_library_response_failed'));
        if (empty($result['code'])) throw new \think\admin\Exception($result['info']);
        return $result['data'] ?? [];
    }

    /**
     * 接口响应数据签名
     * @param array $data ['appid','nostr','time','sign','data']
     * @return array
     */
    private function _buildSign(array $data): array
    {
        [$time, $nostr, $json] = [time(), uniqid(), json_encode($data, 256)];
        $sign = md5("{$this->appid}#{$json}#{$time}#{$this->appkey}#{$nostr}");
        return ['appid' => $this->appid, 'nostr' => $nostr, 'time' => $time, 'sign' => $sign, 'data' => $json];
    }
}