<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\service;

use app\data\model\DataNewsItem;
use app\data\model\DataNewsMark;
use app\data\model\DataNewsXCollect;
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
     */
    public static function syncNewsTotal(string $code, array $total = []): void
    {
        $query = DataNewsXCollect::mk()->field('type,count(1) count');
        foreach ($query->where(['code' => $code, 'status' => 2])->group('type')->cursor() as $item) {
            $total[$item['type']] = $item['count'];
        }
        DataNewsItem::mk()->where(['code' => $code])->update([
            'num_like' => $total[1] ?? 0, 'num_collect' => $total[2] ?? 0, 'num_comment' => $total[4] ?? 0,
        ]);
    }

    /**
     * 根据code绑定列表数据
     * @param array $list 数据列表
     * @return array
     */
    public static function buildListByUidAndCode(array &$list = []): array
    {
        if (count($list) > 0) {
            /*! 绑定文章内容 */
            $colls = 'id,code,name,cover,mark,status,deleted,create_at,num_like,num_read,num_comment,num_collect';
            $items = DataNewsItem::mk()->whereIn('code', array_unique(array_column($list, 'code')))->column($colls, 'code');
            $marks = DataNewsMark::mk()->where(['status' => 1])->column('name');
            foreach ($items as &$vo) $vo['mark'] = str2arr($vo['mark'] ?: '', ',', $marks);
            foreach ($list as &$vo) $vo['record'] = $items[$vo['code']] ?? [];
            /*! 绑定用户数据 */
            $colls = 'id,phone,nickname,username,headimg,status';
            UserAdminService::buildByUid($list, 'uuid', 'user', $colls);
        }
        return $list;
    }

    /**
     * 获取列表状态
     * @param array $list 数据列表
     * @param integer $uuid 用户UID
     * @return array
     */
    public static function buildData(array &$list, int $uuid = 0): array
    {
        if (count($list) > 0) {
            [$code2, $code1] = [[], []];
            $marks = DataNewsMark::mk()->where(['status' => 1])->column('name');
            if ($uuid > 0) {
                $map = [['uuid', '=', $uuid], ['code', 'in', array_unique(array_column($list, 'code'))]];
                $code1 = DataNewsXCollect::mk()->where($map)->where(['type' => 1])->column('code');
                $code2 = DataNewsXCollect::mk()->where($map)->where(['type' => 2])->column('code');
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