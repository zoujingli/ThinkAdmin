<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\MediaService;
use think\admin\Controller;
use think\admin\service\AdminService;

/**
 * 微信图文管理
 * Class News
 * @package app\wechat\controller
 */
class News extends Controller
{

    /**
     * 设置默认操作表
     * @var string
     */
    protected $table = 'WechatNews';

    /**
     * 微信图文管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '微信图文列表';
        $this->_query($this->table)->where(['is_deleted' => '0'])->order('id desc')->page();
    }

    /**
     * 图文列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _index_page_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo = MediaService::instance()->news($vo['id']);
        }
    }

    /**
     * 图文选择器
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $this->index();
    }

    /**
     * 列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _select_page_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo = MediaService::instance()->news($vo['id']);
        }
    }

    /**
     * 添加微信图文
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function add()
    {
        if ($this->request->isGet()) {
            $this->title = '新建图文';
            $this->fetch('form');
        } else {
            $update = [
                'create_by'  => AdminService::instance()->getUserId(),
                'article_id' => $this->_buildArticle($this->request->post('data', [])),
            ];
            if ($this->app->db->name($this->table)->insert($update) !== false) {
                $this->success('图文添加成功！', 'javascript:history.back()');
            } else {
                $this->error('图文添加失败，请稍候再试！');
            }
        }
    }

    /**
     * 编辑微信图文
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->id = $this->request->get('id');
        if (empty($this->id)) $this->error('参数错误，请稍候再试！');
        if ($this->request->isGet()) {
            if ($this->request->get('output') === 'json') {
                $this->success('获取数据成功！', MediaService::instance()->news($this->id));
            } else {
                $this->title = '编辑图文';
                $this->fetch('form');
            }
        } else {
            $ids = $this->_buildArticle($this->request->post('data', []));
            list($map, $data) = [['id' => $this->id], ['article_id' => $ids]];
            if ($this->app->db->name($this->table)->where($map)->update($data) !== false) {
                $this->success('图文更新成功！', 'javascript:history.back()');
            } else {
                $this->error('图文更新失败，请稍候再试！');
            }
        }
    }

    /**
     * 图文更新操作
     * @param array $data
     * @param array $ids
     * @return string
     * @throws \think\db\exception\DbException
     */
    private function _buildArticle($data, $ids = [])
    {
        foreach ($data as $vo) {
            if (empty($vo['digest'])) {
                $vo['digest'] = mb_substr(strip_tags(str_replace(["\s", '　'], '', $vo['content'])), 0, 120);
            }
            $vo['create_at'] = date('Y-m-d H:i:s');
            if (empty($vo['id'])) {
                $result = $id = $this->app->db->name('WechatNewsArticle')->insertGetId($vo);
            } else {
                $id = intval($vo['id']);
                $result = $this->app->db->name('WechatNewsArticle')->where('id', $id)->update($vo);
            }
            if ($result !== false) array_push($ids, $id);
        }
        return join(',', $ids);
    }

    /**
     * 删除微信图文
     * auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
