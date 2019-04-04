<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\store\controller;

use app\store\service\Extend;
use library\Controller;

/**
 * 微信商城配置
 * Class Config
 * @package app\store\controller
 */
class Config extends Controller
{
    /**
     * 微信商城配置
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->applyCsrfToken();
        $this->title = '商城参数配置';
        if ($this->request->isGet()) {
            $this->query = Extend::querySmsBalance();
            $this->fetch();
        } else {
            foreach ($this->request->post() as $k => $v) sysconf($k, $v);
            $this->success('商城参数配置保存成功！');
        }
    }

}