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

use library\command\Sync as UpdateLogic;
use library\Controller;

/**
 * 系统更新接口
 * Class Update
 * @package app\admin\controller\api
 */
class Update extends Controller
{
    /**
     * 基础URL地址
     * @var string
     */
    protected $baseUri = 'https://framework.thinkadmin.top';

    /**
     * 获取文件列表
     */
    public function tree()
    {
        $this->success('获取当前文件列表成功！', UpdateLogic::build());
    }

    /**
     * 读取线上文件数据
     * @param string $encode
     */
    public function read($encode)
    {
        $file = env('root_path') . decode($encode);
        if (!file_exists($file)) $this->error('获取文件内容失败！');
        $this->success('获取文件内容成功！', [
            'format' => 'base64', 'content' => base64_encode(file_get_contents($file)),
        ]);
    }

}