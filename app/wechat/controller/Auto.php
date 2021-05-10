<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use think\admin\Controller;
use think\admin\extend\CodeExtend;

/**
 * 关注自动回复
 * Class Auto
 * @package app\wechat\controller
 */
class Auto extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'WechatAuto';

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
        $this->title = '关注自动回复';
        $query = $this->_query($this->table)->like('code,type');
        $query->equal('status')->dateBetween('create_at')->order('time asc')->page();
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->title = '添加自动回复';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑自动回复
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->title = '编辑自动回复';
        $this->_form($this->table, 'form');
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
            $public = dirname($this->request->basefile(true));
            $this->defaultImage = "{$public}/static/theme/img/image.png";
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _form_result(bool $result)
    {
        if ($result !== false) {
            $this->success('恭喜, 关键字保存成功！', 'javascript:history.back()');
        } else {
            $this->error('关键字保存失败, 请稍候再试！');
        }
    }

    /**
     * 修改规则状态
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
     * 删除自动回复
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}