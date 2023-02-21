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

use app\data\model\DataNewsItem;
use app\data\model\DataNewsMark;
use app\data\service\NewsService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\helper\QueryHelper;

/**
 * 文章内容管理
 * Class Item
 * @package app\data\controller\news
 */
class Item extends Controller
{
    /**
     * 文章内容管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->type = $this->get['type'] ?? 'index';
        DataNewsItem::mQuery($this->get)->layTable(function () {
            $this->title = '文章内容管理';
            $this->marks = DataNewsMark::items();
        }, function (QueryHelper $query) {
            $query->like('code,name')->like('mark', ',')->dateBetween('create_at');
            $query->where(['status' => intval($this->type === 'index'), 'deleted' => 0]);
        });
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        NewsService::buildData($data);
    }

    /**
     * 添加文章内容
     * @auth true
     */
    public function add()
    {
        $this->title = '添加文章内容';
        DataNewsItem::mForm('form');
    }

    /**
     * 编辑文章内容
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑文章内容';
        DataNewsItem::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidNumber(20, 'A');
        }
        if ($this->request->isGet()) {
            $model = DataNewsMark::mk()->where(['status' => 1, 'deleted' => 0]);
            $this->marks = $model->order('sort desc,id desc')->select()->toArray();
            $data['mark'] = str2arr($data['mark'] ?? '');
        } else {
            $data['mark'] = arr2str($data['mark'] ?? []);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $state
     */
    protected function _form_result(bool $state)
    {
        if ($state) {
            $this->success('文章保存成功！', 'javascript:history.back()');
        }
    }

    /**
     * 修改文章状态
     * @auth true
     */
    public function state()
    {
        DataNewsItem::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除文章内容
     * @auth true
     */
    public function remove()
    {
        DataNewsItem::mDelete();
    }

    /**
     * 文章内容选择
     * @login true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $this->get['status'] = 1;
        $this->index();
    }
}