<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\helper;

use think\admin\Helper;
use think\admin\service\TokenService;
use think\exception\HttpResponseException;

/**
 * 表单令牌验证器
 * Class TokenHelper
 * @package think\admin\helper
 */
class TokenHelper extends Helper
{
    /**
     * 获取当前令牌值
     * @var string
     */
    protected $token;

    /**
     * 初始化验证码器
     * @param boolean $return
     * @return boolean
     */
    public function init($return = false)
    {
        $this->class->csrf_state = true;
        $this->token = $this->app->request->header('user-form-token', input('_csrf_', ''));
        if ($this->app->request->isPost() && !TokenService::instance($this->app)->checkFormToken($this->token)) {
            if ($return) return false;
            $this->class->error($this->class->csrf_message);
        } else {
            return true;
        }
    }

    /**
     * 清理表单令牌
     */
    public function clear()
    {
        $this->token = $this->app->request->header('user-form-token', input('_csrf_', ''));
        if (!empty($this->token)) TokenService::instance($this->app)->clearFormToken($this->token);
    }

    /**
     * 返回视图内容
     * @param string $tpl 模板名称
     * @param array $vars 模板变量
     * @param string $node CSRF授权节点
     */
    public function fetchTemplate($tpl = '', $vars = [], $node = null)
    {
        throw new HttpResponseException(view($tpl, $vars, 200, function ($html) use ($node) {
            return preg_replace_callback('/<\/form>/i', function () use ($node) {
                $csrf = TokenService::instance($this->app)->buildFormToken($node);
                return "<input type='hidden' name='_token_' value='{$csrf['token']}'></form>";
            }, $html);
        }));
    }

}