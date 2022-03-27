<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\model\SystemConfig;
use think\admin\service\AdminService;
use think\admin\service\SystemService;
use think\exception\HttpResponseException;

/**
 * 系统运行控制管理
 * Class Runtime
 * @package app\admin\controller\api
 */
class Runtime extends Controller
{

    /**
     * 网站压缩发布
     * @login true
     */
    public function push()
    {
        if (AdminService::instance()->isSuper()) try {
            AdminService::instance()->clearCache();
            SystemService::instance()->pushRuntime();
            sysoplog('系统运维管理', '刷新并创建网站路由缓存');
            $this->success('网站缓存加速成功！', 'javascript:location.reload()');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        } else {
            $this->error('只有超级管理员才能操作！');
        }
    }

    /**
     * 清理运行缓存
     * @login true
     */
    public function clear()
    {
        if (AdminService::instance()->isSuper()) try {
            AdminService::instance()->clearCache();
            SystemService::instance()->clearRuntime();
            sysoplog('系统运维管理', '清理网站日志及缓存数据');
            $this->success('清空缓存日志成功！', 'javascript:location.reload()');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        } else {
            $this->error('只有超级管理员才能操作！');
        }
    }

    /**
     * 当前运行模式
     * @login true
     */
    public function debug()
    {
        if (AdminService::instance()->isSuper()) if (input('state')) {
            SystemService::instance()->setRuntime('product');
            sysoplog('系统运维管理', '由开发模式切换为生产模式');
            $this->success('已切换为生产模式！', 'javascript:location.reload()');
        } else {
            SystemService::instance()->setRuntime('debug');
            sysoplog('系统运维管理', '由生产模式切换为开发模式');
            $this->success('已切换为开发模式！', 'javascript:location.reload()');
        } else {
            $this->error('只有超级管理员才能操作！');
        }
    }

    /**
     * 清理系统配置
     * @login true
     */
    public function config()
    {
        if (AdminService::instance()->isSuper()) try {
            [$tmpdata, $newdata] = [[], []];
            foreach (SystemConfig::mk()->order('type,name asc')->cursor() as $item) {
                $tmpdata[$item['type']][$item['name']] = $item['value'];
            }
            foreach ($tmpdata as $type => $items) foreach ($items as $name => $value) {
                $newdata[] = ['type' => $type, 'name' => $name, 'value' => $value];
            }
            $this->app->db->transaction(function () use ($newdata) {
                SystemConfig::mQuery()->empty()->insertAll($newdata);
            });
            $this->app->cache->delete('SystemConfig');
            sysoplog('系统运维管理', '清理系统参数配置成功');
            $this->success('清理系统配置成功！', 'javascript:location.reload()');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        } else {
            $this->error('只有超级管理员才能操作！');
        }
    }
}