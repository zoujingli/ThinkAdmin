<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

$extra = [];
$extra['开发人员或在功能调试时使用，系统异常时会显示详细的错误信息，同时还会记录操作日志及数据库 SQL 语句信息。'] = 'Developers may use it during functional debugging. When there are system exceptions, detailed error messages will be displayed, and operation logs and database SQL statement information will also be recorded.';
$extra['项目正式部署上线后使用，系统异常时统一显示 “%s”，只记录重要的异常日志信息，强烈推荐上线后使用此模式。'] = 'After the project is officially deployed and launched, it will be used. When there are system exceptions, " %s " will be displayed uniformly, and only important exception log information will be recorded. It is strongly recommended to use this mode after launch.';
$extra['旧版本编辑器，对浏览器兼容较好，但内容编辑体验稍有不足。'] = 'The old version of the editor is compatible with browsers, but the content editing experience is slightly insufficient.';
$extra['新版本编辑器，只支持新特性浏览器，对内容编辑体验较好，推荐使用。'] = 'The new version of the editor only supports the new feature browser and has a good experience in content editing. It is recommended to use it.';
$extra['优先使用新版本编辑器，若浏览器不支持新版本时自动降级为旧版本编辑器。'] = 'Priority should be given to using the new version of the editor. If the browser does not support the new version, it will automatically be downgraded to the old version of the editor.';
$extra['文件上传到本地服务器的 `static/upload` 目录，不支持大文件上传，占用服务器磁盘空间，访问时消耗服务器带宽流量。'] = 'Uploading files to the `static/upload` directory of the local server does not support uploading large files, occupying server disk space, and consuming server bandwidth traffic during access.';
$extra['文件上传到 Alist 存储的服务器或云存储空间，根据服务配置可支持大文件上传，不占用本身服务器空间及服务器带宽流量。'] = 'Files can be uploaded to the Alist storage server or Cloud storage space. According to the service configuration, large file upload can be supported without occupying the server space and server bandwidth traffic.';
$extra['文件上传到七牛云存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持 CDN 加速访问，访问量大时推荐使用。'] = 'Files can be uploaded to Qiniu Cloud storage space. It supports large file upload, does not occupy server space and server bandwidth traffic, and supports CDN accelerated access. It is recommended when there is a large amount of access.';
$extra['文件上传到又拍云 USS 存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持 CDN 加速访问，访问量大时推荐使用。'] = "Uploading files to Upyun Cloud's USS storage space supports large file uploads without occupying server space or bandwidth traffic. It supports CDN accelerated access and is recommended for high traffic.";
$extra['文件上传到阿里云 OSS 存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持 CDN 加速访问，访问量大时推荐使用。'] = "Uploading files to Aliyun Cloud's OSS storage space supports large file uploads without occupying server space or bandwidth traffic. It supports CDN accelerated access and is recommended for high traffic.";
$extra['文件上传到腾讯云 COS 存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持 CDN 加速访问，访问量大时推荐使用。'] = "Uploading files to Tencent Cloud's COS storage space supports large file uploads without occupying server space or bandwidth traffic. It supports CDN accelerated access and is recommended for high traffic.";
$extra['网站名称及网站图标，将显示在浏览器的标签上。'] = "The website name and icon will be displayed on the browser's label.";
$extra['管理程序名称，将显示在后台左上角标题。'] = 'The name of the management program will be displayed in the header in the upper left corner of the background.';
$extra['管理程序版本，将显示在后台左上角标题。'] = 'The management program version will be displayed in the top left corner of the background with a title.';
$extra['网站版权信息，在后台登录页面显示版本信息并链接到备案到信息备案管理系统。'] = 'Website copyright information is displayed on the backend login page and linked to the information filing management system.';
$extra['网站备案号，可以在 %s 查询获取，将显示在登录页面下面。'] = 'The website registration number can be found at %s and will be displayed below the login page.';
$extra['公安备案号，可以在 %s 查询获取，将在登录页面下面显示。'] = 'The public security registration number can be obtained by searching at %s and will be displayed below the login page.';
$extra['点击可复制【服务启动指令】'] = "Click to copy the 'Service Start Command'";
$extra['待处理 %s 个任务，处理中 %s 个任务，已完成 %s 个任务，已失败 %s 个任务。'] = 'There are %s tasks to be processed, %s tasks in progress, %s tasks completed, and %s tasks failed.';
$extra['确定要切换到生产模式运行吗？'] = 'Are you sure you want to switch to Production mode?';
$extra['确定要切换到开发模式运行吗？'] = 'Are you sure you want to switch to Development mode?';
$extra["超级管理员账号的密码未修改，建议立即<a data-modal='%s'>修改密码</a>！"] = "The super administrator password has not been changed. Suggest <a data-modal='%s'>changing password</a>.";

