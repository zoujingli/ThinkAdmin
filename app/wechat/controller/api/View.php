<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\model\WechatNewsArticle;
use app\wechat\service\MediaService;
use think\admin\Controller;

/**
 * 微信图文显示
 * @class View
 * @package app\wechat\controller\api
 */
class View extends Controller
{

    /**
     * 图文列表展示
     * @param string|integer $id 图文ID编号
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function news($id = 0)
    {
        $this->id = $id ?: input('id', 0);
        $this->news = MediaService::news($this->id);
        $this->fetch();
    }

    /**
     * 文章内容展示
     * @param string|integer $id 文章ID编号
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function item($id = 0)
    {
        $map = ['id' => $id ?: input('id', 0)];
        WechatNewsArticle::mk()->where($map)->update([
            'read_num' => $this->app->db->raw('read_num+1'),
        ]);
        $this->info = WechatNewsArticle::mk()->where($map)->find();
        $this->fetch();
    }

    /**
     * 文本展示
     */
    public function text()
    {
        $this->content = strip_tags(input('content', ''), '<a><img>');
        $this->fetch();
    }

    /**
     * 图片展示
     */
    public function image()
    {
        $this->content = strip_tags(input('content', ''), '<a><img>');
        $this->fetch();
    }

    /**
     * 视频展示
     */
    public function video()
    {
        $this->url = strip_tags(input('url', ''), '<a><img>');
        $this->title = strip_tags(input('title', ''), '<a><img>');
        $this->fetch();
    }

    /**
     * 语音展示
     */
    public function voice()
    {
        $this->url = strip_tags(input('url', ''), '<a><img>');
        $this->fetch();
    }

    /**
     * 音乐展示
     */
    public function music()
    {
        $this->url = strip_tags(input('url', ''), '<a><img>');
        $this->desc = strip_tags(input('desc', ''), '<a><img>');
        $this->title = strip_tags(input('title', ''), '<a><img>');
        $this->fetch();
    }
}
