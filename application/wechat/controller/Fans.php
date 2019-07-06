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

namespace app\wechat\controller;

use app\admin\service\QueueService;
use app\wechat\queue\WechatQueue;
use app\wechat\service\WechatService;
use library\Controller;
use think\Db;
use think\exception\HttpResponseException;

/**
 * 微信粉丝管理
 * Class Fans
 * @package app\wechat\controller
 */
class Fans extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'WechatFans';

    /**
     * 微信粉丝管理
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
        $this->title = '微信粉丝管理';
        $query = $this->_query($this->table)->like('nickname')->equal('subscribe,is_black');
        $query->dateBetween('subscribe_at')->order('subscribe_time desc')->page();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        $tags = Db::name('WechatFansTags')->column('id,name');
        foreach ($data as &$user) {
            $user['tags'] = [];
            foreach (explode(',', $user['tagid_list']) as $tagid) {
                if (isset($tags[$tagid])) $user['tags'][] = $tags[$tagid];
            }
            foreach (['country', 'province', 'city', 'nickname', 'remark'] as $k) {
                if (isset($user[$k])) $user[$k] = emoji_decode($user[$k]);
            }
        }
    }

    /**
     * 批量拉黑粉丝
     * @auth true
     */
    public function setBlack()
    {
        $this->applyCsrfToken();
        try {
            foreach (array_chunk(explode(',', $this->request->post('openid')), 20) as $openids) {
                WechatService::WeChatUser()->batchBlackList($openids);
                Db::name('WechatFans')->whereIn('openid', $openids)->update(['is_black' => '1']);
            }
            $this->success('拉黑粉丝信息成功！');
        } catch (HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $e) {
            $this->error("拉黑粉丝信息失败，请稍候再试！{$e->getMessage()}");
        }
    }

    /**
     * 取消拉黑粉丝
     * @auth true
     */
    public function delBlack()
    {
        $this->applyCsrfToken();
        try {
            foreach (array_chunk(explode(',', $this->request->post('openid')), 20) as $openids) {
                WechatService::WeChatUser()->batchUnblackList($openids);
                Db::name('WechatFans')->whereIn('openid', $openids)->update(['is_black' => '0']);
            }
            $this->success('取消拉黑粉丝信息成功！');
        } catch (HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $e) {
            $this->error("取消拉黑粉丝信息失败，请稍候再试！{$e->getMessage()}");
        }
    }

    /**
     * 同步粉丝列表
     * @auth true
     */
    public function sync()
    {
        try {
            sysoplog('微信管理', '创建微信粉丝同步任务');
            QueueService::add('同步粉丝列表', WechatQueue::URI, 0, [], 0);
            $this->success('创建同步粉丝任务成功，需要时间来完成。<br>请到系统任务管理查看进度！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("创建同步粉丝任务失败，请稍候再试！<br> {$e->getMessage()}");
        }
    }

    /**
     * 删除粉丝信息
     * @auth true
     */
    public function remove()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

}