<?php

// +----------------------------------------------------------------------
// | Static Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-static
// | github 代码仓库：https://github.com/zoujingli/think-plugs-static
// +----------------------------------------------------------------------

return [
    // 模板引擎类型使用 Think
    'type'           => 'Think',
    // 默认模板渲染规则 1.解析为小写+下划线 2.全部转换小写 3.保持操作方法
    'auto_rule'      => 1,
    // 模板目录名
    'view_dir_name'  => 'view',
    // 模板文件后缀
    'view_suffix'    => 'html',
    // 模板文件名分隔符
    'view_depr'      => DIRECTORY_SEPARATOR,
    // 模板缓存配置
    'tpl_cache'      => isOnline(),
    // 模板引擎标签开始标记
    'tpl_begin'      => '{',
    // 模板引擎标签结束标记
    'tpl_end'        => '}',
    // 标签库标签开始标记
    'taglib_begin'   => '{',
    // 标签库标签结束标记
    'taglib_end'     => '}',
    // 去除HTML空格换行
    'strip_space'    => true,
    // 标签默认过滤输出方法
    'default_filter' => 'htmlentities=###,ENT_QUOTES',
];