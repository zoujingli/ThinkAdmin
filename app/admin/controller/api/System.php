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
 * Class System
 * @package app\admin\controller\api
 */
class System extends Controller
{

    /**
     * 网站压缩发布
     * @login true
     */
    public function push()
    {
        if (AdminService::isSuper()) try {
            AdminService::clearCache();
            SystemService::pushRuntime();
            sysoplog('系统运维管理', '刷新创建路由缓存');
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
        if (AdminService::isSuper()) try {
            AdminService::clearCache();
            SystemService::clearRuntime();
            sysoplog('系统运维管理', '清理网站日志缓存');
            $this->success('清空日志缓存成功！', 'javascript:location.reload()');
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
        if (AdminService::isSuper()) if (input('state')) {
            SystemService::setRuntime('product');
            sysoplog('系统运维管理', '开发模式切换为生产模式');
            $this->success('已切换为生产模式！', 'javascript:location.reload()');
        } else {
            SystemService::setRuntime('debug');
            sysoplog('系统运维管理', '生产模式切换为开发模式');
            $this->success('已切换为开发模式！', 'javascript:location.reload()');
        } else {
            $this->error('只有超级管理员才能操作！');
        }
    }

    /**
     * 修改富文本编辑器
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editor()
    {
        if (AdminService::isSuper()) {
            $editor = input('editor', 'auto');
            sysconf('base.editor', $editor);
            sysoplog('系统运维管理', "切换编辑器为{$editor}");
            $this->success('已切换后台编辑器！', 'javascript:location.reload()');
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
        if (AdminService::isSuper()) try {
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
            sysoplog('系统运维管理', '清理系统配置参数');
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