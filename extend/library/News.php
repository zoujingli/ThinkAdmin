<?php

namespace library;

use think\Db;
use think\Log;

/**
 * 微信图文处理器
 *
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/03/15 17:28
 */
class News {

    /**
     * 通过图文ID读取图文信息
     * @param int $id 本地图文ID
     * @param array $where 额外的查询条件
     * @return array
     */
    static public function get($id, $where = []) {
        $data = Db::table('wechat_news')->where('id', $id)->where($where)->find();
        $article_ids = explode(',', $data['article_id']);
        $articles = Db::table('wechat_news_article')->where('id', 'in', $article_ids)->select();
        $data['articles'] = array();
        foreach ($article_ids as $article_id) {
            foreach ($articles as $article) {
                if (intval($article['id']) === intval($article_id)) {
                    unset($article['create_by'], $article['create_at']);
                    $data['articles'][] = $article;
                }
            }
        }
        unset($articles);
        return $data;
    }

    /**
     * 上传图片永久素材
     * @param string $appid 公众号APPID
     * @param string $local_url 文件URL地址
     * @param string $type 文件类型
     * @param bool $is_video 是否为视频文件
     * @param array $video_info 视频信息
     * @return string|null
     */
    static public function uploadMedia($appid, $local_url = '', $type = 'image', $is_video = false, $video_info = array()) {
        # 检测文件上否已经上传过了
        $md5 = md5($local_url);
        $wechat = &load_wechat('media', $appid);
        $map = ['md5' => $md5, 'appid' => $wechat->appid];
        if (($result = Db::table('wechat_news_media')->where($map)->find()) && !empty($result)) {
            return $result['media_id'];
        }
        # 下载临时文件到本地
        $filename = ROOT_PATH . 'public/static/upload/wechat/' . join('/', str_split($md5, 16)) . '.' . pathinfo($local_url, PATHINFO_EXTENSION);
        if (!file_exists($filename) || !is_file($filename)) {
            !is_dir(dirname($filename)) && mkdir(dirname($filename), 0755, TRUE);
            file_put_contents($filename, file_get_contents($local_url));
        }
        # 上传图片素材
        $result = $wechat->uploadForeverMedia(array('media' => "@{$filename}"), $type, $is_video, $video_info);
        unlink($filename);
        if (FALSE !== $result) {
            $data = ['appid' => $wechat->appid, 'md5' => $md5, 'type' => $type];
            $data['media_id'] = $result['media_id'];
            isset($result['url']) && $data['media_url'] = $result['url'];
            $data['local_url'] = $local_url;
            if (false !== Db::table('wechat_news_media')->insert($data)) {
                return $data['media_id'];
            }
        }
        Log::error("素材上传失败，请稍后再试！{$wechat->errMsg}[{$wechat->errCode}]");
        return NULL;
    }

}
