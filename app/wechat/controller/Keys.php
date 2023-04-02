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

use app\wechat\model\WechatKeys;
use app\wechat\service\WechatService;
use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\service\SystemService;
use think\exception\HttpResponseException;

/**
 * 回复规则管理
 * @class Keys
 * @package app\wechat\controller
 */
class Keys extends Controller
{
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
        if ($this->request->get('action') === 'qrc') try {
            $wechat = WechatService::WeChatQrcode();
            $result = $wechat->create($this->request->get('keys', ''));
            $this->success('生成二维码成功！', "javascript:$.previewImage('{$wechat->url($result['ticket'])}')");
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("生成二维码失败，请稍候再试！<br> {$exception->getMessage()}");
        }
        // 数据列表分页处理
        $this->type = $this->get['type'] ?? 'index';
        WechatKeys::mQuery()->layTable(function () {
            $this->title = '回复规则管理';
        }, function (QueryHelper $query) {
            $query->whereNotIn('keys', ['subscribe', 'default']);
            $query->like('keys,type#mtype')->dateBetween('create_at');
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
            $vo['qrc'] = sysuri('wechat/keys/index') . "?action=qrc&keys={$vo['keys']}";
        }
    }

    /**
     * 添加回复规则
     * @auth true
     */
    public function add()
    {
        $this->title = '添加回复规则';
        WechatKeys::mForm('form');
    }

    /**
     * 编辑回复规则
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑回复规则';
        WechatKeys::mForm('form');
    }

    /**
     * 修改规则状态
     * @auth true
     */
    public function state()
    {
        WechatKeys::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除回复规则
     * @auth true
     */
    public function remove()
    {
        WechatKeys::mDelete();
    }

    /**
     * 配置订阅回复
     * @auth true
     */
    public function subscribe()
    {
        $this->title = '编辑订阅回复规则';
        WechatKeys::mForm('form', 'keys', [], ['keys' => 'subscribe']);
    }

    /**
     * 配置默认回复
     * @auth true
     */
    public function defaults()
    {
        $this->title = '编辑默认回复规则';
        WechatKeys::mForm('form', 'keys', [], ['keys' => 'default']);
    }

    /**
     * 添加数据处理
     * @param array $data
     * @throws \think\db\exception\DbException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            $map = [['keys', '=', $data['keys']], ['id', '<>', $data['id'] ?? 0]];
            if (WechatKeys::mk()->where($map)->count() > 0) $this->error('关键字已经存在！');
            $data['content'] = strip_tags($data['content'] ?? '', '<a>');
        } elseif ($this->request->isGet()) {
            $this->defaultImage = SystemService::uri('/static/theme/img/image.png', '__FULL__');
        }
    }
}
