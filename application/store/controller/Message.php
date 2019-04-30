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

use library\Controller;

/**
 * 短信发送管理
 * Class Message
 * @package app\store\controller
 */
class Message extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'StoreMemberSmsHistory';

    /**
     * 短信发送管理
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '短信发送管理';
        $this->_query($this->table)->like('phone,content,result')->dateBetween('create_at')->order('id desc')->page();
    }

}