<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\FansService;
use app\wechat\service\TagsService;
use controller\BasicAdmin;
use service\LogService;
use service\ToolsService;
use service\WechatService;
use think\Db;

/**
 * 微信粉丝管理
 * Class Fans
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Fans extends BasicAdmin
{

    /**
     * 定义当前默认数据表
     * @var string
     */
    public $table = 'WechatFans';

    /**
     * 显示粉丝列表
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function index()
    {
        $this->title = '微信粉丝管理';
        $get = $this->request->get();
        $db = Db::name($this->table)->where(['is_black' => '0']);
        (isset($get['sex']) && $get['sex'] !== '') && $db->where('sex', $get['sex']);
        foreach (['nickname', 'country', 'province', 'city'] as $key) {
            (isset($get[$key]) && $get[$key] !== '') && $db->whereLike($key, "%{$get[$key]}%");
        }
        if (isset($get['tag']) && $get['tag'] !== '') {
            $db->where("concat(',',tagid_list,',') like :tag", ['tag' => "%,{$get['tag']},%"]);
        }
        if (isset($get['create_at']) && $get['create_at'] !== '') {
            list($start, $end) = explode(' - ', $get['create_at']);
            $db->whereBetween('subscribe_at', ["{$start} 00:00:00", "{$end} 23:59:59"]);
        }
        return parent::_list($db->order('subscribe_time desc'));
    }

    /**
     * 列表数据处理
     * @param array $list
     */
    protected function _data_filter(&$list)
    {
        $tags = Db::name('WechatFansTags')->column('id,name');
        foreach ($list as &$vo) {
            list($vo['tags_list'], $vo['nickname']) = [[], ToolsService::emojiDecode($vo['nickname'])];
            foreach (explode(',', $vo['tagid_list']) as $tag) {
                if ($tag !== '' && isset($tags[$tag])) {
                    $vo['tags_list'][$tag] = $tags[$tag];
                } elseif ($tag !== '') {
                    $vo['tags_list'][$tag] = $tag;
                }
            }
        }
        $this->assign('tags', $tags);
    }

    /**
     * 设置黑名单
     */
    public function backadd()
    {
        try {
            $openids = $this->_getActionOpenids();
            WechatService::WeChatUser()->batchBlackList($openids);
            Db::name($this->table)->whereIn('openid', $openids)->setField('is_black', '1');
        } catch (\Exception $e) {
            $this->error("设置黑名单失败，请稍候再试！");
        }
        $this->success('设置黑名单成功！', '');
    }

    /**
     * 标签选择
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function tagset()
    {
        $tags = $this->request->post('tags', '');
        $fans_id = $this->request->post('fans_id', '');
        $fans = Db::name('WechatFans')->where(['id' => $fans_id])->find();
        empty($fans) && $this->error('需要操作的数据不存在!');
        try {
            $wechat = WechatService::WeChatTags();
            foreach (explode(',', $fans['tagid_list']) as $tagid) {
                is_numeric($tagid) && $wechat->batchUntagging([$fans['openid']], $tagid);
            }
            foreach (explode(',', $tags) as $tagid) {
                is_numeric($tagid) && $wechat->batchTagging([$fans['openid']], $tagid);
            }
            Db::name('WechatFans')->where(['id' => $fans_id])->setField('tagid_list', $tags);
        } catch (\Exception $e) {
            $this->error('粉丝标签设置失败, 请稍候再试!');
        }
        $this->success('粉丝标签成功!', '');
    }

    /**
     * 给粉丝增加标签
     */
    public function tagadd()
    {
        $tagid = $this->request->post('tag_id', 0);
        empty($tagid) && $this->error('没有可能操作的标签ID');
        try {
            $openids = $this->_getActionOpenids();
            WechatService::WeChatTags()->batchTagging($openids, $tagid);
        } catch (\Exception $e) {
            $this->error("设置粉丝标签失败, 请稍候再试! " . $e->getMessage());
        }
        $this->success('设置粉丝标签成功!', '');
    }

    /**
     * 移除粉丝标签
     */
    public function tagdel()
    {
        $tagid = $this->request->post('tag_id', 0);
        empty($tagid) && $this->error('没有可能操作的标签ID');
        try {
            $openids = $this->_getActionOpenids();
            WechatService::WeChatTags()->batchUntagging($openids, $tagid);
        } catch (\Exception $e) {
            $this->error("删除粉丝标签失败, 请稍候再试! ");
        }
        $this->success('删除粉丝标签成功!', '');
    }

    /**
     * 获取当前操作用户openid数组
     * @return array
     */
    private function _getActionOpenids()
    {
        $ids = $this->request->post('id', '');
        empty($ids) && $this->error('没有需要操作的数据!');
        $openids = Db::name($this->table)->whereIn('id', explode(',', $ids))->column('openid');
        empty($openids) && $this->error('没有需要操作的数据!');
        return $openids;
    }

    /**
     * 同步粉丝列表
     */
    public function sync()
    {
        try {
            Db::name($this->table)->where('1=1')->delete();
            [FansService::sync(), TagsService::sync()];
            LogService::write('微信管理', '同步全部微信粉丝成功');
        } catch (\Exception $e) {
            $this->error('同步粉丝记录失败，请稍候再试！' . $e->getMessage());
        }
        $this->success('同步获取所有粉丝成功！', '');
    }

}
