/*
Navicat MySQL Data Transfer

Source Server         : ctolog.com
Source Server Version : 50629
Source Host           : ctolog.com:3306
Source Database       : think.admin

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2017-03-24 17:58:33
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
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COMMENT='系统权限表';

-- ----------------------------
-- Records of system_auth
-- ----------------------------

-- ----------------------------
-- Table structure for system_auth_node
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node` (
  `auth` bigint(20) unsigned DEFAULT NULL COMMENT '角色ID',
  `node` varchar(200) DEFAULT NULL COMMENT '节点路径',
  KEY `index_system_auth_auth` (`auth`) USING BTREE,
  KEY `index_system_auth_node` (`node`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色与节点关系表';

-- ----------------------------
-- Records of system_auth_node
-- ----------------------------
INSERT INTO `system_auth_node` VALUES ('67', 'admin');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/index');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/index/index');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/index/main');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/index/pass');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/index/info');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/login');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/login/index');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/login/out');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/plugs');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/plugs/upfile');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/plugs/upstate');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/plugs/upload');
INSERT INTO `system_auth_node` VALUES ('67', 'admin/plugs/icon');
INSERT INTO `system_auth_node` VALUES ('71', 'admin');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('71', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('75', 'admin');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('75', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('74', 'admin');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('74', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('79', 'admin');
INSERT INTO `system_auth_node` VALUES ('79', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('79', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('81', 'admin');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('81', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('78', 'admin');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('78', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('83', 'admin');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('83', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('87', 'admin');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('87', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('84', 'admin');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('84', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('90', 'admin');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('90', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('86', 'admin');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('86', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('92', 'admin');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('92', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('93', 'admin');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('93', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('95', 'admin');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('95', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('97', 'admin');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('97', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('104', 'admin');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('104', 'admin/user/resume');
INSERT INTO `system_auth_node` VALUES ('98', 'admin');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/index');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/apply');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/add');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/edit');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/forbid');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/resume');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/auth/del');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/config');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/config/index');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/config/file');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/config/mail');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/config/sms');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu/index');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu/add');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu/edit');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu/del');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu/forbid');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/menu/resume');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/node');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/node/index');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/node/save');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/index');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/auth');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/add');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/edit');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/pass');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/del');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/forbid');
INSERT INTO `system_auth_node` VALUES ('98', 'admin/user/resume');

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` varchar(500) DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('139', 'sms_smtp_username', '23391719');
INSERT INTO `system_config` VALUES ('140', 'sms_smtp_password', '2d696a53cd0dab1b1145d539477b050a');
INSERT INTO `system_config` VALUES ('141', 'sms_product', 'SMS_10795763');
INSERT INTO `system_config` VALUES ('142', 'sms_tpl_register', '');
INSERT INTO `system_config` VALUES ('144', 'site_tongji_baidu', 'f9a6d4c4393e28fa0b3f8a7d89c1c6da');
INSERT INTO `system_config` VALUES ('145', 'site_tongji_cnzz', 'gsdagdsa');
INSERT INTO `system_config` VALUES ('148', 'file_storage', 'qiniu');
INSERT INTO `system_config` VALUES ('149', 'site_copy', '广州楚才信息科技有限公司 © 2017');
INSERT INTO `system_config` VALUES ('150', 'site_beian', '11114');
INSERT INTO `system_config` VALUES ('151', 'site_keys', '2werewrewr');
INSERT INTO `system_config` VALUES ('158', 'mail_from_name', '测试1');
INSERT INTO `system_config` VALUES ('159', 'mail_reply', 'sdsss');
INSERT INTO `system_config` VALUES ('160', 'mail_smtp_host', 'smtp.qq.com');
INSERT INTO `system_config` VALUES ('161', 'mail_smtp_port', '3430000');
INSERT INTO `system_config` VALUES ('162', 'mail_smtp_username', 'admin');
INSERT INTO `system_config` VALUES ('163', 'mail_smtp_password', 'admin');
INSERT INTO `system_config` VALUES ('164', 'storage_type', 'qiniu');
INSERT INTO `system_config` VALUES ('165', 'storage_qiniu_is_https', '0');
INSERT INTO `system_config` VALUES ('166', 'storage_qiniu_bucket', 'static');
INSERT INTO `system_config` VALUES ('167', 'storage_qiniu_domain', 'static.cdn.cuci.com');
INSERT INTO `system_config` VALUES ('168', 'storage_qiniu_access_key', 'admin');
INSERT INTO `system_config` VALUES ('169', 'storage_qiniu_secret_key', 'admin');
INSERT INTO `system_config` VALUES ('170', 'site_name', '测试1');
INSERT INTO `system_config` VALUES ('171', 'site_domain', 'thi11111wewewedd');
INSERT INTO `system_config` VALUES ('172', 'site_desc', 'sad');
INSERT INTO `system_config` VALUES ('173', 'app_name', 'Think.Admi1');
INSERT INTO `system_config` VALUES ('174', 'app_version', '1.00 dev');
INSERT INTO `system_config` VALUES ('175', 'site_logo', 'https://think.ctolog.com/upload/f47b8fe06e38ae99/08e8398da45583b9.png');
INSERT INTO `system_config` VALUES ('176', 'app_logo', 'http://5000.gr83c9c9.zoujingli.ali-sh.goodrain.net:10080/upload/f47b8fe06e38ae99/08e8398da45583b9.png');
INSERT INTO `system_config` VALUES ('177', 'sms_type', 'zt');
INSERT INTO `system_config` VALUES ('178', 'sms_zt_username', 'admin');
INSERT INTO `system_config` VALUES ('179', 'sms_zt_password', 'admin');
INSERT INTO `system_config` VALUES ('180', 'sms_ali_key', '123');
INSERT INTO `system_config` VALUES ('181', 'sms_ali_secret', '123');
INSERT INTO `system_config` VALUES ('182', 'username', 'admin');
INSERT INTO `system_config` VALUES ('183', 'password', 'Test12345');

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
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8 COMMENT='系统文件';

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
INSERT INTO `system_file` VALUES ('47', 'qiniu', '2eeadbbeec852d1c7112df7d14ec9c5a', '25fb8ce54bf912e6930eec178b945704.jpg', '7112df7d14ec9c5a.jpg', '2eeadbbeec852d1c/7112df7d14ec9c5a.jpg', '2eeadbbeec852d1c/7112df7d14ec9c5a.jpg', 'jpg', null, '2eeadbbeec852d1c/7112df7d14ec9c5a.jpg', 'https://static.ctolog.com/2eeadbbeec852d1c/7112df7d14ec9c5a.jpg', '10000', '2017-02-24 16:40:32');
INSERT INTO `system_file` VALUES ('48', 'qiniu', 'fd1c9480827347b886bbf5655d6a073f', 'isLockBg.png', '86bbf5655d6a073f.png', 'fd1c9480827347b8/86bbf5655d6a073f.png', 'fd1c9480827347b8/86bbf5655d6a073f.png', 'png', null, 'fd1c9480827347b8/86bbf5655d6a073f.png', 'https://static.ctolog.com/fd1c9480827347b8/86bbf5655d6a073f.png', '10000', '2017-02-24 21:59:23');
INSERT INTO `system_file` VALUES ('49', 'qiniu', '57b68be8b814ae7e816f51fb56d821d6', '12.jpg', '816f51fb56d821d6.jpg', '57b68be8b814ae7e/816f51fb56d821d6.jpg', '57b68be8b814ae7e/816f51fb56d821d6.jpg', 'jpg', null, '57b68be8b814ae7e/816f51fb56d821d6.jpg', 'https://static.ctolog.com/57b68be8b814ae7e/816f51fb56d821d6.jpg', '10000', '2017-02-24 22:06:48');
INSERT INTO `system_file` VALUES ('50', 'qiniu', 'c5f42306de881a3790eacb3ef1fd7d45', '201702241613149402.jpg', '90eacb3ef1fd7d45.jpg', 'c5f42306de881a37/90eacb3ef1fd7d45.jpg', 'c5f42306de881a37/90eacb3ef1fd7d45.jpg', 'jpg', null, 'c5f42306de881a37/90eacb3ef1fd7d45.jpg', 'https://static.ctolog.com/c5f42306de881a37/90eacb3ef1fd7d45.jpg', '10000', '2017-02-24 23:14:11');
INSERT INTO `system_file` VALUES ('51', 'qiniu', '134a1a44ae677c7b75b888cb218356af', '3 2.jpg', '75b888cb218356af.jpg', '134a1a44ae677c7b/75b888cb218356af.jpg', '134a1a44ae677c7b/75b888cb218356af.jpg', 'jpg', null, '134a1a44ae677c7b/75b888cb218356af.jpg', 'https://static.ctolog.com/134a1a44ae677c7b/75b888cb218356af.jpg', '10000', '2017-02-25 08:14:19');
INSERT INTO `system_file` VALUES ('52', 'qiniu', 'f907d23fbd52f97db53ecca7e247af77', '组-3@3x.png', 'b53ecca7e247af77.png', 'f907d23fbd52f97d/b53ecca7e247af77.png', 'f907d23fbd52f97d/b53ecca7e247af77.png', 'png', null, 'f907d23fbd52f97d/b53ecca7e247af77.png', 'https://static.ctolog.com/f907d23fbd52f97d/b53ecca7e247af77.png', '10000', '2017-02-25 08:14:32');
INSERT INTO `system_file` VALUES ('53', 'qiniu', '6607edc88a1553560ecee54869145ac7', 'news-logo.png', '0ecee54869145ac7.png', '6607edc88a155356/0ecee54869145ac7.png', '6607edc88a155356/0ecee54869145ac7.png', 'png', null, '6607edc88a155356/0ecee54869145ac7.png', 'https://static.ctolog.com/6607edc88a155356/0ecee54869145ac7.png', '10000', '2017-02-25 08:29:17');
INSERT INTO `system_file` VALUES ('54', 'qiniu', '8da4e1d73862f317c6f35e0f82ec2da5', '016.jpg', 'c6f35e0f82ec2da5.jpg', '8da4e1d73862f317/c6f35e0f82ec2da5.jpg', '8da4e1d73862f317/c6f35e0f82ec2da5.jpg', 'jpg', null, '8da4e1d73862f317/c6f35e0f82ec2da5.jpg', 'https://static.ctolog.com/8da4e1d73862f317/c6f35e0f82ec2da5.jpg', '10000', '2017-02-25 14:55:42');
INSERT INTO `system_file` VALUES ('55', 'qiniu', '1fcd96343822b4c48311f1f04c96d1dd', '568cf9379a7f0035_jpg!600x600.jpg', '8311f1f04c96d1dd.jpg', '1fcd96343822b4c4/8311f1f04c96d1dd.jpg', '1fcd96343822b4c4/8311f1f04c96d1dd.jpg', 'jpg', null, '1fcd96343822b4c4/8311f1f04c96d1dd.jpg', 'https://static.ctolog.com/1fcd96343822b4c4/8311f1f04c96d1dd.jpg', '10000', '2017-02-25 18:37:26');
INSERT INTO `system_file` VALUES ('56', 'qiniu', '527bd63d7ee4a497657c534045a3385f', 'QQ截图20170117111058.png', '657c534045a3385f.png', '527bd63d7ee4a497/657c534045a3385f.png', '527bd63d7ee4a497/657c534045a3385f.png', 'png', null, '527bd63d7ee4a497/657c534045a3385f.png', 'https://static.ctolog.com/527bd63d7ee4a497/657c534045a3385f.png', '10000', '2017-02-26 00:27:54');
INSERT INTO `system_file` VALUES ('57', 'qiniu', '1b757e1d50d2adf7c267511eb5d139b8', 'card.jpg', 'c267511eb5d139b8.jpg', '1b757e1d50d2adf7/c267511eb5d139b8.jpg', '1b757e1d50d2adf7/c267511eb5d139b8.jpg', 'jpg', null, '1b757e1d50d2adf7/c267511eb5d139b8.jpg', 'https://static.ctolog.com/1b757e1d50d2adf7/c267511eb5d139b8.jpg', '10000', '2017-02-26 11:44:30');
INSERT INTO `system_file` VALUES ('58', 'qiniu', '4f48d81328902d717787acb397d2c379', '栏目管理.png', '7787acb397d2c379.png', '4f48d81328902d71/7787acb397d2c379.png', '4f48d81328902d71/7787acb397d2c379.png', 'png', null, '4f48d81328902d71/7787acb397d2c379.png', 'https://static.ctolog.com/4f48d81328902d71/7787acb397d2c379.png', '10000', '2017-02-26 11:44:54');
INSERT INTO `system_file` VALUES ('59', 'qiniu', '2784b6f98620ab6c5a3d583a8ccd7fa1', 'icon_button3_3.png', '5a3d583a8ccd7fa1.png', '2784b6f98620ab6c/5a3d583a8ccd7fa1.png', '2784b6f98620ab6c/5a3d583a8ccd7fa1.png', 'png', null, '2784b6f98620ab6c/5a3d583a8ccd7fa1.png', 'https://static.ctolog.com/2784b6f98620ab6c/5a3d583a8ccd7fa1.png', '10000', '2017-02-26 14:04:07');
INSERT INTO `system_file` VALUES ('60', 'qiniu', '0119c890cc181c7260532e946cf4294a', '222.png', '60532e946cf4294a.png', '0119c890cc181c72/60532e946cf4294a.png', '0119c890cc181c72/60532e946cf4294a.png', 'png', null, '0119c890cc181c72/60532e946cf4294a.png', 'https://static.ctolog.com/0119c890cc181c72/60532e946cf4294a.png', '10000', '2017-02-26 15:01:15');
INSERT INTO `system_file` VALUES ('61', 'qiniu', '27d4787e4bb8515341ef2d1979306e9c', 'liebao01.png', '41ef2d1979306e9c.png', '27d4787e4bb85153/41ef2d1979306e9c.png', '27d4787e4bb85153/41ef2d1979306e9c.png', 'png', null, '27d4787e4bb85153/41ef2d1979306e9c.png', 'https://static.ctolog.com/27d4787e4bb85153/41ef2d1979306e9c.png', '10000', '2017-02-26 16:38:12');
INSERT INTO `system_file` VALUES ('62', 'qiniu', 'c2a68101e58d5f8ce1ce1bba36c5dd0a', 'shijiezhichuangjisu01.png', 'e1ce1bba36c5dd0a.png', 'c2a68101e58d5f8c/e1ce1bba36c5dd0a.png', 'c2a68101e58d5f8c/e1ce1bba36c5dd0a.png', 'png', null, 'c2a68101e58d5f8c/e1ce1bba36c5dd0a.png', 'https://static.ctolog.com/c2a68101e58d5f8c/e1ce1bba36c5dd0a.png', '10000', '2017-02-26 16:38:17');
INSERT INTO `system_file` VALUES ('63', 'qiniu', 'ac7dcf3c6c6ac5feb6ca4b714d37354d', 'psb (2).jpg', 'b6ca4b714d37354d.jpg', 'ac7dcf3c6c6ac5fe/b6ca4b714d37354d.jpg', 'ac7dcf3c6c6ac5fe/b6ca4b714d37354d.jpg', 'jpg', null, 'ac7dcf3c6c6ac5fe/b6ca4b714d37354d.jpg', 'http://static.ctolog.com/ac7dcf3c6c6ac5fe/b6ca4b714d37354d.jpg', '10000', '2017-02-26 22:18:34');
INSERT INTO `system_file` VALUES ('64', 'qiniu', '4eba04624639b39066fc84faf30b2708', '555.jpg', '66fc84faf30b2708.jpg', '4eba04624639b390/66fc84faf30b2708.jpg', '4eba04624639b390/66fc84faf30b2708.jpg', 'jpg', null, '4eba04624639b390/66fc84faf30b2708.jpg', 'http://static.ctolog.com/4eba04624639b390/66fc84faf30b2708.jpg', '10000', '2017-02-27 11:10:24');
INSERT INTO `system_file` VALUES ('65', 'qiniu', 'fcff0aae6874bec04626ac61edd04762', '544444.jpg', '4626ac61edd04762.jpg', 'fcff0aae6874bec0/4626ac61edd04762.jpg', 'fcff0aae6874bec0/4626ac61edd04762.jpg', 'jpg', null, 'fcff0aae6874bec0/4626ac61edd04762.jpg', 'http://static.ctolog.com/fcff0aae6874bec0/4626ac61edd04762.jpg', '10000', '2017-02-27 11:10:38');
INSERT INTO `system_file` VALUES ('66', 'qiniu', '6daa6ed0a3fa4fdb926b90649ea63bd4', 'l1.png', '926b90649ea63bd4.png', '6daa6ed0a3fa4fdb/926b90649ea63bd4.png', '6daa6ed0a3fa4fdb/926b90649ea63bd4.png', 'png', null, '6daa6ed0a3fa4fdb/926b90649ea63bd4.png', 'http://static.ctolog.com/6daa6ed0a3fa4fdb/926b90649ea63bd4.png', '10000', '2017-02-27 11:10:47');
INSERT INTO `system_file` VALUES ('67', 'qiniu', 'af93c22243dc34b2ccf5101d66170317', '100-100.png', 'ccf5101d66170317.png', 'af93c22243dc34b2/ccf5101d66170317.png', 'af93c22243dc34b2/ccf5101d66170317.png', 'png', null, 'af93c22243dc34b2/ccf5101d66170317.png', 'https://static.ctolog.com/af93c22243dc34b2/ccf5101d66170317.png', '10000', '2017-02-27 12:41:00');
INSERT INTO `system_file` VALUES ('68', 'qiniu', 'ea478fa9ff81dca461f0595dd5dbe14b', '80-80.png', '61f0595dd5dbe14b.png', 'ea478fa9ff81dca4/61f0595dd5dbe14b.png', 'ea478fa9ff81dca4/61f0595dd5dbe14b.png', 'png', null, 'ea478fa9ff81dca4/61f0595dd5dbe14b.png', 'https://static.ctolog.com/ea478fa9ff81dca4/61f0595dd5dbe14b.png', '10000', '2017-02-27 12:41:06');
INSERT INTO `system_file` VALUES ('69', 'qiniu', '9008f473ced9794630498bedc734afe7', 'timg.gif', '30498bedc734afe7.gif', '9008f473ced97946/30498bedc734afe7.gif', '9008f473ced97946/30498bedc734afe7.gif', 'gif', null, '9008f473ced97946/30498bedc734afe7.gif', 'https://static.ctolog.com/9008f473ced97946/30498bedc734afe7.gif', '10000', '2017-02-27 14:18:45');
INSERT INTO `system_file` VALUES ('70', 'qiniu', 'b967d34ca852745071d17aed8f0b0c08', 'logo.jpg', '71d17aed8f0b0c08.jpg', 'b967d34ca8527450/71d17aed8f0b0c08.jpg', 'b967d34ca8527450/71d17aed8f0b0c08.jpg', 'jpg', null, 'b967d34ca8527450/71d17aed8f0b0c08.jpg', 'https://static.ctolog.com/b967d34ca8527450/71d17aed8f0b0c08.jpg', '10000', '2017-02-27 15:48:53');
INSERT INTO `system_file` VALUES ('71', 'local', '456dc9de7ed0a821deb8474b506a312b', '测试平台.jpg', 'deb8474b506a312b.jpg', 'upload/456dc9de7ed0a821/deb8474b506a312b.jpg', '/home/wwwroot/think/trunk/public/upload/456dc9de7ed0a821/deb8474b506a312b.jpg', 'jpg', '29209.00', 'upload/456dc9de7ed0a821/deb8474b506a312b.jpg', 'https://think.ctolog.com/upload/456dc9de7ed0a821/deb8474b506a312b.jpg', '10000', '2017-02-27 16:42:12');
INSERT INTO `system_file` VALUES ('72', 'qiniu', '894e8e22a139e3f9175b6acace62d9c9', 'logo.png', '175b6acace62d9c9.png', '894e8e22a139e3f9/175b6acace62d9c9.png', '894e8e22a139e3f9/175b6acace62d9c9.png', 'png', null, '894e8e22a139e3f9/175b6acace62d9c9.png', 'https://static.ctolog.com/894e8e22a139e3f9/175b6acace62d9c9.png', '10000', '2017-02-27 22:01:52');
INSERT INTO `system_file` VALUES ('73', 'qiniu', 'f46f8e8025b9203e9d6ea16610859ba6', '91af3f416743c3f33d1bf89889282a95.jpg', '9d6ea16610859ba6.jpg', 'f46f8e8025b9203e/9d6ea16610859ba6.jpg', 'f46f8e8025b9203e/9d6ea16610859ba6.jpg', 'jpg', null, 'f46f8e8025b9203e/9d6ea16610859ba6.jpg', 'https://static.ctolog.com/f46f8e8025b9203e/9d6ea16610859ba6.jpg', '10000', '2017-02-28 11:34:48');
INSERT INTO `system_file` VALUES ('74', 'qiniu', '7609a74086bd6b75112b89987f870fe9', 'Tulip.jpg', '112b89987f870fe9.jpg', '7609a74086bd6b75/112b89987f870fe9.jpg', '7609a74086bd6b75/112b89987f870fe9.jpg', 'jpg', null, '7609a74086bd6b75/112b89987f870fe9.jpg', 'http://static.ctolog.com/7609a74086bd6b75/112b89987f870fe9.jpg', '10000', '2017-02-28 14:42:22');
INSERT INTO `system_file` VALUES ('75', 'qiniu', '9886d00b6b692408ad951b1227bf8c90', 'logo.png', 'ad951b1227bf8c90.png', '9886d00b6b692408/ad951b1227bf8c90.png', '9886d00b6b692408/ad951b1227bf8c90.png', 'png', null, '9886d00b6b692408/ad951b1227bf8c90.png', 'http://static.ctolog.com/9886d00b6b692408/ad951b1227bf8c90.png', '10000', '2017-02-28 14:42:31');
INSERT INTO `system_file` VALUES ('76', 'qiniu', 'b9f8c028088d28787ea8f9c3efa5103c', 'QQ截图20170228152145.jpg', '7ea8f9c3efa5103c.jpg', 'b9f8c028088d2878/7ea8f9c3efa5103c.jpg', 'b9f8c028088d2878/7ea8f9c3efa5103c.jpg', 'jpg', null, 'b9f8c028088d2878/7ea8f9c3efa5103c.jpg', 'http://static.ctolog.com/b9f8c028088d2878/7ea8f9c3efa5103c.jpg', '10000', '2017-02-28 17:11:37');
INSERT INTO `system_file` VALUES ('77', 'qiniu', '527bb4a55eff89bdfa61b9015883f241', '3950220_165919649390_2.jpg', 'fa61b9015883f241.jpg', '527bb4a55eff89bd/fa61b9015883f241.jpg', '527bb4a55eff89bd/fa61b9015883f241.jpg', 'jpg', null, '527bb4a55eff89bd/fa61b9015883f241.jpg', 'http://static.ctolog.com/527bb4a55eff89bd/fa61b9015883f241.jpg', '10000', '2017-02-28 17:46:05');
INSERT INTO `system_file` VALUES ('78', 'qiniu', '309093df452a1e6cab14b25d057d2780', '04820d67c5839983de863f1eadd365d873b771cc.jpg', 'ab14b25d057d2780.jpg', '309093df452a1e6c/ab14b25d057d2780.jpg', '309093df452a1e6c/ab14b25d057d2780.jpg', 'jpg', null, '309093df452a1e6c/ab14b25d057d2780.jpg', 'http://static.ctolog.com/309093df452a1e6c/ab14b25d057d2780.jpg', '10000', '2017-02-28 20:54:34');
INSERT INTO `system_file` VALUES ('79', 'qiniu', 'abef72bbe6b01000d325d04ca6e0714f', 'IMG_0870_看图王.jpg', 'd325d04ca6e0714f.jpg', 'abef72bbe6b01000/d325d04ca6e0714f.jpg', 'abef72bbe6b01000/d325d04ca6e0714f.jpg', 'jpg', null, 'abef72bbe6b01000/d325d04ca6e0714f.jpg', 'http://static.ctolog.com/abef72bbe6b01000/d325d04ca6e0714f.jpg', '10000', '2017-02-28 20:59:27');
INSERT INTO `system_file` VALUES ('80', 'local', 'f160f98692210b7c297d07e1af4712f3', '20161127142604666.jpg', '297d07e1af4712f3.jpg', 'upload/f160f98692210b7c/297d07e1af4712f3.jpg', '/home/wwwroot/think/trunk/public/upload/f160f98692210b7c/297d07e1af4712f3.jpg', 'jpg', '39104.00', 'upload/f160f98692210b7c/297d07e1af4712f3.jpg', 'https://think.ctolog.com/upload/f160f98692210b7c/297d07e1af4712f3.jpg', '10000', '2017-03-01 10:50:01');
INSERT INTO `system_file` VALUES ('81', 'local', '4c288616bf23b22de86725c8f63c0e50', 'QQ截图20160608092917.png', 'e86725c8f63c0e50.png', 'upload/4c288616bf23b22d/e86725c8f63c0e50.png', '/home/wwwroot/think/trunk/public/upload/4c288616bf23b22d/e86725c8f63c0e50.png', 'png', '375490.00', 'upload/4c288616bf23b22d/e86725c8f63c0e50.png', 'https://think.ctolog.com/upload/4c288616bf23b22d/e86725c8f63c0e50.png', '10000', '2017-03-01 11:40:56');
INSERT INTO `system_file` VALUES ('82', 'local', '857f31caa49f171b07b44df1b6ca9afc', '0f1f16c4e7df412fa5411505a8f2b0aa - 副本.png', '07b44df1b6ca9afc.png', 'upload/857f31caa49f171b/07b44df1b6ca9afc.png', '/home/wwwroot/think/trunk/public/upload/857f31caa49f171b/07b44df1b6ca9afc.png', 'png', '24748.00', 'upload/857f31caa49f171b/07b44df1b6ca9afc.png', 'https://think.ctolog.com/upload/857f31caa49f171b/07b44df1b6ca9afc.png', '10000', '2017-03-01 14:47:46');
INSERT INTO `system_file` VALUES ('83', 'local', '914219306d9811ea91b23de78eabcddd', '6a75a84235b94027ae805e265b154cf6 - 副本.png', '91b23de78eabcddd.png', 'upload/914219306d9811ea/91b23de78eabcddd.png', '/home/wwwroot/think/trunk/public/upload/914219306d9811ea/91b23de78eabcddd.png', 'png', '18743.00', 'upload/914219306d9811ea/91b23de78eabcddd.png', 'https://think.ctolog.com/upload/914219306d9811ea/91b23de78eabcddd.png', '10000', '2017-03-01 14:49:06');
INSERT INTO `system_file` VALUES ('84', 'local', '8fb3d6d8ae0d0e2b16104fc8c3fe3921', '757ca65b622a4b41a9b3bb2b32938bb2.png', '16104fc8c3fe3921.png', 'upload/8fb3d6d8ae0d0e2b/16104fc8c3fe3921.png', '/home/wwwroot/think/trunk/public/upload/8fb3d6d8ae0d0e2b/16104fc8c3fe3921.png', 'png', '26375.00', 'upload/8fb3d6d8ae0d0e2b/16104fc8c3fe3921.png', 'https://think.ctolog.com/upload/8fb3d6d8ae0d0e2b/16104fc8c3fe3921.png', '10000', '2017-03-01 14:49:14');
INSERT INTO `system_file` VALUES ('85', 'qiniu', '8a613430dc742499396540d18ff2393b', '11287039304867518bl.jpg', '396540d18ff2393b.jpg', '8a613430dc742499/396540d18ff2393b.jpg', '8a613430dc742499/396540d18ff2393b.jpg', 'jpg', null, '8a613430dc742499/396540d18ff2393b.jpg', 'http://static.ctolog.com/8a613430dc742499/396540d18ff2393b.jpg', '10000', '2017-03-01 14:59:28');
INSERT INTO `system_file` VALUES ('86', 'qiniu', '1bfa981c3c33d5bc140d4e411337f673', '4(1).png', '140d4e411337f673.png', '1bfa981c3c33d5bc/140d4e411337f673.png', '1bfa981c3c33d5bc/140d4e411337f673.png', 'png', null, '1bfa981c3c33d5bc/140d4e411337f673.png', 'http://static.ctolog.com/1bfa981c3c33d5bc/140d4e411337f673.png', '10000', '2017-03-01 15:29:11');
INSERT INTO `system_file` VALUES ('87', 'qiniu', 'c9d49fb465d39414a74cd558c2a8cad1', '17-18.jpg', 'a74cd558c2a8cad1.jpg', 'c9d49fb465d39414/a74cd558c2a8cad1.jpg', 'c9d49fb465d39414/a74cd558c2a8cad1.jpg', 'jpg', null, 'c9d49fb465d39414/a74cd558c2a8cad1.jpg', 'https://static.ctolog.com/c9d49fb465d39414/a74cd558c2a8cad1.jpg', '10000', '2017-03-01 16:25:54');
INSERT INTO `system_file` VALUES ('88', 'qiniu', '6b48b02e1f0952ec4508f048a537a15a', 'x4.png', '4508f048a537a15a.png', '6b48b02e1f0952ec/4508f048a537a15a.png', '6b48b02e1f0952ec/4508f048a537a15a.png', 'png', null, '6b48b02e1f0952ec/4508f048a537a15a.png', 'https://static.ctolog.com/6b48b02e1f0952ec/4508f048a537a15a.png', '10000', '2017-03-01 17:40:22');
INSERT INTO `system_file` VALUES ('89', 'qiniu', '4bea5c784e7d73120a33dc875ff81e40', '497a9a2e-a729-4cc8-926f-7e61cffbfbf5.jpg', '0a33dc875ff81e40.jpg', '4bea5c784e7d7312/0a33dc875ff81e40.jpg', '4bea5c784e7d7312/0a33dc875ff81e40.jpg', 'jpg', null, '4bea5c784e7d7312/0a33dc875ff81e40.jpg', 'https://static.ctolog.com/4bea5c784e7d7312/0a33dc875ff81e40.jpg', '10000', '2017-03-01 20:50:04');
INSERT INTO `system_file` VALUES ('90', 'qiniu', '1ca7d52dd54841841a037017ffc93e68', 'addbiaoqing.png', '1a037017ffc93e68.png', '1ca7d52dd5484184/1a037017ffc93e68.png', '1ca7d52dd5484184/1a037017ffc93e68.png', 'png', null, '1ca7d52dd5484184/1a037017ffc93e68.png', 'https://static.ctolog.com/1ca7d52dd5484184/1a037017ffc93e68.png', '10000', '2017-03-01 20:50:19');
INSERT INTO `system_file` VALUES ('91', 'qiniu', '64fa02803ecadc4bc821c5bbe247bfb6', 'timg.jpg', 'c821c5bbe247bfb6.jpg', '64fa02803ecadc4b/c821c5bbe247bfb6.jpg', '64fa02803ecadc4b/c821c5bbe247bfb6.jpg', 'jpg', null, '64fa02803ecadc4b/c821c5bbe247bfb6.jpg', 'https://static.ctolog.com/64fa02803ecadc4b/c821c5bbe247bfb6.jpg', '10000', '2017-03-01 23:18:07');
INSERT INTO `system_file` VALUES ('92', 'qiniu', '9bbd2a7e27fba3dca75c5c58bd9bbe08', 'logo.png', 'a75c5c58bd9bbe08.png', '9bbd2a7e27fba3dc/a75c5c58bd9bbe08.png', '9bbd2a7e27fba3dc/a75c5c58bd9bbe08.png', 'png', null, '9bbd2a7e27fba3dc/a75c5c58bd9bbe08.png', 'https://static.ctolog.com/9bbd2a7e27fba3dc/a75c5c58bd9bbe08.png', '10000', '2017-03-01 23:18:20');
INSERT INTO `system_file` VALUES ('93', 'qiniu', '57f9efc908b6bb078df7542820fb8286', 'QQ截图20170223154424.png', '8df7542820fb8286.png', '57f9efc908b6bb07/8df7542820fb8286.png', '57f9efc908b6bb07/8df7542820fb8286.png', 'png', null, '57f9efc908b6bb07/8df7542820fb8286.png', 'https://static.ctolog.com/57f9efc908b6bb07/8df7542820fb8286.png', '10000', '2017-03-02 09:25:56');
INSERT INTO `system_file` VALUES ('94', 'qiniu', '07141c208a0faa4716ebad9127ccb970', 'u=3704122693,1924714915&fm=23&gp=0.jpg', '16ebad9127ccb970.jpg', '07141c208a0faa47/16ebad9127ccb970.jpg', '07141c208a0faa47/16ebad9127ccb970.jpg', 'jpg', null, '07141c208a0faa47/16ebad9127ccb970.jpg', 'https://static.ctolog.com/07141c208a0faa47/16ebad9127ccb970.jpg', '10000', '2017-03-02 11:19:04');
INSERT INTO `system_file` VALUES ('95', 'qiniu', '54ee9342e243e355f642f60d376469d2', '57806f9ea11a6.jpg', 'f642f60d376469d2.jpg', '54ee9342e243e355/f642f60d376469d2.jpg', '54ee9342e243e355/f642f60d376469d2.jpg', 'jpg', null, '54ee9342e243e355/f642f60d376469d2.jpg', 'https://static.ctolog.com/54ee9342e243e355/f642f60d376469d2.jpg', '10000', '2017-03-02 11:51:40');
INSERT INTO `system_file` VALUES ('96', 'qiniu', '9c65205d32c0ff8198283620e7052ec0', '3.png', '98283620e7052ec0.png', '9c65205d32c0ff81/98283620e7052ec0.png', '9c65205d32c0ff81/98283620e7052ec0.png', 'png', null, '9c65205d32c0ff81/98283620e7052ec0.png', 'https://static.ctolog.com/9c65205d32c0ff81/98283620e7052ec0.png', '10000', '2017-03-02 17:34:18');
INSERT INTO `system_file` VALUES ('97', 'qiniu', '14f5e7123f62f79a67cb437f413a4d91', 'head1.png', '67cb437f413a4d91.png', '14f5e7123f62f79a/67cb437f413a4d91.png', '14f5e7123f62f79a/67cb437f413a4d91.png', 'png', null, '14f5e7123f62f79a/67cb437f413a4d91.png', 'https://static.ctolog.com/14f5e7123f62f79a/67cb437f413a4d91.png', '10000', '2017-03-02 17:34:25');
INSERT INTO `system_file` VALUES ('98', 'qiniu', 'f5ebbcaf872eddfabf75095df5b87ec1', 'goutong.png', 'bf75095df5b87ec1.png', 'f5ebbcaf872eddfa/bf75095df5b87ec1.png', 'f5ebbcaf872eddfa/bf75095df5b87ec1.png', 'png', null, 'f5ebbcaf872eddfa/bf75095df5b87ec1.png', 'https://static.ctolog.com/f5ebbcaf872eddfa/bf75095df5b87ec1.png', '10000', '2017-03-03 00:53:01');
INSERT INTO `system_file` VALUES ('99', 'qiniu', '907643036888645c66f716a7a251be7e', '20.jpg', '66f716a7a251be7e.jpg', '907643036888645c/66f716a7a251be7e.jpg', '907643036888645c/66f716a7a251be7e.jpg', 'jpg', null, '907643036888645c/66f716a7a251be7e.jpg', 'https://static.ctolog.com/907643036888645c/66f716a7a251be7e.jpg', '10000', '2017-03-03 00:53:15');
INSERT INTO `system_file` VALUES ('100', 'qiniu', '7367c0e8fa7cc189a409bc895df60ba6', 'aimage160200051.jpg', 'a409bc895df60ba6.jpg', '7367c0e8fa7cc189/a409bc895df60ba6.jpg', '7367c0e8fa7cc189/a409bc895df60ba6.jpg', 'jpg', null, '7367c0e8fa7cc189/a409bc895df60ba6.jpg', 'https://static.ctolog.com/7367c0e8fa7cc189/a409bc895df60ba6.jpg', '10000', '2017-03-03 00:53:27');
INSERT INTO `system_file` VALUES ('101', 'qiniu', '2810025ddf50b68c4220907231208362', 'big-img.png', '4220907231208362.png', '2810025ddf50b68c/4220907231208362.png', '2810025ddf50b68c/4220907231208362.png', 'png', null, '2810025ddf50b68c/4220907231208362.png', 'https://static.ctolog.com/2810025ddf50b68c/4220907231208362.png', '10000', '2017-03-03 00:53:45');
INSERT INTO `system_file` VALUES ('102', 'qiniu', '2acd7c41ef3d1de4cb436d8ba7d77659', '222.png', 'cb436d8ba7d77659.png', '2acd7c41ef3d1de4/cb436d8ba7d77659.png', '2acd7c41ef3d1de4/cb436d8ba7d77659.png', 'png', null, '2acd7c41ef3d1de4/cb436d8ba7d77659.png', 'https://static.ctolog.com/2acd7c41ef3d1de4/cb436d8ba7d77659.png', '10000', '2017-03-03 09:09:43');
INSERT INTO `system_file` VALUES ('103', 'qiniu', 'b4b78fe4c7a310aa10bacb1cdfd61427', '1.png', '10bacb1cdfd61427.png', 'b4b78fe4c7a310aa/10bacb1cdfd61427.png', 'b4b78fe4c7a310aa/10bacb1cdfd61427.png', 'png', null, 'b4b78fe4c7a310aa/10bacb1cdfd61427.png', 'https://static.ctolog.com/b4b78fe4c7a310aa/10bacb1cdfd61427.png', '10000', '2017-03-03 09:10:02');
INSERT INTO `system_file` VALUES ('104', 'qiniu', '0776021c646c9cc3dbe74a0f4d731fd2', '1.jpg', 'dbe74a0f4d731fd2.jpg', '0776021c646c9cc3/dbe74a0f4d731fd2.jpg', '0776021c646c9cc3/dbe74a0f4d731fd2.jpg', 'jpg', null, '0776021c646c9cc3/dbe74a0f4d731fd2.jpg', 'https://static.ctolog.com/0776021c646c9cc3/dbe74a0f4d731fd2.jpg', '10000', '2017-03-03 14:17:42');
INSERT INTO `system_file` VALUES ('105', 'qiniu', '16448cd6ec7af958e948e07267798042', '示例图片_03.jpg', 'e948e07267798042.jpg', '16448cd6ec7af958/e948e07267798042.jpg', '16448cd6ec7af958/e948e07267798042.jpg', 'jpg', null, '16448cd6ec7af958/e948e07267798042.jpg', 'https://static.ctolog.com/16448cd6ec7af958/e948e07267798042.jpg', '10000', '2017-03-03 14:18:53');
INSERT INTO `system_file` VALUES ('106', 'qiniu', '473f88108946b70375affcd9b4fc73d8', 'wKiom1VBgMnzbv2-AABqqtUsIjk591.jpg', '75affcd9b4fc73d8.jpg', '473f88108946b703/75affcd9b4fc73d8.jpg', '473f88108946b703/75affcd9b4fc73d8.jpg', 'jpg', null, '473f88108946b703/75affcd9b4fc73d8.jpg', 'https://static.ctolog.com/473f88108946b703/75affcd9b4fc73d8.jpg', '10000', '2017-03-03 14:27:32');
INSERT INTO `system_file` VALUES ('107', 'qiniu', 'f497af0c9dfe0cd9bb91a0c9be42370f', 'cbd977dbb6fd5266c807255aaa18972bd4073665.jpg', 'bb91a0c9be42370f.jpg', 'f497af0c9dfe0cd9/bb91a0c9be42370f.jpg', 'f497af0c9dfe0cd9/bb91a0c9be42370f.jpg', 'jpg', null, 'f497af0c9dfe0cd9/bb91a0c9be42370f.jpg', 'https://static.ctolog.com/f497af0c9dfe0cd9/bb91a0c9be42370f.jpg', '10000', '2017-03-03 15:54:49');
INSERT INTO `system_file` VALUES ('108', 'qiniu', '4d458e3036ffa25ba9fe5638fe16b495', 'e77c93c451da81cb2aff98835366d01609243170.jpg', 'a9fe5638fe16b495.jpg', '4d458e3036ffa25b/a9fe5638fe16b495.jpg', '4d458e3036ffa25b/a9fe5638fe16b495.jpg', 'jpg', null, '4d458e3036ffa25b/a9fe5638fe16b495.jpg', 'https://static.ctolog.com/4d458e3036ffa25b/a9fe5638fe16b495.jpg', '10000', '2017-03-03 15:54:50');
INSERT INTO `system_file` VALUES ('109', 'qiniu', '0068f5e8b09c4f00ed780012ca7a6859', '0.gif', 'ed780012ca7a6859.gif', '0068f5e8b09c4f00/ed780012ca7a6859.gif', '0068f5e8b09c4f00/ed780012ca7a6859.gif', 'gif', null, '0068f5e8b09c4f00/ed780012ca7a6859.gif', 'https://static.ctolog.com/0068f5e8b09c4f00/ed780012ca7a6859.gif', null, '2017-03-03 18:48:56');
INSERT INTO `system_file` VALUES ('110', 'qiniu', 'cf847625f1a00fe63b464173f7128ff2', '26g58PICbJK.jpg', '3b464173f7128ff2.jpg', 'cf847625f1a00fe6/3b464173f7128ff2.jpg', 'cf847625f1a00fe6/3b464173f7128ff2.jpg', 'jpg', null, 'cf847625f1a00fe6/3b464173f7128ff2.jpg', 'https://static.ctolog.com/cf847625f1a00fe6/3b464173f7128ff2.jpg', '10000', '2017-03-04 18:27:39');
INSERT INTO `system_file` VALUES ('111', 'qiniu', 'de0cec57622938c69850ced196020e26', 'b1.jpg', '9850ced196020e26.jpg', 'de0cec57622938c6/9850ced196020e26.jpg', 'de0cec57622938c6/9850ced196020e26.jpg', 'jpg', null, 'de0cec57622938c6/9850ced196020e26.jpg', 'https://static.ctolog.com/de0cec57622938c6/9850ced196020e26.jpg', '10000', '2017-03-04 18:28:11');
INSERT INTO `system_file` VALUES ('112', 'qiniu', '47b4d829ffa31e188bcc0ef1f7afdded', '56a03dbcda4da.png', '8bcc0ef1f7afdded.png', '47b4d829ffa31e18/8bcc0ef1f7afdded.png', '47b4d829ffa31e18/8bcc0ef1f7afdded.png', 'png', null, '47b4d829ffa31e18/8bcc0ef1f7afdded.png', 'https://static.ctolog.com/47b4d829ffa31e18/8bcc0ef1f7afdded.png', '10000', '2017-03-04 18:28:26');
INSERT INTO `system_file` VALUES ('113', 'qiniu', 'e2104bf6f1081b4f5b88730962f8bf70', '576b527377e3c.png', '5b88730962f8bf70.png', 'e2104bf6f1081b4f/5b88730962f8bf70.png', 'e2104bf6f1081b4f/5b88730962f8bf70.png', 'png', null, 'e2104bf6f1081b4f/5b88730962f8bf70.png', 'https://static.ctolog.com/e2104bf6f1081b4f/5b88730962f8bf70.png', '10000', '2017-03-04 18:46:23');
INSERT INTO `system_file` VALUES ('114', 'local', 'd577aefc7b8284c12b5bd3b9c0b6cad4', 'TB2VJ.2dt4opuFjSZFLXXX8mXXa_!!853652705.jpg_400x400.jpg_.webp.jpg', '2b5bd3b9c0b6cad4.jpg', 'upload/d577aefc7b8284c1/2b5bd3b9c0b6cad4.jpg', 'D:/WWW/ThinkAdmin/upload/d577aefc7b8284c1/2b5bd3b9c0b6cad4.jpg', 'jpg', '111713.00', 'upload/d577aefc7b8284c1/2b5bd3b9c0b6cad4.jpg', 'http://127.0.0.1/upload/d577aefc7b8284c1/2b5bd3b9c0b6cad4.jpg', '10000', '2017-03-04 20:04:41');
INSERT INTO `system_file` VALUES ('115', 'local', 'ed0b897ed997f5b0424bf4daf1ff74eb', 'bn01.jpg', '424bf4daf1ff74eb.jpg', 'upload/ed0b897ed997f5b0/424bf4daf1ff74eb.jpg', 'D:/WWW/ThinkAdmin/upload/ed0b897ed997f5b0/424bf4daf1ff74eb.jpg', 'jpg', '251954.00', 'upload/ed0b897ed997f5b0/424bf4daf1ff74eb.jpg', 'http://127.0.0.1/upload/ed0b897ed997f5b0/424bf4daf1ff74eb.jpg', '10000', '2017-03-04 20:05:13');
INSERT INTO `system_file` VALUES ('116', 'local', '3cca6a5380a99aa46d63a0210d2a98b4', '1450923190375371.png', '6d63a0210d2a98b4.png', 'upload/3cca6a5380a99aa4/6d63a0210d2a98b4.png', 'D:/WWW/ThinkAdmin/upload/3cca6a5380a99aa4/6d63a0210d2a98b4.png', 'png', '108688.00', 'upload/3cca6a5380a99aa4/6d63a0210d2a98b4.png', 'http://127.0.0.1/upload/3cca6a5380a99aa4/6d63a0210d2a98b4.png', '10000', '2017-03-04 20:09:17');
INSERT INTO `system_file` VALUES ('117', 'qiniu', '12f6099e6488999413c9a39f7d5304ae', 'QQ图片20170302134535.png', '13c9a39f7d5304ae.png', '12f6099e64889994/13c9a39f7d5304ae.png', '12f6099e64889994/13c9a39f7d5304ae.png', 'png', null, '12f6099e64889994/13c9a39f7d5304ae.png', 'https://static.ctolog.com/12f6099e64889994/13c9a39f7d5304ae.png', '10000', '2017-03-05 07:02:53');
INSERT INTO `system_file` VALUES ('118', 'qiniu', 'f88bd49a988a22b452ea09497c477d0f', 'anonymous.jpg', '52ea09497c477d0f.jpg', 'f88bd49a988a22b4/52ea09497c477d0f.jpg', 'f88bd49a988a22b4/52ea09497c477d0f.jpg', 'jpg', null, 'f88bd49a988a22b4/52ea09497c477d0f.jpg', 'https://static.ctolog.com/f88bd49a988a22b4/52ea09497c477d0f.jpg', '10000', '2017-03-05 08:29:36');
INSERT INTO `system_file` VALUES ('119', 'qiniu', '85ca89fbf48e897c3afaf8c7e12f9149', '16232Q101-0.gif', '3afaf8c7e12f9149.gif', '85ca89fbf48e897c/3afaf8c7e12f9149.gif', '85ca89fbf48e897c/3afaf8c7e12f9149.gif', 'gif', null, '85ca89fbf48e897c/3afaf8c7e12f9149.gif', 'https://static.ctolog.com/85ca89fbf48e897c/3afaf8c7e12f9149.gif', '10000', '2017-03-05 10:40:57');
INSERT INTO `system_file` VALUES ('120', 'qiniu', '2e38372786fb7b3dcc51d84481e83215', '2015110514160726399.jpg', 'cc51d84481e83215.jpg', '2e38372786fb7b3d/cc51d84481e83215.jpg', '2e38372786fb7b3d/cc51d84481e83215.jpg', 'jpg', null, '2e38372786fb7b3d/cc51d84481e83215.jpg', 'https://static.ctolog.com/2e38372786fb7b3d/cc51d84481e83215.jpg', '10000', '2017-03-05 12:36:34');
INSERT INTO `system_file` VALUES ('121', 'qiniu', '46771f56bdf9ea0419767d6c05af8157', '家装公司列表页.jpg', '19767d6c05af8157.jpg', '46771f56bdf9ea04/19767d6c05af8157.jpg', '46771f56bdf9ea04/19767d6c05af8157.jpg', 'jpg', null, '46771f56bdf9ea04/19767d6c05af8157.jpg', 'https://static.ctolog.com/46771f56bdf9ea04/19767d6c05af8157.jpg', '10000', '2017-03-05 14:22:53');
INSERT INTO `system_file` VALUES ('122', 'qiniu', 'b4db5d2cc54db21f73177ddb0c06c1ba', '706031451644961253.jpg', '73177ddb0c06c1ba.jpg', 'b4db5d2cc54db21f/73177ddb0c06c1ba.jpg', 'b4db5d2cc54db21f/73177ddb0c06c1ba.jpg', 'jpg', null, 'b4db5d2cc54db21f/73177ddb0c06c1ba.jpg', 'http://static.ctolog.com/b4db5d2cc54db21f/73177ddb0c06c1ba.jpg', '10000', '2017-03-05 15:31:23');
INSERT INTO `system_file` VALUES ('123', 'qiniu', 'ee0f46db71f71d39fe635dd35e8863cc', '603458451003609978.jpg', 'fe635dd35e8863cc.jpg', 'ee0f46db71f71d39/fe635dd35e8863cc.jpg', 'ee0f46db71f71d39/fe635dd35e8863cc.jpg', 'jpg', null, 'ee0f46db71f71d39/fe635dd35e8863cc.jpg', 'http://static.ctolog.com/ee0f46db71f71d39/fe635dd35e8863cc.jpg', '10000', '2017-03-05 15:31:32');
INSERT INTO `system_file` VALUES ('124', 'qiniu', '0bf755483f42ab5cf95ccbb3b393baac', '598673.jpg', 'f95ccbb3b393baac.jpg', '0bf755483f42ab5c/f95ccbb3b393baac.jpg', '0bf755483f42ab5c/f95ccbb3b393baac.jpg', 'jpg', null, '0bf755483f42ab5c/f95ccbb3b393baac.jpg', 'http://static.ctolog.com/0bf755483f42ab5c/f95ccbb3b393baac.jpg', '10000', '2017-03-05 17:51:51');
INSERT INTO `system_file` VALUES ('125', 'qiniu', '62f72471f5c0d16400643e371a2f5a70', 'img02.jpg', '00643e371a2f5a70.jpg', '62f72471f5c0d164/00643e371a2f5a70.jpg', '62f72471f5c0d164/00643e371a2f5a70.jpg', 'jpg', null, '62f72471f5c0d164/00643e371a2f5a70.jpg', 'https://static.ctolog.com/62f72471f5c0d164/00643e371a2f5a70.jpg', '10000', '2017-03-06 08:26:39');
INSERT INTO `system_file` VALUES ('126', 'qiniu', '2ca1109411117c62e6376689cbe1ec5e', 'caiyilin.jpg', 'e6376689cbe1ec5e.jpg', '2ca1109411117c62/e6376689cbe1ec5e.jpg', '2ca1109411117c62/e6376689cbe1ec5e.jpg', 'jpg', null, '2ca1109411117c62/e6376689cbe1ec5e.jpg', 'http://static.ctolog.com/2ca1109411117c62/e6376689cbe1ec5e.jpg', '10000', '2017-03-06 10:02:45');
INSERT INTO `system_file` VALUES ('127', 'qiniu', '7f5e19b55f1e95c7f319150baf6ea455', '2246_161119104622_1.png', 'f319150baf6ea455.png', '7f5e19b55f1e95c7/f319150baf6ea455.png', '7f5e19b55f1e95c7/f319150baf6ea455.png', 'png', null, '7f5e19b55f1e95c7/f319150baf6ea455.png', 'https://static.ctolog.com/7f5e19b55f1e95c7/f319150baf6ea455.png', '10000', '2017-03-06 11:08:52');
INSERT INTO `system_file` VALUES ('128', 'qiniu', '0b2d3e977ce40e94c2279e0bcbef687a', 'getheadimg.jpg', 'c2279e0bcbef687a.jpg', '0b2d3e977ce40e94/c2279e0bcbef687a.jpg', '0b2d3e977ce40e94/c2279e0bcbef687a.jpg', 'jpg', null, '0b2d3e977ce40e94/c2279e0bcbef687a.jpg', 'https://static.ctolog.com/0b2d3e977ce40e94/c2279e0bcbef687a.jpg', '10000', '2017-03-06 11:24:12');
INSERT INTO `system_file` VALUES ('129', 'qiniu', 'cfd4b538dc1d8b96a09310cab5fa44c9', '20150705211109.gif', 'a09310cab5fa44c9.gif', 'cfd4b538dc1d8b96/a09310cab5fa44c9.gif', 'cfd4b538dc1d8b96/a09310cab5fa44c9.gif', 'gif', null, 'cfd4b538dc1d8b96/a09310cab5fa44c9.gif', 'https://static.ctolog.com/cfd4b538dc1d8b96/a09310cab5fa44c9.gif', '10000', '2017-03-06 11:25:01');
INSERT INTO `system_file` VALUES ('130', 'qiniu', '790382d9c355ecbdf7563f0d06e2b4e7', 'sshot-2.png', 'f7563f0d06e2b4e7.png', '790382d9c355ecbd/f7563f0d06e2b4e7.png', '790382d9c355ecbd/f7563f0d06e2b4e7.png', 'png', null, '790382d9c355ecbd/f7563f0d06e2b4e7.png', 'https://static.ctolog.com/790382d9c355ecbd/f7563f0d06e2b4e7.png', '10000', '2017-03-06 11:25:23');
INSERT INTO `system_file` VALUES ('131', 'local', '790382d9c355ecbdf7563f0d06e2b4e7', 'sshot-2.png', 'f7563f0d06e2b4e7.png', 'upload/790382d9c355ecbd/f7563f0d06e2b4e7.png', '/home/wwwroot/think/trunk/public/upload/790382d9c355ecbd/f7563f0d06e2b4e7.png', 'png', '586029.00', 'upload/790382d9c355ecbd/f7563f0d06e2b4e7.png', 'https://think.ctolog.com/upload/790382d9c355ecbd/f7563f0d06e2b4e7.png', '10000', '2017-03-06 11:26:31');
INSERT INTO `system_file` VALUES ('132', 'local', '0b2d3e977ce40e94c2279e0bcbef687a', 'getheadimg.jpg', 'c2279e0bcbef687a.jpg', 'upload/0b2d3e977ce40e94/c2279e0bcbef687a.jpg', 'D:/WebRoot/store/public/upload/0b2d3e977ce40e94/c2279e0bcbef687a.jpg', 'jpg', '1946.00', 'upload/0b2d3e977ce40e94/c2279e0bcbef687a.jpg', 'http://localhost/store/public/upload/0b2d3e977ce40e94/c2279e0bcbef687a.jpg', '10000', '2017-03-06 11:26:54');
INSERT INTO `system_file` VALUES ('133', 'local', '943ef23f75adcffafdb4ab2c49f8e711', 'sshot-1.png', 'fdb4ab2c49f8e711.png', 'upload/943ef23f75adcffa/fdb4ab2c49f8e711.png', 'D:/WebRoot/store/public/upload/943ef23f75adcffa/fdb4ab2c49f8e711.png', 'png', '9716.00', 'upload/943ef23f75adcffa/fdb4ab2c49f8e711.png', 'http://localhost/store/public/upload/943ef23f75adcffa/fdb4ab2c49f8e711.png', '10000', '2017-03-06 11:28:42');
INSERT INTO `system_file` VALUES ('134', 'local', 'cfd4b538dc1d8b96a09310cab5fa44c9', '20150705211109.gif', 'a09310cab5fa44c9.gif', 'upload/cfd4b538dc1d8b96/a09310cab5fa44c9.gif', '/home/wwwroot/think/trunk/public/upload/cfd4b538dc1d8b96/a09310cab5fa44c9.gif', 'gif', '129103.00', 'upload/cfd4b538dc1d8b96/a09310cab5fa44c9.gif', 'https://think.ctolog.com/upload/cfd4b538dc1d8b96/a09310cab5fa44c9.gif', '10000', '2017-03-06 11:38:01');
INSERT INTO `system_file` VALUES ('135', 'qiniu', '4764d9b554c1e6cfc263c2920b4d00b5', '屏幕快照 2017-03-02 下午4.43.19.png', 'c263c2920b4d00b5.png', '4764d9b554c1e6cf/c263c2920b4d00b5.png', '4764d9b554c1e6cf/c263c2920b4d00b5.png', 'png', null, '4764d9b554c1e6cf/c263c2920b4d00b5.png', 'http://static.ctolog.com/4764d9b554c1e6cf/c263c2920b4d00b5.png', '10000', '2017-03-06 15:37:31');
INSERT INTO `system_file` VALUES ('136', 'qiniu', 'cc1f297826b3528c5a6402c726d59106', 'b5_bg.jpg', '5a6402c726d59106.jpg', 'cc1f297826b3528c/5a6402c726d59106.jpg', 'cc1f297826b3528c/5a6402c726d59106.jpg', 'jpg', null, 'cc1f297826b3528c/5a6402c726d59106.jpg', 'http://static.ctolog.com/cc1f297826b3528c/5a6402c726d59106.jpg', '10000', '2017-03-06 15:42:24');
INSERT INTO `system_file` VALUES ('137', 'qiniu', '60c944750206122af6b87602156235e2', '2.jpg', 'f6b87602156235e2.jpg', '60c944750206122a/f6b87602156235e2.jpg', '60c944750206122a/f6b87602156235e2.jpg', 'jpg', null, '60c944750206122a/f6b87602156235e2.jpg', 'http://static.ctolog.com/60c944750206122a/f6b87602156235e2.jpg', '10000', '2017-03-06 16:30:15');
INSERT INTO `system_file` VALUES ('138', 'local', '60c944750206122af6b87602156235e2', '2.jpg', 'f6b87602156235e2.jpg', 'upload/60c944750206122a/f6b87602156235e2.jpg', 'D:/xampp/htdocs/Think/public/upload/60c944750206122a/f6b87602156235e2.jpg', 'jpg', '730822.00', 'upload/60c944750206122a/f6b87602156235e2.jpg', 'http://www.think.com/public/upload/60c944750206122a/f6b87602156235e2.jpg', '10000', '2017-03-06 17:21:53');
INSERT INTO `system_file` VALUES ('139', 'local', '4a0856174dd9234a89c0bff42f5b94fd', '22.png', '89c0bff42f5b94fd.png', 'upload/4a0856174dd9234a/89c0bff42f5b94fd.png', 'D:/xampp/htdocs/Think/public/upload/4a0856174dd9234a/89c0bff42f5b94fd.png', 'png', '453.00', 'upload/4a0856174dd9234a/89c0bff42f5b94fd.png', 'http://www.think.com/public/upload/4a0856174dd9234a/89c0bff42f5b94fd.png', '10000', '2017-03-06 17:22:15');
INSERT INTO `system_file` VALUES ('140', 'local', '771db63b6ffc9de1c06da564796adc6e', 'help.png', 'c06da564796adc6e.png', 'upload/771db63b6ffc9de1/c06da564796adc6e.png', 'D:/xampp/htdocs/Think/public/upload/771db63b6ffc9de1/c06da564796adc6e.png', 'png', '3299.00', 'upload/771db63b6ffc9de1/c06da564796adc6e.png', 'http://www.think.com/public/upload/771db63b6ffc9de1/c06da564796adc6e.png', '10000', '2017-03-06 17:41:34');
INSERT INTO `system_file` VALUES ('141', 'local', '56f3bb329c7756e50a54e5c75a2104da', '111.png', '0a54e5c75a2104da.png', 'upload/56f3bb329c7756e5/0a54e5c75a2104da.png', '/home/wwwroot/think/trunk/public/upload/56f3bb329c7756e5/0a54e5c75a2104da.png', 'png', '1500606.00', 'upload/56f3bb329c7756e5/0a54e5c75a2104da.png', 'https://think.ctolog.com/upload/56f3bb329c7756e5/0a54e5c75a2104da.png', '10000', '2017-03-06 21:22:06');
INSERT INTO `system_file` VALUES ('142', 'local', '908b0cdbd2f44f28e1ba347e8bc2c01c', '屏幕快照 2016-03-08 下午3.28.31.png', 'e1ba347e8bc2c01c.png', 'upload/908b0cdbd2f44f28/e1ba347e8bc2c01c.png', '/home/wwwroot/think/trunk/public/upload/908b0cdbd2f44f28/e1ba347e8bc2c01c.png', 'png', '188606.00', 'upload/908b0cdbd2f44f28/e1ba347e8bc2c01c.png', 'https://think.ctolog.com/upload/908b0cdbd2f44f28/e1ba347e8bc2c01c.png', '10000', '2017-03-06 21:22:24');
INSERT INTO `system_file` VALUES ('143', 'qiniu', '32ae5ac7c6d854fcdf0bf338e266885c', 'logo.png', 'df0bf338e266885c.png', '32ae5ac7c6d854fc/df0bf338e266885c.png', '32ae5ac7c6d854fc/df0bf338e266885c.png', 'png', null, '32ae5ac7c6d854fc/df0bf338e266885c.png', 'https://static.ctolog.com/32ae5ac7c6d854fc/df0bf338e266885c.png', '10000', '2017-03-07 02:18:54');
INSERT INTO `system_file` VALUES ('144', 'qiniu', 'e894d7f3a5069080c3b1b22a67e8d9db', 'i20160804_307_508.jpg', 'c3b1b22a67e8d9db.jpg', 'e894d7f3a5069080/c3b1b22a67e8d9db.jpg', 'e894d7f3a5069080/c3b1b22a67e8d9db.jpg', 'jpg', null, 'e894d7f3a5069080/c3b1b22a67e8d9db.jpg', 'https://static.ctolog.com/e894d7f3a5069080/c3b1b22a67e8d9db.jpg', '10000', '2017-03-07 08:47:40');
INSERT INTO `system_file` VALUES ('145', 'qiniu', '7d81fb62455c5dc9f23d0dd6757acde6', 'i20161130_831_618.png', 'f23d0dd6757acde6.png', '7d81fb62455c5dc9/f23d0dd6757acde6.png', '7d81fb62455c5dc9/f23d0dd6757acde6.png', 'png', null, '7d81fb62455c5dc9/f23d0dd6757acde6.png', 'https://static.ctolog.com/7d81fb62455c5dc9/f23d0dd6757acde6.png', '10000', '2017-03-07 08:48:00');
INSERT INTO `system_file` VALUES ('146', 'qiniu', '1ad981dbeca0eaab7c21246306331c92', '5837d9aeNf52e37e5.jpg', '7c21246306331c92.jpg', '1ad981dbeca0eaab/7c21246306331c92.jpg', '1ad981dbeca0eaab/7c21246306331c92.jpg', 'jpg', null, '1ad981dbeca0eaab/7c21246306331c92.jpg', 'https://static.ctolog.com/1ad981dbeca0eaab/7c21246306331c92.jpg', '10000', '2017-03-07 09:17:28');
INSERT INTO `system_file` VALUES ('147', 'qiniu', 'a0e956aaf0cddf68adb98d95b23ad57e', '1.jpg', 'adb98d95b23ad57e.jpg', 'a0e956aaf0cddf68/adb98d95b23ad57e.jpg', 'a0e956aaf0cddf68/adb98d95b23ad57e.jpg', 'jpg', null, 'a0e956aaf0cddf68/adb98d95b23ad57e.jpg', 'https://static.ctolog.com/a0e956aaf0cddf68/adb98d95b23ad57e.jpg', '10000', '2017-03-07 09:20:26');
INSERT INTO `system_file` VALUES ('148', 'local', '9fc61316490438944a63ed8c6be5f473', 'action.png', '4a63ed8c6be5f473.png', 'upload/9fc6131649043894/4a63ed8c6be5f473.png', '/home/wwwroot/think/trunk/public/upload/9fc6131649043894/4a63ed8c6be5f473.png', 'png', '1174.00', 'upload/9fc6131649043894/4a63ed8c6be5f473.png', 'https://think.ctolog.com/upload/9fc6131649043894/4a63ed8c6be5f473.png', '10000', '2017-03-07 12:01:49');
INSERT INTO `system_file` VALUES ('149', 'local', '1437932ffe760ab55f5f31bfe50fbc04', '2bb0a9ef49ca4227c1142325b71cbac9.jpg', '5f5f31bfe50fbc04.jpg', 'upload/1437932ffe760ab5/5f5f31bfe50fbc04.jpg', '/home/wwwroot/think/trunk/public/upload/1437932ffe760ab5/5f5f31bfe50fbc04.jpg', 'jpg', '249098.00', 'upload/1437932ffe760ab5/5f5f31bfe50fbc04.jpg', 'https://think.ctolog.com/upload/1437932ffe760ab5/5f5f31bfe50fbc04.jpg', '10000', '2017-03-07 12:12:26');
INSERT INTO `system_file` VALUES ('150', 'local', '4db940829027a8b09a2afe5074c225f3', '02e62bc197a94c42cb210ead4ddfe4ff.jpg', '9a2afe5074c225f3.jpg', 'upload/4db940829027a8b0/9a2afe5074c225f3.jpg', '/home/wwwroot/think/trunk/public/upload/4db940829027a8b0/9a2afe5074c225f3.jpg', 'jpg', '382601.00', 'upload/4db940829027a8b0/9a2afe5074c225f3.jpg', 'https://think.ctolog.com/upload/4db940829027a8b0/9a2afe5074c225f3.jpg', '10000', '2017-03-07 12:21:39');
INSERT INTO `system_file` VALUES ('151', 'local', 'c5de903726fcce898fe6a29a240c1c4f', '6.png', '8fe6a29a240c1c4f.png', 'upload/c5de903726fcce89/8fe6a29a240c1c4f.png', 'D:/WebRoot/store/public/upload/c5de903726fcce89/8fe6a29a240c1c4f.png', 'png', '7539.00', 'upload/c5de903726fcce89/8fe6a29a240c1c4f.png', 'http://localhost/store/public/upload/c5de903726fcce89/8fe6a29a240c1c4f.png', '10000', '2017-03-08 15:19:50');
INSERT INTO `system_file` VALUES ('152', 'local', 'd94dded06a2ffa09b864bce7ee156989', '22222.png', 'b864bce7ee156989.png', 'upload/d94dded06a2ffa09/b864bce7ee156989.png', 'D:/WebRoot/store/public/upload/d94dded06a2ffa09/b864bce7ee156989.png', 'png', '152018.00', 'upload/d94dded06a2ffa09/b864bce7ee156989.png', 'http://localhost/store/public/upload/d94dded06a2ffa09/b864bce7ee156989.png', '10000', '2017-03-08 15:31:48');
INSERT INTO `system_file` VALUES ('153', 'local', '1a026a499503df160f8bcd6d71770ffa', 'QQ图片20170306155413.jpg', '0f8bcd6d71770ffa.jpg', 'upload/1a026a499503df16/0f8bcd6d71770ffa.jpg', 'D:/WebRoot/store/public/upload/1a026a499503df16/0f8bcd6d71770ffa.jpg', 'jpg', '605274.00', 'upload/1a026a499503df16/0f8bcd6d71770ffa.jpg', 'http://localhost/store/public/upload/1a026a499503df16/0f8bcd6d71770ffa.jpg', '10000', '2017-03-08 16:01:57');
INSERT INTO `system_file` VALUES ('154', 'local', 'cd48631d3dd2a1e0d316a865c31cee11', '91857a2465724a878cb181608e33b759.jpg.webp', 'd316a865c31cee11.webp', 'upload/cd48631d3dd2a1e0/d316a865c31cee11.webp', 'D:/WebRoot/store/public/upload/cd48631d3dd2a1e0/d316a865c31cee11.webp', 'webp', '30020.00', 'upload/cd48631d3dd2a1e0/d316a865c31cee11.webp', 'http://localhost/store/public/upload/cd48631d3dd2a1e0/d316a865c31cee11.webp', '10000', '2017-03-08 16:06:10');
INSERT INTO `system_file` VALUES ('155', 'local', 'e2a16716021b48d321908fc58d0bd367', '4349951.jpg', '21908fc58d0bd367.jpg', 'upload/e2a16716021b48d3/21908fc58d0bd367.jpg', 'D:/WebRoot/store/public/upload/e2a16716021b48d3/21908fc58d0bd367.jpg', 'jpg', '28728.00', 'upload/e2a16716021b48d3/21908fc58d0bd367.jpg', 'http://localhost/store/public/upload/e2a16716021b48d3/21908fc58d0bd367.jpg', '10000', '2017-03-09 14:52:26');
INSERT INTO `system_file` VALUES ('156', 'local', '62d17f4d841baf801bac9032bc8e1056', 'logo.png', '1bac9032bc8e1056.png', 'upload/62d17f4d841baf80/1bac9032bc8e1056.png', '/home/wwwroot/think/trunk/public/upload/62d17f4d841baf80/1bac9032bc8e1056.png', 'png', '2965.00', 'upload/62d17f4d841baf80/1bac9032bc8e1056.png', 'https://think.ctolog.com/upload/62d17f4d841baf80/1bac9032bc8e1056.png', '10000', '2017-03-14 18:00:38');
INSERT INTO `system_file` VALUES ('157', 'local', '8b457a0460091268b4d9e154b98f13a9', '4D5EB1BD-5146-4550-AF94-6730CE8C792E.png', 'b4d9e154b98f13a9.png', 'upload/8b457a0460091268/b4d9e154b98f13a9.png', '/home/wwwroot/think/trunk/public/upload/8b457a0460091268/b4d9e154b98f13a9.png', 'png', '12128.00', 'upload/8b457a0460091268/b4d9e154b98f13a9.png', 'https://think.ctolog.com/upload/8b457a0460091268/b4d9e154b98f13a9.png', '10000', '2017-03-14 22:19:54');
INSERT INTO `system_file` VALUES ('158', 'local', 'b3a2413e763eeaabc5382bb0c1b767ad', 'background2.png', 'c5382bb0c1b767ad.png', 'upload/b3a2413e763eeaab/c5382bb0c1b767ad.png', '/home/wwwroot/think/trunk/public/upload/b3a2413e763eeaab/c5382bb0c1b767ad.png', 'png', '928822.00', 'upload/b3a2413e763eeaab/c5382bb0c1b767ad.png', 'https://think.ctolog.com/upload/b3a2413e763eeaab/c5382bb0c1b767ad.png', '10000', '2017-03-14 22:20:22');
INSERT INTO `system_file` VALUES ('159', 'local', '0668a419d0237b98cedf1fd7ee70e8cd', 'WechatIMG65.jpg', 'cedf1fd7ee70e8cd.jpg', 'upload/0668a419d0237b98/cedf1fd7ee70e8cd.jpg', '/home/wwwroot/think/trunk/public/upload/0668a419d0237b98/cedf1fd7ee70e8cd.jpg', 'jpg', '63959.00', 'upload/0668a419d0237b98/cedf1fd7ee70e8cd.jpg', 'https://think.ctolog.com/upload/0668a419d0237b98/cedf1fd7ee70e8cd.jpg', '10000', '2017-03-15 09:07:34');
INSERT INTO `system_file` VALUES ('160', 'local', 'd66b1ee970e32240c632cdfaedf676ce', '114965361564677479.jpg', 'c632cdfaedf676ce.jpg', 'upload/d66b1ee970e32240/c632cdfaedf676ce.jpg', '/home/wwwroot/think/trunk/public/upload/d66b1ee970e32240/c632cdfaedf676ce.jpg', 'jpg', '79927.00', 'upload/d66b1ee970e32240/c632cdfaedf676ce.jpg', 'https://think.ctolog.com/upload/d66b1ee970e32240/c632cdfaedf676ce.jpg', '10000', '2017-03-15 10:09:56');
INSERT INTO `system_file` VALUES ('161', 'local', '03c09207ec37d3bc246339665ee1f718', 'app388_388_75.png', '246339665ee1f718.png', 'upload/03c09207ec37d3bc/246339665ee1f718.png', '/home/wwwroot/think/trunk/public/upload/03c09207ec37d3bc/246339665ee1f718.png', 'png', '10761.00', 'upload/03c09207ec37d3bc/246339665ee1f718.png', 'https://think.ctolog.com/upload/03c09207ec37d3bc/246339665ee1f718.png', '10000', '2017-03-15 10:17:51');
INSERT INTO `system_file` VALUES ('162', 'local', '8cd2ab293660edf015723a9730c2d51a', 'app502_502_75.png', '15723a9730c2d51a.png', 'upload/8cd2ab293660edf0/15723a9730c2d51a.png', '/home/wwwroot/think/trunk/public/upload/8cd2ab293660edf0/15723a9730c2d51a.png', 'png', '8155.00', 'upload/8cd2ab293660edf0/15723a9730c2d51a.png', 'https://think.ctolog.com/upload/8cd2ab293660edf0/15723a9730c2d51a.png', '10000', '2017-03-15 10:17:56');
INSERT INTO `system_file` VALUES ('163', 'local', '12e9a4747577cb58e77c92d676a228fe', '0.png', 'e77c92d676a228fe.png', 'upload/12e9a4747577cb58/e77c92d676a228fe.png', '/home/wwwroot/think/trunk/public/upload/12e9a4747577cb58/e77c92d676a228fe.png', 'png', '5686.00', 'upload/12e9a4747577cb58/e77c92d676a228fe.png', 'https://think.ctolog.com/upload/12e9a4747577cb58/e77c92d676a228fe.png', '10000', '2017-03-15 13:37:25');
INSERT INTO `system_file` VALUES ('164', 'local', '9e14d8cb01a782ebba10ee36c81920e8', 'QQ图片20170304070142.jpg', 'ba10ee36c81920e8.jpg', 'upload/9e14d8cb01a782eb/ba10ee36c81920e8.jpg', '/home/wwwroot/think/trunk/public/upload/9e14d8cb01a782eb/ba10ee36c81920e8.jpg', 'jpg', '53408.00', 'upload/9e14d8cb01a782eb/ba10ee36c81920e8.jpg', 'https://think.ctolog.com/upload/9e14d8cb01a782eb/ba10ee36c81920e8.jpg', '10000', '2017-03-15 14:30:14');
INSERT INTO `system_file` VALUES ('165', 'local', '5a44c7ba5bbe4ec867233d67e4806848', 'Jellyfish.jpg', '67233d67e4806848.jpg', 'upload/5a44c7ba5bbe4ec8/67233d67e4806848.jpg', '/home/wwwroot/think/trunk/public/upload/5a44c7ba5bbe4ec8/67233d67e4806848.jpg', 'jpg', '775702.00', 'upload/5a44c7ba5bbe4ec8/67233d67e4806848.jpg', 'https://think.ctolog.com/upload/5a44c7ba5bbe4ec8/67233d67e4806848.jpg', '10000', '2017-03-15 15:41:21');
INSERT INTO `system_file` VALUES ('166', 'qiniu', '4b671bd4bd2f08d25430d4bb875e173a', 'user.jpg', '5430d4bb875e173a.jpg', '4b671bd4bd2f08d2/5430d4bb875e173a.jpg', '4b671bd4bd2f08d2/5430d4bb875e173a.jpg', 'jpg', null, '4b671bd4bd2f08d2/5430d4bb875e173a.jpg', 'http://omuafhgch.bkt.clouddn.com/4b671bd4bd2f08d2/5430d4bb875e173a.jpg', '10000', '2017-03-15 16:08:49');
INSERT INTO `system_file` VALUES ('167', 'qiniu', '9e36890a2f16a0d6d3a53b43789539a4', 'logo.png', 'd3a53b43789539a4.png', '9e36890a2f16a0d6/d3a53b43789539a4.png', '9e36890a2f16a0d6/d3a53b43789539a4.png', 'png', null, '9e36890a2f16a0d6/d3a53b43789539a4.png', 'https://omuafhgch.bkt.clouddn.com/9e36890a2f16a0d6/d3a53b43789539a4.png', '10000', '2017-03-15 16:09:40');
INSERT INTO `system_file` VALUES ('168', 'qiniu', 'f1585e5d3419666567b23c159a4b096a', '壁纸.jpg', '67b23c159a4b096a.jpg', 'f1585e5d34196665/67b23c159a4b096a.jpg', 'f1585e5d34196665/67b23c159a4b096a.jpg', 'jpg', null, 'f1585e5d34196665/67b23c159a4b096a.jpg', 'https://static.cdn.cuci.com/f1585e5d34196665/67b23c159a4b096a.jpg', '10000', '2017-03-15 19:23:56');
INSERT INTO `system_file` VALUES ('169', 'qiniu', '9e7daee1ad44ffd026f5df4ccd77caba', '栈模型.png', '26f5df4ccd77caba.png', '9e7daee1ad44ffd0/26f5df4ccd77caba.png', '9e7daee1ad44ffd0/26f5df4ccd77caba.png', 'png', null, '9e7daee1ad44ffd0/26f5df4ccd77caba.png', 'https://static.cdn.cuci.com/9e7daee1ad44ffd0/26f5df4ccd77caba.png', '10000', '2017-03-15 19:24:07');
INSERT INTO `system_file` VALUES ('170', 'qiniu', '38559f2658505f156b2f76dc37507a3e', 'bg_home.png', '6b2f76dc37507a3e.png', '38559f2658505f15/6b2f76dc37507a3e.png', '38559f2658505f15/6b2f76dc37507a3e.png', 'png', null, '38559f2658505f15/6b2f76dc37507a3e.png', 'https://static.cdn.cuci.com/38559f2658505f15/6b2f76dc37507a3e.png', '10000', '2017-03-15 19:24:26');
INSERT INTO `system_file` VALUES ('171', 'qiniu', '9ec570fac4104a47da0531c7c62e58e8', '11205.jpg', 'da0531c7c62e58e8.jpg', '9ec570fac4104a47/da0531c7c62e58e8.jpg', '9ec570fac4104a47/da0531c7c62e58e8.jpg', 'jpg', null, '9ec570fac4104a47/da0531c7c62e58e8.jpg', 'https://static.cdn.cuci.com/9ec570fac4104a47/da0531c7c62e58e8.jpg', '10000', '2017-03-15 19:25:38');
INSERT INTO `system_file` VALUES ('172', 'qiniu', 'a82ddd68fda930c3dab63e3e40fc11b8', '01-a.jpg', 'dab63e3e40fc11b8.jpg', 'a82ddd68fda930c3/dab63e3e40fc11b8.jpg', 'a82ddd68fda930c3/dab63e3e40fc11b8.jpg', 'jpg', null, 'a82ddd68fda930c3/dab63e3e40fc11b8.jpg', 'https://static.cdn.cuci.com/a82ddd68fda930c3/dab63e3e40fc11b8.jpg', '10000', '2017-03-15 22:11:51');
INSERT INTO `system_file` VALUES ('173', 'qiniu', 'bb62a20158689cba040c7bfe46f4a0fc', 'imac.png', '040c7bfe46f4a0fc.png', 'bb62a20158689cba/040c7bfe46f4a0fc.png', 'bb62a20158689cba/040c7bfe46f4a0fc.png', 'png', null, 'bb62a20158689cba/040c7bfe46f4a0fc.png', 'https://static.cdn.cuci.com/bb62a20158689cba/040c7bfe46f4a0fc.png', '10000', '2017-03-15 22:12:04');
INSERT INTO `system_file` VALUES ('174', 'qiniu', 'b70e335a86f5cc1ad6a1df438a9e5f10', 'asrat almedha2.jpg', 'd6a1df438a9e5f10.jpg', 'b70e335a86f5cc1a/d6a1df438a9e5f10.jpg', 'b70e335a86f5cc1a/d6a1df438a9e5f10.jpg', 'jpg', null, 'b70e335a86f5cc1a/d6a1df438a9e5f10.jpg', 'https://static.cdn.cuci.com/b70e335a86f5cc1a/d6a1df438a9e5f10.jpg', '10000', '2017-03-16 09:49:08');
INSERT INTO `system_file` VALUES ('175', 'qiniu', '7d371b5beb3fe508ea69970834bc05a0', 'ddd.ico', 'ea69970834bc05a0.ico', '7d371b5beb3fe508/ea69970834bc05a0.ico', '7d371b5beb3fe508/ea69970834bc05a0.ico', 'ico', null, '7d371b5beb3fe508/ea69970834bc05a0.ico', 'https://static.cdn.cuci.com/7d371b5beb3fe508/ea69970834bc05a0.ico', '10000', '2017-03-16 11:19:08');
INSERT INTO `system_file` VALUES ('176', 'qiniu', '99b1746267749ed6016a1258cb15f902', 'logo.png', '016a1258cb15f902.png', '99b1746267749ed6/016a1258cb15f902.png', '99b1746267749ed6/016a1258cb15f902.png', 'png', null, '99b1746267749ed6/016a1258cb15f902.png', 'http://static.cdn.cuci.com/99b1746267749ed6/016a1258cb15f902.png', '10000', '2017-03-16 15:52:34');
INSERT INTO `system_file` VALUES ('177', 'qiniu', 'd693c95ecc16fbe0282f368e83a85974', 'p5.jpg', '282f368e83a85974.jpg', 'd693c95ecc16fbe0/282f368e83a85974.jpg', 'd693c95ecc16fbe0/282f368e83a85974.jpg', 'jpg', null, 'd693c95ecc16fbe0/282f368e83a85974.jpg', 'http://static.cdn.cuci.com/d693c95ecc16fbe0/282f368e83a85974.jpg', '10000', '2017-03-16 18:47:32');
INSERT INTO `system_file` VALUES ('178', 'qiniu', '5c060d11a045a11139ba24ce926f5c86', 'tem4_003.jpg', '39ba24ce926f5c86.jpg', '5c060d11a045a111/39ba24ce926f5c86.jpg', '5c060d11a045a111/39ba24ce926f5c86.jpg', 'jpg', null, '5c060d11a045a111/39ba24ce926f5c86.jpg', 'http://static.cdn.cuci.com/5c060d11a045a111/39ba24ce926f5c86.jpg', '10000', '2017-03-16 23:03:57');
INSERT INTO `system_file` VALUES ('179', 'qiniu', '015277cd8613e891ae9f8706b6281977', 'tem4_006.jpg', 'ae9f8706b6281977.jpg', '015277cd8613e891/ae9f8706b6281977.jpg', '015277cd8613e891/ae9f8706b6281977.jpg', 'jpg', null, '015277cd8613e891/ae9f8706b6281977.jpg', 'http://static.cdn.cuci.com/015277cd8613e891/ae9f8706b6281977.jpg', '10000', '2017-03-16 23:04:13');
INSERT INTO `system_file` VALUES ('180', 'qiniu', '3c3cdfa13d07a66365788efdd7d92784', 'sty_013.png', '65788efdd7d92784.png', '3c3cdfa13d07a663/65788efdd7d92784.png', '3c3cdfa13d07a663/65788efdd7d92784.png', 'png', null, '3c3cdfa13d07a663/65788efdd7d92784.png', 'http://static.cdn.cuci.com/3c3cdfa13d07a663/65788efdd7d92784.png', '10000', '2017-03-16 23:04:26');
INSERT INTO `system_file` VALUES ('181', 'qiniu', 'df932df0a1b10c49fc911cadbc8e3346', '6.png', 'fc911cadbc8e3346.png', 'df932df0a1b10c49/fc911cadbc8e3346.png', 'df932df0a1b10c49/fc911cadbc8e3346.png', 'png', null, 'df932df0a1b10c49/fc911cadbc8e3346.png', 'http://static.cdn.cuci.com/df932df0a1b10c49/fc911cadbc8e3346.png', '10000', '2017-03-16 23:06:16');
INSERT INTO `system_file` VALUES ('182', 'local', '6e0aa2f2e3aa562f918005beed1c8037', '123.png', '918005beed1c8037.png', 'upload/6e0aa2f2e3aa562f/918005beed1c8037.png', '/home/wwwroot/think/trunk/public/upload/6e0aa2f2e3aa562f/918005beed1c8037.png', 'png', '170686.00', 'upload/6e0aa2f2e3aa562f/918005beed1c8037.png', 'https://think.ctolog.com/upload/6e0aa2f2e3aa562f/918005beed1c8037.png', '10000', '2017-03-17 09:10:05');
INSERT INTO `system_file` VALUES ('183', 'local', '19c7dff54c958a083197bfee0cede1f4', 'QQ截图20150828141959.png', '3197bfee0cede1f4.png', 'upload/19c7dff54c958a08/3197bfee0cede1f4.png', '/home/wwwroot/think/trunk/public/upload/19c7dff54c958a08/3197bfee0cede1f4.png', 'png', '193245.00', 'upload/19c7dff54c958a08/3197bfee0cede1f4.png', 'https://think.ctolog.com/upload/19c7dff54c958a08/3197bfee0cede1f4.png', '10000', '2017-03-17 09:10:24');
INSERT INTO `system_file` VALUES ('184', 'local', 'da1a5a82eb6f0cd4e73734ac9ac6d59f', 'id-card-photo.jpg', 'e73734ac9ac6d59f.jpg', 'upload/da1a5a82eb6f0cd4/e73734ac9ac6d59f.jpg', '/home/wwwroot/think/trunk/public/upload/da1a5a82eb6f0cd4/e73734ac9ac6d59f.jpg', 'jpg', '7281.00', 'upload/da1a5a82eb6f0cd4/e73734ac9ac6d59f.jpg', 'https://think.ctolog.com/upload/da1a5a82eb6f0cd4/e73734ac9ac6d59f.jpg', '10000', '2017-03-17 10:01:02');
INSERT INTO `system_file` VALUES ('185', 'local', 'df4ab23c747615db10a8f1ddd183b2a4', 'radio-01.png', '10a8f1ddd183b2a4.png', 'upload/df4ab23c747615db/10a8f1ddd183b2a4.png', '/home/wwwroot/think/trunk/public/upload/df4ab23c747615db/10a8f1ddd183b2a4.png', 'png', '207.00', 'upload/df4ab23c747615db/10a8f1ddd183b2a4.png', 'https://think.ctolog.com/upload/df4ab23c747615db/10a8f1ddd183b2a4.png', '10000', '2017-03-17 10:01:05');
INSERT INTO `system_file` VALUES ('186', 'qiniu', 'fafa5efeaf3cbe3b23b2748d13e629a1', 'Tulips.jpg', '23b2748d13e629a1.jpg', 'fafa5efeaf3cbe3b/23b2748d13e629a1.jpg', 'fafa5efeaf3cbe3b/23b2748d13e629a1.jpg', 'jpg', null, 'fafa5efeaf3cbe3b/23b2748d13e629a1.jpg', 'https://static.cdn.cuci.com/fafa5efeaf3cbe3b/23b2748d13e629a1.jpg', null, '2017-03-21 17:17:19');
INSERT INTO `system_file` VALUES ('187', 'qiniu', '2b04df3ecc1d94afddff082d139c6f15', 'Koala.jpg', 'ddff082d139c6f15.jpg', '2b04df3ecc1d94af/ddff082d139c6f15.jpg', '2b04df3ecc1d94af/ddff082d139c6f15.jpg', 'jpg', null, '2b04df3ecc1d94af/ddff082d139c6f15.jpg', 'https://static.cdn.cuci.com/2b04df3ecc1d94af/ddff082d139c6f15.jpg', null, '2017-03-21 17:17:39');
INSERT INTO `system_file` VALUES ('188', 'qiniu', 'f579d2e9dfe1940c5da85e7c7fef5ef6', 'QQ截图20170321171808.jpg', '5da85e7c7fef5ef6.jpg', 'f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', 'f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', 'jpg', null, 'f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', 'https://static.cdn.cuci.com/f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', null, '2017-03-21 17:18:16');
INSERT INTO `system_file` VALUES ('189', 'local', 'f579d2e9dfe1940c5da85e7c7fef5ef6', 'QQ截图20170321171808.jpg', '5da85e7c7fef5ef6.jpg', 'upload/f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', 'E:/www/tpadmin/public/upload/f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', 'jpg', '2183.00', 'upload/f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', 'http://localhost:801/tpadmin/public/upload/f579d2e9dfe1940c/5da85e7c7fef5ef6.jpg', '10000', '2017-03-21 17:18:53');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统操作日志表';

-- ----------------------------
-- Records of system_log
-- ----------------------------

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
  KEY `index_system_menu_node` (`node`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='系统菜单表';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES ('2', '0', '系统管理', '', '', '#', '', '_self', '1000', '1', '0', '2015-11-16 19:15:38');
INSERT INTO `system_menu` VALUES ('3', '4', '后台首页', '', 'fa fa-fw fa-tachometer', 'admin/index/main', '', '_self', '10', '1', '0', '2015-11-17 13:27:25');
INSERT INTO `system_menu` VALUES ('4', '2', '系统配置', '', '', '#', '', '_self', '100', '1', '0', '2016-03-14 18:12:55');
INSERT INTO `system_menu` VALUES ('5', '4', '网站参数', '', 'fa fa-apple', 'admin/config/index', '', '_self', '20', '1', '0', '2016-05-06 14:36:49');
INSERT INTO `system_menu` VALUES ('6', '4', '文件存储', '', 'fa fa-hdd-o', 'admin/config/file', '', '_self', '30', '1', '0', '2016-05-06 14:39:43');
INSERT INTO `system_menu` VALUES ('7', '4', '邮箱配置', '', 'fa fa-envelope', 'admin/config/mail', '', '_self', '40', '1', '0', '2016-05-12 16:24:21');
INSERT INTO `system_menu` VALUES ('8', '4', '短信配置', '', 'fa fa-envelope-square', 'admin/config/sms', '', '_self', '30', '1', '0', '2016-05-12 16:26:36');
INSERT INTO `system_menu` VALUES ('9', '20', '操作日志', '', '', 'admin/log/index', '', '_self', '1000', '1', '0', '2017-03-24 15:49:31');
INSERT INTO `system_menu` VALUES ('19', '20', '权限管理', '', 'fa fa-user-secret', 'admin/auth/index', '', '_self', '20', '1', '0', '2015-11-17 13:18:12');
INSERT INTO `system_menu` VALUES ('20', '2', '系统权限', '', '', '#', '', '_self', '200', '1', '0', '2016-03-14 18:11:41');
INSERT INTO `system_menu` VALUES ('21', '20', '系统菜单', '', 'glyphicon glyphicon-menu-hamburger', 'admin/menu/index', '', '_self', '10', '1', '0', '2015-11-16 19:16:16');
INSERT INTO `system_menu` VALUES ('22', '20', '节点管理', '', 'fa fa-ellipsis-v', 'admin/node/index', '', '_self', '30', '1', '0', '2015-11-16 19:16:16');
INSERT INTO `system_menu` VALUES ('29', '20', '系统用户', '', 'fa fa-users', 'admin/user/index', '', '_self', '40', '1', '0', '2016-10-31 14:31:40');
INSERT INTO `system_menu` VALUES ('50', '0', '插件管理', '', '', '#', '', '_self', '2000', '1', '0', '2017-02-22 16:44:14');
INSERT INTO `system_menu` VALUES ('51', '50', '我的店铺', '', 'fa fa-mixcloud', 'admin/index/main', '', '_self', '0', '1', '0', '2017-02-22 16:45:38');
INSERT INTO `system_menu` VALUES ('52', '50', '菜谱管理', '', 'fa fa-modx', 'admin/index/main', '', '_self', '0', '1', '0', '2017-03-07 15:28:32');
INSERT INTO `system_menu` VALUES ('57', '50', '订单管理', '', 'fa fa-product-hunt', 'admin/index/main', '', '_self', '0', '1', '0', '2017-03-15 17:04:06');
INSERT INTO `system_menu` VALUES ('58', '50', '优惠券管理', '', 'fa fa-percent', 'admin/index/main', '', '_self', '0', '1', '0', '2017-03-15 18:12:15');
INSERT INTO `system_menu` VALUES ('59', '50', '打印机管理', '', '', 'admin/index/main', '', '_self', '0', '1', '0', '2017-03-23 16:54:16');

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统节点表';

-- ----------------------------
-- Records of system_node
-- ----------------------------
INSERT INTO `system_node` VALUES ('3', 'admin', 's', '0', '1', '2017-03-10 15:31:29');
INSERT INTO `system_node` VALUES ('4', 'admin/menu/add', '添加菜单', '0', '0', '2017-03-10 15:32:21');
INSERT INTO `system_node` VALUES ('5', 'admin/config', '34', '0', '1', '2017-03-10 15:32:56');
INSERT INTO `system_node` VALUES ('6', 'admin/config/index', '系统主页', '0', '1', '2017-03-10 15:32:58');
INSERT INTO `system_node` VALUES ('7', 'admin/config/file', '文件配置', '0', '0', '2017-03-10 15:33:02');
INSERT INTO `system_node` VALUES ('8', 'admin/config/mail', '邮件配置', '0', '0', '2017-03-10 15:36:42');
INSERT INTO `system_node` VALUES ('9', 'admin/config/sms', '短信配置', '0', '0', '2017-03-10 15:36:43');
INSERT INTO `system_node` VALUES ('10', 'admin/menu/index', '菜单列表', '0', '0', '2017-03-10 15:36:50');
INSERT INTO `system_node` VALUES ('11', 'admin/node/index', '节点列表', '0', '0', '2017-03-10 15:36:59');
INSERT INTO `system_node` VALUES ('12', 'admin/node/save', '节点更新', '0', '0', '2017-03-10 15:36:59');
INSERT INTO `system_node` VALUES ('13', 'store/menu/index', '菜单列表', '1', '1', '2017-03-10 15:37:22');
INSERT INTO `system_node` VALUES ('14', 'store/menu/add', '添加菜单', '0', '1', '2017-03-10 15:37:23');
INSERT INTO `system_node` VALUES ('15', 'store/menu/edit', '编辑菜单', '0', '1', '2017-03-10 15:37:24');
INSERT INTO `system_node` VALUES ('16', 'store/menu/del', '删除菜单', '0', '1', '2017-03-10 15:37:24');
INSERT INTO `system_node` VALUES ('17', 'admin/index/index', '', '1', '1', '2017-03-10 15:39:23');
INSERT INTO `system_node` VALUES ('18', 'admin/index/main', '', '0', '1', '2017-03-14 16:21:54');
INSERT INTO `system_node` VALUES ('19', 'admin/index/pass', null, '0', '1', '2017-03-14 16:25:56');
INSERT INTO `system_node` VALUES ('20', 'admin/index/info', null, '0', '1', '2017-03-14 16:25:57');
INSERT INTO `system_node` VALUES ('21', 'store/menu/tagmove', '移动标签', '0', '1', '2017-03-14 17:07:12');
INSERT INTO `system_node` VALUES ('22', 'store/menu/tagedit', '编辑标签', '0', '1', '2017-03-14 17:07:13');
INSERT INTO `system_node` VALUES ('23', 'store/menu/tagdel', '删除标签', '0', '1', '2017-03-14 17:07:13');
INSERT INTO `system_node` VALUES ('24', 'store/menu/resume', '启用菜单', '0', '1', '2017-03-14 17:07:14');
INSERT INTO `system_node` VALUES ('25', 'store/menu/forbid', '禁用菜单', '0', '1', '2017-03-14 17:07:15');
INSERT INTO `system_node` VALUES ('26', 'store/menu/tagadd', '添加标签', '0', '1', '2017-03-14 17:07:15');
INSERT INTO `system_node` VALUES ('27', 'store/menu/hot', '设置热卖', '0', '1', '2017-03-14 17:07:18');
INSERT INTO `system_node` VALUES ('28', 'admin/index', '', '0', '1', '2017-03-14 17:27:00');
INSERT INTO `system_node` VALUES ('29', 'store/order/index', '订单列表', '1', '1', '2017-03-14 17:52:51');
INSERT INTO `system_node` VALUES ('30', 'store/index/qrcimg', '店铺二维码', '0', '1', '2017-03-14 17:52:52');
INSERT INTO `system_node` VALUES ('31', 'store/index/edit', '编辑店铺', '0', '1', '2017-03-14 17:52:55');
INSERT INTO `system_node` VALUES ('32', 'store/index/qrc', '二维码列表', '0', '1', '2017-03-14 17:52:56');
INSERT INTO `system_node` VALUES ('33', 'store/index/add', '添加店铺', '0', '1', '2017-03-14 17:52:56');
INSERT INTO `system_node` VALUES ('34', 'store/index/index', '我的店铺', '1', '1', '2017-03-14 17:52:57');
INSERT INTO `system_node` VALUES ('35', 'store/api/delcache', null, '0', '1', '2017-03-14 17:52:59');
INSERT INTO `system_node` VALUES ('36', 'store/api/getcache', null, '0', '1', '2017-03-14 17:53:00');
INSERT INTO `system_node` VALUES ('37', 'store/api/setcache', null, '0', '1', '2017-03-14 17:53:01');
INSERT INTO `system_node` VALUES ('38', 'store/api/response', null, '0', '1', '2017-03-14 17:53:01');
INSERT INTO `system_node` VALUES ('39', 'store/api/auth', null, '0', '1', '2017-03-14 17:53:02');
INSERT INTO `system_node` VALUES ('40', 'admin/user/resume', '启用用户', '0', '0', '2017-03-14 17:53:03');
INSERT INTO `system_node` VALUES ('41', 'admin/user/forbid', '禁用用户', '0', '0', '2017-03-14 17:53:03');
INSERT INTO `system_node` VALUES ('42', 'admin/user/del', '删除用户', '0', '0', '2017-03-14 17:53:04');
INSERT INTO `system_node` VALUES ('43', 'admin/user/pass', '修改密码', '0', '0', '2017-03-14 17:53:04');
INSERT INTO `system_node` VALUES ('44', 'admin/user/edit', '编辑用户', '0', '0', '2017-03-14 17:53:05');
INSERT INTO `system_node` VALUES ('45', 'admin/user/index', '用户列表', '0', '0', '2017-03-14 17:53:07');
INSERT INTO `system_node` VALUES ('46', 'admin/user/auth', '用户授权', '0', '0', '2017-03-14 17:53:08');
INSERT INTO `system_node` VALUES ('47', 'admin/user/add', '添加用户', '0', '0', '2017-03-14 17:53:09');
INSERT INTO `system_node` VALUES ('48', 'admin/plugs/icon', null, '0', '1', '2017-03-14 17:53:09');
INSERT INTO `system_node` VALUES ('49', 'admin/plugs/upload', null, '0', '1', '2017-03-14 17:53:10');
INSERT INTO `system_node` VALUES ('50', 'admin/plugs/upfile', null, '0', '1', '2017-03-14 17:53:11');
INSERT INTO `system_node` VALUES ('51', 'admin/plugs/upstate', null, '0', '1', '2017-03-14 17:53:11');
INSERT INTO `system_node` VALUES ('52', 'admin/menu/resume', '菜单启用', '1', '1', '2017-03-14 17:53:14');
INSERT INTO `system_node` VALUES ('53', 'admin/menu/forbid', '菜单禁用', '0', '0', '2017-03-14 17:53:15');
INSERT INTO `system_node` VALUES ('54', 'admin/login/index', null, '0', '1', '2017-03-14 17:53:17');
INSERT INTO `system_node` VALUES ('55', 'admin/login/out', '', '0', '1', '2017-03-14 17:53:18');
INSERT INTO `system_node` VALUES ('56', 'admin/menu/edit', '编辑菜单', '0', '0', '2017-03-14 17:53:20');
INSERT INTO `system_node` VALUES ('57', 'admin/menu/del', '菜单删除', '0', '0', '2017-03-14 17:53:21');
INSERT INTO `system_node` VALUES ('58', 'store/menu', '菜谱管理', '0', '1', '2017-03-14 17:57:47');
INSERT INTO `system_node` VALUES ('59', 'store/index', '店铺管理', '0', '1', '2017-03-14 17:58:28');
INSERT INTO `system_node` VALUES ('60', 'store', '店铺管理', '0', '1', '2017-03-14 17:58:29');
INSERT INTO `system_node` VALUES ('61', 'store/order', '订单管理', '0', '1', '2017-03-14 17:58:56');
INSERT INTO `system_node` VALUES ('62', 'admin/user', '用户管理', '0', '1', '2017-03-14 17:59:39');
INSERT INTO `system_node` VALUES ('63', 'admin/node', '节点管理', '0', '1', '2017-03-14 17:59:53');
INSERT INTO `system_node` VALUES ('64', 'admin/menu', '菜单管理1', '0', '1', '2017-03-14 18:00:31');
INSERT INTO `system_node` VALUES ('65', 'admin/auth', '权限管理', '0', '1', '2017-03-17 14:37:05');
INSERT INTO `system_node` VALUES ('66', 'admin/auth/index', '权', '0', '1', '2017-03-17 14:37:14');
INSERT INTO `system_node` VALUES ('67', 'admin/auth/apply', '节点', '0', '1', '2017-03-17 14:37:29');
INSERT INTO `system_node` VALUES ('68', 'admin/auth/add', '添加权限', '0', '1', '2017-03-17 14:37:32');
INSERT INTO `system_node` VALUES ('69', 'admin/auth/edit', '编辑权限', '0', '0', '2017-03-17 14:37:36');
INSERT INTO `system_node` VALUES ('70', 'admin/auth/forbid', '禁用权限fff', '0', '0', '2017-03-17 14:37:38');
INSERT INTO `system_node` VALUES ('71', 'admin/auth/resume', 'm', '0', '0', '2017-03-17 14:37:41');
INSERT INTO `system_node` VALUES ('72', 'admin/auth/del', '删除权限1', '0', '0', '2017-03-17 14:37:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=10041 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES ('10000', 'admin', '21232f297a57a5a743894a0e4a801fc3', '22222222', 'zoujingli@cuci.ccc', '13617343801', '444444', '3666', '2017-03-24 17:54:34', '1', '98,102,103,104', '0', null, '2015-11-13 15:14:22');
INSERT INTO `system_user` VALUES ('10010', 'test', '', null, '', '13687227657', '', '0', null, '1', '71,72', '1', null, '2017-03-15 14:57:22');
INSERT INTO `system_user` VALUES ('10011', 'test1', '', null, '', '', '', '0', null, '1', null, '1', null, '2017-03-15 22:42:38');
INSERT INTO `system_user` VALUES ('10012', '你好', '', null, 'eqomnc@q.com', '13738152615', '', '0', null, '1', '72', '1', null, '2017-03-16 10:19:34');
INSERT INTO `system_user` VALUES ('10013', '个636', '', null, '841115691@qq.com', '18875948598', '浮动个', '0', null, '1', '72,73,74,75,77', '1', null, '2017-03-16 11:46:00');
INSERT INTO `system_user` VALUES ('10014', '31212312123', '', null, '', '', '', '0', null, '1', null, '1', null, '2017-03-16 14:42:09');
INSERT INTO `system_user` VALUES ('10015', 'uzi', '4297f44b13955235245b2497399d7a93', null, '', '', '', '0', null, '1', '79', '1', null, '2017-03-16 16:04:08');
INSERT INTO `system_user` VALUES ('10016', 'uzii', '4297f44b13955235245b2497399d7a93', null, '', '', '', '1', '2017-03-16 16:10:38', '1', '79', '1', null, '2017-03-16 16:09:52');
INSERT INTO `system_user` VALUES ('10017', 'aaa', 'e10adc3949ba59abbe56e057f20f883e', null, '', '18866666666', '111', '0', null, '1', '78', '1', null, '2017-03-17 11:14:30');
INSERT INTO `system_user` VALUES ('10018', 'anyon', '21232f297a57a5a743894a0e4a801fc3', null, '', '', '', '8', '2017-03-17 15:33:20', '1', '81', '1', null, '2017-03-17 14:20:14');
INSERT INTO `system_user` VALUES ('10019', 'flsdfkj', '', null, '', '', '', '0', null, '0', '84', '1', null, '2017-03-17 17:46:12');
INSERT INTO `system_user` VALUES ('10020', '11', '', null, '111@qq.com', '15021975678', '', '0', null, '1', null, '1', null, '2017-03-18 22:22:28');
INSERT INTO `system_user` VALUES ('10021', 'test001', '', null, '', '13712312312', '', '0', null, '1', null, '1', null, '2017-03-20 11:16:35');
INSERT INTO `system_user` VALUES ('10022', 'tt', '', null, '3333@qq.com', '15021975913', 'dfdf', '0', null, '0', null, '1', null, '2017-03-20 15:36:12');
INSERT INTO `system_user` VALUES ('10023', '112', '', null, '3333@qq.com', '15021975914', 'dfdf', '0', null, '1', null, '1', null, '2017-03-20 17:20:23');
INSERT INTO `system_user` VALUES ('10024', '1122', '', null, '3333@qq.com', '15021975913', '11', '0', null, '1', null, '1', null, '2017-03-20 17:21:24');
INSERT INTO `system_user` VALUES ('10025', '33', '', null, '3333@qq.com', '15021975913', '333', '0', null, '1', null, '1', null, '2017-03-20 17:21:37');
INSERT INTO `system_user` VALUES ('10026', 'test1112313', '', null, '', '18987676656', '特讨厌', '0', null, '1', '86,89', '1', null, '2017-03-21 09:44:05');
INSERT INTO `system_user` VALUES ('10027', 'aaasdfsdf', '', null, '', '', 'sf', '0', null, '1', '84', '1', null, '2017-03-21 10:36:52');
INSERT INTO `system_user` VALUES ('10028', '20256811', 'e10adc3949ba59abbe56e057f20f883e', null, '', '18829025582', '', '1', '2017-03-21 14:33:29', '1', '94,95', '1', null, '2017-03-21 14:32:41');
INSERT INTO `system_user` VALUES ('10029', '351402401', 'e10adc3949ba59abbe56e057f20f883e', null, '', '', '351402401', '1', '2017-03-21 17:16:46', '1', '94', '1', null, '2017-03-21 17:15:13');
INSERT INTO `system_user` VALUES ('10030', '测试', '', null, '', '', '', '0', null, '1', null, '1', null, '2017-03-21 17:23:02');
INSERT INTO `system_user` VALUES ('10031', '1312', '', null, '1123@ad.adf', '15423232345', '123123', '0', null, '1', '93', '1', null, '2017-03-22 10:12:12');
INSERT INTO `system_user` VALUES ('10032', '111', '', null, '', '13899665566', '', '0', null, '1', null, '1', null, '2017-03-22 12:58:23');
INSERT INTO `system_user` VALUES ('10033', 'weiwie', '', null, '1234567@qq.com', '18308463002', 'wu ', '0', null, '1', '94,95', '1', null, '2017-03-23 14:23:19');
INSERT INTO `system_user` VALUES ('10034', '123123', '', null, '123@qq.com', '14012311231', 'asd', '0', null, '1', '94,95', '1', null, '2017-03-23 15:19:56');
INSERT INTO `system_user` VALUES ('10035', 'gzx', '', null, 'gxx@163.com', '13826429302', 'ds', '0', null, '0', '95,96,97', '1', null, '2017-03-23 16:37:56');
INSERT INTO `system_user` VALUES ('10036', 'gxy', '', null, 'fs@ss.com', '13826429303', '', '0', null, '0', '95,96,97', '1', null, '2017-03-23 16:43:42');
INSERT INTO `system_user` VALUES ('10037', 'dd', '', null, 'dds@ss.com', '13826429303', '', '0', null, '1', '94,95', '1', null, '2017-03-23 16:55:29');
INSERT INTO `system_user` VALUES ('10038', 'fsee', '', null, '556@dd.com', '13719205474', '', '0', null, '1', '94', '1', null, '2017-03-23 17:02:13');
INSERT INTO `system_user` VALUES ('10039', 'test123', 'e10adc3949ba59abbe56e057f20f883e', null, '', '', '', '2', '2017-03-24 11:51:29', '1', '98', '1', null, '2017-03-24 11:44:53');
INSERT INTO `system_user` VALUES ('10040', 'sdf', '', null, '1732702632@qq.com', '18336967516', 'adfsf ', '0', null, '1', '98', '1', null, '2017-03-24 15:44:56');
