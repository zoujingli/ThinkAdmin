<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
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
        foreach ($data as &$vo) $vo = MediaService::instance()->news($vo['id']);
    }

    /**
     * 图文选择器
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @auth true
     */
    public function select()
    {
        $this->index();
    }

    /**
     * 图文列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _select_page_filter(&$data)
    {
        foreach ($data as &$vo) $vo = MediaService::instance()->news($vo['id']);
    }

    /**
     * 添加微信图文
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        if ($this->request->isGet()) {
            $this->title = '新建图文';
            $this->fetch('form');
        } else {
            $data = $this->request->post();
            if (($ids = $this->_buildArticle($data['data'])) && !empty($ids)) {
                if (data_save($this->table, ['article_id' => $ids, 'create_by' => session('user.id')], 'id') !== false) {
                    $url = url('@admin') . '#' . url('@wechat/news/index') . '?spm=' . $this->request->get('spm');
                    $this->success('图文添加成功！', $url);
                }
            }
            $this->error('图文添加失败，请稍候再试！');
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
        if (($this->id = $this->request->get('id')) < 1) {
            $this->error('参数错误，请稍候再试！');
        }
        if ($this->request->isGet()) {
            if ($this->request->get('output') === 'json') {
                $this->success('获取数据成功！', MediaService::instance()->news($this->id));
            } else {
                $this->fetch('form', ['title' => '编辑图文']);
            }
        } else {
            $post = $this->request->post();
            if (isset($post['data']) && ($ids = $this->_buildArticle($post['data']))) {
                if (data_save('wechat_news', ['id' => $this->id, 'article_id' => $ids], 'id')) {
                    $this->success('图文更新成功！', 'javascript:history.back()');
                }
            }
            $this->error('图文更新失败，请稍候再试！');
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
        foreach ($data as &$vo) {
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
            if ($result !== false) {
                array_push($ids, $id);
            }
        }
        return join(',', $ids);
    }

    /**
     * 删除微信图文
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
