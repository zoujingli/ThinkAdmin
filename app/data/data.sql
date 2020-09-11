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

 Date: 11/09/2020 14:15:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for data_member
-- ----------------------------
DROP TABLE IF EXISTS `data_member`;
CREATE TABLE `data_member`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '邀请者MID',
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权TOKEN',
  `tokenv` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '授权TOKEN验证',
  `openid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '小程序OPENID',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员手机',
  `headimg` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员头像',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员姓名',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员昵称',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '登录密码',
  `region_province` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在省份',
  `region_city` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在城市',
  `region_area` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '所在区域',
  `base_age` bigint(20) NULL DEFAULT 0 COMMENT '会员年龄',
  `base_sex` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员性别',
  `base_height` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员身高',
  `base_weight` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员体重',
  `base_birthday` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '会员生日',
  `coin_total` bigint(20) NULL DEFAULT 0 COMMENT '金币数量',
  `coin_used` bigint(20) NULL DEFAULT 0 COMMENT '金币已用',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '会员状态(1正常,0已拉黑)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_member_token`(`token`) USING BTREE,
  INDEX `idx_data_member_status`(`status`) USING BTREE,
  INDEX `idx_data_member_openid`(`openid`) USING BTREE,
  INDEX `idx_data_member_deleted`(`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-会员' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for data_member_address
-- ----------------------------
DROP TABLE IF EXISTS `data_member_address`;
CREATE TABLE `data_member_address`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '地址类型(0普通,1默认)',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址编号',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货姓名',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收货手机',
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-省份',
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-城市',
  `area` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-区域',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址-详情',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_member_address_mid`(`mid`) USING BTREE,
  INDEX `idx_data_member_address_type`(`type`) USING BTREE,
  INDEX `idx_data_member_address_code`(`code`) USING BTREE,
  INDEX `idx_data_member_address_deleted`(`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-会员-地址' ROW_FORMAT=Compact;

-- ----------------------------
-- Table structure for data_member_coin_item
-- ----------------------------
DROP TABLE IF EXISTS `data_member_coin_item`;
CREATE TABLE `data_member_coin_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录编号',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录类型',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录名称',
  `number` bigint(20) NULL DEFAULT 0 COMMENT '奖励数量',
  `date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录日期',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_member_coin_mid`(`mid`) USING BTREE,
  INDEX `idx_data_member_coin_type`(`type`) USING BTREE,
  INDEX `idx_data_member_coin_name`(`name`) USING BTREE,
  INDEX `idx_data_member_coin_date`(`date`) USING BTREE,
  INDEX `idx_data_member_coin_code`(`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8 COLLATE=utf8_general_ci COMMENT='数据-会员-金币-获得' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for data_member_coin_used
-- ----------------------------
DROP TABLE IF EXISTS `data_member_coin_used`;
CREATE TABLE `data_member_coin_used`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员ID',
  `from` bigint(20) NULL DEFAULT 0 COMMENT '来自MID',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录类型',
  `target` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '目标ID',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录名称',
  `number` bigint(20) NULL DEFAULT 0 COMMENT '奖励数量',
  `date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录日期',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_member_coin_used_mid`(`mid`) USING BTREE,
  INDEX `idx_data_member_coin_used_type`(`type`) USING BTREE,
  INDEX `idx_data_member_coin_used_name`(`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8 COLLATE=utf8_general_ci COMMENT='数据-会员-金币-消费' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for data_news_item
-- ----------------------------
DROP TABLE IF EXISTS `data_news_item`;
CREATE TABLE `data_news_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标题',
  `mark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标签',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章封面',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '文章内容',
  `num_like` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章点赞数',
  `num_read` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章阅读数',
  `num_collect` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章收藏数',
  `num_comment` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章评论数',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-文章-内容' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for data_news_mark
-- ----------------------------
DROP TABLE IF EXISTS `data_news_mark`;
CREATE TABLE `data_news_mark`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签说明',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_mark_status`(`status`) USING BTREE,
  INDEX `idx_data_news_mark_deleted`(`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-文章-标签' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for data_news_x_collect
-- ----------------------------
DROP TABLE IF EXISTS `data_news_x_collect`;
CREATE TABLE `data_news_x_collect`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '记录类型(1收藏,2点赞)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_x_collect_cid`(`cid`) USING BTREE,
  INDEX `idx_data_news_x_collect_mid`(`mid`) USING BTREE,
  INDEX `idx_data_news_x_collect_type`(`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-文章-会员-收藏' ROW_FORMAT=Compact;

-- ----------------------------
-- Table structure for data_news_x_comment
-- ----------------------------
DROP TABLE IF EXISTS `data_news_x_comment`;
CREATE TABLE `data_news_x_comment`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '评论内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_x_comment_cid`(`cid`) USING BTREE,
  INDEX `idx_data_news_x_comment_mid`(`mid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-文章-会员-评论' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for data_news_x_history
-- ----------------------------
DROP TABLE IF EXISTS `data_news_x_history`;
CREATE TABLE `data_news_x_history`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_x_history_cid`(`cid`) USING BTREE,
  INDEX `idx_data_news_x_history_mid`(`mid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据-文章-会员-历史' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate` bigint(20) NULL DEFAULT 0 COMMENT '商品分类',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品名称',
  `mark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品标签',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品封面',
  `slider` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '轮播图片',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品描述',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品详情',
  `data_specs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格',
  `data_items` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品规格',
  `stock_total` bigint(20) NULL DEFAULT 0 COMMENT '库存统计',
  `stock_sales` bigint(20) NULL DEFAULT 0 COMMENT '销售统计',
  `stock_virtual` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '虚拟销量',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品销售价格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品市场价格',
  `num_read` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章阅读数',
  `num_collect` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章收藏数',
  `num_comment` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章评论数',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-商品-内容' ROW_FORMAT=Compact;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-商品-分类' ROW_FORMAT=Compact;

-- ----------------------------
-- Table structure for shop_goods_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_item`;
CREATE TABLE `shop_goods_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_sku` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售价格',
  `price_market` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '市场价格',
  `stock_sales` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '销售数量',
  `stock_total` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '商品库存',
  `number_virtual` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '虚拟销量',
  `number_express` bigint(20) UNSIGNED NULL DEFAULT 1 COMMENT '计件数量',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_store_goods_list_id`(`goods_code`) USING BTREE,
  INDEX `index_store_goods_list_spec`(`goods_spec`) USING BTREE,
  INDEX `index_store_goods_list_status`(`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 CHARACTER SET=utf8 COLLATE=utf8_general_ci COMMENT='商城-商品-规格' ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for shop_goods_mark
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods_mark`;
CREATE TABLE `shop_goods_mark`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签描述',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_goods_mark_sort`(`sort`) USING BTREE,
  INDEX `idx_shop_goods_mark_status`(`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-商品-标签' ROW_FORMAT=Compact;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-商品-库存' ROW_FORMAT=Compact;

-- ----------------------------
-- Table structure for shop_order
-- ----------------------------
DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE `shop_order`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员编号',
  `from` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐会员',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单编号',
  `amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '支付总金额',
  `amount_goods` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品总金额',
  `amount_reduct` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '随机减免金额',
  `amount_express` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '快递费用金额',
  `amount_discount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '策略优惠金额',
  `payment_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际支付平台',
  `payment_code` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '实际支付单号',
  `payment_status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '实际支付状态',
  `payment_amount` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '实际支付金额',
  `payment_remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付结果描述',
  `payment_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '支付到账时间',
  `truck_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址编号',
  `truck_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人姓名',
  `truck_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送收货人手机',
  `truck_province` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址省份',
  `truck_city` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址城市',
  `truck_area` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送地址区域',
  `truck_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送详细地址',
  `truck_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单确认时间',
  `truck_express_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送公司编号',
  `truck_express_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送公司名称',
  `truck_express_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配送发送时间',
  `cancel_status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '订单取消状态',
  `cancel_remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单取消描述',
  `cancel_datetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单取消时间',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '订单状态(0已取消,1预订单,2待支付,3待发货,4待签收,5已完成)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_mid`(`mid`) USING BTREE,
  INDEX `idx_shop_order_from`(`from`) USING BTREE,
  INDEX `idx_shop_order_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_orderno`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_cancel_status`(`cancel_status`) USING BTREE,
  INDEX `idx_shop_order_payment_status`(`payment_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-订单-内容' ROW_FORMAT=Compact;

-- ----------------------------
-- Table structure for shop_order_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_item`;
CREATE TABLE `shop_order_item`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员编号',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单订单',
  `goods_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品名称',
  `goods_cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品图片',
  `goods_sku` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场单价',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售单价',
  `total_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场总价',
  `total_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售总价',
  `stock_sales` bigint(20) UNSIGNED NULL DEFAULT 1 COMMENT '销售数量',
  `truck_count` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '快递数量',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_shop_order_item_status`(`status`) USING BTREE,
  INDEX `idx_shop_order_item_deleted`(`deleted`) USING BTREE,
  INDEX `idx_shop_order_item_order_no`(`order_no`) USING BTREE,
  INDEX `idx_shop_order_item_goods_sku`(`goods_sku`) USING BTREE,
  INDEX `idx_shop_order_item_goods_code`(`goods_code`) USING BTREE,
  INDEX `idx_shop_order_item_goods_spec`(`goods_spec`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-订单-商品' ROW_FORMAT=Compact;

-- ----------------------------
-- Table structure for shop_order_service
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_service`;
CREATE TABLE `shop_order_service`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `send_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标题',
  `mark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标签',
  `cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章封面',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '文章内容',
  `num_like` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章点赞数',
  `num_read` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章阅读数',
  `num_collect` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章收藏数',
  `num_comment` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章评论数',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商城-订单-售后' ROW_FORMAT=Compact;

SET FOREIGN_KEY_CHECKS=1;
