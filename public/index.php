<?php

declare(strict_types=1);
/**
 * // +----------------------------------------------------------------------
 * // | Payment Plugin for ThinkAdmin
 * // +----------------------------------------------------------------------
 * // | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * // +----------------------------------------------------------------------
 * // | 官方网站: https://thinkadmin.top
 * // +----------------------------------------------------------------------
 * // | 开源协议 ( https://mit-license.org )
 * // | 免责声明 ( https://thinkadmin.top/disclaimer )
 * // | 会员免费 ( https://thinkadmin.top/vip-introduce )
 * // +----------------------------------------------------------------------
 * // | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * // | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * // +----------------------------------------------------------------------
 */
use think\admin\service\RuntimeService;

// 加载基础文件
require __DIR__ . '/../vendor/autoload.php';

// WEB应用初始化
RuntimeService::doWebsiteInit();
