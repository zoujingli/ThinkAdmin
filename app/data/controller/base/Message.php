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

namespace app\data\controller\base;

use app\data\model\BaseUserMessage;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 系统通知管理
 * Class Notify
 * @package app\data\controller\base
 */
class Message extends Controller
{
    /**
     * 系统通知管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        BaseUserMessage::mQuery()->layTable(function () {
            $this->title = '系统通知管理';
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0]);
            $query->like('name')->equal('status')->dateBetween('create_at');
        });
    }

    /**
     * 添加系统通知
     * @auth true
     */
    public function add()
    {
        $this->title = '添加系统通知';
        BaseUserMessage::mForm('form');
    }

    /**
     * 编辑系统通知
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑系统通知';
        BaseUserMessage::mForm('form');
    }

    /**
     * 表单结果处理
     * @param boolean $state
     */
    protected function _form_result(bool $state)
    {
        if ($state) {
            $this->success('内容保存成功！', 'javascript:history.back()');
        }
    }

    /**
     * 修改通知状态
     * @auth true
     */
    public function state()
    {
        BaseUserMessage::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除系统通知
     * @auth true
     */
    public function remove()
    {
        BaseUserMessage::mDelete();
    }
}