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

namespace app\data\controller\api;

use app\data\model\BaseUserMessage;
use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemBase;

/**
 * 基础数据接口
 * Class Data
 * @package app\data\controller\api
 */
class Data extends Controller
{

    /**
     * 获取指定数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getData()
    {
        $data = $this->_vali(['name.require' => '数据名称不能为空！']);
        $extra = ['about', 'slider', 'agreement', 'cropper']; // 其他数据
        if (in_array($data['name'], $extra) || isset(SystemBase::items('页面内容')[$data['name']])) {
            $this->success('获取数据对象', sysdata($data['name']));
        } else {
            $this->error('获取数据失败', []);
        }
    }

    /**
     * 图片内容数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSlider()
    {
        $this->keys = input('keys', '首页图片');
        if (isset(SystemBase::items('图片内容')[$this->keys])) {
            $this->success('获取图片内容', sysdata($this->keys));
        } else {
            $this->error('获取图片失败', []);
        }
    }

    /**
     * 系统通知数据
     */
    public function getNotify()
    {
        BaseUserMessage::mQuery(null, function (QueryHelper $query) {
            if (($id = input('id')) > 0) {
                BaseUserMessage::mk()->where(['id' => $id])->inc('num_read')->update([]);
            }
            $query->equal('id')->where(['status' => 1, 'deleted' => 0]);
            $this->success('获取系统通知', $query->order('sort desc,id desc')->page(true, false, false, 20));
        });
    }
}