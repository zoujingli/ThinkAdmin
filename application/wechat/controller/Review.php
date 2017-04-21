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
            $news = News::get($content, ['appid' => $this->real_appid]);
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
    public function wechatImage() {
        $url = input('get.url', '');
        $filename = 'upload/tmp/' . join('/', str_split(md5($url), 16));
        $realfile = ROOT_PATH . 'public/' . $filename;
        file_exists(dirname($realfile)) || mkdir(dirname($realfile), 0755, true);
        if (!file_exists($realfile)) {
            file_put_contents($realfile, file_get_contents($url));
        }
        $this->redirect(pathinfo($this->requestbaseFile(true), PATHINFO_DIRNAME) . '/' . $filename);
    }

}