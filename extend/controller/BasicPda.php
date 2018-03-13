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
use think\Db;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;

/**
 * PDA数据基础控制器
 * Class BasicPda
 * @package controller
 */
class BasicPda
{

    /**
     * 当前请求对象
     * @var \think\Request
     */
    protected $request;

    /**
     * PDA设备ID标识
     * @var string
     */
    protected $deviceid = '';

    /**
     * PDA用户信息
     * @var array
     */
    protected $user = [];

    /**
     * 检查登录
     * @var bool
     */
    protected $checkLogin = true;

    /**
     * 构造方法
     * BasicPda constructor.
     */
    public function __construct()
    {
        ToolsService::corsOptionsHandler();
        $this->request = app('request');
        $this->deviceid = $this->request->post('deviceid', '');
        $this->_initialize();
    }

    /**
     * PDA接口初始化
     */
    public function _initialize()
    {
        empty($this->deviceid) && $this->error("接口异常，缺少必要参数！");
        sysconf('depot_pda_secret_key') !== $this->request->post('appkey') && $this->error("PDA密钥有误！");
        $this->checkLogin && !$this->checkLogin() && $this->error('请登录后再操作！');
    }

    /**
     * 检查用户登录
     * @return bool
     */
    protected function checkLogin()
    {
        return !!$this->initUser();
    }

    /**
     * 初始化用户数据
     * @return array|false|\PDOStatement|string|\think\Model
     */
    protected function initUser()
    {
        $where = "deviceid='{$this->deviceid}' and deviceid<>''";
        $this->user = Db::name('GoodsDepotKeeper')->where(['status' => '1', 'is_deleted' => 0])->where($where)->find();
        if (!empty($this->user)) {
            $this->user['depot'] = Db::name('GoodsDepot')->where(['id' => $this->user['depot_id']])->value('name');
        }
        return $this->user;
    }

    /**
     * 返回成功的操作
     * @param string $msg 消息内容
     * @param array $data 返回数据
     */
    protected function success($msg, $data = [])
    {
        $result = ['code' => 1, 'msg' => $msg, 'data' => $data];
        throw new HttpResponseException(Response::create($result, 'json', 200, ToolsService::corsRequestHander()));
    }

    /**
     * 返回失败的请求
     * @param string $msg 消息内容
     * @param array $data 返回数据
     */
    protected function error($msg, $data = [])
    {
        $result = ['code' => 0, 'msg' => $msg, 'data' => $data];
        throw new HttpResponseException(Response::create($result, 'json', 200, ToolsService::corsRequestHander()));
    }

}
