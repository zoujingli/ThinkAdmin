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
        $query->where(['status' => 1, 'deleted' => 0])->withoutField('sort,status,deleted');
        $this->success('获取文章标签', $query->order('sort desc,id desc')->page(false, false));
    }

    /**
     * 获取文章内容列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getItem()
    {
        if ($code = input('code', '')) {
            $this->app->db->name('DataNewsItem')->where(['code' => $code])->inc('num_read')->update();
            if (($uid = input('uid', 0)) > 0) {
                $data = ['uid' => $uid, 'code' => $code, 'type' => 3, 'status' => 2];
                $this->app->db->name('DataNewsXCollect')->where($data)->delete();
                $this->app->db->name('DataNewsXCollect')->insert($data);
            }
        }
        $query = $this->_query('DataNewsItem')->like('name,mark')->equal('id,code');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $result = $query->order('sort desc,id desc')->page(true, false, false, 15);
        NewsService::instance()->buildData($result['list'], input('uid', 0));
        $this->success('获取文章内容', $result);
    }

    /**
     * 获取文章评论
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getComment()
    {
        $map = $this->_vali(['code.require' => '文章不能为空！']);
        $query = $this->_query('DataNewsXCollect')->where(['type' => 4, 'status' => 2]);
        $result = $query->where($map)->order('id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取评论成功', $result);
    }

}