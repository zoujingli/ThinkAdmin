<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\model\WechatAuto;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\helper\QueryHelper;
use think\admin\service\SystemService;

/**
 * 关注自动回复
 * @class Auto
 * @package app\wechat\controller
 */
class Auto extends Controller
{
    /**
     * 消息类型
     * @var array
     */
    public $types = [
        'text'  => '文字', 'news' => '图文',
        'image' => '图片', 'music' => '音乐',
        'video' => '视频', 'voice' => '语音',
    ];

    /**
     * 关注自动回复
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->type = $this->get['type'] ?? 'index';
        WechatAuto::mQuery()->layTable(function () {
            $this->title = '关注自动回复';
        }, function (QueryHelper $query) {
            $query->like('code,type#mtype')->dateBetween('create_at');
            $query->where(['status' => intval($this->type === 'index')]);
        });
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['type'] = $this->types[$vo['type']] ?? $vo['type'];
        }
    }

    /**
     * 添加自动回复
     * @auth true
     */
    public function add()
    {
        $this->title = '添加自动回复';
        WechatAuto::mForm('form');
    }

    /**
     * 编辑自动回复
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑自动回复';
        WechatAuto::mForm('form');
    }

    /**
     * 添加数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidNumber(18, 'AM');
        }
        if ($this->request->isGet()) {
            $this->defaultImage = SystemService::uri('/static/theme/img/image.png', '__FULL__');
        } else {
            $data['content'] = strip_tags($data['content'] ?? '', '<a>');
        }
    }

    /**
     * 修改规则状态
     * @auth true
     */
    public function state()
    {
        WechatAuto::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除自动回复
     * @auth true
     */
    public function remove()
    {
        WechatAuto::mDelete();
    }
}