<?php

namespace app\data\controller\api\member;

use app\data\controller\api\Member;
use app\data\service\ArticleService;

/**
 * 文章评论内容
 * Class Article
 * @package app\data\controller\api\member
 */
class Article extends Member
{
    /**
     * 会员评论内容
     * @throws \think\db\exception\DbException
     */
    public function addComment()
    {
        $data = $this->_vali([
            'mid.value'       => $this->mid,
            'cid.require'     => '文章ID不能为空！',
            'content.require' => '评论内容不能为空！',
        ]);
        if ($this->app->db->name('DataArticleComment')->insert($data) !== false) {
            ArticleService::instance()->syncTotal($data['cid']);
            $this->success('添加评论成功！');
        } else {
            $this->error('添加评论失败！');
        }
    }

    /**
     * 删除内容评论
     * @throws \think\db\exception\DbException
     */
    public function delComment()
    {
        $data = $this->_vali([
            'mid.value'   => $this->mid,
            'id.require'  => '评论ID不能为空',
            'cid.require' => '文章ID不能为空！',
        ]);
        if ($this->app->db->name('DataArticleComment')->where($data)->delete() !== false) {
            $this->success('评论删除成功！');
        } else {
            $this->error('认证删除失败！');
        }
    }

    /**
     * 获取我的评论
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getComment()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '内容ID不能为空！']);
        $this->success('获取评论列表成功', [
            'list' => $this->app->db->name('DataArticleComment')->where($data)->order('id desc')->select()->toArray(),
        ]);
    }

    /**
     * 添加内容收藏
     * @throws \think\db\exception\DbException
     */
    public function addCollection()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '内容ID不能为空！']);
        if ($this->app->db->name('DataArticleCollection')->where($data)->count() > 0) {
            $this->success('您已收藏！');
        }
        if ($this->app->db->name('DataArticleCollection')->insert($data) !== false) {
            ArticleService::instance()->syncTotal($data['cid']);
            $this->success('收藏成功！');
        } else {
            $this->error('收藏失败！');
        }
    }

    /**
     * 取消收藏文章
     * @throws \think\db\exception\DbException
     */
    public function delCollection()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '文章ID不能为空！']);
        if ($this->app->db->name('DataArticleCollection')->where($data)->delete() !== false) {
            ArticleService::instance()->syncTotal($data['cid']);
            $this->success('取消收藏成功！');
        } else {
            $this->error('取消收藏失败！');
        }
    }

    /**
     * 获取我收藏的资讯
     * @throws \think\db\exception\DbException
     */
    public function getMyCollection()
    {
        $query = $this->_query('DataArticleCollection')->where(['mid' => $this->mid]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        if (count($result['list']) > 0) {
            $ids = array_unique(array_column($result['list'], 'cid'));
            $fields = 'id,title,logo,source,number_likes,number_reads,number_comment,number_collection,status,deleted,create_at';
            $Articles = $this->app->db->name('DataArticleContent')->whereIn('id', $ids)->column($fields, 'id');
            foreach ($result['list'] as &$vo) $vo['record'] = $Articles[$vo['cid']] ?? [];
        }
        $this->success('获取收藏记录成功！', $result);

    }

    /**
     * 添加内容点赞
     * @throws \think\db\exception\DbException
     */
    public function addLike()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '内容ID不能为空！']);
        if ($this->app->db->name('DataArticleLike')->where($data)->count() > 0) {
            $this->success('您已点赞！');
        }
        if ($this->app->db->name('DataArticleLike')->insert($data) !== false) {
            ArticleService::instance()->syncTotal($data['cid']);
            $this->success('点赞成功！');
        } else {
            $this->error('点赞失败！');
        }
    }

    /**
     * 取消内容点赞
     * @throws \think\db\exception\DbException
     */
    public function delLike()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '内容ID不能为空！']);
        if ($this->app->db->name('DataArticleLike')->where($data)->delete() !== false) {
            ArticleService::instance()->syncTotal($data['cid']);
            $this->success('取消点赞成功！');
        } else {
            $this->error('取消点赞失败！');
        }
    }

    /**
     * 获取浏览历史
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getHistory()
    {
        $query = $this->_query('DataArticleHistory')->where(['mid' => $this->mid]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        if (count($result['list']) > 0) {
            $ids = array_unique(array_column($result['list'], 'cid'));
            $fields = 'id,title,logo,source,number_likes,number_reads,number_comment,number_collection,status,deleted,create_at';
            $articles = $this->app->db->name('DataArticleContent')->whereIn('id', $ids)->column($fields, 'id');
            foreach ($result['list'] as &$vo) $vo['record'] = $articles[$vo['cid']] ?? [];
        }
        $this->success('获取浏览历史成功！', $result);
    }

}