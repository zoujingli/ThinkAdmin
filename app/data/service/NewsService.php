<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 文章数据服务
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
    public function syncNewsTotal(int $cid): void
    {
        [$map, $total] = [['cid' => $cid], []];
        $query = $this->app->db->name('DataNewsXCollect')->field('count(1) count,type');
        $query->where($map)->group('type')->select()->map(function ($item) use (&$total) {
            $total[$item['type']] = $item['count'];
        });
        $this->app->db->name('DataNewsItem')->where(['id' => $cid])->update([
            'num_collect' => $total[2] ?? 0, 'num_like' => $total[1] ?? 0,
            'num_comment' => $this->app->db->name('DataNewsXComment')->where($map)->count(),
        ]);
    }

    /**
     * 根据CID绑定列表数据
     * @param array $list 数据列表
     * @return array
     */
    public function buildListByCidAndMid(array &$list = []): array
    {
        if (count($list) > 0) {
            /*! 读取文章内容 */
            $cids = array_unique(array_column($list, 'cid'));
            $cols = 'id,name,cover,mark,status,deleted,create_at,num_like,num_read,num_comment,num_collect';
            $items = $this->app->db->name('DataNewsItem')->whereIn('id', $cids)->column($cols, 'id');
            $marks = $this->app->db->name('DataNewsMark')->where(['status' => 1])->column('name');
            foreach ($items as &$vo) $vo['mark'] = mark_str_2_arr($vo['mark'] ?: '', ',', $marks);
            /*! 绑定会员数据 */
            $mids = array_unique(array_column($list, 'mid'));
            $cols = 'id,phone,nickname,username,headimg,status';
            $users = $this->app->db->name('DataMember')->whereIn('id', $mids)->column($cols, 'id');
            foreach ($list as &$vo) {
                $vo['record'] = $items[$vo['cid']] ?? [];
                $vo['member'] = $users[$vo['mid']] ?? [];
            }
        }
        return $list;
    }

    /**
     * 获取列表状态
     * @param array $list 数据列表
     * @param integer $mid 会员MID
     * @return array
     */
    public function buildListState(array &$list, int $mid = 0): array
    {
        if (count($list) > 0) {
            [$cid1s, $cid2s, $marks] = [[], [], []];
            if ($mid > 0) {
                $map = [['mid', '=', $mid], ['cid', 'in', array_unique(array_column($list, 'id'))]];
                $marks = $this->app->db->name('DataNewsMark')->where(['status' => 1])->column('name');
                $cid1s = $this->app->db->name('DataNewsXCollect')->where($map)->where(['type' => 2])->column('cid');
                $cid2s = $this->app->db->name('DataNewsXCollect')->where($map)->where(['type' => 1])->column('cid');
            }
            foreach ($list as &$vo) {
                $vo['mark'] = mark_string_array($vo['mark'] ?: '', ',', $marks);
                $vo['my_like_state'] = in_array($vo['id'], $cid1s) ? 1 : 0;
                $vo['my_coll_state'] = in_array($vo['id'], $cid2s) ? 1 : 0;
            }
        }
        return $list;
    }

}