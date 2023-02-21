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

namespace app\data\controller\base\postage;

use app\data\model\BasePostageTemplate;
use app\data\service\ExpressService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\helper\QueryHelper;

/**
 * 邮费模板管理
 * Class Template
 * @package app\data\controller\base\postage
 */
class Template extends Controller
{
    /**
     * 快递邮费模板
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->type = $this->get['type'] ?? 'index';;
        BasePostageTemplate::mQuery()->layTable(function () {
            $this->title = '快递邮费模板';
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0, 'status' => intval($this->type === 'index')]);
            $query->like('code,name')->equal('status')->dateBetween('create_at');
        });
    }

    /**
     * 配送区域管理
     * @auth true
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function region()
    {
        if ($this->request->isGet()) {
            $this->title = '配送区域管理';
            $this->citys = ExpressService::region();
            $this->fetch('form_region');
        } else {
            $data = $this->_vali(['nos.default' => '']);
            sysdata('data.NotRegion', str2arr($data['nos']));
            $this->success('修改配送区域成功！', 'javascript:history.back()');
        }
    }

    /**
     * 添加配送邮费模板
     * @auth true
     */
    public function add()
    {
        $this->title = '添加配送邮费模板';
        BasePostageTemplate::mForm('form');
    }

    /**
     * 编辑配送邮费模板
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑配送邮费模板';
        BasePostageTemplate::mForm('form');
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
            $data['code'] = CodeExtend::uniqidDate(12, 'T');
        }
        if ($this->request->isGet()) {
            $this->citys = ExpressService::region(2, 1);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _form_result(bool $result)
    {
        if ($result && $this->request->isPost()) {
            $this->success('邮费模板保存成功！', 'javascript:history.back()');
        }
    }

    /**
     * 启用或禁用邮费模板
     * @auth true
     */
    public function state()
    {
        BasePostageTemplate::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除邮费模板
     * @auth true
     */
    public function remove()
    {
        BasePostageTemplate::mDelete();
    }
}