<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\wechat\model;

use think\admin\Model;

/**
 * 微信回复关键词模型
 *
 * @property int $create_by 创建人
 * @property int $id
 * @property int $news_id 图文ID
 * @property int $sort 排序字段
 * @property int $status 状态(0禁用,1启用)
 * @property string $appid 公众号APPID
 * @property string $content 文本内容
 * @property string $create_at 创建时间
 * @property string $image_url 图片链接
 * @property string $keys 关键字
 * @property string $music_desc 音乐描述
 * @property string $music_image 缩略图片
 * @property string $music_title 音乐标题
 * @property string $music_url 音乐链接
 * @property string $type 类型(text,image,news)
 * @property string $video_desc 视频描述
 * @property string $video_title 视频标题
 * @property string $video_url 视频URL
 * @property string $voice_url 语音链接
 * @class WechatKeys
 * @package app\wechat\model
 */
class WechatKeys extends Model
{
    /**
     * 格式化创建时间
     * @param mixed $value
     * @return string
     */
    public function getCreateAtAttr($value): string
    {
        return format_datetime($value);
    }
}