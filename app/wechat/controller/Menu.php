<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
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
 * 微信菜单管理
 * Class Menu
 * @package app\wechat\controller
 */
class Menu extends Controller
{
    /**
     * 存储数据名称
     * @var string
     */
    protected $ckey = 'wechat_menu_data';

    /**
     * 微信菜单的类型
     * @var array
     */
    protected $menuTypes = [
        'click'              => '匹配规则',
        'view'               => '跳转网页',
        'miniprogram'        => '打开小程序',
        'customservice'      => '转多客服',
        'scancode_push'      => '扫码推事件',
        'scancode_waitmsg'   => '扫码推事件且弹出“消息接收中”提示框',
        'pic_sysphoto'       => '弹出系统拍照发图',
        'pic_photo_or_album' => '弹出拍照或者相册发图',
        'pic_weixin'         => '弹出微信相册发图器',
        'location_select'    => '弹出地理位置选择器',
    ];

    /**
     * 微信菜单管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        if ($this->request->get('output') === 'json') {
            $map = [['keys', 'notin', ['subscribe', 'default']], ['status', '=', 1]];
            $result = $this->app->db->name('WechatKeys')->where($map)->order('sort desc,id desc')->select();
            $this->success('获取数据成功!', ['menudata' => sysdata($this->ckey), 'keysdata' => $result->toArray()]);
        } else {
            $this->title = '微信菜单定制';
            $this->fetch();
        }
    }

    /**
     * 取消微信菜单
     * @auth true
     */
    public function cancel()
    {
        try {
            WechatService::WeChatMenu()->delete();
            $this->success('菜单取消成功，重新订阅可立即生效！');
        } catch (HttpResponseException $exception) {
            sysoplog('微信管理', '取消微信菜单成功');
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("菜单取消失败，请稍候再试！<br> {$exception->getMessage()}");
        }
    }

    /**
     * 编辑微信菜单
     * @auth true
     */
    public function push()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post('data');
            if (empty($data)) try {
                WechatService::WeChatMenu()->delete();
                sysoplog('微信菜单管理', '删除微信菜单成功');
                $this->success('删除微信菜单成功！', '');
            } catch (HttpResponseException $exception) {
                throw $exception;
            } catch (\Exception $exception) {
                sysoplog('微信菜单管理', "删除微信菜单失败：{$exception->getMessage()}");
                $this->error("删除微信菜单失败，请稍候再试！<br>{$exception->getMessage()}");
            } else try {
                sysdata($this->ckey, $this->_buildMenuData(json_decode($data, true)));
                WechatService::WeChatMenu()->create(['button' => sysdata($this->ckey)]);
                sysoplog('微信菜单管理', '发布微信菜单成功');
                $this->success('保存发布菜单成功！', '');
            } catch (HttpResponseException $exception) {
                throw $exception;
            } catch (\Exception $exception) {
                sysoplog('微信菜单管理', "发布微信菜单失败：{$exception->getMessage()}");
                $this->error("微信菜单发布失败，请稍候再试！<br> {$exception->getMessage()}");
            }
        }
    }

    /**
     * 菜单数据处理
     * @param array $list
     * @return array
     */
    private function _buildMenuData(array $list): array
    {
        foreach ($list as $key => &$item) {
            if (empty($item['sub_button'])) {
                $item = $this->_buildMenuDataItem($item);
            } else {
                $button = ['name' => $item['name'], 'sub_button' => []];
                foreach ($item['sub_button'] as &$sub) {
                    $button['sub_button'][] = $this->_buildMenuDataItem($sub);
                }
                $item = $button;
            }
        }
        return $list;
    }

    /**
     * 单个微信菜单数据处理
     * @param array $item
     * @return array
     */
    private function _buildMenuDataItem(array $item): array
    {
        switch (strtolower($item['type'])) {
            case 'pic_weixin':
            case 'pic_sysphoto':
            case 'scancode_push':
            case 'location_select':
            case 'scancode_waitmsg':
            case 'pic_photo_or_album':
                return ['name' => $item['name'], 'type' => $item['type'], 'key' => isset($item['key']) ? $item['key'] : $item['type']];
            case 'click':
                if (empty($item['key'])) $this->error('匹配规则存在空的选项');
                return ['name' => $item['name'], 'type' => $item['type'], 'key' => $item['key']];
            case 'view':
                return ['name' => $item['name'], 'type' => $item['type'], 'url' => $item['url']];
            case 'miniprogram':
                return ['name' => $item['name'], 'type' => $item['type'], 'url' => $item['url'], 'appid' => $item['appid'], 'pagepath' => $item['pagepath']];
            default:
                return [];
        }
    }

}
