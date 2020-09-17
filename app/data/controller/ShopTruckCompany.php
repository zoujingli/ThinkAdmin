<?php

namespace app\data\controller;

use app\data\service\TruckService;
use think\admin\Controller;
use think\admin\service\SystemService;
use think\exception\HttpResponseException;

/**
 * 配送快递公司管理
 * Class ShopTruckCompany
 * @package app\data\controller
 */
class ShopTruckCompany extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopTruckCompany';

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
        $query = $this->_query($this->table);
        $query->like('name,code')->equal('status')->dateBetween('craete_at');
        // 加载对应数据
        $this->type = $this->request->get('type', 'index');
        if ($this->type === 'index') $query->where(['status' => '1']);
        elseif ($this->type === 'recycle') $query->where(['status' => '0']);
        // 列表显示分页
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 添加快递公司
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->title = '添加快递公司';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑快递公司
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->title = '编辑快递公司';
        $this->_form($this->table, 'form');
    }

    /**
     * 修改快递公司状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除快递公司
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

    /**
     * 同步快递公司
     * @auth true
     */
    public function synchronize()
    {
        try {
            $result = TruckService::instance()->company();
            if (empty($result['code'])) $this->error($result['info']);
            foreach ($result['data'] as $vo) SystemService::instance()->save($this->table, [
                'code_1' => $vo['code_1'], 'code_2' => $vo['code_2'],
                'code_3' => $vo['code_3'], 'name' => $vo['title'], 'deleted' => 0,
            ], 'code_1');
            $this->success('同步快递公司成功！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error('同步快递公司数据失败！');
        }
    }

}