<?php

declare(strict_types=1);
/**
 * +----------------------------------------------------------------------
 * | ThinkAdmin Plugin for ThinkAdmin
 * +----------------------------------------------------------------------
 * | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * +----------------------------------------------------------------------
 * | 官方网站: https://thinkadmin.top
 * +----------------------------------------------------------------------
 * | 开源协议 ( https://mit-license.org )
 * | 免责声明 ( https://thinkadmin.top/disclaimer )
 * | 会员特权 ( https://thinkadmin.top/vip-introduce )
 * +----------------------------------------------------------------------
 * | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * +----------------------------------------------------------------------
 */
$extra = [];
$extra['开发人员或在功能调试时使用，系统异常时会显示详细的错误信息，同时还会记录操作日志及数据库 SQL 语句信息。'] = 'Developers may use it during functional debugging. When there are system exceptions, detailed error messages will be displayed, and operation logs and database SQL statement information will also be recorded.';
$extra['项目正式部署上线后使用，系统异常时统一显示 “%s”，只记录重要的异常日志信息，强烈推荐上线后使用此模式。'] = 'After the project is officially deployed and launched, it will be used. When there are system exceptions, " %s " will be displayed uniformly, and only important exception log information will be recorded. It is strongly recommended to use this mode after launch.';
$extra['旧版本编辑器，对浏览器兼容较好，但内容编辑体验稍有不足。'] = 'The old version of the editor is compatible with browsers, but the content editing experience is slightly insufficient.';
$extra['新版本编辑器，只支持新特性浏览器，对内容编辑体验较好，推荐使用。'] = 'The new version of the editor only supports the new feature browser and has a good experience in content editing. It is recommended to use it.';
$extra['国产优质富文本编辑器，对于小程序及App内容支持会更友好，推荐使用。'] = 'A high-quality Chinese rich text editor that provides better support for mini-programs and App content. Recommended for use.';
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
    '基本资料' => 'Basic information',
    '安全设置' => 'Security setting',
    '缓存加速' => 'Cache acceleration',
    '清理缓存' => 'Clean cache',
    '配色方案' => 'Color scheme',
    '立即登录' => 'Login',
    '退出登录' => 'Logout',
    '系统提示：' => 'System Notify: ',
    '清空日志缓存成功！' => 'Successfully cleared the log cache.',
    '获取任务进度成功！' => 'Successfully obtained task progress.',
    '网站缓存加速成功！' => 'Website cache acceleration successful.',
    '请使用超管账号操作！' => 'Please use a super managed account to operate.',
    '停止任务监听服务成功！' => 'Successfully stopped task listening service.',
    '任务监听服务启动成功！' => 'Task monitoring service started successfully.',
    '任务监听服务已经启动！' => 'The task monitoring service has started.',
    '没有找到需要停止的服务！' => 'No services found that need to be stopped.',
    '已切换后台编辑器！' => 'Switched to background editor.',
    // 其他搜索器提示
    '请选择登录时间' => 'Please select the Login time',
    '请选择创建时间' => 'Please select the creation time',
    '请输入账号或名称' => 'Please enter an account or name',
    '请输入权限名称' => 'Please enter the permission name',
    '请输入数据编码' => 'Please enter the data code',
    '请输入数据名称' => 'Please enter the data name',
    '请输入文件名称' => 'Please enter the file name',
    '请输入文件哈希' => 'Please enter the file hash',
    '请输入操作节点' => 'Please enter the operate node',
    '请输入操作内容' => 'Please enter the operate content',
    '请输入访问地址' => 'Please enter the access Geoip',
    // 系统配置
    '运行模式' => 'Running Mode',
    '生产模式' => 'Production mode',
    '开发模式' => 'Development mode',
    '以开发模式运行' => 'Running in Development mode',
    '以生产模式运行' => 'Running in Production mode',
    '清理无效配置' => 'Clean up Invalid Configurations',
    '修改系统参数' => 'Modify System Parameters',
    '清理系统配置成功！' => 'Successfully cleaned.',
    '自适应模式' => 'Adaptive Mode',
    '富编辑器' => 'RichText Editor',
    '存储引擎' => 'Storage Engine',
    '系统参数' => 'System Parameter',
    '网站名称' => 'Site Name',
    '管理程序名称' => 'Program Name',
    '管理程序版本' => 'Program Version',
    '公安备案号' => 'Public security registration number',
    '网站备案号' => 'Website registration number',
    '网站版权信息' => 'Website copyright information',
    '系统信息' => 'System Information',
    '应用插件' => 'Plugin Information',
    '核心框架' => 'Core Framework',
    '平台框架' => 'Platform Framework',
    '操作系统' => 'Operating System',
    '运行环境' => 'Runtime Environment',
    '仅开发模式可见' => 'Visible only in Development mode',
    '仅生产模式可见' => 'Visible only in Production mode',
    '插件名称' => 'Plugin Name',
    '应用名称' => 'App Name',
    '插件包名' => 'Package Name',
    '插件版本' => 'Plugin Version',
    '授权协议' => 'License',
    '文件默认存储方式' => 'Default storage method for file upload',
    '当前系统配置参数' => 'Current system configuration parameters',
    '仅超级管理员可配置' => 'Only super administrators can configure',

    // 系统任务管理
    '优化数据库' => 'Optimize Database',
    '开启服务' => 'Start Service',
    '关闭服务' => 'Shutdown Service',
    '定时清理' => 'Regular cleaning',
    '服务状态' => 'Service',
    '任务统计' => 'Total',
    '编号名称' => 'Name',
    '任务指令' => 'Command',
    '任务状态' => 'Status',
    '计划时间' => 'scheduled time',
    '任务名称' => 'Name',
    '检查中' => 'Checking',
    '任务计划' => 'Scheduled',
    '重 置' => 'Reset',
    '日 志' => 'Logs',
    '异 常' => 'Abnormal',
    '无权限' => 'Denied',
    '已启动' => 'Started',
    '未启动' => 'Stopped',
    // 数据字典管理
    '数据编码' => 'Code',
    '数据名称' => 'Name',
    '操作账号' => 'User',
    '操作节点' => 'Node',
    '操作行为' => 'Action',
    '操作内容' => 'Content',
    '访问地址' => 'Geo IP',
    '网络服务商' => 'ISP.',
    '日志清理成功！' => 'Logger Clear Complate.',
    '成功清理所有日志' => 'Successfully cleared all logs.',
    // 系统文件管理
    '文件名称' => 'Name',
    '文件哈希' => 'HASH',
    '文件大小' => 'Size',
    '文件后缀' => 'Exts',
    '存储方式' => 'Storage Type',
    '清理重复' => 'Clear Replace',
    '上传方式' => 'Upload Type',
    '查看文件' => 'View',
    '文件链接' => 'Link',
    '秒传' => 'Speedy',
    '普通' => 'Normal',
    // 系统菜单管理
    '图 标' => 'Icon',
    '添加菜单' => 'Add',
    '禁用菜单' => 'Forbid',
    '激活菜单' => 'Resume',
    '系统菜单' => 'Menus',
    '菜单名称' => 'Name',
    '跳转链接' => 'Link',
    '上级菜单' => 'Parent',
    '菜单链接' => 'Link',
    '链接参数' => 'Params',
    '权限节点' => 'Node',
    '菜单图标' => 'Icon',
    '选择图标' => 'Select Icon',
    // 系统权限管理
    '授 权' => 'Auth',
    '添加权限' => 'Add',
    '权限名称' => 'Name',
    '权限描述' => 'Description',
    '请输入权限描述' => 'Please enter a permission description',
    // 系统用户管理
    '账号名称' => 'Username',
    '添加用户' => 'Add User',
    '最后登录' => 'Last Login Time',
    '头像' => 'Head',
    '登录账号' => 'Username',
    '用户名称' => 'Nickname',
    '登录次数' => 'Login Times',
    '系统用户' => 'System User',
    '密 码' => 'Password',
    '系统用户管理' => 'Users',

    // 通用操作
    '回 收 站' => 'Recycle Bin',
    '排序权重' => 'Sort Weight',
    '使用状态' => 'Status',
    '操作面板' => 'Actions',
    '已激活' => 'Activated',
    '已禁用' => 'Disabled',
    '已启用' => 'Enabled',
    '添 加' => 'Add',
    '编 辑' => 'Edit',
    '删 除' => 'Delete',
    '全部' => 'All',
    '搜 索' => 'Search',
    '导 出' => 'Export',
    '保存数据' => 'Save Data',
    '取消编辑' => 'Cancel Edit',
    '操作日志' => 'Operation Log',
    '创建时间' => 'Create Time',

    // 用户管理
    '批量禁用' => 'Batch Disable',
    '批量恢复' => 'Batch Restore',
    '编辑用户' => 'Edit User',
    '设置密码' => 'Set Password',
    '角色身份' => 'Role Identity',
    '全部菜单' => 'All Menus',

    // 权限管理
    '确定要批量删除权限吗？' => 'Are you sure you want to batch delete permissions?',
    '确定要删除权限吗?' => 'Are you sure you want to delete the permission?',
    '功能节点' => 'Function Node',
    '访问权限名称需要保持不重复，在给用户授权时需要根据名称选择！' => 'Access permission names must be unique. When authorizing users, select based on the name!',
    '已禁用记录' => 'Disabled Records',
    '已激活记录' => 'Activated Records',

    // 菜单管理
    '确定要删除菜单吗？' => 'Are you sure you want to delete the menu?',
    '添加系统菜单' => 'Add System Menu',
    '编辑系统菜单' => 'Edit System Menu',

    // 文件管理
    '确定删除这些记录吗？' => 'Are you sure you want to delete these records?',
    '播放视频' => 'Play Video',
    '播放音频' => 'Play Audio',
    '查看下载' => 'View/Download',
    '编辑文件信息' => 'Edit File Info',

    // 任务管理
    '确定批量删除记录吗？' => 'Are you sure you want to batch delete records?',
    '确定要重置该任务吗？' => 'Are you sure you want to reset this task?',
    '确定要删除该记录吗？' => 'Are you sure you want to delete this record?',
    '请选择计划时间' => 'Please select scheduled time',
    '请输入名称或编号' => 'Please enter name or code',
    '请输入任务指令' => 'Please enter task command',

    // 确认提示
    '确定要永久删除吗？' => 'Are you sure you want to permanently delete?',
    '确定要取消编辑吗？' => 'Are you sure you want to cancel editing?',
    '确定要取消修改吗？' => 'Are you sure you want to cancel the modification?',
    '确定要禁用这些用户吗？' => 'Are you sure you want to disable these users?',
    '确定要恢复这些账号吗？' => 'Are you sure you want to restore these accounts?',
    '确定永久删除这些账号吗？' => 'Are you sure you want to permanently delete these accounts?',

    // 系统提示
    '新增类型' => 'New Type',
    '只有超级管理员才能操作！' => 'Only super administrators can operate!',
    '日志清理失败，%s' => 'Log cleanup failed, %s',
    '已存在 %s 应用！' => 'Application %s already exists!',

    // 演示环境提示
    '演示环境禁止修改用户密码！' => 'Demo environment prohibits modifying user passwords!',
    '演示环境禁止修改系统配置！' => 'Demo environment prohibits modifying system configuration!',
    '演示环境禁止给菜单排序！' => 'Demo environment prohibits menu sorting!',
    '演示环境禁止添加菜单！' => 'Demo environment prohibits adding menus!',
    '演示环境禁止编辑菜单！' => 'Demo environment prohibits editing menus!',
    '演示环境禁止禁用菜单！' => 'Demo environment prohibits disabling menus!',
    '演示环境禁止删除菜单！' => 'Demo environment prohibits deleting menus!',
    '演示环境禁止修改密码！' => 'Demo environment prohibits modifying passwords!',

    // 表单字段
    '用户账号' => 'User Account',
    '用户权限' => 'User Permissions',
    '用户资料' => 'User Profile',
    '登录账号' => 'Login Account',
    '用户名称' => 'User Name',
    '角色身份' => 'Role Identity',
    '访问权限' => 'Access Permissions',
    '联系邮箱' => 'Contact Email',
    '联系手机' => 'Contact Mobile',
    '联系ＱＱ' => 'Contact QQ',
    '用户描述' => 'User Description',
    '登录用户账号' => 'Login Username',
    '旧的登录密码' => 'Old Password',
    '新的登录密码' => 'New Password',
    '重复登录密码' => 'Repeat Password',
    '验证密码' => 'Verify Password',
    '登录密码' => 'Login Password',
    '重复密码' => 'Repeat Password',

    // 表单提示
    '登录账号不能少于4位字符，创建后不能再次修改.' => 'Login account must be at least 4 characters and cannot be modified after creation.',
    '用于区分用户数据的用户名称，请尽量不要重复.' => 'User name used to distinguish user data, please try not to duplicate.',
    '超级用户拥所有访问权限，不需要配置权限。' => 'Super users have all access permissions and do not need to configure permissions.',
    '可选，请填写用户常用的电子邮箱' => 'Optional, please fill in the user\'s commonly used email address',
    '可选，请填写用户常用的联系手机号' => 'Optional, please fill in the user\'s commonly used mobile phone number',
    '可选，请填写用户常用的联系ＱＱ号' => 'Optional, please fill in the user\'s commonly used QQ number',
    '请输入用户描述' => 'Please enter user description',
    '登录用户账号创建后，不允许再次修改。' => 'Login username cannot be modified after creation.',
    '请输入旧密码来验证修改权限，旧密码不限制格式。' => 'Please enter the old password to verify modification permission. The old password format is not restricted.',
    '密码必须包含大小写字母、数字、符号的任意两者组合。' => 'Password must contain any combination of uppercase letters, lowercase letters, numbers, and symbols.',
    '请重复输入登录密码' => 'Please repeat the login password',

    // 系统配置表单
    '登录表单标题' => 'Login Form Title',
    '后台登录入口' => 'Backend Login Entry',
    '后台默认配色' => 'Backend Default Theme',
    '登录背景图片' => 'Login Background Image',
    'JWT 接口密钥' => 'JWT API Key',
    '浏览器小图标' => 'Browser Icon',
    '后台程序名称' => 'Backend Program Name',
    '后台程序版本' => 'Backend Program Version',
    '公安安备号' => 'Public Security Registration Number',
    '保存配置' => 'Save Configuration',
    '取消修改' => 'Cancel Modification',
    '登录标题' => 'Login Title',
    '登录入口' => 'Login Entry',
    '接口密钥' => 'API Key',
    '图标文件' => 'Icon File',
    '程序名称' => 'Program Name',
    '版权信息' => 'Copyright Information',

    // 菜单表单提示
    '必选' => 'Required',
    '可选' => 'Optional',
    '请选择上级菜单或顶级菜单 ( 目前最多支持三级菜单 )' => 'Please select parent menu or top-level menu (currently supports up to 3 levels)',
    '请填写菜单名称 ( 如：系统管理 )，建议字符不要太长，一般 4-6 个汉字' => 'Please fill in the menu name (e.g., System Management), it is recommended not to be too long, generally 4-6 Chinese characters',
    '请填写链接地址或选择系统节点 ( 如：https://domain.com/admin/user/index.html 或 admin/user/index )' => 'Please fill in the link address or select a system node (e.g., https://domain.com/admin/user/index.html or admin/user/index)',
    '当填写链接地址时，以下面的 "权限节点" 来判断菜单自动隐藏或显示，注意未填写 "权限节点" 时将不会隐藏该菜单哦' => 'When filling in the link address, use the "Permission Node" below to determine whether the menu is automatically hidden or displayed. Note that if the "Permission Node" is not filled in, the menu will not be hidden',
    '设置菜单链接的 GET 访问参数 ( 如：name=1&age=3 )' => 'Set GET access parameters for menu links (e.g., name=1&age=3)',
    '请填写系统权限节点 ( 如：admin/user/index )，未填写时默认解释"菜单链接"判断是否拥有访问权限；' => 'Please fill in the system permission node (e.g., admin/user/index). If not filled in, the "Menu Link" will be used by default to determine access permissions',
    '设置菜单选项前置图标，目前支持 layui 字体图标及 iconfont 定制字体图标。' => 'Set the prefix icon for menu options. Currently supports layui font icons and iconfont custom font icons.',
    '请输入或选择图标' => 'Please enter or select an icon',
    '请输入菜单名称' => 'Please enter menu name',
    '请输入菜单链接' => 'Please enter menu link',
    '请输入链接参数' => 'Please enter link parameters',
    '请输入权限节点' => 'Please enter permission node',
    '请输入登录账号' => 'Please enter login account',
    '请输入用户名称' => 'Please enter user name',
    '请输入联系电子邮箱' => 'Please enter contact email',
    '请输入用户联系手机' => 'Please enter user contact mobile',
    '请输入常用的联系ＱＱ' => 'Please enter commonly used contact QQ',
    '请输入旧的登录密码' => 'Please enter old login password',
    '请输入新的登录密码' => 'Please enter new login password',

    // 系统配置表单提示
    '请输入登录页面的表单标题' => 'Please enter login form title',
    '后台登录入口是由英文字母开头，且不能有相同名称的模块，设置之后原地址不能继续访问，请谨慎配置 ~' => 'Backend login entry must start with English letters and cannot have modules with the same name. After setting, the original address cannot be accessed. Please configure carefully.',
    '请输入32位JWT接口密钥' => 'Please enter 32-bit JWT API key',
    '请输入 32 位 JWT 接口密钥，在使用 JWT 接口时需要使用此密钥进行加密及签名！' => 'Please enter a 32-bit JWT API key. This key is required for encryption and signing when using JWT interfaces!',
    '请上传浏览器图标' => 'Please upload browser icon',
    '建议上传 128x128 或 256x256 的 JPG,PNG,JPEG 图片，保存后会自动生成 48x48 的 ICO 文件 ~' => 'It is recommended to upload JPG, PNG, or JPEG images of 128x128 or 256x256. After saving, a 48x48 ICO file will be automatically generated.',
    '请输入网站名称' => 'Please enter site name',
    '网站名称将显示在浏览器的标签上 ~' => 'Site name will be displayed on the browser tab.',
    '请输入程序名称' => 'Please enter program name',
    '管理程序名称显示在后台左上标题处 ~' => 'Management program name is displayed in the top left title of the backend.',
    '请输入程序版本' => 'Please enter program version',
    '管理程序版本显示在后台左上标题处 ~' => 'Management program version is displayed in the top left title of the backend.',
    '请输入公安安备号' => 'Please enter public security registration number',
    '请输入网站备案号' => 'Please enter website registration number',
    '请输入版权信息' => 'Please enter copyright information',
    '网站备案号和公安备案号可以在<a target="_blank" href="https://beian.miit.gov.cn">备案管理中心</a>查询并获取，网站上线时必需配置备案号，备案号会链接到信息备案管理系统 ~' => 'Website registration number and public security registration number can be queried and obtained at the <a target="_blank" href="https://beian.miit.gov.cn">Registration Management Center</a>. Registration numbers must be configured when the website goes online, and will be linked to the information registration management system.',

    // 数据字典表单提示
    '数据类型' => 'Data Type',
    '请选择数据类型，数据创建后不能再次修改哦 ~' => 'Please select data type. Data type cannot be modified after creation.',
    '请输入数据类型' => 'Please enter data type',
    '请输入新的数据类型，数据创建后不能再次修改哦 ~' => 'Please enter new data type. Data type cannot be modified after creation.',
    '数据编码' => 'Data Code',
    '请输入新的数据编码，数据创建后不能再次修改，同种数据类型的数据编码不能出现重复 ~' => 'Please enter new data code. Data code cannot be modified after creation, and duplicate codes are not allowed for the same data type.',
    '数据名称' => 'Data Name',
    '请输入当前数据名称，请尽量保持名称的唯一性，数据名称尽量不要出现重复 ~' => 'Please enter data name. Try to keep the name unique and avoid duplicates.',
    '数据内容' => 'Data Content',
    '请输入数据内容' => 'Please enter data content',

    // 数据字典列表
    '添加数据' => 'Add Data',
    '确定要批量删除数据吗？' => 'Are you sure you want to batch delete data?',
    '数据状态' => 'Data Status',
    '数据操作' => 'Actions',
    '编辑数据' => 'Edit Data',
    '确定要删除数据吗?' => 'Are you sure you want to delete data?',
]);
