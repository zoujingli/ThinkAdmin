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
     * 服务端地址
     * @var string
     */
    private $proxy;

    /**
     * 请求ID
     * @var integer
     */
    private $requestid;

    /**
     * 创建连接对象
     * @param string $proxy
     * @return $this
     */
    public function create($proxy)
    {
        $this->proxy = $proxy;
        $this->requestid = CodeExtend::uniqidNumber();
        return $this;
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
            $params = array_values($params);
        } else {
            throw new \think\Exception('Params must be given as array');
        }
        // performs the HTTP POST
        $options = [
            'http' => [
                'method'  => 'POST', 'header' => 'Content-type: application/json',
                'content' => json_encode(['method' => $method, 'params' => $params, 'id' => $this->requestid], JSON_UNESCAPED_UNICODE),
            ],
        ];
        if ($fp = fopen($this->proxy, 'r', false, stream_context_create($options))) {
            $response = '';
            while ($row = fgets($fp)) $response .= trim($row) . "\n";
            fclose($fp);
            $response = json_decode($response, true);
        } else {
            throw new \think\Exception("Unable to connect to {$this->proxy}");
        }
        // final checks and return
        if ($response['id'] != $this->requestid) {
            throw new \think\Exception("Incorrect response id (request id: {$this->requestid}, response id: {$response['id']}）");
        }
        if (is_null($response['error'])) {
            return $response['result'];
        } else {
            throw new \think\Exception("Request error: {$response['error']}");
        }
    }
}