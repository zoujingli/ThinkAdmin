/*
 Navicat Premium Data Transfer

 Source Server         : ctolog.com
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : 127.0.0.1:3306
 Source Schema         : admin_v4

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 02/04/2019 13:45:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for store_express
-- ----------------------------
DROP TABLE IF EXISTS `store_express`;
CREATE TABLE `store_express`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `express_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `express_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司代码',
  `express_desc` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0.无效,1.有效)',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(1删除,0未删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_express_code`(`express_code`) USING BTREE,
  INDEX `index_store_express_status`(`status`) USING BTREE,
  INDEX `index_store_express_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城-快递' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of store_express
-- ----------------------------
INSERT INTO `store_express` VALUES (5, 'AAE全球专递', 'aae', NULL, 0, 0, 0, '2017-09-12 11:53:40');
INSERT INTO `store_express` VALUES (6, '安捷快递', 'anjie', '', 0, 0, 0, '2017-09-13 15:27:26');
INSERT INTO `store_express` VALUES (7, '安信达快递', 'anxindakuaixi', NULL, 0, 0, 0, '2017-09-13 16:05:19');
INSERT INTO `store_express` VALUES (8, '彪记快递', 'biaojikuaidi', NULL, 0, 0, 0, '2017-09-13 16:05:26');
INSERT INTO `store_express` VALUES (9, 'BHT', 'bht', '', 0, 0, 0, '2017-09-13 16:05:37');
INSERT INTO `store_express` VALUES (10, '百福东方国际物流', 'baifudongfang', NULL, 0, 0, 0, '2017-09-13 16:05:41');
INSERT INTO `store_express` VALUES (11, '中国东方（COE）', 'coe', NULL, 0, 0, 0, '2017-09-13 16:05:48');
INSERT INTO `store_express` VALUES (12, '长宇物流', 'changyuwuliu', NULL, 0, 0, 0, '2017-09-13 16:05:58');
INSERT INTO `store_express` VALUES (13, '大田物流', 'datianwuliu', NULL, 0, 0, 0, '2017-09-13 16:06:06');
INSERT INTO `store_express` VALUES (14, '德邦物流', 'debangwuliu', NULL, 1, 1, 0, '2017-09-13 16:06:14');
INSERT INTO `store_express` VALUES (15, 'DHL', 'dhl', NULL, 0, 0, 0, '2017-09-13 16:06:24');
INSERT INTO `store_express` VALUES (16, 'DPEX', 'dpex', NULL, 0, 0, 0, '2017-09-13 16:06:29');
INSERT INTO `store_express` VALUES (17, 'd速快递', 'dsukuaidi', NULL, 0, 0, 0, '2017-09-13 16:06:34');
INSERT INTO `store_express` VALUES (18, '递四方', 'disifang', NULL, 0, 0, 0, '2017-09-13 16:06:40');
INSERT INTO `store_express` VALUES (19, 'EMS快递', 'ems', '', 1, 0, 0, '2017-09-13 16:06:47');
INSERT INTO `store_express` VALUES (20, 'FEDEX（国外）', 'fedex', NULL, 0, 0, 0, '2017-09-13 16:06:56');
INSERT INTO `store_express` VALUES (21, '飞康达物流', 'feikangda', NULL, 0, 0, 0, '2017-09-13 16:07:03');
INSERT INTO `store_express` VALUES (22, '凤凰快递', 'fenghuangkuaidi', NULL, 0, 0, 0, '2017-09-13 16:07:10');
INSERT INTO `store_express` VALUES (23, '飞快达', 'feikuaida', NULL, 0, 0, 0, '2017-09-13 16:07:16');
INSERT INTO `store_express` VALUES (24, '国通快递', 'guotongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:07:27');
INSERT INTO `store_express` VALUES (25, '港中能达物流', 'ganzhongnengda', NULL, 0, 0, 0, '2017-09-13 16:07:33');
INSERT INTO `store_express` VALUES (26, '广东邮政物流', 'guangdongyouzhengwuliu', NULL, 0, 0, 0, '2017-09-13 16:08:22');
INSERT INTO `store_express` VALUES (27, '共速达', 'gongsuda', NULL, 0, 0, 0, '2017-09-13 16:08:48');
INSERT INTO `store_express` VALUES (28, '汇通快运', 'huitongkuaidi', NULL, 1, 0, 0, '2017-09-13 16:08:56');
INSERT INTO `store_express` VALUES (29, '恒路物流', 'hengluwuliu', NULL, 0, 0, 0, '2017-09-13 16:09:02');
INSERT INTO `store_express` VALUES (30, '华夏龙物流', 'huaxialongwuliu', NULL, 0, 0, 0, '2017-09-13 16:09:12');
INSERT INTO `store_express` VALUES (31, '海红', 'haihongwangsong', NULL, 0, 0, 0, '2017-09-13 16:09:20');
INSERT INTO `store_express` VALUES (32, '海外环球', 'haiwaihuanqiu', NULL, 0, 0, 0, '2017-09-13 16:09:27');
INSERT INTO `store_express` VALUES (33, '佳怡物流', 'jiayiwuliu', NULL, 0, 0, 0, '2017-09-13 16:09:35');
INSERT INTO `store_express` VALUES (34, '京广速递', 'jinguangsudikuaijian', NULL, 0, 0, 0, '2017-09-13 16:09:42');
INSERT INTO `store_express` VALUES (35, '急先达', 'jixianda', NULL, 0, 0, 0, '2017-09-13 16:09:49');
INSERT INTO `store_express` VALUES (36, '佳吉物流', 'jjwl', NULL, 0, 0, 0, '2017-09-13 16:10:01');
INSERT INTO `store_express` VALUES (37, '加运美物流', 'jymwl', NULL, 0, 0, 0, '2017-09-13 16:10:13');
INSERT INTO `store_express` VALUES (38, '金大物流', 'jindawuliu', NULL, 0, 0, 0, '2017-09-13 16:10:22');
INSERT INTO `store_express` VALUES (39, '嘉里大通', 'jialidatong', NULL, 0, 0, 0, '2017-09-13 16:10:33');
INSERT INTO `store_express` VALUES (40, '晋越快递', 'jykd', NULL, 0, 0, 0, '2017-09-13 16:10:40');
INSERT INTO `store_express` VALUES (41, '快捷速递', 'kuaijiesudi', NULL, 0, 0, 0, '2017-09-13 16:10:49');
INSERT INTO `store_express` VALUES (42, '联邦快递（国内）', 'lianb', NULL, 0, 0, 0, '2017-09-13 16:10:58');
INSERT INTO `store_express` VALUES (43, '联昊通物流', 'lianhaowuliu', NULL, 0, 0, 0, '2017-09-13 16:11:07');
INSERT INTO `store_express` VALUES (44, '龙邦物流', 'longbanwuliu', NULL, 0, 0, 0, '2017-09-13 16:11:15');
INSERT INTO `store_express` VALUES (45, '立即送', 'lijisong', NULL, 0, 0, 0, '2017-09-13 16:11:25');
INSERT INTO `store_express` VALUES (46, '乐捷递', 'lejiedi', NULL, 0, 0, 0, '2017-09-13 16:11:36');
INSERT INTO `store_express` VALUES (47, '民航快递', 'minghangkuaidi', NULL, 0, 0, 0, '2017-09-13 16:11:45');
INSERT INTO `store_express` VALUES (48, '美国快递', 'meiguokuaidi', NULL, 0, 0, 0, '2017-09-13 16:11:53');
INSERT INTO `store_express` VALUES (49, '门对门', 'menduimen', NULL, 0, 0, 0, '2017-09-13 16:12:01');
INSERT INTO `store_express` VALUES (50, 'OCS', 'ocs', NULL, 0, 0, 0, '2017-09-13 16:12:10');
INSERT INTO `store_express` VALUES (51, '配思货运', 'peisihuoyunkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:18');
INSERT INTO `store_express` VALUES (52, '全晨快递', 'quanchenkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:26');
INSERT INTO `store_express` VALUES (53, '全峰快递', 'quanfengkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:34');
INSERT INTO `store_express` VALUES (54, '全际通物流', 'quanjitong', NULL, 0, 0, 0, '2017-09-13 16:12:41');
INSERT INTO `store_express` VALUES (55, '全日通快递', 'quanritongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:49');
INSERT INTO `store_express` VALUES (56, '全一快递', 'quanyikuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:56');
INSERT INTO `store_express` VALUES (57, '如风达', 'rufengda', NULL, 0, 0, 0, '2017-09-13 16:13:03');
INSERT INTO `store_express` VALUES (58, '三态速递', 'santaisudi', NULL, 0, 0, 0, '2017-09-13 16:13:15');
INSERT INTO `store_express` VALUES (59, '盛辉物流', 'shenghuiwuliu', NULL, 0, 0, 0, '2017-09-13 16:13:22');
INSERT INTO `store_express` VALUES (60, '申通', 'shentong', NULL, 1, 0, 0, '2017-09-13 16:13:34');
INSERT INTO `store_express` VALUES (61, '顺丰', 'shunfeng', '', 0, 0, 0, '2017-09-13 16:13:41');
INSERT INTO `store_express` VALUES (62, '速尔物流', 'sue', NULL, 1, 0, 0, '2017-09-13 16:13:48');
INSERT INTO `store_express` VALUES (63, '盛丰物流', 'shengfeng', NULL, 0, 0, 0, '2017-09-13 16:13:55');
INSERT INTO `store_express` VALUES (64, '赛澳递', 'saiaodi', NULL, 0, 0, 0, '2017-09-13 16:14:02');
INSERT INTO `store_express` VALUES (65, '天地华宇', 'tiandihuayu', NULL, 0, 0, 0, '2017-09-13 16:14:11');
INSERT INTO `store_express` VALUES (66, '天天快递', 'tiantian', NULL, 1, 0, 0, '2017-09-13 16:14:19');
INSERT INTO `store_express` VALUES (67, 'TNT', 'tnt', NULL, 0, 0, 0, '2017-09-13 16:14:26');
INSERT INTO `store_express` VALUES (68, 'UPS', 'ups', NULL, 0, 0, 0, '2017-09-13 16:14:29');
INSERT INTO `store_express` VALUES (69, '万家物流', 'wanjiawuliu', NULL, 0, 0, 0, '2017-09-13 16:14:37');
INSERT INTO `store_express` VALUES (70, '文捷航空速递', 'wenjiesudi', NULL, 0, 0, 0, '2017-09-13 16:14:46');
INSERT INTO `store_express` VALUES (71, '伍圆', 'wuyuan', NULL, 0, 0, 0, '2017-09-13 16:14:52');
INSERT INTO `store_express` VALUES (72, '万象物流', 'wxwl', NULL, 0, 0, 0, '2017-09-13 16:15:00');
INSERT INTO `store_express` VALUES (73, '新邦物流', 'xinbangwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:06');
INSERT INTO `store_express` VALUES (74, '信丰物流', 'xinfengwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:15');
INSERT INTO `store_express` VALUES (75, '亚风速递', 'yafengsudi', NULL, 0, 0, 0, '2017-09-13 16:15:23');
INSERT INTO `store_express` VALUES (76, '一邦速递', 'yibangwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:30');
INSERT INTO `store_express` VALUES (77, '优速物流', 'youshuwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:36');
INSERT INTO `store_express` VALUES (78, '邮政包裹挂号信', 'youzhengguonei', NULL, 0, 3, 0, '2017-09-13 16:15:44');
INSERT INTO `store_express` VALUES (79, '邮政国际包裹挂号信', 'youzhengguoji', NULL, 1, 2, 0, '2017-09-13 16:15:51');
INSERT INTO `store_express` VALUES (80, '远成物流', 'yuanchengwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:57');
INSERT INTO `store_express` VALUES (81, '圆通速递', 'yuantong', NULL, 1, 1, 0, '2017-09-13 16:16:03');
INSERT INTO `store_express` VALUES (82, '源伟丰快递', 'yuanweifeng', NULL, 0, 0, 0, '2017-09-13 16:16:10');
INSERT INTO `store_express` VALUES (83, '元智捷诚快递', 'yuanzhijiecheng', NULL, 0, 0, 0, '2017-09-13 16:16:17');
INSERT INTO `store_express` VALUES (84, '韵达快运', 'yunda', NULL, 1, 0, 0, '2017-09-13 16:16:24');
INSERT INTO `store_express` VALUES (85, '运通快递', 'yuntongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:16:33');
INSERT INTO `store_express` VALUES (86, '越丰物流', 'yuefengwuliu', NULL, 0, 0, 0, '2017-09-13 16:16:40');
INSERT INTO `store_express` VALUES (87, '源安达', 'yad', NULL, 0, 0, 0, '2017-09-13 16:16:47');
INSERT INTO `store_express` VALUES (88, '银捷速递', 'yinjiesudi', NULL, 0, 0, 0, '2017-09-13 16:16:56');
INSERT INTO `store_express` VALUES (89, '宅急送', 'zhaijisong', NULL, 0, 0, 0, '2017-09-13 16:17:03');
INSERT INTO `store_express` VALUES (90, '中铁快运', 'zhongtiekuaiyun', NULL, 0, 0, 0, '2017-09-13 16:17:10');
INSERT INTO `store_express` VALUES (91, '中通速递', 'zhongtong', '', 1, 0, 0, '2017-09-13 16:17:16');
INSERT INTO `store_express` VALUES (92, '中邮物流', 'zhongyouwuliu', NULL, 0, 0, 0, '2017-09-13 16:17:27');
INSERT INTO `store_express` VALUES (93, '忠信达', 'zhongxinda', NULL, 0, 0, 0, '2017-09-13 16:17:34');
INSERT INTO `store_express` VALUES (94, '芝麻开门', 'zhimakaimen', NULL, 1, 0, 1, '2017-09-13 16:17:41');
INSERT INTO `store_express` VALUES (95, '中通快运', 'zhongtongkuaiyun', '', 1, 0, 0, '2019-03-28 15:04:41');
INSERT INTO `store_express` VALUES (96, '德邦快递', 'debangkuaidi', '', 1, 0, 0, '2019-03-28 15:05:30');

-- ----------------------------
-- Table structure for store_goods
-- ----------------------------
DROP TABLE IF EXISTS `store_goods`;
CREATE TABLE `store_goods`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品分类',
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品标题',
  `logo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品图标',
  `specs` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品规格JSON',
  `lists` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品列表JSON',
  `image` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品图片',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品内容',
  `number_sales` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '销售数量',
  `number_stock` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '库库数量',
  `price_rate` decimal(20, 4) UNSIGNED NULL DEFAULT 0.0000 COMMENT '返利比例',
  `price_express` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '统一运费',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '销售状态',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_status`(`status`) USING BTREE,
  INDEX `index_store_goods_cate_id`(`cate_id`) USING BTREE,
  INDEX `index_store_goods_is_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品-记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `store_goods_cate`;
CREATE TABLE `store_goods_cate`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类图标',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `desc` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '销售状态',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_cate_is_deleted`(`is_deleted`) USING BTREE,
  INDEX `index_store_goods_cate_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品-分类' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_goods_list
-- ----------------------------
DROP TABLE IF EXISTS `store_goods_list`;
CREATE TABLE `store_goods_list`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品ID',
  `goods_spec` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_market` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品标价',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品售价',
  `number_sales` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '销售数量',
  `number_stock` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品库存',
  `number_virtual` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '虚拟销量',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_list_id`(`goods_id`) USING BTREE,
  INDEX `index_store_goods_list_spec`(`goods_spec`) USING BTREE,
  INDEX `index_store_goods_list_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品-详情' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_goods_stock
-- ----------------------------
DROP TABLE IF EXISTS `store_goods_stock`;
CREATE TABLE `store_goods_stock`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品ID',
  `goods_spec` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `number_stock` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品库存',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_stock_gid`(`goods_id`) USING BTREE,
  INDEX `index_store_goods_stock_spec`(`goods_spec`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品-入库' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_member
-- ----------------------------
DROP TABLE IF EXISTS `store_member`;
CREATE TABLE `store_member`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '微信OPENID',
  `headimg` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '头像地址',
  `nickname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '微信昵称',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '联系手机',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '真实姓名',
  `vip_level` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '会员级别(0游客,1为临时,2为VIP1,3为VIP2)',
  `vip_date` date NULL DEFAULT NULL COMMENT '保级日期',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_openid`(`openid`) USING BTREE,
  INDEX `index_store_member_phone`(`phone`) USING BTREE,
  INDEX `index_store_member_vip_level`(`vip_level`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员-记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_member_address
-- ----------------------------
DROP TABLE IF EXISTS `store_member_address`;
CREATE TABLE `store_member_address`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货姓名',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货手机',
  `province` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '地址-省份',
  `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '地址-城市',
  `area` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '地址-区域',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '地址-详情',
  `is_default` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '默认地址',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_address_mid`(`mid`) USING BTREE,
  INDEX `index_store_member_address_is_default`(`is_default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员-收货地址' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_member_sms_history
-- ----------------------------
DROP TABLE IF EXISTS `store_member_sms_history`;
CREATE TABLE `store_member_sms_history`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '目标手机',
  `content` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '短信内容',
  `result` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '返回结果',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_sms_history_phone`(`phone`) USING BTREE,
  INDEX `index_store_member_sms_history_mid`(`mid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员-短信' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_order
-- ----------------------------
DROP TABLE IF EXISTS `store_order`;
CREATE TABLE `store_order`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `order_no` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '订单单号',
  `from_mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐会员ID',
  `price_total` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '待付金额统计',
  `price_goods` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品费用统计',
  `price_express` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '快递费用统计',
  `price_rate_amount` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '返利金额统计',
  `pay_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '支付状态(0未支付,1已支付)',
  `pay_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '支付方式',
  `pay_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '支付金额',
  `pay_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '支付单号',
  `pay_at` datetime NULL DEFAULT NULL COMMENT '支付时间',
  `cancel_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '取消状态',
  `cancel_at` datetime NULL DEFAULT NULL COMMENT '取消时间',
  `cancel_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '取消描述',
  `refund_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '退款状态(0未退款,1待退款,2已退款)',
  `refund_at` datetime NULL DEFAULT NULL COMMENT '退款时间',
  `refund_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '退款单号',
  `refund_price` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '退款金额',
  `refund_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '退款描述',
  `express_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '发货状态(0未发货,1已发货,2已签收)',
  `express_company_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '发货快递公司编码',
  `express_company_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '发货快递公司名称',
  `express_send_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '发货单号',
  `express_send_at` datetime NULL DEFAULT NULL COMMENT '发货时间',
  `express_address_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '收货地址ID',
  `express_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货人姓名',
  `express_phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货人手机',
  `express_province` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货地址省份',
  `express_city` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货地址城市',
  `express_area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货地址区域',
  `express_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收货详细地址',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '订单状态(0已取消,1预订单待补全,2新订单待支付,3已支付待发货,4已发货待签收,5已完成)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_groups_order_mid`(`mid`) USING BTREE,
  INDEX `index_store_groups_order_order_no`(`order_no`) USING BTREE,
  INDEX `index_store_groups_order_pay_state`(`pay_state`) USING BTREE,
  INDEX `index_store_groups_order_cancel_state`(`cancel_state`) USING BTREE,
  INDEX `index_store_groups_order_refund_state`(`refund_state`) USING BTREE,
  INDEX `index_store_groups_order_status`(`status`) USING BTREE,
  INDEX `index_store_groups_order_pay_no`(`pay_no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单-记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_order_list
-- ----------------------------
DROP TABLE IF EXISTS `store_order_list`;
CREATE TABLE `store_order_list`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `from_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐会员',
  `order_no` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '订单单号',
  `number` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '交易数量',
  `goods_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品标识',
  `goods_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品标题',
  `goods_logo` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品图标',
  `goods_spec` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_real` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '交易金额',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '销售价格',
  `price_market` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '市场价格',
  `price_express` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '快递费用',
  `price_rate` decimal(20, 4) UNSIGNED NULL DEFAULT 0.0000 COMMENT '分成比例',
  `price_rate_amount` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '分成金额',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_list_id`(`goods_id`) USING BTREE,
  INDEX `index_store_goods_list_spec`(`goods_spec`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单-详情' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_profit_record
-- ----------------------------
DROP TABLE IF EXISTS `store_profit_record`;
CREATE TABLE `store_profit_record`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '来源会员ID',
  `order_no` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '订单单号',
  `order_mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '订单会员ID',
  `order_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '订单金额',
  `profit_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '拥金金额',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_phone`(`profit_price`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '拥金-记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for store_profit_used
-- ----------------------------
DROP TABLE IF EXISTS `store_profit_used`;
CREATE TABLE `store_profit_used`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `appid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `openid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '微信OPENID',
  `trs_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '订单号',
  `pay_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '交易号',
  `pay_desc` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '提现描述',
  `pay_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '提现金额',
  `pay_at` datetime NULL DEFAULT NULL COMMENT '打款时间',
  `last_at` datetime NULL DEFAULT NULL COMMENT '最后处理时间',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '提现状态(0失败,1待打款,2已完成)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_profit_used_openid`(`openid`) USING BTREE,
  INDEX `index_store_profit_used_mid`(`mid`) USING BTREE,
  INDEX `index_store_profit_used_appid`(`appid`) USING BTREE,
  INDEX `index_store_profit_used_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '拥金-提现' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_auth
-- ----------------------------
DROP TABLE IF EXISTS `system_auth`;
CREATE TABLE `system_auth`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '权限名称',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_auth_status`(`status`) USING BTREE,
  INDEX `index_system_auth_title`(`title`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-权限' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auth` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '角色',
  `node` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '节点',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_auth_auth`(`auth`) USING BTREE,
  INDEX `index_system_auth_node`(`node`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-权限-授权' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '配置名',
  `value` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_config_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-配置' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES (1, 'app_name', 'ThinkAdmin');
INSERT INTO `system_config` VALUES (2, 'site_name', 'ThinkAdmin');
INSERT INTO `system_config` VALUES (3, 'app_version', 'v4.0');
INSERT INTO `system_config` VALUES (4, 'site_copy', '©版权所有 2014-2018 楚才科技');
INSERT INTO `system_config` VALUES (5, 'site_icon', 'http://127.0.0.1:8000/upload/f47b8fe06e38ae99/08e8398da45583b9.png');
INSERT INTO `system_config` VALUES (7, 'miitbeian', '粤ICP备16006642号-2');
INSERT INTO `system_config` VALUES (8, 'storage_type', 'local');
INSERT INTO `system_config` VALUES (9, 'storage_local_exts', 'doc,gif,icon,jpg,mp3,mp4,p12,pem,png,rar');
INSERT INTO `system_config` VALUES (10, 'storage_qiniu_bucket', 'https');
INSERT INTO `system_config` VALUES (11, 'storage_qiniu_domain', '用你自己的吧');
INSERT INTO `system_config` VALUES (12, 'storage_qiniu_access_key', '用你自己的吧');
INSERT INTO `system_config` VALUES (13, 'storage_qiniu_secret_key', '用你自己的吧');
INSERT INTO `system_config` VALUES (14, 'storage_oss_bucket', 'cuci-mytest');
INSERT INTO `system_config` VALUES (15, 'storage_oss_endpoint', 'oss-cn-hangzhou.aliyuncs.com');
INSERT INTO `system_config` VALUES (16, 'storage_oss_domain', '用你自己的吧');
INSERT INTO `system_config` VALUES (17, 'storage_oss_keyid', '用你自己的吧');
INSERT INTO `system_config` VALUES (18, 'storage_oss_secret', '用你自己的吧');
INSERT INTO `system_config` VALUES (36, 'storage_oss_is_https', 'http');
INSERT INTO `system_config` VALUES (43, 'storage_qiniu_region', '华东');
INSERT INTO `system_config` VALUES (44, 'storage_qiniu_is_https', 'https');
INSERT INTO `system_config` VALUES (45, 'wechat_mch_id', '1332187001');
INSERT INTO `system_config` VALUES (46, 'wechat_mch_key', 'A82DC5BD1F3359081049C568D8502BC5');
INSERT INTO `system_config` VALUES (47, 'wechat_mch_ssl_type', 'p12');
INSERT INTO `system_config` VALUES (48, 'wechat_mch_ssl_p12', '65b8e4f56718182d/1bc857ee646aa15d.p12');
INSERT INTO `system_config` VALUES (49, 'wechat_mch_ssl_key', '');
INSERT INTO `system_config` VALUES (50, 'wechat_mch_ssl_cer', '');
INSERT INTO `system_config` VALUES (51, 'wechat_token', 'mytoken');
INSERT INTO `system_config` VALUES (52, 'wechat_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES (53, 'wechat_appsecret', '9978422e0e431643d4b42868d183d60b');
INSERT INTO `system_config` VALUES (54, 'wechat_encodingaeskey', '');
INSERT INTO `system_config` VALUES (55, 'wechat_push_url', '消息推送地址：http://127.0.0.1:8000/wechat/api.push');
INSERT INTO `system_config` VALUES (56, 'wechat_type', 'thr');
INSERT INTO `system_config` VALUES (57, 'wechat_thr_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES (58, 'wechat_thr_appkey', '8007da35fd45afe88f2ccc05fe22324d');
INSERT INTO `system_config` VALUES (60, 'wechat_thr_appurl', '消息推送地址：http://127.0.0.1:8000/wechat/api.push');
INSERT INTO `system_config` VALUES (61, 'component_appid', 'wx1b8278fa121d8dc6');
INSERT INTO `system_config` VALUES (62, 'component_appsecret', 'cf5af39408fb3b977584a40d399d298c');
INSERT INTO `system_config` VALUES (63, 'component_token', 'P8QHTIxpBEq88IrxatqhgpBm2OAQROkI');
INSERT INTO `system_config` VALUES (64, 'component_encodingaeskey', 'L5uFIa0U6KLalPyXckyqoVIJYLhsfrg8k9YzybZIHsx');
INSERT INTO `system_config` VALUES (65, 'system_message_state', '0');
INSERT INTO `system_config` VALUES (66, 'sms_zt_username', '可以找CUCI申请');
INSERT INTO `system_config` VALUES (67, 'sms_zt_password', '可以找CUCI申请');
INSERT INTO `system_config` VALUES (68, 'sms_reg_template', '您的验证码为{code}，请在十分钟内完成操作！');
INSERT INTO `system_config` VALUES (69, 'sms_secure', '可以找CUCI申请');

-- ----------------------------
-- Table structure for system_data
-- ----------------------------
DROP TABLE IF EXISTS `system_data`;
CREATE TABLE `system_data`  (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配置名',
  `value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_data_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-数据' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_data
-- ----------------------------
INSERT INTO `system_data` VALUES (1, 'menudata', '[{\"name\":\"请输入名称\",\"type\":\"view\",\"url\":\"3252\"}]');

-- ----------------------------
-- Table structure for system_jobs
-- ----------------------------
DROP TABLE IF EXISTS `system_jobs`;
CREATE TABLE `system_jobs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `attempts` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `reserved` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_at` int(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_jobs_reserved`(`reserved`) USING BTREE,
  INDEX `index_system_jobs_attempts`(`attempts`) USING BTREE,
  INDEX `index_system_jobs_reserved_at`(`reserved_at`) USING BTREE,
  INDEX `index_system_jobs_available_at`(`available_at`) USING BTREE,
  INDEX `index_system_jobs_create_at`(`created_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-任务' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_jobs_log
-- ----------------------------
DROP TABLE IF EXISTS `system_jobs_log`;
CREATE TABLE `system_jobs_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '任务名称',
  `uri` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '任务对象',
  `later` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '任务延时',
  `data` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '任务数据',
  `desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '任务描述',
  `double` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '任务多开',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '任务状态(1新任务,2任务进行中,3任务成功,4任务失败)',
  `status_at` datetime NULL DEFAULT NULL COMMENT '任务状态时间',
  `status_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '任务状态描述',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_jobs_log_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-任务-日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_log
-- ----------------------------
DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `node` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `geoip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `action` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作行为名称',
  `content` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作内容描述',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '父ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '名称',
  `node` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '节点代码',
  `icon` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '链接',
  `params` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '_self' COMMENT '打开方式',
  `sort` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '菜单排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0:禁用,1:启用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_menu_node`(`node`) USING BTREE,
  INDEX `index_system_menu_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-菜单' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES (1, 0, '后台首页', '', '', 'admin/index/main', '', '_self', 100, 1, '2018-09-05 17:59:38');
INSERT INTO `system_menu` VALUES (2, 0, '系统管理', '', '', '#', '', '_self', 300, 1, '2018-09-05 18:04:52');
INSERT INTO `system_menu` VALUES (3, 12, '系统菜单', '', 'layui-icon layui-icon-layouts', 'admin/menu/index', '', '_self', 3, 1, '2018-09-05 18:05:26');
INSERT INTO `system_menu` VALUES (4, 2, '系统配置', '', '', '#', '', '_self', 10, 1, '2018-09-05 18:07:17');
INSERT INTO `system_menu` VALUES (5, 12, '用户管理', '', 'layui-icon layui-icon-username', 'admin/user/index', '', '_self', 4, 1, '2018-09-06 11:10:42');
INSERT INTO `system_menu` VALUES (6, 12, '节点管理', '', 'layui-icon layui-icon-template', 'admin/node/index', '', '_self', 1, 1, '2018-09-06 14:16:13');
INSERT INTO `system_menu` VALUES (7, 12, '权限管理', '', 'layui-icon layui-icon-vercode', 'admin/auth/index', '', '_self', 2, 1, '2018-09-06 15:17:14');
INSERT INTO `system_menu` VALUES (10, 4, '文件存储', '', 'layui-icon layui-icon-template-1', 'admin/config/file', '', '_self', 2, 1, '2018-09-06 16:43:19');
INSERT INTO `system_menu` VALUES (11, 4, '系统参数', '', 'layui-icon layui-icon-set', 'admin/config/info', '', '_self', 1, 1, '2018-09-06 16:43:47');
INSERT INTO `system_menu` VALUES (12, 2, '权限管理', '', '', '#', '', '_self', 20, 1, '2018-09-06 18:01:31');
INSERT INTO `system_menu` VALUES (13, 0, '商城管理', '', '', '#', '', '_self', 200, 1, '2018-10-12 13:56:29');
INSERT INTO `system_menu` VALUES (14, 48, '商品管理', '', 'layui-icon layui-icon-component', 'store/goods/index', '', '_self', 30, 1, '2018-10-12 13:56:48');
INSERT INTO `system_menu` VALUES (16, 0, '微信管理', '', '', '#', '', '_self', 210, 1, '2018-10-31 15:15:27');
INSERT INTO `system_menu` VALUES (17, 16, '微信管理', '', '', '#', '', '_self', 10, 1, '2018-10-31 15:16:46');
INSERT INTO `system_menu` VALUES (18, 17, '微信配置', '', 'layui-icon layui-icon-set', 'wechat/config/options', '', '_self', 1, 1, '2018-10-31 15:17:11');
INSERT INTO `system_menu` VALUES (19, 17, '支付配置', '', 'layui-icon layui-icon-rmb', 'wechat/config/payment', '', '_self', 2, 1, '2018-10-31 18:28:09');
INSERT INTO `system_menu` VALUES (20, 16, '微信定制', '', '', '#', '', '_self', 20, 1, '2018-11-13 11:46:27');
INSERT INTO `system_menu` VALUES (21, 20, '图文管理', '', 'layui-icon layui-icon-template', 'wechat/news/index', '', '_self', 1, 1, '2018-11-13 11:46:55');
INSERT INTO `system_menu` VALUES (22, 20, '粉丝管理', '', 'layui-icon layui-icon-user', 'wechat/fans/index', '', '_self', 2, 1, '2018-11-15 09:51:13');
INSERT INTO `system_menu` VALUES (23, 20, '回复规则', '', 'layui-icon layui-icon-engine', 'wechat/keys/index', '', '_self', 3, 1, '2018-11-22 11:29:08');
INSERT INTO `system_menu` VALUES (24, 20, '关注回复', '', 'layui-icon layui-icon-senior', 'wechat/keys/subscribe', '', '_self', 4, 1, '2018-11-27 11:45:28');
INSERT INTO `system_menu` VALUES (25, 20, '默认回复', '', 'layui-icon layui-icon-survey', 'wechat/keys/defaults', '', '_self', 5, 1, '2018-11-27 11:45:58');
INSERT INTO `system_menu` VALUES (26, 20, '微信菜单', '', 'layui-icon layui-icon-cellphone', 'wechat/menu/index', '', '_self', 6, 1, '2018-11-27 17:56:56');
INSERT INTO `system_menu` VALUES (27, 4, '任务管理', '', 'layui-icon layui-icon-log', 'admin/queue/index', '', '_self', 3, 1, '2018-11-29 11:13:34');
INSERT INTO `system_menu` VALUES (35, 4, '消息管理', '', 'layui-icon layui-icon-notice', 'admin/message/index', '', '_self', 4, 1, '2018-12-24 14:03:52');
INSERT INTO `system_menu` VALUES (37, 0, '开放平台', '', '', '#', '', '_self', 220, 1, '2018-12-28 13:29:25');
INSERT INTO `system_menu` VALUES (38, 40, '开放平台配置', '', 'layui-icon layui-icon-set', 'service/config/index', '', '_self', 0, 1, '2018-12-28 13:29:44');
INSERT INTO `system_menu` VALUES (39, 40, '公众授权管理', '', 'layui-icon layui-icon-template-1', 'service/index/index', '', '_self', 0, 1, '2018-12-28 13:30:07');
INSERT INTO `system_menu` VALUES (40, 37, '开放平台管理', '', '', '#', '', '_self', 0, 1, '2018-12-28 16:05:46');
INSERT INTO `system_menu` VALUES (42, 48, '会员管理', '', 'layui-icon layui-icon-username', 'store/member/index', '', '_self', 50, 1, '2019-01-22 14:24:23');
INSERT INTO `system_menu` VALUES (43, 48, '订单管理', '', 'layui-icon layui-icon-template-1', 'store/order/index', '', '_self', 40, 1, '2019-01-22 14:46:22');
INSERT INTO `system_menu` VALUES (44, 48, '商品分类', '', 'layui-icon layui-icon-app', 'store/goods_cate/index', '', '_self', 20, 1, '2019-01-23 10:41:06');
INSERT INTO `system_menu` VALUES (45, 47, '商城配置', '', 'layui-icon layui-icon-set', 'store/config/index', '', '_self', 10, 1, '2019-01-24 16:47:33');
INSERT INTO `system_menu` VALUES (46, 47, '短信记录', '', 'layui-icon layui-icon-tabs', 'store/message/index', '', '_self', 30, 1, '2019-01-24 18:09:58');
INSERT INTO `system_menu` VALUES (47, 13, '商城配置', '', '', '#', '', '_self', 10, 1, '2019-01-25 16:47:49');
INSERT INTO `system_menu` VALUES (48, 13, '数据管理', '', '', '#', '', '_self', 20, 1, '2019-01-25 16:48:35');
INSERT INTO `system_menu` VALUES (49, 4, '系统日志', '', 'layui-icon layui-icon-form', 'admin/log/index', '', '_self', 5, 1, '2019-02-18 12:56:56');
INSERT INTO `system_menu` VALUES (50, 47, '快递管理', '', 'layui-icon layui-icon-release', 'store/express/index', '', '_self', 40, 1, '2019-04-01 17:10:59');

-- ----------------------------
-- Table structure for system_message
-- ----------------------------
DROP TABLE IF EXISTS `system_message`;
CREATE TABLE `system_message`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '消息编号',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '消息名称',
  `url` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '跳转地址',
  `desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '消息描述',
  `node` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '消息授权',
  `read_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '读取状态',
  `read_uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '读取用户',
  `read_at` datetime NULL DEFAULT NULL COMMENT '读取时间',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '消息状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_message_code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-消息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_node
-- ----------------------------
DROP TABLE IF EXISTS `system_node`;
CREATE TABLE `system_node`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `node` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '节点代码',
  `title` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '节点标题',
  `is_menu` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否可设置为菜单',
  `is_auth` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '是否启动RBAC权限控制',
  `is_login` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '是否启动登录控制',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_node_node`(`node`) USING BTREE,
  INDEX `index_system_node_is_menu`(`is_menu`) USING BTREE,
  INDEX `index_system_node_is_auth`(`is_auth`) USING BTREE,
  INDEX `index_system_node_is_login`(`is_login`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 187 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-节点' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_node
-- ----------------------------
INSERT INTO `system_node` VALUES (1, 'admin', '系统管理', 0, 1, 1, '2018-09-06 14:20:42');
INSERT INTO `system_node` VALUES (2, 'admin/menu', '菜单管理', 0, 1, 1, '2018-09-06 14:23:01');
INSERT INTO `system_node` VALUES (3, 'admin/menu/index', '菜单列表', 1, 1, 1, '2018-09-06 14:23:01');
INSERT INTO `system_node` VALUES (4, 'admin/menu/edit', '编辑菜单', 0, 1, 1, '2018-09-06 14:23:01');
INSERT INTO `system_node` VALUES (5, 'admin/menu/add', '添加菜单', 0, 1, 1, '2018-09-06 14:23:01');
INSERT INTO `system_node` VALUES (6, 'admin/menu/resume', '启用菜单', 0, 1, 1, '2018-09-06 14:23:01');
INSERT INTO `system_node` VALUES (7, 'admin/menu/forbid', '禁用菜单', 0, 1, 1, '2018-09-06 14:23:02');
INSERT INTO `system_node` VALUES (8, 'admin/menu/del', '删除菜单', 0, 1, 1, '2018-09-06 14:23:02');
INSERT INTO `system_node` VALUES (9, 'admin/node/index', '节点列表', 1, 1, 1, '2018-09-06 14:24:20');
INSERT INTO `system_node` VALUES (10, 'admin/node/clear', '清理节点', 0, 1, 1, '2018-09-06 14:24:20');
INSERT INTO `system_node` VALUES (11, 'admin/node/save', '更新节点', 0, 1, 1, '2018-09-06 14:24:20');
INSERT INTO `system_node` VALUES (12, 'admin/user/index', '用户列表', 1, 1, 1, '2018-09-06 14:24:21');
INSERT INTO `system_node` VALUES (13, 'admin/user/auth', '用户授权', 0, 1, 1, '2018-09-06 14:24:21');
INSERT INTO `system_node` VALUES (14, 'admin/user/add', '添加用户', 0, 1, 1, '2018-09-06 14:24:21');
INSERT INTO `system_node` VALUES (15, 'admin/user/edit', '编辑用户', 0, 1, 1, '2018-09-06 14:24:21');
INSERT INTO `system_node` VALUES (16, 'admin/user/pass', '修改密码', 0, 1, 1, '2018-09-06 14:24:22');
INSERT INTO `system_node` VALUES (17, 'admin/user/del', '删除用户', 0, 1, 1, '2018-09-06 14:24:22');
INSERT INTO `system_node` VALUES (18, 'admin/user/forbid', '禁用用户', 0, 1, 1, '2018-09-06 14:24:22');
INSERT INTO `system_node` VALUES (19, 'admin/user/resume', '启用用户', 0, 1, 1, '2018-09-06 14:24:22');
INSERT INTO `system_node` VALUES (20, 'admin/node', '节点管理', 0, 1, 1, '2018-09-06 14:35:36');
INSERT INTO `system_node` VALUES (21, 'admin/user', '用户管理', 0, 1, 1, '2018-09-06 14:36:09');
INSERT INTO `system_node` VALUES (22, 'admin/auth', '权限管理', 0, 1, 1, '2018-09-06 15:16:10');
INSERT INTO `system_node` VALUES (23, 'admin/auth/index', '权限列表', 1, 1, 1, '2018-09-06 15:16:10');
INSERT INTO `system_node` VALUES (24, 'admin/auth/apply', '节点授权', 0, 1, 1, '2018-09-06 15:16:10');
INSERT INTO `system_node` VALUES (25, 'admin/auth/add', '添加授权', 0, 1, 1, '2018-09-06 15:16:10');
INSERT INTO `system_node` VALUES (26, 'admin/auth/edit', '编辑权限', 0, 1, 1, '2018-09-06 15:16:10');
INSERT INTO `system_node` VALUES (27, 'admin/auth/forbid', '禁用权限', 0, 1, 1, '2018-09-06 15:16:11');
INSERT INTO `system_node` VALUES (28, 'admin/auth/resume', '启用权限', 0, 1, 1, '2018-09-06 15:16:11');
INSERT INTO `system_node` VALUES (29, 'admin/auth/del', '删除权限', 0, 1, 1, '2018-09-06 15:16:11');
INSERT INTO `system_node` VALUES (30, 'admin/config', '参数配置', 0, 1, 1, '2018-09-06 16:41:18');
INSERT INTO `system_node` VALUES (32, 'admin/config/file', '文件存储', 1, 1, 1, '2018-09-06 16:41:19');
INSERT INTO `system_node` VALUES (34, 'admin/config/info', '系统信息', 1, 1, 1, '2018-09-06 16:42:10');
INSERT INTO `system_node` VALUES (36, 'store/goods/index', '商品列表', 1, 1, 1, '2018-10-12 13:54:45');
INSERT INTO `system_node` VALUES (37, 'store/goods/add', '添加商品', 0, 1, 1, '2018-10-12 13:54:45');
INSERT INTO `system_node` VALUES (38, 'store/goods/edit', '编辑商品', 0, 1, 1, '2018-10-12 13:54:46');
INSERT INTO `system_node` VALUES (39, 'store', '商城管理', 0, 1, 1, '2018-10-12 13:54:53');
INSERT INTO `system_node` VALUES (40, 'store/goods', '商品管理', 0, 1, 1, '2018-10-12 13:55:20');
INSERT INTO `system_node` VALUES (41, 'store/goods/forbid', '禁用商品', 0, 1, 1, '2018-10-12 16:49:02');
INSERT INTO `system_node` VALUES (42, 'store/goods/resume', '启用商品', 0, 1, 1, '2018-10-16 18:31:42');
INSERT INTO `system_node` VALUES (43, 'store/goods/del', '删除商品', 0, 1, 1, '2018-10-16 18:31:50');
INSERT INTO `system_node` VALUES (44, 'store/goods/stock', '商品入库', 0, 1, 1, '2018-10-22 17:58:37');
INSERT INTO `system_node` VALUES (45, 'wechat', '微信模块', 0, 1, 1, '2018-10-31 15:13:55');
INSERT INTO `system_node` VALUES (46, 'wechat/config', '微信配置', 0, 1, 1, '2018-10-31 15:14:00');
INSERT INTO `system_node` VALUES (51, 'wechat/config/payment', '微信支付', 1, 1, 1, '2018-11-01 11:19:37');
INSERT INTO `system_node` VALUES (53, 'wechat/config/options', '授权配置', 1, 1, 1, '2018-11-01 11:27:55');
INSERT INTO `system_node` VALUES (54, 'wechat/news/index', '图文列表', 1, 1, 1, '2018-11-13 11:45:46');
INSERT INTO `system_node` VALUES (56, 'wechat/news/select', '选择图文', 0, 1, 1, '2018-11-13 11:45:46');
INSERT INTO `system_node` VALUES (57, 'wechat/news/add', '添加图文', 0, 1, 1, '2018-11-13 11:45:47');
INSERT INTO `system_node` VALUES (58, 'wechat/news/edit', '编辑图文', 0, 1, 1, '2018-11-13 11:45:47');
INSERT INTO `system_node` VALUES (59, 'wechat/news/del', '删除图文', 0, 1, 1, '2018-11-13 11:45:47');
INSERT INTO `system_node` VALUES (61, 'wechat/fans/index', '粉丝列表', 1, 1, 1, '2018-11-15 09:50:28');
INSERT INTO `system_node` VALUES (62, 'wechat/fans', '微信粉丝', 0, 1, 1, '2018-11-15 09:50:34');
INSERT INTO `system_node` VALUES (63, 'wechat/news', '微信图文', 0, 1, 1, '2018-11-15 11:31:16');
INSERT INTO `system_node` VALUES (64, 'wechat/fans/sync', '同步粉丝', 0, 1, 1, '2018-11-22 11:27:26');
INSERT INTO `system_node` VALUES (65, 'wechat/keys/index', '回复规则列表', 1, 1, 1, '2018-11-22 11:27:27');
INSERT INTO `system_node` VALUES (66, 'wechat/keys/add', '添加回复规则', 0, 1, 1, '2018-11-22 11:27:27');
INSERT INTO `system_node` VALUES (67, 'wechat/keys/edit', '编辑回复规则', 0, 1, 1, '2018-11-22 11:27:27');
INSERT INTO `system_node` VALUES (68, 'wechat/keys/del', '删除回复规则', 0, 1, 1, '2018-11-22 11:27:27');
INSERT INTO `system_node` VALUES (69, 'wechat/keys/forbid', '禁用回复规则', 0, 1, 1, '2018-11-22 11:27:27');
INSERT INTO `system_node` VALUES (70, 'wechat/keys/resume', '启用回复规则', 0, 1, 1, '2018-11-22 11:27:28');
INSERT INTO `system_node` VALUES (71, 'wechat/keys', '回复规则管理', 0, 1, 1, '2018-11-23 10:26:06');
INSERT INTO `system_node` VALUES (72, 'wechat/keys/subscribe', '关注回复规则', 1, 1, 1, '2018-11-27 11:43:27');
INSERT INTO `system_node` VALUES (73, 'wechat/keys/defaults', '默认回复规则', 1, 1, 1, '2018-11-27 11:43:27');
INSERT INTO `system_node` VALUES (74, 'wechat/fans/setblack', '拉黑粉丝', 0, 1, 1, '2018-11-27 16:23:21');
INSERT INTO `system_node` VALUES (75, 'wechat/fans/delblack', '取消拉黑', 0, 1, 1, '2018-11-27 16:23:21');
INSERT INTO `system_node` VALUES (76, 'wechat/menu/index', '微信菜单显示', 1, 1, 1, '2018-11-27 17:56:28');
INSERT INTO `system_node` VALUES (77, 'wechat/menu/edit', '更新微信菜单', 0, 1, 1, '2018-11-27 17:56:28');
INSERT INTO `system_node` VALUES (78, 'wechat/menu/cancel', '取消微信菜单', 0, 1, 1, '2018-11-27 17:56:29');
INSERT INTO `system_node` VALUES (79, 'wechat/menu', '微信菜单管理', 0, 1, 1, '2018-11-28 16:03:03');
INSERT INTO `system_node` VALUES (80, 'admin/queue/index', '任务列表', 1, 1, 1, '2018-11-29 11:12:54');
INSERT INTO `system_node` VALUES (81, 'admin/queue', '任务管理', 0, 1, 1, '2018-11-29 11:13:05');
INSERT INTO `system_node` VALUES (82, 'admin/queue/redo', '重启任务', 0, 1, 1, '2018-11-29 15:17:43');
INSERT INTO `system_node` VALUES (83, 'admin/queue/del', '删除任务', 0, 1, 1, '2018-12-04 15:16:59');
INSERT INTO `system_node` VALUES (114, 'admin/message/index', '消息管理', 1, 1, 1, '2018-12-24 14:03:09');
INSERT INTO `system_node` VALUES (115, 'admin/message', '消息管理', 0, 1, 1, '2018-12-24 14:03:14');
INSERT INTO `system_node` VALUES (116, 'admin/message/state', '消息状态', 0, 1, 1, '2018-12-24 18:41:37');
INSERT INTO `system_node` VALUES (117, 'admin/message/del', '删除消息', 0, 1, 1, '2018-12-24 18:41:37');
INSERT INTO `system_node` VALUES (118, 'service', '开放平台', 0, 1, 1, '2018-12-28 13:27:38');
INSERT INTO `system_node` VALUES (119, 'service/config', '开放平台', 0, 1, 1, '2018-12-28 13:27:41');
INSERT INTO `system_node` VALUES (120, 'service/config/index', '开放平台配置', 1, 1, 1, '2018-12-28 13:27:42');
INSERT INTO `system_node` VALUES (121, 'service/index/index', '公众号授权列表', 1, 1, 1, '2018-12-28 13:27:42');
INSERT INTO `system_node` VALUES (122, 'service/index/sync', '同步公众号授权', 0, 1, 1, '2018-12-28 13:27:42');
INSERT INTO `system_node` VALUES (123, 'service/index/syncall', '公众号所有授权', 0, 1, 1, '2018-12-28 13:27:43');
INSERT INTO `system_node` VALUES (124, 'service/index/del', '删除公众号授权', 0, 1, 1, '2018-12-28 13:27:43');
INSERT INTO `system_node` VALUES (125, 'service/index/forbid', '禁用公众号授权', 0, 1, 1, '2018-12-28 13:27:43');
INSERT INTO `system_node` VALUES (126, 'service/index/resume', '启用公众号授权', 0, 1, 1, '2018-12-28 13:27:43');
INSERT INTO `system_node` VALUES (127, 'service/index', '公众号授权管理', 0, 1, 1, '2018-12-28 13:27:59');
INSERT INTO `system_node` VALUES (147, 'admin/message/clear', '清理消息', 0, 1, 1, '2019-01-05 13:23:49');
INSERT INTO `system_node` VALUES (148, 'admin/message/onoff', '消息开关', 0, 1, 1, '2019-01-05 13:23:49');
INSERT INTO `system_node` VALUES (149, 'store/page/index', '页面管理', 1, 1, 1, '2019-01-18 09:58:00');
INSERT INTO `system_node` VALUES (150, 'store/page/add', '添加页面', 0, 1, 1, '2019-01-18 09:58:00');
INSERT INTO `system_node` VALUES (151, 'store/page/edit', '编辑页面', 0, 1, 1, '2019-01-18 09:58:00');
INSERT INTO `system_node` VALUES (152, 'store/page/forbid', '禁用页面', 0, 1, 1, '2019-01-18 09:58:00');
INSERT INTO `system_node` VALUES (153, 'store/page/resume', '启用页面', 0, 1, 1, '2019-01-18 09:58:01');
INSERT INTO `system_node` VALUES (154, 'store/page/del', '删除页面', 0, 1, 1, '2019-01-18 09:58:01');
INSERT INTO `system_node` VALUES (155, 'store/page', '页面管理', 0, 1, 1, '2019-01-18 09:58:07');
INSERT INTO `system_node` VALUES (156, 'store/member/index', '商城会员管理', 1, 1, 1, '2019-01-22 14:23:55');
INSERT INTO `system_node` VALUES (157, 'store/member', '商城会员管理', 0, 1, 1, '2019-01-22 14:24:02');
INSERT INTO `system_node` VALUES (158, 'store/order/index', '商城订单管理', 1, 1, 1, '2019-01-22 14:45:52');
INSERT INTO `system_node` VALUES (159, 'store/order', '商城订单管理', 0, 1, 1, '2019-01-22 14:45:59');
INSERT INTO `system_node` VALUES (160, 'store/goods_cate/index', '商品分类管理', 1, 1, 1, '2019-01-23 10:39:54');
INSERT INTO `system_node` VALUES (161, 'store/goods_cate/add', '添加商品分类', 0, 1, 1, '2019-01-23 10:39:54');
INSERT INTO `system_node` VALUES (162, 'store/goods_cate/edit', '编辑商品分类', 0, 1, 1, '2019-01-23 10:39:54');
INSERT INTO `system_node` VALUES (163, 'store/goods_cate/forbid', '禁用商品分类', 0, 1, 1, '2019-01-23 10:39:55');
INSERT INTO `system_node` VALUES (164, 'store/goods_cate/resume', '启用商品分类', 0, 1, 1, '2019-01-23 10:39:55');
INSERT INTO `system_node` VALUES (165, 'store/goods_cate/del', '删除商品分类', 0, 1, 1, '2019-01-23 10:39:55');
INSERT INTO `system_node` VALUES (166, 'store/goods_cate', '商品分类', 0, 1, 1, '2019-01-23 10:40:01');
INSERT INTO `system_node` VALUES (167, 'store/config/index', '商城配置', 1, 1, 1, '2019-01-24 16:47:01');
INSERT INTO `system_node` VALUES (168, 'store/config', '商城配置', 0, 1, 1, '2019-01-24 16:47:09');
INSERT INTO `system_node` VALUES (169, 'store/message/index', '短信消息', 1, 1, 1, '2019-01-24 18:09:05');
INSERT INTO `system_node` VALUES (170, 'store/message', '短信消息', 0, 1, 1, '2019-01-24 18:09:12');
INSERT INTO `system_node` VALUES (171, 'admin/log/index', '日志管理列表', 1, 1, 1, '2019-02-18 12:56:07');
INSERT INTO `system_node` VALUES (172, 'admin/log/del', '删除日志管理', 0, 1, 1, '2019-02-18 12:56:07');
INSERT INTO `system_node` VALUES (173, 'admin/log', '系统日志管理', 0, 1, 1, '2019-02-18 12:56:15');
INSERT INTO `system_node` VALUES (176, 'wechat/fans/del', '删除粉丝', 0, 1, 1, '2019-03-18 10:58:10');
INSERT INTO `system_node` VALUES (177, 'service/index/clearquota', '清空调用次数', 0, 1, 1, '2019-03-30 16:39:17');
INSERT INTO `system_node` VALUES (178, 'store/express/index', '快递公司管理', 1, 1, 1, '2019-04-01 17:09:27');
INSERT INTO `system_node` VALUES (179, 'store/express/add', '添加快递公司', 0, 1, 1, '2019-04-01 17:09:27');
INSERT INTO `system_node` VALUES (180, 'store/express/edit', '编辑快递公司', 0, 1, 1, '2019-04-01 17:09:27');
INSERT INTO `system_node` VALUES (181, 'store/express/forbid', '禁用快递公司', 0, 1, 1, '2019-04-01 17:09:27');
INSERT INTO `system_node` VALUES (182, 'store/express/resume', '启用快递公司', 0, 1, 1, '2019-04-01 17:09:28');
INSERT INTO `system_node` VALUES (183, 'store/express/del', '删除快递公司', 0, 1, 1, '2019-04-01 17:09:28');
INSERT INTO `system_node` VALUES (184, 'store/order/express', '商城订单发货', 0, 1, 1, '2019-04-01 17:09:30');
INSERT INTO `system_node` VALUES (185, 'store/order/expressquery', '商城快递查询', 0, 1, 1, '2019-04-01 17:09:30');
INSERT INTO `system_node` VALUES (186, 'store/express', '快递公司管理', 0, 1, 1, '2019-04-01 17:09:55');

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户账号',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户密码',
  `qq` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '联系QQ',
  `mail` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '联系邮箱',
  `phone` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '联系手机号',
  `login_at` datetime NULL DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '登录IP',
  `login_num` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '登录次数',
  `authorize` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '权限授权',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0:禁用,1:启用)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除(1:删除,0:未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `index_system_user_username`(`username`) USING BTREE,
  INDEX `index_system_user_status`(`status`) USING BTREE,
  INDEX `index_system_user_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统-用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES (10000, 'admin', '21232f297a57a5a743894a0e4a801fc3', '22222222', '', '', '2019-04-01 16:55:15', '127.0.0.1', 500, '', '', 1, 0, '2015-11-13 15:14:22');

-- ----------------------------
-- Table structure for wechat_fans
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans`;
CREATE TABLE `wechat_fans`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `unionid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '粉丝unionid',
  `openid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '粉丝openid',
  `tagid_list` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '粉丝标签id',
  `is_black` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否为黑名单状态',
  `subscribe` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '关注状态(0未关注,1已关注)',
  `nickname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户昵称',
  `sex` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '用户性别(1男性,2女性,0未知)',
  `country` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户所在国家',
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户所在省份',
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户所在城市',
  `language` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户的语言(zh_CN)',
  `headimgurl` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户头像',
  `subscribe_time` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '关注时间',
  `subscribe_at` datetime NULL DEFAULT NULL COMMENT '关注时间',
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '备注',
  `subscribe_scene` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '扫码关注场景',
  `qr_scene` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '二维码场景值',
  `qr_scene_str` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '二维码场景内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_fans_openid`(`openid`) USING BTREE,
  INDEX `index_wechat_fans_unionid`(`unionid`) USING BTREE,
  INDEX `index_wechat_fans_is_back`(`is_black`) USING BTREE,
  INDEX `index_wechat_fans_subscribe`(`subscribe`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-粉丝' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wechat_fans_tags
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans_tags`;
CREATE TABLE `wechat_fans_tags`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `appid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `name` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签名称',
  `count` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '总数',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  INDEX `index_wechat_fans_tags_id`(`id`) USING BTREE,
  INDEX `index_wechat_fans_tags_appid`(`appid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-粉丝-标签' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wechat_keys
-- ----------------------------
DROP TABLE IF EXISTS `wechat_keys`;
CREATE TABLE `wechat_keys`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '类型，text 文件消息，image 图片消息，news 图文消息',
  `keys` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关键字',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '文本内容',
  `image_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片链接',
  `voice_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '语音链接',
  `music_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '音乐标题',
  `music_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '音乐链接',
  `music_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '音乐缩略图链接',
  `music_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '音乐描述',
  `video_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '视频标题',
  `video_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '视频URL',
  `video_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '视频描述',
  `news_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '图文ID',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序字段',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '0 禁用，1 启用',
  `create_by` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_keys_appid`(`appid`) USING BTREE,
  INDEX `index_wechat_keys_type`(`type`) USING BTREE,
  INDEX `index_wechat_keys_keys`(`keys`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-关键字' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wechat_media
-- ----------------------------
DROP TABLE IF EXISTS `wechat_media`;
CREATE TABLE `wechat_media`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号ID',
  `md5` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文件md5',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '媒体类型',
  `media_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '本地文件链接',
  `media_url` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_media_appid`(`appid`) USING BTREE,
  INDEX `index_wechat_media_md5`(`md5`) USING BTREE,
  INDEX `index_wechat_media_type`(`type`) USING BTREE,
  INDEX `index_wechat_media_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-素材' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news`;
CREATE TABLE `wechat_news`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '永久素材显示URL',
  `article_id` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关联图文ID，用，号做分割',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否删除',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_news_artcle_id`(`article_id`) USING BTREE,
  INDEX `index_wechat_news_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-图文' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wechat_news_article
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_article`;
CREATE TABLE `wechat_news_article`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '素材标题',
  `local_url` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) UNSIGNED NULL DEFAULT 0 COMMENT '显示封面(0 不显示, 1 显示)',
  `author` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '作者',
  `digest` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '摘要内容',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '图文内容',
  `content_source_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '原文地址',
  `read_num` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '阅读量',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-图文-文章' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wechat_service_config
-- ----------------------------
DROP TABLE IF EXISTS `wechat_service_config`;
CREATE TABLE `wechat_service_config`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `authorizer_appid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `authorizer_access_token` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号授权Token',
  `authorizer_refresh_token` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号刷新Token',
  `func_info` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号集权',
  `nick_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号昵称',
  `head_img` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号头像',
  `expires_in` bigint(20) NULL DEFAULT NULL COMMENT 'Token有效时间',
  `service_type` tinyint(2) NULL DEFAULT NULL COMMENT '微信类型(0代表订阅号,2代表服务号,3代表小程序)',
  `service_type_info` tinyint(2) NULL DEFAULT NULL COMMENT '公众号实际类型',
  `verify_type` tinyint(2) NULL DEFAULT NULL COMMENT '公众号认证类型(-1代表未认证, 0代表微信认证)',
  `verify_type_info` tinyint(2) NULL DEFAULT NULL COMMENT '公众号实际认证类型',
  `user_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '众众号原始账号',
  `alias` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号别名',
  `qrcode_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公众号二维码',
  `business_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `principal_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公司名称',
  `miniprograminfo` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '小程序JSON',
  `idc` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `signature` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '小程序的描述',
  `total` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '统计调用次数',
  `appkey` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '应用接口KEY',
  `appuri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '应用接口URI',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(1正常授权,0取消授权)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删除,1已删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `index_wechat_service_config_authorizer_appid`(`authorizer_appid`) USING BTREE,
  INDEX `index_wechat_service_config_status`(`status`) USING BTREE,
  INDEX `index_wechat_service_config_is_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信-授权' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