$extra['等待处理'] = 'Pending';
$extra['正在处理'] = 'Processing';
$extra['处理完成'] = 'Completed';
$extra['处理失败'] = 'Failed';

$extra['条件搜索'] = 'Search';
$extra['批量删除'] = 'Batch Delete';

$extra['上传进度 %s'] = 'Upload progress %s';
$extra['文件上传出错！'] = 'File upload error.';
$extra['文件上传失败！'] = 'File upload failed.';
$extra['大小超出限制！'] = 'Size exceeds limit.';
$extra['文件秒传成功！'] = 'Successfully transmitted the file in seconds.';
$extra['上传接口异常！'] = 'Abnormal upload interface.';
$extra['文件上传成功！'] = 'File uploaded successfully.';
$extra['图片压缩失败！'] = 'Image compression failed.';
$extra['无效的文件上传对象！'] = 'Invalid file upload object.';

return array_merge($extra, [
    // 系统操作
    '基本资料'                => 'Basic information',
    '安全设置'                => 'Security setting',
    '缓存加速'                => 'Cache acceleration',
    '清理缓存'                => 'Clean cache',
    '配色方案'                => 'Color scheme',
    '立即登录'                => 'Login',
    '退出登录'                => 'Logout',
    '系统提示：'               => 'System Notify: ',
    '清空日志缓存成功！'       => 'Successfully cleared the log cache.',
    '获取任务进度成功！'       => 'Successfully obtained task progress.',
    '网站缓存加速成功！'       => 'Website cache acceleration successful.',
    '请使用超管账号操作！'     => 'Please use a super managed account to operate.',
    '停止任务监听服务成功！'   => 'Successfully stopped task listening service.',
    '任务监听服务启动成功！'   => 'Task monitoring service started successfully.',
    '任务监听服务已经启动！'   => 'The task monitoring service has started.',
    '没有找到需要停止的服务！' => 'No services found that need to be stopped.',
    '已切换后台编辑器！'       => 'Switched to background editor.',
    // 其他搜索器提示
    '请选择登录时间'          => 'Please select the Login time',
    '请选择创建时间'          => 'Please select the creation time',
    '请输入账号或名称'        => 'Please enter an account or name',
    '请输入权限名称'          => 'Please enter the permission name',
    '请输入数据编码'          => 'Please enter the data code',
    '请输入数据名称'          => 'Please enter the data name',
    '请输入文件名称'          => 'Please enter the file name',
    '请输入文件哈希'          => 'Please enter the file hash',
    '请输入操作节点'          => 'Please enter the operate node',
    '请输入操作内容'          => 'Please enter the operate content',
    '请输入访问地址'          => 'Please enter the access Geoip',
    // 系统配置
    '运行模式'                => 'Running Mode',
    '生产模式'                => 'Production mode',
    '开发模式'                => 'Development mode',
    '以开发模式运行'          => 'Running in Development mode',
    '以生产模式运行'          => 'Running in Production mode',
    '清理无效配置'            => 'Clean up Invalid Configurations',
    '修改系统参数'            => 'Modify System Parameters',
    '清理系统配置成功！'       => 'Successfully cleaned.',
    '自适应模式'              => 'Adaptive Mode',
    '富编辑器'                => 'RichText Editor',
    '存储引擎'                => 'Storage Engine',
    '系统参数'                => 'System Parameter',
    '网站名称'                => 'Site Name',
    '管理程序名称'            => 'Program Name',
    '管理程序版本'            => 'Program Version',
    '公安备案号'              => 'Public security registration number',
    '网站备案号'              => 'Website registration number',
    '网站版权信息'            => 'Website copyright information',
    '系统信息'                => 'System Information',
    '应用插件'                => 'Plugin Information',
    '核心框架'                => 'Core Framework',
    '平台框架'                => 'Platform Framework',
    '操作系统'                => 'Operating System',
    '运行环境'                => 'Runtime Environment',
    '仅开发模式可见'          => 'Visible only in Development mode',
    '仅生产模式可见'          => 'Visible only in Production mode',
    '插件名称'                => 'Plugin Name',
    '应用名称'                => 'App Name',
    '插件包名'                => 'Package Name',
    '插件版本'                => 'Plugin Version',
    '授权协议'                => 'License',
    '文件默认存储方式'        => 'Default storage method for file upload',
    '当前系统配置参数'        => 'Current system configuration parameters',
    '仅超级管理员可配置'      => 'Only super administrators can configure',

    // 系统任务管理
    '优化数据库'              => 'Optimize Database',
    '开启服务'                => 'Start Service',
    '关闭服务'                => 'Shutdown Service',
    '定时清理'                => 'Regular cleaning',
    '服务状态'                => 'Service',
    '任务统计'                => 'Total',
    '编号名称'                => 'Name',
    '任务指令'                => 'Command',
    '任务状态'                => 'Status',
    '计划时间'                => 'scheduled time',
    '任务名称'                => 'Name',
    '检查中'                  => 'Checking',
    '任务计划'                => 'Scheduled',
    '重 置'                   => 'Reset',
    '日 志'                   => 'Logs',
    '异 常'                   => 'Abnormal',
    '无权限'                  => 'Denied',
    '已启动'                  => 'Started',
    '未启动'                  => 'Stopped',
    // 数据字典管理
    '数据编码'                => 'Code',
    '数据名称'                => 'Name',
    '操作账号'                => 'User',
    '操作节点'                => "Node",
    '操作行为'                => 'Action',
    '操作内容'                => "Content",
    '访问地址'                => 'Geo IP',
    '网络服务商'              => 'ISP.',
    '日志清理成功！'           => 'Logger Clear Complate.',
    '成功清理所有日志'        => 'Successfully cleared all logs.',
    // 系统文件管理
    '文件名称'                => 'Name',
    '文件哈希'                => "HASH",
    '文件大小'                => "Size",
    '文件后缀'                => 'Exts',
    '存储方式'                => 'Storage Type',
    '清理重复'                => 'Clear Replace',
    '上传方式'                => 'Upload Type',
    '查看文件'                => 'View',
    '文件链接'                => 'Link',
    '秒传'                    => 'Speedy',
    '普通'                    => 'Normal',
    // 系统菜单管理
    '图 标'                   => "Icon",
    '添加菜单'                => 'Add',
    '禁用菜单'                => 'Forbid',
    '激活菜单'                => "Resume",
    '系统菜单'                => 'Menus',
    '菜单名称'                => 'Name',
    '跳转链接'                => 'Link',
    '上级菜单'                => 'Parent',
    '菜单链接'                => 'Link',
    '链接参数'                => 'Params',
    '权限节点'                => "Node",
    '菜单图标'                => 'Icon',
    '选择图标'                => 'Select Icon',
    // 系统权限管理
    "授 权"                   => 'Auth',
    '添加权限'                => 'Add',
    '权限名称'                => "Name",
    '权限描述'                => 'Description',
    '请输入权限描述'          => 'Please enter a permission description',
    // 系统用户管理
    '账号名称'                => 'Username',
    '添加用户'                => 'Add User',
    '最后登录'                => "Last Login Time",
    '头像'                    => "Head",
    '登录账号'                => 'Username',
    '用户名称'                => 'Nickname',
    '登录次数'                => 'Login Times',
    '系统用户'                => 'System User',
    '密 码'                   => 'Password',
    '系统用户管理'            => 'Users',
]);