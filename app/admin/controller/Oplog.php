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

namespace app\admin\controller;

use Exception;
use Ip2Region;
use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemOplog;
use think\exception\HttpResponseException;

/**
 * 系统日志管理
 * Class Oplog
 * @package app\admin\controller
 */
class Oplog extends Controller
{
    /**
     * 系统日志管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        SystemOplog::mQuery()->layTable(function () {
            $this->title = '系统日志管理';
            $columns = SystemOplog::mk()->column('action,username', 'id');
            $this->users = array_unique(array_column($columns, 'username'));
            $this->actions = array_unique(array_column($columns, 'action'));
        }, function (QueryHelper $query) {
            $query->dateBetween('create_at')->equal('username,action')->like('content,geoip,node');
        });
    }

    /**
     * 列表数据处理
     * @auth true
     * @param array $data
     * @throws \Exception
     */
    protected function _index_page_filter(array &$data)
    {
        $region = new Ip2Region();
        foreach ($data as &$vo) {
            $isp = $region->btreeSearch($vo['geoip']);
            $vo['geoisp'] = str_replace(['内网IP', '0', '|'], '', $isp['region'] ?? '') ?: '-';
        }
    }

    /**
     * 清理系统日志
     * @auth true
     */
    public function clear()
    {
        try {
            SystemOplog::mQuery()->empty();
            sysoplog('系统运维管理', '成功清理所有日志');
            $this->success('日志清理成功！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->error("日志清理失败，{$exception->getMessage()}");
        }
    }

    /**
     * 删除系统日志
     * @auth true
     */
    public function remove()
    {
        SystemOplog::mDelete();
    }
}
