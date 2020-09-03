<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\NewsService;

/**
 * 文章评论内容
 * Class News
 * @package app\data\controller\api\auth
 */
class News extends Auth
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
        if ($this->app->db->name('DataNewsXComment')->insert($data) !== false) {
            NewsService::instance()->syncNewsTotal($data['cid']);
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
        if ($this->app->db->name('DataNewsXComment')->where($data)->delete() !== false) {
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
        $query = $this->app->db->name('DataNewsXComment')->where($data)->order('id desc');
        $this->success('获取评论列表成功', ['list' => $query->select()->toArray()]);
    }

    /**
     * 添加内容收藏
     * @throws \think\db\exception\DbException
     */
    public function addCollect()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '内容ID不能为空！']);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->count() > 0) {
            $this->success('您已收藏！');
        }
        if ($this->app->db->name('DataNewsXCollect')->insert($data) !== false) {
            NewsService::instance()->syncNewsTotal($data['cid']);
            $this->success('收藏成功！');
        } else {
            $this->error('收藏失败！');
        }
    }

    /**
     * 取消收藏文章
     * @throws \think\db\exception\DbException
     */
    public function delCollect()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '文章ID不能为空！']);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->delete() !== false) {
            NewsService::instance()->syncNewsTotal($data['cid']);
            $this->success('取消收藏成功！');
        } else {
            $this->error('取消收藏失败！');
        }
    }

    /**
     * 获取我收藏的资讯
     * @throws \think\db\exception\DbException
     */
    public function getMyCollect()
    {
        $query = $this->_query('DataNewsXCollect')->where(['mid' => $this->mid]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListByCid($result['list']);
        $this->success('获取收藏记录成功！', $result);
    }

    /**
     * 添加内容点赞
     * @throws \think\db\exception\DbException
     */
    public function addLike()
    {
        $data = $this->_vali(['mid.value' => $this->mid, 'cid.require' => '内容ID不能为空！']);
        if ($this->app->db->name('DataNewsXLike')->where($data)->count() > 0) {
            $this->success('您已点赞！');
        }
        if ($this->app->db->name('DataNewsXLike')->insert($data) !== false) {
            NewsService::instance()->syncNewsTotal($data['cid']);
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
        if ($this->app->db->name('DataNewsXLike')->where($data)->delete() !== false) {
            NewsService::instance()->syncNewsTotal($data['cid']);
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
        $query = $this->_query('DataNewsXHistory');
        $query->where(['mid' => $this->mid])->order('id desc');
        $result = $query->page(true, false, false, 15);
        NewsService::instance()->buildListByCid($result['list']);
        $this->success('获取浏览历史成功！', $result);
    }

}