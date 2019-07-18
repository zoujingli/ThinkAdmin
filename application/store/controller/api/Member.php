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
use think\Db;

/**
 * 会员管理基类
 * Class Member
 * @package app\store\controller\api
 */
class Member extends Controller
{
    /**
     * 当前会员ID
     * @var integer
     */
    protected $mid;

    /**
     * 当前会员数据
     * @var array
     */
    protected $member;

    /**
     * 当前公众号OPENID
     * @var string
     */
    protected $openid;

    /**
     * Member constructor.
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct()
    {
        parent::__construct();
        // 会员信息检查
        $this->mid = $this->request->post('mid');
        $this->openid = $this->request->post('openid');
        if (empty($this->mid)) $this->error('无效的会员ID参数！');
        if (empty($this->openid)) $this->error('无效的会员绑定OPENID！');
        $this->getMember();
    }

    /**
     * 获取会员信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function getMember()
    {
        $where = ['id' => $this->mid, 'openid' => $this->openid];
        $this->member = Db::name('StoreMember')->where($where)->find();
        if (empty($this->member)) $this->error('无效的会员信息，请重新登录授权！');
        // 会员当前已经领取次数
        $where = [['mid', 'eq', $this->mid], ['status', 'in', ['2', '3', '4', '5']]];
        $this->member['times_used'] = Db::name('StoreOrder')->where($where)->count();
        return $this->member;
    }

}
