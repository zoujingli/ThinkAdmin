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

namespace app\data\controller\shop;

use app\data\model\ShopGoodsCate;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;

/**
 * 商品分类管理
 * Class Cate
 * @package app\data\controller\shop
 */
class Cate extends Controller
{
    /**
     * 最大级别
     * @var integer
     */
    protected $maxLevel = 5;

    /**
     * 商品分类管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        ShopGoodsCate::mQuery()->layTable(function () {
            $this->title = "商品分类管理";
        }, function (QueryHelper $query) {
            $query->where(['deleted' => 0]);
            $query->like('name')->equal('status')->dateBetween('create_at');
        });
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        $data = DataExtend::arr2table($data);
    }

    /**
     * 添加商品分类
     * @auth true
     */
    public function add()
    {
        ShopGoodsCate::mForm('form');
    }

    /**
     * 编辑商品分类
     * @auth true
     */
    public function edit()
    {
        ShopGoodsCate::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isGet()) {
            $data['pid'] = intval($data['pid'] ?? input('pid', '0'));
            $this->cates = ShopGoodsCate::getParentData($this->maxLevel, $data, [
                'id' => '0', 'pid' => '-1', 'name' => '顶部分类',
            ]);
        }
    }

    /**
     * 修改商品分类状态
     * @auth true
     */
    public function state()
    {
        ShopGoodsCate::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除商品分类
     * @auth true
     */
    public function remove()
    {
        ShopGoodsCate::mDelete();
    }
}