<?php

namespace app\data\controller\base\postage;

use app\data\model\BasePostageCompany;
use app\data\service\ExpressService;
use think\admin\Controller;
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
        $this->title = '快递公司管理';

        // 加载对应数据
        $map = ['deleted' => 0];
        $this->type = input('get.type', 'index');
        if ($this->type === 'index') $map['status'] = 1;
        if ($this->type === 'recycle') $map['status'] = 0;

        // 列表显示分页
        $query = BasePostageCompany::mQuery();
        $query->like('name,code')->equal('status')->dateBetween('craete_at');
        $query->where($map)->order('sort desc,id desc')->page();
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
            $result = ExpressService::instance()->company();
            if (empty($result['code'])) $this->error($result['info']);
            foreach ($result['data'] as $vo) BasePostageCompany::mUpdate([
                'code_1' => $vo['code_1'], 'code_2' => $vo['code_2'], 'code_3' => $vo['code_3'], 'name' => $vo['title'], 'deleted' => 0,
            ], 'code_1');
            $this->success('同步快递公司成功！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error('同步快递公司数据失败！');
        }
    }
}