<?php

declare(strict_types=1);
/**
 * +----------------------------------------------------------------------
 * | ThinkAdmin Plugin for ThinkAdmin
 * +----------------------------------------------------------------------
 * | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * +----------------------------------------------------------------------
 * | 官方网站: https://thinkadmin.top
 * +----------------------------------------------------------------------
 * | 开源协议 ( https://mit-license.org )
 * | 免责声明 ( https://thinkadmin.top/disclaimer )
 * | 会员特权 ( https://thinkadmin.top/vip-introduce )
 * +----------------------------------------------------------------------
 * | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemFile;
use think\admin\service\AdminService;
use think\admin\Storage;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 系统文件管理.
 * @class File
 */
class File extends Controller
{
    /**
     * 存储类型.
     * @var array
     */
    protected $types;

    /**
     * 系统文件管理.
     * @auth true
     * @menu true
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function index()
    {
        SystemFile::mQuery()->layTable(function () {
            $this->title = '系统文件管理';
            $this->xexts = SystemFile::mk()->distinct()->column('xext');
        }, static function (QueryHelper $query) {
            $query->like('name,hash,xext')->equal('type')->dateBetween('create_at');
            $query->where(['issafe' => 0, 'status' => 2, 'uuid' => AdminService::getUserId()]);
        });
    }

    /**
     * 编辑系统文件.
     * @auth true
     */
    public function edit()
    {
        SystemFile::mForm('form');
    }

    /**
     * 删除系统文件.
     * @auth true
     */
    public function remove()
    {
        if (!AdminService::isSuper()) {
            $where = ['uuid' => AdminService::getUserId()];
        }
        SystemFile::mDelete('', $where ?? []);
    }

    /**
     * 清理重复文件.
     * @auth true
     * @throws DbException
     */
    public function distinct()
    {
        $map = ['issafe' => 0, 'uuid' => AdminService::getUserId()];
        // 使用派生表包装子查询，避免直接引用同一表
        $keepSubQuery = SystemFile::mk()->fieldRaw('MAX(id) AS id')->where($map)->group('type, xkey')->buildSql();
        // 使用 whereNotExists 配合派生表子查询删除，避免 1093 错误和 whereIn
        SystemFile::mk()->where($map)->whereNotExists(function ($query) use ($keepSubQuery) {
            $query->table("({$keepSubQuery})")->alias('f2')->whereRaw('f2.id = system_file.id');
        })->delete();
        $this->success('清理重复文件成功！');
    }

    /**
     * 控制器初始化.
     */
    protected function initialize()
    {
        $this->types = Storage::types();
    }

    /**
     * 数据列表处理.
     */
    protected function _page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['ctype'] = $this->types[$vo['type']] ?? $vo['type'];
        }
    }
}
