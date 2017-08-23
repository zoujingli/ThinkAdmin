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

use think\Controller;

/**
 * 微信基础控制器
 * Class BasicWechat
 * @package controller
 */
class BasicWechat extends Controller
{

    /**
     * 当前粉丝用户OPENID
     * @var string
     */
    protected $openid;

    /**
     * 当前粉丝信息
     * @var array
     */
    protected $fansinfo;

    /**
     * 微信网页授权
     * @param bool $mode 获取完整
     * @return string
     */
    protected function oauth($mode = true)
    {
        $this->openid = session('openid');
        if (!empty($this->openid) && empty($mode)) {
            return $this->openid;
        } elseif (!empty($this->openid) && session('fansinfo')) {
            $this->fansinfo = session('fansinfo');
            return $this->openid;
        }
        list($sessionid, $location) = [session_id(), $this->request->url(true)];
        $result = load_wechat('wechat')->oauth($sessionid, $location, intval($mode));
        !empty($result['url']) && $this->redirect($result['url']);
        if (!empty($result['openid'])) {
            list($this->openid, $this->fansinfo) = [$result['openid'], $result['fans']];
            session('openid', $this->openid);
            session('fansinfo', $this->fansinfo);
            return $this->openid;
        }
        $this->error('网页授权失败，请稍候再试！');
    }

}
