/*
 Navicat Premium Data Transfer

 Source Server         : thinkadmin.top.tencent
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : 127.0.0.1:3306
 Source Schema         : admin_v6

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 19/09/2022 10:24:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for base_postage_company
-- ----------------------------
DROP TABLE IF EXISTS `base_postage_company`;
CREATE TABLE `base_postage_company`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `code_1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司代码',
  `code_2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '百度快递100代码',
  `code_3` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '官方快递100代码',
  `remark` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司描述',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态(0.无效,1.有效)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(1已删除,0未删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_postage_company_code1`(`code_1`) USING BTREE,
  INDEX `idx_base_postage_company_code2`(`code_2`) USING BTREE,
  INDEX `idx_base_postage_company_code3`(`code_3`) USING BTREE,
  INDEX `idx_base_postage_company_status`(`status`) USING BTREE,
  INDEX `idx_base_postage_company_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 125 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-快递-公司' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for base_postage_region
-- ----------------------------
DROP TABLE IF EXISTS `base_postage_region`;
CREATE TABLE `base_postage_region`  (
  `id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'ID',
  `pid` bigint(20) NULL DEFAULT NULL COMMENT '上级PID',
  `first` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '首字母',
  `short` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '区域简称',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '区域名称',
  `level` tinyint(4) NULL DEFAULT 0 COMMENT '区域层级',
  `pinyin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '区域拼音',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '区域邮编',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '使用状态',
  `lng` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在经度',
  `lat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在纬度',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_postage_region_pid`(`pid`) USING BTREE,
  INDEX `idx_base_postage_region_name`(`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-快递-区域' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for base_postage_template
-- ----------------------------
DROP TABLE IF EXISTS `base_postage_template`;
CREATE TABLE `base_postage_template`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '模板编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '模板名称',
  `normal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '默认规则',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '模板规则',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '模板状态',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_postage_template_code`(`code`) USING BTREE,
  INDEX `idx_base_postage_template_status`(`status`) USING BTREE,
  INDEX `idx_base_postage_template_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 63 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-快递-模板' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for base_user_discount
-- ----------------------------
DROP TABLE IF EXISTS `base_user_discount`;
CREATE TABLE `base_user_discount`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '方案名称',
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '方案规则',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '方案描述',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '方案状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_user_discount_status`(`status`) USING BTREE,
  INDEX `idx_base_user_discount_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-基础-折扣' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for base_user_message
-- ----------------------------
DROP TABLE IF EXISTS `base_user_message`;
CREATE TABLE `base_user_message`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息类型',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息名称',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '消息内容',
  `num_read` bigint(20) NULL DEFAULT 0 COMMENT '阅读次数',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '消息状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_user_message_type`(`type`) USING BTREE,
  INDEX `idx_base_user_message_status`(`status`) USING BTREE,
  INDEX `idx_base_user_message_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-基础-通知' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for base_user_payment
-- ----------------------------
DROP TABLE IF EXISTS `base_user_payment`;
CREATE TABLE `base_user_payment`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付类型',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '通道编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付名称',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付图标',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '支付参数',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付说明',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '支付状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_user_payment_type`(`type`) USING BTREE,
  INDEX `idx_base_user_payment_code`(`code`) USING BTREE,
  INDEX `idx_base_user_payment_status`(`status`) USING BTREE,
  INDEX `idx_base_user_payment_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 54 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-基础-支付' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for base_user_upgrade
-- ----------------------------
DROP TABLE IF EXISTS `base_user_upgrade`;
CREATE TABLE `base_user_upgrade`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户级别名称',
  `number` tinyint(2) NULL DEFAULT 0 COMMENT '用户级别序号',
  `rebate_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户奖利规则',
  `upgrade_type` tinyint(1) NULL DEFAULT 0 COMMENT '会员升级规则(0单个,1同时)',
  `upgrade_team` tinyint(1) NULL DEFAULT 1 COMMENT '团队人数统计(0不计,1累计)',
  `goods_vip_status` tinyint(1) NULL DEFAULT 0 COMMENT '入会礼包状态',
  `order_amount_status` tinyint(1) NULL DEFAULT 0 COMMENT '订单金额状态',
  `order_amount_number` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单金额累计',
  `teams_users_status` tinyint(1) NULL DEFAULT 0 COMMENT '团队人数状态',
  `teams_users_number` bigint(20) NULL DEFAULT 0 COMMENT '团队人数累计',
  `teams_direct_status` tinyint(1) NULL DEFAULT 0 COMMENT '直推人数状态',
  `teams_direct_number` bigint(20) NULL DEFAULT 0 COMMENT '直推人数累计',
  `teams_indirect_status` tinyint(1) NULL DEFAULT 0 COMMENT '间推人数状态',
  `teams_indirect_number` bigint(20) NULL DEFAULT 0 COMMENT '间推人数累计',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户级别描述',
  `utime` bigint(20) NULL DEFAULT 0 COMMENT '等级更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '用户等级状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '等级创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_base_user_upgrade_status`(`status`) USING BTREE,
  INDEX `idx_base_user_upgrade_number`(`number`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-等级' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_news_item
-- ----------------------------
DROP TABLE IF EXISTS `data_news_item`;
CREATE TABLE `data_news_item`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标题',
  `mark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标签',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章封面',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '文章内容',
  `num_like` bigint(20) NULL DEFAULT 0 COMMENT '文章点赞数',
  `num_read` bigint(20) NULL DEFAULT 0 COMMENT '文章阅读数',
  `num_collect` bigint(20) NULL DEFAULT 0 COMMENT '文章收藏数',
  `num_comment` bigint(20) NULL DEFAULT 0 COMMENT '文章评论数',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '文章状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_code`(`code`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 181 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-内容' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_news_mark
-- ----------------------------
DROP TABLE IF EXISTS `data_news_mark`;
CREATE TABLE `data_news_mark`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签说明',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '标签状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_mark_status`(`status`) USING BTREE,
  INDEX `idx_data_news_mark_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 63 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-标签' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_news_x_collect
-- ----------------------------
DROP TABLE IF EXISTS `data_news_x_collect`;
CREATE TABLE `data_news_x_collect`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '记录类型(1收藏,2点赞,3历史,4评论)',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章编号',
  `reply` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '评论内容',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '记录状态(0无效,1待审核,2已审核)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_x_collect_type`(`type`) USING BTREE,
  INDEX `idx_data_news_x_collect_code`(`code`) USING BTREE,
  INDEX `idx_data_news_x_collect_status`(`status`) USING BTREE,
  INDEX `idx_data_news_x_collect_uuid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-标记' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user
-- ----------------------------
DROP TABLE IF EXISTS `data_user`;
CREATE TABLE `data_user`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid0` bigint(20) NULL DEFAULT 0 COMMENT '临时推荐人UID',
  `pid1` bigint(20) NULL DEFAULT 0 COMMENT '推荐人一级UID',
  `pid2` bigint(20) NULL DEFAULT 0 COMMENT '推荐人二级UID',
  `pids` tinyint(1) NULL DEFAULT 0 COMMENT '推荐人绑定状态',
  `path` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '-' COMMENT '推荐关系路径',
  `layer` bigint(20) NULL DEFAULT 1 COMMENT '推荐关系层级',
  `openid1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '小程序OPENID',
  `openid2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '服务号OPENID',
  `unionid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号UnionID',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户手机',
  `headimg` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户头像',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户姓名',
  `nickname` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '登录密码',
  `region_province` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在省份',
  `region_city` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在城市',
  `region_area` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在区域',
  `base_age` bigint(20) NULL DEFAULT 0 COMMENT '用户年龄',
  `base_sex` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户性别',
  `base_height` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户身高',
  `base_weight` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户体重',
  `base_birthday` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户生日',
  `vip_code` bigint(20) NULL DEFAULT 0 COMMENT 'VIP等级编号',
  `vip_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '普通用户' COMMENT 'VIP等级名称',
  `vip_order` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'VIP升级订单',
  `vip_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'VIP等级时间',
  `buy_vip_entry` tinyint(1) NULL DEFAULT 0 COMMENT '是否入会礼包',
  `buy_last_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '最后支付时间',
  `rebate_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '返利金额统计',
  `rebate_used` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '返利提现统计',
  `rebate_lock` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '返利锁定统计',
  `balance_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '累计充值统计',
  `balance_used` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '已经使用统计',
  `teams_users_total` bigint(20) NULL DEFAULT 0 COMMENT '团队人数统计',
  `teams_users_direct` bigint(20) NULL DEFAULT 0 COMMENT '直属人数团队',
  `teams_users_indirect` bigint(20) NULL DEFAULT 0 COMMENT '间接人数团队',
  `order_amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单交易统计',
  `teams_amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '二级团队业绩',
  `teams_amount_direct` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '直属团队业绩',
  `teams_amount_indirect` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '间接团队业绩',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户备注描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '用户状态(1正常,0已黑)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_status`(`status`) USING BTREE,
  INDEX `idx_data_user_deleted`(`deleted`) USING BTREE,
  INDEX `idx_data_user_openid1`(`openid1`) USING BTREE,
  INDEX `idx_data_user_openid2`(`openid2`) USING BTREE,
  INDEX `idx_data_user_unionid`(`unionid`) USING BTREE,
  INDEX `idx_data_user_pid1`(`pid1`) USING BTREE,
  INDEX `idx_data_user_pid2`(`pid2`) USING BTREE,
  INDEX `idx_data_user_pid0`(`pid0`) USING BTREE,
  INDEX `idx_data_user_pids`(`pids`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-会员' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_address
-- ----------------------------
DROP TABLE IF EXISTS `data_user_address`;
CREATE TABLE `data_user_address`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `type` tinyint(1) NULL DEFAULT 0 COMMENT '地址类型(0普通,1默认)',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货姓名',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货手机',
  `idcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '身体证号',
  `idimg1` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '身份证正面',
  `idimg2` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '身份证反面',
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-省份',
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-城市',
  `area` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-区域',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-详情',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_address_type`(`type`) USING BTREE,
  INDEX `idx_data_user_address_code`(`code`) USING BTREE,
  INDEX `idx_data_user_address_deleted`(`deleted`) USING BTREE,
  INDEX `idx_data_user_address_uuid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-地址' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_balance
-- ----------------------------
DROP TABLE IF EXISTS `data_user_balance`;
CREATE TABLE `data_user_balance`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '充值编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '充值名称',
  `remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '充值备注',
  `amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '充值金额',
  `upgrade` tinyint(20) NULL DEFAULT 0 COMMENT '强制升级',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_by` bigint(20) NULL DEFAULT 0 COMMENT '系统用户',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_balance_code`(`code`) USING BTREE,
  INDEX `idx_data_user_balance_deleted`(`deleted`) USING BTREE,
  INDEX `idx_data_user_balance_uuid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 328 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-余额' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_message
-- ----------------------------
DROP TABLE IF EXISTS `data_user_message`;
CREATE TABLE `data_user_message`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '短信类型',
  `msgid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息编号',
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '目标手机',
  `region` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '国家编号',
  `result` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '返回结果',
  `content` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '短信内容',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '短信状态(0失败,1成功)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_message_type`(`type`) USING BTREE,
  INDEX `idx_data_user_message_status`(`status`) USING BTREE,
  INDEX `idx_data_user_message_phone`(`phone`) USING BTREE,
  INDEX `idx_data_user_message_msgid`(`msgid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-短信' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_payment
-- ----------------------------
DROP TABLE IF EXISTS `data_user_payment`;
CREATE TABLE `data_user_payment`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单单号',
  `order_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单描述',
  `order_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单金额',
  `payment_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付编号',
  `payment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付通道',
  `payment_trade` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付单号',
  `payment_status` tinyint(1) NULL DEFAULT 0 COMMENT '支付状态',
  `payment_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '支付金额',
  `payment_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付时间',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_payment_order_no`(`order_no`) USING BTREE,
  INDEX `idx_data_user_payment_payment_code`(`payment_code`) USING BTREE,
  INDEX `idx_data_user_payment_payment_type`(`payment_type`) USING BTREE,
  INDEX `idx_data_user_payment_payment_trade`(`payment_trade`) USING BTREE,
  INDEX `idx_data_user_payment_payment_status`(`payment_status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-支付' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_rebate
-- ----------------------------
DROP TABLE IF EXISTS `data_user_rebate`;
CREATE TABLE `data_user_rebate`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '奖励日期',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '奖励编号',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '奖励类型',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '奖励名称',
  `amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '奖励数量',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单单号',
  `order_uuid` bigint(20) NULL DEFAULT 0 COMMENT '订单用户',
  `order_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单金额',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '生效状态(0未生效,1已生效)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删除,1已删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_rebate_type`(`type`) USING BTREE,
  INDEX `idx_data_user_rebate_date`(`date`) USING BTREE,
  INDEX `idx_data_user_rebate_code`(`code`) USING BTREE,
  INDEX `idx_data_user_rebate_name`(`name`) USING BTREE,
  INDEX `idx_data_user_rebate_status`(`status`) USING BTREE,
  INDEX `idx_data_user_rebate_uuid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-返利' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_token
-- ----------------------------
DROP TABLE IF EXISTS `data_user_token`;
CREATE TABLE `data_user_token`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权类型',
  `time` bigint(20) NULL DEFAULT 0 COMMENT '有效时间',
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权令牌',
  `tokenv` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权验证',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_token_uuid`(`uuid`) USING BTREE,
  INDEX `idx_data_user_token_type`(`type`) USING BTREE,
  INDEX `idx_data_user_token_time`(`time`) USING BTREE,
  INDEX `idx_data_user_token_token`(`token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 242 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-认证' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for data_user_transfer
-- ----------------------------
DROP TABLE IF EXISTS `data_user_transfer`;
CREATE TABLE `data_user_transfer`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '提现方式',
  `date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '提现日期',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '提现单号',
  `appid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `openid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号OPENID',
  `charge_rate` decimal(20, 4) NULL DEFAULT 0.0000 COMMENT '提现手续费比例',
  `charge_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '提现手续费金额',
  `amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '提现转账金额',
  `qrcode` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收款码图片地址',
  `bank_wseq` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '微信银行编号',
  `bank_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_bran` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开户分行名称',
  `bank_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开户账号姓名',
  `bank_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开户银行卡号',
  `alipay_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付宝姓名',
  `alipay_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付宝账号',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '提现描述',
  `trade_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '交易单号',
  `trade_time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '打款时间',
  `change_time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '处理时间',
  `change_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '处理描述',
  `audit_status` tinyint(1) NULL DEFAULT 0 COMMENT '审核状态',
  `audit_remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '审核描述',
  `audit_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '审核时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '提现状态(0失败,1待审核,2已审核,3打款中,4已打款,5已收款)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_transfer_code`(`code`) USING BTREE,
  INDEX `idx_data_user_transfer_status`(`status`) USING BTREE,
  INDEX `idx_data_user_transfer_date`(`date`) USING BTREE,
  INDEX `idx_data_user_transfer_type`(`type`) USING BTREE,
  INDEX `idx_data_user_transfer_audit_status`(`audit_status`) USING BTREE,
  INDEX `idx_data_user_transfer_appid`(`appid`) USING BTREE,
  INDEX `idx_data_user_transfer_openid`(`openid`) USING BTREE,
  INDEX `idx_data_user_transfer_uuid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-提现' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品名称',
  `marks` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品标签',
  `cateids` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类编号',
  `cover` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品封面',
  `slider` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '轮播图片',
  `remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品描述',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品详情',
  `payment` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付方式',
  `data_specs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格(JSON)',
  `data_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格(JSON)',
  `stock_total` bigint(20) NULL DEFAULT 0 COMMENT '商品库存统计',
  `stock_sales` bigint(20) NULL DEFAULT 0 COMMENT '商品销售统计',
  `stock_virtual` bigint(20) NULL DEFAULT 0 COMMENT '商品虚拟销量',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '最低销售价格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '最低市场价格',
  `discount_id` bigint(20) NULL DEFAULT 0 COMMENT '折扣方案编号',
  `truck_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '物流运费模板',
  `truck_type` tinyint(1) NULL DEFAULT 0 COMMENT '物流配送(0无需配送,1需要配送)',
  `rebate_type` tinyint(1) NULL DEFAULT 1 COMMENT '参与返利(0无需返利,1需要返利)',
  `vip_entry` tinyint(1) NULL DEFAULT 0 COMMENT '入会礼包(0非入会礼包,1是入会礼包)',
  `vip_upgrade` bigint(20) NULL DEFAULT 0 COMMENT '购买升级等级(0不升级,其他升级)',
  `limit_low_vip` bigint(20) NULL DEFAULT 0 COMMENT '限制最低等级(0不限制,其他限制)',
  `limit_max_num` bigint(20) NULL DEFAULT 0 COMMENT '最大购买数量(0不限制,其他限制)',
  `num_read` bigint(20) NULL DEFAULT 0 COMMENT '访问阅读统计',
  `state_hot` tinyint(1) NULL DEFAULT 0 COMMENT '设置热度标签',
  `state_home` tinyint(1) NULL DEFAULT 0 COMMENT '设置首页推荐',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '列表排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_code`(`code`) USING BTREE,
  INDEX `idx_shop_goods_status`(`status`) USING BTREE,
  INDEX `idx_shop_goods_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 189 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-内容' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_cate`;
CREATE TABLE `shop_goods_cate`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NULL DEFAULT 0 COMMENT '上级分类',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类图标',
  `remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '使用状态',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_cate_sort`(`sort`) USING BTREE,
  INDEX `idx_shop_goods_cate_status`(`status`) USING BTREE,
  INDEX `idx_shop_goods_cate_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1231 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-分类' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_goods_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_item`;
CREATE TABLE `shop_goods_item`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_sku` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `stock_sales` bigint(20) NULL DEFAULT 0 COMMENT '销售数量',
  `stock_total` bigint(20) NULL DEFAULT 0 COMMENT '商品库存',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售价格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场价格',
  `number_virtual` bigint(20) NULL DEFAULT 0 COMMENT '虚拟销量',
  `number_express` bigint(20) NULL DEFAULT 1 COMMENT '配送计件',
  `reward_balance` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '奖励余额',
  `reward_integral` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '奖励积分',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '商品状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_item_code`(`goods_code`) USING BTREE,
  INDEX `idx_shop_goods_item_spec`(`goods_spec`) USING BTREE,
  INDEX `idx_shop_goods_item_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1187 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-规格' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_goods_mark
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_mark`;
CREATE TABLE `shop_goods_mark`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签描述',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '标签状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_mark_sort`(`sort`) USING BTREE,
  INDEX `idx_shop_goods_mark_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 119 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-标签' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_goods_stock
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_stock`;
CREATE TABLE `shop_goods_stock`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `batch_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '操作批量',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `goods_stock` bigint(20) NULL DEFAULT 0 COMMENT '入库数量',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '数据状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_stock_status`(`status`) USING BTREE,
  INDEX `idx_shop_goods_stock_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 684 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-库存' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_order
-- ----------------------------
DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE `shop_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '下单用户编号',
  `puid1` bigint(20) NULL DEFAULT 0 COMMENT '推荐一层用户',
  `puid2` bigint(20) NULL DEFAULT 0 COMMENT '推荐二层用户',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品订单单号',
  `amount_real` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单实际金额',
  `amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单统计金额',
  `amount_goods` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品统计金额',
  `amount_reduct` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '随机减免金额',
  `amount_express` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '快递费用金额',
  `amount_discount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '折扣后的金额',
  `payment_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际支付平台',
  `payment_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际通道编号',
  `payment_allow` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '允许支付通道',
  `payment_trade` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际支付单号',
  `payment_status` tinyint(1) NULL DEFAULT 0 COMMENT '实际支付状态',
  `payment_image` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付凭证图片',
  `payment_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '实际支付金额',
  `payment_balance` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '余额抵扣金额',
  `payment_remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付结果描述',
  `payment_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付到账时间',
  `number_goods` bigint(20) NULL DEFAULT 0 COMMENT '订单商品数量',
  `number_express` bigint(20) NULL DEFAULT 0 COMMENT '订单快递计数',
  `truck_type` tinyint(1) NULL DEFAULT 0 COMMENT '物流配送类型(0无需配送,1需要配送)',
  `rebate_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '参与返利金额',
  `reward_balance` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '奖励账户余额',
  `order_remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单用户备注',
  `cancel_status` tinyint(1) NULL DEFAULT 0 COMMENT '订单取消状态',
  `cancel_remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单取消描述',
  `cancel_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单取消时间',
  `deleted_status` tinyint(1) NULL DEFAULT 0 COMMENT '订单删除状态(0未删,1已删)',
  `deleted_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单删除描述',
  `deleted_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单删除时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '订单流程状态(0已取消,1预订单,2待支付,3支付中,4已支付,5已发货,6已完成)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_orderno`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_cancel_status`(`cancel_status`) USING BTREE,
  INDEX `idx_shop_order_payment_status`(`payment_status`) USING BTREE,
  INDEX `idx_shop_order_from`(`puid1`) USING BTREE,
  INDEX `idx_shop_order_deleted`(`deleted_status`) USING BTREE,
  INDEX `idx_shop_order_mid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-内容' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_order_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_item`;
CREATE TABLE `shop_order_item`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '商城用户编号',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商城订单单号',
  `goods_sku` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商城商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商城商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商城商品规格',
  `goods_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商城商品名称',
  `goods_cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品封面图片',
  `goods_payment` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '指定支付通道',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品市场单价',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品销售单价',
  `total_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品市场总价',
  `total_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品销售总价',
  `reward_balance` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品奖励余额',
  `reward_integral` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品奖励积分',
  `stock_sales` bigint(20) NULL DEFAULT 1 COMMENT '包含商品数量',
  `vip_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户等级名称',
  `vip_code` bigint(20) NULL DEFAULT 0 COMMENT '用户等级序号',
  `vip_entry` tinyint(1) NULL DEFAULT 0 COMMENT '是否入会礼包(0非礼包,1是礼包)',
  `vip_upgrade` bigint(20) NULL DEFAULT 0 COMMENT '升级用户等级',
  `truck_type` tinyint(1) NULL DEFAULT 0 COMMENT '物流配送类型(0虚物,1实物)',
  `truck_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递邮费模板',
  `truck_number` bigint(20) NULL DEFAULT 0 COMMENT '快递计费基数',
  `rebate_type` tinyint(1) NULL DEFAULT 0 COMMENT '参与返利状态(0不返,1返利)',
  `rebate_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '参与返利金额',
  `discount_id` bigint(20) NULL DEFAULT 0 COMMENT '优惠方案编号',
  `discount_rate` decimal(20, 6) NULL DEFAULT 100.000000 COMMENT '销售价格折扣',
  `discount_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品优惠金额',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_item_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_item_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_item_order_no`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_item_goods_sku`(`goods_sku`) USING BTREE,
  INDEX `idx_shop_order_item_goods_code`(`goods_code`) USING BTREE,
  INDEX `idx_shop_order_item_goods_spec`(`goods_spec`) USING BTREE,
  INDEX `idx_shop_order_item_rebate_type`(`rebate_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-商品' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_order_send
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_send`;
CREATE TABLE `shop_order_send`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '商城用户编号',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商城订单单号',
  `address_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址编号',
  `address_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人姓名',
  `address_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人手机',
  `address_idcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人证件号码',
  `address_idimg1` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人证件正面',
  `address_idimg2` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人证件反面',
  `address_province` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址的省份',
  `address_city` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址的城市',
  `address_area` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址的区域',
  `address_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送的详细地址',
  `address_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址确认时间',
  `template_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送模板编号',
  `template_count` bigint(20) NULL DEFAULT 0 COMMENT '快递计费基数',
  `template_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送计算描述',
  `template_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '配送计算金额',
  `company_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司编码',
  `company_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `send_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递运送单号',
  `send_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递发送备注',
  `send_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递发送时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '发货商品状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '发货删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_send_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_send_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_send_order_no`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_send_mid`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-配送' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for system_auth
-- ----------------------------
DROP TABLE IF EXISTS `system_auth`;
CREATE TABLE `system_auth`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '权限名称',
  `utype` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '身份权限',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_auth_status`(`status`) USING BTREE,
  INDEX `idx_system_auth_title`(`title`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 155 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-权限' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for system_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `auth` bigint(20) NULL DEFAULT 0 COMMENT '角色',
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '节点',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_auth_auth`(`auth`) USING BTREE,
  INDEX `idx_system_auth_node`(`node`(191)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24370 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-授权' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for system_base
-- ----------------------------
DROP TABLE IF EXISTS `system_base`;
CREATE TABLE `system_base`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '数据类型',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '数据代码',
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '数据名称',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '数据内容',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '数据状态(0禁用,1启动)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0正常,1已删)',
  `deleted_at` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '删除时间',
  `deleted_by` bigint(20) NULL DEFAULT 0 COMMENT '删除用户',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_base_type`(`type`) USING BTREE,
  INDEX `idx_system_base_code`(`code`) USING BTREE,
  INDEX `idx_system_base_name`(`name`(191)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 179 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-字典' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置分类',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置名称',
  `value` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置内容',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_config_type`(`type`) USING BTREE,
  INDEX `idx_system_config_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-配置' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for system_data
-- ----------------------------
DROP TABLE IF EXISTS `system_data`;
CREATE TABLE `system_data`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置名',
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_data_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-数据' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for system_file
-- ----------------------------
DROP TABLE IF EXISTS `system_file`;
CREATE TABLE `system_file`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '上传类型',
  `hash` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件哈希',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件名称',
  `xext` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件后缀',
  `xurl` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '访问链接',
  `xkey` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件路径',
  `mime` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件类型',
  `size` bigint(20) NULL DEFAULT 0 COMMENT '文件大小',
  `uuid` bigint(20) NULL DEFAULT 0 COMMENT '用户编号',
  `isfast` tinyint(1) NULL DEFAULT 0 COMMENT '是否秒传',
  `issafe` tinyint(1) NULL DEFAULT 0 COMMENT '安全模式',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '上传状态(1悬空,2落地)',
  `create_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_file_type`(`type`) USING BTREE,
  INDEX `idx_system_file_hash`(`hash`) USING BTREE,
  INDEX `idx_system_file_uuid`(`uuid`) USING BTREE,
  INDEX `idx_system_file_xext`(`xext`) USING BTREE,
  INDEX `idx_system_file_status`(`status`) USING BTREE,
  INDEX `idx_system_file_issafe`(`issafe`) USING BTREE,
  INDEX `idx_system_file_isfast`(`isfast`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 587 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-文件' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NULL DEFAULT 0 COMMENT '上级ID',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '菜单图标',
  `node` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '节点代码',
  `url` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接节点',
  `params` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '_self' COMMENT '打开方式',
  `sort` int(11) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态(0:禁用,1:启用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_system_menu_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-菜单' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_oplog
-- ----------------------------
DROP TABLE IF EXISTS `system_oplog`;
CREATE TABLE `system_oplog`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `node` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `geoip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `action` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作行为名称',
  `content` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作内容描述',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1581 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-日志' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for system_queue
-- ----------------------------
DROP TABLE IF EXISTS `system_queue`;
CREATE TABLE `system_queue`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '任务编号',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '任务名称',
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
) ENGINE = InnoDB AUTO_INCREMENT = 5554 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-任务' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usertype` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户类型',
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
) ENGINE = InnoDB AUTO_INCREMENT = 10131 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-用户' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for wechat_auto
-- ----------------------------
DROP TABLE IF EXISTS `wechat_auto`;
CREATE TABLE `wechat_auto`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '类型(text,image,news)',
  `time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '延迟时间',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息编号',
  `appid` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
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
  `news_id` bigint(20) NULL DEFAULT 0 COMMENT '图文ID',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态(0禁用,1启用)',
  `create_by` bigint(20) NULL DEFAULT 0 COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_wechat_auto_type`(`type`) USING BTREE,
  INDEX `idx_wechat_auto_keys`(`time`) USING BTREE,
  INDEX `idx_wechat_auto_code`(`code`) USING BTREE,
  INDEX `idx_wechat_auto_appid`(`appid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-回复' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for wechat_fans
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans`;
CREATE TABLE `wechat_fans`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `unionid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '粉丝unionid',
  `openid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '粉丝openid',
  `tagid_list` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '粉丝标签id',
  `is_black` tinyint(1) NULL DEFAULT 0 COMMENT '是否为黑名单状态',
  `subscribe` tinyint(1) NULL DEFAULT 0 COMMENT '关注状态(0未关注,1已关注)',
  `nickname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户昵称',
  `sex` tinyint(1) NULL DEFAULT 0 COMMENT '用户性别(1男性,2女性,0未知)',
  `country` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户所在国家',
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户所在省份',
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户所在城市',
  `language` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户的语言(zh_CN)',
  `headimgurl` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户头像',
  `subscribe_time` bigint(20) NULL DEFAULT 0 COMMENT '关注时间',
  `subscribe_at` datetime NULL DEFAULT NULL COMMENT '关注时间',
  `remark` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `subscribe_scene` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '扫码关注场景',
  `qr_scene` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '二维码场景值',
  `qr_scene_str` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '二维码场景内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_wechat_fans_openid`(`openid`) USING BTREE,
  INDEX `idx_wechat_fans_unionid`(`unionid`) USING BTREE,
  INDEX `idx_wechat_fans_isblack`(`is_black`) USING BTREE,
  INDEX `idx_wechat_fans_subscribe`(`subscribe`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 491 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-粉丝' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for wechat_fans_tags
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans_tags`;
CREATE TABLE `wechat_fans_tags`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `appid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `name` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `count` bigint(20) NULL DEFAULT 0 COMMENT '总数',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  INDEX `idx_wechat_fans_tags_id`(`id`) USING BTREE,
  INDEX `idx_wechat_fans_tags_appid`(`appid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 246 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-标签' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for wechat_keys
-- ----------------------------
DROP TABLE IF EXISTS `wechat_keys`;
CREATE TABLE `wechat_keys`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号APPID',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '类型(text,image,news)',
  `keys` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '关键字',
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
  `news_id` bigint(20) NULL DEFAULT 0 COMMENT '图文ID',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序字段',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态(0禁用,1启用)',
  `create_by` bigint(20) NULL DEFAULT 0 COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_wechat_keys_appid`(`appid`) USING BTREE,
  INDEX `idx_wechat_keys_type`(`type`) USING BTREE,
  INDEX `idx_wechat_keys_keys`(`keys`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-规则' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for wechat_media
-- ----------------------------
DROP TABLE IF EXISTS `wechat_media`;
CREATE TABLE `wechat_media`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `md5` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文件md5',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '媒体类型',
  `appid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公众号ID',
  `media_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '本地文件链接',
  `media_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_wechat_media_appid`(`appid`) USING BTREE,
  INDEX `idx_wechat_media_md5`(`md5`) USING BTREE,
  INDEX `idx_wechat_media_type`(`type`) USING BTREE,
  INDEX `idx_wechat_media_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-素材' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news`;
CREATE TABLE `wechat_news`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材外网URL',
  `article_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '关联图文ID(用英文逗号做分割)',
  `is_deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删除,1已删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_wechat_news_artcle_id`(`article_id`) USING BTREE,
  INDEX `idx_wechat_news_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 118 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-图文' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for wechat_news_article
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_article`;
CREATE TABLE `wechat_news_article`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '素材标题',
  `local_url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) NULL DEFAULT 0 COMMENT '显示封面(0不显示,1显示)',
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章作者',
  `digest` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '摘要内容',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '图文内容',
  `content_source_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '原文地址',
  `read_num` bigint(20) NULL DEFAULT 0 COMMENT '阅读数量',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 303 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-文章' ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
