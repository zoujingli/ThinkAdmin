<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

return [
    // 模板引擎类型使用 Think
    'type'               => 'Think',
    // 默认模板渲染规则 1.解析为小写+下划线 2.全部转换小写 3.保持操作方法
    'auto_rule'          => 1,
    // 模板目录名
    'view_dir_name'      => 'view',
    // 模板后缀
    'view_suffix'        => 'html',
    // 模板文件名分隔符
    'view_depr'          => DIRECTORY_SEPARATOR,
    // 去除HTML空格换行
    'strip_space'        => true,
    // 模板缓存配置
    'tpl_cache'          => !app()->isDebug(),
    // 模板引擎普通标签开始标记
    'tpl_begin'          => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'            => '}',
    // 标签库标签开始标记
    'taglib_begin'       => '{',
    // 标签库标签结束标记
    'taglib_end'         => '}',
    // 定义模板替换字符串
    'tpl_replace_string' => [
        '__APP__'  => rtrim(url('@')->build(), '\\/'),
        '__ROOT__' => rtrim(dirname(request()->basefile()), '\\/'),
        '__FULL__' => rtrim(dirname(request()->basefile(true)), '\\/'),
    ],
];