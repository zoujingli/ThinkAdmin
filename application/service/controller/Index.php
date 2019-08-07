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

namespace app\service\controller;

use app\service\service\BuildService;
use app\service\service\WechatService;
use library\Controller;
use think\Db;
use think\exception\HttpResponseException;

/**
 * 公众授权管理
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
     * 公众授权管理
     * @auth true
     * @menu true
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->applyCsrfToken();
        $this->title = '公众授权管理';
        $query = $this->_query($this->table)->like('authorizer_appid,nick_name,principal_name');
        $query = $query->equal('service_type,status')->dateBetween('create_at');
        $query->where(['is_deleted' => '0'])->order('id desc')->page();
    }

    /**
     * 清理调用次数
     * @auth true
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function clearQuota()
    {
        $appid = input('appid');
        $result = WechatService::WeChatLimit($appid)->clearQuota();
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
     * @auth true
     */
    public function sync()
    {
        try {
            $appid = $this->request->get('appid');
            $where = ['authorizer_appid' => $appid, 'is_deleted' => '0', 'status' => '1'];
            $author = Db::name('WechatServiceConfig')->where($where)->find();
            if (empty($author)) $this->error('无效的授权信息，请同步其它公众号！');
            $data = BuildService::filter(WechatService::service()->getAuthorizerInfo($appid));
            $data['authorizer_appid'] = $appid;
            $where = ['authorizer_appid' => $data['authorizer_appid']];
            $appkey = Db::name('WechatServiceConfig')->where($where)->value('appkey');
            if (empty($appkey)) $data['appkey'] = md5(uniqid('', true));
            if (data_save('WechatServiceConfig', $data, 'authorizer_appid')) {
                $this->success('更新公众号授权成功！', '');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("获取授权信息失败，请稍候再试！<br>{$e->getMessage()}");
        }
    }

    /**
     * 同步所有授权公众号
     * @auth true
     */
    public function syncall()
    {
        try {
            $wechat = WechatService::service();
            $result = $wechat->getAuthorizerList();
            foreach ($result['list'] as $item) if (!empty($item['refresh_token']) && !empty($item['auth_time'])) {
                $data = BuildService::filter($wechat->getAuthorizerInfo($item['authorizer_appid']));
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
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("同步授权失败，请稍候再试！<br>{$e->getMessage()}");
        }
    }

    /**
     * 删除公众号授权
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

    /**
     * 禁用公众号授权
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用公众号授权
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }
}
