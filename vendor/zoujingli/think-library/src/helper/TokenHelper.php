<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\helper;

use library\Helper;
use library\service\TokenService;
use think\exception\HttpResponseException;

/**
 * Class TokenHelper
 * @package library\helper
 */
class TokenHelper extends Helper
{
    /**
     * 初始化验证码器
     * @param boolean $return
     * @return boolean
     */
    public function init($return = false)
    {
        $this->controller->csrf_state = true;
        if ($this->app->request->isPost() && !TokenService::instance()->checkFormToken()) {
            if ($return) return false;
            $this->controller->error($this->controller->csrf_message);
        } else {
            return true;
        }
    }

    /**
     * 清理表单令牌
     */
    public function clear()
    {
        TokenService::instance()->clearFormToken();
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
                $csrf = TokenService::instance()->buildFormToken($node);
                return "<input type='hidden' name='_token_' value='{$csrf['token']}'></form>";
            }, $html);
        }));
    }
}