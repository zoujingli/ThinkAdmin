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
use think\Db;
use think\exception\HttpResponseException;
use think\Response;

/**
 * App数据基础控制器
 * Class BasicApp
 * @package controller
 */
class BasicApp
{

    /**
     * 当前请求对象
     * @var \think\Request
     */
    protected $request;

    /**
     * App设备ID标识
     * @var string
     */
    protected $deviceid = '';

    /**
     * 微信unionid
     * @var string
     */
    protected $unionid = '';

    /**
     * App会员信息
     * @var array
     */
    protected $member = [];

    /**
     * 当前粉丝信息
     * @var array
     */
    protected $fans = [];

    /**
     * 构造方法
     * BasicApp constructor.
     */
    public function __construct()
    {
        ToolsService::corsOptionsHandler();
        $this->request = app('request');
        $this->unionid = $this->request->post('unionid', '');
        $this->deviceid = $this->request->post('deviceid', '');
        $this->_initialize();
    }

    /**
     * App接口初始化
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        if (empty($this->deviceid) && empty($this->unionid)) {
            $this->error("接口异常，缺少必要参数！");
        }
        return $this->checkLogin();
    }

    /**
     * 检查用户登录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function checkLogin()
    {
        $this->member = $this->initMember();
        empty($this->member) && $this->error('还没有登录哦，请登录后再来访问！');
    }

    /**
     * 初始化会员数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function initMember()
    {
        $where = "(deviceid='{$this->deviceid}' and deviceid<>'') or (unionid='{$this->unionid}' and unionid<>'')";
        $this->member = Db::name('Member')->where(['status' => '1'])->where($where)->find();
        if (!empty($this->member)) {
            $where = ['level' => $this->member['level']];
            $this->member['nickname'] = ToolsService::emojiDecode($this->member['nickname']);
            $this->member['level_title'] = Db::name('MemberLevel')->where($where)->value('title', '');
            // 计算会员的积分排行榜
            $rateWhere = ['is_pass' => '1', 'total_integral' => ['>', $this->member['total_integral']]];
            $rateCount = Db::name('Member')->where($rateWhere)->count();
            $count = Db::name('Member')->where(['is_pass' => '1'])->count();
            $this->member['integral_rate'] = number_format(floatval(100 - $rateCount * 100 / $count), 2);
        }
        return $this->member;
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
