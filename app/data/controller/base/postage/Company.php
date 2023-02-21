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

use app\data\model\BasePostageCompany;
use app\data\service\ExpressService;
use Exception;
use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\exception\HttpResponseException;

/**
 * 快递公司管理
 * Class Company
 * @package app\data\controller\base\postage
 */
class Company extends Controller
{
    /**
     * 快递公司管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->type = $this->get['type'] ?? 'index';
        BasePostageCompany::mQuery()->layTable(function () {
            $this->title = '快递公司管理';
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0, 'status' => intval($this->type === 'index')]);
            $query->like('name,code_1|code_3#code')->equal('status')->dateBetween('create_at');
        });
    }

    /**
     * 添加快递公司
     * @auth true
     */
    public function add()
    {
        $this->title = '添加快递公司';
        BasePostageCompany::mForm('form');
    }

    /**
     * 编辑快递公司
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑快递公司';
        BasePostageCompany::mForm('form');
    }

    /**
     * 同步字段编号
     * @param array $data
     * @return void
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            if (empty($data['code_2'])) {
                $data['code_2'] = $data['code_3'];
            }
        }
    }

    /**
     * 修改快递公司状态
     * @auth true
     */
    public function state()
    {
        BasePostageCompany::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除快递公司
     * @auth true
     */
    public function remove()
    {
        BasePostageCompany::mDelete();
    }

    /**
     * 同步快递公司
     * @auth true
     */
    public function sync()
    {
        try {
            $result = ExpressService::company();
            if (empty($result['code'])) $this->error($result['info']);
            foreach ($result['data'] as $vo) BasePostageCompany::mUpdate([
                'name'    => $vo['title'],
                'code_1'  => $vo['code_1'],
                'code_2'  => $vo['code_2'],
                'code_3'  => $vo['code_3'],
                'deleted' => 0,
            ], 'code_1');
            $this->success('同步快递公司成功！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->error('同步快递公司数据失败！');
        }
    }
}