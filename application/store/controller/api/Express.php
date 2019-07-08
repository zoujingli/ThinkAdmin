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

namespace app\store\controller\api;

use library\Controller;

/**
 * 快递查询结果
 * Class Express
 * @package app\store\controller\api
 */
class Express extends Controller
{
    /**
     * 物流查询结果
     */
    public function query()
    {
        $express_no = $this->request->post('express_no', '');
        $express_code = $this->request->post('express_code', '');
        $result = \library\tools\Express::query($express_code, $express_no);
        $this->success('获取物流查询结果！', $result);
    }

}
