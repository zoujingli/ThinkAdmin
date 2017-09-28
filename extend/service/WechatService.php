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
class WechatService
{

    /**
     * 通过图文ID读取图文信息
     * @param int $id 本地图文ID
     * @param array $where 额外的查询条件
     * @return array
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
        unset($articles);
        return $data;
    }

    /**
     * 上传图片到微信服务器
     * @param string $local_url
     * @return string|null
     */
    public static function uploadImage($local_url)
    {
        # 检测文件上否已经上传过了
        $md5 = md5($local_url);
        if (($img = Db::name('WechatNewsImage')->where(['md5' => $md5])->find()) && !empty($img['media_url'])) {
            return $img['media_url'];
        }
        # 下载临时文件到本地
        $content = file_get_contents($local_url);
        $filename = 'wechat/image/' . join('/', str_split($md5, 16)) . '.' . strtolower(pathinfo($local_url, 4));
        # 上传图片到微信服务器
        if (($result = FileService::local($filename, $content)) && isset($result['file'])) {
            $wechat = load_wechat('media');
            $info = $wechat->uploadImg(['media' => base64_encode($content)]);
            if (!empty($info)) {
                $data = ['local_url' => $local_url, 'media_url' => $info['url'], 'md5' => $md5];
                Db::name('WechatNewsImage')->insert($data);
                return $info['url'];
            }
            Log::error("图片上传失败，请稍后再试！{$wechat->errMsg}[{$wechat->errCode}]");
        }
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
    public static function uploadForeverMedia($local_url = '', $type = 'image', $is_video = false, $video_info = [])
    {
        # 检测文件上否已经上传过了
        $wechat = load_wechat('media');
        $map = ['md5' => md5($local_url), 'appid' => $wechat->getAppid()];
        if (($img = Db::name('WechatNewsMedia')->where($map)->find()) && !empty($img['media_id'])) {
            return $img['media_id'];
        }
        # 下载临时文件到本地
        $content = file_get_contents($local_url);
        $filename = 'wechat/image/' . join('/', str_split(md5($local_url), 16)) . '.' . strtolower(pathinfo($local_url, 4));
        if (($upload = FileService::local($filename, $content)) && isset($upload['file']) && file_exists($upload['file'])) {
            # 上传图片到微信服务器
            if (false !== ($result = $wechat->uploadForeverMedia(['media' => base64_encode($content)], $type, $is_video, $video_info))) {
                $data = ['md5' => $map['md5'], 'type' => $type, 'appid' => $wechat->getAppid(), 'media_id' => $result['media_id'], 'local_url' => $local_url];
                isset($result['url']) && $data['media_url'] = $result['url'];
                Db::name('WechatNewsMedia')->insert($data);
                return $data['media_id'];
            }
        }
        Log::error("素材上传失败, 请稍后再试! {$wechat->errMsg}[{$wechat->errCode}]");
        return null;
    }

    /**
     * 从微信服务器获取所有标签
     * @return bool
     */
    public static function syncFansTags()
    {
        $wechat = load_wechat("User");
        if (($result = $wechat->getTags()) !== false) {
            Db::name('WechatFansTags')->where('appid', $wechat->getAppid())->delete();
            foreach (array_chunk($result['tags'], 100) as $list) {
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
    public static function syncFansTagsByOpenid($openid)
    {
        $wechat = load_wechat('User');
        $tagsid = $wechat->getUserTags($openid);
        if ($tagsid === false || !is_array($tagsid)) {
            return false;
        }
        $data = ['openid' => $openid, 'tagid_list' => join(',', $tagsid)];
        return DataService::save('wechat_fans', $data, 'openid', ['appid' => $wechat->getAppid()]);
    }

    /**
     * 保存/更新粉丝信息
     * @param array $user
     * @param string $appid
     * @return bool
     */
    public static function setFansInfo($user, $appid = '')
    {
        if (!empty($user['subscribe_time'])) {
            $user['subscribe_at'] = date('Y-m-d H:i:s', $user['subscribe_time']);
        }
        if (!empty($user['tagid_list']) && is_array($user['tagid_list'])) {
            $user['tagid_list'] = join(',', $user['tagid_list']);
        }
        foreach (['country', 'province', 'city', 'nickname', 'remark'] as $k) {
            isset($user[$k]) && $user[$k] = ToolsService::emojiEncode($user[$k]);
        }
        $user['appid'] = $appid;
        return DataService::save('WechatFans', $user, 'openid');
    }

    /**
     * 读取粉丝信息
     * @param string $openid 微信用户openid
     * @param string $appid 公众号appid
     * @return array|false
     */
    public static function getFansInfo($openid, $appid = null)
    {
        $map = ['openid' => $openid];
        is_string($appid) && $map['appid'] = $appid;
        $user = Db::name('WechatFans')->where($map)->find();
        foreach (['country', 'province', 'city', 'nickname', 'remark'] as $k) {
            isset($user[$k]) && $user[$k] = ToolsService::emojiDecode($user[$k]);
        }
        return $user;
    }

    /**
     * 同步获取粉丝列表
     * @param string $next_openid
     * @return bool
     */
    public static function syncAllFans($next_openid = '')
    {
        $wechat = load_wechat('User');
        $appid = $wechat->getAppid();
        if (false === ($result = $wechat->getUserList($next_openid)) || empty($result['data']['openid'])) {
            Log::error("获取粉丝列表失败, {$wechat->errMsg} [{$wechat->errCode}]");
            return false;
        }
        foreach (array_chunk($result['data']['openid'], 100) as $openids) {
            if (false === ($info = $wechat->getUserBatchInfo($openids)) || !is_array($info)) {
                Log::error("获取用户信息失败, {$wechat->errMsg} [{$wechat->errCode}]");
                return false;
            }
            foreach ($info as $user) {
                if (false === self::setFansInfo($user, $appid)) {
                    Log::error('更新粉丝信息更新失败!');
                    return false;
                }
                if ($result['next_openid'] === $user['openid']) {
                    unset($result['next_openid']);
                }
            }
        }
        return empty($result['next_openid']) ? true : self::syncAllFans($result['next_openid']);
    }

    /**
     * 同步获取黑名单信息
     * @param string $next_openid
     * @return bool
     */
    public static function syncBlackFans($next_openid = '')
    {
        $wechat = load_wechat('User');
        $result = $wechat->getBacklist($next_openid);
        if ($result === false || empty($result['data']['openid'])) {
            if (empty($result['total'])) {
                return true;
            }
            Log::error("获取粉丝黑名单列表失败，{$wechat->errMsg} [{$wechat->errCode}]");
            return false;
        }
        foreach ($result['data']['openid'] as $openid) {
            if (false === ($user = $wechat->getUserInfo($openid))) {
                Log::error("获取用户[{$openid}]信息失败，$wechat->errMsg");
                return false;
            }
            $user['is_back'] = '1';
            if (false === self::setFansInfo($user)) {
                Log::error('更新粉丝信息更新失败！');
                return false;
            }
            if ($result['next_openid'] === $openid) {
                unset($result['next_openid']);
            }
        }
        return empty($result['next_openid']) ? true : self::syncBlackFans($result['next_openid']);
    }

}
