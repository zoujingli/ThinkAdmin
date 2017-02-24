/*
Navicat MySQL Data Transfer

Source Server         : ctolog.com
Source Server Version : 50629
Source Host           : ctolog.com:3306
Source Database       : think.admin

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2017-02-24 15:57:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for system_auth
-- ----------------------------
DROP TABLE IF EXISTS `system_auth`;
CREATE TABLE `system_auth` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '权限名称',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(1:禁用,2:启用)',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT '排序权重',
  `desc` varchar(255) DEFAULT NULL COMMENT '备注说明',
  `create_by` bigint(11) unsigned DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_auth_name_index` (`title`) USING BTREE,
  KEY `system_auth_status_index` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='系统权限表';

-- ----------------------------
-- Records of system_auth
-- ----------------------------

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` varchar(500) DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('139', 'sms_smtp_username', '23391719');
INSERT INTO `system_config` VALUES ('140', 'sms_smtp_password', '2d696a53cd0dab1b1145d539477b050a');
INSERT INTO `system_config` VALUES ('141', 'sms_product', 'SMS_10795763');
INSERT INTO `system_config` VALUES ('142', 'sms_tpl_register', '');
INSERT INTO `system_config` VALUES ('144', 'site_tongji_baidu', 'f9a6d4c4393e28fa0b3f8a7d89c1c6da');
INSERT INTO `system_config` VALUES ('145', 'site_tongji_cnzz', '1259948094');
INSERT INTO `system_config` VALUES ('148', 'file_storage', 'qiniu');
INSERT INTO `system_config` VALUES ('149', 'site_copy', '广州楚才信息科技有限公司 © 2017');
INSERT INTO `system_config` VALUES ('150', 'site_beian', '11');
INSERT INTO `system_config` VALUES ('151', 'site_keys', '');
INSERT INTO `system_config` VALUES ('158', 'mail_from_name', '广州楚才信息科技有限公司');
INSERT INTO `system_config` VALUES ('159', 'mail_reply', 'zoujingli@qq.com');
INSERT INTO `system_config` VALUES ('160', 'mail_smtp_host', 'smtp.qq.com');
INSERT INTO `system_config` VALUES ('161', 'mail_smtp_port', '465');
INSERT INTO `system_config` VALUES ('162', 'mail_smtp_username', 'pm@cuci.cc');
INSERT INTO `system_config` VALUES ('163', 'mail_smtp_password', 'Test12345');
INSERT INTO `system_config` VALUES ('164', 'storage_type', 'local');
INSERT INTO `system_config` VALUES ('165', 'storage_qiniu_is_https', '1');
INSERT INTO `system_config` VALUES ('166', 'storage_qiniu_bucket', 'static');
INSERT INTO `system_config` VALUES ('167', 'storage_qiniu_domain', 'static.ctolog.com');
INSERT INTO `system_config` VALUES ('168', 'storage_qiniu_access_key', 'admin');
INSERT INTO `system_config` VALUES ('169', 'storage_qiniu_secret_key', 'Test12345');
INSERT INTO `system_config` VALUES ('170', 'site_name', '123');
INSERT INTO `system_config` VALUES ('171', 'site_domain', 'thi1111');
INSERT INTO `system_config` VALUES ('172', 'site_desc', '000');
INSERT INTO `system_config` VALUES ('173', 'app_name', 'Think.Admin');
INSERT INTO `system_config` VALUES ('174', 'app_version', '1.0 dev');
INSERT INTO `system_config` VALUES ('175', 'site_logo', 'https://think.ctolog.com/upload/1d64fcf0f92414f0/a6989fd5a7d1e547.jpg');
INSERT INTO `system_config` VALUES ('176', 'app_logo', 'https://static.ctolog.com/f47b8fe06e38ae99/08e8398da45583b9.png');
INSERT INTO `system_config` VALUES ('177', 'sms_type', 'zt');
INSERT INTO `system_config` VALUES ('178', 'sms_zt_username', 'admin');
INSERT INTO `system_config` VALUES ('179', 'sms_zt_password', 'Test12345');
INSERT INTO `system_config` VALUES ('180', 'sms_ali_key', '');
INSERT INTO `system_config` VALUES ('181', 'sms_ali_secret', '');

-- ----------------------------
-- Table structure for system_file
-- ----------------------------
DROP TABLE IF EXISTS `system_file`;
CREATE TABLE `system_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uptype` varchar(100) DEFAULT NULL COMMENT '上传方式',
  `md5` varchar(32) DEFAULT NULL COMMENT '文件MD5值',
  `real_name` varchar(100) DEFAULT NULL COMMENT '源文件名',
  `file_name` varchar(100) NOT NULL DEFAULT '' COMMENT '服务器文件名',
  `file_path` varchar(200) NOT NULL COMMENT '服务器相对路径',
  `full_path` varchar(200) DEFAULT NULL COMMENT '绝对文件位置',
  `file_ext` varchar(20) DEFAULT NULL COMMENT '文件后缀',
  `file_size` decimal(20,2) DEFAULT NULL COMMENT '文件大小',
  `file_url` varchar(300) DEFAULT NULL COMMENT '相对URL地址',
  `site_url` varchar(300) DEFAULT NULL COMMENT '绝对URL地址',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_file_md5` (`md5`) USING BTREE,
  KEY `index_system_file_uptype` (`uptype`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='系统文件';

-- ----------------------------
-- Records of system_file
-- ----------------------------
INSERT INTO `system_file` VALUES ('22', 'qiniu', 'f47b8fe06e38ae9908e8398da45583b9', 'long.png', '08e8398da45583b9.png', 'f47b8fe06e38ae99/08e8398da45583b9.png', 'f47b8fe06e38ae99/08e8398da45583b9.png', 'png', null, 'f47b8fe06e38ae99/08e8398da45583b9.png', 'https://static.ctolog.com/f47b8fe06e38ae99/08e8398da45583b9.png', '10000', '2017-02-22 14:09:39');
INSERT INTO `system_file` VALUES ('23', 'qiniu', '21f88ba102f896508660ff3e46f0a16c', '1486611399_308354_meitu_2_33副本.jpg', '8660ff3e46f0a16c.jpg', '21f88ba102f89650/8660ff3e46f0a16c.jpg', '21f88ba102f89650/8660ff3e46f0a16c.jpg', 'jpg', null, '21f88ba102f89650/8660ff3e46f0a16c.jpg', 'https://static.ctolog.com/21f88ba102f89650/8660ff3e46f0a16c.jpg', '10000', '2017-02-22 14:16:44');
INSERT INTO `system_file` VALUES ('24', 'qiniu', '19af0e8b89b6696748a3b5c922642602', '1486623395_191494_副本.jpg', '48a3b5c922642602.jpg', '19af0e8b89b66967/48a3b5c922642602.jpg', '19af0e8b89b66967/48a3b5c922642602.jpg', 'jpg', null, '19af0e8b89b66967/48a3b5c922642602.jpg', 'https://static.ctolog.com/19af0e8b89b66967/48a3b5c922642602.jpg', '10000', '2017-02-22 14:16:57');
INSERT INTO `system_file` VALUES ('25', 'qiniu', 'bd835163b61fa2dd11579b2de70023fc', 'a7.jpg', '11579b2de70023fc.jpg', 'bd835163b61fa2dd/11579b2de70023fc.jpg', 'bd835163b61fa2dd/11579b2de70023fc.jpg', 'jpg', null, 'bd835163b61fa2dd/11579b2de70023fc.jpg', 'https://static.ctolog.com/bd835163b61fa2dd/11579b2de70023fc.jpg', '10000', '2017-02-22 14:24:21');
INSERT INTO `system_file` VALUES ('26', 'qiniu', '5112881784000c6cf6d81e5a8aa10f3c', 'index_4.jpg', 'f6d81e5a8aa10f3c.jpg', '5112881784000c6c/f6d81e5a8aa10f3c.jpg', '5112881784000c6c/f6d81e5a8aa10f3c.jpg', 'jpg', null, '5112881784000c6c/f6d81e5a8aa10f3c.jpg', 'https://static.ctolog.com/5112881784000c6c/f6d81e5a8aa10f3c.jpg', '10000', '2017-02-22 14:24:28');
INSERT INTO `system_file` VALUES ('27', 'qiniu', '8feae3652f626ba9ec74d14792de6b95', 'qr_code.png', 'ec74d14792de6b95.png', '8feae3652f626ba9/ec74d14792de6b95.png', '8feae3652f626ba9/ec74d14792de6b95.png', 'png', null, '8feae3652f626ba9/ec74d14792de6b95.png', 'https://static.ctolog.com/8feae3652f626ba9/ec74d14792de6b95.png', '10000', '2017-02-22 14:24:39');
INSERT INTO `system_file` VALUES ('28', 'qiniu', '2cb9a79d3ee3f3c990b6989eb0160adc', '9db4d90f1c470e7d2b5efe159534d979.jpg', '90b6989eb0160adc.jpg', '2cb9a79d3ee3f3c9/90b6989eb0160adc.jpg', '2cb9a79d3ee3f3c9/90b6989eb0160adc.jpg', 'jpg', null, '2cb9a79d3ee3f3c9/90b6989eb0160adc.jpg', 'https://static.ctolog.com/2cb9a79d3ee3f3c9/90b6989eb0160adc.jpg', '10000', '2017-02-22 15:13:07');
INSERT INTO `system_file` VALUES ('29', 'qiniu', 'a80e2d293234bf0e8089c9563ae31622', 'background-wallpapers-for-pc-1.jpg', '8089c9563ae31622.jpg', 'a80e2d293234bf0e/8089c9563ae31622.jpg', 'a80e2d293234bf0e/8089c9563ae31622.jpg', 'jpg', null, 'a80e2d293234bf0e/8089c9563ae31622.jpg', 'https://static.ctolog.com/a80e2d293234bf0e/8089c9563ae31622.jpg', '10000', '2017-02-22 15:13:15');
INSERT INTO `system_file` VALUES ('30', 'qiniu', '9a11b651d2f39f9c33e2b35b1d16e49e', 'error.png', '33e2b35b1d16e49e.png', '9a11b651d2f39f9c/33e2b35b1d16e49e.png', '9a11b651d2f39f9c/33e2b35b1d16e49e.png', 'png', null, '9a11b651d2f39f9c/33e2b35b1d16e49e.png', 'https://static.ctolog.com/9a11b651d2f39f9c/33e2b35b1d16e49e.png', '10000', '2017-02-22 15:42:53');
INSERT INTO `system_file` VALUES ('31', 'qiniu', '131bd633cb97c07f657dae0b96467033', '325647047411570055.jpg', '657dae0b96467033.jpg', '131bd633cb97c07f/657dae0b96467033.jpg', '131bd633cb97c07f/657dae0b96467033.jpg', 'jpg', null, '131bd633cb97c07f/657dae0b96467033.jpg', 'https://static.ctolog.com/131bd633cb97c07f/657dae0b96467033.jpg', '10000', '2017-02-22 21:40:00');
INSERT INTO `system_file` VALUES ('32', 'qiniu', '32d594fc8a7e1c7aa1ee4e1deab60466', '31bc1cc.png', 'a1ee4e1deab60466.png', '32d594fc8a7e1c7a/a1ee4e1deab60466.png', '32d594fc8a7e1c7a/a1ee4e1deab60466.png', 'png', null, '32d594fc8a7e1c7a/a1ee4e1deab60466.png', 'https://static.ctolog.com/32d594fc8a7e1c7a/a1ee4e1deab60466.png', '10000', '2017-02-23 09:20:58');
INSERT INTO `system_file` VALUES ('33', 'qiniu', 'abf99fbe910fd4626d62f6e9168a7c8a', '6.gif', '6d62f6e9168a7c8a.gif', 'abf99fbe910fd462/6d62f6e9168a7c8a.gif', 'abf99fbe910fd462/6d62f6e9168a7c8a.gif', 'gif', null, 'abf99fbe910fd462/6d62f6e9168a7c8a.gif', 'https://static.ctolog.com/abf99fbe910fd462/6d62f6e9168a7c8a.gif', '10000', '2017-02-23 09:35:19');
INSERT INTO `system_file` VALUES ('34', 'qiniu', 'f2d30a04ae01a091ed5c5f77f737310e', '87739079930835375.jpg', 'ed5c5f77f737310e.jpg', 'f2d30a04ae01a091/ed5c5f77f737310e.jpg', 'f2d30a04ae01a091/ed5c5f77f737310e.jpg', 'jpg', null, 'f2d30a04ae01a091/ed5c5f77f737310e.jpg', 'http://static.ctolog.com/f2d30a04ae01a091/ed5c5f77f737310e.jpg', '10000', '2017-02-23 11:37:03');
INSERT INTO `system_file` VALUES ('35', 'qiniu', 'b490deabac7bfc82cc3622182f49a2d2', 'lALOo0qlkc0CDM0DkQ_913_524.png_620x10000q90g.jpg', 'cc3622182f49a2d2.jpg', 'b490deabac7bfc82/cc3622182f49a2d2.jpg', 'b490deabac7bfc82/cc3622182f49a2d2.jpg', 'jpg', null, 'b490deabac7bfc82/cc3622182f49a2d2.jpg', 'http://static.ctolog.com/b490deabac7bfc82/cc3622182f49a2d2.jpg', '10000', '2017-02-23 13:20:07');
INSERT INTO `system_file` VALUES ('36', 'qiniu', 'dcf47fa0f5fe7489d397e7e6d839c00d', '331.jpg', 'd397e7e6d839c00d.jpg', 'dcf47fa0f5fe7489/d397e7e6d839c00d.jpg', 'dcf47fa0f5fe7489/d397e7e6d839c00d.jpg', 'jpg', null, 'dcf47fa0f5fe7489/d397e7e6d839c00d.jpg', 'https://static.ctolog.com/dcf47fa0f5fe7489/d397e7e6d839c00d.jpg', '10000', '2017-02-23 17:10:36');
INSERT INTO `system_file` VALUES ('37', 'qiniu', 'dcbc7e8c27a18ec5f3b8119bdf026ba0', 'ada6b0039f246d16e6f788f1e35876fa.jpg', 'f3b8119bdf026ba0.jpg', 'dcbc7e8c27a18ec5/f3b8119bdf026ba0.jpg', 'dcbc7e8c27a18ec5/f3b8119bdf026ba0.jpg', 'jpg', null, 'dcbc7e8c27a18ec5/f3b8119bdf026ba0.jpg', 'https://static.ctolog.com/dcbc7e8c27a18ec5/f3b8119bdf026ba0.jpg', '10000', '2017-02-23 17:57:33');
INSERT INTO `system_file` VALUES ('38', 'qiniu', '293d5b62eff82546ef5b6a1bbf33bbdc', 'logo.jpg', 'ef5b6a1bbf33bbdc.jpg', '293d5b62eff82546/ef5b6a1bbf33bbdc.jpg', '293d5b62eff82546/ef5b6a1bbf33bbdc.jpg', 'jpg', null, '293d5b62eff82546/ef5b6a1bbf33bbdc.jpg', 'https://static.ctolog.com/293d5b62eff82546/ef5b6a1bbf33bbdc.jpg', '10000', '2017-02-23 18:26:15');
INSERT INTO `system_file` VALUES ('39', 'qiniu', 'dae77ae7bc80aff604df9d7aa9671625', 'logo.png', '04df9d7aa9671625.png', 'dae77ae7bc80aff6/04df9d7aa9671625.png', 'dae77ae7bc80aff6/04df9d7aa9671625.png', 'png', null, 'dae77ae7bc80aff6/04df9d7aa9671625.png', 'https://static.ctolog.com/dae77ae7bc80aff6/04df9d7aa9671625.png', '10000', '2017-02-23 18:26:24');
INSERT INTO `system_file` VALUES ('40', 'qiniu', 'cd9d763f1dae9f31efa1edaf6e13be82', '14701.jpg', 'efa1edaf6e13be82.jpg', 'cd9d763f1dae9f31/efa1edaf6e13be82.jpg', 'cd9d763f1dae9f31/efa1edaf6e13be82.jpg', 'jpg', null, 'cd9d763f1dae9f31/efa1edaf6e13be82.jpg', 'https://static.ctolog.com/cd9d763f1dae9f31/efa1edaf6e13be82.jpg', '10000', '2017-02-24 01:15:18');
INSERT INTO `system_file` VALUES ('41', 'local', '65fa8e868eba8874eb6ed4d852ff2dd9', '20114514542883.png', 'eb6ed4d852ff2dd9.png', 'upload/65fa8e868eba8874/eb6ed4d852ff2dd9.png', '/home/wwwroot/think/trunk/public/upload/65fa8e868eba8874/eb6ed4d852ff2dd9.png', 'png', '5812.00', 'upload/65fa8e868eba8874/eb6ed4d852ff2dd9.png', 'https://think.ctolog.com/upload/65fa8e868eba8874/eb6ed4d852ff2dd9.png', '10000', '2017-02-24 09:55:39');
INSERT INTO `system_file` VALUES ('42', 'local', '079d8f191ddf58317ee3d803fb780048', '境淘APP.png', '7ee3d803fb780048.png', 'upload/079d8f191ddf5831/7ee3d803fb780048.png', '/home/wwwroot/think/trunk/public/upload/079d8f191ddf5831/7ee3d803fb780048.png', 'png', '7226.00', 'upload/079d8f191ddf5831/7ee3d803fb780048.png', 'https://think.ctolog.com/upload/079d8f191ddf5831/7ee3d803fb780048.png', '10000', '2017-02-24 12:00:26');
INSERT INTO `system_file` VALUES ('43', 'local', 'f47b8fe06e38ae9908e8398da45583b9', 'long.png', '08e8398da45583b9.png', 'upload/f47b8fe06e38ae99/08e8398da45583b9.png', '/home/wwwroot/think/trunk/public/upload/f47b8fe06e38ae99/08e8398da45583b9.png', 'png', '25382.00', 'upload/f47b8fe06e38ae99/08e8398da45583b9.png', 'https://think.ctolog.com/upload/f47b8fe06e38ae99/08e8398da45583b9.png', '10000', '2017-02-24 12:20:04');
INSERT INTO `system_file` VALUES ('44', 'local', 'cae0da0d68d73235fd6f83a97ef0af68', '黑底.png', 'fd6f83a97ef0af68.png', 'upload/cae0da0d68d73235/fd6f83a97ef0af68.png', '/home/wwwroot/think/trunk/public/upload/cae0da0d68d73235/fd6f83a97ef0af68.png', 'png', '246.00', 'upload/cae0da0d68d73235/fd6f83a97ef0af68.png', 'https://think.ctolog.com/upload/cae0da0d68d73235/fd6f83a97ef0af68.png', '10000', '2017-02-24 13:42:12');
INSERT INTO `system_file` VALUES ('45', 'local', 'ba45c8f60456a672e003a875e469d0eb', 'Desert.jpg', 'e003a875e469d0eb.jpg', 'upload/ba45c8f60456a672/e003a875e469d0eb.jpg', '/home/wwwroot/think/trunk/public/upload/ba45c8f60456a672/e003a875e469d0eb.jpg', 'jpg', '845941.00', 'upload/ba45c8f60456a672/e003a875e469d0eb.jpg', 'https://think.ctolog.com/upload/ba45c8f60456a672/e003a875e469d0eb.jpg', '10000', '2017-02-24 14:10:44');
INSERT INTO `system_file` VALUES ('46', 'local', '1d64fcf0f92414f0a6989fd5a7d1e547', 'icon.jpg', 'a6989fd5a7d1e547.jpg', 'upload/1d64fcf0f92414f0/a6989fd5a7d1e547.jpg', '/home/wwwroot/think/trunk/public/upload/1d64fcf0f92414f0/a6989fd5a7d1e547.jpg', 'jpg', '6883.00', 'upload/1d64fcf0f92414f0/a6989fd5a7d1e547.jpg', 'https://think.ctolog.com/upload/1d64fcf0f92414f0/a6989fd5a7d1e547.jpg', '10000', '2017-02-24 14:37:21');

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `node` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '节点代码',
  `icon` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `params` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
  `sort` int(11) unsigned DEFAULT '0' COMMENT '菜单排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `create_by` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `system_menu_node` (`node`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='系统菜单表';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES ('2', '0', '系统管理', '', '', '#', '', '_self', '1000', '1', '0', '2015-11-16 19:15:38');
INSERT INTO `system_menu` VALUES ('3', '4', '后台首页', '', 'fa fa-fw fa-tachometer', 'admin/index/main', '', '_self', '10', '1', '0', '2015-11-17 13:27:25');
INSERT INTO `system_menu` VALUES ('4', '2', '系统配置', '', '', '#', '', '_self', '123', '1', '0', '2016-03-14 18:12:55');
INSERT INTO `system_menu` VALUES ('5', '4', '网站参数', '', 'fa fa-apple', 'admin/config/index', '', '_self', '20', '1', '0', '2016-05-06 14:36:49');
INSERT INTO `system_menu` VALUES ('6', '4', '文件存储', '', 'fa fa-hdd-o', 'admin/config/file', '', '_self', '30', '1', '0', '2016-05-06 14:39:43');
INSERT INTO `system_menu` VALUES ('7', '4', '邮箱配置', '', 'fa fa-envelope', 'admin/config/mail', '', '_self', '40', '1', '0', '2016-05-12 16:24:21');
INSERT INTO `system_menu` VALUES ('8', '4', '短信配置', '', 'fa fa-envelope-square', 'admin/config/sms', '', '_self', '30', '1', '0', '2016-05-12 16:26:36');
INSERT INTO `system_menu` VALUES ('19', '20', '权限管理', '', 'fa fa-user-secret', 'admin/auth/index', '', '_self', '20', '1', '0', '2015-11-17 13:18:12');
INSERT INTO `system_menu` VALUES ('20', '2', '系统权限', '', '', '#', '', '_self', '200', '1', '0', '2016-03-14 18:11:41');
INSERT INTO `system_menu` VALUES ('21', '20', '系统菜单', '', 'glyphicon glyphicon-menu-hamburger', 'admin/menu/index', '', '_self', '10', '1', '0', '2015-11-16 19:16:16');
INSERT INTO `system_menu` VALUES ('22', '20', '节点管理', '', 'fa fa-ellipsis-v', 'admin/node/index', '', '_self', '30', '1', '0', '2015-11-16 19:16:16');
INSERT INTO `system_menu` VALUES ('29', '20', '系统用户', '', 'fa fa-users', 'admin/user/index', '', '_self', '40', '1', '0', '2016-10-31 14:31:40');
INSERT INTO `system_menu` VALUES ('30', '2', '插件管理', '', '', '#', '', '_self', '300', '1', '0', '2016-11-07 16:34:28');
INSERT INTO `system_menu` VALUES ('35', '30', '插件列表', '', 'fa fa-get-pocket', 'admin/plugs/index', '', '_self', '0', '1', '0', '2016-11-18 14:19:28');
INSERT INTO `system_menu` VALUES ('44', '2', '应用管理', '', '', '#', '', '_self', '400', '1', '0', '2017-01-11 10:42:38');
INSERT INTO `system_menu` VALUES ('45', '44', '应用列表', '', '', 'admin/apps/index', '', '_self', '11', '1', '0', '2017-01-11 14:19:45');
INSERT INTO `system_menu` VALUES ('50', '0', '插件管理', '', '', '#', '', '_self', '2000', '1', '0', '2017-02-22 16:44:14');
INSERT INTO `system_menu` VALUES ('51', '50', '我的插件', '', 'fa fa-mixcloud', 'admin/index/main', '', '_self', '0', '1', '0', '2017-02-22 16:45:38');

-- ----------------------------
-- Table structure for system_node
-- ----------------------------
DROP TABLE IF EXISTS `system_node`;
CREATE TABLE `system_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `node` varchar(100) DEFAULT NULL COMMENT '节点代码',
  `title` varchar(500) DEFAULT NULL COMMENT '节点标题',
  `is_menu` tinyint(1) unsigned DEFAULT '0' COMMENT '是否可设置为菜单',
  `is_auth` tinyint(1) unsigned DEFAULT '1' COMMENT '是启启动RBAC权限控制',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_node_node` (`node`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统节点表';

-- ----------------------------
-- Records of system_node
-- ----------------------------
INSERT INTO `system_node` VALUES ('1', 'admin', '系统管理', '0', '0', '2017-02-23 16:23:09');
INSERT INTO `system_node` VALUES ('2', 'admin/config', '系统配置', '0', '0', '2017-02-23 16:23:09');
INSERT INTO `system_node` VALUES ('3', 'admin/config/index', '网站参数', '1', '1', '2017-02-23 16:23:09');
INSERT INTO `system_node` VALUES ('4', 'admin/config/file', '文件存储', '1', '1', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('5', 'admin/config/mail', '邮箱配置', '1', '1', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('6', 'admin/config/sms', '短信配置', '1', '1', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('7', 'admin/index', '系统主页', '0', '0', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('8', 'admin/index/index', '后台界面框架', '1', '1', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('9', 'admin/index/main', '后台首页', '1', '1', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('10', 'admin/login', '登录管理', '0', '0', '2017-02-23 16:23:10');
INSERT INTO `system_node` VALUES ('11', 'admin/login/index', '用户管理', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('12', 'admin/login/out', '用户退出', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('13', 'admin/menu', '系统菜单管理', '0', '0', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('14', 'admin/menu/index', '系统菜单列表', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('15', 'admin/menu/add', '系统菜单添加', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('16', 'admin/menu/edit', '系统菜单编辑', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('17', 'admin/menu/del', '系统菜单删除', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('18', 'admin/menu/forbid', '系统菜单禁用', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('19', 'admin/menu/resume', '系统菜单恢复', '1', '1', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('20', 'admin/node', '系统节点管理', '0', '0', '2017-02-23 16:23:11');
INSERT INTO `system_node` VALUES ('21', 'admin/node/index', '系统节点列表', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('22', 'admin/node/save', '系统节点修改', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('23', 'admin/plugs', '系统插件管理', '0', '0', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('24', 'admin/plugs/upfile', '系统文件上传', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('25', 'admin/plugs/upstate', '系统文件状态检查', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('26', 'admin/plugs/upload', '系统文件上传处理', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('27', 'admin/plugs/icon', '系统图标选择器', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('28', 'admin/role', '系统角色管理', '0', '0', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('29', 'admin/role/index', '系统角色列表', '1', '1', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('30', 'admin/user', '系统用户管理', '0', '0', '2017-02-23 16:23:12');
INSERT INTO `system_node` VALUES ('31', 'admin/user/index', '系统用户列表', '1', '1', '2017-02-23 16:23:13');
INSERT INTO `system_node` VALUES ('32', 'index', '网站主页', '0', '0', '2017-02-23 16:23:13');
INSERT INTO `system_node` VALUES ('33', 'index/index', '网站主模块', '0', '0', '2017-02-23 16:23:13');
INSERT INTO `system_node` VALUES ('34', 'index/index/index', '网站主页', '1', '1', '2017-02-23 16:23:13');
INSERT INTO `system_node` VALUES ('35', 'index/test', '开发测试模块', '0', '0', '2017-02-23 16:23:13');
INSERT INTO `system_node` VALUES ('36', 'index/test/index', '开发测试主页', '1', '0', '2017-02-23 16:23:13');

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户登录名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户登录密码',
  `qq` varchar(16) DEFAULT NULL COMMENT '联系QQ',
  `mail` varchar(32) DEFAULT NULL COMMENT '联系邮箱',
  `phone` varchar(16) DEFAULT NULL COMMENT '联系手机号',
  `remark` varchar(255) DEFAULT '' COMMENT '备注说明',
  `login_num` bigint(20) unsigned DEFAULT '0' COMMENT '登录次数',
  `login_at` datetime DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '删除状态(1:删除,0:未删)',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_user_username_index` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10006 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES ('10000', 'admin', '662af1cd1976f09a9f8cecc868ccc0a2', '22222222', 'zoujingli@cuci.cc', '13617343800', '', '1283', '2016-12-29 14:33:45', '1', '0', null, '2015-11-13 15:14:22');
