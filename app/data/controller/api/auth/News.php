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
     * 用户评论内容
     * @throws \think\db\exception\DbException
     */
    public function addComment()
    {
        $data = $this->_vali([
            'uid.value'       => $this->uuid,
            'code.require'    => '文章不能为空！',
            'content.require' => '内容不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXComment')->insert($data) !== false) {
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
        $map = $this->_vali(['uid.value' => $this->uuid, 'code.require' => '文章不能为空！']);
        $result = $this->_query('DataNewsXComment')->where($map)->order('id desc')->page(true, false);
        NewsService::instance()->buildListByUidAndCode($result);
        $this->success('获取评论列表成功', $result);
    }

    /**
     * 删除内容评论
     * @throws \think\db\exception\DbException
     */
    public function delComment()
    {
        $map = $this->_vali([
            'uid.value'    => $this->uuid,
            'id.require'   => '评论ID不能为空！',
            'code.require' => '文章CODE不能为空！',
        ]);
        if ($this->app->db->name('DataNewsXComment')->where($map)->delete() !== false) {
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
        $map = $this->_getCollectWhere(1);
        if ($this->app->db->name('DataNewsXCollect')->where($map)->count() > 0) {
            $this->success('您已收藏！');
        }
        if ($this->app->db->name('DataNewsXCollect')->insert($map) !== false) {
            NewsService::instance()->syncNewsTotal($map['code']);
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
        $map = $this->_getCollectWhere(1);
        if ($this->app->db->name('DataNewsXCollect')->where($map)->delete() !== false) {
            NewsService::instance()->syncNewsTotal($map['code']);
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
        $map = $this->_getCollectWhere(2);
        if ($this->app->db->name('DataNewsXCollect')->where($map)->count() > 0) {
            $this->success('您已点赞！');
        }
        if ($this->app->db->name('DataNewsXCollect')->insert($map) !== false) {
            NewsService::instance()->syncNewsTotal($map['code']);
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
        $map = $this->_getCollectWhere(2);
        if ($this->app->db->name('DataNewsXCollect')->where($map)->delete() !== false) {
            NewsService::instance()->syncNewsTotal($map['code']);
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
        $query = $this->_query('DataNewsXCollect')->order('id desc');
        $result = $query->where(['uid' => $this->uuid, 'type' => 2])->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取点赞记录成功！', $result);
    }

    /**
     * 获取用户的浏览历史
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getHistory()
    {
        $query = $this->_query('DataNewsXCollect')->order('id desc');
        $result = $query->where(['uid' => $this->uuid, 'type' => 3])->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取浏览历史成功！', $result);
    }

    /**
     * 获取收藏点赞
     * @param integer $type 数据类型
     * @return array
     */
    private function _getCollectWhere(int $type = 1): array
    {
        return $this->_vali([
            'uid.value'    => $this->uuid,
            'type.value'   => $type,
            'code.require' => '编号不能为空！',
        ]);
    }

}