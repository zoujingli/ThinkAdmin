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
use library\tools\Data;

/**
 * JsonRpc 客户端服务
 * Class JsonRpcClientService
 * @package library\service
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
        $this->requestid = Data::randomCode(16, 3);
        $this->proxy = $proxy;
        return $this;
    }

    /**
     * 执行 JsonRpc 请求
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws \think\Exception
     */
    public function __call($method, $params)
    {
        // Performs the HTTP POST
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => json_encode([
                    'jsonrpc' => '2.0', 'method' => $method, 'params' => $params, 'id' => $this->requestid,
                ], JSON_UNESCAPED_UNICODE),
            ],
        ];
        if ($fp = fopen($this->proxy, 'r', false, stream_context_create($options))) {
            $response = '';
            while ($row = fgets($fp)) $response .= trim($row) . "\n";
            fclose($fp);
            $response = json_decode($response, true);
        } else {
            throw new \think\Exception("无法连接到 {$this->proxy}");
        }
        // Final checks and return
        if ($response['id'] != $this->requestid) {
            throw new \think\Exception("错误的响应标记 (请求标记: {$this->requestid}, 响应标记: {$response['id']}）");
        }
        if (is_null($response['error'])) {
            return $response['result'];
        } else {
            throw new \think\Exception("请求错误：[{$response['error']['code']}] {$response['error']['message']}");
        }
    }
}