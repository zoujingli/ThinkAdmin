<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\model\SystemConfig;
use think\admin\service\AdminService;
use think\admin\service\RuntimeService;
use think\exception\HttpResponseException;

/**
 * 系统运行管理
 * @class System
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
            RuntimeService::push() && sysoplog('系统运维管理', '刷新发布运行缓存');
            $this->success('网站缓存加速成功！', 'javascript:location.reload()');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }

    /**
     * 清理运行缓存
     * @login true
     */
    public function clear()
    {
        if (AdminService::isSuper()) try {
            RuntimeService::clear() && sysoplog('系统运维管理', '清理网站日志缓存');
            $this->success('清空日志缓存成功！', 'javascript:location.reload()');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }

    /**
     * 当前运行模式
     * @login true
     */
    public function debug()
    {
        if (AdminService::isSuper()) if (input('state')) {
            RuntimeService::set('product');
            sysoplog('系统运维管理', '开发模式切换为生产模式');
            $this->success('已切换为生产模式！', 'javascript:location.reload()');
        } else {
            RuntimeService::set('debug');
            sysoplog('系统运维管理', '生产模式切换为开发模式');
            $this->success('已切换为开发模式！', 'javascript:location.reload()');
        } else {
            $this->error('请使用超管账号操作！');
        }
    }

    /**
     * 修改富文本编辑器
     * @return void
     * @throws \think\admin\Exception
     */
    public function editor()
    {
        if (AdminService::isSuper()) {
            $editor = input('editor', 'auto');
            sysconf('base.editor', $editor);
            sysoplog('系统运维管理', "切换编辑器为{$editor}");
            $this->success('已切换后台编辑器！', 'javascript:location.reload()');
        } else {
            $this->error('请使用超管账号操作！');
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
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }
}