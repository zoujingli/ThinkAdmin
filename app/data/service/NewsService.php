<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 文章数据处理服务
 * Class NewsService
 * @package app\data\service
 */
class NewsService extends Service
{
    /**
     * 同步文章数据统计
     * @param integer $cid 文章ID
     * @throws \think\db\exception\DbException
     */
    public function syncTotal($cid)
    {
        $this->app->db->name('DataNewsItem')->where(['id' => $cid])->update([
            'num_like'    => $this->app->db->name('DataNewsXLike')->where(['cid' => $cid])->count(),
            'num_comment' => $this->app->db->name('DataNewsXComment')->where(['cid' => $cid])->count(),
            'num_collect' => $this->app->db->name('DataNewsXCollect')->where(['cid' => $cid])->count(),
        ]);
    }

    /**
     * 根据CID绑定列表数据
     * @param array $list
     * @return array
     */
    public function buildListByCid(array &$list = []): array
    {
        if (count($list) > 0) {
            $cids = array_unique(array_column($list, 'cid'));
            $cols = 'id,title,logo,status,deleted,create_at,num_like,num_read,num_comment,num_collect';
            $news = $this->app->db->name('DataNewsItem')->whereIn('id', $cids)->column($cols, 'id');
            foreach ($list as &$vo) $vo['record'] = $news[$vo['cid']] ?? [];
        }
        return $list;
    }

    /**
     * 根据MID绑定列表数据
     * @param array $list
     * @return array
     */
    public function buildListByMid(array &$list = []): array
    {
        if (count($list) > 0) {
            $ids = array_unique(array_column($list, 'mid'));
            $cols = 'id,phone,nickname,username,headimg,status';
            $mems = $this->app->db->name('DataMember')->whereIn('id', $ids)->column($cols, 'id');
            foreach ($list as &$vo) $vo['member'] = $mems[$vo['mid']] ?? [];
        }
        return $list;
    }

    /**
     * 获取列表状态
     * @param array $list
     * @param integer $mid
     * @return array
     */
    public function buildListState(array &$list, int $mid = 0): array
    {
        if (count($list) > 0 && $mid > 0) {
            $map = [['mid', '=', $mid], ['cid', 'in', array_column($list, 'id')]];
            $cid1s = $this->app->db->name('DataNewsXLike')->where($map)->column('cid');
            $cid2s = $this->app->db->name('DataNewsXCollect')->where($map)->column('cid');
            foreach ($list as &$vo) {
                $vo['my_like_state'] = in_array($vo['id'], $cid1s) ? 1 : 0;
                $vo['my_collect_state'] = in_array($vo['id'], $cid2s) ? 1 : 0;
            }
        }
        return $list;
    }

}