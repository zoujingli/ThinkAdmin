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

namespace think\admin\service;

use think\admin\extend\CodeExtend;
use think\admin\Service;

/**
 * JsonRpc 客户端服务
 * Class JsonRpcClientService
 * @package think\admin\service
 */
class JsonRpcClientService extends Service
{
    /**
     * 调式状态
     * @var boolean
     */
    private $debug;

    /**
     * 服务端地址
     * @var string
     */
    private $proxy;

    /**
     * 请求ID
     * @var integer
     */
    private $requestId;

    /**
     * 通知状态
     * @var boolean
     */
    private $notification = false;

    /**
     * 创建连接对象
     * @param string $proxy
     * @param boolean $debug
     * @return $this
     */
    public function create($proxy, $debug = false)
    {
        $this->proxy = $proxy;
        $this->debug = empty($debug) ? false : true;
        $this->requestId = CodeExtend::uniqidNumber();
        return $this;
    }

    /**
     * 设置对象的通知状态（在此状态下，将执行通知而不是请求）
     * @param boolean $notification
     */
    public function setRpcNotification($notification)
    {
        $this->notification = empty($notification) ? false : true;
    }

    /**
     * 执行 JsonRCP 请求
     * @param string $method
     * @param array $params
     * @return array|boolean
     * @throws \think\Exception
     */
    public function __call($method, $params)
    {

        // check
        if (!is_scalar($method)) {
            throw new \think\Exception('Method name has no scalar value');
        }

        // check
        if (is_array($params)) {
            // no keys
            $params = array_values($params);
        } else {
            throw new \think\Exception('Params must be given as array');
        }

        // sets notification or request task
        $currentId = $this->notification ? null : $this->requestId;

        // prepares the request
        $request = json_encode(['method' => $method, 'params' => $params, 'id' => $currentId], JSON_UNESCAPED_UNICODE);
        $this->debug && $this->debug .= '***** Request *****' . "\n" . $request . "\n" . '***** End Of request *****' . "\n\n";

        // performs the HTTP POST
        $options = ['http' => ['method' => 'POST', 'header' => 'Content-type: application/json', 'content' => $request]];
        if ($fp = fopen($this->proxy, 'r', false, stream_context_create($options))) {
            $response = '';
            while ($row = fgets($fp)) $response .= trim($row) . "\n";
            $this->debug && $this->debug .= '***** Server response *****' . "\n" . $response . '***** End of server response *****' . "\n";
            $response = json_decode($response, true);
        } else {
            throw new \think\Exception("Unable to connect to {$this->proxy}");
        }
        // debug output
        if ($this->debug) {
            echo nl2br($this->debug);
        }
        // final checks and return
        if ($this->notification) {
            return true;
        } else {
            // check
            if ($response['id'] != $currentId) {
                throw new \think\Exception("Incorrect response id (request id: {$currentId}, response id: {$response['id']}）");
            }
            if (!is_null($response['error'])) {
                throw new \think\Exception("Request error: {$response['error']}");
            }
            return $response['result'];
        }
    }
}