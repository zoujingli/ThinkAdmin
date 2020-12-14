<?php

namespace app\data\controller\api;

use app\data\service\UserService;
use think\admin\Controller;
use think\exception\HttpResponseException;
use think\Response;
use WeMini\Crypt;
use WeMini\Live;
use WeMini\Qrcode;

/**
 * 微信小程序入口
 * Class Wxapp
 * @package app\data\controller\api
 */
class Wxapp extends Controller
{
    /**
     * 接口认证类型
     * @var string
     */
    private $type = UserService::APITYPE_WXAPP;

    /**
     * 唯一绑定字段
     * @var string
     */
    private $field;

    /**
     * 小程序配置参数
     * @var array
     */
    private $config;

    /**
     * 接口服务初始化
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        $this->config = [
            'appid'      => sysconf('data.wxapp_appid'),
            'appsecret'  => sysconf('data.wxapp_appkey'),
            'cache_path' => $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . 'wechat',
        ];
        if (empty(UserService::TYPES[$this->type]['auth'])) {
            $this->error("接口类型[{$this->type}]没有定义规则");
        } else {
            $this->field = UserService::TYPES[$this->type]['auth'];
        }
    }

    /**
     * 授权Code换取会话信息
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function session()
    {
        $input = $this->_vali(['code.require' => '登录凭证code不能为空！']);
        [$openid, $unionid, $sessionKey] = $this->_getSessionKey($input['code']);
        $map = empty($unionid) ? [$this->field => $openid] : ['unionid' => $unionid];
        $data = array_merge($map, [$this->field => $openid, 'session_key' => $sessionKey]);
        $this->success('授权换取成功！', UserService::instance()->set($map, $data, $this->type, true));
    }

    /**
     * 小程序数据解密
     * @throws HttpResponseException
     */
    public function decode()
    {
        try {
            $input = $this->_vali([
                'code.default'        => '', // code 与 session_key 二选一
                'session_key.default' => '', // code 与 session_key 二选一
                'iv.require'          => '解密向量不能为空！',
                'encrypted.require'   => '加密内容不能为空！',
            ]);
            if (empty($input['session_key'])) {
                if (empty($input['code'])) $this->error('登录凭证code不能为空！');
                [, , $input['session_key']] = $this->_getSessionKey($input['code']);
            }
            $result = Crypt::instance($this->config)->decode($input['iv'], $input['session_key'], $input['encrypted']);
            if (is_array($result) && isset($result['openId']) && isset($result['avatarUrl']) && isset($result['nickName'])) {
                $sex = ['未知', '男', '女'][$result['gender']] ?? '未知';
                $map = empty($result['unionId']) ? [$this->field => $result['openId']] : ['unionid' => $result['unionId']];
                $data = [$this->field => $result['openId'], 'headimg' => $result['avatarUrl'], 'nickname' => $result['nickName'], 'base_sex' => $sex];
                $this->success('数据解密成功！', UserService::instance()->set($map, array_merge($map, $data), $this->type, true));
            } elseif (is_array($result) && isset($result['phoneNumber'])) {
                $this->success('数据解密成功！', $result);
            } else {
                $this->error('数据处理失败，请稍候再试！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("数据处理失败，{$exception->getMessage()}");
        }
    }

    /**
     * 授权CODE换取会话信息
     * @param string $code 换取授权CODE
     * @return array [openid, sessionkey]
     */
    private function _getSessionKey(string $code): array
    {
        try {
            $cache = $this->app->cache->get($code, []);
            if (isset($cache['openid']) && isset($cache['session_key'])) {
                return [$cache['openid'], $cache['unionid'] ?? '', $cache['session_key']];
            }
            $result = Crypt::instance($this->config)->session($code);
            if (isset($result['openid']) && isset($result['session_key'])) {
                $this->app->cache->set($code, $result, 3600);
                return [$result['openid'], $cache['unionid'] ?? '', $result['session_key']];
            } elseif (isset($result['errmsg'])) {
                $this->error($result['errmsg']);
            } else {
                $this->error("授权换取失败，请稍候再试！");
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("授权换取失败，{$exception->getMessage()}");
        }
    }

    /**
     * 获取小程序码
     */
    public function qrcode(): Response
    {
        try {
            $data = $this->_vali([
                'size.default' => 430,
                'type.default' => 'base64',
                'path.require' => '跳转路径不能为空!',
            ]);
            $result = Qrcode::instance($this->config)->createMiniPath($data['path'], $data['size']);
            if ($data['type'] === 'base64') {
                $this->success('生成小程序码成功！', [
                    'base64' => 'data:image/png;base64,' . base64_encode($result),
                ]);
            } else {
                return response($result)->contentType('image/png');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 获取直播列表
     */
    public function getLiveList()
    {
        try {
            $data = $this->_vali(['start.default' => 0, 'limit.default' => 10]);
            $list = Live::instance($this->config)->getLiveList($data['start'], $data['limit']);
            $this->success('获取直播列表成功！', $list);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 获取回放源视频
     */
    public function getLiveInfo()
    {
        try {
            $data = $this->_vali([
                'start.default'   => 0,
                'limit.default'   => 10,
                'action.default'  => 'get_replay',
                'room_id.require' => '直播间不能为空',
            ]);
            $result = Live::instance($this->config)->getLiveInfo($data);
            $this->success('获取回放视频成功！', $result);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}