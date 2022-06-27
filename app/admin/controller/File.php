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

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemFile;

/**
 * 媒体文件管理
 * Class File
 * @package app\admin\controller
 */
class File extends Controller
{
    /**
     * 存储方式处理
     * @var string[]
     */
    protected $types = [
        'local'  => '本地服务器存储',
        'qiniu'  => '七牛云对象存储',
        'upyun'  => '又拍云USS存储',
        'alioss' => '阿里云OSS存储',
        'txcos'  => '腾讯云COS存储'
    ];

    /**
     * 媒体文件管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        SystemFile::mQuery()->layTable(function () {
            $this->title = '媒体文件管理';
        }, function (QueryHelper $query) {
            $query->like('name,hash,xext')->dateBetween('create_at');
            $query->where(['issafe' => 0, 'status' => 2])->equal('type');
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
     * 删除媒体文件
     * @auth true
     * @return void
     */
    public function remove()
    {
        SystemFile::mDelete();
    }
}