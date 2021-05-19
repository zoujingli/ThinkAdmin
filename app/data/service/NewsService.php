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
     * @param string $code 文章编号
     * @param array $total 查询统计
     * @throws \think\db\exception\DbException
     */
    public function syncNewsTotal(string $code, array $total = []): void
    {
        $query = $this->app->db->name('DataNewsXCollect')->field('type,count(1) count');
        foreach ($query->where(['code' => $code, 'status' => 2])->group('type')->cursor() as $item) {
            $total[$item['type']] = $item['count'];
        }
        $this->app->db->name('DataNewsItem')->where(['code' => $code])->update([
            'num_like' => $total[1] ?? 0, 'num_collect' => $total[2] ?? 0, 'num_comment' => $total[4] ?? 0,
        ]);
    }

    /**
     * 根据code绑定列表数据
     * @param array $list 数据列表
     * @return array
     */
    public function buildListByUidAndCode(array &$list = []): array
    {
        if (count($list) > 0) {
            /*! 绑定文章内容 */
            $codes = array_unique(array_column($list, 'code'));
            $colls = 'id,code,name,cover,mark,status,deleted,create_at,num_like,num_read,num_comment,num_collect';
            $items = $this->app->db->name('DataNewsItem')->whereIn('code', $codes)->column($colls, 'code');
            $marks = $this->app->db->name('DataNewsMark')->where(['status' => 1])->column('name');
            foreach ($items as &$vo) $vo['mark'] = str2arr($vo['mark'] ?: '', ',', $marks);
            foreach ($list as &$vo) $vo['record'] = $items[$vo['code']] ?? [];
            /*! 绑定用户数据 */
            $colls = 'id,phone,nickname,username,headimg,status';
            UserAdminService::instance()->buildByUid($list, 'uid', 'user', $colls);
        }
        return $list;
    }

    /**
     * 获取列表状态
     * @param array $list 数据列表
     * @param integer $uid 用户UID
     * @return array
     */
    public function buildData(array &$list, int $uid = 0): array
    {
        if (count($list) > 0) {
            [$code2, $code1] = [[], []];
            $marks = $this->app->db->name('DataNewsMark')->where(['status' => 1])->column('name');
            if ($uid > 0) {
                $map = [['uid', '=', $uid], ['code', 'in', array_unique(array_column($list, 'code'))]];
                $code1 = $this->app->db->name('DataNewsXCollect')->where($map)->where(['type' => 1])->column('code');
                $code2 = $this->app->db->name('DataNewsXCollect')->where($map)->where(['type' => 2])->column('code');
            }
            foreach ($list as &$vo) {
                $vo['mark'] = str2arr($vo['mark'] ?: '', ',', $marks);
                $vo['my_like_state'] = in_array($vo['code'], $code2) ? 1 : 0;
                $vo['my_coll_state'] = in_array($vo['code'], $code1) ? 1 : 0;
            }
        }
        return $list;
    }

}