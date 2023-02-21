<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\controller\api;

use app\data\model\ShopGoods;
use app\data\model\ShopGoodsCate;
use app\data\model\ShopGoodsMark;
use app\data\service\ExpressService;
use app\data\service\GoodsService;
use think\admin\Controller;

/**
 * 商品数据接口
 * Class Goods
 * @package app\data\controller\api
 */
class Goods extends Controller
{
    /**
     * 获取分类数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCate()
    {
        $this->success('获取分类成功', ShopGoodsCate::treeData());
    }

    /**
     * 获取标签数据
     */
    public function getMark()
    {
        $this->success('获取标签成功', ShopGoodsMark::items());
    }

    /**
     * 获取商品数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGoods()
    {
        // 更新访问统计
        $map = $this->_vali(['code.default' => '']);
        if ($map['code']) ShopGoods::mk()->where($map)->inc('num_read')->update([]);
        // 商品数据处理
        $query = ShopGoods::mQuery()->like('name,marks,cateids,payment')->equal('code,vip_entry');
        $result = $query->where(['deleted' => 0, 'status' => 1])->order('sort desc,id desc')->page(true, false, false, 10);
        if (count($result['list']) > 0) GoodsService::bindData($result['list']);
        $this->success('获取商品数据', $result);
    }

    /**
     *  获取配送区域
     */
    public function getRegion()
    {
        $this->success('获取区域成功', ExpressService::region(3, 1));
    }
}