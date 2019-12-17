<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\service;

use library\Service;
use think\exception\HttpResponseException;

/**
 * JsonRpc 服务端服务
 * Class JsonRpcServerService
 * @package think\admin\service
 */
class JsonRpcServerService extends Service
{
    /**
     * 设置监听对象
     * @param mixed $object
     * @throws \think\Exception
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
            if (empty($request['id'])) {
                throw new \think\Exception('JsonRpc Request id cannot be empty');
            }
            // Executes the task on local object
            try {
                if ($result = @call_user_func_array([$object, $request['method']], $request['params'])) {
                    $response = ['id' => $request['id'], 'result' => $result, 'error' => null];
                } else {
                    $response = ['id' => $request['id'], 'result' => null, 'error' => 'unknown method or incorrect parameters'];
                }
            } catch (\Exception $e) {
                $response = ['id' => $request['id'], 'result' => null, 'error' => $e->getMessage()];
            }
            // Output the response
            throw new HttpResponseException(json($response)->contentType('text/javascript'));
        }
    }

}