<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

declare(strict_types=1);

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemAuth;
use think\admin\model\SystemNode;
use think\admin\Plugin;
use think\admin\service\AdminService;

/**
 * 系统权限管理
 * @class Auth
 * @package app\admin\controller
 */
class Auth extends Controller
{
    /**
     * 系统权限管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        SystemAuth::mQuery()->layTable(function () {
            $this->title = '系统权限管理';
        }, static function (QueryHelper $query) {
            $query->like('title,desc')->equal('status,utype')->dateBetween('create_at');
        });
    }

    /**
     * 修改权限状态
     * @auth true
     */
    public function state()
    {
        SystemAuth::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除系统权限
     * @auth true
     */
    public function remove()
    {
        SystemAuth::mDelete();
    }


    /**
     * 添加系统权限
     * @auth true
     */
    public function add()
    {
        SystemAuth::mForm('form');
    }

    /**
     * 编辑系统权限
     * @auth true
     */
    public function edit()
    {
        SystemAuth::mForm('form');
    }

    /**
     * 表单后置数据处理
     * @param array $data
     */
    protected function _form_filter(array $data)
    {
        if ($this->request->isGet()) {
            $this->title = empty($data['title']) ? "添加访问授权" : "编辑【{$data['title']}】授权";
        } elseif ($this->request->post('action') === 'json') {
            if ($this->app->isDebug()) AdminService::clear();
            $ztree = AdminService::getTree(empty($data['id']) ? [] : SystemNode::mk()->where(['auth' => $data['id']])->column('node'));
            usort($ztree, static function ($a, $b) {
                if (explode('-', $a['node'])[0] !== explode('-', $b['node'])[0]) {
                    if (stripos($a['node'], 'plugin-') === 0) return 1;
                }
                return $a['node'] === $b['node'] ? 0 : ($a['node'] > $b['node'] ? 1 : -1);
            });
            [$ps, $cs] = [Plugin::get(), (array)$this->app->config->get('app.app_names', [])];
            foreach ($ztree as &$n) $n['title'] = lang($cs[$n['node']] ?? (($ps[$n['node']] ?? [])['name'] ?? $n['title']));
            $this->success('获取权限节点成功！', $ztree);
        } elseif (empty($data['nodes'])) {
            $this->error('未配置功能节点！');
        }
    }

    /**
     * 节点更新处理
     * @param boolean $state
     * @param array $post
     * @return void
     */
    protected function _form_result(bool $state, array $post)
    {
        if ($state && $this->request->post('action') === 'save') {
            [$map, $data] = [['auth' => $post['id']], []];
            foreach ($post['nodes'] ?? [] as $node) $data[] = $map + ['node' => $node];
            SystemNode::mk()->where($map)->delete();
            count($data) > 0 && SystemNode::mk()->insertAll($data);
            sysoplog('系统权限管理', "配置系统权限[{$map['auth']}]授权成功");
            $this->success('权限修改成功！', 'javascript:history.back()');
        }
    }
}
