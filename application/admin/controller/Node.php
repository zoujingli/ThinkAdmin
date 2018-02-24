<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use service\NodeService;
use service\ToolsService;

/**
 * 系统功能节点管理
 * Class Node
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Node extends BasicAdmin
{

    /**
     * 指定当前默认模型
     * @var string
     */
    public $table = 'SystemNode';

    /**
     * 显示节点列表
     */
    public function index()
    {
        $alert = [
            'type'    => 'danger',
            'title'   => '操作安全警告（默认新节点所有人可以访问，请勾选登录控制）',
            'content' => '结构为系统自动生成，其权限各选项直接影响到不同权限用户的访问及操作，请勿随意修改数据！'
        ];
        $nodes = ToolsService::arr2table(NodeService::get(), 'node', 'pnode');
        return view('', ['title' => '系统节点管理', 'nodes' => $nodes, 'alert' => $alert]);
    }

    /**
     * 保存节点变更
     */
    public function save()
    {
        if ($this->request->isPost()) {
            list($data, $post) = [[], $this->request->post()];
            if (isset($post['list'])) {
                foreach ($post['list'] as $vo) {
                    $data['node'] = $vo['node'];
                    $data[$vo['name']] = $vo['value'];
                }
                !empty($data) && DataService::save($this->table, $data, 'node');
                $this->success('参数保存成功！', '');
            }
        } else {
            $this->error('访问异常，请重新进入...');
        }
    }

}
