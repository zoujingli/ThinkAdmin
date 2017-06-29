<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

use think\Db;
use think\Request;

/**
 * 操作日志服务
 * Class LogService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/24 13:25
 */
class LogService {

    /**
     * 获取数据操作对象
     * @return \think\db\Query
     */
    protected static function db() {
        return Db::name('SystemLog');
    }

    /**
     * 写入操作日志
     * @param string $action
     * @param string $content
     * @return bool
     */
    public static function write($action = '行为', $content = "内容描述") {
        $request = Request::instance();
        $node = strtolower(join('/', [$request->module(), $request->controller(), $request->action()]));
        $data = ['ip' => $request->ip(), 'node' => $node, 'username' => session('user.username') . '', 'action' => $action, 'content' => $content];
        return self::db()->insert($data) !== false;
    }

}
