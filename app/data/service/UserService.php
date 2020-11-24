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
    /**
     * 认证有效时间
     * @var integer
     */
    private $expire = 3600;

    /**
     * 获取用户数据
     * @param string $type 接口类型
     * @param integer $uuid 用户UID
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get(string $type, int $uuid)
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uuid, 'deleted' => 0])->findOrEmpty();
        $data = $this->app->db->name('DataUserToken')->where(['uid' => $uuid, 'type' => $type])->findOrEmpty();
        [$state, $message] = $this->checkUserToken($type, $data['token'], $data);
        if (empty($state)) throw new \think\Exception($message);
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
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save(array $map, array $data, string $type, bool $force = false): array
    {
        unset($data['id'], $data['deleted'], $data['create_at']);
        if ($uid = $this->app->db->name('DataUser')->where($map)->where(['deleted' => 0])->value('id')) {
            if (!empty($data)) {
                $map = ['id' => $uid, 'deleted' => 0];
                $this->app->db->name('DataUser')->strict(false)->where($map)->update($data);
            }
        } else {
            $uid = $this->app->db->name('DataUser')->strict(false)->insertGetId($data);
        }
        if ($force) $this->buildUserToken($uid, $type);
        return $this->get($uid, $type);
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
        // 创建用户新的用户认证数据
        do $map = ['type' => $type, 'token' => md5(uniqid('', true) . rand(100, 999))];
        while ($this->app->db->name('DataUser')->where($map)->count() > 0);
        $token = array_merge($map, ['time' => $time + $this->expire, 'tokenv' => $this->_buildTokenVerify()]);
        if ($this->app->db->name('DataUserToken')->insert($token) !== false) {
            return [1, '刷新用户认证成功', $token];
        } else {
            return [0, '刷新用户认证失败', []];
        }
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
            return [0, '接口认证令牌无效', 0, 0];
        } elseif ($data['time'] < time()) {
            return [0, '接口认证令牌已失效', 0, 0];
        } elseif ($data['tokenv'] !== $this->_buildTokenVerify()) {
            return [0, '接口请求客户端已更换', 0, 0];
        } else {
            return [1, '接口认证令牌验证成功', $data['uid'], $data['time']];
        }
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