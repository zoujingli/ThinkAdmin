/*
Navicat MySQL Data Transfer

Source Server         : ctolog.com
Source Server Version : 50559
Source Host           : ctolog.com:3306
Source Database       : admin_v3

Target Server Type    : MYSQL
Target Server Version : 50559
File Encoding         : 65001

Date: 2018-03-13 15:35:47
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
  UNIQUE KEY `index_system_auth_title` (`title`) USING BTREE,
  KEY `index_system_auth_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统权限表';

-- ----------------------------
-- Records of system_auth
-- ----------------------------
INSERT INTO `system_auth` VALUES ('1', '测试', '1', '1', '测试权限', '0', '2018-01-23 13:28:14');

-- ----------------------------
-- Table structure for system_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `auth` bigint(20) unsigned DEFAULT NULL COMMENT '角色ID',
  `node` varchar(200) DEFAULT NULL COMMENT '节点路径',
  PRIMARY KEY (`id`),
  KEY `index_system_auth_auth` (`auth`) USING BTREE,
  KEY `index_system_auth_node` (`node`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8 COMMENT='系统角色与节点绑定';

-- ----------------------------
-- Records of system_auth_node
-- ----------------------------
INSERT INTO `system_auth_node` VALUES ('77', '1', 'admin');
INSERT INTO `system_auth_node` VALUES ('78', '1', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('79', '1', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('80', '1', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('81', '1', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('82', '1', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('83', '1', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('84', '1', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('85', '1', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('86', '1', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('87', '1', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('88', '1', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('89', '1', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('90', '1', 'admin/log');
INSERT INTO `system_auth_node` VALUES ('91', '1', 'admin/log/index');
INSERT INTO `system_auth_node` VALUES ('92', '1', 'admin/log/sms');
INSERT INTO `system_auth_node` VALUES ('93', '1', 'admin/log/del');
INSERT INTO `system_auth_node` VALUES ('94', '1', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('95', '1', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('96', '1', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('97', '1', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('98', '1', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('99', '1', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('100', '1', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('101', '1', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('102', '1', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('103', '1', 'admin/node/clear');
INSERT INTO `system_auth_node` VALUES ('104', '1', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('105', '1', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('106', '1', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('107', '1', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('108', '1', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('109', '1', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('110', '1', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('111', '1', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('112', '1', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('113', '1', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('114', '1', 'wechat');
INSERT INTO `system_auth_node` VALUES ('115', '1', 'wechat/block');
INSERT INTO `system_auth_node` VALUES ('116', '1', 'wechat/block/index');
INSERT INTO `system_auth_node` VALUES ('117', '1', 'wechat/block/backdel');
INSERT INTO `system_auth_node` VALUES ('118', '1', 'wechat/config');
INSERT INTO `system_auth_node` VALUES ('119', '1', 'wechat/config/index');
INSERT INTO `system_auth_node` VALUES ('120', '1', 'wechat/fans');
INSERT INTO `system_auth_node` VALUES ('121', '1', 'wechat/fans/index');
INSERT INTO `system_auth_node` VALUES ('122', '1', 'wechat/fans/backadd');
INSERT INTO `system_auth_node` VALUES ('123', '1', 'wechat/fans/tagset');
INSERT INTO `system_auth_node` VALUES ('124', '1', 'wechat/fans/tagadd');
INSERT INTO `system_auth_node` VALUES ('125', '1', 'wechat/fans/tagdel');
INSERT INTO `system_auth_node` VALUES ('126', '1', 'wechat/fans/sync');
INSERT INTO `system_auth_node` VALUES ('127', '1', 'wechat/keys');
INSERT INTO `system_auth_node` VALUES ('128', '1', 'wechat/keys/index');
INSERT INTO `system_auth_node` VALUES ('129', '1', 'wechat/keys/add');
INSERT INTO `system_auth_node` VALUES ('130', '1', 'wechat/keys/edit');
INSERT INTO `system_auth_node` VALUES ('131', '1', 'wechat/keys/del');
INSERT INTO `system_auth_node` VALUES ('132', '1', 'wechat/keys/forbid');
INSERT INTO `system_auth_node` VALUES ('133', '1', 'wechat/keys/resume');
INSERT INTO `system_auth_node` VALUES ('134', '1', 'wechat/keys/subscribe');
INSERT INTO `system_auth_node` VALUES ('135', '1', 'wechat/keys/defaults');
INSERT INTO `system_auth_node` VALUES ('136', '1', 'wechat/menu');
INSERT INTO `system_auth_node` VALUES ('137', '1', 'wechat/menu/index');
INSERT INTO `system_auth_node` VALUES ('138', '1', 'wechat/menu/edit');
INSERT INTO `system_auth_node` VALUES ('139', '1', 'wechat/menu/cancel');
INSERT INTO `system_auth_node` VALUES ('140', '1', 'wechat/news');
INSERT INTO `system_auth_node` VALUES ('141', '1', 'wechat/news/index');
INSERT INTO `system_auth_node` VALUES ('142', '1', 'wechat/news/select');
INSERT INTO `system_auth_node` VALUES ('143', '1', 'wechat/news/image');
INSERT INTO `system_auth_node` VALUES ('144', '1', 'wechat/news/add');
INSERT INTO `system_auth_node` VALUES ('145', '1', 'wechat/news/edit');
INSERT INTO `system_auth_node` VALUES ('146', '1', 'wechat/news/del');
INSERT INTO `system_auth_node` VALUES ('147', '1', 'wechat/news/push');
INSERT INTO `system_auth_node` VALUES ('148', '1', 'wechat/tags');
INSERT INTO `system_auth_node` VALUES ('149', '1', 'wechat/tags/index');
INSERT INTO `system_auth_node` VALUES ('150', '1', 'wechat/tags/add');
INSERT INTO `system_auth_node` VALUES ('151', '1', 'wechat/tags/edit');
INSERT INTO `system_auth_node` VALUES ('152', '1', 'wechat/tags/del');
INSERT INTO `system_auth_node` VALUES ('153', '1', 'wechat/tags/sync');

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` varchar(500) DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`),
  KEY `index_system_config_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统参数配置';

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('1', 'app_name', 'ThinkAdmin');
INSERT INTO `system_config` VALUES ('2', 'site_name', 'ThinkAdmin');
INSERT INTO `system_config` VALUES ('3', 'app_version', '3.0 dev');
INSERT INTO `system_config` VALUES ('4', 'site_copy', '&copy;版权所有 2014-2018 楚才科技');
INSERT INTO `system_config` VALUES ('5', 'browser_icon', 'http://service.thinkadmin.top/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png');
INSERT INTO `system_config` VALUES ('6', 'tongji_baidu_key', '');
INSERT INTO `system_config` VALUES ('7', 'miitbeian', '粤ICP备16006642号-2');
INSERT INTO `system_config` VALUES ('8', 'storage_type', 'local');
INSERT INTO `system_config` VALUES ('9', 'storage_local_exts', 'png,jpg,rar,doc,icon,mp4');
INSERT INTO `system_config` VALUES ('10', 'storage_qiniu_bucket', '');
INSERT INTO `system_config` VALUES ('11', 'storage_qiniu_domain', '');
INSERT INTO `system_config` VALUES ('12', 'storage_qiniu_access_key', '');
INSERT INTO `system_config` VALUES ('13', 'storage_qiniu_secret_key', '');
INSERT INTO `system_config` VALUES ('14', 'storage_oss_bucket', 'cuci');
INSERT INTO `system_config` VALUES ('15', 'storage_oss_endpoint', 'oss-cn-beijing.aliyuncs.com');
INSERT INTO `system_config` VALUES ('16', 'storage_oss_domain', 'cuci.oss-cn-beijing.aliyuncs.com');
INSERT INTO `system_config` VALUES ('17', 'storage_oss_keyid', '用你自己的吧');
INSERT INTO `system_config` VALUES ('18', 'storage_oss_secret', '用你自己的吧');
INSERT INTO `system_config` VALUES ('19', 'component_appid', 'wx1b8278fa121d8dc6');
INSERT INTO `system_config` VALUES ('20', 'component_appsecret', 'f404e33a75d278d6a0f944229bb84afb');
INSERT INTO `system_config` VALUES ('21', 'component_token', 'P8QHTIxpBEq88IrxatqhgpBm2OAQROkI');
INSERT INTO `system_config` VALUES ('22', 'component_encodingaeskey', 'L5uFIa0U6KLalPyXckyqoVIJYLhsfrg8k9YzybZIHsx');
INSERT INTO `system_config` VALUES ('23', 'wechat_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES ('24', 'wechat_appkey', '67b0056909f8ac5f42add03323d1faa0');
INSERT INTO `system_config` VALUES ('25', 'wuma_appid', '2844152665343808');
INSERT INTO `system_config` VALUES ('26', 'wuma_appkey', '25280e2930a30d81bc93b2bf40a62b48');
INSERT INTO `system_config` VALUES ('27', 'depot_pda_secret_key', 'ACE7041C3204B10736F11309B66E2214');
INSERT INTO `system_config` VALUES ('28', 'storage_oss_is_https', 'http');
INSERT INTO `system_config` VALUES ('29', 'store_title', '商城');
INSERT INTO `system_config` VALUES ('30', 'store_runtime_status', '0');
INSERT INTO `system_config` VALUES ('31', 'store_order_dalay', '1');
INSERT INTO `system_config` VALUES ('32', 'store_order_auto_cancel', '12.00');
INSERT INTO `system_config` VALUES ('33', 'store_order_auto_comfirm', '12.00');

-- ----------------------------
-- Table structure for system_log
-- ----------------------------
DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `node` char(200) NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=366 DEFAULT CHARSET=utf8 COMMENT='系统操作日志表';

-- ----------------------------
-- Records of system_log
-- ----------------------------
INSERT INTO `system_log` VALUES ('169', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-25 18:49:05');
INSERT INTO `system_log` VALUES ('170', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-25 18:53:02');
INSERT INTO `system_log` VALUES ('171', '116.21.13.54', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-26 10:28:18');
INSERT INTO `system_log` VALUES ('172', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-26 10:30:21');
INSERT INTO `system_log` VALUES ('173', '113.67.75.233', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-27 10:08:51');
INSERT INTO `system_log` VALUES ('174', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 13:17:51');
INSERT INTO `system_log` VALUES ('175', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 17:41:58');
INSERT INTO `system_log` VALUES ('176', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 17:57:28');
INSERT INTO `system_log` VALUES ('177', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 17:59:01');
INSERT INTO `system_log` VALUES ('178', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 17:59:04');
INSERT INTO `system_log` VALUES ('179', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:01:31');
INSERT INTO `system_log` VALUES ('180', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 18:01:35');
INSERT INTO `system_log` VALUES ('181', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:01:37');
INSERT INTO `system_log` VALUES ('182', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 18:01:43');
INSERT INTO `system_log` VALUES ('183', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:01:56');
INSERT INTO `system_log` VALUES ('184', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 18:02:14');
INSERT INTO `system_log` VALUES ('185', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:02:26');
INSERT INTO `system_log` VALUES ('186', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 18:02:30');
INSERT INTO `system_log` VALUES ('187', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:07:07');
INSERT INTO `system_log` VALUES ('188', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 18:07:50');
INSERT INTO `system_log` VALUES ('189', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:10:34');
INSERT INTO `system_log` VALUES ('190', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-02-28 18:10:38');
INSERT INTO `system_log` VALUES ('191', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:12:41');
INSERT INTO `system_log` VALUES ('192', '113.67.75.233', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 18:22:15');
INSERT INTO `system_log` VALUES ('193', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 19:06:46');
INSERT INTO `system_log` VALUES ('194', '61.140.235.78', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-02-28 20:51:18');
INSERT INTO `system_log` VALUES ('195', '61.140.235.78', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-01 09:15:54');
INSERT INTO `system_log` VALUES ('196', '59.42.236.22', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-01 11:17:00');
INSERT INTO `system_log` VALUES ('197', '113.67.74.221', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-02 10:00:39');
INSERT INTO `system_log` VALUES ('198', '113.67.74.221', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-02 11:09:52');
INSERT INTO `system_log` VALUES ('199', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-02 11:10:47');
INSERT INTO `system_log` VALUES ('200', '113.67.74.221', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-02 11:39:40');
INSERT INTO `system_log` VALUES ('201', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-02 12:28:13');
INSERT INTO `system_log` VALUES ('202', '113.67.74.221', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-02 12:31:01');
INSERT INTO `system_log` VALUES ('203', '113.67.74.221', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-02 17:33:13');
INSERT INTO `system_log` VALUES ('204', '61.136.79.242', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-05 09:02:47');
INSERT INTO `system_log` VALUES ('205', '113.67.73.37', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-05 13:53:34');
INSERT INTO `system_log` VALUES ('206', '113.67.73.37', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-05 18:40:09');
INSERT INTO `system_log` VALUES ('207', '116.21.13.188', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-05 20:01:19');
INSERT INTO `system_log` VALUES ('208', '61.140.235.78', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 00:08:40');
INSERT INTO `system_log` VALUES ('209', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 09:48:57');
INSERT INTO `system_log` VALUES ('210', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-03-06 09:51:12');
INSERT INTO `system_log` VALUES ('211', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 09:52:44');
INSERT INTO `system_log` VALUES ('212', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 10:01:02');
INSERT INTO `system_log` VALUES ('213', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-03-06 10:01:09');
INSERT INTO `system_log` VALUES ('214', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 10:01:11');
INSERT INTO `system_log` VALUES ('215', '113.67.73.37', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-03-06 10:48:41');
INSERT INTO `system_log` VALUES ('216', '113.67.73.37', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 10:49:00');
INSERT INTO `system_log` VALUES ('217', '113.67.73.37', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-03-06 10:49:18');
INSERT INTO `system_log` VALUES ('218', '113.67.73.37', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 10:49:45');
INSERT INTO `system_log` VALUES ('219', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-03-06 10:58:05');
INSERT INTO `system_log` VALUES ('220', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 10:58:20');
INSERT INTO `system_log` VALUES ('221', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 11:25:13');
INSERT INTO `system_log` VALUES ('222', '127.0.0.1', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-06 14:05:44');
INSERT INTO `system_log` VALUES ('223', '127.0.0.1', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-06 14:05:48');
INSERT INTO `system_log` VALUES ('224', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 14:09:04');
INSERT INTO `system_log` VALUES ('225', '127.0.0.1', 'admin/config/file', 'admin', '系统管理', '系统参数配置成功', '2018-03-06 14:10:11');
INSERT INTO `system_log` VALUES ('226', '127.0.0.1', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-06 14:10:23');
INSERT INTO `system_log` VALUES ('227', '127.0.0.1', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-06 14:10:32');
INSERT INTO `system_log` VALUES ('228', '127.0.0.1', 'wechat/tags/sync', 'admin', '微信管理', '同步全部微信粉丝标签成功', '2018-03-06 15:10:31');
INSERT INTO `system_log` VALUES ('229', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:31:09');
INSERT INTO `system_log` VALUES ('230', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:31:30');
INSERT INTO `system_log` VALUES ('231', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:31:54');
INSERT INTO `system_log` VALUES ('232', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:32:15');
INSERT INTO `system_log` VALUES ('233', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:32:35');
INSERT INTO `system_log` VALUES ('234', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:32:57');
INSERT INTO `system_log` VALUES ('235', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:33:18');
INSERT INTO `system_log` VALUES ('236', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:33:37');
INSERT INTO `system_log` VALUES ('237', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:33:57');
INSERT INTO `system_log` VALUES ('238', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:34:17');
INSERT INTO `system_log` VALUES ('239', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:34:35');
INSERT INTO `system_log` VALUES ('240', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:34:55');
INSERT INTO `system_log` VALUES ('241', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:35:14');
INSERT INTO `system_log` VALUES ('242', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:35:34');
INSERT INTO `system_log` VALUES ('243', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:35:55');
INSERT INTO `system_log` VALUES ('244', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:36:15');
INSERT INTO `system_log` VALUES ('245', '127.0.0.1', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-06 15:36:33');
INSERT INTO `system_log` VALUES ('246', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-06 15:37:05');
INSERT INTO `system_log` VALUES ('247', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 10:11:52');
INSERT INTO `system_log` VALUES ('248', '59.42.238.6', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 10:20:48');
INSERT INTO `system_log` VALUES ('249', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:28:36');
INSERT INTO `system_log` VALUES ('250', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:29:09');
INSERT INTO `system_log` VALUES ('251', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:29:13');
INSERT INTO `system_log` VALUES ('252', '127.0.0.1', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:32:28');
INSERT INTO `system_log` VALUES ('253', '127.0.0.1', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:35:52');
INSERT INTO `system_log` VALUES ('254', '127.0.0.1', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:37:08');
INSERT INTO `system_log` VALUES ('255', '127.0.0.1', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:37:35');
INSERT INTO `system_log` VALUES ('256', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:38:48');
INSERT INTO `system_log` VALUES ('257', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 10:38:50');
INSERT INTO `system_log` VALUES ('258', '113.67.75.198', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 11:49:52');
INSERT INTO `system_log` VALUES ('259', '59.42.238.6', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 11:50:08');
INSERT INTO `system_log` VALUES ('260', '59.42.238.6', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 11:50:41');
INSERT INTO `system_log` VALUES ('261', '127.0.0.1', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 12:14:40');
INSERT INTO `system_log` VALUES ('262', '127.0.0.1', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 12:15:27');
INSERT INTO `system_log` VALUES ('263', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 14:26:50');
INSERT INTO `system_log` VALUES ('264', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 14:28:27');
INSERT INTO `system_log` VALUES ('265', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 14:57:32');
INSERT INTO `system_log` VALUES ('266', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 15:02:02');
INSERT INTO `system_log` VALUES ('267', '59.42.238.6', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-07 15:02:04');
INSERT INTO `system_log` VALUES ('268', '127.0.0.1', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-07 15:36:58');
INSERT INTO `system_log` VALUES ('269', '59.42.238.6', 'wechat/news/push', 'admin', '微信管理', '图文[1]推送成功', '2018-03-07 15:38:19');
INSERT INTO `system_log` VALUES ('270', '59.42.238.6', 'wechat/tags/sync', 'admin', '微信管理', '同步全部微信粉丝标签成功', '2018-03-07 15:38:46');
INSERT INTO `system_log` VALUES ('271', '127.0.0.1', 'wechat/tags/sync', 'admin', '微信管理', '同步全部微信粉丝标签成功', '2018-03-07 15:41:43');
INSERT INTO `system_log` VALUES ('273', '175.172.29.18', 'wechat/news/push', 'admin', '微信管理', '图文[1]推送成功', '2018-03-07 15:48:41');
INSERT INTO `system_log` VALUES ('274', '113.67.75.198', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-07 17:59:56');
INSERT INTO `system_log` VALUES ('275', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 18:13:08');
INSERT INTO `system_log` VALUES ('276', '113.67.75.198', 'wechat/tags/sync', 'admin', '微信管理', '同步全部微信粉丝标签成功', '2018-03-07 18:46:16');
INSERT INTO `system_log` VALUES ('280', '59.42.238.6', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-07 23:01:37');
INSERT INTO `system_log` VALUES ('285', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-08 15:30:02');
INSERT INTO `system_log` VALUES ('286', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-08 17:06:28');
INSERT INTO `system_log` VALUES ('287', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-08 18:11:10');
INSERT INTO `system_log` VALUES ('288', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-08 18:40:51');
INSERT INTO `system_log` VALUES ('289', '116.22.196.196', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-08 20:32:32');
INSERT INTO `system_log` VALUES ('291', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 11:25:50');
INSERT INTO `system_log` VALUES ('292', '127.0.0.1', 'admin/login/out', 'admin', '系统管理', '用户退出系统成功', '2018-03-09 14:58:23');
INSERT INTO `system_log` VALUES ('293', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 14:58:46');
INSERT INTO `system_log` VALUES ('294', '59.42.237.151', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:09:15');
INSERT INTO `system_log` VALUES ('295', '59.42.237.151', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-09 15:10:10');
INSERT INTO `system_log` VALUES ('296', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 15:20:55');
INSERT INTO `system_log` VALUES ('297', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 15:21:08');
INSERT INTO `system_log` VALUES ('298', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 15:24:56');
INSERT INTO `system_log` VALUES ('299', '59.42.237.151', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:26:19');
INSERT INTO `system_log` VALUES ('300', '59.42.237.151', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:30:41');
INSERT INTO `system_log` VALUES ('301', '59.42.237.151', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:31:20');
INSERT INTO `system_log` VALUES ('302', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 15:31:24');
INSERT INTO `system_log` VALUES ('303', '127.0.0.1', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:45:34');
INSERT INTO `system_log` VALUES ('304', '127.0.0.1', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:46:11');
INSERT INTO `system_log` VALUES ('305', '127.0.0.1', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:46:31');
INSERT INTO `system_log` VALUES ('306', '127.0.0.1', 'wechat/menu/edit', 'admin', '微信管理', '发布微信菜单成功', '2018-03-09 15:46:43');
INSERT INTO `system_log` VALUES ('307', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 16:21:21');
INSERT INTO `system_log` VALUES ('308', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 16:23:21');
INSERT INTO `system_log` VALUES ('309', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 16:32:09');
INSERT INTO `system_log` VALUES ('310', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 16:32:45');
INSERT INTO `system_log` VALUES ('311', '59.42.237.151', 'wechat/fans/sync', 'admin', '微信管理', '同步全部微信粉丝成功', '2018-03-09 19:35:45');
INSERT INTO `system_log` VALUES ('312', '59.42.237.151', 'wechat/tags/sync', 'admin', '微信管理', '同步全部微信粉丝标签成功', '2018-03-09 19:36:38');
INSERT INTO `system_log` VALUES ('313', '116.22.196.196', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 21:12:54');
INSERT INTO `system_log` VALUES ('314', '116.22.196.196', 'wechat/config/index', 'admin', '微信管理', '修改微信接口参数成功', '2018-03-09 21:23:54');
INSERT INTO `system_log` VALUES ('315', '119.108.225.208', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-09 23:44:25');
INSERT INTO `system_log` VALUES ('316', '119.108.225.208', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-10 02:51:25');
INSERT INTO `system_log` VALUES ('317', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-10 11:06:45');
INSERT INTO `system_log` VALUES ('318', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-10 11:10:15');
INSERT INTO `system_log` VALUES ('319', '59.42.237.151', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-10 11:14:46');
INSERT INTO `system_log` VALUES ('360', '127.0.0.1', 'admin/config/file', 'admin', '系统管理', '系统参数配置成功', '2018-03-13 14:54:30');
INSERT INTO `system_log` VALUES ('361', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-13 14:57:52');
INSERT INTO `system_log` VALUES ('362', '127.0.0.1', 'admin/login/index', 'admin', '系统管理', '用户登录系统成功', '2018-03-13 15:04:35');
INSERT INTO `system_log` VALUES ('363', '127.0.0.1', 'admin/config/file', 'admin', '系统管理', '系统参数配置成功', '2018-03-13 15:07:22');
INSERT INTO `system_log` VALUES ('364', '127.0.0.1', 'admin/config/file', 'admin', '系统管理', '系统参数配置成功', '2018-03-13 15:07:25');
INSERT INTO `system_log` VALUES ('365', '127.0.0.1', 'admin/config/index', 'admin', '系统管理', '系统参数配置成功', '2018-03-13 15:07:59');

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `node` varchar(200) NOT NULL DEFAULT '' COMMENT '节点代码',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(400) NOT NULL DEFAULT '' COMMENT '链接',
  `params` varchar(500) DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
  `sort` int(11) unsigned DEFAULT '0' COMMENT '菜单排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `create_by` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_menu_node` (`node`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='系统菜单表';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES ('1', '0', '系统设置', '', '', '#', '', '_self', '9000', '1', '10000', '2018-01-19 15:27:00');
INSERT INTO `system_menu` VALUES ('2', '10', '后台菜单', '', 'fa fa-leaf', 'admin/menu/index', '', '_self', '10', '1', '10000', '2018-01-19 15:27:17');
INSERT INTO `system_menu` VALUES ('3', '10', '系统参数', '', 'fa fa-modx', 'admin/config/index', '', '_self', '20', '1', '10000', '2018-01-19 15:27:57');
INSERT INTO `system_menu` VALUES ('4', '11', '访问授权', '', 'fa fa-group', 'admin/auth/index', '', '_self', '20', '1', '10000', '2018-01-22 11:13:02');
INSERT INTO `system_menu` VALUES ('5', '11', '用户管理', '', 'fa fa-user', 'admin/user/index', '', '_self', '10', '1', '0', '2018-01-23 12:15:12');
INSERT INTO `system_menu` VALUES ('6', '11', '访问节点', '', 'fa fa-fort-awesome', 'admin/node/index', '', '_self', '30', '1', '0', '2018-01-23 12:36:54');
INSERT INTO `system_menu` VALUES ('7', '0', '后台首页', '', '', 'admin/index/main', '', '_self', '1000', '1', '0', '2018-01-23 13:42:30');
INSERT INTO `system_menu` VALUES ('8', '16', '系统日志', '', 'fa fa-code', 'admin/log/index', '', '_self', '10', '1', '0', '2018-01-24 13:52:58');
INSERT INTO `system_menu` VALUES ('9', '10', '文件存储', '', 'fa fa-stop-circle', 'admin/config/file', '', '_self', '30', '1', '0', '2018-01-25 10:54:28');
INSERT INTO `system_menu` VALUES ('10', '1', '系统管理', '', 'fa fa-scribd', '#', '', '_self', '200', '1', '0', '2018-01-25 18:14:28');
INSERT INTO `system_menu` VALUES ('11', '1', '访问权限', '', 'fa fa-anchor', '#', '', '_self', '300', '1', '0', '2018-01-25 18:15:08');
INSERT INTO `system_menu` VALUES ('16', '1', '日志管理', '', 'fa fa-hashtag', '#', '', '_self', '400', '1', '0', '2018-02-10 16:31:15');
INSERT INTO `system_menu` VALUES ('17', '0', '微信管理', '', '', '#', '', '_self', '8000', '1', '0', '2018-03-06 14:42:49');
INSERT INTO `system_menu` VALUES ('18', '17', '公众号配置', '', 'fa fa-cogs', '#', '', '_self', '0', '1', '0', '2018-03-06 14:43:05');
INSERT INTO `system_menu` VALUES ('19', '18', '微信授权绑定', '', 'fa fa-cog', 'wechat/config/index', '', '_self', '0', '1', '0', '2018-03-06 14:43:26');
INSERT INTO `system_menu` VALUES ('20', '18', '关注默认回复', '', 'fa fa-comment-o', 'wechat/keys/subscribe', '', '_self', '0', '1', '0', '2018-03-06 14:44:45');
INSERT INTO `system_menu` VALUES ('21', '18', '无反馈默认回复', '', 'fa fa-commenting', 'wechat/keys/defaults', '', '_self', '0', '1', '0', '2018-03-06 14:45:55');
INSERT INTO `system_menu` VALUES ('22', '18', '微信关键字管理', '', 'fa fa-hashtag', 'wechat/keys/index', '', '_self', '0', '1', '0', '2018-03-06 14:46:23');
INSERT INTO `system_menu` VALUES ('23', '17', '微信服务定制', '', 'fa fa-cubes', '#', '', '_self', '0', '1', '0', '2018-03-06 14:47:11');
INSERT INTO `system_menu` VALUES ('24', '23', '微信菜单管理', '', 'fa fa-gg-circle', 'wechat/menu/index', '', '_self', '0', '1', '0', '2018-03-06 14:47:39');
INSERT INTO `system_menu` VALUES ('25', '23', '微信图文管理', '', 'fa fa-map-o', 'wechat/news/index', '', '_self', '0', '1', '0', '2018-03-06 14:48:14');
INSERT INTO `system_menu` VALUES ('26', '17', '微信粉丝管理', '', 'fa fa-user', '#', '', '_self', '0', '1', '0', '2018-03-06 14:48:33');
INSERT INTO `system_menu` VALUES ('27', '26', '微信粉丝列表', '', 'fa fa-users', 'wechat/fans/index', '', '_self', '20', '1', '0', '2018-03-06 14:49:04');
INSERT INTO `system_menu` VALUES ('28', '26', '微信黑名单管理', '', 'fa fa-user-times', 'wechat/block/index', '', '_self', '30', '1', '0', '2018-03-06 14:49:22');
INSERT INTO `system_menu` VALUES ('29', '26', '微信标签管理', '', 'fa fa-tags', 'wechat/tags/index', '', '_self', '10', '1', '0', '2018-03-06 14:49:39');

-- ----------------------------
-- Table structure for system_node
-- ----------------------------
DROP TABLE IF EXISTS `system_node`;
CREATE TABLE `system_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `node` varchar(100) DEFAULT NULL COMMENT '节点代码',
  `title` varchar(500) DEFAULT NULL COMMENT '节点标题',
  `is_menu` tinyint(1) unsigned DEFAULT '0' COMMENT '是否可设置为菜单',
  `is_auth` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启动RBAC权限控制',
  `is_login` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启动登录控制',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_node_node` (`node`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统节点表';

-- ----------------------------
-- Records of system_node
-- ----------------------------
INSERT INTO `system_node` VALUES ('1', 'admin', '系统管理', '0', '1', '1', '2018-01-23 12:39:13');
INSERT INTO `system_node` VALUES ('2', 'admin/auth', '权限管理', '0', '1', '1', '2018-01-23 12:39:14');
INSERT INTO `system_node` VALUES ('3', 'admin/auth/index', '权限列表', '1', '1', '1', '2018-01-23 12:39:14');
INSERT INTO `system_node` VALUES ('4', 'admin/auth/apply', '访问授权', '0', '1', '1', '2018-01-23 12:39:19');
INSERT INTO `system_node` VALUES ('5', 'admin/auth/add', '添加权限', '0', '1', '1', '2018-01-23 12:39:22');
INSERT INTO `system_node` VALUES ('6', 'admin/auth/edit', '编辑权限', '0', '1', '1', '2018-01-23 12:39:23');
INSERT INTO `system_node` VALUES ('7', 'admin/auth/forbid', '禁用权限', '0', '1', '1', '2018-01-23 12:39:23');
INSERT INTO `system_node` VALUES ('8', 'admin/auth/resume', '启用权限', '0', '1', '1', '2018-01-23 12:39:24');
INSERT INTO `system_node` VALUES ('9', 'admin/auth/del', '删除权限', '0', '1', '1', '2018-01-23 12:39:25');
INSERT INTO `system_node` VALUES ('10', 'admin/config/index', '系统参数', '1', '1', '1', '2018-01-23 12:39:25');
INSERT INTO `system_node` VALUES ('11', 'admin/config/file', '文件存储', '0', '1', '1', '2018-01-23 12:39:26');
INSERT INTO `system_node` VALUES ('12', 'admin/config/sms', '短信接口', '0', '1', '1', '2018-01-23 12:39:28');
INSERT INTO `system_node` VALUES ('13', 'admin/log/index', '日志记录', '1', '1', '1', '2018-01-23 12:39:28');
INSERT INTO `system_node` VALUES ('14', 'admin/log/sms', '短信记录', '0', '1', '1', '2018-01-23 12:39:29');
INSERT INTO `system_node` VALUES ('15', 'admin/log/del', '日志删除', '0', '1', '1', '2018-01-23 12:39:29');
INSERT INTO `system_node` VALUES ('16', 'admin/menu/index', '系统菜单列表', '1', '1', '1', '2018-01-23 12:39:31');
INSERT INTO `system_node` VALUES ('17', 'admin/menu/add', '添加系统菜单', '0', '1', '1', '2018-01-23 12:39:31');
INSERT INTO `system_node` VALUES ('18', 'admin/menu/edit', '编辑系统菜单', '0', '1', '1', '2018-01-23 12:39:32');
INSERT INTO `system_node` VALUES ('19', 'admin/menu/del', '删除系统菜单', '0', '1', '1', '2018-01-23 12:39:33');
INSERT INTO `system_node` VALUES ('20', 'admin/menu/forbid', '禁用系统菜单', '0', '1', '1', '2018-01-23 12:39:33');
INSERT INTO `system_node` VALUES ('21', 'admin/menu/resume', '启用系统菜单', '0', '1', '1', '2018-01-23 12:39:34');
INSERT INTO `system_node` VALUES ('22', 'admin/node/index', '系统节点列表', '1', '1', '1', '2018-01-23 12:39:36');
INSERT INTO `system_node` VALUES ('23', 'admin/node/save', '保存节点信息', '0', '1', '1', '2018-01-23 12:39:36');
INSERT INTO `system_node` VALUES ('24', 'admin/user/index', '系统用户列表', '1', '1', '1', '2018-01-23 12:39:37');
INSERT INTO `system_node` VALUES ('25', 'admin/user/auth', '用户授权操作', '0', '1', '1', '2018-01-23 12:39:38');
INSERT INTO `system_node` VALUES ('26', 'admin/user/add', '添加系统用户', '0', '1', '1', '2018-01-23 12:39:39');
INSERT INTO `system_node` VALUES ('27', 'admin/user/edit', '编辑系统用户', '0', '1', '1', '2018-01-23 12:39:39');
INSERT INTO `system_node` VALUES ('28', 'admin/user/pass', '修改用户密码', '0', '1', '1', '2018-01-23 12:39:40');
INSERT INTO `system_node` VALUES ('29', 'admin/user/del', '删除系统用户', '0', '1', '1', '2018-01-23 12:39:41');
INSERT INTO `system_node` VALUES ('30', 'admin/user/forbid', '禁用系统用户', '0', '1', '1', '2018-01-23 12:39:41');
INSERT INTO `system_node` VALUES ('31', 'admin/user/resume', '启用系统用户', '0', '1', '1', '2018-01-23 12:39:42');
INSERT INTO `system_node` VALUES ('32', 'admin/config', '系统配置', '0', '1', '1', '2018-01-23 13:34:37');
INSERT INTO `system_node` VALUES ('33', 'admin/log', '日志管理', '0', '1', '1', '2018-01-23 13:34:48');
INSERT INTO `system_node` VALUES ('34', 'admin/menu', '系统菜单管理', '0', '1', '1', '2018-01-23 13:34:58');
INSERT INTO `system_node` VALUES ('35', 'admin/node', '系统节点管理', '0', '1', '1', '2018-01-23 13:35:17');
INSERT INTO `system_node` VALUES ('36', 'admin/user', '系统用户管理', '0', '1', '1', '2018-01-23 13:35:26');
INSERT INTO `system_node` VALUES ('37', 'wechat', '微信管理', '0', '1', '1', '2018-02-06 11:53:21');
INSERT INTO `system_node` VALUES ('38', 'wechat/config', '公众号对接', '0', '1', '1', '2018-02-06 11:53:32');
INSERT INTO `system_node` VALUES ('39', 'wechat/config/index', '公众号对接', '1', '1', '1', '2018-02-06 11:53:32');
INSERT INTO `system_node` VALUES ('45', 'wechat/block', '黑名单', '0', '1', '1', '2018-03-06 14:37:37');
INSERT INTO `system_node` VALUES ('46', 'wechat/block/index', '黑名单列表', '1', '1', '1', '2018-03-06 14:37:47');
INSERT INTO `system_node` VALUES ('47', 'wechat/block/backdel', '移出黑名单', '0', '1', '1', '2018-03-06 14:37:49');
INSERT INTO `system_node` VALUES ('48', 'wechat/fans', '粉丝管理', '0', '1', '1', '2018-03-06 14:38:06');
INSERT INTO `system_node` VALUES ('49', 'wechat/fans/index', '粉丝列表', '1', '1', '1', '2018-03-06 14:38:25');
INSERT INTO `system_node` VALUES ('50', 'wechat/fans/backadd', '移入黑名单', '0', '1', '1', '2018-03-06 14:38:35');
INSERT INTO `system_node` VALUES ('51', 'wechat/fans/tagset', '标签设置', '0', '1', '1', '2018-03-06 14:38:36');
INSERT INTO `system_node` VALUES ('52', 'wechat/fans/tagadd', '添加标签', '0', '1', '1', '2018-03-06 14:38:37');
INSERT INTO `system_node` VALUES ('53', 'wechat/fans/tagdel', '删除标签', '0', '1', '1', '2018-03-06 14:38:38');
INSERT INTO `system_node` VALUES ('54', 'wechat/fans/sync', '同步粉丝', '0', '1', '1', '2018-03-06 14:38:38');
INSERT INTO `system_node` VALUES ('55', 'wechat/keys', '关键字管理', '0', '1', '1', '2018-03-06 14:39:21');
INSERT INTO `system_node` VALUES ('56', 'wechat/keys/index', '关键字列表', '1', '1', '1', '2018-03-06 14:39:25');
INSERT INTO `system_node` VALUES ('57', 'wechat/keys/add', '添加关键字', '0', '1', '1', '2018-03-06 14:39:27');
INSERT INTO `system_node` VALUES ('58', 'wechat/keys/edit', '编辑关键字', '0', '1', '1', '2018-03-06 14:39:28');
INSERT INTO `system_node` VALUES ('59', 'wechat/keys/del', '删除关键字', '0', '1', '1', '2018-03-06 14:39:42');
INSERT INTO `system_node` VALUES ('60', 'wechat/keys/forbid', '禁用关键字', '0', '1', '1', '2018-03-06 14:39:55');
INSERT INTO `system_node` VALUES ('61', 'wechat/keys/resume', '启用关键字', '0', '1', '1', '2018-03-06 14:40:01');
INSERT INTO `system_node` VALUES ('62', 'wechat/keys/subscribe', '关注默认回复', '1', '1', '1', '2018-03-06 14:40:12');
INSERT INTO `system_node` VALUES ('63', 'wechat/keys/defaults', '无反馈默认回复', '1', '1', '1', '2018-03-06 14:40:27');
INSERT INTO `system_node` VALUES ('64', 'wechat/menu', '微信菜单管理', '0', '1', '1', '2018-03-06 14:40:37');
INSERT INTO `system_node` VALUES ('65', 'wechat/menu/index', '微信菜单管理', '1', '1', '1', '2018-03-06 14:40:41');
INSERT INTO `system_node` VALUES ('66', 'wechat/menu/edit', '编辑发布菜单', '0', '1', '1', '2018-03-06 14:40:53');
INSERT INTO `system_node` VALUES ('67', 'wechat/menu/cancel', '取消发布菜单', '0', '1', '1', '2018-03-06 14:41:01');
INSERT INTO `system_node` VALUES ('68', 'wechat/news', '图文内容管理', '0', '1', '1', '2018-03-06 14:41:13');
INSERT INTO `system_node` VALUES ('69', 'wechat/news/index', '图文内容管理', '1', '1', '1', '2018-03-06 14:41:20');
INSERT INTO `system_node` VALUES ('70', 'wechat/news/select', '图文选择器', '0', '1', '1', '2018-03-06 14:41:22');
INSERT INTO `system_node` VALUES ('71', 'wechat/news/image', '图文选择器', '0', '1', '1', '2018-03-06 14:41:22');
INSERT INTO `system_node` VALUES ('72', 'wechat/news/add', '添加图文', '0', '1', '1', '2018-03-06 14:41:23');
INSERT INTO `system_node` VALUES ('73', 'wechat/news/del', '删除图文', '0', '1', '1', '2018-03-06 14:41:23');
INSERT INTO `system_node` VALUES ('74', 'wechat/news/push', '推荐图文', '0', '1', '1', '2018-03-06 14:41:24');
INSERT INTO `system_node` VALUES ('75', 'wechat/news/edit', '编辑图文', '0', '1', '1', '2018-03-06 14:41:25');
INSERT INTO `system_node` VALUES ('76', 'wechat/tags', '标签管理', '0', '1', '1', '2018-03-06 14:42:06');
INSERT INTO `system_node` VALUES ('77', 'wechat/tags/index', '标签列表', '1', '1', '1', '2018-03-06 14:42:09');
INSERT INTO `system_node` VALUES ('78', 'wechat/tags/add', '添加标签', '0', '1', '1', '2018-03-06 14:42:14');
INSERT INTO `system_node` VALUES ('79', 'wechat/tags/edit', '编辑标签', '0', '1', '1', '2018-03-06 14:42:17');
INSERT INTO `system_node` VALUES ('80', 'wechat/tags/del', '删除标签', '0', '1', '1', '2018-03-06 14:42:20');
INSERT INTO `system_node` VALUES ('81', 'wechat/tags/sync', '同步标签', '0', '1', '1', '2018-03-06 14:42:23');
INSERT INTO `system_node` VALUES ('229', 'admin/node/clear', '清理无效记录', '0', '1', '1', '2018-03-09 12:24:31');

-- ----------------------------
-- Table structure for system_sequence
-- ----------------------------
DROP TABLE IF EXISTS `system_sequence`;
CREATE TABLE `system_sequence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL COMMENT '序号类型',
  `sequence` char(50) NOT NULL COMMENT '序号值',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_sequence_unique` (`type`,`sequence`) USING BTREE,
  KEY `index_system_sequence_type` (`type`),
  KEY `index_system_sequence_number` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统序号表';

-- ----------------------------
-- Records of system_sequence
-- ----------------------------

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
  `desc` varchar(255) DEFAULT '' COMMENT '备注说明',
  `login_num` bigint(20) unsigned DEFAULT '0' COMMENT '登录次数',
  `login_at` datetime DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `authorize` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '删除状态(1:删除,0:未删)',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_user_username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES ('10000', 'admin', '21232f297a57a5a743894a0e4a801fc3', '22222222', 'zoujingli@qq.com', '13617343800', '', '22405', '2018-03-13 15:04:35', '1', '1', '0', null, '2015-11-13 15:14:22');

-- ----------------------------
-- Table structure for wechat_fans
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans`;
CREATE TABLE `wechat_fans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` char(50) DEFAULT '' COMMENT '公众号Appid',
  `unionid` char(100) DEFAULT '' COMMENT 'unionid',
  `openid` char(100) DEFAULT '' COMMENT '用户的标识,对当前公众号唯一',
  `spread_openid` char(100) DEFAULT '' COMMENT '推荐人OPENID',
  `spread_at` datetime DEFAULT NULL COMMENT '推荐时间',
  `tagid_list` varchar(100) DEFAULT '' COMMENT '标签id',
  `is_black` tinyint(1) unsigned DEFAULT '0' COMMENT '是否为黑名单用户',
  `subscribe` tinyint(1) unsigned DEFAULT '0' COMMENT '用户是否关注该公众号(0:未关注, 1:已关注)',
  `nickname` varchar(200) DEFAULT '' COMMENT '用户的昵称',
  `sex` tinyint(1) unsigned DEFAULT NULL COMMENT '用户的性别,值为1时是男性,值为2时是女性,值为0时是未知',
  `country` varchar(50) DEFAULT '' COMMENT '用户所在国家',
  `province` varchar(50) DEFAULT '' COMMENT '用户所在省份',
  `city` varchar(50) DEFAULT '' COMMENT '用户所在城市',
  `language` varchar(50) DEFAULT '' COMMENT '用户的语言,简体中文为zh_CN',
  `headimgurl` varchar(500) DEFAULT '' COMMENT '用户头像',
  `subscribe_time` bigint(20) unsigned DEFAULT '0' COMMENT '用户关注时间',
  `subscribe_at` datetime DEFAULT NULL COMMENT '关注时间',
  `remark` varchar(50) DEFAULT '' COMMENT '备注',
  `expires_in` bigint(20) unsigned DEFAULT '0' COMMENT '有效时间',
  `refresh_token` varchar(200) DEFAULT '' COMMENT '刷新token',
  `access_token` varchar(200) DEFAULT '' COMMENT '访问token',
  `subscribe_scene` varchar(200) DEFAULT '' COMMENT '扫码关注场景',
  `qr_scene` varchar(100) DEFAULT '' COMMENT '二维码场景值',
  `qr_scene_str` varchar(200) DEFAULT '' COMMENT '二维码场景内容',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_fans_spread_openid` (`spread_openid`) USING BTREE,
  KEY `index_wechat_fans_openid` (`openid`) USING BTREE,
  KEY `index_wechat_fans_unionid` (`unionid`),
  KEY `index_wechat_fans_is_back` (`is_black`),
  KEY `index_wechat_fans_subscribe` (`subscribe`)
) ENGINE=InnoDB AUTO_INCREMENT=2324 DEFAULT CHARSET=utf8 COMMENT='微信粉丝';

-- ----------------------------
-- Records of wechat_fans
-- ----------------------------
INSERT INTO `wechat_fans` VALUES ('2227', 'wx60a43dd8161666d4', 'oGsrkszQSaou6tKM-4c2Tl625Ta8', 'o38gps8yp0qvO2Oa0OelGA66uX8k', '', null, '2', '0', '1', '\\ud83d\\ude36 夏俊杰', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/ajNVdqHZLLAWLLrYeJLDoL7FaicsJ2zbI92l04ibMIk8ym62Unzg9ZhatQDXqicXkXjjVDbicN9dK5GRVz2Pcfv7JA/132', '1484634161', '2017-01-17 14:22:41', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2228', 'wx60a43dd8161666d4', 'oGsrks1qovmJUGycmiAKSry3ISp4', 'o38gps4pJjHGkXVGe1aXxgzKJ7u4', '', null, '', '0', '1', 'Y.c', '1', '中国', '贵州', '贵阳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhXkkCBI9xTlsSFWhic9MhhoVcFsjR7AS1u3sOQCQdZYpt4MIaIvulmZhibBT9ibmuPiby7Qdic1NPjnnQ/132', '1517301228', '2018-01-30 16:33:48', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2229', 'wx60a43dd8161666d4', 'oGsrks9XUFq6O6g2len8l2TaS6dA', 'o38gps5khVMMG2trfekmkNX13VOI', '', null, '2', '0', '1', '成哲', '1', '中国', '福建', '泉州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM5BicBM70CuKklke6GvFFGzPibK60aR42zibKfpOe6xzwJFlUreOmTtagKXYyK6p2tlqaKAx3ISMyaCw/132', '1497508654', '2017-06-15 14:37:34', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2230', 'wx60a43dd8161666d4', 'oGsrks9i1WGC341Sw8YSzLh_L-ws', 'o38gps-IeXhG6ghhF1oUHmPrC4mw', '', null, '', '0', '1', '胜!!!', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKqWzwNeqjpichF75WDj9sib9oexCiaU8sY3fZtmNUA3Qnc7wDKG3csRuIrN5wbfospITr4icqa89IGUruHOHQstdEy4/132', '1499953283', '2017-07-13 21:41:23', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2231', 'wx60a43dd8161666d4', 'oGsrkswZ9aRbMxNeADBiIoFs7Ixs', 'o38gps5cxg7TIJjhW40hcfx3ceM0', '', null, '', '0', '1', '大豪', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKqWzwNeqjpichAgPGia3yWJjWELUkZB1ZeNLiaA5FUtiaicc4t1nicDW8j7bllJVnAlKNYOD3hrXiaricadxuzTUveqIghR/132', '1501054131', '2017-07-26 15:28:51', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2232', 'wx60a43dd8161666d4', 'oGsrkszCVFA8v-3_FGYhmTRiURlc', 'o38gpsza67FfLSapYrfBTo1Zu5zw', '', null, '', '0', '1', '杨永安', '1', '中国', '陕西', '汉中', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnjFHIKUiabCChkMVagHWKWmHrtxcgfrSRM9SrYjhcXvXTIuTwcfoT2g2HjdckiaxUyicU2T6hcKazca6IzF1vKz2Jic/132', '1514250857', '2017-12-26 09:14:17', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2233', 'wx60a43dd8161666d4', 'oGsrks8FUHqgI4nOt8JJP8qd8ioE', 'o38gps7jMkHnBSV6JN-Rpgog6lu0', '', null, '', '0', '1', '生命精神', '1', '中国', '浙江', '杭州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1nJzR8unwfcHwsPJh1P5SWGcxK4tCMh0to6KrsRCzWn8MZLibmeD6bMgItT1bs8ROmrNahJib2lDhAQ/132', '1476402502', '2016-10-14 07:48:22', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2234', 'wx60a43dd8161666d4', 'oGsrks2Mv-0flhVG8Oi-bZZSdRFE', 'o38gps1COGG9--oRbPIazGFPmtcE', '', null, '2', '0', '1', 'Howard', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnjFHIKUiabCChlvlBvNO4ItvQANPqmdKRIoDJTXm56vaS0ic2luQH0MwyMglnuYJlrVHNJp78RhYkknibSZI68RvZp/132', '1466066875', '2016-06-16 16:47:55', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2235', 'wx60a43dd8161666d4', 'oGsrks5PzhNfMRmV1E5dL6Ydsm4A', 'o38gps9lnht0uxYR6cTlnntT6bA0', '', null, '', '0', '1', '_Xiαпg™', '1', '中国', '广东', '深圳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1mkKSyWyia8EEvwt23OaKQmcibicbzKmyDHP8HNeHEHqc552NUtZeoTZ4PhBNYWvYyae5WeSa6KRoq4gtwciamjI9DI/132', '1496038821', '2017-05-29 14:20:21', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2236', 'wx60a43dd8161666d4', 'oGsrks9Sl2pcIhFCLoXBwxFi5P8w', 'o38gps2DCEuBJkh-5i9kGg7lxNsE', '', null, '', '0', '1', '在路上', '1', '中国', '上海', '浦东新区', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/ajNVdqHZLLCicuAKzkTwgEBjApfbJO4leQhpxR3kLsszfu3qcNaIzAsod4jW06HasuBCgFURe13b1NiabBHblpcQ/132', '1496907572', '2017-06-08 15:39:32', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2237', 'wx60a43dd8161666d4', 'oGsrks7bq2oijI9rA38zZ1KxTHyA', 'o38gps1-O1OEFn6Fle0jQGoDuDdg', '', null, '', '0', '1', '无形…', '1', '中国', '四川', '成都', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFlqFUCaneic7zYBL9qFNibfCSyyTxQfRwlmYGE7EL54lHJ6DbuWUqfbvTLnWqiaMYzGSiatDNqwKwuE2z1OLKygepqe/132', '1510799509', '2017-11-16 10:31:49', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2238', 'wx60a43dd8161666d4', 'oGsrks68g1elLyggOA9wUXezjkVY', 'o38gps-clgtfbM1BjVHTV7OdQTiY', '', null, '', '0', '1', '瓦力', '1', '中国', '河南', '洛阳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/ajNVdqHZLLCM2O5qico9GsVRoicn1HHh6BXuyJ1xUkjuc0icq1e1DN6hh87P5KchiblFkpYic9cHmlcQwBXdwKebQBg/132', '1498804317', '2017-06-30 14:31:57', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2239', 'wx60a43dd8161666d4', 'oGsrksydSQWBQZBegH8J5u6CM8Jc', 'o38gpszDg5iN-1GlAObk6Lj4RhfM', '', null, '2', '0', '1', '一卡易|谢永发', '1', '中国', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1mnLu0ourZB5uibPZM6m9cCXO2AmPTHHciaMjgLbibRTjpjKwrbFmhqfPKkXbttWZj8uGibcaphnicibSng/132', '1492329188', '2017-04-16 15:53:08', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2240', 'wx60a43dd8161666d4', 'oGsrks-mJu7hqiRMhNDPVGR0Fu9o', 'o38gpszLGFY86inXygfs3klN5QMI', '', null, '', '0', '1', '叫我小周', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/PiajxSqBRaEIxKQLuhIBibnLUkbHjfyiaKXBWaZcWbS6vibLAiaicFDkMWyxia4Mt75pUMp0WiczciaEUM8keeQg71D7X6A/132', '1461314119', '2016-04-22 16:35:19', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2241', 'wx60a43dd8161666d4', 'oGsrks0Q0Q5WAT-aSKHuJsmXjojU', 'o38gps_d4aGPEpf6eyRH73SAuCuY', '', null, '', '0', '1', '李彦18127877079微商系统一站通', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1mkKSyWyia8EEquArYSyUgT9dHEUBrFMvuUVWTAQMVcTpicEUicafhGqzYHyslrvLUvZ5TziaEKJvcYQkq6hOBw5qNk/132', '1501207299', '2017-07-28 10:01:39', '', '0', '', '', 'ADD_SCENE_PROFILE_CARD', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2242', 'wx60a43dd8161666d4', 'oGsrks1_4lRQum_CKGWAVsDZxYps', 'o38gps33cPD8u2cxNx5evYBYIVs8', '', null, '', '0', '1', '逸尘', '1', '中国', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/ajNVdqHZLLBia7xaYiafnETkiczAxjqJsAuyEiapPbjcEFqO3HWtPC2Ekny5jY1Dq8dPCLDRZGFoxBy1ELOia1hLkDg/132', '1520303270', '2018-03-06 10:27:50', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2243', 'wx60a43dd8161666d4', 'oGsrksx8x7WPo5hELWahpPnbDcKw', 'o38gps1OSpEMht-JsrSZ2-WwqZpY', '', null, '2', '0', '1', '蚊子', '1', '中国', '浙江', '杭州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM6W7naf6WCsmEcEKXZ7EDlHR4RtbKzvfAOxDf4ZicAZ9yRU0MA3icVW0PSmgHR7hd7AR8JZQcumBKxw/132', '1499867678', '2017-07-12 21:54:38', '', '0', '', '', 'ADD_SCENE_PROFILE_CARD', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2244', 'wx60a43dd8161666d4', 'oGsrks6zpXTf3A9n6hJeElMM1CF0', 'o38gps31jfVXc2XAHI-kkkb68btw', '', null, '', '0', '1', '辫子编程', '1', '中国', '河北', '石家庄', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1lKOpDLzcicpHdUPtFHovDeujrfCwD1ibRplDic3W5aaziaZAFoX22085f82zl9FGmjGIADnPsKIgGaSg/132', '1505962042', '2017-09-21 10:47:22', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2245', 'wx60a43dd8161666d4', 'oGsrks7b6Vr4xR5zEfUxfkocvpFs', 'o38gps1zUbMdHqVrneOcRX2s9w-Y', '', null, '', '0', '1', '叫我小贤\\ue131', '2', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaa2ZABsHxhbDstmoknTNNDJ5UaLHQsbkvpjJUAT2yBtrgS9VA8v5CbmDsHKKiam8FNDuDqHudfVtBPIYcw3eicw4/132', '1500262365', '2017-07-17 11:32:45', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2246', 'wx60a43dd8161666d4', 'oGsrks1-omPbZPIyJjqDHGrJ2uNU', 'o38gpszg_-jIQYq6Iy2zBj3N5ndM', '', null, '', '0', '1', '周峥宇\\ud83e\\udd20我又胖了', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/PiajxSqBRaEJDT62uNn5Apd4hOGVbkYLIr0JeCuZiakMRYnpqcEibwbJhgd6tKLiba66NFNsFbWibshGup3ITAKsUhA/132', '1500284215', '2017-07-17 17:36:55', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2247', 'wx60a43dd8161666d4', 'oGsrks3xwnOorGl_tvt9oupQLxwY', 'o38gps8HQRZr3mk32MdM-KCm1rAI', '', null, '2', '0', '1', 'Aries', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaa2ZABsHxhbMBdNOwMpBIJNI4IguZ4d6BzQ6yKVxHWJmvNNZzjrMbloHj0Tm65p996cWmgib51WkLzxQiaNZ3gtl/132', '1499998442', '2017-07-14 10:14:02', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2248', 'wx60a43dd8161666d4', 'oGsrksxL7JHpBw-JQkzZlkoSKL_E', 'o38gps-YmcToFI9KPCIU50EzyApM', '', null, '', '0', '1', '动感排骨', '1', '阿拉伯联合酋长国', '迪拜', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1licrjBnJJkGRAIetAibGZMqsdFpIBUqjsL0CpTbTLWJwz48FHKZNj5VTOeQBBlJ8ufib3Qb3pLYvYfA/132', '1493167619', '2017-04-26 08:46:59', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2249', 'wx60a43dd8161666d4', 'oGsrks_ReHkrfr-fHmd9CROHrX7k', 'o38gps3KOfAj3hqGaLuYdi-F8Pcw', '', null, '', '0', '1', '(´-ι_-｀)', '1', '中国', '湖北', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM5Ba4Ha2y7wJQ5pH33bxJOCJXW4kHY48gwN2iaNB5L1Vib8eHxAzTnticHb9g2aLpEjAcRzqOknMNlMw/132', '1495683774', '2017-05-25 11:42:54', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2250', 'wx60a43dd8161666d4', 'oGsrks4vN3pEBSCIwOB8_Juat5l0', 'o38gpswFGKNyVQe8WEiEPj5V_o-E', '', null, '2', '0', '1', '喧气...炎魔', '0', '', '', '', 'zh_CN', '', '1467451373', '2016-07-02 17:22:53', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2251', 'wx60a43dd8161666d4', 'oGsrks8wZprONrqzxV50sUxsbyEM', 'o38gps6H7P1RE2pkvyLgHhK5X5yQ', '', null, '', '0', '1', '小朋', '1', '中国', '陕西', '西安', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKpZfaTicicM8gaa6Zyz3ZB4pLv8YZbq0yN35tS2H27fdAkkQIA1FlmHKr4c0Uz6G8nR3zLxNsPia2qzRNjygD57ia6s/132', '1461829132', '2016-04-28 15:38:52', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2252', 'wx60a43dd8161666d4', 'oGsrks5h-iq2PsHWnomgbHQW7cbI', 'o38gps2gTDZrgo7xDQcBnOv6kSCw', '', null, '', '0', '1', '肖', '1', '中国', '北京', '昌平', 'zh_TW', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM6P5wB3cJN5SkRHzwKTJ8Ixtyk8LDcA6zvTPTdkaBMicypiaxOTVYH2P1nib8wwmCIkrUkvskut1sVXQ/132', '1511144044', '2017-11-20 10:14:04', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2253', 'wx60a43dd8161666d4', 'oGsrks-4KSMJUTVBrkiZwmKFnKkw', 'o38gpsyHiwv9XeLT7FnB-X-wXnrY', '', null, '2', '0', '1', '杨志斌', '1', '中国', '江西', '吉安', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFnfDEMRYcBCAVHLhWduAGWWh1SmEfGnth6Qpibvzhiax5tUePAVg6w3CjbibUrACRrG9HxegTt0zCJ6A/132', '1468834443', '2016-07-18 17:34:03', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2254', 'wx60a43dd8161666d4', 'oGsrksx6pGST6OZpQd3kxVDVe0-4', 'o38gpsxqDndY2CNb-wKqzfQOCxOs', '', null, '', '0', '0', '.', '1', '阿鲁巴', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1ktoYc3JFOdy0UBggCicqR6QMCp09kTIhG96h6dRwLAI4CrTJ7AKR95n8CVKUjt1pftol3Sias1WFvQ/132', '1506388223', '2017-09-26 09:10:23', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2255', 'wx60a43dd8161666d4', 'oGsrks_ByPI_LoQcutU_Efgh9VFo', 'o38gps-hP-kkUfiDRrPNNgHt-2sk', '', null, '2', '0', '1', '李兴宇（大宇）', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaa2ZABsHxhbH3GFewwtabnLnd1dFvjVwvH232efzzR96aia0iaur7EhEC1NEuTQRKcbfiaVYNxt0Wplkj4nkEU1sw/132', '1466065790', '2016-06-16 16:29:50', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2256', 'wx60a43dd8161666d4', 'oGsrks33jf6hGYbr-fN4hl2O3t2E', 'o38gps0VZNX4tMBGf9wc62ze50iY', '', null, '', '0', '1', 'clement', '1', '中国', '河南', '郑州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFnStnyIWbGOSib3R3feZytljzGuMh82Q9oXLJejdDoXGhJjGtRXicXVJcAmc8KRBQOIL7dMKp41YXVw/132', '1501581665', '2017-08-01 18:01:05', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2257', 'wx60a43dd8161666d4', 'oGsrks0JJffPwk-8i9k1omC812ho', 'o38gpswRdt7MOJ0qTYkvcTzLVOL0', '', null, '', '0', '1', '孙海锋', '1', '中国', '四川', '达州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/ajNVdqHZLLDpWmRlKAcow16dZuXYKokRyX8kiazDtWEjXXOiaYaAXRjdrLribt8eB7pEodKzWqJ0gmdfoqlDbIG5g/132', '1499827720', '2017-07-12 10:48:40', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2258', 'wx60a43dd8161666d4', 'oGsrksy8u0sYaQ3n1oYliCkMzC68', 'o38gps2Tx8cdNfGzaEis2Mc4pvTI', '', null, '2', '0', '1', '周星星', '1', '中国', '陕西', '西安', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKpZfaTicicM8gaXUd33E2xm49mibmfE14cLwH2ROdxK7kI8vsVeVPOUvKZgE6JcwUmX0ZXWAVP44dKeFLUIz4zDWtia/132', '1498098232', '2017-06-22 10:23:52', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2259', 'wx60a43dd8161666d4', 'oGsrks23Z-JsvGGn9rFSNqBnW9ik', 'o38gps2HY7h23CJoVvk5PM303kNY', '', null, '', '0', '1', 'hxxx', '1', '中国', '广东', '深圳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaa2ZABsHxhbOOaHOUFD9B5wSic3q3icK8EE58G8PY0f4nALGOWdia25Z7wqSSanlfK6tBGuysyTenTLSJCBLSVnXF/132', '1506316538', '2017-09-25 13:15:38', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2260', 'wx60a43dd8161666d4', 'oGsrks_hP6tLtqnPLDO2c2mdCiKU', 'o38gpsyh30CKHUULhEf4ILUQqZ5s', '', null, '', '0', '1', 'Promise', '1', '中国', '广东', '深圳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKpZfaTicicM8gaUeOuxB80yqBYX6YiaYUkIS54eEmUpelLPvFd0uXfeoreo5wdb4uxSeYEaia5IYw2tiaS98Pg0Q64XK/132', '1509438514', '2017-10-31 16:28:34', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2261', 'wx60a43dd8161666d4', 'oGsrks8MgmWGcHiTXw8-MVOud_jk', 'o38gps3vNdCqaggFfrBRCRikwlWY', '', null, '2,195', '0', '1', 'Anyon', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKpZfaTicicM8gabdQdx2gUg5S8g0bpwruPiccFZRPhicvIiazQISqcia9kKQBETsYnJiakE1DSFhUN7t529jXh7iaibBjB5z/132', '1520407544', '2018-03-07 15:25:44', '', '0', '', '', 'ADD_SCENE_QR_CODE', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2262', 'wx60a43dd8161666d4', 'oGsrksyuQFA4llVF36HPs5Gv2UMQ', 'o38gps-uNjXogTeIcCq_Fs5d_J6E', '', null, '', '0', '1', '晨曦记忆，过往云烟', '1', '中国', '广西', '南宁', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1kJibfasazNpwQbdwJo28iaYfQRg5b7mPTQib52JHUSjrIaZ4uTO3HfriaAM6v9T8fpr3tpenv5mI9y8Q/132', '1497952981', '2017-06-20 18:03:01', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2263', 'wx60a43dd8161666d4', 'oGsrks9yOCbqOASjxEwfMwVNildI', 'o38gps79rC4d7rwnfhmWnxXi_1i8', '', null, '', '0', '1', '狒狒', '2', '中国', '湖南', '长沙', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaa2ZABsHxhbGVF36I9BzRtZKsHVnr8ucPeqwR03EAYXMLC36aN71dNJLc8axpaMkpDCepQLmltyZibjtZYeqfwe/132', '1461593762', '2016-04-25 22:16:02', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2264', 'wx60a43dd8161666d4', 'oGsrkszZVl6PTAtbzrmfkUl4KyLM', 'o38gpsxFtOXxBpZ9AjXs5RkEfPj0', '', null, '', '0', '1', 'Chen', '1', '中国', '广西', '南宁', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/QxhD6QevWDypRKO3jAbt91libGBOUmV1GibwYNJ7mQmP5xkdUDVoVXvN36bYeicD71pTFL4SgTbeqhe8DVvibt3uL6adwOt8J8bH/132', '1500003321', '2017-07-14 11:35:21', '', '0', '', '', 'ADD_SCENE_QR_CODE', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2265', 'wx60a43dd8161666d4', 'oGsrks7qKxIVsxToJYHuRANPEFB8', 'o38gps83KBbjv_gvAA41Hf2JTBDI', '', null, '', '0', '1', '谈德茂', '1', '中国', '湖北', '武汉', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFn6rUOLzb2HTQSoVHmHiaicqz45Td0ocFib53iaAzFicpuFwR9QAt8X87eotIhib1s69T8syxMxibiatJibGQw/132', '1504061982', '2017-08-30 10:59:42', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2266', 'wx60a43dd8161666d4', 'oGsrks_Yf9S9KemX-5shUhvPkWSk', 'o38gps_3EjXgILhDBDRhhrD7DMkk', '', null, '', '0', '1', 'NH', '2', '中国', '陕西', '西安', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/PiajxSqBRaELPibepDuGJ8xMgJCJRvBfwjVyq390nibich61YlXNFFia4aibvA4jibvcQtwLiczucKrdOpC25RHrReDSUA/132', '1461314624', '2016-04-22 16:43:44', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2267', 'wx60a43dd8161666d4', 'oGsrksxRpWEHDH9IdIxdus8_h57g', 'o38gpswZkDihqLaHEIgCYg2rDFek', '', null, '', '0', '1', '梁金城', '1', '中国', '广东', '湛江', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaa2ZABsHxhbKOjhibtPQbN6WE2l1hqFEjZYPlHxMeEjoXiaP8lnbyTmzRUxgWGcgwibTcthlLdyAAs4pwhsgFYpIc/132', '1509860364', '2017-11-05 13:39:24', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2268', 'wx60a43dd8161666d4', 'oGsrksxKC6HssWvXSv2hHXNFHf6M', 'o38gps4ssW_HpC_wiML44kJDPObo', '', null, '', '0', '1', '山里人', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/QxhD6QevWDypRKO3jAbt90Hc72JgV7Go0ygPRztzQXn5OBn4sTD7icSJTzrUsiaE9gGE7oPaNRmXicZsd2OVQAbZN83VswO2rmd/132', '1497665032', '2017-06-17 10:03:52', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2269', 'wx60a43dd8161666d4', 'oGsrks3QCAmS0w84Rz-vEId_vEjE', 'o38gpsyhNsz9oufVc9cJWX8YTkTE', '', null, '', '0', '1', 'Biao', '1', '中国', '广西', '南宁', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFnLq4hSElRXEqHibwT5P6gee7Q9dk9ca8icSCBhHnTNbh9KteCYKgepTUar9USzJlZLX3TvvpFVCsU3fNXyby3Bky/132', '1505788891', '2017-09-19 10:41:31', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2270', 'wx60a43dd8161666d4', 'oGsrks6H0hBnuX9dRGeqNQmoFm_Y', 'o38gps0ZJKvxjEc0N2BOgR-T1doM', '', null, '', '0', '1', 'hhaoqin', '1', '安道尔', '', '', 'en', 'http://thirdwx.qlogo.cn/mmopen/KULsUKmynFu6SiahhNaO6M5RmJZYJTEM8TcsuiaUiaDuUh6NuQzx17CZ0JrU3XD8vzUvCdhPfT8Hcxhian6kY96ZqIgOfta4Vv5Z/132', '1513841189', '2017-12-21 15:26:29', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2271', 'wx60a43dd8161666d4', 'oGsrksynwJRL7pBTOshy-iMzFwOc', 'o38gps-4TexA575MN0Qy_x7hPeGU', '', null, '2,195', '0', '1', '黑马\\ue419青田嗨购', '1', '中国', '浙江', '丽水', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/PiajxSqBRaEKDmibBPic7ia9uCAznbmiacpXjlPLbK8RO6DunGb4BKLlaK9szMae6p64xtmkN1hIAmiaHWwEyeKBEjZ3GJo7bUc0AqovWRn16icSL4/132', '1520417834', '2018-03-07 18:17:14', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2272', 'wx60a43dd8161666d4', 'oGsrks68I0iO8K1a-ovuXlQbe6ek', 'o38gps35ZFbur02-CpnFoCJ-a_BM', '', null, '', '0', '1', '代号为纯洁\\ud83d\\ude43', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKrBw3cFObrgH5sPDvLic7on8pdfrgRSVXicBEiaJ8XXsrojeAma7SHIL4vWAibnYhpRYYzklVO5OhhQ3Yjngr2mp3Ag/132', '1487058795', '2017-02-14 15:53:15', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2273', 'wx60a43dd8161666d4', 'oGsrks5oAnVDeARhvzJsXkv9cwj0', 'o38gps2FSyO8uilTJiC5RqaqPptQ', '', null, '', '0', '1', 'Miranda', '2', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlK9MUdQ3sMKzPChibZRlLKNDfZQRU2OUshtAyFsUZL0BhxbrR09zrH1p1QFRb67gbKm0oaG6GSl6y/132', '1461418982', '2016-04-23 21:43:02', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2274', 'wx60a43dd8161666d4', 'oGsrksw6We2OFFxFcjtKgvHK9f10', 'o38gpszO1lJ05I_jRV0vUNmFzZR4', '', null, '', '0', '0', '衣先生', '1', '中国', '山东', '青岛', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFmr7dAfxG0unedyDjK6rjffLsvEPGZHqWptiac60Y4Ts0U8IibDvGzic4iaNaO4Hx5RzPGlM0gkLPnolyzSUIMsDj2k/132', '1520302268', '2018-03-06 10:11:08', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2275', 'wx60a43dd8161666d4', 'oGsrks_cMX730air6ZKOSPhUv5bI', 'o38gps5zUa08f5ivxsv10AqPVTM8', '', null, '', '0', '1', '阿科', '1', '中国', '湖北', '荆州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlCrtvWZCGVUsTQpZzGR53Ykyg1rjg5jTWiaEDQKdtsewAwEXFavouZcwfOAF390ibDC9MXWOdoDwicy/132', '1517735573', '2018-02-04 17:12:53', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2276', 'wx60a43dd8161666d4', 'oGsrks43DcAGrJnOczRRYbEywK_A', 'o38gps-K1CBkMth56oq0YpiP7z6s', '', null, '', '0', '0', '叶之伟', '1', '中国', '山东', '济南', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/KULsUKmynFu6SiahhNaO6M0NicAD2zcuYiaCLolMdp0YicmTqjzoHTst50GQJtjxBRKpG4SKP7yFzhpVYx4FQA0MguicpXwnwUJca/132', '1515672598', '2018-01-11 20:09:58', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2277', 'wx60a43dd8161666d4', 'oGsrks6KXJGK44csA7Ye6kIfbLn4', 'o38gps2fH8aFwmFhFhU4Aurv18os', '', null, '', '0', '1', 'UM - 15524468881', '1', '中国', '辽宁', '沈阳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFmr7dAfxG0unQpG2L0JFNuvwW19VD6ZuhR3ycpbk1SjIp4daCm9sdrzWI7E4ZjlXbibRcvy1JKHYc9U7XPAQ3W8V/132', '1516189815', '2018-01-17 19:50:15', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2278', 'wx60a43dd8161666d4', 'oGsrksyJ9EZJAjlzQdZnGByZiwyE', 'o38gps9GErwzTtZPTiNPC9f8ay1s', '', null, '', '0', '1', '昂', '2', '中国', '吉林', '长春', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/KULsUKmynFu6SiahhNaO6M3MunrZR1ACAIalhmLGWSs4RHhY6d4ibglDGJXypxhmpDrcgb50muM37bR3wZTcpjzlGP3LQ2KFJR/132', '1511158120', '2017-11-20 14:08:40', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2279', 'wx60a43dd8161666d4', 'oGsrkswvewcgA2obzWXeCj_yIHzs', 'o38gpsycVcwBKD3CfXL4hhzvOgt4', '', null, '', '0', '1', 'linf', '1', '中国', '上海', '青浦', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlNiaEKOh52TwmbCSiaUavoqRAGZvgjlcEbgibZlHUODepwaicMcME7EYD5q7wicOPKBKtEIYzFicibES4gK/132', '1495794329', '2017-05-26 18:25:29', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2280', 'wx60a43dd8161666d4', 'oGsrks2xiOxVbOWvaJYHEWkGxzWk', 'o38gps-cq3BpRloot4Zn_SgkERIU', '', null, '', '0', '1', '瑋瑋', '2', '中国', '湖南', '衡阳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1mWdjxsYDFxLgNia0zvtXj9NTLNic1btoLLpIGVu6CviafENqODPtZ4icH7YL07ImRciaEc6BwlJRmDxVfxic2pIiaeOTL/132', '1472542553', '2016-08-30 15:35:53', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2281', 'wx60a43dd8161666d4', 'oGsrksyLTQeGsy4ePCY_yKfBYMF8', 'o38gps2VZzGMKIpQyebRKfv--5Gk', '', null, '', '0', '1', 'lemon', '1', '中国', '湖北', '武汉', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlKfwQcmu0EqdAzpibIiao3Sr8oHbBt2sObibUHOJj2errQyfbRW29TTTooI4eCJWiafPXAh9rUntlFQT/132', '1508837682', '2017-10-24 17:34:42', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2282', 'wx60a43dd8161666d4', 'oGsrks0jW9y25wKFxLurrUPrxvFw', 'o38gps-VE_f7mOEfN5NRf9fzYLNg', '', null, '2', '0', '1', '暴躁的jk苏', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1mWdjxsYDFxLjE1gRKdbiaibvesz4iaXN4wCEJX49wKuVUhjic57UicRjT6mbaEFVeFUvwQUkffRjP7za5ezHicNCr0WZ/132', '1476260898', '2016-10-12 16:28:18', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2283', 'wx60a43dd8161666d4', 'oGsrksxKqIJpVprxJUsbAdZZ5tjU', 'o38gps9nSy6jFfqk8dS5QhtPh8nc', '', null, '', '0', '1', 'JHChan', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/bnoQ9ztOjnTj93lo94aVb4ZIwA4m2jKBZnqVpcjm7fKqua8fkgp8mIRwicl68uGpxZ65GibLCzJoNcbOVWbpQRYWib1D6VCGSrC/132', '1508309343', '2017-10-18 14:49:03', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2284', 'wx60a43dd8161666d4', 'oGsrks8ZUdqV1DJ7nAqWXCtli5YI', 'o38gps14GCla4tRvK5vLpYWyYeQU', '', null, '', '0', '1', 'fantasticcat', '1', '中国', '四川', '成都', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKpT2WiaPkStSibc7ROfOldhenn4G8hJMsL3Ga3q63ia3vEibytQF1IRqo7flfI62iaUuOIP3OECU217Cfib6icnxBSDGsC/132', '1504289794', '2017-09-02 02:16:34', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2285', 'wx60a43dd8161666d4', 'oGsrks3bi69ROBM7wdcnwLiCJN7g', 'o38gps0kRV2gBR97_kn69yXfiQ4o', '', null, '', '0', '1', '༄ེིོུ張偉ཉ྄ིོུ', '1', '中国', '江苏', '南京', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlPKWmdmurlyTJvu98zJvDCfmfvHQUjPhackiatOzWQbHHGntrocpaicEwNtmNAtVuCEkAZ9okPyaWf/132', '1512742506', '2017-12-08 22:15:06', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2286', 'wx60a43dd8161666d4', 'oGsrksy0OwP1IYm09qo_kaXyCxgc', 'o38gps76Z2Pn1Iv6y85sDS0jIgG0', '', null, '', '0', '1', '.', '1', '中国', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM7rYo6NN0asQjBKCjlPibyyxichoibBXLY1VeKHDw7dmdJLGHJzQtbqOgTdpsj9GGBLu77Ef2ezFp6g8qgDuhfKCQte5LcECqlPtw/132', '1503387391', '2017-08-22 15:36:31', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2287', 'wx60a43dd8161666d4', 'oGsrks8wNGTqTCcLsqXSLYAVeio8', 'o38gpsyU0XajgtHzkCbd5tGhTdEc', '', null, '', '0', '1', '劲松', '1', '中国', '湖北', '武汉', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlMDlhvyJq18DBIrKUJ5Fu2ibCeltbQAPEtvloLd1qornF5zHrzR4hODCuHxoYUk0daLOhsQd4WaSS/132', '1519129201', '2018-02-20 20:20:01', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2288', 'wx60a43dd8161666d4', 'oGsrks--NFosz0qEXlty29HMvDhU', 'o38gps_VXV82i7k-aDEBxf73_wqc', '', null, '', '0', '1', 'xuhf', '1', '中国', '安徽', '合肥', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlPV94mAf8GIAficLU4icVjqbaRicBnUjry0qLk9tNvfibKcWsiba4fWObiaYs06bKK3mrd2KwpQN4ibKticR/132', '1498359038', '2017-06-25 10:50:38', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2289', 'wx60a43dd8161666d4', 'oGsrks9HRARkEHMSqsZKh5L0kfhw', 'o38gps-a5LvX7yhK_q0RMmavHLZs', '', null, '', '0', '1', '柯靖', '1', '中国', '重庆', '江北', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1mcAn4p8XickiciclKy1eG2Jxl41kaBGbib75xg8ocqKSAVuytCTKKbNoibARg3GPQDQyzjp5coqdZNBQiaEAWGtIgo9p/132', '1499769194', '2017-07-11 18:33:14', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2290', 'wx60a43dd8161666d4', 'oGsrksxBQW56NSMZvXuBDIDJh1iM', 'o38gps2sIrPg2g74VLwGgY-FRQz4', '', null, '', '0', '1', '二流子', '1', '中国', '四川', '成都', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM7sk1IrZ7LEPG52cktWKpB0f2xYzsxWJOBibfS6Ct9R2ZGyL61h43Y2gibLmNsf3pACIRomicqicdV14jzKZia4sibQhUBhUIAsmqtNc/132', '1502625756', '2017-08-13 20:02:36', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2291', 'wx60a43dd8161666d4', 'oGsrks4gMjJSBSWQbtyxwJiZQj18', 'o38gps0Trh8Ggyc7mwBH2XIRIAEc', '', null, '', '0', '1', 'Mr. La', '1', '中国', '青海', '西宁', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlIw66OXtcgoHictuwB6ZyWRQGOkSeEuibMytbxyZvPmM6r1HJHdia4Hgr07toMBj4PczIlfjnIVAtaB/132', '1516598324', '2018-01-22 13:18:44', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2292', 'wx60a43dd8161666d4', 'oGsrks5EfMlOFmfmwTwYG6WFlGCw', 'o38gps3PQyzns75wVKupe_8zQN14', '', null, '2', '0', '1', '杨翊(yì)', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFlhdxossu0UW6MKUKGvJObib9TXaNibDInOkPticBCeCTRl8HOibh8e0SLmFvusIspPuJU5EdRFnyKTibZOUCzB6ibk2G/132', '1464141541', '2016-05-25 09:59:01', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2293', 'wx60a43dd8161666d4', 'oGsrks5arhP8js3-C_Mc2tLOaB34', 'o38gps5soAzcDO6PvbTz3XE88VIY', '', null, '2', '0', '1', 'WGZXU', '2', '中国', '广东', '梅州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlHPCX0qeQZpGxaJRlwA7GjjKY30Rr4HpW9GwibzqdV2mSiaYYypDbqLDZyRWQiatcP8YoGD552mYgiaH/132', '1472019816', '2016-08-24 14:23:36', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2294', 'wx60a43dd8161666d4', 'oGsrks9Bl7SPEjPgN-ui3eFMhDog', 'o38gpszG6ZnGcvNV7feJnT70MCkI', '', null, '', '0', '1', 'piu piu', '1', '澳大利亚', '堪培拉', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFmr7dAfxG0unZbrGAx1eB9WAn3A6qlRrC6v49zINA1Om1zibUsQuR48enw1iajve86lEiciaWiboKzGaqTSSPF0HSRpO/132', '1496744829', '2017-06-06 18:27:09', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2295', 'wx60a43dd8161666d4', 'oGsrkszhE3kIdWyYlN4E_zgLWdUk', 'o38gpsyVfsO9gDNPoRDvsme8n3FE', '', null, '', '0', '1', 'A鼎盛电脑科技', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniataKbRtW1icXGOBCSkhgGs9MUyKylzOuWvqOoyX1OM8aXtTRKLek8yssWialQhneHdxBnl9vbU6OrJ6PaRQHuGm2/132', '1514213921', '2017-12-25 22:58:41', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2296', 'wx60a43dd8161666d4', 'oGsrks1Wd6i5m0YalfiuXg6X6a40', 'o38gpswc8aL1dUFMb2TcABmsksDw', '', null, '2', '0', '1', 'Adrian、', '1', '中国', '广东', '江门', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/6x8XdQdSNbyAXStw8vdF2G8hVk7RzNjpvZjExn3l7s7xLqlsL5unJvShahZ67kZXeytfxvySU1VXZ5JfGBvGOriahadYe9qtib/132', '1495683769', '2017-05-25 11:42:49', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2297', 'wx60a43dd8161666d4', 'oGsrks_nMhj7vI10yWxY8GzscIx0', 'o38gps4zEPecqw8rdL1b9d1D1YPo', '', null, '', '0', '1', '麦客', '1', '中国', '广东', '东莞', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/ajNVdqHZLLAiapCVthUgNysHHjeyicsQ8FtMhhjkcSOMX3yZaAK2IdRCsMO9J8H0ApicOvlZUsiaMiaibcouAftEwstiaTMQkMg5YB4YVicGIt8lGEc/132', '1493125763', '2017-04-25 21:09:23', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2298', 'wx60a43dd8161666d4', 'oGsrkswo8fDPab1lg_UXQkK6kOFA', 'o38gps74mjt-oVMudAu7zHmD70Jk', '', null, '', '0', '1', 'Simon', '1', '中国', '云南', '昆明', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhmHmkWasbv8O5rEkY908OEKxibG9wgn22GbG7W8zmEiaia5rvuQggGlnWOGs5aFc34E8UG6dx01Iicg9ZDlvsyyE2V/132', '1506754302', '2017-09-30 14:51:42', '', '0', '', '', 'ADD_SCENE_QR_CODE', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2299', 'wx60a43dd8161666d4', 'oGsrks1Vd2boIxw3KjWdfrgD2XjY', 'o38gps1Unf64JOTdxNdd424lsEmM', '', null, '2,195', '0', '1', 'SuperX', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/tqRiaNianNl1m81icHORPw7chvQ4c1V0mJibS5Iia6elg2nJFpfmDvtibbEFvC9wIQaI4kibEybHnl2gwChAqQUBHlnh4eDKkOv7QPm/132', '1520409810', '2018-03-07 16:03:30', '', '0', '', '', 'ADD_SCENE_QR_CODE', '0', '测试', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2300', 'wx60a43dd8161666d4', 'oGsrkszrkFk55kOq6LCuEA-IttMQ', 'o38gpsxVkzZd6UY_3c6qAN-LiUw8', '', null, '195,2', '0', '1', '姜敏', '1', '中国', '上海', '浦东新区', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFmr7dAfxG0unXubkwiblxic68V1gx9oz6nJww5MtFOGnmlEu6fxDRUicLOlZBf16XOPiaaSWJSaXjlibshibQib0pic2ic07/132', '1520561646', '2018-03-09 10:14:06', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2301', 'wx60a43dd8161666d4', 'oGsrks5mX7Kr6b1guI9ecDgrXJVE', 'o38gps1tvPvDBPeMXFTZkFvBMxjU', '', null, '', '0', '1', '刘彪', '1', '中国', '广东', '深圳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFme3s8TLGP6cciaxANiaJdtJVZiaibE3x4QDqpFTsM0Hm4ibHR3bX0klc8QWNdbq2nLoRgdXo2sMGVxCnbfnb28TOMHB/132', '1515404964', '2018-01-08 17:49:24', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2302', 'wx60a43dd8161666d4', 'oGsrks6bAMKwkxgHnQtwZzrw7HH0', 'o38gps-kWCJNweHtom-Ur6-_7ipU', '', null, '', '0', '1', '郭树峰', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhmWzkEyg0xZlcRFJ9uzsHwpkn6mKuBCtRs8pO2wACy20joQ9fSwolf3Ny0achnCyUbKGn5ibpgJNDMkADy12ianZ/132', '1515727836', '2018-01-12 11:30:36', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2303', 'wx60a43dd8161666d4', 'oGsrks-n2GxjfG75V5EjcwK3k7Ks', 'o38gpsx-lvKmbJE0YkySrWWgYCuA', '', null, '', '0', '1', 'Mr.L', '1', '中国', '重庆', '两江新区', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlEOfjomrweTyEuy1DEoMscI3m4srjIZBxYNia59E6rLAaTbibxc1E2RrWraqoDz1eImc3fXEnwMD8a/132', '1510220091', '2017-11-09 17:34:51', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2304', 'wx60a43dd8161666d4', 'oGsrks93peyNDIECPpLAppB-kFvU', 'o38gps-4z7nkOJ9VljnrjZ1hJs9Q', '', null, '', '0', '1', '刘鹏飞', '1', '中国', '河南', '郑州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKoicF6Kjzex0vJFrqTpJK7MOEVJgLwLz3f08sMEQLxMcwCKsJibmR4KCd9NPvTycT7w6TZ0ib1aehnt8PO2kkIWRDx/132', '1498788522', '2017-06-30 10:08:42', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2305', 'wx60a43dd8161666d4', 'oGsrks89DGZXf8VfajzOVlbAQ3z8', 'o38gps8K3eiJ3cNAU0TKkAs2a9CU', '', null, '2', '0', '1', 'Johnny Y.', '1', '中国', '湖南', '长沙', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnia6pYhZ3PxuJ0XM46qfibjVS4Y4R4qMm5N4fosz9JWP8NibNO4tjI0eWDpojgkw73WKFovI5O0wW14LnEgcT1oQ2ib/132', '1460548852', '2016-04-13 20:00:52', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2306', 'wx60a43dd8161666d4', 'oGsrks3ubNH4NlW9vTethfs9Yfk8', 'o38gps4yFLVFKQ5TRwRJF-gxhoFE', '', null, '', '0', '1', 'Colin', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKqWzwNeqjpichLW6UrpKOcr0ct9y2nEAxfnhTWQMj6luiaMO8KYL4de5pAMoJyiaGrLaYiaH9liaIzvRhlXADgPqicyzu/132', '1513856956', '2017-12-21 19:49:16', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2307', 'wx60a43dd8161666d4', 'oGsrks7YjGV_35_A98qIyanIXx4s', 'o38gpswjzR0S7wMTdDI-lF6kvYaU', '', null, '', '0', '1', '卡卡', '1', '中国', '江苏', '苏州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlFh2E95z0gvulwLNVERZelr67hKMYGxCwbCMsaBapwt2Ef3a0ibLAicVtAzhVgOIvL3UGQTQOWwnq8/132', '1512692256', '2017-12-08 08:17:36', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2308', 'wx60a43dd8161666d4', 'oGsrksxkol9l-RayJxFnhi8ARb6E', 'o38gps0aBICw5jkQ9fYU77T2e-ig', '', null, '', '0', '1', '小时候', '1', '中国', '湖南', '长沙', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFnLhucNNeBTibnMkOfiaSPNXDl1c0ia74NCqHuk3GJO23PFy1wzFibIJCBLl1ibAxyWguBSPPAocQicelEBy8icoN163ZZ/132', '1513565731', '2017-12-18 10:55:31', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2309', 'wx60a43dd8161666d4', 'oGsrkswYnd9qL8EdvS-ABl55wb-I', 'o38gps6_chW-YV83sCx9fm_LOids', '', null, '2', '0', '1', '盼盼\\ud83d\\udd30雅滋美特®总部', '2', '中国', '陕西', '西安', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKpbjOibFLiaRzBwY2ia7XH9Ive6oCQiazl8hRBQr8WORSph7a5swBFoCy9ZewOMqExx7wGQzt4z5Tehoa7qulnEXdO4/132', '1462429726', '2016-05-05 14:28:46', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2310', 'wx60a43dd8161666d4', 'oGsrksylW6rvVpCOTMgBwVeA7mXM', 'o38gps_lFGor-5-sQAxuYCOq4H98', '', null, '', '0', '0', '阿莫', '1', '中国', '广东', '东莞', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKoPVFiceZY7rlfDWxiawIiboh9NjbRlWCugJzgkUtgEqZiaemqhmicWPWu6aBxqBDq4WhSMS67eWxLOFyOQIxT3ME6tO/132', '1508999198', '2017-10-26 14:26:38', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2311', 'wx60a43dd8161666d4', 'oGsrks-DFJgLi94eTz9bR9b6hukU', 'o38gpsw8os7p6RnIW9zDF5INjd58', '', null, '2', '0', '1', '瑋瑋', '2', '中国', '湖南', '衡阳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSngWiakNf5LZdzibaJ2Bzhc39n1crMbeqG55dylBrCwxX5ubpqIxaepRGiayic3xBC8tcTiaVP0I7pdxb3AZQKRtXwf7E/132', '1472105946', '2016-08-25 14:19:06', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2312', 'wx60a43dd8161666d4', 'oGsrksxHmXVcZMJeySQ37uDytOmg', 'o38gpsxjv6TDDkmlPpOCybQ9tjJ0', '', null, '2', '0', '1', '　　　　　　　　', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKqHxl82Xol99xTovqtPdth2ulKkXk8Ckibwop7NqC4SASx0iaFNB0FxtgF9ubk9xPWSDW1OLd7RNZibfp0XMJpIecia/132', '1491880522', '2017-04-11 11:15:22', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2313', 'wx60a43dd8161666d4', 'oGsrks8AQ_mp1XePvYuUDAJ7oBJg', 'o38gpswwa0WyHEKVXaHtF0kcjoJk', '', null, '2', '0', '1', '堂堂', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKp5nibynO469KphibAhuVZ1ZWA5hR79YlLUT9l8ic4ckibpgkPlC0zm1Rwem9kLsN3kPBAhibfIWo7gBmPSvSsLjQKuE/132', '1467771020', '2016-07-06 10:10:20', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2314', 'wx60a43dd8161666d4', 'oGsrkszEXoNDqIw5Og2WBNAiP2D0', 'o38gps4gSFILIoalRs0PP8FfSir8', '', null, '', '0', '1', '老何', '1', '中国', '福建', '福州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/wLcWG0U6YFmr7dAfxG0unZegKCys0B6beoZrQBibU8vppYRwDfx10zxiaA7W7BSuFl0GN0lOjfpleP9h2MPpl2zOib7ZycbMCGh/132', '1502371948', '2017-08-10 21:32:28', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2315', 'wx60a43dd8161666d4', 'oGsrks71BIPANqZDyv4B64e4Eozg', 'o38gps7sSKAiIosZcPtvDCIp5iqg', '', null, '', '0', '1', '风⃢染⃢季⃢末', '1', '北马里亚纳群岛', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnhlmkw5WDLWlMqlYggVlxQQjEz0gI06NiaiciaLd1jFpjMmj6lc4SlQicuPtSAdmfXAoEhQeCIqY9cU7Agp8gYUYLAT/132', '1508379559', '2017-10-19 10:19:19', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2316', 'wx60a43dd8161666d4', 'oGsrks22hZFbB-J-Y98nM-h_9uMM', 'o38gps2Fh1GdM5rQkC3_Bckn3iEY', '', null, '', '0', '1', '永圣', '1', '中国', '陕西', '西安', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/PiajxSqBRaEI86EI2Ha7IFPfp74kFRMzpgYKMwSialEYlhQrD2xKePzDU27MCmZhYayYAJ1gmsrsuBzVkfgeXl3F0k2dMElMEcNaKtRHZduxc/132', '1462429914', '2016-05-05 14:31:54', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2317', 'wx60a43dd8161666d4', 'oGsrks6Y0TUcHa-IhfxS0Me6gl4c', 'o38gps08RgM4pxI5aKCMvAC6iQNw', '', null, '', '0', '1', '麻水劲松_楚鸟', '1', '中国', '湖北', '荆州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/KULsUKmynFu6SiahhNaO6MwjVAA8Bb0TUf0aaElVVYCibMLqI5BNclYGhGM9Lgict7uI2UOxnfuricfcdUIa1SWb0tfBW1uqYewF/132', '1495687411', '2017-05-25 12:43:31', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2318', 'wx60a43dd8161666d4', 'oGsrks4by1arcjSIeWdtWVKx_Vjc', 'o38gps8JDZdTpmnyBzrXqfabhdTw', '', null, '', '0', '0', 'i', '1', '中国', '广东', '深圳', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM7rYo6NN0asQjBKCjlPibyyxEMD3benk5akljSsj7SljY8OsKVbdGQrejeOFGOMdhgNotpnX9yPCKIjnDO51RmeIWpjgFLUrlvY/132', '1510584392', '2017-11-13 22:46:32', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2319', 'wx60a43dd8161666d4', 'oGsrks9nEbjHQbOOgKFjvgpw4qj4', 'o38gps4Awds1FrY2N9HAidN0FF8Q', '', null, '', '0', '1', '网络共享吧', '0', '', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSnjjBLgK5sTicJaDCncHEGHdj3fPwCIicWXGcljtxrdvh5ugHped5smMamcCIAM133yic1ZsymQgrSWzx2ptyahBy5R/132', '1509361509', '2017-10-30 19:05:09', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2320', 'wx60a43dd8161666d4', 'oGsrksxKTwgEWj0ApQlblA_V9NEo', 'o38gps9mF9Em-CTs7aV9B88DuTpw', '', null, '', '0', '1', 'yyhhyj', '0', '', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaZgJibibxOwB5fygtmZ1JTrNYwqxKRPBPJYhSmibVzibKeuhQxbT8r9QLk4y9ro0ictValBGaibxIOiaQHW1RbgjFViahM/132', '1503323592', '2017-08-21 21:53:12', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2321', 'wx60a43dd8161666d4', 'oGsrks0mBGjUxYLw1GGbQgNdaN4s', 'o38gpszoJoC9oJYz3UHHf6bEp0Lo', '', null, '', '0', '1', '伟红', '0', '', '', '', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/lQEcz8ricSniaaiciciagbYiahct41to1c8qKJJq00odyYm1kskyE6og7ic0VSnuWankib2DOUZuHvkicGc9XZUN8c55uRb5PMMQmhlrT/132', '1514285567', '2017-12-26 18:52:47', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2322', 'wx60a43dd8161666d4', 'oGsrksxawVziyr-ePlU6nOxALYgA', 'o38gps47H7kIFrv0pQ15ODVQR1mA', '', null, '2', '0', '1', '才子佳人', '1', '中国', '广东', '广州', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKqWzwNeqjpichC3NRcX3D5LVKUapG9XE3xzbt2jdh0qlRYiabia541bkdsY81ICFWrcKhicbAOic4iatlKts4nSVosACa/132', '1461809072', '2016-04-28 10:04:32', '', '0', '', '', 'ADD_SCENE_OTHERS', '0', '', '2018-03-10 17:42:18');
INSERT INTO `wechat_fans` VALUES ('2323', 'wx60a43dd8161666d4', 'oGsrks3twpOdvQ0N61bJ53UYU0nI', 'o38gps_jAAYPzd6xmE_eNFiecVQA', '', null, '', '0', '0', '上帝抬了我一手。', '1', '中国', '湖北', '宜昌', 'zh_CN', 'http://thirdwx.qlogo.cn/mmopen/cXaM0LzKLKruLDwc9TvAZ4gZmrzr9FLUhOYKtpkbj3xvyt6IXeT38WG2X7dCvABefB3JOkl6svZjjvxoaH2Z6eb0wW1ZLGur/132', '1520905980', '2018-03-13 09:53:00', '', '0', '', '', 'ADD_SCENE_SEARCH', '0', '', '2018-03-13 09:53:02');

-- ----------------------------
-- Table structure for wechat_fans_tags
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans_tags`;
CREATE TABLE `wechat_fans_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `name` varchar(35) DEFAULT NULL COMMENT '标签名称',
  `count` int(11) unsigned DEFAULT NULL COMMENT '总数',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  KEY `index_wechat_fans_tags_id` (`id`) USING BTREE,
  KEY `index_wechat_fans_tags_appid` (`appid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8 COMMENT='微信会员标签';

-- ----------------------------
-- Records of wechat_fans_tags
-- ----------------------------
INSERT INTO `wechat_fans_tags` VALUES ('2', 'wx60a43dd8161666d4', '星标组', '20', '2018-03-12 09:55:32');
INSERT INTO `wechat_fans_tags` VALUES ('195', 'wx60a43dd8161666d4', '新增标签', '0', '2018-03-12 09:55:32');

-- ----------------------------
-- Table structure for wechat_keys
-- ----------------------------
DROP TABLE IF EXISTS `wechat_keys`;
CREATE TABLE `wechat_keys` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` char(100) DEFAULT '' COMMENT '公众号APPID',
  `type` varchar(20) DEFAULT '' COMMENT '类型，text 文件消息，image 图片消息，news 图文消息',
  `keys` varchar(100) DEFAULT NULL COMMENT '关键字',
  `content` text COMMENT '文本内容',
  `image_url` varchar(255) DEFAULT '' COMMENT '图片链接',
  `voice_url` varchar(255) DEFAULT '' COMMENT '语音链接',
  `music_title` varchar(100) DEFAULT '' COMMENT '音乐标题',
  `music_url` varchar(255) DEFAULT '' COMMENT '音乐链接',
  `music_image` varchar(255) DEFAULT '' COMMENT '音乐缩略图链接',
  `music_desc` varchar(255) DEFAULT '' COMMENT '音乐描述',
  `video_title` varchar(100) DEFAULT '' COMMENT '视频标题',
  `video_url` varchar(255) DEFAULT '' COMMENT '视频URL',
  `video_desc` varchar(255) DEFAULT '' COMMENT '视频描述',
  `news_id` bigint(20) unsigned DEFAULT NULL COMMENT '图文ID',
  `sort` bigint(20) unsigned DEFAULT '0' COMMENT '排序字段',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '0 禁用，1 启用',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_keys_appid` (`appid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='微信关键字';

-- ----------------------------
-- Records of wechat_keys
-- ----------------------------
INSERT INTO `wechat_keys` VALUES ('1', '', 'news', '测试', '说点什么吧', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '3', '0', '1', null, '2018-03-12 10:52:03');
INSERT INTO `wechat_keys` VALUES ('2', '', 'news', 'default', '说点什么吧', 'http://plugs.ctolog.com/theme/default/img/image.png', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '1', '0', '1', null, '2018-03-07 15:16:20');
INSERT INTO `wechat_keys` VALUES ('3', '', 'news', 'default', '说点什么吧', 'http://plugs.ctolog.com/theme/default/img/image.png', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '1', '0', '1', null, '2018-03-06 22:16:23');
INSERT INTO `wechat_keys` VALUES ('4', '', 'text', 'default', '说点什么吧', 'http://plugs.ctolog.com/theme/default/img/image.png', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '0', '0', '1', null, '2018-03-06 22:22:31');
INSERT INTO `wechat_keys` VALUES ('5', '', 'text', 'default', '说点什么吧', 'http://plugs.ctolog.com/theme/default/img/image.png', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '0', '0', '1', null, '2018-03-06 22:22:52');
INSERT INTO `wechat_keys` VALUES ('6', '', 'text', 'default', '说点什么吧', 'http://plugs.ctolog.com/theme/default/img/image.png', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '0', '0', '1', null, '2018-03-06 22:23:39');
INSERT INTO `wechat_keys` VALUES ('7', '', 'news', 'subscribe', '说点什么吧', 'http://thinkagent.data.cuci.cc/static/upload/1325ee90939a1545/05e10b79fd70fa3a.jpg', '', '音乐标题', '', 'http://plugs.ctolog.com/theme/default/img/image.png', '音乐描述', '视频标题', '', '视频描述', '4', '0', '1', null, '2018-03-12 14:17:05');

-- ----------------------------
-- Table structure for wechat_menu
-- ----------------------------
DROP TABLE IF EXISTS `wechat_menu`;
CREATE TABLE `wechat_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `index` bigint(20) DEFAULT NULL,
  `pindex` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `type` varchar(24) NOT NULL DEFAULT '' COMMENT '菜单类型 null主菜单 link链接 keys关键字',
  `name` varchar(256) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `content` text NOT NULL COMMENT '文字内容',
  `sort` bigint(20) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(0禁用1启用)',
  `create_by` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_menu_pindex` (`pindex`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COMMENT='微信菜单配置';

-- ----------------------------
-- Records of wechat_menu
-- ----------------------------
INSERT INTO `wechat_menu` VALUES ('134', '1', '0', 'miniprogram', '一级菜单', ',,', '0', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('135', '11', '1', 'text', '二级菜单', '13412,41234,413241', '0', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('136', '12', '1', 'text', '二级菜单', '请输入内容1', '1', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('137', '13', '1', 'text', '二级菜单', '请输入内容2', '2', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('138', '14', '1', 'text', '二级菜单', '请输入内容3', '3', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('139', '15', '1', 'text', '二级菜单', '请输入内容4', '4', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('140', '2', '0', 'text', '一级菜单', '', '1', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('141', '21', '2', 'text', '二级菜单', '请输入内容5', '0', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('142', '22', '2', 'text', '二级菜单', '请输入内容6', '1', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('143', '23', '2', 'text', '二级菜单', '请输入内容7', '2', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('144', '24', '2', 'text', '二级菜单', '请输入内容8', '3', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('145', '25', '2', 'text', '二级菜单', '请输入内容9', '4', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('146', '3', '0', 'text', '一级菜单', '', '2', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('147', '31', '3', 'text', '二级菜单', '请输入内容11', '0', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('148', '32', '3', 'text', '二级菜单', '请输入内容22', '1', '1', '0', '2018-03-09 15:46:41');
INSERT INTO `wechat_menu` VALUES ('149', '33', '3', 'text', '二级菜单', '请输入内容33', '2', '1', '0', '2018-03-09 15:46:41');

-- ----------------------------
-- Table structure for wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news`;
CREATE TABLE `wechat_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT '' COMMENT '永久素材显示URL',
  `article_id` varchar(60) DEFAULT '' COMMENT '关联图文ID，用，号做分割',
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`),
  KEY `index_wechat_news_artcle_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='微信图文表';

-- ----------------------------
-- Records of wechat_news
-- ----------------------------
INSERT INTO `wechat_news` VALUES ('1', 'Bw3hChJY74VW97EwV7b79bU_PgbaoLQzuoxw0LRfTk0', '', '2,11', '0', '2018-03-06 22:07:37', '10000');
INSERT INTO `wechat_news` VALUES ('2', '', '', '3', '0', '2018-03-12 10:24:35', '10000');
INSERT INTO `wechat_news` VALUES ('3', '', '', '4,5,10', '0', '2018-03-12 10:24:55', '10000');
INSERT INTO `wechat_news` VALUES ('4', 'Bw3hChJY74VW97EwV7b79ZM2QqCSN9e5d0-uucJ9Dno', '', '6,7,8,9', '0', '2018-03-12 10:25:42', '10000');

-- ----------------------------
-- Table structure for wechat_news_article
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_article`;
CREATE TABLE `wechat_news_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '' COMMENT '素材标题',
  `local_url` varchar(300) DEFAULT '' COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) unsigned DEFAULT '0' COMMENT '是否显示封面 0不显示，1 显示',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `digest` varchar(300) DEFAULT '' COMMENT '摘要内容',
  `content` longtext COMMENT '图文内容',
  `content_source_url` varchar(200) DEFAULT '' COMMENT '图文消息原文地址',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='微信素材表';

-- ----------------------------
-- Records of wechat_news_article
-- ----------------------------
INSERT INTO `wechat_news_article` VALUES ('2', '测试商户', 'http://api.cuci.cc/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png', '0', '3412', '文章内容不能留空，请输入内容！', '&lt;p&gt;421341234&lt;/p&gt;', '', '2018-03-12 10:26:17', '10000');
INSERT INTO `wechat_news_article` VALUES ('3', '测试图文', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '0', 'test', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:24:36', '10000');
INSERT INTO `wechat_news_article` VALUES ('4', '测试商户', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:25:58', '10000');
INSERT INTO `wechat_news_article` VALUES ('5', '数码管理', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&amp;lt;p&amp;gt;文章内容不能留空，请输入内容！&amp;lt;/p&amp;gt;', '', '2018-03-12 10:25:58', '10000');
INSERT INTO `wechat_news_article` VALUES ('6', '测试商户', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:54:39', '10000');
INSERT INTO `wechat_news_article` VALUES ('7', '测试商户', 'http://thinkagent.data.cuci.cc/static/upload/1325ee90939a1545/05e10b79fd70fa3a.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:54:39', '10000');
INSERT INTO `wechat_news_article` VALUES ('8', '测试商户2', 'http://api.cuci.cc/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:54:39', '10000');
INSERT INTO `wechat_news_article` VALUES ('9', '数码管理', 'http://thinkagent.data.cuci.cc/static/upload/1325ee90939a1545/05e10b79fd70fa3a.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:54:39', '10000');
INSERT INTO `wechat_news_article` VALUES ('10', '测试商户2', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:25:58', '10000');
INSERT INTO `wechat_news_article` VALUES ('11', '商户管理', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', '0', '系统', '文章内容不能留空，请输入内容！', '&lt;p&gt;文章内容不能留空，请输入内容！&lt;/p&gt;', '', '2018-03-12 10:26:17', '10000');

-- ----------------------------
-- Table structure for wechat_news_image
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_image`;
CREATE TABLE `wechat_news_image` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `md5` varchar(32) DEFAULT '' COMMENT '文件md5',
  `local_url` varchar(300) DEFAULT '' COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT '' COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_news_image_md5` (`md5`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='微信服务器图片';

-- ----------------------------
-- Records of wechat_news_image
-- ----------------------------
INSERT INTO `wechat_news_image` VALUES ('2', '27a5a7e3d00175ebda58a90276cba129', 'http://api.cuci.cc/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png', 'http://mmbiz.qpic.cn/mmbiz_png/nMCGwywCQYKJ9J6w993p5zaZUOwkXQaZBgicxicRu0zRfyDJicGQg2eMmiabM59NH8bYvjl8QdAoSV0YialSfdatfVQ/0', '2018-03-06 13:35:55');

-- ----------------------------
-- Table structure for wechat_news_media
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_media`;
CREATE TABLE `wechat_news_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) DEFAULT '' COMMENT '公众号ID',
  `md5` varchar(32) DEFAULT '' COMMENT '文件md5',
  `type` varchar(20) DEFAULT '' COMMENT '媒体类型',
  `media_id` varchar(100) DEFAULT '' COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT '' COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT '' COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='微信素材表';

-- ----------------------------
-- Records of wechat_news_media
-- ----------------------------
INSERT INTO `wechat_news_media` VALUES ('1', 'wx60a43dd8161666d4', '27a5a7e3d00175ebda58a90276cba129', 'image', 'Bw3hChJY74VW97EwV7b79dmVQNeSJ6cdRZwS7yiTM28', 'http://api.cuci.cc/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png', 'http://mmbiz.qpic.cn/mmbiz_png/nMCGwywCQYKJ9J6w993p5zaZUOwkXQaZBgicxicRu0zRfyDJicGQg2eMmiabM59NH8bYvjl8QdAoSV0YialSfdatfVQ/0?wx_fmt=png', '2018-03-06 13:52:52');
INSERT INTO `wechat_news_media` VALUES ('28', 'wx60a43dd8161666d4', 'c9f9f81deb548d98d74096ed8a7aa758', 'image', 'Bw3hChJY74VW97EwV7b79ZwhaEkwVSoga0nSVUMFwYs', 'http://thinkagent.data.cuci.cc/static/upload/1325ee90939a1545/05e10b79fd70fa3a.jpg', 'http://mmbiz.qpic.cn/mmbiz_jpg/nMCGwywCQYKeUibetjDUAsfnuwoamicmavX8Y52qvIK2l6YUykc8QzUufYkDAK60Y47zgtTnVttgMs42TBM6UWjA/0?wx_fmt=jpeg', '2018-03-10 11:13:48');
INSERT INTO `wechat_news_media` VALUES ('29', 'wx60a43dd8161666d4', 'cc6967059b91b21a8c4164652cfa739d', 'image', 'Bw3hChJY74VW97EwV7b79YJXRuN8mmUIhRwfLmr0SN0', 'http://thinkagent.data.cuci.cc/static/upload/aca8c68f0d1c0d24/0e2af8e0ac440157.jpg', 'http://mmbiz.qpic.cn/mmbiz_jpg/nMCGwywCQYKeUibetjDUAsfnuwoamicmav2cCibv6JyY315bSeXDAxLSMWfAJGCmFk1032lhAo8Y2KIr75odJTWibA/0?wx_fmt=jpeg', '2018-03-10 20:34:56');
