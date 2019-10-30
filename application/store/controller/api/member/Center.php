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

namespace app\store\controller\api\member;

use app\store\controller\api\Member;
use app\store\service\ExtendService;
use think\Db;

/**
 * 商品会员中心
 * Class Center
 * @package app\store\controller\api\member
 */
class Center extends Member
{
    /**
     * 修改会员资料
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function info()
    {
        $data = [];
        if ($this->request->has('headimg', 'post', true)) {
            $data['headimg'] = $this->request->post('headimg');
        }
        if ($this->request->has('nickname', 'post', true)) {
            $data['nickname'] = $this->request->post('nickname');
        }
        if ($this->request->has('username', 'post', true)) {
            $data['username'] = $this->request->post('username');
        }
        if (empty($data)) $this->error('没有需要修改的数据哦！');
        if (data_save('StoreMember', array_merge($data, ['id' => $this->mid]), 'id') !== false) {
            $this->success('会员资料更新成功！', $this->getMember());
        } else {
            $this->error('会员资料更新失败，请稍候再试！');
        }
    }

    /**
     * 发送短信验证码
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function sendsms()
    {
        $phone = $this->request->post('phone');
        if ($this->request->post('secure') !== sysconf('sms_secure')) {
            $this->error('短信发送安全码不正确，请使用正确的安全码！');
        }
        $member = Db::name('StoreMember')->where(['phone' => $phone])->find();
        if (!empty($member)) $this->error('该手机号已经注册了，请使用其它手机号！');
        $cache = cache($cachekey = "send_register_sms_{$phone}");
        if (is_array($cache) && isset($cache['time']) && $cache['time'] > time() - 120) {
            $dtime = ($cache['time'] + 120 < time()) ? 0 : (120 - time() + $cache['time']);
            $this->success('短信验证码已经发送！', ['time' => $dtime]);
        }
        list($code, $content) = [rand(1000, 9999), sysconf('sms_reg_template')];
        if (empty($content) || stripos($content, '{code}') === false) {
            $content = '您的验证码为{code}，请在十分钟内完成操作！';
        }
        cache($cachekey, ['phone' => $phone, 'captcha' => $code, 'time' => time()], 600);
        if (empty($content) || strpos($content, '{code}') === false) {
            $this->error('获取短信模板失败，联系管理员配置！');
        }
        $cache = cache($cachekey);
        if (ExtendService::sendChinaSms($this->mid, $phone, str_replace('{code}', $code, $content))) {
            $dtime = ($cache['time'] + 120 < time()) ? 0 : (120 - time() + $cache['time']);
            $this->success('短信验证码发送成功！', ['time' => $dtime]);
        } else {
            $this->error('短信发送失败，请稍候再试！');
        }
    }

    /**
     * 会员登录绑定
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function bind()
    {
        $code = $this->request->post('code');
        $phone = $this->request->post('phone');
        $cache = cache($cachekey = "send_register_sms_{$phone}");
        if (is_array($cache) && isset($cache['captcha']) && $cache['captcha'] == $code) {
            $where = ['id' => $this->member['id']];
            if (Db::name('StoreMember')->where($where)->update(['phone' => $phone]) !== false) {
                $this->success('手机绑定登录成功！');
            } else {
                $this->error('手机绑定登录失败，请稍候再试！');
            }
        } else {
            $this->error('短信验证码验证失败！');
        }
    }

    /**
     * 获取会员资源成功
     */
    public function member()
    {
        $this->success('获取会员资料成功！', $this->member);
    }

}
