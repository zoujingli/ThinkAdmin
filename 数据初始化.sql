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

 Date: 17/03/2021 15:32:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-菜单' ROW_FORMAT = COMPACT;

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
INSERT INTO `system_menu` VALUES (70, 68, '文章内容管理', 'layui-icon layui-icon-template', '', 'data/news_item/index', '', '_self', 10, 1, '2020-07-13 06:52:26');
INSERT INTO `system_menu` VALUES (71, 68, '轮播图片管理', 'layui-icon layui-icon-carousel', 'data/config/sliderhome', 'data/config/sliderhome', '', '_self', 30, 1, '2020-07-14 01:17:02');
INSERT INTO `system_menu` VALUES (73, 67, '商城管理（开发中）', '', '', '#', '', '_self', 0, 1, '2020-09-08 02:51:30');
INSERT INTO `system_menu` VALUES (75, 73, '商品分类管理', 'layui-icon layui-icon-tabs', 'data/shop_goods_cate/index', 'data/shop_goods_cate/index', '', '_self', 70, 1, '2020-09-08 03:35:58');
INSERT INTO `system_menu` VALUES (76, 73, '商品数据管理', 'layui-icon layui-icon-star', 'data/shop_goods/index', 'data/shop_goods/index', '', '_self', 90, 1, '2020-09-08 07:13:19');
INSERT INTO `system_menu` VALUES (77, 90, '会员用户管理', 'layui-icon layui-icon-user', 'data/user/index', 'data/user/index', '', '_self', 900, 1, '2020-09-10 01:48:02');
INSERT INTO `system_menu` VALUES (78, 73, '订单数据管理', 'layui-icon layui-icon-template', 'data/shop_order/index', 'data/shop_order/index', '', '_self', 60, 1, '2020-09-10 01:48:41');
INSERT INTO `system_menu` VALUES (79, 73, '订单发货管理', 'layui-icon layui-icon-transfer', 'data/shop_order_send/index', 'data/shop_order_send/index', '', '_self', 50, 1, '2020-09-10 01:50:12');
INSERT INTO `system_menu` VALUES (81, 73, '快递公司管理', 'layui-icon layui-icon-website', 'data/shop_truck_company/index', 'data/shop_truck_company/index', '', '_self', 0, 1, '2020-09-15 08:47:46');
INSERT INTO `system_menu` VALUES (82, 73, '邮费模板管理', 'layui-icon layui-icon-template-1', 'data/shop_truck_template/index', 'data/shop_truck_template/index', '', '_self', 0, 1, '2020-09-15 09:14:46');
INSERT INTO `system_menu` VALUES (83, 73, '配送区域管理', 'layui-icon layui-icon-location', 'data/shop_truck_template/region', 'data/shop_truck_template/region', '', '_self', 0, 1, '2020-09-17 09:13:35');
INSERT INTO `system_menu` VALUES (84, 68, '微信小程序配置', 'layui-icon layui-icon-set', 'data/config/wxapp', 'data/config/wxapp', '', '_self', 5, 1, '2020-09-21 16:34:08');
INSERT INTO `system_menu` VALUES (87, 68, '支付参数管理', 'layui-icon layui-icon-rmb', 'data/shop_payment/index', 'data/shop_payment/index', '', '_self', 6, 1, '2020-12-12 09:08:09');
INSERT INTO `system_menu` VALUES (88, 68, '系统通知管理', 'layui-icon layui-icon-notice', 'data/user_notify/index', 'data/user_notify/index', '', '_self', 6, 1, '2021-01-20 10:07:32');
INSERT INTO `system_menu` VALUES (89, 90, '余额充值记录', 'layui-icon layui-icon-rmb', 'data/user_balance/index', 'data/user_balance/index', '', '_self', 800, 1, '2021-01-20 10:09:49');
INSERT INTO `system_menu` VALUES (90, 67, '用户管理', '', '', '#', '', '_self', 0, 1, '2021-01-22 05:43:01');
INSERT INTO `system_menu` VALUES (91, 90, '用户等级管理', 'layui-icon layui-icon-senior', 'data/user_upgrade/index', 'data/user_upgrade/index', '', '_self', 700, 1, '2021-01-22 05:43:27');
INSERT INTO `system_menu` VALUES (92, 90, '用户折扣方案', 'layui-icon layui-icon-set', 'data/user_discount/index', 'data/user_discount/index', '', '_self', 0, 1, '2021-01-27 05:44:51');
INSERT INTO `system_menu` VALUES (93, 90, '用户提现管理', 'layui-icon layui-icon-component', 'data/user_transfer/index', 'data/user_transfer/index', '', '_self', 0, 1, '2021-01-28 06:48:34');
INSERT INTO `system_menu` VALUES (94, 68, '页面内容管理', 'layui-icon layui-icon-read', 'data/config/pagehome', 'data/config/pagehome', '', '_self', 20, 1, '2021-02-24 08:49:16');
INSERT INTO `system_menu` VALUES (95, 68, '邀请二维码设置', 'layui-icon layui-icon-cols', 'data/config/cropper', 'data/config/cropper', '', '_self', 0, 1, '2021-03-01 09:53:59');
INSERT INTO `system_menu` VALUES (97, 90, '用户返利管理', 'layui-icon layui-icon-transfer', 'data/user_rebate/index', 'data/user_rebate/index', '', '_self', 0, 1, '2021-03-12 10:06:49');

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
  INDEX `idx_system_user_status`(`status`) USING BTREE,
  INDEX `idx_system_user_username`(`username`) USING BTREE,
  INDEX `idx_system_user_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-用户' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES (10000, 'admin', '21232f297a57a5a743894a0e4a801fc3', '系统管理员', 'http://127.0.0.1:8000/upload/cf/d4b538dc1d8b96a09310cab5fa44c9.gif', ',,', '', '', '', '116.21.40.249', '2021-03-17 07:10:44', 95, '', 1, 0, 0, '2015-11-13 15:14:22');

SET FOREIGN_KEY_CHECKS = 1;
