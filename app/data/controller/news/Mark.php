<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\controller\news;

use app\data\model\DataNewsMark;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 文章标签管理
 * Class Mark
 * @package app\data\controller\news
 */
class Mark extends Controller
{
    /**
     * 文章标签管理
     * @auth true
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        DataNewsMark::mQuery()->layTable(function () {
            $this->title = '文章标签管理';
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0]);
            $query->like('name')->equal('status')->dateBetween('create_at');
        });
    }

    /**
     * 添加文章标签
     * @auth true
     */
    public function add()
    {
        DataNewsMark::mForm('form');
    }

    /**
     * 编辑文章标签
     * @auth true
     */
    public function edit()
    {
        DataNewsMark::mForm('form');
    }

    /**
     * 表单结果处理
     * @param bool $state
     * @return void
     */
    protected function _form_result(bool $state)
    {
        if ($state) {
            $this->success('修改标签成功', "javascript:$('#TagsData').trigger('reload')");
        }
    }

    /**
     * 修改文章标签状态
     * @auth true
     */
    public function state()
    {
        DataNewsMark::mSave();
    }

    /**
     * 删除文章标签
     * @auth true
     */
    public function remove()
    {
        DataNewsMark::mDelete();
    }
}