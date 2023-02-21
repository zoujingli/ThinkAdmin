<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\service;

use app\data\model\DataUser;
use app\data\model\DataUserToken;
use think\admin\Exception;
use think\admin\Service;

/**
 * 用户数据管理服务
 * Class UserAdminService
 * @package app\data\service
 */
class UserAdminService extends Service
{
    const API_TYPE_WAP = 'wap';
    const API_TYPE_WEB = 'web';
    const API_TYPE_WXAPP = 'wxapp';
    const API_TYPE_WECHAT = 'wechat';
    const API_TYPE_IOSAPP = 'iosapp';
    const API_TYPE_ANDROID = 'android';

    const TYPES = [
        // 接口支付配置（不需要的直接注释）
        self::API_TYPE_WAP     => [
            'name' => '手机浏览器',
            'auth' => 'phone',
        ],
        self::API_TYPE_WEB     => [
            'name' => '电脑浏览器',
            'auth' => 'phone',
        ],
        self::API_TYPE_WXAPP   => [
            'name' => '微信小程序',
            'auth' => 'openid1',
        ],
        self::API_TYPE_WECHAT  => [
            'name' => '微信服务号',
            'auth' => 'openid2',
        ],
        self::API_TYPE_IOSAPP  => [
            'name' => '苹果APP应用',
            'auth' => 'phone',
        ],
        self::API_TYPE_ANDROID => [
            'name' => '安卓APP应用',
            'auth' => 'phone',
        ],
    ];

    /**
     * 更新用户用户参数
     * @param mixed $map 查询条件
     * @param array $data 更新数据
     * @param string $type 接口类型
     * @param boolean $force 强刷令牌
     * @return array
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DbException
     */
    public static function set($map, array $data, string $type, bool $force = false): array
    {
        unset($data['id'], $data['deleted'], $data['create_at']);
        $user = DataUser::mk()->where($map)->where(['deleted' => 0])->findOrEmpty();
        if (!$user->save($data)) throw new Exception("更新用户资料失败！");
        // 刷新用户认证令牌
        if ($force) UserTokenService::token($user['id'], $type);
        // 返回当前用户资料
        return static::get($user['id'], $type);
    }

    /**
     * 获取用户数据
     * @param integer $uuid 用户UID
     * @param string $type 接口类型
     * @return array
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function get(int $uuid, string $type): array
    {
        $map = ['id' => $uuid, 'deleted' => 0];
        $user = DataUser::mk()->where($map)->findOrEmpty();
        if ($user->isEmpty()) throw new Exception('用户还没有注册！');
        // 用户认证令牌处理
        $map = ['uuid' => $uuid, 'type' => $type];
        if (!($access = DataUserToken::mk()->where($map)->find())) {
            [$state, $message, $access] = UserTokenService::token($uuid, $type);
            if (empty($state) || empty($access)) throw new Exception($message);
        }
        $user['token'] = ['token' => $access['token'], 'expire' => $access['time']];
        return $user->hidden(['deleted', 'password'])->toArray();
    }

    /**
     * 获取用户数据统计
     * @param int $uuid 用户UID
     * @return array
     */
    public static function total(int $uuid): array
    {
        return ['my_invite' => DataUser::mk()->where(['pid1' => $uuid])->count()];
    }

    /**
     * 获取用户查询条件
     * @param string $field 认证字段
     * @param string $openid 用户OPENID值
     * @param string $unionid 用户UNIONID值
     * @return array
     */
    public static function getUserUniMap(string $field, string $openid, string $unionid = ''): array
    {
        if (!empty($unionid)) {
            [$map1, $map2] = [[['unionid', '=', $unionid]], [[$field, '=', $openid]]];
            if ($uuid = DataUser::mk()->whereOr([$map1, $map2])->value('id')) {
                return ['id' => $uuid];
            }
        }
        return [$field => $openid];
    }

    /**
     * 列表绑定用户数据
     * @param array $list 原数据列表
     * @param string $keys 用户UID字段
     * @param string $bind 绑定字段名称
     * @param string $cols 返回用户字段
     * @return array
     */
    public static function buildByUid(array &$list, string $keys = 'uuid', string $bind = 'user', string $cols = '*'): array
    {
        if (count($list) < 1) return $list;
        $uids = array_unique(array_column($list, $keys));
        $users = DataUser::mk()->whereIn('id', $uids)->column($cols, 'id');
        foreach ($list as &$vo) $vo[$bind] = $users[$vo[$keys]] ?? [];
        return $list;
    }
}