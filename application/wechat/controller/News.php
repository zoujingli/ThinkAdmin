<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\Media;
use library\Controller;
use think\Db;

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
     * @return array|string
     */
    public function index()
    {
        $this->title = '微信图文列表';
        $db = Db::name($this->table)->where(['is_deleted' => '0']);
        return parent::_page($db->order('id desc'));
    }

    /**
     * 图文列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _index_page_filter(&$data)
    {
        foreach ($data as &$vo) $vo = Media::news($vo['id']);
    }

    /**
     * 图文选择器
     * @return string
     */
    public function select()
    {
        return $this->index();
    }

    /**
     * 图文列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _select_page_filter(&$data)
    {
        foreach ($data as &$vo) $vo = Media::news($vo['id']);
    }

    /**
     * 添加微信图文
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if ($this->request->isGet()) {
            $this->title = '新建图文';
            return $this->fetch('form');
        }
        $data = $this->request->post();
        if (($ids = $this->_apply_news_article($data['data'])) && !empty($ids)) {
            if (data_save($this->table, ['article_id' => $ids, 'create_by' => session('user.id')], 'id') !== false) {
                $url = url('@admin') . '#' . url('@wechat/news/index') . '?spm=' . $this->request->get('spm');
                $this->success('图文添加成功！', $url);
            }
        }
        $this->error('图文添加失败，请稍候再试！');
    }

    /**
     * 编辑微信图文
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $id = $this->request->get('id', '');
        if ($this->request->isGet()) {
            empty($id) && $this->error('参数错误，请稍候再试！');
            if ($this->request->get('output') === 'json') {
                $this->success('获取数据成功！', Media::news($id));
            }
            return $this->fetch('form', ['title' => '编辑图文']);
        }
        $post = $this->request->post();
        if (isset($post['data']) && ($ids = $this->_apply_news_article($post['data']))) {
            if (data_save('wechat_news', ['id' => $id, 'article_id' => $ids], 'id')) {
                $this->success('图文更新成功！', url('@admin') . '#' . url('@wechat/news/index'));
            }
        }
        $this->error('图文更新失败，请稍候再试！');
    }

    /**
     * 图文更新操作
     * @param array $data
     * @param array $ids
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function _apply_news_article($data, $ids = [])
    {
        foreach ($data as &$vo) {
            $vo['create_at'] = date('Y-m-d H:i:s');
            if (empty($vo['digest'])) {
                $vo['digest'] = mb_substr(strip_tags(str_replace(["\s", '　'], '', $vo['content'])), 0, 120);
            }
            if (empty($vo['id'])) {
                $result = $id = Db::name('WechatNewsArticle')->insertGetId($vo);
            } else {
                $id = intval($vo['id']);
                $result = Db::name('WechatNewsArticle')->where('id', $id)->update($vo);
            }
            if ($result !== false) array_push($ids, $id);
        }
        return join(',', $ids);
    }

    /**
     * 删除微信图文
     */
    public function del()
    {
        $this->_delete($this->table);
    }

}