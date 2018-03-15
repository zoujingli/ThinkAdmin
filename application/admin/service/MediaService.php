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

namespace app\wechat\service;

use service\WechatService;
use think\Db;

/**
 * 微信媒体文件管理
 * Class MediaService
 * @package app\wechat\service
 */
class MediaService
{
    /**
     * 通过图文ID读取图文信息
     * @param int $id 本地图文ID
     * @param array $where 额外的查询条件
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getNewsById($id, $where = [])
    {
        $data = Db::name('WechatNews')->where(['id' => $id])->where($where)->find();
        $article_ids = explode(',', $data['article_id']);
        $articles = Db::name('WechatNewsArticle')->whereIn('id', $article_ids)->select();
        $data['articles'] = [];
        foreach ($article_ids as $article_id) {
            foreach ($articles as $article) {
                if (intval($article['id']) === intval($article_id)) {
                    unset($article['create_by'], $article['create_at']);
                    $article['content'] = htmlspecialchars_decode($article['content']);
                    $data['articles'][] = $article;
                }
            }
        }
        return $data;
    }

    /**
     * 上传图片到微信服务器
     * @param string $local_url 图文地址
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public static function uploadImage($local_url)
    {
        $media_url = Db::name('WechatNewsImage')->where(['md5' => md5($local_url)])->value('media_url');
        if (!empty($media_url)) {
            return $media_url;
        }
        $result = WechatService::wechat()->upFile(base64_encode(file_get_contents($local_url)), $local_url);
        $info = WechatService::media()->uploadImg($result['file']);
        WechatService::wechat()->rmFile($local_url);
        $data = ['local_url' => $local_url, 'media_url' => $info['url'], 'md5' => md5($local_url)];
        Db::name('WechatNewsImage')->insert($data);
        return $info['url'];
    }

    /**
     * 上传图片永久素材，返回素材media_id
     * @param string $local_url 文件URL地址
     * @param string $type 文件类型
     * @param array $video_info 视频信息
     * @return string|null
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function uploadForeverMedia($local_url, $type = 'image', $video_info = [])
    {
        $map = ['md5' => md5($local_url), 'appid' => sysconf('wechat_appid')];
        if (($media_id = Db::name('WechatNewsMedia')->where($map)->value('media_id'))) {
            return $media_id;
        }
        $result = WechatService::wechat()->upFile(base64_encode(file_get_contents($local_url)), $local_url);
        $result = WechatService::media()->addMaterial($result['file'], $type, $video_info);
        WechatService::wechat()->rmFile($local_url);
        $data = ['md5' => $map['md5'], 'type' => $type, 'appid' => $map['appid'], 'media_id' => $result['media_id'], 'local_url' => $local_url];
        isset($result['url']) && $data['media_url'] = $result['url'];
        Db::name('WechatNewsMedia')->insert($data);
        return $data['media_id'];
    }

}