/*
 Navicat MySQL Data Transfer

 Source Server         : server.cuci.cc
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : localhost:3306
 Source Schema         : admin_v6

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 24/11/2020 15:55:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for system_auth
-- ----------------------------
DROP TABLE IF EXISTS `system_auth`;
CREATE TABLE `system_auth`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '权限名称',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_auth_title`(`title`) USING BTREE,
  INDEX `idx_system_auth_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-权限' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_auth
-- ----------------------------

-- ----------------------------
-- Table structure for system_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auth` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '角色',
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '节点',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_auth_auth`(`auth`) USING BTREE,
  INDEX `idx_system_auth_node`(`node`(191)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-授权' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_auth_node
-- ----------------------------

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config`  (
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置名',
  `value` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置值',
  INDEX `idx_system_config_type`(`type`) USING BTREE,
  INDEX `idx_system_config_name`(`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-配置' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('base', 'app_name', 'ThinkAdmin');
INSERT INTO `system_config` VALUES ('base', 'app_version', 'v6');
INSERT INTO `system_config` VALUES ('base', 'beian', '');
INSERT INTO `system_config` VALUES ('base', 'miitbeian', '粤ICP备16006642号-2');
INSERT INTO `system_config` VALUES ('base', 'site_copy', '©版权所有 2014-2020 楚才科技');
INSERT INTO `system_config` VALUES ('base', 'site_icon', 'https://v6.thinkadmin.top/upload/f4/7b8fe06e38ae9908e8398da45583b9.png');
INSERT INTO `system_config` VALUES ('base', 'site_name', 'ThinkAdmin');
INSERT INTO `system_config` VALUES ('base', 'xpath', 'admin');
INSERT INTO `system_config` VALUES ('storage', 'link_type', 'none');
INSERT INTO `system_config` VALUES ('storage', 'allow_exts', 'doc,gif,icon,jpg,mp3,mp4,p12,pem,png,rar,xls,xlsx');
INSERT INTO `system_config` VALUES ('storage', 'local_http_protocol', 'follow');
INSERT INTO `system_config` VALUES ('storage', 'local_http_domain', '');
INSERT INTO `system_config` VALUES ('storage', 'type', 'local');

-- ----------------------------
-- Table structure for system_data
-- ----------------------------
DROP TABLE IF EXISTS `system_data`;
CREATE TABLE `system_data`  (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置名',
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_data_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-数据' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_data
-- ----------------------------

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '上级ID',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '菜单图标',
  `node` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '节点代码',
  `url` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接节点',
  `params` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '_self' COMMENT '打开方式',
  `sort` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0:禁用,1:启用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_menu_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-菜单' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES (2, 0, '系统管理', '', '', '#', '', '_self', 100, 1, '2018-09-05 18:04:52');
INSERT INTO `system_menu` VALUES (3, 4, '系统菜单管理', 'layui-icon layui-icon-layouts', '', 'admin/menu/index', '', '_self', 1, 1, '2018-09-05 18:05:26');
INSERT INTO `system_menu` VALUES (4, 2, '系统配置', '', '', '#', '', '_self', 20, 1, '2018-09-05 18:07:17');
INSERT INTO `system_menu` VALUES (5, 12, '系统用户管理', 'layui-icon layui-icon-username', '', 'admin/user/index', '', '_self', 1, 1, '2018-09-06 11:10:42');
INSERT INTO `system_menu` VALUES (7, 12, '访问权限管理', 'layui-icon layui-icon-vercode', '', 'admin/auth/index', '', '_self', 2, 1, '2018-09-06 15:17:14');
INSERT INTO `system_menu` VALUES (11, 4, '系统参数配置', 'layui-icon layui-icon-set', '', 'admin/config/index', '', '_self', 4, 1, '2018-09-06 16:43:47');
INSERT INTO `system_menu` VALUES (12, 2, '权限管理', '', '', '#', '', '_self', 10, 1, '2018-09-06 18:01:31');
INSERT INTO `system_menu` VALUES (27, 4, '系统任务管理', 'layui-icon layui-icon-log', '', 'admin/queue/index', '', '_self', 3, 1, '2018-11-29 11:13:34');
INSERT INTO `system_menu` VALUES (49, 4, '系统日志管理', 'layui-icon layui-icon-form', '', 'admin/oplog/index', '', '_self', 2, 1, '2019-02-18 12:56:56');
INSERT INTO `system_menu` VALUES (56, 0, '微信管理', '', '', '#', '', '_self', 200, 1, '2019-12-09 11:00:37');
INSERT INTO `system_menu` VALUES (57, 56, '微信管理', '', '', '#', '', '_self', 0, 1, '2019-12-09 13:56:58');
INSERT INTO `system_menu` VALUES (58, 57, '微信接口配置', 'layui-icon layui-icon-set', '', 'wechat/config/options', '', '_self', 0, 1, '2019-12-09 13:57:28');
INSERT INTO `system_menu` VALUES (59, 57, '微信支付配置', 'layui-icon layui-icon-rmb', '', 'wechat/config/payment', '', '_self', 0, 1, '2019-12-09 13:58:42');
INSERT INTO `system_menu` VALUES (60, 56, '微信定制', '', '', '#', '', '_self', 0, 1, '2019-12-09 18:35:16');
INSERT INTO `system_menu` VALUES (61, 60, '微信粉丝管理', 'layui-icon layui-icon-username', '', 'wechat/fans/index', '', '_self', 0, 1, '2019-12-09 18:35:37');
INSERT INTO `system_menu` VALUES (62, 60, '微信图文管理', 'layui-icon layui-icon-template-1', '', 'wechat/news/index', '', '_self', 0, 1, '2019-12-09 18:43:51');
INSERT INTO `system_menu` VALUES (63, 60, '微信菜单配置', 'layui-icon layui-icon-cellphone', '', 'wechat/menu/index', '', '_self', 0, 1, '2019-12-09 22:49:28');
INSERT INTO `system_menu` VALUES (64, 60, '回复规则管理', 'layui-icon layui-icon-engine', '', 'wechat/keys/index', '', '_self', 0, 1, '2019-12-14 14:09:04');
INSERT INTO `system_menu` VALUES (65, 60, '关注回复配置', 'layui-icon layui-icon-senior', '', 'wechat/keys/subscribe', '', '_self', 0, 1, '2019-12-14 14:10:31');
INSERT INTO `system_menu` VALUES (66, 60, '默认回复配置', 'layui-icon layui-icon-util', '', 'wechat/keys/defaults', '', '_self', 0, 1, '2019-12-14 14:11:18');
INSERT INTO `system_menu` VALUES (67, 0, '控制台', '', '', '#', '', '_self', 300, 1, '2020-07-13 06:51:46');
INSERT INTO `system_menu` VALUES (68, 67, '数据管理（接口案例）', '', '', '#', '', '_self', 0, 1, '2020-07-13 06:51:54');
INSERT INTO `system_menu` VALUES (69, 68, '文章标签管理', 'layui-icon layui-icon-note', '', 'data/news_mark/index', '', '_self', 20, 1, '2020-07-13 06:52:09');
INSERT INTO `system_menu` VALUES (70, 68, '文章内容管理', 'layui-icon layui-icon-template', '', 'data/news_item/index', '', '_self', 10, 1, '2020-07-13 06:52:26');
INSERT INTO `system_menu` VALUES (71, 68, '轮播图片管理', 'layui-icon layui-icon-carousel', '', 'data/config/slider', '', '_self', 0, 1, '2020-07-14 01:17:02');
INSERT INTO `system_menu` VALUES (73, 67, '商城管理（开发中）', '', '', '#', '', '_self', 0, 1, '2020-09-08 02:51:30');
INSERT INTO `system_menu` VALUES (74, 73, '商品分类管理', 'layui-icon layui-icon-app', 'data/shop_goods_cate/index', 'data/shop_goods_cate/index', '', '_self', 80, 1, '2020-09-08 02:51:49');
INSERT INTO `system_menu` VALUES (75, 73, '商品标签管理', 'layui-icon layui-icon-form', 'data/shop_goods_mark/index', 'data/shop_goods_mark/index', '', '_self', 70, 1, '2020-09-08 03:35:58');
INSERT INTO `system_menu` VALUES (76, 73, '商品数据管理', 'layui-icon layui-icon-star', 'data/shop_goods/index', 'data/shop_goods/index', '', '_self', 90, 1, '2020-09-08 07:13:19');
INSERT INTO `system_menu` VALUES (77, 73, '会员用户管理', 'layui-icon layui-icon-user', 'data/member/index', 'data/member/index', '', '_self', 100, 1, '2020-09-10 01:48:02');
INSERT INTO `system_menu` VALUES (78, 73, '订单数据管理', 'layui-icon layui-icon-template-1', 'data/shop_order/index', 'data/shop_order/index', '', '_self', 60, 1, '2020-09-10 01:48:41');
INSERT INTO `system_menu` VALUES (79, 73, '订单发货管理', 'layui-icon layui-icon-transfer', 'data/shop_order_send/index', 'data/shop_order_send/index', '', '_self', 50, 1, '2020-09-10 01:50:12');
INSERT INTO `system_menu` VALUES (80, 73, '售后申请管理', 'layui-icon layui-icon-diamond', 'data/shop_order_service/index', 'data/shop_order_service/index', '', '_self', 40, 1, '2020-09-10 01:53:16');
INSERT INTO `system_menu` VALUES (81, 73, '快递公司管理', 'layui-icon layui-icon-website', 'data/shop_truck_company/index', 'data/shop_truck_company/index', '', '_self', 0, 1, '2020-09-15 08:47:46');
INSERT INTO `system_menu` VALUES (82, 73, '邮费模板管理', 'layui-icon layui-icon-template-1', 'data/shop_truck_template/index', 'data/shop_truck_template/index', '', '_self', 0, 1, '2020-09-15 09:14:46');
INSERT INTO `system_menu` VALUES (83, 73, '配送区域管理', 'layui-icon layui-icon-location', 'data/shop_truck_template/region', 'data/shop_truck_template/region', '', '_self', 0, 1, '2020-09-17 09:13:35');
INSERT INTO `system_menu` VALUES (84, 68, '微信小程序配置', 'layui-icon layui-icon-set', 'data/config/wxapp', 'data/config/wxapp', '', '_self', 0, 1, '2020-09-21 16:34:08');
INSERT INTO `system_menu` VALUES (85, 68, '会员服务协议', 'layui-icon layui-icon-template-1', 'data/config/agreement', 'data/config/agreement', '', '_self', 30, 1, '2020-09-22 16:00:10');
INSERT INTO `system_menu` VALUES (86, 68, '关于我们描述', 'layui-icon layui-icon-app', 'data/config/about', 'data/config/about', '', '_self', 40, 1, '2020-09-22 16:12:44');

-- ----------------------------
-- Table structure for system_oplog
-- ----------------------------
DROP TABLE IF EXISTS `system_oplog`;
CREATE TABLE `system_oplog`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `geoip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `action` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作行为名称',
  `content` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作内容描述',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_oplog
-- ----------------------------
INSERT INTO `system_oplog` VALUES (1, 'admin/login/index', '127.0.0.1', '用户登录', '登录系统后台成功', 'admin', '2020-11-24 07:34:11');

-- ----------------------------
-- Table structure for system_queue
-- ----------------------------
DROP TABLE IF EXISTS `system_queue`;
CREATE TABLE `system_queue`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '任务编号',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '任务名称',
  `command` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '执行指令',
  `exec_pid` bigint(20) NULL DEFAULT 0 COMMENT '执行进程',
  `exec_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '执行参数',
  `exec_time` bigint(20) NULL DEFAULT 0 COMMENT '执行时间',
  `exec_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '执行描述',
  `enter_time` decimal(20, 4) NULL DEFAULT 0.0000 COMMENT '开始时间',
  `outer_time` decimal(20, 4) NULL DEFAULT 0.0000 COMMENT '结束时间',
  `loops_time` bigint(20) NULL DEFAULT 0 COMMENT '循环时间',
  `attempts` bigint(20) NULL DEFAULT 0 COMMENT '执行次数',
  `rscript` tinyint(1) NULL DEFAULT 1 COMMENT '任务类型(0单例,1多例)',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '任务状态(1新任务,2处理中,3成功,4失败)',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_queue_code`(`code`) USING BTREE,
  INDEX `idx_system_queue_title`(`title`) USING BTREE,
  INDEX `idx_system_queue_status`(`status`) USING BTREE,
  INDEX `idx_system_queue_rscript`(`rscript`) USING BTREE,
  INDEX `idx_system_queue_create_at`(`create_at`) USING BTREE,
  INDEX `idx_system_queue_exec_time`(`exec_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-任务' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_queue
-- ----------------------------

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户账号',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户密码',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户昵称',
  `headimg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '头像地址',
  `authorize` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '权限授权',
  `contact_qq` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系QQ',
  `contact_mail` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系邮箱',
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系手机',
  `login_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '登录地址',
  `login_at` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '登录时间',
  `login_num` bigint(20) NULL DEFAULT 0 COMMENT '登录次数',
  `describe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态(0禁用,1启用)',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `is_deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除(1删除,0未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_user_username`(`username`) USING BTREE,
  INDEX `idx_system_user_deleted`(`is_deleted`) USING BTREE,
  INDEX `idx_system_user_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES (10000, 'admin', '21232f297a57a5a743894a0e4a801fc3', '系统管理员', 'https://v6.thinkadmin.top/upload/ec/f571134493e54fe06855c88557052c.png', '', '', '', '', '127.0.0.1', '2020-11-24 07:34:11', 1, '', 1, 0, 0, '2015-11-13 15:14:22');

-- ----------------------------
-- Table structure for wechat_fans
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans`;
CREATE TABLE `wechat_fans`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `unionid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '粉丝unionid',
  `openid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '粉丝openid',
  `tagid_list` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '粉丝标签id',
  `is_black` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否为黑名单状态',
  `subscribe` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '关注状态(0未关注,1已关注)',
  `nickname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户昵称',
  `sex` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '用户性别(1男性,2女性,0未知)',
  `country` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户所在国家',
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户所在省份',
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户所在城市',
  `language` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户的语言(zh_CN)',
  `headimgurl` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户头像',
  `subscribe_time` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '关注时间',
  `subscribe_at` datetime NULL DEFAULT NULL COMMENT '关注时间',
  `remark` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `subscribe_scene` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '扫码关注场景',
  `qr_scene` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '二维码场景值',
  `qr_scene_str` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '二维码场景内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_fans_openid`(`openid`) USING BTREE,
  INDEX `index_wechat_fans_unionid`(`unionid`) USING BTREE,
  INDEX `index_wechat_fans_subscribe`(`subscribe`) USING BTREE,
  INDEX `index_wechat_fans_isblack`(`is_black`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-粉丝' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wechat_fans
-- ----------------------------

-- ----------------------------
-- Table structure for wechat_fans_tags
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans_tags`;
CREATE TABLE `wechat_fans_tags`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `appid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `name` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '标签名称',
  `count` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '总数',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  INDEX `index_wechat_fans_tags_id`(`id`) USING BTREE,
  INDEX `index_wechat_fans_tags_appid`(`appid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-标签' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wechat_fans_tags
-- ----------------------------

-- ----------------------------
-- Table structure for wechat_keys
-- ----------------------------
DROP TABLE IF EXISTS `wechat_keys`;
CREATE TABLE `wechat_keys`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '类型(text,image,news)',
  `keys` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '关键字',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '文本内容',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '图片链接',
  `voice_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '语音链接',
  `music_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '音乐标题',
  `music_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '音乐链接',
  `music_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '缩略图片',
  `music_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '音乐描述',
  `video_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '视频标题',
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '视频URL',
  `video_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '视频描述',
  `news_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '图文ID',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序字段',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0禁用,1启用)',
  `create_by` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_keys_appid`(`appid`) USING BTREE,
  INDEX `index_wechat_keys_type`(`type`) USING BTREE,
  INDEX `index_wechat_keys_keys`(`keys`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-规则' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wechat_keys
-- ----------------------------

-- ----------------------------
-- Table structure for wechat_media
-- ----------------------------
DROP TABLE IF EXISTS `wechat_media`;
CREATE TABLE `wechat_media`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号ID',
  `md5` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件md5',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '媒体类型',
  `media_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '本地文件链接',
  `media_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_media_appid`(`appid`) USING BTREE,
  INDEX `index_wechat_media_md5`(`md5`) USING BTREE,
  INDEX `index_wechat_media_type`(`type`) USING BTREE,
  INDEX `index_wechat_media_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-素材' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wechat_media
-- ----------------------------

-- ----------------------------
-- Table structure for wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news`;
CREATE TABLE `wechat_news`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材外网URL',
  `article_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '关联图文ID(用英文逗号做分割)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删除,1已删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_news_artcle_id`(`article_id`) USING BTREE,
  INDEX `index_wechat_news_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-图文' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wechat_news
-- ----------------------------

-- ----------------------------
-- Table structure for wechat_news_article
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_article`;
CREATE TABLE `wechat_news_article`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '素材标题',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) UNSIGNED NULL DEFAULT 0 COMMENT '显示封面(0不显示,1显示)',
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章作者',
  `digest` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '摘要内容',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '图文内容',
  `content_source_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '原文地址',
  `read_num` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '阅读数量',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-文章' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wechat_news_article
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
