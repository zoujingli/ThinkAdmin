<?php

namespace app\data\controller\api;

use think\admin\Controller;

/**
 * 文章接口控制器
 * Class Article
 * @package app\data\controller\api
 */
class Article extends Controller
{
    /**
     * 获取文章标签列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getTags()
    {
        $query = $this->_query('DataArticleTags')->like('title');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $this->success('获取文章标签列表', $query->order('sort desc,id desc')->page(false, false));
    }

    /**
     * 获取文章内容列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getContent()
    {
        if (($id = intval(input('id', 0))) > 0) {
            $this->app->db->name('DataArticleContent')->where(['id' => $id])->update([
                'number_reads' => $this->app->db->raw('`number_reads`+1'),
            ]);
            if (input('mid') > 0) {
                $history = ['mid' => input('mid'), 'cid' => $id];
                $this->app->db->name('DataArticleHistory')->where($history)->delete();
                $this->app->db->name('DataArticleHistory')->insert($history);
            }
        }
        $query = $this->_query('DataArticleContent')->equal('type,id')->like('title,tags');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $result = $query->order('sort desc,id desc')->page(true, false, false, 15);
        foreach ($result['list'] as &$vo) $vo['tags'] = trim($vo['tags'], ',');
        $this->success('获取文章内容列表', $result);
    }

    /**
     * 获取文章评论
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getComment()
    {
        $data = $this->_vali(['cid.require' => '文章ID不能为空！']);
        $query = $this->_query('DataArticleComment')->where($data);
        $result = $query->order('id desc')->page(false, false, false, 5);
        if (count($result['list']) > 0) {
            $ids = array_unique(array_column($result['list'], 'mid'));
            $mems = $this->app->db->name('DataMember')->whereIn('id', $ids)->column('id,nickname,username,headimg', 'id');
            foreach ($result['list'] as &$vo) $vo['member'] = $mems[$vo['mid']] ?? [];
        }
        $this->success('获取文章评论成功！', $result);
    }

    /**
     * 获取已点赞的会员
     */
    public function getLike()
    {
        $data = $this->_vali(['cid.require' => '文章ID不能为空！']);
        $query = $this->app->db->name('DataArticleLike')->where($data);
        $this->success('获取已点赞的会员', ['list' => $query->order('mid asc')->column('mid')]);
    }

    /**
     * 获取已收藏的会员
     */
    public function getCollection()
    {
        $data = $this->_vali(['cid.require' => '文章ID不能为空！']);
        $query = $this->app->db->name('DataArticleCollection')->where($data);
        $this->success('获取已收藏的会员', ['list' => $query->order('mid asc')->column('mid')]);
    }
}