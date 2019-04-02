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
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use library\Controller;

/**
 * Class Message
 * @package app\admin\controller\api
 */
class Message extends Controller
{

    /**
     * 获取系统消息列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function gets()
    {
        $list = \app\admin\service\Message::gets();
        $this->success('获取系统消息成功！', $list);
    }

    /**
     * 系统消息状态更新
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function set()
    {
        $code = $this->request->post('code');
        if (\app\admin\service\Message::set($code)) {
            $this->success('系统消息状态更新成功！');
        } else {
            $this->error('系统消息状态更新失败，请稍候再试！');
        }
    }

}