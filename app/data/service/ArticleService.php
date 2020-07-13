<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 文章数据处理服务
 * Class ArticleService
 * @package app\data\service
 */
class ArticleService extends Service
{
    /**
     * 同步文章数据统计
     * @param integer $cid 文章ID
     * @throws \think\db\exception\DbException
     */
    public function syncTotal($cid)
    {
        $this->app->db->name('DataArticleContent')->where(['id' => $cid])->update([
            'number_likes'      => $this->app->db->name('DataArticleLike')->where(['cid' => $cid])->count(),
            'number_comment'    => $this->app->db->name('DataArticleComment')->where(['cid' => $cid])->count(),
            'number_collection' => $this->app->db->name('DataArticleCollection')->where(['cid' => $cid])->count(),
        ]);
    }

}