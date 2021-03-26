<?php

namespace app\data\service;

use think\admin\Service;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 用户接口授权服务
 * Class UserTokenService
 * @package app\data\service
 */
class UserTokenService extends Service
{

    /**
     * 认证有效时间
     * @var integer
     */
    private $expire = 7200;

    /**
     * 检查 TOKEN 是否有效
     * @param string $type 接口类型
     * @param string $token 认证令牌
     * @param array $data 认证数据
     * @return array [ 检查状态，状态描述，用户UID, 有效时间 ]
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function check(string $type, string $token, array $data = []): array
    {
        if (empty($data)) {
            $map = ['type' => $type, 'token' => $token];
            $data = $this->app->db->name('DataUserToken')->where($map)->find();
        }
        if (empty($data) || empty($data['uid'])) {
            return [0, '请重新登录，登录认证无效', 0, 0];
        } elseif ($token !== 'token' && $data['time'] < time()) {
            return [0, '请重新登录，登录认证失效', 0, 0];
        } elseif ($token !== 'token' && $data['tokenv'] !== $this->_buildTokenVerify()) {
            return [0, '请重新登录，客户端已更换', 0, 0];
        } else {
            $this->expire($type, $token);
            return [1, '登录验证成功', $data['uid'], $data['time']];
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

    /**
     * 延期 TOKEN 有效时间
     * @param string $type 接口类型
     * @param string $token 授权令牌
     * @throws DbException
     */
    public function expire(string $type, string $token)
    {
        $map = ['type' => $type, 'token' => $token];
        $this->app->db->name('DataUserToken')->where($map)->update([
            'time' => time() + $this->expire,
        ]);
    }

    /**
     * 生成新的用户令牌
     * @param int $uuid 授权用户
     * @param string $type 接口类型
     * @return array [创建状态, 状态描述, 令牌数据]
     * @throws DbException
     */
    public function token(int $uuid, string $type): array
    {
        // 清理无效认证数据
        $map1 = [['uid', '=', $uuid], ['type', '=', $type]];
        $map2 = [['time', '<', $time = time()], ['token', '<>', 'token']];
        $this->app->db->name('DataUserToken')->whereOr([$map1, $map2])->delete();
        // 创建新的认证数据
        do $map = ['type' => $type, 'token' => md5(uniqid() . rand(100, 999))];
        while ($this->app->db->name('DataUserToken')->where($map)->count() > 0);
        // 写入用户认证数据
        $data = array_merge($map, ['uid' => $uuid, 'time' => $time + $this->expire, 'tokenv' => $this->_buildTokenVerify()]);
        if ($this->app->db->name('DataUserToken')->insert($data) !== false) {
            return [1, '刷新认证成功', $data];
        } else {
            return [0, '刷新认证失败', []];
        }
    }
}