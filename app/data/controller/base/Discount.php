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

use app\data\model\BaseUserDiscount;
use app\data\model\BaseUserUpgrade;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 折扣方案管理
 * Class Discount
 * @package app\data\controller\base
 */
class Discount extends Controller
{
    /**
     * 折扣方案管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->type = $this->get['type'] ?? 'index';
        BaseUserDiscount::mQuery()->layTable(function () {
            $this->title = '折扣方案管理';
        }, function (QueryHelper $query) {
            $query->where(['status' => intval($this->type === 'index'), 'deleted' => 0]);
        });
    }

    /**
     * 添加折扣方案
     * @auth true
     */
    public function add()
    {
        BaseUserDiscount::mForm('form');
    }

    /**
     * 编辑折扣方案
     * @auth true
     */
    public function edit()
    {
        BaseUserDiscount::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     */
    protected function _form_filter(array &$vo)
    {
        if ($this->request->isPost()) {
            $rule = [];
            foreach ($vo as $k => $v) if (stripos($k, '_level_') !== false) {
                [, $level] = explode('_level_', $k);
                $rule[] = ['level' => $level, 'discount' => $v];
            }
            $vo['items'] = json_encode($rule, JSON_UNESCAPED_UNICODE);
        } else {
            $this->levels = BaseUserUpgrade::items();
            if (empty($this->levels)) $this->error('未配置用户等级！');
            foreach ($vo['items'] ?? [] as $item) {
                $vo["_level_{$item['level']}"] = $item['discount'];
            }
        }
    }

    /**
     * 修改折扣方案状态
     * @auth true
     */
    public function state()
    {
        BaseUserDiscount::mSave();
    }

    /**
     * 删除折扣方案配置
     * @auth true
     */
    public function remove()
    {
        BaseUserDiscount::mDelete();
    }
}