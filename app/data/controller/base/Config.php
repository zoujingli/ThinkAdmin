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

namespace app\data\controller\base;

use think\admin\Controller;

/**
 * 应用参数配置
 * Class Config
 * @package app\data\controller\base
 */
class Config extends Controller
{

    /**
     * 微信小程序配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function wxapp()
    {
        $this->skey = 'wxapp';
        $this->title = '微信小程序配置';
        $this->__sysdata('wxapp');
    }

    /**
     * 邀请二维码设置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cropper()
    {
        $this->skey = 'cropper';
        $this->title = '邀请二维码设置';
        $this->__sysdata('cropper');
    }

    /**
     * 显示并保存数据
     * @param string $template 模板文件
     * @param string $history 跳转处理
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function __sysdata(string $template, string $history = '')
    {
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->fetch($template);
        }
        if ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = $this->request->post();
            }
            if (sysdata($this->skey, $data) !== false) {
                $this->success('内容保存成功！', $history);
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }
    }
}