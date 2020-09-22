<?php

namespace app\data\controller\api;

use app\data\service\NewsService;
use think\admin\Controller;

/**
 * 文章接口控制器
 * Class News
 * @package app\data\controller\api
 */
class News extends Controller
{
    /**
     * 获取文章标签列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMark()
    {
        $query = $this->_query('DataNewsMark')->like('name');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $this->success('获取文章标签列表', $query->order('sort desc,id desc')->page(false, false));
    }

    /**
     * 获取文章内容列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getItem()
    {
        if (($id = intval(input('id', 0))) > 0) {
            $this->app->db->name('DataNewsItem')->where(['id' => $id])->update([
                'num_read' => $this->app->db->raw('`num_read`+1'),
            ]);
            if (input('mid', 0) > 0) {
                $history = ['mid' => input('mid'), 'cid' => $id];
                $this->app->db->name('DataNewsXHistory')->where($history)->delete();
                $this->app->db->name('DataNewsXHistory')->insert($history);
            }
        }
        $query = $this->_query('DataNewsItem')->like('name,mark')->equal('id');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $result = $query->order('sort desc,id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListState($result['list'], input('mid', 0));
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
        $map = $this->_vali(['cid.require' => '文章不能为空！']);
        $query = $this->_query('DataNewsXComment')->where($map);
        $result = $query->order('id desc')->page(false, false, false, 5);
        NewsService::instance()->buildListByCidAndMid($result['list']);
        $this->success('获取文章评论成功！', $result);
    }

}