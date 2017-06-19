<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

use think\Db;
use think\Log;

/**
 * 微信数据服务
 * Class WechatService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/22 15:32
 */
class WechatService {

    /**
     * 通过图文ID读取图文信息
     * @param int $id 本地图文ID
     * @param array $where 额外的查询条件
     * @return array
     */
    public static function getNewsById($id, $where = []) {
        $data = Db::name('WechatNews')->where('id', $id)->where($where)->find();
        $article_ids = explode(',', $data['article_id']);
        $articles = Db::name('WechatNewsArticle')->where('id', 'in', $article_ids)->select();
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
     * 上传图片到微信服务器 
     * @param string $local_url
     * @return string|null
     */
    public static function uploadImage($local_url) {
        # 检测文件上否已经上传过了
        if (($img = Db::name('WechatNewsImage')->where('md5', md5($local_url))->find()) && isset($img['media_url'])) {
            return $img['media_url'];
        }
        # 下载临时文件到本地
        $filename = 'wechat/image/' . join('/', str_split(md5($local_url), 16)) . '.' . strtolower(pathinfo($local_url, 4));
        $result = FileService::local($filename, file_get_contents($local_url));
        if ($result && isset($result['file'])) {
            # 上传图片到微信服务器
            $wechat = &load_wechat('media');
            $mediainfo = $wechat->uploadImg(['media' => "@{$result['file']}"]);
            if (!empty($mediainfo)) {
                $data = ['local_url' => $local_url, 'media_url' => $mediainfo['url'], 'md5' => md5($local_url)];
                Db::name('WechatNewsImage')->insert($data);
                return $mediainfo['url'];
            }
        }
        Log::error("图片上传失败，请稍后再试！{$wechat->errMsg}[{$wechat->errCode}]");
        return null;
    }

    /**
     * 上传图片永久素材
     * @param string $local_url 文件URL地址
     * @param string $type 文件类型
     * @param bool $is_video 是否为视频文件
     * @param array $video_info 视频信息
     * @return string|null
     */
    public static function uploadForeverMedia($local_url = '', $type = 'image', $is_video = false, $video_info = array()) {
        # 检测文件上否已经上传过了
        $wechat = &load_wechat('media');
        # 检查文件URL是否已经上传为永久素材
        $map = ['md5' => ($md5 = md5($local_url)), 'appid' => $wechat->appid];
        if (($img = Db::name('WechatNewsMedia')->where($map)->find()) && isset($img['media_id'])) {
            return $img['media_id'];
        }
        # 下载临时文件到本地
        $filename = 'wechat/image/' . join('/', str_split(md5($local_url), 16)) . '.' . strtolower(pathinfo($local_url, 4));
        $upload = FileService::local($filename, file_get_contents($local_url));
        if (!empty($upload) && isset($upload['file']) && file_exists($upload['file'])) {
            # 上传图片到微信服务器
            if (false !== ($result = $wechat->uploadForeverMedia(array('media' => "@{$upload['file']}"), $type, $is_video, $video_info))) {
                $data = ['md5' => $md5, 'type' => $type, 'appid' => $wechat->appid, 'media_id' => $result['media_id'], 'local_url' => $local_url];
                isset($result['url']) && $data['media_url'] = $result['url'];
                Db::name('WechatNewsMedia')->insert($data);
                return $data['media_id'];
            }
        }
        Log::error("素材上传失败，请稍后再试！{$wechat->errMsg}[{$wechat->errCode}]");
        return null;
    }

    /**
     * 从微信服务器获取所有标签
     * @return bool
     */
    public static function syncFansTags() {
        $wechat = &load_wechat("User");
        if (($result = $wechat->getTags()) !== false) {
            $tags = $result['tags'];
            foreach ($tags as &$tag) {
                $tag['appid'] = $wechat->appid;
            }
            Db::name('WechatFansTags')->where('appid', $wechat->appid)->delete();
            foreach (array_chunk($tags, 100) as $list) {
                Db::name('WechatFansTags')->insertAll($list);
            }
        }
        return true;
    }

    /**
     * 同步粉丝的标签
     * @param string $openid
     * @return bool
     */
    public static function syncFansTagsByOpenid($openid) {
        $wechat = &load_wechat('User');
        $tagsid = $wechat->getUserTags($openid);
        if ($tagsid === false || !is_array($tagsid)) {
            return false;
        }
        $data = ['appid' => $wechat->appid, 'openid' => $openid, 'tagid_list' => join(',', $tagsid)];
        return DataService::save('wechat_fans', $data, 'openid', ['appid' => $wechat->appid]);
    }

    /**
     * 保存/更新粉丝信息
     * @param array $userInfo
     * @param string $appid
     * @return bool
     */
    public static function setFansInfo($userInfo, $appid = '') {
        if (!empty($userInfo['subscribe_time'])) {
            $userInfo['subscribe_at'] = date('Y-m-d H:i:s', $userInfo['subscribe_time']);
        }
        if (!empty($userInfo['tagid_list']) && is_array($userInfo['tagid_list'])) {
            $userInfo['tagid_list'] = join(',', $userInfo['tagid_list']);
        }
        $userInfo['appid'] = $appid;
        $userInfo['nickname'] = ToolsService::emojiEncode($userInfo['nickname']);
        return DataService::save('WechatFans', $userInfo, 'openid');
    }

    /**
     * 读取粉丝信息
     * @param string $openid 微信用户openid
     * @param string $appid 公众号appid
     * @return array|false
     */
    public static function getFansInfo($openid, $appid = null) {
        $map = ['openid' => $openid];
        is_string($appid) && $map['appid'] = $appid;
        if (($fans = Db::name('WechatFans')->where($map)->find()) && isset($fans['nickname'])) {
            $fans['nickname'] = ToolsService::emojiDecode($fans['nickname']);
        }
        return $fans;
    }

    /**
     * 同步获取粉丝列表
     * @param string $next_openid
     * @return bool
     */
    public static function syncAllFans($next_openid = '') {
        $wechat = &load_wechat('User');
        if (false === ($result = $wechat->getUserList($next_openid)) || empty($result['data']['openid'])) {
            Log::error("获取粉丝列表失败, {$wechat->errMsg} [{$wechat->errCode}]");
            return false;
        }
        foreach (array_chunk($result['data']['openid'], 100) as $openids) {
            if (false === ($info = $wechat->getUserBatchInfo($openids)) || !is_array($info)) {
                Log::error("获取用户信息失败, {$wechat->errMsg} [{$wechat->errCode}]");
                return false;
            }
            foreach ($info as $userInfo) {
                if (false === self::setFansInfo($userInfo, $wechat->appid)) {
                    Log::error('更新粉丝信息更新失败!');
                    return false;
                }
                if ($result['next_openid'] === $userInfo['openid']) {
                    unset($result['next_openid']);
                }
            }
        }
        return !empty($result['next_openid']) ? self::syncAllFans($result['next_openid']) : true;
    }

    /**
     * 同步获取黑名单信息
     * @param string $next_openid
     * @return bool
     */
    public static function syncBlackFans($next_openid = '') {
        $wechat = &load_wechat('User');
        $result = $wechat->getBacklist($next_openid);
        if ($result === false || (empty($result['data']['openid']))) {
            if (empty($result['total'])) {
                return true;
            }
            Log::error("获取粉丝黑名单列表失败，{$wechat->errMsg} [{$wechat->errCode}]");
            return false;
        }
        foreach ($result['data']['openid'] as $openid) {
            if (false === ($userInfo = $wechat->getUserInfo($openid))) {
                Log::error("获取用户[{$openid}]信息失败，$wechat->errMsg");
                return false;
            }
            $userInfo['is_back'] = '1';
            if (false === self::setFansInfo($userInfo)) {
                Log::error('更新粉丝信息更新失败！');
                return false;
            }
            if ($result['next_openid'] === $openid) {
                unset($result['next_openid']);
            }
        }
        return !empty($result['next_openid']) ? self::syncBlackFans($result['next_openid']) : true;
    }

}
