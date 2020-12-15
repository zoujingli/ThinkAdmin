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
        if ($code = input('code', '')) {
            $this->app->db->name('DataNewsItem')->where(['code' => $code])->update([
                'num_read' => $this->app->db->raw('`num_read`+1'),
            ]);
            if (($mid = input('uid', 0)) > 0) {
                $data = ['uid' => $mid, 'code' => $code, 'type' => 3];
                $this->app->db->name('DataNewsXCollect')->where($data)->delete();
                $this->app->db->name('DataNewsXCollect')->insert($data);
            }
        }
        $query = $this->_query('DataNewsItem')->like('name,mark')->equal('id,code');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $result = $query->order('sort desc,id desc')->page(true, false, false, 15);
        NewsService::instance()->buildListState($result['list'], input('uid', 0));
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
        $map = $this->_vali(['code.require' => '文章不能为空！']);
        $query = $this->_query('DataNewsXComment')->where($map);
        $result = $query->order('id desc')->page(false, false, false, 5);
        NewsService::instance()->buildListByUidAndCode($result['list']);
        $this->success('获取文章评论成功！', $result);
    }

}