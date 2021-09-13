<?php

namespace app\data\service;

use app\data\model\DataUserToken;
use think\admin\Service;

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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function check(string $type, string $token, array $data = []): array
    {
        if (empty($data)) {
            $map = ['type' => $type, 'token' => $token];
            $data = DataUserToken::mk()->where($map)->find();
        }
        if (empty($data) || empty($data['uuid'])) {
            return [0, '请重新登录，登录认证无效', 0, 0];
        } elseif ($token !== 'token' && $data['time'] < time()) {
            return [0, '请重新登录，登录认证失效', 0, 0];
        } elseif ($token !== 'token' && $data['tokenv'] !== $this->_buildTokenVerify()) {
            return [0, '请重新登录，客户端已更换', 0, 0];
        } else {
            $this->expire($type, $token);
            return [1, '登录验证成功', $data['uuid'], $data['time']];
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
     */
    public function expire(string $type, string $token)
    {
        $map = ['type' => $type, 'token' => $token];
        DataUserToken::mk()->where($map)->update([
            'time' => time() + $this->expire,
        ]);
    }

    /**
     * 生成新的用户令牌
     * @param int $uuid 授权用户
     * @param string $type 接口类型
     * @return array [创建状态, 状态描述, 令牌数据]
     */
    public function token(int $uuid, string $type): array
    {
        // 清理无效认证数据
        $time = time();
        $map1 = [['token', '<>', 'token'], ['time', '<', $time]];
        $map2 = [['token', '<>', 'token'], ['type', '=', $type], ['uuid', '=', $uuid]];
        DataUserToken::mk()->whereOr([$map1, $map2])->delete();
        // 创建新的认证数据
        do $map = ['type' => $type, 'token' => md5(uniqid() . rand(100, 999))];
        while (DataUserToken::mk()->where($map)->count() > 0);
        // 写入用户认证数据
        $data = array_merge($map, ['uuid' => $uuid, 'time' => $time + $this->expire, 'tokenv' => $this->_buildTokenVerify()]);
        if (DataUserToken::mk()->insert($data) !== false) {
            return [1, '刷新认证成功', $data];
        } else {
            return [0, '刷新认证失败', []];
        }
    }
}