<?php

namespace app\data\controller;

use app\data\service\GoodsService;
use think\admin\Controller;
use think\admin\extend\DataExtend;

/**
 * 商品分类管理
 * Class ShopGoodsCate
 * @package app\data\controller
 */
class ShopGoodsCate extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopGoodsCate';

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
     * 商品分类管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = "商品分类管理（最大{$this->cateLevel}级）";
        $query = $this->_query($this->table)->like('name')->dateBetween('create_at');
        $query->equal('status')->where(['deleted' => 0])->order('sort desc,id desc')->page(false);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['ids'] = join(',', DataExtend::getArrSubIds($data, $vo['id']));
        }
        $data = DataExtend::arr2table($data);
    }

    /**
     * 添加商品分类
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑商品分类
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
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
            $cates = $this->app->db->name($this->table)->where(['deleted' => 0])->order('sort desc,id desc')->select()->toArray();
            $this->cates = DataExtend::arr2table(array_merge($cates, [['id' => '0', 'pid' => '-1', 'name' => '顶部分类']]));
            if (isset($data['id'])) foreach ($this->cates as $key => $cate) if ($cate['id'] === $data['id']) $data = $cate;
            foreach ($this->cates as $key => $cate) if ($cate['spt'] >= $this->cateLevel || (isset($data['spt']) && $data['spt'] <= $cate['spt'])) {
                unset($this->cates[$key]);
            }
        }
    }

    /**
     * 修改商品分类状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除商品分类
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}