<?php

namespace app\data\controller\app;

use app\wechat\service\WechatService;
use think\admin\Controller;

/**
 * 抽奖活动管理
 * Class Luckdraw
 * @package app\data\controller\wap
 */
class Luckdraw extends Controller
{

    /**
     * 当前活动
     * @var array
     */
    protected $vo;

    /**
     * 活动编号
     * @var string
     */
    protected $code;

    /**
     * 当前会员数据
     * @var array
     */
    protected $member;

    /**
     * 当前中奖记录
     * @var array
     */
    protected $record;

    /**
     * 活动规则
     * @var string
     */
    protected $rules;

    /**
     * 控制器初始化
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        $this->code = $this->request->param('code');
        if (empty($this->code)) $this->error('活动编号不能为空！');
        //  微信网页授权
        $this->jsoptin = json_encode(WechatService::instance()->getWebJssdkSign(), 256);
        $this->openid = WechatService::instance()->getWebOauthInfo($this->request->url(true), 0, true)['openid'];
        // 活动数据初始化
        $map = ['code' => $this->code, 'deleted' => 0];
        $this->vo = $this->app->db->name('ActivityLuckdrawConfig')->where($map)->find();
        if (empty($this->vo)) $this->error('活动不存在，请通过邀请二维码进入！');
        // 活动会员信息
        $map = ['openid' => $this->openid];
        $this->member = $this->app->db->name('ActivityLuckdrawMember')->where($map)->find();
        // 会员中奖数据
        $map = ['mid' => $this->member['id'], 'code' => $this->vo['code']];
        $this->record = $this->app->db->name('ActivityLuckdrawRecord')->where($map)->find();
        // 抽奖活动规则
        $this->rules = explode("\n", $this->vo['content']);
    }

    /**
     * 进入活动列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $map = [['prize_code', '<>', ''], ['code', '=', $this->vo['code']]];
        $this->records = $this->app->db->name('ActivityLuckdrawRecord')->where($map)->order('id desc')->select()->toArray();
        foreach ($this->records as &$vo) $vo['username'] = mb_substr($vo['username'], 0, 1) . ' * * ';
        $this->fetch();
    }

    /**
     * 用户信息录入
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function info()
    {
        $data = $this->_vali([
            'openid.value'     => $this->openid,
            'username.require' => '请输入您的姓名！',
            'phone.require'    => '请输入您的手机！',
            'phone.mobile'     => '请输入正确的手机号！',
        ]);
        if (data_save('ActivityLuckdrawMember', $data, 'openid')) {
            $this->success('信息录入成功，可以进行抽奖了！');
        }
        $this->error('信息录入失败，请稍候再试！');
    }

    /**
     * 进行抽奖
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function prize()
    {
        if ($this->record) {
            $this->error('已经参与抽奖，不能再抽奖了！');
        }
        /* 统计已经发出的奖品 */
        $map = ['code' => $this->code];
        [$check, $useds, $rateNumber, $rateRand] = [[], [], 0, rand(1, 1000000) / 10000];
        $query = $this->app->db->name('ActivityLuckdrawRecord')->where($map)->group('prize_code,prize_level');
        $query->field('prize_code,prize_level,count(1) prize_used')->select()->map(function ($item) use (&$useds) {
            $useds["{$item['prize_code']}_{$item['prize_level']}"] = $item['prize_used'];
        });
        /* 统计活动的奖品数据 */
        $query = $this->app->db->name('ActivityLuckdrawConfigRecord')->field('prize_num,prize_rate,prize_level,prize_code');
        /* 计算抽奖的中奖数据 */
        foreach ($query->where($map)->select()->toArray() as $key => $item) {
            $item['prize_used'] = $useds["{$item['prize_code']}_{$item['prize_level']}"] ?? 0;
            if (empty($item['prize_num']) || $item['prize_used'] >= $item['prize_num']) {
                continue;
            } elseif ($rateRand <= ($rateNumber += $item['prize_rate'])) {
                $check = $item;
                break;
            }
        }
        /* 组装活动中奖记录 */
        $data = ['code' => $this->code];
        $data['mid'] = $this->member['id'];
        $data['phone'] = $this->member['phone'];
        $data['username'] = $this->member['username'];
        if (empty($check)) {
            $data['prize_code'] = '';
            $data['prize_level'] = '未中奖';
            if ($this->app->db->name('ActivityLuckdrawRecord')->insert($data) !== false) {
                $this->success('抱歉没有抽到奖品哦！');
            }
        } else {
            $map = ['code' => $check['prize_code'], 'deleted' => 0, 'status' => 1];
            $prize = $this->app->db->name('ActivityLuckdrawPrize')->where($map)->find();
            if (empty($prize)) {
                $this->error('奖品已下架或被禁用！');
            } else {
                $data['prize_code'] = $prize['code'];
                $data['prize_name'] = $prize['name'];
                $data['prize_cover'] = $prize['cover'];
                $data['prize_remark'] = $prize['remark'];
                $data['prize_express'] = $prize['express'];
                $data['prize_level'] = $check['prize_level'];
                if ($this->app->db->name('ActivityLuckdrawRecord')->insert($data) !== false) {
                    $this->success('奖品抽取成功！', $data);
                }
            }
        }
        $this->error('抽奖失败，请稍候再试！');
    }

    /**
     * 奖品记录核销
     * @throws \think\db\exception\DbException
     */
    public function used()
    {
        $map = $this->_vali(['uncode.require' => '奖品核销码不能为空！']);
        if ($this->vo['uncode'] !== $map['uncode']) $this->error('核销码错误，请重新输入！');
        if ($this->vo['uncode_status'] > 0) $this->error('该奖品已经核销，请勿重复核销！');
        $data = ['uncode_code' => $map['uncode'], 'uncode_status' => 1, 'uncode_datatime' => date('Y-m-d H:i:s')];
        $result = $this->app->db->name('ActivityLuckdrawRecord')->where(['id' => $this->record['id']])->update($data);
        $result !== false ? $this->success('奖品核销成功！') : $this->error('奖品核销失败，请稍候再试！');
    }

    /**
     * 提交收货地址
     * @throws \think\db\exception\DbException
     */
    public function express()
    {
        $data = $this->_vali([
            'express_city.require#city'         => '收货城市不能为空！',
            'express_area.require#area'         => '收货区域不能为空！',
            'express_address.require#address'   => '详细地址不能为空！',
            'express_province.require#province' => '收货省份不能为空！',
        ]);
        $result = $this->app->db->name('ActivityLuckdrawRecord')->where(['id' => $this->record['id']])->update($data);
        $result !== false ? $this->success('提交收货地址成功！') : $this->error('提交收货地址失败，请稍候再试！');
    }
}