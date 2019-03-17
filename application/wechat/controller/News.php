<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\MediaService;
use controller\BasicAdmin;
use service\DataService;
use service\LogService;
use service\ToolsService;
use service\WechatService;
use think\Db;
use think\facade\Log;

/**
 * 微信图文管理
 * Class News
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class News extends BasicAdmin
{

    /**
     * 设置默认操作表
     * @var string
     */
    public $table = 'WechatNews';

    /**
     * 图文列表
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->title = '微信图文列表';
        $db = Db::name($this->table)->where(['is_deleted' => '0']);
        return parent::_list($db->order('id desc'));
    }

    /**
     * 图文列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _index_data_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo = MediaService::getNewsById($vo['id']);
        }
    }

    /**
     * 图文选择器
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
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
    protected function _select_data_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo = MediaService::getNewsById($vo['id']);
        }
    }

    /**
     * 媒体资源显示
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function image()
    {
        $_GET['rows'] = 18;
        $this->assign('field', $this->request->get('field', 'local_url'));
        return $this->_list(Db::name('WechatNewsMedia')->where('type', 'image'));
    }

    /**
     * 添加图文
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if ($this->request->isGet()) {
            return $this->fetch('form', ['title' => '新建图文']);
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (($ids = $this->_apply_news_article($data['data'])) && !empty($ids)) {
                $post = ['article_id' => $ids, 'create_by' => session('user.id')];
                if (DataService::save($this->table, $post, 'id') !== false) {
                    $url = url('@admin') . '#' . url('@wechat/news/index') . '?spm=' . $this->request->get('spm');
                    $this->success('图文添加成功！', $url);
                }
            }
            $this->error('图文添加失败，请稍候再试！');
        }
    }

    /**
     * 编辑图文
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
                ToolsService::success('获取数据成功', MediaService::getNewsById($id));
            }
            return $this->fetch('form', ['title' => '编辑图文']);
        }
        $data = $this->request->post();
        $ids = $this->_apply_news_article($data['data']);
        if (!empty($ids)) {
            $post = ['id' => $id, 'article_id' => $ids, 'create_by' => session('user.id')];
            if (false !== DataService::save('wechat_news', $post, 'id')) {
                $url = url('@admin') . '#' . url('@wechat/news/index') . '?spm=' . $this->request->get('spm');
                $this->success('图文更新成功!', $url);
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
    protected function _apply_news_article($data, $ids = [])
    {
        foreach ($data as &$vo) {
            $vo['create_by'] = session('user.id');
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
            if ($result !== false) {
                $ids[] = $id;
            }
        }
        return join(',', $ids);
    }

    /**
     * 删除用户
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        if (DataService::update($this->table)) {
            $this->success("图文删除成功!", '');
        }
        $this->error("图文删除失败, 请稍候再试!");
    }

    /**
     * 推荐图文
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function push()
    {
        # 获取将要推送的粉丝列表
        switch (strtolower($this->request->get('action', ''))) {
            case 'getuser':
                if ('' === ($params = $this->request->post('group', ''))) {
                    return ['code' => 'SUCCESS', 'data' => []];
                }
                list($ids, $db) = [explode(',', $params), Db::name('WechatFans')];
                !in_array('0', $ids) && $db->where("concat(',',tagid_list,',') REGEXP '," . join(',|,', $ids) . ",'");
                $list = $db->where(['subscribe' => '1'])->limit(200)->column('nickname');
                foreach ($list as &$vo) {
                    $vo = ToolsService::emojiDecode($vo);
                }
                return ['code' => "SUCCESS", 'data' => $list];
            default :
                $news_id = $this->request->get('id', '');
                // 显示及图文
                $newsinfo = MediaService::getNewsById($news_id);
                // Get 请求，显示选择器界面
                if ($this->request->isGet()) {
                    $fans_tags = (array)Db::name('WechatFansTags')->select();
                    $count = Db::name('WechatFans')->where(['subscribe' => '1'])->count();
                    array_unshift($fans_tags, ['id' => 0, 'name' => '全部', 'count' => $count]);
                    return $this->fetch('push', ['vo' => $newsinfo, 'fans_tags' => $fans_tags]);
                }
                // Post 请求，执行图文推送操作
                $post = $this->request->post();
                empty($post['fans_tags']) && $this->error('还没有选择要粉丝对象！');
                // 图文上传操作
                !$this->_uploadWechatNews($newsinfo) && $this->error('图文上传失败，请稍候再试！');
                // 数据拼装
                $data = [];
                if (in_array('0', $post['fans_tags'])) {
                    $data['msgtype'] = 'mpnews';
                    $data['filter'] = ['is_to_all' => true];
                    $data['mpnews'] = ['media_id' => $newsinfo['media_id']];
                } else {
                    $data['msgtype'] = 'mpnews';
                    $data['filter'] = ['is_to_all' => false, 'tag_id' => join(',', $post['fans_tags'])];
                    $data['mpnews'] = ['media_id' => $newsinfo['media_id']];
                }
                if (WechatService::WeChatCustom()->massSendAll($data)) {
                    LogService::write('微信管理', "图文[{$news_id}]推送成功");
                    $this->success('微信图文推送成功！', '');
                }
                $this->error("微信图文推送失败");
        }
    }

    /**
     * 上传永久图文
     * @param array $news
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function _uploadWechatNews(&$news)
    {
        foreach ($news['articles'] as &$article) {
            $article['thumb_media_id'] = MediaService::uploadForeverMedia($article['local_url']);
            $article['content'] = preg_replace_callback("/<img(.*?)src=['\"](.*?)['\"](.*?)\/?>/i", function ($matches) {
                $src = MediaService::uploadImage($matches[2]);
                return "<img{$matches[1]}src=\"{$src}\"{$matches[3]}/>";
            }, $article['content']);
        }
        $wechat = WechatService::WeChatMedia();
        // 如果已经上传过，先删除之前的历史记录
        !empty($news['media_id']) && $wechat->delMaterial($news['media_id']);
        // 上传图文到微信服务器
        $result = $wechat->addNews(['articles' => $news['articles']]);
        if (isset($result['media_id'])) {
            $news['media_id'] = $result['media_id'];
            return Db::name('WechatNews')->where(['id' => $news['id']])->update(['media_id' => $result['media_id']]);
        }
        Log::error("上传永久图文失败");
        return false;
    }

}
