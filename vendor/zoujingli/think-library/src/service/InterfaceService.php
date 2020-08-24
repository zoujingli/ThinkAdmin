<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\service;

use think\admin\extend\HttpExtend;
use think\admin\helper\ValidateHelper;
use think\admin\Service;
use think\App;
use think\exception\HttpResponseException;

/**
 * 系统接口基础服务
 * Class InterfaceService
 * @package think\admin\service
 */
class InterfaceService extends Service
{
    /**
     * 接口认证账号
     * @var string
     */
    public $appid;

    /**
     * 接口认证密钥
     * @var string
     */
    public $appkey;

    /**
     * 接口请求地址
     * @var string
     */
    public $baseapi;

    /**
     * 接口服务初始化
     * OpenService constructor.
     * @param App $app
     * @param string $appid 接口账号
     * @param string $appkey 接口密钥
     * @param string $baseapi 接口地址
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function __construct(App $app, $appid = '', $appkey = '', $baseapi = '')
    {
        parent::__construct($app);
        $this->appid = $appid ?: sysconf('data.interface_appid');
        $this->appkey = $appkey ?: sysconf('data.interface_appkey');
        $this->baseapi = $baseapi ?: sysconf('data.interface_baseapi');
    }

    /**
     * 获取接口账号
     * @return string
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * 获取请求数据
     * @return array
     */
    public function get(): array
    {
        // 基础参数获取
        $input = ValidateHelper::instance()->init([
            'appid.require' => lang('think_library_params_failed_empty', ['appid']),
            'nostr.require' => lang('think_library_params_failed_empty', ['nostr']),
            'time.require'  => lang('think_library_params_failed_empty', ['time']),
            'sign.require'  => lang('think_library_params_failed_empty', ['sign']),
            'data.require'  => lang('think_library_params_failed_empty', ['data']),
        ], 'post', [$this, 'baseError']);
        // 接口参数处理
        if ($input['appid'] !== $this->appid) {
            $this->baseError(lang('think_library_params_failed_auth'));
        }
        // 请求时间检查
        if (abs($input['time'] - time()) > 30) {
            $this->baseError(lang('think_library_params_failed_time'));
        }
        // 请求签名验证
        if (!$this->_checkSign($input)) {
            $this->baseError(lang('think_library_params_failed_sign'));
        }
        // 解析请求数据
        return json_decode($input['data'], true) ?: [];
    }

    /**
     * 回复业务处理失败的消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回状态码
     */
    public function error($info, $data = '{-null-}', $code = 0)
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
    public function success($info, $data = '{-null-}', $code = 1)
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
    public function baseError($info, $data = [], $code = 0)
    {
        $this->baseResponse($info, $data, $code);
    }

    /**
     * 回复根成功消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 根状态码
     */
    public function baseSuccess($info, $data = [], $code = 1)
    {
        $this->baseResponse($info, $data, $code);
    }

    /**
     * 回复根签名消息
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 根状态码
     */
    public function baseResponse($info, $data = [], $code = 1)
    {
        $extend = ['code' => $code, 'info' => $info, 'data' => $data, 'appid' => $data['appid']];
        throw new HttpResponseException(json(array_merge($this->_buildSign($data), $extend)));
    }

    /**
     * 接口数据请求
     * @param string $uri 接口地址
     * @param array $data 请求数据
     * @return array
     * @throws \think\admin\Exception
     */
    public function doRequest(string $uri, array $data = []): array
    {
        $result = json_decode(HttpExtend::post($this->baseapi . $uri, $this->_buildSign($data)), true);
        if (empty($result)) throw new \think\admin\Exception(lang('think_library_response_failed'));
        if (empty($result['code'])) throw new \think\admin\Exception($result['info']);
        return $result['data'] ?? [];
    }

    /**
     * 请求数据签名验证
     * @param array $data 待检查数据
     * @return boolean
     */
    private function _checkSign(array $data): bool
    {
        if (isset($data['sign']) && isset($data['appid']) && isset($data['data']) && isset($data['time']) && isset($data['nostr'])) {
            return md5("{$data['appid']}#{$data['data']}#{$data['time']}#{$this->appkey}#{$data['nostr']}") === $data['sign'];
        } else {
            return false;
        }
    }

    /**
     * 接口数据签名
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