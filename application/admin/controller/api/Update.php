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

namespace app\admin\controller\api;

use library\command\Sync;
use library\Controller;

/**
 * 系统更新接口
 * Class Update
 * @package app\admin\controller\api
 */
class Update extends Controller
{
    /**
     * 访问权限
     */
    protected function initialize()
    {
        $domain = $this->app->request->host(true);
        $isDemo = is_numeric(stripos($domain, 'thinkadmin.top'));
        $isLocal = in_array($domain, ['127.0.0.1', 'localhost']);
        if (!$isLocal && !$isDemo) $this->error('只允许访问本地或官方代码！');
    }

    /**
     * 获取文件列表
     */
    public function tree()
    {
        $sync = new Sync('Update');
        $this->success('获取当前文件列表成功！', $sync->build());
    }

    /**
     * 读取线上文件数据
     * @param string $encode
     */
    public function read($encode)
    {
        $this->file = env('root_path') . decode($encode);
        if (file_exists($this->file)) {
            $this->success('读取文件成功！', [
                'format'  => 'base64',
                'content' => base64_encode(file_get_contents($this->file)),
            ]);
        } else {
            $this->error('获取文件内容失败！');
        }
    }

}
