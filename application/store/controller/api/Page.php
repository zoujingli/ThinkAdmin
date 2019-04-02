<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\controller\api;

use library\Controller;
use think\Db;

/**
 * 页面接口管理
 * Class Page
 * @package app\store\controller\api
 */
class Page extends Controller
{

    /**
     * 获取微信商品首页
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function gets()
    {
        $list = Db::name('StorePage')->field('title,type,one,mul')->where(['status' => '1'])->order('sort asc,id desc')->select();
        foreach ($list as &$vo) {
            $vo['one'] = json_decode($vo['one'], true);
            $vo['mul'] = json_decode($vo['mul'], true);
            if ($vo['type'] === 'one') unset($vo['mul']);
            if ($vo['type'] === 'mul') unset($vo['one']);
        }
        $this->success('获取页面列表成功！', ['list' => $this->build($list)]);
    }

    /**
     * 数据列表处理
     * @param array $data
     * @param array $goodsId
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function build($data = [], $goodsId = [])
    {
        foreach ($data as $vo) if (isset($vo['mul'])) {
            $goodsId = array_unique(array_merge($goodsId, $vo['mul']['goods']));
        }
        $goodsList = Db::name('StoreGoods')->field('id,title,logo')->whereIn('id', $goodsId)->select();
        $field = 'goods_id,goods_spec,price_market,price_selling,number_sales,number_stock,number_virtual';
        $goodsLists = Db::name('StoreGoodsList')->field($field)->where(['status' => '1'])->whereIn('goods_id', $goodsId)->select();
        foreach ($goodsList as &$vo) {
            $vo['list'] = [];
            foreach ($goodsLists as $v) if ($vo['id'] === $v['goods_id']) $vo['list'][] = $v;
        }
        foreach ($data as &$vo) if (isset($vo['mul'])) {
            foreach ($vo['mul']['goods'] as &$g) foreach ($goodsList as $v) if ($g == $v['id']) $g = $v;
        }
        return $data;
    }
}