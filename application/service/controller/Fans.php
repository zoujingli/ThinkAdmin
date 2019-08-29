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

use app\admin\service\QueueService;
use app\service\queue\WechatQueue;
use app\service\service\WechatService;
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

    protected $appid = '';

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'WechatFans';

    /**
     * 初始化函数
     * Fans constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->appid = input('appid', session('current_appid'));
        if (empty($this->appid)) {
            $this->where = ['status' => '1', 'service_type' => '2', 'is_deleted' => '0', 'verify_type' => '0'];
            $this->appid = Db::name('WechatServiceConfig')->where($this->where)->value('authorizer_appid');
        }
        if (empty($this->appid)) {
            $this->fetch('/not-auth');
        } else {
            session('current_appid', $this->appid);
        }
        if ($this->request->isGet()) {
            $this->where = ['status' => '1', 'service_type' => '2', 'is_deleted' => '0', 'verify_type' => '0'];
            $this->wechats = Db::name('WechatServiceConfig')->where($this->where)->order('id desc')->column('authorizer_appid,nick_name');
        }
    }

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
        $query->dateBetween('subscribe_at')->where(['appid' => $this->appid])->order('subscribe_time desc')->page();
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
        }
    }

    /**
     * 批量拉黑粉丝
     * @auth true
     */
    public function setBlack()
    {
        try {
            $this->applyCsrfToken();
            foreach (array_chunk(explode(',', $this->request->post('openid')), 20) as $openids) {
                WechatService::WeChatUser($this->appid)->batchBlackList($openids);
                Db::name('WechatFans')->where(['appid' => $this->appid])->whereIn('openid', $openids)->update(['is_black' => '1']);
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
        try {
            $this->applyCsrfToken();
            foreach (array_chunk(explode(',', $this->request->post('openid')), 20) as $openids) {
                WechatService::WeChatUser($this->appid)->batchUnblackList($openids);
                Db::name('WechatFans')->where(['appid' => $this->appid])->whereIn('openid', $openids)->update(['is_black' => '0']);
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
            sysoplog('微信管理', "创建微信[{$this->appid}]粉丝同步任务");
            sysqueue("同步[{$this->appid}]粉丝列表", WechatQueue::URI, 0, ['appid' => $this->appid], 0);
            $this->success('创建同步粉丝任务成功，需要时间来完成。<br>请到 系统管理 > 任务管理 查看执行进度！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("创建同步粉丝任务失败，请稍候再试！<br> {$e->getMessage()}");
        }
    }

    /**
     * 删除粉丝信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

}
