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

namespace app\wechat\controller;

use controller\BasicAdmin;
use service\LogService;
use service\ToolsService;
use service\WechatService;
use think\Db;

/**
 * 微信菜单管理
 * Class Menu
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Menu extends BasicAdmin
{

    /**
     * 指定当前页面标题
     * @var string
     */
    public $title = '微信菜单定制';

    /**
     * 指定默认操作的数据表
     * @var string
     */
    public $table = 'WechatMenu';

    /**
     * 微信菜单的类型
     * @var array
     */
    protected $menuType = [
        'view'               => '跳转URL',
        'click'              => '点击推事件',
        'scancode_push'      => '扫码推事件',
        'scancode_waitmsg'   => '扫码推事件且弹出“消息接收中”提示框',
        'pic_sysphoto'       => '弹出系统拍照发图',
        'pic_photo_or_album' => '弹出拍照或者相册发图',
        'pic_weixin'         => '弹出微信相册发图器',
        'location_select'    => '弹出地理位置选择器',
    ];

    /**
     * 显示菜单列表
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function index()
    {
        return parent::_list(Db::name($this->table), false, true);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_data_filter(&$data)
    {
        $data = ToolsService::arr2tree($data, 'index', 'pindex');
    }

    /**
     * 微信菜单编辑
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            !isset($post['data']) && $this->error('访问出错，请稍候再试！');
            // 删除菜单
            if (empty($post['data'])) {
                try {
                    Db::name($this->table)->where('1=1')->delete();
                    WechatService::WeChatMenu()->delete();
                } catch (\Exception $e) {
                    $this->error('删除取消微信菜单失败，请稍候再试！' . $e->getMessage());
                }
                $this->success('删除并取消微信菜单成功！', '');
            }
            // 数据过滤处理
            try {
                foreach ($post['data'] as &$vo) {
                    isset($vo['content']) && ($vo['content'] = str_replace('"', "'", $vo['content']));
                }
                Db::transaction(function () use ($post) {
                    Db::name($this->table)->where('1=1')->delete();
                    Db::name($this->table)->insertAll($post['data']);
                });
                $this->_push();
            } catch (\Exception $e) {
                $this->error('微信菜单发布失败，请稍候再试！' . $e->getMessage());
            }
            LogService::write('微信管理', '发布微信菜单成功');
            $this->success('保存发布菜单成功！', '');
        }
    }

    /**
     * 取消菜单
     */
    public function cancel()
    {
        try {
            WechatService::WeChatMenu()->delete();
        } catch (\Exception $e) {
            $this->error('菜单取消失败');
        }
        $this->success('菜单取消成功，重新关注可立即生效！', '');
    }

    /**
     * 菜单推送
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function _push()
    {
        list($map, $field) = [['status' => '1'], 'id,index,pindex,name,type,content'];
        $result = (array)Db::name($this->table)->field($field)->where($map)->order('sort ASC,id ASC')->select();
        foreach ($result as &$row) {
            empty($row['content']) && $row['content'] = uniqid();
            if ($row['type'] === 'miniprogram') {
                list($row['appid'], $row['url'], $row['pagepath']) = explode(',', "{$row['content']},,");
            } elseif ($row['type'] === 'view') {
                if (preg_match('#^(\w+:)?//#', $row['content'])) {
                    $row['url'] = $row['content'];
                } else {
                    $row['url'] = url($row['content'], '', true, true);
                }
            } elseif ($row['type'] === 'event') {
                if (isset($this->menuType[$row['content']])) {
                    list($row['type'], $row['key']) = [$row['content'], "wechat_menu#id#{$row['id']}"];
                }
            } elseif ($row['type'] === 'media_id') {
                $row['media_id'] = $row['content'];
            } else {
                $row['key'] = "wechat_menu#id#{$row['id']}";
                !in_array($row['type'], $this->menuType) && $row['type'] = 'click';
            }
            unset($row['content']);
        }
        $menus = ToolsService::arr2tree($result, 'index', 'pindex', 'sub_button');
        //去除无效的字段
        foreach ($menus as &$menu) {
            unset($menu['index'], $menu['pindex'], $menu['id']);
            if (empty($menu['sub_button'])) {
                continue;
            }
            foreach ($menu['sub_button'] as &$submenu) {
                unset($submenu['index'], $submenu['pindex'], $submenu['id']);
            }
            unset($menu['type']);
        }
        WechatService::WeChatMenu()->create(['button' => $menus]);
    }

}
