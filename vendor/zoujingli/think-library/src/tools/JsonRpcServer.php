<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

use think\App;
use think\Container;
use think\exception\HttpResponseException;

/**
 * JsonRpc 服务端
 * Class JsonRpcServer
 * @package think\admin\extend
 */
class JsonRpcServer
{
    /**
     * 当前App对象
     * @var App
     */
    protected $app;

    /**
     * JsonRpcServer constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * 静态实例对象
     * @return static
     */
    public static function instance()
    {
        return Container::getInstance()->make(static::class);
    }

    /**
     * 设置监听对象
     * @param mixed $object
     */
    public function handle($object)
    {
        // Checks if a JSON-RCP request has been received
        if ($this->app->request->method() !== "POST" || $this->app->request->contentType() != 'application/json') {
            echo "<h2>" . get_class($object) . "</h2>";
            foreach (get_class_methods($object) as $method) {
                if ($method[0] !== '_') echo "<p>method {$method}()</p>";
            }
        } else {
            // Reads the input data
            $request = json_decode(file_get_contents('php://input'), true);
            if (empty($request)) {
                $error = ['code' => '-32700', 'message' => '语法解析错误', 'meaning' => '服务端接收到无效的JSON'];
                $response = ['jsonrpc' => '2.0', 'id' => $request['id'], 'result' => null, 'error' => $error];
            } elseif (!isset($request['id']) || !isset($request['method']) || !isset($request['params'])) {
                $error = ['code' => '-32600', 'message' => '无效的请求', 'meaning' => '发送的JSON不是一个有效的请求对象'];
                $response = ['jsonrpc' => '2.0', 'id' => $request['id'], 'result' => null, 'error' => $error];
            } else try {
                // Executes the task on local object
                if ($result = @call_user_func_array([$object, $request['method']], $request['params'])) {
                    $response = ['jsonrpc' => '2.0', 'id' => $request['id'], 'result' => $result, 'error' => null];
                } else {
                    $error = ['code' => '-32601', 'message' => '找不到方法', 'meaning' => '该方法不存在或无效'];
                    $response = ['jsonrpc' => '2.0', 'id' => $request['id'], 'result' => null, 'error' => $error];
                }
            } catch (\Exception $e) {
                $error = ['code' => $e->getCode(), 'message' => $e->getMessage()];
                $response = ['jsonrpc' => '2.0', 'id' => $request['id'], 'result' => null, 'error' => $error];
            }
            // Output the response
            throw new HttpResponseException(json($response)->contentType('text/javascript'));
        }
    }
}