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

namespace app\data\controller\api;

use app\data\model\DataNewsItem;
use app\data\model\DataNewsMark;
use app\data\model\DataNewsXCollect;
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
        $query = DataNewsMark::mQuery()->like('name');
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
            DataNewsItem::mk()->where(['code' => $code])->inc('num_read')->update([]);
            if (($uuid = input('uuid', 0)) > 0) {
                $data = ['uuid' => $uuid, 'code' => $code, 'type' => 3, 'status' => 2];
                DataNewsXCollect::mk()->where($data)->delete();
                DataNewsXCollect::mk()->insert($data);
            }
        }
        $query = DataNewsItem::mQuery()->like('name,mark')->equal('id,code');
        $query->where(['deleted' => 0, 'status' => 1])->withoutField('sort,status,deleted');
        $result = $query->order('sort desc,id desc')->page(true, false, false, 15);
        NewsService::buildData($result['list'], input('uuid', 0));
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
        $query = DataNewsXCollect::mQuery()->where(['type' => 4, 'status' => 2]);
        $result = $query->where($map)->order('id desc')->page(true, false, false, 15);
        NewsService::buildListByUidAndCode($result['list']);
        $this->success('获取评论成功', $result);
    }
}