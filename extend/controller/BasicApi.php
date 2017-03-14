<?php

namespace controller;

use think\Cache;
use think\Request;
use think\Response;

/**
 * 数据接口通用控制器
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
        $this->request = is_null($request) ? Request::instance() : $request;
        if (in_array($this->request->action(), ['response', 'setcache', 'getcache', 'delcache', '_empty'])) {
            exit($this->response('禁止访问接口安全方法！', 'ACCESS_NOT_ALLOWED')->send());
        }
        $this->token = $this->request->request('token', $this->request->header('token', false));
        if ((empty($this->token) || !$this->getCache($this->token)) && ($this->request->action() !== 'auth')) {
            exit($this->response('访问TOKEN失效，请重新授权！', 'ACCESS_TOKEN_FAILD')->send());
        }
        // CORS 跨域 Options 检测响应
        if ($this->request->isOptions()) {
            header('Access-Control-Allow-Origin:*');
            header('Access-Control-Allow-Headers:Accept,Referer,Host,Keep-Alive,User-Agent,X-Requested-With,Cache-Control,Content-Type,token');
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
            header('Access-Control-Max-Age:1728000');
            header('Content-Type:text/plain charset=UTF-8');
            header('Content-Length: 0', true);
            header('status: 204');
            header('HTTP/1.0 204 No Content');
            exit;
        }
    }

    /**
     * 输出返回数据
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param String    $type 返回类型 JSON XML
     * @param integer   $code HTTP状态码
     * @return Response
     */
    public function response($msg, $code = 'SUCCESS', $data = [], $type = 'json') {
        $result = ['code' => $code, 'msg' => $msg, 'data' => $data, 'token' => $this->token, 'dataType' => strtolower($type)];
        return Response::create($result, $type)->code(200);
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
     * @param mixed  $default 默认值
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
            $Api = "app\\{$module}\\{$controller}\\{$action}Api";
            if (method_exists($Api, $method)) {
                return $Api::$method($this);
            }
            return $this->response('访问的接口不存在！', 'NOT_FOUND');
        }
        return $this->response('不符合标准的接口！', 'API_ERROR');
    }

}
