<?php

namespace app\data\controller;

use app\data\service\GoodsService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;

/**
 * 商品数据管理
 * Class ShopGoods
 * @package app\data\controller
 */
class ShopGoods extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopGoods';

    /**
     * 最大分类级别
     * @var integer
     */
    protected $cateLevel;

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        $this->cateLevel = GoodsService::instance()->getCateLevel();
    }

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
        $query = $this->_query($this->table);
        // 加载对应数据
        $this->type = $this->request->get('type', 'index');
        if ($this->type === 'index') $query->where(['deleted' => 0]);
        elseif ($this->type === 'recycle') $query->where(['deleted' => 1]);
        else $this->error("无法加载 {$this->type} 数据列表！");
        // 列表排序并显示
        $query->like('code,name,mark')->equal('status,cate');
        $query->order('sort desc,id desc')->page();
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
        $query = $this->_query($this->table);
        $query->equal('status,cate')->like('code,name,mark');
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
        $this->marks = GoodsService::instance()->getMarkList();
        $this->clist = GoodsService::instance()->getCateList('arr2table');
        $clist = $this->app->db->name('ShopGoodsCate')->whereIn('id', array_column($data, 'cate'))->column('pid,name,status', 'id');
        foreach ($data as &$vo) {
            $vo['cate'] = $clist[$vo['cate']] ?? $vo['cate'];
            $vo['mark'] = str2arr($vo['mark'] ?: '', ',', $this->marks);
        }
    }

    /**
     * 添加商品数据
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->mode = 'add';
        $this->title = '添加商品数据';
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 编辑商品数据
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->mode = 'edit';
        $this->title = '编辑商品数据';
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 复制编辑商品
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function copy()
    {
        $this->mode = 'copy';
        $this->title = '复制编辑商品';
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _copy_form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            $data['code'] = CodeExtend::uniqidNumber(14, 'G');
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
            $data['code'] = CodeExtend::uniqidNumber(14, 'G');
        }
        if ($this->request->isGet()) {
            $data['mark'] = str2arr($data['mark'] ?? '');
            [$this->marks, $this->cates] = [GoodsService::instance()->getMarkList(), GoodsService::instance()->getCateList('arr2table')];
            $fields = 'goods_sku `sku`,goods_code,goods_spec `key`,price_selling `selling`,price_market `market`,number_virtual `virtual`,number_express `express`,status';
            $data['data_items'] = json_encode($this->app->db->name('ShopGoodsItem')->where(['goods_code' => $data['code']])->column($fields, 'goods_spec'), JSON_UNESCAPED_UNICODE);
            $data['truck_items'] = $this->app->db->name('ShopTruckTemplate')->where(['status' => 1, 'deleted' => 0])->order('sort desc,id desc')->column('code,name');
        } elseif ($this->request->isPost()) {
            if (empty($data['cover'])) $this->error('商品图片不能为空！');
            if (empty($data['slider'])) $this->error('轮播图不能为空！');
            // 商品规格保存
            $data['mark'] = arr2str($data['mark'] ?? []);
            [$count, $items] = [0, json_decode($data['data_items'], true)];
            foreach ($items as $item) {
                $count += intval($item[0]['status']);
                if (empty($data['price_market'])) $data['price_market'] = $item[0]['market'];
            }
            if (empty($count)) $this->error('无效的的商品价格信息！');
            $this->app->db->name('ShopGoodsItem')->where(['goods_code' => $data['code']])->update(['status' => 0]);
            foreach ($items as $item) data_save('ShopGoodsItem', [
                'goods_code'     => $data['code'],
                'goods_sku'      => $item[0]['sku'],
                'goods_spec'     => $item[0]['key'],
                'price_market'   => $item[0]['market'],
                'price_selling'  => $item[0]['selling'],
                'number_virtual' => $item[0]['virtual'],
                'number_express' => $item[0]['express'],
                'status'         => $item[0]['status'] ? 1 : 0,
            ], 'goods_spec', ['goods_code' => $data['code']]);
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
            GoodsService::instance()->syncStock(input('code'));
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
            $list = $this->app->db->name('ShopGoods')->where($map)->select()->toArray();
            if (empty($list)) $this->error('无效的商品数据，请稍候再试！');
            [$this->vo] = GoodsService::instance()->buildItemData($list);
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
                    $this->app->db->name('ShopGoodsStock')->insertAll($data);
                    GoodsService::instance()->syncStock($map['code']);
                    $this->success('商品数据入库成功！');
                }
            }
            $this->error('没有需要商品入库的数据！');
        }
    }

    /**
     * 商品上下架
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]), 'code');
    }

    /**
     * 删除商品数据
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_save($this->table, $this->_vali([
            'deleted.in:0,1'  => '状态值范围异常！',
            'deleted.require' => '状态值不能为空！',
        ]), 'code');
    }

}