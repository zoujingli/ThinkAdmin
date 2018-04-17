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

use controller\BasicAdmin;
use service\ToolsService;
use service\WechatService;
use think\Db;

/**
 * 微信粉丝管理
 * Class Block
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Block extends BasicAdmin
{

    /**
     * 定义当前默认数据表
     * @var string
     */
    public $table = 'WechatFans';

    /**
     * 黑名单列表
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function index()
    {
        $this->title = '微信黑名单管理';
        $get = $this->request->get();
        $db = Db::name($this->table)->where(['is_black' => '1']);
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
     * 取消黑名
     */
    public function backdel()
    {
        $openids = $this->_getActionOpenids();
        try {
            WechatService::user()->batchUnblackList($openids);
            Db::name($this->table)->whereIn('openid', $openids)->setField('is_black', '0');
        } catch (\Exception $e) {
            $this->error("设备黑名单失败，请稍候再试！" . $e->getMessage());
        }
        $this->success("已成功将 " . count($openids) . " 名粉丝从黑名单中移除!", '');
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

}
