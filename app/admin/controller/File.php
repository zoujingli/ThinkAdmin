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

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemFile;
use think\admin\service\AdminService;
use think\admin\Storage;

/**
 * 系统文件管理
 * @class File
 * @package app\admin\controller
 */
class File extends Controller
{
    /**
     * 存储类型
     * @var array
     */
    protected $types;

    /**
     * 控制器初始化
     * @return void
     */
    protected function initialize()
    {
        $this->types = Storage::types();
    }

    /**
     * 系统文件管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        SystemFile::mQuery()->layTable(function () {
            $this->title = '系统文件管理';
            $this->xexts = SystemFile::mk()->distinct()->column('xext');
        }, function (QueryHelper $query) {
            $query->like('name,hash,xext')->equal('type')->dateBetween('create_at');
            $query->where(['issafe' => 0, 'status' => 2, 'uuid' => AdminService::getUserId()]);
        });
    }

    /**
     * 数据列表处理
     * @param array $data
     * @return void
     */
    protected function _page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['ctype'] = $this->types[$vo['type']] ?? $vo['type'];
        }
    }

    /**
     * 编辑系统文件
     * @auth true
     * @return void
     */
    public function edit()
    {
        SystemFile::mForm('form');
    }

    /**
     * 删除系统文件
     * @auth true
     * @return void
     */
    public function remove()
    {
        SystemFile::mDelete();
    }

    /**
     * 清理重复文件
     * @auth true
     * @return void
     * @throws \think\db\exception\DbException
     */
    public function distinct()
    {
        $map = ['uuid' => AdminService::getUserId()];
        $db1 = SystemFile::mk()->fieldRaw('max(id) id')->where($map)->group('type,xkey');
        $db2 = $this->app->db->table($db1->buildSql())->alias('dt')->field('id');
        SystemFile::mk()->whereRaw("id not in {$db2->buildSql()}")->delete();
        SystemFile::mk()->where($map)->where(['status' => 1])->delete();
        $this->success('清理重复文件成功！');
    }
}