<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
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
 * Class InputHelper
 * @package library\helper
 */
class InputHelper extends Helper
{
    /**
     * 验证器规则
     * @var array
     */
    protected $rule;

    /**
     * 待验证的数据
     * @var array
     */
    protected $data;

    /**
     * 验证结果消息
     * @var array
     */
    protected $info;

    /**
     * 输入验证器
     * @param array $data
     * @param array $rule
     * @param array $info
     * @return array
     */
    public function init($data, $rule, $info)
    {
        list($this->rule, $this->info) = [$rule, $info];
        $this->data = $this->parse($data);
        $validate = Validate::make($this->rule, $this->info);
        if ($validate->check($this->data)) {
            return $this->data;
        } else {
            $this->controller->error($validate->getError());
        }
    }

    /**
     * 解析输入数据
     * @param array|string $data
     * @param array $result
     * @return array
     */
    private function parse($data, $result = [])
    {
        if (is_array($data)) return $data;
        if (is_string($data)) foreach (explode(',', $data) as $field) {
            if (strpos($field, '#') === false) {
                $array = explode('.', $field);
                $result[end($array)] = input($field);
            } else {
                list($name, $value) = explode('#', $field);
                $array = explode('.', $name);
                $result[end($array)] = input($name, $value);
            }
        }
        return $result;
    }

}