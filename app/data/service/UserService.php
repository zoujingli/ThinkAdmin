<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户数据接口服务
 * Class UserService
 * @package app\store\service
 */
class UserService extends Service
{
    const APITYPE_WAP = 'wap';
    const APITYPE_WEB = 'web';
    const APITYPE_WXAPP = 'wxapp';
    const APITYPE_WECHAT = 'wechat';
    const APITYPE_IOSAPP = 'ios';
    const APITYPE_ANDROID = 'android';

    const TYPES = [
        // 接口通道配置（不需要的直接注释）
        UserService::APITYPE_WAP     => [
            'name' => '手机浏览器',
            'auth' => 'phone',
        ],
        UserService::APITYPE_WEB     => [
            'name' => '电脑浏览器',
            'auth' => 'phone',
        ],
        UserService::APITYPE_IOSAPP  => [
            'name' => '苹果应用',
            'auth' => 'phone',
        ],
        UserService::APITYPE_ANDROID => [
            'name' => '安卓应用',
            'auth' => 'phone',
        ],
        UserService::APITYPE_WXAPP   => [
            'name' => '微信小程序',
            'auth' => 'openid1',
        ],
        UserService::APITYPE_WECHAT  => [
            'name' => '微信服务号',
            'auth' => 'openid2',
        ],
    ];

    /**
     * 认证有效时间
     * @var integer
     */
    private $expire = 7200;

    /**
     * 获取用户数据
     * @param string $type 接口类型
     * @param integer $uuid 用户UID
     * @return array
     */
    public function get(string $type, int $uuid): array
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uuid, 'deleted' => 0])->findOrEmpty();
        $data = $this->app->db->name('DataUserToken')->where(['uid' => $uuid, 'type' => $type])->where(function ($query) {
            $query->where(['tokenv' => ''])->whereOr(['tokenv' => $this->_buildTokenVerify()]);
        })->findOrEmpty();
        unset($user['deleted'], $user['password']);
        $user['token'] = ['token' => $data['token'], 'expire' => $data['time']];
        return $user;
    }

    /**
     * 更新用户用户参数
     * @param array $map 查询条件
     * @param array $data 更新数据
     * @param string $type 接口类型
     * @param boolean $force 强刷令牌
     * @return array
     * @throws \think\db\exception\DbException
     */
    public function set(array $map, array $data, string $type, bool $force = false): array
    {
        unset($data['id'], $data['deleted'], $data['create_at']);
        if ($uuid = $this->app->db->name('DataUser')->where($map)->where(['deleted' => 0])->value('id')) {
            if (!empty($data)) {
                $map = ['id' => $uuid, 'deleted' => 0];
                $this->app->db->name('DataUser')->strict(false)->where($map)->update($data);
            }
        } else {
            $uuid = $this->app->db->name('DataUser')->strict(false)->insertGetId($data);
        }
        if ($force) $this->buildUserToken(intval($uuid), $type);
        return $this->get($type, $uuid);
    }

    /**
     * 获取用户数据统计
     * @param int $uid 用户UID
     * @return array
     */
    public function total(int $uid): array
    {
        $query = $this->app->db->name('DataUser');
        return ['my_invite' => $query->where(['from' => $uid])->count()];
    }

    /**
     * 生成新的用户令牌
     * @param int $uid 授权用户
     * @param string $type 接口类型
     * @return array [创建状态, 状态描述, 令牌数据]
     * @throws \think\db\exception\DbException
     */
    public function buildUserToken(int $uid, string $type): array
    {
        // 清理历史认证及已过期的认证
        $map1 = [['time', '<', $time = time()]];
        $map2 = [['uid', '=', $uid], ['type', '=', $type]];
        $this->app->db->name('DataUserToken')->whereOr([$map1, $map2])->delete();
        // 创建新的用户认证数据
        do $map = ['type' => $type, 'token' => md5(uniqid('', true) . rand(100, 999))];
        while ($this->app->db->name('DataUserToken')->where($map)->count() > 0);
        // 写入接口用户认证数据
        $data = array_merge($map, ['uid' => $uid, 'time' => $time + $this->expire, 'tokenv' => $this->_buildTokenVerify()]);
        if ($this->app->db->name('DataUserToken')->insert($data) !== false) {
            return [1, '刷新认证成功', $data];
        } else {
            return [0, '刷新认证失败', []];
        }
    }

    /**
     * 延期 TOKEN 有效时间
     * @param string $type 接口类型
     * @param string $token 授权令牌
     * @throws \think\db\exception\DbException
     */
    public function expireUserToken(string $type, string $token)
    {
        $map = ['type' => $type, 'token' => $token];
        $this->app->db->name('DataUserToken')->where($map)->update([
            'time' => time() + $this->expire,
        ]);
    }

    /**
     * 检查接口授权 TOKEN 是否有效
     * @param string $type 接口类型
     * @param string $token 认证令牌
     * @param array $data 认证数据
     * @return array [ 检查状态，状态描述，用户UID, 有效时间 ]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function checkUserToken(string $type, string $token, array $data = []): array
    {
        if (empty($data)) {
            $map = ['type' => $type, 'token' => $token];
            $data = $this->app->db->name('DataUserToken')->where($map)->find();
        }
        if (empty($data) || empty($data['uid'])) {
            return [0, '请重新登录，登录认证无效', 0, 0];
        } elseif ($data['time'] < time()) {
            return [0, '请重新登录，登录认证已失效', 0, 0];
        } elseif ($data['tokenv'] !== $this->_buildTokenVerify() && $token !== 'token') {
            return [0, '请重新登录，客户端已更换', 0, 0];
        } else {
            $this->expireUserToken($type, $token);
            return [1, '登录验证成功', $data['uid'], $data['time']];
        }
    }

    /**
     * 列表绑定用户数据
     * @param array $list 原数据列表
     * @param string $keys 用户UID字段
     * @param string $bind 绑定字段名称
     * @param string $column 返回用户字段
     * @return array
     */
    public function buildByUid(array &$list, string $keys = 'uid', string $bind = 'user', string $column = '*'): array
    {
        if (count($list) < 1) return $list;
        $uids = array_unique(array_column($list, $keys));
        $users = $this->app->db->name('DataUser')->whereIn('id', $uids)->column($column, 'id');
        foreach ($list as &$vo) $vo[$bind] = $users[$vo[$keys]] ?? [];
        return $list;
    }

    /**
     * 获取令牌的认证值
     * @return string
     */
    private function _buildTokenVerify(): string
    {
        return md5($this->app->request->server('HTTP_USER_AGENT', '-'));
    }

}