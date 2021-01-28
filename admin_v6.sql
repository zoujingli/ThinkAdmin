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

 Date: 28/01/2021 16:01:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for data_news_item
-- ----------------------------
DROP TABLE IF EXISTS `data_news_item`;
CREATE TABLE `data_news_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标题',
  `mark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标签',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章封面',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '文章内容',
  `num_like` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章点赞数',
  `num_read` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章阅读数',
  `num_collect` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章收藏数',
  `num_comment` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章评论数',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '文章状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_code`(`code`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-内容' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_news_item
-- ----------------------------

-- ----------------------------
-- Table structure for data_news_mark
-- ----------------------------
DROP TABLE IF EXISTS `data_news_mark`;
CREATE TABLE `data_news_mark`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签说明',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '标签状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_mark_status`(`status`) USING BTREE,
  INDEX `idx_data_news_mark_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-标签' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_news_mark
-- ----------------------------

-- ----------------------------
-- Table structure for data_news_x_collect
-- ----------------------------
DROP TABLE IF EXISTS `data_news_x_collect`;
CREATE TABLE `data_news_x_collect`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '记录类型(1收藏,2点赞,3历史)',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章编号',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_x_collect_mid`(`uid`) USING BTREE,
  INDEX `idx_data_news_x_collect_type`(`type`) USING BTREE,
  INDEX `idx_data_news_x_collect_code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-标记' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_news_x_collect
-- ----------------------------

-- ----------------------------
-- Table structure for data_news_x_comment
-- ----------------------------
DROP TABLE IF EXISTS `data_news_x_comment`;
CREATE TABLE `data_news_x_comment`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章编号',
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '评论内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_x_comment_mid`(`uid`) USING BTREE,
  INDEX `idx_data_news_x_comment_code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-评论' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_news_x_comment
-- ----------------------------

-- ----------------------------
-- Table structure for data_user
-- ----------------------------
DROP TABLE IF EXISTS `data_user`;
CREATE TABLE `data_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '-' COMMENT '推荐关系',
  `layer` bigint(20) UNSIGNED NULL DEFAULT 1 COMMENT '推荐层级',
  `from` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐人1UID',
  `pfrom` bigint(20) NULL DEFAULT 0 COMMENT '推荐人2UID',
  `from_at` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '推荐人绑定时间',
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
  `vip_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'VIP等级名称',
  `vip_number` bigint(20) NULL DEFAULT 0 COMMENT 'VIP等级序号',
  `vip_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'VIP等级时间',
  `amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '返利收益统计',
  `amount_used` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '提现金额统计',
  `balance_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '累计充值统计',
  `balance_used` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '已经使用统计',
  `order_amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单交易统计',
  `teams_users_total` bigint(20) NULL DEFAULT 0 COMMENT '团队人数统计',
  `teams_users_direct` bigint(20) NULL DEFAULT 0 COMMENT '直属人数团队',
  `teams_users_indirect` bigint(20) NULL DEFAULT 0 COMMENT '间接人数团队',
  `teams_amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '二级团队业绩',
  `teams_amount_direct` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '直属团队业绩',
  `teams_amount_indirect` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '间接团队业绩',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户备注描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '用户状态(1正常,0已黑)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_status`(`status`) USING BTREE,
  INDEX `idx_data_user_deleted`(`deleted`) USING BTREE,
  INDEX `idx_data_user_openid1`(`openid1`) USING BTREE,
  INDEX `idx_data_user_openid2`(`openid2`) USING BTREE,
  INDEX `idx_data_user_unionid`(`unionid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-会员' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_address
-- ----------------------------
DROP TABLE IF EXISTS `data_user_address`;
CREATE TABLE `data_user_address`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '地址类型(0普通,1默认)',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货姓名',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货手机',
  `idcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '身体证号',
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-省份',
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-城市',
  `area` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-区域',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-详情',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_address_type`(`type`) USING BTREE,
  INDEX `idx_data_user_address_code`(`code`) USING BTREE,
  INDEX `idx_data_user_address_deleted`(`deleted`) USING BTREE,
  INDEX `idx_data_user_address_uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-地址' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_address
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_balance
-- ----------------------------
DROP TABLE IF EXISTS `data_user_balance`;
CREATE TABLE `data_user_balance`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '充值编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '充值名称',
  `remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '充值备注',
  `amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '充值金额',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_by` bigint(20) NULL DEFAULT 0 COMMENT '系统用户',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_balance_uid`(`uid`) USING BTREE,
  INDEX `idx_data_user_balance_code`(`code`) USING BTREE,
  INDEX `idx_data_user_balance_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-余额' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_balance
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_balance_transfer
-- ----------------------------
DROP TABLE IF EXISTS `data_user_balance_transfer`;
CREATE TABLE `data_user_balance_transfer`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `from` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '来自UID',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '转账编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '转账名称',
  `remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '转账备注',
  `amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '转账金额',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_balance_transfer_uid`(`uid`) USING BTREE,
  INDEX `idx_data_user_balance_transfer_code`(`code`) USING BTREE,
  INDEX `idx_data_user_balance_transfer_from`(`from`) USING BTREE,
  INDEX `idx_data_user_balance_transfer_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-转账' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_balance_transfer
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_discount
-- ----------------------------
DROP TABLE IF EXISTS `data_user_discount`;
CREATE TABLE `data_user_discount`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '方案名称',
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '方案规则',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '方案描述',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '方案状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_discount_status`(`status`) USING BTREE,
  INDEX `idx_data_user_discount_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-会员-折扣' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of data_user_discount
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_level
-- ----------------------------
DROP TABLE IF EXISTS `data_user_level`;
CREATE TABLE `data_user_level`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户级别名称',
  `number` tinyint(2) UNSIGNED NULL DEFAULT 0 COMMENT '用户级别序号',
  `rebate_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户奖利规则',
  `upgrade_type` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '会员升级规则(0单个,1同时)',
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
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '用户等级状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '等级创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_level_status`(`status`) USING BTREE,
  INDEX `idx_data_user_level_number`(`number`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-等级' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of data_user_level
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_message
-- ----------------------------
DROP TABLE IF EXISTS `data_user_message`;
CREATE TABLE `data_user_message`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '短信类型',
  `msgid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息编号',
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '目标手机',
  `region` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '国家编号',
  `result` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '返回结果',
  `content` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '短信内容',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '短信状态(0失败,1成功)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_message_type`(`type`) USING BTREE,
  INDEX `idx_data_user_message_phone`(`phone`) USING BTREE,
  INDEX `idx_data_user_message_msgid`(`msgid`) USING BTREE,
  INDEX `idx_data_user_message_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-短信' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_message
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_notify
-- ----------------------------
DROP TABLE IF EXISTS `data_user_notify`;
CREATE TABLE `data_user_notify`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息类型',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '消息名称',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '消息内容',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '消息状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_notify_type`(`type`) USING BTREE,
  INDEX `idx_data_user_notify_status`(`status`) USING BTREE,
  INDEX `idx_data_user_notify_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-通知' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_notify
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_rebate
-- ----------------------------
DROP TABLE IF EXISTS `data_user_rebate`;
CREATE TABLE `data_user_rebate`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '奖励日期',
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '奖励编号',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '奖励类型',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '奖励名称',
  `amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '奖励数量',
  `order_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '订单单号',
  `order_uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '订单用户',
  `order_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单金额',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_rebate_uid`(`uid`) USING BTREE,
  INDEX `idx_data_user_rebate_type`(`type`) USING BTREE,
  INDEX `idx_data_user_rebate_date`(`date`) USING BTREE,
  INDEX `idx_data_user_rebate_code`(`code`) USING BTREE,
  INDEX `idx_data_user_rebate_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '数据-用户-返利' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of data_user_rebate
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_token
-- ----------------------------
DROP TABLE IF EXISTS `data_user_token`;
CREATE TABLE `data_user_token`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NULL DEFAULT 0 COMMENT '用户UID',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权类型',
  `time` bigint(20) NULL DEFAULT 0 COMMENT '有效时间',
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权令牌',
  `tokenv` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权验证',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_token_type`(`type`) USING BTREE,
  INDEX `idx_data_user_token_time`(`time`) USING BTREE,
  INDEX `idx_data_user_token_token`(`token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-认证' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_token
-- ----------------------------

-- ----------------------------
-- Table structure for data_user_transfer
-- ----------------------------
DROP TABLE IF EXISTS `data_user_transfer`;
CREATE TABLE `data_user_transfer`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户UID',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '提现类型（1余额提现，2银行提现）',
  `code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '提现单号',
  `openid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'OPENID',
  `amount` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '提现金额',
  `remark` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '提现描述',
  `trade_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商户交易',
  `trade_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '打款时间',
  `bank_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '开户姓名',
  `bank_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '银行名称',
  `bank_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '银行卡号',
  `bank_bran` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '开户分行',
  `change_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '处理时间',
  `change_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '处理描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '提现状态(0失败,1待审核,2已审核,3打款中,4已打款,5已收款)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_transfer_uid`(`uid`) USING BTREE,
  INDEX `idx_data_user_transfer_type`(`type`) USING BTREE,
  INDEX `idx_data_user_transfer_code`(`code`) USING BTREE,
  INDEX `idx_data_user_transfer_status`(`status`) USING BTREE,
  INDEX `idx_data_user_transfer_openid`(`openid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '数据-用户-提现' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of data_user_transfer
-- ----------------------------

-- ----------------------------
-- Table structure for shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cate` bigint(20) NULL DEFAULT 0 COMMENT '商品分类',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品名称',
  `mark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品标签',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品封面',
  `slider` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '轮播图片',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品描述',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品详情',
  `data_specs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格',
  `data_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格',
  `truck_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '运费模板',
  `stock_total` bigint(20) NULL DEFAULT 0 COMMENT '库存统计',
  `stock_sales` bigint(20) NULL DEFAULT 0 COMMENT '销售统计',
  `stock_virtual` bigint(20) NULL DEFAULT 0 COMMENT '虚拟销量',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '最低销售价格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '最低市场价格',
  `discount_id` bigint(20) NULL DEFAULT 0 COMMENT '折扣方案编号',
  `vip_entry` tinyint(1) NULL DEFAULT 0 COMMENT '入会礼包升级',
  `vip_upgrade` bigint(20) NULL DEFAULT 0 COMMENT '购买立即升级',
  `limit_low_vip` bigint(20) NULL DEFAULT 0 COMMENT '限制最低等级',
  `limit_max_buy` bigint(20) NULL DEFAULT 0 COMMENT '最大购买数量',
  `set_hot` tinyint(1) NULL DEFAULT 0 COMMENT '设置热度标签',
  `set_home` tinyint(1) NULL DEFAULT 0 COMMENT '设置首页推荐',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '列表排序权重',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_code`(`code`) USING BTREE,
  INDEX `idx_shop_goods_cate`(`cate`) USING BTREE,
  INDEX `idx_shop_goods_status`(`status`) USING BTREE,
  INDEX `idx_shop_goods_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-内容' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_goods
-- ----------------------------

-- ----------------------------
-- Table structure for shop_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_cate`;
CREATE TABLE `shop_goods_cate`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NULL DEFAULT 0 COMMENT '上级分类',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类名称',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类图标',
  `remark` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类描述',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '使用状态',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_cate_sort`(`sort`) USING BTREE,
  INDEX `idx_shop_goods_cate_status`(`status`) USING BTREE,
  INDEX `idx_shop_goods_cate_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-分类' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_goods_cate
-- ----------------------------

-- ----------------------------
-- Table structure for shop_goods_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_item`;
CREATE TABLE `shop_goods_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_sku` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `stock_sales` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '销售数量',
  `stock_total` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品库存',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '销售价格',
  `price_market` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '市场价格',
  `number_virtual` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '虚拟销量',
  `number_express` bigint(20) UNSIGNED NULL DEFAULT 1 COMMENT '计件数量',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_item_code`(`goods_code`) USING BTREE,
  INDEX `index_store_goods_item_spec`(`goods_spec`) USING BTREE,
  INDEX `index_store_goods_item_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城-商品-规格' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_goods_item
-- ----------------------------

-- ----------------------------
-- Table structure for shop_goods_mark
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_mark`;
CREATE TABLE `shop_goods_mark`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签描述',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '标签状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_mark_sort`(`sort`) USING BTREE,
  INDEX `idx_shop_goods_mark_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-标签' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_goods_mark
-- ----------------------------

-- ----------------------------
-- Table structure for shop_goods_stock
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_stock`;
CREATE TABLE `shop_goods_stock`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `batch_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '操作批量',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `goods_stock` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '入库数量',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '数据状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-商品-库存' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_goods_stock
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order
-- ----------------------------
DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE `shop_order`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户编号',
  `from` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐用户',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单编号',
  `amount_real` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单实际金额',
  `amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单统计金额',
  `amount_goods` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品统计金额',
  `amount_reduct` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '随机减免金额',
  `amount_express` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '快递费用金额',
  `amount_balance` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '全额抵扣金额',
  `amount_discount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '策略优惠金额',
  `payment_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际支付平台',
  `payment_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际通道编号',
  `payment_trade` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际支付单号',
  `payment_status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '实际支付状态',
  `payment_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '实际支付金额',
  `payment_remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付结果描述',
  `payment_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付到账时间',
  `number_goods` bigint(20) NULL DEFAULT 0 COMMENT '订单商品数量',
  `cancel_status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '订单取消状态',
  `cancel_remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单取消描述',
  `cancel_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单取消时间',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '订单删除状态(0未删,1已删)',
  `deleted_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单删除描述',
  `deleted_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单删除时间',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '订单状态(0已取消,1预订单,2待支付,3待发货,4待签收,5已完成)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_mid`(`uid`) USING BTREE,
  INDEX `idx_shop_order_from`(`from`) USING BTREE,
  INDEX `idx_shop_order_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_orderno`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_cancel_status`(`cancel_status`) USING BTREE,
  INDEX `idx_shop_order_payment_status`(`payment_status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-内容' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_order
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_item`;
CREATE TABLE `shop_order_item`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NULL DEFAULT 0 COMMENT '用户编号',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单单号',
  `goods_sku` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `goods_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品名称',
  `goods_cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品图片',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场单价',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售单价',
  `total_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场总价',
  `total_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售总价',
  `truck_count` bigint(20) NULL DEFAULT 0 COMMENT '快递计费基数',
  `truck_tcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递邮费模板',
  `stock_sales` bigint(20) NULL DEFAULT 1 COMMENT '购买商品数量',
  `vip_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户等级名称',
  `vip_entry` tinyint(1) NULL DEFAULT 0 COMMENT '是否入会礼包',
  `vip_number` bigint(20) NULL DEFAULT 0 COMMENT '用户等级序号',
  `discount_id` bigint(20) NULL DEFAULT 0 COMMENT '优惠方案编号',
  `discount_rate` decimal(20, 6) NULL DEFAULT 100.000000 COMMENT '销售价格折扣',
  `discount_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品优惠金额',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_item_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_item_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_item_order_no`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_item_goods_sku`(`goods_sku`) USING BTREE,
  INDEX `idx_shop_order_item_goods_code`(`goods_code`) USING BTREE,
  INDEX `idx_shop_order_item_goods_spec`(`goods_spec`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-商品' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_order_item
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_send
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_send`;
CREATE TABLE `shop_order_send`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户编号',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单订单',
  `address_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址编号',
  `address_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人姓名',
  `address_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人手机',
  `address_idcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人证件',
  `address_province` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址的省份',
  `address_city` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址的城市',
  `address_area` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址的区域',
  `address_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送的详细地址',
  `address_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址确认时间',
  `template_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送模板编号',
  `template_count` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '快递计费基数',
  `template_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送计算描述',
  `template_amount` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '配送计算金额',
  `company_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司编码',
  `company_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `send_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递运送单号',
  `send_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递发送备注',
  `send_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递发送时间',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_send_mid`(`uid`) USING BTREE,
  INDEX `idx_shop_order_send_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_send_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_send_order_no`(`order_no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-配送' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_order_send
-- ----------------------------

-- ----------------------------
-- Table structure for shop_payment
-- ----------------------------
DROP TABLE IF EXISTS `shop_payment`;
CREATE TABLE `shop_payment`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付类型',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '通道编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付名称',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '支付参数',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付说明',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '支付状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_payment_type`(`type`) USING BTREE,
  INDEX `idx_data_payment_code`(`code`) USING BTREE,
  INDEX `idx_data_payment_status`(`status`) USING BTREE,
  INDEX `idx_data_payment_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-支付-方式' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_payment
-- ----------------------------

-- ----------------------------
-- Table structure for shop_payment_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_payment_item`;
CREATE TABLE `shop_payment_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单单号',
  `order_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单描述',
  `order_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '订单金额',
  `payment_code` bigint(20) NULL DEFAULT 0 COMMENT '支付编号',
  `payment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付通道',
  `payment_trade` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付单号',
  `payment_status` tinyint(1) NULL DEFAULT 0 COMMENT '支付状态',
  `payment_amount` decimal(20, 2) NULL DEFAULT NULL COMMENT '支付金额',
  `payment_datatime` datetime NULL DEFAULT NULL COMMENT '支付时间',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_payment_item_order_no`(`order_no`) USING BTREE,
  INDEX `idx_data_payment_item_payment_code`(`payment_code`) USING BTREE,
  INDEX `idx_data_payment_item_payment_type`(`payment_type`) USING BTREE,
  INDEX `idx_data_payment_item_payment_trade`(`payment_trade`) USING BTREE,
  INDEX `idx_data_payment_item_payment_status`(`payment_status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-支付-记录' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_payment_item
-- ----------------------------

-- ----------------------------
-- Table structure for shop_truck_company
-- ----------------------------
DROP TABLE IF EXISTS `shop_truck_company`;
CREATE TABLE `shop_truck_company`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `code_1` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司代码',
  `code_2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '百度快递100代码',
  `code_3` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '官方快递100代码',
  `remark` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司描述',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0.无效,1.有效)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(1已删除,0未删除)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_truck_company_code1`(`code_1`) USING BTREE,
  INDEX `idx_shop_truck_company_code2`(`code_2`) USING BTREE,
  INDEX `idx_shop_truck_company_code3`(`code_3`) USING BTREE,
  INDEX `idx_shop_truck_company_status`(`status`) USING BTREE,
  INDEX `idx_shop_truck_company_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城-快递-公司' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_truck_company
-- ----------------------------
INSERT INTO `shop_truck_company` VALUES (1, '顺丰速运', 'SF', 'shunfeng', 'shunfeng', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (2, '百世快递', 'HTKY', 'huitongkuaidi', 'huitongkuaidi', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (3, '中通快递', 'ZTO', 'zhongtong', 'zhongtong', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (4, '申通快递', 'STO', 'shentong', 'shentong', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (5, '圆通速递', 'YTO', 'yuantong', 'yuantong', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (6, '韵达速递', 'YD', 'yunda', 'yunda', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (7, '邮政快递包裹', 'YZPY', 'youzhengguonei', 'youzhengguonei', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (8, 'EMS', 'EMS', 'ems', 'ems', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (9, '天天快递', 'HHTT', 'tiantian', 'tiantian', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (10, '京东快递', 'JD', 'jd', 'jd', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (11, '德邦快递', 'DBL', 'debangwuliu', 'debangkuaidi', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (12, '优速快递', 'UC', 'youshuwuliu', 'youshuwuliu', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (13, '宅急送', 'ZJS', 'zhaijisong', 'zhaijisong', '', 0, 1, 0, '2020-12-22 07:23:05');
INSERT INTO `shop_truck_company` VALUES (14, '极兔快递', 'jtexpress', 'jtexpress', 'jtexpress', '', 0, 1, 0, '2020-12-22 07:23:05');

-- ----------------------------
-- Table structure for shop_truck_region
-- ----------------------------
DROP TABLE IF EXISTS `shop_truck_region`;
CREATE TABLE `shop_truck_region`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '上级PID',
  `first` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '首字母',
  `short` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '区域简称',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '区域名称',
  `level` tinyint(4) NULL DEFAULT 0 COMMENT '区域层级',
  `pinyin` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '区域拼音',
  `code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '区域邮编',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '使用状态',
  `lng` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '所在经度',
  `lat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '所在纬度',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_truck_region_pid`(`pid`) USING BTREE,
  INDEX `idx_shop_truck_region_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城-快递-区域' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_truck_region
-- ----------------------------

-- ----------------------------
-- Table structure for shop_truck_template
-- ----------------------------
DROP TABLE IF EXISTS `shop_truck_template`;
CREATE TABLE `shop_truck_template`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '模板编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '模板名称',
  `normal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '默认规则',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '模板规则',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '模板状态',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-快递-模板' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_truck_template
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-权限' ROW_FORMAT = COMPACT;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-授权' ROW_FORMAT = COMPACT;

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-配置' ROW_FORMAT = COMPACT;

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
INSERT INTO `system_config` VALUES ('storage', 'allow_exts', 'doc,gif,icon,jpg,mp3,mp4,p12,pem,png,rar,xls,xlsx');
INSERT INTO `system_config` VALUES ('storage', 'link_type', 'none');
INSERT INTO `system_config` VALUES ('storage', 'local_http_domain', '');
INSERT INTO `system_config` VALUES ('storage', 'local_http_protocol', 'follow');
INSERT INTO `system_config` VALUES ('storage', 'type', 'local');
INSERT INTO `system_config` VALUES ('wechat', 'type', 'thr');
INSERT INTO `system_config` VALUES ('wechat', 'thr_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES ('wechat', 'thr_appkey', '7d0e4a487c6258b2232294b6ef0adb9e');
INSERT INTO `system_config` VALUES ('storage', 'qiniu_http_protocol', 'http');
INSERT INTO `system_config` VALUES ('storage', 'txcos_http_protocol', 'http');
INSERT INTO `system_config` VALUES ('data', 'wxapp_appid', 'wx6bb7b70258da09c6');
INSERT INTO `system_config` VALUES ('data', 'wxapp_appkey', '4cdab4affa9c160e935a24a2860ff7f0');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-数据' ROW_FORMAT = COMPACT;

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
) ENGINE = InnoDB AUTO_INCREMENT = 94 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-菜单' ROW_FORMAT = COMPACT;

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
INSERT INTO `system_menu` VALUES (71, 68, '轮播图片管理', 'layui-icon layui-icon-carousel', '', 'data/config/slider', '', '_self', 8, 1, '2020-07-14 01:17:02');
INSERT INTO `system_menu` VALUES (73, 67, '商城管理（开发中）', '', '', '#', '', '_self', 0, 1, '2020-09-08 02:51:30');
INSERT INTO `system_menu` VALUES (75, 73, '商品分类管理', 'layui-icon layui-icon-form', 'data/shop_goods_cate/index', 'data/shop_goods_cate/index', '', '_self', 70, 1, '2020-09-08 03:35:58');
INSERT INTO `system_menu` VALUES (76, 73, '商品数据管理', 'layui-icon layui-icon-star', 'data/shop_goods/index', 'data/shop_goods/index', '', '_self', 90, 1, '2020-09-08 07:13:19');
INSERT INTO `system_menu` VALUES (77, 90, '会员用户管理', 'layui-icon layui-icon-user', 'data/user/index', 'data/user/index', '', '_self', 900, 1, '2020-09-10 01:48:02');
INSERT INTO `system_menu` VALUES (78, 73, '订单数据管理', 'layui-icon layui-icon-template-1', 'data/shop_order/index', 'data/shop_order/index', '', '_self', 60, 1, '2020-09-10 01:48:41');
INSERT INTO `system_menu` VALUES (79, 73, '订单发货管理', 'layui-icon layui-icon-transfer', 'data/shop_order_send/index', 'data/shop_order_send/index', '', '_self', 50, 1, '2020-09-10 01:50:12');
INSERT INTO `system_menu` VALUES (81, 73, '快递公司管理', 'layui-icon layui-icon-website', 'data/shop_truck_company/index', 'data/shop_truck_company/index', '', '_self', 0, 1, '2020-09-15 08:47:46');
INSERT INTO `system_menu` VALUES (82, 73, '邮费模板管理', 'layui-icon layui-icon-template-1', 'data/shop_truck_template/index', 'data/shop_truck_template/index', '', '_self', 0, 1, '2020-09-15 09:14:46');
INSERT INTO `system_menu` VALUES (83, 73, '配送区域管理', 'layui-icon layui-icon-location', 'data/shop_truck_template/region', 'data/shop_truck_template/region', '', '_self', 0, 1, '2020-09-17 09:13:35');
INSERT INTO `system_menu` VALUES (84, 68, '微信小程序配置', 'layui-icon layui-icon-set', 'data/config/wxapp', 'data/config/wxapp', '', '_self', 5, 1, '2020-09-21 16:34:08');
INSERT INTO `system_menu` VALUES (85, 68, '会员服务协议', 'layui-icon layui-icon-template-1', 'data/config/agreement', 'data/config/agreement', '', '_self', 30, 1, '2020-09-22 16:00:10');
INSERT INTO `system_menu` VALUES (86, 68, '关于我们描述', 'layui-icon layui-icon-app', 'data/config/about', 'data/config/about', '', '_self', 40, 1, '2020-09-22 16:12:44');
INSERT INTO `system_menu` VALUES (87, 68, '支付参数管理', 'layui-icon layui-icon-rmb', 'data/shop_payment/index', 'data/shop_payment/index', '', '_self', 6, 1, '2020-12-12 09:08:09');
INSERT INTO `system_menu` VALUES (88, 68, '系统通知管理', 'layui-icon layui-icon-notice', 'data/user_notify/index', 'data/user_notify/index', '', '_self', 6, 1, '2021-01-20 10:07:32');
INSERT INTO `system_menu` VALUES (89, 90, '余额充值记录', 'layui-icon layui-icon-rmb', 'data/user_balance/index', 'data/user_balance/index', '', '_self', 800, 1, '2021-01-20 10:09:49');
INSERT INTO `system_menu` VALUES (90, 67, '用户管理', '', '', '#', '', '_self', 0, 1, '2021-01-22 05:43:01');
INSERT INTO `system_menu` VALUES (91, 90, '用户等级管理', 'layui-icon layui-icon-senior', 'data/user_level/index', 'data/user_level/index', '', '_self', 700, 1, '2021-01-22 05:43:27');
INSERT INTO `system_menu` VALUES (92, 90, '用户折扣方案', 'layui-icon layui-icon-set', 'data/user_discount/index', 'data/user_discount/index', '', '_self', 0, 1, '2021-01-27 05:44:51');
INSERT INTO `system_menu` VALUES (93, 90, '用户提现管理', 'layui-icon layui-icon-component', 'data/user_transfer/index', 'data/user_transfer/index', '', '_self', 0, 1, '2021-01-28 06:48:34');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-日志' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of system_oplog
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-任务' ROW_FORMAT = COMPACT;

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
  INDEX `idx_system_user_status`(`status`) USING BTREE,
  INDEX `idx_system_user_username`(`username`) USING BTREE,
  INDEX `idx_system_user_deleted`(`is_deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-用户' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES (10000, 'admin', '21232f297a57a5a743894a0e4a801fc3', '系统管理员', 'http://127.0.0.1:8000/upload/0b/41ddc2fe3395af9c8de51282b70e87.jpg', ',,', '', '', '', '127.0.0.1', '2021-01-28 06:20:48', 71, '', 1, 0, 0, '2015-11-13 15:14:22');

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
  INDEX `index_wechat_fans_isblack`(`is_black`) USING BTREE,
  INDEX `index_wechat_fans_subscribe`(`subscribe`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-粉丝' ROW_FORMAT = COMPACT;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-标签' ROW_FORMAT = COMPACT;

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
  INDEX `index_wechat_keys_type`(`type`) USING BTREE,
  INDEX `index_wechat_keys_keys`(`keys`) USING BTREE,
  INDEX `index_wechat_keys_appid`(`appid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-规则' ROW_FORMAT = COMPACT;

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
  INDEX `index_wechat_media_md5`(`md5`) USING BTREE,
  INDEX `index_wechat_media_type`(`type`) USING BTREE,
  INDEX `index_wechat_media_appid`(`appid`) USING BTREE,
  INDEX `index_wechat_media_media_id`(`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-素材' ROW_FORMAT = COMPACT;

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
  INDEX `index_wechat_news_media_id`(`media_id`) USING BTREE,
  INDEX `index_wechat_news_artcle_id`(`article_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-图文' ROW_FORMAT = COMPACT;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信-文章' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of wechat_news_article
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
