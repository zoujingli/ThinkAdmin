<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\queue;

use think\console\Input;
use think\console\Output;

/**
 * 基础任务基类
 * Class Queue
 * @package app\admin\queue
 */
abstract class Queue
{
    /**
     * 判断是否WIN环境
     * @return boolean
     */
    protected function isWin()
    {
        return PATH_SEPARATOR === ';';
    }

    abstract function execute(Input $input, Output $output, array $data = []);
}