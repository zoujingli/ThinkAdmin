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

use service\FileService;
use service\WechatService;
use think\Controller;
use think\Db;

class Review extends Controller {

    /**
     * 显示手机预览
     * @return string
     */
    public function index() {
        $get = $this->request->get();
        // 内容
        $content = $this->request->get('content', '');
        $this->assign('content', $content);
        // 类型
        $type = $this->request->get('type', 'text');
        $this->assign('type', $type);
        // 图文处理
        if ($type === 'news' && is_numeric($content) && !empty($content)) {
            $news = WechatService::getNewsById($content);
            $this->assign('articles', $news['articles']);
        }
        // 文章预览
        if ($type === 'article' && is_numeric($content) && !empty($content)) {
            $article = Db::name('WechatNewsArticle')->where('id', $content)->find();
            $this->assign('vo', $article);
        }
        $this->assign($get);
        // 渲染模板并显示
        return view();
    }

    /**
     * 微信图片显示
     */
    public function img() {
        $url = $this->request->get('url', '');
        $filename = 'wechat/tmp/' . join('/', str_split(md5($url), 16)) . '.jpg';
        if (false === ($img = FileService::getFileUrl($filename))) {
            $info = FileService::save($filename, file_get_contents($url));
            $img = (is_array($info) && isset($info['url'])) ? $info['url'] : $url;
        }
        $this->redirect($img);
    }

}