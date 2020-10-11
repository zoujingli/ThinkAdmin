<?php

namespace app\data\controller;

use app\wechat\service\WechatService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;

/**
 * 抽奖活动配置
 * Class LuckdrawConfig
 * @package app\data\controller
 */
class LuckdrawConfig extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'ActivityLuckdrawConfig';

    /**
     * 抽奖活动配置
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
        if ($this->request->get('action') === 'qrc') try {
            [$wechat, $code] = [WechatService::WeChatQrcode(), $this->request->get('code', '')];
            $short = $wechat->shortUrl(url("@data/app.luckdraw/index/code/{$code}", [], true, true)->build());
            $result = $wechat->create("reply#text:活动地址：\n{$short['short_url']}");
            $this->success('生成二维码成功！', "javascript:$.previewImage('{$wechat->url($result['ticket'])}')");
        } catch (\think\exception\HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("生成二维码失败，请稍候再试！<br> {$exception->getMessage()}");
        }
        $this->title = '抽奖活动管理';
        $query = $this->_query($this->table)->like('code,name')->equal('status');
        $query->dateBetween('create_at')->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 添加抽奖活动
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->title = '添加抽奖活动';
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 编辑抽奖活动
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->title = '编辑抽奖活动';
        $this->_form($this->table, 'form', 'code');
    }

    /**
     * 表单数据处理
     * @param array $vo
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _form_filter(array &$vo)
    {
        $vo['code'] = $vo['code'] ?? CodeExtend::uniqidDate(16, 'A');
        if ($this->request->isGet()) {
            $this->prizes = $this->app->db->name('ActivityLuckdrawPrize')->where(['deleted' => 0, 'status' => 1])->select()->toArray();
            $this->selectPrizes = $this->app->db->name('ActivityLuckdrawConfigRecord')->where(['code' => $vo['code']])->select()->toArray();
        } elseif ($this->request->isPost()) {
            [$post, $records] = [$this->request->post(), []];
            if (empty($post['cover'])) $this->error('活动图片不能为空！');
            if (empty($post['prize_code']) || !is_array($post['prize_code'])) $this->error('请配置奖品信息！');
            $prizes = $this->app->db->name('ActivityLuckdrawPrize')->whereIn('code', $post['prize_code'])->select();
            foreach (array_keys($post['prize_code']) as $key) foreach ($prizes as $pz) {
                if (intval($pz['code']) === intval($post['prize_code'][$key])) $records[] = [
                    'code'        => $vo['code'],
                    'prize_code'  => $pz['code'],
                    'prize_name'  => $pz['name'],
                    'prize_cover' => $pz['cover'],
                    'prize_num'   => $post['prize_num'][$key],
                    'prize_rate'  => $post['prize_rate'][$key],
                    'prize_level' => $post['prize_level'][$key],
                ];
            }
            $this->app->db->name('ActivityLuckdrawConfigRecord')->where(['code' => $vo['code']])->delete();
            $this->app->db->name('ActivityLuckdrawConfigRecord')->insertAll($records);
        }
    }

    /**
     * 保存成功后的处理
     * @param boolean $result
     */
    protected function _form_result(bool $result)
    {
        if ($result) {
            $this->success('活动配置成功!', 'javascript:history.back()');
        }
    }

    /**
     * 修改活动状态
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
     * 删除抽奖活动
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}