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

namespace app\store\controller;

use library\Controller;

/**
 * 会员信息管理
 * Class Member
 * @package app\store\controller
 */
class Member extends Controller
{

    use \app\admin\traits\SearchTraits;

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'StoreMember';

    /**
     * 会员信息管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '会员信息管理';
        // 搜索构建器示例
        $this->setSearchParames([
            [
                'name'  => 'nickname',
                'type'  => 'text',
                'title' => '会员昵称',
            ],
            [
                'name'  => 'username',
                'type'  => 'text',
                'title' => '会员手机',
            ],
            [
                'name'  => 'level',
                'type'  => 'select',
                'title' => '会员等级',
                'tips'  => ['0'=>'游客会员','1'=>'临时会员','2'=>'VIP1会员','3'=>'VIP2会员'],
            ],
            [
                'name'  => 'create_at',
                'type'  => 'date',
                'title' => '注册时间',
                'range' => true,
            ],
        ]);
        $query = $this->_query($this->table)->like('nickname,phone')->equal('vip_level');
        $query->dateBetween('create_at')->order('id desc')->page();
    }

}
