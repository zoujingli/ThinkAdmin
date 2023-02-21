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

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\model\DataNewsXCollect;
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
     */
    public function addComment()
    {
        $data = $this->_vali([
            'uuid.value'    => $this->uuid,
            'type.value'    => 4,
            'status.value'  => 1,
            'code.require'  => '文章不能为空！',
            'reply.require' => '评论不能为空！',
        ]);
        if (DataNewsXCollect::mk()->insert($data) !== false) {
            NewsService::syncNewsTotal($data['code']);
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
        $query = DataNewsXCollect::mQuery()->where(['uuid' => $this->uuid, 'type' => 4]);
        $result = $query->whereIn('status', [1, 2])->order('id desc')->page(true, false);
        NewsService::buildListByUidAndCode($result);
        $this->success('获取评论列表成功', $result);
    }

    /**
     * 删除内容评论
     */
    public function delComment()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.value'   => 4,
            'id.require'   => '评论编号不能为空！',
            'code.require' => '文章编号不能为空！',
        ]);
        if (DataNewsXCollect::mk()->where($data)->delete() !== false) {
            $this->success('评论删除成功！');
        } else {
            $this->error('认证删除失败！');
        }
    }

    /**
     * 添加内容收藏
     */
    public function addCollect()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.value'   => 1,
            'status.value' => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        if (DataNewsXCollect::mk()->where($data)->count() > 0) {
            $this->success('您已收藏！');
        }
        if (DataNewsXCollect::mk()->insert($data) !== false) {
            NewsService::syncNewsTotal($data['code']);
            $this->success('收藏成功！');
        } else {
            $this->error('收藏失败！');
        }
    }

    /**
     * 取消收藏文章
     */
    public function delCollect()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.value'   => 1,
            'code.require' => '文章编号不能为空！',
        ]);
        if (DataNewsXCollect::mk()->where($data)->delete() !== false) {
            NewsService::syncNewsTotal($data['code']);
            $this->success('取消收藏成功！');
        } else {
            $this->error('取消收藏失败！');
        }
    }

    /**
     * 获取用户收藏的资讯
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCollect()
    {
        $map = ['uuid' => $this->uuid, 'type' => 1];
        $query = DataNewsXCollect::mQuery()->where($map);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::buildListByUidAndCode($result['list']);
        $this->success('获取收藏记录成功！', $result);
    }

    /**
     * 添加内容点赞
     */
    public function addLike()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.value'   => 2,
            'status.value' => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        if (DataNewsXCollect::mk()->where($data)->count() > 0) {
            $this->success('您已点赞！');
        }
        if (DataNewsXCollect::mk()->insert($data) !== false) {
            NewsService::syncNewsTotal($data['code']);
            $this->success('点赞成功！');
        } else {
            $this->error('点赞失败！');
        }
    }

    /**
     * 取消内容点赞
     */
    public function delLike()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.value'   => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        if (DataNewsXCollect::mk()->where($data)->delete() !== false) {
            NewsService::syncNewsTotal($data['code']);
            $this->success('取消点赞成功！');
        } else {
            $this->error('取消点赞失败！');
        }
    }

    /**
     * 获取用户收藏的资讯
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getLike()
    {
        $query = DataNewsXCollect::mQuery();
        $query->where(['uuid' => $this->uuid, 'type' => 2, 'status' => 2]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::buildListByUidAndCode($result['list']);
        $this->success('获取点赞记录成功！', $result);
    }

    /**
     * 添加用户的浏览历史
     */
    public function addHistory()
    {
        $data = $this->_vali([
            'uuid.value'   => $this->uuid,
            'type.value'   => 2,
            'status.value' => 2,
            'code.require' => '文章编号不能为空！',
        ]);
        DataNewsXCollect::mk()->where($data)->delete();
        DataNewsXCollect::mk()->insert($data);
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
        $query = DataNewsXCollect::mQuery();
        $query->where(['uuid' => $this->uuid, 'type' => 3, 'status' => 2]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        NewsService::buildListByUidAndCode($result['list']);
        $this->success('获取浏览历史成功！', $result);
    }
}