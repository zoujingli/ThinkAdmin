<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
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
use library\Controller;
use think\Db;

/**
 * 微信数据统计
 * Class Index
 * @package app\wechat\controller
 */
class Index extends Controller
{
    /**
     * 微信数据统计
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $map = ['appid' => WechatService::getAppid()];
        $this->totalJson = ['xs' => [], 'ys' => []];
        for ($i = 5; $i >= 0; $i--) {
            $time = strtotime("-{$i} months");
            $where = [['subscribe_at', '<', date('Y-m-32 00:00:00', $time)]];
            $this->totalJson['xs'][] = date('Y年m月', $time);
            $item = ['_0' => 0, '_1' => 0];
            $list = Db::name('WechatFans')->field('count(1) count,is_black black')->where($map)->where($where)->group('is_black')->select();
            foreach ($list as $vo) $item["_{$vo['black']}"] = $vo['count'];
            $this->totalJson['ys']['_0'][] = $item['_0'];
            $this->totalJson['ys']['_1'][] = $item['_1'];
        }
        $this->totalFans = Db::name('WechatFans')->where(['is_black' => '0'])->where($map)->count();
        $this->totalBlack = Db::name('WechatFans')->where(['is_black' => '1'])->where($map)->count();
        $this->totalNews = Db::name('WechatNews')->where(['is_deleted' => '0'])->count();
        $this->totalRule = Db::name('WechatKeys')->count();
        $this->fetch();
    }

}
