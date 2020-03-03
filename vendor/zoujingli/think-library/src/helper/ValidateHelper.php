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
use think\Validate;

/**
 * 快捷输入验证器
 * Class ValidateHelper
 * @package library\helper
 */
class ValidateHelper extends Helper
{
    /**
     * 快捷输入并验证（ 支持 规则 # 别名 ）
     * @param array $rules 验证规则（ 验证信息数组 ）
     * @param string $type 输入方式 ( post. 或 get. )
     * @return array
     */
    public function init(array $rules, $type = '')
    {
        list($data, $rule, $info) = [[], [], []];
        foreach ($rules as $name => $message) {
            if (stripos($name, '#') !== false) {
                list($name, $alias) = explode('#', $name);
            }
            if (stripos($name, '.') === false) {
                if (is_numeric($name)) {
                    $keys = $message;
                    if (is_string($message) && stripos($message, '#') !== false) {
                        list($name, $alias) = explode('#', $message);
                        $keys = empty($alias) ? $name : $alias;
                    }
                    $data[$name] = input("{$type}{$keys}");
                } else {
                    $data[$name] = $message;
                }
            } else {
                list($_rgx) = explode(':', $name);
                list($_key, $_rule) = explode('.', $name);
                $keys = empty($alias) ? $_key : $alias;
                $info[$_rgx] = $message;
                $data[$_key] = input("{$type}{$keys}");
                $rule[$_key] = empty($rule[$_key]) ? $_rule : "{$rule[$_key]}|{$_rule}";
            }
        }
        $validate = new Validate();
        if ($validate->rule($rule)->message($info)->check($data)) {
            return $data;
        } else {
            $this->controller->error($validate->getError());
        }
    }
}