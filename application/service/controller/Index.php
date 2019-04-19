<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\service\controller;

use app\service\logic\Build;
use app\service\logic\Wechat;
use library\Controller;
use think\Db;

/**
 * Class Index
 * @package app\service\controller
 */
class Index extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    public $table = 'WechatServiceConfig';

    /**
     * 授权公众号管理
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->applyCsrfToken();
        $this->title = '微信授权管理';
        $this->_query($this->table)
            ->like('authorizer_appid,nick_name,principal_name')
            ->equal('service_type,status')->dateBetween('create_at')
            ->where(['is_deleted' => '0'])->order('id desc')->page();

    }

    /**
     * 清理调用次数
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function clearQuota()
    {
        $appid = input('appid');
        $result = Wechat::WeChatLimit($appid)->clearQuota();
        if (empty($result['errcode']) && $result['errmsg'] === 'ok') {
            $this->success('接口调用次数清零成功！');
        } elseif (isset($result['errmsg'])) {
            $this->error('接口调用次数清零失败，请稍候再试！' . $result['errmsg']);
        } else {
            $this->error('接口调用次数清零失败，请稍候再试！');
        }
    }

    /**
     * 同步指定授权公众号
     */
    public function sync()
    {
        try {
            $appid = $this->request->get('appid');
            $where = ['authorizer_appid' => $appid, 'is_deleted' => '0', 'status' => '1'];
            $author = Db::name('WechatServiceConfig')->where($where)->find();
            empty($author) && $this->error('无效的授权信息，请同步其它公众号！');
            $data = Build::filter(Wechat::service()->getAuthorizerInfo($appid));
            $data['authorizer_appid'] = $appid;
            $where = ['authorizer_appid' => $data['authorizer_appid']];
            $appkey = Db::name('WechatServiceConfig')->where($where)->value('appkey');
            if (empty($appkey)) $data['appkey'] = md5(uniqid('', true));
            if (data_save('WechatServiceConfig', $data, 'authorizer_appid')) {
                $this->success('更新公众号授权信息成功！', '');
            }
        } catch (\think\exception\HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("获取授权信息失败，请稍候再试！<br>{$e->getMessage()}");
        }
    }

    /**
     * 同步所有授权公众号
     */
    public function syncall()
    {
        try {
            $wechat = Wechat::service();
            $result = $wechat->getAuthorizerList();
            foreach ($result['list'] as $item) if (!empty($item['refresh_token']) && !empty($item['auth_time'])) {
                $data = Build::filter($wechat->getAuthorizerInfo($item['authorizer_appid']));
                $data['is_deleted'] = '0';
                $data['authorizer_appid'] = $item['authorizer_appid'];
                $data['authorizer_refresh_token'] = $item['refresh_token'];
                $data['create_at'] = date('Y-m-d H:i:s', $item['auth_time']);
                $where = ['authorizer_appid' => $data['authorizer_appid']];
                $appkey = Db::name('WechatServiceConfig')->where($where)->value('appkey');
                if (empty($appkey)) $data['appkey'] = md5(uniqid('', true));
                if (!data_save('WechatServiceConfig', $data, 'authorizer_appid')) {
                    $this->error('获取授权信息失败，请稍候再试！', '');
                }
            }
            $this->success('同步所有授权信息成功！', '');
        } catch (\think\exception\HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("同步授权失败，请稍候再试！<br>{$e->getMessage()}");
        }
    }

    /**
     * 删除公众号授权
     */
    public function del()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

    /**
     * 禁用公众号授权
     */
    public function forbid()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用公众号授权
     */
    public function resume()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }
}