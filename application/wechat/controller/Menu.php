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
     * 显示列表操作
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
            $data = $post['data'];
            if (empty($data)) {
                Db::name($this->table)->where('1=1')->delete();
                load_wechat('Menu')->deleteMenu();
                $this->success('删除并取消微信菜单成功！', '');
            }
            foreach ($data as &$vo) {
                if (isset($vo['content'])) {
                    $vo['content'] = str_replace('"', "'", $vo['content']);
                }
            }
            if (Db::name($this->table)->where('1=1')->delete() !== false && Db::name($this->table)->insertAll($data) !== false) {
                $result = $this->_push();
                if ($result['status']) {
                    LogService::write('微信管理', '发布微信菜单成功');
                    $this->success('保存发布菜单成功！', '');
                }
                $this->error('菜单发布失败，' . $result['errmsg']);
            }
            $this->error('保存发布菜单失败！');
        }
    }

    /**
     * 取消菜单
     */
    public function cancel()
    {
        $wehcat = load_wechat('Menu');
        if (false !== $wehcat->deleteMenu()) {
            $this->success('菜单取消成功，重新关注可立即生效！', '');
        }
        $this->error('菜单取消失败，' . $wehcat->getError());
    }

    /**
     * 菜单推送
     */
    protected function _push()
    {
        list($map, $fields) = [['status' => '1'], 'id,index,pindex,name,type,content'];
        $result = (array)Db::name($this->table)->field($fields)->where($map)->order('sort ASC,id ASC')->select();
        foreach ($result as &$row) {
            empty($row['content']) && $row['content'] = uniqid();
            if ($row['type'] === 'miniprogram') :
                list($row['appid'], $row['url'], $row['pagepath']) = explode(',', "{$row['content']},,");
            elseif ($row['type'] === 'view') :
                if (preg_match('#^(\w+:)?//#', $row['content'])) {
                    $row['url'] = $row['content'];
                } else {
                    $row['url'] = url($row['content'], '', true, true);
                }
            elseif ($row['type'] === 'event') :
                if (isset($this->menuType[$row['content']])) {
                    list($row['type'], $row['key']) = [$row['content'], "wechat_menu#id#{$row['id']}"];
                };
            elseif ($row['type'] === 'media_id'):
                $row['media_id'] = $row['content'];
            else :
                $row['key'] = "wechat_menu#id#{$row['id']}";
                !in_array($row['type'], $this->menuType) && $row['type'] = 'click';
            endif;
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
        $wechat = load_wechat('Menu');
        if (false !== $wechat->createMenu(['button' => $menus])) {
            return ['status' => true, 'errmsg' => ''];
        }
        return ['status' => false, 'errmsg' => $wechat->getError()];
    }

}
