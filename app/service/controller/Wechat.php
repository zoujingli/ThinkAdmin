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

namespace app\service\controller;

use think\admin\Controller;

/**
 * 公众号授权管理
 * Class Wechat
 * @package app\service\controller
 */
class Wechat extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'WechatServiceConfig';

    /**
     * 公众号授权管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '公众号授权管理';
        $query = $this->_query($this->table)->like('authorizer_appid,nick_name,principal_name');
        $query = $query->equal('service_type,status')->dateBetween('create_at');
        $query->where(['is_deleted' => '0'])->order('id desc')->page();
    }

    /**
     * 修改公众号状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_applyFormToken();
        $this->_save($this->table, ['status' => input('status')]);
    }

    /**
     * 删除公众号授权
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

}