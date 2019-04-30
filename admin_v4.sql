/*
 Navicat Premium Data Transfer

 Source Server         : local.server.cuci.cc
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : server.cuci.cc:3306
 Source Schema         : ThinkAdmin

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 30/04/2019 17:30:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for store_express_company
-- ----------------------------
DROP TABLE IF EXISTS `store_express_company`;
CREATE TABLE `store_express_company`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `express_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `express_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司代码',
  `express_desc` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0.无效,1.有效)',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(1删除,0未删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 95 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城-快递-公司';

-- ----------------------------
-- Records of store_express_company
-- ----------------------------
INSERT INTO `store_express_company` VALUES (5, 'AAE全球专递', 'aae', NULL, 0, 0, 0, '2017-09-12 11:53:40');
INSERT INTO `store_express_company` VALUES (6, '安捷快递', 'anjie', '', 0, 0, 0, '2017-09-13 15:27:26');
INSERT INTO `store_express_company` VALUES (7, '安信达快递', 'anxindakuaixi', NULL, 0, 0, 0, '2017-09-13 16:05:19');
INSERT INTO `store_express_company` VALUES (8, '彪记快递', 'biaojikuaidi', NULL, 0, 0, 0, '2017-09-13 16:05:26');
INSERT INTO `store_express_company` VALUES (9, 'BHT', 'bht', '', 0, 0, 0, '2017-09-13 16:05:37');
INSERT INTO `store_express_company` VALUES (10, '百福东方国际物流', 'baifudongfang', NULL, 0, 0, 0, '2017-09-13 16:05:41');
INSERT INTO `store_express_company` VALUES (11, '中国东方（COE）', 'coe', NULL, 0, 0, 0, '2017-09-13 16:05:48');
INSERT INTO `store_express_company` VALUES (12, '长宇物流', 'changyuwuliu', NULL, 0, 0, 0, '2017-09-13 16:05:58');
INSERT INTO `store_express_company` VALUES (13, '大田物流', 'datianwuliu', NULL, 0, 0, 0, '2017-09-13 16:06:06');
INSERT INTO `store_express_company` VALUES (14, '德邦物流', 'debangwuliu', '', 1, 1, 0, '2017-09-13 16:06:14');
INSERT INTO `store_express_company` VALUES (15, 'DHL', 'dhl', NULL, 0, 0, 0, '2017-09-13 16:06:24');
INSERT INTO `store_express_company` VALUES (16, 'DPEX', 'dpex', NULL, 0, 0, 0, '2017-09-13 16:06:29');
INSERT INTO `store_express_company` VALUES (17, 'd速快递', 'dsukuaidi', NULL, 0, 0, 0, '2017-09-13 16:06:34');
INSERT INTO `store_express_company` VALUES (18, '递四方', 'disifang', NULL, 0, 0, 0, '2017-09-13 16:06:40');
INSERT INTO `store_express_company` VALUES (19, 'EMS快递', 'ems', '', 1, 0, 0, '2017-09-13 16:06:47');
INSERT INTO `store_express_company` VALUES (20, 'FEDEX（国外）', 'fedex', NULL, 0, 0, 0, '2017-09-13 16:06:56');
INSERT INTO `store_express_company` VALUES (21, '飞康达物流', 'feikangda', NULL, 0, 0, 0, '2017-09-13 16:07:03');
INSERT INTO `store_express_company` VALUES (22, '凤凰快递', 'fenghuangkuaidi', NULL, 0, 0, 0, '2017-09-13 16:07:10');
INSERT INTO `store_express_company` VALUES (23, '飞快达', 'feikuaida', NULL, 0, 0, 0, '2017-09-13 16:07:16');
INSERT INTO `store_express_company` VALUES (24, '国通快递', 'guotongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:07:27');
INSERT INTO `store_express_company` VALUES (25, '港中能达物流', 'ganzhongnengda', NULL, 0, 0, 0, '2017-09-13 16:07:33');
INSERT INTO `store_express_company` VALUES (26, '广东邮政物流', 'guangdongyouzhengwuliu', NULL, 0, 0, 0, '2017-09-13 16:08:22');
INSERT INTO `store_express_company` VALUES (27, '共速达', 'gongsuda', NULL, 0, 0, 0, '2017-09-13 16:08:48');
INSERT INTO `store_express_company` VALUES (28, '汇通快运', 'huitongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:08:56');
INSERT INTO `store_express_company` VALUES (29, '恒路物流', 'hengluwuliu', NULL, 0, 0, 0, '2017-09-13 16:09:02');
INSERT INTO `store_express_company` VALUES (30, '华夏龙物流', 'huaxialongwuliu', NULL, 0, 0, 0, '2017-09-13 16:09:12');
INSERT INTO `store_express_company` VALUES (31, '海红', 'haihongwangsong', NULL, 0, 0, 0, '2017-09-13 16:09:20');
INSERT INTO `store_express_company` VALUES (32, '海外环球', 'haiwaihuanqiu', NULL, 0, 0, 0, '2017-09-13 16:09:27');
INSERT INTO `store_express_company` VALUES (33, '佳怡物流', 'jiayiwuliu', NULL, 0, 0, 0, '2017-09-13 16:09:35');
INSERT INTO `store_express_company` VALUES (34, '京广速递', 'jinguangsudikuaijian', NULL, 0, 0, 0, '2017-09-13 16:09:42');
INSERT INTO `store_express_company` VALUES (35, '急先达', 'jixianda', NULL, 0, 0, 0, '2017-09-13 16:09:49');
INSERT INTO `store_express_company` VALUES (36, '佳吉物流', 'jjwl', NULL, 0, 0, 0, '2017-09-13 16:10:01');
INSERT INTO `store_express_company` VALUES (37, '加运美物流', 'jymwl', NULL, 0, 0, 0, '2017-09-13 16:10:13');
INSERT INTO `store_express_company` VALUES (38, '金大物流', 'jindawuliu', NULL, 0, 0, 0, '2017-09-13 16:10:22');
INSERT INTO `store_express_company` VALUES (39, '嘉里大通', 'jialidatong', NULL, 0, 0, 0, '2017-09-13 16:10:33');
INSERT INTO `store_express_company` VALUES (40, '晋越快递', 'jykd', NULL, 0, 0, 0, '2017-09-13 16:10:40');
INSERT INTO `store_express_company` VALUES (41, '快捷速递', 'kuaijiesudi', NULL, 0, 0, 0, '2017-09-13 16:10:49');
INSERT INTO `store_express_company` VALUES (42, '联邦快递（国内）', 'lianb', NULL, 0, 0, 0, '2017-09-13 16:10:58');
INSERT INTO `store_express_company` VALUES (43, '联昊通物流', 'lianhaowuliu', NULL, 0, 0, 0, '2017-09-13 16:11:07');
INSERT INTO `store_express_company` VALUES (44, '龙邦物流', 'longbanwuliu', NULL, 0, 0, 0, '2017-09-13 16:11:15');
INSERT INTO `store_express_company` VALUES (45, '立即送', 'lijisong', NULL, 0, 0, 0, '2017-09-13 16:11:25');
INSERT INTO `store_express_company` VALUES (46, '乐捷递', 'lejiedi', NULL, 0, 0, 0, '2017-09-13 16:11:36');
INSERT INTO `store_express_company` VALUES (47, '民航快递', 'minghangkuaidi', NULL, 0, 0, 0, '2017-09-13 16:11:45');
INSERT INTO `store_express_company` VALUES (48, '美国快递', 'meiguokuaidi', NULL, 0, 0, 0, '2017-09-13 16:11:53');
INSERT INTO `store_express_company` VALUES (49, '门对门', 'menduimen', NULL, 0, 0, 0, '2017-09-13 16:12:01');
INSERT INTO `store_express_company` VALUES (50, 'OCS', 'ocs', NULL, 0, 0, 0, '2017-09-13 16:12:10');
INSERT INTO `store_express_company` VALUES (51, '配思货运', 'peisihuoyunkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:18');
INSERT INTO `store_express_company` VALUES (52, '全晨快递', 'quanchenkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:26');
INSERT INTO `store_express_company` VALUES (53, '全峰快递', 'quanfengkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:34');
INSERT INTO `store_express_company` VALUES (54, '全际通物流', 'quanjitong', NULL, 0, 0, 0, '2017-09-13 16:12:41');
INSERT INTO `store_express_company` VALUES (55, '全日通快递', 'quanritongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:49');
INSERT INTO `store_express_company` VALUES (56, '全一快递', 'quanyikuaidi', NULL, 0, 0, 0, '2017-09-13 16:12:56');
INSERT INTO `store_express_company` VALUES (57, '如风达', 'rufengda', NULL, 0, 0, 0, '2017-09-13 16:13:03');
INSERT INTO `store_express_company` VALUES (58, '三态速递', 'santaisudi', NULL, 0, 0, 0, '2017-09-13 16:13:15');
INSERT INTO `store_express_company` VALUES (59, '盛辉物流', 'shenghuiwuliu', NULL, 0, 0, 0, '2017-09-13 16:13:22');
INSERT INTO `store_express_company` VALUES (60, '申通', 'shentong', NULL, 0, 0, 0, '2017-09-13 16:13:34');
INSERT INTO `store_express_company` VALUES (61, '顺丰', 'shunfeng', '', 0, 0, 0, '2017-09-13 16:13:41');
INSERT INTO `store_express_company` VALUES (62, '速尔物流', 'sue', NULL, 0, 0, 0, '2017-09-13 16:13:48');
INSERT INTO `store_express_company` VALUES (63, '盛丰物流', 'shengfeng', NULL, 0, 0, 0, '2017-09-13 16:13:55');
INSERT INTO `store_express_company` VALUES (64, '赛澳递', 'saiaodi', NULL, 0, 0, 0, '2017-09-13 16:14:02');
INSERT INTO `store_express_company` VALUES (65, '天地华宇', 'tiandihuayu', NULL, 0, 0, 0, '2017-09-13 16:14:11');
INSERT INTO `store_express_company` VALUES (66, '天天快递', 'tiantian', NULL, 0, 0, 0, '2017-09-13 16:14:19');
INSERT INTO `store_express_company` VALUES (67, 'TNT', 'tnt', NULL, 0, 0, 0, '2017-09-13 16:14:26');
INSERT INTO `store_express_company` VALUES (68, 'UPS', 'ups', NULL, 0, 0, 0, '2017-09-13 16:14:29');
INSERT INTO `store_express_company` VALUES (69, '万家物流', 'wanjiawuliu', NULL, 0, 0, 0, '2017-09-13 16:14:37');
INSERT INTO `store_express_company` VALUES (70, '文捷航空速递', 'wenjiesudi', NULL, 0, 0, 0, '2017-09-13 16:14:46');
INSERT INTO `store_express_company` VALUES (71, '伍圆', 'wuyuan', NULL, 0, 0, 0, '2017-09-13 16:14:52');
INSERT INTO `store_express_company` VALUES (72, '万象物流', 'wxwl', NULL, 0, 0, 0, '2017-09-13 16:15:00');
INSERT INTO `store_express_company` VALUES (73, '新邦物流', 'xinbangwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:06');
INSERT INTO `store_express_company` VALUES (74, '信丰物流', 'xinfengwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:15');
INSERT INTO `store_express_company` VALUES (75, '亚风速递', 'yafengsudi', NULL, 0, 0, 0, '2017-09-13 16:15:23');
INSERT INTO `store_express_company` VALUES (76, '一邦速递', 'yibangwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:30');
INSERT INTO `store_express_company` VALUES (77, '优速物流', 'youshuwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:36');
INSERT INTO `store_express_company` VALUES (78, '邮政包裹挂号信', 'youzhengguonei', NULL, 0, 3, 0, '2017-09-13 16:15:44');
INSERT INTO `store_express_company` VALUES (79, '邮政国际包裹挂号信', 'youzhengguoji', NULL, 0, 2, 0, '2017-09-13 16:15:51');
INSERT INTO `store_express_company` VALUES (80, '远成物流', 'yuanchengwuliu', NULL, 0, 0, 0, '2017-09-13 16:15:57');
INSERT INTO `store_express_company` VALUES (81, '圆通速递', 'yuantong', '', 1, 1, 0, '2017-09-13 16:16:03');
INSERT INTO `store_express_company` VALUES (82, '源伟丰快递', 'yuanweifeng', NULL, 0, 0, 0, '2017-09-13 16:16:10');
INSERT INTO `store_express_company` VALUES (83, '元智捷诚快递', 'yuanzhijiecheng', NULL, 0, 0, 0, '2017-09-13 16:16:17');
INSERT INTO `store_express_company` VALUES (84, '韵达快运', 'yunda', NULL, 0, 0, 0, '2017-09-13 16:16:24');
INSERT INTO `store_express_company` VALUES (85, '运通快递', 'yuntongkuaidi', NULL, 0, 0, 0, '2017-09-13 16:16:33');
INSERT INTO `store_express_company` VALUES (86, '越丰物流', 'yuefengwuliu', NULL, 0, 0, 0, '2017-09-13 16:16:40');
INSERT INTO `store_express_company` VALUES (87, '源安达', 'yad', NULL, 0, 0, 0, '2017-09-13 16:16:47');
INSERT INTO `store_express_company` VALUES (88, '银捷速递', 'yinjiesudi', NULL, 0, 0, 0, '2017-09-13 16:16:56');
INSERT INTO `store_express_company` VALUES (89, '宅急送', 'zhaijisong', NULL, 0, 0, 0, '2017-09-13 16:17:03');
INSERT INTO `store_express_company` VALUES (90, '中铁快运', 'zhongtiekuaiyun', NULL, 0, 0, 0, '2017-09-13 16:17:10');
INSERT INTO `store_express_company` VALUES (91, '中通速递', 'zhongtong', '', 0, 0, 0, '2017-09-13 16:17:16');
INSERT INTO `store_express_company` VALUES (92, '中邮物流', 'zhongyouwuliu', NULL, 0, 0, 0, '2017-09-13 16:17:27');
INSERT INTO `store_express_company` VALUES (93, '忠信达', 'zhongxinda', NULL, 0, 0, 0, '2017-09-13 16:17:34');
INSERT INTO `store_express_company` VALUES (94, '芝麻开门', 'zhimakaimen', '', 0, 0, 0, '2017-09-13 16:17:41');

-- ----------------------------
-- Table structure for store_express_province
-- ----------------------------
DROP TABLE IF EXISTS `store_express_province`;
CREATE TABLE `store_express_province`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地区名称',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权限',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '数据状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_express_province_title`(`title`) USING BTREE,
  INDEX `index_store_express_province_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3261 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-快递-省份';

-- ----------------------------
-- Records of store_express_province
-- ----------------------------
INSERT INTO `store_express_province` VALUES (1, '北京市', 1, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (19, '天津市', 2, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (37, '河北省', 3, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (217, '山西省', 4, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (348, '内蒙古自治区', 5, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (464, '辽宁省', 6, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (579, '吉林省', 7, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (649, '黑龙江省', 8, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (792, '上海市', 9, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (810, '江苏省', 10, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (920, '浙江省', 11, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1021, '安徽省', 12, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1143, '福建省', 13, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1238, '江西省', 14, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1350, '山东省', 15, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1505, '河南省', 16, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1681, '湖北省', 17, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1798, '湖南省', 18, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (1935, '广东省', 19, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2079, '广西壮族自治区', 20, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2205, '海南省', 21, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2236, '重庆市', 22, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2277, '四川省', 23, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2482, '贵州省', 24, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2580, '云南省', 25, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2726, '西藏自治区', 26, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2808, '陕西省', 27, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (2926, '甘肃省', 28, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (3027, '青海省', 29, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (3080, '宁夏回族自治区', 30, 1, '2017-09-12 11:53:40');
INSERT INTO `store_express_province` VALUES (3108, '新疆维吾尔自治区', 31, 1, '2017-09-12 11:53:40');

-- ----------------------------
-- Table structure for store_express_template
-- ----------------------------
DROP TABLE IF EXISTS `store_express_template`;
CREATE TABLE `store_express_template`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '省份规则内容',
  `order_reduction_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '订单满减状态',
  `order_reduction_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '订单满减金额',
  `first_number` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '首件数量',
  `first_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '首件邮费',
  `next_number` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '续件数量',
  `next_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '续件邮费',
  `is_default` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '默认规则',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_express_template_is_default`(`is_default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-快递-模板';

-- ----------------------------
-- Table structure for store_goods
-- ----------------------------
DROP TABLE IF EXISTS `store_goods`;
CREATE TABLE `store_goods`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品分类',
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品标题',
  `logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品图标',
  `specs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格JSON',
  `lists` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品列表JSON',
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品图片',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品内容',
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品-记录';

-- ----------------------------
-- Table structure for store_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `store_goods_cate`;
CREATE TABLE `store_goods_cate`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类图标',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `desc` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '销售状态',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_cate_is_deleted`(`is_deleted`) USING BTREE,
  INDEX `index_store_goods_cate_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品-分类';

-- ----------------------------
-- Table structure for store_goods_list
-- ----------------------------
DROP TABLE IF EXISTS `store_goods_list`;
CREATE TABLE `store_goods_list`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品ID',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_market` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品标价',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品售价',
  `number_sales` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '销售数量',
  `number_stock` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品库存',
  `number_virtual` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '虚拟销量',
  `number_express` bigint(20) UNSIGNED NULL DEFAULT 1 COMMENT '快递数量',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_list_id`(`goods_id`) USING BTREE,
  INDEX `index_store_goods_list_spec`(`goods_spec`) USING BTREE,
  INDEX `index_store_goods_list_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品-详情';

-- ----------------------------
-- Table structure for store_goods_stock
-- ----------------------------
DROP TABLE IF EXISTS `store_goods_stock`;
CREATE TABLE `store_goods_stock`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品ID',
  `goods_spec` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `number_stock` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品库存',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_stock_gid`(`goods_id`) USING BTREE,
  INDEX `index_store_goods_stock_spec`(`goods_spec`(191)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品-入库';

-- ----------------------------
-- Table structure for store_member
-- ----------------------------
DROP TABLE IF EXISTS `store_member`;
CREATE TABLE `store_member`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '微信OPENID',
  `headimg` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '头像地址',
  `nickname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '微信昵称',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系手机',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '真实姓名',
  `vip_level` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '会员级别(0游客,1为临时,2为VIP1,3为VIP2)',
  `vip_date` date NULL DEFAULT NULL COMMENT '保级日期',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_openid`(`openid`) USING BTREE,
  INDEX `index_store_member_phone`(`phone`) USING BTREE,
  INDEX `index_store_member_vip_level`(`vip_level`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '会员-记录';

-- ----------------------------
-- Table structure for store_member_address
-- ----------------------------
DROP TABLE IF EXISTS `store_member_address`;
CREATE TABLE `store_member_address`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货姓名',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货手机',
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-省份',
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-城市',
  `area` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-区域',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-详情',
  `is_default` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '默认地址',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_address_mid`(`mid`) USING BTREE,
  INDEX `index_store_member_address_is_default`(`is_default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '会员-地址';

-- ----------------------------
-- Table structure for store_member_sms_history
-- ----------------------------
DROP TABLE IF EXISTS `store_member_sms_history`;
CREATE TABLE `store_member_sms_history`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '目标手机',
  `content` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '短信内容',
  `result` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '返回结果',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_member_sms_history_phone`(`phone`) USING BTREE,
  INDEX `index_store_member_sms_history_mid`(`mid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '会员-短信';

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
  `pay_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付方式',
  `pay_price` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '支付金额',
  `pay_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付单号',
  `pay_at` datetime NULL DEFAULT NULL COMMENT '支付时间',
  `cancel_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '取消状态',
  `cancel_at` datetime NULL DEFAULT NULL COMMENT '取消时间',
  `cancel_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '取消描述',
  `refund_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '退款状态(0未退款,1待退款,2已退款)',
  `refund_at` datetime NULL DEFAULT NULL COMMENT '退款时间',
  `refund_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '退款单号',
  `refund_price` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '退款金额',
  `refund_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '退款描述',
  `express_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '发货状态(0未发货,1已发货,2已签收)',
  `express_company_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '发货快递公司编码',
  `express_company_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '发货快递公司名称',
  `express_send_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '发货单号',
  `express_send_at` datetime NULL DEFAULT NULL COMMENT '发货时间',
  `express_address_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '收货地址ID',
  `express_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货人姓名',
  `express_phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货人手机',
  `express_province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货地址省份',
  `express_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货地址城市',
  `express_area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货地址区域',
  `express_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货详细地址',
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单-记录';

-- ----------------------------
-- Table structure for store_order_list
-- ----------------------------
DROP TABLE IF EXISTS `store_order_list`;
CREATE TABLE `store_order_list`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `from_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐会员',
  `order_no` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '订单单号',
  `goods_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品标识',
  `goods_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品标题',
  `goods_logo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品图标',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_real` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '交易金额',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '销售价格',
  `price_market` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '市场价格',
  `price_express` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '快递费用',
  `price_rate` decimal(20, 4) UNSIGNED NULL DEFAULT 0.0000 COMMENT '分成比例',
  `price_rate_amount` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '分成金额',
  `number_goods` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品数量',
  `number_express` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '快递数量',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_list_id`(`goods_id`) USING BTREE,
  INDEX `index_store_goods_list_spec`(`goods_spec`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单-详情';

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '拥金-记录';

-- ----------------------------
-- Table structure for store_profit_used
-- ----------------------------
DROP TABLE IF EXISTS `store_profit_used`;
CREATE TABLE `store_profit_used`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `appid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `openid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '微信OPENID',
  `trs_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单号',
  `pay_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '交易号',
  `pay_desc` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '提现描述',
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '拥金-提现';

-- ----------------------------
-- Table structure for system_auth
-- ----------------------------
DROP TABLE IF EXISTS `system_auth`;
CREATE TABLE `system_auth`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '权限名称',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_auth_status`(`status`) USING BTREE,
  INDEX `index_system_auth_title`(`title`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-权限';

-- ----------------------------
-- Table structure for system_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auth` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '角色',
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '节点',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_auth_auth`(`auth`) USING BTREE,
  INDEX `index_system_auth_node`(`node`(191)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-权限-授权';

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置名',
  `value` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_config_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-配置';

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
INSERT INTO `system_config` VALUES (49, 'wechat_mch_ssl_key', 'cc2e3e1345123930/c407d033294f283d.pem');
INSERT INTO `system_config` VALUES (50, 'wechat_mch_ssl_cer', '966eaf89299e9c95/7014872cc109b29a.pem');
INSERT INTO `system_config` VALUES (51, 'wechat_token', 'mytoken');
INSERT INTO `system_config` VALUES (52, 'wechat_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES (53, 'wechat_appsecret', '9978422e0e431643d4b42868d183d60b');
INSERT INTO `system_config` VALUES (54, 'wechat_encodingaeskey', '');
INSERT INTO `system_config` VALUES (55, 'wechat_push_url', '消息推送地址：http://127.0.0.1:8000/wechat/api.push');
INSERT INTO `system_config` VALUES (56, 'wechat_type', 'thr');
INSERT INTO `system_config` VALUES (57, 'wechat_thr_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES (58, 'wechat_thr_appkey', 'cb1610a7030b373c233d2921a8f81f21');
INSERT INTO `system_config` VALUES (60, 'wechat_thr_appurl', '消息推送地址：http://127.0.0.1:8000/wechat/api.push');
INSERT INTO `system_config` VALUES (61, 'component_appid', 'wx28b58798480874f9');
INSERT INTO `system_config` VALUES (62, 'component_appsecret', '87ddce1cc24e4cd691039f926febd942');
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
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置名',
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_data_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-数据';

-- ----------------------------
-- Records of system_data
-- ----------------------------
INSERT INTO `system_data` VALUES (1, 'menudata', '[{\"name\":\"请输入名称\",\"type\":\"view\",\"url\":\"3252\"}]');

-- ----------------------------
-- Table structure for system_jobs
-- ----------------------------
DROP TABLE IF EXISTS `system_jobs`;
CREATE TABLE `system_jobs`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `queue` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
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
  INDEX `index_system_jobs_create_at`(`created_at`) USING BTREE,
  INDEX `index_system_jobs_queue`(`queue`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-任务';

-- ----------------------------
-- Table structure for system_jobs_log
-- ----------------------------
DROP TABLE IF EXISTS `system_jobs_log`;
CREATE TABLE `system_jobs_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '任务名称',
  `uri` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '任务对象',
  `later` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '任务延时',
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '任务数据',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '任务描述',
  `double` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '任务多开',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '任务状态(1新任务,2任务进行中,3任务成功,4任务失败)',
  `status_at` datetime NULL DEFAULT NULL COMMENT '任务状态时间',
  `status_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '任务状态描述',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_jobs_log_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-任务-日志';

-- ----------------------------
-- Table structure for system_log
-- ----------------------------
DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `geoip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `action` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作行为名称',
  `content` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作内容描述',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-日志';

-- ----------------------------
-- Records of system_log
-- ----------------------------
INSERT INTO `system_log` VALUES (1, 'admin/login/index', '127.0.0.1', '系统管理', '用户登录系统成功', 'admin', '2019-04-30 13:49:46');
INSERT INTO `system_log` VALUES (2, 'admin/login/index', '127.0.0.1', '系统管理', '用户登录系统成功', 'admin', '2019-04-30 17:14:22');

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '父ID',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '名称',
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '节点代码',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接',
  `params` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '_self' COMMENT '打开方式',
  `sort` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '菜单排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0:禁用,1:启用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_menu_node`(`node`(191)) USING BTREE,
  INDEX `index_system_menu_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 54 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-菜单';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES (1, 0, '后台首页', '', '', 'admin/index/main', '', '_self', 100, 1, '2018-09-05 17:59:38');
INSERT INTO `system_menu` VALUES (2, 0, '系统管理', '', '', '#', '', '_self', 300, 1, '2018-09-05 18:04:52');
INSERT INTO `system_menu` VALUES (3, 12, '系统菜单管理', '', 'layui-icon layui-icon-layouts', 'admin/menu/index', '', '_self', 3, 1, '2018-09-05 18:05:26');
INSERT INTO `system_menu` VALUES (4, 2, '系统配置', '', '', '#', '', '_self', 10, 1, '2018-09-05 18:07:17');
INSERT INTO `system_menu` VALUES (5, 12, '系统用户管理', '', 'layui-icon layui-icon-username', 'admin/user/index', '', '_self', 4, 1, '2018-09-06 11:10:42');
INSERT INTO `system_menu` VALUES (6, 12, '功能节点管理', '', 'layui-icon layui-icon-template', 'admin/node/index', '', '_self', 1, 1, '2018-09-06 14:16:13');
INSERT INTO `system_menu` VALUES (7, 12, '访问权限管理', '', 'layui-icon layui-icon-vercode', 'admin/auth/index', '', '_self', 2, 1, '2018-09-06 15:17:14');
INSERT INTO `system_menu` VALUES (10, 4, '文件存储配置', '', 'layui-icon layui-icon-template-1', 'admin/config/file', '', '_self', 2, 1, '2018-09-06 16:43:19');
INSERT INTO `system_menu` VALUES (11, 4, '系统参数配置', '', 'layui-icon layui-icon-set', 'admin/config/info', '', '_self', 1, 1, '2018-09-06 16:43:47');
INSERT INTO `system_menu` VALUES (12, 2, '权限管理', '', '', '#', '', '_self', 20, 1, '2018-09-06 18:01:31');
INSERT INTO `system_menu` VALUES (13, 0, '商城管理', '', '', '#', '', '_self', 200, 1, '2018-10-12 13:56:29');
INSERT INTO `system_menu` VALUES (14, 48, '商品信息管理', '', 'layui-icon layui-icon-component', 'store/goods/index', '', '_self', 30, 1, '2018-10-12 13:56:48');
INSERT INTO `system_menu` VALUES (16, 0, '微信管理', '', '', '#', '', '_self', 210, 1, '2018-10-31 15:15:27');
INSERT INTO `system_menu` VALUES (17, 16, '微信管理', '', '', '#', '', '_self', 10, 1, '2018-10-31 15:16:46');
INSERT INTO `system_menu` VALUES (18, 17, '微信授权配置', '', 'layui-icon layui-icon-set', 'wechat/config/options', '', '_self', 1, 1, '2018-10-31 15:17:11');
INSERT INTO `system_menu` VALUES (19, 17, '微信支付配置', '', 'layui-icon layui-icon-rmb', 'wechat/config/payment', '', '_self', 2, 1, '2018-10-31 18:28:09');
INSERT INTO `system_menu` VALUES (20, 16, '微信定制', '', '', '#', '', '_self', 20, 1, '2018-11-13 11:46:27');
INSERT INTO `system_menu` VALUES (21, 20, '图文素材管理', '', 'layui-icon layui-icon-template', 'wechat/news/index', '', '_self', 1, 1, '2018-11-13 11:46:55');
INSERT INTO `system_menu` VALUES (22, 20, '粉丝信息管理', '', 'layui-icon layui-icon-user', 'wechat/fans/index', '', '_self', 2, 1, '2018-11-15 09:51:13');
INSERT INTO `system_menu` VALUES (23, 20, '回复规则管理', '', 'layui-icon layui-icon-engine', 'wechat/keys/index', '', '_self', 3, 1, '2018-11-22 11:29:08');
INSERT INTO `system_menu` VALUES (24, 20, '关注回复配置', '', 'layui-icon layui-icon-senior', 'wechat/keys/subscribe', '', '_self', 4, 1, '2018-11-27 11:45:28');
INSERT INTO `system_menu` VALUES (25, 20, '默认回复配置', '', 'layui-icon layui-icon-survey', 'wechat/keys/defaults', '', '_self', 5, 1, '2018-11-27 11:45:58');
INSERT INTO `system_menu` VALUES (26, 20, '微信菜单管理', '', 'layui-icon layui-icon-cellphone', 'wechat/menu/index', '', '_self', 6, 1, '2018-11-27 17:56:56');
INSERT INTO `system_menu` VALUES (27, 4, '系统任务管理', '', 'layui-icon layui-icon-log', 'admin/queue/index', '', '_self', 3, 1, '2018-11-29 11:13:34');
INSERT INTO `system_menu` VALUES (35, 4, '系统消息管理', '', 'layui-icon layui-icon-notice', 'admin/message/index', '', '_self', 4, 1, '2018-12-24 14:03:52');
INSERT INTO `system_menu` VALUES (37, 0, '开放平台', '', '', '#', '', '_self', 220, 1, '2018-12-28 13:29:25');
INSERT INTO `system_menu` VALUES (38, 40, '开放平台配置', '', 'layui-icon layui-icon-set', 'service/config/index', '', '_self', 0, 1, '2018-12-28 13:29:44');
INSERT INTO `system_menu` VALUES (39, 40, '公众授权管理', '', 'layui-icon layui-icon-template-1', 'service/index/index', '', '_self', 0, 1, '2018-12-28 13:30:07');
INSERT INTO `system_menu` VALUES (40, 37, '开放平台管理', '', '', '#', '', '_self', 0, 1, '2018-12-28 16:05:46');
INSERT INTO `system_menu` VALUES (42, 48, '会员信息管理', '', 'layui-icon layui-icon-user', 'store/member/index', '', '_self', 50, 1, '2019-01-22 14:24:23');
INSERT INTO `system_menu` VALUES (43, 48, '订单记录管理', '', 'layui-icon layui-icon-template-1', 'store/order/index', '', '_self', 40, 1, '2019-01-22 14:46:22');
INSERT INTO `system_menu` VALUES (44, 48, '商品分类管理', '', 'layui-icon layui-icon-app', 'store/goods_cate/index', '', '_self', 20, 1, '2019-01-23 10:41:06');
INSERT INTO `system_menu` VALUES (45, 47, '商城参数配置', '', 'layui-icon layui-icon-set', 'store/config/index', '', '_self', 10, 1, '2019-01-24 16:47:33');
INSERT INTO `system_menu` VALUES (46, 47, '短信发送记录', '', 'layui-icon layui-icon-console', 'store/message/index', '', '_self', 30, 1, '2019-01-24 18:09:58');
INSERT INTO `system_menu` VALUES (47, 13, '商城配置', '', '', '#', '', '_self', 10, 1, '2019-01-25 16:47:49');
INSERT INTO `system_menu` VALUES (48, 13, '数据管理', '', '', '#', '', '_self', 20, 1, '2019-01-25 16:48:35');
INSERT INTO `system_menu` VALUES (49, 4, '系统日志管理', '', 'layui-icon layui-icon-form', 'admin/log/index', '', '_self', 5, 1, '2019-02-18 12:56:56');
INSERT INTO `system_menu` VALUES (50, 47, '快递公司管理', '', 'layui-icon layui-icon-form', 'store/express_company/index', '', '_self', 40, 1, '2019-04-01 17:10:59');
INSERT INTO `system_menu` VALUES (52, 47, '邮费模板管理', '', 'layui-icon layui-icon-fonts-clear', 'store/express_template/index', '', '_self', 60, 1, '2019-04-23 13:17:10');
INSERT INTO `system_menu` VALUES (53, 47, '配送省份管理', '', 'layui-icon layui-icon-location', 'store/express_province/index', '', '_self', 55, 1, '2019-04-24 14:47:27');

-- ----------------------------
-- Table structure for system_message
-- ----------------------------
DROP TABLE IF EXISTS `system_message`;
CREATE TABLE `system_message`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息编号',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息名称',
  `url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '跳转地址',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息描述',
  `node` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息授权',
  `read_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '读取状态',
  `read_uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '读取用户',
  `read_at` datetime NULL DEFAULT NULL COMMENT '读取时间',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '消息状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_message_code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-消息';

-- ----------------------------
-- Table structure for system_node
-- ----------------------------
DROP TABLE IF EXISTS `system_node`;
CREATE TABLE `system_node`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `node` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '节点代码',
  `title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '节点标题',
  `is_menu` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否可设置为菜单',
  `is_auth` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '是否启动RBAC权限控制',
  `is_login` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '是否启动登录控制',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_system_node_node`(`node`) USING BTREE,
  INDEX `index_system_node_is_menu`(`is_menu`) USING BTREE,
  INDEX `index_system_node_is_auth`(`is_auth`) USING BTREE,
  INDEX `index_system_node_is_login`(`is_login`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 110 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-节点';

-- ----------------------------
-- Records of system_node
-- ----------------------------
INSERT INTO `system_node` VALUES (1, 'admin', '系统管理', 0, 1, 1, '2019-04-30 17:18:30');
INSERT INTO `system_node` VALUES (2, 'admin/auth/index', '系统权限管理', 1, 1, 1, '2019-04-30 17:18:32');
INSERT INTO `system_node` VALUES (3, 'admin/auth/apply', '权限配置节点', 0, 1, 1, '2019-04-30 17:18:33');
INSERT INTO `system_node` VALUES (4, 'admin/auth/add', '添加系统权限', 0, 1, 1, '2019-04-30 17:18:33');
INSERT INTO `system_node` VALUES (5, 'admin/auth/edit', '编辑系统权限', 0, 1, 1, '2019-04-30 17:18:33');
INSERT INTO `system_node` VALUES (6, 'admin/auth/forbid', '禁用系统权限', 0, 1, 1, '2019-04-30 17:18:33');
INSERT INTO `system_node` VALUES (7, 'admin/auth/resume', '启用系统权限', 0, 1, 1, '2019-04-30 17:18:33');
INSERT INTO `system_node` VALUES (8, 'admin/auth/del', '删除系统权限', 0, 1, 1, '2019-04-30 17:18:33');
INSERT INTO `system_node` VALUES (9, 'admin/config/info', '系统参数配置', 1, 1, 1, '2019-04-30 17:18:34');
INSERT INTO `system_node` VALUES (10, 'admin/config/file', '文件存储配置', 1, 1, 1, '2019-04-30 17:18:34');
INSERT INTO `system_node` VALUES (11, 'admin/log/index', '系统操作日志', 1, 1, 1, '2019-04-30 17:18:35');
INSERT INTO `system_node` VALUES (12, 'admin/log/del', '删除系统日志', 0, 1, 1, '2019-04-30 17:18:35');
INSERT INTO `system_node` VALUES (13, 'admin/menu/index', '系统菜单管理', 1, 1, 1, '2019-04-30 17:18:36');
INSERT INTO `system_node` VALUES (14, 'admin/menu/add', '添加系统菜单', 0, 1, 1, '2019-04-30 17:18:36');
INSERT INTO `system_node` VALUES (15, 'admin/menu/edit', '编辑系统菜单', 0, 1, 1, '2019-04-30 17:18:37');
INSERT INTO `system_node` VALUES (16, 'admin/menu/resume', '启用系统菜单', 0, 1, 1, '2019-04-30 17:18:37');
INSERT INTO `system_node` VALUES (17, 'admin/menu/forbid', '禁用系统菜单', 0, 1, 1, '2019-04-30 17:18:37');
INSERT INTO `system_node` VALUES (18, 'admin/menu/del', '删除系统菜单', 0, 1, 1, '2019-04-30 17:18:37');
INSERT INTO `system_node` VALUES (19, 'admin/message/index', '', 1, 1, 1, '2019-04-30 17:18:38');
INSERT INTO `system_node` VALUES (20, 'admin/message/state', '设置消息状态', 0, 1, 1, '2019-04-30 17:18:38');
INSERT INTO `system_node` VALUES (21, 'admin/message/del', '删除系统消息', 0, 1, 1, '2019-04-30 17:18:38');
INSERT INTO `system_node` VALUES (22, 'admin/message/clear', '清理所有消息', 0, 1, 1, '2019-04-30 17:18:38');
INSERT INTO `system_node` VALUES (23, 'admin/message/onoff', '设置消息开关', 0, 1, 1, '2019-04-30 17:18:38');
INSERT INTO `system_node` VALUES (24, 'admin/node/index', '系统节点管理', 1, 1, 1, '2019-04-30 17:18:40');
INSERT INTO `system_node` VALUES (25, 'admin/node/clear', '清理无效的节点', 0, 1, 1, '2019-04-30 17:18:40');
INSERT INTO `system_node` VALUES (26, 'admin/node/save', '更新节点数据', 0, 1, 1, '2019-04-30 17:18:40');
INSERT INTO `system_node` VALUES (27, 'admin/queue/index', '系统消息任务', 1, 1, 1, '2019-04-30 17:18:40');
INSERT INTO `system_node` VALUES (28, 'admin/queue/redo', '重置失败的任务', 0, 1, 1, '2019-04-30 17:18:41');
INSERT INTO `system_node` VALUES (29, 'admin/queue/del', '删除消息任务', 0, 1, 1, '2019-04-30 17:18:41');
INSERT INTO `system_node` VALUES (30, 'admin/user/index', '系统用户管理', 1, 1, 1, '2019-04-30 17:18:42');
INSERT INTO `system_node` VALUES (31, 'admin/user/auth', '用户授权管理', 0, 1, 1, '2019-04-30 17:18:42');
INSERT INTO `system_node` VALUES (32, 'admin/user/add', '添加系统用户', 0, 1, 1, '2019-04-30 17:18:42');
INSERT INTO `system_node` VALUES (33, 'admin/user/edit', '编辑系统用户', 0, 1, 1, '2019-04-30 17:18:43');
INSERT INTO `system_node` VALUES (34, 'admin/user/pass', '修改用户密码', 0, 1, 1, '2019-04-30 17:18:43');
INSERT INTO `system_node` VALUES (35, 'admin/user/del', '删除系统用户', 0, 1, 1, '2019-04-30 17:18:43');
INSERT INTO `system_node` VALUES (36, 'admin/user/forbid', '禁用系统用户', 0, 1, 1, '2019-04-30 17:18:43');
INSERT INTO `system_node` VALUES (37, 'admin/user/resume', '启用系统用户', 0, 1, 1, '2019-04-30 17:18:43');
INSERT INTO `system_node` VALUES (38, 'service', '开放平台', 0, 1, 1, '2019-04-30 17:20:46');
INSERT INTO `system_node` VALUES (39, 'service/config/index', '开放平台参数配置', 1, 1, 1, '2019-04-30 17:20:47');
INSERT INTO `system_node` VALUES (40, 'service/index/index', '授权公众号管理', 1, 1, 1, '2019-04-30 17:20:48');
INSERT INTO `system_node` VALUES (41, 'service/index/clearquota', '清理调用次数', 0, 1, 1, '2019-04-30 17:20:48');
INSERT INTO `system_node` VALUES (42, 'service/index/sync', '同步指定授权公众号', 0, 1, 1, '2019-04-30 17:20:48');
INSERT INTO `system_node` VALUES (43, 'service/index/syncall', '同步所有授权公众号', 0, 1, 1, '2019-04-30 17:20:49');
INSERT INTO `system_node` VALUES (44, 'service/index/del', '删除公众号授权', 0, 1, 1, '2019-04-30 17:20:49');
INSERT INTO `system_node` VALUES (45, 'service/index/forbid', '禁用公众号授权', 0, 1, 1, '2019-04-30 17:20:49');
INSERT INTO `system_node` VALUES (46, 'service/index/resume', '启用公众号授权', 0, 1, 1, '2019-04-30 17:20:49');
INSERT INTO `system_node` VALUES (47, 'store', '商城管理', 0, 1, 1, '2019-04-30 17:20:56');
INSERT INTO `system_node` VALUES (48, 'store/config/index', '商城参数配置', 1, 1, 1, '2019-04-30 17:20:57');
INSERT INTO `system_node` VALUES (55, 'store/express_company/index', '快递公司管理', 1, 1, 1, '2019-04-30 17:20:59');
INSERT INTO `system_node` VALUES (56, 'store/express_company/add', '添加快递公司', 0, 1, 1, '2019-04-30 17:20:59');
INSERT INTO `system_node` VALUES (57, 'store/express_company/edit', '编辑快递公司', 0, 1, 1, '2019-04-30 17:20:59');
INSERT INTO `system_node` VALUES (58, 'store/express_company/forbid', '禁用快递公司', 0, 1, 1, '2019-04-30 17:20:59');
INSERT INTO `system_node` VALUES (59, 'store/express_company/resume', '启用快递公司', 0, 1, 1, '2019-04-30 17:20:59');
INSERT INTO `system_node` VALUES (60, 'store/express_company/del', '删除快递公司', 0, 1, 1, '2019-04-30 17:20:59');
INSERT INTO `system_node` VALUES (61, 'store/express_province/index', '配送省份管理', 1, 1, 1, '2019-04-30 17:21:00');
INSERT INTO `system_node` VALUES (62, 'store/express_province/add', '添加配送省份', 0, 1, 1, '2019-04-30 17:21:00');
INSERT INTO `system_node` VALUES (63, 'store/express_province/edit', '编辑配送省份', 0, 1, 1, '2019-04-30 17:21:00');
INSERT INTO `system_node` VALUES (64, 'store/express_province/resume', '启用配送省份', 0, 1, 1, '2019-04-30 17:21:00');
INSERT INTO `system_node` VALUES (65, 'store/express_province/forbid', '禁用配送省份', 0, 1, 1, '2019-04-30 17:21:00');
INSERT INTO `system_node` VALUES (66, 'store/express_province/del', '删除配送省份', 0, 1, 1, '2019-04-30 17:21:00');
INSERT INTO `system_node` VALUES (67, 'store/express_template/index', '邮费模板管理', 1, 1, 1, '2019-04-30 17:21:01');
INSERT INTO `system_node` VALUES (68, 'store/goods/index', '商品信息管理', 1, 1, 1, '2019-04-30 17:21:02');
INSERT INTO `system_node` VALUES (69, 'store/goods/stock', '商品库存入库', 0, 1, 1, '2019-04-30 17:21:02');
INSERT INTO `system_node` VALUES (70, 'store/goods/add', '添加商品信息', 0, 1, 1, '2019-04-30 17:21:02');
INSERT INTO `system_node` VALUES (71, 'store/goods/edit', '编辑商品信息', 0, 1, 1, '2019-04-30 17:21:02');
INSERT INTO `system_node` VALUES (72, 'store/goods/forbid', '禁用商品信息', 0, 1, 1, '2019-04-30 17:21:02');
INSERT INTO `system_node` VALUES (73, 'store/goods/resume', '启用商品信息', 0, 1, 1, '2019-04-30 17:21:02');
INSERT INTO `system_node` VALUES (74, 'store/goods/del', '删除商品信息', 0, 1, 1, '2019-04-30 17:21:03');
INSERT INTO `system_node` VALUES (75, 'store/goods_cate/index', '商品分类管理', 1, 1, 1, '2019-04-30 17:21:03');
INSERT INTO `system_node` VALUES (76, 'store/goods_cate/add', '添加商品分类', 0, 1, 1, '2019-04-30 17:21:03');
INSERT INTO `system_node` VALUES (77, 'store/goods_cate/edit', '编辑添加商品分类', 0, 1, 1, '2019-04-30 17:21:03');
INSERT INTO `system_node` VALUES (78, 'store/goods_cate/forbid', '禁用添加商品分类', 0, 1, 1, '2019-04-30 17:21:03');
INSERT INTO `system_node` VALUES (79, 'store/goods_cate/resume', '启用商品分类', 0, 1, 1, '2019-04-30 17:21:04');
INSERT INTO `system_node` VALUES (80, 'store/goods_cate/del', '删除商品分类', 0, 1, 1, '2019-04-30 17:21:04');
INSERT INTO `system_node` VALUES (81, 'store/member/index', '会员信息管理', 1, 1, 1, '2019-04-30 17:21:04');
INSERT INTO `system_node` VALUES (82, 'store/message/index', '短信发送管理', 1, 1, 1, '2019-04-30 17:21:05');
INSERT INTO `system_node` VALUES (83, 'store/order/index', '订单记录管理', 1, 1, 1, '2019-04-30 17:21:06');
INSERT INTO `system_node` VALUES (84, 'store/order/express', '修改快递管理', 0, 1, 1, '2019-04-30 17:21:07');
INSERT INTO `system_node` VALUES (85, 'store/order/expressquery', '', 0, 1, 1, '2019-04-30 17:21:07');
INSERT INTO `system_node` VALUES (86, 'wechat/config/options', '公众号授权绑定', 1, 1, 1, '2019-04-30 17:21:28');
INSERT INTO `system_node` VALUES (87, 'wechat/config/payment', '公众号支付配置', 1, 1, 1, '2019-04-30 17:21:28');
INSERT INTO `system_node` VALUES (88, 'wechat/fans/index', '微信粉丝管理', 1, 1, 1, '2019-04-30 17:21:29');
INSERT INTO `system_node` VALUES (89, 'wechat/fans/setblack', '批量拉黑粉丝', 0, 1, 1, '2019-04-30 17:21:29');
INSERT INTO `system_node` VALUES (90, 'wechat/fans/delblack', '取消拉黑粉丝', 0, 1, 1, '2019-04-30 17:21:29');
INSERT INTO `system_node` VALUES (91, 'wechat/fans/sync', '同步粉丝列表', 0, 1, 1, '2019-04-30 17:21:29');
INSERT INTO `system_node` VALUES (92, 'wechat/fans/del', '删除粉丝信息', 0, 1, 1, '2019-04-30 17:21:29');
INSERT INTO `system_node` VALUES (93, 'wechat/keys/index', '回复规则管理', 1, 1, 1, '2019-04-30 17:21:30');
INSERT INTO `system_node` VALUES (94, 'wechat/keys/add', '添加关键字', 0, 1, 1, '2019-04-30 17:21:30');
INSERT INTO `system_node` VALUES (95, 'wechat/keys/edit', '编辑关键字', 0, 1, 1, '2019-04-30 17:21:30');
INSERT INTO `system_node` VALUES (96, 'wechat/keys/del', '删除关键字', 0, 1, 1, '2019-04-30 17:21:30');
INSERT INTO `system_node` VALUES (97, 'wechat/keys/forbid', '禁用关键字', 0, 1, 1, '2019-04-30 17:21:30');
INSERT INTO `system_node` VALUES (98, 'wechat/keys/resume', '启用关键字', 0, 1, 1, '2019-04-30 17:21:31');
INSERT INTO `system_node` VALUES (99, 'wechat/keys/subscribe', '关注默认回复', 0, 1, 1, '2019-04-30 17:21:31');
INSERT INTO `system_node` VALUES (100, 'wechat/keys/defaults', '无配置默认回复', 0, 1, 1, '2019-04-30 17:21:31');
INSERT INTO `system_node` VALUES (101, 'wechat/menu/index', '微信菜单管理', 1, 1, 1, '2019-04-30 17:21:31');
INSERT INTO `system_node` VALUES (102, 'wechat/menu/edit', '编辑微信菜单', 0, 1, 1, '2019-04-30 17:21:31');
INSERT INTO `system_node` VALUES (103, 'wechat/menu/cancel', '取消微信菜单', 0, 1, 1, '2019-04-30 17:21:31');
INSERT INTO `system_node` VALUES (104, 'wechat/news/index', '微信图文管理', 1, 1, 1, '2019-04-30 17:21:32');
INSERT INTO `system_node` VALUES (105, 'wechat/news/select', '图文选择器', 0, 1, 1, '2019-04-30 17:21:33');
INSERT INTO `system_node` VALUES (106, 'wechat/news/add', '添加微信图文', 0, 1, 1, '2019-04-30 17:21:33');
INSERT INTO `system_node` VALUES (107, 'wechat/news/edit', '编辑微信图文', 0, 1, 1, '2019-04-30 17:21:33');
INSERT INTO `system_node` VALUES (108, 'wechat/news/del', '删除微信图文', 0, 1, 1, '2019-04-30 17:21:33');
INSERT INTO `system_node` VALUES (109, 'wechat', '微信管理', 0, 1, 1, '2019-04-30 17:21:53');

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户账号',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户密码',
  `qq` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系QQ',
  `mail` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系邮箱',
  `phone` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系手机',
  `login_at` datetime NULL DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '登录IP',
  `login_num` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '登录次数',
  `authorize` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '权限授权',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0:禁用,1:启用)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除(1:删除,0:未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `index_system_user_username`(`username`) USING BTREE,
  INDEX `index_system_user_status`(`status`) USING BTREE,
  INDEX `index_system_user_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10002 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-用户';

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES (10000, 'admin', '21232f297a57a5a743894a0e4a801fc3', '22222222', '', '', '2019-04-30 17:14:22', '127.0.0.1', 548, '', '', 1, 0, '2015-11-13 15:14:22');
INSERT INTO `system_user` VALUES (10001, 'test', '662af1cd1976f09a9f8cecc868ccc0a2', '', '', '', '2019-04-18 13:28:57', '127.0.0.1', 1, '1', '', 1, 0, '2019-04-18 13:28:23');

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
  `sex` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '用户性别(1男性,2女性,0未知)',
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
  INDEX `index_wechat_fans_is_back`(`is_black`) USING BTREE,
  INDEX `index_wechat_fans_subscribe`(`subscribe`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-粉丝';

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-粉丝-标签';

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-关键字';

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-素材';

-- ----------------------------
-- Table structure for wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news`;
CREATE TABLE `wechat_news`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材显示URL',
  `article_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '关联图文ID(用英文逗号做分割)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否删除',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_news_artcle_id`(`article_id`) USING BTREE,
  INDEX `index_wechat_news_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-图文';

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-图文-文章';

-- ----------------------------
-- Table structure for wechat_service_config
-- ----------------------------
DROP TABLE IF EXISTS `wechat_service_config`;
CREATE TABLE `wechat_service_config`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `authorizer_appid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `authorizer_access_token` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号授权Token',
  `authorizer_refresh_token` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号刷新Token',
  `func_info` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号集权',
  `nick_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号昵称',
  `head_img` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号头像',
  `expires_in` bigint(20) NULL DEFAULT NULL COMMENT 'Token有效时间',
  `service_type` tinyint(2) NULL DEFAULT NULL COMMENT '微信类型(0代表订阅号,2代表服务号,3代表小程序)',
  `service_type_info` tinyint(2) NULL DEFAULT NULL COMMENT '公众号实际类型',
  `verify_type` tinyint(2) NULL DEFAULT NULL COMMENT '公众号认证类型(-1代表未认证, 0代表微信认证)',
  `verify_type_info` tinyint(2) NULL DEFAULT NULL COMMENT '公众号实际认证类型',
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '众众号原始账号',
  `alias` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号别名',
  `qrcode_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号二维码',
  `business_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `principal_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公司名称',
  `miniprograminfo` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '小程序JSON',
  `idc` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `signature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '小程序的描述',
  `total` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '统计调用次数',
  `appkey` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '应用接口KEY',
  `appuri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '应用接口URI',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(1正常授权,0取消授权)',
  `is_deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删除,1已删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `index_wechat_service_config_authorizer_appid`(`authorizer_appid`) USING BTREE,
  INDEX `index_wechat_service_config_status`(`status`) USING BTREE,
  INDEX `index_wechat_service_config_is_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-授权';

SET FOREIGN_KEY_CHECKS = 1;