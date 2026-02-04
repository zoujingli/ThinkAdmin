<?php

declare(strict_types=1);
/**
 * +----------------------------------------------------------------------
 * | ThinkAdmin Plugin for ThinkAdmin
 * +----------------------------------------------------------------------
 * | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * +----------------------------------------------------------------------
 * | 官方网站: https://thinkadmin.top
 * +----------------------------------------------------------------------
 * | 开源协议 ( https://mit-license.org )
 * | 免责声明 ( https://thinkadmin.top/disclaimer )
 * | 会员特权 ( https://thinkadmin.top/vip-introduce )
 * +----------------------------------------------------------------------
 * | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * +----------------------------------------------------------------------
 */

namespace app\wechat\model;

use think\admin\Model;

/**
 * 微信粉丝用户模型.
 *
 * @property int $id
 * @property int $is_black 是否为黑名单状态
 * @property int $sex 用户性别(1男性,2女性,0未知)
 * @property int $subscribe 关注状态(0未关注,1已关注)
 * @property int $subscribe_time 关注时间
 * @property string $appid 公众号APPID
 * @property string $city 用户所在城市
 * @property string $country 用户所在国家
 * @property string $create_at 创建时间
 * @property string $headimgurl 用户头像
 * @property string $language 用户的语言(zh_CN)
 * @property string $nickname 用户昵称
 * @property string $openid 粉丝openid
 * @property string $province 用户所在省份
 * @property string $qr_scene 二维码场景值
 * @property string $qr_scene_str 二维码场景内容
 * @property string $remark 备注
 * @property string $subscribe_at 关注时间
 * @property string $subscribe_scene 扫码关注场景
 * @property string $tagid_list 粉丝标签id
 * @property string $unionid 粉丝unionid
 * @class WechatFans
 */
class WechatFans extends Model {}
