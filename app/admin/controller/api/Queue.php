<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\service\QueueService;

/**
 * 后台任务通用接口
 * Class Queue
 * @package app\admin\controller\api
 */
class Queue extends Controller
{
    /**
     * 任务进度查询
     * @login true
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function progress()
    {
        $input = $this->_vali(['code.require' => '任务编号不能为空！']);
        $queue = QueueService::instance()->initialize($input['code']);
        $this->success('获取任务进度成功！', $queue->progress());
    }

}