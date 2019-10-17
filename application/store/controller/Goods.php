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

namespace app\store\controller;

use library\Controller;
use library\tools\Data;
use think\Db;

/**
 * 商品信息管理
 * Class Goods
 * @package app\store\controller
 */
class Goods extends Controller
{
    /**
     * 指定数据表
     * @var string
     */
    protected $table = 'StoreGoods';

    /**
     * 商品信息管理
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
        $this->title = '商品信息管理';
        $query = $this->_query($this->table)->equal('status,cate_id')->like('title');
        $query->where(['is_deleted' => '0'])->order('sort desc,id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _index_page_filter(&$data)
    {
        $this->clist = Db::name('StoreGoodsCate')->where(['is_deleted' => '0', 'status' => '1'])->select();
        $list = Db::name('StoreGoodsList')->where('status', '1')->whereIn('goods_id', array_unique(array_column($data, 'id')))->select();
        foreach ($data as &$vo) {
            list($vo['list'], $vo['cate']) = [[], []];
            foreach ($list as $goods) if ($goods['goods_id'] === $vo['id']) array_push($vo['list'], $goods);
            foreach ($this->clist as $cate) if ($cate['id'] === $vo['cate_id']) $vo['cate'] = $cate;
        }
    }

    /**
     * 商品库存入库
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function stock()
    {
        if ($this->request->isGet()) {
            $GoodsId = $this->request->get('id');
            $goods = Db::name('StoreGoods')->where(['id' => $GoodsId])->find();
            empty($goods) && $this->error('无效的商品信息，请稍候再试！');
            $goods['list'] = Db::name('StoreGoodsList')->where(['goods_id' => $GoodsId])->select();
            $this->fetch('', ['vo' => $goods]);
        } else {
            list($post, $data) = [$this->request->post(), []];
            if (isset($post['id']) && isset($post['goods_id']) && is_array($post['goods_id'])) {
                foreach (array_keys($post['goods_id']) as $key) if ($post['goods_number'][$key] > 0) array_push($data, [
                    'goods_id'     => $post['goods_id'][$key],
                    'goods_spec'   => $post['goods_spec'][$key],
                    'number_stock' => $post['goods_number'][$key],
                ]);
                if (!empty($data)) {
                    Db::name('StoreGoodsStock')->insertAll($data);
                    \app\store\service\GoodsService::syncStock($post['id']);
                    $this->success('商品信息入库成功！');
                }
            }
            $this->error('没有需要商品入库的数据！');
        }
    }

    /**
     * 添加商品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        $this->title = '添加商品信息';
        $this->isAddMode = '1';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑商品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $this->title = '编辑商品信息';
        $this->isAddMode = '0';
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _form_filter(&$data)
    {
        // 生成商品ID
        if (empty($data['id'])) $data['id'] = Data::uniqidNumberCode(14);
        if ($this->request->isGet()) {
            $fields = 'goods_spec,goods_id,status,price_market market,price_selling selling,number_virtual `virtual`,number_express express';
            $defaultValues = Db::name('StoreGoodsList')->where(['goods_id' => $data['id']])->column($fields);
            $this->defaultValues = json_encode($defaultValues, JSON_UNESCAPED_UNICODE);
            $this->cates = Db::name('StoreGoodsCate')->where(['is_deleted' => '0', 'status' => '1'])->order('sort desc,id desc')->select();
        } elseif ($this->request->isPost()) {
            if (empty($data['logo'])) $this->error('商品LOGO不能为空，请上传图片');
            if (empty($data['image'])) $this->error('商品展示图片不能为空，请上传图片');
            Db::name('StoreGoodsList')->where(['goods_id' => $data['id']])->update(['status' => '0']);
            foreach (json_decode($data['lists'], true) as $vo) Data::save('StoreGoodsList', [
                'goods_id'       => $data['id'],
                'goods_spec'     => $vo[0]['key'],
                'price_market'   => $vo[0]['market'],
                'price_selling'  => $vo[0]['selling'],
                'number_virtual' => $vo[0]['virtual'],
                'number_express' => $vo[0]['express'],
                'status'         => $vo[0]['status'] ? 1 : 0,
            ], 'goods_spec', ['goods_id' => $data['id']]);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _form_result($result)
    {
        if ($result && $this->request->isPost()) {
            $this->success('商品编辑成功！', 'javascript:history.back()');
        }
    }

    /**
     * 禁用商品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用商品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 删除商品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
