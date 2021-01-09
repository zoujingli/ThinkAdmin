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

 Date: 09/01/2021 14:55:33
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
-- Table structure for data_payment
-- ----------------------------
DROP TABLE IF EXISTS `data_payment`;
CREATE TABLE `data_payment`  (
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-支付-通道' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_payment
-- ----------------------------

-- ----------------------------
-- Table structure for data_payment_item
-- ----------------------------
DROP TABLE IF EXISTS `data_payment_item`;
CREATE TABLE `data_payment_item`  (
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
-- Records of data_payment_item
-- ----------------------------

-- ----------------------------
-- Table structure for data_user
-- ----------------------------
DROP TABLE IF EXISTS `data_user`;
CREATE TABLE `data_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '当前身份',
  `path` varchar(999) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '-' COMMENT '推荐关系',
  `from` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '推荐人UID',
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
  `amount_total` bigint(20) NULL DEFAULT 0 COMMENT '总收益统计',
  `amount_used` bigint(20) NULL DEFAULT 0 COMMENT '已提现统计',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '用户状态(1正常,0已拉黑)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_user_status`(`status`) USING BTREE,
  INDEX `idx_data_user_deleted`(`deleted`) USING BTREE,
  INDEX `idx_data_user_openid1`(`openid1`) USING BTREE,
  INDEX `idx_data_user_openid2`(`openid2`) USING BTREE,
  INDEX `idx_data_user_unionid`(`unionid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-记录' ROW_FORMAT = COMPACT;

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
  INDEX `idx_data_user_address_mid`(`uid`) USING BTREE,
  INDEX `idx_data_user_address_type`(`type`) USING BTREE,
  INDEX `idx_data_user_address_code`(`code`) USING BTREE,
  INDEX `idx_data_user_address_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-用户-地址' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_address
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-用户-短信' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of data_user_message
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
  `truck_tcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '运费模板',
  `stock_total` bigint(20) NULL DEFAULT 0 COMMENT '库存统计',
  `stock_sales` bigint(20) NULL DEFAULT 0 COMMENT '销售统计',
  `stock_virtual` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '虚拟销量',
  `price_selling` decimal(20, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品销售价格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品市场价格',
  `num_read` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章阅读数',
  `num_collect` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章收藏数',
  `num_comment` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章评论数',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品状态(1使用,0禁用)',
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
  `amount_total` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '支付总金额',
  `amount_goods` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '商品总金额',
  `amount_reduct` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '随机减免金额',
  `amount_express` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '快递费用金额',
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
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '订单状态(0已取消,1预订单,2待支付,3待发货,4待签收,5已完成)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
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
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '用户编号',
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '订单单号',
  `goods_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品名称',
  `goods_cover` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品图片',
  `goods_sku` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品SKU',
  `goods_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品编号',
  `goods_spec` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '商品规格',
  `price_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场单价',
  `price_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售单价',
  `total_market` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '市场总价',
  `total_selling` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '销售总价',
  `truck_count` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '快递计费基数',
  `truck_tcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递邮费模板',
  `stock_sales` bigint(20) UNSIGNED NULL DEFAULT 1 COMMENT '购买商品数量',
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
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '记录状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_news_item_status`(`status`) USING BTREE,
  INDEX `idx_data_news_item_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城-订单-售后' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_order_service
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
) ENGINE = InnoDB AUTO_INCREMENT = 4019 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城-快递-区域' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of shop_truck_region
-- ----------------------------
INSERT INTO `shop_truck_region` VALUES (1, 0, 'B', '北京', '北京市', 1, 'beijing', '', 1, '116.405285', '39.904989');
INSERT INTO `shop_truck_region` VALUES (2, 1, 'B', '北京', '北京市', 2, 'beijing', '100000', 1, '116.405285', '39.904989');
INSERT INTO `shop_truck_region` VALUES (3, 2, 'D', '东城', '东城区', 3, 'dongcheng', '100010', 1, '116.41005', '39.93157');
INSERT INTO `shop_truck_region` VALUES (4, 2, 'X', '西城', '西城区', 3, 'xicheng', '100032', 1, '116.36003', '39.9305');
INSERT INTO `shop_truck_region` VALUES (5, 2, 'C', '朝阳', '朝阳区', 3, 'chaoyang', '100020', 1, '116.48548', '39.9484');
INSERT INTO `shop_truck_region` VALUES (6, 2, 'F', '丰台', '丰台区', 3, 'fengtai', '100071', 1, '116.28625', '39.8585');
INSERT INTO `shop_truck_region` VALUES (7, 2, 'S', '石景山', '石景山区', 3, 'shijingshan', '100043', 1, '116.2229', '39.90564');
INSERT INTO `shop_truck_region` VALUES (8, 2, 'H', '海淀', '海淀区', 3, 'haidian', '100089', 1, '116.29812', '39.95931');
INSERT INTO `shop_truck_region` VALUES (9, 2, 'M', '门头沟', '门头沟区', 3, 'mentougou', '102300', 1, '116.10137', '39.94043');
INSERT INTO `shop_truck_region` VALUES (10, 2, 'F', '房山', '房山区', 3, 'fangshan', '102488', 1, '116.14257', '39.74786');
INSERT INTO `shop_truck_region` VALUES (11, 2, 'T', '通州', '通州区', 3, 'tongzhou', '101149', 1, '116.65716', '39.90966');
INSERT INTO `shop_truck_region` VALUES (12, 2, 'S', '顺义', '顺义区', 3, 'shunyi', '101300', 1, '116.65417', '40.1302');
INSERT INTO `shop_truck_region` VALUES (13, 2, 'C', '昌平', '昌平区', 3, 'changping', '102200', 1, '116.2312', '40.22072');
INSERT INTO `shop_truck_region` VALUES (14, 2, 'D', '大兴', '大兴区', 3, 'daxing', '102600', 1, '116.34149', '39.72668');
INSERT INTO `shop_truck_region` VALUES (15, 2, 'H', '怀柔', '怀柔区', 3, 'huairou', '101400', 1, '116.63168', '40.31602');
INSERT INTO `shop_truck_region` VALUES (16, 2, 'P', '平谷', '平谷区', 3, 'pinggu', '101200', 1, '117.12133', '40.14056');
INSERT INTO `shop_truck_region` VALUES (17, 2, 'M', '密云', '密云县', 3, 'miyun', '101500', 1, '116.84295', '40.37618');
INSERT INTO `shop_truck_region` VALUES (18, 2, 'Y', '延庆', '延庆县', 3, 'yanqing', '102100', 1, '115.97494', '40.45672');
INSERT INTO `shop_truck_region` VALUES (19, 0, 'T', '天津', '天津市', 1, 'tianjin', '', 1, '117.190182', '39.125596');
INSERT INTO `shop_truck_region` VALUES (20, 19, 'T', '天津', '天津市', 2, 'tianjin', '300000', 1, '117.190182', '39.125596');
INSERT INTO `shop_truck_region` VALUES (21, 20, 'H', '和平', '和平区', 3, 'heping', '300041', 1, '117.21456', '39.11718');
INSERT INTO `shop_truck_region` VALUES (22, 20, 'H', '河东', '河东区', 3, 'hedong', '300171', 1, '117.22562', '39.12318');
INSERT INTO `shop_truck_region` VALUES (23, 20, 'H', '河西', '河西区', 3, 'hexi', '300202', 1, '117.22327', '39.10959');
INSERT INTO `shop_truck_region` VALUES (24, 20, 'N', '南开', '南开区', 3, 'nankai', '300110', 1, '117.15074', '39.13821');
INSERT INTO `shop_truck_region` VALUES (25, 20, 'H', '河北', '河北区', 3, 'hebei', '300143', 1, '117.19697', '39.14816');
INSERT INTO `shop_truck_region` VALUES (26, 20, 'H', '红桥', '红桥区', 3, 'hongqiao', '300131', 1, '117.15145', '39.16715');
INSERT INTO `shop_truck_region` VALUES (27, 20, 'D', '东丽', '东丽区', 3, 'dongli', '300300', 1, '117.31436', '39.0863');
INSERT INTO `shop_truck_region` VALUES (28, 20, 'X', '西青', '西青区', 3, 'xiqing', '300380', 1, '117.00927', '39.14123');
INSERT INTO `shop_truck_region` VALUES (29, 20, 'J', '津南', '津南区', 3, 'jinnan', '300350', 1, '117.38537', '38.99139');
INSERT INTO `shop_truck_region` VALUES (30, 20, 'B', '北辰', '北辰区', 3, 'beichen', '300400', 1, '117.13217', '39.22131');
INSERT INTO `shop_truck_region` VALUES (31, 20, 'W', '武清', '武清区', 3, 'wuqing', '301700', 1, '117.04443', '39.38415');
INSERT INTO `shop_truck_region` VALUES (32, 20, 'B', '宝坻', '宝坻区', 3, 'baodi', '301800', 1, '117.3103', '39.71761');
INSERT INTO `shop_truck_region` VALUES (33, 20, 'B', '滨海新区', '滨海新区', 3, 'binhaixinqu', '300451', 1, '117.70162', '39.02668');
INSERT INTO `shop_truck_region` VALUES (34, 20, 'N', '宁河', '宁河县', 3, 'ninghe', '301500', 1, '117.8255', '39.33048');
INSERT INTO `shop_truck_region` VALUES (35, 20, 'J', '静海', '静海县', 3, 'jinghai', '301600', 1, '116.97436', '38.94582');
INSERT INTO `shop_truck_region` VALUES (36, 20, 'J', '蓟县', '蓟县', 3, 'jixian', '301900', 1, '117.40799', '40.04567');
INSERT INTO `shop_truck_region` VALUES (37, 0, 'H', '河北', '河北省', 1, 'hebei', '', 1, '114.502461', '38.045474');
INSERT INTO `shop_truck_region` VALUES (38, 37, 'S', '石家庄', '石家庄市', 2, 'shijiazhuang', '050011', 1, '114.502461', '38.045474');
INSERT INTO `shop_truck_region` VALUES (39, 38, 'C', '长安', '长安区', 3, 'changan', '050011', 1, '114.53906', '38.03665');
INSERT INTO `shop_truck_region` VALUES (40, 38, 'Q', '桥西', '桥西区', 3, 'qiaoxi', '050091', 1, '114.46977', '38.03221');
INSERT INTO `shop_truck_region` VALUES (41, 38, 'X', '新华', '新华区', 3, 'xinhua', '050051', 1, '114.46326', '38.05088');
INSERT INTO `shop_truck_region` VALUES (42, 38, 'J', '井陉矿区', '井陉矿区', 3, 'jingxingkuangqu', '050100', 1, '114.06518', '38.06705');
INSERT INTO `shop_truck_region` VALUES (43, 38, 'Y', '裕华', '裕华区', 3, 'yuhua', '050031', 1, '114.53115', '38.00604');
INSERT INTO `shop_truck_region` VALUES (44, 38, 'G', '藁城', '藁城区', 3, 'gaocheng', '052160', 1, '114.84671', '38.02162');
INSERT INTO `shop_truck_region` VALUES (45, 38, 'L', '鹿泉', '鹿泉区', 3, 'luquan', '050200', 1, '114.31347', '38.08782');
INSERT INTO `shop_truck_region` VALUES (46, 38, 'L', '栾城', '栾城区', 3, 'luancheng', '051430', 1, '114.64834', '37.90022');
INSERT INTO `shop_truck_region` VALUES (47, 38, 'J', '井陉', '井陉县', 3, 'jingxing', '050300', 1, '114.14257', '38.03688');
INSERT INTO `shop_truck_region` VALUES (48, 38, 'Z', '正定', '正定县', 3, 'zhengding', '050800', 1, '114.57296', '38.14445');
INSERT INTO `shop_truck_region` VALUES (49, 38, 'X', '行唐', '行唐县', 3, 'xingtang', '050600', 1, '114.55316', '38.43654');
INSERT INTO `shop_truck_region` VALUES (50, 38, 'L', '灵寿', '灵寿县', 3, 'lingshou', '050500', 1, '114.38259', '38.30845');
INSERT INTO `shop_truck_region` VALUES (51, 38, 'G', '高邑', '高邑县', 3, 'gaoyi', '051330', 1, '114.61142', '37.61556');
INSERT INTO `shop_truck_region` VALUES (52, 38, 'S', '深泽', '深泽县', 3, 'shenze', '052560', 1, '115.20358', '38.18353');
INSERT INTO `shop_truck_region` VALUES (53, 38, 'Z', '赞皇', '赞皇县', 3, 'zanhuang', '051230', 1, '114.38775', '37.66135');
INSERT INTO `shop_truck_region` VALUES (54, 38, 'W', '无极', '无极县', 3, 'wuji', '052460', 1, '114.97509', '38.17653');
INSERT INTO `shop_truck_region` VALUES (55, 38, 'P', '平山', '平山县', 3, 'pingshan', '050400', 1, '114.186', '38.25994');
INSERT INTO `shop_truck_region` VALUES (56, 38, 'Y', '元氏', '元氏县', 3, 'yuanshi', '051130', 1, '114.52539', '37.76668');
INSERT INTO `shop_truck_region` VALUES (57, 38, 'Z', '赵县', '赵县', 3, 'zhaoxian', '051530', 1, '114.77612', '37.75628');
INSERT INTO `shop_truck_region` VALUES (58, 38, 'X', '辛集', '辛集市', 3, 'xinji', '052360', 1, '115.20626', '37.94079');
INSERT INTO `shop_truck_region` VALUES (59, 38, 'J', '晋州', '晋州市', 3, 'jinzhou', '052260', 1, '115.04348', '38.03135');
INSERT INTO `shop_truck_region` VALUES (60, 38, 'X', '新乐', '新乐市', 3, 'xinle', '050700', 1, '114.68985', '38.34417');
INSERT INTO `shop_truck_region` VALUES (61, 37, 'T', '唐山', '唐山市', 2, 'tangshan', '063000', 1, '118.175393', '39.635113');
INSERT INTO `shop_truck_region` VALUES (62, 61, 'L', '路南', '路南区', 3, 'lunan', '063000', 1, '118.15431', '39.62505');
INSERT INTO `shop_truck_region` VALUES (63, 61, 'L', '路北', '路北区', 3, 'lubei', '063000', 1, '118.20079', '39.62436');
INSERT INTO `shop_truck_region` VALUES (64, 61, 'G', '古冶', '古冶区', 3, 'guye', '063100', 1, '118.45803', '39.71993');
INSERT INTO `shop_truck_region` VALUES (65, 61, 'K', '开平', '开平区', 3, 'kaiping', '063021', 1, '118.26171', '39.67128');
INSERT INTO `shop_truck_region` VALUES (66, 61, 'F', '丰南', '丰南区', 3, 'fengnan', '063300', 1, '118.11282', '39.56483');
INSERT INTO `shop_truck_region` VALUES (67, 61, 'F', '丰润', '丰润区', 3, 'fengrun', '064000', 1, '118.12976', '39.8244');
INSERT INTO `shop_truck_region` VALUES (68, 61, 'C', '曹妃甸', '曹妃甸区', 3, 'caofeidian', '063200', 1, '118.460379', '39.273070');
INSERT INTO `shop_truck_region` VALUES (69, 61, 'L', '滦县', '滦县', 3, 'luanxian', '063700', 1, '118.70346', '39.74056');
INSERT INTO `shop_truck_region` VALUES (70, 61, 'L', '滦南', '滦南县', 3, 'luannan', '063500', 1, '118.6741', '39.5039');
INSERT INTO `shop_truck_region` VALUES (71, 61, 'L', '乐亭', '乐亭县', 3, 'laoting', '063600', 1, '118.9125', '39.42561');
INSERT INTO `shop_truck_region` VALUES (72, 61, 'Q', '迁西', '迁西县', 3, 'qianxi', '064300', 1, '118.31616', '40.14587');
INSERT INTO `shop_truck_region` VALUES (73, 61, 'Y', '玉田', '玉田县', 3, 'yutian', '064100', 1, '117.7388', '39.90049');
INSERT INTO `shop_truck_region` VALUES (74, 61, 'Z', '遵化', '遵化市', 3, 'zunhua', '064200', 1, '117.96444', '40.18741');
INSERT INTO `shop_truck_region` VALUES (75, 61, 'Q', '迁安', '迁安市', 3, 'qianan', '064400', 1, '118.70068', '39.99833');
INSERT INTO `shop_truck_region` VALUES (76, 37, 'Q', '秦皇岛', '秦皇岛市', 2, 'qinhuangdao', '066000', 1, '119.586579', '39.942531');
INSERT INTO `shop_truck_region` VALUES (77, 76, 'H', '海港', '海港区', 3, 'haigang', '066000', 1, '119.61046', '39.9345');
INSERT INTO `shop_truck_region` VALUES (78, 76, 'S', '山海关', '山海关区', 3, 'shanhaiguan', '066200', 1, '119.77563', '39.97869');
INSERT INTO `shop_truck_region` VALUES (79, 76, 'B', '北戴河', '北戴河区', 3, 'beidaihe', '066100', 1, '119.48388', '39.83408');
INSERT INTO `shop_truck_region` VALUES (80, 76, 'Q', '青龙', '青龙满族自治县', 3, 'qinglong', '066500', 1, '118.95242', '40.40743');
INSERT INTO `shop_truck_region` VALUES (81, 76, 'C', '昌黎', '昌黎县', 3, 'changli', '066600', 1, '119.16595', '39.70884');
INSERT INTO `shop_truck_region` VALUES (82, 76, 'F', '抚宁', '抚宁县', 3, 'funing', '066300', 1, '119.24487', '39.87538');
INSERT INTO `shop_truck_region` VALUES (83, 76, 'L', '卢龙', '卢龙县', 3, 'lulong', '066400', 1, '118.89288', '39.89176');
INSERT INTO `shop_truck_region` VALUES (84, 37, 'H', '邯郸', '邯郸市', 2, 'handan', '056002', 1, '114.490686', '36.612273');
INSERT INTO `shop_truck_region` VALUES (85, 84, 'H', '邯山', '邯山区', 3, 'hanshan', '056001', 1, '114.48375', '36.60006');
INSERT INTO `shop_truck_region` VALUES (86, 84, 'C', '丛台', '丛台区', 3, 'congtai', '056002', 1, '114.49343', '36.61847');
INSERT INTO `shop_truck_region` VALUES (87, 84, 'F', '复兴', '复兴区', 3, 'fuxing', '056003', 1, '114.45928', '36.61134');
INSERT INTO `shop_truck_region` VALUES (88, 84, 'F', '峰峰矿区', '峰峰矿区', 3, 'fengfengkuangqu', '056200', 1, '114.21148', '36.41937');
INSERT INTO `shop_truck_region` VALUES (89, 84, 'H', '邯郸', '邯郸县', 3, 'handan', '056101', 1, '114.53103', '36.59385');
INSERT INTO `shop_truck_region` VALUES (90, 84, 'L', '临漳', '临漳县', 3, 'linzhang', '056600', 1, '114.6195', '36.33461');
INSERT INTO `shop_truck_region` VALUES (91, 84, 'C', '成安', '成安县', 3, 'chengan', '056700', 1, '114.66995', '36.44411');
INSERT INTO `shop_truck_region` VALUES (92, 84, 'D', '大名', '大名县', 3, 'daming', '056900', 1, '115.15362', '36.27994');
INSERT INTO `shop_truck_region` VALUES (93, 84, 'S', '涉县', '涉县', 3, 'shexian', '056400', 1, '113.69183', '36.58072');
INSERT INTO `shop_truck_region` VALUES (94, 84, 'C', '磁县', '磁县', 3, 'cixian', '056500', 1, '114.37387', '36.37392');
INSERT INTO `shop_truck_region` VALUES (95, 84, 'F', '肥乡', '肥乡县', 3, 'feixiang', '057550', 1, '114.79998', '36.54807');
INSERT INTO `shop_truck_region` VALUES (96, 84, 'Y', '永年', '永年县', 3, 'yongnian', '057150', 1, '114.48925', '36.78356');
INSERT INTO `shop_truck_region` VALUES (97, 84, 'Q', '邱县', '邱县', 3, 'qiuxian', '057450', 1, '115.17407', '36.82082');
INSERT INTO `shop_truck_region` VALUES (98, 84, 'J', '鸡泽', '鸡泽县', 3, 'jize', '057350', 1, '114.8742', '36.92374');
INSERT INTO `shop_truck_region` VALUES (99, 84, 'G', '广平', '广平县', 3, 'guangping', '057650', 1, '114.94653', '36.48046');
INSERT INTO `shop_truck_region` VALUES (100, 84, 'G', '馆陶', '馆陶县', 3, 'guantao', '057750', 1, '115.29913', '36.53719');
INSERT INTO `shop_truck_region` VALUES (101, 84, 'W', '魏县', '魏县', 3, 'weixian', '056800', 1, '114.93518', '36.36171');
INSERT INTO `shop_truck_region` VALUES (102, 84, 'Q', '曲周', '曲周县', 3, 'quzhou', '057250', 1, '114.95196', '36.77671');
INSERT INTO `shop_truck_region` VALUES (103, 84, 'W', '武安', '武安市', 3, 'wuan', '056300', 1, '114.20153', '36.69281');
INSERT INTO `shop_truck_region` VALUES (104, 37, 'X', '邢台', '邢台市', 2, 'xingtai', '054001', 1, '114.508851', '37.0682');
INSERT INTO `shop_truck_region` VALUES (105, 104, 'Q', '桥东', '桥东区', 3, 'qiaodong', '054001', 1, '114.50725', '37.06801');
INSERT INTO `shop_truck_region` VALUES (106, 104, 'Q', '桥西', '桥西区', 3, 'qiaoxi', '054000', 1, '114.46803', '37.05984');
INSERT INTO `shop_truck_region` VALUES (107, 104, 'X', '邢台', '邢台县', 3, 'xingtai', '054001', 1, '114.56575', '37.0456');
INSERT INTO `shop_truck_region` VALUES (108, 104, 'L', '临城', '临城县', 3, 'lincheng', '054300', 1, '114.50387', '37.43977');
INSERT INTO `shop_truck_region` VALUES (109, 104, 'N', '内丘', '内丘县', 3, 'neiqiu', '054200', 1, '114.51212', '37.28671');
INSERT INTO `shop_truck_region` VALUES (110, 104, 'B', '柏乡', '柏乡县', 3, 'baixiang', '055450', 1, '114.69332', '37.48242');
INSERT INTO `shop_truck_region` VALUES (111, 104, 'L', '隆尧', '隆尧县', 3, 'longyao', '055350', 1, '114.77615', '37.35351');
INSERT INTO `shop_truck_region` VALUES (112, 104, 'R', '任县', '任县', 3, 'renxian', '055150', 1, '114.6842', '37.12575');
INSERT INTO `shop_truck_region` VALUES (113, 104, 'N', '南和', '南和县', 3, 'nanhe', '054400', 1, '114.68371', '37.00488');
INSERT INTO `shop_truck_region` VALUES (114, 104, 'N', '宁晋', '宁晋县', 3, 'ningjin', '055550', 1, '114.92117', '37.61696');
INSERT INTO `shop_truck_region` VALUES (115, 104, 'J', '巨鹿', '巨鹿县', 3, 'julu', '055250', 1, '115.03524', '37.21801');
INSERT INTO `shop_truck_region` VALUES (116, 104, 'X', '新河', '新河县', 3, 'xinhe', '055650', 1, '115.24987', '37.52718');
INSERT INTO `shop_truck_region` VALUES (117, 104, 'G', '广宗', '广宗县', 3, 'guangzong', '054600', 1, '115.14254', '37.0746');
INSERT INTO `shop_truck_region` VALUES (118, 104, 'P', '平乡', '平乡县', 3, 'pingxiang', '054500', 1, '115.03002', '37.06317');
INSERT INTO `shop_truck_region` VALUES (119, 104, 'W', '威县', '威县', 3, 'weixian', '054700', 1, '115.2637', '36.9768');
INSERT INTO `shop_truck_region` VALUES (120, 104, 'Q', '清河', '清河县', 3, 'qinghe', '054800', 1, '115.66479', '37.07122');
INSERT INTO `shop_truck_region` VALUES (121, 104, 'L', '临西', '临西县', 3, 'linxi', '054900', 1, '115.50097', '36.87078');
INSERT INTO `shop_truck_region` VALUES (122, 104, 'N', '南宫', '南宫市', 3, 'nangong', '055750', 1, '115.39068', '37.35799');
INSERT INTO `shop_truck_region` VALUES (123, 104, 'S', '沙河', '沙河市', 3, 'shahe', '054100', 1, '114.4981', '36.8577');
INSERT INTO `shop_truck_region` VALUES (124, 37, 'B', '保定', '保定市', 2, 'baoding', '071052', 1, '115.482331', '38.867657');
INSERT INTO `shop_truck_region` VALUES (125, 124, 'X', '新市', '新市区', 3, 'xinshi', '071051', 1, '115.4587', '38.87751');
INSERT INTO `shop_truck_region` VALUES (126, 124, 'B', '北市', '北市区', 3, 'beishi', '071000', 1, '115.49715', '38.88322');
INSERT INTO `shop_truck_region` VALUES (127, 124, 'N', '南市', '南市区', 3, 'nanshi', '071001', 1, '115.52859', '38.85455');
INSERT INTO `shop_truck_region` VALUES (128, 124, 'M', '满城', '满城县', 3, 'mancheng', '072150', 1, '115.32296', '38.94972');
INSERT INTO `shop_truck_region` VALUES (129, 124, 'Q', '清苑', '清苑县', 3, 'qingyuan', '071100', 1, '115.49267', '38.76709');
INSERT INTO `shop_truck_region` VALUES (130, 124, 'L', '涞水', '涞水县', 3, 'laishui', '074100', 1, '115.71517', '39.39404');
INSERT INTO `shop_truck_region` VALUES (131, 124, 'F', '阜平', '阜平县', 3, 'fuping', '073200', 1, '114.19683', '38.84763');
INSERT INTO `shop_truck_region` VALUES (132, 124, 'X', '徐水', '徐水县', 3, 'xushui', '072550', 1, '115.65829', '39.02099');
INSERT INTO `shop_truck_region` VALUES (133, 124, 'D', '定兴', '定兴县', 3, 'dingxing', '072650', 1, '115.80786', '39.26312');
INSERT INTO `shop_truck_region` VALUES (134, 124, 'T', '唐县', '唐县', 3, 'tangxian', '072350', 1, '114.98516', '38.74513');
INSERT INTO `shop_truck_region` VALUES (135, 124, 'G', '高阳', '高阳县', 3, 'gaoyang', '071500', 1, '115.7788', '38.70003');
INSERT INTO `shop_truck_region` VALUES (136, 124, 'R', '容城', '容城县', 3, 'rongcheng', '071700', 1, '115.87158', '39.0535');
INSERT INTO `shop_truck_region` VALUES (137, 124, 'L', '涞源', '涞源县', 3, 'laiyuan', '074300', 1, '114.69128', '39.35388');
INSERT INTO `shop_truck_region` VALUES (138, 124, 'W', '望都', '望都县', 3, 'wangdu', '072450', 1, '115.1567', '38.70996');
INSERT INTO `shop_truck_region` VALUES (139, 124, 'A', '安新', '安新县', 3, 'anxin', '071600', 1, '115.93557', '38.93532');
INSERT INTO `shop_truck_region` VALUES (140, 124, 'Y', '易县', '易县', 3, 'yixian', '074200', 1, '115.4981', '39.34885');
INSERT INTO `shop_truck_region` VALUES (141, 124, 'Q', '曲阳', '曲阳县', 3, 'quyang', '073100', 1, '114.70123', '38.62154');
INSERT INTO `shop_truck_region` VALUES (142, 124, 'L', '蠡县', '蠡县', 3, 'lixian', '071400', 1, '115.57717', '38.48974');
INSERT INTO `shop_truck_region` VALUES (143, 124, 'S', '顺平', '顺平县', 3, 'shunping', '072250', 1, '115.1347', '38.83854');
INSERT INTO `shop_truck_region` VALUES (144, 124, 'B', '博野', '博野县', 3, 'boye', '071300', 1, '115.47033', '38.4564');
INSERT INTO `shop_truck_region` VALUES (145, 124, 'X', '雄县', '雄县', 3, 'xiongxian', '071800', 1, '116.10873', '38.99442');
INSERT INTO `shop_truck_region` VALUES (146, 124, 'Z', '涿州', '涿州市', 3, 'zhuozhou', '072750', 1, '115.98062', '39.48622');
INSERT INTO `shop_truck_region` VALUES (147, 124, 'D', '定州', '定州市', 3, 'dingzhou', '073000', 1, '114.9902', '38.51623');
INSERT INTO `shop_truck_region` VALUES (148, 124, 'A', '安国', '安国市', 3, 'anguo', '071200', 1, '115.32321', '38.41391');
INSERT INTO `shop_truck_region` VALUES (149, 124, 'G', '高碑店', '高碑店市', 3, 'gaobeidian', '074000', 1, '115.87368', '39.32655');
INSERT INTO `shop_truck_region` VALUES (150, 37, 'Z', '张家口', '张家口市', 2, 'zhangjiakou', '075000', 1, '114.884091', '40.811901');
INSERT INTO `shop_truck_region` VALUES (151, 150, 'Q', '桥东', '桥东区', 3, 'qiaodong', '075000', 1, '114.8943', '40.78844');
INSERT INTO `shop_truck_region` VALUES (152, 150, 'Q', '桥西', '桥西区', 3, 'qiaoxi', '075061', 1, '114.86962', '40.81945');
INSERT INTO `shop_truck_region` VALUES (153, 150, 'X', '宣化', '宣化区', 3, 'xuanhua', '075100', 1, '115.06543', '40.60957');
INSERT INTO `shop_truck_region` VALUES (154, 150, 'X', '下花园', '下花园区', 3, 'xiahuayuan', '075300', 1, '115.28744', '40.50236');
INSERT INTO `shop_truck_region` VALUES (155, 150, 'X', '宣化', '宣化县', 3, 'xuanhua', '075100', 1, '115.15497', '40.56618');
INSERT INTO `shop_truck_region` VALUES (156, 150, 'Z', '张北', '张北县', 3, 'zhangbei', '076450', 1, '114.71432', '41.15977');
INSERT INTO `shop_truck_region` VALUES (157, 150, 'K', '康保', '康保县', 3, 'kangbao', '076650', 1, '114.60031', '41.85225');
INSERT INTO `shop_truck_region` VALUES (158, 150, 'G', '沽源', '沽源县', 3, 'guyuan', '076550', 1, '115.68859', '41.66959');
INSERT INTO `shop_truck_region` VALUES (159, 150, 'S', '尚义', '尚义县', 3, 'shangyi', '076750', 1, '113.97134', '41.07782');
INSERT INTO `shop_truck_region` VALUES (160, 150, 'W', '蔚县', '蔚县', 3, 'yuxian', '075700', 1, '114.58892', '39.84067');
INSERT INTO `shop_truck_region` VALUES (161, 150, 'Y', '阳原', '阳原县', 3, 'yangyuan', '075800', 1, '114.15051', '40.10361');
INSERT INTO `shop_truck_region` VALUES (162, 150, 'H', '怀安', '怀安县', 3, 'huaian', '076150', 1, '114.38559', '40.67425');
INSERT INTO `shop_truck_region` VALUES (163, 150, 'W', '万全', '万全县', 3, 'wanquan', '076250', 1, '114.7405', '40.76694');
INSERT INTO `shop_truck_region` VALUES (164, 150, 'H', '怀来', '怀来县', 3, 'huailai', '075400', 1, '115.51773', '40.41536');
INSERT INTO `shop_truck_region` VALUES (165, 150, 'Z', '涿鹿', '涿鹿县', 3, 'zhuolu', '075600', 1, '115.22403', '40.37636');
INSERT INTO `shop_truck_region` VALUES (166, 150, 'C', '赤城', '赤城县', 3, 'chicheng', '075500', 1, '115.83187', '40.91438');
INSERT INTO `shop_truck_region` VALUES (167, 150, 'C', '崇礼', '崇礼县', 3, 'chongli', '076350', 1, '115.27993', '40.97519');
INSERT INTO `shop_truck_region` VALUES (168, 37, 'C', '承德', '承德市', 2, 'chengde', '067000', 1, '117.939152', '40.976204');
INSERT INTO `shop_truck_region` VALUES (169, 168, 'S', '双桥', '双桥区', 3, 'shuangqiao', '067000', 1, '117.9432', '40.97466');
INSERT INTO `shop_truck_region` VALUES (170, 168, 'S', '双滦', '双滦区', 3, 'shuangluan', '067001', 1, '117.74487', '40.95375');
INSERT INTO `shop_truck_region` VALUES (171, 168, 'Y', '鹰手营子矿区', '鹰手营子矿区', 3, 'yingshouyingzikuangqu', '067200', 1, '117.65985', '40.54744');
INSERT INTO `shop_truck_region` VALUES (172, 168, 'C', '承德', '承德县', 3, 'chengde', '067400', 1, '118.17639', '40.76985');
INSERT INTO `shop_truck_region` VALUES (173, 168, 'X', '兴隆', '兴隆县', 3, 'xinglong', '067300', 1, '117.50073', '40.41709');
INSERT INTO `shop_truck_region` VALUES (174, 168, 'P', '平泉', '平泉县', 3, 'pingquan', '067500', 1, '118.70196', '41.01839');
INSERT INTO `shop_truck_region` VALUES (175, 168, 'L', '滦平', '滦平县', 3, 'luanping', '068250', 1, '117.33276', '40.94148');
INSERT INTO `shop_truck_region` VALUES (176, 168, 'L', '隆化', '隆化县', 3, 'longhua', '068150', 1, '117.7297', '41.31412');
INSERT INTO `shop_truck_region` VALUES (177, 168, 'F', '丰宁', '丰宁满族自治县', 3, 'fengning', '068350', 1, '116.6492', '41.20481');
INSERT INTO `shop_truck_region` VALUES (178, 168, 'K', '宽城', '宽城满族自治县', 3, 'kuancheng', '067600', 1, '118.49176', '40.60829');
INSERT INTO `shop_truck_region` VALUES (179, 168, 'W', '围场', '围场满族蒙古族自治县', 3, 'weichang', '068450', 1, '117.7601', '41.94368');
INSERT INTO `shop_truck_region` VALUES (180, 37, 'C', '沧州', '沧州市', 2, 'cangzhou', '061001', 1, '116.857461', '38.310582');
INSERT INTO `shop_truck_region` VALUES (181, 180, 'X', '新华', '新华区', 3, 'xinhua', '061000', 1, '116.86643', '38.31438');
INSERT INTO `shop_truck_region` VALUES (182, 180, 'Y', '运河', '运河区', 3, 'yunhe', '061001', 1, '116.85706', '38.31352');
INSERT INTO `shop_truck_region` VALUES (183, 180, 'C', '沧县', '沧县', 3, 'cangxian', '061000', 1, '116.87817', '38.29361');
INSERT INTO `shop_truck_region` VALUES (184, 180, 'Q', '青县', '青县', 3, 'qingxian', '062650', 1, '116.80316', '38.58345');
INSERT INTO `shop_truck_region` VALUES (185, 180, 'D', '东光', '东光县', 3, 'dongguang', '061600', 1, '116.53668', '37.8857');
INSERT INTO `shop_truck_region` VALUES (186, 180, 'H', '海兴', '海兴县', 3, 'haixing', '061200', 1, '117.49758', '38.13958');
INSERT INTO `shop_truck_region` VALUES (187, 180, 'Y', '盐山', '盐山县', 3, 'yanshan', '061300', 1, '117.23092', '38.05647');
INSERT INTO `shop_truck_region` VALUES (188, 180, 'S', '肃宁', '肃宁县', 3, 'suning', '062350', 1, '115.82971', '38.42272');
INSERT INTO `shop_truck_region` VALUES (189, 180, 'N', '南皮', '南皮县', 3, 'nanpi', '061500', 1, '116.70224', '38.04109');
INSERT INTO `shop_truck_region` VALUES (190, 180, 'W', '吴桥', '吴桥县', 3, 'wuqiao', '061800', 1, '116.3847', '37.62546');
INSERT INTO `shop_truck_region` VALUES (191, 180, 'X', '献县', '献县', 3, 'xianxian', '062250', 1, '116.12695', '38.19228');
INSERT INTO `shop_truck_region` VALUES (192, 180, 'M', '孟村', '孟村回族自治县', 3, 'mengcun', '061400', 1, '117.10412', '38.05338');
INSERT INTO `shop_truck_region` VALUES (193, 180, 'B', '泊头', '泊头市', 3, 'botou', '062150', 1, '116.57824', '38.08359');
INSERT INTO `shop_truck_region` VALUES (194, 180, 'R', '任丘', '任丘市', 3, 'renqiu', '062550', 1, '116.1033', '38.71124');
INSERT INTO `shop_truck_region` VALUES (195, 180, 'H', '黄骅', '黄骅市', 3, 'huanghua', '061100', 1, '117.33883', '38.3706');
INSERT INTO `shop_truck_region` VALUES (196, 180, 'H', '河间', '河间市', 3, 'hejian', '062450', 1, '116.0993', '38.44549');
INSERT INTO `shop_truck_region` VALUES (197, 37, 'L', '廊坊', '廊坊市', 2, 'langfang', '065000', 1, '116.713873', '39.529244');
INSERT INTO `shop_truck_region` VALUES (198, 197, 'A', '安次', '安次区', 3, 'anci', '065000', 1, '116.70308', '39.52057');
INSERT INTO `shop_truck_region` VALUES (199, 197, 'G', '广阳', '广阳区', 3, 'guangyang', '065000', 1, '116.71069', '39.52278');
INSERT INTO `shop_truck_region` VALUES (200, 197, 'G', '固安', '固安县', 3, 'guan', '065500', 1, '116.29916', '39.43833');
INSERT INTO `shop_truck_region` VALUES (201, 197, 'Y', '永清', '永清县', 3, 'yongqing', '065600', 1, '116.50091', '39.32069');
INSERT INTO `shop_truck_region` VALUES (202, 197, 'X', '香河', '香河县', 3, 'xianghe', '065400', 1, '117.00634', '39.76133');
INSERT INTO `shop_truck_region` VALUES (203, 197, 'D', '大城', '大城县', 3, 'daicheng', '065900', 1, '116.65353', '38.70534');
INSERT INTO `shop_truck_region` VALUES (204, 197, 'W', '文安', '文安县', 3, 'wenan', '065800', 1, '116.45846', '38.87325');
INSERT INTO `shop_truck_region` VALUES (205, 197, 'D', '大厂', '大厂回族自治县', 3, 'dachang', '065300', 1, '116.98916', '39.88649');
INSERT INTO `shop_truck_region` VALUES (206, 197, 'B', '霸州', '霸州市', 3, 'bazhou', '065700', 1, '116.39154', '39.12569');
INSERT INTO `shop_truck_region` VALUES (207, 197, 'S', '三河', '三河市', 3, 'sanhe', '065200', 1, '117.07229', '39.98358');
INSERT INTO `shop_truck_region` VALUES (208, 37, 'H', '衡水', '衡水市', 2, 'hengshui', '053000', 1, '115.665993', '37.735097');
INSERT INTO `shop_truck_region` VALUES (209, 208, 'T', '桃城', '桃城区', 3, 'taocheng', '053000', 1, '115.67529', '37.73499');
INSERT INTO `shop_truck_region` VALUES (210, 208, 'Z', '枣强', '枣强县', 3, 'zaoqiang', '053100', 1, '115.72576', '37.51027');
INSERT INTO `shop_truck_region` VALUES (211, 208, 'W', '武邑', '武邑县', 3, 'wuyi', '053400', 1, '115.88748', '37.80181');
INSERT INTO `shop_truck_region` VALUES (212, 208, 'W', '武强', '武强县', 3, 'wuqiang', '053300', 1, '115.98226', '38.04138');
INSERT INTO `shop_truck_region` VALUES (213, 208, 'R', '饶阳', '饶阳县', 3, 'raoyang', '053900', 1, '115.72558', '38.23529');
INSERT INTO `shop_truck_region` VALUES (214, 208, 'A', '安平', '安平县', 3, 'anping', '053600', 1, '115.51876', '38.23388');
INSERT INTO `shop_truck_region` VALUES (215, 208, 'G', '故城', '故城县', 3, 'gucheng', '053800', 1, '115.97076', '37.34773');
INSERT INTO `shop_truck_region` VALUES (216, 208, 'J', '景县', '景县', 3, 'jingxian', '053500', 1, '116.26904', '37.6926');
INSERT INTO `shop_truck_region` VALUES (217, 208, 'F', '阜城', '阜城县', 3, 'fucheng', '053700', 1, '116.14431', '37.86881');
INSERT INTO `shop_truck_region` VALUES (218, 208, 'J', '冀州', '冀州市', 3, 'jizhou', '053200', 1, '115.57934', '37.55082');
INSERT INTO `shop_truck_region` VALUES (219, 208, 'S', '深州', '深州市', 3, 'shenzhou', '053800', 1, '115.55993', '38.00109');
INSERT INTO `shop_truck_region` VALUES (220, 0, 'S', '山西', '山西省', 1, 'shanxi', '', 1, '112.549248', '37.857014');
INSERT INTO `shop_truck_region` VALUES (221, 220, 'T', '太原', '太原市', 2, 'taiyuan', '030082', 1, '112.549248', '37.857014');
INSERT INTO `shop_truck_region` VALUES (222, 221, 'X', '小店', '小店区', 3, 'xiaodian', '030032', 1, '112.56878', '37.73565');
INSERT INTO `shop_truck_region` VALUES (223, 221, 'Y', '迎泽', '迎泽区', 3, 'yingze', '030002', 1, '112.56338', '37.86326');
INSERT INTO `shop_truck_region` VALUES (224, 221, 'X', '杏花岭', '杏花岭区', 3, 'xinghualing', '030009', 1, '112.56237', '37.88429');
INSERT INTO `shop_truck_region` VALUES (225, 221, 'J', '尖草坪', '尖草坪区', 3, 'jiancaoping', '030023', 1, '112.48709', '37.94193');
INSERT INTO `shop_truck_region` VALUES (226, 221, 'W', '万柏林', '万柏林区', 3, 'wanbailin', '030024', 1, '112.51553', '37.85923');
INSERT INTO `shop_truck_region` VALUES (227, 221, 'J', '晋源', '晋源区', 3, 'jinyuan', '030025', 1, '112.47985', '37.72479');
INSERT INTO `shop_truck_region` VALUES (228, 221, 'Q', '清徐', '清徐县', 3, 'qingxu', '030400', 1, '112.35888', '37.60758');
INSERT INTO `shop_truck_region` VALUES (229, 221, 'Y', '阳曲', '阳曲县', 3, 'yangqu', '030100', 1, '112.67861', '38.05989');
INSERT INTO `shop_truck_region` VALUES (230, 221, 'L', '娄烦', '娄烦县', 3, 'loufan', '030300', 1, '111.79473', '38.06689');
INSERT INTO `shop_truck_region` VALUES (231, 221, 'G', '古交', '古交市', 3, 'gujiao', '030200', 1, '112.16918', '37.90983');
INSERT INTO `shop_truck_region` VALUES (232, 220, 'D', '大同', '大同市', 2, 'datong', '037008', 1, '113.295259', '40.09031');
INSERT INTO `shop_truck_region` VALUES (233, 232, 'C', '城区', '城区', 3, 'chengqu', '037008', 1, '113.298', '40.07566');
INSERT INTO `shop_truck_region` VALUES (234, 232, 'K', '矿区', '矿区', 3, 'kuangqu', '037003', 1, '113.1772', '40.03685');
INSERT INTO `shop_truck_region` VALUES (235, 232, 'N', '南郊', '南郊区', 3, 'nanjiao', '037001', 1, '113.14947', '40.00539');
INSERT INTO `shop_truck_region` VALUES (236, 232, 'X', '新荣', '新荣区', 3, 'xinrong', '037002', 1, '113.13504', '40.25618');
INSERT INTO `shop_truck_region` VALUES (237, 232, 'Y', '阳高', '阳高县', 3, 'yanggao', '038100', 1, '113.75012', '40.36256');
INSERT INTO `shop_truck_region` VALUES (238, 232, 'T', '天镇', '天镇县', 3, 'tianzhen', '038200', 1, '114.0931', '40.42299');
INSERT INTO `shop_truck_region` VALUES (239, 232, 'G', '广灵', '广灵县', 3, 'guangling', '037500', 1, '114.28204', '39.76082');
INSERT INTO `shop_truck_region` VALUES (240, 232, 'L', '灵丘', '灵丘县', 3, 'lingqiu', '034400', 1, '114.23672', '39.44043');
INSERT INTO `shop_truck_region` VALUES (241, 232, 'H', '浑源', '浑源县', 3, 'hunyuan', '037400', 1, '113.69552', '39.69962');
INSERT INTO `shop_truck_region` VALUES (242, 232, 'Z', '左云', '左云县', 3, 'zuoyun', '037100', 1, '112.70266', '40.01336');
INSERT INTO `shop_truck_region` VALUES (243, 232, 'D', '大同', '大同县', 3, 'datong', '037300', 1, '113.61212', '40.04012');
INSERT INTO `shop_truck_region` VALUES (244, 220, 'Y', '阳泉', '阳泉市', 2, 'yangquan', '045000', 1, '113.583285', '37.861188');
INSERT INTO `shop_truck_region` VALUES (245, 244, 'C', '城区', '城区', 3, 'chengqu', '045000', 1, '113.60069', '37.8474');
INSERT INTO `shop_truck_region` VALUES (246, 244, 'K', '矿区', '矿区', 3, 'kuangqu', '045000', 1, '113.55677', '37.86895');
INSERT INTO `shop_truck_region` VALUES (247, 244, 'J', '郊区', '郊区', 3, 'jiaoqu', '045011', 1, '113.58539', '37.94139');
INSERT INTO `shop_truck_region` VALUES (248, 244, 'P', '平定', '平定县', 3, 'pingding', '045200', 1, '113.65789', '37.78601');
INSERT INTO `shop_truck_region` VALUES (249, 244, 'Y', '盂县', '盂县', 3, 'yuxian', '045100', 1, '113.41235', '38.08579');
INSERT INTO `shop_truck_region` VALUES (250, 220, 'C', '长治', '长治市', 2, 'changzhi', '046000', 1, '113.113556', '36.191112');
INSERT INTO `shop_truck_region` VALUES (251, 250, 'C', '城区', '城区', 3, 'chengqu', '046011', 1, '113.12308', '36.20351');
INSERT INTO `shop_truck_region` VALUES (252, 250, 'J', '郊区', '郊区', 3, 'jiaoqu', '046011', 1, '113.12653', '36.19918');
INSERT INTO `shop_truck_region` VALUES (253, 250, 'C', '长治', '长治县', 3, 'changzhi', '047100', 1, '113.04791', '36.04722');
INSERT INTO `shop_truck_region` VALUES (254, 250, 'X', '襄垣', '襄垣县', 3, 'xiangyuan', '046200', 1, '113.05157', '36.53527');
INSERT INTO `shop_truck_region` VALUES (255, 250, 'T', '屯留', '屯留县', 3, 'tunliu', '046100', 1, '112.89196', '36.31579');
INSERT INTO `shop_truck_region` VALUES (256, 250, 'P', '平顺', '平顺县', 3, 'pingshun', '047400', 1, '113.43603', '36.20005');
INSERT INTO `shop_truck_region` VALUES (257, 250, 'L', '黎城', '黎城县', 3, 'licheng', '047600', 1, '113.38766', '36.50301');
INSERT INTO `shop_truck_region` VALUES (258, 250, 'H', '壶关', '壶关县', 3, 'huguan', '047300', 1, '113.207', '36.11301');
INSERT INTO `shop_truck_region` VALUES (259, 250, 'C', '长子', '长子县', 3, 'zhangzi', '046600', 1, '112.87731', '36.12125');
INSERT INTO `shop_truck_region` VALUES (260, 250, 'W', '武乡', '武乡县', 3, 'wuxiang', '046300', 1, '112.86343', '36.83687');
INSERT INTO `shop_truck_region` VALUES (261, 250, 'Q', '沁县', '沁县', 3, 'qinxian', '046400', 1, '112.69863', '36.75628');
INSERT INTO `shop_truck_region` VALUES (262, 250, 'Q', '沁源', '沁源县', 3, 'qinyuan', '046500', 1, '112.33758', '36.50008');
INSERT INTO `shop_truck_region` VALUES (263, 250, 'L', '潞城', '潞城市', 3, 'lucheng', '047500', 1, '113.22888', '36.33414');
INSERT INTO `shop_truck_region` VALUES (264, 220, 'J', '晋城', '晋城市', 2, 'jincheng', '048000', 1, '112.851274', '35.497553');
INSERT INTO `shop_truck_region` VALUES (265, 264, 'C', '城区', '城区', 3, 'chengqu', '048000', 1, '112.85319', '35.50175');
INSERT INTO `shop_truck_region` VALUES (266, 264, 'Q', '沁水', '沁水县', 3, 'qinshui', '048200', 1, '112.1871', '35.69102');
INSERT INTO `shop_truck_region` VALUES (267, 264, 'Y', '阳城', '阳城县', 3, 'yangcheng', '048100', 1, '112.41485', '35.48614');
INSERT INTO `shop_truck_region` VALUES (268, 264, 'L', '陵川', '陵川县', 3, 'lingchuan', '048300', 1, '113.2806', '35.77532');
INSERT INTO `shop_truck_region` VALUES (269, 264, 'Z', '泽州', '泽州县', 3, 'zezhou', '048012', 1, '112.83947', '35.50789');
INSERT INTO `shop_truck_region` VALUES (270, 264, 'G', '高平', '高平市', 3, 'gaoping', '048400', 1, '112.92288', '35.79705');
INSERT INTO `shop_truck_region` VALUES (271, 220, 'S', '朔州', '朔州市', 2, 'shuozhou', '038500', 1, '112.433387', '39.331261');
INSERT INTO `shop_truck_region` VALUES (272, 271, 'S', '朔城', '朔城区', 3, 'shuocheng', '036000', 1, '112.43189', '39.31982');
INSERT INTO `shop_truck_region` VALUES (273, 271, 'P', '平鲁', '平鲁区', 3, 'pinglu', '038600', 1, '112.28833', '39.51155');
INSERT INTO `shop_truck_region` VALUES (274, 271, 'S', '山阴', '山阴县', 3, 'shanyin', '036900', 1, '112.81662', '39.52697');
INSERT INTO `shop_truck_region` VALUES (275, 271, 'Y', '应县', '应县', 3, 'yingxian', '037600', 1, '113.19052', '39.55279');
INSERT INTO `shop_truck_region` VALUES (276, 271, 'Y', '右玉', '右玉县', 3, 'youyu', '037200', 1, '112.46902', '39.99011');
INSERT INTO `shop_truck_region` VALUES (277, 271, 'H', '怀仁', '怀仁县', 3, 'huairen', '038300', 1, '113.10009', '39.82806');
INSERT INTO `shop_truck_region` VALUES (278, 220, 'J', '晋中', '晋中市', 2, 'jinzhong', '030600', 1, '112.736465', '37.696495');
INSERT INTO `shop_truck_region` VALUES (279, 278, 'Y', '榆次', '榆次区', 3, 'yuci', '030600', 1, '112.70788', '37.6978');
INSERT INTO `shop_truck_region` VALUES (280, 278, 'Y', '榆社', '榆社县', 3, 'yushe', '031800', 1, '112.97558', '37.0721');
INSERT INTO `shop_truck_region` VALUES (281, 278, 'Z', '左权', '左权县', 3, 'zuoquan', '032600', 1, '113.37918', '37.08235');
INSERT INTO `shop_truck_region` VALUES (282, 278, 'H', '和顺', '和顺县', 3, 'heshun', '032700', 1, '113.56988', '37.32963');
INSERT INTO `shop_truck_region` VALUES (283, 278, 'X', '昔阳', '昔阳县', 3, 'xiyang', '045300', 1, '113.70517', '37.61863');
INSERT INTO `shop_truck_region` VALUES (284, 278, 'S', '寿阳', '寿阳县', 3, 'shouyang', '045400', 1, '113.17495', '37.88899');
INSERT INTO `shop_truck_region` VALUES (285, 278, 'T', '太谷', '太谷县', 3, 'taigu', '030800', 1, '112.55246', '37.42161');
INSERT INTO `shop_truck_region` VALUES (286, 278, 'Q', '祁县', '祁县', 3, 'qixian', '030900', 1, '112.33358', '37.3579');
INSERT INTO `shop_truck_region` VALUES (287, 278, 'P', '平遥', '平遥县', 3, 'pingyao', '031100', 1, '112.17553', '37.1892');
INSERT INTO `shop_truck_region` VALUES (288, 278, 'L', '灵石', '灵石县', 3, 'lingshi', '031300', 1, '111.7774', '36.84814');
INSERT INTO `shop_truck_region` VALUES (289, 278, 'J', '介休', '介休市', 3, 'jiexiu', '032000', 1, '111.91824', '37.02771');
INSERT INTO `shop_truck_region` VALUES (290, 220, 'Y', '运城', '运城市', 2, 'yuncheng', '044000', 1, '111.003957', '35.022778');
INSERT INTO `shop_truck_region` VALUES (291, 290, 'Y', '盐湖', '盐湖区', 3, 'yanhu', '044000', 1, '110.99827', '35.0151');
INSERT INTO `shop_truck_region` VALUES (292, 290, 'L', '临猗', '临猗县', 3, 'linyi', '044100', 1, '110.77432', '35.14455');
INSERT INTO `shop_truck_region` VALUES (293, 290, 'W', '万荣', '万荣县', 3, 'wanrong', '044200', 1, '110.83657', '35.41556');
INSERT INTO `shop_truck_region` VALUES (294, 290, 'W', '闻喜', '闻喜县', 3, 'wenxi', '043800', 1, '111.22265', '35.35553');
INSERT INTO `shop_truck_region` VALUES (295, 290, 'J', '稷山', '稷山县', 3, 'jishan', '043200', 1, '110.97924', '35.59993');
INSERT INTO `shop_truck_region` VALUES (296, 290, 'X', '新绛', '新绛县', 3, 'xinjiang', '043100', 1, '111.22509', '35.61566');
INSERT INTO `shop_truck_region` VALUES (297, 290, 'J', '绛县', '绛县', 3, 'jiangxian', '043600', 1, '111.56668', '35.49096');
INSERT INTO `shop_truck_region` VALUES (298, 290, 'Y', '垣曲', '垣曲县', 3, 'yuanqu', '043700', 1, '111.67166', '35.29923');
INSERT INTO `shop_truck_region` VALUES (299, 290, 'X', '夏县', '夏县', 3, 'xiaxian', '044400', 1, '111.21966', '35.14121');
INSERT INTO `shop_truck_region` VALUES (300, 290, 'P', '平陆', '平陆县', 3, 'pinglu', '044300', 1, '111.21704', '34.83772');
INSERT INTO `shop_truck_region` VALUES (301, 290, 'R', '芮城', '芮城县', 3, 'ruicheng', '044600', 1, '110.69455', '34.69384');
INSERT INTO `shop_truck_region` VALUES (302, 290, 'Y', '永济', '永济市', 3, 'yongji', '044500', 1, '110.44537', '34.86556');
INSERT INTO `shop_truck_region` VALUES (303, 290, 'H', '河津', '河津市', 3, 'hejin', '043300', 1, '110.7116', '35.59478');
INSERT INTO `shop_truck_region` VALUES (304, 220, 'X', '忻州', '忻州市', 2, 'xinzhou', '034000', 1, '112.733538', '38.41769');
INSERT INTO `shop_truck_region` VALUES (305, 304, 'X', '忻府', '忻府区', 3, 'xinfu', '034000', 1, '112.74603', '38.40414');
INSERT INTO `shop_truck_region` VALUES (306, 304, 'D', '定襄', '定襄县', 3, 'dingxiang', '035400', 1, '112.95733', '38.47387');
INSERT INTO `shop_truck_region` VALUES (307, 304, 'W', '五台', '五台县', 3, 'wutai', '035500', 1, '113.25256', '38.72774');
INSERT INTO `shop_truck_region` VALUES (308, 304, 'D', '代县', '代县', 3, 'daixian', '034200', 1, '112.95913', '39.06717');
INSERT INTO `shop_truck_region` VALUES (309, 304, 'F', '繁峙', '繁峙县', 3, 'fanshi', '034300', 1, '113.26303', '39.18886');
INSERT INTO `shop_truck_region` VALUES (310, 304, 'N', '宁武', '宁武县', 3, 'ningwu', '036700', 1, '112.30423', '39.00211');
INSERT INTO `shop_truck_region` VALUES (311, 304, 'J', '静乐', '静乐县', 3, 'jingle', '035100', 1, '111.94158', '38.3602');
INSERT INTO `shop_truck_region` VALUES (312, 304, 'S', '神池', '神池县', 3, 'shenchi', '036100', 1, '112.20541', '39.09');
INSERT INTO `shop_truck_region` VALUES (313, 304, 'W', '五寨', '五寨县', 3, 'wuzhai', '036200', 1, '111.8489', '38.90757');
INSERT INTO `shop_truck_region` VALUES (314, 304, 'K', '岢岚', '岢岚县', 3, 'kelan', '036300', 1, '111.57388', '38.70452');
INSERT INTO `shop_truck_region` VALUES (315, 304, 'H', '河曲', '河曲县', 3, 'hequ', '036500', 1, '111.13821', '39.38439');
INSERT INTO `shop_truck_region` VALUES (316, 304, 'B', '保德', '保德县', 3, 'baode', '036600', 1, '111.08656', '39.02248');
INSERT INTO `shop_truck_region` VALUES (317, 304, 'P', '偏关', '偏关县', 3, 'pianguan', '036400', 1, '111.50863', '39.43609');
INSERT INTO `shop_truck_region` VALUES (318, 304, 'Y', '原平', '原平市', 3, 'yuanping', '034100', 1, '112.70584', '38.73181');
INSERT INTO `shop_truck_region` VALUES (319, 220, 'L', '临汾', '临汾市', 2, 'linfen', '041000', 1, '111.517973', '36.08415');
INSERT INTO `shop_truck_region` VALUES (320, 319, 'Y', '尧都', '尧都区', 3, 'yaodu', '041000', 1, '111.5787', '36.08298');
INSERT INTO `shop_truck_region` VALUES (321, 319, 'Q', '曲沃', '曲沃县', 3, 'quwo', '043400', 1, '111.47525', '35.64119');
INSERT INTO `shop_truck_region` VALUES (322, 319, 'Y', '翼城', '翼城县', 3, 'yicheng', '043500', 1, '111.7181', '35.73881');
INSERT INTO `shop_truck_region` VALUES (323, 319, 'X', '襄汾', '襄汾县', 3, 'xiangfen', '041500', 1, '111.44204', '35.87711');
INSERT INTO `shop_truck_region` VALUES (324, 319, 'H', '洪洞', '洪洞县', 3, 'hongtong', '041600', 1, '111.67501', '36.25425');
INSERT INTO `shop_truck_region` VALUES (325, 319, 'G', '古县', '古县', 3, 'guxian', '042400', 1, '111.92041', '36.26688');
INSERT INTO `shop_truck_region` VALUES (326, 319, 'A', '安泽', '安泽县', 3, 'anze', '042500', 1, '112.24981', '36.14803');
INSERT INTO `shop_truck_region` VALUES (327, 319, 'F', '浮山', '浮山县', 3, 'fushan', '042600', 1, '111.84744', '35.96854');
INSERT INTO `shop_truck_region` VALUES (328, 319, 'J', '吉县', '吉县', 3, 'jixian', '042200', 1, '110.68148', '36.09873');
INSERT INTO `shop_truck_region` VALUES (329, 319, 'X', '乡宁', '乡宁县', 3, 'xiangning', '042100', 1, '110.84652', '35.97072');
INSERT INTO `shop_truck_region` VALUES (330, 319, 'D', '大宁', '大宁县', 3, 'daning', '042300', 1, '110.75216', '36.46624');
INSERT INTO `shop_truck_region` VALUES (331, 319, 'X', '隰县', '隰县', 3, 'xixian', '041300', 1, '110.93881', '36.69258');
INSERT INTO `shop_truck_region` VALUES (332, 319, 'Y', '永和', '永和县', 3, 'yonghe', '041400', 1, '110.63168', '36.7584');
INSERT INTO `shop_truck_region` VALUES (333, 319, 'P', '蒲县', '蒲县', 3, 'puxian', '041200', 1, '111.09674', '36.41243');
INSERT INTO `shop_truck_region` VALUES (334, 319, 'F', '汾西', '汾西县', 3, 'fenxi', '031500', 1, '111.56811', '36.65063');
INSERT INTO `shop_truck_region` VALUES (335, 319, 'H', '侯马', '侯马市', 3, 'houma', '043000', 1, '111.37207', '35.61903');
INSERT INTO `shop_truck_region` VALUES (336, 319, 'H', '霍州', '霍州市', 3, 'huozhou', '031400', 1, '111.755', '36.5638');
INSERT INTO `shop_truck_region` VALUES (337, 220, 'L', '吕梁', '吕梁市', 2, 'lvliang', '033000', 1, '111.134335', '37.524366');
INSERT INTO `shop_truck_region` VALUES (338, 337, 'L', '离石', '离石区', 3, 'lishi', '033000', 1, '111.15059', '37.5177');
INSERT INTO `shop_truck_region` VALUES (339, 337, 'W', '文水', '文水县', 3, 'wenshui', '032100', 1, '112.02829', '37.43841');
INSERT INTO `shop_truck_region` VALUES (340, 337, 'J', '交城', '交城县', 3, 'jiaocheng', '030500', 1, '112.1585', '37.5512');
INSERT INTO `shop_truck_region` VALUES (341, 337, 'X', '兴县', '兴县', 3, 'xingxian', '033600', 1, '111.12692', '38.46321');
INSERT INTO `shop_truck_region` VALUES (342, 337, 'L', '临县', '临县', 3, 'linxian', '033200', 1, '110.99282', '37.95271');
INSERT INTO `shop_truck_region` VALUES (343, 337, 'L', '柳林', '柳林县', 3, 'liulin', '033300', 1, '110.88922', '37.42932');
INSERT INTO `shop_truck_region` VALUES (344, 337, 'S', '石楼', '石楼县', 3, 'shilou', '032500', 1, '110.8352', '36.99731');
INSERT INTO `shop_truck_region` VALUES (345, 337, 'L', '岚县', '岚县', 3, 'lanxian', '033500', 1, '111.67627', '38.27874');
INSERT INTO `shop_truck_region` VALUES (346, 337, 'F', '方山', '方山县', 3, 'fangshan', '033100', 1, '111.24011', '37.88979');
INSERT INTO `shop_truck_region` VALUES (347, 337, 'Z', '中阳', '中阳县', 3, 'zhongyang', '033400', 1, '111.1795', '37.35715');
INSERT INTO `shop_truck_region` VALUES (348, 337, 'J', '交口', '交口县', 3, 'jiaokou', '032400', 1, '111.18103', '36.98213');
INSERT INTO `shop_truck_region` VALUES (349, 337, 'X', '孝义', '孝义市', 3, 'xiaoyi', '032300', 1, '111.77362', '37.14414');
INSERT INTO `shop_truck_region` VALUES (350, 337, 'F', '汾阳', '汾阳市', 3, 'fenyang', '032200', 1, '111.7882', '37.26605');
INSERT INTO `shop_truck_region` VALUES (351, 0, 'N', '内蒙古', '内蒙古自治区', 1, 'innermongolia', '', 1, '111.670801', '40.818311');
INSERT INTO `shop_truck_region` VALUES (352, 351, 'H', '呼和浩特', '呼和浩特市', 2, 'hohhot', '010000', 1, '111.670801', '40.818311');
INSERT INTO `shop_truck_region` VALUES (353, 352, 'X', '新城', '新城区', 3, 'xincheng', '010050', 1, '111.66554', '40.85828');
INSERT INTO `shop_truck_region` VALUES (354, 352, 'H', '回民', '回民区', 3, 'huimin', '010030', 1, '111.62402', '40.80827');
INSERT INTO `shop_truck_region` VALUES (355, 352, 'Y', '玉泉', '玉泉区', 3, 'yuquan', '010020', 1, '111.67456', '40.75227');
INSERT INTO `shop_truck_region` VALUES (356, 352, 'S', '赛罕', '赛罕区', 3, 'saihan', '010020', 1, '111.70224', '40.79207');
INSERT INTO `shop_truck_region` VALUES (357, 352, 'T', '土默特左旗', '土默特左旗', 3, 'tumotezuoqi', '010100', 1, '111.14898', '40.72229');
INSERT INTO `shop_truck_region` VALUES (358, 352, 'T', '托克托', '托克托县', 3, 'tuoketuo', '010200', 1, '111.19101', '40.27492');
INSERT INTO `shop_truck_region` VALUES (359, 352, 'H', '和林格尔', '和林格尔县', 3, 'helingeer', '011500', 1, '111.82205', '40.37892');
INSERT INTO `shop_truck_region` VALUES (360, 352, 'Q', '清水河', '清水河县', 3, 'qingshuihe', '011600', 1, '111.68316', '39.9097');
INSERT INTO `shop_truck_region` VALUES (361, 352, 'W', '武川', '武川县', 3, 'wuchuan', '011700', 1, '111.45785', '41.09289');
INSERT INTO `shop_truck_region` VALUES (362, 351, 'B', '包头', '包头市', 2, 'baotou', '014025', 1, '109.840405', '40.658168');
INSERT INTO `shop_truck_region` VALUES (363, 362, 'D', '东河', '东河区', 3, 'donghe', '014040', 1, '110.0462', '40.58237');
INSERT INTO `shop_truck_region` VALUES (364, 362, 'K', '昆都仑', '昆都仑区', 3, 'kundulun', '014010', 1, '109.83862', '40.64175');
INSERT INTO `shop_truck_region` VALUES (365, 362, 'Q', '青山', '青山区', 3, 'qingshan', '014030', 1, '109.90131', '40.64329');
INSERT INTO `shop_truck_region` VALUES (366, 362, 'S', '石拐', '石拐区', 3, 'shiguai', '014070', 1, '110.27322', '40.67297');
INSERT INTO `shop_truck_region` VALUES (367, 362, 'B', '白云鄂博矿区', '白云鄂博矿区', 3, 'baiyunebokuangqu', '014080', 1, '109.97367', '41.76968');
INSERT INTO `shop_truck_region` VALUES (368, 362, 'J', '九原', '九原区', 3, 'jiuyuan', '014060', 1, '109.96496', '40.60554');
INSERT INTO `shop_truck_region` VALUES (369, 362, 'T', '土默特右旗', '土默特右旗', 3, 'tumoteyouqi', '014100', 1, '110.52417', '40.5688');
INSERT INTO `shop_truck_region` VALUES (370, 362, 'G', '固阳', '固阳县', 3, 'guyang', '014200', 1, '110.06372', '41.01851');
INSERT INTO `shop_truck_region` VALUES (371, 362, 'D', '达茂旗', '达尔罕茂明安联合旗', 3, 'damaoqi', '014500', 1, '110.43258', '41.69875');
INSERT INTO `shop_truck_region` VALUES (372, 351, 'W', '乌海', '乌海市', 2, 'wuhai', '016000', 1, '106.825563', '39.673734');
INSERT INTO `shop_truck_region` VALUES (373, 372, 'H', '海勃湾', '海勃湾区', 3, 'haibowan', '016000', 1, '106.8222', '39.66955');
INSERT INTO `shop_truck_region` VALUES (374, 372, 'H', '海南', '海南区', 3, 'hainan', '016030', 1, '106.88656', '39.44128');
INSERT INTO `shop_truck_region` VALUES (375, 372, 'W', '乌达', '乌达区', 3, 'wuda', '016040', 1, '106.72723', '39.505');
INSERT INTO `shop_truck_region` VALUES (376, 351, 'C', '赤峰', '赤峰市', 2, 'chifeng', '024000', 1, '118.956806', '42.275317');
INSERT INTO `shop_truck_region` VALUES (377, 376, 'H', '红山', '红山区', 3, 'hongshan', '024020', 1, '118.95755', '42.24312');
INSERT INTO `shop_truck_region` VALUES (378, 376, 'Y', '元宝山', '元宝山区', 3, 'yuanbaoshan', '024076', 1, '119.28921', '42.04005');
INSERT INTO `shop_truck_region` VALUES (379, 376, 'S', '松山', '松山区', 3, 'songshan', '024005', 1, '118.9328', '42.28613');
INSERT INTO `shop_truck_region` VALUES (380, 376, 'A', '阿鲁科尔沁旗', '阿鲁科尔沁旗', 3, 'alukeerqinqi', '025550', 1, '120.06527', '43.87988');
INSERT INTO `shop_truck_region` VALUES (381, 376, 'B', '巴林左旗', '巴林左旗', 3, 'balinzuoqi', '025450', 1, '119.38012', '43.97031');
INSERT INTO `shop_truck_region` VALUES (382, 376, 'B', '巴林右旗', '巴林右旗', 3, 'balinyouqi', '025150', 1, '118.66461', '43.53387');
INSERT INTO `shop_truck_region` VALUES (383, 376, 'L', '林西', '林西县', 3, 'linxi', '025250', 1, '118.04733', '43.61165');
INSERT INTO `shop_truck_region` VALUES (384, 376, 'K', '克什克腾旗', '克什克腾旗', 3, 'keshiketengqi', '025350', 1, '117.54562', '43.26501');
INSERT INTO `shop_truck_region` VALUES (385, 376, 'W', '翁牛特旗', '翁牛特旗', 3, 'wengniuteqi', '024500', 1, '119.03042', '42.93147');
INSERT INTO `shop_truck_region` VALUES (386, 376, 'K', '喀喇沁旗', '喀喇沁旗', 3, 'kalaqinqi', '024400', 1, '118.70144', '41.92917');
INSERT INTO `shop_truck_region` VALUES (387, 376, 'N', '宁城', '宁城县', 3, 'ningcheng', '024200', 1, '119.34375', '41.59661');
INSERT INTO `shop_truck_region` VALUES (388, 376, 'A', '敖汉旗', '敖汉旗', 3, 'aohanqi', '024300', 1, '119.92163', '42.29071');
INSERT INTO `shop_truck_region` VALUES (389, 351, 'T', '通辽', '通辽市', 2, 'tongliao', '028000', 1, '122.263119', '43.617429');
INSERT INTO `shop_truck_region` VALUES (390, 389, 'K', '科尔沁', '科尔沁区', 3, 'keerqin', '028000', 1, '122.25573', '43.62257');
INSERT INTO `shop_truck_region` VALUES (391, 389, 'K', '科尔沁左翼中旗', '科尔沁左翼中旗', 3, 'keerqinzuoyizhongqi', '029300', 1, '123.31912', '44.13014');
INSERT INTO `shop_truck_region` VALUES (392, 389, 'K', '科尔沁左翼后旗', '科尔沁左翼后旗', 3, 'keerqinzuoyihouqi', '028100', 1, '122.35745', '42.94897');
INSERT INTO `shop_truck_region` VALUES (393, 389, 'K', '开鲁', '开鲁县', 3, 'kailu', '028400', 1, '121.31884', '43.60003');
INSERT INTO `shop_truck_region` VALUES (394, 389, 'K', '库伦旗', '库伦旗', 3, 'kulunqi', '028200', 1, '121.776', '42.72998');
INSERT INTO `shop_truck_region` VALUES (395, 389, 'N', '奈曼旗', '奈曼旗', 3, 'naimanqi', '028300', 1, '120.66348', '42.84527');
INSERT INTO `shop_truck_region` VALUES (396, 389, 'Z', '扎鲁特旗', '扎鲁特旗', 3, 'zhaluteqi', '029100', 1, '120.91507', '44.55592');
INSERT INTO `shop_truck_region` VALUES (397, 389, 'H', '霍林郭勒', '霍林郭勒市', 3, 'huolinguole', '029200', 1, '119.65429', '45.53454');
INSERT INTO `shop_truck_region` VALUES (398, 351, 'E', '鄂尔多斯', '鄂尔多斯市', 2, 'ordos', '017004', 1, '109.99029', '39.817179');
INSERT INTO `shop_truck_region` VALUES (399, 398, 'D', '东胜', '东胜区', 3, 'dongsheng', '017000', 1, '109.96289', '39.82236');
INSERT INTO `shop_truck_region` VALUES (400, 398, 'D', '达拉特旗', '达拉特旗', 3, 'dalateqi', '014300', 1, '110.03317', '40.4001');
INSERT INTO `shop_truck_region` VALUES (401, 398, 'Z', '准格尔旗', '准格尔旗', 3, 'zhungeerqi', '017100', 1, '111.23645', '39.86783');
INSERT INTO `shop_truck_region` VALUES (402, 398, 'E', '鄂托克前旗', '鄂托克前旗', 3, 'etuokeqianqi', '016200', 1, '107.48403', '38.18396');
INSERT INTO `shop_truck_region` VALUES (403, 398, 'E', '鄂托克旗', '鄂托克旗', 3, 'etuokeqi', '016100', 1, '107.98226', '39.09456');
INSERT INTO `shop_truck_region` VALUES (404, 398, 'H', '杭锦旗', '杭锦旗', 3, 'hangjinqi', '017400', 1, '108.72934', '39.84023');
INSERT INTO `shop_truck_region` VALUES (405, 398, 'W', '乌审旗', '乌审旗', 3, 'wushenqi', '017300', 1, '108.8461', '38.59092');
INSERT INTO `shop_truck_region` VALUES (406, 398, 'Y', '伊金霍洛旗', '伊金霍洛旗', 3, 'yijinhuoluoqi', '017200', 1, '109.74908', '39.57393');
INSERT INTO `shop_truck_region` VALUES (407, 351, 'H', '呼伦贝尔', '呼伦贝尔市', 2, 'hulunber', '021008', 1, '119.758168', '49.215333');
INSERT INTO `shop_truck_region` VALUES (408, 407, 'H', '海拉尔', '海拉尔区', 3, 'hailaer', '021000', 1, '119.7364', '49.2122');
INSERT INTO `shop_truck_region` VALUES (409, 407, 'Z', '扎赉诺尔', '扎赉诺尔区', 3, 'zhalainuoer', '021410', 1, '117.792702', '49.486943');
INSERT INTO `shop_truck_region` VALUES (410, 407, 'A', '阿荣旗', '阿荣旗', 3, 'arongqi', '162750', 1, '123.45941', '48.12581');
INSERT INTO `shop_truck_region` VALUES (411, 407, 'M', '莫旗', '莫力达瓦达斡尔族自治旗', 3, 'moqi', '162850', 1, '124.51498', '48.48055');
INSERT INTO `shop_truck_region` VALUES (412, 407, 'E', '鄂伦春', '鄂伦春自治旗', 3, 'elunchun', '165450', 1, '123.72604', '50.59777');
INSERT INTO `shop_truck_region` VALUES (413, 407, 'E', '鄂温', '鄂温克族自治旗', 3, 'ewen', '021100', 1, '119.7565', '49.14284');
INSERT INTO `shop_truck_region` VALUES (414, 407, 'C', '陈巴尔虎旗', '陈巴尔虎旗', 3, 'chenbaerhuqi', '021500', 1, '119.42434', '49.32684');
INSERT INTO `shop_truck_region` VALUES (415, 407, 'X', '新巴尔虎左旗', '新巴尔虎左旗', 3, 'xinbaerhuzuoqi', '021200', 1, '118.26989', '48.21842');
INSERT INTO `shop_truck_region` VALUES (416, 407, 'X', '新巴尔虎右旗', '新巴尔虎右旗', 3, 'xinbaerhuyouqi', '021300', 1, '116.82366', '48.66473');
INSERT INTO `shop_truck_region` VALUES (417, 407, 'M', '满洲里', '满洲里市', 3, 'manzhouli', '021400', 1, '117.47946', '49.58272');
INSERT INTO `shop_truck_region` VALUES (418, 407, 'Y', '牙克石', '牙克石市', 3, 'yakeshi', '022150', 1, '120.7117', '49.2856');
INSERT INTO `shop_truck_region` VALUES (419, 407, 'Z', '扎兰屯', '扎兰屯市', 3, 'zhalantun', '162650', 1, '122.73757', '48.01363');
INSERT INTO `shop_truck_region` VALUES (420, 407, 'E', '额尔古纳', '额尔古纳市', 3, 'eerguna', '022250', 1, '120.19094', '50.24249');
INSERT INTO `shop_truck_region` VALUES (421, 407, 'G', '根河', '根河市', 3, 'genhe', '022350', 1, '121.52197', '50.77996');
INSERT INTO `shop_truck_region` VALUES (422, 351, 'B', '巴彦淖尔', '巴彦淖尔市', 2, 'bayannur', '015001', 1, '107.416959', '40.757402');
INSERT INTO `shop_truck_region` VALUES (423, 422, 'L', '临河', '临河区', 3, 'linhe', '015001', 1, '107.42668', '40.75827');
INSERT INTO `shop_truck_region` VALUES (424, 422, 'W', '五原', '五原县', 3, 'wuyuan', '015100', 1, '108.26916', '41.09631');
INSERT INTO `shop_truck_region` VALUES (425, 422, 'D', '磴口', '磴口县', 3, 'dengkou', '015200', 1, '107.00936', '40.33062');
INSERT INTO `shop_truck_region` VALUES (426, 422, 'W', '乌拉特前旗', '乌拉特前旗', 3, 'wulateqianqi', '014400', 1, '108.65219', '40.73649');
INSERT INTO `shop_truck_region` VALUES (427, 422, 'W', '乌拉特中旗', '乌拉特中旗', 3, 'wulatezhongqi', '015300', 1, '108.52587', '41.56789');
INSERT INTO `shop_truck_region` VALUES (428, 422, 'W', '乌拉特后旗', '乌拉特后旗', 3, 'wulatehouqi', '015500', 1, '106.98971', '41.43151');
INSERT INTO `shop_truck_region` VALUES (429, 422, 'H', '杭锦后旗', '杭锦后旗', 3, 'hangjinhouqi', '015400', 1, '107.15133', '40.88627');
INSERT INTO `shop_truck_region` VALUES (430, 351, 'W', '乌兰察布', '乌兰察布市', 2, 'ulanqab', '012000', 1, '113.114543', '41.034126');
INSERT INTO `shop_truck_region` VALUES (431, 430, 'J', '集宁', '集宁区', 3, 'jining', '012000', 1, '113.11452', '41.0353');
INSERT INTO `shop_truck_region` VALUES (432, 430, 'Z', '卓资', '卓资县', 3, 'zhuozi', '012300', 1, '112.57757', '40.89414');
INSERT INTO `shop_truck_region` VALUES (433, 430, 'H', '化德', '化德县', 3, 'huade', '013350', 1, '114.01071', '41.90433');
INSERT INTO `shop_truck_region` VALUES (434, 430, 'S', '商都', '商都县', 3, 'shangdu', '013450', 1, '113.57772', '41.56213');
INSERT INTO `shop_truck_region` VALUES (435, 430, 'X', '兴和', '兴和县', 3, 'xinghe', '013650', 1, '113.83395', '40.87186');
INSERT INTO `shop_truck_region` VALUES (436, 430, 'L', '凉城', '凉城县', 3, 'liangcheng', '013750', 1, '112.49569', '40.53346');
INSERT INTO `shop_truck_region` VALUES (437, 430, 'C', '察右前旗', '察哈尔右翼前旗', 3, 'chayouqianqi', '012200', 1, '113.22131', '40.7788');
INSERT INTO `shop_truck_region` VALUES (438, 430, 'C', '察右中旗', '察哈尔右翼中旗', 3, 'chayouzhongqi', '013550', 1, '112.63537', '41.27742');
INSERT INTO `shop_truck_region` VALUES (439, 430, 'C', '察右后旗', '察哈尔右翼后旗', 3, 'chayouhouqi', '012400', 1, '113.19216', '41.43554');
INSERT INTO `shop_truck_region` VALUES (440, 430, 'S', '四子王旗', '四子王旗', 3, 'siziwangqi', '011800', 1, '111.70654', '41.53312');
INSERT INTO `shop_truck_region` VALUES (441, 430, 'F', '丰镇', '丰镇市', 3, 'fengzhen', '012100', 1, '113.10983', '40.4369');
INSERT INTO `shop_truck_region` VALUES (442, 351, 'X', '兴安盟', '兴安盟', 2, 'hinggan', '137401', 1, '122.070317', '46.076268');
INSERT INTO `shop_truck_region` VALUES (443, 442, 'W', '乌兰浩特', '乌兰浩特市', 3, 'wulanhaote', '137401', 1, '122.06378', '46.06235');
INSERT INTO `shop_truck_region` VALUES (444, 442, 'A', '阿尔山', '阿尔山市', 3, 'aershan', '137800', 1, '119.94317', '47.17716');
INSERT INTO `shop_truck_region` VALUES (445, 442, 'K', '科右前旗', '科尔沁右翼前旗', 3, 'keyouqianqi', '137423', 1, '121.95269', '46.0795');
INSERT INTO `shop_truck_region` VALUES (446, 442, 'K', '科右中旗', '科尔沁右翼中旗', 3, 'keyouzhongqi', '029400', 1, '121.46807', '45.05605');
INSERT INTO `shop_truck_region` VALUES (447, 442, 'Z', '扎赉特旗', '扎赉特旗', 3, 'zhalaiteqi', '137600', 1, '122.91229', '46.7267');
INSERT INTO `shop_truck_region` VALUES (448, 442, 'T', '突泉', '突泉县', 3, 'tuquan', '137500', 1, '121.59396', '45.38187');
INSERT INTO `shop_truck_region` VALUES (449, 351, 'X', '锡林郭勒盟', '锡林郭勒盟', 2, 'xilingol', '026000', 1, '116.090996', '43.944018');
INSERT INTO `shop_truck_region` VALUES (450, 449, 'E', '二连浩特', '二连浩特市', 3, 'erlianhaote', '011100', 1, '111.98297', '43.65303');
INSERT INTO `shop_truck_region` VALUES (451, 449, 'X', '锡林浩特', '锡林浩特市', 3, 'xilinhaote', '026021', 1, '116.08603', '43.93341');
INSERT INTO `shop_truck_region` VALUES (452, 449, 'A', '阿巴嘎旗', '阿巴嘎旗', 3, 'abagaqi', '011400', 1, '114.96826', '44.02174');
INSERT INTO `shop_truck_region` VALUES (453, 449, 'S', '苏尼特左旗', '苏尼特左旗', 3, 'sunitezuoqi', '011300', 1, '113.6506', '43.85687');
INSERT INTO `shop_truck_region` VALUES (454, 449, 'S', '苏尼特右旗', '苏尼特右旗', 3, 'suniteyouqi', '011200', 1, '112.65741', '42.7469');
INSERT INTO `shop_truck_region` VALUES (455, 449, 'D', '东乌旗', '东乌珠穆沁旗', 3, 'dongwuqi', '026300', 1, '116.97293', '45.51108');
INSERT INTO `shop_truck_region` VALUES (456, 449, 'X', '西乌旗', '西乌珠穆沁旗', 3, 'xiwuqi', '026200', 1, '117.60983', '44.59623');
INSERT INTO `shop_truck_region` VALUES (457, 449, 'T', '太仆寺旗', '太仆寺旗', 3, 'taipusiqi', '027000', 1, '115.28302', '41.87727');
INSERT INTO `shop_truck_region` VALUES (458, 449, 'X', '镶黄旗', '镶黄旗', 3, 'xianghuangqi', '013250', 1, '113.84472', '42.23927');
INSERT INTO `shop_truck_region` VALUES (459, 449, 'Z', '正镶白旗', '正镶白旗', 3, 'zhengxiangbaiqi', '013800', 1, '115.00067', '42.30712');
INSERT INTO `shop_truck_region` VALUES (460, 449, 'Z', '正蓝旗', '正蓝旗', 3, 'zhenglanqi', '027200', 1, '116.00363', '42.25229');
INSERT INTO `shop_truck_region` VALUES (461, 449, 'D', '多伦', '多伦县', 3, 'duolun', '027300', 1, '116.48565', '42.203');
INSERT INTO `shop_truck_region` VALUES (462, 351, 'A', '阿拉善盟', '阿拉善盟', 2, 'alxa', '750306', 1, '105.706422', '38.844814');
INSERT INTO `shop_truck_region` VALUES (463, 462, 'A', '阿拉善左旗', '阿拉善左旗', 3, 'alashanzuoqi', '750306', 1, '105.67532', '38.8293');
INSERT INTO `shop_truck_region` VALUES (464, 462, 'A', '阿拉善右旗', '阿拉善右旗', 3, 'alashanyouqi', '737300', 1, '101.66705', '39.21533');
INSERT INTO `shop_truck_region` VALUES (465, 462, 'E', '额济纳旗', '额济纳旗', 3, 'ejinaqi', '735400', 1, '101.06887', '41.96755');
INSERT INTO `shop_truck_region` VALUES (466, 0, 'L', '辽宁', '辽宁省', 1, 'liaoning', '', 1, '123.429096', '41.796767');
INSERT INTO `shop_truck_region` VALUES (467, 466, 'S', '沈阳', '沈阳市', 2, 'shenyang', '110013', 1, '123.429096', '41.796767');
INSERT INTO `shop_truck_region` VALUES (468, 467, 'H', '和平', '和平区', 3, 'heping', '110001', 1, '123.4204', '41.78997');
INSERT INTO `shop_truck_region` VALUES (469, 467, 'S', '沈河', '沈河区', 3, 'shenhe', '110011', 1, '123.45871', '41.79625');
INSERT INTO `shop_truck_region` VALUES (470, 467, 'D', '大东', '大东区', 3, 'dadong', '110041', 1, '123.46997', '41.80539');
INSERT INTO `shop_truck_region` VALUES (471, 467, 'H', '皇姑', '皇姑区', 3, 'huanggu', '110031', 1, '123.42527', '41.82035');
INSERT INTO `shop_truck_region` VALUES (472, 467, 'T', '铁西', '铁西区', 3, 'tiexi', '110021', 1, '123.37675', '41.80269');
INSERT INTO `shop_truck_region` VALUES (473, 467, 'S', '苏家屯', '苏家屯区', 3, 'sujiatun', '110101', 1, '123.34405', '41.66475');
INSERT INTO `shop_truck_region` VALUES (474, 467, 'H', '浑南', '浑南区', 3, 'hunnan', '110015', 1, '123.457707', '41.719450');
INSERT INTO `shop_truck_region` VALUES (475, 467, 'S', '沈北新区', '沈北新区', 3, 'shenbeixinqu', '110121', 1, '123.52658', '42.05297');
INSERT INTO `shop_truck_region` VALUES (476, 467, 'Y', '于洪', '于洪区', 3, 'yuhong', '110141', 1, '123.30807', '41.794');
INSERT INTO `shop_truck_region` VALUES (477, 467, 'L', '辽中', '辽中县', 3, 'liaozhong', '110200', 1, '122.72659', '41.51302');
INSERT INTO `shop_truck_region` VALUES (478, 467, 'K', '康平', '康平县', 3, 'kangping', '110500', 1, '123.35446', '42.75081');
INSERT INTO `shop_truck_region` VALUES (479, 467, 'F', '法库', '法库县', 3, 'faku', '110400', 1, '123.41214', '42.50608');
INSERT INTO `shop_truck_region` VALUES (480, 467, 'X', '新民', '新民市', 3, 'xinmin', '110300', 1, '122.82867', '41.99847');
INSERT INTO `shop_truck_region` VALUES (481, 466, 'D', '大连', '大连市', 2, 'dalian', '116011', 1, '121.618622', '38.91459');
INSERT INTO `shop_truck_region` VALUES (482, 481, 'Z', '中山', '中山区', 3, 'zhongshan', '116001', 1, '121.64465', '38.91859');
INSERT INTO `shop_truck_region` VALUES (483, 481, 'X', '西岗', '西岗区', 3, 'xigang', '116011', 1, '121.61238', '38.91469');
INSERT INTO `shop_truck_region` VALUES (484, 481, 'S', '沙河口', '沙河口区', 3, 'shahekou', '116021', 1, '121.58017', '38.90536');
INSERT INTO `shop_truck_region` VALUES (485, 481, 'G', '甘井子', '甘井子区', 3, 'ganjingzi', '116033', 1, '121.56567', '38.95017');
INSERT INTO `shop_truck_region` VALUES (486, 481, 'L', '旅顺口', '旅顺口区', 3, 'lvshunkou', '116041', 1, '121.26202', '38.85125');
INSERT INTO `shop_truck_region` VALUES (487, 481, 'J', '金州', '金州区', 3, 'jinzhou', '116100', 1, '121.71893', '39.1004');
INSERT INTO `shop_truck_region` VALUES (488, 481, 'C', '长海', '长海县', 3, 'changhai', '116500', 1, '122.58859', '39.27274');
INSERT INTO `shop_truck_region` VALUES (489, 481, 'W', '瓦房店', '瓦房店市', 3, 'wafangdian', '116300', 1, '121.98104', '39.62843');
INSERT INTO `shop_truck_region` VALUES (490, 481, 'P', '普兰店', '普兰店市', 3, 'pulandian', '116200', 1, '121.96316', '39.39465');
INSERT INTO `shop_truck_region` VALUES (491, 481, 'Z', '庄河', '庄河市', 3, 'zhuanghe', '116400', 1, '122.96725', '39.68815');
INSERT INTO `shop_truck_region` VALUES (492, 466, 'A', '鞍山', '鞍山市', 2, 'anshan', '114001', 1, '122.995632', '41.110626');
INSERT INTO `shop_truck_region` VALUES (493, 492, 'T', '铁东', '铁东区', 3, 'tiedong', '114001', 1, '122.99085', '41.08975');
INSERT INTO `shop_truck_region` VALUES (494, 492, 'T', '铁西', '铁西区', 3, 'tiexi', '114013', 1, '122.96967', '41.11977');
INSERT INTO `shop_truck_region` VALUES (495, 492, 'L', '立山', '立山区', 3, 'lishan', '114031', 1, '123.02948', '41.15008');
INSERT INTO `shop_truck_region` VALUES (496, 492, 'Q', '千山', '千山区', 3, 'qianshan', '114041', 1, '122.96048', '41.07507');
INSERT INTO `shop_truck_region` VALUES (497, 492, 'T', '台安', '台安县', 3, 'taian', '114100', 1, '122.43585', '41.41265');
INSERT INTO `shop_truck_region` VALUES (498, 492, 'X', '岫岩', '岫岩满族自治县', 3, 'xiuyan', '114300', 1, '123.28875', '40.27996');
INSERT INTO `shop_truck_region` VALUES (499, 492, 'H', '海城', '海城市', 3, 'haicheng', '114200', 1, '122.68457', '40.88142');
INSERT INTO `shop_truck_region` VALUES (500, 466, 'F', '抚顺', '抚顺市', 2, 'fushun', '113008', 1, '123.921109', '41.875956');
INSERT INTO `shop_truck_region` VALUES (501, 500, 'X', '新抚', '新抚区', 3, 'xinfu', '113008', 1, '123.91264', '41.86205');
INSERT INTO `shop_truck_region` VALUES (502, 500, 'D', '东洲', '东洲区', 3, 'dongzhou', '113003', 1, '124.03759', '41.8519');
INSERT INTO `shop_truck_region` VALUES (503, 500, 'W', '望花', '望花区', 3, 'wanghua', '113001', 1, '123.78283', '41.85532');
INSERT INTO `shop_truck_region` VALUES (504, 500, 'S', '顺城', '顺城区', 3, 'shuncheng', '113006', 1, '123.94506', '41.88321');
INSERT INTO `shop_truck_region` VALUES (505, 500, 'F', '抚顺', '抚顺县', 3, 'fushun', '113006', 1, '124.17755', '41.71217');
INSERT INTO `shop_truck_region` VALUES (506, 500, 'X', '新宾', '新宾满族自治县', 3, 'xinbin', '113200', 1, '125.04049', '41.73409');
INSERT INTO `shop_truck_region` VALUES (507, 500, 'Q', '清原', '清原满族自治县', 3, 'qingyuan', '113300', 1, '124.92807', '42.10221');
INSERT INTO `shop_truck_region` VALUES (508, 466, 'B', '本溪', '本溪市', 2, 'benxi', '117000', 1, '123.770519', '41.297909');
INSERT INTO `shop_truck_region` VALUES (509, 508, 'P', '平山', '平山区', 3, 'pingshan', '117000', 1, '123.76892', '41.2997');
INSERT INTO `shop_truck_region` VALUES (510, 508, 'X', '溪湖', '溪湖区', 3, 'xihu', '117002', 1, '123.76764', '41.32921');
INSERT INTO `shop_truck_region` VALUES (511, 508, 'M', '明山', '明山区', 3, 'mingshan', '117021', 1, '123.81746', '41.30827');
INSERT INTO `shop_truck_region` VALUES (512, 508, 'N', '南芬', '南芬区', 3, 'nanfen', '117014', 1, '123.74523', '41.1006');
INSERT INTO `shop_truck_region` VALUES (513, 508, 'B', '本溪', '本溪满族自治县', 3, 'benxi', '117100', 1, '124.12741', '41.30059');
INSERT INTO `shop_truck_region` VALUES (514, 508, 'H', '桓仁', '桓仁满族自治县', 3, 'huanren', '117200', 1, '125.36062', '41.26798');
INSERT INTO `shop_truck_region` VALUES (515, 466, 'D', '丹东', '丹东市', 2, 'dandong', '118000', 1, '124.383044', '40.124296');
INSERT INTO `shop_truck_region` VALUES (516, 515, 'Y', '元宝', '元宝区', 3, 'yuanbao', '118000', 1, '124.39575', '40.13651');
INSERT INTO `shop_truck_region` VALUES (517, 515, 'Z', '振兴', '振兴区', 3, 'zhenxing', '118002', 1, '124.36035', '40.10489');
INSERT INTO `shop_truck_region` VALUES (518, 515, 'Z', '振安', '振安区', 3, 'zhenan', '118001', 1, '124.42816', '40.15826');
INSERT INTO `shop_truck_region` VALUES (519, 515, 'K', '宽甸', '宽甸满族自治县', 3, 'kuandian', '118200', 1, '124.78247', '40.73187');
INSERT INTO `shop_truck_region` VALUES (520, 515, 'D', '东港', '东港市', 3, 'donggang', '118300', 1, '124.16287', '39.86256');
INSERT INTO `shop_truck_region` VALUES (521, 515, 'F', '凤城', '凤城市', 3, 'fengcheng', '118100', 1, '124.06671', '40.45302');
INSERT INTO `shop_truck_region` VALUES (522, 466, 'J', '锦州', '锦州市', 2, 'jinzhou', '121000', 1, '121.135742', '41.119269');
INSERT INTO `shop_truck_region` VALUES (523, 522, 'G', '古塔', '古塔区', 3, 'guta', '121001', 1, '121.12832', '41.11725');
INSERT INTO `shop_truck_region` VALUES (524, 522, 'L', '凌河', '凌河区', 3, 'linghe', '121000', 1, '121.15089', '41.11496');
INSERT INTO `shop_truck_region` VALUES (525, 522, 'T', '太和', '太和区', 3, 'taihe', '121011', 1, '121.10354', '41.10929');
INSERT INTO `shop_truck_region` VALUES (526, 522, 'H', '黑山', '黑山县', 3, 'heishan', '121400', 1, '122.12081', '41.69417');
INSERT INTO `shop_truck_region` VALUES (527, 522, 'Y', '义县', '义县', 3, 'yixian', '121100', 1, '121.24035', '41.53458');
INSERT INTO `shop_truck_region` VALUES (528, 522, 'L', '凌海', '凌海市', 3, 'linghai', '121200', 1, '121.35705', '41.1737');
INSERT INTO `shop_truck_region` VALUES (529, 522, 'B', '北镇', '北镇市', 3, 'beizhen', '121300', 1, '121.79858', '41.59537');
INSERT INTO `shop_truck_region` VALUES (530, 466, 'Y', '营口', '营口市', 2, 'yingkou', '115003', 1, '122.235151', '40.667432');
INSERT INTO `shop_truck_region` VALUES (531, 530, 'Z', '站前', '站前区', 3, 'zhanqian', '115002', 1, '122.25896', '40.67266');
INSERT INTO `shop_truck_region` VALUES (532, 530, 'X', '西市', '西市区', 3, 'xishi', '115004', 1, '122.20641', '40.6664');
INSERT INTO `shop_truck_region` VALUES (533, 530, 'B', '鲅鱼圈', '鲅鱼圈区', 3, 'bayuquan', '115007', 1, '122.13266', '40.26865');
INSERT INTO `shop_truck_region` VALUES (534, 530, 'L', '老边', '老边区', 3, 'laobian', '115005', 1, '122.37996', '40.6803');
INSERT INTO `shop_truck_region` VALUES (535, 530, 'G', '盖州', '盖州市', 3, 'gaizhou', '115200', 1, '122.35464', '40.40446');
INSERT INTO `shop_truck_region` VALUES (536, 530, 'D', '大石桥', '大石桥市', 3, 'dashiqiao', '115100', 1, '122.50927', '40.64567');
INSERT INTO `shop_truck_region` VALUES (537, 466, 'F', '阜新', '阜新市', 2, 'fuxin', '123000', 1, '121.648962', '42.011796');
INSERT INTO `shop_truck_region` VALUES (538, 537, 'H', '海州', '海州区', 3, 'haizhou', '123000', 1, '121.65626', '42.01336');
INSERT INTO `shop_truck_region` VALUES (539, 537, 'X', '新邱', '新邱区', 3, 'xinqiu', '123005', 1, '121.79251', '42.09181');
INSERT INTO `shop_truck_region` VALUES (540, 537, 'T', '太平', '太平区', 3, 'taiping', '123003', 1, '121.67865', '42.01065');
INSERT INTO `shop_truck_region` VALUES (541, 537, 'Q', '清河门', '清河门区', 3, 'qinghemen', '123006', 1, '121.4161', '41.78309');
INSERT INTO `shop_truck_region` VALUES (542, 537, 'X', '细河', '细河区', 3, 'xihe', '123000', 1, '121.68013', '42.02533');
INSERT INTO `shop_truck_region` VALUES (543, 537, 'F', '阜新', '阜新蒙古族自治县', 3, 'fuxin', '123100', 1, '121.75787', '42.0651');
INSERT INTO `shop_truck_region` VALUES (544, 537, 'Z', '彰武', '彰武县', 3, 'zhangwu', '123200', 1, '122.54022', '42.38625');
INSERT INTO `shop_truck_region` VALUES (545, 466, 'L', '辽阳', '辽阳市', 2, 'liaoyang', '111000', 1, '123.18152', '41.269402');
INSERT INTO `shop_truck_region` VALUES (546, 545, 'B', '白塔', '白塔区', 3, 'baita', '111000', 1, '123.1747', '41.27025');
INSERT INTO `shop_truck_region` VALUES (547, 545, 'W', '文圣', '文圣区', 3, 'wensheng', '111000', 1, '123.18521', '41.26267');
INSERT INTO `shop_truck_region` VALUES (548, 545, 'H', '宏伟', '宏伟区', 3, 'hongwei', '111003', 1, '123.1929', '41.21852');
INSERT INTO `shop_truck_region` VALUES (549, 545, 'G', '弓长岭', '弓长岭区', 3, 'gongchangling', '111008', 1, '123.41963', '41.15181');
INSERT INTO `shop_truck_region` VALUES (550, 545, 'T', '太子河', '太子河区', 3, 'taizihe', '111000', 1, '123.18182', '41.25337');
INSERT INTO `shop_truck_region` VALUES (551, 545, 'L', '辽阳', '辽阳县', 3, 'liaoyang', '111200', 1, '123.10574', '41.20542');
INSERT INTO `shop_truck_region` VALUES (552, 545, 'D', '灯塔', '灯塔市', 3, 'dengta', '111300', 1, '123.33926', '41.42612');
INSERT INTO `shop_truck_region` VALUES (553, 466, 'P', '盘锦', '盘锦市', 2, 'panjin', '124010', 1, '122.06957', '41.124484');
INSERT INTO `shop_truck_region` VALUES (554, 553, 'S', '双台子', '双台子区', 3, 'shuangtaizi', '124000', 1, '122.06011', '41.1906');
INSERT INTO `shop_truck_region` VALUES (555, 553, 'X', '兴隆台', '兴隆台区', 3, 'xinglongtai', '124010', 1, '122.07529', '41.12402');
INSERT INTO `shop_truck_region` VALUES (556, 553, 'D', '大洼', '大洼县', 3, 'dawa', '124200', 1, '122.08239', '41.00244');
INSERT INTO `shop_truck_region` VALUES (557, 553, 'P', '盘山', '盘山县', 3, 'panshan', '124000', 1, '121.99777', '41.23805');
INSERT INTO `shop_truck_region` VALUES (558, 466, 'T', '铁岭', '铁岭市', 2, 'tieling', '112000', 1, '123.844279', '42.290585');
INSERT INTO `shop_truck_region` VALUES (559, 558, 'Y', '银州', '银州区', 3, 'yinzhou', '112000', 1, '123.8573', '42.29507');
INSERT INTO `shop_truck_region` VALUES (560, 558, 'Q', '清河', '清河区', 3, 'qinghe', '112003', 1, '124.15911', '42.54679');
INSERT INTO `shop_truck_region` VALUES (561, 558, 'T', '铁岭', '铁岭县', 3, 'tieling', '112000', 1, '123.77325', '42.22498');
INSERT INTO `shop_truck_region` VALUES (562, 558, 'X', '西丰', '西丰县', 3, 'xifeng', '112400', 1, '124.7304', '42.73756');
INSERT INTO `shop_truck_region` VALUES (563, 558, 'C', '昌图', '昌图县', 3, 'changtu', '112500', 1, '124.11206', '42.78428');
INSERT INTO `shop_truck_region` VALUES (564, 558, 'D', '调兵山', '调兵山市', 3, 'diaobingshan', '112700', 1, '123.56689', '42.4675');
INSERT INTO `shop_truck_region` VALUES (565, 558, 'K', '开原', '开原市', 3, 'kaiyuan', '112300', 1, '124.03945', '42.54585');
INSERT INTO `shop_truck_region` VALUES (566, 466, 'C', '朝阳', '朝阳市', 2, 'chaoyang', '122000', 1, '120.451176', '41.576758');
INSERT INTO `shop_truck_region` VALUES (567, 566, 'S', '双塔', '双塔区', 3, 'shuangta', '122000', 1, '120.45385', '41.566');
INSERT INTO `shop_truck_region` VALUES (568, 566, 'L', '龙城', '龙城区', 3, 'longcheng', '122000', 1, '120.43719', '41.59264');
INSERT INTO `shop_truck_region` VALUES (569, 566, 'C', '朝阳', '朝阳县', 3, 'chaoyang', '122000', 1, '120.17401', '41.4324');
INSERT INTO `shop_truck_region` VALUES (570, 566, 'J', '建平', '建平县', 3, 'jianping', '122400', 1, '119.64392', '41.40315');
INSERT INTO `shop_truck_region` VALUES (571, 566, 'K', '喀喇沁左翼', '喀喇沁左翼蒙古族自治县', 3, 'kalaqinzuoyi', '122300', 1, '119.74185', '41.12801');
INSERT INTO `shop_truck_region` VALUES (572, 566, 'B', '北票', '北票市', 3, 'beipiao', '122100', 1, '120.76977', '41.80196');
INSERT INTO `shop_truck_region` VALUES (573, 566, 'L', '凌源', '凌源市', 3, 'lingyuan', '122500', 1, '119.40148', '41.24558');
INSERT INTO `shop_truck_region` VALUES (574, 466, 'H', '葫芦岛', '葫芦岛市', 2, 'huludao', '125000', 1, '120.856394', '40.755572');
INSERT INTO `shop_truck_region` VALUES (575, 574, 'L', '连山', '连山区', 3, 'lianshan', '125001', 1, '120.86393', '40.75554');
INSERT INTO `shop_truck_region` VALUES (576, 574, 'L', '龙港', '龙港区', 3, 'longgang', '125003', 1, '120.94866', '40.71919');
INSERT INTO `shop_truck_region` VALUES (577, 574, 'N', '南票', '南票区', 3, 'nanpiao', '125027', 1, '120.74978', '41.10707');
INSERT INTO `shop_truck_region` VALUES (578, 574, 'S', '绥中', '绥中县', 3, 'suizhong', '125200', 1, '120.34451', '40.32552');
INSERT INTO `shop_truck_region` VALUES (579, 574, 'J', '建昌', '建昌县', 3, 'jianchang', '125300', 1, '119.8377', '40.82448');
INSERT INTO `shop_truck_region` VALUES (580, 574, 'X', '兴城', '兴城市', 3, 'xingcheng', '125100', 1, '120.72537', '40.61492');
INSERT INTO `shop_truck_region` VALUES (581, 466, 'J', '金普新区', '金普新区', 2, 'jinpuxinqu', '116100', 1, '121.789627', '39.055451');
INSERT INTO `shop_truck_region` VALUES (582, 581, 'J', '金州新区', '金州新区', 3, 'jinzhouxinqu', '116100', 1, '121.784821', '39.052252');
INSERT INTO `shop_truck_region` VALUES (583, 581, 'P', '普湾新区', '普湾新区', 3, 'puwanxinqu', '116200', 1, '121.812812', '39.330093');
INSERT INTO `shop_truck_region` VALUES (584, 581, 'B', '保税区', '保税区', 3, 'baoshuiqu', '116100', 1, '121.94289', '39.224614');
INSERT INTO `shop_truck_region` VALUES (585, 0, 'J', '吉林', '吉林省', 1, 'jilin', '', 1, '125.3245', '43.886841');
INSERT INTO `shop_truck_region` VALUES (586, 585, 'C', '长春', '长春市', 2, 'changchun', '130022', 1, '125.3245', '43.886841');
INSERT INTO `shop_truck_region` VALUES (587, 586, 'N', '南关', '南关区', 3, 'nanguan', '130022', 1, '125.35035', '43.86401');
INSERT INTO `shop_truck_region` VALUES (588, 586, 'K', '宽城', '宽城区', 3, 'kuancheng', '130051', 1, '125.32635', '43.90182');
INSERT INTO `shop_truck_region` VALUES (589, 586, 'C', '朝阳', '朝阳区', 3, 'chaoyang', '130012', 1, '125.2883', '43.83339');
INSERT INTO `shop_truck_region` VALUES (590, 586, 'E', '二道', '二道区', 3, 'erdao', '130031', 1, '125.37429', '43.86501');
INSERT INTO `shop_truck_region` VALUES (591, 586, 'L', '绿园', '绿园区', 3, 'lvyuan', '130062', 1, '125.25582', '43.88045');
INSERT INTO `shop_truck_region` VALUES (592, 586, 'S', '双阳', '双阳区', 3, 'shuangyang', '130600', 1, '125.65631', '43.52803');
INSERT INTO `shop_truck_region` VALUES (593, 586, 'J', '九台', '九台区', 3, 'jiutai', '130500', 1, '125.8395', '44.15163');
INSERT INTO `shop_truck_region` VALUES (594, 586, 'N', '农安', '农安县', 3, 'nongan', '130200', 1, '125.18481', '44.43265');
INSERT INTO `shop_truck_region` VALUES (595, 586, 'Y', '榆树', '榆树市', 3, 'yushu', '130400', 1, '126.55688', '44.82523');
INSERT INTO `shop_truck_region` VALUES (596, 586, 'D', '德惠', '德惠市', 3, 'dehui', '130300', 1, '125.70538', '44.53719');
INSERT INTO `shop_truck_region` VALUES (597, 585, 'J', '吉林', '吉林市', 2, 'jilin', '132011', 1, '126.55302', '43.843577');
INSERT INTO `shop_truck_region` VALUES (598, 597, 'C', '昌邑', '昌邑区', 3, 'changyi', '132002', 1, '126.57424', '43.88183');
INSERT INTO `shop_truck_region` VALUES (599, 597, 'L', '龙潭', '龙潭区', 3, 'longtan', '132021', 1, '126.56213', '43.91054');
INSERT INTO `shop_truck_region` VALUES (600, 597, 'C', '船营', '船营区', 3, 'chuanying', '132011', 1, '126.54096', '43.83344');
INSERT INTO `shop_truck_region` VALUES (601, 597, 'F', '丰满', '丰满区', 3, 'fengman', '132013', 1, '126.56237', '43.82236');
INSERT INTO `shop_truck_region` VALUES (602, 597, 'Y', '永吉', '永吉县', 3, 'yongji', '132200', 1, '126.4963', '43.67197');
INSERT INTO `shop_truck_region` VALUES (603, 597, NULL, '蛟河', '蛟河市', 3, 'jiaohe', '132500', 1, '127.34426', '43.72696');
INSERT INTO `shop_truck_region` VALUES (604, 597, NULL, '桦甸', '桦甸市', 3, 'huadian', '132400', 1, '126.74624', '42.97206');
INSERT INTO `shop_truck_region` VALUES (605, 597, 'S', '舒兰', '舒兰市', 3, 'shulan', '132600', 1, '126.9653', '44.40582');
INSERT INTO `shop_truck_region` VALUES (606, 597, 'P', '磐石', '磐石市', 3, 'panshi', '132300', 1, '126.0625', '42.94628');
INSERT INTO `shop_truck_region` VALUES (607, 585, 'S', '四平', '四平市', 2, 'siping', '136000', 1, '124.370785', '43.170344');
INSERT INTO `shop_truck_region` VALUES (608, 607, 'T', '铁西', '铁西区', 3, 'tiexi', '136000', 1, '124.37369', '43.17456');
INSERT INTO `shop_truck_region` VALUES (609, 607, 'T', '铁东', '铁东区', 3, 'tiedong', '136001', 1, '124.40976', '43.16241');
INSERT INTO `shop_truck_region` VALUES (610, 607, 'L', '梨树', '梨树县', 3, 'lishu', '136500', 1, '124.33563', '43.30717');
INSERT INTO `shop_truck_region` VALUES (611, 607, 'Y', '伊通', '伊通满族自治县', 3, 'yitong', '130700', 1, '125.30596', '43.34434');
INSERT INTO `shop_truck_region` VALUES (612, 607, 'G', '公主岭', '公主岭市', 3, 'gongzhuling', '136100', 1, '124.82266', '43.50453');
INSERT INTO `shop_truck_region` VALUES (613, 607, 'S', '双辽', '双辽市', 3, 'shuangliao', '136400', 1, '123.50106', '43.52099');
INSERT INTO `shop_truck_region` VALUES (614, 585, 'L', '辽源', '辽源市', 2, 'liaoyuan', '136200', 1, '125.145349', '42.902692');
INSERT INTO `shop_truck_region` VALUES (615, 614, 'L', '龙山', '龙山区', 3, 'longshan', '136200', 1, '125.13641', '42.89714');
INSERT INTO `shop_truck_region` VALUES (616, 614, 'X', '西安', '西安区', 3, 'xian', '136201', 1, '125.14904', '42.927');
INSERT INTO `shop_truck_region` VALUES (617, 614, 'D', '东丰', '东丰县', 3, 'dongfeng', '136300', 1, '125.53244', '42.6783');
INSERT INTO `shop_truck_region` VALUES (618, 614, 'D', '东辽', '东辽县', 3, 'dongliao', '136600', 1, '124.98596', '42.92492');
INSERT INTO `shop_truck_region` VALUES (619, 585, 'T', '通化', '通化市', 2, 'tonghua', '134001', 1, '125.936501', '41.721177');
INSERT INTO `shop_truck_region` VALUES (620, 619, 'D', '东昌', '东昌区', 3, 'dongchang', '134001', 1, '125.9551', '41.72849');
INSERT INTO `shop_truck_region` VALUES (621, 619, 'E', '二道江', '二道江区', 3, 'erdaojiang', '134003', 1, '126.04257', '41.7741');
INSERT INTO `shop_truck_region` VALUES (622, 619, 'T', '通化', '通化县', 3, 'tonghua', '134100', 1, '125.75936', '41.67928');
INSERT INTO `shop_truck_region` VALUES (623, 619, 'H', '辉南', '辉南县', 3, 'huinan', '135100', 1, '126.04684', '42.68497');
INSERT INTO `shop_truck_region` VALUES (624, 619, 'L', '柳河', '柳河县', 3, 'liuhe', '135300', 1, '125.74475', '42.28468');
INSERT INTO `shop_truck_region` VALUES (625, 619, 'M', '梅河口', '梅河口市', 3, 'meihekou', '135000', 1, '125.71041', '42.53828');
INSERT INTO `shop_truck_region` VALUES (626, 619, 'J', '集安', '集安市', 3, 'jian', '134200', 1, '126.18829', '41.12268');
INSERT INTO `shop_truck_region` VALUES (627, 585, 'B', '白山', '白山市', 2, 'baishan', '134300', 1, '126.427839', '41.942505');
INSERT INTO `shop_truck_region` VALUES (628, 627, 'H', '浑江', '浑江区', 3, 'hunjiang', '134300', 1, '126.422342', '41.945656');
INSERT INTO `shop_truck_region` VALUES (629, 627, 'J', '江源', '江源区', 3, 'jiangyuan', '134700', 1, '126.59079', '42.05664');
INSERT INTO `shop_truck_region` VALUES (630, 627, 'F', '抚松', '抚松县', 3, 'fusong', '134500', 1, '127.2803', '42.34198');
INSERT INTO `shop_truck_region` VALUES (631, 627, 'J', '靖宇', '靖宇县', 3, 'jingyu', '135200', 1, '126.81308', '42.38863');
INSERT INTO `shop_truck_region` VALUES (632, 627, 'C', '长白', '长白朝鲜族自治县', 3, 'changbai', '134400', 1, '128.20047', '41.41996');
INSERT INTO `shop_truck_region` VALUES (633, 627, 'L', '临江', '临江市', 3, 'linjiang', '134600', 1, '126.91751', '41.81142');
INSERT INTO `shop_truck_region` VALUES (634, 585, 'S', '松原', '松原市', 2, 'songyuan', '138000', 1, '124.823608', '45.118243');
INSERT INTO `shop_truck_region` VALUES (635, 634, 'N', '宁江', '宁江区', 3, 'ningjiang', '138000', 1, '124.81689', '45.17175');
INSERT INTO `shop_truck_region` VALUES (636, 634, 'Q', '前郭尔罗斯', '前郭尔罗斯蒙古族自治县', 3, 'qianguoerluosi', '138000', 1, '124.82351', '45.11726');
INSERT INTO `shop_truck_region` VALUES (637, 634, 'C', '长岭', '长岭县', 3, 'changling', '131500', 1, '123.96725', '44.27581');
INSERT INTO `shop_truck_region` VALUES (638, 634, 'Q', '乾安', '乾安县', 3, 'qianan', '131400', 1, '124.02737', '45.01068');
INSERT INTO `shop_truck_region` VALUES (639, 634, 'F', '扶余', '扶余市', 3, 'fuyu', '131200', 1, '126.042758', '44.986199');
INSERT INTO `shop_truck_region` VALUES (640, 585, 'B', '白城', '白城市', 2, 'baicheng', '137000', 1, '122.841114', '45.619026');
INSERT INTO `shop_truck_region` VALUES (641, 640, NULL, '洮北', '洮北区', 3, 'taobei', '137000', 1, '122.85104', '45.62167');
INSERT INTO `shop_truck_region` VALUES (642, 640, 'Z', '镇赉', '镇赉县', 3, 'zhenlai', '137300', 1, '123.19924', '45.84779');
INSERT INTO `shop_truck_region` VALUES (643, 640, 'T', '通榆', '通榆县', 3, 'tongyu', '137200', 1, '123.08761', '44.81388');
INSERT INTO `shop_truck_region` VALUES (644, 640, NULL, '洮南', '洮南市', 3, 'taonan', '137100', 1, '122.78772', '45.33502');
INSERT INTO `shop_truck_region` VALUES (645, 640, 'D', '大安', '大安市', 3, 'daan', '131300', 1, '124.29519', '45.50846');
INSERT INTO `shop_truck_region` VALUES (646, 585, 'Y', '延边', '延边朝鲜族自治州', 2, 'yanbian', '133000', 1, '129.513228', '42.904823');
INSERT INTO `shop_truck_region` VALUES (647, 646, 'Y', '延吉', '延吉市', 3, 'yanji', '133000', 1, '129.51357', '42.90682');
INSERT INTO `shop_truck_region` VALUES (648, 646, 'T', '图们', '图们市', 3, 'tumen', '133100', 1, '129.84381', '42.96801');
INSERT INTO `shop_truck_region` VALUES (649, 646, 'D', '敦化', '敦化市', 3, 'dunhua', '133700', 1, '128.23242', '43.37304');
INSERT INTO `shop_truck_region` VALUES (650, 646, NULL, '珲春', '珲春市', 3, 'hunchun', '133300', 1, '130.36572', '42.86242');
INSERT INTO `shop_truck_region` VALUES (651, 646, 'L', '龙井', '龙井市', 3, 'longjing', '133400', 1, '129.42584', '42.76804');
INSERT INTO `shop_truck_region` VALUES (652, 646, 'H', '和龙', '和龙市', 3, 'helong', '133500', 1, '129.01077', '42.5464');
INSERT INTO `shop_truck_region` VALUES (653, 646, 'W', '汪清', '汪清县', 3, 'wangqing', '133200', 1, '129.77121', '43.31278');
INSERT INTO `shop_truck_region` VALUES (654, 646, 'A', '安图', '安图县', 3, 'antu', '133600', 1, '128.90625', '43.11533');
INSERT INTO `shop_truck_region` VALUES (655, 0, 'H', '黑龙江', '黑龙江省', 1, 'heilongjiang', '', 1, '126.642464', '45.756967');
INSERT INTO `shop_truck_region` VALUES (656, 655, 'H', '哈尔滨', '哈尔滨市', 2, 'harbin', '150010', 1, '126.642464', '45.756967');
INSERT INTO `shop_truck_region` VALUES (657, 656, 'D', '道里', '道里区', 3, 'daoli', '150010', 1, '126.61705', '45.75586');
INSERT INTO `shop_truck_region` VALUES (658, 656, 'N', '南岗', '南岗区', 3, 'nangang', '150006', 1, '126.66854', '45.75996');
INSERT INTO `shop_truck_region` VALUES (659, 656, 'D', '道外', '道外区', 3, 'daowai', '150020', 1, '126.64938', '45.79187');
INSERT INTO `shop_truck_region` VALUES (660, 656, 'P', '平房', '平房区', 3, 'pingfang', '150060', 1, '126.63729', '45.59777');
INSERT INTO `shop_truck_region` VALUES (661, 656, 'S', '松北', '松北区', 3, 'songbei', '150028', 1, '126.56276', '45.80831');
INSERT INTO `shop_truck_region` VALUES (662, 656, 'X', '香坊', '香坊区', 3, 'xiangfang', '150036', 1, '126.67968', '45.72383');
INSERT INTO `shop_truck_region` VALUES (663, 656, 'H', '呼兰', '呼兰区', 3, 'hulan', '150500', 1, '126.58792', '45.88895');
INSERT INTO `shop_truck_region` VALUES (664, 656, 'A', '阿城', '阿城区', 3, 'acheng', '150300', 1, '126.97525', '45.54144');
INSERT INTO `shop_truck_region` VALUES (665, 656, 'S', '双城', '双城区', 3, 'shuangcheng', '150100', 1, '126.308784', '45.377942');
INSERT INTO `shop_truck_region` VALUES (666, 656, 'Y', '依兰', '依兰县', 3, 'yilan', '154800', 1, '129.56817', '46.3247');
INSERT INTO `shop_truck_region` VALUES (667, 656, 'F', '方正', '方正县', 3, 'fangzheng', '150800', 1, '128.82952', '45.85162');
INSERT INTO `shop_truck_region` VALUES (668, 656, 'B', '宾县', '宾县', 3, 'binxian', '150400', 1, '127.48675', '45.75504');
INSERT INTO `shop_truck_region` VALUES (669, 656, 'B', '巴彦', '巴彦县', 3, 'bayan', '151800', 1, '127.40799', '46.08148');
INSERT INTO `shop_truck_region` VALUES (670, 656, 'M', '木兰', '木兰县', 3, 'mulan', '151900', 1, '128.0448', '45.94944');
INSERT INTO `shop_truck_region` VALUES (671, 656, 'T', '通河', '通河县', 3, 'tonghe', '150900', 1, '128.74603', '45.99007');
INSERT INTO `shop_truck_region` VALUES (672, 656, 'Y', '延寿', '延寿县', 3, 'yanshou', '150700', 1, '128.33419', '45.4554');
INSERT INTO `shop_truck_region` VALUES (673, 656, 'S', '尚志', '尚志市', 3, 'shangzhi', '150600', 1, '127.96191', '45.21736');
INSERT INTO `shop_truck_region` VALUES (674, 656, 'W', '五常', '五常市', 3, 'wuchang', '150200', 1, '127.16751', '44.93184');
INSERT INTO `shop_truck_region` VALUES (675, 655, 'Q', '齐齐哈尔', '齐齐哈尔市', 2, 'qiqihar', '161005', 1, '123.953486', '47.348079');
INSERT INTO `shop_truck_region` VALUES (676, 675, 'L', '龙沙', '龙沙区', 3, 'longsha', '161000', 1, '123.95752', '47.31776');
INSERT INTO `shop_truck_region` VALUES (677, 675, 'J', '建华', '建华区', 3, 'jianhua', '161006', 1, '124.0133', '47.36718');
INSERT INTO `shop_truck_region` VALUES (678, 675, 'T', '铁锋', '铁锋区', 3, 'tiefeng', '161000', 1, '123.97821', '47.34075');
INSERT INTO `shop_truck_region` VALUES (679, 675, 'A', '昂昂溪', '昂昂溪区', 3, 'angangxi', '161031', 1, '123.82229', '47.15513');
INSERT INTO `shop_truck_region` VALUES (680, 675, 'F', '富拉尔基', '富拉尔基区', 3, 'fulaerji', '161041', 1, '123.62918', '47.20884');
INSERT INTO `shop_truck_region` VALUES (681, 675, 'N', '碾子山', '碾子山区', 3, 'nianzishan', '161046', 1, '122.88183', '47.51662');
INSERT INTO `shop_truck_region` VALUES (682, 675, 'M', '梅里斯', '梅里斯达斡尔族区', 3, 'meilisi', '161021', 1, '123.75274', '47.30946');
INSERT INTO `shop_truck_region` VALUES (683, 675, 'L', '龙江', '龙江县', 3, 'longjiang', '161100', 1, '123.20532', '47.33868');
INSERT INTO `shop_truck_region` VALUES (684, 675, 'Y', '依安', '依安县', 3, 'yian', '161500', 1, '125.30896', '47.8931');
INSERT INTO `shop_truck_region` VALUES (685, 675, 'T', '泰来', '泰来县', 3, 'tailai', '162400', 1, '123.42285', '46.39386');
INSERT INTO `shop_truck_region` VALUES (686, 675, 'G', '甘南', '甘南县', 3, 'gannan', '162100', 1, '123.50317', '47.92437');
INSERT INTO `shop_truck_region` VALUES (687, 675, 'F', '富裕', '富裕县', 3, 'fuyu', '161200', 1, '124.47457', '47.77431');
INSERT INTO `shop_truck_region` VALUES (688, 675, 'K', '克山', '克山县', 3, 'keshan', '161600', 1, '125.87396', '48.03265');
INSERT INTO `shop_truck_region` VALUES (689, 675, 'K', '克东', '克东县', 3, 'kedong', '164800', 1, '126.24917', '48.03828');
INSERT INTO `shop_truck_region` VALUES (690, 675, 'B', '拜泉', '拜泉县', 3, 'baiquan', '164700', 1, '126.09167', '47.60817');
INSERT INTO `shop_truck_region` VALUES (691, 675, NULL, '讷河', '讷河市', 3, 'nehe', '161300', 1, '124.87713', '48.48388');
INSERT INTO `shop_truck_region` VALUES (692, 655, 'J', '鸡西', '鸡西市', 2, 'jixi', '158100', 1, '130.975966', '45.300046');
INSERT INTO `shop_truck_region` VALUES (693, 692, 'J', '鸡冠', '鸡冠区', 3, 'jiguan', '158100', 1, '130.98139', '45.30396');
INSERT INTO `shop_truck_region` VALUES (694, 692, 'H', '恒山', '恒山区', 3, 'hengshan', '158130', 1, '130.90493', '45.21071');
INSERT INTO `shop_truck_region` VALUES (695, 692, 'D', '滴道', '滴道区', 3, 'didao', '158150', 1, '130.84841', '45.35109');
INSERT INTO `shop_truck_region` VALUES (696, 692, 'L', '梨树', '梨树区', 3, 'lishu', '158160', 1, '130.69848', '45.09037');
INSERT INTO `shop_truck_region` VALUES (697, 692, 'C', '城子河', '城子河区', 3, 'chengzihe', '158170', 1, '131.01132', '45.33689');
INSERT INTO `shop_truck_region` VALUES (698, 692, 'M', '麻山', '麻山区', 3, 'mashan', '158180', 1, '130.47811', '45.21209');
INSERT INTO `shop_truck_region` VALUES (699, 692, 'J', '鸡东', '鸡东县', 3, 'jidong', '158200', 1, '131.12423', '45.26025');
INSERT INTO `shop_truck_region` VALUES (700, 692, 'H', '虎林', '虎林市', 3, 'hulin', '158400', 1, '132.93679', '45.76291');
INSERT INTO `shop_truck_region` VALUES (701, 692, 'M', '密山', '密山市', 3, 'mishan', '158300', 1, '131.84625', '45.5297');
INSERT INTO `shop_truck_region` VALUES (702, 655, 'H', '鹤岗', '鹤岗市', 2, 'hegang', '154100', 1, '130.277487', '47.332085');
INSERT INTO `shop_truck_region` VALUES (703, 702, 'X', '向阳', '向阳区', 3, 'xiangyang', '154100', 1, '130.2943', '47.34247');
INSERT INTO `shop_truck_region` VALUES (704, 702, 'G', '工农', '工农区', 3, 'gongnong', '154101', 1, '130.27468', '47.31869');
INSERT INTO `shop_truck_region` VALUES (705, 702, 'N', '南山', '南山区', 3, 'nanshan', '154104', 1, '130.27676', '47.31404');
INSERT INTO `shop_truck_region` VALUES (706, 702, 'X', '兴安', '兴安区', 3, 'xingan', '154102', 1, '130.23965', '47.2526');
INSERT INTO `shop_truck_region` VALUES (707, 702, 'D', '东山', '东山区', 3, 'dongshan', '154106', 1, '130.31706', '47.33853');
INSERT INTO `shop_truck_region` VALUES (708, 702, 'X', '兴山', '兴山区', 3, 'xingshan', '154105', 1, '130.29271', '47.35776');
INSERT INTO `shop_truck_region` VALUES (709, 702, 'L', '萝北', '萝北县', 3, 'luobei', '154200', 1, '130.83346', '47.57959');
INSERT INTO `shop_truck_region` VALUES (710, 702, 'S', '绥滨', '绥滨县', 3, 'suibin', '156200', 1, '131.86029', '47.2903');
INSERT INTO `shop_truck_region` VALUES (711, 655, 'S', '双鸭山', '双鸭山市', 2, 'shuangyashan', '155100', 1, '131.157304', '46.643442');
INSERT INTO `shop_truck_region` VALUES (712, 711, 'J', '尖山', '尖山区', 3, 'jianshan', '155100', 1, '131.15841', '46.64635');
INSERT INTO `shop_truck_region` VALUES (713, 711, 'L', '岭东', '岭东区', 3, 'lingdong', '155120', 1, '131.16473', '46.59043');
INSERT INTO `shop_truck_region` VALUES (714, 711, 'S', '四方台', '四方台区', 3, 'sifangtai', '155130', 1, '131.33593', '46.59499');
INSERT INTO `shop_truck_region` VALUES (715, 711, 'B', '宝山', '宝山区', 3, 'baoshan', '155131', 1, '131.4016', '46.57718');
INSERT INTO `shop_truck_region` VALUES (716, 711, 'J', '集贤', '集贤县', 3, 'jixian', '155900', 1, '131.14053', '46.72678');
INSERT INTO `shop_truck_region` VALUES (717, 711, 'Y', '友谊', '友谊县', 3, 'youyi', '155800', 1, '131.80789', '46.76739');
INSERT INTO `shop_truck_region` VALUES (718, 711, 'B', '宝清', '宝清县', 3, 'baoqing', '155600', 1, '132.19695', '46.32716');
INSERT INTO `shop_truck_region` VALUES (719, 711, 'R', '饶河', '饶河县', 3, 'raohe', '155700', 1, '134.01986', '46.79899');
INSERT INTO `shop_truck_region` VALUES (720, 655, 'D', '大庆', '大庆市', 2, 'daqing', '163000', 1, '125.11272', '46.590734');
INSERT INTO `shop_truck_region` VALUES (721, 720, 'S', '萨尔图', '萨尔图区', 3, 'saertu', '163001', 1, '125.08792', '46.59359');
INSERT INTO `shop_truck_region` VALUES (722, 720, 'L', '龙凤', '龙凤区', 3, 'longfeng', '163711', 1, '125.11657', '46.53273');
INSERT INTO `shop_truck_region` VALUES (723, 720, 'R', '让胡路', '让胡路区', 3, 'ranghulu', '163712', 1, '124.87075', '46.6522');
INSERT INTO `shop_truck_region` VALUES (724, 720, 'H', '红岗', '红岗区', 3, 'honggang', '163511', 1, '124.89248', '46.40128');
INSERT INTO `shop_truck_region` VALUES (725, 720, 'D', '大同', '大同区', 3, 'datong', '163515', 1, '124.81591', '46.03295');
INSERT INTO `shop_truck_region` VALUES (726, 720, 'Z', '肇州', '肇州县', 3, 'zhaozhou', '166400', 1, '125.27059', '45.70414');
INSERT INTO `shop_truck_region` VALUES (727, 720, 'Z', '肇源', '肇源县', 3, 'zhaoyuan', '166500', 1, '125.08456', '45.52032');
INSERT INTO `shop_truck_region` VALUES (728, 720, 'L', '林甸', '林甸县', 3, 'lindian', '166300', 1, '124.87564', '47.18601');
INSERT INTO `shop_truck_region` VALUES (729, 720, 'D', '杜尔伯特', '杜尔伯特蒙古族自治县', 3, 'duerbote', '166200', 1, '124.44937', '46.86507');
INSERT INTO `shop_truck_region` VALUES (730, 655, 'Y', '伊春', '伊春市', 2, 'yichun', '153000', 1, '128.899396', '47.724775');
INSERT INTO `shop_truck_region` VALUES (731, 730, 'Y', '伊春', '伊春区', 3, 'yichun', '153000', 1, '128.90752', '47.728');
INSERT INTO `shop_truck_region` VALUES (732, 730, 'N', '南岔', '南岔区', 3, 'nancha', '153100', 1, '129.28362', '47.13897');
INSERT INTO `shop_truck_region` VALUES (733, 730, 'Y', '友好', '友好区', 3, 'youhao', '153031', 1, '128.84039', '47.85371');
INSERT INTO `shop_truck_region` VALUES (734, 730, 'X', '西林', '西林区', 3, 'xilin', '153025', 1, '129.31201', '47.48103');
INSERT INTO `shop_truck_region` VALUES (735, 730, 'C', '翠峦', '翠峦区', 3, 'cuiluan', '153013', 1, '128.66729', '47.72503');
INSERT INTO `shop_truck_region` VALUES (736, 730, 'X', '新青', '新青区', 3, 'xinqing', '153036', 1, '129.53653', '48.29067');
INSERT INTO `shop_truck_region` VALUES (737, 730, 'M', '美溪', '美溪区', 3, 'meixi', '153021', 1, '129.13708', '47.63513');
INSERT INTO `shop_truck_region` VALUES (738, 730, 'J', '金山屯', '金山屯区', 3, 'jinshantun', '153026', 1, '129.43768', '47.41349');
INSERT INTO `shop_truck_region` VALUES (739, 730, 'W', '五营', '五营区', 3, 'wuying', '153033', 1, '129.24545', '48.10791');
INSERT INTO `shop_truck_region` VALUES (740, 730, 'W', '乌马河', '乌马河区', 3, 'wumahe', '153011', 1, '128.79672', '47.728');
INSERT INTO `shop_truck_region` VALUES (741, 730, 'T', '汤旺河', '汤旺河区', 3, 'tangwanghe', '153037', 1, '129.57226', '48.45182');
INSERT INTO `shop_truck_region` VALUES (742, 730, 'D', '带岭', '带岭区', 3, 'dailing', '153106', 1, '129.02352', '47.02553');
INSERT INTO `shop_truck_region` VALUES (743, 730, 'W', '乌伊岭', '乌伊岭区', 3, 'wuyiling', '153038', 1, '129.43981', '48.59602');
INSERT INTO `shop_truck_region` VALUES (744, 730, 'H', '红星', '红星区', 3, 'hongxing', '153035', 1, '129.3887', '48.23944');
INSERT INTO `shop_truck_region` VALUES (745, 730, 'S', '上甘岭', '上甘岭区', 3, 'shangganling', '153032', 1, '129.02447', '47.97522');
INSERT INTO `shop_truck_region` VALUES (746, 730, 'J', '嘉荫', '嘉荫县', 3, 'jiayin', '153200', 1, '130.39825', '48.8917');
INSERT INTO `shop_truck_region` VALUES (747, 730, 'T', '铁力', '铁力市', 3, 'tieli', '152500', 1, '128.0317', '46.98571');
INSERT INTO `shop_truck_region` VALUES (748, 655, 'J', '佳木斯', '佳木斯市', 2, 'jiamusi', '154002', 1, '130.361634', '46.809606');
INSERT INTO `shop_truck_region` VALUES (749, 748, 'X', '向阳', '向阳区', 3, 'xiangyang', '154002', 1, '130.36519', '46.80778');
INSERT INTO `shop_truck_region` VALUES (750, 748, 'Q', '前进', '前进区', 3, 'qianjin', '154002', 1, '130.37497', '46.81401');
INSERT INTO `shop_truck_region` VALUES (751, 748, 'D', '东风', '东风区', 3, 'dongfeng', '154005', 1, '130.40366', '46.82257');
INSERT INTO `shop_truck_region` VALUES (752, 748, 'J', '郊区', '郊区', 3, 'jiaoqu', '154004', 1, '130.32731', '46.80958');
INSERT INTO `shop_truck_region` VALUES (753, 748, NULL, '桦南', '桦南县', 3, 'huanan', '154400', 1, '130.55361', '46.23921');
INSERT INTO `shop_truck_region` VALUES (754, 748, NULL, '桦川', '桦川县', 3, 'huachuan', '154300', 1, '130.71893', '47.02297');
INSERT INTO `shop_truck_region` VALUES (755, 748, 'T', '汤原', '汤原县', 3, 'tangyuan', '154700', 1, '129.90966', '46.72755');
INSERT INTO `shop_truck_region` VALUES (756, 748, 'F', '抚远', '抚远县', 3, 'fuyuan', '156500', 1, '134.29595', '48.36794');
INSERT INTO `shop_truck_region` VALUES (757, 748, 'T', '同江', '同江市', 3, 'tongjiang', '156400', 1, '132.51095', '47.64211');
INSERT INTO `shop_truck_region` VALUES (758, 748, 'F', '富锦', '富锦市', 3, 'fujin', '156100', 1, '132.03707', '47.25132');
INSERT INTO `shop_truck_region` VALUES (759, 655, 'Q', '七台河', '七台河市', 2, 'qitaihe', '154600', 1, '131.015584', '45.771266');
INSERT INTO `shop_truck_region` VALUES (760, 759, 'X', '新兴', '新兴区', 3, 'xinxing', '154604', 1, '130.93212', '45.81624');
INSERT INTO `shop_truck_region` VALUES (761, 759, 'T', '桃山', '桃山区', 3, 'taoshan', '154600', 1, '131.01786', '45.76782');
INSERT INTO `shop_truck_region` VALUES (762, 759, 'Q', '茄子河', '茄子河区', 3, 'qiezihe', '154622', 1, '131.06807', '45.78519');
INSERT INTO `shop_truck_region` VALUES (763, 759, 'B', '勃利', '勃利县', 3, 'boli', '154500', 1, '130.59179', '45.755');
INSERT INTO `shop_truck_region` VALUES (764, 655, 'M', '牡丹江', '牡丹江市', 2, 'mudanjiang', '157000', 1, '129.618602', '44.582962');
INSERT INTO `shop_truck_region` VALUES (765, 764, 'D', '东安', '东安区', 3, 'dongan', '157000', 1, '129.62665', '44.58133');
INSERT INTO `shop_truck_region` VALUES (766, 764, 'Y', '阳明', '阳明区', 3, 'yangming', '157013', 1, '129.63547', '44.59603');
INSERT INTO `shop_truck_region` VALUES (767, 764, 'A', '爱民', '爱民区', 3, 'aimin', '157009', 1, '129.59077', '44.59648');
INSERT INTO `shop_truck_region` VALUES (768, 764, 'X', '西安', '西安区', 3, 'xian', '157000', 1, '129.61616', '44.57766');
INSERT INTO `shop_truck_region` VALUES (769, 764, 'D', '东宁', '东宁县', 3, 'dongning', '157200', 1, '131.12793', '44.0661');
INSERT INTO `shop_truck_region` VALUES (770, 764, 'L', '林口', '林口县', 3, 'linkou', '157600', 1, '130.28393', '45.27809');
INSERT INTO `shop_truck_region` VALUES (771, 764, 'S', '绥芬河', '绥芬河市', 3, 'suifenhe', '157300', 1, '131.15139', '44.41249');
INSERT INTO `shop_truck_region` VALUES (772, 764, 'H', '海林', '海林市', 3, 'hailin', '157100', 1, '129.38156', '44.59');
INSERT INTO `shop_truck_region` VALUES (773, 764, 'N', '宁安', '宁安市', 3, 'ningan', '157400', 1, '129.48303', '44.34016');
INSERT INTO `shop_truck_region` VALUES (774, 764, 'M', '穆棱', '穆棱市', 3, 'muling', '157500', 1, '130.52465', '44.919');
INSERT INTO `shop_truck_region` VALUES (775, 655, 'H', '黑河', '黑河市', 2, 'heihe', '164300', 1, '127.499023', '50.249585');
INSERT INTO `shop_truck_region` VALUES (776, 775, 'A', '爱辉', '爱辉区', 3, 'aihui', '164300', 1, '127.50074', '50.25202');
INSERT INTO `shop_truck_region` VALUES (777, 775, 'N', '嫩江', '嫩江县', 3, 'nenjiang', '161400', 1, '125.22607', '49.17844');
INSERT INTO `shop_truck_region` VALUES (778, 775, 'X', '逊克', '逊克县', 3, 'xunke', '164400', 1, '128.47882', '49.57983');
INSERT INTO `shop_truck_region` VALUES (779, 775, 'S', '孙吴', '孙吴县', 3, 'sunwu', '164200', 1, '127.33599', '49.42539');
INSERT INTO `shop_truck_region` VALUES (780, 775, 'B', '北安', '北安市', 3, 'beian', '164000', 1, '126.48193', '48.23872');
INSERT INTO `shop_truck_region` VALUES (781, 775, 'W', '五大连池', '五大连池市', 3, 'wudalianchi', '164100', 1, '126.20294', '48.51507');
INSERT INTO `shop_truck_region` VALUES (782, 655, 'S', '绥化', '绥化市', 2, 'suihua', '152000', 1, '126.99293', '46.637393');
INSERT INTO `shop_truck_region` VALUES (783, 782, 'B', '北林', '北林区', 3, 'beilin', '152000', 1, '126.98564', '46.63735');
INSERT INTO `shop_truck_region` VALUES (784, 782, 'W', '望奎', '望奎县', 3, 'wangkui', '152100', 1, '126.48187', '46.83079');
INSERT INTO `shop_truck_region` VALUES (785, 782, 'L', '兰西', '兰西县', 3, 'lanxi', '151500', 1, '126.28994', '46.2525');
INSERT INTO `shop_truck_region` VALUES (786, 782, 'Q', '青冈', '青冈县', 3, 'qinggang', '151600', 1, '126.11325', '46.68534');
INSERT INTO `shop_truck_region` VALUES (787, 782, 'Q', '庆安', '庆安县', 3, 'qingan', '152400', 1, '127.50753', '46.88016');
INSERT INTO `shop_truck_region` VALUES (788, 782, 'M', '明水', '明水县', 3, 'mingshui', '151700', 1, '125.90594', '47.17327');
INSERT INTO `shop_truck_region` VALUES (789, 782, 'S', '绥棱', '绥棱县', 3, 'suileng', '152200', 1, '127.11584', '47.24267');
INSERT INTO `shop_truck_region` VALUES (790, 782, 'A', '安达', '安达市', 3, 'anda', '151400', 1, '125.34375', '46.4177');
INSERT INTO `shop_truck_region` VALUES (791, 782, 'Z', '肇东', '肇东市', 3, 'zhaodong', '151100', 1, '125.96243', '46.05131');
INSERT INTO `shop_truck_region` VALUES (792, 782, 'H', '海伦', '海伦市', 3, 'hailun', '152300', 1, '126.9682', '47.46093');
INSERT INTO `shop_truck_region` VALUES (793, 655, 'D', '大兴安岭', '大兴安岭地区', 2, 'daxinganling', '165000', 1, '124.711526', '52.335262');
INSERT INTO `shop_truck_region` VALUES (794, 793, 'J', '加格达奇', '加格达奇区', 3, 'jiagedaqi', '165000', 1, '124.30954', '51.98144');
INSERT INTO `shop_truck_region` VALUES (795, 793, 'X', '新林', '新林区', 3, 'xinlin', '165000', 1, '124.397983', '51.67341');
INSERT INTO `shop_truck_region` VALUES (796, 793, 'S', '松岭', '松岭区', 3, 'songling', '165000', 1, '124.189713', '51.985453');
INSERT INTO `shop_truck_region` VALUES (797, 793, 'H', '呼中', '呼中区', 3, 'huzhong', '165000', 1, '123.60009', '52.03346');
INSERT INTO `shop_truck_region` VALUES (798, 793, 'H', '呼玛', '呼玛县', 3, 'huma', '165100', 1, '126.66174', '51.73112');
INSERT INTO `shop_truck_region` VALUES (799, 793, 'T', '塔河', '塔河县', 3, 'tahe', '165200', 1, '124.70999', '52.33431');
INSERT INTO `shop_truck_region` VALUES (800, 793, 'M', '漠河', '漠河县', 3, 'mohe', '165300', 1, '122.53759', '52.97003');
INSERT INTO `shop_truck_region` VALUES (801, 0, 'S', '上海', '上海市', 1, 'shanghai', '', 1, '121.472644', '31.231706');
INSERT INTO `shop_truck_region` VALUES (802, 801, 'S', '上海', '上海市', 2, 'shanghai', '200000', 1, '121.472644', '31.231706');
INSERT INTO `shop_truck_region` VALUES (803, 802, 'H', '黄浦', '黄浦区', 3, 'huangpu', '200001', 1, '121.49295', '31.22337');
INSERT INTO `shop_truck_region` VALUES (804, 802, 'X', '徐汇', '徐汇区', 3, 'xuhui', '200030', 1, '121.43676', '31.18831');
INSERT INTO `shop_truck_region` VALUES (805, 802, 'C', '长宁', '长宁区', 3, 'changning', '200050', 1, '121.42462', '31.22036');
INSERT INTO `shop_truck_region` VALUES (806, 802, 'J', '静安', '静安区', 3, 'jingan', '200040', 1, '121.4444', '31.22884');
INSERT INTO `shop_truck_region` VALUES (807, 802, 'P', '普陀', '普陀区', 3, 'putuo', '200333', 1, '121.39703', '31.24951');
INSERT INTO `shop_truck_region` VALUES (808, 802, 'Z', '闸北', '闸北区', 3, 'zhabei', '200070', 1, '121.44636', '31.28075');
INSERT INTO `shop_truck_region` VALUES (809, 802, 'H', '虹口', '虹口区', 3, 'hongkou', '200086', 1, '121.48162', '31.27788');
INSERT INTO `shop_truck_region` VALUES (810, 802, 'Y', '杨浦', '杨浦区', 3, 'yangpu', '200082', 1, '121.526', '31.2595');
INSERT INTO `shop_truck_region` VALUES (811, 802, NULL, '闵行', '闵行区', 3, 'minhang', '201100', 1, '121.38162', '31.11246');
INSERT INTO `shop_truck_region` VALUES (812, 802, 'B', '宝山', '宝山区', 3, 'baoshan', '201900', 1, '121.4891', '31.4045');
INSERT INTO `shop_truck_region` VALUES (813, 802, 'J', '嘉定', '嘉定区', 3, 'jiading', '201800', 1, '121.2655', '31.37473');
INSERT INTO `shop_truck_region` VALUES (814, 802, 'P', '浦东', '浦东新区', 3, 'pudong', '200135', 1, '121.5447', '31.22249');
INSERT INTO `shop_truck_region` VALUES (815, 802, 'J', '金山', '金山区', 3, 'jinshan', '200540', 1, '121.34164', '30.74163');
INSERT INTO `shop_truck_region` VALUES (816, 802, 'S', '松江', '松江区', 3, 'songjiang', '201600', 1, '121.22879', '31.03222');
INSERT INTO `shop_truck_region` VALUES (817, 802, 'Q', '青浦', '青浦区', 3, 'qingpu', '201700', 1, '121.12417', '31.14974');
INSERT INTO `shop_truck_region` VALUES (818, 802, 'F', '奉贤', '奉贤区', 3, 'fengxian', '201400', 1, '121.47412', '30.9179');
INSERT INTO `shop_truck_region` VALUES (819, 802, 'C', '崇明', '崇明县', 3, 'chongming', '202150', 1, '121.39758', '31.62278');
INSERT INTO `shop_truck_region` VALUES (820, 0, 'J', '江苏', '江苏省', 1, 'jiangsu', '', 1, '118.767413', '32.041544');
INSERT INTO `shop_truck_region` VALUES (821, 820, 'N', '南京', '南京市', 2, 'nanjing', '210008', 1, '118.767413', '32.041544');
INSERT INTO `shop_truck_region` VALUES (822, 821, 'X', '玄武', '玄武区', 3, 'xuanwu', '210018', 1, '118.79772', '32.04856');
INSERT INTO `shop_truck_region` VALUES (823, 821, 'Q', '秦淮', '秦淮区', 3, 'qinhuai', '210001', 1, '118.79815', '32.01112');
INSERT INTO `shop_truck_region` VALUES (824, 821, 'J', '建邺', '建邺区', 3, 'jianye', '210004', 1, '118.76641', '32.03096');
INSERT INTO `shop_truck_region` VALUES (825, 821, 'G', '鼓楼', '鼓楼区', 3, 'gulou', '210009', 1, '118.76974', '32.06632');
INSERT INTO `shop_truck_region` VALUES (826, 821, 'P', '浦口', '浦口区', 3, 'pukou', '211800', 1, '118.62802', '32.05881');
INSERT INTO `shop_truck_region` VALUES (827, 821, 'Q', '栖霞', '栖霞区', 3, 'qixia', '210046', 1, '118.88064', '32.11352');
INSERT INTO `shop_truck_region` VALUES (828, 821, 'Y', '雨花台', '雨花台区', 3, 'yuhuatai', '210012', 1, '118.7799', '31.99202');
INSERT INTO `shop_truck_region` VALUES (829, 821, 'J', '江宁', '江宁区', 3, 'jiangning', '211100', 1, '118.8399', '31.95263');
INSERT INTO `shop_truck_region` VALUES (830, 821, 'L', '六合', '六合区', 3, 'luhe', '211500', 1, '118.8413', '32.34222');
INSERT INTO `shop_truck_region` VALUES (831, 821, NULL, '溧水', '溧水区', 3, 'lishui', '211200', 1, '119.028732', '31.653061');
INSERT INTO `shop_truck_region` VALUES (832, 821, 'G', '高淳', '高淳区', 3, 'gaochun', '211300', 1, '118.87589', '31.327132');
INSERT INTO `shop_truck_region` VALUES (833, 820, 'W', '无锡', '无锡市', 2, 'wuxi', '214000', 1, '120.301663', '31.574729');
INSERT INTO `shop_truck_region` VALUES (834, 833, 'C', '崇安', '崇安区', 3, 'chongan', '214001', 1, '120.29975', '31.58002');
INSERT INTO `shop_truck_region` VALUES (835, 833, 'N', '南长', '南长区', 3, 'nanchang', '214021', 1, '120.30873', '31.56359');
INSERT INTO `shop_truck_region` VALUES (836, 833, 'B', '北塘', '北塘区', 3, 'beitang', '214044', 1, '120.29405', '31.60592');
INSERT INTO `shop_truck_region` VALUES (837, 833, 'X', '锡山', '锡山区', 3, 'xishan', '214101', 1, '120.35699', '31.5886');
INSERT INTO `shop_truck_region` VALUES (838, 833, 'H', '惠山', '惠山区', 3, 'huishan', '214174', 1, '120.29849', '31.68088');
INSERT INTO `shop_truck_region` VALUES (839, 833, 'B', '滨湖', '滨湖区', 3, 'binhu', '214123', 1, '120.29461', '31.52162');
INSERT INTO `shop_truck_region` VALUES (840, 833, 'J', '江阴', '江阴市', 3, 'jiangyin', '214431', 1, '120.2853', '31.91996');
INSERT INTO `shop_truck_region` VALUES (841, 833, 'Y', '宜兴', '宜兴市', 3, 'yixing', '214200', 1, '119.82357', '31.33978');
INSERT INTO `shop_truck_region` VALUES (842, 820, 'X', '徐州', '徐州市', 2, 'xuzhou', '221003', 1, '117.184811', '34.261792');
INSERT INTO `shop_truck_region` VALUES (843, 842, 'G', '鼓楼', '鼓楼区', 3, 'gulou', '221005', 1, '117.18559', '34.28851');
INSERT INTO `shop_truck_region` VALUES (844, 842, 'Y', '云龙', '云龙区', 3, 'yunlong', '221007', 1, '117.23053', '34.24895');
INSERT INTO `shop_truck_region` VALUES (845, 842, 'J', '贾汪', '贾汪区', 3, 'jiawang', '221003', 1, '117.45346', '34.44264');
INSERT INTO `shop_truck_region` VALUES (846, 842, 'Q', '泉山', '泉山区', 3, 'quanshan', '221006', 1, '117.19378', '34.24418');
INSERT INTO `shop_truck_region` VALUES (847, 842, 'T', '铜山', '铜山区', 3, 'tongshan', '221106', 1, '117.183894', '34.19288');
INSERT INTO `shop_truck_region` VALUES (848, 842, 'F', '丰县', '丰县', 3, 'fengxian', '221700', 1, '116.59957', '34.69972');
INSERT INTO `shop_truck_region` VALUES (849, 842, 'P', '沛县', '沛县', 3, 'peixian', '221600', 1, '116.93743', '34.72163');
INSERT INTO `shop_truck_region` VALUES (850, 842, NULL, '睢宁', '睢宁县', 3, 'suining', '221200', 1, '117.94104', '33.91269');
INSERT INTO `shop_truck_region` VALUES (851, 842, 'X', '新沂', '新沂市', 3, 'xinyi', '221400', 1, '118.35452', '34.36942');
INSERT INTO `shop_truck_region` VALUES (852, 842, NULL, '邳州', '邳州市', 3, 'pizhou', '221300', 1, '117.95858', '34.33329');
INSERT INTO `shop_truck_region` VALUES (853, 820, 'C', '常州', '常州市', 2, 'changzhou', '213000', 1, '119.946973', '31.772752');
INSERT INTO `shop_truck_region` VALUES (854, 853, 'T', '天宁', '天宁区', 3, 'tianning', '213000', 1, '119.95132', '31.75211');
INSERT INTO `shop_truck_region` VALUES (855, 853, 'Z', '钟楼', '钟楼区', 3, 'zhonglou', '213023', 1, '119.90178', '31.80221');
INSERT INTO `shop_truck_region` VALUES (856, 853, 'Q', '戚墅堰', '戚墅堰区', 3, 'qishuyan', '213025', 1, '120.06106', '31.71956');
INSERT INTO `shop_truck_region` VALUES (857, 853, 'X', '新北', '新北区', 3, 'xinbei', '213022', 1, '119.97131', '31.83046');
INSERT INTO `shop_truck_region` VALUES (858, 853, 'W', '武进', '武进区', 3, 'wujin', '213100', 1, '119.94244', '31.70086');
INSERT INTO `shop_truck_region` VALUES (859, 853, NULL, '溧阳', '溧阳市', 3, 'liyang', '213300', 1, '119.4837', '31.41538');
INSERT INTO `shop_truck_region` VALUES (860, 853, 'J', '金坛', '金坛市', 3, 'jintan', '213200', 1, '119.57757', '31.74043');
INSERT INTO `shop_truck_region` VALUES (861, 820, 'S', '苏州', '苏州市', 2, 'suzhou', '215002', 1, '120.619585', '31.299379');
INSERT INTO `shop_truck_region` VALUES (862, 861, 'H', '虎丘', '虎丘区', 3, 'huqiu', '215004', 1, '120.57345', '31.2953');
INSERT INTO `shop_truck_region` VALUES (863, 861, 'W', '吴中', '吴中区', 3, 'wuzhong', '215128', 1, '120.63211', '31.26226');
INSERT INTO `shop_truck_region` VALUES (864, 861, 'X', '相城', '相城区', 3, 'xiangcheng', '215131', 1, '120.64239', '31.36889');
INSERT INTO `shop_truck_region` VALUES (865, 861, 'G', '姑苏', '姑苏区', 3, 'gusu', '215031', 1, '120.619585', '31.299379');
INSERT INTO `shop_truck_region` VALUES (866, 861, 'W', '吴江', '吴江区', 3, 'wujiang', '215200', 1, '120.638317', '31.159815');
INSERT INTO `shop_truck_region` VALUES (867, 861, 'C', '常熟', '常熟市', 3, 'changshu', '215500', 1, '120.75225', '31.65374');
INSERT INTO `shop_truck_region` VALUES (868, 861, 'Z', '张家港', '张家港市', 3, 'zhangjiagang', '215600', 1, '120.55538', '31.87532');
INSERT INTO `shop_truck_region` VALUES (869, 861, 'K', '昆山', '昆山市', 3, 'kunshan', '215300', 1, '120.98074', '31.38464');
INSERT INTO `shop_truck_region` VALUES (870, 861, 'T', '太仓', '太仓市', 3, 'taicang', '215400', 1, '121.10891', '31.4497');
INSERT INTO `shop_truck_region` VALUES (871, 820, 'N', '南通', '南通市', 2, 'nantong', '226001', 1, '120.864608', '32.016212');
INSERT INTO `shop_truck_region` VALUES (872, 871, 'C', '崇川', '崇川区', 3, 'chongchuan', '226001', 1, '120.8573', '32.0098');
INSERT INTO `shop_truck_region` VALUES (873, 871, 'G', '港闸', '港闸区', 3, 'gangzha', '226001', 1, '120.81778', '32.03163');
INSERT INTO `shop_truck_region` VALUES (874, 871, 'T', '通州', '通州区', 3, 'tongzhou', '226300', 1, '121.07293', '32.0676');
INSERT INTO `shop_truck_region` VALUES (875, 871, 'H', '海安', '海安县', 3, 'haian', '226600', 1, '120.45852', '32.54514');
INSERT INTO `shop_truck_region` VALUES (876, 871, 'R', '如东', '如东县', 3, 'rudong', '226400', 1, '121.18942', '32.31439');
INSERT INTO `shop_truck_region` VALUES (877, 871, 'Q', '启东', '启东市', 3, 'qidong', '226200', 1, '121.65985', '31.81083');
INSERT INTO `shop_truck_region` VALUES (878, 871, 'R', '如皋', '如皋市', 3, 'rugao', '226500', 1, '120.55969', '32.37597');
INSERT INTO `shop_truck_region` VALUES (879, 871, 'H', '海门', '海门市', 3, 'haimen', '226100', 1, '121.16995', '31.89422');
INSERT INTO `shop_truck_region` VALUES (880, 820, 'L', '连云港', '连云港市', 2, 'lianyungang', '222002', 1, '119.178821', '34.600018');
INSERT INTO `shop_truck_region` VALUES (881, 880, 'L', '连云', '连云区', 3, 'lianyun', '222042', 1, '119.37304', '34.75293');
INSERT INTO `shop_truck_region` VALUES (882, 880, 'H', '海州', '海州区', 3, 'haizhou', '222003', 1, '119.13128', '34.56986');
INSERT INTO `shop_truck_region` VALUES (883, 880, 'G', '赣榆', '赣榆区', 3, 'ganyu', '222100', 1, '119.128774', '34.839154');
INSERT INTO `shop_truck_region` VALUES (884, 880, 'D', '东海', '东海县', 3, 'donghai', '222300', 1, '118.77145', '34.54215');
INSERT INTO `shop_truck_region` VALUES (885, 880, 'G', '灌云', '灌云县', 3, 'guanyun', '222200', 1, '119.23925', '34.28391');
INSERT INTO `shop_truck_region` VALUES (886, 880, 'G', '灌南', '灌南县', 3, 'guannan', '222500', 1, '119.35632', '34.09');
INSERT INTO `shop_truck_region` VALUES (887, 820, 'H', '淮安', '淮安市', 2, 'huaian', '223001', 1, '119.021265', '33.597506');
INSERT INTO `shop_truck_region` VALUES (888, 887, 'Q', '清河', '清河区', 3, 'qinghe', '223001', 1, '119.00778', '33.59949');
INSERT INTO `shop_truck_region` VALUES (889, 887, 'H', '淮安', '淮安区', 3, 'huaian', '223200', 1, '119.021265', '33.597506');
INSERT INTO `shop_truck_region` VALUES (890, 887, 'H', '淮阴', '淮阴区', 3, 'huaiyin', '223300', 1, '119.03485', '33.63171');
INSERT INTO `shop_truck_region` VALUES (891, 887, 'Q', '清浦', '清浦区', 3, 'qingpu', '223002', 1, '119.02648', '33.55232');
INSERT INTO `shop_truck_region` VALUES (892, 887, 'L', '涟水', '涟水县', 3, 'lianshui', '223400', 1, '119.26083', '33.78094');
INSERT INTO `shop_truck_region` VALUES (893, 887, 'H', '洪泽', '洪泽县', 3, 'hongze', '223100', 1, '118.87344', '33.29429');
INSERT INTO `shop_truck_region` VALUES (894, 887, 'X', '盱眙', '盱眙县', 3, 'xuyi', '211700', 1, '118.54495', '33.01086');
INSERT INTO `shop_truck_region` VALUES (895, 887, 'J', '金湖', '金湖县', 3, 'jinhu', '211600', 1, '119.02307', '33.02219');
INSERT INTO `shop_truck_region` VALUES (896, 820, 'Y', '盐城', '盐城市', 2, 'yancheng', '224005', 1, '120.139998', '33.377631');
INSERT INTO `shop_truck_region` VALUES (897, 896, 'T', '亭湖', '亭湖区', 3, 'tinghu', '224005', 1, '120.16583', '33.37825');
INSERT INTO `shop_truck_region` VALUES (898, 896, 'Y', '盐都', '盐都区', 3, 'yandu', '224055', 1, '120.15441', '33.3373');
INSERT INTO `shop_truck_region` VALUES (899, 896, 'X', '响水', '响水县', 3, 'xiangshui', '224600', 1, '119.56985', '34.20513');
INSERT INTO `shop_truck_region` VALUES (900, 896, 'B', '滨海', '滨海县', 3, 'binhai', '224500', 1, '119.82058', '33.98972');
INSERT INTO `shop_truck_region` VALUES (901, 896, 'F', '阜宁', '阜宁县', 3, 'funing', '224400', 1, '119.80175', '33.78228');
INSERT INTO `shop_truck_region` VALUES (902, 896, 'S', '射阳', '射阳县', 3, 'sheyang', '224300', 1, '120.26043', '33.77636');
INSERT INTO `shop_truck_region` VALUES (903, 896, 'J', '建湖', '建湖县', 3, 'jianhu', '224700', 1, '119.79852', '33.47241');
INSERT INTO `shop_truck_region` VALUES (904, 896, 'D', '东台', '东台市', 3, 'dongtai', '224200', 1, '120.32376', '32.85078');
INSERT INTO `shop_truck_region` VALUES (905, 896, 'D', '大丰', '大丰市', 3, 'dafeng', '224100', 1, '120.46594', '33.19893');
INSERT INTO `shop_truck_region` VALUES (906, 820, 'Y', '扬州', '扬州市', 2, 'yangzhou', '225002', 1, '119.421003', '32.393159');
INSERT INTO `shop_truck_region` VALUES (907, 906, 'G', '广陵', '广陵区', 3, 'guangling', '225002', 1, '119.43186', '32.39472');
INSERT INTO `shop_truck_region` VALUES (908, 906, 'H', '邗江', '邗江区', 3, 'hanjiang', '225002', 1, '119.39816', '32.3765');
INSERT INTO `shop_truck_region` VALUES (909, 906, 'J', '江都', '江都区', 3, 'jiangdu', '225200', 1, '119.567481', '32.426564');
INSERT INTO `shop_truck_region` VALUES (910, 906, 'B', '宝应', '宝应县', 3, 'baoying', '225800', 1, '119.31213', '33.23549');
INSERT INTO `shop_truck_region` VALUES (911, 906, 'Y', '仪征', '仪征市', 3, 'yizheng', '211400', 1, '119.18432', '32.27197');
INSERT INTO `shop_truck_region` VALUES (912, 906, 'G', '高邮', '高邮市', 3, 'gaoyou', '225600', 1, '119.45965', '32.78135');
INSERT INTO `shop_truck_region` VALUES (913, 820, 'Z', '镇江', '镇江市', 2, 'zhenjiang', '212004', 1, '119.452753', '32.204402');
INSERT INTO `shop_truck_region` VALUES (914, 913, 'J', '京口', '京口区', 3, 'jingkou', '212003', 1, '119.46947', '32.19809');
INSERT INTO `shop_truck_region` VALUES (915, 913, 'R', '润州', '润州区', 3, 'runzhou', '212005', 1, '119.41134', '32.19523');
INSERT INTO `shop_truck_region` VALUES (916, 913, 'D', '丹徒', '丹徒区', 3, 'dantu', '212028', 1, '119.43383', '32.13183');
INSERT INTO `shop_truck_region` VALUES (917, 913, 'D', '丹阳', '丹阳市', 3, 'danyang', '212300', 1, '119.57525', '31.99121');
INSERT INTO `shop_truck_region` VALUES (918, 913, 'Y', '扬中', '扬中市', 3, 'yangzhong', '212200', 1, '119.79718', '32.2363');
INSERT INTO `shop_truck_region` VALUES (919, 913, 'J', '句容', '句容市', 3, 'jurong', '212400', 1, '119.16482', '31.95591');
INSERT INTO `shop_truck_region` VALUES (920, 820, 'T', '泰州', '泰州市', 2, 'taizhou', '225300', 1, '119.915176', '32.484882');
INSERT INTO `shop_truck_region` VALUES (921, 920, 'H', '海陵', '海陵区', 3, 'hailing', '225300', 1, '119.91942', '32.49101');
INSERT INTO `shop_truck_region` VALUES (922, 920, 'G', '高港', '高港区', 3, 'gaogang', '225321', 1, '119.88089', '32.31833');
INSERT INTO `shop_truck_region` VALUES (923, 920, 'J', '姜堰', '姜堰区', 3, 'jiangyan', '225500', 1, '120.148208', '32.508483');
INSERT INTO `shop_truck_region` VALUES (924, 920, 'X', '兴化', '兴化市', 3, 'xinghua', '225700', 1, '119.85238', '32.90944');
INSERT INTO `shop_truck_region` VALUES (925, 920, 'J', '靖江', '靖江市', 3, 'jingjiang', '214500', 1, '120.27291', '32.01595');
INSERT INTO `shop_truck_region` VALUES (926, 920, 'T', '泰兴', '泰兴市', 3, 'taixing', '225400', 1, '120.05194', '32.17187');
INSERT INTO `shop_truck_region` VALUES (927, 820, 'S', '宿迁', '宿迁市', 2, 'suqian', '223800', 1, '118.293328', '33.945154');
INSERT INTO `shop_truck_region` VALUES (928, 927, 'S', '宿城', '宿城区', 3, 'sucheng', '223800', 1, '118.29141', '33.94219');
INSERT INTO `shop_truck_region` VALUES (929, 927, 'S', '宿豫', '宿豫区', 3, 'suyu', '223800', 1, '118.32922', '33.94673');
INSERT INTO `shop_truck_region` VALUES (930, 927, 'S', '沭阳', '沭阳县', 3, 'shuyang', '223600', 1, '118.76873', '34.11446');
INSERT INTO `shop_truck_region` VALUES (931, 927, 'S', '泗阳', '泗阳县', 3, 'siyang', '223700', 1, '118.7033', '33.72096');
INSERT INTO `shop_truck_region` VALUES (932, 927, 'S', '泗洪', '泗洪县', 3, 'sihong', '223900', 1, '118.21716', '33.45996');
INSERT INTO `shop_truck_region` VALUES (933, 0, 'Z', '浙江', '浙江省', 1, 'zhejiang', '', 1, '120.153576', '30.287459');
INSERT INTO `shop_truck_region` VALUES (934, 933, 'H', '杭州', '杭州市', 2, 'hangzhou', '310026', 1, '120.153576', '30.287459');
INSERT INTO `shop_truck_region` VALUES (935, 934, 'S', '上城', '上城区', 3, 'shangcheng', '310002', 1, '120.16922', '30.24255');
INSERT INTO `shop_truck_region` VALUES (936, 934, 'X', '下城', '下城区', 3, 'xiacheng', '310006', 1, '120.18096', '30.28153');
INSERT INTO `shop_truck_region` VALUES (937, 934, 'J', '江干', '江干区', 3, 'jianggan', '310016', 1, '120.20517', '30.2572');
INSERT INTO `shop_truck_region` VALUES (938, 934, 'G', '拱墅', '拱墅区', 3, 'gongshu', '310011', 1, '120.14209', '30.31968');
INSERT INTO `shop_truck_region` VALUES (939, 934, 'X', '西湖', '西湖区', 3, 'xihu', '310013', 1, '120.12979', '30.25949');
INSERT INTO `shop_truck_region` VALUES (940, 934, 'B', '滨江', '滨江区', 3, 'binjiang', '310051', 1, '120.21194', '30.20835');
INSERT INTO `shop_truck_region` VALUES (941, 934, 'X', '萧山', '萧山区', 3, 'xiaoshan', '311200', 1, '120.26452', '30.18505');
INSERT INTO `shop_truck_region` VALUES (942, 934, 'Y', '余杭', '余杭区', 3, 'yuhang', '311100', 1, '120.29986', '30.41829');
INSERT INTO `shop_truck_region` VALUES (943, 934, 'T', '桐庐', '桐庐县', 3, 'tonglu', '311500', 1, '119.68853', '29.79779');
INSERT INTO `shop_truck_region` VALUES (944, 934, 'C', '淳安', '淳安县', 3, 'chunan', '311700', 1, '119.04257', '29.60988');
INSERT INTO `shop_truck_region` VALUES (945, 934, 'J', '建德', '建德市', 3, 'jiande', '311600', 1, '119.28158', '29.47603');
INSERT INTO `shop_truck_region` VALUES (946, 934, 'F', '富阳', '富阳区', 3, 'fuyang', '311400', 1, '119.96041', '30.04878');
INSERT INTO `shop_truck_region` VALUES (947, 934, 'L', '临安', '临安市', 3, 'linan', '311300', 1, '119.72473', '30.23447');
INSERT INTO `shop_truck_region` VALUES (948, 933, 'N', '宁波', '宁波市', 2, 'ningbo', '315000', 1, '121.549792', '29.868388');
INSERT INTO `shop_truck_region` VALUES (949, 948, 'H', '海曙', '海曙区', 3, 'haishu', '315000', 1, '121.55106', '29.85977');
INSERT INTO `shop_truck_region` VALUES (950, 948, 'J', '江东', '江东区', 3, 'jiangdong', '315040', 1, '121.57028', '29.86701');
INSERT INTO `shop_truck_region` VALUES (951, 948, 'J', '江北', '江北区', 3, 'jiangbei', '315020', 1, '121.55681', '29.88776');
INSERT INTO `shop_truck_region` VALUES (952, 948, 'B', '北仑', '北仑区', 3, 'beilun', '315800', 1, '121.84408', '29.90069');
INSERT INTO `shop_truck_region` VALUES (953, 948, 'Z', '镇海', '镇海区', 3, 'zhenhai', '315200', 1, '121.71615', '29.94893');
INSERT INTO `shop_truck_region` VALUES (954, 948, 'Y', '鄞州', '鄞州区', 3, 'yinzhou', '315100', 1, '121.54754', '29.81614');
INSERT INTO `shop_truck_region` VALUES (955, 948, 'X', '象山', '象山县', 3, 'xiangshan', '315700', 1, '121.86917', '29.47758');
INSERT INTO `shop_truck_region` VALUES (956, 948, 'N', '宁海', '宁海县', 3, 'ninghai', '315600', 1, '121.43072', '29.2889');
INSERT INTO `shop_truck_region` VALUES (957, 948, 'Y', '余姚', '余姚市', 3, 'yuyao', '315400', 1, '121.15341', '30.03867');
INSERT INTO `shop_truck_region` VALUES (958, 948, 'C', '慈溪', '慈溪市', 3, 'cixi', '315300', 1, '121.26641', '30.16959');
INSERT INTO `shop_truck_region` VALUES (959, 948, 'F', '奉化', '奉化市', 3, 'fenghua', '315500', 1, '121.41003', '29.65537');
INSERT INTO `shop_truck_region` VALUES (960, 933, 'W', '温州', '温州市', 2, 'wenzhou', '325000', 1, '120.672111', '28.000575');
INSERT INTO `shop_truck_region` VALUES (961, 960, 'L', '鹿城', '鹿城区', 3, 'lucheng', '325000', 1, '120.65505', '28.01489');
INSERT INTO `shop_truck_region` VALUES (962, 960, 'L', '龙湾', '龙湾区', 3, 'longwan', '325013', 1, '120.83053', '27.91284');
INSERT INTO `shop_truck_region` VALUES (963, 960, 'O', '瓯海', '瓯海区', 3, 'ouhai', '325005', 1, '120.63751', '28.00714');
INSERT INTO `shop_truck_region` VALUES (964, 960, 'D', '洞头', '洞头县', 3, 'dongtou', '325700', 1, '121.15606', '27.83634');
INSERT INTO `shop_truck_region` VALUES (965, 960, 'Y', '永嘉', '永嘉县', 3, 'yongjia', '325100', 1, '120.69317', '28.15456');
INSERT INTO `shop_truck_region` VALUES (966, 960, 'P', '平阳', '平阳县', 3, 'pingyang', '325400', 1, '120.56506', '27.66245');
INSERT INTO `shop_truck_region` VALUES (967, 960, 'C', '苍南', '苍南县', 3, 'cangnan', '325800', 1, '120.42608', '27.51739');
INSERT INTO `shop_truck_region` VALUES (968, 960, 'W', '文成', '文成县', 3, 'wencheng', '325300', 1, '120.09063', '27.78678');
INSERT INTO `shop_truck_region` VALUES (969, 960, 'T', '泰顺', '泰顺县', 3, 'taishun', '325500', 1, '119.7182', '27.55694');
INSERT INTO `shop_truck_region` VALUES (970, 960, 'R', '瑞安', '瑞安市', 3, 'ruian', '325200', 1, '120.65466', '27.78041');
INSERT INTO `shop_truck_region` VALUES (971, 960, 'L', '乐清', '乐清市', 3, 'yueqing', '325600', 1, '120.9617', '28.12404');
INSERT INTO `shop_truck_region` VALUES (972, 933, 'J', '嘉兴', '嘉兴市', 2, 'jiaxing', '314000', 1, '120.750865', '30.762653');
INSERT INTO `shop_truck_region` VALUES (973, 972, 'N', '南湖', '南湖区', 3, 'nanhu', '314051', 1, '120.78524', '30.74865');
INSERT INTO `shop_truck_region` VALUES (974, 972, 'X', '秀洲', '秀洲区', 3, 'xiuzhou', '314031', 1, '120.70867', '30.76454');
INSERT INTO `shop_truck_region` VALUES (975, 972, 'J', '嘉善', '嘉善县', 3, 'jiashan', '314100', 1, '120.92559', '30.82993');
INSERT INTO `shop_truck_region` VALUES (976, 972, 'H', '海盐', '海盐县', 3, 'haiyan', '314300', 1, '120.9457', '30.52547');
INSERT INTO `shop_truck_region` VALUES (977, 972, 'H', '海宁', '海宁市', 3, 'haining', '314400', 1, '120.6813', '30.5097');
INSERT INTO `shop_truck_region` VALUES (978, 972, 'P', '平湖', '平湖市', 3, 'pinghu', '314200', 1, '121.02166', '30.69618');
INSERT INTO `shop_truck_region` VALUES (979, 972, 'T', '桐乡', '桐乡市', 3, 'tongxiang', '314500', 1, '120.56485', '30.6302');
INSERT INTO `shop_truck_region` VALUES (980, 933, 'H', '湖州', '湖州市', 2, 'huzhou', '313000', 1, '120.102398', '30.867198');
INSERT INTO `shop_truck_region` VALUES (981, 980, 'W', '吴兴', '吴兴区', 3, 'wuxing', '313000', 1, '120.12548', '30.85752');
INSERT INTO `shop_truck_region` VALUES (982, 980, 'N', '南浔', '南浔区', 3, 'nanxun', '313009', 1, '120.42038', '30.86686');
INSERT INTO `shop_truck_region` VALUES (983, 980, 'D', '德清', '德清县', 3, 'deqing', '313200', 1, '119.97836', '30.53369');
INSERT INTO `shop_truck_region` VALUES (984, 980, 'C', '长兴', '长兴县', 3, 'changxing', '313100', 1, '119.90783', '31.00606');
INSERT INTO `shop_truck_region` VALUES (985, 980, 'A', '安吉', '安吉县', 3, 'anji', '313300', 1, '119.68158', '30.63798');
INSERT INTO `shop_truck_region` VALUES (986, 933, 'S', '绍兴', '绍兴市', 2, 'shaoxing', '312000', 1, '120.582112', '29.997117');
INSERT INTO `shop_truck_region` VALUES (987, 986, 'Y', '越城', '越城区', 3, 'yuecheng', '312000', 1, '120.5819', '29.98895');
INSERT INTO `shop_truck_region` VALUES (988, 986, 'K', '柯桥', '柯桥区', 3, 'keqiao', '312030', 1, '120.492736', '30.08763');
INSERT INTO `shop_truck_region` VALUES (989, 986, 'S', '上虞', '上虞区', 3, 'shangyu', '312300', 1, '120.476075', '30.078038');
INSERT INTO `shop_truck_region` VALUES (990, 986, 'X', '新昌', '新昌县', 3, 'xinchang', '312500', 1, '120.90435', '29.49991');
INSERT INTO `shop_truck_region` VALUES (991, 986, 'Z', '诸暨', '诸暨市', 3, 'zhuji', '311800', 1, '120.23629', '29.71358');
INSERT INTO `shop_truck_region` VALUES (992, 986, 'S', '嵊州', '嵊州市', 3, 'shengzhou', '312400', 1, '120.82174', '29.58854');
INSERT INTO `shop_truck_region` VALUES (993, 933, 'J', '金华', '金华市', 2, 'jinhua', '321000', 1, '119.649506', '29.089524');
INSERT INTO `shop_truck_region` VALUES (994, 993, 'W', '婺城', '婺城区', 3, 'wucheng', '321000', 1, '119.57135', '29.09521');
INSERT INTO `shop_truck_region` VALUES (995, 993, 'J', '金东', '金东区', 3, 'jindong', '321000', 1, '119.69302', '29.0991');
INSERT INTO `shop_truck_region` VALUES (996, 993, 'W', '武义', '武义县', 3, 'wuyi', '321200', 1, '119.8164', '28.89331');
INSERT INTO `shop_truck_region` VALUES (997, 993, 'P', '浦江', '浦江县', 3, 'pujiang', '322200', 1, '119.89181', '29.45353');
INSERT INTO `shop_truck_region` VALUES (998, 993, 'P', '磐安', '磐安县', 3, 'panan', '322300', 1, '120.45022', '29.05733');
INSERT INTO `shop_truck_region` VALUES (999, 993, 'L', '兰溪', '兰溪市', 3, 'lanxi', '321100', 1, '119.45965', '29.20841');
INSERT INTO `shop_truck_region` VALUES (1000, 993, 'Y', '义乌', '义乌市', 3, 'yiwu', '322000', 1, '120.0744', '29.30558');
INSERT INTO `shop_truck_region` VALUES (1001, 993, 'D', '东阳', '东阳市', 3, 'dongyang', '322100', 1, '120.24185', '29.28942');
INSERT INTO `shop_truck_region` VALUES (1002, 993, 'Y', '永康', '永康市', 3, 'yongkang', '321300', 1, '120.04727', '28.88844');
INSERT INTO `shop_truck_region` VALUES (1003, 933, NULL, '衢州', '衢州市', 2, 'quzhou', '324002', 1, '118.87263', '28.941708');
INSERT INTO `shop_truck_region` VALUES (1004, 1003, 'K', '柯城', '柯城区', 3, 'kecheng', '324100', 1, '118.87109', '28.96858');
INSERT INTO `shop_truck_region` VALUES (1005, 1003, NULL, '衢江', '衢江区', 3, 'qujiang', '324022', 1, '118.9598', '28.97977');
INSERT INTO `shop_truck_region` VALUES (1006, 1003, 'C', '常山', '常山县', 3, 'changshan', '324200', 1, '118.51025', '28.90191');
INSERT INTO `shop_truck_region` VALUES (1007, 1003, 'K', '开化', '开化县', 3, 'kaihua', '324300', 1, '118.41616', '29.13785');
INSERT INTO `shop_truck_region` VALUES (1008, 1003, 'L', '龙游', '龙游县', 3, 'longyou', '324400', 1, '119.17221', '29.02823');
INSERT INTO `shop_truck_region` VALUES (1009, 1003, 'J', '江山', '江山市', 3, 'jiangshan', '324100', 1, '118.62674', '28.7386');
INSERT INTO `shop_truck_region` VALUES (1010, 933, 'Z', '舟山', '舟山市', 2, 'zhoushan', '316000', 1, '122.106863', '30.016028');
INSERT INTO `shop_truck_region` VALUES (1011, 1010, 'D', '定海', '定海区', 3, 'dinghai', '316000', 1, '122.10677', '30.01985');
INSERT INTO `shop_truck_region` VALUES (1012, 1010, 'P', '普陀', '普陀区', 3, 'putuo', '316100', 1, '122.30278', '29.94908');
INSERT INTO `shop_truck_region` VALUES (1013, 1010, NULL, '岱山', '岱山县', 3, 'daishan', '316200', 1, '122.20486', '30.24385');
INSERT INTO `shop_truck_region` VALUES (1014, 1010, NULL, '嵊泗', '嵊泗县', 3, 'shengsi', '202450', 1, '122.45129', '30.72678');
INSERT INTO `shop_truck_region` VALUES (1015, 933, 'T', '台州', '台州市', 2, 'taizhou', '318000', 1, '121.428599', '28.661378');
INSERT INTO `shop_truck_region` VALUES (1016, 1015, 'J', '椒江', '椒江区', 3, 'jiaojiang', '318000', 1, '121.44287', '28.67301');
INSERT INTO `shop_truck_region` VALUES (1017, 1015, 'H', '黄岩', '黄岩区', 3, 'huangyan', '318020', 1, '121.25891', '28.65077');
INSERT INTO `shop_truck_region` VALUES (1018, 1015, 'L', '路桥', '路桥区', 3, 'luqiao', '318050', 1, '121.37381', '28.58016');
INSERT INTO `shop_truck_region` VALUES (1019, 1015, 'Y', '玉环', '玉环县', 3, 'yuhuan', '317600', 1, '121.23242', '28.13637');
INSERT INTO `shop_truck_region` VALUES (1020, 1015, 'S', '三门', '三门县', 3, 'sanmen', '317100', 1, '121.3937', '29.1051');
INSERT INTO `shop_truck_region` VALUES (1021, 1015, 'T', '天台', '天台县', 3, 'tiantai', '317200', 1, '121.00848', '29.1429');
INSERT INTO `shop_truck_region` VALUES (1022, 1015, 'X', '仙居', '仙居县', 3, 'xianju', '317300', 1, '120.72872', '28.84672');
INSERT INTO `shop_truck_region` VALUES (1023, 1015, 'W', '温岭', '温岭市', 3, 'wenling', '317500', 1, '121.38595', '28.37176');
INSERT INTO `shop_truck_region` VALUES (1024, 1015, 'L', '临海', '临海市', 3, 'linhai', '317000', 1, '121.13885', '28.85603');
INSERT INTO `shop_truck_region` VALUES (1025, 933, 'L', '丽水', '丽水市', 2, 'lishui', '323000', 1, '119.921786', '28.451993');
INSERT INTO `shop_truck_region` VALUES (1026, 1025, 'L', '莲都', '莲都区', 3, 'liandu', '323000', 1, '119.9127', '28.44583');
INSERT INTO `shop_truck_region` VALUES (1027, 1025, 'Q', '青田', '青田县', 3, 'qingtian', '323900', 1, '120.29028', '28.13897');
INSERT INTO `shop_truck_region` VALUES (1028, 1025, NULL, '缙云', '缙云县', 3, 'jinyun', '321400', 1, '120.09036', '28.65944');
INSERT INTO `shop_truck_region` VALUES (1029, 1025, 'S', '遂昌', '遂昌县', 3, 'suichang', '323300', 1, '119.27606', '28.59291');
INSERT INTO `shop_truck_region` VALUES (1030, 1025, 'S', '松阳', '松阳县', 3, 'songyang', '323400', 1, '119.48199', '28.4494');
INSERT INTO `shop_truck_region` VALUES (1031, 1025, 'Y', '云和', '云和县', 3, 'yunhe', '323600', 1, '119.57287', '28.11643');
INSERT INTO `shop_truck_region` VALUES (1032, 1025, 'Q', '庆元', '庆元县', 3, 'qingyuan', '323800', 1, '119.06256', '27.61842');
INSERT INTO `shop_truck_region` VALUES (1033, 1025, 'J', '景宁', '景宁畲族自治县', 3, 'jingning', '323500', 1, '119.63839', '27.97393');
INSERT INTO `shop_truck_region` VALUES (1034, 1025, 'L', '龙泉', '龙泉市', 3, 'longquan', '323700', 1, '119.14163', '28.0743');
INSERT INTO `shop_truck_region` VALUES (1035, 933, 'Z', '舟山新区', '舟山群岛新区', 2, 'zhoushan', '316000', 1, '122.317657', '29.813242');
INSERT INTO `shop_truck_region` VALUES (1036, 1035, 'J', '金塘', '金塘岛', 3, 'jintang', '316000', 1, '121.893373', '30.040641');
INSERT INTO `shop_truck_region` VALUES (1037, 1035, 'L', '六横', '六横岛', 3, 'liuheng', '316000', 1, '122.14265', '29.662938');
INSERT INTO `shop_truck_region` VALUES (1038, 1035, NULL, '衢山', '衢山岛', 3, 'qushan', '316000', 1, '122.358425', '30.442642');
INSERT INTO `shop_truck_region` VALUES (1039, 1035, 'Z', '舟山', '舟山本岛西北部', 3, 'zhoushan', '316000', 1, '122.03064', '30.140377');
INSERT INTO `shop_truck_region` VALUES (1040, 1035, NULL, '岱山', '岱山岛西南部', 3, 'daishan', '316000', 1, '122.180123', '30.277269');
INSERT INTO `shop_truck_region` VALUES (1041, 1035, NULL, '泗礁', '泗礁岛', 3, 'sijiao', '316000', 1, '122.45803', '30.725112');
INSERT INTO `shop_truck_region` VALUES (1042, 1035, 'Z', '朱家尖', '朱家尖岛', 3, 'zhujiajian', '316000', 1, '122.390636', '29.916303');
INSERT INTO `shop_truck_region` VALUES (1043, 1035, 'Y', '洋山', '洋山岛', 3, 'yangshan', '316000', 1, '121.995891', '30.094637');
INSERT INTO `shop_truck_region` VALUES (1044, 1035, 'C', '长涂', '长涂岛', 3, 'changtu', '316000', 1, '122.284681', '30.24888');
INSERT INTO `shop_truck_region` VALUES (1045, 1035, 'X', '虾峙', '虾峙岛', 3, 'xiazhi', '316000', 1, '122.244686', '29.752941');
INSERT INTO `shop_truck_region` VALUES (1046, 0, 'A', '安徽', '安徽省', 1, 'anhui', '', 1, '117.283042', '31.86119');
INSERT INTO `shop_truck_region` VALUES (1047, 1046, 'H', '合肥', '合肥市', 2, 'hefei', '230001', 1, '117.283042', '31.86119');
INSERT INTO `shop_truck_region` VALUES (1048, 1047, 'Y', '瑶海', '瑶海区', 3, 'yaohai', '230011', 1, '117.30947', '31.85809');
INSERT INTO `shop_truck_region` VALUES (1049, 1047, 'L', '庐阳', '庐阳区', 3, 'luyang', '230001', 1, '117.26452', '31.87874');
INSERT INTO `shop_truck_region` VALUES (1050, 1047, 'S', '蜀山', '蜀山区', 3, 'shushan', '230031', 1, '117.26104', '31.85117');
INSERT INTO `shop_truck_region` VALUES (1051, 1047, 'B', '包河', '包河区', 3, 'baohe', '230041', 1, '117.30984', '31.79502');
INSERT INTO `shop_truck_region` VALUES (1052, 1047, 'C', '长丰', '长丰县', 3, 'changfeng', '231100', 1, '117.16549', '32.47959');
INSERT INTO `shop_truck_region` VALUES (1053, 1047, 'F', '肥东', '肥东县', 3, 'feidong', '231600', 1, '117.47128', '31.88525');
INSERT INTO `shop_truck_region` VALUES (1054, 1047, 'F', '肥西', '肥西县', 3, 'feixi', '231200', 1, '117.16845', '31.72143');
INSERT INTO `shop_truck_region` VALUES (1055, 1047, 'L', '庐江', '庐江县', 3, 'lujiang', '231500', 1, '117.289844', '31.251488');
INSERT INTO `shop_truck_region` VALUES (1056, 1047, 'C', '巢湖', '巢湖市', 3, 'chaohu', '238000', 1, '117.874155', '31.600518');
INSERT INTO `shop_truck_region` VALUES (1057, 1046, 'W', '芜湖', '芜湖市', 2, 'wuhu', '241000', 1, '118.376451', '31.326319');
INSERT INTO `shop_truck_region` VALUES (1058, 1057, 'J', '镜湖', '镜湖区', 3, 'jinghu', '241000', 1, '118.38525', '31.34038');
INSERT INTO `shop_truck_region` VALUES (1059, 1057, NULL, '弋江', '弋江区', 3, 'yijiang', '241000', 1, '118.37265', '31.31178');
INSERT INTO `shop_truck_region` VALUES (1060, 1057, NULL, '鸠江', '鸠江区', 3, 'jiujiang', '241000', 1, '118.39215', '31.36928');
INSERT INTO `shop_truck_region` VALUES (1061, 1057, 'S', '三山', '三山区', 3, 'sanshan', '241000', 1, '118.22509', '31.20703');
INSERT INTO `shop_truck_region` VALUES (1062, 1057, 'W', '芜湖', '芜湖县', 3, 'wuhu', '241100', 1, '118.57525', '31.13476');
INSERT INTO `shop_truck_region` VALUES (1063, 1057, 'F', '繁昌', '繁昌县', 3, 'fanchang', '241200', 1, '118.19982', '31.08319');
INSERT INTO `shop_truck_region` VALUES (1064, 1057, 'N', '南陵', '南陵县', 3, 'nanling', '242400', 1, '118.33688', '30.91969');
INSERT INTO `shop_truck_region` VALUES (1065, 1057, 'W', '无为', '无为县', 3, 'wuwei', '238300', 1, '117.911432', '31.303075');
INSERT INTO `shop_truck_region` VALUES (1066, 1046, 'B', '蚌埠', '蚌埠市', 2, 'bengbu', '233000', 1, '117.36237', '32.934037');
INSERT INTO `shop_truck_region` VALUES (1067, 1066, 'L', '龙子湖', '龙子湖区', 3, 'longzihu', '233000', 1, '117.39379', '32.94301');
INSERT INTO `shop_truck_region` VALUES (1068, 1066, 'B', '蚌山', '蚌山区', 3, 'bengshan', '233000', 1, '117.36767', '32.94411');
INSERT INTO `shop_truck_region` VALUES (1069, 1066, 'Y', '禹会', '禹会区', 3, 'yuhui', '233010', 1, '117.35315', '32.93336');
INSERT INTO `shop_truck_region` VALUES (1070, 1066, 'H', '淮上', '淮上区', 3, 'huaishang', '233002', 1, '117.35983', '32.96423');
INSERT INTO `shop_truck_region` VALUES (1071, 1066, 'H', '怀远', '怀远县', 3, 'huaiyuan', '233400', 1, '117.20507', '32.97007');
INSERT INTO `shop_truck_region` VALUES (1072, 1066, 'W', '五河', '五河县', 3, 'wuhe', '233300', 1, '117.89144', '33.14457');
INSERT INTO `shop_truck_region` VALUES (1073, 1066, 'G', '固镇', '固镇县', 3, 'guzhen', '233700', 1, '117.31558', '33.31803');
INSERT INTO `shop_truck_region` VALUES (1074, 1046, 'H', '淮南', '淮南市', 2, 'huainan', '232001', 1, '117.025449', '32.645947');
INSERT INTO `shop_truck_region` VALUES (1075, 1074, 'D', '大通', '大通区', 3, 'datong', '232033', 1, '117.05255', '32.63265');
INSERT INTO `shop_truck_region` VALUES (1076, 1074, 'T', '田家庵', '田家庵区', 3, 'tianjiaan', '232000', 1, '117.01739', '32.64697');
INSERT INTO `shop_truck_region` VALUES (1077, 1074, 'X', '谢家集', '谢家集区', 3, 'xiejiaji', '232052', 1, '116.86377', '32.59818');
INSERT INTO `shop_truck_region` VALUES (1078, 1074, 'B', '八公山', '八公山区', 3, 'bagongshan', '232072', 1, '116.83694', '32.62941');
INSERT INTO `shop_truck_region` VALUES (1079, 1074, 'P', '潘集', '潘集区', 3, 'panji', '232082', 1, '116.81622', '32.78287');
INSERT INTO `shop_truck_region` VALUES (1080, 1074, 'F', '凤台', '凤台县', 3, 'fengtai', '232100', 1, '116.71569', '32.70752');
INSERT INTO `shop_truck_region` VALUES (1081, 1046, 'M', '马鞍山', '马鞍山市', 2, 'maanshan', '243001', 1, '118.507906', '31.689362');
INSERT INTO `shop_truck_region` VALUES (1082, 1081, 'H', '花山', '花山区', 3, 'huashan', '243000', 1, '118.51231', '31.7001');
INSERT INTO `shop_truck_region` VALUES (1083, 1081, 'Y', '雨山', '雨山区', 3, 'yushan', '243071', 1, '118.49869', '31.68219');
INSERT INTO `shop_truck_region` VALUES (1084, 1081, 'B', '博望', '博望区', 3, 'bowang', '243131', 1, '118.844387', '31.561871');
INSERT INTO `shop_truck_region` VALUES (1085, 1081, 'D', '当涂', '当涂县', 3, 'dangtu', '243100', 1, '118.49786', '31.57098');
INSERT INTO `shop_truck_region` VALUES (1086, 1081, 'H', '含山', '含山县', 3, 'hanshan', '238100', 1, '118.105545', '31.727758');
INSERT INTO `shop_truck_region` VALUES (1087, 1081, 'H', '和县', '和县', 3, 'hexian', '238200', 1, '118.351405', '31.741794');
INSERT INTO `shop_truck_region` VALUES (1088, 1046, 'H', '淮北', '淮北市', 2, 'huaibei', '235000', 1, '116.794664', '33.971707');
INSERT INTO `shop_truck_region` VALUES (1089, 1088, 'D', '杜集', '杜集区', 3, 'duji', '235000', 1, '116.82998', '33.99363');
INSERT INTO `shop_truck_region` VALUES (1090, 1088, 'X', '相山', '相山区', 3, 'xiangshan', '235000', 1, '116.79464', '33.95979');
INSERT INTO `shop_truck_region` VALUES (1091, 1088, 'L', '烈山', '烈山区', 3, 'lieshan', '235000', 1, '116.81448', '33.89355');
INSERT INTO `shop_truck_region` VALUES (1092, 1088, NULL, '濉溪', '濉溪县', 3, 'suixi', '235100', 1, '116.76785', '33.91455');
INSERT INTO `shop_truck_region` VALUES (1093, 1046, 'T', '铜陵', '铜陵市', 2, 'tongling', '244000', 1, '117.816576', '30.929935');
INSERT INTO `shop_truck_region` VALUES (1094, 1093, 'T', '铜官山', '铜官山区', 3, 'tongguanshan', '244000', 1, '117.81525', '30.93423');
INSERT INTO `shop_truck_region` VALUES (1095, 1093, 'S', '狮子山', '狮子山区', 3, 'shizishan', '244000', 1, '117.89178', '30.92631');
INSERT INTO `shop_truck_region` VALUES (1096, 1093, 'J', '郊区', '郊区', 3, 'jiaoqu', '244000', 1, '117.80868', '30.91976');
INSERT INTO `shop_truck_region` VALUES (1097, 1093, 'T', '铜陵', '铜陵县', 3, 'tongling', '244100', 1, '117.79113', '30.95365');
INSERT INTO `shop_truck_region` VALUES (1098, 1046, 'A', '安庆', '安庆市', 2, 'anqing', '246001', 1, '117.053571', '30.524816');
INSERT INTO `shop_truck_region` VALUES (1099, 1098, 'Y', '迎江', '迎江区', 3, 'yingjiang', '246001', 1, '117.0493', '30.50421');
INSERT INTO `shop_truck_region` VALUES (1100, 1098, 'D', '大观', '大观区', 3, 'daguan', '246002', 1, '117.03426', '30.51216');
INSERT INTO `shop_truck_region` VALUES (1101, 1098, 'Y', '宜秀', '宜秀区', 3, 'yixiu', '246003', 1, '117.06127', '30.50783');
INSERT INTO `shop_truck_region` VALUES (1102, 1098, 'H', '怀宁', '怀宁县', 3, 'huaining', '246100', 1, '116.82968', '30.73376');
INSERT INTO `shop_truck_region` VALUES (1103, 1098, NULL, '枞阳', '枞阳县', 3, 'zongyang', '246700', 1, '117.22015', '30.69956');
INSERT INTO `shop_truck_region` VALUES (1104, 1098, 'Q', '潜山', '潜山县', 3, 'qianshan', '246300', 1, '116.57574', '30.63037');
INSERT INTO `shop_truck_region` VALUES (1105, 1098, 'T', '太湖', '太湖县', 3, 'taihu', '246400', 1, '116.3088', '30.4541');
INSERT INTO `shop_truck_region` VALUES (1106, 1098, 'S', '宿松', '宿松县', 3, 'susong', '246500', 1, '116.12915', '30.1536');
INSERT INTO `shop_truck_region` VALUES (1107, 1098, 'W', '望江', '望江县', 3, 'wangjiang', '246200', 1, '116.68814', '30.12585');
INSERT INTO `shop_truck_region` VALUES (1108, 1098, 'Y', '岳西', '岳西县', 3, 'yuexi', '246600', 1, '116.35995', '30.84983');
INSERT INTO `shop_truck_region` VALUES (1109, 1098, 'T', '桐城', '桐城市', 3, 'tongcheng', '231400', 1, '116.95071', '31.05216');
INSERT INTO `shop_truck_region` VALUES (1110, 1046, 'H', '黄山', '黄山市', 2, 'huangshan', '245000', 1, '118.317325', '29.709239');
INSERT INTO `shop_truck_region` VALUES (1111, 1110, 'T', '屯溪', '屯溪区', 3, 'tunxi', '245000', 1, '118.33368', '29.71138');
INSERT INTO `shop_truck_region` VALUES (1112, 1110, 'H', '黄山', '黄山区', 3, 'huangshan', '242700', 1, '118.1416', '30.2729');
INSERT INTO `shop_truck_region` VALUES (1113, 1110, 'H', '徽州', '徽州区', 3, 'huizhou', '245061', 1, '118.33654', '29.82784');
INSERT INTO `shop_truck_region` VALUES (1114, 1110, NULL, '歙县', '歙县', 3, 'shexian', '245200', 1, '118.43676', '29.86745');
INSERT INTO `shop_truck_region` VALUES (1115, 1110, 'X', '休宁', '休宁县', 3, 'xiuning', '245400', 1, '118.18136', '29.78607');
INSERT INTO `shop_truck_region` VALUES (1116, 1110, NULL, '黟县', '黟县', 3, 'yixian', '245500', 1, '117.94137', '29.92588');
INSERT INTO `shop_truck_region` VALUES (1117, 1110, 'Q', '祁门', '祁门县', 3, 'qimen', '245600', 1, '117.71847', '29.85723');
INSERT INTO `shop_truck_region` VALUES (1118, 1046, 'C', '滁州', '滁州市', 2, 'chuzhou', '239000', 1, '118.316264', '32.303627');
INSERT INTO `shop_truck_region` VALUES (1119, 1118, 'L', '琅琊', '琅琊区', 3, 'langya', '239000', 1, '118.30538', '32.29521');
INSERT INTO `shop_truck_region` VALUES (1120, 1118, 'N', '南谯', '南谯区', 3, 'nanqiao', '239000', 1, '118.31222', '32.31861');
INSERT INTO `shop_truck_region` VALUES (1121, 1118, 'L', '来安', '来安县', 3, 'laian', '239200', 1, '118.43438', '32.45176');
INSERT INTO `shop_truck_region` VALUES (1122, 1118, 'Q', '全椒', '全椒县', 3, 'quanjiao', '239500', 1, '118.27291', '32.08524');
INSERT INTO `shop_truck_region` VALUES (1123, 1118, 'D', '定远', '定远县', 3, 'dingyuan', '233200', 1, '117.68035', '32.52488');
INSERT INTO `shop_truck_region` VALUES (1124, 1118, 'F', '凤阳', '凤阳县', 3, 'fengyang', '233100', 1, '117.56454', '32.86507');
INSERT INTO `shop_truck_region` VALUES (1125, 1118, 'T', '天长', '天长市', 3, 'tianchang', '239300', 1, '118.99868', '32.69124');
INSERT INTO `shop_truck_region` VALUES (1126, 1118, 'M', '明光', '明光市', 3, 'mingguang', '239400', 1, '117.99093', '32.77819');
INSERT INTO `shop_truck_region` VALUES (1127, 1046, 'F', '阜阳', '阜阳市', 2, 'fuyang', '236033', 1, '115.819729', '32.896969');
INSERT INTO `shop_truck_region` VALUES (1128, 1127, NULL, '颍州', '颍州区', 3, 'yingzhou', '236001', 1, '115.80694', '32.88346');
INSERT INTO `shop_truck_region` VALUES (1129, 1127, NULL, '颍东', '颍东区', 3, 'yingdong', '236058', 1, '115.85659', '32.91296');
INSERT INTO `shop_truck_region` VALUES (1130, 1127, NULL, '颍泉', '颍泉区', 3, 'yingquan', '236045', 1, '115.80712', '32.9249');
INSERT INTO `shop_truck_region` VALUES (1131, 1127, 'L', '临泉', '临泉县', 3, 'linquan', '236400', 1, '115.26232', '33.06758');
INSERT INTO `shop_truck_region` VALUES (1132, 1127, 'T', '太和', '太和县', 3, 'taihe', '236600', 1, '115.62191', '33.16025');
INSERT INTO `shop_truck_region` VALUES (1133, 1127, 'F', '阜南', '阜南县', 3, 'funan', '236300', 1, '115.58563', '32.63551');
INSERT INTO `shop_truck_region` VALUES (1134, 1127, NULL, '颍上', '颍上县', 3, 'yingshang', '236200', 1, '116.26458', '32.62998');
INSERT INTO `shop_truck_region` VALUES (1135, 1127, 'J', '界首', '界首市', 3, 'jieshou', '236500', 1, '115.37445', '33.25714');
INSERT INTO `shop_truck_region` VALUES (1136, 1046, 'S', '宿州', '宿州市', 2, 'suzhou', '234000', 1, '116.984084', '33.633891');
INSERT INTO `shop_truck_region` VALUES (1137, 1136, NULL, '埇桥', '埇桥区', 3, 'yongqiao', '234000', 1, '116.97731', '33.64058');
INSERT INTO `shop_truck_region` VALUES (1138, 1136, NULL, '砀山', '砀山县', 3, 'dangshan', '235300', 1, '116.35363', '34.42356');
INSERT INTO `shop_truck_region` VALUES (1139, 1136, 'X', '萧县', '萧县', 3, 'xiaoxian', '235200', 1, '116.94546', '34.1879');
INSERT INTO `shop_truck_region` VALUES (1140, 1136, 'L', '灵璧', '灵璧县', 3, 'lingbi', '234200', 1, '117.55813', '33.54339');
INSERT INTO `shop_truck_region` VALUES (1141, 1136, NULL, '泗县', '泗县', 3, 'sixian', '234300', 1, '117.91033', '33.48295');
INSERT INTO `shop_truck_region` VALUES (1142, 1046, 'L', '六安', '六安市', 2, 'luan', '237000', 1, '116.507676', '31.752889');
INSERT INTO `shop_truck_region` VALUES (1143, 1142, 'J', '金安', '金安区', 3, 'jinan', '237005', 1, '116.50912', '31.75573');
INSERT INTO `shop_truck_region` VALUES (1144, 1142, 'Y', '裕安', '裕安区', 3, 'yuan', '237010', 1, '116.47985', '31.73787');
INSERT INTO `shop_truck_region` VALUES (1145, 1142, 'S', '寿县', '寿县', 3, 'shouxian', '232200', 1, '116.78466', '32.57653');
INSERT INTO `shop_truck_region` VALUES (1146, 1142, 'H', '霍邱', '霍邱县', 3, 'huoqiu', '237400', 1, '116.27795', '32.353');
INSERT INTO `shop_truck_region` VALUES (1147, 1142, 'S', '舒城', '舒城县', 3, 'shucheng', '231300', 1, '116.94491', '31.46413');
INSERT INTO `shop_truck_region` VALUES (1148, 1142, 'J', '金寨', '金寨县', 3, 'jinzhai', '237300', 1, '115.93463', '31.7351');
INSERT INTO `shop_truck_region` VALUES (1149, 1142, 'H', '霍山', '霍山县', 3, 'huoshan', '237200', 1, '116.33291', '31.3929');
INSERT INTO `shop_truck_region` VALUES (1150, 1046, NULL, '亳州', '亳州市', 2, 'bozhou', '236802', 1, '115.782939', '33.869338');
INSERT INTO `shop_truck_region` VALUES (1151, 1150, NULL, '谯城', '谯城区', 3, 'qiaocheng', '236800', 1, '115.77941', '33.87532');
INSERT INTO `shop_truck_region` VALUES (1152, 1150, 'W', '涡阳', '涡阳县', 3, 'guoyang', '233600', 1, '116.21682', '33.50911');
INSERT INTO `shop_truck_region` VALUES (1153, 1150, 'M', '蒙城', '蒙城县', 3, 'mengcheng', '233500', 1, '116.5646', '33.26477');
INSERT INTO `shop_truck_region` VALUES (1154, 1150, 'L', '利辛', '利辛县', 3, 'lixin', '236700', 1, '116.208', '33.14198');
INSERT INTO `shop_truck_region` VALUES (1155, 1046, 'C', '池州', '池州市', 2, 'chizhou', '247100', 1, '117.489157', '30.656037');
INSERT INTO `shop_truck_region` VALUES (1156, 1155, 'G', '贵池', '贵池区', 3, 'guichi', '247100', 1, '117.48722', '30.65283');
INSERT INTO `shop_truck_region` VALUES (1157, 1155, 'D', '东至', '东至县', 3, 'dongzhi', '247200', 1, '117.02719', '30.0969');
INSERT INTO `shop_truck_region` VALUES (1158, 1155, 'S', '石台', '石台县', 3, 'shitai', '245100', 1, '117.48666', '30.21042');
INSERT INTO `shop_truck_region` VALUES (1159, 1155, 'Q', '青阳', '青阳县', 3, 'qingyang', '242800', 1, '117.84744', '30.63932');
INSERT INTO `shop_truck_region` VALUES (1160, 1046, 'X', '宣城', '宣城市', 2, 'xuancheng', '242000', 1, '118.757995', '30.945667');
INSERT INTO `shop_truck_region` VALUES (1161, 1160, 'X', '宣州', '宣州区', 3, 'xuanzhou', '242000', 1, '118.75462', '30.94439');
INSERT INTO `shop_truck_region` VALUES (1162, 1160, 'L', '郎溪', '郎溪县', 3, 'langxi', '242100', 1, '119.17923', '31.12599');
INSERT INTO `shop_truck_region` VALUES (1163, 1160, 'G', '广德', '广德县', 3, 'guangde', '242200', 1, '119.41769', '30.89371');
INSERT INTO `shop_truck_region` VALUES (1164, 1160, NULL, '泾县', '泾县', 3, 'jingxian', '242500', 1, '118.41964', '30.69498');
INSERT INTO `shop_truck_region` VALUES (1165, 1160, 'J', '绩溪', '绩溪县', 3, 'jixi', '245300', 1, '118.59765', '30.07069');
INSERT INTO `shop_truck_region` VALUES (1166, 1160, NULL, '旌德', '旌德县', 3, 'jingde', '242600', 1, '118.54299', '30.28898');
INSERT INTO `shop_truck_region` VALUES (1167, 1160, 'N', '宁国', '宁国市', 3, 'ningguo', '242300', 1, '118.98349', '30.6238');
INSERT INTO `shop_truck_region` VALUES (1168, 0, 'F', '福建', '福建省', 1, 'fujian', '', 1, '119.306239', '26.075302');
INSERT INTO `shop_truck_region` VALUES (1169, 1168, 'F', '福州', '福州市', 2, 'fuzhou', '350001', 1, '119.306239', '26.075302');
INSERT INTO `shop_truck_region` VALUES (1170, 1169, 'G', '鼓楼', '鼓楼区', 3, 'gulou', '350001', 1, '119.30384', '26.08225');
INSERT INTO `shop_truck_region` VALUES (1171, 1169, 'T', '台江', '台江区', 3, 'taijiang', '350004', 1, '119.30899', '26.06204');
INSERT INTO `shop_truck_region` VALUES (1172, 1169, 'C', '仓山', '仓山区', 3, 'cangshan', '350007', 1, '119.31543', '26.04335');
INSERT INTO `shop_truck_region` VALUES (1173, 1169, 'M', '马尾', '马尾区', 3, 'mawei', '350015', 1, '119.4555', '25.98942');
INSERT INTO `shop_truck_region` VALUES (1174, 1169, 'J', '晋安', '晋安区', 3, 'jinan', '350011', 1, '119.32828', '26.0818');
INSERT INTO `shop_truck_region` VALUES (1175, 1169, 'M', '闽侯', '闽侯县', 3, 'minhou', '350100', 1, '119.13388', '26.15014');
INSERT INTO `shop_truck_region` VALUES (1176, 1169, 'L', '连江', '连江县', 3, 'lianjiang', '350500', 1, '119.53433', '26.19466');
INSERT INTO `shop_truck_region` VALUES (1177, 1169, 'L', '罗源', '罗源县', 3, 'luoyuan', '350600', 1, '119.5509', '26.48752');
INSERT INTO `shop_truck_region` VALUES (1178, 1169, 'M', '闽清', '闽清县', 3, 'minqing', '350800', 1, '118.8623', '26.21901');
INSERT INTO `shop_truck_region` VALUES (1179, 1169, 'Y', '永泰', '永泰县', 3, 'yongtai', '350700', 1, '118.936', '25.86816');
INSERT INTO `shop_truck_region` VALUES (1180, 1169, 'P', '平潭', '平潭县', 3, 'pingtan', '350400', 1, '119.791197', '25.503672');
INSERT INTO `shop_truck_region` VALUES (1181, 1169, 'F', '福清', '福清市', 3, 'fuqing', '350300', 1, '119.38507', '25.72086');
INSERT INTO `shop_truck_region` VALUES (1182, 1169, 'C', '长乐', '长乐市', 3, 'changle', '350200', 1, '119.52313', '25.96276');
INSERT INTO `shop_truck_region` VALUES (1183, 1168, 'X', '厦门', '厦门市', 2, 'xiamen', '361003', 1, '118.11022', '24.490474');
INSERT INTO `shop_truck_region` VALUES (1184, 1183, 'S', '思明', '思明区', 3, 'siming', '361001', 1, '118.08233', '24.44543');
INSERT INTO `shop_truck_region` VALUES (1185, 1183, 'H', '海沧', '海沧区', 3, 'haicang', '361026', 1, '118.03289', '24.48461');
INSERT INTO `shop_truck_region` VALUES (1186, 1183, 'H', '湖里', '湖里区', 3, 'huli', '361006', 1, '118.14621', '24.51253');
INSERT INTO `shop_truck_region` VALUES (1187, 1183, 'J', '集美', '集美区', 3, 'jimei', '361021', 1, '118.09719', '24.57584');
INSERT INTO `shop_truck_region` VALUES (1188, 1183, 'T', '同安', '同安区', 3, 'tongan', '361100', 1, '118.15197', '24.72308');
INSERT INTO `shop_truck_region` VALUES (1189, 1183, 'X', '翔安', '翔安区', 3, 'xiangan', '361101', 1, '118.24783', '24.61863');
INSERT INTO `shop_truck_region` VALUES (1190, 1168, 'P', '莆田', '莆田市', 2, 'putian', '351100', 1, '119.007558', '25.431011');
INSERT INTO `shop_truck_region` VALUES (1191, 1190, 'C', '城厢', '城厢区', 3, 'chengxiang', '351100', 1, '118.99462', '25.41872');
INSERT INTO `shop_truck_region` VALUES (1192, 1190, 'H', '涵江', '涵江区', 3, 'hanjiang', '351111', 1, '119.11621', '25.45876');
INSERT INTO `shop_truck_region` VALUES (1193, 1190, 'L', '荔城', '荔城区', 3, 'licheng', '351100', 1, '119.01339', '25.43369');
INSERT INTO `shop_truck_region` VALUES (1194, 1190, 'X', '秀屿', '秀屿区', 3, 'xiuyu', '351152', 1, '119.10553', '25.31831');
INSERT INTO `shop_truck_region` VALUES (1195, 1190, 'X', '仙游', '仙游县', 3, 'xianyou', '351200', 1, '118.69177', '25.36214');
INSERT INTO `shop_truck_region` VALUES (1196, 1168, 'S', '三明', '三明市', 2, 'sanming', '365000', 1, '117.635001', '26.265444');
INSERT INTO `shop_truck_region` VALUES (1197, 1196, 'M', '梅列', '梅列区', 3, 'meilie', '365000', 1, '117.64585', '26.27171');
INSERT INTO `shop_truck_region` VALUES (1198, 1196, 'S', '三元', '三元区', 3, 'sanyuan', '365001', 1, '117.60788', '26.23372');
INSERT INTO `shop_truck_region` VALUES (1199, 1196, 'M', '明溪', '明溪县', 3, 'mingxi', '365200', 1, '117.20498', '26.35294');
INSERT INTO `shop_truck_region` VALUES (1200, 1196, 'Q', '清流', '清流县', 3, 'qingliu', '365300', 1, '116.8146', '26.17144');
INSERT INTO `shop_truck_region` VALUES (1201, 1196, 'N', '宁化', '宁化县', 3, 'ninghua', '365400', 1, '116.66101', '26.25874');
INSERT INTO `shop_truck_region` VALUES (1202, 1196, 'D', '大田', '大田县', 3, 'datian', '366100', 1, '117.8471', '25.6926');
INSERT INTO `shop_truck_region` VALUES (1203, 1196, 'Y', '尤溪', '尤溪县', 3, 'youxi', '365100', 1, '118.19049', '26.17002');
INSERT INTO `shop_truck_region` VALUES (1204, 1196, 'S', '沙县', '沙县', 3, 'shaxian', '365500', 1, '117.79266', '26.39615');
INSERT INTO `shop_truck_region` VALUES (1205, 1196, 'J', '将乐', '将乐县', 3, 'jiangle', '353300', 1, '117.47317', '26.72837');
INSERT INTO `shop_truck_region` VALUES (1206, 1196, 'T', '泰宁', '泰宁县', 3, 'taining', '354400', 1, '117.17578', '26.9001');
INSERT INTO `shop_truck_region` VALUES (1207, 1196, 'J', '建宁', '建宁县', 3, 'jianning', '354500', 1, '116.84603', '26.83091');
INSERT INTO `shop_truck_region` VALUES (1208, 1196, 'Y', '永安', '永安市', 3, 'yongan', '366000', 1, '117.36517', '25.94136');
INSERT INTO `shop_truck_region` VALUES (1209, 1168, 'Q', '泉州', '泉州市', 2, 'quanzhou', '362000', 1, '118.589421', '24.908853');
INSERT INTO `shop_truck_region` VALUES (1210, 1209, 'L', '鲤城', '鲤城区', 3, 'licheng', '362000', 1, '118.56591', '24.88741');
INSERT INTO `shop_truck_region` VALUES (1211, 1209, 'F', '丰泽', '丰泽区', 3, 'fengze', '362000', 1, '118.61328', '24.89119');
INSERT INTO `shop_truck_region` VALUES (1212, 1209, 'L', '洛江', '洛江区', 3, 'luojiang', '362011', 1, '118.67111', '24.93984');
INSERT INTO `shop_truck_region` VALUES (1213, 1209, 'Q', '泉港', '泉港区', 3, 'quangang', '362114', 1, '118.91586', '25.12005');
INSERT INTO `shop_truck_region` VALUES (1214, 1209, 'H', '惠安', '惠安县', 3, 'huian', '362100', 1, '118.79687', '25.03059');
INSERT INTO `shop_truck_region` VALUES (1215, 1209, 'A', '安溪', '安溪县', 3, 'anxi', '362400', 1, '118.18719', '25.05627');
INSERT INTO `shop_truck_region` VALUES (1216, 1209, 'Y', '永春', '永春县', 3, 'yongchun', '362600', 1, '118.29437', '25.32183');
INSERT INTO `shop_truck_region` VALUES (1217, 1209, 'D', '德化', '德化县', 3, 'dehua', '362500', 1, '118.24176', '25.49224');
INSERT INTO `shop_truck_region` VALUES (1218, 1209, 'J', '金门', '金门县', 3, 'jinmen', '', 1, '118.32263', '24.42922');
INSERT INTO `shop_truck_region` VALUES (1219, 1209, 'S', '石狮', '石狮市', 3, 'shishi', '362700', 1, '118.64779', '24.73242');
INSERT INTO `shop_truck_region` VALUES (1220, 1209, 'J', '晋江', '晋江市', 3, 'jinjiang', '362200', 1, '118.55194', '24.78141');
INSERT INTO `shop_truck_region` VALUES (1221, 1209, 'N', '南安', '南安市', 3, 'nanan', '362300', 1, '118.38589', '24.96055');
INSERT INTO `shop_truck_region` VALUES (1222, 1168, 'Z', '漳州', '漳州市', 2, 'zhangzhou', '363005', 1, '117.661801', '24.510897');
INSERT INTO `shop_truck_region` VALUES (1223, 1222, NULL, '芗城', '芗城区', 3, 'xiangcheng', '363000', 1, '117.65402', '24.51081');
INSERT INTO `shop_truck_region` VALUES (1224, 1222, 'L', '龙文', '龙文区', 3, 'longwen', '363005', 1, '117.70971', '24.50323');
INSERT INTO `shop_truck_region` VALUES (1225, 1222, 'Y', '云霄', '云霄县', 3, 'yunxiao', '363300', 1, '117.34051', '23.95534');
INSERT INTO `shop_truck_region` VALUES (1226, 1222, 'Z', '漳浦', '漳浦县', 3, 'zhangpu', '363200', 1, '117.61367', '24.11706');
INSERT INTO `shop_truck_region` VALUES (1227, 1222, NULL, '诏安', '诏安县', 3, 'zhaoan', '363500', 1, '117.17501', '23.71148');
INSERT INTO `shop_truck_region` VALUES (1228, 1222, 'C', '长泰', '长泰县', 3, 'changtai', '363900', 1, '117.75924', '24.62526');
INSERT INTO `shop_truck_region` VALUES (1229, 1222, 'D', '东山', '东山县', 3, 'dongshan', '363400', 1, '117.42822', '23.70109');
INSERT INTO `shop_truck_region` VALUES (1230, 1222, 'N', '南靖', '南靖县', 3, 'nanjing', '363600', 1, '117.35736', '24.51448');
INSERT INTO `shop_truck_region` VALUES (1231, 1222, 'P', '平和', '平和县', 3, 'pinghe', '363700', 1, '117.3124', '24.36395');
INSERT INTO `shop_truck_region` VALUES (1232, 1222, 'H', '华安', '华安县', 3, 'huaan', '363800', 1, '117.54077', '25.00563');
INSERT INTO `shop_truck_region` VALUES (1233, 1222, 'L', '龙海', '龙海市', 3, 'longhai', '363100', 1, '117.81802', '24.44655');
INSERT INTO `shop_truck_region` VALUES (1234, 1168, 'N', '南平', '南平市', 2, 'nanping', '353000', 1, '118.178459', '26.635627');
INSERT INTO `shop_truck_region` VALUES (1235, 1234, 'Y', '延平', '延平区', 3, 'yanping', '353000', 1, '118.18189', '26.63745');
INSERT INTO `shop_truck_region` VALUES (1236, 1234, 'J', '建阳', '建阳区', 3, 'jianyang', '354200', 1, '118.12267', '27.332067');
INSERT INTO `shop_truck_region` VALUES (1237, 1234, 'S', '顺昌', '顺昌县', 3, 'shunchang', '353200', 1, '117.8103', '26.79298');
INSERT INTO `shop_truck_region` VALUES (1238, 1234, 'P', '浦城', '浦城县', 3, 'pucheng', '353400', 1, '118.54007', '27.91888');
INSERT INTO `shop_truck_region` VALUES (1239, 1234, 'G', '光泽', '光泽县', 3, 'guangze', '354100', 1, '117.33346', '27.54231');
INSERT INTO `shop_truck_region` VALUES (1240, 1234, 'S', '松溪', '松溪县', 3, 'songxi', '353500', 1, '118.78533', '27.52624');
INSERT INTO `shop_truck_region` VALUES (1241, 1234, 'Z', '政和', '政和县', 3, 'zhenghe', '353600', 1, '118.85571', '27.36769');
INSERT INTO `shop_truck_region` VALUES (1242, 1234, 'S', '邵武', '邵武市', 3, 'shaowu', '354000', 1, '117.4924', '27.34033');
INSERT INTO `shop_truck_region` VALUES (1243, 1234, 'W', '武夷山', '武夷山市', 3, 'wuyishan', '354300', 1, '118.03665', '27.75543');
INSERT INTO `shop_truck_region` VALUES (1244, 1234, 'J', '建瓯', '建瓯市', 3, 'jianou', '353100', 1, '118.29766', '27.02301');
INSERT INTO `shop_truck_region` VALUES (1245, 1168, 'L', '龙岩', '龙岩市', 2, 'longyan', '364000', 1, '117.02978', '25.091603');
INSERT INTO `shop_truck_region` VALUES (1246, 1245, 'X', '新罗', '新罗区', 3, 'xinluo', '364000', 1, '117.03693', '25.09834');
INSERT INTO `shop_truck_region` VALUES (1247, 1245, 'C', '长汀', '长汀县', 3, 'changting', '366300', 1, '116.35888', '25.82773');
INSERT INTO `shop_truck_region` VALUES (1248, 1245, 'Y', '永定', '永定区', 3, 'yongding', '364100', 1, '116.73199', '24.72302');
INSERT INTO `shop_truck_region` VALUES (1249, 1245, 'S', '上杭', '上杭县', 3, 'shanghang', '364200', 1, '116.42022', '25.04943');
INSERT INTO `shop_truck_region` VALUES (1250, 1245, 'W', '武平', '武平县', 3, 'wuping', '364300', 1, '116.10229', '25.09244');
INSERT INTO `shop_truck_region` VALUES (1251, 1245, 'L', '连城', '连城县', 3, 'liancheng', '366200', 1, '116.75454', '25.7103');
INSERT INTO `shop_truck_region` VALUES (1252, 1245, 'Z', '漳平', '漳平市', 3, 'zhangping', '364400', 1, '117.41992', '25.29109');
INSERT INTO `shop_truck_region` VALUES (1253, 1168, 'N', '宁德', '宁德市', 2, 'ningde', '352100', 1, '119.527082', '26.65924');
INSERT INTO `shop_truck_region` VALUES (1254, 1253, 'J', '蕉城', '蕉城区', 3, 'jiaocheng', '352100', 1, '119.52643', '26.66048');
INSERT INTO `shop_truck_region` VALUES (1255, 1253, 'X', '霞浦', '霞浦县', 3, 'xiapu', '355100', 1, '119.99893', '26.88578');
INSERT INTO `shop_truck_region` VALUES (1256, 1253, 'G', '古田', '古田县', 3, 'gutian', '352200', 1, '118.74688', '26.57682');
INSERT INTO `shop_truck_region` VALUES (1257, 1253, 'P', '屏南', '屏南县', 3, 'pingnan', '352300', 1, '118.98861', '26.91099');
INSERT INTO `shop_truck_region` VALUES (1258, 1253, 'S', '寿宁', '寿宁县', 3, 'shouning', '355500', 1, '119.5039', '27.45996');
INSERT INTO `shop_truck_region` VALUES (1259, 1253, 'Z', '周宁', '周宁县', 3, 'zhouning', '355400', 1, '119.33837', '27.10664');
INSERT INTO `shop_truck_region` VALUES (1260, 1253, NULL, '柘荣', '柘荣县', 3, 'zherong', '355300', 1, '119.89971', '27.23543');
INSERT INTO `shop_truck_region` VALUES (1261, 1253, 'F', '福安', '福安市', 3, 'fuan', '355000', 1, '119.6495', '27.08673');
INSERT INTO `shop_truck_region` VALUES (1262, 1253, 'F', '福鼎', '福鼎市', 3, 'fuding', '355200', 1, '120.21664', '27.3243');
INSERT INTO `shop_truck_region` VALUES (1263, 0, 'J', '江西', '江西省', 1, 'jiangxi', '', 1, '115.892151', '28.676493');
INSERT INTO `shop_truck_region` VALUES (1264, 1263, 'N', '南昌', '南昌市', 2, 'nanchang', '330008', 1, '115.892151', '28.676493');
INSERT INTO `shop_truck_region` VALUES (1265, 1264, 'D', '东湖', '东湖区', 3, 'donghu', '330006', 1, '115.8988', '28.68505');
INSERT INTO `shop_truck_region` VALUES (1266, 1264, 'X', '西湖', '西湖区', 3, 'xihu', '330009', 1, '115.87728', '28.65688');
INSERT INTO `shop_truck_region` VALUES (1267, 1264, 'Q', '青云谱', '青云谱区', 3, 'qingyunpu', '330001', 1, '115.915', '28.63199');
INSERT INTO `shop_truck_region` VALUES (1268, 1264, 'W', '湾里', '湾里区', 3, 'wanli', '330004', 1, '115.73104', '28.71529');
INSERT INTO `shop_truck_region` VALUES (1269, 1264, 'Q', '青山湖', '青山湖区', 3, 'qingshanhu', '330029', 1, '115.9617', '28.68206');
INSERT INTO `shop_truck_region` VALUES (1270, 1264, 'N', '南昌', '南昌县', 3, 'nanchang', '330200', 1, '115.94393', '28.54559');
INSERT INTO `shop_truck_region` VALUES (1271, 1264, 'X', '新建', '新建县', 3, 'xinjian', '330100', 1, '115.81546', '28.69248');
INSERT INTO `shop_truck_region` VALUES (1272, 1264, 'A', '安义', '安义县', 3, 'anyi', '330500', 1, '115.54879', '28.84602');
INSERT INTO `shop_truck_region` VALUES (1273, 1264, 'J', '进贤', '进贤县', 3, 'jinxian', '331700', 1, '116.24087', '28.37679');
INSERT INTO `shop_truck_region` VALUES (1274, 1263, 'J', '景德镇', '景德镇市', 2, 'jingdezhen', '333000', 1, '117.214664', '29.29256');
INSERT INTO `shop_truck_region` VALUES (1275, 1274, 'C', '昌江', '昌江区', 3, 'changjiang', '333000', 1, '117.18359', '29.27321');
INSERT INTO `shop_truck_region` VALUES (1276, 1274, 'Z', '珠山', '珠山区', 3, 'zhushan', '333000', 1, '117.20233', '29.30127');
INSERT INTO `shop_truck_region` VALUES (1277, 1274, 'F', '浮梁', '浮梁县', 3, 'fuliang', '333400', 1, '117.21517', '29.35156');
INSERT INTO `shop_truck_region` VALUES (1278, 1274, 'L', '乐平', '乐平市', 3, 'leping', '333300', 1, '117.12887', '28.96295');
INSERT INTO `shop_truck_region` VALUES (1279, 1263, 'P', '萍乡', '萍乡市', 2, 'pingxiang', '337000', 1, '113.852186', '27.622946');
INSERT INTO `shop_truck_region` VALUES (1280, 1279, 'A', '安源', '安源区', 3, 'anyuan', '337000', 1, '113.89135', '27.61653');
INSERT INTO `shop_truck_region` VALUES (1281, 1279, 'X', '湘东', '湘东区', 3, 'xiangdong', '337016', 1, '113.73294', '27.64007');
INSERT INTO `shop_truck_region` VALUES (1282, 1279, 'L', '莲花', '莲花县', 3, 'lianhua', '337100', 1, '113.96142', '27.12866');
INSERT INTO `shop_truck_region` VALUES (1283, 1279, 'S', '上栗', '上栗县', 3, 'shangli', '337009', 1, '113.79403', '27.87467');
INSERT INTO `shop_truck_region` VALUES (1284, 1279, 'L', '芦溪', '芦溪县', 3, 'luxi', '337053', 1, '114.02951', '27.63063');
INSERT INTO `shop_truck_region` VALUES (1285, 1263, 'J', '九江', '九江市', 2, 'jiujiang', '332000', 1, '115.992811', '29.712034');
INSERT INTO `shop_truck_region` VALUES (1286, 1285, 'L', '庐山', '庐山区', 3, 'lushan', '332005', 1, '115.98904', '29.67177');
INSERT INTO `shop_truck_region` VALUES (1287, 1285, NULL, '浔阳', '浔阳区', 3, 'xunyang', '332000', 1, '115.98986', '29.72786');
INSERT INTO `shop_truck_region` VALUES (1288, 1285, 'J', '九江', '九江县', 3, 'jiujiang', '332100', 1, '115.91128', '29.60852');
INSERT INTO `shop_truck_region` VALUES (1289, 1285, 'W', '武宁', '武宁县', 3, 'wuning', '332300', 1, '115.10061', '29.2584');
INSERT INTO `shop_truck_region` VALUES (1290, 1285, 'X', '修水', '修水县', 3, 'xiushui', '332400', 1, '114.54684', '29.02539');
INSERT INTO `shop_truck_region` VALUES (1291, 1285, 'Y', '永修', '永修县', 3, 'yongxiu', '330300', 1, '115.80911', '29.02093');
INSERT INTO `shop_truck_region` VALUES (1292, 1285, 'D', '德安', '德安县', 3, 'dean', '330400', 1, '115.75601', '29.31341');
INSERT INTO `shop_truck_region` VALUES (1293, 1285, 'X', '星子', '星子县', 3, 'xingzi', '332800', 1, '116.04492', '29.44608');
INSERT INTO `shop_truck_region` VALUES (1294, 1285, 'D', '都昌', '都昌县', 3, 'duchang', '332600', 1, '116.20401', '29.27327');
INSERT INTO `shop_truck_region` VALUES (1295, 1285, 'H', '湖口', '湖口县', 3, 'hukou', '332500', 1, '116.21853', '29.73818');
INSERT INTO `shop_truck_region` VALUES (1296, 1285, 'P', '彭泽', '彭泽县', 3, 'pengze', '332700', 1, '116.55011', '29.89589');
INSERT INTO `shop_truck_region` VALUES (1297, 1285, 'R', '瑞昌', '瑞昌市', 3, 'ruichang', '332200', 1, '115.66705', '29.67183');
INSERT INTO `shop_truck_region` VALUES (1298, 1285, 'G', '共青城', '共青城市', 3, 'gongqingcheng', '332020', 1, '115.801939', '29.238785');
INSERT INTO `shop_truck_region` VALUES (1299, 1263, 'X', '新余', '新余市', 2, 'xinyu', '338025', 1, '114.930835', '27.810834');
INSERT INTO `shop_truck_region` VALUES (1300, 1299, 'Y', '渝水', '渝水区', 3, 'yushui', '338025', 1, '114.944', '27.80098');
INSERT INTO `shop_truck_region` VALUES (1301, 1299, 'F', '分宜', '分宜县', 3, 'fenyi', '336600', 1, '114.69189', '27.81475');
INSERT INTO `shop_truck_region` VALUES (1302, 1263, 'Y', '鹰潭', '鹰潭市', 2, 'yingtan', '335000', 1, '117.033838', '28.238638');
INSERT INTO `shop_truck_region` VALUES (1303, 1302, 'Y', '月湖', '月湖区', 3, 'yuehu', '335000', 1, '117.03732', '28.23913');
INSERT INTO `shop_truck_region` VALUES (1304, 1302, 'Y', '余江', '余江县', 3, 'yujiang', '335200', 1, '116.81851', '28.21034');
INSERT INTO `shop_truck_region` VALUES (1305, 1302, 'G', '贵溪', '贵溪市', 3, 'guixi', '335400', 1, '117.24246', '28.2926');
INSERT INTO `shop_truck_region` VALUES (1306, 1263, 'G', '赣州', '赣州市', 2, 'ganzhou', '341000', 1, '114.940278', '25.85097');
INSERT INTO `shop_truck_region` VALUES (1307, 1306, 'Z', '章贡', '章贡区', 3, 'zhanggong', '341000', 1, '114.94284', '25.8624');
INSERT INTO `shop_truck_region` VALUES (1308, 1306, 'N', '南康', '南康区', 3, 'nankang', '341400', 1, '114.756933', '25.661721');
INSERT INTO `shop_truck_region` VALUES (1309, 1306, 'G', '赣县', '赣县', 3, 'ganxian', '341100', 1, '115.01171', '25.86149');
INSERT INTO `shop_truck_region` VALUES (1310, 1306, 'X', '信丰', '信丰县', 3, 'xinfeng', '341600', 1, '114.92279', '25.38612');
INSERT INTO `shop_truck_region` VALUES (1311, 1306, 'D', '大余', '大余县', 3, 'dayu', '341500', 1, '114.35757', '25.39561');
INSERT INTO `shop_truck_region` VALUES (1312, 1306, 'S', '上犹', '上犹县', 3, 'shangyou', '341200', 1, '114.54138', '25.79567');
INSERT INTO `shop_truck_region` VALUES (1313, 1306, 'C', '崇义', '崇义县', 3, 'chongyi', '341300', 1, '114.30835', '25.68186');
INSERT INTO `shop_truck_region` VALUES (1314, 1306, 'A', '安远', '安远县', 3, 'anyuan', '342100', 1, '115.39483', '25.1371');
INSERT INTO `shop_truck_region` VALUES (1315, 1306, 'L', '龙南', '龙南县', 3, 'longnan', '341700', 1, '114.78994', '24.91086');
INSERT INTO `shop_truck_region` VALUES (1316, 1306, 'D', '定南', '定南县', 3, 'dingnan', '341900', 1, '115.02713', '24.78395');
INSERT INTO `shop_truck_region` VALUES (1317, 1306, 'Q', '全南', '全南县', 3, 'quannan', '341800', 1, '114.5292', '24.74324');
INSERT INTO `shop_truck_region` VALUES (1318, 1306, 'N', '宁都', '宁都县', 3, 'ningdu', '342800', 1, '116.01565', '26.47227');
INSERT INTO `shop_truck_region` VALUES (1319, 1306, 'Y', '于都', '于都县', 3, 'yudu', '342300', 1, '115.41415', '25.95257');
INSERT INTO `shop_truck_region` VALUES (1320, 1306, 'X', '兴国', '兴国县', 3, 'xingguo', '342400', 1, '115.36309', '26.33776');
INSERT INTO `shop_truck_region` VALUES (1321, 1306, 'H', '会昌', '会昌县', 3, 'huichang', '342600', 1, '115.78555', '25.60068');
INSERT INTO `shop_truck_region` VALUES (1322, 1306, 'X', '寻乌', '寻乌县', 3, 'xunwu', '342200', 1, '115.64852', '24.95513');
INSERT INTO `shop_truck_region` VALUES (1323, 1306, 'S', '石城', '石城县', 3, 'shicheng', '342700', 1, '116.3442', '26.32617');
INSERT INTO `shop_truck_region` VALUES (1324, 1306, 'R', '瑞金', '瑞金市', 3, 'ruijin', '342500', 1, '116.02703', '25.88557');
INSERT INTO `shop_truck_region` VALUES (1325, 1263, 'J', '吉安', '吉安市', 2, 'jian', '343000', 1, '114.986373', '27.111699');
INSERT INTO `shop_truck_region` VALUES (1326, 1325, 'J', '吉州', '吉州区', 3, 'jizhou', '343000', 1, '114.97598', '27.10669');
INSERT INTO `shop_truck_region` VALUES (1327, 1325, 'Q', '青原', '青原区', 3, 'qingyuan', '343009', 1, '115.01747', '27.10577');
INSERT INTO `shop_truck_region` VALUES (1328, 1325, 'J', '吉安', '吉安县', 3, 'jian', '343100', 1, '114.90695', '27.04048');
INSERT INTO `shop_truck_region` VALUES (1329, 1325, 'J', '吉水', '吉水县', 3, 'jishui', '331600', 1, '115.1343', '27.21071');
INSERT INTO `shop_truck_region` VALUES (1330, 1325, 'X', '峡江', '峡江县', 3, 'xiajiang', '331409', 1, '115.31723', '27.576');
INSERT INTO `shop_truck_region` VALUES (1331, 1325, 'X', '新干', '新干县', 3, 'xingan', '331300', 1, '115.39306', '27.74092');
INSERT INTO `shop_truck_region` VALUES (1332, 1325, 'Y', '永丰', '永丰县', 3, 'yongfeng', '331500', 1, '115.44238', '27.31785');
INSERT INTO `shop_truck_region` VALUES (1333, 1325, 'T', '泰和', '泰和县', 3, 'taihe', '343700', 1, '114.90789', '26.79113');
INSERT INTO `shop_truck_region` VALUES (1334, 1325, 'S', '遂川', '遂川县', 3, 'suichuan', '343900', 1, '114.51629', '26.32598');
INSERT INTO `shop_truck_region` VALUES (1335, 1325, 'W', '万安', '万安县', 3, 'wanan', '343800', 1, '114.78659', '26.45931');
INSERT INTO `shop_truck_region` VALUES (1336, 1325, 'A', '安福', '安福县', 3, 'anfu', '343200', 1, '114.61956', '27.39276');
INSERT INTO `shop_truck_region` VALUES (1337, 1325, 'Y', '永新', '永新县', 3, 'yongxin', '343400', 1, '114.24246', '26.94488');
INSERT INTO `shop_truck_region` VALUES (1338, 1325, 'J', '井冈山', '井冈山市', 3, 'jinggangshan', '343600', 1, '114.28949', '26.74804');
INSERT INTO `shop_truck_region` VALUES (1339, 1263, 'Y', '宜春', '宜春市', 2, 'yichun', '336000', 1, '114.391136', '27.8043');
INSERT INTO `shop_truck_region` VALUES (1340, 1339, 'Y', '袁州', '袁州区', 3, 'yuanzhou', '336000', 1, '114.38246', '27.79649');
INSERT INTO `shop_truck_region` VALUES (1341, 1339, 'F', '奉新', '奉新县', 3, 'fengxin', '330700', 1, '115.40036', '28.6879');
INSERT INTO `shop_truck_region` VALUES (1342, 1339, 'W', '万载', '万载县', 3, 'wanzai', '336100', 1, '114.4458', '28.10656');
INSERT INTO `shop_truck_region` VALUES (1343, 1339, 'S', '上高', '上高县', 3, 'shanggao', '336400', 1, '114.92459', '28.23423');
INSERT INTO `shop_truck_region` VALUES (1344, 1339, 'Y', '宜丰', '宜丰县', 3, 'yifeng', '336300', 1, '114.7803', '28.38555');
INSERT INTO `shop_truck_region` VALUES (1345, 1339, 'J', '靖安', '靖安县', 3, 'jingan', '330600', 1, '115.36279', '28.86167');
INSERT INTO `shop_truck_region` VALUES (1346, 1339, 'T', '铜鼓', '铜鼓县', 3, 'tonggu', '336200', 1, '114.37036', '28.52311');
INSERT INTO `shop_truck_region` VALUES (1347, 1339, 'F', '丰城', '丰城市', 3, 'fengcheng', '331100', 1, '115.77114', '28.15918');
INSERT INTO `shop_truck_region` VALUES (1348, 1339, 'Z', '樟树', '樟树市', 3, 'zhangshu', '331200', 1, '115.5465', '28.05332');
INSERT INTO `shop_truck_region` VALUES (1349, 1339, 'G', '高安', '高安市', 3, 'gaoan', '330800', 1, '115.3753', '28.4178');
INSERT INTO `shop_truck_region` VALUES (1350, 1263, 'F', '抚州', '抚州市', 2, 'fuzhou', '344000', 1, '116.358351', '27.98385');
INSERT INTO `shop_truck_region` VALUES (1351, 1350, 'L', '临川', '临川区', 3, 'linchuan', '344000', 1, '116.35919', '27.97721');
INSERT INTO `shop_truck_region` VALUES (1352, 1350, 'N', '南城', '南城县', 3, 'nancheng', '344700', 1, '116.64419', '27.55381');
INSERT INTO `shop_truck_region` VALUES (1353, 1350, 'L', '黎川', '黎川县', 3, 'lichuan', '344600', 1, '116.90771', '27.28232');
INSERT INTO `shop_truck_region` VALUES (1354, 1350, 'N', '南丰', '南丰县', 3, 'nanfeng', '344500', 1, '116.5256', '27.21842');
INSERT INTO `shop_truck_region` VALUES (1355, 1350, 'C', '崇仁', '崇仁县', 3, 'chongren', '344200', 1, '116.06021', '27.75962');
INSERT INTO `shop_truck_region` VALUES (1356, 1350, 'L', '乐安', '乐安县', 3, 'lean', '344300', 1, '115.83108', '27.42812');
INSERT INTO `shop_truck_region` VALUES (1357, 1350, 'Y', '宜黄', '宜黄县', 3, 'yihuang', '344400', 1, '116.23626', '27.55487');
INSERT INTO `shop_truck_region` VALUES (1358, 1350, 'J', '金溪', '金溪县', 3, 'jinxi', '344800', 1, '116.77392', '27.90753');
INSERT INTO `shop_truck_region` VALUES (1359, 1350, 'Z', '资溪', '资溪县', 3, 'zixi', '335300', 1, '117.06939', '27.70493');
INSERT INTO `shop_truck_region` VALUES (1360, 1350, 'D', '东乡', '东乡县', 3, 'dongxiang', '331800', 1, '116.59039', '28.23614');
INSERT INTO `shop_truck_region` VALUES (1361, 1350, 'G', '广昌', '广昌县', 3, 'guangchang', '344900', 1, '116.32547', '26.8341');
INSERT INTO `shop_truck_region` VALUES (1362, 1263, 'S', '上饶', '上饶市', 2, 'shangrao', '334000', 1, '117.971185', '28.44442');
INSERT INTO `shop_truck_region` VALUES (1363, 1362, 'X', '信州', '信州区', 3, 'xinzhou', '334000', 1, '117.96682', '28.43121');
INSERT INTO `shop_truck_region` VALUES (1364, 1362, 'S', '上饶', '上饶县', 3, 'shangrao', '334100', 1, '117.90884', '28.44856');
INSERT INTO `shop_truck_region` VALUES (1365, 1362, 'G', '广丰', '广丰县', 3, 'guangfeng', '334600', 1, '118.19158', '28.43766');
INSERT INTO `shop_truck_region` VALUES (1366, 1362, 'Y', '玉山', '玉山县', 3, 'yushan', '334700', 1, '118.24462', '28.6818');
INSERT INTO `shop_truck_region` VALUES (1367, 1362, 'Q', '铅山', '铅山县', 3, 'yanshan', '334500', 1, '117.70996', '28.31549');
INSERT INTO `shop_truck_region` VALUES (1368, 1362, 'H', '横峰', '横峰县', 3, 'hengfeng', '334300', 1, '117.5964', '28.40716');
INSERT INTO `shop_truck_region` VALUES (1369, 1362, NULL, '弋阳', '弋阳县', 3, 'yiyang', '334400', 1, '117.45929', '28.37451');
INSERT INTO `shop_truck_region` VALUES (1370, 1362, 'Y', '余干', '余干县', 3, 'yugan', '335100', 1, '116.69555', '28.70206');
INSERT INTO `shop_truck_region` VALUES (1371, 1362, NULL, '鄱阳', '鄱阳县', 3, 'poyang', '333100', 1, '116.69967', '29.0118');
INSERT INTO `shop_truck_region` VALUES (1372, 1362, 'W', '万年', '万年县', 3, 'wannian', '335500', 1, '117.06884', '28.69537');
INSERT INTO `shop_truck_region` VALUES (1373, 1362, NULL, '婺源', '婺源县', 3, 'wuyuan', '333200', 1, '117.86105', '29.24841');
INSERT INTO `shop_truck_region` VALUES (1374, 1362, 'D', '德兴', '德兴市', 3, 'dexing', '334200', 1, '117.57919', '28.94736');
INSERT INTO `shop_truck_region` VALUES (1375, 0, 'S', '山东', '山东省', 1, 'shandong', '', 1, '117.000923', '36.675807');
INSERT INTO `shop_truck_region` VALUES (1376, 1375, 'J', '济南', '济南市', 2, 'jinan', '250001', 1, '117.000923', '36.675807');
INSERT INTO `shop_truck_region` VALUES (1377, 1376, 'L', '历下', '历下区', 3, 'lixia', '250014', 1, '117.0768', '36.66661');
INSERT INTO `shop_truck_region` VALUES (1378, 1376, 'S', '市中区', '市中区', 3, 'shizhongqu', '250001', 1, '116.99741', '36.65101');
INSERT INTO `shop_truck_region` VALUES (1379, 1376, 'H', '槐荫', '槐荫区', 3, 'huaiyin', '250117', 1, '116.90075', '36.65136');
INSERT INTO `shop_truck_region` VALUES (1380, 1376, 'T', '天桥', '天桥区', 3, 'tianqiao', '250031', 1, '116.98749', '36.67801');
INSERT INTO `shop_truck_region` VALUES (1381, 1376, 'L', '历城', '历城区', 3, 'licheng', '250100', 1, '117.06509', '36.67995');
INSERT INTO `shop_truck_region` VALUES (1382, 1376, 'C', '长清', '长清区', 3, 'changqing', '250300', 1, '116.75192', '36.55352');
INSERT INTO `shop_truck_region` VALUES (1383, 1376, 'P', '平阴', '平阴县', 3, 'pingyin', '250400', 1, '116.45587', '36.28955');
INSERT INTO `shop_truck_region` VALUES (1384, 1376, 'J', '济阳', '济阳县', 3, 'jiyang', '251400', 1, '117.17327', '36.97845');
INSERT INTO `shop_truck_region` VALUES (1385, 1376, 'S', '商河', '商河县', 3, 'shanghe', '251600', 1, '117.15722', '37.31119');
INSERT INTO `shop_truck_region` VALUES (1386, 1376, 'Z', '章丘', '章丘市', 3, 'zhangqiu', '250200', 1, '117.53677', '36.71392');
INSERT INTO `shop_truck_region` VALUES (1387, 1375, 'Q', '青岛', '青岛市', 2, 'qingdao', '266001', 1, '120.369557', '36.094406');
INSERT INTO `shop_truck_region` VALUES (1388, 1387, 'S', '市南', '市南区', 3, 'shinan', '266001', 1, '120.38773', '36.06671');
INSERT INTO `shop_truck_region` VALUES (1389, 1387, 'S', '市北', '市北区', 3, 'shibei', '266011', 1, '120.37469', '36.08734');
INSERT INTO `shop_truck_region` VALUES (1390, 1387, 'H', '黄岛', '黄岛区', 3, 'huangdao', '266500', 1, '120.19775', '35.96065');
INSERT INTO `shop_truck_region` VALUES (1391, 1387, NULL, '崂山', '崂山区', 3, 'laoshan', '266100', 1, '120.46923', '36.10717');
INSERT INTO `shop_truck_region` VALUES (1392, 1387, 'L', '李沧', '李沧区', 3, 'licang', '266021', 1, '120.43286', '36.14502');
INSERT INTO `shop_truck_region` VALUES (1393, 1387, 'C', '城阳', '城阳区', 3, 'chengyang', '266041', 1, '120.39621', '36.30735');
INSERT INTO `shop_truck_region` VALUES (1394, 1387, 'J', '胶州', '胶州市', 3, 'jiaozhou', '266300', 1, '120.0335', '36.26442');
INSERT INTO `shop_truck_region` VALUES (1395, 1387, 'J', '即墨', '即墨市', 3, 'jimo', '266200', 1, '120.44699', '36.38907');
INSERT INTO `shop_truck_region` VALUES (1396, 1387, 'P', '平度', '平度市', 3, 'pingdu', '266700', 1, '119.95996', '36.78688');
INSERT INTO `shop_truck_region` VALUES (1397, 1387, 'L', '莱西', '莱西市', 3, 'laixi', '266600', 1, '120.51773', '36.88804');
INSERT INTO `shop_truck_region` VALUES (1398, 1387, 'X', '西海岸', '西海岸新区', 3, 'xihaian', '266500', 1, '120.19775', '35.96065');
INSERT INTO `shop_truck_region` VALUES (1399, 1375, 'Z', '淄博', '淄博市', 2, 'zibo', '255039', 1, '118.047648', '36.814939');
INSERT INTO `shop_truck_region` VALUES (1400, 1399, 'Z', '淄川', '淄川区', 3, 'zichuan', '255100', 1, '117.96655', '36.64339');
INSERT INTO `shop_truck_region` VALUES (1401, 1399, 'Z', '张店', '张店区', 3, 'zhangdian', '255022', 1, '118.01788', '36.80676');
INSERT INTO `shop_truck_region` VALUES (1402, 1399, 'B', '博山', '博山区', 3, 'boshan', '255200', 1, '117.86166', '36.49469');
INSERT INTO `shop_truck_region` VALUES (1403, 1399, 'L', '临淄', '临淄区', 3, 'linzi', '255400', 1, '118.30966', '36.8259');
INSERT INTO `shop_truck_region` VALUES (1404, 1399, 'Z', '周村', '周村区', 3, 'zhoucun', '255300', 1, '117.86969', '36.80322');
INSERT INTO `shop_truck_region` VALUES (1405, 1399, 'H', '桓台', '桓台县', 3, 'huantai', '256400', 1, '118.09698', '36.96036');
INSERT INTO `shop_truck_region` VALUES (1406, 1399, 'G', '高青', '高青县', 3, 'gaoqing', '256300', 1, '117.82708', '37.17197');
INSERT INTO `shop_truck_region` VALUES (1407, 1399, 'Y', '沂源', '沂源县', 3, 'yiyuan', '256100', 1, '118.17105', '36.18536');
INSERT INTO `shop_truck_region` VALUES (1408, 1375, 'Z', '枣庄', '枣庄市', 2, 'zaozhuang', '277101', 1, '117.557964', '34.856424');
INSERT INTO `shop_truck_region` VALUES (1409, 1408, 'S', '市中区', '市中区', 3, 'shizhongqu', '277101', 1, '117.55603', '34.86391');
INSERT INTO `shop_truck_region` VALUES (1410, 1408, 'X', '薛城', '薛城区', 3, 'xuecheng', '277000', 1, '117.26318', '34.79498');
INSERT INTO `shop_truck_region` VALUES (1411, 1408, NULL, '峄城', '峄城区', 3, 'yicheng', '277300', 1, '117.59057', '34.77225');
INSERT INTO `shop_truck_region` VALUES (1412, 1408, 'T', '台儿庄', '台儿庄区', 3, 'taierzhuang', '277400', 1, '117.73452', '34.56363');
INSERT INTO `shop_truck_region` VALUES (1413, 1408, 'S', '山亭', '山亭区', 3, 'shanting', '277200', 1, '117.4663', '35.09541');
INSERT INTO `shop_truck_region` VALUES (1414, 1408, NULL, '滕州', '滕州市', 3, 'tengzhou', '277500', 1, '117.165', '35.10534');
INSERT INTO `shop_truck_region` VALUES (1415, 1375, 'D', '东营', '东营市', 2, 'dongying', '257093', 1, '118.4963', '37.461266');
INSERT INTO `shop_truck_region` VALUES (1416, 1415, 'D', '东营', '东营区', 3, 'dongying', '257029', 1, '118.5816', '37.44875');
INSERT INTO `shop_truck_region` VALUES (1417, 1415, 'H', '河口', '河口区', 3, 'hekou', '257200', 1, '118.5249', '37.88541');
INSERT INTO `shop_truck_region` VALUES (1418, 1415, 'K', '垦利', '垦利县', 3, 'kenli', '257500', 1, '118.54815', '37.58825');
INSERT INTO `shop_truck_region` VALUES (1419, 1415, 'L', '利津', '利津县', 3, 'lijin', '257400', 1, '118.25637', '37.49157');
INSERT INTO `shop_truck_region` VALUES (1420, 1415, 'G', '广饶', '广饶县', 3, 'guangrao', '257300', 1, '118.40704', '37.05381');
INSERT INTO `shop_truck_region` VALUES (1421, 1375, 'Y', '烟台', '烟台市', 2, 'yantai', '264010', 1, '121.391382', '37.539297');
INSERT INTO `shop_truck_region` VALUES (1422, 1421, 'Z', '芝罘', '芝罘区', 3, 'zhifu', '264001', 1, '121.40023', '37.54064');
INSERT INTO `shop_truck_region` VALUES (1423, 1421, 'F', '福山', '福山区', 3, 'fushan', '265500', 1, '121.26812', '37.49841');
INSERT INTO `shop_truck_region` VALUES (1424, 1421, 'M', '牟平', '牟平区', 3, 'muping', '264100', 1, '121.60067', '37.38846');
INSERT INTO `shop_truck_region` VALUES (1425, 1421, 'L', '莱山', '莱山区', 3, 'laishan', '264600', 1, '121.44512', '37.51165');
INSERT INTO `shop_truck_region` VALUES (1426, 1421, 'C', '长岛', '长岛县', 3, 'changdao', '265800', 1, '120.738', '37.91754');
INSERT INTO `shop_truck_region` VALUES (1427, 1421, 'L', '龙口', '龙口市', 3, 'longkou', '265700', 1, '120.50634', '37.64064');
INSERT INTO `shop_truck_region` VALUES (1428, 1421, 'L', '莱阳', '莱阳市', 3, 'laiyang', '265200', 1, '120.71066', '36.98012');
INSERT INTO `shop_truck_region` VALUES (1429, 1421, 'L', '莱州', '莱州市', 3, 'laizhou', '261400', 1, '119.94137', '37.17806');
INSERT INTO `shop_truck_region` VALUES (1430, 1421, 'P', '蓬莱', '蓬莱市', 3, 'penglai', '265600', 1, '120.75988', '37.81119');
INSERT INTO `shop_truck_region` VALUES (1431, 1421, 'Z', '招远', '招远市', 3, 'zhaoyuan', '265400', 1, '120.40481', '37.36269');
INSERT INTO `shop_truck_region` VALUES (1432, 1421, 'Q', '栖霞', '栖霞市', 3, 'qixia', '265300', 1, '120.85025', '37.33571');
INSERT INTO `shop_truck_region` VALUES (1433, 1421, 'H', '海阳', '海阳市', 3, 'haiyang', '265100', 1, '121.15976', '36.77622');
INSERT INTO `shop_truck_region` VALUES (1434, 1375, 'W', '潍坊', '潍坊市', 2, 'weifang', '261041', 1, '119.107078', '36.70925');
INSERT INTO `shop_truck_region` VALUES (1435, 1434, 'W', '潍城', '潍城区', 3, 'weicheng', '261021', 1, '119.10582', '36.7139');
INSERT INTO `shop_truck_region` VALUES (1436, 1434, 'H', '寒亭', '寒亭区', 3, 'hanting', '261100', 1, '119.21832', '36.77504');
INSERT INTO `shop_truck_region` VALUES (1437, 1434, 'F', '坊子', '坊子区', 3, 'fangzi', '261200', 1, '119.16476', '36.65218');
INSERT INTO `shop_truck_region` VALUES (1438, 1434, 'K', '奎文', '奎文区', 3, 'kuiwen', '261031', 1, '119.12532', '36.70723');
INSERT INTO `shop_truck_region` VALUES (1439, 1434, 'L', '临朐', '临朐县', 3, 'linqu', '262600', 1, '118.544', '36.51216');
INSERT INTO `shop_truck_region` VALUES (1440, 1434, 'C', '昌乐', '昌乐县', 3, 'changle', '262400', 1, '118.83017', '36.7078');
INSERT INTO `shop_truck_region` VALUES (1441, 1434, 'Q', '青州', '青州市', 3, 'qingzhou', '262500', 1, '118.47915', '36.68505');
INSERT INTO `shop_truck_region` VALUES (1442, 1434, 'Z', '诸城', '诸城市', 3, 'zhucheng', '262200', 1, '119.40988', '35.99662');
INSERT INTO `shop_truck_region` VALUES (1443, 1434, 'S', '寿光', '寿光市', 3, 'shouguang', '262700', 1, '118.74047', '36.88128');
INSERT INTO `shop_truck_region` VALUES (1444, 1434, 'A', '安丘', '安丘市', 3, 'anqiu', '262100', 1, '119.2189', '36.47847');
INSERT INTO `shop_truck_region` VALUES (1445, 1434, 'G', '高密', '高密市', 3, 'gaomi', '261500', 1, '119.75701', '36.38397');
INSERT INTO `shop_truck_region` VALUES (1446, 1434, 'C', '昌邑', '昌邑市', 3, 'changyi', '261300', 1, '119.39767', '36.86008');
INSERT INTO `shop_truck_region` VALUES (1447, 1375, 'J', '济宁', '济宁市', 2, 'jining', '272119', 1, '116.587245', '35.415393');
INSERT INTO `shop_truck_region` VALUES (1448, 1447, 'R', '任城', '任城区', 3, 'rencheng', '272113', 1, '116.59504', '35.40659');
INSERT INTO `shop_truck_region` VALUES (1449, 1447, NULL, '兖州', '兖州区', 3, 'yanzhou', '272000', 1, '116.826546', '35.552305');
INSERT INTO `shop_truck_region` VALUES (1450, 1447, 'W', '微山', '微山县', 3, 'weishan', '277600', 1, '117.12875', '34.80712');
INSERT INTO `shop_truck_region` VALUES (1451, 1447, 'Y', '鱼台', '鱼台县', 3, 'yutai', '272300', 1, '116.64761', '34.99674');
INSERT INTO `shop_truck_region` VALUES (1452, 1447, 'J', '金乡', '金乡县', 3, 'jinxiang', '272200', 1, '116.31146', '35.065');
INSERT INTO `shop_truck_region` VALUES (1453, 1447, 'J', '嘉祥', '嘉祥县', 3, 'jiaxiang', '272400', 1, '116.34249', '35.40836');
INSERT INTO `shop_truck_region` VALUES (1454, 1447, NULL, '汶上', '汶上县', 3, 'wenshang', '272501', 1, '116.48742', '35.73295');
INSERT INTO `shop_truck_region` VALUES (1455, 1447, NULL, '泗水', '泗水县', 3, 'sishui', '273200', 1, '117.27948', '35.66113');
INSERT INTO `shop_truck_region` VALUES (1456, 1447, 'L', '梁山', '梁山县', 3, 'liangshan', '272600', 1, '116.09683', '35.80322');
INSERT INTO `shop_truck_region` VALUES (1457, 1447, 'Q', '曲阜', '曲阜市', 3, 'qufu', '273100', 1, '116.98645', '35.58091');
INSERT INTO `shop_truck_region` VALUES (1458, 1447, 'Z', '邹城', '邹城市', 3, 'zoucheng', '273500', 1, '116.97335', '35.40531');
INSERT INTO `shop_truck_region` VALUES (1459, 1375, 'T', '泰安', '泰安市', 2, 'taian', '271000', 1, '117.129063', '36.194968');
INSERT INTO `shop_truck_region` VALUES (1460, 1459, 'T', '泰山', '泰山区', 3, 'taishan', '271000', 1, '117.13446', '36.19411');
INSERT INTO `shop_truck_region` VALUES (1461, 1459, NULL, '岱岳', '岱岳区', 3, 'daiyue', '271000', 1, '117.04174', '36.1875');
INSERT INTO `shop_truck_region` VALUES (1462, 1459, 'N', '宁阳', '宁阳县', 3, 'ningyang', '271400', 1, '116.80542', '35.7599');
INSERT INTO `shop_truck_region` VALUES (1463, 1459, 'D', '东平', '东平县', 3, 'dongping', '271500', 1, '116.47113', '35.93792');
INSERT INTO `shop_truck_region` VALUES (1464, 1459, 'X', '新泰', '新泰市', 3, 'xintai', '271200', 1, '117.76959', '35.90887');
INSERT INTO `shop_truck_region` VALUES (1465, 1459, 'F', '肥城', '肥城市', 3, 'feicheng', '271600', 1, '116.76815', '36.18247');
INSERT INTO `shop_truck_region` VALUES (1466, 1375, 'W', '威海', '威海市', 2, 'weihai', '264200', 1, '122.116394', '37.509691');
INSERT INTO `shop_truck_region` VALUES (1467, 1466, 'H', '环翠', '环翠区', 3, 'huancui', '264200', 1, '122.12344', '37.50199');
INSERT INTO `shop_truck_region` VALUES (1468, 1466, 'W', '文登', '文登区', 3, 'wendeng', '266440', 1, '122.057139', '37.196211');
INSERT INTO `shop_truck_region` VALUES (1469, 1466, 'R', '荣成', '荣成市', 3, 'rongcheng', '264300', 1, '122.48773', '37.1652');
INSERT INTO `shop_truck_region` VALUES (1470, 1466, 'R', '乳山', '乳山市', 3, 'rushan', '264500', 1, '121.53814', '36.91918');
INSERT INTO `shop_truck_region` VALUES (1471, 1375, 'R', '日照', '日照市', 2, 'rizhao', '276800', 1, '119.461208', '35.428588');
INSERT INTO `shop_truck_region` VALUES (1472, 1471, 'D', '东港', '东港区', 3, 'donggang', '276800', 1, '119.46237', '35.42541');
INSERT INTO `shop_truck_region` VALUES (1473, 1471, NULL, '岚山', '岚山区', 3, 'lanshan', '276808', 1, '119.31884', '35.12203');
INSERT INTO `shop_truck_region` VALUES (1474, 1471, 'W', '五莲', '五莲县', 3, 'wulian', '262300', 1, '119.207', '35.75004');
INSERT INTO `shop_truck_region` VALUES (1475, 1471, NULL, '莒县', '莒县', 3, 'juxian', '276500', 1, '118.83789', '35.58054');
INSERT INTO `shop_truck_region` VALUES (1476, 1375, 'L', '莱芜', '莱芜市', 2, 'laiwu', '271100', 1, '117.677736', '36.214397');
INSERT INTO `shop_truck_region` VALUES (1477, 1476, 'L', '莱城', '莱城区', 3, 'laicheng', '271199', 1, '117.65986', '36.2032');
INSERT INTO `shop_truck_region` VALUES (1478, 1476, 'G', '钢城', '钢城区', 3, 'gangcheng', '271100', 1, '117.8049', '36.06319');
INSERT INTO `shop_truck_region` VALUES (1479, 1375, 'L', '临沂', '临沂市', 2, 'linyi', '253000', 1, '118.326443', '35.065282');
INSERT INTO `shop_truck_region` VALUES (1480, 1479, 'L', '兰山', '兰山区', 3, 'lanshan', '276002', 1, '118.34817', '35.06872');
INSERT INTO `shop_truck_region` VALUES (1481, 1479, 'L', '罗庄', '罗庄区', 3, 'luozhuang', '276022', 1, '118.28466', '34.99627');
INSERT INTO `shop_truck_region` VALUES (1482, 1479, 'H', '河东', '河东区', 3, 'hedong', '276034', 1, '118.41055', '35.08803');
INSERT INTO `shop_truck_region` VALUES (1483, 1479, 'Y', '沂南', '沂南县', 3, 'yinan', '276300', 1, '118.47061', '35.55131');
INSERT INTO `shop_truck_region` VALUES (1484, 1479, NULL, '郯城', '郯城县', 3, 'tancheng', '276100', 1, '118.36712', '34.61354');
INSERT INTO `shop_truck_region` VALUES (1485, 1479, 'Y', '沂水', '沂水县', 3, 'yishui', '276400', 1, '118.63009', '35.78731');
INSERT INTO `shop_truck_region` VALUES (1486, 1479, 'L', '兰陵', '兰陵县', 3, 'lanling', '277700', 1, '117.856592', '34.738315');
INSERT INTO `shop_truck_region` VALUES (1487, 1479, 'F', '费县', '费县', 3, 'feixian', '273400', 1, '117.97836', '35.26562');
INSERT INTO `shop_truck_region` VALUES (1488, 1479, 'P', '平邑', '平邑县', 3, 'pingyi', '273300', 1, '117.63867', '35.50573');
INSERT INTO `shop_truck_region` VALUES (1489, 1479, NULL, '莒南', '莒南县', 3, 'junan', '276600', 1, '118.83227', '35.17539');
INSERT INTO `shop_truck_region` VALUES (1490, 1479, 'M', '蒙阴', '蒙阴县', 3, 'mengyin', '276200', 1, '117.94592', '35.70996');
INSERT INTO `shop_truck_region` VALUES (1491, 1479, 'L', '临沭', '临沭县', 3, 'linshu', '276700', 1, '118.65267', '34.92091');
INSERT INTO `shop_truck_region` VALUES (1492, 1375, 'D', '德州', '德州市', 2, 'dezhou', '253000', 1, '116.307428', '37.453968');
INSERT INTO `shop_truck_region` VALUES (1493, 1492, 'D', '德城', '德城区', 3, 'decheng', '253012', 1, '116.29943', '37.45126');
INSERT INTO `shop_truck_region` VALUES (1494, 1492, 'L', '陵城', '陵城区', 3, 'lingcheng', '253500', 1, '116.57601', '37.33571');
INSERT INTO `shop_truck_region` VALUES (1495, 1492, 'N', '宁津', '宁津县', 3, 'ningjin', '253400', 1, '116.79702', '37.65301');
INSERT INTO `shop_truck_region` VALUES (1496, 1492, 'Q', '庆云', '庆云县', 3, 'qingyun', '253700', 1, '117.38635', '37.77616');
INSERT INTO `shop_truck_region` VALUES (1497, 1492, 'L', '临邑', '临邑县', 3, 'linyi', '251500', 1, '116.86547', '37.19053');
INSERT INTO `shop_truck_region` VALUES (1498, 1492, 'Q', '齐河', '齐河县', 3, 'qihe', '251100', 1, '116.75515', '36.79532');
INSERT INTO `shop_truck_region` VALUES (1499, 1492, 'P', '平原', '平原县', 3, 'pingyuan', '253100', 1, '116.43432', '37.16632');
INSERT INTO `shop_truck_region` VALUES (1500, 1492, 'X', '夏津', '夏津县', 3, 'xiajin', '253200', 1, '116.0017', '36.94852');
INSERT INTO `shop_truck_region` VALUES (1501, 1492, 'W', '武城', '武城县', 3, 'wucheng', '253300', 1, '116.07009', '37.21403');
INSERT INTO `shop_truck_region` VALUES (1502, 1492, 'L', '乐陵', '乐陵市', 3, 'leling', '253600', 1, '117.23141', '37.73164');
INSERT INTO `shop_truck_region` VALUES (1503, 1492, 'Y', '禹城', '禹城市', 3, 'yucheng', '251200', 1, '116.64309', '36.93444');
INSERT INTO `shop_truck_region` VALUES (1504, 1375, 'L', '聊城', '聊城市', 2, 'liaocheng', '252052', 1, '115.980367', '36.456013');
INSERT INTO `shop_truck_region` VALUES (1505, 1504, 'D', '东昌府', '东昌府区', 3, 'dongchangfu', '252000', 1, '115.97383', '36.44458');
INSERT INTO `shop_truck_region` VALUES (1506, 1504, 'Y', '阳谷', '阳谷县', 3, 'yanggu', '252300', 1, '115.79126', '36.11444');
INSERT INTO `shop_truck_region` VALUES (1507, 1504, NULL, '莘县', '莘县', 3, 'shenxian', '252400', 1, '115.6697', '36.23423');
INSERT INTO `shop_truck_region` VALUES (1508, 1504, NULL, '茌平', '茌平县', 3, 'chiping', '252100', 1, '116.25491', '36.57969');
INSERT INTO `shop_truck_region` VALUES (1509, 1504, 'D', '东阿', '东阿县', 3, 'donge', '252200', 1, '116.25012', '36.33209');
INSERT INTO `shop_truck_region` VALUES (1510, 1504, 'G', '冠县', '冠县', 3, 'guanxian', '252500', 1, '115.44195', '36.48429');
INSERT INTO `shop_truck_region` VALUES (1511, 1504, 'G', '高唐', '高唐县', 3, 'gaotang', '252800', 1, '116.23172', '36.86535');
INSERT INTO `shop_truck_region` VALUES (1512, 1504, 'L', '临清', '临清市', 3, 'linqing', '252600', 1, '115.70629', '36.83945');
INSERT INTO `shop_truck_region` VALUES (1513, 1375, 'B', '滨州', '滨州市', 2, 'binzhou', '256619', 1, '118.016974', '37.383542');
INSERT INTO `shop_truck_region` VALUES (1514, 1513, 'B', '滨城', '滨城区', 3, 'bincheng', '256613', 1, '118.02026', '37.38524');
INSERT INTO `shop_truck_region` VALUES (1515, 1513, 'Z', '沾化', '沾化区', 3, 'zhanhua', '256800', 1, '118.13214', '37.69832');
INSERT INTO `shop_truck_region` VALUES (1516, 1513, 'H', '惠民', '惠民县', 3, 'huimin', '251700', 1, '117.51113', '37.49013');
INSERT INTO `shop_truck_region` VALUES (1517, 1513, 'Y', '阳信', '阳信县', 3, 'yangxin', '251800', 1, '117.58139', '37.64198');
INSERT INTO `shop_truck_region` VALUES (1518, 1513, 'W', '无棣', '无棣县', 3, 'wudi', '251900', 1, '117.61395', '37.74009');
INSERT INTO `shop_truck_region` VALUES (1519, 1513, 'B', '博兴', '博兴县', 3, 'boxing', '256500', 1, '118.1336', '37.14316');
INSERT INTO `shop_truck_region` VALUES (1520, 1513, 'Z', '邹平', '邹平县', 3, 'zouping', '256200', 1, '117.74307', '36.86295');
INSERT INTO `shop_truck_region` VALUES (1521, 1513, 'B', '北海新区', '北海新区', 3, 'beihaixinqu', '256200', 1, '118.016974', '37.383542');
INSERT INTO `shop_truck_region` VALUES (1522, 1375, 'H', '菏泽', '菏泽市', 2, 'heze', '274020', 1, '115.469381', '35.246531');
INSERT INTO `shop_truck_region` VALUES (1523, 1522, 'M', '牡丹', '牡丹区', 3, 'mudan', '274009', 1, '115.41662', '35.25091');
INSERT INTO `shop_truck_region` VALUES (1524, 1522, 'C', '曹县', '曹县', 3, 'caoxian', '274400', 1, '115.54226', '34.82659');
INSERT INTO `shop_truck_region` VALUES (1525, 1522, 'D', '单县', '单县', 3, 'shanxian', '273700', 1, '116.08703', '34.79514');
INSERT INTO `shop_truck_region` VALUES (1526, 1522, 'C', '成武', '成武县', 3, 'chengwu', '274200', 1, '115.8897', '34.95332');
INSERT INTO `shop_truck_region` VALUES (1527, 1522, 'J', '巨野', '巨野县', 3, 'juye', '274900', 1, '116.09497', '35.39788');
INSERT INTO `shop_truck_region` VALUES (1528, 1522, NULL, '郓城', '郓城县', 3, 'yuncheng', '274700', 1, '115.94439', '35.60044');
INSERT INTO `shop_truck_region` VALUES (1529, 1522, NULL, '鄄城', '鄄城县', 3, 'juancheng', '274600', 1, '115.50997', '35.56412');
INSERT INTO `shop_truck_region` VALUES (1530, 1522, 'D', '定陶', '定陶县', 3, 'dingtao', '274100', 1, '115.57287', '35.07118');
INSERT INTO `shop_truck_region` VALUES (1531, 1522, 'D', '东明', '东明县', 3, 'dongming', '274500', 1, '115.09079', '35.28906');
INSERT INTO `shop_truck_region` VALUES (1532, 0, 'H', '河南', '河南省', 1, 'henan', '', 1, '113.665412', '34.757975');
INSERT INTO `shop_truck_region` VALUES (1533, 1532, 'Z', '郑州', '郑州市', 2, 'zhengzhou', '450000', 1, '113.665412', '34.757975');
INSERT INTO `shop_truck_region` VALUES (1534, 1533, 'Z', '中原', '中原区', 3, 'zhongyuan', '450007', 1, '113.61333', '34.74827');
INSERT INTO `shop_truck_region` VALUES (1535, 1533, 'E', '二七', '二七区', 3, 'erqi', '450052', 1, '113.63931', '34.72336');
INSERT INTO `shop_truck_region` VALUES (1536, 1533, 'G', '管城', '管城回族区', 3, 'guancheng', '450000', 1, '113.67734', '34.75383');
INSERT INTO `shop_truck_region` VALUES (1537, 1533, 'J', '金水', '金水区', 3, 'jinshui', '450003', 1, '113.66057', '34.80028');
INSERT INTO `shop_truck_region` VALUES (1538, 1533, 'S', '上街', '上街区', 3, 'shangjie', '450041', 1, '113.30897', '34.80276');
INSERT INTO `shop_truck_region` VALUES (1539, 1533, 'H', '惠济', '惠济区', 3, 'huiji', '450053', 1, '113.61688', '34.86735');
INSERT INTO `shop_truck_region` VALUES (1540, 1533, 'Z', '中牟', '中牟县', 3, 'zhongmu', '451450', 1, '113.97619', '34.71899');
INSERT INTO `shop_truck_region` VALUES (1541, 1533, 'G', '巩义', '巩义市', 3, 'gongyi', '451200', 1, '113.022', '34.74794');
INSERT INTO `shop_truck_region` VALUES (1542, 1533, NULL, '荥阳', '荥阳市', 3, 'xingyang', '450100', 1, '113.38345', '34.78759');
INSERT INTO `shop_truck_region` VALUES (1543, 1533, 'X', '新密', '新密市', 3, 'xinmi', '452300', 1, '113.3869', '34.53704');
INSERT INTO `shop_truck_region` VALUES (1544, 1533, 'X', '新郑', '新郑市', 3, 'xinzheng', '451100', 1, '113.73645', '34.3955');
INSERT INTO `shop_truck_region` VALUES (1545, 1533, 'D', '登封', '登封市', 3, 'dengfeng', '452470', 1, '113.05023', '34.45345');
INSERT INTO `shop_truck_region` VALUES (1546, 1532, 'K', '开封', '开封市', 2, 'kaifeng', '475001', 1, '114.341447', '34.797049');
INSERT INTO `shop_truck_region` VALUES (1547, 1546, 'L', '龙亭', '龙亭区', 3, 'longting', '475100', 1, '114.35484', '34.79995');
INSERT INTO `shop_truck_region` VALUES (1548, 1546, 'S', '顺河', '顺河回族区', 3, 'shunhe', '475000', 1, '114.36123', '34.79586');
INSERT INTO `shop_truck_region` VALUES (1549, 1546, 'G', '鼓楼', '鼓楼区', 3, 'gulou', '475000', 1, '114.35559', '34.79517');
INSERT INTO `shop_truck_region` VALUES (1550, 1546, 'Y', '禹王台', '禹王台区', 3, 'yuwangtai', '475003', 1, '114.34787', '34.77693');
INSERT INTO `shop_truck_region` VALUES (1551, 1546, 'X', '祥符', '祥符区', 3, 'xiangfu', '475100', 1, '114.43859', '34.75874');
INSERT INTO `shop_truck_region` VALUES (1552, 1546, NULL, '杞县', '杞县', 3, 'qixian', '475200', 1, '114.7828', '34.55033');
INSERT INTO `shop_truck_region` VALUES (1553, 1546, 'T', '通许', '通许县', 3, 'tongxu', '475400', 1, '114.46716', '34.47522');
INSERT INTO `shop_truck_region` VALUES (1554, 1546, 'W', '尉氏', '尉氏县', 3, 'weishi', '475500', 1, '114.19284', '34.41223');
INSERT INTO `shop_truck_region` VALUES (1555, 1546, 'L', '兰考', '兰考县', 3, 'lankao', '475300', 1, '114.81961', '34.8235');
INSERT INTO `shop_truck_region` VALUES (1556, 1532, 'L', '洛阳', '洛阳市', 2, 'luoyang', '471000', 1, '112.434468', '34.663041');
INSERT INTO `shop_truck_region` VALUES (1557, 1556, 'L', '老城', '老城区', 3, 'laocheng', '471002', 1, '112.46902', '34.68364');
INSERT INTO `shop_truck_region` VALUES (1558, 1556, 'X', '西工', '西工区', 3, 'xigong', '471000', 1, '112.4371', '34.67');
INSERT INTO `shop_truck_region` VALUES (1559, 1556, NULL, '瀍河', '瀍河回族区', 3, 'chanhe', '471002', 1, '112.50018', '34.67985');
INSERT INTO `shop_truck_region` VALUES (1560, 1556, 'J', '涧西', '涧西区', 3, 'jianxi', '471003', 1, '112.39588', '34.65823');
INSERT INTO `shop_truck_region` VALUES (1561, 1556, 'J', '吉利', '吉利区', 3, 'jili', '471012', 1, '112.58905', '34.90088');
INSERT INTO `shop_truck_region` VALUES (1562, 1556, 'L', '洛龙', '洛龙区', 3, 'luolong', '471000', 1, '112.46412', '34.61866');
INSERT INTO `shop_truck_region` VALUES (1563, 1556, 'M', '孟津', '孟津县', 3, 'mengjin', '471100', 1, '112.44351', '34.826');
INSERT INTO `shop_truck_region` VALUES (1564, 1556, 'X', '新安', '新安县', 3, 'xinan', '471800', 1, '112.13238', '34.72814');
INSERT INTO `shop_truck_region` VALUES (1565, 1556, NULL, '栾川', '栾川县', 3, 'luanchuan', '471500', 1, '111.61779', '33.78576');
INSERT INTO `shop_truck_region` VALUES (1566, 1556, NULL, '嵩县', '嵩县', 3, 'songxian', '471400', 1, '112.08526', '34.13466');
INSERT INTO `shop_truck_region` VALUES (1567, 1556, 'R', '汝阳', '汝阳县', 3, 'ruyang', '471200', 1, '112.47314', '34.15387');
INSERT INTO `shop_truck_region` VALUES (1568, 1556, 'Y', '宜阳', '宜阳县', 3, 'yiyang', '471600', 1, '112.17907', '34.51523');
INSERT INTO `shop_truck_region` VALUES (1569, 1556, 'L', '洛宁', '洛宁县', 3, 'luoning', '471700', 1, '111.65087', '34.38913');
INSERT INTO `shop_truck_region` VALUES (1570, 1556, 'Y', '伊川', '伊川县', 3, 'yichuan', '471300', 1, '112.42947', '34.42205');
INSERT INTO `shop_truck_region` VALUES (1571, 1556, NULL, '偃师', '偃师市', 3, 'yanshi', '471900', 1, '112.7922', '34.7281');
INSERT INTO `shop_truck_region` VALUES (1572, 1532, 'P', '平顶山', '平顶山市', 2, 'pingdingshan', '467000', 1, '113.307718', '33.735241');
INSERT INTO `shop_truck_region` VALUES (1573, 1572, 'X', '新华', '新华区', 3, 'xinhua', '467002', 1, '113.29402', '33.7373');
INSERT INTO `shop_truck_region` VALUES (1574, 1572, 'W', '卫东', '卫东区', 3, 'weidong', '467021', 1, '113.33511', '33.73472');
INSERT INTO `shop_truck_region` VALUES (1575, 1572, 'S', '石龙', '石龙区', 3, 'shilong', '467045', 1, '112.89879', '33.89878');
INSERT INTO `shop_truck_region` VALUES (1576, 1572, 'Z', '湛河', '湛河区', 3, 'zhanhe', '467000', 1, '113.29252', '33.7362');
INSERT INTO `shop_truck_region` VALUES (1577, 1572, 'B', '宝丰', '宝丰县', 3, 'baofeng', '467400', 1, '113.05493', '33.86916');
INSERT INTO `shop_truck_region` VALUES (1578, 1572, 'Y', '叶县', '叶县', 3, 'yexian', '467200', 1, '113.35104', '33.62225');
INSERT INTO `shop_truck_region` VALUES (1579, 1572, 'L', '鲁山', '鲁山县', 3, 'lushan', '467300', 1, '112.9057', '33.73879');
INSERT INTO `shop_truck_region` VALUES (1580, 1572, NULL, '郏县', '郏县', 3, 'jiaxian', '467100', 1, '113.21588', '33.97072');
INSERT INTO `shop_truck_region` VALUES (1581, 1572, 'W', '舞钢', '舞钢市', 3, 'wugang', '462500', 1, '113.52417', '33.2938');
INSERT INTO `shop_truck_region` VALUES (1582, 1572, 'R', '汝州', '汝州市', 3, 'ruzhou', '467500', 1, '112.84301', '34.16135');
INSERT INTO `shop_truck_region` VALUES (1583, 1532, 'A', '安阳', '安阳市', 2, 'anyang', '455000', 1, '114.352482', '36.103442');
INSERT INTO `shop_truck_region` VALUES (1584, 1583, 'W', '文峰', '文峰区', 3, 'wenfeng', '455000', 1, '114.35708', '36.09046');
INSERT INTO `shop_truck_region` VALUES (1585, 1583, 'B', '北关', '北关区', 3, 'beiguan', '455001', 1, '114.35735', '36.11872');
INSERT INTO `shop_truck_region` VALUES (1586, 1583, 'Y', '殷都', '殷都区', 3, 'yindu', '455004', 1, '114.3034', '36.1099');
INSERT INTO `shop_truck_region` VALUES (1587, 1583, 'L', '龙安', '龙安区', 3, 'longan', '455001', 1, '114.34814', '36.11904');
INSERT INTO `shop_truck_region` VALUES (1588, 1583, 'A', '安阳', '安阳县', 3, 'anyang', '455000', 1, '114.36605', '36.06695');
INSERT INTO `shop_truck_region` VALUES (1589, 1583, 'T', '汤阴', '汤阴县', 3, 'tangyin', '456150', 1, '114.35839', '35.92152');
INSERT INTO `shop_truck_region` VALUES (1590, 1583, 'H', '滑县', '滑县', 3, 'huaxian', '456400', 1, '114.52066', '35.5807');
INSERT INTO `shop_truck_region` VALUES (1591, 1583, 'N', '内黄', '内黄县', 3, 'neihuang', '456350', 1, '114.90673', '35.95269');
INSERT INTO `shop_truck_region` VALUES (1592, 1583, 'L', '林州', '林州市', 3, 'linzhou', '456550', 1, '113.81558', '36.07804');
INSERT INTO `shop_truck_region` VALUES (1593, 1532, 'H', '鹤壁', '鹤壁市', 2, 'hebi', '458030', 1, '114.295444', '35.748236');
INSERT INTO `shop_truck_region` VALUES (1594, 1593, 'H', '鹤山', '鹤山区', 3, 'heshan', '458010', 1, '114.16336', '35.95458');
INSERT INTO `shop_truck_region` VALUES (1595, 1593, 'S', '山城', '山城区', 3, 'shancheng', '458000', 1, '114.18443', '35.89773');
INSERT INTO `shop_truck_region` VALUES (1596, 1593, NULL, '淇滨', '淇滨区', 3, 'qibin', '458000', 1, '114.29867', '35.74127');
INSERT INTO `shop_truck_region` VALUES (1597, 1593, 'J', '浚县', '浚县', 3, 'xunxian', '456250', 1, '114.54879', '35.67085');
INSERT INTO `shop_truck_region` VALUES (1598, 1593, NULL, '淇县', '淇县', 3, 'qixian', '456750', 1, '114.1976', '35.60782');
INSERT INTO `shop_truck_region` VALUES (1599, 1532, 'X', '新乡', '新乡市', 2, 'xinxiang', '453000', 1, '113.883991', '35.302616');
INSERT INTO `shop_truck_region` VALUES (1600, 1599, 'H', '红旗', '红旗区', 3, 'hongqi', '453000', 1, '113.87523', '35.30367');
INSERT INTO `shop_truck_region` VALUES (1601, 1599, 'W', '卫滨', '卫滨区', 3, 'weibin', '453000', 1, '113.86578', '35.30211');
INSERT INTO `shop_truck_region` VALUES (1602, 1599, 'F', '凤泉', '凤泉区', 3, 'fengquan', '453011', 1, '113.91507', '35.38399');
INSERT INTO `shop_truck_region` VALUES (1603, 1599, 'M', '牧野', '牧野区', 3, 'muye', '453002', 1, '113.9086', '35.3149');
INSERT INTO `shop_truck_region` VALUES (1604, 1599, 'X', '新乡', '新乡县', 3, 'xinxiang', '453700', 1, '113.80511', '35.19075');
INSERT INTO `shop_truck_region` VALUES (1605, 1599, 'H', '获嘉', '获嘉县', 3, 'huojia', '453800', 1, '113.66159', '35.26521');
INSERT INTO `shop_truck_region` VALUES (1606, 1599, 'Y', '原阳', '原阳县', 3, 'yuanyang', '453500', 1, '113.93994', '35.06565');
INSERT INTO `shop_truck_region` VALUES (1607, 1599, 'Y', '延津', '延津县', 3, 'yanjin', '453200', 1, '114.20266', '35.14327');
INSERT INTO `shop_truck_region` VALUES (1608, 1599, 'F', '封丘', '封丘县', 3, 'fengqiu', '453300', 1, '114.41915', '35.04166');
INSERT INTO `shop_truck_region` VALUES (1609, 1599, 'C', '长垣', '长垣县', 3, 'changyuan', '453400', 1, '114.66882', '35.20046');
INSERT INTO `shop_truck_region` VALUES (1610, 1599, 'W', '卫辉', '卫辉市', 3, 'weihui', '453100', 1, '114.06454', '35.39843');
INSERT INTO `shop_truck_region` VALUES (1611, 1599, 'H', '辉县', '辉县市', 3, 'huixian', '453600', 1, '113.8067', '35.46307');
INSERT INTO `shop_truck_region` VALUES (1612, 1532, 'J', '焦作', '焦作市', 2, 'jiaozuo', '454002', 1, '113.238266', '35.23904');
INSERT INTO `shop_truck_region` VALUES (1613, 1612, 'J', '解放', '解放区', 3, 'jiefang', '454000', 1, '113.22933', '35.24023');
INSERT INTO `shop_truck_region` VALUES (1614, 1612, 'Z', '中站', '中站区', 3, 'zhongzhan', '454191', 1, '113.18315', '35.23665');
INSERT INTO `shop_truck_region` VALUES (1615, 1612, 'M', '马村', '马村区', 3, 'macun', '454171', 1, '113.3187', '35.26908');
INSERT INTO `shop_truck_region` VALUES (1616, 1612, 'S', '山阳', '山阳区', 3, 'shanyang', '454002', 1, '113.25464', '35.21436');
INSERT INTO `shop_truck_region` VALUES (1617, 1612, 'X', '修武', '修武县', 3, 'xiuwu', '454350', 1, '113.44775', '35.22357');
INSERT INTO `shop_truck_region` VALUES (1618, 1612, 'B', '博爱', '博爱县', 3, 'boai', '454450', 1, '113.06698', '35.16943');
INSERT INTO `shop_truck_region` VALUES (1619, 1612, 'W', '武陟', '武陟县', 3, 'wuzhi', '454950', 1, '113.39718', '35.09505');
INSERT INTO `shop_truck_region` VALUES (1620, 1612, 'W', '温县', '温县', 3, 'wenxian', '454850', 1, '113.08065', '34.94022');
INSERT INTO `shop_truck_region` VALUES (1621, 1612, 'Q', '沁阳', '沁阳市', 3, 'qinyang', '454550', 1, '112.94494', '35.08935');
INSERT INTO `shop_truck_region` VALUES (1622, 1612, 'M', '孟州', '孟州市', 3, 'mengzhou', '454750', 1, '112.79138', '34.9071');
INSERT INTO `shop_truck_region` VALUES (1623, 1532, NULL, '濮阳', '濮阳市', 2, 'puyang', '457000', 1, '115.041299', '35.768234');
INSERT INTO `shop_truck_region` VALUES (1624, 1623, 'H', '华龙', '华龙区', 3, 'hualong', '457001', 1, '115.07446', '35.77736');
INSERT INTO `shop_truck_region` VALUES (1625, 1623, 'Q', '清丰', '清丰县', 3, 'qingfeng', '457300', 1, '115.10415', '35.88507');
INSERT INTO `shop_truck_region` VALUES (1626, 1623, 'N', '南乐', '南乐县', 3, 'nanle', '457400', 1, '115.20639', '36.07686');
INSERT INTO `shop_truck_region` VALUES (1627, 1623, 'F', '范县', '范县', 3, 'fanxian', '457500', 1, '115.50405', '35.85178');
INSERT INTO `shop_truck_region` VALUES (1628, 1623, 'T', '台前', '台前县', 3, 'taiqian', '457600', 1, '115.87158', '35.96923');
INSERT INTO `shop_truck_region` VALUES (1629, 1623, NULL, '濮阳', '濮阳县', 3, 'puyang', '457100', 1, '115.03057', '35.70745');
INSERT INTO `shop_truck_region` VALUES (1630, 1532, 'X', '许昌', '许昌市', 2, 'xuchang', '461000', 1, '113.826063', '34.022956');
INSERT INTO `shop_truck_region` VALUES (1631, 1630, 'W', '魏都', '魏都区', 3, 'weidu', '461000', 1, '113.8227', '34.02544');
INSERT INTO `shop_truck_region` VALUES (1632, 1630, 'X', '许昌', '许昌县', 3, 'xuchang', '461100', 1, '113.84707', '34.00406');
INSERT INTO `shop_truck_region` VALUES (1633, 1630, NULL, '鄢陵', '鄢陵县', 3, 'yanling', '461200', 1, '114.18795', '34.10317');
INSERT INTO `shop_truck_region` VALUES (1634, 1630, 'X', '襄城', '襄城县', 3, 'xiangcheng', '461700', 1, '113.48196', '33.84928');
INSERT INTO `shop_truck_region` VALUES (1635, 1630, 'Y', '禹州', '禹州市', 3, 'yuzhou', '461670', 1, '113.48803', '34.14054');
INSERT INTO `shop_truck_region` VALUES (1636, 1630, 'C', '长葛', '长葛市', 3, 'changge', '461500', 1, '113.77328', '34.21846');
INSERT INTO `shop_truck_region` VALUES (1637, 1532, NULL, '漯河', '漯河市', 2, 'luohe', '462000', 1, '114.026405', '33.575855');
INSERT INTO `shop_truck_region` VALUES (1638, 1637, 'Y', '源汇', '源汇区', 3, 'yuanhui', '462000', 1, '114.00647', '33.55627');
INSERT INTO `shop_truck_region` VALUES (1639, 1637, NULL, '郾城', '郾城区', 3, 'yancheng', '462300', 1, '114.00694', '33.58723');
INSERT INTO `shop_truck_region` VALUES (1640, 1637, 'Z', '召陵', '召陵区', 3, 'zhaoling', '462300', 1, '114.09399', '33.58601');
INSERT INTO `shop_truck_region` VALUES (1641, 1637, 'W', '舞阳', '舞阳县', 3, 'wuyang', '462400', 1, '113.59848', '33.43243');
INSERT INTO `shop_truck_region` VALUES (1642, 1637, 'L', '临颍', '临颍县', 3, 'linying', '462600', 1, '113.93661', '33.81123');
INSERT INTO `shop_truck_region` VALUES (1643, 1532, 'S', '三门峡', '三门峡市', 2, 'sanmenxia', '472000', 1, '111.194099', '34.777338');
INSERT INTO `shop_truck_region` VALUES (1644, 1643, 'H', '湖滨', '湖滨区', 3, 'hubin', '472000', 1, '111.20006', '34.77872');
INSERT INTO `shop_truck_region` VALUES (1645, 1643, NULL, '渑池', '渑池县', 3, 'mianchi', '472400', 1, '111.76184', '34.76725');
INSERT INTO `shop_truck_region` VALUES (1646, 1643, 'S', '陕县', '陕县', 3, 'shanxian', '472100', 1, '111.10333', '34.72052');
INSERT INTO `shop_truck_region` VALUES (1647, 1643, 'L', '卢氏', '卢氏县', 3, 'lushi', '472200', 1, '111.04782', '34.05436');
INSERT INTO `shop_truck_region` VALUES (1648, 1643, 'Y', '义马', '义马市', 3, 'yima', '472300', 1, '111.87445', '34.74721');
INSERT INTO `shop_truck_region` VALUES (1649, 1643, 'L', '灵宝', '灵宝市', 3, 'lingbao', '472500', 1, '110.8945', '34.51682');
INSERT INTO `shop_truck_region` VALUES (1650, 1532, 'N', '南阳', '南阳市', 2, 'nanyang', '473002', 1, '112.540918', '32.999082');
INSERT INTO `shop_truck_region` VALUES (1651, 1650, 'W', '宛城', '宛城区', 3, 'wancheng', '473001', 1, '112.53955', '33.00378');
INSERT INTO `shop_truck_region` VALUES (1652, 1650, 'W', '卧龙', '卧龙区', 3, 'wolong', '473003', 1, '112.53479', '32.98615');
INSERT INTO `shop_truck_region` VALUES (1653, 1650, 'N', '南召', '南召县', 3, 'nanzhao', '474650', 1, '112.43194', '33.49098');
INSERT INTO `shop_truck_region` VALUES (1654, 1650, 'F', '方城', '方城县', 3, 'fangcheng', '473200', 1, '113.01269', '33.25453');
INSERT INTO `shop_truck_region` VALUES (1655, 1650, 'X', '西峡', '西峡县', 3, 'xixia', '474550', 1, '111.48187', '33.29772');
INSERT INTO `shop_truck_region` VALUES (1656, 1650, 'Z', '镇平', '镇平县', 3, 'zhenping', '474250', 1, '112.2398', '33.03629');
INSERT INTO `shop_truck_region` VALUES (1657, 1650, 'N', '内乡', '内乡县', 3, 'neixiang', '474350', 1, '111.84957', '33.04671');
INSERT INTO `shop_truck_region` VALUES (1658, 1650, NULL, '淅川', '淅川县', 3, 'xichuan', '474450', 1, '111.48663', '33.13708');
INSERT INTO `shop_truck_region` VALUES (1659, 1650, 'S', '社旗', '社旗县', 3, 'sheqi', '473300', 1, '112.94656', '33.05503');
INSERT INTO `shop_truck_region` VALUES (1660, 1650, 'T', '唐河', '唐河县', 3, 'tanghe', '473400', 1, '112.83609', '32.69453');
INSERT INTO `shop_truck_region` VALUES (1661, 1650, 'X', '新野', '新野县', 3, 'xinye', '473500', 1, '112.36151', '32.51698');
INSERT INTO `shop_truck_region` VALUES (1662, 1650, 'T', '桐柏', '桐柏县', 3, 'tongbai', '474750', 1, '113.42886', '32.37917');
INSERT INTO `shop_truck_region` VALUES (1663, 1650, 'D', '邓州', '邓州市', 3, 'dengzhou', '474150', 1, '112.0896', '32.68577');
INSERT INTO `shop_truck_region` VALUES (1664, 1532, 'S', '商丘', '商丘市', 2, 'shangqiu', '476000', 1, '115.650497', '34.437054');
INSERT INTO `shop_truck_region` VALUES (1665, 1664, 'L', '梁园', '梁园区', 3, 'liangyuan', '476000', 1, '115.64487', '34.44341');
INSERT INTO `shop_truck_region` VALUES (1666, 1664, NULL, '睢阳', '睢阳区', 3, 'suiyang', '476100', 1, '115.65338', '34.38804');
INSERT INTO `shop_truck_region` VALUES (1667, 1664, 'M', '民权', '民权县', 3, 'minquan', '476800', 1, '115.14621', '34.64931');
INSERT INTO `shop_truck_region` VALUES (1668, 1664, NULL, '睢县', '睢县', 3, 'suixian', '476900', 1, '115.07168', '34.44539');
INSERT INTO `shop_truck_region` VALUES (1669, 1664, 'N', '宁陵', '宁陵县', 3, 'ningling', '476700', 1, '115.30511', '34.45463');
INSERT INTO `shop_truck_region` VALUES (1670, 1664, NULL, '柘城', '柘城县', 3, 'zhecheng', '476200', 1, '115.30538', '34.0911');
INSERT INTO `shop_truck_region` VALUES (1671, 1664, 'Y', '虞城', '虞城县', 3, 'yucheng', '476300', 1, '115.86337', '34.40189');
INSERT INTO `shop_truck_region` VALUES (1672, 1664, 'X', '夏邑', '夏邑县', 3, 'xiayi', '476400', 1, '116.13348', '34.23242');
INSERT INTO `shop_truck_region` VALUES (1673, 1664, 'Y', '永城', '永城市', 3, 'yongcheng', '476600', 1, '116.44943', '33.92911');
INSERT INTO `shop_truck_region` VALUES (1674, 1532, 'X', '信阳', '信阳市', 2, 'xinyang', '464000', 1, '114.075031', '32.123274');
INSERT INTO `shop_truck_region` VALUES (1675, 1674, NULL, '浉河', '浉河区', 3, 'shihe', '464000', 1, '114.05871', '32.1168');
INSERT INTO `shop_truck_region` VALUES (1676, 1674, 'P', '平桥', '平桥区', 3, 'pingqiao', '464100', 1, '114.12435', '32.10095');
INSERT INTO `shop_truck_region` VALUES (1677, 1674, 'L', '罗山', '罗山县', 3, 'luoshan', '464200', 1, '114.5314', '32.20277');
INSERT INTO `shop_truck_region` VALUES (1678, 1674, 'G', '光山', '光山县', 3, 'guangshan', '465450', 1, '114.91873', '32.00992');
INSERT INTO `shop_truck_region` VALUES (1679, 1674, 'X', '新县', '新县', 3, 'xinxian', '465550', 1, '114.87924', '31.64386');
INSERT INTO `shop_truck_region` VALUES (1680, 1674, 'S', '商城', '商城县', 3, 'shangcheng', '465350', 1, '115.40856', '31.79986');
INSERT INTO `shop_truck_region` VALUES (1681, 1674, 'G', '固始', '固始县', 3, 'gushi', '465250', 1, '115.68298', '32.18011');
INSERT INTO `shop_truck_region` VALUES (1682, 1674, NULL, '潢川', '潢川县', 3, 'huangchuan', '465150', 1, '115.04696', '32.13763');
INSERT INTO `shop_truck_region` VALUES (1683, 1674, 'H', '淮滨', '淮滨县', 3, 'huaibin', '464400', 1, '115.4205', '32.46614');
INSERT INTO `shop_truck_region` VALUES (1684, 1674, 'X', '息县', '息县', 3, 'xixian', '464300', 1, '114.7402', '32.34279');
INSERT INTO `shop_truck_region` VALUES (1685, 1532, 'Z', '周口', '周口市', 2, 'zhoukou', '466000', 1, '114.649653', '33.620357');
INSERT INTO `shop_truck_region` VALUES (1686, 1685, 'C', '川汇', '川汇区', 3, 'chuanhui', '466000', 1, '114.64202', '33.6256');
INSERT INTO `shop_truck_region` VALUES (1687, 1685, 'F', '扶沟', '扶沟县', 3, 'fugou', '461300', 1, '114.39477', '34.05999');
INSERT INTO `shop_truck_region` VALUES (1688, 1685, 'X', '西华', '西华县', 3, 'xihua', '466600', 1, '114.52279', '33.78548');
INSERT INTO `shop_truck_region` VALUES (1689, 1685, 'S', '商水', '商水县', 3, 'shangshui', '466100', 1, '114.60604', '33.53912');
INSERT INTO `shop_truck_region` VALUES (1690, 1685, 'S', '沈丘', '沈丘县', 3, 'shenqiu', '466300', 1, '115.09851', '33.40936');
INSERT INTO `shop_truck_region` VALUES (1691, 1685, 'D', '郸城', '郸城县', 3, 'dancheng', '477150', 1, '115.17715', '33.64485');
INSERT INTO `shop_truck_region` VALUES (1692, 1685, 'H', '淮阳', '淮阳县', 3, 'huaiyang', '466700', 1, '114.88848', '33.73211');
INSERT INTO `shop_truck_region` VALUES (1693, 1685, 'T', '太康', '太康县', 3, 'taikang', '461400', 1, '114.83773', '34.06376');
INSERT INTO `shop_truck_region` VALUES (1694, 1685, 'L', '鹿邑', '鹿邑县', 3, 'luyi', '477200', 1, '115.48553', '33.85931');
INSERT INTO `shop_truck_region` VALUES (1695, 1685, 'X', '项城', '项城市', 3, 'xiangcheng', '466200', 1, '114.87558', '33.4672');
INSERT INTO `shop_truck_region` VALUES (1696, 1532, 'Z', '驻马店', '驻马店市', 2, 'zhumadian', '463000', 1, '114.024736', '32.980169');
INSERT INTO `shop_truck_region` VALUES (1697, 1696, NULL, '驿城', '驿城区', 3, 'yicheng', '463000', 1, '113.99377', '32.97316');
INSERT INTO `shop_truck_region` VALUES (1698, 1696, 'X', '西平', '西平县', 3, 'xiping', '463900', 1, '114.02322', '33.3845');
INSERT INTO `shop_truck_region` VALUES (1699, 1696, 'S', '上蔡', '上蔡县', 3, 'shangcai', '463800', 1, '114.26825', '33.26825');
INSERT INTO `shop_truck_region` VALUES (1700, 1696, 'P', '平舆', '平舆县', 3, 'pingyu', '463400', 1, '114.63552', '32.95727');
INSERT INTO `shop_truck_region` VALUES (1701, 1696, 'Z', '正阳', '正阳县', 3, 'zhengyang', '463600', 1, '114.38952', '32.6039');
INSERT INTO `shop_truck_region` VALUES (1702, 1696, 'Q', '确山', '确山县', 3, 'queshan', '463200', 1, '114.02917', '32.80281');
INSERT INTO `shop_truck_region` VALUES (1703, 1696, 'M', '泌阳', '泌阳县', 3, 'biyang', '463700', 1, '113.32681', '32.71781');
INSERT INTO `shop_truck_region` VALUES (1704, 1696, 'R', '汝南', '汝南县', 3, 'runan', '463300', 1, '114.36138', '33.00461');
INSERT INTO `shop_truck_region` VALUES (1705, 1696, 'S', '遂平', '遂平县', 3, 'suiping', '463100', 1, '114.01297', '33.14571');
INSERT INTO `shop_truck_region` VALUES (1706, 1696, 'X', '新蔡', '新蔡县', 3, 'xincai', '463500', 1, '114.98199', '32.7502');
INSERT INTO `shop_truck_region` VALUES (1707, 1532, 'Z', ' ', '直辖县级', 2, '', '', 1, '113.665412', '34.757975');
INSERT INTO `shop_truck_region` VALUES (1708, 1707, 'J', '济源', '济源市', 3, 'jiyuan', '454650', 1, '112.590047', '35.090378');
INSERT INTO `shop_truck_region` VALUES (1709, 0, 'H', '湖北', '湖北省', 1, 'hubei', '', 1, '114.298572', '30.584355');
INSERT INTO `shop_truck_region` VALUES (1710, 1709, 'W', '武汉', '武汉市', 2, 'wuhan', '430014', 1, '114.298572', '30.584355');
INSERT INTO `shop_truck_region` VALUES (1711, 1710, 'J', '江岸', '江岸区', 3, 'jiangan', '430014', 1, '114.30943', '30.59982');
INSERT INTO `shop_truck_region` VALUES (1712, 1710, 'J', '江汉', '江汉区', 3, 'jianghan', '430021', 1, '114.27093', '30.60146');
INSERT INTO `shop_truck_region` VALUES (1713, 1710, NULL, '硚口', '硚口区', 3, 'qiaokou', '430033', 1, '114.26422', '30.56945');
INSERT INTO `shop_truck_region` VALUES (1714, 1710, 'H', '汉阳', '汉阳区', 3, 'hanyang', '430050', 1, '114.27478', '30.54915');
INSERT INTO `shop_truck_region` VALUES (1715, 1710, 'W', '武昌', '武昌区', 3, 'wuchang', '430061', 1, '114.31589', '30.55389');
INSERT INTO `shop_truck_region` VALUES (1716, 1710, 'Q', '青山', '青山区', 3, 'qingshan', '430080', 1, '114.39117', '30.63427');
INSERT INTO `shop_truck_region` VALUES (1717, 1710, 'H', '洪山', '洪山区', 3, 'hongshan', '430070', 1, '114.34375', '30.49989');
INSERT INTO `shop_truck_region` VALUES (1718, 1710, 'D', '东西湖', '东西湖区', 3, 'dongxihu', '430040', 1, '114.13708', '30.61989');
INSERT INTO `shop_truck_region` VALUES (1719, 1710, 'H', '汉南', '汉南区', 3, 'hannan', '430090', 1, '114.08462', '30.30879');
INSERT INTO `shop_truck_region` VALUES (1720, 1710, 'C', '蔡甸', '蔡甸区', 3, 'caidian', '430100', 1, '114.02929', '30.58197');
INSERT INTO `shop_truck_region` VALUES (1721, 1710, 'J', '江夏', '江夏区', 3, 'jiangxia', '430200', 1, '114.31301', '30.34653');
INSERT INTO `shop_truck_region` VALUES (1722, 1710, 'H', '黄陂', '黄陂区', 3, 'huangpi', '432200', 1, '114.37512', '30.88151');
INSERT INTO `shop_truck_region` VALUES (1723, 1710, 'X', '新洲', '新洲区', 3, 'xinzhou', '431400', 1, '114.80136', '30.84145');
INSERT INTO `shop_truck_region` VALUES (1724, 1709, 'H', '黄石', '黄石市', 2, 'huangshi', '435003', 1, '115.077048', '30.220074');
INSERT INTO `shop_truck_region` VALUES (1725, 1724, 'H', '黄石港', '黄石港区', 3, 'huangshigang', '435000', 1, '115.06604', '30.22279');
INSERT INTO `shop_truck_region` VALUES (1726, 1724, 'X', '西塞山', '西塞山区', 3, 'xisaishan', '435001', 1, '115.11016', '30.20487');
INSERT INTO `shop_truck_region` VALUES (1727, 1724, 'X', '下陆', '下陆区', 3, 'xialu', '435005', 1, '114.96112', '30.17368');
INSERT INTO `shop_truck_region` VALUES (1728, 1724, 'T', '铁山', '铁山区', 3, 'tieshan', '435006', 1, '114.90109', '30.20678');
INSERT INTO `shop_truck_region` VALUES (1729, 1724, 'Y', '阳新', '阳新县', 3, 'yangxin', '435200', 1, '115.21527', '29.83038');
INSERT INTO `shop_truck_region` VALUES (1730, 1724, 'D', '大冶', '大冶市', 3, 'daye', '435100', 1, '114.97174', '30.09438');
INSERT INTO `shop_truck_region` VALUES (1731, 1709, 'S', '十堰', '十堰市', 2, 'shiyan', '442000', 1, '110.785239', '32.647017');
INSERT INTO `shop_truck_region` VALUES (1732, 1731, 'M', '茅箭', '茅箭区', 3, 'maojian', '442012', 1, '110.81341', '32.59153');
INSERT INTO `shop_truck_region` VALUES (1733, 1731, 'Z', '张湾', '张湾区', 3, 'zhangwan', '442001', 1, '110.77067', '32.65195');
INSERT INTO `shop_truck_region` VALUES (1734, 1731, 'Y', '郧阳', '郧阳区', 3, 'yunyang', '442500', 1, '110.81854', '32.83593');
INSERT INTO `shop_truck_region` VALUES (1735, 1731, 'Y', '郧西', '郧西县', 3, 'yunxi', '442600', 1, '110.42556', '32.99349');
INSERT INTO `shop_truck_region` VALUES (1736, 1731, 'Z', '竹山', '竹山县', 3, 'zhushan', '442200', 1, '110.23071', '32.22536');
INSERT INTO `shop_truck_region` VALUES (1737, 1731, 'Z', '竹溪', '竹溪县', 3, 'zhuxi', '442300', 1, '109.71798', '32.31901');
INSERT INTO `shop_truck_region` VALUES (1738, 1731, 'F', '房县', '房县', 3, 'fangxian', '442100', 1, '110.74386', '32.05794');
INSERT INTO `shop_truck_region` VALUES (1739, 1731, 'D', '丹江口', '丹江口市', 3, 'danjiangkou', '442700', 1, '111.51525', '32.54085');
INSERT INTO `shop_truck_region` VALUES (1740, 1709, 'Y', '宜昌', '宜昌市', 2, 'yichang', '443000', 1, '111.290843', '30.702636');
INSERT INTO `shop_truck_region` VALUES (1741, 1740, 'X', '西陵', '西陵区', 3, 'xiling', '443000', 1, '111.28573', '30.71077');
INSERT INTO `shop_truck_region` VALUES (1742, 1740, 'W', '伍家岗', '伍家岗区', 3, 'wujiagang', '443001', 1, '111.3609', '30.64434');
INSERT INTO `shop_truck_region` VALUES (1743, 1740, 'D', '点军', '点军区', 3, 'dianjun', '443006', 1, '111.26828', '30.6934');
INSERT INTO `shop_truck_region` VALUES (1744, 1740, NULL, '猇亭', '猇亭区', 3, 'xiaoting', '443007', 1, '111.44079', '30.52663');
INSERT INTO `shop_truck_region` VALUES (1745, 1740, 'Y', '夷陵', '夷陵区', 3, 'yiling', '443100', 1, '111.3262', '30.76881');
INSERT INTO `shop_truck_region` VALUES (1746, 1740, 'Y', '远安', '远安县', 3, 'yuanan', '444200', 1, '111.6416', '31.05989');
INSERT INTO `shop_truck_region` VALUES (1747, 1740, 'X', '兴山', '兴山县', 3, 'xingshan', '443711', 1, '110.74951', '31.34686');
INSERT INTO `shop_truck_region` VALUES (1748, 1740, NULL, '秭归', '秭归县', 3, 'zigui', '443600', 1, '110.98156', '30.82702');
INSERT INTO `shop_truck_region` VALUES (1749, 1740, 'C', '长阳', '长阳土家族自治县', 3, 'changyang', '443500', 1, '111.20105', '30.47052');
INSERT INTO `shop_truck_region` VALUES (1750, 1740, 'W', '五峰', '五峰土家族自治县', 3, 'wufeng', '443413', 1, '110.6748', '30.19856');
INSERT INTO `shop_truck_region` VALUES (1751, 1740, 'Y', '宜都', '宜都市', 3, 'yidu', '443300', 1, '111.45025', '30.37807');
INSERT INTO `shop_truck_region` VALUES (1752, 1740, 'D', '当阳', '当阳市', 3, 'dangyang', '444100', 1, '111.78912', '30.8208');
INSERT INTO `shop_truck_region` VALUES (1753, 1740, 'Z', '枝江', '枝江市', 3, 'zhijiang', '443200', 1, '111.76855', '30.42612');
INSERT INTO `shop_truck_region` VALUES (1754, 1709, 'X', '襄阳', '襄阳市', 2, 'xiangyang', '441021', 1, '112.144146', '32.042426');
INSERT INTO `shop_truck_region` VALUES (1755, 1754, 'X', '襄城', '襄城区', 3, 'xiangcheng', '441021', 1, '112.13372', '32.01017');
INSERT INTO `shop_truck_region` VALUES (1756, 1754, 'F', '樊城', '樊城区', 3, 'fancheng', '441001', 1, '112.13546', '32.04482');
INSERT INTO `shop_truck_region` VALUES (1757, 1754, 'X', '襄州', '襄州区', 3, 'xiangzhou', '441100', 1, '112.150327', '32.015088');
INSERT INTO `shop_truck_region` VALUES (1758, 1754, 'N', '南漳', '南漳县', 3, 'nanzhang', '441500', 1, '111.84603', '31.77653');
INSERT INTO `shop_truck_region` VALUES (1759, 1754, 'G', '谷城', '谷城县', 3, 'gucheng', '441700', 1, '111.65267', '32.26377');
INSERT INTO `shop_truck_region` VALUES (1760, 1754, 'B', '保康', '保康县', 3, 'baokang', '441600', 1, '111.26138', '31.87874');
INSERT INTO `shop_truck_region` VALUES (1761, 1754, 'L', '老河口', '老河口市', 3, 'laohekou', '441800', 1, '111.67117', '32.38476');
INSERT INTO `shop_truck_region` VALUES (1762, 1754, 'Z', '枣阳', '枣阳市', 3, 'zaoyang', '441200', 1, '112.77444', '32.13142');
INSERT INTO `shop_truck_region` VALUES (1763, 1754, 'Y', '宜城', '宜城市', 3, 'yicheng', '441400', 1, '112.25772', '31.71972');
INSERT INTO `shop_truck_region` VALUES (1764, 1709, 'E', '鄂州', '鄂州市', 2, 'ezhou', '436000', 1, '114.890593', '30.396536');
INSERT INTO `shop_truck_region` VALUES (1765, 1764, 'L', '梁子湖', '梁子湖区', 3, 'liangzihu', '436064', 1, '114.68463', '30.10003');
INSERT INTO `shop_truck_region` VALUES (1766, 1764, 'H', '华容', '华容区', 3, 'huarong', '436030', 1, '114.73568', '30.53328');
INSERT INTO `shop_truck_region` VALUES (1767, 1764, 'E', '鄂城', '鄂城区', 3, 'echeng', '436000', 1, '114.89158', '30.40024');
INSERT INTO `shop_truck_region` VALUES (1768, 1709, 'J', '荆门', '荆门市', 2, 'jingmen', '448000', 1, '112.204251', '31.03542');
INSERT INTO `shop_truck_region` VALUES (1769, 1768, 'D', '东宝', '东宝区', 3, 'dongbao', '448004', 1, '112.20147', '31.05192');
INSERT INTO `shop_truck_region` VALUES (1770, 1768, 'D', '掇刀', '掇刀区', 3, 'duodao', '448124', 1, '112.208', '30.97316');
INSERT INTO `shop_truck_region` VALUES (1771, 1768, 'J', '京山', '京山县', 3, 'jingshan', '431800', 1, '113.11074', '31.0224');
INSERT INTO `shop_truck_region` VALUES (1772, 1768, 'S', '沙洋', '沙洋县', 3, 'shayang', '448200', 1, '112.58853', '30.70916');
INSERT INTO `shop_truck_region` VALUES (1773, 1768, 'Z', '钟祥', '钟祥市', 3, 'zhongxiang', '431900', 1, '112.58932', '31.1678');
INSERT INTO `shop_truck_region` VALUES (1774, 1709, 'X', '孝感', '孝感市', 2, 'xiaogan', '432100', 1, '113.926655', '30.926423');
INSERT INTO `shop_truck_region` VALUES (1775, 1774, 'X', '孝南', '孝南区', 3, 'xiaonan', '432100', 1, '113.91111', '30.9168');
INSERT INTO `shop_truck_region` VALUES (1776, 1774, 'X', '孝昌', '孝昌县', 3, 'xiaochang', '432900', 1, '113.99795', '31.25799');
INSERT INTO `shop_truck_region` VALUES (1777, 1774, 'D', '大悟', '大悟县', 3, 'dawu', '432800', 1, '114.12564', '31.56176');
INSERT INTO `shop_truck_region` VALUES (1778, 1774, 'Y', '云梦', '云梦县', 3, 'yunmeng', '432500', 1, '113.75289', '31.02093');
INSERT INTO `shop_truck_region` VALUES (1779, 1774, 'Y', '应城', '应城市', 3, 'yingcheng', '432400', 1, '113.57287', '30.92834');
INSERT INTO `shop_truck_region` VALUES (1780, 1774, 'A', '安陆', '安陆市', 3, 'anlu', '432600', 1, '113.68557', '31.25693');
INSERT INTO `shop_truck_region` VALUES (1781, 1774, 'H', '汉川', '汉川市', 3, 'hanchuan', '432300', 1, '113.83898', '30.66117');
INSERT INTO `shop_truck_region` VALUES (1782, 1709, 'J', '荆州', '荆州市', 2, 'jingzhou', '434000', 1, '112.23813', '30.326857');
INSERT INTO `shop_truck_region` VALUES (1783, 1782, 'S', '沙市', '沙市区', 3, 'shashi', '434000', 1, '112.25543', '30.31107');
INSERT INTO `shop_truck_region` VALUES (1784, 1782, 'J', '荆州', '荆州区', 3, 'jingzhou', '434020', 1, '112.19006', '30.35264');
INSERT INTO `shop_truck_region` VALUES (1785, 1782, 'G', '公安', '公安县', 3, 'gongan', '434300', 1, '112.23242', '30.05902');
INSERT INTO `shop_truck_region` VALUES (1786, 1782, 'J', '监利', '监利县', 3, 'jianli', '433300', 1, '112.89462', '29.81494');
INSERT INTO `shop_truck_region` VALUES (1787, 1782, 'J', '江陵', '江陵县', 3, 'jiangling', '434101', 1, '112.42468', '30.04174');
INSERT INTO `shop_truck_region` VALUES (1788, 1782, 'S', '石首', '石首市', 3, 'shishou', '434400', 1, '112.42636', '29.72127');
INSERT INTO `shop_truck_region` VALUES (1789, 1782, 'H', '洪湖', '洪湖市', 3, 'honghu', '433200', 1, '113.47598', '29.827');
INSERT INTO `shop_truck_region` VALUES (1790, 1782, 'S', '松滋', '松滋市', 3, 'songzi', '434200', 1, '111.76739', '30.16965');
INSERT INTO `shop_truck_region` VALUES (1791, 1709, 'H', '黄冈', '黄冈市', 2, 'huanggang', '438000', 1, '114.879365', '30.447711');
INSERT INTO `shop_truck_region` VALUES (1792, 1791, 'H', '黄州', '黄州区', 3, 'huangzhou', '438000', 1, '114.88008', '30.43436');
INSERT INTO `shop_truck_region` VALUES (1793, 1791, 'T', '团风', '团风县', 3, 'tuanfeng', '438800', 1, '114.87228', '30.64359');
INSERT INTO `shop_truck_region` VALUES (1794, 1791, 'H', '红安', '红安县', 3, 'hongan', '438401', 1, '114.6224', '31.28668');
INSERT INTO `shop_truck_region` VALUES (1795, 1791, 'L', '罗田', '罗田县', 3, 'luotian', '438600', 1, '115.39971', '30.78255');
INSERT INTO `shop_truck_region` VALUES (1796, 1791, 'Y', '英山', '英山县', 3, 'yingshan', '438700', 1, '115.68142', '30.73516');
INSERT INTO `shop_truck_region` VALUES (1797, 1791, NULL, '浠水', '浠水县', 3, 'xishui', '438200', 1, '115.26913', '30.45265');
INSERT INTO `shop_truck_region` VALUES (1798, 1791, NULL, '蕲春', '蕲春县', 3, 'qichun', '435300', 1, '115.43615', '30.22613');
INSERT INTO `shop_truck_region` VALUES (1799, 1791, 'H', '黄梅', '黄梅县', 3, 'huangmei', '435500', 1, '115.94427', '30.07033');
INSERT INTO `shop_truck_region` VALUES (1800, 1791, 'M', '麻城', '麻城市', 3, 'macheng', '438300', 1, '115.00988', '31.17228');
INSERT INTO `shop_truck_region` VALUES (1801, 1791, 'W', '武穴', '武穴市', 3, 'wuxue', '435400', 1, '115.55975', '29.84446');
INSERT INTO `shop_truck_region` VALUES (1802, 1709, 'X', '咸宁', '咸宁市', 2, 'xianning', '437000', 1, '114.328963', '29.832798');
INSERT INTO `shop_truck_region` VALUES (1803, 1802, 'X', '咸安', '咸安区', 3, 'xianan', '437000', 1, '114.29872', '29.8529');
INSERT INTO `shop_truck_region` VALUES (1804, 1802, 'J', '嘉鱼', '嘉鱼县', 3, 'jiayu', '437200', 1, '113.93927', '29.97054');
INSERT INTO `shop_truck_region` VALUES (1805, 1802, 'T', '通城', '通城县', 3, 'tongcheng', '437400', 1, '113.81582', '29.24568');
INSERT INTO `shop_truck_region` VALUES (1806, 1802, 'C', '崇阳', '崇阳县', 3, 'chongyang', '437500', 1, '114.03982', '29.55564');
INSERT INTO `shop_truck_region` VALUES (1807, 1802, 'T', '通山', '通山县', 3, 'tongshan', '437600', 1, '114.48239', '29.6063');
INSERT INTO `shop_truck_region` VALUES (1808, 1802, 'C', '赤壁', '赤壁市', 3, 'chibi', '437300', 1, '113.90039', '29.72454');
INSERT INTO `shop_truck_region` VALUES (1809, 1709, 'S', '随州', '随州市', 2, 'suizhou', '441300', 1, '113.37377', '31.717497');
INSERT INTO `shop_truck_region` VALUES (1810, 1809, 'Z', '曾都', '曾都区', 3, 'zengdu', '441300', 1, '113.37128', '31.71614');
INSERT INTO `shop_truck_region` VALUES (1811, 1809, 'S', '随县', '随县', 3, 'suixian', '441309', 1, '113.82663', '31.6179');
INSERT INTO `shop_truck_region` VALUES (1812, 1809, 'G', '广水', '广水市', 3, 'guangshui', '432700', 1, '113.82663', '31.6179');
INSERT INTO `shop_truck_region` VALUES (1813, 1709, 'E', '恩施', '恩施土家族苗族自治州', 2, 'enshi', '445000', 1, '109.48699', '30.283114');
INSERT INTO `shop_truck_region` VALUES (1814, 1813, 'E', '恩施', '恩施市', 3, 'enshi', '445000', 1, '109.47942', '30.29502');
INSERT INTO `shop_truck_region` VALUES (1815, 1813, 'L', '利川', '利川市', 3, 'lichuan', '445400', 1, '108.93591', '30.29117');
INSERT INTO `shop_truck_region` VALUES (1816, 1813, 'J', '建始', '建始县', 3, 'jianshi', '445300', 1, '109.72207', '30.60209');
INSERT INTO `shop_truck_region` VALUES (1817, 1813, 'B', '巴东', '巴东县', 3, 'badong', '444300', 1, '110.34066', '31.04233');
INSERT INTO `shop_truck_region` VALUES (1818, 1813, 'X', '宣恩', '宣恩县', 3, 'xuanen', '445500', 1, '109.49179', '29.98714');
INSERT INTO `shop_truck_region` VALUES (1819, 1813, 'X', '咸丰', '咸丰县', 3, 'xianfeng', '445600', 1, '109.152', '29.67983');
INSERT INTO `shop_truck_region` VALUES (1820, 1813, 'L', '来凤', '来凤县', 3, 'laifeng', '445700', 1, '109.40716', '29.49373');
INSERT INTO `shop_truck_region` VALUES (1821, 1813, 'H', '鹤峰', '鹤峰县', 3, 'hefeng', '445800', 1, '110.03091', '29.89072');
INSERT INTO `shop_truck_region` VALUES (1822, 1709, 'Z', ' ', '直辖县级', 2, '', '', 1, '114.298572', '30.584355');
INSERT INTO `shop_truck_region` VALUES (1823, 1822, 'X', '仙桃', '仙桃市', 3, 'xiantao', '433000', 1, '113.453974', '30.364953');
INSERT INTO `shop_truck_region` VALUES (1824, 1822, 'Q', '潜江', '潜江市', 3, 'qianjiang', '433100', 1, '112.896866', '30.421215');
INSERT INTO `shop_truck_region` VALUES (1825, 1822, 'T', '天门', '天门市', 3, 'tianmen', '431700', 1, '113.165862', '30.653061');
INSERT INTO `shop_truck_region` VALUES (1826, 1822, 'S', '神农架', '神农架林区', 3, 'shennongjia', '442400', 1, '110.671525', '31.744449');
INSERT INTO `shop_truck_region` VALUES (1827, 0, 'H', '湖南', '湖南省', 1, 'hunan', '', 1, '112.982279', '28.19409');
INSERT INTO `shop_truck_region` VALUES (1828, 1827, 'C', '长沙', '长沙市', 2, 'changsha', '410005', 1, '112.982279', '28.19409');
INSERT INTO `shop_truck_region` VALUES (1829, 1828, NULL, '芙蓉', '芙蓉区', 3, 'furong', '410011', 1, '113.03176', '28.1844');
INSERT INTO `shop_truck_region` VALUES (1830, 1828, 'T', '天心', '天心区', 3, 'tianxin', '410004', 1, '112.98991', '28.1127');
INSERT INTO `shop_truck_region` VALUES (1831, 1828, 'Y', '岳麓', '岳麓区', 3, 'yuelu', '410013', 1, '112.93133', '28.2351');
INSERT INTO `shop_truck_region` VALUES (1832, 1828, 'K', '开福', '开福区', 3, 'kaifu', '410008', 1, '112.98623', '28.25585');
INSERT INTO `shop_truck_region` VALUES (1833, 1828, 'Y', '雨花', '雨花区', 3, 'yuhua', '410011', 1, '113.03567', '28.13541');
INSERT INTO `shop_truck_region` VALUES (1834, 1828, 'W', '望城', '望城区', 3, 'wangcheng', '410200', 1, '112.819549', '28.347458');
INSERT INTO `shop_truck_region` VALUES (1835, 1828, 'C', '长沙', '长沙县', 3, 'changsha', '410100', 1, '113.08071', '28.24595');
INSERT INTO `shop_truck_region` VALUES (1836, 1828, 'N', '宁乡', '宁乡县', 3, 'ningxiang', '410600', 1, '112.55749', '28.25358');
INSERT INTO `shop_truck_region` VALUES (1837, 1828, NULL, '浏阳', '浏阳市', 3, 'liuyang', '410300', 1, '113.64312', '28.16375');
INSERT INTO `shop_truck_region` VALUES (1838, 1827, 'Z', '株洲', '株洲市', 2, 'zhuzhou', '412000', 1, '113.151737', '27.835806');
INSERT INTO `shop_truck_region` VALUES (1839, 1838, 'H', '荷塘', '荷塘区', 3, 'hetang', '412000', 1, '113.17315', '27.85569');
INSERT INTO `shop_truck_region` VALUES (1840, 1838, 'L', '芦淞', '芦淞区', 3, 'lusong', '412000', 1, '113.15562', '27.78525');
INSERT INTO `shop_truck_region` VALUES (1841, 1838, 'S', '石峰', '石峰区', 3, 'shifeng', '412005', 1, '113.11776', '27.87552');
INSERT INTO `shop_truck_region` VALUES (1842, 1838, 'T', '天元', '天元区', 3, 'tianyuan', '412007', 1, '113.12335', '27.83103');
INSERT INTO `shop_truck_region` VALUES (1843, 1838, 'Z', '株洲', '株洲县', 3, 'zhuzhou', '412100', 1, '113.14428', '27.69826');
INSERT INTO `shop_truck_region` VALUES (1844, 1838, NULL, '攸县', '攸县', 3, 'youxian', '412300', 1, '113.34365', '27.00352');
INSERT INTO `shop_truck_region` VALUES (1845, 1838, 'C', '茶陵', '茶陵县', 3, 'chaling', '412400', 1, '113.54364', '26.7915');
INSERT INTO `shop_truck_region` VALUES (1846, 1838, 'Y', '炎陵', '炎陵县', 3, 'yanling', '412500', 1, '113.77163', '26.48818');
INSERT INTO `shop_truck_region` VALUES (1847, 1838, NULL, '醴陵', '醴陵市', 3, 'liling', '412200', 1, '113.49704', '27.64615');
INSERT INTO `shop_truck_region` VALUES (1848, 1827, 'X', '湘潭', '湘潭市', 2, 'xiangtan', '411100', 1, '112.925083', '27.846725');
INSERT INTO `shop_truck_region` VALUES (1849, 1848, 'Y', '雨湖', '雨湖区', 3, 'yuhu', '411100', 1, '112.90399', '27.86859');
INSERT INTO `shop_truck_region` VALUES (1850, 1848, 'Y', '岳塘', '岳塘区', 3, 'yuetang', '411101', 1, '112.9606', '27.85784');
INSERT INTO `shop_truck_region` VALUES (1851, 1848, 'X', '湘潭', '湘潭县', 3, 'xiangtan', '411228', 1, '112.9508', '27.77893');
INSERT INTO `shop_truck_region` VALUES (1852, 1848, 'X', '湘乡', '湘乡市', 3, 'xiangxiang', '411400', 1, '112.53512', '27.73543');
INSERT INTO `shop_truck_region` VALUES (1853, 1848, 'S', '韶山', '韶山市', 3, 'shaoshan', '411300', 1, '112.52655', '27.91503');
INSERT INTO `shop_truck_region` VALUES (1854, 1827, 'H', '衡阳', '衡阳市', 2, 'hengyang', '421001', 1, '112.607693', '26.900358');
INSERT INTO `shop_truck_region` VALUES (1855, 1854, 'Z', '珠晖', '珠晖区', 3, 'zhuhui', '421002', 1, '112.62054', '26.89361');
INSERT INTO `shop_truck_region` VALUES (1856, 1854, 'Y', '雁峰', '雁峰区', 3, 'yanfeng', '421001', 1, '112.61654', '26.88866');
INSERT INTO `shop_truck_region` VALUES (1857, 1854, 'S', '石鼓', '石鼓区', 3, 'shigu', '421005', 1, '112.61069', '26.90232');
INSERT INTO `shop_truck_region` VALUES (1858, 1854, 'Z', '蒸湘', '蒸湘区', 3, 'zhengxiang', '421001', 1, '112.6033', '26.89651');
INSERT INTO `shop_truck_region` VALUES (1859, 1854, 'N', '南岳', '南岳区', 3, 'nanyue', '421900', 1, '112.7384', '27.23262');
INSERT INTO `shop_truck_region` VALUES (1860, 1854, 'H', '衡阳', '衡阳县', 3, 'hengyang', '421200', 1, '112.37088', '26.9706');
INSERT INTO `shop_truck_region` VALUES (1861, 1854, 'H', '衡南', '衡南县', 3, 'hengnan', '421131', 1, '112.67788', '26.73828');
INSERT INTO `shop_truck_region` VALUES (1862, 1854, 'H', '衡山', '衡山县', 3, 'hengshan', '421300', 1, '112.86776', '27.23134');
INSERT INTO `shop_truck_region` VALUES (1863, 1854, 'H', '衡东', '衡东县', 3, 'hengdong', '421400', 1, '112.94833', '27.08093');
INSERT INTO `shop_truck_region` VALUES (1864, 1854, 'Q', '祁东', '祁东县', 3, 'qidong', '421600', 1, '112.09039', '26.79964');
INSERT INTO `shop_truck_region` VALUES (1865, 1854, NULL, '耒阳', '耒阳市', 3, 'leiyang', '421800', 1, '112.85998', '26.42132');
INSERT INTO `shop_truck_region` VALUES (1866, 1854, 'C', '常宁', '常宁市', 3, 'changning', '421500', 1, '112.4009', '26.40692');
INSERT INTO `shop_truck_region` VALUES (1867, 1827, 'S', '邵阳', '邵阳市', 2, 'shaoyang', '422000', 1, '111.46923', '27.237842');
INSERT INTO `shop_truck_region` VALUES (1868, 1867, 'S', '双清', '双清区', 3, 'shuangqing', '422001', 1, '111.49715', '27.23291');
INSERT INTO `shop_truck_region` VALUES (1869, 1867, 'D', '大祥', '大祥区', 3, 'daxiang', '422000', 1, '111.45412', '27.23332');
INSERT INTO `shop_truck_region` VALUES (1870, 1867, 'B', '北塔', '北塔区', 3, 'beita', '422007', 1, '111.45219', '27.24648');
INSERT INTO `shop_truck_region` VALUES (1871, 1867, 'S', '邵东', '邵东县', 3, 'shaodong', '422800', 1, '111.74441', '27.2584');
INSERT INTO `shop_truck_region` VALUES (1872, 1867, 'X', '新邵', '新邵县', 3, 'xinshao', '422900', 1, '111.46066', '27.32169');
INSERT INTO `shop_truck_region` VALUES (1873, 1867, 'S', '邵阳', '邵阳县', 3, 'shaoyang', '422100', 1, '111.27459', '26.99143');
INSERT INTO `shop_truck_region` VALUES (1874, 1867, 'L', '隆回', '隆回县', 3, 'longhui', '422200', 1, '111.03216', '27.10937');
INSERT INTO `shop_truck_region` VALUES (1875, 1867, 'D', '洞口', '洞口县', 3, 'dongkou', '422300', 1, '110.57388', '27.05462');
INSERT INTO `shop_truck_region` VALUES (1876, 1867, 'S', '绥宁', '绥宁县', 3, 'suining', '422600', 1, '110.15576', '26.58636');
INSERT INTO `shop_truck_region` VALUES (1877, 1867, 'X', '新宁', '新宁县', 3, 'xinning', '422700', 1, '110.85131', '26.42936');
INSERT INTO `shop_truck_region` VALUES (1878, 1867, 'C', '城步', '城步苗族自治县', 3, 'chengbu', '422500', 1, '110.3222', '26.39048');
INSERT INTO `shop_truck_region` VALUES (1879, 1867, 'W', '武冈', '武冈市', 3, 'wugang', '422400', 1, '110.63281', '26.72817');
INSERT INTO `shop_truck_region` VALUES (1880, 1827, 'Y', '岳阳', '岳阳市', 2, 'yueyang', '414000', 1, '113.132855', '29.37029');
INSERT INTO `shop_truck_region` VALUES (1881, 1880, 'Y', '岳阳楼', '岳阳楼区', 3, 'yueyanglou', '414000', 1, '113.12942', '29.3719');
INSERT INTO `shop_truck_region` VALUES (1882, 1880, 'Y', '云溪', '云溪区', 3, 'yunxi', '414009', 1, '113.27713', '29.47357');
INSERT INTO `shop_truck_region` VALUES (1883, 1880, 'J', '君山', '君山区', 3, 'junshan', '414005', 1, '113.00439', '29.45941');
INSERT INTO `shop_truck_region` VALUES (1884, 1880, 'Y', '岳阳', '岳阳县', 3, 'yueyang', '414100', 1, '113.11987', '29.14314');
INSERT INTO `shop_truck_region` VALUES (1885, 1880, 'H', '华容', '华容县', 3, 'huarong', '414200', 1, '112.54089', '29.53019');
INSERT INTO `shop_truck_region` VALUES (1886, 1880, 'X', '湘阴', '湘阴县', 3, 'xiangyin', '414600', 1, '112.90911', '28.68922');
INSERT INTO `shop_truck_region` VALUES (1887, 1880, 'P', '平江', '平江县', 3, 'pingjiang', '414500', 1, '113.58105', '28.70664');
INSERT INTO `shop_truck_region` VALUES (1888, 1880, NULL, '汨罗', '汨罗市', 3, 'miluo', '414400', 1, '113.06707', '28.80631');
INSERT INTO `shop_truck_region` VALUES (1889, 1880, 'L', '临湘', '临湘市', 3, 'linxiang', '414300', 1, '113.4501', '29.47701');
INSERT INTO `shop_truck_region` VALUES (1890, 1827, 'C', '常德', '常德市', 2, 'changde', '415000', 1, '111.691347', '29.040225');
INSERT INTO `shop_truck_region` VALUES (1891, 1890, 'W', '武陵', '武陵区', 3, 'wuling', '415000', 1, '111.69791', '29.02876');
INSERT INTO `shop_truck_region` VALUES (1892, 1890, 'D', '鼎城', '鼎城区', 3, 'dingcheng', '415101', 1, '111.68078', '29.01859');
INSERT INTO `shop_truck_region` VALUES (1893, 1890, 'A', '安乡', '安乡县', 3, 'anxiang', '415600', 1, '112.16732', '29.41326');
INSERT INTO `shop_truck_region` VALUES (1894, 1890, 'H', '汉寿', '汉寿县', 3, 'hanshou', '415900', 1, '111.96691', '28.90299');
INSERT INTO `shop_truck_region` VALUES (1895, 1890, NULL, '澧县', '澧县', 3, 'lixian', '415500', 1, '111.75866', '29.63317');
INSERT INTO `shop_truck_region` VALUES (1896, 1890, 'L', '临澧', '临澧县', 3, 'linli', '415200', 1, '111.65161', '29.44163');
INSERT INTO `shop_truck_region` VALUES (1897, 1890, 'T', '桃源', '桃源县', 3, 'taoyuan', '415700', 1, '111.48892', '28.90474');
INSERT INTO `shop_truck_region` VALUES (1898, 1890, 'S', '石门', '石门县', 3, 'shimen', '415300', 1, '111.37966', '29.58424');
INSERT INTO `shop_truck_region` VALUES (1899, 1890, 'J', '津市', '津市市', 3, 'jinshi', '415400', 1, '111.87756', '29.60563');
INSERT INTO `shop_truck_region` VALUES (1900, 1827, 'Z', '张家界', '张家界市', 2, 'zhangjiajie', '427000', 1, '110.479921', '29.127401');
INSERT INTO `shop_truck_region` VALUES (1901, 1900, 'Y', '永定', '永定区', 3, 'yongding', '427000', 1, '110.47464', '29.13387');
INSERT INTO `shop_truck_region` VALUES (1902, 1900, 'W', '武陵源', '武陵源区', 3, 'wulingyuan', '427400', 1, '110.55026', '29.34574');
INSERT INTO `shop_truck_region` VALUES (1903, 1900, 'C', '慈利', '慈利县', 3, 'cili', '427200', 1, '111.13946', '29.42989');
INSERT INTO `shop_truck_region` VALUES (1904, 1900, 'S', '桑植', '桑植县', 3, 'sangzhi', '427100', 1, '110.16308', '29.39815');
INSERT INTO `shop_truck_region` VALUES (1905, 1827, 'Y', '益阳', '益阳市', 2, 'yiyang', '413000', 1, '112.355042', '28.570066');
INSERT INTO `shop_truck_region` VALUES (1906, 1905, 'Z', '资阳', '资阳区', 3, 'ziyang', '413001', 1, '112.32447', '28.59095');
INSERT INTO `shop_truck_region` VALUES (1907, 1905, 'H', '赫山', '赫山区', 3, 'heshan', '413002', 1, '112.37265', '28.57425');
INSERT INTO `shop_truck_region` VALUES (1908, 1905, 'N', '南县', '南县', 3, 'nanxian', '413200', 1, '112.3963', '29.36159');
INSERT INTO `shop_truck_region` VALUES (1909, 1905, 'T', '桃江', '桃江县', 3, 'taojiang', '413400', 1, '112.1557', '28.51814');
INSERT INTO `shop_truck_region` VALUES (1910, 1905, 'A', '安化', '安化县', 3, 'anhua', '413500', 1, '111.21298', '28.37424');
INSERT INTO `shop_truck_region` VALUES (1911, 1905, NULL, '沅江', '沅江市', 3, 'yuanjiang', '413100', 1, '112.35427', '28.84403');
INSERT INTO `shop_truck_region` VALUES (1912, 1827, 'C', '郴州', '郴州市', 2, 'chenzhou', '423000', 1, '113.032067', '25.793589');
INSERT INTO `shop_truck_region` VALUES (1913, 1912, 'B', '北湖', '北湖区', 3, 'beihu', '423000', 1, '113.01103', '25.78405');
INSERT INTO `shop_truck_region` VALUES (1914, 1912, 'S', '苏仙', '苏仙区', 3, 'suxian', '423000', 1, '113.04226', '25.80045');
INSERT INTO `shop_truck_region` VALUES (1915, 1912, 'G', '桂阳', '桂阳县', 3, 'guiyang', '424400', 1, '112.73364', '25.75406');
INSERT INTO `shop_truck_region` VALUES (1916, 1912, 'Y', '宜章', '宜章县', 3, 'yizhang', '424200', 1, '112.95147', '25.39931');
INSERT INTO `shop_truck_region` VALUES (1917, 1912, 'Y', '永兴', '永兴县', 3, 'yongxing', '423300', 1, '113.11242', '26.12646');
INSERT INTO `shop_truck_region` VALUES (1918, 1912, 'J', '嘉禾', '嘉禾县', 3, 'jiahe', '424500', 1, '112.36935', '25.58795');
INSERT INTO `shop_truck_region` VALUES (1919, 1912, 'L', '临武', '临武县', 3, 'linwu', '424300', 1, '112.56369', '25.27602');
INSERT INTO `shop_truck_region` VALUES (1920, 1912, 'R', '汝城', '汝城县', 3, 'rucheng', '424100', 1, '113.68582', '25.55204');
INSERT INTO `shop_truck_region` VALUES (1921, 1912, 'G', '桂东', '桂东县', 3, 'guidong', '423500', 1, '113.9468', '26.07987');
INSERT INTO `shop_truck_region` VALUES (1922, 1912, 'A', '安仁', '安仁县', 3, 'anren', '423600', 1, '113.26944', '26.70931');
INSERT INTO `shop_truck_region` VALUES (1923, 1912, 'Z', '资兴', '资兴市', 3, 'zixing', '423400', 1, '113.23724', '25.97668');
INSERT INTO `shop_truck_region` VALUES (1924, 1827, 'Y', '永州', '永州市', 2, 'yongzhou', '425000', 1, '111.608019', '26.434516');
INSERT INTO `shop_truck_region` VALUES (1925, 1924, 'L', '零陵', '零陵区', 3, 'lingling', '425100', 1, '111.62103', '26.22109');
INSERT INTO `shop_truck_region` VALUES (1926, 1924, 'L', '冷水滩', '冷水滩区', 3, 'lengshuitan', '425100', 1, '111.59214', '26.46107');
INSERT INTO `shop_truck_region` VALUES (1927, 1924, 'Q', '祁阳', '祁阳县', 3, 'qiyang', '426100', 1, '111.84011', '26.58009');
INSERT INTO `shop_truck_region` VALUES (1928, 1924, 'D', '东安', '东安县', 3, 'dongan', '425900', 1, '111.3164', '26.39202');
INSERT INTO `shop_truck_region` VALUES (1929, 1924, 'S', '双牌', '双牌县', 3, 'shuangpai', '425200', 1, '111.65927', '25.95988');
INSERT INTO `shop_truck_region` VALUES (1930, 1924, 'D', '道县', '道县', 3, 'daoxian', '425300', 1, '111.60195', '25.52766');
INSERT INTO `shop_truck_region` VALUES (1931, 1924, 'J', '江永', '江永县', 3, 'jiangyong', '425400', 1, '111.34082', '25.27233');
INSERT INTO `shop_truck_region` VALUES (1932, 1924, 'N', '宁远', '宁远县', 3, 'ningyuan', '425600', 1, '111.94625', '25.56913');
INSERT INTO `shop_truck_region` VALUES (1933, 1924, 'L', '蓝山', '蓝山县', 3, 'lanshan', '425800', 1, '112.19363', '25.36794');
INSERT INTO `shop_truck_region` VALUES (1934, 1924, 'X', '新田', '新田县', 3, 'xintian', '425700', 1, '112.22103', '25.9095');
INSERT INTO `shop_truck_region` VALUES (1935, 1924, 'J', '江华', '江华瑶族自治县', 3, 'jianghua', '425500', 1, '111.58847', '25.1845');
INSERT INTO `shop_truck_region` VALUES (1936, 1827, 'H', '怀化', '怀化市', 2, 'huaihua', '418000', 1, '109.97824', '27.550082');
INSERT INTO `shop_truck_region` VALUES (1937, 1936, 'H', '鹤城', '鹤城区', 3, 'hecheng', '418000', 1, '109.96509', '27.54942');
INSERT INTO `shop_truck_region` VALUES (1938, 1936, 'Z', '中方', '中方县', 3, 'zhongfang', '418005', 1, '109.94497', '27.43988');
INSERT INTO `shop_truck_region` VALUES (1939, 1936, NULL, '沅陵', '沅陵县', 3, 'yuanling', '419600', 1, '110.39633', '28.45548');
INSERT INTO `shop_truck_region` VALUES (1940, 1936, 'C', '辰溪', '辰溪县', 3, 'chenxi', '419500', 1, '110.18942', '28.00406');
INSERT INTO `shop_truck_region` VALUES (1941, 1936, NULL, '溆浦', '溆浦县', 3, 'xupu', '419300', 1, '110.59384', '27.90836');
INSERT INTO `shop_truck_region` VALUES (1942, 1936, 'H', '会同', '会同县', 3, 'huitong', '418300', 1, '109.73568', '26.88716');
INSERT INTO `shop_truck_region` VALUES (1943, 1936, 'M', '麻阳', '麻阳苗族自治县', 3, 'mayang', '419400', 1, '109.80194', '27.866');
INSERT INTO `shop_truck_region` VALUES (1944, 1936, 'X', '新晃', '新晃侗族自治县', 3, 'xinhuang', '419200', 1, '109.17166', '27.35937');
INSERT INTO `shop_truck_region` VALUES (1945, 1936, NULL, '芷江', '芷江侗族自治县', 3, 'zhijiang', '419100', 1, '109.6849', '27.44297');
INSERT INTO `shop_truck_region` VALUES (1946, 1936, 'J', '靖州', '靖州苗族侗族自治县', 3, 'jingzhou', '418400', 1, '109.69821', '26.57651');
INSERT INTO `shop_truck_region` VALUES (1947, 1936, 'T', '通道', '通道侗族自治县', 3, 'tongdao', '418500', 1, '109.78515', '26.1571');
INSERT INTO `shop_truck_region` VALUES (1948, 1936, 'H', '洪江', '洪江市', 3, 'hongjiang', '418100', 1, '109.83651', '27.20922');
INSERT INTO `shop_truck_region` VALUES (1949, 1827, 'L', '娄底', '娄底市', 2, 'loudi', '417000', 1, '112.008497', '27.728136');
INSERT INTO `shop_truck_region` VALUES (1950, 1949, 'L', '娄星', '娄星区', 3, 'louxing', '417000', 1, '112.00193', '27.72992');
INSERT INTO `shop_truck_region` VALUES (1951, 1949, 'S', '双峰', '双峰县', 3, 'shuangfeng', '417700', 1, '112.19921', '27.45418');
INSERT INTO `shop_truck_region` VALUES (1952, 1949, 'X', '新化', '新化县', 3, 'xinhua', '417600', 1, '111.32739', '27.7266');
INSERT INTO `shop_truck_region` VALUES (1953, 1949, 'L', '冷水江', '冷水江市', 3, 'lengshuijiang', '417500', 1, '111.43554', '27.68147');
INSERT INTO `shop_truck_region` VALUES (1954, 1949, 'L', '涟源', '涟源市', 3, 'lianyuan', '417100', 1, '111.67233', '27.68831');
INSERT INTO `shop_truck_region` VALUES (1955, 1827, 'X', '湘西', '湘西土家族苗族自治州', 2, 'xiangxi', '416000', 1, '109.739735', '28.314296');
INSERT INTO `shop_truck_region` VALUES (1956, 1955, 'J', '吉首', '吉首市', 3, 'jishou', '416000', 1, '109.69799', '28.26247');
INSERT INTO `shop_truck_region` VALUES (1957, 1955, NULL, '泸溪', '泸溪县', 3, 'luxi', '416100', 1, '110.21682', '28.2205');
INSERT INTO `shop_truck_region` VALUES (1958, 1955, 'F', '凤凰', '凤凰县', 3, 'fenghuang', '416200', 1, '109.60156', '27.94822');
INSERT INTO `shop_truck_region` VALUES (1959, 1955, 'H', '花垣', '花垣县', 3, 'huayuan', '416400', 1, '109.48217', '28.5721');
INSERT INTO `shop_truck_region` VALUES (1960, 1955, 'B', '保靖', '保靖县', 3, 'baojing', '416500', 1, '109.66049', '28.69997');
INSERT INTO `shop_truck_region` VALUES (1961, 1955, 'G', '古丈', '古丈县', 3, 'guzhang', '416300', 1, '109.94812', '28.61944');
INSERT INTO `shop_truck_region` VALUES (1962, 1955, 'Y', '永顺', '永顺县', 3, 'yongshun', '416700', 1, '109.85266', '29.00103');
INSERT INTO `shop_truck_region` VALUES (1963, 1955, 'L', '龙山', '龙山县', 3, 'longshan', '416800', 1, '109.4432', '29.45693');
INSERT INTO `shop_truck_region` VALUES (1964, 0, 'G', '广东', '广东省', 1, 'guangdong', '', 1, '113.280637', '23.125178');
INSERT INTO `shop_truck_region` VALUES (1965, 1964, 'G', '广州', '广州市', 2, 'guangzhou', '510032', 1, '113.280637', '23.125178');
INSERT INTO `shop_truck_region` VALUES (1966, 1965, 'L', '荔湾', '荔湾区', 3, 'liwan', '510170', 1, '113.2442', '23.12592');
INSERT INTO `shop_truck_region` VALUES (1967, 1965, 'Y', '越秀', '越秀区', 3, 'yuexiu', '510030', 1, '113.26683', '23.12897');
INSERT INTO `shop_truck_region` VALUES (1968, 1965, 'H', '海珠', '海珠区', 3, 'haizhu', '510300', 1, '113.26197', '23.10379');
INSERT INTO `shop_truck_region` VALUES (1969, 1965, 'T', '天河', '天河区', 3, 'tianhe', '510665', 1, '113.36112', '23.12467');
INSERT INTO `shop_truck_region` VALUES (1970, 1965, 'B', '白云', '白云区', 3, 'baiyun', '510405', 1, '113.27307', '23.15787');
INSERT INTO `shop_truck_region` VALUES (1971, 1965, 'H', '黄埔', '黄埔区', 3, 'huangpu', '510700', 1, '113.45895', '23.10642');
INSERT INTO `shop_truck_region` VALUES (1972, 1965, 'F', '番禺', '番禺区', 3, 'panyu', '511400', 1, '113.38397', '22.93599');
INSERT INTO `shop_truck_region` VALUES (1973, 1965, 'H', '花都', '花都区', 3, 'huadu', '510800', 1, '113.22033', '23.40358');
INSERT INTO `shop_truck_region` VALUES (1974, 1965, 'N', '南沙', '南沙区', 3, 'nansha', '511458', 1, '113.60845', '22.77144');
INSERT INTO `shop_truck_region` VALUES (1975, 1965, 'C', '从化', '从化区', 3, 'conghua', '510900', 1, '113.587386', '23.545283');
INSERT INTO `shop_truck_region` VALUES (1976, 1965, 'Z', '增城', '增城区', 3, 'zengcheng', '511300', 1, '113.829579', '23.290497');
INSERT INTO `shop_truck_region` VALUES (1977, 1964, 'S', '韶关', '韶关市', 2, 'shaoguan', '512002', 1, '113.591544', '24.801322');
INSERT INTO `shop_truck_region` VALUES (1978, 1977, 'W', '武江', '武江区', 3, 'wujiang', '512026', 1, '113.58767', '24.79264');
INSERT INTO `shop_truck_region` VALUES (1979, 1977, NULL, '浈江', '浈江区', 3, 'zhenjiang', '512023', 1, '113.61109', '24.80438');
INSERT INTO `shop_truck_region` VALUES (1980, 1977, 'Q', '曲江', '曲江区', 3, 'qujiang', '512101', 1, '113.60165', '24.67915');
INSERT INTO `shop_truck_region` VALUES (1981, 1977, 'S', '始兴', '始兴县', 3, 'shixing', '512500', 1, '114.06799', '24.94759');
INSERT INTO `shop_truck_region` VALUES (1982, 1977, 'R', '仁化', '仁化县', 3, 'renhua', '512300', 1, '113.74737', '25.08742');
INSERT INTO `shop_truck_region` VALUES (1983, 1977, 'W', '翁源', '翁源县', 3, 'wengyuan', '512600', 1, '114.13385', '24.3495');
INSERT INTO `shop_truck_region` VALUES (1984, 1977, 'R', '乳源', '乳源瑶族自治县', 3, 'ruyuan', '512700', 1, '113.27734', '24.77803');
INSERT INTO `shop_truck_region` VALUES (1985, 1977, 'X', '新丰', '新丰县', 3, 'xinfeng', '511100', 1, '114.20788', '24.05924');
INSERT INTO `shop_truck_region` VALUES (1986, 1977, 'L', '乐昌', '乐昌市', 3, 'lechang', '512200', 1, '113.35653', '25.12799');
INSERT INTO `shop_truck_region` VALUES (1987, 1977, 'N', '南雄', '南雄市', 3, 'nanxiong', '512400', 1, '114.30966', '25.11706');
INSERT INTO `shop_truck_region` VALUES (1988, 1964, 'S', '深圳', '深圳市', 2, 'shenzhen', '518035', 1, '114.085947', '22.547');
INSERT INTO `shop_truck_region` VALUES (1989, 1988, 'L', '罗湖', '罗湖区', 3, 'luohu', '518021', 1, '114.13116', '22.54836');
INSERT INTO `shop_truck_region` VALUES (1990, 1988, 'F', '福田', '福田区', 3, 'futian', '518048', 1, '114.05571', '22.52245');
INSERT INTO `shop_truck_region` VALUES (1991, 1988, 'N', '南山', '南山区', 3, 'nanshan', '518051', 1, '113.93029', '22.53291');
INSERT INTO `shop_truck_region` VALUES (1992, 1988, 'B', '宝安', '宝安区', 3, 'baoan', '518101', 1, '113.88311', '22.55371');
INSERT INTO `shop_truck_region` VALUES (1993, 1988, 'L', '龙岗', '龙岗区', 3, 'longgang', '518172', 1, '114.24771', '22.71986');
INSERT INTO `shop_truck_region` VALUES (1994, 1988, 'Y', '盐田', '盐田区', 3, 'yantian', '518081', 1, '114.23733', '22.5578');
INSERT INTO `shop_truck_region` VALUES (1995, 1988, 'G', '光明新区', '光明新区', 3, 'guangmingxinqu', '518100', 1, '113.896026', '22.777292');
INSERT INTO `shop_truck_region` VALUES (1996, 1988, 'P', '坪山新区', '坪山新区', 3, 'pingshanxinqu', '518000', 1, '114.34637', '22.690529');
INSERT INTO `shop_truck_region` VALUES (1997, 1988, 'D', '大鹏新区', '大鹏新区', 3, 'dapengxinqu', '518000', 1, '114.479901', '22.587862');
INSERT INTO `shop_truck_region` VALUES (1998, 1988, 'L', '龙华新区', '龙华新区', 3, 'longhuaxinqu', '518100', 1, '114.036585', '22.68695');
INSERT INTO `shop_truck_region` VALUES (1999, 1964, 'Z', '珠海', '珠海市', 2, 'zhuhai', '519000', 1, '113.552724', '22.255899');
INSERT INTO `shop_truck_region` VALUES (2000, 1999, 'X', '香洲', '香洲区', 3, 'xiangzhou', '519000', 1, '113.5435', '22.26654');
INSERT INTO `shop_truck_region` VALUES (2001, 1999, 'D', '斗门', '斗门区', 3, 'doumen', '519110', 1, '113.29644', '22.20898');
INSERT INTO `shop_truck_region` VALUES (2002, 1999, 'J', '金湾', '金湾区', 3, 'jinwan', '519040', 1, '113.36361', '22.14691');
INSERT INTO `shop_truck_region` VALUES (2003, 1964, 'S', '汕头', '汕头市', 2, 'shantou', '515041', 1, '116.708463', '23.37102');
INSERT INTO `shop_truck_region` VALUES (2004, 2003, 'L', '龙湖', '龙湖区', 3, 'longhu', '515041', 1, '116.71641', '23.37166');
INSERT INTO `shop_truck_region` VALUES (2005, 2003, 'J', '金平', '金平区', 3, 'jinping', '515041', 1, '116.70364', '23.36637');
INSERT INTO `shop_truck_region` VALUES (2006, 2003, NULL, '濠江', '濠江区', 3, 'haojiang', '515071', 1, '116.72659', '23.28588');
INSERT INTO `shop_truck_region` VALUES (2007, 2003, 'C', '潮阳', '潮阳区', 3, 'chaoyang', '515100', 1, '116.6015', '23.26485');
INSERT INTO `shop_truck_region` VALUES (2008, 2003, 'C', '潮南', '潮南区', 3, 'chaonan', '515144', 1, '116.43188', '23.25');
INSERT INTO `shop_truck_region` VALUES (2009, 2003, 'C', '澄海', '澄海区', 3, 'chenghai', '515800', 1, '116.75589', '23.46728');
INSERT INTO `shop_truck_region` VALUES (2010, 2003, 'N', '南澳', '南澳县', 3, 'nanao', '515900', 1, '117.01889', '23.4223');
INSERT INTO `shop_truck_region` VALUES (2011, 1964, 'F', '佛山', '佛山市', 2, 'foshan', '528000', 1, '113.122717', '23.028762');
INSERT INTO `shop_truck_region` VALUES (2012, 2011, NULL, '禅城', '禅城区', 3, 'chancheng', '528000', 1, '113.1228', '23.00842');
INSERT INTO `shop_truck_region` VALUES (2013, 2011, 'N', '南海', '南海区', 3, 'nanhai', '528251', 1, '113.14299', '23.02877');
INSERT INTO `shop_truck_region` VALUES (2014, 2011, 'S', '顺德', '顺德区', 3, 'shunde', '528300', 1, '113.29394', '22.80452');
INSERT INTO `shop_truck_region` VALUES (2015, 2011, 'S', '三水', '三水区', 3, 'sanshui', '528133', 1, '112.89703', '23.15564');
INSERT INTO `shop_truck_region` VALUES (2016, 2011, 'G', '高明', '高明区', 3, 'gaoming', '528500', 1, '112.89254', '22.90022');
INSERT INTO `shop_truck_region` VALUES (2017, 1964, 'J', '江门', '江门市', 2, 'jiangmen', '529000', 1, '113.094942', '22.590431');
INSERT INTO `shop_truck_region` VALUES (2018, 2017, 'P', '蓬江', '蓬江区', 3, 'pengjiang', '529000', 1, '113.07849', '22.59515');
INSERT INTO `shop_truck_region` VALUES (2019, 2017, 'J', '江海', '江海区', 3, 'jianghai', '529040', 1, '113.11099', '22.56024');
INSERT INTO `shop_truck_region` VALUES (2020, 2017, 'X', '新会', '新会区', 3, 'xinhui', '529100', 1, '113.03225', '22.45876');
INSERT INTO `shop_truck_region` VALUES (2021, 2017, 'T', '台山', '台山市', 3, 'taishan', '529200', 1, '112.79382', '22.2515');
INSERT INTO `shop_truck_region` VALUES (2022, 2017, 'K', '开平', '开平市', 3, 'kaiping', '529337', 1, '112.69842', '22.37622');
INSERT INTO `shop_truck_region` VALUES (2023, 2017, 'H', '鹤山', '鹤山市', 3, 'heshan', '529700', 1, '112.96429', '22.76523');
INSERT INTO `shop_truck_region` VALUES (2024, 2017, 'E', '恩平', '恩平市', 3, 'enping', '529400', 1, '112.30496', '22.18288');
INSERT INTO `shop_truck_region` VALUES (2025, 1964, 'Z', '湛江', '湛江市', 2, 'zhanjiang', '524047', 1, '110.405529', '21.195338');
INSERT INTO `shop_truck_region` VALUES (2026, 2025, 'C', '赤坎', '赤坎区', 3, 'chikan', '524033', 1, '110.36592', '21.26606');
INSERT INTO `shop_truck_region` VALUES (2027, 2025, 'X', '霞山', '霞山区', 3, 'xiashan', '524011', 1, '110.39822', '21.19181');
INSERT INTO `shop_truck_region` VALUES (2028, 2025, 'P', '坡头', '坡头区', 3, 'potou', '524057', 1, '110.45533', '21.24472');
INSERT INTO `shop_truck_region` VALUES (2029, 2025, 'M', '麻章', '麻章区', 3, 'mazhang', '524094', 1, '110.3342', '21.26333');
INSERT INTO `shop_truck_region` VALUES (2030, 2025, 'S', '遂溪', '遂溪县', 3, 'suixi', '524300', 1, '110.25003', '21.37721');
INSERT INTO `shop_truck_region` VALUES (2031, 2025, 'X', '徐闻', '徐闻县', 3, 'xuwen', '524100', 1, '110.17379', '20.32812');
INSERT INTO `shop_truck_region` VALUES (2032, 2025, 'L', '廉江', '廉江市', 3, 'lianjiang', '524400', 1, '110.28442', '21.60917');
INSERT INTO `shop_truck_region` VALUES (2033, 2025, 'L', '雷州', '雷州市', 3, 'leizhou', '524200', 1, '110.10092', '20.91428');
INSERT INTO `shop_truck_region` VALUES (2034, 2025, 'W', '吴川', '吴川市', 3, 'wuchuan', '524500', 1, '110.77703', '21.44584');
INSERT INTO `shop_truck_region` VALUES (2035, 1964, 'M', '茂名', '茂名市', 2, 'maoming', '525000', 1, '110.919229', '21.659751');
INSERT INTO `shop_truck_region` VALUES (2036, 2035, 'M', '茂南', '茂南区', 3, 'maonan', '525000', 1, '110.9187', '21.64103');
INSERT INTO `shop_truck_region` VALUES (2037, 2035, 'D', '电白', '电白区', 3, 'dianbai', '525400', 1, '111.007264', '21.507219');
INSERT INTO `shop_truck_region` VALUES (2038, 2035, 'G', '高州', '高州市', 3, 'gaozhou', '525200', 1, '110.85519', '21.92057');
INSERT INTO `shop_truck_region` VALUES (2039, 2035, 'H', '化州', '化州市', 3, 'huazhou', '525100', 1, '110.63949', '21.66394');
INSERT INTO `shop_truck_region` VALUES (2040, 2035, 'X', '信宜', '信宜市', 3, 'xinyi', '525300', 1, '110.94647', '22.35351');
INSERT INTO `shop_truck_region` VALUES (2041, 1964, 'Z', '肇庆', '肇庆市', 2, 'zhaoqing', '526040', 1, '112.472529', '23.051546');
INSERT INTO `shop_truck_region` VALUES (2042, 2041, 'D', '端州', '端州区', 3, 'duanzhou', '526060', 1, '112.48495', '23.0519');
INSERT INTO `shop_truck_region` VALUES (2043, 2041, 'D', '鼎湖', '鼎湖区', 3, 'dinghu', '526070', 1, '112.56643', '23.15846');
INSERT INTO `shop_truck_region` VALUES (2044, 2041, 'G', '广宁', '广宁县', 3, 'guangning', '526300', 1, '112.44064', '23.6346');
INSERT INTO `shop_truck_region` VALUES (2045, 2041, 'H', '怀集', '怀集县', 3, 'huaiji', '526400', 1, '112.18396', '23.90918');
INSERT INTO `shop_truck_region` VALUES (2046, 2041, 'F', '封开', '封开县', 3, 'fengkai', '526500', 1, '111.50332', '23.43571');
INSERT INTO `shop_truck_region` VALUES (2047, 2041, 'D', '德庆', '德庆县', 3, 'deqing', '526600', 1, '111.78555', '23.14371');
INSERT INTO `shop_truck_region` VALUES (2048, 2041, 'G', '高要', '高要市', 3, 'gaoyao', '526100', 1, '112.45834', '23.02577');
INSERT INTO `shop_truck_region` VALUES (2049, 2041, 'S', '四会', '四会市', 3, 'sihui', '526200', 1, '112.73416', '23.32686');
INSERT INTO `shop_truck_region` VALUES (2050, 1964, 'H', '惠州', '惠州市', 2, 'huizhou', '516000', 1, '114.412599', '23.079404');
INSERT INTO `shop_truck_region` VALUES (2051, 2050, 'H', '惠城', '惠城区', 3, 'huicheng', '516008', 1, '114.3828', '23.08377');
INSERT INTO `shop_truck_region` VALUES (2052, 2050, 'H', '惠阳', '惠阳区', 3, 'huiyang', '516211', 1, '114.45639', '22.78845');
INSERT INTO `shop_truck_region` VALUES (2053, 2050, 'B', '博罗', '博罗县', 3, 'boluo', '516100', 1, '114.28964', '23.17307');
INSERT INTO `shop_truck_region` VALUES (2054, 2050, 'H', '惠东', '惠东县', 3, 'huidong', '516300', 1, '114.72009', '22.98484');
INSERT INTO `shop_truck_region` VALUES (2055, 2050, 'L', '龙门', '龙门县', 3, 'longmen', '516800', 1, '114.25479', '23.72758');
INSERT INTO `shop_truck_region` VALUES (2056, 1964, 'M', '梅州', '梅州市', 2, 'meizhou', '514021', 1, '116.117582', '24.299112');
INSERT INTO `shop_truck_region` VALUES (2057, 2056, 'M', '梅江', '梅江区', 3, 'meijiang', '514000', 1, '116.11663', '24.31062');
INSERT INTO `shop_truck_region` VALUES (2058, 2056, 'M', '梅县', '梅县区', 3, 'meixian', '514787', 1, '116.097753', '24.286739');
INSERT INTO `shop_truck_region` VALUES (2059, 2056, 'D', '大埔', '大埔县', 3, 'dabu', '514200', 1, '116.69662', '24.35325');
INSERT INTO `shop_truck_region` VALUES (2060, 2056, 'F', '丰顺', '丰顺县', 3, 'fengshun', '514300', 1, '116.18219', '23.74094');
INSERT INTO `shop_truck_region` VALUES (2061, 2056, 'W', '五华', '五华县', 3, 'wuhua', '514400', 1, '115.77893', '23.92417');
INSERT INTO `shop_truck_region` VALUES (2062, 2056, 'P', '平远', '平远县', 3, 'pingyuan', '514600', 1, '115.89556', '24.57116');
INSERT INTO `shop_truck_region` VALUES (2063, 2056, 'J', '蕉岭', '蕉岭县', 3, 'jiaoling', '514100', 1, '116.17089', '24.65732');
INSERT INTO `shop_truck_region` VALUES (2064, 2056, 'X', '兴宁', '兴宁市', 3, 'xingning', '514500', 1, '115.73141', '24.14001');
INSERT INTO `shop_truck_region` VALUES (2065, 1964, 'S', '汕尾', '汕尾市', 2, 'shanwei', '516600', 1, '115.364238', '22.774485');
INSERT INTO `shop_truck_region` VALUES (2066, 2065, 'C', '城区', '城区', 3, 'chengqu', '516600', 1, '115.36503', '22.7789');
INSERT INTO `shop_truck_region` VALUES (2067, 2065, 'H', '海丰', '海丰县', 3, 'haifeng', '516400', 1, '115.32336', '22.96653');
INSERT INTO `shop_truck_region` VALUES (2068, 2065, 'L', '陆河', '陆河县', 3, 'luhe', '516700', 1, '115.65597', '23.30365');
INSERT INTO `shop_truck_region` VALUES (2069, 2065, 'L', '陆丰', '陆丰市', 3, 'lufeng', '516500', 1, '115.64813', '22.94335');
INSERT INTO `shop_truck_region` VALUES (2070, 1964, 'H', '河源', '河源市', 2, 'heyuan', '517000', 1, '114.697802', '23.746266');
INSERT INTO `shop_truck_region` VALUES (2071, 2070, 'Y', '源城', '源城区', 3, 'yuancheng', '517000', 1, '114.70242', '23.7341');
INSERT INTO `shop_truck_region` VALUES (2072, 2070, 'Z', '紫金', '紫金县', 3, 'zijin', '517400', 1, '115.18365', '23.63867');
INSERT INTO `shop_truck_region` VALUES (2073, 2070, 'L', '龙川', '龙川县', 3, 'longchuan', '517300', 1, '115.26025', '24.10142');
INSERT INTO `shop_truck_region` VALUES (2074, 2070, 'L', '连平', '连平县', 3, 'lianping', '517100', 1, '114.49026', '24.37156');
INSERT INTO `shop_truck_region` VALUES (2075, 2070, 'H', '和平', '和平县', 3, 'heping', '517200', 1, '114.93841', '24.44319');
INSERT INTO `shop_truck_region` VALUES (2076, 2070, 'D', '东源', '东源县', 3, 'dongyuan', '517583', 1, '114.74633', '23.78835');
INSERT INTO `shop_truck_region` VALUES (2077, 1964, 'Y', '阳江', '阳江市', 2, 'yangjiang', '529500', 1, '111.975107', '21.859222');
INSERT INTO `shop_truck_region` VALUES (2078, 2077, 'J', '江城', '江城区', 3, 'jiangcheng', '529500', 1, '111.95488', '21.86193');
INSERT INTO `shop_truck_region` VALUES (2079, 2077, 'Y', '阳东', '阳东区', 3, 'yangdong', '529900', 1, '112.01467', '21.87398');
INSERT INTO `shop_truck_region` VALUES (2080, 2077, 'Y', '阳西', '阳西县', 3, 'yangxi', '529800', 1, '111.61785', '21.75234');
INSERT INTO `shop_truck_region` VALUES (2081, 2077, 'Y', '阳春', '阳春市', 3, 'yangchun', '529600', 1, '111.78854', '22.17232');
INSERT INTO `shop_truck_region` VALUES (2082, 1964, 'Q', '清远', '清远市', 2, 'qingyuan', '511500', 1, '113.036779', '23.704188');
INSERT INTO `shop_truck_region` VALUES (2083, 2082, 'Q', '清城', '清城区', 3, 'qingcheng', '511515', 1, '113.06265', '23.69784');
INSERT INTO `shop_truck_region` VALUES (2084, 2082, 'Q', '清新', '清新区', 3, 'qingxin', '511810', 1, '113.015203', '23.736949');
INSERT INTO `shop_truck_region` VALUES (2085, 2082, 'F', '佛冈', '佛冈县', 3, 'fogang', '511600', 1, '113.53286', '23.87231');
INSERT INTO `shop_truck_region` VALUES (2086, 2082, 'Y', '阳山', '阳山县', 3, 'yangshan', '513100', 1, '112.64129', '24.46516');
INSERT INTO `shop_truck_region` VALUES (2087, 2082, 'L', '连山', '连山壮族瑶族自治县', 3, 'lianshan', '513200', 1, '112.0802', '24.56807');
INSERT INTO `shop_truck_region` VALUES (2088, 2082, 'L', '连南', '连南瑶族自治县', 3, 'liannan', '513300', 1, '112.28842', '24.71726');
INSERT INTO `shop_truck_region` VALUES (2089, 2082, 'Y', '英德', '英德市', 3, 'yingde', '513000', 1, '113.415', '24.18571');
INSERT INTO `shop_truck_region` VALUES (2090, 2082, 'L', '连州', '连州市', 3, 'lianzhou', '513400', 1, '112.38153', '24.77913');
INSERT INTO `shop_truck_region` VALUES (2091, 1964, 'D', '东莞', '东莞市', 2, 'dongguan', '523888', 1, '113.760234', '23.048884');
INSERT INTO `shop_truck_region` VALUES (2092, 2091, NULL, '莞城', '莞城区', 3, 'guancheng', '523128', 1, '113.751043', '23.053412');
INSERT INTO `shop_truck_region` VALUES (2093, 2091, 'N', '南城', '南城区', 3, 'nancheng', '523617', 1, '113.752125', '23.02018');
INSERT INTO `shop_truck_region` VALUES (2094, 2091, 'W', '万江', '万江区', 3, 'wanjiang', '523039', 1, '113.739053', '23.043842');
INSERT INTO `shop_truck_region` VALUES (2095, 2091, 'S', '石碣', '石碣镇', 3, 'shijie', '523290', 1, '113.80217', '23.09899');
INSERT INTO `shop_truck_region` VALUES (2096, 2091, 'S', '石龙', '石龙镇', 3, 'shilong', '523326', 1, '113.876381', '23.107444');
INSERT INTO `shop_truck_region` VALUES (2097, 2091, 'C', '茶山', '茶山镇', 3, 'chashan', '523380', 1, '113.883526', '23.062375');
INSERT INTO `shop_truck_region` VALUES (2098, 2091, 'S', '石排', '石排镇', 3, 'shipai', '523346', 1, '113.919859', '23.0863');
INSERT INTO `shop_truck_region` VALUES (2099, 2091, 'Q', '企石', '企石镇', 3, 'qishi', '523507', 1, '114.013233', '23.066044');
INSERT INTO `shop_truck_region` VALUES (2100, 2091, 'H', '横沥', '横沥镇', 3, 'hengli', '523471', 1, '113.957436', '23.025732');
INSERT INTO `shop_truck_region` VALUES (2101, 2091, 'Q', '桥头', '桥头镇', 3, 'qiaotou', '523520', 1, '114.01385', '22.939727');
INSERT INTO `shop_truck_region` VALUES (2102, 2091, 'X', '谢岗', '谢岗镇', 3, 'xiegang', '523592', 1, '114.141396', '22.959664');
INSERT INTO `shop_truck_region` VALUES (2103, 2091, 'D', '东坑', '东坑镇', 3, 'dongkeng', '523451', 1, '113.939835', '22.992804');
INSERT INTO `shop_truck_region` VALUES (2104, 2091, 'C', '常平', '常平镇', 3, 'changping', '523560', 1, '114.029627', '23.016116');
INSERT INTO `shop_truck_region` VALUES (2105, 2091, NULL, '寮步', '寮步镇', 3, 'liaobu', '523411', 1, '113.884745', '22.991738');
INSERT INTO `shop_truck_region` VALUES (2106, 2091, 'D', '大朗', '大朗镇', 3, 'dalang', '523770', 1, '113.9271', '22.965748');
INSERT INTO `shop_truck_region` VALUES (2107, 2091, 'M', '麻涌', '麻涌镇', 3, 'machong', '523143', 1, '113.546177', '23.045315');
INSERT INTO `shop_truck_region` VALUES (2108, 2091, 'Z', '中堂', '中堂镇', 3, 'zhongtang', '523233', 1, '113.654422', '23.090164');
INSERT INTO `shop_truck_region` VALUES (2109, 2091, NULL, '高埗', '高埗镇', 3, 'gaobu', '523282', 1, '113.735917', '23.068415');
INSERT INTO `shop_truck_region` VALUES (2110, 2091, 'Z', '樟木头', '樟木头镇', 3, 'zhangmutou', '523619', 1, '114.066298', '22.956682');
INSERT INTO `shop_truck_region` VALUES (2111, 2091, 'D', '大岭山', '大岭山镇', 3, 'dalingshan', '523835', 1, '113.782955', '22.885366');
INSERT INTO `shop_truck_region` VALUES (2112, 2091, 'W', '望牛墩', '望牛墩镇', 3, 'wangniudun', '523203', 1, '113.658847', '23.055018');
INSERT INTO `shop_truck_region` VALUES (2113, 2091, 'H', '黄江', '黄江镇', 3, 'huangjiang', '523755', 1, '113.992635', '22.877536');
INSERT INTO `shop_truck_region` VALUES (2114, 2091, 'H', '洪梅', '洪梅镇', 3, 'hongmei', '523163', 1, '113.613081', '22.992675');
INSERT INTO `shop_truck_region` VALUES (2115, 2091, 'Q', '清溪', '清溪镇', 3, 'qingxi', '523660', 1, '114.155796', '22.844456');
INSERT INTO `shop_truck_region` VALUES (2116, 2091, 'S', '沙田', '沙田镇', 3, 'shatian', '523988', 1, '113.760234', '23.048884');
INSERT INTO `shop_truck_region` VALUES (2117, 2091, NULL, '道滘', '道滘镇', 3, 'daojiao', '523171', 1, '113.760234', '23.048884');
INSERT INTO `shop_truck_region` VALUES (2118, 2091, 'T', '塘厦', '塘厦镇', 3, 'tangxia', '523713', 1, '114.10765', '22.822862');
INSERT INTO `shop_truck_region` VALUES (2119, 2091, 'H', '虎门', '虎门镇', 3, 'humen', '523932', 1, '113.71118', '22.82615');
INSERT INTO `shop_truck_region` VALUES (2120, 2091, 'H', '厚街', '厚街镇', 3, 'houjie', '523960', 1, '113.67301', '22.940815');
INSERT INTO `shop_truck_region` VALUES (2121, 2091, 'F', '凤岗', '凤岗镇', 3, 'fenggang', '523690', 1, '114.141194', '22.744598');
INSERT INTO `shop_truck_region` VALUES (2122, 2091, 'C', '长安', '长安镇', 3, 'changan', '523850', 1, '113.803939', '22.816644');
INSERT INTO `shop_truck_region` VALUES (2123, 1964, 'Z', '中山', '中山市', 2, 'zhongshan', '528403', 1, '113.382391', '22.521113');
INSERT INTO `shop_truck_region` VALUES (2124, 2123, 'S', '石岐', '石岐区', 3, 'shiqi', '528400', 1, '113.378835', '22.52522');
INSERT INTO `shop_truck_region` VALUES (2125, 2123, 'N', '南区', '南区', 3, 'nanqu', '528400', 1, '113.355896', '22.486568');
INSERT INTO `shop_truck_region` VALUES (2126, 2123, 'W', '五桂山', '五桂山区', 3, 'wuguishan', '528458', 1, '113.41079', '22.51968');
INSERT INTO `shop_truck_region` VALUES (2127, 2123, 'H', '火炬', '火炬开发区', 3, 'huoju', '528437', 1, '113.480523', '22.566082');
INSERT INTO `shop_truck_region` VALUES (2128, 2123, 'H', '黄圃', '黄圃镇', 3, 'huangpu', '528429', 1, '113.342359', '22.715116');
INSERT INTO `shop_truck_region` VALUES (2129, 2123, 'N', '南头', '南头镇', 3, 'nantou', '528421', 1, '113.296358', '22.713907');
INSERT INTO `shop_truck_region` VALUES (2130, 2123, 'D', '东凤', '东凤镇', 3, 'dongfeng', '528425', 1, '113.26114', '22.68775');
INSERT INTO `shop_truck_region` VALUES (2131, 2123, 'F', '阜沙', '阜沙镇', 3, 'fusha', '528434', 1, '113.353024', '22.666364');
INSERT INTO `shop_truck_region` VALUES (2132, 2123, 'X', '小榄', '小榄镇', 3, 'xiaolan', '528415', 1, '113.244235', '22.666951');
INSERT INTO `shop_truck_region` VALUES (2133, 2123, 'D', '东升', '东升镇', 3, 'dongsheng', '528400', 1, '113.296298', '22.614003');
INSERT INTO `shop_truck_region` VALUES (2134, 2123, 'G', '古镇', '古镇镇', 3, 'guzhen', '528422', 1, '113.179745', '22.611019');
INSERT INTO `shop_truck_region` VALUES (2135, 2123, 'H', '横栏', '横栏镇', 3, 'henglan', '528478', 1, '113.265845', '22.523202');
INSERT INTO `shop_truck_region` VALUES (2136, 2123, 'S', '三角', '三角镇', 3, 'sanjiao', '528422', 1, '113.423624', '22.677033');
INSERT INTO `shop_truck_region` VALUES (2137, 2123, 'M', '民众', '民众镇', 3, 'minzhong', '528441', 1, '113.486025', '22.623468');
INSERT INTO `shop_truck_region` VALUES (2138, 2123, 'N', '南朗', '南朗镇', 3, 'nanlang', '528454', 1, '113.533939', '22.492378');
INSERT INTO `shop_truck_region` VALUES (2139, 2123, 'G', '港口', '港口镇', 3, 'gangkou', '528447', 1, '113.382391', '22.521113');
INSERT INTO `shop_truck_region` VALUES (2140, 2123, 'D', '大涌', '大涌镇', 3, 'dayong', '528476', 1, '113.291708', '22.467712');
INSERT INTO `shop_truck_region` VALUES (2141, 2123, 'S', '沙溪', '沙溪镇', 3, 'shaxi', '528471', 1, '113.328369', '22.526325');
INSERT INTO `shop_truck_region` VALUES (2142, 2123, 'S', '三乡', '三乡镇', 3, 'sanxiang', '528463', 1, '113.4334', '22.352494');
INSERT INTO `shop_truck_region` VALUES (2143, 2123, 'B', '板芙', '板芙镇', 3, 'banfu', '528459', 1, '113.320346', '22.415674');
INSERT INTO `shop_truck_region` VALUES (2144, 2123, 'S', '神湾', '神湾镇', 3, 'shenwan', '528462', 1, '113.359387', '22.312476');
INSERT INTO `shop_truck_region` VALUES (2145, 2123, 'T', '坦洲', '坦洲镇', 3, 'tanzhou', '528467', 1, '113.485677', '22.261269');
INSERT INTO `shop_truck_region` VALUES (2146, 1964, 'C', '潮州', '潮州市', 2, 'chaozhou', '521000', 1, '116.632301', '23.661701');
INSERT INTO `shop_truck_region` VALUES (2147, 2146, 'X', '湘桥', '湘桥区', 3, 'xiangqiao', '521000', 1, '116.62805', '23.67451');
INSERT INTO `shop_truck_region` VALUES (2148, 2146, 'C', '潮安', '潮安区', 3, 'chaoan', '515638', 1, '116.592895', '23.643656');
INSERT INTO `shop_truck_region` VALUES (2149, 2146, 'R', '饶平', '饶平县', 3, 'raoping', '515700', 1, '117.00692', '23.66994');
INSERT INTO `shop_truck_region` VALUES (2150, 1964, 'J', '揭阳', '揭阳市', 2, 'jieyang', '522000', 1, '116.355733', '23.543778');
INSERT INTO `shop_truck_region` VALUES (2151, 2150, NULL, '榕城', '榕城区', 3, 'rongcheng', '522000', 1, '116.3671', '23.52508');
INSERT INTO `shop_truck_region` VALUES (2152, 2150, 'J', '揭东', '揭东区', 3, 'jiedong', '515500', 1, '116.412947', '23.569887');
INSERT INTO `shop_truck_region` VALUES (2153, 2150, 'J', '揭西', '揭西县', 3, 'jiexi', '515400', 1, '115.83883', '23.42714');
INSERT INTO `shop_truck_region` VALUES (2154, 2150, 'H', '惠来', '惠来县', 3, 'huilai', '515200', 1, '116.29599', '23.03289');
INSERT INTO `shop_truck_region` VALUES (2155, 2150, 'P', '普宁', '普宁市', 3, 'puning', '515300', 1, '116.16564', '23.29732');
INSERT INTO `shop_truck_region` VALUES (2156, 1964, 'Y', '云浮', '云浮市', 2, 'yunfu', '527300', 1, '112.044439', '22.929801');
INSERT INTO `shop_truck_region` VALUES (2157, 2156, 'Y', '云城', '云城区', 3, 'yuncheng', '527300', 1, '112.03908', '22.92996');
INSERT INTO `shop_truck_region` VALUES (2158, 2156, 'Y', '云安', '云安区', 3, 'yunan', '527500', 1, '112.00936', '23.07779');
INSERT INTO `shop_truck_region` VALUES (2159, 2156, 'X', '新兴', '新兴县', 3, 'xinxing', '527400', 1, '112.23019', '22.69734');
INSERT INTO `shop_truck_region` VALUES (2160, 2156, 'Y', '郁南', '郁南县', 3, 'yunan', '527100', 1, '111.53387', '23.23307');
INSERT INTO `shop_truck_region` VALUES (2161, 2156, 'L', '罗定', '罗定市', 3, 'luoding', '527200', 1, '111.56979', '22.76967');
INSERT INTO `shop_truck_region` VALUES (2162, 0, 'G', '广西', '广西壮族自治区', 1, 'guangxi', '', 1, '108.320004', '22.82402');
INSERT INTO `shop_truck_region` VALUES (2163, 2162, 'N', '南宁', '南宁市', 2, 'nanning', '530028', 1, '108.320004', '22.82402');
INSERT INTO `shop_truck_region` VALUES (2164, 2163, 'X', '兴宁', '兴宁区', 3, 'xingning', '530023', 1, '108.36694', '22.85355');
INSERT INTO `shop_truck_region` VALUES (2165, 2163, 'Q', '青秀', '青秀区', 3, 'qingxiu', '530213', 1, '108.49545', '22.78511');
INSERT INTO `shop_truck_region` VALUES (2166, 2163, 'J', '江南', '江南区', 3, 'jiangnan', '530031', 1, '108.27325', '22.78127');
INSERT INTO `shop_truck_region` VALUES (2167, 2163, 'X', '西乡塘', '西乡塘区', 3, 'xixiangtang', '530001', 1, '108.31347', '22.83386');
INSERT INTO `shop_truck_region` VALUES (2168, 2163, 'L', '良庆', '良庆区', 3, 'liangqing', '530219', 1, '108.41284', '22.74914');
INSERT INTO `shop_truck_region` VALUES (2169, 2163, NULL, '邕宁', '邕宁区', 3, 'yongning', '530200', 1, '108.48684', '22.75628');
INSERT INTO `shop_truck_region` VALUES (2170, 2163, 'W', '武鸣', '武鸣县', 3, 'wuming', '530100', 1, '108.27719', '23.15643');
INSERT INTO `shop_truck_region` VALUES (2171, 2163, 'L', '隆安', '隆安县', 3, 'longan', '532700', 1, '107.69192', '23.17336');
INSERT INTO `shop_truck_region` VALUES (2172, 2163, 'M', '马山', '马山县', 3, 'mashan', '530600', 1, '108.17697', '23.70931');
INSERT INTO `shop_truck_region` VALUES (2173, 2163, 'S', '上林', '上林县', 3, 'shanglin', '530500', 1, '108.60522', '23.432');
INSERT INTO `shop_truck_region` VALUES (2174, 2163, 'B', '宾阳', '宾阳县', 3, 'binyang', '530400', 1, '108.81185', '23.2196');
INSERT INTO `shop_truck_region` VALUES (2175, 2163, 'H', '横县', '横县', 3, 'hengxian', '530300', 1, '109.26608', '22.68448');
INSERT INTO `shop_truck_region` VALUES (2176, 2163, NULL, '埌东', '埌东新区', 3, 'langdong', '530000', 1, '108.419094', '22.812976');
INSERT INTO `shop_truck_region` VALUES (2177, 2162, 'L', '柳州', '柳州市', 2, 'liuzhou', '545001', 1, '109.411703', '24.314617');
INSERT INTO `shop_truck_region` VALUES (2178, 2177, 'C', '城中', '城中区', 3, 'chengzhong', '545001', 1, '109.41082', '24.31543');
INSERT INTO `shop_truck_region` VALUES (2179, 2177, 'Y', '鱼峰', '鱼峰区', 3, 'yufeng', '545005', 1, '109.4533', '24.31868');
INSERT INTO `shop_truck_region` VALUES (2180, 2177, 'L', '柳南', '柳南区', 3, 'liunan', '545007', 1, '109.38548', '24.33599');
INSERT INTO `shop_truck_region` VALUES (2181, 2177, 'L', '柳北', '柳北区', 3, 'liubei', '545002', 1, '109.40202', '24.36267');
INSERT INTO `shop_truck_region` VALUES (2182, 2177, 'L', '柳江', '柳江县', 3, 'liujiang', '545100', 1, '109.33273', '24.25596');
INSERT INTO `shop_truck_region` VALUES (2183, 2177, 'L', '柳城', '柳城县', 3, 'liucheng', '545200', 1, '109.23877', '24.64951');
INSERT INTO `shop_truck_region` VALUES (2184, 2177, 'L', '鹿寨', '鹿寨县', 3, 'luzhai', '545600', 1, '109.75177', '24.47306');
INSERT INTO `shop_truck_region` VALUES (2185, 2177, 'R', '融安', '融安县', 3, 'rongan', '545400', 1, '109.39761', '25.22465');
INSERT INTO `shop_truck_region` VALUES (2186, 2177, 'R', '融水', '融水苗族自治县', 3, 'rongshui', '545300', 1, '109.25634', '25.06628');
INSERT INTO `shop_truck_region` VALUES (2187, 2177, 'S', '三江', '三江侗族自治县', 3, 'sanjiang', '545500', 1, '109.60446', '25.78428');
INSERT INTO `shop_truck_region` VALUES (2188, 2177, 'L', '柳东', '柳东新区', 3, 'liudong', '545000', 1, '109.437053', '24.329204');
INSERT INTO `shop_truck_region` VALUES (2189, 2162, 'G', '桂林', '桂林市', 2, 'guilin', '541100', 1, '110.299121', '25.274215');
INSERT INTO `shop_truck_region` VALUES (2190, 2189, 'X', '秀峰', '秀峰区', 3, 'xiufeng', '541001', 1, '110.28915', '25.28249');
INSERT INTO `shop_truck_region` VALUES (2191, 2189, 'D', '叠彩', '叠彩区', 3, 'diecai', '541001', 1, '110.30195', '25.31381');
INSERT INTO `shop_truck_region` VALUES (2192, 2189, 'X', '象山', '象山区', 3, 'xiangshan', '541002', 1, '110.28108', '25.26168');
INSERT INTO `shop_truck_region` VALUES (2193, 2189, 'Q', '七星', '七星区', 3, 'qixing', '541004', 1, '110.31793', '25.2525');
INSERT INTO `shop_truck_region` VALUES (2194, 2189, 'Y', '雁山', '雁山区', 3, 'yanshan', '541006', 1, '110.30911', '25.06038');
INSERT INTO `shop_truck_region` VALUES (2195, 2189, 'L', '临桂', '临桂区', 3, 'lingui', '541100', 1, '110.205487', '25.246257');
INSERT INTO `shop_truck_region` VALUES (2196, 2189, 'Y', '阳朔', '阳朔县', 3, 'yangshuo', '541900', 1, '110.49475', '24.77579');
INSERT INTO `shop_truck_region` VALUES (2197, 2189, 'L', '灵川', '灵川县', 3, 'lingchuan', '541200', 1, '110.32949', '25.41292');
INSERT INTO `shop_truck_region` VALUES (2198, 2189, 'Q', '全州', '全州县', 3, 'quanzhou', '541503', 1, '111.07211', '25.92799');
INSERT INTO `shop_truck_region` VALUES (2199, 2189, 'X', '兴安', '兴安县', 3, 'xingan', '541300', 1, '110.67144', '25.61167');
INSERT INTO `shop_truck_region` VALUES (2200, 2189, 'Y', '永福', '永福县', 3, 'yongfu', '541800', 1, '109.98333', '24.98004');
INSERT INTO `shop_truck_region` VALUES (2201, 2189, 'G', '灌阳', '灌阳县', 3, 'guanyang', '541600', 1, '111.15954', '25.48803');
INSERT INTO `shop_truck_region` VALUES (2202, 2189, 'L', '龙胜', '龙胜各族自治县', 3, 'longsheng', '541700', 1, '110.01226', '25.79614');
INSERT INTO `shop_truck_region` VALUES (2203, 2189, 'Z', '资源', '资源县', 3, 'ziyuan', '541400', 1, '110.65255', '26.04237');
INSERT INTO `shop_truck_region` VALUES (2204, 2189, 'P', '平乐', '平乐县', 3, 'pingle', '542400', 1, '110.64175', '24.63242');
INSERT INTO `shop_truck_region` VALUES (2205, 2189, 'L', '荔浦', '荔浦县', 3, 'lipu', '546600', 1, '110.3971', '24.49589');
INSERT INTO `shop_truck_region` VALUES (2206, 2189, 'G', '恭城', '恭城瑶族自治县', 3, 'gongcheng', '542500', 1, '110.83035', '24.83286');
INSERT INTO `shop_truck_region` VALUES (2207, 2162, 'W', '梧州', '梧州市', 2, 'wuzhou', '543002', 1, '111.316229', '23.472309');
INSERT INTO `shop_truck_region` VALUES (2208, 2207, 'W', '万秀', '万秀区', 3, 'wanxiu', '543000', 1, '111.32052', '23.47298');
INSERT INTO `shop_truck_region` VALUES (2209, 2207, 'C', '长洲', '长洲区', 3, 'changzhou', '543003', 1, '111.27494', '23.48573');
INSERT INTO `shop_truck_region` VALUES (2210, 2207, 'L', '龙圩', '龙圩区', 3, 'longxu', '543002', 1, '111.316229', '23.472309');
INSERT INTO `shop_truck_region` VALUES (2211, 2207, 'C', '苍梧', '苍梧县', 3, 'cangwu', '543100', 1, '111.24533', '23.42049');
INSERT INTO `shop_truck_region` VALUES (2212, 2207, 'T', '藤县', '藤县', 3, 'tengxian', '543300', 1, '110.91418', '23.37605');
INSERT INTO `shop_truck_region` VALUES (2213, 2207, 'M', '蒙山', '蒙山县', 3, 'mengshan', '546700', 1, '110.52221', '24.20168');
INSERT INTO `shop_truck_region` VALUES (2214, 2207, NULL, '岑溪', '岑溪市', 3, 'cenxi', '543200', 1, '110.99594', '22.9191');
INSERT INTO `shop_truck_region` VALUES (2215, 2162, 'B', '北海', '北海市', 2, 'beihai', '536000', 1, '109.119254', '21.473343');
INSERT INTO `shop_truck_region` VALUES (2216, 2215, 'H', '海城', '海城区', 3, 'haicheng', '536000', 1, '109.11744', '21.47501');
INSERT INTO `shop_truck_region` VALUES (2217, 2215, 'Y', '银海', '银海区', 3, 'yinhai', '536000', 1, '109.13029', '21.4783');
INSERT INTO `shop_truck_region` VALUES (2218, 2215, 'T', '铁山港', '铁山港区', 3, 'tieshangang', '536017', 1, '109.45578', '21.59661');
INSERT INTO `shop_truck_region` VALUES (2219, 2215, 'H', '合浦', '合浦县', 3, 'hepu', '536100', 1, '109.20068', '21.66601');
INSERT INTO `shop_truck_region` VALUES (2220, 2162, 'F', '防城港', '防城港市', 2, 'fangchenggang', '538001', 1, '108.345478', '21.614631');
INSERT INTO `shop_truck_region` VALUES (2221, 2220, 'G', '港口', '港口区', 3, 'gangkou', '538001', 1, '108.38022', '21.64342');
INSERT INTO `shop_truck_region` VALUES (2222, 2220, 'F', '防城', '防城区', 3, 'fangcheng', '538021', 1, '108.35726', '21.76464');
INSERT INTO `shop_truck_region` VALUES (2223, 2220, 'S', '上思', '上思县', 3, 'shangsi', '535500', 1, '107.9823', '22.14957');
INSERT INTO `shop_truck_region` VALUES (2224, 2220, 'D', '东兴', '东兴市', 3, 'dongxing', '538100', 1, '107.97204', '21.54713');
INSERT INTO `shop_truck_region` VALUES (2225, 2162, 'Q', '钦州', '钦州市', 2, 'qinzhou', '535099', 1, '108.624175', '21.967127');
INSERT INTO `shop_truck_region` VALUES (2226, 2225, 'Q', '钦南', '钦南区', 3, 'qinnan', '535099', 1, '108.61775', '21.95137');
INSERT INTO `shop_truck_region` VALUES (2227, 2225, 'Q', '钦北', '钦北区', 3, 'qinbei', '535099', 1, '108.63037', '21.95127');
INSERT INTO `shop_truck_region` VALUES (2228, 2225, 'L', '灵山', '灵山县', 3, 'lingshan', '535099', 1, '109.29153', '22.4165');
INSERT INTO `shop_truck_region` VALUES (2229, 2225, 'P', '浦北', '浦北县', 3, 'pubei', '535099', 1, '109.55572', '22.26888');
INSERT INTO `shop_truck_region` VALUES (2230, 2162, 'G', '贵港', '贵港市', 2, 'guigang', '537100', 1, '109.602146', '23.0936');
INSERT INTO `shop_truck_region` VALUES (2231, 2230, 'G', '港北', '港北区', 3, 'gangbei', '537100', 1, '109.57224', '23.11153');
INSERT INTO `shop_truck_region` VALUES (2232, 2230, 'G', '港南', '港南区', 3, 'gangnan', '537100', 1, '109.60617', '23.07226');
INSERT INTO `shop_truck_region` VALUES (2233, 2230, NULL, '覃塘', '覃塘区', 3, 'qintang', '537121', 1, '109.44293', '23.12677');
INSERT INTO `shop_truck_region` VALUES (2234, 2230, 'P', '平南', '平南县', 3, 'pingnan', '537300', 1, '110.39062', '23.54201');
INSERT INTO `shop_truck_region` VALUES (2235, 2230, 'G', '桂平', '桂平市', 3, 'guiping', '537200', 1, '110.08105', '23.39339');
INSERT INTO `shop_truck_region` VALUES (2236, 2162, 'Y', '玉林', '玉林市', 2, 'yulin', '537000', 1, '110.154393', '22.63136');
INSERT INTO `shop_truck_region` VALUES (2237, 2236, 'Y', '玉州', '玉州区', 3, 'yuzhou', '537000', 1, '110.15114', '22.6281');
INSERT INTO `shop_truck_region` VALUES (2238, 2236, 'F', '福绵', '福绵区', 3, 'fumian', '537023', 1, '110.064816', '22.583057');
INSERT INTO `shop_truck_region` VALUES (2239, 2236, 'Y', '玉东', '玉东新区', 3, 'yudong', '537000', 1, '110.154393', '22.63136');
INSERT INTO `shop_truck_region` VALUES (2240, 2236, 'R', '容县', '容县', 3, 'rongxian', '537500', 1, '110.55593', '22.85701');
INSERT INTO `shop_truck_region` VALUES (2241, 2236, 'L', '陆川', '陆川县', 3, 'luchuan', '537700', 1, '110.26413', '22.32454');
INSERT INTO `shop_truck_region` VALUES (2242, 2236, 'B', '博白', '博白县', 3, 'bobai', '537600', 1, '109.97744', '22.27286');
INSERT INTO `shop_truck_region` VALUES (2243, 2236, 'X', '兴业', '兴业县', 3, 'xingye', '537800', 1, '109.87612', '22.74237');
INSERT INTO `shop_truck_region` VALUES (2244, 2236, 'B', '北流', '北流市', 3, 'beiliu', '537400', 1, '110.35302', '22.70817');
INSERT INTO `shop_truck_region` VALUES (2245, 2162, 'B', '百色', '百色市', 2, 'baise', '533000', 1, '106.616285', '23.897742');
INSERT INTO `shop_truck_region` VALUES (2246, 2245, 'Y', '右江', '右江区', 3, 'youjiang', '533000', 1, '106.61764', '23.9009');
INSERT INTO `shop_truck_region` VALUES (2247, 2245, 'T', '田阳', '田阳县', 3, 'tianyang', '533600', 1, '106.91558', '23.73535');
INSERT INTO `shop_truck_region` VALUES (2248, 2245, 'T', '田东', '田东县', 3, 'tiandong', '531500', 1, '107.12432', '23.60003');
INSERT INTO `shop_truck_region` VALUES (2249, 2245, 'P', '平果', '平果县', 3, 'pingguo', '531400', 1, '107.59045', '23.32969');
INSERT INTO `shop_truck_region` VALUES (2250, 2245, 'D', '德保', '德保县', 3, 'debao', '533700', 1, '106.61917', '23.32515');
INSERT INTO `shop_truck_region` VALUES (2251, 2245, 'J', '靖西', '靖西县', 3, 'jingxi', '533800', 1, '106.41766', '23.13425');
INSERT INTO `shop_truck_region` VALUES (2252, 2245, 'N', '那坡', '那坡县', 3, 'napo', '533900', 1, '105.84191', '23.40649');
INSERT INTO `shop_truck_region` VALUES (2253, 2245, 'L', '凌云', '凌云县', 3, 'lingyun', '533100', 1, '106.56155', '24.34747');
INSERT INTO `shop_truck_region` VALUES (2254, 2245, 'L', '乐业', '乐业县', 3, 'leye', '533200', 1, '106.56124', '24.78295');
INSERT INTO `shop_truck_region` VALUES (2255, 2245, 'T', '田林', '田林县', 3, 'tianlin', '533300', 1, '106.22882', '24.29207');
INSERT INTO `shop_truck_region` VALUES (2256, 2245, 'X', '西林', '西林县', 3, 'xilin', '533500', 1, '105.09722', '24.48966');
INSERT INTO `shop_truck_region` VALUES (2257, 2245, 'L', '隆林', '隆林各族自治县', 3, 'longlin', '533400', 1, '105.34295', '24.77036');
INSERT INTO `shop_truck_region` VALUES (2258, 2162, 'H', '贺州', '贺州市', 2, 'hezhou', '542800', 1, '111.552056', '24.414141');
INSERT INTO `shop_truck_region` VALUES (2259, 2258, 'B', '八步', '八步区', 3, 'babu', '542800', 1, '111.55225', '24.41179');
INSERT INTO `shop_truck_region` VALUES (2260, 2258, 'Z', '昭平', '昭平县', 3, 'zhaoping', '546800', 1, '110.81082', '24.1701');
INSERT INTO `shop_truck_region` VALUES (2261, 2258, 'Z', '钟山', '钟山县', 3, 'zhongshan', '542600', 1, '111.30459', '24.52482');
INSERT INTO `shop_truck_region` VALUES (2262, 2258, 'F', '富川', '富川瑶族自治县', 3, 'fuchuan', '542700', 1, '111.27767', '24.81431');
INSERT INTO `shop_truck_region` VALUES (2263, 2258, 'P', '平桂', '平桂管理区', 3, 'pingui', '542800', 1, '111.485651', '24.458041');
INSERT INTO `shop_truck_region` VALUES (2264, 2162, 'H', '河池', '河池市', 2, 'hechi', '547000', 1, '108.062105', '24.695899');
INSERT INTO `shop_truck_region` VALUES (2265, 2264, 'J', '金城江', '金城江区', 3, 'jinchengjiang', '547000', 1, '108.03727', '24.6897');
INSERT INTO `shop_truck_region` VALUES (2266, 2264, 'N', '南丹', '南丹县', 3, 'nandan', '547200', 1, '107.54562', '24.9776');
INSERT INTO `shop_truck_region` VALUES (2267, 2264, 'T', '天峨', '天峨县', 3, 'tiane', '547300', 1, '107.17205', '24.99593');
INSERT INTO `shop_truck_region` VALUES (2268, 2264, 'F', '凤山', '凤山县', 3, 'fengshan', '547600', 1, '107.04892', '24.54215');
INSERT INTO `shop_truck_region` VALUES (2269, 2264, 'D', '东兰', '东兰县', 3, 'donglan', '547400', 1, '107.37527', '24.51053');
INSERT INTO `shop_truck_region` VALUES (2270, 2264, 'L', '罗城', '罗城仫佬族自治县', 3, 'luocheng', '546400', 1, '108.90777', '24.77923');
INSERT INTO `shop_truck_region` VALUES (2271, 2264, 'H', '环江', '环江毛南族自治县', 3, 'huanjiang', '547100', 1, '108.26055', '24.82916');
INSERT INTO `shop_truck_region` VALUES (2272, 2264, 'B', '巴马', '巴马瑶族自治县', 3, 'bama', '547500', 1, '107.25308', '24.14135');
INSERT INTO `shop_truck_region` VALUES (2273, 2264, 'D', '都安', '都安瑶族自治县', 3, 'duan', '530700', 1, '108.10116', '23.93245');
INSERT INTO `shop_truck_region` VALUES (2274, 2264, 'D', '大化', '大化瑶族自治县', 3, 'dahua', '530800', 1, '107.9985', '23.74487');
INSERT INTO `shop_truck_region` VALUES (2275, 2264, 'Y', '宜州', '宜州市', 3, 'yizhou', '546300', 1, '108.65304', '24.49391');
INSERT INTO `shop_truck_region` VALUES (2276, 2162, 'L', '来宾', '来宾市', 2, 'laibin', '546100', 1, '109.229772', '23.733766');
INSERT INTO `shop_truck_region` VALUES (2277, 2276, 'X', '兴宾', '兴宾区', 3, 'xingbin', '546100', 1, '109.23471', '23.72731');
INSERT INTO `shop_truck_region` VALUES (2278, 2276, 'X', '忻城', '忻城县', 3, 'xincheng', '546200', 1, '108.66357', '24.06862');
INSERT INTO `shop_truck_region` VALUES (2279, 2276, 'X', '象州', '象州县', 3, 'xiangzhou', '545800', 1, '109.6994', '23.97355');
INSERT INTO `shop_truck_region` VALUES (2280, 2276, 'W', '武宣', '武宣县', 3, 'wuxuan', '545900', 1, '109.66284', '23.59474');
INSERT INTO `shop_truck_region` VALUES (2281, 2276, 'J', '金秀', '金秀瑶族自治县', 3, 'jinxiu', '545799', 1, '110.19079', '24.12929');
INSERT INTO `shop_truck_region` VALUES (2282, 2276, 'H', '合山', '合山市', 3, 'heshan', '546500', 1, '108.88586', '23.80619');
INSERT INTO `shop_truck_region` VALUES (2283, 2162, 'C', '崇左', '崇左市', 2, 'chongzuo', '532299', 1, '107.353926', '22.404108');
INSERT INTO `shop_truck_region` VALUES (2284, 2283, 'J', '江州', '江州区', 3, 'jiangzhou', '532299', 1, '107.34747', '22.41135');
INSERT INTO `shop_truck_region` VALUES (2285, 2283, 'F', '扶绥', '扶绥县', 3, 'fusui', '532199', 1, '107.90405', '22.63413');
INSERT INTO `shop_truck_region` VALUES (2286, 2283, 'N', '宁明', '宁明县', 3, 'ningming', '532599', 1, '107.07299', '22.13655');
INSERT INTO `shop_truck_region` VALUES (2287, 2283, 'L', '龙州', '龙州县', 3, 'longzhou', '532499', 1, '106.85415', '22.33937');
INSERT INTO `shop_truck_region` VALUES (2288, 2283, 'D', '大新', '大新县', 3, 'daxin', '532399', 1, '107.19821', '22.83412');
INSERT INTO `shop_truck_region` VALUES (2289, 2283, 'T', '天等', '天等县', 3, 'tiandeng', '532899', 1, '107.13998', '23.077');
INSERT INTO `shop_truck_region` VALUES (2290, 2283, 'P', '凭祥', '凭祥市', 3, 'pingxiang', '532699', 1, '106.75534', '22.10573');
INSERT INTO `shop_truck_region` VALUES (2291, 0, 'H', '海南', '海南省', 1, 'hainan', '', 1, '110.33119', '20.031971');
INSERT INTO `shop_truck_region` VALUES (2292, 2291, 'H', '海口', '海口市', 2, 'haikou', '570000', 1, '110.33119', '20.031971');
INSERT INTO `shop_truck_region` VALUES (2293, 2292, 'X', '秀英', '秀英区', 3, 'xiuying', '570311', 1, '110.29345', '20.00752');
INSERT INTO `shop_truck_region` VALUES (2294, 2292, 'L', '龙华', '龙华区', 3, 'longhua', '570145', 1, '110.30194', '20.02866');
INSERT INTO `shop_truck_region` VALUES (2295, 2292, 'Q', '琼山', '琼山区', 3, 'qiongshan', '571100', 1, '110.35418', '20.00321');
INSERT INTO `shop_truck_region` VALUES (2296, 2292, 'M', '美兰', '美兰区', 3, 'meilan', '570203', 1, '110.36908', '20.02864');
INSERT INTO `shop_truck_region` VALUES (2297, 2291, 'S', '三亚', '三亚市', 2, 'sanya', '572000', 1, '109.508268', '18.247872');
INSERT INTO `shop_truck_region` VALUES (2298, 2297, 'H', '海棠', '海棠区', 3, 'haitang', '572000', 1, '109.508268', '18.247872');
INSERT INTO `shop_truck_region` VALUES (2299, 2297, 'J', '吉阳', '吉阳区', 3, 'jiyang', '572000', 1, '109.508268', '18.247872');
INSERT INTO `shop_truck_region` VALUES (2300, 2297, 'T', '天涯', '天涯区', 3, 'tianya', '572000', 1, '109.508268', '18.247872');
INSERT INTO `shop_truck_region` VALUES (2301, 2297, 'Y', '崖州', '崖州区', 3, 'yazhou', '572000', 1, '109.508268', '18.247872');
INSERT INTO `shop_truck_region` VALUES (2302, 2291, 'S', '三沙', '三沙市', 2, 'sansha', '573199', 1, '112.34882', '16.831039');
INSERT INTO `shop_truck_region` VALUES (2303, 2302, 'X', '西沙', '西沙群岛', 3, 'xishaislands', '572000', 1, '112.025528', '16.331342');
INSERT INTO `shop_truck_region` VALUES (2304, 2302, 'N', '南沙', '南沙群岛', 3, 'nanshaislands', '573100', 1, '116.749998', '11.471888');
INSERT INTO `shop_truck_region` VALUES (2305, 2302, 'Z', '中沙', '中沙群岛', 3, 'zhongshaislands', '573100', 1, '117.740071', '15.112856');
INSERT INTO `shop_truck_region` VALUES (2306, 2291, 'Z', ' ', '直辖县级', 2, '', '', 1, '109.503479', '18.739906');
INSERT INTO `shop_truck_region` VALUES (2307, 2306, 'W', '五指山', '五指山市', 3, 'wuzhishan', '572200', 1, '109.516662', '18.776921');
INSERT INTO `shop_truck_region` VALUES (2308, 2306, 'Q', '琼海', '琼海市', 3, 'qionghai', '571400', 1, '110.466785', '19.246011');
INSERT INTO `shop_truck_region` VALUES (2309, 2306, NULL, '儋州', '儋州市', 3, 'danzhou', '571700', 1, '109.576782', '19.517486');
INSERT INTO `shop_truck_region` VALUES (2310, 2306, 'W', '文昌', '文昌市', 3, 'wenchang', '571339', 1, '110.753975', '19.612986');
INSERT INTO `shop_truck_region` VALUES (2311, 2306, 'W', '万宁', '万宁市', 3, 'wanning', '571500', 1, '110.388793', '18.796216');
INSERT INTO `shop_truck_region` VALUES (2312, 2306, 'D', '东方', '东方市', 3, 'dongfang', '572600', 1, '108.653789', '19.10198');
INSERT INTO `shop_truck_region` VALUES (2313, 2306, 'D', '定安', '定安县', 3, 'dingan', '571200', 1, '110.323959', '19.699211');
INSERT INTO `shop_truck_region` VALUES (2314, 2306, 'T', '屯昌', '屯昌县', 3, 'tunchang', '571600', 1, '110.102773', '19.362916');
INSERT INTO `shop_truck_region` VALUES (2315, 2306, 'C', '澄迈', '澄迈县', 3, 'chengmai', '571900', 1, '110.007147', '19.737095');
INSERT INTO `shop_truck_region` VALUES (2316, 2306, 'L', '临高', '临高县', 3, 'lingao', '571800', 1, '109.687697', '19.908293');
INSERT INTO `shop_truck_region` VALUES (2317, 2306, 'B', '白沙', '白沙黎族自治县', 3, 'baisha', '572800', 1, '109.452606', '19.224584');
INSERT INTO `shop_truck_region` VALUES (2318, 2306, 'C', '昌江', '昌江黎族自治县', 3, 'changjiang', '572700', 1, '109.053351', '19.260968');
INSERT INTO `shop_truck_region` VALUES (2319, 2306, 'L', '乐东', '乐东黎族自治县', 3, 'ledong', '572500', 1, '109.175444', '18.74758');
INSERT INTO `shop_truck_region` VALUES (2320, 2306, 'L', '陵水', '陵水黎族自治县', 3, 'lingshui', '572400', 1, '110.037218', '18.505006');
INSERT INTO `shop_truck_region` VALUES (2321, 2306, 'B', '保亭', '保亭黎族苗族自治县', 3, 'baoting', '572300', 1, '109.70245', '18.636371');
INSERT INTO `shop_truck_region` VALUES (2322, 2306, 'Q', '琼中', '琼中黎族苗族自治县', 3, 'qiongzhong', '572900', 1, '109.839996', '19.03557');
INSERT INTO `shop_truck_region` VALUES (2323, 0, 'Z', '重庆', '重庆市', 1, 'chongqing', '', 1, '106.504962', '29.533155');
INSERT INTO `shop_truck_region` VALUES (2324, 2323, 'Z', '重庆', '重庆市', 2, 'chongqing', '400000', 1, '106.504962', '29.533155');
INSERT INTO `shop_truck_region` VALUES (2325, 2324, 'W', '万州', '万州区', 3, 'wanzhou', '404000', 1, '108.40869', '30.80788');
INSERT INTO `shop_truck_region` VALUES (2326, 2324, 'F', '涪陵', '涪陵区', 3, 'fuling', '408000', 1, '107.39007', '29.70292');
INSERT INTO `shop_truck_region` VALUES (2327, 2324, 'Y', '渝中', '渝中区', 3, 'yuzhong', '400010', 1, '106.56901', '29.55279');
INSERT INTO `shop_truck_region` VALUES (2328, 2324, 'D', '大渡口', '大渡口区', 3, 'dadukou', '400080', 1, '106.48262', '29.48447');
INSERT INTO `shop_truck_region` VALUES (2329, 2324, 'J', '江北', '江北区', 3, 'jiangbei', '400020', 1, '106.57434', '29.60658');
INSERT INTO `shop_truck_region` VALUES (2330, 2324, 'S', '沙坪坝', '沙坪坝区', 3, 'shapingba', '400030', 1, '106.45752', '29.54113');
INSERT INTO `shop_truck_region` VALUES (2331, 2324, 'J', '九龙坡', '九龙坡区', 3, 'jiulongpo', '400050', 1, '106.51107', '29.50197');
INSERT INTO `shop_truck_region` VALUES (2332, 2324, 'N', '南岸', '南岸区', 3, 'nanan', '400064', 1, '106.56347', '29.52311');
INSERT INTO `shop_truck_region` VALUES (2333, 2324, 'B', '北碚', '北碚区', 3, 'beibei', '400700', 1, '106.39614', '29.80574');
INSERT INTO `shop_truck_region` VALUES (2334, 2324, NULL, '綦江', '綦江区', 3, 'qijiang', '400800', 1, '106.926779', '28.960656');
INSERT INTO `shop_truck_region` VALUES (2335, 2324, 'D', '大足', '大足区', 3, 'dazu', '400900', 1, '105.768121', '29.484025');
INSERT INTO `shop_truck_region` VALUES (2336, 2324, 'Y', '渝北', '渝北区', 3, 'yubei', '401120', 1, '106.6307', '29.7182');
INSERT INTO `shop_truck_region` VALUES (2337, 2324, 'B', '巴南', '巴南区', 3, 'banan', '401320', 1, '106.52365', '29.38311');
INSERT INTO `shop_truck_region` VALUES (2338, 2324, 'Q', '黔江', '黔江区', 3, 'qianjiang', '409700', 1, '108.7709', '29.5332');
INSERT INTO `shop_truck_region` VALUES (2339, 2324, 'C', '长寿', '长寿区', 3, 'changshou', '401220', 1, '107.08166', '29.85359');
INSERT INTO `shop_truck_region` VALUES (2340, 2324, 'J', '江津', '江津区', 3, 'jiangjin', '402260', 1, '106.25912', '29.29008');
INSERT INTO `shop_truck_region` VALUES (2341, 2324, 'H', '合川', '合川区', 3, 'hechuan', '401520', 1, '106.27633', '29.97227');
INSERT INTO `shop_truck_region` VALUES (2342, 2324, 'Y', '永川', '永川区', 3, 'yongchuan', '402160', 1, '105.927', '29.35593');
INSERT INTO `shop_truck_region` VALUES (2343, 2324, 'N', '南川', '南川区', 3, 'nanchuan', '408400', 1, '107.09936', '29.15751');
INSERT INTO `shop_truck_region` VALUES (2344, 2324, NULL, '璧山', '璧山区', 3, 'bishan', '402760', 1, '106.231126', '29.593581');
INSERT INTO `shop_truck_region` VALUES (2345, 2324, 'T', '铜梁', '铜梁区', 3, 'tongliang', '402560', 1, '106.054948', '29.839944');
INSERT INTO `shop_truck_region` VALUES (2346, 2324, NULL, '潼南', '潼南区', 3, 'tongnan', '402660', 1, '105.84005', '30.1912');
INSERT INTO `shop_truck_region` VALUES (2347, 2324, 'R', '荣昌', '荣昌区', 3, 'rongchang', '402460', 1, '105.59442', '29.40488');
INSERT INTO `shop_truck_region` VALUES (2348, 2324, 'L', '梁平', '梁平区', 3, 'liangping', '405200', 1, '107.79998', '30.67545');
INSERT INTO `shop_truck_region` VALUES (2349, 2363, 'C', '城口', '城口县', 3, 'chengkou', '405900', 1, '108.66513', '31.94801');
INSERT INTO `shop_truck_region` VALUES (2350, 2363, 'F', '丰都', '丰都县', 3, 'fengdu', '408200', 1, '107.73098', '29.86348');
INSERT INTO `shop_truck_region` VALUES (2351, 2363, 'D', '垫江', '垫江县', 3, 'dianjiang', '408300', 1, '107.35446', '30.33359');
INSERT INTO `shop_truck_region` VALUES (2352, 2363, 'W', '武隆', '武隆县', 3, 'wulong', '408500', 1, '107.7601', '29.32548');
INSERT INTO `shop_truck_region` VALUES (2353, 2363, 'Z', '忠县', '忠县', 3, 'zhongxian', '404300', 1, '108.03689', '30.28898');
INSERT INTO `shop_truck_region` VALUES (2354, 2363, 'K', '开县', '开县', 3, 'kaixian', '405400', 1, '108.39306', '31.16095');
INSERT INTO `shop_truck_region` VALUES (2355, 2363, 'Y', '云阳', '云阳县', 3, 'yunyang', '404500', 1, '108.69726', '30.93062');
INSERT INTO `shop_truck_region` VALUES (2356, 2363, 'F', '奉节', '奉节县', 3, 'fengjie', '404600', 1, '109.46478', '31.01825');
INSERT INTO `shop_truck_region` VALUES (2357, 2363, 'W', '巫山', '巫山县', 3, 'wushan', '404700', 1, '109.87814', '31.07458');
INSERT INTO `shop_truck_region` VALUES (2358, 2363, 'W', '巫溪', '巫溪县', 3, 'wuxi', '405800', 1, '109.63128', '31.39756');
INSERT INTO `shop_truck_region` VALUES (2359, 2363, 'S', '石柱', '石柱土家族自治县', 3, 'shizhu', '409100', 1, '108.11389', '30.00054');
INSERT INTO `shop_truck_region` VALUES (2360, 2363, 'X', '秀山', '秀山土家族苗族自治县', 3, 'xiushan', '409900', 1, '108.98861', '28.45062');
INSERT INTO `shop_truck_region` VALUES (2361, 2363, 'Y', '酉阳', '酉阳土家族苗族自治县', 3, 'youyang', '409800', 1, '108.77212', '28.8446');
INSERT INTO `shop_truck_region` VALUES (2362, 2363, 'P', '彭水', '彭水苗族土家族自治县', 3, 'pengshui', '409600', 1, '108.16638', '29.29516');
INSERT INTO `shop_truck_region` VALUES (2363, 2323, 'L', '县', '县', 2, 'xian', '400000', 1, '106.463344', '29.729153');
INSERT INTO `shop_truck_region` VALUES (2367, 0, 'S', '四川', '四川省', 1, 'sichuan', '', 1, '104.065735', '30.659462');
INSERT INTO `shop_truck_region` VALUES (2368, 2367, 'C', '成都', '成都市', 2, 'chengdu', '610015', 1, '104.065735', '30.659462');
INSERT INTO `shop_truck_region` VALUES (2369, 2368, 'J', '锦江', '锦江区', 3, 'jinjiang', '610021', 1, '104.08347', '30.65614');
INSERT INTO `shop_truck_region` VALUES (2370, 2368, 'Q', '青羊', '青羊区', 3, 'qingyang', '610031', 1, '104.06151', '30.67387');
INSERT INTO `shop_truck_region` VALUES (2371, 2368, 'J', '金牛', '金牛区', 3, 'jinniu', '610036', 1, '104.05114', '30.69126');
INSERT INTO `shop_truck_region` VALUES (2372, 2368, 'W', '武侯', '武侯区', 3, 'wuhou', '610041', 1, '104.04303', '30.64235');
INSERT INTO `shop_truck_region` VALUES (2373, 2368, 'C', '成华', '成华区', 3, 'chenghua', '610066', 1, '104.10193', '30.65993');
INSERT INTO `shop_truck_region` VALUES (2374, 2368, 'L', '龙泉驿', '龙泉驿区', 3, 'longquanyi', '610100', 1, '104.27462', '30.55658');
INSERT INTO `shop_truck_region` VALUES (2375, 2368, 'Q', '青白江', '青白江区', 3, 'qingbaijiang', '610300', 1, '104.251', '30.87841');
INSERT INTO `shop_truck_region` VALUES (2376, 2368, 'X', '新都', '新都区', 3, 'xindu', '610500', 1, '104.15921', '30.82314');
INSERT INTO `shop_truck_region` VALUES (2377, 2368, 'W', '温江', '温江区', 3, 'wenjiang', '611130', 1, '103.84881', '30.68444');
INSERT INTO `shop_truck_region` VALUES (2378, 2368, 'J', '金堂', '金堂县', 3, 'jintang', '610400', 1, '104.41195', '30.86195');
INSERT INTO `shop_truck_region` VALUES (2379, 2368, 'S', '双流', '双流县', 3, 'shuangliu', '610200', 1, '103.92373', '30.57444');
INSERT INTO `shop_truck_region` VALUES (2380, 2368, NULL, '郫县', '郫县', 3, 'pixian', '611730', 1, '103.88717', '30.81054');
INSERT INTO `shop_truck_region` VALUES (2381, 2368, 'D', '大邑', '大邑县', 3, 'dayi', '611330', 1, '103.52075', '30.58738');
INSERT INTO `shop_truck_region` VALUES (2382, 2368, 'P', '蒲江', '蒲江县', 3, 'pujiang', '611630', 1, '103.50616', '30.19667');
INSERT INTO `shop_truck_region` VALUES (2383, 2368, 'X', '新津', '新津县', 3, 'xinjin', '611430', 1, '103.8114', '30.40983');
INSERT INTO `shop_truck_region` VALUES (2384, 2368, 'D', '都江堰', '都江堰市', 3, 'dujiangyan', '611830', 1, '103.61941', '30.99825');
INSERT INTO `shop_truck_region` VALUES (2385, 2368, 'P', '彭州', '彭州市', 3, 'pengzhou', '611930', 1, '103.958', '30.99011');
INSERT INTO `shop_truck_region` VALUES (2386, 2368, NULL, '邛崃', '邛崃市', 3, 'qionglai', '611530', 1, '103.46283', '30.41489');
INSERT INTO `shop_truck_region` VALUES (2387, 2368, 'C', '崇州', '崇州市', 3, 'chongzhou', '611230', 1, '103.67285', '30.63014');
INSERT INTO `shop_truck_region` VALUES (2388, 2367, 'Z', '自贡', '自贡市', 2, 'zigong', '643000', 1, '104.773447', '29.352765');
INSERT INTO `shop_truck_region` VALUES (2389, 2388, 'Z', '自流井', '自流井区', 3, 'ziliujing', '643000', 1, '104.77719', '29.33745');
INSERT INTO `shop_truck_region` VALUES (2390, 2388, 'G', '贡井', '贡井区', 3, 'gongjing', '643020', 1, '104.71536', '29.34576');
INSERT INTO `shop_truck_region` VALUES (2391, 2388, 'D', '大安', '大安区', 3, 'daan', '643010', 1, '104.77383', '29.36364');
INSERT INTO `shop_truck_region` VALUES (2392, 2388, 'Y', '沿滩', '沿滩区', 3, 'yantan', '643030', 1, '104.88012', '29.26611');
INSERT INTO `shop_truck_region` VALUES (2393, 2388, 'R', '荣县', '荣县', 3, 'rongxian', '643100', 1, '104.4176', '29.44445');
INSERT INTO `shop_truck_region` VALUES (2394, 2388, 'F', '富顺', '富顺县', 3, 'fushun', '643200', 1, '104.97491', '29.18123');
INSERT INTO `shop_truck_region` VALUES (2395, 2367, 'P', '攀枝花', '攀枝花市', 2, 'panzhihua', '617000', 1, '101.716007', '26.580446');
INSERT INTO `shop_truck_region` VALUES (2396, 2395, 'D', '东区', '东区', 3, 'dongqu', '617067', 1, '101.7052', '26.54677');
INSERT INTO `shop_truck_region` VALUES (2397, 2395, 'X', '西区', '西区', 3, 'xiqu', '617068', 1, '101.63058', '26.59753');
INSERT INTO `shop_truck_region` VALUES (2398, 2395, 'R', '仁和', '仁和区', 3, 'renhe', '617061', 1, '101.73812', '26.49841');
INSERT INTO `shop_truck_region` VALUES (2399, 2395, 'M', '米易', '米易县', 3, 'miyi', '617200', 1, '102.11132', '26.88718');
INSERT INTO `shop_truck_region` VALUES (2400, 2395, 'Y', '盐边', '盐边县', 3, 'yanbian', '617100', 1, '101.85446', '26.68847');
INSERT INTO `shop_truck_region` VALUES (2401, 2367, NULL, '泸州', '泸州市', 2, 'luzhou', '646000', 1, '105.443348', '28.889138');
INSERT INTO `shop_truck_region` VALUES (2402, 2401, 'J', '江阳', '江阳区', 3, 'jiangyang', '646000', 1, '105.45336', '28.88934');
INSERT INTO `shop_truck_region` VALUES (2403, 2401, 'N', '纳溪', '纳溪区', 3, 'naxi', '646300', 1, '105.37255', '28.77343');
INSERT INTO `shop_truck_region` VALUES (2404, 2401, 'L', '龙马潭', '龙马潭区', 3, 'longmatan', '646000', 1, '105.43774', '28.91308');
INSERT INTO `shop_truck_region` VALUES (2405, 2401, NULL, '泸县', '泸县', 3, 'luxian', '646106', 1, '105.38192', '29.15041');
INSERT INTO `shop_truck_region` VALUES (2406, 2401, 'H', '合江', '合江县', 3, 'hejiang', '646200', 1, '105.8352', '28.81005');
INSERT INTO `shop_truck_region` VALUES (2407, 2401, 'X', '叙永', '叙永县', 3, 'xuyong', '646400', 1, '105.44473', '28.15586');
INSERT INTO `shop_truck_region` VALUES (2408, 2401, 'G', '古蔺', '古蔺县', 3, 'gulin', '646500', 1, '105.81347', '28.03867');
INSERT INTO `shop_truck_region` VALUES (2409, 2367, 'D', '德阳', '德阳市', 2, 'deyang', '618000', 1, '104.398651', '31.127991');
INSERT INTO `shop_truck_region` VALUES (2410, 2409, NULL, '旌阳', '旌阳区', 3, 'jingyang', '618000', 1, '104.39367', '31.13906');
INSERT INTO `shop_truck_region` VALUES (2411, 2409, 'Z', '中江', '中江县', 3, 'zhongjiang', '618100', 1, '104.67861', '31.03297');
INSERT INTO `shop_truck_region` VALUES (2412, 2409, 'L', '罗江', '罗江县', 3, 'luojiang', '618500', 1, '104.51025', '31.31665');
INSERT INTO `shop_truck_region` VALUES (2413, 2409, 'G', '广汉', '广汉市', 3, 'guanghan', '618300', 1, '104.28234', '30.97686');
INSERT INTO `shop_truck_region` VALUES (2414, 2409, 'S', '什邡', '什邡市', 3, 'shifang', '618400', 1, '104.16754', '31.1264');
INSERT INTO `shop_truck_region` VALUES (2415, 2409, 'M', '绵竹', '绵竹市', 3, 'mianzhu', '618200', 1, '104.22076', '31.33772');
INSERT INTO `shop_truck_region` VALUES (2416, 2367, 'M', '绵阳', '绵阳市', 2, 'mianyang', '621000', 1, '104.741722', '31.46402');
INSERT INTO `shop_truck_region` VALUES (2417, 2416, 'F', '涪城', '涪城区', 3, 'fucheng', '621000', 1, '104.75719', '31.45522');
INSERT INTO `shop_truck_region` VALUES (2418, 2416, 'Y', '游仙', '游仙区', 3, 'youxian', '621022', 1, '104.77092', '31.46574');
INSERT INTO `shop_truck_region` VALUES (2419, 2416, 'S', '三台', '三台县', 3, 'santai', '621100', 1, '105.09079', '31.09179');
INSERT INTO `shop_truck_region` VALUES (2420, 2416, 'Y', '盐亭', '盐亭县', 3, 'yanting', '621600', 1, '105.3898', '31.22176');
INSERT INTO `shop_truck_region` VALUES (2421, 2416, 'A', '安县', '安县', 3, 'anxian', '622650', 1, '104.56738', '31.53487');
INSERT INTO `shop_truck_region` VALUES (2422, 2416, NULL, '梓潼', '梓潼县', 3, 'zitong', '622150', 1, '105.16183', '31.6359');
INSERT INTO `shop_truck_region` VALUES (2423, 2416, 'B', '北川', '北川羌族自治县', 3, 'beichuan', '622750', 1, '104.46408', '31.83286');
INSERT INTO `shop_truck_region` VALUES (2424, 2416, 'P', '平武', '平武县', 3, 'pingwu', '622550', 1, '104.52862', '32.40791');
INSERT INTO `shop_truck_region` VALUES (2425, 2416, 'J', '江油', '江油市', 3, 'jiangyou', '621700', 1, '104.74539', '31.77775');
INSERT INTO `shop_truck_region` VALUES (2426, 2367, 'G', '广元', '广元市', 2, 'guangyuan', '628000', 1, '105.829757', '32.433668');
INSERT INTO `shop_truck_region` VALUES (2427, 2426, 'L', '利州', '利州区', 3, 'lizhou', '628017', 1, '105.826194', '32.432276');
INSERT INTO `shop_truck_region` VALUES (2428, 2426, 'Z', '昭化', '昭化区', 3, 'zhaohua', '628017', 1, '105.640491', '32.386518');
INSERT INTO `shop_truck_region` VALUES (2429, 2426, 'C', '朝天', '朝天区', 3, 'chaotian', '628017', 1, '105.89273', '32.64398');
INSERT INTO `shop_truck_region` VALUES (2430, 2426, 'W', '旺苍', '旺苍县', 3, 'wangcang', '628200', 1, '106.29022', '32.22845');
INSERT INTO `shop_truck_region` VALUES (2431, 2426, 'Q', '青川', '青川县', 3, 'qingchuan', '628100', 1, '105.2391', '32.58563');
INSERT INTO `shop_truck_region` VALUES (2432, 2426, 'J', '剑阁', '剑阁县', 3, 'jiange', '628300', 1, '105.5252', '32.28845');
INSERT INTO `shop_truck_region` VALUES (2433, 2426, 'C', '苍溪', '苍溪县', 3, 'cangxi', '628400', 1, '105.936', '31.73209');
INSERT INTO `shop_truck_region` VALUES (2434, 2367, 'S', '遂宁', '遂宁市', 2, 'suining', '629000', 1, '105.571331', '30.513311');
INSERT INTO `shop_truck_region` VALUES (2435, 2434, 'C', '船山', '船山区', 3, 'chuanshan', '629000', 1, '105.5809', '30.49991');
INSERT INTO `shop_truck_region` VALUES (2436, 2434, 'A', '安居', '安居区', 3, 'anju', '629000', 1, '105.46402', '30.35778');
INSERT INTO `shop_truck_region` VALUES (2437, 2434, 'P', '蓬溪', '蓬溪县', 3, 'pengxi', '629100', 1, '105.70752', '30.75775');
INSERT INTO `shop_truck_region` VALUES (2438, 2434, 'S', '射洪', '射洪县', 3, 'shehong', '629200', 1, '105.38922', '30.87203');
INSERT INTO `shop_truck_region` VALUES (2439, 2434, 'D', '大英', '大英县', 3, 'daying', '629300', 1, '105.24346', '30.59434');
INSERT INTO `shop_truck_region` VALUES (2440, 2367, 'N', '内江', '内江市', 2, 'neijiang', '641000', 1, '105.066138', '29.58708');
INSERT INTO `shop_truck_region` VALUES (2441, 2440, 'S', '市中区', '市中区', 3, 'shizhongqu', '641000', 1, '105.0679', '29.58709');
INSERT INTO `shop_truck_region` VALUES (2442, 2440, 'D', '东兴', '东兴区', 3, 'dongxing', '641100', 1, '105.07554', '29.59278');
INSERT INTO `shop_truck_region` VALUES (2443, 2440, 'W', '威远', '威远县', 3, 'weiyuan', '642450', 1, '104.66955', '29.52823');
INSERT INTO `shop_truck_region` VALUES (2444, 2440, 'Z', '资中', '资中县', 3, 'zizhong', '641200', 1, '104.85205', '29.76409');
INSERT INTO `shop_truck_region` VALUES (2445, 2440, 'L', '隆昌', '隆昌县', 3, 'longchang', '642150', 1, '105.28738', '29.33937');
INSERT INTO `shop_truck_region` VALUES (2446, 2367, 'L', '乐山', '乐山市', 2, 'leshan', '614000', 1, '103.761263', '29.582024');
INSERT INTO `shop_truck_region` VALUES (2447, 2446, 'S', '市中区', '市中区', 3, 'shizhongqu', '614000', 1, '103.76159', '29.55543');
INSERT INTO `shop_truck_region` VALUES (2448, 2446, 'S', '沙湾', '沙湾区', 3, 'shawan', '614900', 1, '103.54873', '29.41194');
INSERT INTO `shop_truck_region` VALUES (2449, 2446, 'W', '五通桥', '五通桥区', 3, 'wutongqiao', '614800', 1, '103.82345', '29.40344');
INSERT INTO `shop_truck_region` VALUES (2450, 2446, 'J', '金口河', '金口河区', 3, 'jinkouhe', '614700', 1, '103.07858', '29.24578');
INSERT INTO `shop_truck_region` VALUES (2451, 2446, NULL, '犍为', '犍为县', 3, 'qianwei', '614400', 1, '103.94989', '29.20973');
INSERT INTO `shop_truck_region` VALUES (2452, 2446, 'J', '井研', '井研县', 3, 'jingyan', '613100', 1, '104.07019', '29.65228');
INSERT INTO `shop_truck_region` VALUES (2453, 2446, 'J', '夹江', '夹江县', 3, 'jiajiang', '614100', 1, '103.57199', '29.73868');
INSERT INTO `shop_truck_region` VALUES (2454, 2446, NULL, '沐川', '沐川县', 3, 'muchuan', '614500', 1, '103.90353', '28.95646');
INSERT INTO `shop_truck_region` VALUES (2455, 2446, 'E', '峨边', '峨边彝族自治县', 3, 'ebian', '614300', 1, '103.26339', '29.23004');
INSERT INTO `shop_truck_region` VALUES (2456, 2446, 'M', '马边', '马边彝族自治县', 3, 'mabian', '614600', 1, '103.54617', '28.83593');
INSERT INTO `shop_truck_region` VALUES (2457, 2446, 'E', '峨眉山', '峨眉山市', 3, 'emeishan', '614200', 1, '103.4844', '29.60117');
INSERT INTO `shop_truck_region` VALUES (2458, 2367, 'N', '南充', '南充市', 2, 'nanchong', '637000', 1, '106.082974', '30.795281');
INSERT INTO `shop_truck_region` VALUES (2459, 2458, 'S', '顺庆', '顺庆区', 3, 'shunqing', '637000', 1, '106.09216', '30.79642');
INSERT INTO `shop_truck_region` VALUES (2460, 2458, 'G', '高坪', '高坪区', 3, 'gaoping', '637100', 1, '106.11894', '30.78162');
INSERT INTO `shop_truck_region` VALUES (2461, 2458, 'J', '嘉陵', '嘉陵区', 3, 'jialing', '637100', 1, '106.07141', '30.75848');
INSERT INTO `shop_truck_region` VALUES (2462, 2458, 'N', '南部', '南部县', 3, 'nanbu', '637300', 1, '106.06738', '31.35451');
INSERT INTO `shop_truck_region` VALUES (2463, 2458, 'Y', '营山', '营山县', 3, 'yingshan', '637700', 1, '106.56637', '31.07747');
INSERT INTO `shop_truck_region` VALUES (2464, 2458, 'P', '蓬安', '蓬安县', 3, 'pengan', '637800', 1, '106.41262', '31.02964');
INSERT INTO `shop_truck_region` VALUES (2465, 2458, 'Y', '仪陇', '仪陇县', 3, 'yilong', '637600', 1, '106.29974', '31.27628');
INSERT INTO `shop_truck_region` VALUES (2466, 2458, 'X', '西充', '西充县', 3, 'xichong', '637200', 1, '105.89996', '30.9969');
INSERT INTO `shop_truck_region` VALUES (2467, 2458, NULL, '阆中', '阆中市', 3, 'langzhong', '637400', 1, '106.00494', '31.55832');
INSERT INTO `shop_truck_region` VALUES (2468, 2367, 'M', '眉山', '眉山市', 2, 'meishan', '620020', 1, '103.831788', '30.048318');
INSERT INTO `shop_truck_region` VALUES (2469, 2468, 'D', '东坡', '东坡区', 3, 'dongpo', '620010', 1, '103.832', '30.04219');
INSERT INTO `shop_truck_region` VALUES (2470, 2468, 'P', '彭山', '彭山区', 3, 'pengshan', '620860', 1, '103.87268', '30.19283');
INSERT INTO `shop_truck_region` VALUES (2471, 2468, 'R', '仁寿', '仁寿县', 3, 'renshou', '620500', 1, '104.13412', '29.99599');
INSERT INTO `shop_truck_region` VALUES (2472, 2468, 'H', '洪雅', '洪雅县', 3, 'hongya', '620360', 1, '103.37313', '29.90661');
INSERT INTO `shop_truck_region` VALUES (2473, 2468, 'D', '丹棱', '丹棱县', 3, 'danling', '620200', 1, '103.51339', '30.01562');
INSERT INTO `shop_truck_region` VALUES (2474, 2468, 'Q', '青神', '青神县', 3, 'qingshen', '620460', 1, '103.84771', '29.83235');
INSERT INTO `shop_truck_region` VALUES (2475, 2367, 'Y', '宜宾', '宜宾市', 2, 'yibin', '644000', 1, '104.630825', '28.760189');
INSERT INTO `shop_truck_region` VALUES (2476, 2475, 'C', '翠屏', '翠屏区', 3, 'cuiping', '644000', 1, '104.61978', '28.76566');
INSERT INTO `shop_truck_region` VALUES (2477, 2475, 'N', '南溪', '南溪区', 3, 'nanxi', '644100', 1, '104.981133', '28.839806');
INSERT INTO `shop_truck_region` VALUES (2478, 2475, 'Y', '宜宾', '宜宾县', 3, 'yibin', '644600', 1, '104.53314', '28.68996');
INSERT INTO `shop_truck_region` VALUES (2479, 2475, 'J', '江安', '江安县', 3, 'jiangan', '644200', 1, '105.06683', '28.72385');
INSERT INTO `shop_truck_region` VALUES (2480, 2475, 'C', '长宁', '长宁县', 3, 'changning', '644300', 1, '104.9252', '28.57777');
INSERT INTO `shop_truck_region` VALUES (2481, 2475, 'G', '高县', '高县', 3, 'gaoxian', '645150', 1, '104.51754', '28.43619');
INSERT INTO `shop_truck_region` VALUES (2482, 2475, NULL, '珙县', '珙县', 3, 'gongxian', '644500', 1, '104.71398', '28.44512');
INSERT INTO `shop_truck_region` VALUES (2483, 2475, NULL, '筠连', '筠连县', 3, 'junlian', '645250', 1, '104.51217', '28.16495');
INSERT INTO `shop_truck_region` VALUES (2484, 2475, 'X', '兴文', '兴文县', 3, 'xingwen', '644400', 1, '105.23675', '28.3044');
INSERT INTO `shop_truck_region` VALUES (2485, 2475, 'P', '屏山', '屏山县', 3, 'pingshan', '645350', 1, '104.16293', '28.64369');
INSERT INTO `shop_truck_region` VALUES (2486, 2367, 'G', '广安', '广安市', 2, 'guangan', '638000', 1, '106.633369', '30.456398');
INSERT INTO `shop_truck_region` VALUES (2487, 2486, 'G', '广安', '广安区', 3, 'guangan', '638000', 1, '106.64163', '30.47389');
INSERT INTO `shop_truck_region` VALUES (2488, 2486, 'Q', '前锋', '前锋区', 3, 'qianfeng', '638019', 1, '106.893537', '30.494572');
INSERT INTO `shop_truck_region` VALUES (2489, 2486, 'Y', '岳池', '岳池县', 3, 'yuechi', '638300', 1, '106.44079', '30.53918');
INSERT INTO `shop_truck_region` VALUES (2490, 2486, 'W', '武胜', '武胜县', 3, 'wusheng', '638400', 1, '106.29592', '30.34932');
INSERT INTO `shop_truck_region` VALUES (2491, 2486, 'L', '邻水', '邻水县', 3, 'linshui', '638500', 1, '106.92968', '30.33449');
INSERT INTO `shop_truck_region` VALUES (2492, 2486, 'H', '华蓥', '华蓥市', 3, 'huaying', '638600', 1, '106.78466', '30.39007');
INSERT INTO `shop_truck_region` VALUES (2493, 2367, 'D', '达州', '达州市', 2, 'dazhou', '635000', 1, '107.502262', '31.209484');
INSERT INTO `shop_truck_region` VALUES (2494, 2493, 'T', '通川', '通川区', 3, 'tongchuan', '635000', 1, '107.50456', '31.21469');
INSERT INTO `shop_truck_region` VALUES (2495, 2493, 'D', '达川', '达川区', 3, 'dachuan', '635000', 1, '107.502262', '31.209484');
INSERT INTO `shop_truck_region` VALUES (2496, 2493, 'X', '宣汉', '宣汉县', 3, 'xuanhan', '636150', 1, '107.72775', '31.35516');
INSERT INTO `shop_truck_region` VALUES (2497, 2493, 'K', '开江', '开江县', 3, 'kaijiang', '636250', 1, '107.86889', '31.0841');
INSERT INTO `shop_truck_region` VALUES (2498, 2493, 'D', '大竹', '大竹县', 3, 'dazhu', '635100', 1, '107.20855', '30.74147');
INSERT INTO `shop_truck_region` VALUES (2499, 2493, 'Q', '渠县', '渠县', 3, 'quxian', '635200', 1, '106.97381', '30.8376');
INSERT INTO `shop_truck_region` VALUES (2500, 2493, 'W', '万源', '万源市', 3, 'wanyuan', '636350', 1, '108.03598', '32.08091');
INSERT INTO `shop_truck_region` VALUES (2501, 2367, 'Y', '雅安', '雅安市', 2, 'yaan', '625000', 1, '103.001033', '29.987722');
INSERT INTO `shop_truck_region` VALUES (2502, 2501, 'Y', '雨城', '雨城区', 3, 'yucheng', '625000', 1, '103.03305', '30.00531');
INSERT INTO `shop_truck_region` VALUES (2503, 2501, 'M', '名山', '名山区', 3, 'mingshan', '625100', 1, '103.112214', '30.084718');
INSERT INTO `shop_truck_region` VALUES (2504, 2501, NULL, '荥经', '荥经县', 3, 'yingjing', '625200', 1, '102.84652', '29.79402');
INSERT INTO `shop_truck_region` VALUES (2505, 2501, 'H', '汉源', '汉源县', 3, 'hanyuan', '625300', 1, '102.6784', '29.35168');
INSERT INTO `shop_truck_region` VALUES (2506, 2501, 'S', '石棉', '石棉县', 3, 'shimian', '625400', 1, '102.35943', '29.22796');
INSERT INTO `shop_truck_region` VALUES (2507, 2501, 'T', '天全', '天全县', 3, 'tianquan', '625500', 1, '102.75906', '30.06754');
INSERT INTO `shop_truck_region` VALUES (2508, 2501, 'L', '芦山', '芦山县', 3, 'lushan', '625600', 1, '102.92791', '30.14369');
INSERT INTO `shop_truck_region` VALUES (2509, 2501, 'B', '宝兴', '宝兴县', 3, 'baoxing', '625700', 1, '102.81555', '30.36836');
INSERT INTO `shop_truck_region` VALUES (2510, 2367, 'B', '巴中', '巴中市', 2, 'bazhong', '636000', 1, '106.753669', '31.858809');
INSERT INTO `shop_truck_region` VALUES (2511, 2510, 'B', '巴州', '巴州区', 3, 'bazhou', '636001', 1, '106.76889', '31.85125');
INSERT INTO `shop_truck_region` VALUES (2512, 2510, 'E', '恩阳', '恩阳区', 3, 'enyang', '636064', 1, '106.753669', '31.858809');
INSERT INTO `shop_truck_region` VALUES (2513, 2510, 'T', '通江', '通江县', 3, 'tongjiang', '636700', 1, '107.24398', '31.91294');
INSERT INTO `shop_truck_region` VALUES (2514, 2510, 'N', '南江', '南江县', 3, 'nanjiang', '636600', 1, '106.84164', '32.35335');
INSERT INTO `shop_truck_region` VALUES (2515, 2510, 'P', '平昌', '平昌县', 3, 'pingchang', '636400', 1, '107.10424', '31.5594');
INSERT INTO `shop_truck_region` VALUES (2516, 2367, 'Z', '资阳', '资阳市', 2, 'ziyang', '641300', 1, '104.641917', '30.122211');
INSERT INTO `shop_truck_region` VALUES (2517, 2516, 'Y', '雁江', '雁江区', 3, 'yanjiang', '641300', 1, '104.65216', '30.11525');
INSERT INTO `shop_truck_region` VALUES (2518, 2516, 'A', '安岳', '安岳县', 3, 'anyue', '642350', 1, '105.3363', '30.09786');
INSERT INTO `shop_truck_region` VALUES (2519, 2516, 'L', '乐至', '乐至县', 3, 'lezhi', '641500', 1, '105.03207', '30.27227');
INSERT INTO `shop_truck_region` VALUES (2520, 2516, 'J', '简阳', '简阳市', 3, 'jianyang', '641400', 1, '104.54864', '30.3904');
INSERT INTO `shop_truck_region` VALUES (2521, 2367, 'A', '阿坝', '阿坝藏族羌族自治州', 2, 'aba', '624000', 1, '102.221374', '31.899792');
INSERT INTO `shop_truck_region` VALUES (2522, 2521, NULL, '汶川', '汶川县', 3, 'wenchuan', '623000', 1, '103.59079', '31.47326');
INSERT INTO `shop_truck_region` VALUES (2523, 2521, 'L', '理县', '理县', 3, 'lixian', '623100', 1, '103.17175', '31.43603');
INSERT INTO `shop_truck_region` VALUES (2524, 2521, 'M', '茂县', '茂县', 3, 'maoxian', '623200', 1, '103.85372', '31.682');
INSERT INTO `shop_truck_region` VALUES (2525, 2521, 'S', '松潘', '松潘县', 3, 'songpan', '623300', 1, '103.59924', '32.63871');
INSERT INTO `shop_truck_region` VALUES (2526, 2521, 'J', '九寨沟', '九寨沟县', 3, 'jiuzhaigou', '623400', 1, '104.23672', '33.26318');
INSERT INTO `shop_truck_region` VALUES (2527, 2521, 'J', '金川', '金川县', 3, 'jinchuan', '624100', 1, '102.06555', '31.47623');
INSERT INTO `shop_truck_region` VALUES (2528, 2521, 'X', '小金', '小金县', 3, 'xiaojin', '624200', 1, '102.36499', '30.99934');
INSERT INTO `shop_truck_region` VALUES (2529, 2521, 'H', '黑水', '黑水县', 3, 'heishui', '623500', 1, '102.99176', '32.06184');
INSERT INTO `shop_truck_region` VALUES (2530, 2521, 'M', '马尔康', '马尔康县', 3, 'maerkang', '624000', 1, '102.20625', '31.90584');
INSERT INTO `shop_truck_region` VALUES (2531, 2521, 'R', '壤塘', '壤塘县', 3, 'rangtang', '624300', 1, '100.9783', '32.26578');
INSERT INTO `shop_truck_region` VALUES (2532, 2521, 'A', '阿坝', '阿坝县', 3, 'aba', '624600', 1, '101.70632', '32.90301');
INSERT INTO `shop_truck_region` VALUES (2533, 2521, 'R', '若尔盖', '若尔盖县', 3, 'ruoergai', '624500', 1, '102.9598', '33.57432');
INSERT INTO `shop_truck_region` VALUES (2534, 2521, 'H', '红原', '红原县', 3, 'hongyuan', '624400', 1, '102.54525', '32.78989');
INSERT INTO `shop_truck_region` VALUES (2535, 2367, 'G', '甘孜', '甘孜藏族自治州', 2, 'garze', '626000', 1, '101.963815', '30.050663');
INSERT INTO `shop_truck_region` VALUES (2536, 2535, 'K', '康定', '康定县', 3, 'kangding', '626000', 1, '101.96487', '30.05532');
INSERT INTO `shop_truck_region` VALUES (2537, 2535, NULL, '泸定', '泸定县', 3, 'luding', '626100', 1, '102.23507', '29.91475');
INSERT INTO `shop_truck_region` VALUES (2538, 2535, 'D', '丹巴', '丹巴县', 3, 'danba', '626300', 1, '101.88424', '30.87656');
INSERT INTO `shop_truck_region` VALUES (2539, 2535, 'J', '九龙', '九龙县', 3, 'jiulong', '626200', 1, '101.50848', '29.00091');
INSERT INTO `shop_truck_region` VALUES (2540, 2535, 'Y', '雅江', '雅江县', 3, 'yajiang', '627450', 1, '101.01492', '30.03281');
INSERT INTO `shop_truck_region` VALUES (2541, 2535, 'D', '道孚', '道孚县', 3, 'daofu', '626400', 1, '101.12554', '30.98046');
INSERT INTO `shop_truck_region` VALUES (2542, 2535, 'L', '炉霍', '炉霍县', 3, 'luhuo', '626500', 1, '100.67681', '31.3917');
INSERT INTO `shop_truck_region` VALUES (2543, 2535, 'G', '甘孜', '甘孜县', 3, 'ganzi', '626700', 1, '99.99307', '31.62672');
INSERT INTO `shop_truck_region` VALUES (2544, 2535, 'X', '新龙', '新龙县', 3, 'xinlong', '626800', 1, '100.3125', '30.94067');
INSERT INTO `shop_truck_region` VALUES (2545, 2535, 'D', '德格', '德格县', 3, 'dege', '627250', 1, '98.58078', '31.80615');
INSERT INTO `shop_truck_region` VALUES (2546, 2535, 'B', '白玉', '白玉县', 3, 'baiyu', '627150', 1, '98.82568', '31.20902');
INSERT INTO `shop_truck_region` VALUES (2547, 2535, 'S', '石渠', '石渠县', 3, 'shiqu', '627350', 1, '98.10156', '32.97884');
INSERT INTO `shop_truck_region` VALUES (2548, 2535, 'S', '色达', '色达县', 3, 'seda', '626600', 1, '100.33224', '32.26839');
INSERT INTO `shop_truck_region` VALUES (2549, 2535, 'L', '理塘', '理塘县', 3, 'litang', '627550', 1, '100.27005', '29.99674');
INSERT INTO `shop_truck_region` VALUES (2550, 2535, 'B', '巴塘', '巴塘县', 3, 'batang', '627650', 1, '99.10409', '30.00423');
INSERT INTO `shop_truck_region` VALUES (2551, 2535, 'X', '乡城', '乡城县', 3, 'xiangcheng', '627850', 1, '99.79943', '28.93554');
INSERT INTO `shop_truck_region` VALUES (2552, 2535, 'D', '稻城', '稻城县', 3, 'daocheng', '627750', 1, '100.29809', '29.0379');
INSERT INTO `shop_truck_region` VALUES (2553, 2535, 'D', '得荣', '得荣县', 3, 'derong', '627950', 1, '99.28628', '28.71297');
INSERT INTO `shop_truck_region` VALUES (2554, 2367, 'L', '凉山', '凉山彝族自治州', 2, 'liangshan', '615000', 1, '102.258746', '27.886762');
INSERT INTO `shop_truck_region` VALUES (2555, 2554, 'X', '西昌', '西昌市', 3, 'xichang', '615000', 1, '102.26413', '27.89524');
INSERT INTO `shop_truck_region` VALUES (2556, 2554, 'M', '木里', '木里藏族自治县', 3, 'muli', '615800', 1, '101.2796', '27.92875');
INSERT INTO `shop_truck_region` VALUES (2557, 2554, 'Y', '盐源', '盐源县', 3, 'yanyuan', '615700', 1, '101.5097', '27.42177');
INSERT INTO `shop_truck_region` VALUES (2558, 2554, 'D', '德昌', '德昌县', 3, 'dechang', '615500', 1, '102.18017', '27.40482');
INSERT INTO `shop_truck_region` VALUES (2559, 2554, 'H', '会理', '会理县', 3, 'huili', '615100', 1, '102.24539', '26.65627');
INSERT INTO `shop_truck_region` VALUES (2560, 2554, 'H', '会东', '会东县', 3, 'huidong', '615200', 1, '102.57815', '26.63429');
INSERT INTO `shop_truck_region` VALUES (2561, 2554, 'N', '宁南', '宁南县', 3, 'ningnan', '615400', 1, '102.76116', '27.06567');
INSERT INTO `shop_truck_region` VALUES (2562, 2554, 'P', '普格', '普格县', 3, 'puge', '615300', 1, '102.54055', '27.37485');
INSERT INTO `shop_truck_region` VALUES (2563, 2554, 'B', '布拖', '布拖县', 3, 'butuo', '616350', 1, '102.81234', '27.7079');
INSERT INTO `shop_truck_region` VALUES (2564, 2554, 'J', '金阳', '金阳县', 3, 'jinyang', '616250', 1, '103.24774', '27.69698');
INSERT INTO `shop_truck_region` VALUES (2565, 2554, 'Z', '昭觉', '昭觉县', 3, 'zhaojue', '616150', 1, '102.84661', '28.01155');
INSERT INTO `shop_truck_region` VALUES (2566, 2554, 'X', '喜德', '喜德县', 3, 'xide', '616750', 1, '102.41336', '28.30739');
INSERT INTO `shop_truck_region` VALUES (2567, 2554, 'M', '冕宁', '冕宁县', 3, 'mianning', '615600', 1, '102.17108', '28.55161');
INSERT INTO `shop_truck_region` VALUES (2568, 2554, 'Y', '越西', '越西县', 3, 'yuexi', '616650', 1, '102.5079', '28.64133');
INSERT INTO `shop_truck_region` VALUES (2569, 2554, 'G', '甘洛', '甘洛县', 3, 'ganluo', '616850', 1, '102.77154', '28.96624');
INSERT INTO `shop_truck_region` VALUES (2570, 2554, 'M', '美姑', '美姑县', 3, 'meigu', '616450', 1, '103.13116', '28.32596');
INSERT INTO `shop_truck_region` VALUES (2571, 2554, 'L', '雷波', '雷波县', 3, 'leibo', '616550', 1, '103.57287', '28.26407');
INSERT INTO `shop_truck_region` VALUES (2572, 0, 'G', '贵州', '贵州省', 1, 'guizhou', '', 1, '106.713478', '26.578343');
INSERT INTO `shop_truck_region` VALUES (2573, 2572, 'G', '贵阳', '贵阳市', 2, 'guiyang', '550001', 1, '106.713478', '26.578343');
INSERT INTO `shop_truck_region` VALUES (2574, 2573, 'N', '南明', '南明区', 3, 'nanming', '550001', 1, '106.7145', '26.56819');
INSERT INTO `shop_truck_region` VALUES (2575, 2573, 'Y', '云岩', '云岩区', 3, 'yunyan', '550001', 1, '106.72485', '26.60484');
INSERT INTO `shop_truck_region` VALUES (2576, 2573, 'H', '花溪', '花溪区', 3, 'huaxi', '550025', 1, '106.67688', '26.43343');
INSERT INTO `shop_truck_region` VALUES (2577, 2573, 'W', '乌当', '乌当区', 3, 'wudang', '550018', 1, '106.7521', '26.6302');
INSERT INTO `shop_truck_region` VALUES (2578, 2573, 'B', '白云', '白云区', 3, 'baiyun', '550014', 1, '106.63088', '26.68284');
INSERT INTO `shop_truck_region` VALUES (2579, 2573, 'G', '观山湖', '观山湖区', 3, 'guanshanhu', '550009', 1, '106.625442', '26.618209');
INSERT INTO `shop_truck_region` VALUES (2580, 2573, 'K', '开阳', '开阳县', 3, 'kaiyang', '550300', 1, '106.9692', '27.05533');
INSERT INTO `shop_truck_region` VALUES (2581, 2573, 'X', '息烽', '息烽县', 3, 'xifeng', '551100', 1, '106.738', '27.09346');
INSERT INTO `shop_truck_region` VALUES (2582, 2573, 'X', '修文', '修文县', 3, 'xiuwen', '550200', 1, '106.59487', '26.83783');
INSERT INTO `shop_truck_region` VALUES (2583, 2573, 'Q', '清镇', '清镇市', 3, 'qingzhen', '551400', 1, '106.46862', '26.55261');
INSERT INTO `shop_truck_region` VALUES (2584, 2572, 'L', '六盘水', '六盘水市', 2, 'liupanshui', '553400', 1, '104.846743', '26.584643');
INSERT INTO `shop_truck_region` VALUES (2585, 2584, 'Z', '钟山', '钟山区', 3, 'zhongshan', '553000', 1, '104.87848', '26.57699');
INSERT INTO `shop_truck_region` VALUES (2586, 2584, 'L', '六枝', '六枝特区', 3, 'liuzhi', '553400', 1, '105.48062', '26.20117');
INSERT INTO `shop_truck_region` VALUES (2587, 2584, 'S', '水城', '水城县', 3, 'shuicheng', '553000', 1, '104.95764', '26.54785');
INSERT INTO `shop_truck_region` VALUES (2588, 2584, 'P', '盘县', '盘县', 3, 'panxian', '561601', 1, '104.47061', '25.7136');
INSERT INTO `shop_truck_region` VALUES (2589, 2572, 'Z', '遵义', '遵义市', 2, 'zunyi', '563000', 1, '106.937265', '27.706626');
INSERT INTO `shop_truck_region` VALUES (2590, 2589, 'H', '红花岗', '红花岗区', 3, 'honghuagang', '563000', 1, '106.89404', '27.64471');
INSERT INTO `shop_truck_region` VALUES (2591, 2589, 'H', '汇川', '汇川区', 3, 'huichuan', '563000', 1, '106.9393', '27.70625');
INSERT INTO `shop_truck_region` VALUES (2592, 2589, 'Z', '遵义', '遵义县', 3, 'zunyi', '563100', 1, '106.83331', '27.53772');
INSERT INTO `shop_truck_region` VALUES (2593, 2589, 'T', '桐梓', '桐梓县', 3, 'tongzi', '563200', 1, '106.82568', '28.13806');
INSERT INTO `shop_truck_region` VALUES (2594, 2589, 'S', '绥阳', '绥阳县', 3, 'suiyang', '563300', 1, '107.19064', '27.94702');
INSERT INTO `shop_truck_region` VALUES (2595, 2589, 'Z', '正安', '正安县', 3, 'zhengan', '563400', 1, '107.44357', '28.5512');
INSERT INTO `shop_truck_region` VALUES (2596, 2589, 'D', '道真', '道真仡佬族苗族自治县', 3, 'daozhen', '563500', 1, '107.61152', '28.864');
INSERT INTO `shop_truck_region` VALUES (2597, 2589, 'W', '务川', '务川仡佬族苗族自治县', 3, 'wuchuan', '564300', 1, '107.88935', '28.52227');
INSERT INTO `shop_truck_region` VALUES (2598, 2589, 'F', '凤冈', '凤冈县', 3, 'fenggang', '564200', 1, '107.71682', '27.95461');
INSERT INTO `shop_truck_region` VALUES (2599, 2589, NULL, '湄潭', '湄潭县', 3, 'meitan', '564100', 1, '107.48779', '27.76676');
INSERT INTO `shop_truck_region` VALUES (2600, 2589, 'Y', '余庆', '余庆县', 3, 'yuqing', '564400', 1, '107.88821', '27.22532');
INSERT INTO `shop_truck_region` VALUES (2601, 2589, 'X', '习水', '习水县', 3, 'xishui', '564600', 1, '106.21267', '28.31976');
INSERT INTO `shop_truck_region` VALUES (2602, 2589, 'C', '赤水', '赤水市', 3, 'chishui', '564700', 1, '105.69845', '28.58921');
INSERT INTO `shop_truck_region` VALUES (2603, 2589, 'R', '仁怀', '仁怀市', 3, 'renhuai', '564500', 1, '106.40152', '27.79231');
INSERT INTO `shop_truck_region` VALUES (2604, 2572, 'A', '安顺', '安顺市', 2, 'anshun', '561000', 1, '105.932188', '26.245544');
INSERT INTO `shop_truck_region` VALUES (2605, 2604, 'X', '西秀', '西秀区', 3, 'xixiu', '561000', 1, '105.96585', '26.24491');
INSERT INTO `shop_truck_region` VALUES (2606, 2604, 'P', '平坝', '平坝区', 3, 'pingba', '561100', 1, '106.25683', '26.40543');
INSERT INTO `shop_truck_region` VALUES (2607, 2604, 'P', '普定', '普定县', 3, 'puding', '562100', 1, '105.74285', '26.30141');
INSERT INTO `shop_truck_region` VALUES (2608, 2604, 'Z', '镇宁', '镇宁布依族苗族自治县', 3, 'zhenning', '561200', 1, '105.76513', '26.05533');
INSERT INTO `shop_truck_region` VALUES (2609, 2604, 'G', '关岭', '关岭布依族苗族自治县', 3, 'guanling', '561300', 1, '105.61883', '25.94248');
INSERT INTO `shop_truck_region` VALUES (2610, 2604, 'Z', '紫云', '紫云苗族布依族自治县', 3, 'ziyun', '550800', 1, '106.08364', '25.75258');
INSERT INTO `shop_truck_region` VALUES (2611, 2572, 'B', '毕节', '毕节市', 2, 'bijie', '551700', 1, '105.28501', '27.301693');
INSERT INTO `shop_truck_region` VALUES (2612, 2611, 'Q', '七星关', '七星关区', 3, 'qixingguan', '551700', 1, '104.9497', '27.153556');
INSERT INTO `shop_truck_region` VALUES (2613, 2611, 'D', '大方', '大方县', 3, 'dafang', '551600', 1, '105.609254', '27.143521');
INSERT INTO `shop_truck_region` VALUES (2614, 2611, 'Q', '黔西', '黔西县', 3, 'qianxi', '551500', 1, '106.038299', '27.024923');
INSERT INTO `shop_truck_region` VALUES (2615, 2611, 'J', '金沙', '金沙县', 3, 'jinsha', '551800', 1, '106.222103', '27.459693');
INSERT INTO `shop_truck_region` VALUES (2616, 2611, 'Z', '织金', '织金县', 3, 'zhijin', '552100', 1, '105.768997', '26.668497');
INSERT INTO `shop_truck_region` VALUES (2617, 2611, 'N', '纳雍', '纳雍县', 3, 'nayong', '553300', 1, '105.375322', '26.769875');
INSERT INTO `shop_truck_region` VALUES (2618, 2611, 'W', '威宁', '威宁彝族回族苗族自治县', 3, 'weining', '553100', 1, '104.286523', '26.859099');
INSERT INTO `shop_truck_region` VALUES (2619, 2611, 'H', '赫章', '赫章县', 3, 'hezhang', '553200', 1, '104.726438', '27.119243');
INSERT INTO `shop_truck_region` VALUES (2620, 2572, 'T', '铜仁', '铜仁市', 2, 'tongren', '554300', 1, '109.191555', '27.718346');
INSERT INTO `shop_truck_region` VALUES (2621, 2620, 'B', '碧江', '碧江区', 3, 'bijiang', '554300', 1, '109.191555', '27.718346');
INSERT INTO `shop_truck_region` VALUES (2622, 2620, 'W', '万山', '万山区', 3, 'wanshan', '554200', 1, '109.21199', '27.51903');
INSERT INTO `shop_truck_region` VALUES (2623, 2620, 'J', '江口', '江口县', 3, 'jiangkou', '554400', 1, '108.848427', '27.691904');
INSERT INTO `shop_truck_region` VALUES (2624, 2620, 'Y', '玉屏', '玉屏侗族自治县', 3, 'yuping', '554004', 1, '108.917882', '27.238024');
INSERT INTO `shop_truck_region` VALUES (2625, 2620, 'S', '石阡', '石阡县', 3, 'shiqian', '555100', 1, '108.229854', '27.519386');
INSERT INTO `shop_truck_region` VALUES (2626, 2620, 'S', '思南', '思南县', 3, 'sinan', '565100', 1, '108.255827', '27.941331');
INSERT INTO `shop_truck_region` VALUES (2627, 2620, 'Y', '印江', '印江土家族苗族自治县', 3, 'yinjiang', '555200', 1, '108.405517', '27.997976');
INSERT INTO `shop_truck_region` VALUES (2628, 2620, 'D', '德江', '德江县', 3, 'dejiang', '565200', 1, '108.117317', '28.26094');
INSERT INTO `shop_truck_region` VALUES (2629, 2620, 'Y', '沿河', '沿河土家族自治县', 3, 'yuanhe', '565300', 1, '108.495746', '28.560487');
INSERT INTO `shop_truck_region` VALUES (2630, 2620, 'S', '松桃', '松桃苗族自治县', 3, 'songtao', '554100', 1, '109.202627', '28.165419');
INSERT INTO `shop_truck_region` VALUES (2631, 2572, 'Q', '黔西南', '黔西南布依族苗族自治州', 2, 'qianxinan', '562400', 1, '104.897971', '25.08812');
INSERT INTO `shop_truck_region` VALUES (2632, 2631, 'X', '兴义', '兴义市 ', 3, 'xingyi', '562400', 1, '104.89548', '25.09205');
INSERT INTO `shop_truck_region` VALUES (2633, 2631, 'X', '兴仁', '兴仁县', 3, 'xingren', '562300', 1, '105.18652', '25.43282');
INSERT INTO `shop_truck_region` VALUES (2634, 2631, 'P', '普安', '普安县', 3, 'puan', '561500', 1, '104.95529', '25.78603');
INSERT INTO `shop_truck_region` VALUES (2635, 2631, 'Q', '晴隆', '晴隆县', 3, 'qinglong', '561400', 1, '105.2192', '25.83522');
INSERT INTO `shop_truck_region` VALUES (2636, 2631, 'Z', '贞丰', '贞丰县', 3, 'zhenfeng', '562200', 1, '105.65454', '25.38464');
INSERT INTO `shop_truck_region` VALUES (2637, 2631, 'W', '望谟', '望谟县', 3, 'wangmo', '552300', 1, '106.09957', '25.17822');
INSERT INTO `shop_truck_region` VALUES (2638, 2631, 'C', '册亨', '册亨县', 3, 'ceheng', '552200', 1, '105.8124', '24.98376');
INSERT INTO `shop_truck_region` VALUES (2639, 2631, 'A', '安龙', '安龙县', 3, 'anlong', '552400', 1, '105.44268', '25.09818');
INSERT INTO `shop_truck_region` VALUES (2640, 2572, 'Q', '黔东南', '黔东南苗族侗族自治州', 2, 'qiandongnan', '556000', 1, '107.977488', '26.583352');
INSERT INTO `shop_truck_region` VALUES (2641, 2640, 'K', '凯里', '凯里市', 3, 'kaili', '556000', 1, '107.98132', '26.56689');
INSERT INTO `shop_truck_region` VALUES (2642, 2640, 'H', '黄平', '黄平县', 3, 'huangping', '556100', 1, '107.90179', '26.89573');
INSERT INTO `shop_truck_region` VALUES (2643, 2640, 'S', '施秉', '施秉县', 3, 'shibing', '556200', 1, '108.12597', '27.03495');
INSERT INTO `shop_truck_region` VALUES (2644, 2640, 'S', '三穗', '三穗县', 3, 'sansui', '556500', 1, '108.67132', '26.94765');
INSERT INTO `shop_truck_region` VALUES (2645, 2640, 'Z', '镇远', '镇远县', 3, 'zhenyuan', '557700', 1, '108.42721', '27.04933');
INSERT INTO `shop_truck_region` VALUES (2646, 2640, NULL, '岑巩', '岑巩县', 3, 'cengong', '557800', 1, '108.81884', '27.17539');
INSERT INTO `shop_truck_region` VALUES (2647, 2640, 'T', '天柱', '天柱县', 3, 'tianzhu', '556600', 1, '109.20718', '26.90781');
INSERT INTO `shop_truck_region` VALUES (2648, 2640, 'J', '锦屏', '锦屏县', 3, 'jinping', '556700', 1, '109.19982', '26.67635');
INSERT INTO `shop_truck_region` VALUES (2649, 2640, 'J', '剑河', '剑河县', 3, 'jianhe', '556400', 1, '108.5913', '26.6525');
INSERT INTO `shop_truck_region` VALUES (2650, 2640, 'T', '台江', '台江县', 3, 'taijiang', '556300', 1, '108.31814', '26.66916');
INSERT INTO `shop_truck_region` VALUES (2651, 2640, 'L', '黎平', '黎平县', 3, 'liping', '557300', 1, '109.13607', '26.23114');
INSERT INTO `shop_truck_region` VALUES (2652, 2640, NULL, '榕江', '榕江县', 3, 'rongjiang', '557200', 1, '108.52072', '25.92421');
INSERT INTO `shop_truck_region` VALUES (2653, 2640, 'C', '从江', '从江县', 3, 'congjiang', '557400', 1, '108.90527', '25.75415');
INSERT INTO `shop_truck_region` VALUES (2654, 2640, 'L', '雷山', '雷山县', 3, 'leishan', '557100', 1, '108.07745', '26.38385');
INSERT INTO `shop_truck_region` VALUES (2655, 2640, 'M', '麻江', '麻江县', 3, 'majiang', '557600', 1, '107.59155', '26.49235');
INSERT INTO `shop_truck_region` VALUES (2656, 2640, 'D', '丹寨', '丹寨县', 3, 'danzhai', '557500', 1, '107.79718', '26.19816');
INSERT INTO `shop_truck_region` VALUES (2657, 2572, 'Q', '黔南', '黔南布依族苗族自治州', 2, 'qiannan', '558000', 1, '107.517156', '26.258219');
INSERT INTO `shop_truck_region` VALUES (2658, 2657, 'D', '都匀', '都匀市', 3, 'duyun', '558000', 1, '107.51872', '26.2594');
INSERT INTO `shop_truck_region` VALUES (2659, 2657, 'F', '福泉', '福泉市', 3, 'fuquan', '550500', 1, '107.51715', '26.67989');
INSERT INTO `shop_truck_region` VALUES (2660, 2657, 'L', '荔波', '荔波县', 3, 'libo', '558400', 1, '107.88592', '25.4139');
INSERT INTO `shop_truck_region` VALUES (2661, 2657, 'G', '贵定', '贵定县', 3, 'guiding', '551300', 1, '107.23654', '26.57812');
INSERT INTO `shop_truck_region` VALUES (2662, 2657, 'W', '瓮安', '瓮安县', 3, 'wengan', '550400', 1, '107.4757', '27.06813');
INSERT INTO `shop_truck_region` VALUES (2663, 2657, 'D', '独山', '独山县', 3, 'dushan', '558200', 1, '107.54101', '25.8245');
INSERT INTO `shop_truck_region` VALUES (2664, 2657, 'P', '平塘', '平塘县', 3, 'pingtang', '558300', 1, '107.32428', '25.83294');
INSERT INTO `shop_truck_region` VALUES (2665, 2657, 'L', '罗甸', '罗甸县', 3, 'luodian', '550100', 1, '106.75186', '25.42586');
INSERT INTO `shop_truck_region` VALUES (2666, 2657, 'C', '长顺', '长顺县', 3, 'changshun', '550700', 1, '106.45217', '26.02299');
INSERT INTO `shop_truck_region` VALUES (2667, 2657, 'L', '龙里', '龙里县', 3, 'longli', '551200', 1, '106.97662', '26.45076');
INSERT INTO `shop_truck_region` VALUES (2668, 2657, 'H', '惠水', '惠水县', 3, 'huishui', '550600', 1, '106.65911', '26.13389');
INSERT INTO `shop_truck_region` VALUES (2669, 2657, 'S', '三都', '三都水族自治县', 3, 'sandu', '558100', 1, '107.87464', '25.98562');
INSERT INTO `shop_truck_region` VALUES (2670, 0, 'Y', '云南', '云南省', 1, 'yunnan', '', 1, '102.712251', '25.040609');
INSERT INTO `shop_truck_region` VALUES (2671, 2670, 'K', '昆明', '昆明市', 2, 'kunming', '650500', 1, '102.712251', '25.040609');
INSERT INTO `shop_truck_region` VALUES (2672, 2671, 'W', '五华', '五华区', 3, 'wuhua', '650021', 1, '102.70786', '25.03521');
INSERT INTO `shop_truck_region` VALUES (2673, 2671, 'P', '盘龙', '盘龙区', 3, 'panlong', '650051', 1, '102.71994', '25.04053');
INSERT INTO `shop_truck_region` VALUES (2674, 2671, 'G', '官渡', '官渡区', 3, 'guandu', '650200', 1, '102.74362', '25.01497');
INSERT INTO `shop_truck_region` VALUES (2675, 2671, 'X', '西山', '西山区', 3, 'xishan', '650118', 1, '102.66464', '25.03796');
INSERT INTO `shop_truck_region` VALUES (2676, 2671, 'D', '东川', '东川区', 3, 'dongchuan', '654100', 1, '103.18832', '26.083');
INSERT INTO `shop_truck_region` VALUES (2677, 2671, 'C', '呈贡', '呈贡区', 3, 'chenggong', '650500', 1, '102.801382', '24.889275');
INSERT INTO `shop_truck_region` VALUES (2678, 2671, 'J', '晋宁', '晋宁县', 3, 'jinning', '650600', 1, '102.59393', '24.6665');
INSERT INTO `shop_truck_region` VALUES (2679, 2671, 'F', '富民', '富民县', 3, 'fumin', '650400', 1, '102.4985', '25.22119');
INSERT INTO `shop_truck_region` VALUES (2680, 2671, 'Y', '宜良', '宜良县', 3, 'yiliang', '652100', 1, '103.14117', '24.91705');
INSERT INTO `shop_truck_region` VALUES (2681, 2671, 'S', '石林', '石林彝族自治县', 3, 'shilin', '652200', 1, '103.27148', '24.75897');
INSERT INTO `shop_truck_region` VALUES (2682, 2671, NULL, '嵩明', '嵩明县', 3, 'songming', '651700', 1, '103.03729', '25.33986');
INSERT INTO `shop_truck_region` VALUES (2683, 2671, 'L', '禄劝', '禄劝彝族苗族自治县', 3, 'luquan', '651500', 1, '102.4671', '25.55387');
INSERT INTO `shop_truck_region` VALUES (2684, 2671, 'X', '寻甸', '寻甸回族彝族自治县 ', 3, 'xundian', '655200', 1, '103.2557', '25.55961');
INSERT INTO `shop_truck_region` VALUES (2685, 2671, 'A', '安宁', '安宁市', 3, 'anning', '650300', 1, '102.46972', '24.91652');
INSERT INTO `shop_truck_region` VALUES (2686, 2670, 'Q', '曲靖', '曲靖市', 2, 'qujing', '655000', 1, '103.797851', '25.501557');
INSERT INTO `shop_truck_region` VALUES (2687, 2686, NULL, '麒麟', '麒麟区', 3, 'qilin', '655000', 1, '103.80504', '25.49515');
INSERT INTO `shop_truck_region` VALUES (2688, 2686, 'M', '马龙', '马龙县', 3, 'malong', '655100', 1, '103.57873', '25.42521');
INSERT INTO `shop_truck_region` VALUES (2689, 2686, 'L', '陆良', '陆良县', 3, 'luliang', '655600', 1, '103.6665', '25.02335');
INSERT INTO `shop_truck_region` VALUES (2690, 2686, 'S', '师宗', '师宗县', 3, 'shizong', '655700', 1, '103.99084', '24.82822');
INSERT INTO `shop_truck_region` VALUES (2691, 2686, 'L', '罗平', '罗平县', 3, 'luoping', '655800', 1, '104.30859', '24.88444');
INSERT INTO `shop_truck_region` VALUES (2692, 2686, 'F', '富源', '富源县', 3, 'fuyuan', '655500', 1, '104.25387', '25.66587');
INSERT INTO `shop_truck_region` VALUES (2693, 2686, 'H', '会泽', '会泽县', 3, 'huize', '654200', 1, '103.30017', '26.41076');
INSERT INTO `shop_truck_region` VALUES (2694, 2686, 'Z', '沾益', '沾益县', 3, 'zhanyi', '655331', 1, '103.82135', '25.60715');
INSERT INTO `shop_truck_region` VALUES (2695, 2686, 'X', '宣威', '宣威市', 3, 'xuanwei', '655400', 1, '104.10409', '26.2173');
INSERT INTO `shop_truck_region` VALUES (2696, 2670, 'Y', '玉溪', '玉溪市', 2, 'yuxi', '653100', 1, '102.543907', '24.350461');
INSERT INTO `shop_truck_region` VALUES (2697, 2696, 'H', '红塔', '红塔区', 3, 'hongta', '653100', 1, '102.5449', '24.35411');
INSERT INTO `shop_truck_region` VALUES (2698, 2696, 'J', '江川', '江川县', 3, 'jiangchuan', '652600', 1, '102.75412', '24.28863');
INSERT INTO `shop_truck_region` VALUES (2699, 2696, 'C', '澄江', '澄江县', 3, 'chengjiang', '652500', 1, '102.90817', '24.67376');
INSERT INTO `shop_truck_region` VALUES (2700, 2696, 'T', '通海', '通海县', 3, 'tonghai', '652700', 1, '102.76641', '24.11362');
INSERT INTO `shop_truck_region` VALUES (2701, 2696, 'H', '华宁', '华宁县', 3, 'huaning', '652800', 1, '102.92831', '24.1926');
INSERT INTO `shop_truck_region` VALUES (2702, 2696, 'Y', '易门', '易门县', 3, 'yimen', '651100', 1, '102.16354', '24.67122');
INSERT INTO `shop_truck_region` VALUES (2703, 2696, 'E', '峨山', '峨山彝族自治县', 3, 'eshan', '653200', 1, '102.40576', '24.16904');
INSERT INTO `shop_truck_region` VALUES (2704, 2696, 'X', '新平', '新平彝族傣族自治县', 3, 'xinping', '653400', 1, '101.98895', '24.06886');
INSERT INTO `shop_truck_region` VALUES (2705, 2696, 'Y', '元江', '元江哈尼族彝族傣族自治县', 3, 'yuanjiang', '653300', 1, '101.99812', '23.59655');
INSERT INTO `shop_truck_region` VALUES (2706, 2670, 'B', '保山', '保山市', 2, 'baoshan', '678000', 1, '99.167133', '25.111802');
INSERT INTO `shop_truck_region` VALUES (2707, 2706, 'L', '隆阳', '隆阳区', 3, 'longyang', '678000', 1, '99.16334', '25.11163');
INSERT INTO `shop_truck_region` VALUES (2708, 2706, 'S', '施甸', '施甸县', 3, 'shidian', '678200', 1, '99.18768', '24.72418');
INSERT INTO `shop_truck_region` VALUES (2709, 2706, 'T', '腾冲', '腾冲县', 3, 'tengchong', '679100', 1, '98.49414', '25.02539');
INSERT INTO `shop_truck_region` VALUES (2710, 2706, 'L', '龙陵', '龙陵县', 3, 'longling', '678300', 1, '98.69024', '24.58746');
INSERT INTO `shop_truck_region` VALUES (2711, 2706, 'C', '昌宁', '昌宁县', 3, 'changning', '678100', 1, '99.6036', '24.82763');
INSERT INTO `shop_truck_region` VALUES (2712, 2670, 'Z', '昭通', '昭通市', 2, 'zhaotong', '657000', 1, '103.717216', '27.336999');
INSERT INTO `shop_truck_region` VALUES (2713, 2712, 'Z', '昭阳', '昭阳区', 3, 'zhaoyang', '657000', 1, '103.70654', '27.31998');
INSERT INTO `shop_truck_region` VALUES (2714, 2712, 'L', '鲁甸', '鲁甸县', 3, 'ludian', '657100', 1, '103.54721', '27.19238');
INSERT INTO `shop_truck_region` VALUES (2715, 2712, 'Q', '巧家', '巧家县', 3, 'qiaojia', '654600', 1, '102.92416', '26.91237');
INSERT INTO `shop_truck_region` VALUES (2716, 2712, 'Y', '盐津', '盐津县', 3, 'yanjin', '657500', 1, '104.23461', '28.10856');
INSERT INTO `shop_truck_region` VALUES (2717, 2712, 'D', '大关', '大关县', 3, 'daguan', '657400', 1, '103.89254', '27.7488');
INSERT INTO `shop_truck_region` VALUES (2718, 2712, 'Y', '永善', '永善县', 3, 'yongshan', '657300', 1, '103.63504', '28.2279');
INSERT INTO `shop_truck_region` VALUES (2719, 2712, 'S', '绥江', '绥江县', 3, 'suijiang', '657700', 1, '103.94937', '28.59661');
INSERT INTO `shop_truck_region` VALUES (2720, 2712, 'Z', '镇雄', '镇雄县', 3, 'zhenxiong', '657200', 1, '104.87258', '27.43981');
INSERT INTO `shop_truck_region` VALUES (2721, 2712, 'Y', '彝良', '彝良县', 3, 'yiliang', '657600', 1, '104.04983', '27.62809');
INSERT INTO `shop_truck_region` VALUES (2722, 2712, 'W', '威信', '威信县', 3, 'weixin', '657900', 1, '105.04754', '27.84065');
INSERT INTO `shop_truck_region` VALUES (2723, 2712, 'S', '水富', '水富县', 3, 'shuifu', '657800', 1, '104.4158', '28.62986');
INSERT INTO `shop_truck_region` VALUES (2724, 2670, 'L', '丽江', '丽江市', 2, 'lijiang', '674100', 1, '100.233026', '26.872108');
INSERT INTO `shop_truck_region` VALUES (2725, 2724, 'G', '古城', '古城区', 3, 'gucheng', '674100', 1, '100.2257', '26.87697');
INSERT INTO `shop_truck_region` VALUES (2726, 2724, 'Y', '玉龙', '玉龙纳西族自治县', 3, 'yulong', '674100', 1, '100.2369', '26.82149');
INSERT INTO `shop_truck_region` VALUES (2727, 2724, 'Y', '永胜', '永胜县', 3, 'yongsheng', '674200', 1, '100.74667', '26.68591');
INSERT INTO `shop_truck_region` VALUES (2728, 2724, 'H', '华坪', '华坪县', 3, 'huaping', '674800', 1, '101.26562', '26.62967');
INSERT INTO `shop_truck_region` VALUES (2729, 2724, 'N', '宁蒗', '宁蒗彝族自治县', 3, 'ninglang', '674300', 1, '100.8507', '27.28179');
INSERT INTO `shop_truck_region` VALUES (2730, 2670, 'P', '普洱', '普洱市', 2, 'puer', '665000', 1, '100.972344', '22.777321');
INSERT INTO `shop_truck_region` VALUES (2731, 2730, 'S', '思茅', '思茅区', 3, 'simao', '665000', 1, '100.97716', '22.78691');
INSERT INTO `shop_truck_region` VALUES (2732, 2730, 'N', '宁洱', '宁洱哈尼族彝族自治县', 3, 'ninger', '665100', 1, '101.04653', '23.06341');
INSERT INTO `shop_truck_region` VALUES (2733, 2730, 'M', '墨江', '墨江哈尼族自治县', 3, 'mojiang', '654800', 1, '101.69171', '23.43214');
INSERT INTO `shop_truck_region` VALUES (2734, 2730, 'J', '景东', '景东彝族自治县', 3, 'jingdong', '676200', 1, '100.83599', '24.44791');
INSERT INTO `shop_truck_region` VALUES (2735, 2730, 'J', '景谷', '景谷傣族彝族自治县', 3, 'jinggu', '666400', 1, '100.70251', '23.49705');
INSERT INTO `shop_truck_region` VALUES (2736, 2730, 'Z', '镇沅', '镇沅彝族哈尼族拉祜族自治县', 3, 'zhenyuan', '666500', 1, '101.10675', '24.00557');
INSERT INTO `shop_truck_region` VALUES (2737, 2730, 'J', '江城', '江城哈尼族彝族自治县', 3, 'jiangcheng', '665900', 1, '101.85788', '22.58424');
INSERT INTO `shop_truck_region` VALUES (2738, 2730, 'M', '孟连', '孟连傣族拉祜族佤族自治县', 3, 'menglian', '665800', 1, '99.58424', '22.32922');
INSERT INTO `shop_truck_region` VALUES (2739, 2730, 'L', '澜沧', '澜沧拉祜族自治县', 3, 'lancang', '665600', 1, '99.93591', '22.55474');
INSERT INTO `shop_truck_region` VALUES (2740, 2730, 'X', '西盟', '西盟佤族自治县', 3, 'ximeng', '665700', 1, '99.59869', '22.64774');
INSERT INTO `shop_truck_region` VALUES (2741, 2670, 'L', '临沧', '临沧市', 2, 'lincang', '677000', 1, '100.08697', '23.886567');
INSERT INTO `shop_truck_region` VALUES (2742, 2741, 'L', '临翔', '临翔区', 3, 'linxiang', '677000', 1, '100.08242', '23.89497');
INSERT INTO `shop_truck_region` VALUES (2743, 2741, 'F', '凤庆', '凤庆县', 3, 'fengqing', '675900', 1, '99.92837', '24.58034');
INSERT INTO `shop_truck_region` VALUES (2744, 2741, 'Y', '云县', '云县', 3, 'yunxian', '675800', 1, '100.12808', '24.44675');
INSERT INTO `shop_truck_region` VALUES (2745, 2741, 'Y', '永德', '永德县', 3, 'yongde', '677600', 1, '99.25326', '24.0276');
INSERT INTO `shop_truck_region` VALUES (2746, 2741, 'Z', '镇康', '镇康县', 3, 'zhenkang', '677704', 1, '98.8255', '23.76241');
INSERT INTO `shop_truck_region` VALUES (2747, 2741, 'S', '双江', '双江拉祜族佤族布朗族傣族自治县', 3, 'shuangjiang', '677300', 1, '99.82769', '23.47349');
INSERT INTO `shop_truck_region` VALUES (2748, 2741, 'G', '耿马', '耿马傣族佤族自治县', 3, 'gengma', '677500', 1, '99.39785', '23.53776');
INSERT INTO `shop_truck_region` VALUES (2749, 2741, 'C', '沧源', '沧源佤族自治县', 3, 'cangyuan', '677400', 1, '99.24545', '23.14821');
INSERT INTO `shop_truck_region` VALUES (2750, 2670, 'C', '楚雄', '楚雄彝族自治州', 2, 'chuxiong', '675000', 1, '101.546046', '25.041988');
INSERT INTO `shop_truck_region` VALUES (2751, 2750, 'C', '楚雄', '楚雄市', 3, 'chuxiong', '675000', 1, '101.54615', '25.0329');
INSERT INTO `shop_truck_region` VALUES (2752, 2750, 'S', '双柏', '双柏县', 3, 'shuangbai', '675100', 1, '101.64205', '24.68882');
INSERT INTO `shop_truck_region` VALUES (2753, 2750, 'M', '牟定', '牟定县', 3, 'mouding', '675500', 1, '101.54', '25.31551');
INSERT INTO `shop_truck_region` VALUES (2754, 2750, 'N', '南华', '南华县', 3, 'nanhua', '675200', 1, '101.27313', '25.19293');
INSERT INTO `shop_truck_region` VALUES (2755, 2750, 'Y', '姚安', '姚安县', 3, 'yaoan', '675300', 1, '101.24279', '25.50467');
INSERT INTO `shop_truck_region` VALUES (2756, 2750, 'D', '大姚', '大姚县', 3, 'dayao', '675400', 1, '101.32397', '25.72218');
INSERT INTO `shop_truck_region` VALUES (2757, 2750, 'Y', '永仁', '永仁县', 3, 'yongren', '651400', 1, '101.6716', '26.05794');
INSERT INTO `shop_truck_region` VALUES (2758, 2750, 'Y', '元谋', '元谋县', 3, 'yuanmou', '651300', 1, '101.87728', '25.70438');
INSERT INTO `shop_truck_region` VALUES (2759, 2750, 'W', '武定', '武定县', 3, 'wuding', '651600', 1, '102.4038', '25.5295');
INSERT INTO `shop_truck_region` VALUES (2760, 2750, 'L', '禄丰', '禄丰县', 3, 'lufeng', '651200', 1, '102.07797', '25.14815');
INSERT INTO `shop_truck_region` VALUES (2761, 2670, 'H', '红河', '红河哈尼族彝族自治州', 2, 'honghe', '661400', 1, '103.384182', '23.366775');
INSERT INTO `shop_truck_region` VALUES (2762, 2761, 'G', '个旧', '个旧市', 3, 'gejiu', '661000', 1, '103.15966', '23.35894');
INSERT INTO `shop_truck_region` VALUES (2763, 2761, 'K', '开远', '开远市', 3, 'kaiyuan', '661600', 1, '103.26986', '23.71012');
INSERT INTO `shop_truck_region` VALUES (2764, 2761, 'M', '蒙自', '蒙自市', 3, 'mengzi', '661101', 1, '103.385005', '23.366843');
INSERT INTO `shop_truck_region` VALUES (2765, 2761, 'M', '弥勒', '弥勒市', 3, 'mile', '652300', 1, '103.436988', '24.40837');
INSERT INTO `shop_truck_region` VALUES (2766, 2761, 'P', '屏边', '屏边苗族自治县', 3, 'pingbian', '661200', 1, '103.68554', '22.98425');
INSERT INTO `shop_truck_region` VALUES (2767, 2761, 'J', '建水', '建水县', 3, 'jianshui', '654300', 1, '102.82656', '23.63472');
INSERT INTO `shop_truck_region` VALUES (2768, 2761, 'S', '石屏', '石屏县', 3, 'shiping', '662200', 1, '102.49408', '23.71441');
INSERT INTO `shop_truck_region` VALUES (2769, 2761, NULL, '泸西', '泸西县', 3, 'luxi', '652400', 1, '103.76373', '24.52854');
INSERT INTO `shop_truck_region` VALUES (2770, 2761, 'Y', '元阳', '元阳县', 3, 'yuanyang', '662400', 1, '102.83261', '23.22281');
INSERT INTO `shop_truck_region` VALUES (2771, 2761, 'H', '红河县', '红河县', 3, 'honghexian', '654400', 1, '102.42059', '23.36767');
INSERT INTO `shop_truck_region` VALUES (2772, 2761, 'J', '金平', '金平苗族瑶族傣族自治县', 3, 'jinping', '661500', 1, '103.22651', '22.77959');
INSERT INTO `shop_truck_region` VALUES (2773, 2761, 'L', '绿春', '绿春县', 3, 'lvchun', '662500', 1, '102.39672', '22.99371');
INSERT INTO `shop_truck_region` VALUES (2774, 2761, 'H', '河口', '河口瑶族自治县', 3, 'hekou', '661300', 1, '103.93936', '22.52929');
INSERT INTO `shop_truck_region` VALUES (2775, 2670, 'W', '文山', '文山壮族苗族自治州', 2, 'wenshan', '663000', 1, '104.24401', '23.36951');
INSERT INTO `shop_truck_region` VALUES (2776, 2775, 'W', '文山', '文山市', 3, 'wenshan', '663000', 1, '104.244277', '23.369216');
INSERT INTO `shop_truck_region` VALUES (2777, 2775, 'Y', '砚山', '砚山县', 3, 'yanshan', '663100', 1, '104.33306', '23.60723');
INSERT INTO `shop_truck_region` VALUES (2778, 2775, 'X', '西畴', '西畴县', 3, 'xichou', '663500', 1, '104.67419', '23.43941');
INSERT INTO `shop_truck_region` VALUES (2779, 2775, 'M', '麻栗坡', '麻栗坡县', 3, 'malipo', '663600', 1, '104.70132', '23.12028');
INSERT INTO `shop_truck_region` VALUES (2780, 2775, 'M', '马关', '马关县', 3, 'maguan', '663700', 1, '104.39514', '23.01293');
INSERT INTO `shop_truck_region` VALUES (2781, 2775, 'Q', '丘北', '丘北县', 3, 'qiubei', '663200', 1, '104.19256', '24.03957');
INSERT INTO `shop_truck_region` VALUES (2782, 2775, 'G', '广南', '广南县', 3, 'guangnan', '663300', 1, '105.05511', '24.0464');
INSERT INTO `shop_truck_region` VALUES (2783, 2775, 'F', '富宁', '富宁县', 3, 'funing', '663400', 1, '105.63085', '23.62536');
INSERT INTO `shop_truck_region` VALUES (2784, 2670, 'X', '西双版纳', '西双版纳傣族自治州', 2, 'xishuangbanna', '666100', 1, '100.797941', '22.001724');
INSERT INTO `shop_truck_region` VALUES (2785, 2784, 'J', '景洪', '景洪市', 3, 'jinghong', '666100', 1, '100.79977', '22.01071');
INSERT INTO `shop_truck_region` VALUES (2786, 2784, NULL, '勐海', '勐海县', 3, 'menghai', '666200', 1, '100.44931', '21.96175');
INSERT INTO `shop_truck_region` VALUES (2787, 2784, NULL, '勐腊', '勐腊县', 3, 'mengla', '666300', 1, '101.56488', '21.48162');
INSERT INTO `shop_truck_region` VALUES (2788, 2670, 'D', '大理', '大理白族自治州', 2, 'dali', '671000', 1, '100.240037', '25.592765');
INSERT INTO `shop_truck_region` VALUES (2789, 2788, 'D', '大理', '大理市', 3, 'dali', '671000', 1, '100.22998', '25.59157');
INSERT INTO `shop_truck_region` VALUES (2790, 2788, 'Y', '漾濞', '漾濞彝族自治县', 3, 'yangbi', '672500', 1, '99.95474', '25.6652');
INSERT INTO `shop_truck_region` VALUES (2791, 2788, 'X', '祥云', '祥云县', 3, 'xiangyun', '672100', 1, '100.55761', '25.47342');
INSERT INTO `shop_truck_region` VALUES (2792, 2788, 'B', '宾川', '宾川县', 3, 'binchuan', '671600', 1, '100.57666', '25.83144');
INSERT INTO `shop_truck_region` VALUES (2793, 2788, 'M', '弥渡', '弥渡县', 3, 'midu', '675600', 1, '100.49075', '25.34179');
INSERT INTO `shop_truck_region` VALUES (2794, 2788, 'N', '南涧', '南涧彝族自治县', 3, 'nanjian', '675700', 1, '100.50964', '25.04349');
INSERT INTO `shop_truck_region` VALUES (2795, 2788, 'W', '巍山', '巍山彝族回族自治县', 3, 'weishan', '672400', 1, '100.30612', '25.23197');
INSERT INTO `shop_truck_region` VALUES (2796, 2788, 'Y', '永平', '永平县', 3, 'yongping', '672600', 1, '99.54095', '25.46451');
INSERT INTO `shop_truck_region` VALUES (2797, 2788, 'Y', '云龙', '云龙县', 3, 'yunlong', '672700', 1, '99.37255', '25.88505');
INSERT INTO `shop_truck_region` VALUES (2798, 2788, 'E', '洱源', '洱源县', 3, 'eryuan', '671200', 1, '99.94903', '26.10829');
INSERT INTO `shop_truck_region` VALUES (2799, 2788, 'J', '剑川', '剑川县', 3, 'jianchuan', '671300', 1, '99.90545', '26.53688');
INSERT INTO `shop_truck_region` VALUES (2800, 2788, 'H', '鹤庆', '鹤庆县', 3, 'heqing', '671500', 1, '100.17697', '26.55798');
INSERT INTO `shop_truck_region` VALUES (2801, 2670, 'D', '德宏', '德宏傣族景颇族自治州', 2, 'dehong', '678400', 1, '98.578363', '24.436694');
INSERT INTO `shop_truck_region` VALUES (2802, 2801, 'R', '瑞丽', '瑞丽市', 3, 'ruili', '678600', 1, '97.85183', '24.01277');
INSERT INTO `shop_truck_region` VALUES (2803, 2801, 'M', '芒市', '芒市', 3, 'mangshi', '678400', 1, '98.588641', '24.433735');
INSERT INTO `shop_truck_region` VALUES (2804, 2801, 'L', '梁河', '梁河县', 3, 'lianghe', '679200', 1, '98.29705', '24.80658');
INSERT INTO `shop_truck_region` VALUES (2805, 2801, 'Y', '盈江', '盈江县', 3, 'yingjiang', '679300', 1, '97.93179', '24.70579');
INSERT INTO `shop_truck_region` VALUES (2806, 2801, 'L', '陇川', '陇川县', 3, 'longchuan', '678700', 1, '97.79199', '24.18302');
INSERT INTO `shop_truck_region` VALUES (2807, 2670, 'N', '怒江', '怒江傈僳族自治州', 2, 'nujiang', '673100', 1, '98.854304', '25.850949');
INSERT INTO `shop_truck_region` VALUES (2808, 2807, NULL, '泸水', '泸水县', 3, 'lushui', '673100', 1, '98.85534', '25.83772');
INSERT INTO `shop_truck_region` VALUES (2809, 2807, 'F', '福贡', '福贡县', 3, 'fugong', '673400', 1, '98.86969', '26.90366');
INSERT INTO `shop_truck_region` VALUES (2810, 2807, 'G', '贡山', '贡山独龙族怒族自治县', 3, 'gongshan', '673500', 1, '98.66583', '27.74088');
INSERT INTO `shop_truck_region` VALUES (2811, 2807, 'L', '兰坪', '兰坪白族普米族自治县', 3, 'lanping', '671400', 1, '99.41891', '26.45251');
INSERT INTO `shop_truck_region` VALUES (2812, 2670, 'D', '迪庆', '迪庆藏族自治州', 2, 'deqen', '674400', 1, '99.706463', '27.826853');
INSERT INTO `shop_truck_region` VALUES (2813, 2812, 'X', '香格里拉', '香格里拉市', 3, 'xianggelila', '674400', 1, '99.70601', '27.82308');
INSERT INTO `shop_truck_region` VALUES (2814, 2812, 'D', '德钦', '德钦县', 3, 'deqin', '674500', 1, '98.91082', '28.4863');
INSERT INTO `shop_truck_region` VALUES (2815, 2812, 'W', '维西', '维西傈僳族自治县', 3, 'weixi', '674600', 1, '99.28402', '27.1793');
INSERT INTO `shop_truck_region` VALUES (2816, 0, 'X', '西藏', '西藏自治区', 1, 'tibet', '', 1, '91.132212', '29.660361');
INSERT INTO `shop_truck_region` VALUES (2817, 2816, 'L', '拉萨', '拉萨市', 2, 'lhasa', '850000', 1, '91.132212', '29.660361');
INSERT INTO `shop_truck_region` VALUES (2818, 2817, 'C', '城关', '城关区', 3, 'chengguan', '850000', 1, '91.13859', '29.65312');
INSERT INTO `shop_truck_region` VALUES (2819, 2817, 'L', '林周', '林周县', 3, 'linzhou', '851600', 1, '91.2586', '29.89445');
INSERT INTO `shop_truck_region` VALUES (2820, 2817, 'D', '当雄', '当雄县', 3, 'dangxiong', '851500', 1, '91.10076', '30.48309');
INSERT INTO `shop_truck_region` VALUES (2821, 2817, 'N', '尼木', '尼木县', 3, 'nimu', '851300', 1, '90.16378', '29.43353');
INSERT INTO `shop_truck_region` VALUES (2822, 2817, 'Q', '曲水', '曲水县', 3, 'qushui', '850600', 1, '90.73187', '29.35636');
INSERT INTO `shop_truck_region` VALUES (2823, 2817, 'D', '堆龙德庆', '堆龙德庆县', 3, 'duilongdeqing', '851400', 1, '91.00033', '29.65002');
INSERT INTO `shop_truck_region` VALUES (2824, 2817, 'D', '达孜', '达孜县', 3, 'dazi', '850100', 1, '91.35757', '29.6722');
INSERT INTO `shop_truck_region` VALUES (2825, 2817, 'M', '墨竹工卡', '墨竹工卡县', 3, 'mozhugongka', '850200', 1, '91.72814', '29.83614');
INSERT INTO `shop_truck_region` VALUES (2826, 2816, 'R', '日喀则', '日喀则市', 2, 'rikaze', '857000', 1, '88.884874', '29.263792');
INSERT INTO `shop_truck_region` VALUES (2827, 2826, 'S', '桑珠孜', '桑珠孜区', 3, 'sangzhuzi', '857000', 1, '88.880367', '29.269565');
INSERT INTO `shop_truck_region` VALUES (2828, 2826, 'N', '南木林', '南木林县', 3, 'nanmulin', '857100', 1, '89.09686', '29.68206');
INSERT INTO `shop_truck_region` VALUES (2829, 2826, 'J', '江孜', '江孜县', 3, 'jiangzi', '857400', 1, '89.60263', '28.91744');
INSERT INTO `shop_truck_region` VALUES (2830, 2826, 'D', '定日', '定日县', 3, 'dingri', '858200', 1, '87.12176', '28.66129');
INSERT INTO `shop_truck_region` VALUES (2831, 2826, 'S', '萨迦', '萨迦县', 3, 'sajia', '857800', 1, '88.02191', '28.90299');
INSERT INTO `shop_truck_region` VALUES (2832, 2826, 'L', '拉孜', '拉孜县', 3, 'lazi', '858100', 1, '87.63412', '29.085');
INSERT INTO `shop_truck_region` VALUES (2833, 2826, 'A', '昂仁', '昂仁县', 3, 'angren', '858500', 1, '87.23858', '29.29496');
INSERT INTO `shop_truck_region` VALUES (2834, 2826, 'X', '谢通门', '谢通门县', 3, 'xietongmen', '858900', 1, '88.26242', '29.43337');
INSERT INTO `shop_truck_region` VALUES (2835, 2826, 'B', '白朗', '白朗县', 3, 'bailang', '857300', 1, '89.26205', '29.10553');
INSERT INTO `shop_truck_region` VALUES (2836, 2826, 'R', '仁布', '仁布县', 3, 'renbu', '857200', 1, '89.84228', '29.2301');
INSERT INTO `shop_truck_region` VALUES (2837, 2826, 'K', '康马', '康马县', 3, 'kangma', '857500', 1, '89.68527', '28.5567');
INSERT INTO `shop_truck_region` VALUES (2838, 2826, 'D', '定结', '定结县', 3, 'dingjie', '857900', 1, '87.77255', '28.36403');
INSERT INTO `shop_truck_region` VALUES (2839, 2826, 'Z', '仲巴', '仲巴县', 3, 'zhongba', '858800', 1, '84.02951', '29.76595');
INSERT INTO `shop_truck_region` VALUES (2840, 2826, 'Y', '亚东', '亚东县', 3, 'yadong', '857600', 1, '88.90802', '27.4839');
INSERT INTO `shop_truck_region` VALUES (2841, 2826, 'J', '吉隆', '吉隆县', 3, 'jilong', '858700', 1, '85.29846', '28.85382');
INSERT INTO `shop_truck_region` VALUES (2842, 2826, 'N', '聂拉木', '聂拉木县', 3, 'nielamu', '858300', 1, '85.97998', '28.15645');
INSERT INTO `shop_truck_region` VALUES (2843, 2826, 'S', '萨嘎', '萨嘎县', 3, 'saga', '857800', 1, '85.23413', '29.32936');
INSERT INTO `shop_truck_region` VALUES (2844, 2826, 'G', '岗巴', '岗巴县', 3, 'gangba', '857700', 1, '88.52069', '28.27504');
INSERT INTO `shop_truck_region` VALUES (2845, 2816, 'C', '昌都', '昌都市', 2, 'qamdo', '854000', 1, '97.178452', '31.136875');
INSERT INTO `shop_truck_region` VALUES (2846, 2845, 'K', '昌都', '卡若区', 3, 'karuo', '854000', 1, '97.18043', '31.1385');
INSERT INTO `shop_truck_region` VALUES (2847, 2845, 'J', '江达', '江达县', 3, 'jiangda', '854100', 1, '98.21865', '31.50343');
INSERT INTO `shop_truck_region` VALUES (2848, 2845, 'G', '贡觉', '贡觉县', 3, 'gongjue', '854200', 1, '98.27163', '30.85941');
INSERT INTO `shop_truck_region` VALUES (2849, 2845, 'L', '类乌齐', '类乌齐县', 3, 'leiwuqi', '855600', 1, '96.60015', '31.21207');
INSERT INTO `shop_truck_region` VALUES (2850, 2845, 'D', '丁青', '丁青县', 3, 'dingqing', '855700', 1, '95.59362', '31.41621');
INSERT INTO `shop_truck_region` VALUES (2851, 2845, 'C', '察雅', '察雅县', 3, 'chaya', '854300', 1, '97.56521', '30.65336');
INSERT INTO `shop_truck_region` VALUES (2852, 2845, 'B', '八宿', '八宿县', 3, 'basu', '854600', 1, '96.9176', '30.05346');
INSERT INTO `shop_truck_region` VALUES (2853, 2845, 'Z', '左贡', '左贡县', 3, 'zuogong', '854400', 1, '97.84429', '29.67108');
INSERT INTO `shop_truck_region` VALUES (2854, 2845, 'M', '芒康', '芒康县', 3, 'mangkang', '854500', 1, '98.59378', '29.67946');
INSERT INTO `shop_truck_region` VALUES (2855, 2845, 'L', '洛隆', '洛隆县', 3, 'luolong', '855400', 1, '95.82644', '30.74049');
INSERT INTO `shop_truck_region` VALUES (2856, 2845, 'B', '边坝', '边坝县', 3, 'bianba', '855500', 1, '94.70687', '30.93434');
INSERT INTO `shop_truck_region` VALUES (2857, 2816, 'S', '山南', '山南地区', 2, 'shannan', '856000', 1, '91.766529', '29.236023');
INSERT INTO `shop_truck_region` VALUES (2858, 2857, 'N', '乃东', '乃东县', 3, 'naidong', '856100', 1, '91.76153', '29.2249');
INSERT INTO `shop_truck_region` VALUES (2859, 2857, 'Z', '扎囊', '扎囊县', 3, 'zhanang', '850800', 1, '91.33288', '29.2399');
INSERT INTO `shop_truck_region` VALUES (2860, 2857, 'G', '贡嘎', '贡嘎县', 3, 'gongga', '850700', 1, '90.98867', '29.29408');
INSERT INTO `shop_truck_region` VALUES (2861, 2857, 'S', '桑日', '桑日县', 3, 'sangri', '856200', 1, '92.02005', '29.26643');
INSERT INTO `shop_truck_region` VALUES (2862, 2857, 'Q', '琼结', '琼结县', 3, 'qiongjie', '856800', 1, '91.68093', '29.02632');
INSERT INTO `shop_truck_region` VALUES (2863, 2857, 'Q', '曲松', '曲松县', 3, 'qusong', '856300', 1, '92.20263', '29.06412');
INSERT INTO `shop_truck_region` VALUES (2864, 2857, 'C', '措美', '措美县', 3, 'cuomei', '856900', 1, '91.43237', '28.43794');
INSERT INTO `shop_truck_region` VALUES (2865, 2857, 'L', '洛扎', '洛扎县', 3, 'luozha', '856600', 1, '90.86035', '28.3872');
INSERT INTO `shop_truck_region` VALUES (2866, 2857, 'J', '加查', '加查县', 3, 'jiacha', '856400', 1, '92.57702', '29.13973');
INSERT INTO `shop_truck_region` VALUES (2867, 2857, 'L', '隆子', '隆子县', 3, 'longzi', '856600', 1, '92.46148', '28.40797');
INSERT INTO `shop_truck_region` VALUES (2868, 2857, 'C', '错那', '错那县', 3, 'cuona', '856700', 1, '91.95752', '27.99224');
INSERT INTO `shop_truck_region` VALUES (2869, 2857, 'L', '浪卡子', '浪卡子县', 3, 'langkazi', '851100', 1, '90.40002', '28.96948');
INSERT INTO `shop_truck_region` VALUES (2870, 2816, 'N', '那曲', '那曲地区', 2, 'nagqu', '852000', 1, '92.060214', '31.476004');
INSERT INTO `shop_truck_region` VALUES (2871, 2870, 'N', '那曲', '那曲县', 3, 'naqu', '852000', 1, '92.0535', '31.46964');
INSERT INTO `shop_truck_region` VALUES (2872, 2870, 'J', '嘉黎', '嘉黎县', 3, 'jiali', '852400', 1, '93.24987', '30.64233');
INSERT INTO `shop_truck_region` VALUES (2873, 2870, 'B', '比如', '比如县', 3, 'biru', '852300', 1, '93.68685', '31.4779');
INSERT INTO `shop_truck_region` VALUES (2874, 2870, 'N', '聂荣', '聂荣县', 3, 'nierong', '853500', 1, '92.29574', '32.11193');
INSERT INTO `shop_truck_region` VALUES (2875, 2870, 'A', '安多', '安多县', 3, 'anduo', '853400', 1, '91.6795', '32.26125');
INSERT INTO `shop_truck_region` VALUES (2876, 2870, 'S', '申扎', '申扎县', 3, 'shenzha', '853100', 1, '88.70776', '30.92995');
INSERT INTO `shop_truck_region` VALUES (2877, 2870, 'S', '索县', '索县', 3, 'suoxian', '852200', 1, '93.78295', '31.88427');
INSERT INTO `shop_truck_region` VALUES (2878, 2870, 'B', '班戈', '班戈县', 3, 'bange', '852500', 1, '90.01907', '31.36149');
INSERT INTO `shop_truck_region` VALUES (2879, 2870, 'B', '巴青', '巴青县', 3, 'baqing', '852100', 1, '94.05316', '31.91833');
INSERT INTO `shop_truck_region` VALUES (2880, 2870, 'N', '尼玛', '尼玛县', 3, 'nima', '852600', 1, '87.25256', '31.79654');
INSERT INTO `shop_truck_region` VALUES (2881, 2870, 'S', '双湖', '双湖县', 3, 'shuanghu', '852600', 1, '88.837776', '33.189032');
INSERT INTO `shop_truck_region` VALUES (2882, 2816, 'A', '阿里', '阿里地区', 2, 'ngari', '859000', 1, '80.105498', '32.503187');
INSERT INTO `shop_truck_region` VALUES (2883, 2882, 'P', '普兰', '普兰县', 3, 'pulan', '859500', 1, '81.177', '30.30002');
INSERT INTO `shop_truck_region` VALUES (2884, 2882, 'Z', '札达', '札达县', 3, 'zhada', '859600', 1, '79.80255', '31.48345');
INSERT INTO `shop_truck_region` VALUES (2885, 2882, 'G', '噶尔', '噶尔县', 3, 'gaer', '859400', 1, '80.09579', '32.50024');
INSERT INTO `shop_truck_region` VALUES (2886, 2882, 'R', '日土', '日土县', 3, 'ritu', '859700', 1, '79.7131', '33.38741');
INSERT INTO `shop_truck_region` VALUES (2887, 2882, 'G', '革吉', '革吉县', 3, 'geji', '859100', 1, '81.151', '32.3964');
INSERT INTO `shop_truck_region` VALUES (2888, 2882, 'G', '改则', '改则县', 3, 'gaize', '859200', 1, '84.06295', '32.30446');
INSERT INTO `shop_truck_region` VALUES (2889, 2882, 'C', '措勤', '措勤县', 3, 'cuoqin', '859300', 1, '85.16616', '31.02095');
INSERT INTO `shop_truck_region` VALUES (2890, 2816, 'L', '林芝', '林芝地区', 2, 'nyingchi', '850400', 1, '94.362348', '29.654693');
INSERT INTO `shop_truck_region` VALUES (2891, 2890, 'L', '林芝', '林芝县', 3, 'linzhi', '850400', 1, '94.48391', '29.57562');
INSERT INTO `shop_truck_region` VALUES (2892, 2890, 'G', '工布江达', '工布江达县', 3, 'gongbujiangda', '850300', 1, '93.2452', '29.88576');
INSERT INTO `shop_truck_region` VALUES (2893, 2890, 'M', '米林', '米林县', 3, 'milin', '850500', 1, '94.21316', '29.21535');
INSERT INTO `shop_truck_region` VALUES (2894, 2890, 'M', '墨脱', '墨脱县', 3, 'motuo', '855300', 1, '95.3316', '29.32698');
INSERT INTO `shop_truck_region` VALUES (2895, 2890, 'B', '波密', '波密县', 3, 'bomi', '855200', 1, '95.77096', '29.85907');
INSERT INTO `shop_truck_region` VALUES (2896, 2890, 'C', '察隅', '察隅县', 3, 'chayu', '855100', 1, '97.46679', '28.6618');
INSERT INTO `shop_truck_region` VALUES (2897, 2890, 'L', '朗县', '朗县', 3, 'langxian', '856500', 1, '93.0754', '29.04549');
INSERT INTO `shop_truck_region` VALUES (2898, 0, 'S', '陕西', '陕西省', 1, 'shaanxi', '', 1, '108.948024', '34.263161');
INSERT INTO `shop_truck_region` VALUES (2899, 2898, 'X', '西安', '西安市', 2, 'xian', '710003', 1, '108.948024', '34.263161');
INSERT INTO `shop_truck_region` VALUES (2900, 2899, 'X', '新城', '新城区', 3, 'xincheng', '710004', 1, '108.9608', '34.26641');
INSERT INTO `shop_truck_region` VALUES (2901, 2899, 'B', '碑林', '碑林区', 3, 'beilin', '710001', 1, '108.93426', '34.2304');
INSERT INTO `shop_truck_region` VALUES (2902, 2899, 'L', '莲湖', '莲湖区', 3, 'lianhu', '710003', 1, '108.9401', '34.26709');
INSERT INTO `shop_truck_region` VALUES (2903, 2899, NULL, '灞桥', '灞桥区', 3, 'baqiao', '710038', 1, '109.06451', '34.27264');
INSERT INTO `shop_truck_region` VALUES (2904, 2899, 'W', '未央', '未央区', 3, 'weiyang', '710014', 1, '108.94683', '34.29296');
INSERT INTO `shop_truck_region` VALUES (2905, 2899, 'Y', '雁塔', '雁塔区', 3, 'yanta', '710061', 1, '108.94866', '34.22245');
INSERT INTO `shop_truck_region` VALUES (2906, 2899, 'Y', '阎良', '阎良区', 3, 'yanliang', '710087', 1, '109.22616', '34.66221');
INSERT INTO `shop_truck_region` VALUES (2907, 2899, 'L', '临潼', '临潼区', 3, 'lintong', '710600', 1, '109.21417', '34.36665');
INSERT INTO `shop_truck_region` VALUES (2908, 2899, 'C', '长安', '长安区', 3, 'changan', '710100', 1, '108.94586', '34.15559');
INSERT INTO `shop_truck_region` VALUES (2909, 2899, 'L', '蓝田', '蓝田县', 3, 'lantian', '710500', 1, '109.32339', '34.15128');
INSERT INTO `shop_truck_region` VALUES (2910, 2899, 'Z', '周至', '周至县', 3, 'zhouzhi', '710400', 1, '108.22207', '34.16337');
INSERT INTO `shop_truck_region` VALUES (2911, 2899, 'H', '户县', '户县', 3, 'huxian', '710300', 1, '108.60513', '34.10856');
INSERT INTO `shop_truck_region` VALUES (2912, 2899, 'G', '高陵', '高陵区', 3, 'gaoling', '710200', 1, '109.08816', '34.53483');
INSERT INTO `shop_truck_region` VALUES (2913, 2898, 'T', '铜川', '铜川市', 2, 'tongchuan', '727100', 1, '108.963122', '34.90892');
INSERT INTO `shop_truck_region` VALUES (2914, 2913, 'W', '王益', '王益区', 3, 'wangyi', '727000', 1, '109.07564', '35.06896');
INSERT INTO `shop_truck_region` VALUES (2915, 2913, 'Y', '印台', '印台区', 3, 'yintai', '727007', 1, '109.10208', '35.1169');
INSERT INTO `shop_truck_region` VALUES (2916, 2913, 'Y', '耀州', '耀州区', 3, 'yaozhou', '727100', 1, '108.98556', '34.91308');
INSERT INTO `shop_truck_region` VALUES (2917, 2913, 'Y', '宜君', '宜君县', 3, 'yijun', '727200', 1, '109.11813', '35.40108');
INSERT INTO `shop_truck_region` VALUES (2918, 2898, 'B', '宝鸡', '宝鸡市', 2, 'baoji', '721000', 1, '107.14487', '34.369315');
INSERT INTO `shop_truck_region` VALUES (2919, 2918, 'W', '渭滨', '渭滨区', 3, 'weibin', '721000', 1, '107.14991', '34.37116');
INSERT INTO `shop_truck_region` VALUES (2920, 2918, 'J', '金台', '金台区', 3, 'jintai', '721000', 1, '107.14691', '34.37612');
INSERT INTO `shop_truck_region` VALUES (2921, 2918, 'C', '陈仓', '陈仓区', 3, 'chencang', '721300', 1, '107.38742', '34.35451');
INSERT INTO `shop_truck_region` VALUES (2922, 2918, 'F', '凤翔', '凤翔县', 3, 'fengxiang', '721400', 1, '107.39645', '34.52321');
INSERT INTO `shop_truck_region` VALUES (2923, 2918, NULL, '岐山', '岐山县', 3, 'qishan', '722400', 1, '107.62173', '34.44378');
INSERT INTO `shop_truck_region` VALUES (2924, 2918, 'F', '扶风', '扶风县', 3, 'fufeng', '722200', 1, '107.90017', '34.37524');
INSERT INTO `shop_truck_region` VALUES (2925, 2918, 'M', '眉县', '眉县', 3, 'meixian', '722300', 1, '107.75079', '34.27569');
INSERT INTO `shop_truck_region` VALUES (2926, 2918, 'L', '陇县', '陇县', 3, 'longxian', '721200', 1, '106.85946', '34.89404');
INSERT INTO `shop_truck_region` VALUES (2927, 2918, 'Q', '千阳', '千阳县', 3, 'qianyang', '721100', 1, '107.13043', '34.64219');
INSERT INTO `shop_truck_region` VALUES (2928, 2918, NULL, '麟游', '麟游县', 3, 'linyou', '721500', 1, '107.79623', '34.67844');
INSERT INTO `shop_truck_region` VALUES (2929, 2918, 'F', '凤县', '凤县', 3, 'fengxian', '721700', 1, '106.52356', '33.91172');
INSERT INTO `shop_truck_region` VALUES (2930, 2918, 'T', '太白', '太白县', 3, 'taibai', '721600', 1, '107.31646', '34.06207');
INSERT INTO `shop_truck_region` VALUES (2931, 2898, 'X', '咸阳', '咸阳市', 2, 'xianyang', '712000', 1, '108.705117', '34.333439');
INSERT INTO `shop_truck_region` VALUES (2932, 2931, 'Q', '秦都', '秦都区', 3, 'qindu', '712000', 1, '108.71493', '34.33804');
INSERT INTO `shop_truck_region` VALUES (2933, 2931, 'Y', '杨陵', '杨陵区', 3, 'yangling', '712100', 1, '108.083481', '34.270434');
INSERT INTO `shop_truck_region` VALUES (2934, 2931, 'W', '渭城', '渭城区', 3, 'weicheng', '712000', 1, '108.72227', '34.33198');
INSERT INTO `shop_truck_region` VALUES (2935, 2931, 'S', '三原', '三原县', 3, 'sanyuan', '713800', 1, '108.93194', '34.61556');
INSERT INTO `shop_truck_region` VALUES (2936, 2931, NULL, '泾阳', '泾阳县', 3, 'jingyang', '713700', 1, '108.84259', '34.52705');
INSERT INTO `shop_truck_region` VALUES (2937, 2931, 'Q', '乾县', '乾县', 3, 'qianxian', '713300', 1, '108.24231', '34.52946');
INSERT INTO `shop_truck_region` VALUES (2938, 2931, 'L', '礼泉', '礼泉县', 3, 'liquan', '713200', 1, '108.4263', '34.48455');
INSERT INTO `shop_truck_region` VALUES (2939, 2931, 'Y', '永寿', '永寿县', 3, 'yongshou', '713400', 1, '108.14474', '34.69081');
INSERT INTO `shop_truck_region` VALUES (2940, 2931, 'B', '彬县', '彬县', 3, 'binxian', '713500', 1, '108.08468', '35.0342');
INSERT INTO `shop_truck_region` VALUES (2941, 2931, 'C', '长武', '长武县', 3, 'changwu', '713600', 1, '107.7951', '35.2067');
INSERT INTO `shop_truck_region` VALUES (2942, 2931, 'X', '旬邑', '旬邑县', 3, 'xunyi', '711300', 1, '108.3341', '35.11338');
INSERT INTO `shop_truck_region` VALUES (2943, 2931, 'C', '淳化', '淳化县', 3, 'chunhua', '711200', 1, '108.58026', '34.79886');
INSERT INTO `shop_truck_region` VALUES (2944, 2931, 'W', '武功', '武功县', 3, 'wugong', '712200', 1, '108.20434', '34.26003');
INSERT INTO `shop_truck_region` VALUES (2945, 2931, 'X', '兴平', '兴平市', 3, 'xingping', '713100', 1, '108.49057', '34.29785');
INSERT INTO `shop_truck_region` VALUES (2946, 2898, 'W', '渭南', '渭南市', 2, 'weinan', '714000', 1, '109.502882', '34.499381');
INSERT INTO `shop_truck_region` VALUES (2947, 2946, 'L', '临渭', '临渭区', 3, 'linwei', '714000', 1, '109.49296', '34.49822');
INSERT INTO `shop_truck_region` VALUES (2948, 2946, 'H', '华县', '华县', 3, 'huaxian', '714100', 1, '109.77185', '34.51255');
INSERT INTO `shop_truck_region` VALUES (2949, 2946, NULL, '潼关', '潼关县', 3, 'tongguan', '714300', 1, '110.24362', '34.54284');
INSERT INTO `shop_truck_region` VALUES (2950, 2946, 'D', '大荔', '大荔县', 3, 'dali', '715100', 1, '109.94216', '34.79565');
INSERT INTO `shop_truck_region` VALUES (2951, 2946, 'H', '合阳', '合阳县', 3, 'heyang', '715300', 1, '110.14862', '35.23805');
INSERT INTO `shop_truck_region` VALUES (2952, 2946, 'C', '澄城', '澄城县', 3, 'chengcheng', '715200', 1, '109.93444', '35.18396');
INSERT INTO `shop_truck_region` VALUES (2953, 2946, 'P', '蒲城', '蒲城县', 3, 'pucheng', '715500', 1, '109.5903', '34.9568');
INSERT INTO `shop_truck_region` VALUES (2954, 2946, 'B', '白水', '白水县', 3, 'baishui', '715600', 1, '109.59286', '35.17863');
INSERT INTO `shop_truck_region` VALUES (2955, 2946, 'F', '富平', '富平县', 3, 'fuping', '711700', 1, '109.1802', '34.75109');
INSERT INTO `shop_truck_region` VALUES (2956, 2946, 'H', '韩城', '韩城市', 3, 'hancheng', '715400', 1, '110.44238', '35.47926');
INSERT INTO `shop_truck_region` VALUES (2957, 2946, 'H', '华阴', '华阴市', 3, 'huayin', '714200', 1, '110.08752', '34.56608');
INSERT INTO `shop_truck_region` VALUES (2958, 2898, 'Y', '延安', '延安市', 2, 'yanan', '716000', 1, '109.49081', '36.596537');
INSERT INTO `shop_truck_region` VALUES (2959, 2958, 'B', '宝塔', '宝塔区', 3, 'baota', '716000', 1, '109.49336', '36.59154');
INSERT INTO `shop_truck_region` VALUES (2960, 2958, 'Y', '延长', '延长县', 3, 'yanchang', '717100', 1, '110.01083', '36.57904');
INSERT INTO `shop_truck_region` VALUES (2961, 2958, 'Y', '延川', '延川县', 3, 'yanchuan', '717200', 1, '110.19415', '36.87817');
INSERT INTO `shop_truck_region` VALUES (2962, 2958, 'Z', '子长', '子长县', 3, 'zichang', '717300', 1, '109.67532', '37.14253');
INSERT INTO `shop_truck_region` VALUES (2963, 2958, 'A', '安塞', '安塞县', 3, 'ansai', '717400', 1, '109.32708', '36.86507');
INSERT INTO `shop_truck_region` VALUES (2964, 2958, 'Z', '志丹', '志丹县', 3, 'zhidan', '717500', 1, '108.76815', '36.82177');
INSERT INTO `shop_truck_region` VALUES (2965, 2958, 'W', '吴起', '吴起县', 3, 'wuqi', '717600', 1, '108.17611', '36.92785');
INSERT INTO `shop_truck_region` VALUES (2966, 2958, 'G', '甘泉', '甘泉县', 3, 'ganquan', '716100', 1, '109.35012', '36.27754');
INSERT INTO `shop_truck_region` VALUES (2967, 2958, 'F', '富县', '富县', 3, 'fuxian', '727500', 1, '109.37927', '35.98803');
INSERT INTO `shop_truck_region` VALUES (2968, 2958, 'L', '洛川', '洛川县', 3, 'luochuan', '727400', 1, '109.43286', '35.76076');
INSERT INTO `shop_truck_region` VALUES (2969, 2958, 'Y', '宜川', '宜川县', 3, 'yichuan', '716200', 1, '110.17196', '36.04732');
INSERT INTO `shop_truck_region` VALUES (2970, 2958, 'H', '黄龙', '黄龙县', 3, 'huanglong', '715700', 1, '109.84259', '35.58349');
INSERT INTO `shop_truck_region` VALUES (2971, 2958, 'H', '黄陵', '黄陵县', 3, 'huangling', '727300', 1, '109.26333', '35.58357');
INSERT INTO `shop_truck_region` VALUES (2972, 2898, 'H', '汉中', '汉中市', 2, 'hanzhong', '723000', 1, '107.028621', '33.077668');
INSERT INTO `shop_truck_region` VALUES (2973, 2972, 'H', '汉台', '汉台区', 3, 'hantai', '723000', 1, '107.03187', '33.06774');
INSERT INTO `shop_truck_region` VALUES (2974, 2972, 'N', '南郑', '南郑县', 3, 'nanzheng', '723100', 1, '106.94024', '33.00299');
INSERT INTO `shop_truck_region` VALUES (2975, 2972, 'C', '城固', '城固县', 3, 'chenggu', '723200', 1, '107.33367', '33.15661');
INSERT INTO `shop_truck_region` VALUES (2976, 2972, 'Y', '洋县', '洋县', 3, 'yangxian', '723300', 1, '107.54672', '33.22102');
INSERT INTO `shop_truck_region` VALUES (2977, 2972, 'X', '西乡', '西乡县', 3, 'xixiang', '723500', 1, '107.76867', '32.98411');
INSERT INTO `shop_truck_region` VALUES (2978, 2972, 'M', '勉县', '勉县', 3, 'mianxian', '724200', 1, '106.67584', '33.15273');
INSERT INTO `shop_truck_region` VALUES (2979, 2972, 'N', '宁强', '宁强县', 3, 'ningqiang', '724400', 1, '106.25958', '32.82881');
INSERT INTO `shop_truck_region` VALUES (2980, 2972, 'L', '略阳', '略阳县', 3, 'lueyang', '724300', 1, '106.15399', '33.33009');
INSERT INTO `shop_truck_region` VALUES (2981, 2972, 'Z', '镇巴', '镇巴县', 3, 'zhenba', '723600', 1, '107.89648', '32.53487');
INSERT INTO `shop_truck_region` VALUES (2982, 2972, 'L', '留坝', '留坝县', 3, 'liuba', '724100', 1, '106.92233', '33.61606');
INSERT INTO `shop_truck_region` VALUES (2983, 2972, 'F', '佛坪', '佛坪县', 3, 'foping', '723400', 1, '107.98974', '33.52496');
INSERT INTO `shop_truck_region` VALUES (2984, 2898, 'Y', '榆林', '榆林市', 2, 'yulin', '719000', 1, '109.741193', '38.290162');
INSERT INTO `shop_truck_region` VALUES (2985, 2984, 'Y', '榆阳', '榆阳区', 3, 'yuyang', '719000', 1, '109.73473', '38.27843');
INSERT INTO `shop_truck_region` VALUES (2986, 2984, 'S', '神木', '神木县', 3, 'shenmu', '719300', 1, '110.4989', '38.84234');
INSERT INTO `shop_truck_region` VALUES (2987, 2984, 'F', '府谷', '府谷县', 3, 'fugu', '719400', 1, '111.06723', '39.02805');
INSERT INTO `shop_truck_region` VALUES (2988, 2984, 'H', '横山', '横山县', 3, 'hengshan', '719100', 1, '109.29568', '37.958');
INSERT INTO `shop_truck_region` VALUES (2989, 2984, 'J', '靖边', '靖边县', 3, 'jingbian', '718500', 1, '108.79412', '37.59938');
INSERT INTO `shop_truck_region` VALUES (2990, 2984, 'D', '定边', '定边县', 3, 'dingbian', '718600', 1, '107.59793', '37.59037');
INSERT INTO `shop_truck_region` VALUES (2991, 2984, 'S', '绥德', '绥德县', 3, 'suide', '718000', 1, '110.26126', '37.49778');
INSERT INTO `shop_truck_region` VALUES (2992, 2984, 'M', '米脂', '米脂县', 3, 'mizhi', '718100', 1, '110.18417', '37.75529');
INSERT INTO `shop_truck_region` VALUES (2993, 2984, 'J', '佳县', '佳县', 3, 'jiaxian', '719200', 1, '110.49362', '38.02248');
INSERT INTO `shop_truck_region` VALUES (2994, 2984, 'W', '吴堡', '吴堡县', 3, 'wubu', '718200', 1, '110.74533', '37.45709');
INSERT INTO `shop_truck_region` VALUES (2995, 2984, 'Q', '清涧', '清涧县', 3, 'qingjian', '718300', 1, '110.12173', '37.08854');
INSERT INTO `shop_truck_region` VALUES (2996, 2984, 'Z', '子洲', '子洲县', 3, 'zizhou', '718400', 1, '110.03488', '37.61238');
INSERT INTO `shop_truck_region` VALUES (2997, 2898, 'A', '安康', '安康市', 2, 'ankang', '725000', 1, '109.029273', '32.6903');
INSERT INTO `shop_truck_region` VALUES (2998, 2997, 'H', '汉滨', '汉滨区', 3, 'hanbin', '725000', 1, '109.02683', '32.69517');
INSERT INTO `shop_truck_region` VALUES (2999, 2997, 'H', '汉阴', '汉阴县', 3, 'hanyin', '725100', 1, '108.51098', '32.89129');
INSERT INTO `shop_truck_region` VALUES (3000, 2997, 'S', '石泉', '石泉县', 3, 'shiquan', '725200', 1, '108.24755', '33.03971');
INSERT INTO `shop_truck_region` VALUES (3001, 2997, 'N', '宁陕', '宁陕县', 3, 'ningshan', '711600', 1, '108.31515', '33.31726');
INSERT INTO `shop_truck_region` VALUES (3002, 2997, 'Z', '紫阳', '紫阳县', 3, 'ziyang', '725300', 1, '108.5368', '32.52115');
INSERT INTO `shop_truck_region` VALUES (3003, 2997, NULL, '岚皋', '岚皋县', 3, 'langao', '725400', 1, '108.90289', '32.30794');
INSERT INTO `shop_truck_region` VALUES (3004, 2997, 'P', '平利', '平利县', 3, 'pingli', '725500', 1, '109.35775', '32.39111');
INSERT INTO `shop_truck_region` VALUES (3005, 2997, 'Z', '镇坪', '镇坪县', 3, 'zhenping', '725600', 1, '109.52456', '31.8833');
INSERT INTO `shop_truck_region` VALUES (3006, 2997, 'X', '旬阳', '旬阳县', 3, 'xunyang', '725700', 1, '109.3619', '32.83207');
INSERT INTO `shop_truck_region` VALUES (3007, 2997, 'B', '白河', '白河县', 3, 'baihe', '725800', 1, '110.11315', '32.80955');
INSERT INTO `shop_truck_region` VALUES (3008, 2898, 'S', '商洛', '商洛市', 2, 'shangluo', '726000', 1, '109.939776', '33.868319');
INSERT INTO `shop_truck_region` VALUES (3009, 3008, 'S', '商州', '商州区', 3, 'shangzhou', '726000', 1, '109.94126', '33.8627');
INSERT INTO `shop_truck_region` VALUES (3010, 3008, 'L', '洛南', '洛南县', 3, 'luonan', '726100', 1, '110.14645', '34.08994');
INSERT INTO `shop_truck_region` VALUES (3011, 3008, 'D', '丹凤', '丹凤县', 3, 'danfeng', '726200', 1, '110.33486', '33.69468');
INSERT INTO `shop_truck_region` VALUES (3012, 3008, 'S', '商南', '商南县', 3, 'shangnan', '726300', 1, '110.88375', '33.52581');
INSERT INTO `shop_truck_region` VALUES (3013, 3008, 'S', '山阳', '山阳县', 3, 'shanyang', '726400', 1, '109.88784', '33.52931');
INSERT INTO `shop_truck_region` VALUES (3014, 3008, 'Z', '镇安', '镇安县', 3, 'zhenan', '711500', 1, '109.15374', '33.42366');
INSERT INTO `shop_truck_region` VALUES (3015, 3008, 'Z', '柞水', '柞水县', 3, 'zhashui', '711400', 1, '109.11105', '33.6831');
INSERT INTO `shop_truck_region` VALUES (3016, 2898, 'X', '西咸', '西咸新区', 2, 'xixian', '712000', 1, '108.810654', '34.307144');
INSERT INTO `shop_truck_region` VALUES (3017, 3016, 'K', '空港', '空港新城', 3, 'konggang', '461000', 1, '108.760529', '34.440894');
INSERT INTO `shop_truck_region` VALUES (3018, 3016, NULL, '沣东', '沣东新城', 3, 'fengdong', '710000', 1, '108.82988', '34.267431');
INSERT INTO `shop_truck_region` VALUES (3019, 3016, 'Q', '秦汉', '秦汉新城', 3, 'qinhan', '712000', 1, '108.83812', '34.386513');
INSERT INTO `shop_truck_region` VALUES (3020, 3016, NULL, '沣西', '沣西新城', 3, 'fengxi', '710000', 1, '108.71215', '34.190453');
INSERT INTO `shop_truck_region` VALUES (3021, 3016, NULL, '泾河', '泾河新城', 3, 'jinghe', '713700', 1, '109.049603', '34.460587');
INSERT INTO `shop_truck_region` VALUES (3022, 0, 'G', '甘肃', '甘肃省', 1, 'gansu', '', 1, '103.823557', '36.058039');
INSERT INTO `shop_truck_region` VALUES (3023, 3022, 'L', '兰州', '兰州市', 2, 'lanzhou', '730030', 1, '103.823557', '36.058039');
INSERT INTO `shop_truck_region` VALUES (3024, 3023, 'C', '城关', '城关区', 3, 'chengguan', '730030', 1, '103.8252', '36.05725');
INSERT INTO `shop_truck_region` VALUES (3025, 3023, 'Q', '七里河', '七里河区', 3, 'qilihe', '730050', 1, '103.78564', '36.06585');
INSERT INTO `shop_truck_region` VALUES (3026, 3023, 'X', '西固', '西固区', 3, 'xigu', '730060', 1, '103.62811', '36.08858');
INSERT INTO `shop_truck_region` VALUES (3027, 3023, 'A', '安宁', '安宁区', 3, 'anning', '730070', 1, '103.7189', '36.10384');
INSERT INTO `shop_truck_region` VALUES (3028, 3023, 'H', '红古', '红古区', 3, 'honggu', '730084', 1, '102.85955', '36.34537');
INSERT INTO `shop_truck_region` VALUES (3029, 3023, 'Y', '永登', '永登县', 3, 'yongdeng', '730300', 1, '103.26055', '36.73522');
INSERT INTO `shop_truck_region` VALUES (3030, 3023, 'G', '皋兰', '皋兰县', 3, 'gaolan', '730200', 1, '103.94506', '36.33215');
INSERT INTO `shop_truck_region` VALUES (3031, 3023, 'Y', '榆中', '榆中县', 3, 'yuzhong', '730100', 1, '104.1145', '35.84415');
INSERT INTO `shop_truck_region` VALUES (3032, 3022, 'J', '嘉峪关', '嘉峪关市', 2, 'jiayuguan', '735100', 1, '98.277304', '39.786529');
INSERT INTO `shop_truck_region` VALUES (3033, 3032, 'X', '雄关', '雄关区', 3, 'xiongguan', '735100', 1, '98.277398', '39.77925');
INSERT INTO `shop_truck_region` VALUES (3034, 3032, 'C', '长城', '长城区', 3, 'changcheng', '735106', 1, '98.273523', '39.787431');
INSERT INTO `shop_truck_region` VALUES (3035, 3032, 'J', '镜铁', '镜铁区', 3, 'jingtie', '735100', 1, '98.277304', '39.786529');
INSERT INTO `shop_truck_region` VALUES (3036, 3022, 'J', '金昌', '金昌市', 2, 'jinchang', '737100', 1, '102.187888', '38.514238');
INSERT INTO `shop_truck_region` VALUES (3037, 3036, 'J', '金川', '金川区', 3, 'jinchuan', '737100', 1, '102.19376', '38.52101');
INSERT INTO `shop_truck_region` VALUES (3038, 3036, 'Y', '永昌', '永昌县', 3, 'yongchang', '737200', 1, '101.97222', '38.24711');
INSERT INTO `shop_truck_region` VALUES (3039, 3022, 'B', '白银', '白银市', 2, 'baiyin', '730900', 1, '104.173606', '36.54568');
INSERT INTO `shop_truck_region` VALUES (3040, 3039, 'B', '白银', '白银区', 3, 'baiyin', '730900', 1, '104.17355', '36.54411');
INSERT INTO `shop_truck_region` VALUES (3041, 3039, 'P', '平川', '平川区', 3, 'pingchuan', '730913', 1, '104.82498', '36.7277');
INSERT INTO `shop_truck_region` VALUES (3042, 3039, 'J', '靖远', '靖远县', 3, 'jingyuan', '730600', 1, '104.68325', '36.56602');
INSERT INTO `shop_truck_region` VALUES (3043, 3039, 'H', '会宁', '会宁县', 3, 'huining', '730700', 1, '105.05297', '35.69626');
INSERT INTO `shop_truck_region` VALUES (3044, 3039, 'J', '景泰', '景泰县', 3, 'jingtai', '730400', 1, '104.06295', '37.18359');
INSERT INTO `shop_truck_region` VALUES (3045, 3022, 'T', '天水', '天水市', 2, 'tianshui', '741000', 1, '105.724998', '34.578529');
INSERT INTO `shop_truck_region` VALUES (3046, 3045, 'Q', '秦州', '秦州区', 3, 'qinzhou', '741000', 1, '105.72421', '34.58089');
INSERT INTO `shop_truck_region` VALUES (3047, 3045, 'M', '麦积', '麦积区', 3, 'maiji', '741020', 1, '105.89013', '34.57069');
INSERT INTO `shop_truck_region` VALUES (3048, 3045, 'Q', '清水', '清水县', 3, 'qingshui', '741400', 1, '106.13671', '34.75032');
INSERT INTO `shop_truck_region` VALUES (3049, 3045, 'Q', '秦安', '秦安县', 3, 'qinan', '741600', 1, '105.66955', '34.85894');
INSERT INTO `shop_truck_region` VALUES (3050, 3045, 'G', '甘谷', '甘谷县', 3, 'gangu', '741200', 1, '105.33291', '34.73665');
INSERT INTO `shop_truck_region` VALUES (3051, 3045, 'W', '武山', '武山县', 3, 'wushan', '741300', 1, '104.88382', '34.72123');
INSERT INTO `shop_truck_region` VALUES (3052, 3045, 'Z', '张家川', '张家川回族自治县', 3, 'zhangjiachuan', '741500', 1, '106.21582', '34.99582');
INSERT INTO `shop_truck_region` VALUES (3053, 3022, 'W', '武威', '武威市', 2, 'wuwei', '733000', 1, '102.634697', '37.929996');
INSERT INTO `shop_truck_region` VALUES (3054, 3053, 'L', '凉州', '凉州区', 3, 'liangzhou', '733000', 1, '102.64203', '37.92832');
INSERT INTO `shop_truck_region` VALUES (3055, 3053, 'M', '民勤', '民勤县', 3, 'minqin', '733300', 1, '103.09011', '38.62487');
INSERT INTO `shop_truck_region` VALUES (3056, 3053, 'G', '古浪', '古浪县', 3, 'gulang', '733100', 1, '102.89154', '37.46508');
INSERT INTO `shop_truck_region` VALUES (3057, 3053, 'T', '天祝', '天祝藏族自治县', 3, 'tianzhu', '733200', 1, '103.1361', '36.97715');
INSERT INTO `shop_truck_region` VALUES (3058, 3022, 'Z', '张掖', '张掖市', 2, 'zhangye', '734000', 1, '100.455472', '38.932897');
INSERT INTO `shop_truck_region` VALUES (3059, 3058, 'G', '甘州', '甘州区', 3, 'ganzhou', '734000', 1, '100.4527', '38.92947');
INSERT INTO `shop_truck_region` VALUES (3060, 3058, 'S', '肃南', '肃南裕固族自治县', 3, 'sunan', '734400', 1, '99.61407', '38.83776');
INSERT INTO `shop_truck_region` VALUES (3061, 3058, 'M', '民乐', '民乐县', 3, 'minle', '734500', 1, '100.81091', '38.43479');
INSERT INTO `shop_truck_region` VALUES (3062, 3058, 'L', '临泽', '临泽县', 3, 'linze', '734200', 1, '100.16445', '39.15252');
INSERT INTO `shop_truck_region` VALUES (3063, 3058, 'G', '高台', '高台县', 3, 'gaotai', '734300', 1, '99.81918', '39.37829');
INSERT INTO `shop_truck_region` VALUES (3064, 3058, 'S', '山丹', '山丹县', 3, 'shandan', '734100', 1, '101.09359', '38.78468');
INSERT INTO `shop_truck_region` VALUES (3065, 3022, 'P', '平凉', '平凉市', 2, 'pingliang', '744000', 1, '106.684691', '35.54279');
INSERT INTO `shop_truck_region` VALUES (3066, 3065, NULL, '崆峒', '崆峒区', 3, 'kongtong', '744000', 1, '106.67483', '35.54262');
INSERT INTO `shop_truck_region` VALUES (3067, 3065, NULL, '泾川', '泾川县', 3, 'jingchuan', '744300', 1, '107.36581', '35.33223');
INSERT INTO `shop_truck_region` VALUES (3068, 3065, 'L', '灵台', '灵台县', 3, 'lingtai', '744400', 1, '107.6174', '35.06768');
INSERT INTO `shop_truck_region` VALUES (3069, 3065, 'C', '崇信', '崇信县', 3, 'chongxin', '744200', 1, '107.03738', '35.30344');
INSERT INTO `shop_truck_region` VALUES (3070, 3065, 'H', '华亭', '华亭县', 3, 'huating', '744100', 1, '106.65463', '35.2183');
INSERT INTO `shop_truck_region` VALUES (3071, 3065, 'Z', '庄浪', '庄浪县', 3, 'zhuanglang', '744600', 1, '106.03662', '35.20235');
INSERT INTO `shop_truck_region` VALUES (3072, 3065, 'J', '静宁', '静宁县', 3, 'jingning', '743400', 1, '105.72723', '35.51991');
INSERT INTO `shop_truck_region` VALUES (3073, 3022, 'J', '酒泉', '酒泉市', 2, 'jiuquan', '735000', 1, '98.510795', '39.744023');
INSERT INTO `shop_truck_region` VALUES (3074, 3073, 'S', '肃州', '肃州区', 3, 'suzhou', '735000', 1, '98.50775', '39.74506');
INSERT INTO `shop_truck_region` VALUES (3075, 3073, 'J', '金塔', '金塔县', 3, 'jinta', '735300', 1, '98.90002', '39.97733');
INSERT INTO `shop_truck_region` VALUES (3076, 3073, 'G', '瓜州', '瓜州县', 3, 'guazhou', '736100', 1, '95.78271', '40.51548');
INSERT INTO `shop_truck_region` VALUES (3077, 3073, 'S', '肃北', '肃北蒙古族自治县', 3, 'subei', '736300', 1, '94.87649', '39.51214');
INSERT INTO `shop_truck_region` VALUES (3078, 3073, 'A', '阿克塞', '阿克塞哈萨克族自治县', 3, 'akesai', '736400', 1, '94.34097', '39.63435');
INSERT INTO `shop_truck_region` VALUES (3079, 3073, 'Y', '玉门', '玉门市', 3, 'yumen', '735200', 1, '97.04538', '40.29172');
INSERT INTO `shop_truck_region` VALUES (3080, 3073, 'D', '敦煌', '敦煌市', 3, 'dunhuang', '736200', 1, '94.66159', '40.14211');
INSERT INTO `shop_truck_region` VALUES (3081, 3022, 'Q', '庆阳', '庆阳市', 2, 'qingyang', '745000', 1, '107.638372', '35.734218');
INSERT INTO `shop_truck_region` VALUES (3082, 3081, 'X', '西峰', '西峰区', 3, 'xifeng', '745000', 1, '107.65107', '35.73065');
INSERT INTO `shop_truck_region` VALUES (3083, 3081, 'Q', '庆城', '庆城县', 3, 'qingcheng', '745100', 1, '107.88272', '36.01507');
INSERT INTO `shop_truck_region` VALUES (3084, 3081, 'H', '环县', '环县', 3, 'huanxian', '745700', 1, '107.30835', '36.56846');
INSERT INTO `shop_truck_region` VALUES (3085, 3081, 'H', '华池', '华池县', 3, 'huachi', '745600', 1, '107.9891', '36.46108');
INSERT INTO `shop_truck_region` VALUES (3086, 3081, 'H', '合水', '合水县', 3, 'heshui', '745400', 1, '108.02032', '35.81911');
INSERT INTO `shop_truck_region` VALUES (3087, 3081, 'Z', '正宁', '正宁县', 3, 'zhengning', '745300', 1, '108.36007', '35.49174');
INSERT INTO `shop_truck_region` VALUES (3088, 3081, 'N', '宁县', '宁县', 3, 'ningxian', '745200', 1, '107.92517', '35.50164');
INSERT INTO `shop_truck_region` VALUES (3089, 3081, 'Z', '镇原', '镇原县', 3, 'zhenyuan', '744500', 1, '107.199', '35.67712');
INSERT INTO `shop_truck_region` VALUES (3090, 3022, 'D', '定西', '定西市', 2, 'dingxi', '743000', 1, '104.626294', '35.579578');
INSERT INTO `shop_truck_region` VALUES (3091, 3090, 'A', '安定', '安定区', 3, 'anding', '743000', 1, '104.6106', '35.58066');
INSERT INTO `shop_truck_region` VALUES (3092, 3090, 'T', '通渭', '通渭县', 3, 'tongwei', '743300', 1, '105.24224', '35.21101');
INSERT INTO `shop_truck_region` VALUES (3093, 3090, 'L', '陇西', '陇西县', 3, 'longxi', '748100', 1, '104.63446', '35.00238');
INSERT INTO `shop_truck_region` VALUES (3094, 3090, 'W', '渭源', '渭源县', 3, 'weiyuan', '748200', 1, '104.21435', '35.13649');
INSERT INTO `shop_truck_region` VALUES (3095, 3090, 'L', '临洮', '临洮县', 3, 'lintao', '730500', 1, '103.86196', '35.3751');
INSERT INTO `shop_truck_region` VALUES (3096, 3090, 'Z', '漳县', '漳县', 3, 'zhangxian', '748300', 1, '104.46704', '34.84977');
INSERT INTO `shop_truck_region` VALUES (3097, 3090, NULL, '岷县', '岷县', 3, 'minxian', '748400', 1, '104.03772', '34.43444');
INSERT INTO `shop_truck_region` VALUES (3098, 3022, 'L', '陇南', '陇南市', 2, 'longnan', '746000', 1, '104.929379', '33.388598');
INSERT INTO `shop_truck_region` VALUES (3099, 3098, 'W', '武都', '武都区', 3, 'wudu', '746000', 1, '104.92652', '33.39239');
INSERT INTO `shop_truck_region` VALUES (3100, 3098, 'C', '成县', '成县', 3, 'chengxian', '742500', 1, '105.72586', '33.73925');
INSERT INTO `shop_truck_region` VALUES (3101, 3098, 'W', '文县', '文县', 3, 'wenxian', '746400', 1, '104.68362', '32.94337');
INSERT INTO `shop_truck_region` VALUES (3102, 3098, NULL, '宕昌', '宕昌县', 3, 'dangchang', '748500', 1, '104.39349', '34.04732');
INSERT INTO `shop_truck_region` VALUES (3103, 3098, 'K', '康县', '康县', 3, 'kangxian', '746500', 1, '105.60711', '33.32912');
INSERT INTO `shop_truck_region` VALUES (3104, 3098, 'X', '西和', '西和县', 3, 'xihe', '742100', 1, '105.30099', '34.01432');
INSERT INTO `shop_truck_region` VALUES (3105, 3098, 'L', '礼县', '礼县', 3, 'lixian', '742200', 1, '105.17785', '34.18935');
INSERT INTO `shop_truck_region` VALUES (3106, 3098, 'H', '徽县', '徽县', 3, 'huixian', '742300', 1, '106.08529', '33.76898');
INSERT INTO `shop_truck_region` VALUES (3107, 3098, 'L', '两当', '两当县', 3, 'liangdang', '742400', 1, '106.30484', '33.9096');
INSERT INTO `shop_truck_region` VALUES (3108, 3022, 'L', '临夏', '临夏回族自治州', 2, 'linxia', '731100', 1, '103.212006', '35.599446');
INSERT INTO `shop_truck_region` VALUES (3109, 3108, 'L', '临夏', '临夏市', 3, 'linxia', '731100', 1, '103.21', '35.59916');
INSERT INTO `shop_truck_region` VALUES (3110, 3108, 'L', '临夏', '临夏县', 3, 'linxia', '731800', 1, '102.9938', '35.49519');
INSERT INTO `shop_truck_region` VALUES (3111, 3108, 'K', '康乐', '康乐县', 3, 'kangle', '731500', 1, '103.71093', '35.37219');
INSERT INTO `shop_truck_region` VALUES (3112, 3108, 'Y', '永靖', '永靖县', 3, 'yongjing', '731600', 1, '103.32043', '35.93835');
INSERT INTO `shop_truck_region` VALUES (3113, 3108, 'G', '广河', '广河县', 3, 'guanghe', '731300', 1, '103.56933', '35.48097');
INSERT INTO `shop_truck_region` VALUES (3114, 3108, 'H', '和政', '和政县', 3, 'hezheng', '731200', 1, '103.34936', '35.42592');
INSERT INTO `shop_truck_region` VALUES (3115, 3108, 'D', '东乡族', '东乡族自治县', 3, 'dongxiangzu', '731400', 1, '103.39477', '35.66471');
INSERT INTO `shop_truck_region` VALUES (3116, 3108, 'J', '积石山', '积石山保安族东乡族撒拉族自治县', 3, 'jishishan', '731700', 1, '102.87374', '35.7182');
INSERT INTO `shop_truck_region` VALUES (3117, 3022, 'G', '甘南', '甘南藏族自治州', 2, 'gannan', '747000', 1, '102.911008', '34.986354');
INSERT INTO `shop_truck_region` VALUES (3118, 3117, 'H', '合作', '合作市', 3, 'hezuo', '747000', 1, '102.91082', '35.00016');
INSERT INTO `shop_truck_region` VALUES (3119, 3117, 'L', '临潭', '临潭县', 3, 'lintan', '747500', 1, '103.35287', '34.69515');
INSERT INTO `shop_truck_region` VALUES (3120, 3117, 'Z', '卓尼', '卓尼县', 3, 'zhuoni', '747600', 1, '103.50811', '34.58919');
INSERT INTO `shop_truck_region` VALUES (3121, 3117, 'Z', '舟曲', '舟曲县', 3, 'zhouqu', '746300', 1, '104.37155', '33.78468');
INSERT INTO `shop_truck_region` VALUES (3122, 3117, 'D', '迭部', '迭部县', 3, 'diebu', '747400', 1, '103.22274', '34.05623');
INSERT INTO `shop_truck_region` VALUES (3123, 3117, 'M', '玛曲', '玛曲县', 3, 'maqu', '747300', 1, '102.0754', '33.997');
INSERT INTO `shop_truck_region` VALUES (3124, 3117, 'L', '碌曲', '碌曲县', 3, 'luqu', '747200', 1, '102.49176', '34.58872');
INSERT INTO `shop_truck_region` VALUES (3125, 3117, 'X', '夏河', '夏河县', 3, 'xiahe', '747100', 1, '102.52215', '35.20487');
INSERT INTO `shop_truck_region` VALUES (3126, 0, 'Q', '青海', '青海省', 1, 'qinghai', '', 1, '101.778916', '36.623178');
INSERT INTO `shop_truck_region` VALUES (3127, 3126, 'X', '西宁', '西宁市', 2, 'xining', '810000', 1, '101.778916', '36.623178');
INSERT INTO `shop_truck_region` VALUES (3128, 3127, 'C', '城东', '城东区', 3, 'chengdong', '810007', 1, '101.80373', '36.59969');
INSERT INTO `shop_truck_region` VALUES (3129, 3127, 'C', '城中', '城中区', 3, 'chengzhong', '810000', 1, '101.78394', '36.62279');
INSERT INTO `shop_truck_region` VALUES (3130, 3127, 'C', '城西', '城西区', 3, 'chengxi', '810001', 1, '101.76588', '36.62828');
INSERT INTO `shop_truck_region` VALUES (3131, 3127, 'C', '城北', '城北区', 3, 'chengbei', '810003', 1, '101.7662', '36.65014');
INSERT INTO `shop_truck_region` VALUES (3132, 3127, 'D', '大通', '大通回族土族自治县', 3, 'datong', '810100', 1, '101.70236', '36.93489');
INSERT INTO `shop_truck_region` VALUES (3133, 3127, NULL, '湟中', '湟中县', 3, 'huangzhong', '811600', 1, '101.57159', '36.50083');
INSERT INTO `shop_truck_region` VALUES (3134, 3127, NULL, '湟源', '湟源县', 3, 'huangyuan', '812100', 1, '101.25643', '36.68243');
INSERT INTO `shop_truck_region` VALUES (3135, 3126, 'H', '海东', '海东市', 2, 'haidong', '810700', 1, '102.10327', '36.502916');
INSERT INTO `shop_truck_region` VALUES (3136, 3135, 'L', '乐都', '乐都区', 3, 'ledu', '810700', 1, '102.402431', '36.480291');
INSERT INTO `shop_truck_region` VALUES (3137, 3135, 'P', '平安', '平安县', 3, 'pingan', '810600', 1, '102.104295', '36.502714');
INSERT INTO `shop_truck_region` VALUES (3138, 3135, 'M', '民和', '民和回族土族自治县', 3, 'minhe', '810800', 1, '102.804209', '36.329451');
INSERT INTO `shop_truck_region` VALUES (3139, 3135, 'H', '互助', '互助土族自治县', 3, 'huzhu', '810500', 1, '101.956734', '36.83994');
INSERT INTO `shop_truck_region` VALUES (3140, 3135, 'H', '化隆', '化隆回族自治县', 3, 'hualong', '810900', 1, '102.262329', '36.098322');
INSERT INTO `shop_truck_region` VALUES (3141, 3135, 'X', '循化', '循化撒拉族自治县', 3, 'xunhua', '811100', 1, '102.486534', '35.847247');
INSERT INTO `shop_truck_region` VALUES (3142, 3126, 'H', '海北', '海北藏族自治州', 2, 'haibei', '812200', 1, '100.901059', '36.959435');
INSERT INTO `shop_truck_region` VALUES (3143, 3142, 'M', '门源', '门源回族自治县', 3, 'menyuan', '810300', 1, '101.62228', '37.37611');
INSERT INTO `shop_truck_region` VALUES (3144, 3142, 'Q', '祁连', '祁连县', 3, 'qilian', '810400', 1, '100.24618', '38.17901');
INSERT INTO `shop_truck_region` VALUES (3145, 3142, 'H', '海晏', '海晏县', 3, 'haiyan', '812200', 1, '100.9927', '36.89902');
INSERT INTO `shop_truck_region` VALUES (3146, 3142, 'G', '刚察', '刚察县', 3, 'gangcha', '812300', 1, '100.14675', '37.32161');
INSERT INTO `shop_truck_region` VALUES (3147, 3126, 'H', '黄南', '黄南藏族自治州', 2, 'huangnan', '811300', 1, '102.019988', '35.517744');
INSERT INTO `shop_truck_region` VALUES (3148, 3147, 'T', '同仁', '同仁县', 3, 'tongren', '811300', 1, '102.0184', '35.51603');
INSERT INTO `shop_truck_region` VALUES (3149, 3147, 'J', '尖扎', '尖扎县', 3, 'jianzha', '811200', 1, '102.03411', '35.93947');
INSERT INTO `shop_truck_region` VALUES (3150, 3147, 'Z', '泽库', '泽库县', 3, 'zeku', '811400', 1, '101.46444', '35.03519');
INSERT INTO `shop_truck_region` VALUES (3151, 3147, 'H', '河南', '河南蒙古族自治县', 3, 'henan', '811500', 1, '101.60864', '34.73476');
INSERT INTO `shop_truck_region` VALUES (3152, 3126, 'H', '海南', '海南藏族自治州', 2, 'hainan', '813000', 1, '100.619542', '36.280353');
INSERT INTO `shop_truck_region` VALUES (3153, 3152, 'G', '共和', '共和县', 3, 'gonghe', '813000', 1, '100.62003', '36.2841');
INSERT INTO `shop_truck_region` VALUES (3154, 3152, 'T', '同德', '同德县', 3, 'tongde', '813200', 1, '100.57159', '35.25488');
INSERT INTO `shop_truck_region` VALUES (3155, 3152, 'G', '贵德', '贵德县', 3, 'guide', '811700', 1, '101.432', '36.044');
INSERT INTO `shop_truck_region` VALUES (3156, 3152, 'X', '兴海', '兴海县', 3, 'xinghai', '813300', 1, '99.98846', '35.59031');
INSERT INTO `shop_truck_region` VALUES (3157, 3152, 'G', '贵南', '贵南县', 3, 'guinan', '813100', 1, '100.74716', '35.58667');
INSERT INTO `shop_truck_region` VALUES (3158, 3126, 'G', '果洛', '果洛藏族自治州', 2, 'golog', '814000', 1, '100.242143', '34.4736');
INSERT INTO `shop_truck_region` VALUES (3159, 3158, 'M', '玛沁', '玛沁县', 3, 'maqin', '814000', 1, '100.23901', '34.47746');
INSERT INTO `shop_truck_region` VALUES (3160, 3158, 'B', '班玛', '班玛县', 3, 'banma', '814300', 1, '100.73745', '32.93253');
INSERT INTO `shop_truck_region` VALUES (3161, 3158, 'G', '甘德', '甘德县', 3, 'gande', '814100', 1, '99.90246', '33.96838');
INSERT INTO `shop_truck_region` VALUES (3162, 3158, 'D', '达日', '达日县', 3, 'dari', '814200', 1, '99.65179', '33.75193');
INSERT INTO `shop_truck_region` VALUES (3163, 3158, 'J', '久治', '久治县', 3, 'jiuzhi', '624700', 1, '101.48342', '33.42989');
INSERT INTO `shop_truck_region` VALUES (3164, 3158, 'M', '玛多', '玛多县', 3, 'maduo', '813500', 1, '98.20996', '34.91567');
INSERT INTO `shop_truck_region` VALUES (3165, 3126, 'Y', '玉树', '玉树藏族自治州', 2, 'yushu', '815000', 1, '97.008522', '33.004049');
INSERT INTO `shop_truck_region` VALUES (3166, 3165, 'Y', '玉树', '玉树市', 3, 'yushu', '815000', 1, '97.008762', '33.00393');
INSERT INTO `shop_truck_region` VALUES (3167, 3165, 'Z', '杂多', '杂多县', 3, 'zaduo', '815300', 1, '95.29864', '32.89318');
INSERT INTO `shop_truck_region` VALUES (3168, 3165, 'C', '称多', '称多县', 3, 'chenduo', '815100', 1, '97.10788', '33.36899');
INSERT INTO `shop_truck_region` VALUES (3169, 3165, 'Z', '治多', '治多县', 3, 'zhiduo', '815400', 1, '95.61572', '33.8528');
INSERT INTO `shop_truck_region` VALUES (3170, 3165, 'N', '囊谦', '囊谦县', 3, 'nangqian', '815200', 1, '96.47753', '32.20359');
INSERT INTO `shop_truck_region` VALUES (3171, 3165, 'Q', '曲麻莱', '曲麻莱县', 3, 'qumalai', '815500', 1, '95.79757', '34.12609');
INSERT INTO `shop_truck_region` VALUES (3172, 3126, 'H', '海西', '海西蒙古族藏族自治州', 2, 'haixi', '817000', 1, '97.370785', '37.374663');
INSERT INTO `shop_truck_region` VALUES (3173, 3172, 'G', '格尔木', '格尔木市', 3, 'geermu', '816000', 1, '94.90329', '36.40236');
INSERT INTO `shop_truck_region` VALUES (3174, 3172, 'D', '德令哈', '德令哈市', 3, 'delingha', '817000', 1, '97.36084', '37.36946');
INSERT INTO `shop_truck_region` VALUES (3175, 3172, 'W', '乌兰', '乌兰县', 3, 'wulan', '817100', 1, '98.48196', '36.93471');
INSERT INTO `shop_truck_region` VALUES (3176, 3172, 'D', '都兰', '都兰县', 3, 'dulan', '816100', 1, '98.09228', '36.30135');
INSERT INTO `shop_truck_region` VALUES (3177, 3172, 'T', '天峻', '天峻县', 3, 'tianjun', '817200', 1, '99.02453', '37.30326');
INSERT INTO `shop_truck_region` VALUES (3178, 0, 'N', '宁夏', '宁夏回族自治区', 1, 'ningxia', '', 1, '106.278179', '38.46637');
INSERT INTO `shop_truck_region` VALUES (3179, 3178, 'Y', '银川', '银川市', 2, 'yinchuan', '750004', 1, '106.278179', '38.46637');
INSERT INTO `shop_truck_region` VALUES (3180, 3179, 'X', '兴庆', '兴庆区', 3, 'xingqing', '750001', 1, '106.28872', '38.47392');
INSERT INTO `shop_truck_region` VALUES (3181, 3179, 'X', '西夏', '西夏区', 3, 'xixia', '750021', 1, '106.15023', '38.49137');
INSERT INTO `shop_truck_region` VALUES (3182, 3179, 'J', '金凤', '金凤区', 3, 'jinfeng', '750011', 1, '106.24261', '38.47294');
INSERT INTO `shop_truck_region` VALUES (3183, 3179, 'Y', '永宁', '永宁县', 3, 'yongning', '750100', 1, '106.2517', '38.27559');
INSERT INTO `shop_truck_region` VALUES (3184, 3179, 'H', '贺兰', '贺兰县', 3, 'helan', '750200', 1, '106.34982', '38.5544');
INSERT INTO `shop_truck_region` VALUES (3185, 3179, 'L', '灵武', '灵武市', 3, 'lingwu', '750004', 1, '106.33999', '38.10266');
INSERT INTO `shop_truck_region` VALUES (3186, 3178, 'S', '石嘴山', '石嘴山市', 2, 'shizuishan', '753000', 1, '106.376173', '39.01333');
INSERT INTO `shop_truck_region` VALUES (3187, 3186, 'D', '大武口', '大武口区', 3, 'dawukou', '753000', 1, '106.37717', '39.01226');
INSERT INTO `shop_truck_region` VALUES (3188, 3186, 'H', '惠农', '惠农区', 3, 'huinong', '753600', 1, '106.71145', '39.13193');
INSERT INTO `shop_truck_region` VALUES (3189, 3186, 'P', '平罗', '平罗县', 3, 'pingluo', '753400', 1, '106.54538', '38.90429');
INSERT INTO `shop_truck_region` VALUES (3190, 3178, 'W', '吴忠', '吴忠市', 2, 'wuzhong', '751100', 1, '106.199409', '37.986165');
INSERT INTO `shop_truck_region` VALUES (3191, 3190, 'L', '利通', '利通区', 3, 'litong', '751100', 1, '106.20311', '37.98512');
INSERT INTO `shop_truck_region` VALUES (3192, 3190, 'H', '红寺堡', '红寺堡区', 3, 'hongsibao', '751900', 1, '106.19822', '37.99747');
INSERT INTO `shop_truck_region` VALUES (3193, 3190, 'Y', '盐池', '盐池县', 3, 'yanchi', '751500', 1, '107.40707', '37.7833');
INSERT INTO `shop_truck_region` VALUES (3194, 3190, 'T', '同心', '同心县', 3, 'tongxin', '751300', 1, '105.91418', '36.98116');
INSERT INTO `shop_truck_region` VALUES (3195, 3190, 'Q', '青铜峡', '青铜峡市', 3, 'qingtongxia', '751600', 1, '106.07489', '38.02004');
INSERT INTO `shop_truck_region` VALUES (3196, 3178, 'G', '固原', '固原市', 2, 'guyuan', '756000', 1, '106.285241', '36.004561');
INSERT INTO `shop_truck_region` VALUES (3197, 3196, 'Y', '原州', '原州区', 3, 'yuanzhou', '756000', 1, '106.28778', '36.00374');
INSERT INTO `shop_truck_region` VALUES (3198, 3196, 'X', '西吉', '西吉县', 3, 'xiji', '756200', 1, '105.73107', '35.96616');
INSERT INTO `shop_truck_region` VALUES (3199, 3196, 'L', '隆德', '隆德县', 3, 'longde', '756300', 1, '106.12426', '35.61718');
INSERT INTO `shop_truck_region` VALUES (3200, 3196, NULL, '泾源', '泾源县', 3, 'jingyuan', '756400', 1, '106.33902', '35.49072');
INSERT INTO `shop_truck_region` VALUES (3201, 3196, 'P', '彭阳', '彭阳县', 3, 'pengyang', '756500', 1, '106.64462', '35.85076');
INSERT INTO `shop_truck_region` VALUES (3202, 3178, 'Z', '中卫', '中卫市', 2, 'zhongwei', '751700', 1, '105.189568', '37.514951');
INSERT INTO `shop_truck_region` VALUES (3203, 3202, 'S', '沙坡头', '沙坡头区', 3, 'shapotou', '755000', 1, '105.18962', '37.51044');
INSERT INTO `shop_truck_region` VALUES (3204, 3202, 'Z', '中宁', '中宁县', 3, 'zhongning', '751200', 1, '105.68515', '37.49149');
INSERT INTO `shop_truck_region` VALUES (3205, 3202, 'H', '海原', '海原县', 3, 'haiyuan', '751800', 1, '105.64712', '36.56498');
INSERT INTO `shop_truck_region` VALUES (3206, 0, 'X', '新疆', '新疆维吾尔自治区', 1, 'xinjiang', '', 1, '87.617733', '43.792818');
INSERT INTO `shop_truck_region` VALUES (3207, 3206, 'W', '乌鲁木齐', '乌鲁木齐市', 2, 'urumqi', '830002', 1, '87.617733', '43.792818');
INSERT INTO `shop_truck_region` VALUES (3208, 3207, 'T', '天山', '天山区', 3, 'tianshan', '830002', 1, '87.63167', '43.79439');
INSERT INTO `shop_truck_region` VALUES (3209, 3207, 'S', '沙依巴克', '沙依巴克区', 3, 'shayibake', '830000', 1, '87.59788', '43.80118');
INSERT INTO `shop_truck_region` VALUES (3210, 3207, 'X', '新市', '新市区', 3, 'xinshi', '830011', 1, '87.57406', '43.84348');
INSERT INTO `shop_truck_region` VALUES (3211, 3207, 'S', '水磨沟', '水磨沟区', 3, 'shuimogou', '830017', 1, '87.64249', '43.83247');
INSERT INTO `shop_truck_region` VALUES (3212, 3207, 'T', '头屯河', '头屯河区', 3, 'toutunhe', '830022', 1, '87.29138', '43.85487');
INSERT INTO `shop_truck_region` VALUES (3213, 3207, 'D', '达坂城', '达坂城区', 3, 'dabancheng', '830039', 1, '88.30697', '43.35797');
INSERT INTO `shop_truck_region` VALUES (3214, 3207, 'M', '米东', '米东区', 3, 'midong', '830019', 1, '87.68583', '43.94739');
INSERT INTO `shop_truck_region` VALUES (3215, 3207, 'W', '乌鲁木齐', '乌鲁木齐县', 3, 'wulumuqi', '830063', 1, '87.40939', '43.47125');
INSERT INTO `shop_truck_region` VALUES (3216, 3206, 'K', '克拉玛依', '克拉玛依市', 2, 'karamay', '834000', 1, '84.873946', '45.595886');
INSERT INTO `shop_truck_region` VALUES (3217, 3216, 'D', '独山子', '独山子区', 3, 'dushanzi', '834021', 1, '84.88671', '44.32867');
INSERT INTO `shop_truck_region` VALUES (3218, 3216, 'K', '克拉玛依', '克拉玛依区', 3, 'kelamayi', '834000', 1, '84.86225', '45.59089');
INSERT INTO `shop_truck_region` VALUES (3219, 3216, 'B', '白碱滩', '白碱滩区', 3, 'baijiantan', '834008', 1, '85.13244', '45.68768');
INSERT INTO `shop_truck_region` VALUES (3220, 3216, 'W', '乌尔禾', '乌尔禾区', 3, 'wuerhe', '834012', 1, '85.69143', '46.09006');
INSERT INTO `shop_truck_region` VALUES (3221, 3206, 'T', '吐鲁番', '吐鲁番地区', 2, 'turpan', '838000', 1, '89.184078', '42.947613');
INSERT INTO `shop_truck_region` VALUES (3222, 3221, 'T', '吐鲁番', '吐鲁番市', 3, 'tulufan', '838000', 1, '89.18579', '42.93505');
INSERT INTO `shop_truck_region` VALUES (3223, 3221, NULL, '鄯善', '鄯善县', 3, 'shanshan', '838200', 1, '90.21402', '42.8635');
INSERT INTO `shop_truck_region` VALUES (3224, 3221, 'T', '托克逊', '托克逊县', 3, 'tuokexun', '838100', 1, '88.65823', '42.79231');
INSERT INTO `shop_truck_region` VALUES (3225, 3206, 'H', '哈密', '哈密地区', 2, 'hami', '839000', 1, '93.51316', '42.833248');
INSERT INTO `shop_truck_region` VALUES (3226, 3225, 'H', '哈密', '哈密市', 3, 'hami', '839000', 1, '93.51452', '42.82699');
INSERT INTO `shop_truck_region` VALUES (3227, 3225, 'B', '巴里坤', '巴里坤哈萨克自治县', 3, 'balikun', '839200', 1, '93.01236', '43.59993');
INSERT INTO `shop_truck_region` VALUES (3228, 3225, 'Y', '伊吾', '伊吾县', 3, 'yiwu', '839300', 1, '94.69403', '43.2537');
INSERT INTO `shop_truck_region` VALUES (3229, 3206, 'C', '昌吉', '昌吉回族自治州', 2, 'changji', '831100', 1, '87.304012', '44.014577');
INSERT INTO `shop_truck_region` VALUES (3230, 3229, 'C', '昌吉', '昌吉市', 3, 'changji', '831100', 1, '87.30249', '44.01267');
INSERT INTO `shop_truck_region` VALUES (3231, 3229, 'F', '阜康', '阜康市', 3, 'fukang', '831500', 1, '87.98529', '44.1584');
INSERT INTO `shop_truck_region` VALUES (3232, 3229, 'H', '呼图壁', '呼图壁县', 3, 'hutubi', '831200', 1, '86.89892', '44.18977');
INSERT INTO `shop_truck_region` VALUES (3233, 3229, 'M', '玛纳斯', '玛纳斯县', 3, 'manasi', '832200', 1, '86.2145', '44.30438');
INSERT INTO `shop_truck_region` VALUES (3234, 3229, 'Q', '奇台', '奇台县', 3, 'qitai', '831800', 1, '89.5932', '44.02221');
INSERT INTO `shop_truck_region` VALUES (3235, 3229, 'J', '吉木萨尔', '吉木萨尔县', 3, 'jimusaer', '831700', 1, '89.18078', '44.00048');
INSERT INTO `shop_truck_region` VALUES (3236, 3229, 'M', '木垒', '木垒哈萨克自治县', 3, 'mulei', '831900', 1, '90.28897', '43.83508');
INSERT INTO `shop_truck_region` VALUES (3237, 3206, 'B', '博尔塔拉', '博尔塔拉蒙古自治州', 2, 'bortala', '833400', 1, '82.074778', '44.903258');
INSERT INTO `shop_truck_region` VALUES (3238, 3237, 'B', '博乐', '博乐市', 3, 'bole', '833400', 1, '82.0713', '44.90052');
INSERT INTO `shop_truck_region` VALUES (3239, 3237, 'A', '阿拉山口', '阿拉山口市', 3, 'alashankou', '833400', 1, '82.567721', '45.170616');
INSERT INTO `shop_truck_region` VALUES (3240, 3237, 'J', '精河', '精河县', 3, 'jinghe', '833300', 1, '82.89419', '44.60774');
INSERT INTO `shop_truck_region` VALUES (3241, 3237, 'W', '温泉', '温泉县', 3, 'wenquan', '833500', 1, '81.03134', '44.97373');
INSERT INTO `shop_truck_region` VALUES (3242, 3206, 'B', '巴音郭楞', '巴音郭楞蒙古自治州', 2, 'bayingol', '841000', 1, '86.150969', '41.768552');
INSERT INTO `shop_truck_region` VALUES (3243, 3242, 'K', '库尔勒', '库尔勒市', 3, 'kuerle', '841000', 1, '86.15528', '41.76602');
INSERT INTO `shop_truck_region` VALUES (3244, 3242, 'L', '轮台', '轮台县', 3, 'luntai', '841600', 1, '84.26101', '41.77642');
INSERT INTO `shop_truck_region` VALUES (3245, 3242, 'W', '尉犁', '尉犁县', 3, 'yuli', '841500', 1, '86.25903', '41.33632');
INSERT INTO `shop_truck_region` VALUES (3246, 3242, 'R', '若羌', '若羌县', 3, 'ruoqiang', '841800', 1, '88.16812', '39.0179');
INSERT INTO `shop_truck_region` VALUES (3247, 3242, 'Q', '且末', '且末县', 3, 'qiemo', '841900', 1, '85.52975', '38.14534');
INSERT INTO `shop_truck_region` VALUES (3248, 3242, 'Y', '焉耆', '焉耆回族自治县', 3, 'yanqi', '841100', 1, '86.5744', '42.059');
INSERT INTO `shop_truck_region` VALUES (3249, 3242, 'H', '和静', '和静县', 3, 'hejing', '841300', 1, '86.39611', '42.31838');
INSERT INTO `shop_truck_region` VALUES (3250, 3242, 'H', '和硕', '和硕县', 3, 'heshuo', '841200', 1, '86.86392', '42.26814');
INSERT INTO `shop_truck_region` VALUES (3251, 3242, 'B', '博湖', '博湖县', 3, 'bohu', '841400', 1, '86.63333', '41.98014');
INSERT INTO `shop_truck_region` VALUES (3252, 3206, 'A', '阿克苏', '阿克苏地区', 2, 'aksu', '843000', 1, '80.265068', '41.170712');
INSERT INTO `shop_truck_region` VALUES (3253, 3252, 'A', '阿克苏', '阿克苏市', 3, 'akesu', '843000', 1, '80.26338', '41.16754');
INSERT INTO `shop_truck_region` VALUES (3254, 3252, 'W', '温宿', '温宿县', 3, 'wensu', '843100', 1, '80.24173', '41.27679');
INSERT INTO `shop_truck_region` VALUES (3255, 3252, 'K', '库车', '库车县', 3, 'kuche', '842000', 1, '82.96209', '41.71793');
INSERT INTO `shop_truck_region` VALUES (3256, 3252, 'S', '沙雅', '沙雅县', 3, 'shaya', '842200', 1, '82.78131', '41.22497');
INSERT INTO `shop_truck_region` VALUES (3257, 3252, 'X', '新和', '新和县', 3, 'xinhe', '842100', 1, '82.61053', '41.54964');
INSERT INTO `shop_truck_region` VALUES (3258, 3252, 'B', '拜城', '拜城县', 3, 'baicheng', '842300', 1, '81.87564', '41.79801');
INSERT INTO `shop_truck_region` VALUES (3259, 3252, 'W', '乌什', '乌什县', 3, 'wushi', '843400', 1, '79.22937', '41.21569');
INSERT INTO `shop_truck_region` VALUES (3260, 3252, 'A', '阿瓦提', '阿瓦提县', 3, 'awati', '843200', 1, '80.38336', '40.63926');
INSERT INTO `shop_truck_region` VALUES (3261, 3252, 'K', '柯坪', '柯坪县', 3, 'keping', '843600', 1, '79.04751', '40.50585');
INSERT INTO `shop_truck_region` VALUES (3262, 3206, 'K', '克孜勒苏', '克孜勒苏柯尔克孜自治州', 2, 'kizilsu', '845350', 1, '76.172825', '39.713431');
INSERT INTO `shop_truck_region` VALUES (3263, 3262, 'A', '阿图什', '阿图什市', 3, 'atushi', '845350', 1, '76.16827', '39.71615');
INSERT INTO `shop_truck_region` VALUES (3264, 3262, 'A', '阿克陶', '阿克陶县', 3, 'aketao', '845550', 1, '75.94692', '39.14892');
INSERT INTO `shop_truck_region` VALUES (3265, 3262, 'A', '阿合奇', '阿合奇县', 3, 'aheqi', '843500', 1, '78.44848', '40.93947');
INSERT INTO `shop_truck_region` VALUES (3266, 3262, 'W', '乌恰', '乌恰县', 3, 'wuqia', '845450', 1, '75.25839', '39.71984');
INSERT INTO `shop_truck_region` VALUES (3267, 3206, 'K', '喀什', '喀什地区', 2, 'kashgar', '844000', 1, '75.989138', '39.467664');
INSERT INTO `shop_truck_region` VALUES (3268, 3267, 'K', '喀什', '喀什市', 3, 'kashi', '844000', 1, '75.99379', '39.46768');
INSERT INTO `shop_truck_region` VALUES (3269, 3267, 'S', '疏附', '疏附县', 3, 'shufu', '844100', 1, '75.86029', '39.37534');
INSERT INTO `shop_truck_region` VALUES (3270, 3267, 'S', '疏勒', '疏勒县', 3, 'shule', '844200', 1, '76.05398', '39.40625');
INSERT INTO `shop_truck_region` VALUES (3271, 3267, 'Y', '英吉沙', '英吉沙县', 3, 'yingjisha', '844500', 1, '76.17565', '38.92968');
INSERT INTO `shop_truck_region` VALUES (3272, 3267, 'Z', '泽普', '泽普县', 3, 'zepu', '844800', 1, '77.27145', '38.18935');
INSERT INTO `shop_truck_region` VALUES (3273, 3267, 'S', '莎车', '莎车县', 3, 'shache', '844700', 1, '77.24316', '38.41601');
INSERT INTO `shop_truck_region` VALUES (3274, 3267, 'Y', '叶城', '叶城县', 3, 'yecheng', '844900', 1, '77.41659', '37.88324');
INSERT INTO `shop_truck_region` VALUES (3275, 3267, 'M', '麦盖提', '麦盖提县', 3, 'maigaiti', '844600', 1, '77.64224', '38.89662');
INSERT INTO `shop_truck_region` VALUES (3276, 3267, 'Y', '岳普湖', '岳普湖县', 3, 'yuepuhu', '844400', 1, '76.77233', '39.23561');
INSERT INTO `shop_truck_region` VALUES (3277, 3267, NULL, '伽师', '伽师县', 3, 'jiashi', '844300', 1, '76.72372', '39.48801');
INSERT INTO `shop_truck_region` VALUES (3278, 3267, 'B', '巴楚', '巴楚县', 3, 'bachu', '843800', 1, '78.54888', '39.7855');
INSERT INTO `shop_truck_region` VALUES (3279, 3267, 'T', '塔什库尔干塔吉克', '塔什库尔干塔吉克自治县', 3, 'tashikuergantajike', '845250', 1, '75.23196', '37.77893');
INSERT INTO `shop_truck_region` VALUES (3280, 3206, 'H', '和田', '和田地区', 2, 'hotan', '848000', 1, '79.92533', '37.110687');
INSERT INTO `shop_truck_region` VALUES (3281, 3280, 'H', '和田市', '和田市', 3, 'hetianshi', '848000', 1, '79.91353', '37.11214');
INSERT INTO `shop_truck_region` VALUES (3282, 3280, 'H', '和田县', '和田县', 3, 'hetianxian', '848000', 1, '79.82874', '37.08922');
INSERT INTO `shop_truck_region` VALUES (3283, 3280, 'M', '墨玉', '墨玉县', 3, 'moyu', '848100', 1, '79.74035', '37.27248');
INSERT INTO `shop_truck_region` VALUES (3284, 3280, 'P', '皮山', '皮山县', 3, 'pishan', '845150', 1, '78.28125', '37.62007');
INSERT INTO `shop_truck_region` VALUES (3285, 3280, 'L', '洛浦', '洛浦县', 3, 'luopu', '848200', 1, '80.18536', '37.07364');
INSERT INTO `shop_truck_region` VALUES (3286, 3280, 'C', '策勒', '策勒县', 3, 'cele', '848300', 1, '80.80999', '36.99843');
INSERT INTO `shop_truck_region` VALUES (3287, 3280, 'Y', '于田', '于田县', 3, 'yutian', '848400', 1, '81.66717', '36.854');
INSERT INTO `shop_truck_region` VALUES (3288, 3280, 'M', '民丰', '民丰县', 3, 'minfeng', '848500', 1, '82.68444', '37.06577');
INSERT INTO `shop_truck_region` VALUES (3289, 3206, 'Y', '伊犁', '伊犁哈萨克自治州', 2, 'ili', '835100', 1, '81.317946', '43.92186');
INSERT INTO `shop_truck_region` VALUES (3290, 3289, 'Y', '伊宁', '伊宁市', 3, 'yining', '835000', 1, '81.32932', '43.91294');
INSERT INTO `shop_truck_region` VALUES (3291, 3289, 'K', '奎屯', '奎屯市', 3, 'kuitun', '833200', 1, '84.90228', '44.425');
INSERT INTO `shop_truck_region` VALUES (3292, 3289, 'H', '霍尔果斯', '霍尔果斯市', 3, 'huoerguosi', '835221', 1, '80.418189', '44.205778');
INSERT INTO `shop_truck_region` VALUES (3293, 3289, 'Y', '伊宁', '伊宁县', 3, 'yining', '835100', 1, '81.52764', '43.97863');
INSERT INTO `shop_truck_region` VALUES (3294, 3289, 'C', '察布查尔锡伯', '察布查尔锡伯自治县', 3, 'chabuchaerxibo', '835300', 1, '81.14956', '43.84023');
INSERT INTO `shop_truck_region` VALUES (3295, 3289, 'H', '霍城', '霍城县', 3, 'huocheng', '835200', 1, '80.87826', '44.0533');
INSERT INTO `shop_truck_region` VALUES (3296, 3289, 'G', '巩留', '巩留县', 3, 'gongliu', '835400', 1, '82.22851', '43.48429');
INSERT INTO `shop_truck_region` VALUES (3297, 3289, 'X', '新源', '新源县', 3, 'xinyuan', '835800', 1, '83.26095', '43.4284');
INSERT INTO `shop_truck_region` VALUES (3298, 3289, 'Z', '昭苏', '昭苏县', 3, 'zhaosu', '835600', 1, '81.1307', '43.15828');
INSERT INTO `shop_truck_region` VALUES (3299, 3289, 'T', '特克斯', '特克斯县', 3, 'tekesi', '835500', 1, '81.84005', '43.21938');
INSERT INTO `shop_truck_region` VALUES (3300, 3289, 'N', '尼勒克', '尼勒克县', 3, 'nileke', '835700', 1, '82.51184', '43.79901');
INSERT INTO `shop_truck_region` VALUES (3301, 3206, 'T', '塔城', '塔城地区', 2, 'qoqek', '834700', 1, '82.985732', '46.746301');
INSERT INTO `shop_truck_region` VALUES (3302, 3301, 'T', '塔城', '塔城市', 3, 'tacheng', '834700', 1, '82.97892', '46.74852');
INSERT INTO `shop_truck_region` VALUES (3303, 3301, 'W', '乌苏', '乌苏市', 3, 'wusu', '833000', 1, '84.68258', '44.43729');
INSERT INTO `shop_truck_region` VALUES (3304, 3301, 'E', '额敏', '额敏县', 3, 'emin', '834600', 1, '83.62872', '46.5284');
INSERT INTO `shop_truck_region` VALUES (3305, 3301, 'S', '沙湾', '沙湾县', 3, 'shawan', '832100', 1, '85.61932', '44.33144');
INSERT INTO `shop_truck_region` VALUES (3306, 3301, 'T', '托里', '托里县', 3, 'tuoli', '834500', 1, '83.60592', '45.93623');
INSERT INTO `shop_truck_region` VALUES (3307, 3301, 'Y', '裕民', '裕民县', 3, 'yumin', '834800', 1, '82.99002', '46.20377');
INSERT INTO `shop_truck_region` VALUES (3308, 3301, 'H', '和布克赛尔', '和布克赛尔蒙古自治县', 3, 'hebukesaier', '834400', 1, '85.72662', '46.79362');
INSERT INTO `shop_truck_region` VALUES (3309, 3206, 'A', '阿勒泰', '阿勒泰地区', 2, 'altay', '836500', 1, '88.13963', '47.848393');
INSERT INTO `shop_truck_region` VALUES (3310, 3309, 'A', '阿勒泰', '阿勒泰市', 3, 'aletai', '836500', 1, '88.13913', '47.8317');
INSERT INTO `shop_truck_region` VALUES (3311, 3309, 'B', '布尔津', '布尔津县', 3, 'buerjin', '836600', 1, '86.85751', '47.70062');
INSERT INTO `shop_truck_region` VALUES (3312, 3309, 'F', '富蕴', '富蕴县', 3, 'fuyun', '836100', 1, '89.52679', '46.99444');
INSERT INTO `shop_truck_region` VALUES (3313, 3309, 'F', '福海', '福海县', 3, 'fuhai', '836400', 1, '87.49508', '47.11065');
INSERT INTO `shop_truck_region` VALUES (3314, 3309, 'H', '哈巴河', '哈巴河县', 3, 'habahe', '836700', 1, '86.42092', '48.06046');
INSERT INTO `shop_truck_region` VALUES (3315, 3309, 'Q', '青河', '青河县', 3, 'qinghe', '836200', 1, '90.38305', '46.67382');
INSERT INTO `shop_truck_region` VALUES (3316, 3309, 'J', '吉木乃', '吉木乃县', 3, 'jimunai', '836800', 1, '85.87814', '47.43359');
INSERT INTO `shop_truck_region` VALUES (3317, 3206, 'Z', ' ', '直辖县级', 2, '', '', 1, '91.132212', '29.660361');
INSERT INTO `shop_truck_region` VALUES (3318, 3317, 'S', '石河子', '石河子市', 3, 'shihezi', '832000', 1, '86.041075', '44.305886');
INSERT INTO `shop_truck_region` VALUES (3319, 3317, 'A', '阿拉尔', '阿拉尔市', 3, 'aral', '843300', 1, '81.285884', '40.541914');
INSERT INTO `shop_truck_region` VALUES (3320, 3317, 'T', '图木舒克', '图木舒克市', 3, 'tumxuk', '843806', 1, '79.077978', '39.867316');
INSERT INTO `shop_truck_region` VALUES (3321, 3317, 'W', '五家渠', '五家渠市', 3, 'wujiaqu', '831300', 1, '87.526884', '44.167401');
INSERT INTO `shop_truck_region` VALUES (3322, 3317, 'B', '北屯', '北屯市', 3, 'beitun', '836000', 1, '87.808456', '47.362308');
INSERT INTO `shop_truck_region` VALUES (3323, 3317, 'T', '铁门关', '铁门关市', 3, 'tiemenguan', '836000', 1, '86.194687', '41.811007');
INSERT INTO `shop_truck_region` VALUES (3324, 3317, 'S', '双河', '双河市', 3, 'shuanghe', '833408', 1, '91.132212', '29.660361');
INSERT INTO `shop_truck_region` VALUES (3325, 0, 'T', '台湾', '台湾省', 1, 'taiwan', '', 1, '121.509062', '25.044332');
INSERT INTO `shop_truck_region` VALUES (3326, 3325, 'T', '台北', '台北市', 2, 'taipei', '1', 1, '121.565170', '25.037798');
INSERT INTO `shop_truck_region` VALUES (3327, 3326, 'S', '松山', '松山区', 3, 'songshan', '105', 1, '121.577206', '25.049698');
INSERT INTO `shop_truck_region` VALUES (3328, 3326, 'X', '信义', '信义区', 3, 'xinyi', '110', 1, '121.751381', '25.129407');
INSERT INTO `shop_truck_region` VALUES (3329, 3326, 'D', '大安', '大安区', 3, 'daan', '106', 1, '121.534648', '25.026406');
INSERT INTO `shop_truck_region` VALUES (3330, 3326, 'Z', '中山', '中山区', 3, 'zhongshan', '104', 1, '121.533468', '25.064361');
INSERT INTO `shop_truck_region` VALUES (3331, 3326, 'Z', '中正', '中正区', 3, 'zhongzheng', '100', 1, '121.518267', '25.032361');
INSERT INTO `shop_truck_region` VALUES (3332, 3326, 'D', '大同', '大同区', 3, 'datong', '103', 1, '121.515514', '25.065986');
INSERT INTO `shop_truck_region` VALUES (3333, 3326, 'W', '万华', '万华区', 3, 'wanhua', '108', 1, '121.499332', '25.031933');
INSERT INTO `shop_truck_region` VALUES (3334, 3326, 'W', '文山', '文山区', 3, 'wenshan', '116', 1, '121.570458', '24.989786');
INSERT INTO `shop_truck_region` VALUES (3335, 3326, 'N', '南港', '南港区', 3, 'nangang', '115', 1, '121.606858', '25.054656');
INSERT INTO `shop_truck_region` VALUES (3336, 3326, 'N', '内湖', '内湖区', 3, 'nahu', '114', 1, '121.588998', '25.069664');
INSERT INTO `shop_truck_region` VALUES (3337, 3326, 'S', '士林', '士林区', 3, 'shilin', '111', 1, '121.519874', '25.092822');
INSERT INTO `shop_truck_region` VALUES (3338, 3326, 'B', '北投', '北投区', 3, 'beitou', '112', 1, '121.501379', '25.132419');
INSERT INTO `shop_truck_region` VALUES (3339, 3325, 'G', '高雄', '高雄市', 2, 'kaohsiung', '8', 1, '120.311922', '22.620856');
INSERT INTO `shop_truck_region` VALUES (3340, 3339, 'Y', '盐埕', '盐埕区', 3, 'yancheng', '803', 1, '120.286795', '22.624666');
INSERT INTO `shop_truck_region` VALUES (3341, 3339, 'G', '鼓山', '鼓山区', 3, 'gushan', '804', 1, '120.281154', '22.636797');
INSERT INTO `shop_truck_region` VALUES (3342, 3339, 'Z', '左营', '左营区', 3, 'zuoying', '813', 1, '120.294958', '22.690124');
INSERT INTO `shop_truck_region` VALUES (3343, 3339, NULL, '楠梓', '楠梓区', 3, 'nanzi', '811', 1, '120.326314', '22.728401');
INSERT INTO `shop_truck_region` VALUES (3344, 3339, 'S', '三民', '三民区', 3, 'sanmin', '807', 1, '120.299622', '22.647695');
INSERT INTO `shop_truck_region` VALUES (3345, 3339, 'X', '新兴', '新兴区', 3, 'xinxing', '800', 1, '120.309535', '22.631147');
INSERT INTO `shop_truck_region` VALUES (3346, 3339, 'Q', '前金', '前金区', 3, 'qianjin', '801', 1, '120.294159', '22.627421');
INSERT INTO `shop_truck_region` VALUES (3347, 3339, NULL, '苓雅', '苓雅区', 3, 'lingya', '802', 1, '120.312347', '22.621770');
INSERT INTO `shop_truck_region` VALUES (3348, 3339, 'Q', '前镇', '前镇区', 3, 'qianzhen', '806', 1, '120.318583', '22.586425');
INSERT INTO `shop_truck_region` VALUES (3349, 3339, 'Q', '旗津', '旗津区', 3, 'qijin', '805', 1, '120.284429', '22.590565');
INSERT INTO `shop_truck_region` VALUES (3350, 3339, 'X', '小港', '小港区', 3, 'xiaogang', '812', 1, '120.337970', '22.565354');
INSERT INTO `shop_truck_region` VALUES (3351, 3339, 'F', '凤山', '凤山区', 3, 'fengshan', '830', 1, '120.356892', '22.626945');
INSERT INTO `shop_truck_region` VALUES (3352, 3339, 'L', '林园', '林园区', 3, 'linyuan', '832', 1, '120.395977', '22.501490');
INSERT INTO `shop_truck_region` VALUES (3353, 3339, 'D', '大寮', '大寮区', 3, 'daliao', '831', 1, '120.395422', '22.605386');
INSERT INTO `shop_truck_region` VALUES (3354, 3339, 'D', '大树', '大树区', 3, 'dashu', '840', 1, '120.433095', '22.693394');
INSERT INTO `shop_truck_region` VALUES (3355, 3339, 'D', '大社', '大社区', 3, 'dashe', '815', 1, '120.346635', '22.729966');
INSERT INTO `shop_truck_region` VALUES (3356, 3339, 'R', '仁武', '仁武区', 3, 'renwu', '814', 1, '120.347779', '22.701901');
INSERT INTO `shop_truck_region` VALUES (3357, 3339, 'N', '鸟松', '鸟松区', 3, 'niaosong', '833', 1, '120.364402', '22.659340');
INSERT INTO `shop_truck_region` VALUES (3358, 3339, 'G', '冈山', '冈山区', 3, 'gangshan', '820', 1, '120.295820', '22.796762');
INSERT INTO `shop_truck_region` VALUES (3359, 3339, 'Q', '桥头', '桥头区', 3, 'qiaotou', '825', 1, '120.305741', '22.757501');
INSERT INTO `shop_truck_region` VALUES (3360, 3339, 'Y', '燕巢', '燕巢区', 3, 'yanchao', '824', 1, '120.361956', '22.793370');
INSERT INTO `shop_truck_region` VALUES (3361, 3339, 'T', '田寮', '田寮区', 3, 'tianliao', '823', 1, '120.359636', '22.869307');
INSERT INTO `shop_truck_region` VALUES (3362, 3339, 'A', '阿莲', '阿莲区', 3, 'alian', '822', 1, '120.327036', '22.883703');
INSERT INTO `shop_truck_region` VALUES (3363, 3339, 'L', '路竹', '路竹区', 3, 'luzhu', '821', 1, '120.261828', '22.856851');
INSERT INTO `shop_truck_region` VALUES (3364, 3339, 'H', '湖内', '湖内区', 3, 'huna', '829', 1, '120.211530', '22.908188');
INSERT INTO `shop_truck_region` VALUES (3365, 3339, NULL, '茄萣', '茄萣区', 3, 'qieding', '852', 1, '120.182815', '22.906556');
INSERT INTO `shop_truck_region` VALUES (3366, 3339, 'Y', '永安', '永安区', 3, 'yongan', '828', 1, '120.225308', '22.818580');
INSERT INTO `shop_truck_region` VALUES (3367, 3339, 'M', '弥陀', '弥陀区', 3, 'mituo', '827', 1, '120.247344', '22.782879');
INSERT INTO `shop_truck_region` VALUES (3368, 3339, NULL, '梓官', '梓官区', 3, 'ziguan', '826', 1, '120.267322', '22.760475');
INSERT INTO `shop_truck_region` VALUES (3369, 3339, 'Q', '旗山', '旗山区', 3, 'qishan', '842', 1, '120.483550', '22.888491');
INSERT INTO `shop_truck_region` VALUES (3370, 3339, 'M', '美浓', '美浓区', 3, 'meinong', '843', 1, '120.541530', '22.897880');
INSERT INTO `shop_truck_region` VALUES (3371, 3339, 'L', '六龟', '六龟区', 3, 'liugui', '844', 1, '120.633418', '22.997914');
INSERT INTO `shop_truck_region` VALUES (3372, 3339, 'J', '甲仙', '甲仙区', 3, 'jiaxian', '847', 1, '120.591185', '23.084688');
INSERT INTO `shop_truck_region` VALUES (3373, 3339, 'S', '杉林', '杉林区', 3, 'shanlin', '846', 1, '120.538980', '22.970712');
INSERT INTO `shop_truck_region` VALUES (3374, 3339, 'N', '内门', '内门区', 3, 'namen', '845', 1, '120.462351', '22.943437');
INSERT INTO `shop_truck_region` VALUES (3375, 3339, 'M', '茂林', '茂林区', 3, 'maolin', '851', 1, '120.663217', '22.886248');
INSERT INTO `shop_truck_region` VALUES (3376, 3339, 'T', '桃源', '桃源区', 3, 'taoyuan', '848', 1, '120.760049', '23.159137');
INSERT INTO `shop_truck_region` VALUES (3377, 3339, 'N', '那玛夏', '那玛夏区', 3, 'namaxia', '849', 1, '120.692799', '23.216964');
INSERT INTO `shop_truck_region` VALUES (3378, 3325, 'J', '基隆', '基隆市', 2, 'keelung', '2', 1, '121.746248', '25.130741');
INSERT INTO `shop_truck_region` VALUES (3379, 3378, 'Z', '中正', '中正区', 3, 'zhongzheng', '202', 1, '121.518267', '25.032361');
INSERT INTO `shop_truck_region` VALUES (3380, 3378, 'Q', '七堵', '七堵区', 3, 'qidu', '206', 1, '121.713032', '25.095739');
INSERT INTO `shop_truck_region` VALUES (3381, 3378, 'N', '暖暖', '暖暖区', 3, 'nuannuan', '205', 1, '121.736102', '25.099777');
INSERT INTO `shop_truck_region` VALUES (3382, 3378, 'R', '仁爱', '仁爱区', 3, 'renai', '200', 1, '121.740940', '25.127526');
INSERT INTO `shop_truck_region` VALUES (3383, 3378, 'Z', '中山', '中山区', 3, 'zhongshan', '203', 1, '121.739132', '25.133991');
INSERT INTO `shop_truck_region` VALUES (3384, 3378, 'A', '安乐', '安乐区', 3, 'anle', '204', 1, '121.723203', '25.120910');
INSERT INTO `shop_truck_region` VALUES (3385, 3378, 'X', '信义', '信义区', 3, 'xinyi', '201', 1, '121.751381', '25.129407');
INSERT INTO `shop_truck_region` VALUES (3386, 3325, 'T', '台中', '台中市', 2, 'taichung', '4', 1, '120.679040', '24.138620');
INSERT INTO `shop_truck_region` VALUES (3387, 3386, 'Z', '中区', '中区', 3, 'zhongqu', '400', 1, '120.679510', '24.143830');
INSERT INTO `shop_truck_region` VALUES (3388, 3386, 'D', '东区', '东区', 3, 'dongqu', '401', 1, '120.704', '24.13662');
INSERT INTO `shop_truck_region` VALUES (3389, 3386, 'N', '南区', '南区', 3, 'nanqu', '402', 1, '120.188648', '22.960944');
INSERT INTO `shop_truck_region` VALUES (3390, 3386, 'X', '西区', '西区', 3, 'xiqu', '403', 1, '120.67104', '24.14138');
INSERT INTO `shop_truck_region` VALUES (3391, 3386, 'B', '北区', '北区', 3, 'beiqu', '404', 1, '120.682410', '24.166040');
INSERT INTO `shop_truck_region` VALUES (3392, 3386, 'X', '西屯', '西屯区', 3, 'xitun', '407', 1, '120.639820', '24.181340');
INSERT INTO `shop_truck_region` VALUES (3393, 3386, 'N', '南屯', '南屯区', 3, 'nantun', '408', 1, '120.643080', '24.138270');
INSERT INTO `shop_truck_region` VALUES (3394, 3386, 'B', '北屯', '北屯区', 3, 'beitun', '406', 1, '120.686250', '24.182220');
INSERT INTO `shop_truck_region` VALUES (3395, 3386, 'F', '丰原', '丰原区', 3, 'fengyuan', '420', 1, '120.718460', '24.242190');
INSERT INTO `shop_truck_region` VALUES (3396, 3386, 'D', '东势', '东势区', 3, 'dongshi', '423', 1, '120.827770', '24.258610');
INSERT INTO `shop_truck_region` VALUES (3397, 3386, 'D', '大甲', '大甲区', 3, 'dajia', '437', 1, '120.622390', '24.348920');
INSERT INTO `shop_truck_region` VALUES (3398, 3386, 'Q', '清水', '清水区', 3, 'qingshui', '436', 1, '120.559780', '24.268650');
INSERT INTO `shop_truck_region` VALUES (3399, 3386, 'S', '沙鹿', '沙鹿区', 3, 'shalu', '433', 1, '120.565700', '24.233480');
INSERT INTO `shop_truck_region` VALUES (3400, 3386, 'W', '梧栖', '梧栖区', 3, 'wuqi', '435', 1, '120.531520', '24.254960');
INSERT INTO `shop_truck_region` VALUES (3401, 3386, 'H', '后里', '后里区', 3, 'houli', '421', 1, '120.710710', '24.304910');
INSERT INTO `shop_truck_region` VALUES (3402, 3386, 'S', '神冈', '神冈区', 3, 'shengang', '429', 1, '120.661550', '24.257770');
INSERT INTO `shop_truck_region` VALUES (3403, 3386, 'T', '潭子', '潭子区', 3, 'tanzi', '427', 1, '120.705160', '24.209530');
INSERT INTO `shop_truck_region` VALUES (3404, 3386, 'D', '大雅', '大雅区', 3, 'daya', '428', 1, '120.647780', '24.229230');
INSERT INTO `shop_truck_region` VALUES (3405, 3386, 'X', '新社', '新社区', 3, 'xinshe', '426', 1, '120.809500', '24.234140');
INSERT INTO `shop_truck_region` VALUES (3406, 3386, 'S', '石冈', '石冈区', 3, 'shigang', '422', 1, '120.780410', '24.274980');
INSERT INTO `shop_truck_region` VALUES (3407, 3386, 'W', '外埔', '外埔区', 3, 'waipu', '438', 1, '120.654370', '24.332010');
INSERT INTO `shop_truck_region` VALUES (3408, 3386, 'D', '大安', '大安区', 3, 'daan', '439', 1, '120.58652', '24.34607');
INSERT INTO `shop_truck_region` VALUES (3409, 3386, 'W', '乌日', '乌日区', 3, 'wuri', '414', 1, '120.623810', '24.104500');
INSERT INTO `shop_truck_region` VALUES (3410, 3386, 'D', '大肚', '大肚区', 3, 'dadu', '432', 1, '120.540960', '24.153660');
INSERT INTO `shop_truck_region` VALUES (3411, 3386, 'L', '龙井', '龙井区', 3, 'longjing', '434', 1, '120.545940', '24.192710');
INSERT INTO `shop_truck_region` VALUES (3412, 3386, 'W', '雾峰', '雾峰区', 3, 'wufeng', '413', 1, '120.700200', '24.061520');
INSERT INTO `shop_truck_region` VALUES (3413, 3386, 'T', '太平', '太平区', 3, 'taiping', '411', 1, '120.718523', '24.126472');
INSERT INTO `shop_truck_region` VALUES (3414, 3386, 'D', '大里', '大里区', 3, 'dali', '412', 1, '120.677860', '24.099390');
INSERT INTO `shop_truck_region` VALUES (3415, 3386, 'H', '和平', '和平区', 3, 'heping', '424', 1, '120.88349', '24.17477');
INSERT INTO `shop_truck_region` VALUES (3416, 3325, 'T', '台南', '台南市', 2, 'tainan', '7', 1, '120.279363', '23.172478');
INSERT INTO `shop_truck_region` VALUES (3417, 3416, 'D', '东区', '东区', 3, 'dongqu', '701', 1, '120.224198', '22.980072');
INSERT INTO `shop_truck_region` VALUES (3418, 3416, 'N', '南区', '南区', 3, 'nanqu', '702', 1, '120.188648', '22.960944');
INSERT INTO `shop_truck_region` VALUES (3419, 3416, 'B', '北区', '北区', 3, 'beiqu', '704', 1, '120.682410', '24.166040');
INSERT INTO `shop_truck_region` VALUES (3420, 3416, 'A', '安南', '安南区', 3, 'annan', '709', 1, '120.184617', '23.047230');
INSERT INTO `shop_truck_region` VALUES (3421, 3416, 'A', '安平', '安平区', 3, 'anping', '708', 1, '120.166810', '23.000763');
INSERT INTO `shop_truck_region` VALUES (3422, 3416, 'Z', '中西', '中西区', 3, 'zhongxi', '700', 1, '120.205957', '22.992152');
INSERT INTO `shop_truck_region` VALUES (3423, 3416, 'X', '新营', '新营区', 3, 'xinying', '730', 1, '120.316698', '23.310274');
INSERT INTO `shop_truck_region` VALUES (3424, 3416, 'Y', '盐水', '盐水区', 3, 'yanshui', '737', 1, '120.266398', '23.319828');
INSERT INTO `shop_truck_region` VALUES (3425, 3416, 'B', '白河', '白河区', 3, 'baihe', '732', 1, '120.415810', '23.351221');
INSERT INTO `shop_truck_region` VALUES (3426, 3416, 'L', '柳营', '柳营区', 3, 'liuying', '736', 1, '120.311286', '23.278133');
INSERT INTO `shop_truck_region` VALUES (3427, 3416, 'H', '后壁', '后壁区', 3, 'houbi', '731', 1, '120.362726', '23.366721');
INSERT INTO `shop_truck_region` VALUES (3428, 3416, 'D', '东山', '东山区', 3, 'dongshan', '733', 1, '120.403984', '23.326092');
INSERT INTO `shop_truck_region` VALUES (3429, 3416, 'M', '麻豆', '麻豆区', 3, 'madou', '721', 1, '120.248179', '23.181680');
INSERT INTO `shop_truck_region` VALUES (3430, 3416, 'X', '下营', '下营区', 3, 'xiaying', '735', 1, '120.264484', '23.235413');
INSERT INTO `shop_truck_region` VALUES (3431, 3416, 'L', '六甲', '六甲区', 3, 'liujia', '734', 1, '120.347600', '23.231931');
INSERT INTO `shop_truck_region` VALUES (3432, 3416, 'G', '官田', '官田区', 3, 'guantian', '720', 1, '120.314374', '23.194652');
INSERT INTO `shop_truck_region` VALUES (3433, 3416, 'D', '大内', '大内区', 3, 'dana', '742', 1, '120.348853', '23.119460');
INSERT INTO `shop_truck_region` VALUES (3434, 3416, 'J', '佳里', '佳里区', 3, 'jiali', '722', 1, '120.177211', '23.165121');
INSERT INTO `shop_truck_region` VALUES (3435, 3416, 'X', '学甲', '学甲区', 3, 'xuejia', '726', 1, '120.180255', '23.232348');
INSERT INTO `shop_truck_region` VALUES (3436, 3416, 'X', '西港', '西港区', 3, 'xigang', '723', 1, '120.203618', '23.123057');
INSERT INTO `shop_truck_region` VALUES (3437, 3416, 'Q', '七股', '七股区', 3, 'qigu', '724', 1, '120.140003', '23.140545');
INSERT INTO `shop_truck_region` VALUES (3438, 3416, 'J', '将军', '将军区', 3, 'jiangjun', '725', 1, '120.156871', '23.199543');
INSERT INTO `shop_truck_region` VALUES (3439, 3416, 'B', '北门', '北门区', 3, 'beimen', '727', 1, '120.125821', '23.267148');
INSERT INTO `shop_truck_region` VALUES (3440, 3416, 'X', '新化', '新化区', 3, 'xinhua', '712', 1, '120.310807', '23.038533');
INSERT INTO `shop_truck_region` VALUES (3441, 3416, 'S', '善化', '善化区', 3, 'shanhua', '741', 1, '120.296895', '23.132261');
INSERT INTO `shop_truck_region` VALUES (3442, 3416, 'X', '新市', '新市区', 3, 'xinshi', '744', 1, '120.295138', '23.07897');
INSERT INTO `shop_truck_region` VALUES (3443, 3416, 'A', '安定', '安定区', 3, 'anding', '745', 1, '120.237083', '23.121498');
INSERT INTO `shop_truck_region` VALUES (3444, 3416, 'S', '山上', '山上区', 3, 'shanshang', '743', 1, '120.352908', '23.103223');
INSERT INTO `shop_truck_region` VALUES (3445, 3416, 'Y', '玉井', '玉井区', 3, 'yujing', '714', 1, '120.460110', '23.123859');
INSERT INTO `shop_truck_region` VALUES (3446, 3416, NULL, '楠西', '楠西区', 3, 'nanxi', '715', 1, '120.485396', '23.173454');
INSERT INTO `shop_truck_region` VALUES (3447, 3416, 'N', '南化', '南化区', 3, 'nanhua', '716', 1, '120.477116', '23.042614');
INSERT INTO `shop_truck_region` VALUES (3448, 3416, 'Z', '左镇', '左镇区', 3, 'zuozhen', '713', 1, '120.407309', '23.057955');
INSERT INTO `shop_truck_region` VALUES (3449, 3416, 'R', '仁德', '仁德区', 3, 'rende', '717', 1, '120.251520', '22.972212');
INSERT INTO `shop_truck_region` VALUES (3450, 3416, 'G', '归仁', '归仁区', 3, 'guiren', '711', 1, '120.293791', '22.967081');
INSERT INTO `shop_truck_region` VALUES (3451, 3416, 'G', '关庙', '关庙区', 3, 'guanmiao', '718', 1, '120.327689', '22.962949');
INSERT INTO `shop_truck_region` VALUES (3452, 3416, 'L', '龙崎', '龙崎区', 3, 'longqi', '719', 1, '120.360824', '22.965681');
INSERT INTO `shop_truck_region` VALUES (3453, 3416, 'Y', '永康', '永康区', 3, 'yongkang', '710', 1, '120.257069', '23.026061');
INSERT INTO `shop_truck_region` VALUES (3454, 3325, 'X', '新竹', '新竹市', 2, 'hsinchu', '3', 1, '120.968798', '24.806738');
INSERT INTO `shop_truck_region` VALUES (3455, 3454, 'D', '东区', '东区', 3, 'dongqu', '300', 1, '120.970239', '24.801337');
INSERT INTO `shop_truck_region` VALUES (3456, 3454, 'B', '北区', '北区', 3, 'beiqu', '', 1, '120.682410', '24.166040');
INSERT INTO `shop_truck_region` VALUES (3457, 3454, 'X', '香山', '香山区', 3, 'xiangshan', '', 1, '120.956679', '24.768933');
INSERT INTO `shop_truck_region` VALUES (3458, 3325, 'J', '嘉义', '嘉义市', 2, 'chiayi', '6', 1, '120.452538', '23.481568');
INSERT INTO `shop_truck_region` VALUES (3459, 3458, 'D', '东区', '东区', 3, 'dongqu', '600', 1, '120.458009', '23.486213');
INSERT INTO `shop_truck_region` VALUES (3460, 3458, 'X', '西区', '西区', 3, 'xiqu', '600', 1, '120.437493', '23.473029');
INSERT INTO `shop_truck_region` VALUES (3461, 3325, 'X', '新北', '新北市', 2, 'newtaipei', '2', 1, '121.465746', '25.012366');
INSERT INTO `shop_truck_region` VALUES (3462, 3461, 'B', '板桥', '板桥区', 3, 'banqiao', '220', 1, '121.459084', '25.009578');
INSERT INTO `shop_truck_region` VALUES (3463, 3461, 'S', '三重', '三重区', 3, 'sanzhong', '241', 1, '121.488102', '25.061486');
INSERT INTO `shop_truck_region` VALUES (3464, 3461, 'Z', '中和', '中和区', 3, 'zhonghe', '235', 1, '121.498980', '24.999397');
INSERT INTO `shop_truck_region` VALUES (3465, 3461, 'Y', '永和', '永和区', 3, 'yonghe', '234', 1, '121.513660', '25.007802');
INSERT INTO `shop_truck_region` VALUES (3466, 3461, 'X', '新庄', '新庄区', 3, 'xinzhuang', '242', 1, '121.450413', '25.035947');
INSERT INTO `shop_truck_region` VALUES (3467, 3461, 'X', '新店', '新店区', 3, 'xindian', '231', 1, '121.541750', '24.967558');
INSERT INTO `shop_truck_region` VALUES (3468, 3461, 'S', '树林', '树林区', 3, 'shulin', '238', 1, '121.420533', '24.990706');
INSERT INTO `shop_truck_region` VALUES (3469, 3461, NULL, '莺歌', '莺歌区', 3, 'yingge', '239', 1, '121.354573', '24.955413');
INSERT INTO `shop_truck_region` VALUES (3470, 3461, 'S', '三峡', '三峡区', 3, 'sanxia', '237', 1, '121.368905', '24.934339');
INSERT INTO `shop_truck_region` VALUES (3471, 3461, 'D', '淡水', '淡水区', 3, 'danshui', '251', 1, '121.440915', '25.169452');
INSERT INTO `shop_truck_region` VALUES (3472, 3461, 'X', '汐止', '汐止区', 3, 'xizhi', '221', 1, '121.629470', '25.062999');
INSERT INTO `shop_truck_region` VALUES (3473, 3461, 'R', '瑞芳', '瑞芳区', 3, 'ruifang', '224', 1, '121.810061', '25.108895');
INSERT INTO `shop_truck_region` VALUES (3474, 3461, 'T', '土城', '土城区', 3, 'tucheng', '236', 1, '121.443348', '24.972201');
INSERT INTO `shop_truck_region` VALUES (3475, 3461, 'L', '芦洲', '芦洲区', 3, 'luzhou', '247', 1, '121.473700', '25.084923');
INSERT INTO `shop_truck_region` VALUES (3476, 3461, 'W', '五股', '五股区', 3, 'wugu', '248', 1, '121.438156', '25.082743');
INSERT INTO `shop_truck_region` VALUES (3477, 3461, 'T', '泰山', '泰山区', 3, 'taishan', '243', 1, '121.430811', '25.058864');
INSERT INTO `shop_truck_region` VALUES (3478, 3461, 'L', '林口', '林口区', 3, 'linkou', '244', 1, '121.391602', '25.077531');
INSERT INTO `shop_truck_region` VALUES (3479, 3461, 'S', '深坑', '深坑区', 3, 'shenkeng', '222', 1, '121.615670', '25.002329');
INSERT INTO `shop_truck_region` VALUES (3480, 3461, 'S', '石碇', '石碇区', 3, 'shiding', '223', 1, '121.658567', '24.991679');
INSERT INTO `shop_truck_region` VALUES (3481, 3461, 'P', '坪林', '坪林区', 3, 'pinglin', '232', 1, '121.711185', '24.937388');
INSERT INTO `shop_truck_region` VALUES (3482, 3461, 'S', '三芝', '三芝区', 3, 'sanzhi', '252', 1, '121.500866', '25.258047');
INSERT INTO `shop_truck_region` VALUES (3483, 3461, 'S', '石门', '石门区', 3, 'shimen', '253', 1, '121.568491', '25.290412');
INSERT INTO `shop_truck_region` VALUES (3484, 3461, 'B', '八里', '八里区', 3, 'bali', '249', 1, '121.398227', '25.146680');
INSERT INTO `shop_truck_region` VALUES (3485, 3461, 'P', '平溪', '平溪区', 3, 'pingxi', '226', 1, '121.738255', '25.025725');
INSERT INTO `shop_truck_region` VALUES (3486, 3461, 'S', '双溪', '双溪区', 3, 'shuangxi', '227', 1, '121.865676', '25.033409');
INSERT INTO `shop_truck_region` VALUES (3487, 3461, 'G', '贡寮', '贡寮区', 3, 'gongliao', '228', 1, '121.908185', '25.022388');
INSERT INTO `shop_truck_region` VALUES (3488, 3461, 'J', '金山', '金山区', 3, 'jinshan', '208', 1, '121.636427', '25.221883');
INSERT INTO `shop_truck_region` VALUES (3489, 3461, 'W', '万里', '万里区', 3, 'wanli', '207', 1, '121.688687', '25.181234');
INSERT INTO `shop_truck_region` VALUES (3490, 3461, 'W', '乌来', '乌来区', 3, 'wulai', '233', 1, '121.550531', '24.865296');
INSERT INTO `shop_truck_region` VALUES (3491, 3325, 'Y', '宜兰', '宜兰县', 2, 'yilan', '2', 1, '121.500000', '24.600000');
INSERT INTO `shop_truck_region` VALUES (3492, 3491, 'Y', '宜兰', '宜兰市', 3, 'yilan', '260', 1, '121.753476', '24.751682');
INSERT INTO `shop_truck_region` VALUES (3493, 3491, 'L', '罗东', '罗东镇', 3, 'luodong', '265', 1, '121.766919', '24.677033');
INSERT INTO `shop_truck_region` VALUES (3494, 3491, 'S', '苏澳', '苏澳镇', 3, 'suao', '270', 1, '121.842656', '24.594622');
INSERT INTO `shop_truck_region` VALUES (3495, 3491, 'T', '头城', '头城镇', 3, 'toucheng', '261', 1, '121.823307', '24.859217');
INSERT INTO `shop_truck_region` VALUES (3496, 3491, 'J', '礁溪', '礁溪乡', 3, 'jiaoxi', '262', 1, '121.766680', '24.822345');
INSERT INTO `shop_truck_region` VALUES (3497, 3491, 'Z', '壮围', '壮围乡', 3, 'zhuangwei', '263', 1, '121.781619', '24.744949');
INSERT INTO `shop_truck_region` VALUES (3498, 3491, 'Y', '员山', '员山乡', 3, 'yuanshan', '264', 1, '121.721733', '24.741771');
INSERT INTO `shop_truck_region` VALUES (3499, 3491, 'D', '冬山', '冬山乡', 3, 'dongshan', '269', 1, '121.792280', '24.634514');
INSERT INTO `shop_truck_region` VALUES (3500, 3491, 'W', '五结', '五结乡', 3, 'wujie', '268', 1, '121.798297', '24.684640');
INSERT INTO `shop_truck_region` VALUES (3501, 3491, 'S', '三星', '三星乡', 3, 'sanxing', '266', 1, '121.003418', '23.775291');
INSERT INTO `shop_truck_region` VALUES (3502, 3491, 'D', '大同', '大同乡', 3, 'datong', '267', 1, '121.605557', '24.675997');
INSERT INTO `shop_truck_region` VALUES (3503, 3491, 'N', '南澳', '南澳乡', 3, 'nanao', '272', 1, '121.799810', '24.465393');
INSERT INTO `shop_truck_region` VALUES (3504, 3325, 'T', '桃园', '桃园县', 2, 'taoyuan', '3', 1, '121.083000', '25.000000');
INSERT INTO `shop_truck_region` VALUES (3505, 3504, 'T', '桃园', '桃园市', 3, 'taoyuan', '330', 1, '121.301337', '24.993777');
INSERT INTO `shop_truck_region` VALUES (3506, 3504, 'Z', '中坜', '中坜市', 3, 'zhongli', '320', 1, '121.224926', '24.965353');
INSERT INTO `shop_truck_region` VALUES (3507, 3504, 'P', '平镇', '平镇市', 3, 'pingzhen', '324', 1, '121.218359', '24.945752');
INSERT INTO `shop_truck_region` VALUES (3508, 3504, 'B', '八德', '八德市', 3, 'bade', '334', 1, '121.284655', '24.928651');
INSERT INTO `shop_truck_region` VALUES (3509, 3504, 'Y', '杨梅', '杨梅市', 3, 'yangmei', '326', 1, '121.145873', '24.907575');
INSERT INTO `shop_truck_region` VALUES (3510, 3504, 'L', '芦竹', '芦竹市', 3, 'luzhu', '338', 1, '121.292064', '25.045392');
INSERT INTO `shop_truck_region` VALUES (3511, 3504, 'D', '大溪', '大溪镇', 3, 'daxi', '335', 1, '121.286962', '24.880584');
INSERT INTO `shop_truck_region` VALUES (3512, 3504, 'D', '大园', '大园乡', 3, 'dayuan', '337', 1, '121.196292', '25.064471');
INSERT INTO `shop_truck_region` VALUES (3513, 3504, 'G', '龟山', '龟山乡', 3, 'guishan', '333', 1, '121.337767', '24.992517');
INSERT INTO `shop_truck_region` VALUES (3514, 3504, 'L', '龙潭', '龙潭乡', 3, 'longtan', '325', 1, '121.216392', '24.863851');
INSERT INTO `shop_truck_region` VALUES (3515, 3504, 'X', '新屋', '新屋乡', 3, 'xinwu', '327', 1, '121.105801', '24.972203');
INSERT INTO `shop_truck_region` VALUES (3516, 3504, 'G', '观音', '观音乡', 3, 'guanyin', '328', 1, '121.077519', '25.033303');
INSERT INTO `shop_truck_region` VALUES (3517, 3504, 'F', '复兴', '复兴乡', 3, 'fuxing', '336', 1, '121.352613', '24.820908');
INSERT INTO `shop_truck_region` VALUES (3518, 3325, 'X', '新竹', '新竹县', 2, 'hsinchu', '3', 1, '121.160000', '24.600000');
INSERT INTO `shop_truck_region` VALUES (3519, 3518, 'Z', '竹北', '竹北市', 3, 'zhubei', '302', 1, '121.004317', '24.839652');
INSERT INTO `shop_truck_region` VALUES (3520, 3518, 'Z', '竹东', '竹东镇', 3, 'zhudong', '310', 1, '121.086418', '24.733601');
INSERT INTO `shop_truck_region` VALUES (3521, 3518, 'X', '新埔', '新埔镇', 3, 'xinpu', '305', 1, '121.072804', '24.824820');
INSERT INTO `shop_truck_region` VALUES (3522, 3518, 'G', '关西', '关西镇', 3, 'guanxi', '306', 1, '121.177301', '24.788842');
INSERT INTO `shop_truck_region` VALUES (3523, 3518, 'H', '湖口', '湖口乡', 3, 'hukou', '303', 1, '121.043691', '24.903943');
INSERT INTO `shop_truck_region` VALUES (3524, 3518, 'X', '新丰', '新丰乡', 3, 'xinfeng', '304', 1, '120.983006', '24.899600');
INSERT INTO `shop_truck_region` VALUES (3525, 3518, NULL, '芎林', '芎林乡', 3, 'xionglin', '307', 1, '121.076924', '24.774436');
INSERT INTO `shop_truck_region` VALUES (3526, 3518, 'H', '横山', '横山乡', 3, 'hengshan', '312', 1, '121.116244', '24.720807');
INSERT INTO `shop_truck_region` VALUES (3527, 3518, 'B', '北埔', '北埔乡', 3, 'beipu', '314', 1, '121.053156', '24.697126');
INSERT INTO `shop_truck_region` VALUES (3528, 3518, 'B', '宝山', '宝山乡', 3, 'baoshan', '308', 1, '120.985752', '24.760975');
INSERT INTO `shop_truck_region` VALUES (3529, 3518, 'E', '峨眉', '峨眉乡', 3, 'emei', '315', 1, '121.015291', '24.686127');
INSERT INTO `shop_truck_region` VALUES (3530, 3518, 'J', '尖石', '尖石乡', 3, 'jianshi', '313', 1, '121.197802', '24.704360');
INSERT INTO `shop_truck_region` VALUES (3531, 3518, 'W', '五峰', '五峰乡', 3, 'wufeng', '311', 1, '121.003418', '23.775291');
INSERT INTO `shop_truck_region` VALUES (3532, 3325, 'M', '苗栗', '苗栗县', 2, 'miaoli', '3', 1, '120.750000', '24.500000');
INSERT INTO `shop_truck_region` VALUES (3533, 3532, 'M', '苗栗', '苗栗市', 3, 'miaoli', '360', 1, '120.818869', '24.561472');
INSERT INTO `shop_truck_region` VALUES (3534, 3532, 'Y', '苑里', '苑里镇', 3, 'yuanli', '358', 1, '120.648907', '24.441750');
INSERT INTO `shop_truck_region` VALUES (3535, 3532, 'T', '通霄', '通霄镇', 3, 'tongxiao', '357', 1, '120.676700', '24.489087');
INSERT INTO `shop_truck_region` VALUES (3536, 3532, 'Z', '竹南', '竹南镇', 3, 'zhunan', '350', 1, '120.872641', '24.685513');
INSERT INTO `shop_truck_region` VALUES (3537, 3532, 'T', '头份', '头份镇', 3, 'toufen', '351', 1, '120.895188', '24.687993');
INSERT INTO `shop_truck_region` VALUES (3538, 3532, 'H', '后龙', '后龙镇', 3, 'houlong', '356', 1, '120.786480', '24.612617');
INSERT INTO `shop_truck_region` VALUES (3539, 3532, 'Z', '卓兰', '卓兰镇', 3, 'zhuolan', '369', 1, '120.823441', '24.309509');
INSERT INTO `shop_truck_region` VALUES (3540, 3532, 'D', '大湖', '大湖乡', 3, 'dahu', '364', 1, '120.863641', '24.422547');
INSERT INTO `shop_truck_region` VALUES (3541, 3532, 'G', '公馆', '公馆乡', 3, 'gongguan', '363', 1, '120.822983', '24.499108');
INSERT INTO `shop_truck_region` VALUES (3542, 3532, 'T', '铜锣', '铜锣乡', 3, 'tongluo', '366', 1, '121.003418', '23.775291');
INSERT INTO `shop_truck_region` VALUES (3543, 3532, 'N', '南庄', '南庄乡', 3, 'nanzhuang', '353', 1, '120.994957', '24.596835');
INSERT INTO `shop_truck_region` VALUES (3544, 3532, 'T', '头屋', '头屋乡', 3, 'touwu', '362', 1, '120.846616', '24.574249');
INSERT INTO `shop_truck_region` VALUES (3545, 3532, 'S', '三义', '三义乡', 3, 'sanyi', '367', 1, '120.742340', '24.350270');
INSERT INTO `shop_truck_region` VALUES (3546, 3532, 'X', '西湖', '西湖乡', 3, 'xihu', '368', 1, '121.003418', '23.775291');
INSERT INTO `shop_truck_region` VALUES (3547, 3532, 'Z', '造桥', '造桥乡', 3, 'zaoqiao', '361', 1, '120.862399', '24.637537');
INSERT INTO `shop_truck_region` VALUES (3548, 3532, 'S', '三湾', '三湾乡', 3, 'sanwan', '352', 1, '120.951484', '24.651051');
INSERT INTO `shop_truck_region` VALUES (3549, 3532, 'S', '狮潭', '狮潭乡', 3, 'shitan', '354', 1, '120.918024', '24.540004');
INSERT INTO `shop_truck_region` VALUES (3550, 3532, 'T', '泰安', '泰安乡', 3, 'taian', '365', 1, '120.904441', '24.442600');
INSERT INTO `shop_truck_region` VALUES (3551, 3325, 'Z', '彰化', '彰化县', 2, 'changhua', '5', 1, '120.416000', '24.000000');
INSERT INTO `shop_truck_region` VALUES (3552, 3551, 'Z', '彰化市', '彰化市', 3, 'zhanghuashi', '500', 1, '120.542294', '24.080911');
INSERT INTO `shop_truck_region` VALUES (3553, 3551, 'L', '鹿港', '鹿港镇', 3, 'lugang', '505', 1, '120.435392', '24.056937');
INSERT INTO `shop_truck_region` VALUES (3554, 3551, 'H', '和美', '和美镇', 3, 'hemei', '508', 1, '120.500265', '24.110904');
INSERT INTO `shop_truck_region` VALUES (3555, 3551, 'X', '线西', '线西乡', 3, 'xianxi', '507', 1, '120.465921', '24.128653');
INSERT INTO `shop_truck_region` VALUES (3556, 3551, 'S', '伸港', '伸港乡', 3, 'shengang', '509', 1, '120.484224', '24.146081');
INSERT INTO `shop_truck_region` VALUES (3557, 3551, 'F', '福兴', '福兴乡', 3, 'fuxing', '506', 1, '120.443682', '24.047883');
INSERT INTO `shop_truck_region` VALUES (3558, 3551, 'X', '秀水', '秀水乡', 3, 'xiushui', '504', 1, '120.502658', '24.035267');
INSERT INTO `shop_truck_region` VALUES (3559, 3551, 'H', '花坛', '花坛乡', 3, 'huatan', '503', 1, '120.538403', '24.029399');
INSERT INTO `shop_truck_region` VALUES (3560, 3551, 'F', '芬园', '芬园乡', 3, 'fenyuan', '502', 1, '120.629024', '24.013658');
INSERT INTO `shop_truck_region` VALUES (3561, 3551, 'Y', '员林', '员林镇', 3, 'yuanlin', '510', 1, '120.574625', '23.958999');
INSERT INTO `shop_truck_region` VALUES (3562, 3551, 'X', '溪湖', '溪湖镇', 3, 'xihu', '514', 1, '120.479144', '23.962315');
INSERT INTO `shop_truck_region` VALUES (3563, 3551, 'T', '田中', '田中镇', 3, 'tianzhong', '520', 1, '120.580629', '23.861718');
INSERT INTO `shop_truck_region` VALUES (3564, 3551, 'D', '大村', '大村乡', 3, 'dacun', '515', 1, '120.540713', '23.993726');
INSERT INTO `shop_truck_region` VALUES (3565, 3551, 'P', '埔盐', '埔盐乡', 3, 'puyan', '516', 1, '120.464044', '24.000346');
INSERT INTO `shop_truck_region` VALUES (3566, 3551, 'P', '埔心', '埔心乡', 3, 'puxin', '513', 1, '120.543568', '23.953019');
INSERT INTO `shop_truck_region` VALUES (3567, 3551, 'Y', '永靖', '永靖乡', 3, 'yongjing', '512', 1, '120.547775', '23.924703');
INSERT INTO `shop_truck_region` VALUES (3568, 3551, 'S', '社头', '社头乡', 3, 'shetou', '511', 1, '120.582681', '23.896686');
INSERT INTO `shop_truck_region` VALUES (3569, 3551, 'E', '二水', '二水乡', 3, 'ershui', '530', 1, '120.618788', '23.806995');
INSERT INTO `shop_truck_region` VALUES (3570, 3551, 'B', '北斗', '北斗镇', 3, 'beidou', '521', 1, '120.520449', '23.870911');
INSERT INTO `shop_truck_region` VALUES (3571, 3551, 'E', '二林', '二林镇', 3, 'erlin', '526', 1, '120.374468', '23.899751');
INSERT INTO `shop_truck_region` VALUES (3572, 3551, 'T', '田尾', '田尾乡', 3, 'tianwei', '522', 1, '120.524717', '23.890735');
INSERT INTO `shop_truck_region` VALUES (3573, 3551, NULL, '埤头', '埤头乡', 3, 'pitou', '523', 1, '120.462599', '23.891324');
INSERT INTO `shop_truck_region` VALUES (3574, 3551, 'F', '芳苑', '芳苑乡', 3, 'fangyuan', '528', 1, '120.320329', '23.924222');
INSERT INTO `shop_truck_region` VALUES (3575, 3551, 'D', '大城', '大城乡', 3, 'dacheng', '527', 1, '120.320934', '23.852382');
INSERT INTO `shop_truck_region` VALUES (3576, 3551, 'Z', '竹塘', '竹塘乡', 3, 'zhutang', '525', 1, '120.427499', '23.860112');
INSERT INTO `shop_truck_region` VALUES (3577, 3551, 'X', '溪州', '溪州乡', 3, 'xizhou', '524', 1, '120.498706', '23.851229');
INSERT INTO `shop_truck_region` VALUES (3578, 3325, 'N', '南投', '南投县', 2, 'nantou', '5', 1, '120.830000', '23.830000');
INSERT INTO `shop_truck_region` VALUES (3579, 3578, 'N', '南投市', '南投市', 3, 'nantoushi', '540', 1, '120.683706', '23.909956');
INSERT INTO `shop_truck_region` VALUES (3580, 3578, 'P', '埔里', '埔里镇', 3, 'puli', '545', 1, '120.964648', '23.964789');
INSERT INTO `shop_truck_region` VALUES (3581, 3578, 'C', '草屯', '草屯镇', 3, 'caotun', '542', 1, '120.680343', '23.973947');
INSERT INTO `shop_truck_region` VALUES (3582, 3578, 'Z', '竹山', '竹山镇', 3, 'zhushan', '557', 1, '120.672007', '23.757655');
INSERT INTO `shop_truck_region` VALUES (3583, 3578, 'J', '集集', '集集镇', 3, 'jiji', '552', 1, '120.783673', '23.829013');
INSERT INTO `shop_truck_region` VALUES (3584, 3578, 'M', '名间', '名间乡', 3, 'mingjian', '551', 1, '120.702797', '23.838427');
INSERT INTO `shop_truck_region` VALUES (3585, 3578, 'L', '鹿谷', '鹿谷乡', 3, 'lugu', '558', 1, '120.752796', '23.744471');
INSERT INTO `shop_truck_region` VALUES (3586, 3578, 'Z', '中寮', '中寮乡', 3, 'zhongliao', '541', 1, '120.766654', '23.878935');
INSERT INTO `shop_truck_region` VALUES (3587, 3578, 'Y', '鱼池', '鱼池乡', 3, 'yuchi', '555', 1, '120.936060', '23.896356');
INSERT INTO `shop_truck_region` VALUES (3588, 3578, 'G', '国姓', '国姓乡', 3, 'guoxing', '544', 1, '120.858541', '24.042298');
INSERT INTO `shop_truck_region` VALUES (3589, 3578, 'S', '水里', '水里乡', 3, 'shuili', '553', 1, '120.855912', '23.812086');
INSERT INTO `shop_truck_region` VALUES (3590, 3578, 'X', '信义', '信义乡', 3, 'xinyi', '556', 1, '120.855257', '23.699922');
INSERT INTO `shop_truck_region` VALUES (3591, 3578, 'R', '仁爱', '仁爱乡', 3, 'renai', '546', 1, '121.133543', '24.024429');
INSERT INTO `shop_truck_region` VALUES (3592, 3325, 'Y', '云林', '云林县', 2, 'yunlin', '6', 1, '120.250000', '23.750000');
INSERT INTO `shop_truck_region` VALUES (3593, 3592, 'D', '斗六', '斗六市', 3, 'douliu', '640', 1, '120.527360', '23.697651');
INSERT INTO `shop_truck_region` VALUES (3594, 3592, 'D', '斗南', '斗南镇', 3, 'dounan', '630', 1, '120.479075', '23.679731');
INSERT INTO `shop_truck_region` VALUES (3595, 3592, 'H', '虎尾', '虎尾镇', 3, 'huwei', '632', 1, '120.445339', '23.708182');
INSERT INTO `shop_truck_region` VALUES (3596, 3592, 'X', '西螺', '西螺镇', 3, 'xiluo', '648', 1, '120.466010', '23.797984');
INSERT INTO `shop_truck_region` VALUES (3597, 3592, 'T', '土库', '土库镇', 3, 'tuku', '633', 1, '120.392572', '23.677822');
INSERT INTO `shop_truck_region` VALUES (3598, 3592, 'B', '北港', '北港镇', 3, 'beigang', '651', 1, '120.302393', '23.575525');
INSERT INTO `shop_truck_region` VALUES (3599, 3592, 'G', '古坑', '古坑乡', 3, 'gukeng', '646', 1, '120.562043', '23.642568');
INSERT INTO `shop_truck_region` VALUES (3600, 3592, 'D', '大埤', '大埤乡', 3, 'dapi', '631', 1, '120.430516', '23.645908');
INSERT INTO `shop_truck_region` VALUES (3601, 3592, NULL, '莿桐', '莿桐乡', 3, 'citong', '647', 1, '120.502374', '23.760784');
INSERT INTO `shop_truck_region` VALUES (3602, 3592, 'L', '林内', '林内乡', 3, 'linna', '643', 1, '120.611365', '23.758712');
INSERT INTO `shop_truck_region` VALUES (3603, 3592, 'E', '二仑', '二仑乡', 3, 'erlun', '649', 1, '120.415077', '23.771273');
INSERT INTO `shop_truck_region` VALUES (3604, 3592, 'L', '仑背', '仑背乡', 3, 'lunbei', '637', 1, '120.353895', '23.758840');
INSERT INTO `shop_truck_region` VALUES (3605, 3592, 'M', '麦寮', '麦寮乡', 3, 'mailiao', '638', 1, '120.252043', '23.753841');
INSERT INTO `shop_truck_region` VALUES (3606, 3592, 'D', '东势', '东势乡', 3, 'dongshi', '635', 1, '120.252672', '23.674679');
INSERT INTO `shop_truck_region` VALUES (3607, 3592, 'B', '褒忠', '褒忠乡', 3, 'baozhong', '634', 1, '120.310488', '23.694245');
INSERT INTO `shop_truck_region` VALUES (3608, 3592, 'T', '台西', '台西乡', 3, 'taixi', '636', 1, '120.196141', '23.702819');
INSERT INTO `shop_truck_region` VALUES (3609, 3592, 'Y', '元长', '元长乡', 3, 'yuanchang', '655', 1, '120.315124', '23.649458');
INSERT INTO `shop_truck_region` VALUES (3610, 3592, 'S', '四湖', '四湖乡', 3, 'sihu', '654', 1, '120.225741', '23.637740');
INSERT INTO `shop_truck_region` VALUES (3611, 3592, 'K', '口湖', '口湖乡', 3, 'kouhu', '653', 1, '120.185370', '23.582406');
INSERT INTO `shop_truck_region` VALUES (3612, 3592, 'S', '水林', '水林乡', 3, 'shuilin', '652', 1, '120.245948', '23.572634');
INSERT INTO `shop_truck_region` VALUES (3613, 3325, 'J', '嘉义', '嘉义县', 2, 'chiayi', '6', 1, '120.300000', '23.500000');
INSERT INTO `shop_truck_region` VALUES (3614, 3613, 'T', '太保', '太保市', 3, 'taibao', '612', 1, '120.332876', '23.459647');
INSERT INTO `shop_truck_region` VALUES (3615, 3613, 'P', '朴子', '朴子市', 3, 'puzi', '613', 1, '120.247014', '23.464961');
INSERT INTO `shop_truck_region` VALUES (3616, 3613, 'B', '布袋', '布袋镇', 3, 'budai', '625', 1, '120.166936', '23.377979');
INSERT INTO `shop_truck_region` VALUES (3617, 3613, 'D', '大林', '大林镇', 3, 'dalin', '622', 1, '120.471336', '23.603815');
INSERT INTO `shop_truck_region` VALUES (3618, 3613, 'M', '民雄', '民雄乡', 3, 'minxiong', '621', 1, '120.428577', '23.551456');
INSERT INTO `shop_truck_region` VALUES (3619, 3613, 'X', '溪口', '溪口乡', 3, 'xikou', '623', 1, '120.393822', '23.602223');
INSERT INTO `shop_truck_region` VALUES (3620, 3613, 'X', '新港', '新港乡', 3, 'xingang', '616', 1, '120.347647', '23.551806');
INSERT INTO `shop_truck_region` VALUES (3621, 3613, 'L', '六脚', '六脚乡', 3, 'liujiao', '615', 1, '120.291083', '23.493942');
INSERT INTO `shop_truck_region` VALUES (3622, 3613, 'D', '东石', '东石乡', 3, 'dongshi', '614', 1, '120.153822', '23.459235');
INSERT INTO `shop_truck_region` VALUES (3623, 3613, 'Y', '义竹', '义竹乡', 3, 'yizhu', '624', 1, '120.243423', '23.336277');
INSERT INTO `shop_truck_region` VALUES (3624, 3613, 'L', '鹿草', '鹿草乡', 3, 'lucao', '611', 1, '120.308370', '23.410784');
INSERT INTO `shop_truck_region` VALUES (3625, 3613, 'S', '水上', '水上乡', 3, 'shuishang', '608', 1, '120.397936', '23.428104');
INSERT INTO `shop_truck_region` VALUES (3626, 3613, 'Z', '中埔', '中埔乡', 3, 'zhongpu', '606', 1, '120.522948', '23.425148');
INSERT INTO `shop_truck_region` VALUES (3627, 3613, 'Z', '竹崎', '竹崎乡', 3, 'zhuqi', '604', 1, '120.551466', '23.523184');
INSERT INTO `shop_truck_region` VALUES (3628, 3613, 'M', '梅山', '梅山乡', 3, 'meishan', '603', 1, '120.557192', '23.584915');
INSERT INTO `shop_truck_region` VALUES (3629, 3613, 'F', '番路', '番路乡', 3, 'fanlu', '602', 1, '120.555043', '23.465222');
INSERT INTO `shop_truck_region` VALUES (3630, 3613, 'D', '大埔', '大埔乡', 3, 'dapu', '607', 1, '120.593795', '23.296715');
INSERT INTO `shop_truck_region` VALUES (3631, 3613, 'A', '阿里山', '阿里山乡', 3, 'alishan', '605', 1, '120.732520', '23.467950');
INSERT INTO `shop_truck_region` VALUES (3632, 3325, 'P', '屏东', '屏东县', 2, 'pingtung', '9', 1, '120.487928', '22.682802');
INSERT INTO `shop_truck_region` VALUES (3633, 3632, 'P', '屏东', '屏东市', 3, 'pingdong', '900', 1, '120.488465', '22.669723');
INSERT INTO `shop_truck_region` VALUES (3634, 3632, 'C', '潮州', '潮州镇', 3, 'chaozhou', '920', 1, '120.542854', '22.550536');
INSERT INTO `shop_truck_region` VALUES (3635, 3632, 'D', '东港', '东港镇', 3, 'donggang', '928', 1, '120.454489', '22.466626');
INSERT INTO `shop_truck_region` VALUES (3636, 3632, 'H', '恒春', '恒春镇', 3, 'hengchun', '946', 1, '120.745451', '22.002373');
INSERT INTO `shop_truck_region` VALUES (3637, 3632, 'W', '万丹', '万丹乡', 3, 'wandan', '913', 1, '120.484533', '22.589839');
INSERT INTO `shop_truck_region` VALUES (3638, 3632, 'C', '长治', '长治乡', 3, 'changzhi', '908', 1, '120.527614', '22.677062');
INSERT INTO `shop_truck_region` VALUES (3639, 3632, NULL, '麟洛', '麟洛乡', 3, 'linluo', '909', 1, '120.527283', '22.650604');
INSERT INTO `shop_truck_region` VALUES (3640, 3632, 'J', '九如', '九如乡', 3, 'jiuru', '904', 1, '120.490142', '22.739778');
INSERT INTO `shop_truck_region` VALUES (3641, 3632, 'L', '里港', '里港乡', 3, 'ligang', '905', 1, '120.494490', '22.779220');
INSERT INTO `shop_truck_region` VALUES (3642, 3632, 'Y', '盐埔', '盐埔乡', 3, 'yanpu', '907', 1, '120.572849', '22.754783');
INSERT INTO `shop_truck_region` VALUES (3643, 3632, 'G', '高树', '高树乡', 3, 'gaoshu', '906', 1, '120.600214', '22.826789');
INSERT INTO `shop_truck_region` VALUES (3644, 3632, 'W', '万峦', '万峦乡', 3, 'wanluan', '923', 1, '120.566477', '22.571965');
INSERT INTO `shop_truck_region` VALUES (3645, 3632, 'N', '内埔', '内埔乡', 3, 'napu', '912', 1, '120.566865', '22.611967');
INSERT INTO `shop_truck_region` VALUES (3646, 3632, 'Z', '竹田', '竹田乡', 3, 'zhutian', '911', 1, '120.544038', '22.584678');
INSERT INTO `shop_truck_region` VALUES (3647, 3632, 'X', '新埤', '新埤乡', 3, 'xinpi', '925', 1, '120.549546', '22.469976');
INSERT INTO `shop_truck_region` VALUES (3648, 3632, NULL, '枋寮', '枋寮乡', 3, 'fangliao', '940', 1, '120.593438', '22.365560');
INSERT INTO `shop_truck_region` VALUES (3649, 3632, 'X', '新园', '新园乡', 3, 'xinyuan', '932', 1, '120.461739', '22.543952');
INSERT INTO `shop_truck_region` VALUES (3650, 3632, NULL, '崁顶', '崁顶乡', 3, 'kanding', '924', 1, '120.514571', '22.514795');
INSERT INTO `shop_truck_region` VALUES (3651, 3632, 'L', '林边', '林边乡', 3, 'linbian', '927', 1, '120.515091', '22.434015');
INSERT INTO `shop_truck_region` VALUES (3652, 3632, 'N', '南州', '南州乡', 3, 'nanzhou', '926', 1, '120.509808', '22.490192');
INSERT INTO `shop_truck_region` VALUES (3653, 3632, 'J', '佳冬', '佳冬乡', 3, 'jiadong', '931', 1, '120.551544', '22.417653');
INSERT INTO `shop_truck_region` VALUES (3654, 3632, 'L', '琉球', '琉球乡', 3, 'liuqiu', '929', 1, '120.369020', '22.342366');
INSERT INTO `shop_truck_region` VALUES (3655, 3632, 'C', '车城', '车城乡', 3, 'checheng', '944', 1, '120.710979', '22.072077');
INSERT INTO `shop_truck_region` VALUES (3656, 3632, 'M', '满州', '满州乡', 3, 'manzhou', '947', 1, '120.838843', '22.020853');
INSERT INTO `shop_truck_region` VALUES (3657, 3632, NULL, '枋山', '枋山乡', 3, 'fangshan', '941', 1, '120.656356', '22.260338');
INSERT INTO `shop_truck_region` VALUES (3658, 3632, 'S', '三地门', '三地门乡', 3, 'sandimen', '901', 1, '120.654486', '22.713877');
INSERT INTO `shop_truck_region` VALUES (3659, 3632, 'W', '雾台', '雾台乡', 3, 'wutai', '902', 1, '120.732318', '22.744877');
INSERT INTO `shop_truck_region` VALUES (3660, 3632, 'M', '玛家', '玛家乡', 3, 'majia', '903', 1, '120.644130', '22.706718');
INSERT INTO `shop_truck_region` VALUES (3661, 3632, 'T', '泰武', '泰武乡', 3, 'taiwu', '921', 1, '120.632856', '22.591819');
INSERT INTO `shop_truck_region` VALUES (3662, 3632, 'L', '来义', '来义乡', 3, 'laiyi', '922', 1, '120.633601', '22.525866');
INSERT INTO `shop_truck_region` VALUES (3663, 3632, 'C', '春日', '春日乡', 3, 'chunri', '942', 1, '120.628793', '22.370672');
INSERT INTO `shop_truck_region` VALUES (3664, 3632, 'S', '狮子', '狮子乡', 3, 'shizi', '943', 1, '120.704617', '22.201917');
INSERT INTO `shop_truck_region` VALUES (3665, 3632, 'M', '牡丹', '牡丹乡', 3, 'mudan', '945', 1, '120.770108', '22.125687');
INSERT INTO `shop_truck_region` VALUES (3666, 3325, 'T', '台东', '台东县', 2, 'taitung', '9', 1, '120.916000', '23.000000');
INSERT INTO `shop_truck_region` VALUES (3667, 3666, 'T', '台东', '台东市', 3, 'taidong', '950', 1, '121.145654', '22.756045');
INSERT INTO `shop_truck_region` VALUES (3668, 3666, 'C', '成功', '成功镇', 3, 'chenggong', '961', 1, '121.379571', '23.100223');
INSERT INTO `shop_truck_region` VALUES (3669, 3666, 'G', '关山', '关山镇', 3, 'guanshan', '956', 1, '121.163134', '23.047450');
INSERT INTO `shop_truck_region` VALUES (3670, 3666, 'B', '卑南', '卑南乡', 3, 'beinan', '954', 1, '121.083503', '22.786039');
INSERT INTO `shop_truck_region` VALUES (3671, 3666, 'L', '鹿野', '鹿野乡', 3, 'luye', '955', 1, '121.135982', '22.913951');
INSERT INTO `shop_truck_region` VALUES (3672, 3666, 'C', '池上', '池上乡', 3, 'chishang', '958', 1, '121.215139', '23.122393');
INSERT INTO `shop_truck_region` VALUES (3673, 3666, 'D', '东河', '东河乡', 3, 'donghe', '959', 1, '121.300334', '22.969934');
INSERT INTO `shop_truck_region` VALUES (3674, 3666, 'C', '长滨', '长滨乡', 3, 'changbin', '962', 1, '121.451522', '23.315041');
INSERT INTO `shop_truck_region` VALUES (3675, 3666, 'T', '太麻里', '太麻里乡', 3, 'taimali', '963', 1, '121.007394', '22.615383');
INSERT INTO `shop_truck_region` VALUES (3676, 3666, 'D', '大武', '大武乡', 3, 'dawu', '965', 1, '120.889938', '22.339919');
INSERT INTO `shop_truck_region` VALUES (3677, 3666, 'L', '绿岛', '绿岛乡', 3, 'lvdao', '951', 1, '121.492596', '22.661676');
INSERT INTO `shop_truck_region` VALUES (3678, 3666, 'H', '海端', '海端乡', 3, 'haiduan', '957', 1, '121.172008', '23.101074');
INSERT INTO `shop_truck_region` VALUES (3679, 3666, 'Y', '延平', '延平乡', 3, 'yanping', '953', 1, '121.084499', '22.902358');
INSERT INTO `shop_truck_region` VALUES (3680, 3666, 'J', '金峰', '金峰乡', 3, 'jinfeng', '964', 1, '120.971292', '22.595511');
INSERT INTO `shop_truck_region` VALUES (3681, 3666, 'D', '达仁', '达仁乡', 3, 'daren', '966', 1, '120.884131', '22.294869');
INSERT INTO `shop_truck_region` VALUES (3682, 3666, 'L', '兰屿', '兰屿乡', 3, 'lanyu', '952', 1, '121.532473', '22.056736');
INSERT INTO `shop_truck_region` VALUES (3683, 3325, 'H', '花莲', '花莲县', 2, 'hualien', '9', 1, '121.300000', '23.830000');
INSERT INTO `shop_truck_region` VALUES (3684, 3683, 'H', '花莲', '花莲市', 3, 'hualian', '970', 1, '121.606810', '23.982074');
INSERT INTO `shop_truck_region` VALUES (3685, 3683, 'F', '凤林', '凤林镇', 3, 'fenglin', '975', 1, '121.451687', '23.744648');
INSERT INTO `shop_truck_region` VALUES (3686, 3683, 'Y', '玉里', '玉里镇', 3, 'yuli', '981', 1, '121.316445', '23.336509');
INSERT INTO `shop_truck_region` VALUES (3687, 3683, 'X', '新城', '新城乡', 3, 'xincheng', '971', 1, '121.640512', '24.128133');
INSERT INTO `shop_truck_region` VALUES (3688, 3683, 'J', '吉安', '吉安乡', 3, 'jian', '973', 1, '121.568005', '23.961635');
INSERT INTO `shop_truck_region` VALUES (3689, 3683, 'S', '寿丰', '寿丰乡', 3, 'shoufeng', '974', 1, '121.508955', '23.870680');
INSERT INTO `shop_truck_region` VALUES (3690, 3683, 'G', '光复', '光复乡', 3, 'guangfu', '976', 1, '121.423496', '23.669084');
INSERT INTO `shop_truck_region` VALUES (3691, 3683, 'F', '丰滨', '丰滨乡', 3, 'fengbin', '977', 1, '121.518639', '23.597080');
INSERT INTO `shop_truck_region` VALUES (3692, 3683, 'R', '瑞穗', '瑞穗乡', 3, 'ruisui', '978', 1, '121.375992', '23.496817');
INSERT INTO `shop_truck_region` VALUES (3693, 3683, 'F', '富里', '富里乡', 3, 'fuli', '983', 1, '121.250124', '23.179984');
INSERT INTO `shop_truck_region` VALUES (3694, 3683, 'X', '秀林', '秀林乡', 3, 'xiulin', '972', 1, '121.620381', '24.116642');
INSERT INTO `shop_truck_region` VALUES (3695, 3683, 'W', '万荣', '万荣乡', 3, 'wanrong', '979', 1, '121.407493', '23.715346');
INSERT INTO `shop_truck_region` VALUES (3696, 3683, 'Z', '卓溪', '卓溪乡', 3, 'zhuoxi', '982', 1, '121.303422', '23.346369');
INSERT INTO `shop_truck_region` VALUES (3697, 3325, 'P', '澎湖', '澎湖县', 2, 'penghu', '8', 1, '119.566417', '23.569733');
INSERT INTO `shop_truck_region` VALUES (3698, 3697, 'M', '马公', '马公市', 3, 'magong', '880', 1, '119.566499', '23.565845');
INSERT INTO `shop_truck_region` VALUES (3699, 3697, 'H', '湖西', '湖西乡', 3, 'huxi', '885', 1, '119.659666', '23.583358');
INSERT INTO `shop_truck_region` VALUES (3700, 3697, 'B', '白沙', '白沙乡', 3, 'baisha', '884', 1, '119.597919', '23.666060');
INSERT INTO `shop_truck_region` VALUES (3701, 3697, 'X', '西屿', '西屿乡', 3, 'xiyu', '881', 1, '119.506974', '23.600836');
INSERT INTO `shop_truck_region` VALUES (3702, 3697, 'W', '望安', '望安乡', 3, 'wangan', '882', 1, '119.500538', '23.357531');
INSERT INTO `shop_truck_region` VALUES (3703, 3697, 'Q', '七美', '七美乡', 3, 'qimei', '883', 1, '119.423929', '23.206018');
INSERT INTO `shop_truck_region` VALUES (3704, 3325, 'J', '金门', '金门县', 2, 'jinmen', '8', 1, '118.317089', '24.432706');
INSERT INTO `shop_truck_region` VALUES (3705, 3704, 'J', '金城', '金城镇', 3, 'jincheng', '893', 1, '118.316667', '24.416667');
INSERT INTO `shop_truck_region` VALUES (3706, 3704, 'J', '金湖', '金湖镇', 3, 'jinhu', '891', 1, '118.419743', '24.438633');
INSERT INTO `shop_truck_region` VALUES (3707, 3704, 'J', '金沙', '金沙镇', 3, 'jinsha', '890', 1, '118.427993', '24.481109');
INSERT INTO `shop_truck_region` VALUES (3708, 3704, 'J', '金宁', '金宁乡', 3, 'jinning', '892', 1, '118.334506', '24.45672');
INSERT INTO `shop_truck_region` VALUES (3709, 3704, 'L', '烈屿', '烈屿乡', 3, 'lieyu', '894', 1, '118.247255', '24.433102');
INSERT INTO `shop_truck_region` VALUES (3710, 3704, 'W', '乌丘', '乌丘乡', 3, 'wuqiu', '896', 1, '118.319578', '24.435038');
INSERT INTO `shop_truck_region` VALUES (3711, 3325, 'L', '连江', '连江县', 2, 'lienchiang', '2', 1, '119.539704', '26.197364');
INSERT INTO `shop_truck_region` VALUES (3712, 3711, 'N', '南竿', '南竿乡', 3, 'nangan', '209', 1, '119.944267', '26.144035');
INSERT INTO `shop_truck_region` VALUES (3713, 3711, 'B', '北竿', '北竿乡', 3, 'beigan', '210', 1, '120.000572', '26.221983');
INSERT INTO `shop_truck_region` VALUES (3714, 3711, NULL, '莒光', '莒光乡', 3, 'juguang', '211', 1, '119.940405', '25.976256');
INSERT INTO `shop_truck_region` VALUES (3715, 3711, 'D', '东引', '东引乡', 3, 'dongyin', '212', 1, '120.493955', '26.366164');
INSERT INTO `shop_truck_region` VALUES (3716, 0, 'X', '香港', '香港特别行政区', 1, 'hongkong', '', 1, '114.173355', '22.320048');
INSERT INTO `shop_truck_region` VALUES (3738, 0, 'A', '澳门', '澳门特别行政区', 1, 'macau', '', 1, '113.54909', '22.198951');
INSERT INTO `shop_truck_region` VALUES (3739, 3738, 'A', '澳门半岛', '澳门半岛', 2, 'macaupeninsula', '999078', 1, '113.549134', '22.198751');
INSERT INTO `shop_truck_region` VALUES (3740, 3739, 'H', '花地玛堂区', '花地玛堂区', 3, 'nossasenhoradefatima', '999078', 1, '113.552284', '22.208067');
INSERT INTO `shop_truck_region` VALUES (3741, 3739, 'S', '圣安多尼堂区', '圣安多尼堂区', 3, 'santoantonio', '999078', 1, '113.564301', '22.12381');
INSERT INTO `shop_truck_region` VALUES (3742, 3739, 'D', '大堂', '大堂区', 3, 'sé', '999078', 1, '113.552971', '22.188359');
INSERT INTO `shop_truck_region` VALUES (3743, 3739, 'W', '望德堂区', '望德堂区', 3, 'saolazaro', '999078', 1, '113.550568', '22.194081');
INSERT INTO `shop_truck_region` VALUES (3744, 3739, 'F', '风顺堂区', '风顺堂区', 3, 'saolourenco', '999078', 1, '113.541928', '22.187368');
INSERT INTO `shop_truck_region` VALUES (3745, 3738, NULL, '氹仔岛', '氹仔岛', 2, 'taipa', '999078', 1, '113.577669', '22.156838');
INSERT INTO `shop_truck_region` VALUES (3746, 3745, 'J', '嘉模堂区', '嘉模堂区', 3, 'ourladyofcarmelsparish', '999078', 1, '113.565303', '22.149029');
INSERT INTO `shop_truck_region` VALUES (3747, 3738, 'L', '路环岛', '路环岛', 2, 'coloane', '999078', 1, '113.564857', '22.116226');
INSERT INTO `shop_truck_region` VALUES (3748, 3747, 'S', '圣方济各堂区', '圣方济各堂区', 3, 'stfrancisxaviersparish', '999078', 1, '113.559954', '22.123486');
INSERT INTO `shop_truck_region` VALUES (3999, 3716, NULL, '香港', '香港特别行政区', 2, 'hongkong', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4000, 3999, NULL, '中西区', '中西区', 3, 'zhongxin', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4001, 3999, NULL, '东区', '东区', 3, 'dong', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4002, 3999, NULL, '九龙城区', '九龙城区', 3, 'jiulong', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4003, 3999, NULL, '观塘区', '观塘区', 3, 'guantang', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4004, 3999, NULL, '南区', '南区', 3, 'nan', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4005, 3999, NULL, '深水埗区', '深水埗区', 3, 'shenshuibu', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4006, 3999, NULL, '湾仔区', '湾仔区', 3, 'wanzi', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4007, 3999, NULL, '黄大仙区', '黄大仙区', 3, 'huangdaxian', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4008, 3999, NULL, '油尖旺区', '油尖旺区', 3, 'youjianwang', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4009, 3999, NULL, '离岛区', '离岛区', 3, 'lidao', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4010, 3999, NULL, '葵青区', '葵青区', 3, 'kuiqing', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4011, 3999, NULL, '北区', '北区', 3, 'bei', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4012, 3999, NULL, '西贡区', '西贡区', 3, 'xigong', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4013, 3999, NULL, '沙田区', '沙田区', 3, 'shatian', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4014, 3999, NULL, '屯门区', '屯门区', 3, 'tunmen', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4015, 3999, NULL, '大埔区', '大埔区', 3, 'dapu', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4016, 3999, NULL, '荃湾区', '荃湾区', 3, 'quanwan', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4017, 3999, NULL, '元朗区', '元朗区', 3, 'yuanlang', NULL, 1, NULL, NULL);
INSERT INTO `shop_truck_region` VALUES (4018, 2291, 'D', '儋州', '儋州市', 2, 'danzhou', '571700', 1, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 88 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-菜单' ROW_FORMAT = COMPACT;

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
INSERT INTO `system_menu` VALUES (77, 73, '会员用户管理', 'layui-icon layui-icon-user', 'data/user/index', 'data/user/index', '', '_self', 100, 1, '2020-09-10 01:48:02');
INSERT INTO `system_menu` VALUES (78, 73, '订单数据管理', 'layui-icon layui-icon-template-1', 'data/shop_order/index', 'data/shop_order/index', '', '_self', 60, 1, '2020-09-10 01:48:41');
INSERT INTO `system_menu` VALUES (79, 73, '订单发货管理', 'layui-icon layui-icon-transfer', 'data/shop_order_send/index', 'data/shop_order_send/index', '', '_self', 50, 1, '2020-09-10 01:50:12');
INSERT INTO `system_menu` VALUES (80, 73, '售后申请管理', 'layui-icon layui-icon-diamond', 'data/shop_order_service/index', 'data/shop_order_service/index', '', '_self', 40, 1, '2020-09-10 01:53:16');
INSERT INTO `system_menu` VALUES (81, 73, '快递公司管理', 'layui-icon layui-icon-website', 'data/shop_truck_company/index', 'data/shop_truck_company/index', '', '_self', 0, 1, '2020-09-15 08:47:46');
INSERT INTO `system_menu` VALUES (82, 73, '邮费模板管理', 'layui-icon layui-icon-template-1', 'data/shop_truck_template/index', 'data/shop_truck_template/index', '', '_self', 0, 1, '2020-09-15 09:14:46');
INSERT INTO `system_menu` VALUES (83, 73, '配送区域管理', 'layui-icon layui-icon-location', 'data/shop_truck_template/region', 'data/shop_truck_template/region', '', '_self', 0, 1, '2020-09-17 09:13:35');
INSERT INTO `system_menu` VALUES (84, 68, '微信小程序配置', 'layui-icon layui-icon-set', 'data/config/wxapp', 'data/config/wxapp', '', '_self', 5, 1, '2020-09-21 16:34:08');
INSERT INTO `system_menu` VALUES (85, 68, '会员服务协议', 'layui-icon layui-icon-template-1', 'data/config/agreement', 'data/config/agreement', '', '_self', 30, 1, '2020-09-22 16:00:10');
INSERT INTO `system_menu` VALUES (86, 68, '关于我们描述', 'layui-icon layui-icon-app', 'data/config/about', 'data/config/about', '', '_self', 40, 1, '2020-09-22 16:12:44');
INSERT INTO `system_menu` VALUES (87, 68, '支付通道管理', 'layui-icon layui-icon-rmb', 'data/payment/index', 'data/payment/index', '', '_self', 6, 1, '2020-12-12 09:08:09');

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
INSERT INTO `system_user` VALUES (10000, 'admin', '21232f297a57a5a743894a0e4a801fc3', '系统管理员', 'http://127.0.0.1:8000/upload/0b/41ddc2fe3395af9c8de51282b70e87.jpg', ',,', '', '', '', '127.0.0.1', '2021-01-08 05:18:50', 56, '', 1, 0, 0, '2015-11-13 15:14:22');

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
