<?php


namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\service\QueueService;

class Queue extends Controller
{
    public function progress()
    {
        $input = $this->_vali(['code.require' => '任务编号不能为空！']);
        $result = QueueService::instance()->progress($input['code']);
        $this->success('获取任务进度成功！', $result);
    }

}