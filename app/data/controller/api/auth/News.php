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
     * 绑定数据表
     * @var string
     */
    protected $table = 'DataNewsXCollect';

    /**
     * 用户评论内容
     * @throws \think\db\exception\DbException
     */
    public function addComment()
    {
        $data = $this->_vali([
            'uid.value'     => $this->uuid,
            'type.value'    => 4,
            'status.value'  => 1,
            'code.require'  => '文章不能为空！',
            'reply.require' => '评论不能为空！',
        ]);
        if ($this->app->db->name($this->table)->insert($data) !== false) {
            NewsService::instance()->syncNewsTotal($data['code']);
            $this->success('添加评论成功！');
        } else {
            $this->error('添加评论失败！');
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
        $query = $this->_query($this->table)->where(['uid' => $this->uuid, 'type' => 4]);
        $result = $query->whereIn('status', [1, 2])->order('id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result);
        $this->success('获取评论列表成功', $result);
    }

    /**
     * 删除内容评论
     * @throws \think\db\exception\DbException
     */
    public function delComment()
    {
        $data = $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => 4,
            'id.require'   => '评论编号不能为空！',
            'code.require' => '文章编号不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->delete() !== false) {
            $this->success('评论删除成功！');
        } else {
            $this->error('认证删除失败！');
        }
    }

    /**
     * 添加内容收藏
     * @throws \think\db\exception\DbException
     */
    public function addCollect()
    {
        $data = $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => 1,
            'status.value' => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->count() > 0) {
            $this->success('您已收藏！');
        }
        if ($this->app->db->name('DataNewsXCollect')->insert($data) !== false) {
            NewsService::instance()->syncNewsTotal($data['code']);
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
        $data = $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => 1,
            'code.require' => '文章编号不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->delete() !== false) {
            NewsService::instance()->syncNewsTotal($data['code']);
            $this->success('取消收藏成功！');
        } else {
            $this->error('取消收藏失败！');
        }
    }

    /**
     * 获取用户收藏的资讯
     * @throws \think\db\exception\DbException
     */
    public function getCollect()
    {
        $map = ['uid' => $this->uuid, 'type' => 1];
        $query = $this->_query('DataNewsXCollect')->where($map);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取收藏记录成功！', $result);
    }

    /**
     * 添加内容点赞
     * @throws \think\db\exception\DbException
     */
    public function addLike()
    {
        $data = $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => 2,
            'status.value' => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->count() > 0) {
            $this->success('您已点赞！');
        }
        if ($this->app->db->name('DataNewsXCollect')->insert($data) !== false) {
            NewsService::instance()->syncNewsTotal($data['code']);
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
        $data = $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXCollect')->where($data)->delete() !== false) {
            NewsService::instance()->syncNewsTotal($data['code']);
            $this->success('取消点赞成功！');
        } else {
            $this->error('取消点赞失败！');
        }
    }

    /**
     * 获取用户收藏的资讯
     * @throws \think\db\exception\DbException
     */
    public function getLike()
    {
        $query = $this->_query('DataNewsXCollect');
        $query->where(['uid' => $this->uuid, 'type' => 2, 'status' => 2]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取点赞记录成功！', $result);
    }

    /**
     * 添加用户的浏览历史
     * @throws \think\db\exception\DbException
     */
    public function addHistory()
    {
        $data = $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => 2,
            'status.value' => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        $this->app->db->name('DataNewsXCollect')->where($data)->delete();
        $this->app->db->name('DataNewsXCollect')->insert($data);
        $this->success('添加浏览历史成功！');
    }

    /**
     * 获取用户的浏览历史
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getHistory()
    {
        $query = $this->_query('DataNewsXCollect');
        $query->where(['uid' => $this->uuid, 'type' => 3, 'status' => 2]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取浏览历史成功！', $result);
    }

}