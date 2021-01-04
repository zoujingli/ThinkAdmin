<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\WechatService;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 微信用户管理
 * Class Fans
 * @package app\wechat\controller
 */
class Fans extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'WechatFans';

    /**
     * 微信用户管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '微信用户管理';
        $this->where = ['appid' => WechatService::instance()->getAppid()];
        $query = $this->_query($this->table)->like('nickname')->equal('subscribe,is_black');
        $query->dateBetween('subscribe_at')->where($this->where)->order('subscribe_time desc');
        if (input('output') === 'json') {
            $this->success('获取数据成功', $query->page(true, false));
        } else {
            $query->page();
        }
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        $tags = $this->app->db->name('WechatFansTags')->column('name', 'id');
        foreach ($data as &$vo) {
            $vo['tags'] = [];
            foreach (explode(',', $vo['tagid_list']) as $tagid) {
                if (isset($tags[$tagid])) $vo['tags'][] = $tags[$tagid];
            }
        }
    }

    /**
     * 同步用户数据
     * @auth true
     */
    public function sync()
    {
        sysoplog('微信授权配置', '创建粉丝用户同步任务');
        $this->_queue('同步微信用户数据', "xadmin:fansall");
    }

    /**
     * 删除用户信息
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 用户拉入黑名单
     * @auth true
     */
    public function blackAdd()
    {
        try {
            $this->_applyFormToken();
            foreach (array_chunk(explode(',', $this->request->post('openid')), 20) as $openids) {
                WechatService::WeChatUser()->batchBlackList($openids);
                $this->app->db->name('WechatFans')->whereIn('openid', $openids)->update(['is_black' => '1']);
            }
            $this->success('拉入黑名单成功！');
        } catch (HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $exception) {
            $this->error("拉入黑名单失败，请稍候再试！<br>{$exception->getMessage()}");
        }
    }

    /**
     * 用户移出黑名单
     * @auth true
     */
    public function blackDel()
    {
        try {
            $this->_applyFormToken();
            foreach (array_chunk(explode(',', $this->request->post('openid')), 20) as $openids) {
                WechatService::WeChatUser()->batchUnblackList($openids);
                $this->app->db->name('WechatFans')->whereIn('openid', $openids)->update(['is_black' => '0']);
            }
            $this->success('移出黑名单成功！');
        } catch (HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $exception) {
            $this->error("移出黑名单失败，请稍候再试！<br>{$exception->getMessage()}");
        }
    }

}
