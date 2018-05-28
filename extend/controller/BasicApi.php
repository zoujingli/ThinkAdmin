<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace controller;

use service\ToolsService;

/**
 * 基础接口类
 * Class BasicApi
 * @package controller
 */
class BasicApi
{

    /**
     * 当前请求对象
     * @var \think\Request
     */
    protected $request;

    /**
     * 构造方法
     * BasicApi constructor.
     */
    public function __construct()
    {
        ToolsService::corsOptionsHandler();
        $this->request = app('request');
    }

    /**
     * 返回成功的操作
     * @param string $msg 消息内容
     * @param array $data 返回数据
     */
    protected function success($msg, $data = [])
    {
        ToolsService::success($msg, $data);
    }

    /**
     * 返回失败的请求
     * @param string $msg 消息内容
     * @param array $data 返回数据
     */
    protected function error($msg, $data = [])
    {
        ToolsService::error($msg, $data);
    }

}