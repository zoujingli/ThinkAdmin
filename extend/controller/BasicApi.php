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

namespace controller;

use service\ToolsService;
use think\Cache;
use think\Request;
use think\Response;

/**
 * 数据接口通用控制器
 * Class BasicApi
 * @package controller
 */
class BasicApi {

    /**
     * 访问请求对象
     * @var Request
     */
    public $request;

    /**
     * 当前访问身份
     * @var string
     */
    public $token;

    /**
     * 基础接口SDK
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        // CORS 跨域 Options 检测响应
        ToolsService::corsOptionsHandler();
        // 获取当前 Request 对象
        $this->request = is_null($request) ? Request::instance() : $request;
        // 安全方法请求过滤
        if (in_array(strtolower($this->request->action()), ['response', 'setcache', 'getcache', 'delcache', '_empty'])) {
            exit($this->response('禁止访问接口安全方法！', 'ACCESS_NOT_ALLOWED')->send());
        }
        // 访问 Token 检测处理
        $this->token = $this->request->param('token', $this->request->header('token', false));
        if (empty($this->token) && !method_exists($this, $this->request->action())) {
            exit($this->response('访问TOKEN失效，请重新授权！', 'ACCESS_TOKEN_FAILD')->send());
        }
    }

    /**
     * 输出返回数据
     * @param string $msg 提示消息内容
     * @param string $code 业务状态码
     * @param mixed $data 要返回的数据
     * @param string $type 返回类型 JSON XML
     * @return Response
     */
    public function response($msg, $code = 'SUCCESS', $data = [], $type = 'json') {
        $result = ['msg' => $msg, 'code' => $code, 'data' => $data, 'token' => $this->token, 'dataType' => strtolower($type)];
        return Response::create($result, $type)->header(ToolsService::corsRequestHander())->code(200);
    }

    /**
     * 写入缓存
     * @param string $name 缓存标识
     * @param mixed $value 存储数据
     * @param int|null $expire 有效时间 0为永久
     * @return bool
     */
    public function setCache($name, $value, $expire = null) {
        return Cache::set("{$this->token}_{$name}", $value, $expire);
    }

    /**
     * 读取缓存
     * @param string $name 缓存标识
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getCache($name, $default = false) {
        return Cache::get("{$this->token}_{$name}", $default);
    }

    /**
     * 删除缓存
     * @param string $name 缓存标识
     * @return bool
     */
    public function delCache($name) {
        return Cache::rm("{$this->token}_{$name}");
    }

    /**
     * API接口调度
     * @return Response
     */
    public function _empty() {
        list($module, $controller, $action, $method) = explode('/', $this->request->path() . '///');
        if (!empty($module) && !empty($controller) && !empty($action) && !empty($method)) {
            $action = ucfirst($action);
            $Api = config('app_namespace') . "\\{$module}\\{$controller}\\{$action}Api";
            if (method_exists($Api, $method)) {
                return $Api::$method($this);
            }
            return $this->response('访问的接口不存在！', 'API_NOT_FOUND');
        }
        return $this->response('不符合标准的接口！', 'API_ERROR');
    }

}
