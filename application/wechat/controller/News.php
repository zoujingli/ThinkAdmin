<?php
// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use controller\BasicAdmin;
use service\DataService;
use service\WechatService;
use think\Db;

/**
 * 微信图文管理
 * Class News
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class News extends BasicAdmin {

    /**
     * 设置默认操作表
     * @var string
     */
    protected $table = 'WechatNews';

    /**
     * 添加图文
     * @return \think\response\View
     */
    public function add() {
        if ($this->request->isGet()) {
            return view('form', ['title' => '新建图文']);
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (($ids = $this->_apply_news_article($data['data'])) && !empty($ids)) {
                $post = ['article_id' => $ids, 'create_by' => session('user.id')];
                if (DataService::save($this->table, $post, 'id') !== false) {
                    $this->success('图文添加成功！', '');
                }
            }
            $this->error('图文添加失败，请稍候再试！');
        }
    }

    /**
     * 编辑图文
     * @return \think\response\View
     */
    public function edit() {
        $id = $this->request->get('id', '');
        if ($this->request->isGet()) {
            empty($id) && $this->error('参数错误，请稍候再试！');
            return view('form', ['title' => '编辑图文', 'vo' => WechatService::getNewsById($id)]);
        }
        $data = $this->request->post();
        $ids = $this->_apply_news_article($data['data']);
        if (!empty($ids)) {
            $post = ['id' => $id, 'article_id' => $ids, 'create_by' => session('user.id')];
            if (false !== DataService::save('wechat_news', $post, 'id')) {
                $this->success('图文更新成功!', '');
            }
        }
        $this->error('图文更新失败，请稍候再试！');
    }

    /**
     * 图文更新操作
     * @param array $data
     * @param array $ids
     * @return string
     */
    protected function _apply_news_article($data, $ids = []) {
        foreach ($data as &$vo) {
            $vo['create_by'] = session('user.id');
            $vo['create_at'] = date('Y-m-d H:i:s');
            $vo['digest'] = empty($vo['digest']) ? mb_substr(strip_tags($vo['content']), 0, 120) : $vo['digest'];
            if (empty($vo['id'])) {
                $result = $id = Db::name('WechatNewsArticle')->insertGetId($vo);
            } else {
                $id = intval($vo['id']);
                $result = Db::name('WechatNewsArticle')->where('id', $id)->update($vo);
            }
            if ($result !== FALSE) {
                $ids[] = $id;
            }
        }
        return join(',', $ids);
    }

    public function select() {
        return '开发中';
    }
}
