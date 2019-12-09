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
 * 微信粉丝管理
 * Class Fans
 * @package app\service\controller
 */
class Fans extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'WechatFans';

    /**
     * 初始化函数
     */
    protected function initialize()
    {
        $this->appid = input('appid', $this->app->session->get('current_appid'));
        if (empty($this->appid)) {
            $this->where = ['status' => '1', 'service_type' => '2', 'is_deleted' => '0', 'verify_type' => '0'];
            $this->appid = $this->app->db->name('WechatServiceConfig')->where($this->where)->value('authorizer_appid');
        }
        if (empty($this->appid)) {
            $this->fetch('/not-auth');
        } else {
            $this->app->session->set('current_appid', $this->appid);
        }
        if ($this->request->isGet()) {
            $this->where = ['status' => '1', 'service_type' => '2', 'is_deleted' => '0', 'verify_type' => '0'];
            $this->wechats = $this->app->db->name('WechatServiceConfig')->where($this->where)->order('id desc')->column('authorizer_appid,nick_name');
        }
    }

    /**
     * 微信粉丝管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '微信粉丝管理';
        $query = $this->_query($this->table)->like('nickname')->equal('subscribe,is_black');
        $query->dateBetween('subscribe_at')->where(['appid' => $this->appid])->order('subscribe_time desc')->page();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        $tags = $this->app->db->name('WechatFansTags')->column('id,name');
        foreach ($data as &$user) {
            $user['tags'] = [];
            foreach (explode(',', $user['tagid_list']) as $tagid) {
                if (isset($tags[$tagid])) $user['tags'][] = $tags[$tagid];
            }
        }
    }

    /**
     * 删除粉丝信息
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

}