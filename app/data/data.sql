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

 Date: 13/07/2020 16:11:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for data_article_collection
-- ----------------------------
DROP TABLE IF EXISTS `data_article_collection`;
CREATE TABLE `data_article_collection`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '评论内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_article_comment_cid`(`cid`) USING BTREE,
  INDEX `idx_data_article_comment_mid`(`mid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-收藏' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_article_comment
-- ----------------------------
DROP TABLE IF EXISTS `data_article_comment`;
CREATE TABLE `data_article_comment`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '评论内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_article_comment_cid`(`cid`) USING BTREE,
  INDEX `idx_data_article_comment_mid`(`mid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-评论' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_article_content
-- ----------------------------
DROP TABLE IF EXISTS `data_article_content`;
CREATE TABLE `data_article_content`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标题',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章类型(video,article,audio)',
  `logo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '攻略图片',
  `tags` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章标签',
  `source` varchar(900) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '媒体资源',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注说明',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '文章内容',
  `number_likes` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章点赞数',
  `number_reads` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章阅读数',
  `number_comment` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章评论数',
  `number_collection` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章收藏数',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态(0未删,1已删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_article_content_type`(`type`) USING BTREE,
  INDEX `idx_data_article_content_status`(`status`) USING BTREE,
  INDEX `idx_data_article_content_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-内容' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_article_history
-- ----------------------------
DROP TABLE IF EXISTS `data_article_history`;
CREATE TABLE `data_article_history`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_article_history_cid`(`cid`) USING BTREE,
  INDEX `idx_data_article_history_mid`(`mid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-历史' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_article_like
-- ----------------------------
DROP TABLE IF EXISTS `data_article_like`;
CREATE TABLE `data_article_like`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '文章编号',
  `mid` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '会员MID',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_article_comment_cid`(`cid`) USING BTREE,
  INDEX `idx_data_article_comment_mid`(`mid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-点赞' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_article_tags
-- ----------------------------
DROP TABLE IF EXISTS `data_article_tags`;
CREATE TABLE `data_article_tags`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签名称',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标签说明',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '权限状态(1使用,0禁用)',
  `deleted` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_article_tags_status`(`status`) USING BTREE,
  INDEX `idx_data_article_tags_deleted`(`deleted`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-文章-标签' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_member
-- ----------------------------
DROP TABLE IF EXISTS `data_member`;
CREATE TABLE `data_member`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` bigint(20) NULL DEFAULT 0 COMMENT '邀请者MID',
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
  `deleted` tinyint(1) NULL DEFAULT 0 COMMENT '删除状态',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_data_member_token`(`token`) USING BTREE,
  INDEX `idx_data_member_status`(`status`) USING BTREE,
  INDEX `idx_data_member_openid`(`openid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '数据-会员' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for data_member_coin
-- ----------------------------
DROP TABLE IF EXISTS `data_member_coin`;
CREATE TABLE `data_member_coin`  (
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '数据-会员-金币-获得' ROW_FORMAT = Compact;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '数据-会员-金币-消费' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
