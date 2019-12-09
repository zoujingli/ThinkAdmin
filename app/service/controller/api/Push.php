<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\service\controller\api;

use app\service\handle\PublishHandle;
use app\service\handle\ReceiveHandle;
use app\service\service\WechatService;
use think\admin\Controller;
use WeOpen\Service;

/**
 * 服务平台推送服务
 * Class Push
 * @package app\service\controller\api
 */
class Push extends Controller
{
    /**
     * 微信API推送事件处理
     * @param string $appid
     * @return string
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function notify($appid)
    {
        if (in_array($appid, ['wx570bc396a51b8ff8', 'wxd101a85aa106f53e'])) {
            # 全网发布接口测试
            return PublishHandle::instance()->handler($appid);
        } else {
            # 接口类正常服务
            return ReceiveHandle::instance()->handler($appid);
        }
    }

    /**
     * 一、处理服务推送Ticket
     * 二、处理取消公众号授权
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function ticket()
    {
        try {
            $server = WechatService::WeOpenService();
            if (!($data = $server->getComonentTicket())) {
                return "Ticket event handling failed.";
            }
        } catch (\Exception $e) {
            return "Ticket event handling failed, {$e->getMessage()}";
        }
        if (!empty($data['AuthorizerAppid']) && isset($data['InfoType'])) {
            # 授权成功通知
            if ($data['InfoType'] === 'authorized') {
                $this->app->db->name('WechatServiceConfig')->where(['authorizer_appid' => $data['AuthorizerAppid']])->update(['is_deleted' => '0']);
            }
            # 接收取消授权服务事件
            if ($data['InfoType'] === 'unauthorized') {
                $this->app->db->name('WechatServiceConfig')->where(['authorizer_appid' => $data['AuthorizerAppid']])->update(['is_deleted' => '1']);
            }
            # 授权更新通知
            if ($data['InfoType'] === 'updateauthorized') {
                $_GET['auth_code'] = $data['PreAuthCode'];
                $this->applyAuth($server);
            }
        }
        return 'success';
    }

    /**
     * 微信代网页授权
     * @throws \think\Exception
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function oauth()
    {
        list($mode, $appid, $enurl, $sessid) = [
            $this->request->get('mode'), $this->request->get('state'),
            $this->request->get('enurl'), $this->request->get('sessid'),
        ];
        $result = WechatService::WeOpenService()->getOauthAccessToken($appid);
        if (empty($result['openid'])) throw new \think\Exception('网页授权失败, 无法进一步操作！');
        $this->app->cache->set("{$appid}_{$sessid}_openid", $result['openid'], 3600);
        if (!empty($mode)) {
            $fans = WechatService::WeChatOauth($appid)->getUserInfo($result['access_token'], $result['openid']);
            if (empty($fans)) throw new \think\Exception('网页授权信息获取失败, 无法进一步操作！');
            $this->app->cache->set("{$appid}_{$sessid}_fans", $fans, 3600);
        }
        $this->redirect(debase64url($enurl));
    }

    /**
     * 跳转到微信服务授权页面
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function auth()
    {
        $this->source = input('source');
        if (empty($this->source)) {
            return '请传入回跳 source 参数 ( 请使用 enbase64url 加密 )';
        }
        $this->sourceUrl = debase64url($this->source);
        if (empty($this->sourceUrl)) {
            return '请传入回跳 source 参数 ( 请使用 enbase64url 加密 )';
        }
        # 预授权码不为空，则表示可以进行授权处理
        $service = WechatService::WeOpenService();
        if (($auth_code = $this->request->get('auth_code'))) {
            return $this->applyAuth($service, $this->sourceUrl);
        }
        # 生成微信授权链接，使用刷新跳转到授权网页
        $redirect = url("@service/api.push/auth", [], true, true) . "?source={$this->source}";
        if (($redirect = $service->getAuthRedirect($redirect))) {
            ob_clean();
            header("Refresh:0;url={$redirect}");
            return "<script>window.location.href='{$redirect}';</script><a href='{$redirect}'>跳转中...</a>";
        }
        # 生成微信授权链接失败
        return "<h2>Failed to create authorization. Please return to try again.</h2>";
    }

    /**
     * 公众号授权绑定数据处理
     * @param Service $service 平台服务对象
     * @param string $redirect 授权成功回跳地址
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function applyAuth(Service $service, $redirect = null)
    {
        // 通过授权code换取公众号信息
        $result = $service->getQueryAuthorizerInfo();
        if (empty($result['authorizer_appid'])) {
            return "接收微信第三方平台授权失败! ";
        }
        // 重新通过接口查询公众号参数
        if (!($update = array_merge($result, $service->getAuthorizerInfo($result['authorizer_appid'])))) {
            return '获取授权数据失败, 请稍候再试!';
        }
        // 生成公众号授权参数
        $update = array_merge($this->buildAuthData($update), [
            'status' => '1', 'is_deleted' => '0', 'expires_in' => time() + 7000, 'create_at' => date('y-m-d H:i:s'),
        ]);
        // 微信接口APPKEY处理与更新
        $config = $this->app->db->name('WechatServiceConfig')->where(['authorizer_appid' => $result['authorizer_appid']])->find();
        $update['appkey'] = empty($config['appkey']) ? md5(uniqid('', true)) : $config['appkey'];
        data_save('WechatServiceConfig', $update, 'authorizer_appid');
        if (!empty($redirect)) { // 带上appid与appkey跳转到应用
            $split = stripos($redirect, '?') > 0 ? '&' : '?';
            $realurl = preg_replace(['/appid=\w+/i', '/appkey=\w+/i', '/(\?\&)$/i'], ['', '', ''], $redirect);
            return redirect("{$realurl}{$split}appid={$update['authorizer_appid']}&appkey={$update['appkey']}");
        }
    }

    /**
     * 生成公众号授权信息
     * @param array $info
     * @return array
     */
    private function buildAuthData(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);
        if (isset($info['func_info']) && is_array($info['func_info'])) {
            $info['func_info'] = join(',', array_map(function ($tmp) {
                return isset($tmp['funcscope_category']['id']) ? $tmp['funcscope_category']['id'] : 0;
            }, $info['func_info']));
        }
        $info['business_info'] = serialize($info['business_info']);
        $info['verify_type_info'] = join(',', $info['verify_type_info']);
        $info['service_type_info'] = join(',', $info['service_type_info']);
        // 微信类型:  0 代表订阅号, 2 代表服务号, 3 代表小程序
        $info['service_type'] = intval($info['service_type_info']) === 2 ? 2 : 0;
        if (!empty($info['miniprograminfo'])) {
            $info['service_type'] = 3;
            $info['miniprograminfo'] = serialize($info['miniprograminfo']);
        }
        // 微信认证: -1 代表未认证, 0 代表微信认证
        $info['verify_type'] = intval($info['verify_type_info']) !== 0 ? -1 : 0;
        return $info;
    }
}