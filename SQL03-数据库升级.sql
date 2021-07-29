SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 尝试创建微信自动回复数据表
CREATE TABLE IF NOT EXISTS `wechat_auto`
(
    `id`          bigint(20)                                                    NOT NULL AUTO_INCREMENT,
    `type`        varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT '' COMMENT '类型(text,image,news)',
    `time`        varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '延迟时间',
    `code`        varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT '' COMMENT '消息编号',
    `appid`       char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci    NULL DEFAULT '' COMMENT '公众号APPID',
    `content`     text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NULL COMMENT '文本内容',
    `image_url`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '图片链接',
    `voice_url`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '语音链接',
    `music_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '音乐标题',
    `music_url`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '音乐链接',
    `music_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '缩略图片',
    `music_desc`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '音乐描述',
    `video_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '视频标题',
    `video_url`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '视频URL',
    `video_desc`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '视频描述',
    `news_id`     bigint(20) UNSIGNED                                           NULL DEFAULT NULL COMMENT '图文ID',
    `status`      tinyint(1) UNSIGNED                                           NULL DEFAULT 1 COMMENT '状态(0禁用,1启用)',
    `create_by`   bigint(20) UNSIGNED                                           NULL DEFAULT 0 COMMENT '创建人',
    `create_at`   timestamp                                                     NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `idx_wechat_auto_type` (`type`) USING BTREE,
    INDEX `idx_wechat_auto_keys` (`time`) USING BTREE,
    INDEX `idx_wechat_auto_appid` (`appid`) USING BTREE,
    INDEX `idx_wechat_auto_code` (`code`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT = '微信-回复'
  ROW_FORMAT = COMPACT;

-- 调整字段名称长度
ALTER TABLE `system_queue`
    MODIFY COLUMN `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '任务名称' AFTER `code`;

-- 尝试创建数据字典数据表
CREATE TABLE IF NOT EXISTS `system_base`
(
    `id`         bigint(20)                                                    NOT NULL AUTO_INCREMENT,
    `type`       varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT '' COMMENT '数据类型',
    `code`       varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT '' COMMENT '数据代码',
    `name`       varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '数据名称',
    `content`    text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NULL COMMENT '数据内容',
    `sort`       bigint(20)                                                    NULL DEFAULT 0 COMMENT '排序权重',
    `status`     tinyint(1)                                                    NULL DEFAULT 1 COMMENT '数据状态(0禁用,1启动)',
    `deleted`    tinyint(1)                                                    NULL DEFAULT 0 COMMENT '删除状态(0正常,1已删)',
    `deleted_at` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT '' COMMENT '删除时间',
    `deleted_by` bigint(20)                                                    NULL DEFAULT 0 COMMENT '删除用户',
    `create_at`  timestamp                                                     NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `idx_system_base_type` (`type`) USING BTREE,
    INDEX `idx_system_base_code` (`code`) USING BTREE,
    INDEX `idx_system_base_name` (`name`(191)) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT = '系统-字典'
  ROW_FORMAT = COMPACT;

-- 权限表增加身份权限字段
ALTER TABLE `system_user`
    ADD COLUMN `usertype` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '用户类型' AFTER `id`;

SET FOREIGN_KEY_CHECKS = 1;