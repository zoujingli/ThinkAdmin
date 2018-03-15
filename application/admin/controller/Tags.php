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

use app\wechat\service\TagsService;
use controller\BasicAdmin;
use service\DataService;
use service\LogService;
use service\WechatService;
use think\Db;

/**
 * 微信粉丝标签管理
 * Class Tags
 * @package app\wechat\controller
 */
class Tags extends BasicAdmin
{

    /**
     * 定义当前默认数据表
     * @var string
     */
    public $table = 'WechatFansTags';

    /**
     * 显示粉丝标签列表
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function index()
    {
        $this->title = '微信粉丝标签管理';
        list($get, $db) = [$this->request->get(), Db::name($this->table)];
        foreach (['name'] as $key) {
            (isset($get[$key]) && $get[$key] !== '') && $db->whereLike($key, "%{$get[$key]}%");
        }
        return parent::_list($db->order('id asc'));
    }

    /**
     * 添加粉丝标签
     * @return array|string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if ($this->request->isGet()) {
            return parent::_form($this->table, 'form', 'id');
        }
        $name = $this->request->post('name', '');
        empty($name) && $this->error('粉丝标签名不能为空!');
        if (Db::name($this->table)->where('name', $name)->count() > 0) {
            $this->error('粉丝标签标签名已经存在, 请使用其它标签名!');
        }
        $wechat = WechatService::tags();
        if (false === ($result = $wechat->createTags($name)) && isset($result['tag'])) {
            $this->error("添加粉丝标签失败. ");
        }
        $result['tag']['count'] = 0;
        if (DataService::save($this->table, $result['tag'], 'id')) {
            $this->success('添加粉丝标签成功!', '');
        }
        $this->error('粉丝标签添加失败, 请稍候再试!');
    }

    /**
     * 编辑粉丝标签
     * @return array|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        // 显示编辑界面
        if ($this->request->isGet()) {
            return parent::_form($this->table, 'form', 'id');
        }
        // 接收提交的数据
        $id = $this->request->post('id', '0');
        $name = $this->request->post('name', '');
        $info = Db::name($this->table)->where(['name' => $name])->find();
        if (!empty($info)) {
            if (intval($info['id']) === intval($id)) {
                $this->error('粉丝标签名没有改变, 无需修改!');
            }
            $this->error('标签已经存在, 使用其它名称再试!');
        }
        try {
            WechatService::tags()->updateTags($id, $name);
            DataService::save($this->table, ['id' => $id, 'name' => $name], 'id');
        } catch (\Exception $e) {
            $this->error('编辑标签失败, 请稍后再试!' . $e->getMessage());
        }
        $this->success('编辑标签成功!', '');
    }


    /**
     * 删除粉丝标签
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        $wechat = WechatService::tags();
        foreach (explode(',', $this->request->post('id', '')) as $id) {
            if ($wechat->deleteTags($id)) {
                Db::name('WechatFansTags')->where(['id' => $id])->delete();
            } else {
                $this->error('移除粉丝标签失败，请稍候再试！');
            }
        }
        $this->success('移除粉丝标签成功！', '');
    }

    /**
     * 同步粉丝标签列表
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function sync()
    {
        Db::name($this->table)->where('1=1')->delete();
        if (TagsService::sync()) {
            LogService::write('微信管理', '同步全部微信粉丝标签成功');
            $this->success('同步获取所有粉丝标签成功!', '');
        }
        $this->error('同步获取粉丝标签失败, 请稍候再!');
    }

}
