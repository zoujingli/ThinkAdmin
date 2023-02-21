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

use app\data\model\BaseUserDiscount;
use app\data\model\BaseUserPayment;
use app\data\model\BaseUserUpgrade;
use app\data\model\ShopGoods;
use app\data\model\ShopGoodsCate;
use app\data\model\ShopGoodsItem;
use app\data\model\ShopGoodsMark;
use app\data\model\ShopGoodsStock;
use app\data\service\ExpressService;
use app\data\service\GoodsService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;

/**
 * 商品数据管理
 * Class Goods
 * @package app\data\controller\shop
 */
class Goods extends Controller
{
    /**
     * 商品数据管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '商品数据管理';

        $query = ShopGoods::mQuery();
        // 加载对应数据
        $this->type = $this->request->get('type', 'index');
        if ($this->type === 'index') $query->where(['deleted' => 0]);
        elseif ($this->type === 'recycle') $query->where(['deleted' => 1]);
        else $this->error("无法加载 {$this->type} 数据列表！");

        // 列表排序并显示
        $query->like('code|name#name')->like('marks,cateids', ',');
        $query->equal('status,vip_entry,truck_type,rebate_type')->order('sort desc,id desc')->page();
    }

    /**
     * 商品选择器
     * @login true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $query = ShopGoods::mQuery();
        $query->equal('status')->like('code,name,marks')->in('cateids');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _page_filter(array &$data)
    {
        $this->marks = ShopGoodsMark::items();
        $this->cates = ShopGoodsCate::treeTable();
        GoodsService::bindData($data, false);
    }

    /**
     * 添加商品数据
     * @auth true
     */
    public function add()
    {
        $this->mode = 'add';
        $this->title = '添加商品数据';
        ShopGoods::mForm('form', 'code');
    }

    /**
     * 编辑商品数据
     * @auth true
     */
    public function edit()
    {
        $this->mode = 'edit';
        $this->title = '编辑商品数据';
        ShopGoods::mForm('form', 'code');
    }

    /**
     * 复制编辑商品
     * @auth true
     */
    public function copy()
    {
        $this->mode = 'copy';
        $this->title = '复制编辑商品';
        ShopGoods::mForm('form', 'code');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _copy_form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            $data['code'] = CodeExtend::uniqidNumber(20, 'G');
        }
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
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidNumber(20, 'G');
        }
        if ($this->request->isGet()) {
            $data['marks'] = str2arr($data['marks'] ?? '');
            $data['payment'] = str2arr($data['payment'] ?? '');
            $data['cateids'] = str2arr($data['cateids'] ?? '');
            // 其他表单数据
            $this->marks = ShopGoodsMark::items();
            $this->cates = ShopGoodsCate::treeTable(true);
            $this->trucks = ExpressService::templates();
            $this->upgrades = BaseUserUpgrade::items();
            $this->payments = BaseUserPayment::mk()->where(['status' => 1, 'deleted' => 0])->order('sort desc,id desc')->column('type,code,name', 'code');
            $this->discounts = BaseUserDiscount::mk()->where(['status' => 1, 'deleted' => 0])->order('sort desc,id desc')->column('id,name,items', 'id');
            // 商品规格处理
            $fields = 'goods_sku `sku`,goods_code,goods_spec `key`,price_selling `selling`,price_market `market`,number_virtual `virtual`,number_express `express`,reward_balance `balance`,reward_integral `integral`,status';
            $data['data_items'] = json_encode(ShopGoodsItem::mk()->where(['goods_code' => $data['code']])->column($fields, 'goods_spec'), JSON_UNESCAPED_UNICODE);
        } elseif ($this->request->isPost()) {
            if (empty($data['cover'])) $this->error('商品图片不能为空！');
            if (empty($data['slider'])) $this->error('轮播图片不能为空！');
            if (empty($data['payment'])) $this->error('支付方式不能为空！');
            // 商品规格保存
            [$data['price_market'], $data['price_selling']] = [0, 0];
            [$count, $items] = [0, array_column(json_decode($data['data_items'], true), 0)];
            foreach ($items as $item) if ($item['status'] > 0) {
                if ($data['price_market'] === 0 || $data['price_market'] > $item['market']) $data['price_market'] = $item['market'];
                if ($data['price_selling'] === 0 || $data['price_selling'] > $item['selling']) $data['price_selling'] = $item['selling'];
                $count++;
            }
            if (empty($count)) $this->error('无效的的商品价格信息！');
            $data['marks'] = arr2str($data['marks'] ?? []);
            $data['payment'] = arr2str($data['payment'] ?? []);
            ShopGoodsItem::mk()->where(['goods_code' => $data['code']])->update(['status' => 0]);
            foreach ($items as $item) data_save(ShopGoodsItem::class, [
                'goods_sku'       => $item['sku'],
                'goods_spec'      => $item['key'],
                'goods_code'      => $data['code'],
                'price_market'    => $item['market'],
                'price_selling'   => $item['selling'],
                'number_virtual'  => $item['virtual'],
                'number_express'  => $item['express'],
                'reward_balance'  => $item['balance'],
                'reward_integral' => $item['integral'],
                'status'          => $item['status'] ? 1 : 0,
            ], 'goods_spec', [
                'goods_code' => $data['code'],
            ]);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_result(bool $result)
    {
        if ($result && $this->request->isPost()) {
            GoodsService::stock(input('code'));
            $this->success('商品编辑成功！', 'javascript:history.back()');
        }
    }

    /**
     * 商品库存入库
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function stock()
    {
        $map = $this->_vali(['code.require' => '商品编号不能为空哦！']);
        if ($this->request->isGet()) {
            $list = ShopGoods::mk()->where($map)->select()->toArray();
            if (empty($list)) $this->error('无效的商品数据，请稍候再试！');
            [$this->vo] = GoodsService::bindData($list);
            $this->fetch();
        } else {
            [$data, $post, $batch] = [[], $this->request->post(), CodeExtend::uniqidDate(12, 'B')];
            if (isset($post['goods_code']) && is_array($post['goods_code'])) {
                foreach (array_keys($post['goods_code']) as $key) {
                    if ($post['goods_stock'][$key] > 0) $data[] = [
                        'batch_no'    => $batch,
                        'goods_code'  => $post['goods_code'][$key],
                        'goods_spec'  => $post['goods_spec'][$key],
                        'goods_stock' => $post['goods_stock'][$key],
                    ];
                }
                if (!empty($data)) {
                    ShopGoodsStock::mk()->insertAll($data);
                    GoodsService::stock($map['code']);
                    $this->success('商品数据入库成功！');
                }
            }
            $this->error('没有需要商品入库的数据！');
        }
    }

    /**
     * 商品上下架
     * @auth true
     */
    public function state()
    {
        ShopGoods::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]), 'code');
    }

    /**
     * 删除商品数据
     * @auth true
     */
    public function remove()
    {
        ShopGoods::mSave($this->_vali([
            'deleted.in:0,1'  => '状态值范围异常！',
            'deleted.require' => '状态值不能为空！',
        ]), 'code');
    }
}