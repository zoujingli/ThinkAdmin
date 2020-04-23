<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use app\wechat\service\WechatService;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 回复规则管理
 * Class Keys
 * @package app\wechat\controller
 */
class Keys extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'WechatKeys';

    /**
     * 消息类型
     * @var array
     */
    public $types = [
        'text'  => '文字', 'news' => '图文', 'image' => '图片', 'music' => '音乐',
        'video' => '视频', 'voice' => '语音', 'customservice' => '转客服',
    ];

    /**
     * 回复规则管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        // 关键字二维码生成
        if ($this->request->get('action') === 'qrc') {
            try {
                $wechat = WechatService::WeChatQrcode();
                $result = $wechat->create($this->request->get('keys', ''));
                $this->success('生成二维码成功！', "javascript:$.previewImage('{$wechat->url($result['ticket'])}')");
            } catch (HttpResponseException $exception) {
                throw  $exception;
            } catch (\Exception $e) {
                $this->error("生成二维码失败，请稍候再试！<br> {$e->getMessage()}");
            }
        }
        // 关键字列表显示
        $this->title = '回复规则管理';
        $query = $this->_query($this->table)->like('keys,type')->equal('status')->dateBetween('create_at');
        $query->whereNotIn('keys', ['subscribe', 'default'])->order('sort desc,id desc')->page();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(&$data)
    {
        foreach ($data as &$vo) {
            $vo['qrc'] = url('wechat/keys/index') . "?action=qrc&keys={$vo['keys']}";
            $vo['type'] = isset($this->types[$vo['type']]) ? $this->types[$vo['type']] : $vo['type'];
        }
    }

    /**
     * 添加回复规则
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_applyFormToken();
        $this->title = '添加回复规则';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑回复规则
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_applyFormToken();
        $this->title = '编辑回复规则';
        $this->_form($this->table, 'form');
    }

    /**
     * 修改回复规则状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_applyFormToken();
        $this->_save($this->table, ['status' => input('status')]);
    }

    /**
     * 删除回复规则
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 配置关注回复
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function subscribe()
    {
        $this->_applyFormToken();
        $this->title = '编辑关注回复规则';
        $this->_form($this->table, 'form', 'keys', [], ['keys' => 'subscribe']);
    }

    /**
     * 配置默认回复
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function defaults()
    {
        $this->_applyFormToken();
        $this->title = '编辑默认回复规则';
        $this->_form($this->table, 'form', 'keys', [], ['keys' => 'default']);
    }

    /**
     * 添加数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isPost() && isset($data['keys'])) {
            $db = $this->app->db->name($this->table)->where('keys', $data['keys']);
            empty($data['id']) || $db->where('id', '<>', $data['id']);
            if ($db->count() > 0) {
                $this->error('关键字已经存在，请使用其它关键字！');
            }
        }
        if ($this->request->isGet()) {
            $this->msgTypes = $this->types;
            $root = rtrim(dirname($this->request->basefile(true)), '\\/');
            $this->defaultImage = "{$root}/static/theme/img/image.png";
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _form_result($result)
    {
        if ($result !== false) {
            $iskeys = in_array(input('keys'), ['subscribe', 'default']);
            $location = $iskeys ? 'javascript:$.form.reload()' : 'javascript:history.back()';
            $this->success('恭喜, 关键字保存成功！', $location);
        } else {
            $this->error('关键字保存失败, 请稍候再试！');
        }
    }

}
