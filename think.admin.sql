/*
Navicat MySQL Data Transfer

Source Server         : think.ctolog.com_3306
Source Server Version : 50629
Source Host           : think.ctolog.com:3306
Source Database       : think.admin

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2017-07-07 18:28:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for data_region
-- ----------------------------
DROP TABLE IF EXISTS `data_region`;
CREATE TABLE `data_region` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(6) NOT NULL COMMENT '区域代码',
  `name` varchar(20) DEFAULT '' COMMENT '区域名称',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(1启用,0禁用)',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT '排序权重',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_data_region_code` (`code`) USING BTREE,
  KEY `index_data_region_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='基础数据-区域位置';

-- ----------------------------
-- Records of data_region
-- ----------------------------
INSERT INTO `data_region` VALUES ('1', '110000', '北京市', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('2', '110101', '东城区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('3', '110102', '西城区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('4', '110105', '朝阳区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('5', '110106', '丰台区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('6', '110107', '石景山区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('7', '110108', '海淀区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('8', '110109', '门头沟区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('9', '110111', '房山区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('10', '110112', '通州区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('11', '110113', '顺义区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('12', '110114', '昌平区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('13', '110115', '大兴区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('14', '110116', '怀柔区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('15', '110117', '平谷区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('16', '110118', '密云区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('17', '110119', '延庆区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('18', '120000', '天津市', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('19', '120101', '和平区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('20', '120102', '河东区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('21', '120103', '河西区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('22', '120104', '南开区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('23', '120105', '河北区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('24', '120106', '红桥区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('25', '120110', '东丽区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('26', '120111', '西青区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('27', '120112', '津南区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('28', '120113', '北辰区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('29', '120114', '武清区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('30', '120115', '宝坻区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('31', '120116', '滨海新区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('32', '120117', '宁河区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('33', '120118', '静海区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('34', '120119', '蓟州区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('35', '130000', '河北省', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('36', '130100', '石家庄市', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('37', '130102', '长安区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('38', '130104', '桥西区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('39', '130105', '新华区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('40', '130107', '井陉矿区', '1', '0', '2017-07-07 18:02:39');
INSERT INTO `data_region` VALUES ('41', '130108', '裕华区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('42', '130109', '藁城区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('43', '130110', '鹿泉区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('44', '130111', '栾城区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('45', '130121', '井陉县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('46', '130123', '正定县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('47', '130125', '行唐县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('48', '130126', '灵寿县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('49', '130127', '高邑县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('50', '130128', '深泽县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('51', '130129', '赞皇县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('52', '130130', '无极县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('53', '130131', '平山县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('54', '130132', '元氏县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('55', '130133', '赵县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('56', '130181', '辛集市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('57', '130183', '晋州市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('58', '130184', '新乐市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('59', '130200', '唐山市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('60', '130202', '路南区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('61', '130203', '路北区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('62', '130204', '古冶区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('63', '130205', '开平区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('64', '130207', '丰南区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('65', '130208', '丰润区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('66', '130209', '曹妃甸区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('67', '130223', '滦县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('68', '130224', '滦南县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('69', '130225', '乐亭县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('70', '130227', '迁西县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('71', '130229', '玉田县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('72', '130281', '遵化市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('73', '130283', '迁安市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('74', '130300', '秦皇岛市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('75', '130302', '海港区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('76', '130303', '山海关区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('77', '130304', '北戴河区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('78', '130306', '抚宁区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('79', '130321', '青龙满族自治县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('80', '130322', '昌黎县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('81', '130324', '卢龙县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('82', '130400', '邯郸市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('83', '130402', '邯山区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('84', '130403', '丛台区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('85', '130404', '复兴区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('86', '130406', '峰峰矿区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('87', '130407', '肥乡区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('88', '130408', '永年区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('89', '130423', '临漳县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('90', '130424', '成安县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('91', '130425', '大名县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('92', '130426', '涉县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('93', '130427', '磁县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('94', '130430', '邱县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('95', '130431', '鸡泽县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('96', '130432', '广平县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('97', '130433', '馆陶县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('98', '130434', '魏县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('99', '130435', '曲周县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('100', '130481', '武安市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('101', '130500', '邢台市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('102', '130502', '桥东区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('103', '130503', '桥西区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('104', '130521', '邢台县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('105', '130522', '临城县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('106', '130523', '内丘县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('107', '130524', '柏乡县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('108', '130525', '隆尧县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('109', '130526', '任县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('110', '130527', '南和县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('111', '130528', '宁晋县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('112', '130529', '巨鹿县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('113', '130530', '新河县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('114', '130531', '广宗县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('115', '130532', '平乡县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('116', '130533', '威县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('117', '130534', '清河县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('118', '130535', '临西县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('119', '130581', '南宫市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('120', '130582', '沙河市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('121', '130600', '保定市', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('122', '130602', '竞秀区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('123', '130604', '南市区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('124', '130606', '莲池区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('125', '130607', '满城区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('126', '130608', '清苑区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('127', '130609', '徐水区', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('128', '130623', '涞水县', '1', '0', '2017-07-07 18:02:40');
INSERT INTO `data_region` VALUES ('129', '130624', '阜平县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('130', '130626', '定兴县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('131', '130627', '唐县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('132', '130628', '高阳县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('133', '130629', '容城县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('134', '130630', '涞源县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('135', '130631', '望都县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('136', '130632', '安新县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('137', '130633', '易县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('138', '130634', '曲阳县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('139', '130635', '蠡县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('140', '130636', '顺平县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('141', '130637', '博野县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('142', '130638', '雄县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('143', '130681', '涿州市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('144', '130682', '定州市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('145', '130683', '安国市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('146', '130684', '高碑店市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('147', '130700', '张家口市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('148', '130702', '桥东区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('149', '130703', '桥西区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('150', '130705', '宣化区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('151', '130706', '下花园区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('152', '130708', '万全区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('153', '130709', '崇礼区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('154', '130722', '张北县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('155', '130723', '康保县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('156', '130724', '沽源县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('157', '130725', '尚义县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('158', '130726', '蔚县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('159', '130727', '阳原县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('160', '130728', '怀安县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('161', '130730', '怀来县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('162', '130731', '涿鹿县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('163', '130732', '赤城县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('164', '130800', '承德市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('165', '130802', '双桥区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('166', '130803', '双滦区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('167', '130804', '鹰手营子矿区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('168', '130821', '承德县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('169', '130822', '兴隆县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('170', '130823', '平泉市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('171', '130824', '滦平县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('172', '130825', '隆化县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('173', '130826', '丰宁满族自治县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('174', '130827', '宽城满族自治县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('175', '130828', '围场满族蒙古族自治县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('176', '130900', '沧州市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('177', '130902', '新华区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('178', '130903', '运河区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('179', '130921', '沧县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('180', '130922', '青县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('181', '130923', '东光县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('182', '130924', '海兴县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('183', '130925', '盐山县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('184', '130926', '肃宁县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('185', '130927', '南皮县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('186', '130928', '吴桥县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('187', '130929', '献县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('188', '130930', '孟村回族自治县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('189', '130981', '泊头市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('190', '130982', '任丘市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('191', '130983', '黄骅市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('192', '130984', '河间市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('193', '131000', '廊坊市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('194', '131002', '安次区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('195', '131003', '广阳区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('196', '131022', '固安县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('197', '131023', '永清县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('198', '131024', '香河县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('199', '131025', '大城县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('200', '131026', '文安县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('201', '131028', '大厂回族自治县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('202', '131081', '霸州市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('203', '131082', '三河市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('204', '131100', '衡水市', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('205', '131102', '桃城区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('206', '131103', '冀州区', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('207', '131121', '枣强县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('208', '131122', '武邑县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('209', '131123', '武强县', '1', '0', '2017-07-07 18:02:41');
INSERT INTO `data_region` VALUES ('210', '131124', '饶阳县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('211', '131125', '安平县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('212', '131126', '故城县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('213', '131127', '景县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('214', '131128', '阜城县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('215', '131182', '深州市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('216', '140000', '山西省', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('217', '140100', '太原市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('218', '140105', '小店区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('219', '140106', '迎泽区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('220', '140107', '杏花岭区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('221', '140108', '尖草坪区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('222', '140109', '万柏林区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('223', '140110', '晋源区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('224', '140121', '清徐县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('225', '140122', '阳曲县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('226', '140123', '娄烦县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('227', '140181', '古交市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('228', '140200', '大同市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('229', '140202', '城区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('230', '140203', '矿区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('231', '140211', '南郊区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('232', '140212', '新荣区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('233', '140221', '阳高县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('234', '140222', '天镇县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('235', '140223', '广灵县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('236', '140224', '灵丘县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('237', '140225', '浑源县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('238', '140226', '左云县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('239', '140227', '大同县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('240', '140300', '阳泉市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('241', '140302', '城区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('242', '140303', '矿区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('243', '140311', '郊区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('244', '140321', '平定县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('245', '140322', '盂县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('246', '140400', '长治市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('247', '140402', '城区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('248', '140411', '郊区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('249', '140421', '长治县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('250', '140423', '襄垣县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('251', '140424', '屯留县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('252', '140425', '平顺县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('253', '140426', '黎城县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('254', '140427', '壶关县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('255', '140428', '长子县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('256', '140429', '武乡县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('257', '140430', '沁县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('258', '140431', '沁源县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('259', '140481', '潞城市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('260', '140500', '晋城市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('261', '140502', '城区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('262', '140521', '沁水县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('263', '140522', '阳城县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('264', '140524', '陵川县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('265', '140525', '泽州县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('266', '140581', '高平市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('267', '140600', '朔州市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('268', '140602', '朔城区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('269', '140603', '平鲁区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('270', '140621', '山阴县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('271', '140622', '应县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('272', '140623', '右玉县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('273', '140624', '怀仁县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('274', '140700', '晋中市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('275', '140702', '榆次区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('276', '140721', '榆社县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('277', '140722', '左权县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('278', '140723', '和顺县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('279', '140724', '昔阳县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('280', '140725', '寿阳县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('281', '140726', '太谷县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('282', '140727', '祁县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('283', '140728', '平遥县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('284', '140729', '灵石县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('285', '140781', '介休市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('286', '140800', '运城市', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('287', '140802', '盐湖区', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('288', '140821', '临猗县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('289', '140822', '万荣县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('290', '140823', '闻喜县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('291', '140824', '稷山县', '1', '0', '2017-07-07 18:02:42');
INSERT INTO `data_region` VALUES ('292', '140825', '新绛县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('293', '140826', '绛县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('294', '140827', '垣曲县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('295', '140828', '夏县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('296', '140829', '平陆县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('297', '140830', '芮城县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('298', '140881', '永济市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('299', '140882', '河津市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('300', '140900', '忻州市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('301', '140902', '忻府区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('302', '140921', '定襄县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('303', '140922', '五台县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('304', '140923', '代县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('305', '140924', '繁峙县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('306', '140925', '宁武县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('307', '140926', '静乐县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('308', '140927', '神池县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('309', '140928', '五寨县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('310', '140929', '岢岚县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('311', '140930', '河曲县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('312', '140931', '保德县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('313', '140932', '偏关县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('314', '140981', '原平市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('315', '141000', '临汾市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('316', '141002', '尧都区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('317', '141021', '曲沃县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('318', '141022', '翼城县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('319', '141023', '襄汾县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('320', '141024', '洪洞县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('321', '141025', '古县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('322', '141026', '安泽县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('323', '141027', '浮山县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('324', '141028', '吉县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('325', '141029', '乡宁县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('326', '141030', '大宁县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('327', '141031', '隰县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('328', '141032', '永和县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('329', '141033', '蒲县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('330', '141034', '汾西县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('331', '141081', '侯马市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('332', '141082', '霍州市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('333', '141100', '吕梁市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('334', '141102', '离石区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('335', '141121', '文水县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('336', '141122', '交城县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('337', '141123', '兴县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('338', '141124', '临县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('339', '141125', '柳林县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('340', '141126', '石楼县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('341', '141127', '岚县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('342', '141128', '方山县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('343', '141129', '中阳县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('344', '141130', '交口县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('345', '141181', '孝义市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('346', '141182', '汾阳市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('347', '150000', '内蒙古自治区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('348', '150100', '呼和浩特市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('349', '150102', '新城区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('350', '150103', '回民区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('351', '150104', '玉泉区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('352', '150105', '赛罕区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('353', '150121', '土默特左旗', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('354', '150122', '托克托县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('355', '150123', '和林格尔县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('356', '150124', '清水河县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('357', '150125', '武川县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('358', '150200', '包头市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('359', '150202', '东河区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('360', '150203', '昆都仑区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('361', '150204', '青山区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('362', '150205', '石拐区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('363', '150206', '白云鄂博矿区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('364', '150207', '九原区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('365', '150221', '土默特右旗', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('366', '150222', '固阳县', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('367', '150223', '达尔罕茂明安联合旗', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('368', '150300', '乌海市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('369', '150302', '海勃湾区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('370', '150303', '海南区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('371', '150304', '乌达区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('372', '150400', '赤峰市', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('373', '150402', '红山区', '1', '0', '2017-07-07 18:02:43');
INSERT INTO `data_region` VALUES ('374', '150403', '元宝山区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('375', '150404', '松山区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('376', '150421', '阿鲁科尔沁旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('377', '150422', '巴林左旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('378', '150423', '巴林右旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('379', '150424', '林西县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('380', '150425', '克什克腾旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('381', '150426', '翁牛特旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('382', '150428', '喀喇沁旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('383', '150429', '宁城县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('384', '150430', '敖汉旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('385', '150500', '通辽市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('386', '150502', '科尔沁区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('387', '150521', '科尔沁左翼中旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('388', '150522', '科尔沁左翼后旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('389', '150523', '开鲁县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('390', '150524', '库伦旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('391', '150525', '奈曼旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('392', '150526', '扎鲁特旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('393', '150581', '霍林郭勒市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('394', '150600', '鄂尔多斯市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('395', '150602', '东胜区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('396', '150603', '康巴什区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('397', '150621', '达拉特旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('398', '150622', '准格尔旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('399', '150623', '鄂托克前旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('400', '150624', '鄂托克旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('401', '150625', '杭锦旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('402', '150626', '乌审旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('403', '150627', '伊金霍洛旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('404', '150700', '呼伦贝尔市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('405', '150702', '海拉尔区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('406', '150703', '扎赉诺尔区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('407', '150721', '阿荣旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('408', '150722', '莫力达瓦达斡尔族自治旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('409', '150723', '鄂伦春自治旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('410', '150724', '鄂温克族自治旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('411', '150725', '陈巴尔虎旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('412', '150726', '新巴尔虎左旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('413', '150727', '新巴尔虎右旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('414', '150781', '满洲里市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('415', '150782', '牙克石市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('416', '150783', '扎兰屯市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('417', '150784', '额尔古纳市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('418', '150785', '根河市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('419', '150800', '巴彦淖尔市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('420', '150802', '临河区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('421', '150821', '五原县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('422', '150822', '磴口县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('423', '150823', '乌拉特前旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('424', '150824', '乌拉特中旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('425', '150825', '乌拉特后旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('426', '150826', '杭锦后旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('427', '150900', '乌兰察布市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('428', '150902', '集宁区', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('429', '150921', '卓资县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('430', '150922', '化德县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('431', '150923', '商都县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('432', '150924', '兴和县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('433', '150925', '凉城县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('434', '150926', '察哈尔右翼前旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('435', '150927', '察哈尔右翼中旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('436', '150928', '察哈尔右翼后旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('437', '150929', '四子王旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('438', '150981', '丰镇市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('439', '152200', '兴安盟', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('440', '152201', '乌兰浩特市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('441', '152202', '阿尔山市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('442', '152221', '科尔沁右翼前旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('443', '152222', '科尔沁右翼中旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('444', '152223', '扎赉特旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('445', '152224', '突泉县', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('446', '152500', '锡林郭勒盟', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('447', '152501', '二连浩特市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('448', '152502', '锡林浩特市', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('449', '152522', '阿巴嘎旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('450', '152523', '苏尼特左旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('451', '152524', '苏尼特右旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('452', '152525', '东乌珠穆沁旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('453', '152526', '西乌珠穆沁旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('454', '152527', '太仆寺旗', '1', '0', '2017-07-07 18:02:44');
INSERT INTO `data_region` VALUES ('455', '152528', '镶黄旗', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('456', '152529', '正镶白旗', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('457', '152530', '正蓝旗', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('458', '152531', '多伦县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('459', '152900', '阿拉善盟', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('460', '152921', '阿拉善左旗', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('461', '152922', '阿拉善右旗', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('462', '152923', '额济纳旗', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('463', '210000', '辽宁省', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('464', '210100', '沈阳市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('465', '210102', '和平区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('466', '210103', '沈河区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('467', '210104', '大东区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('468', '210105', '皇姑区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('469', '210106', '铁西区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('470', '210111', '苏家屯区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('471', '210112', '浑南区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('472', '210113', '沈北新区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('473', '210114', '于洪区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('474', '210115', '辽中区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('475', '210123', '康平县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('476', '210124', '法库县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('477', '210181', '新民市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('478', '210200', '大连市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('479', '210202', '中山区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('480', '210203', '西岗区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('481', '210204', '沙河口区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('482', '210211', '甘井子区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('483', '210212', '旅顺口区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('484', '210213', '金州区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('485', '210224', '长海县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('486', '210281', '瓦房店市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('487', '210214', '普兰店区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('488', '210283', '庄河市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('489', '210300', '鞍山市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('490', '210302', '铁东区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('491', '210303', '铁西区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('492', '210304', '立山区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('493', '210311', '千山区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('494', '210321', '台安县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('495', '210323', '岫岩满族自治县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('496', '210381', '海城市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('497', '210400', '抚顺市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('498', '210402', '新抚区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('499', '210403', '东洲区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('500', '210404', '望花区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('501', '210411', '顺城区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('502', '210421', '抚顺县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('503', '210422', '新宾满族自治县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('504', '210423', '清原满族自治县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('505', '210500', '本溪市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('506', '210502', '平山区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('507', '210503', '溪湖区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('508', '210504', '明山区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('509', '210505', '南芬区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('510', '210521', '本溪满族自治县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('511', '210522', '桓仁满族自治县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('512', '210600', '丹东市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('513', '210602', '元宝区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('514', '210603', '振兴区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('515', '210604', '振安区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('516', '210624', '宽甸满族自治县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('517', '210681', '东港市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('518', '210682', '凤城市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('519', '210700', '锦州市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('520', '210702', '古塔区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('521', '210703', '凌河区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('522', '210711', '太和区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('523', '210726', '黑山县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('524', '210727', '义县', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('525', '210781', '凌海市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('526', '210782', '北镇市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('527', '210800', '营口市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('528', '210802', '站前区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('529', '210803', '西市区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('530', '210804', '鲅鱼圈区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('531', '210811', '老边区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('532', '210881', '盖州市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('533', '210882', '大石桥市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('534', '210900', '阜新市', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('535', '210902', '海州区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('536', '210903', '新邱区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('537', '210904', '太平区', '1', '0', '2017-07-07 18:02:45');
INSERT INTO `data_region` VALUES ('538', '210905', '清河门区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('539', '210911', '细河区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('540', '210921', '阜新蒙古族自治县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('541', '210922', '彰武县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('542', '211000', '辽阳市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('543', '211002', '白塔区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('544', '211003', '文圣区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('545', '211004', '宏伟区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('546', '211005', '弓长岭区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('547', '211011', '太子河区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('548', '211021', '辽阳县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('549', '211081', '灯塔市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('550', '211100', '盘锦市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('551', '211102', '双台子区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('552', '211103', '兴隆台区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('553', '211104', '大洼区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('554', '211122', '盘山县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('555', '211200', '铁岭市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('556', '211202', '银州区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('557', '211204', '清河区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('558', '211221', '铁岭县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('559', '211223', '西丰县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('560', '211224', '昌图县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('561', '211281', '调兵山市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('562', '211282', '开原市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('563', '211300', '朝阳市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('564', '211302', '双塔区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('565', '211303', '龙城区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('566', '211321', '朝阳县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('567', '211322', '建平县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('568', '211324', '喀喇沁左翼蒙古族自治县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('569', '211381', '北票市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('570', '211382', '凌源市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('571', '211400', '葫芦岛市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('572', '211402', '连山区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('573', '211403', '龙港区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('574', '211404', '南票区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('575', '211421', '绥中县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('576', '211422', '建昌县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('577', '211481', '兴城市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('578', '220000', '吉林省', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('579', '220100', '长春市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('580', '220102', '南关区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('581', '220103', '宽城区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('582', '220104', '朝阳区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('583', '220105', '二道区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('584', '220106', '绿园区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('585', '220112', '双阳区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('586', '220113', '九台区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('587', '220122', '农安县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('588', '220182', '榆树市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('589', '220183', '德惠市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('590', '220200', '吉林市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('591', '220202', '昌邑区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('592', '220203', '龙潭区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('593', '220204', '船营区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('594', '220211', '丰满区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('595', '220221', '永吉县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('596', '220281', '蛟河市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('597', '220282', '桦甸市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('598', '220283', '舒兰市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('599', '220284', '磐石市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('600', '220300', '四平市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('601', '220302', '铁西区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('602', '220303', '铁东区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('603', '220322', '梨树县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('604', '220323', '伊通满族自治县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('605', '220381', '公主岭市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('606', '220382', '双辽市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('607', '220400', '辽源市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('608', '220402', '龙山区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('609', '220403', '西安区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('610', '220421', '东丰县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('611', '220422', '东辽县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('612', '220500', '通化市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('613', '220502', '东昌区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('614', '220503', '二道江区', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('615', '220521', '通化县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('616', '220523', '辉南县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('617', '220524', '柳河县', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('618', '220581', '梅河口市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('619', '220582', '集安市', '1', '0', '2017-07-07 18:02:46');
INSERT INTO `data_region` VALUES ('620', '220600', '白山市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('621', '220602', '浑江区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('622', '220605', '江源区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('623', '220621', '抚松县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('624', '220622', '靖宇县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('625', '220623', '长白朝鲜族自治县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('626', '220681', '临江市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('627', '220700', '松原市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('628', '220702', '宁江区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('629', '220721', '前郭尔罗斯蒙古族自治县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('630', '220722', '长岭县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('631', '220723', '乾安县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('632', '220781', '扶余市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('633', '220800', '白城市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('634', '220802', '洮北区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('635', '220821', '镇赉县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('636', '220822', '通榆县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('637', '220881', '洮南市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('638', '220882', '大安市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('639', '222400', '延边朝鲜族自治州', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('640', '222401', '延吉市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('641', '222402', '图们市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('642', '222403', '敦化市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('643', '222404', '珲春市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('644', '222405', '龙井市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('645', '222406', '和龙市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('646', '222424', '汪清县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('647', '222426', '安图县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('648', '230000', '黑龙江省', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('649', '230100', '哈尔滨市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('650', '230102', '道里区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('651', '230103', '南岗区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('652', '230104', '道外区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('653', '230108', '平房区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('654', '230109', '松北区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('655', '230110', '香坊区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('656', '230111', '呼兰区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('657', '230112', '阿城区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('658', '230113', '双城区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('659', '230123', '依兰县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('660', '230124', '方正县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('661', '230125', '宾县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('662', '230126', '巴彦县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('663', '230127', '木兰县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('664', '230128', '通河县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('665', '230129', '延寿县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('666', '230183', '尚志市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('667', '230184', '五常市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('668', '230200', '齐齐哈尔市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('669', '230202', '龙沙区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('670', '230203', '建华区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('671', '230204', '铁锋区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('672', '230205', '昂昂溪区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('673', '230206', '富拉尔基区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('674', '230207', '碾子山区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('675', '230208', '梅里斯达斡尔族区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('676', '230221', '龙江县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('677', '230223', '依安县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('678', '230224', '泰来县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('679', '230225', '甘南县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('680', '230227', '富裕县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('681', '230229', '克山县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('682', '230230', '克东县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('683', '230231', '拜泉县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('684', '230281', '讷河市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('685', '230300', '鸡西市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('686', '230302', '鸡冠区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('687', '230303', '恒山区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('688', '230304', '滴道区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('689', '230305', '梨树区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('690', '230306', '城子河区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('691', '230307', '麻山区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('692', '230321', '鸡东县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('693', '230381', '虎林市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('694', '230382', '密山市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('695', '230400', '鹤岗市', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('696', '230402', '向阳区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('697', '230403', '工农区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('698', '230404', '南山区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('699', '230405', '兴安区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('700', '230406', '东山区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('701', '230407', '兴山区', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('702', '230421', '萝北县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('703', '230422', '绥滨县', '1', '0', '2017-07-07 18:02:47');
INSERT INTO `data_region` VALUES ('704', '230500', '双鸭山市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('705', '230502', '尖山区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('706', '230503', '岭东区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('707', '230505', '四方台区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('708', '230506', '宝山区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('709', '230521', '集贤县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('710', '230522', '友谊县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('711', '230523', '宝清县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('712', '230524', '饶河县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('713', '230600', '大庆市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('714', '230602', '萨尔图区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('715', '230603', '龙凤区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('716', '230604', '让胡路区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('717', '230605', '红岗区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('718', '230606', '大同区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('719', '230621', '肇州县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('720', '230622', '肇源县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('721', '230623', '林甸县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('722', '230624', '杜尔伯特蒙古族自治县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('723', '230700', '伊春市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('724', '230702', '伊春区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('725', '230703', '南岔区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('726', '230704', '友好区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('727', '230705', '西林区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('728', '230706', '翠峦区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('729', '230707', '新青区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('730', '230708', '美溪区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('731', '230709', '金山屯区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('732', '230710', '五营区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('733', '230711', '乌马河区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('734', '230712', '汤旺河区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('735', '230713', '带岭区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('736', '230714', '乌伊岭区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('737', '230715', '红星区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('738', '230716', '上甘岭区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('739', '230722', '嘉荫县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('740', '230781', '铁力市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('741', '230800', '佳木斯市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('742', '230803', '向阳区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('743', '230804', '前进区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('744', '230805', '东风区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('745', '230811', '郊区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('746', '230822', '桦南县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('747', '230826', '桦川县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('748', '230828', '汤原县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('749', '230881', '同江市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('750', '230882', '富锦市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('751', '230883', '抚远市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('752', '230900', '七台河市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('753', '230902', '新兴区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('754', '230903', '桃山区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('755', '230904', '茄子河区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('756', '230921', '勃利县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('757', '231000', '牡丹江市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('758', '231002', '东安区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('759', '231003', '阳明区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('760', '231004', '爱民区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('761', '231005', '西安区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('762', '231025', '林口县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('763', '231081', '绥芬河市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('764', '231083', '海林市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('765', '231084', '宁安市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('766', '231085', '穆棱市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('767', '231086', '东宁市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('768', '231100', '黑河市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('769', '231102', '爱辉区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('770', '231121', '嫩江县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('771', '231123', '逊克县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('772', '231124', '孙吴县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('773', '231181', '北安市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('774', '231182', '五大连池市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('775', '231200', '绥化市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('776', '231202', '北林区', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('777', '231221', '望奎县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('778', '231222', '兰西县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('779', '231223', '青冈县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('780', '231224', '庆安县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('781', '231225', '明水县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('782', '231226', '绥棱县', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('783', '231281', '安达市', '1', '0', '2017-07-07 18:02:48');
INSERT INTO `data_region` VALUES ('784', '231282', '肇东市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('785', '231283', '海伦市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('786', '232700', '大兴安岭地区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('787', '232721', '呼玛县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('788', '232722', '塔河县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('789', '232723', '漠河县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('790', '310000', '上海市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('791', '310101', '黄浦区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('792', '310104', '徐汇区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('793', '310105', '长宁区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('794', '310106', '静安区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('795', '310107', '普陀区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('796', '310109', '虹口区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('797', '310110', '杨浦区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('798', '310112', '闵行区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('799', '310113', '宝山区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('800', '310114', '嘉定区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('801', '310115', '浦东新区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('802', '310116', '金山区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('803', '310117', '松江区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('804', '310118', '青浦区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('805', '310120', '奉贤区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('806', '310151', '崇明区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('807', '320000', '江苏省', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('808', '320100', '南京市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('809', '320102', '玄武区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('810', '320104', '秦淮区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('811', '320105', '建邺区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('812', '320106', '鼓楼区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('813', '320111', '浦口区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('814', '320113', '栖霞区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('815', '320114', '雨花台区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('816', '320115', '江宁区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('817', '320116', '六合区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('818', '320117', '溧水区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('819', '320118', '高淳区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('820', '320200', '无锡市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('821', '320205', '锡山区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('822', '320206', '惠山区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('823', '320211', '滨湖区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('824', '320213', '梁溪区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('825', '320214', '新吴区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('826', '320281', '江阴市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('827', '320282', '宜兴市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('828', '320300', '徐州市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('829', '320302', '鼓楼区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('830', '320303', '云龙区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('831', '320305', '贾汪区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('832', '320311', '泉山区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('833', '320312', '铜山区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('834', '320321', '丰县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('835', '320322', '沛县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('836', '320324', '睢宁县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('837', '320381', '新沂市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('838', '320382', '邳州市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('839', '320400', '常州市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('840', '320402', '天宁区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('841', '320404', '钟楼区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('842', '320411', '新北区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('843', '320412', '武进区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('844', '320413', '金坛区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('845', '320481', '溧阳市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('846', '320500', '苏州市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('847', '320505', '虎丘区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('848', '320506', '吴中区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('849', '320507', '相城区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('850', '320508', '姑苏区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('851', '320509', '吴江区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('852', '320581', '常熟市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('853', '320582', '张家港市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('854', '320583', '昆山市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('855', '320585', '太仓市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('856', '320600', '南通市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('857', '320602', '崇川区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('858', '320611', '港闸区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('859', '320612', '通州区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('860', '320621', '海安县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('861', '320623', '如东县', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('862', '320681', '启东市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('863', '320682', '如皋市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('864', '320684', '海门市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('865', '320700', '连云港市', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('866', '320703', '连云区', '1', '0', '2017-07-07 18:02:49');
INSERT INTO `data_region` VALUES ('867', '320706', '海州区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('868', '320707', '赣榆区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('869', '320722', '东海县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('870', '320723', '灌云县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('871', '320724', '灌南县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('872', '320800', '淮安市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('873', '320803', '淮安区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('874', '320804', '淮阴区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('875', '320812', '清江浦区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('876', '320813', '洪泽区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('877', '320826', '涟水县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('878', '320830', '盱眙县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('879', '320831', '金湖县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('880', '320900', '盐城市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('881', '320902', '亭湖区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('882', '320903', '盐都区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('883', '320904', '大丰区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('884', '320921', '响水县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('885', '320922', '滨海县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('886', '320923', '阜宁县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('887', '320924', '射阳县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('888', '320925', '建湖县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('889', '320981', '东台市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('890', '321000', '扬州市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('891', '321002', '广陵区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('892', '321003', '邗江区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('893', '321012', '江都区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('894', '321023', '宝应县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('895', '321081', '仪征市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('896', '321084', '高邮市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('897', '321100', '镇江市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('898', '321102', '京口区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('899', '321111', '润州区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('900', '321112', '丹徒区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('901', '321181', '丹阳市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('902', '321182', '扬中市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('903', '321183', '句容市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('904', '321200', '泰州市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('905', '321202', '海陵区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('906', '321203', '高港区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('907', '321204', '姜堰区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('908', '321281', '兴化市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('909', '321282', '靖江市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('910', '321283', '泰兴市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('911', '321300', '宿迁市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('912', '321302', '宿城区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('913', '321311', '宿豫区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('914', '321322', '沭阳县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('915', '321323', '泗阳县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('916', '321324', '泗洪县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('917', '330000', '浙江省', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('918', '330100', '杭州市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('919', '330102', '上城区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('920', '330103', '下城区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('921', '330104', '江干区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('922', '330105', '拱墅区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('923', '330106', '西湖区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('924', '330108', '滨江区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('925', '330109', '萧山区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('926', '330110', '余杭区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('927', '330111', '富阳区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('928', '330122', '桐庐县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('929', '330127', '淳安县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('930', '330182', '建德市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('931', '330185', '临安市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('932', '330200', '宁波市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('933', '330203', '海曙区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('934', '330205', '江北区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('935', '330206', '北仑区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('936', '330211', '镇海区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('937', '330212', '鄞州区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('938', '330213', '奉化区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('939', '330225', '象山县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('940', '330226', '宁海县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('941', '330281', '余姚市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('942', '330282', '慈溪市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('943', '330300', '温州市', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('944', '330302', '鹿城区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('945', '330303', '龙湾区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('946', '330304', '瓯海区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('947', '330305', '洞头区', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('948', '330324', '永嘉县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('949', '330326', '平阳县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('950', '330327', '苍南县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('951', '330328', '文成县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('952', '330329', '泰顺县', '1', '0', '2017-07-07 18:02:50');
INSERT INTO `data_region` VALUES ('953', '330381', '瑞安市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('954', '330382', '乐清市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('955', '330400', '嘉兴市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('956', '330402', '南湖区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('957', '330411', '秀洲区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('958', '330421', '嘉善县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('959', '330424', '海盐县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('960', '330481', '海宁市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('961', '330482', '平湖市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('962', '330483', '桐乡市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('963', '330500', '湖州市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('964', '330502', '吴兴区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('965', '330503', '南浔区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('966', '330521', '德清县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('967', '330522', '长兴县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('968', '330523', '安吉县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('969', '330600', '绍兴市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('970', '330602', '越城区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('971', '330603', '柯桥区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('972', '330604', '上虞区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('973', '330624', '新昌县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('974', '330681', '诸暨市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('975', '330683', '嵊州市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('976', '330700', '金华市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('977', '330702', '婺城区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('978', '330703', '金东区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('979', '330723', '武义县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('980', '330726', '浦江县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('981', '330727', '磐安县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('982', '330781', '兰溪市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('983', '330782', '义乌市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('984', '330783', '东阳市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('985', '330784', '永康市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('986', '330800', '衢州市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('987', '330802', '柯城区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('988', '330803', '衢江区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('989', '330822', '常山县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('990', '330824', '开化县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('991', '330825', '龙游县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('992', '330881', '江山市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('993', '330900', '舟山市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('994', '330902', '定海区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('995', '330903', '普陀区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('996', '330921', '岱山县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('997', '330922', '嵊泗县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('998', '331000', '台州市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('999', '331002', '椒江区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1000', '331003', '黄岩区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1001', '331004', '路桥区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1002', '331021', '玉环市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1003', '331022', '三门县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1004', '331023', '天台县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1005', '331024', '仙居县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1006', '331081', '温岭市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1007', '331082', '临海市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1008', '331100', '丽水市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1009', '331102', '莲都区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1010', '331121', '青田县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1011', '331122', '缙云县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1012', '331123', '遂昌县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1013', '331124', '松阳县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1014', '331125', '云和县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1015', '331126', '庆元县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1016', '331127', '景宁畲族自治县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1017', '331181', '龙泉市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1018', '340000', '安徽省', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1019', '340100', '合肥市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1020', '340102', '瑶海区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1021', '340103', '庐阳区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1022', '340104', '蜀山区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1023', '340111', '包河区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1024', '340121', '长丰县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1025', '340122', '肥东县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1026', '340123', '肥西县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1027', '340124', '庐江县', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1028', '340181', '巢湖市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1029', '340200', '芜湖市', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1030', '340202', '镜湖区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1031', '340203', '弋江区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1032', '340207', '鸠江区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1033', '340208', '三山区', '1', '0', '2017-07-07 18:02:51');
INSERT INTO `data_region` VALUES ('1034', '340221', '芜湖县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1035', '340222', '繁昌县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1036', '340223', '南陵县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1037', '340225', '无为县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1038', '340300', '蚌埠市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1039', '340302', '龙子湖区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1040', '340303', '蚌山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1041', '340304', '禹会区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1042', '340311', '淮上区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1043', '340321', '怀远县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1044', '340322', '五河县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1045', '340323', '固镇县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1046', '340400', '淮南市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1047', '340402', '大通区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1048', '340403', '田家庵区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1049', '340404', '谢家集区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1050', '340405', '八公山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1051', '340406', '潘集区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1052', '340421', '凤台县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1053', '340422', '寿县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1054', '340500', '马鞍山市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1055', '340503', '花山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1056', '340504', '雨山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1057', '340506', '博望区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1058', '340521', '当涂县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1059', '340522', '含山县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1060', '340523', '和县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1061', '340600', '淮北市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1062', '340602', '杜集区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1063', '340603', '相山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1064', '340604', '烈山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1065', '340621', '濉溪县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1066', '340700', '铜陵市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1067', '340705', '铜官区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1068', '340706', '义安区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1069', '340711', '郊区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1070', '340722', '枞阳县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1071', '340800', '安庆市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1072', '340802', '迎江区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1073', '340803', '大观区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1074', '340811', '宜秀区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1075', '340822', '怀宁县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1076', '340824', '潜山县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1077', '340825', '太湖县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1078', '340826', '宿松县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1079', '340827', '望江县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1080', '340828', '岳西县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1081', '340881', '桐城市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1082', '341000', '黄山市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1083', '341002', '屯溪区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1084', '341003', '黄山区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1085', '341004', '徽州区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1086', '341021', '歙县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1087', '341022', '休宁县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1088', '341023', '黟县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1089', '341024', '祁门县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1090', '341100', '滁州市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1091', '341102', '琅琊区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1092', '341103', '南谯区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1093', '341122', '来安县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1094', '341124', '全椒县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1095', '341125', '定远县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1096', '341126', '凤阳县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1097', '341181', '天长市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1098', '341182', '明光市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1099', '341200', '阜阳市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1100', '341202', '颍州区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1101', '341203', '颍东区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1102', '341204', '颍泉区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1103', '341221', '临泉县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1104', '341222', '太和县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1105', '341225', '阜南县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1106', '341226', '颍上县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1107', '341282', '界首市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1108', '341300', '宿州市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1109', '341302', '埇桥区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1110', '341321', '砀山县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1111', '341322', '萧县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1112', '341323', '灵璧县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1113', '341324', '泗县', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1114', '341500', '六安市', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1115', '341502', '金安区', '1', '0', '2017-07-07 18:02:52');
INSERT INTO `data_region` VALUES ('1116', '341503', '裕安区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1117', '341504', '叶集区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1118', '341522', '霍邱县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1119', '341523', '舒城县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1120', '341524', '金寨县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1121', '341525', '霍山县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1122', '341600', '亳州市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1123', '341602', '谯城区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1124', '341621', '涡阳县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1125', '341622', '蒙城县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1126', '341623', '利辛县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1127', '341700', '池州市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1128', '341702', '贵池区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1129', '341721', '东至县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1130', '341722', '石台县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1131', '341723', '青阳县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1132', '341800', '宣城市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1133', '341802', '宣州区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1134', '341821', '郎溪县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1135', '341822', '广德县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1136', '341823', '泾县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1137', '341824', '绩溪县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1138', '341825', '旌德县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1139', '341881', '宁国市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1140', '350000', '福建省', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1141', '350100', '福州市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1142', '350102', '鼓楼区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1143', '350103', '台江区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1144', '350104', '仓山区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1145', '350105', '马尾区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1146', '350111', '晋安区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1147', '350121', '闽侯县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1148', '350122', '连江县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1149', '350123', '罗源县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1150', '350124', '闽清县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1151', '350125', '永泰县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1152', '350128', '平潭县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1153', '350181', '福清市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1154', '350182', '长乐市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1155', '350200', '厦门市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1156', '350203', '思明区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1157', '350205', '海沧区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1158', '350206', '湖里区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1159', '350211', '集美区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1160', '350212', '同安区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1161', '350213', '翔安区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1162', '350300', '莆田市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1163', '350302', '城厢区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1164', '350303', '涵江区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1165', '350304', '荔城区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1166', '350305', '秀屿区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1167', '350322', '仙游县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1168', '350400', '三明市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1169', '350402', '梅列区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1170', '350403', '三元区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1171', '350421', '明溪县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1172', '350423', '清流县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1173', '350424', '宁化县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1174', '350425', '大田县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1175', '350426', '尤溪县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1176', '350427', '沙县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1177', '350428', '将乐县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1178', '350429', '泰宁县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1179', '350430', '建宁县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1180', '350481', '永安市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1181', '350500', '泉州市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1182', '350502', '鲤城区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1183', '350503', '丰泽区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1184', '350504', '洛江区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1185', '350505', '泉港区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1186', '350521', '惠安县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1187', '350524', '安溪县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1188', '350525', '永春县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1189', '350526', '德化县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1190', '350527', '金门县', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1191', '350581', '石狮市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1192', '350582', '晋江市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1193', '350583', '南安市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1194', '350600', '漳州市', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1195', '350602', '芗城区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1196', '350603', '龙文区', '1', '0', '2017-07-07 18:02:53');
INSERT INTO `data_region` VALUES ('1197', '350622', '云霄县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1198', '350623', '漳浦县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1199', '350624', '诏安县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1200', '350625', '长泰县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1201', '350626', '东山县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1202', '350627', '南靖县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1203', '350628', '平和县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1204', '350629', '华安县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1205', '350681', '龙海市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1206', '350700', '南平市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1207', '350702', '延平区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1208', '350703', '建阳区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1209', '350721', '顺昌县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1210', '350722', '浦城县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1211', '350723', '光泽县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1212', '350724', '松溪县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1213', '350725', '政和县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1214', '350781', '邵武市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1215', '350782', '武夷山市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1216', '350783', '建瓯市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1217', '350800', '龙岩市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1218', '350802', '新罗区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1219', '350803', '永定区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1220', '350821', '长汀县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1221', '350823', '上杭县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1222', '350824', '武平县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1223', '350825', '连城县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1224', '350881', '漳平市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1225', '350900', '宁德市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1226', '350902', '蕉城区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1227', '350921', '霞浦县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1228', '350922', '古田县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1229', '350923', '屏南县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1230', '350924', '寿宁县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1231', '350925', '周宁县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1232', '350926', '柘荣县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1233', '350981', '福安市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1234', '350982', '福鼎市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1235', '360000', '江西省', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1236', '360100', '南昌市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1237', '360102', '东湖区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1238', '360103', '西湖区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1239', '360104', '青云谱区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1240', '360105', '湾里区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1241', '360111', '青山湖区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1242', '360112', '新建区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1243', '360121', '南昌县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1244', '360123', '安义县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1245', '360124', '进贤县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1246', '360200', '景德镇市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1247', '360202', '昌江区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1248', '360203', '珠山区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1249', '360222', '浮梁县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1250', '360281', '乐平市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1251', '360300', '萍乡市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1252', '360302', '安源区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1253', '360313', '湘东区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1254', '360321', '莲花县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1255', '360322', '上栗县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1256', '360323', '芦溪县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1257', '360400', '九江市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1258', '360402', '濂溪区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1259', '360403', '浔阳区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1260', '360421', '九江县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1261', '360423', '武宁县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1262', '360424', '修水县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1263', '360425', '永修县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1264', '360426', '德安县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1265', '360428', '都昌县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1266', '360429', '湖口县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1267', '360430', '彭泽县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1268', '360481', '瑞昌市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1269', '360482', '共青城市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1270', '360483', '庐山市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1271', '360500', '新余市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1272', '360502', '渝水区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1273', '360521', '分宜县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1274', '360600', '鹰潭市', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1275', '360602', '月湖区', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1276', '360622', '余江县', '1', '0', '2017-07-07 18:02:54');
INSERT INTO `data_region` VALUES ('1277', '360681', '贵溪市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1278', '360700', '赣州市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1279', '360702', '章贡区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1280', '360703', '南康区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1281', '360704', '赣县区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1282', '360722', '信丰县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1283', '360723', '大余县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1284', '360724', '上犹县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1285', '360725', '崇义县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1286', '360726', '安远县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1287', '360727', '龙南县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1288', '360728', '定南县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1289', '360729', '全南县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1290', '360730', '宁都县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1291', '360731', '于都县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1292', '360732', '兴国县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1293', '360733', '会昌县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1294', '360734', '寻乌县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1295', '360735', '石城县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1296', '360781', '瑞金市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1297', '360800', '吉安市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1298', '360802', '吉州区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1299', '360803', '青原区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1300', '360821', '吉安县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1301', '360822', '吉水县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1302', '360823', '峡江县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1303', '360824', '新干县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1304', '360825', '永丰县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1305', '360826', '泰和县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1306', '360827', '遂川县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1307', '360828', '万安县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1308', '360829', '安福县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1309', '360830', '永新县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1310', '360881', '井冈山市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1311', '360900', '宜春市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1312', '360902', '袁州区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1313', '360921', '奉新县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1314', '360922', '万载县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1315', '360923', '上高县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1316', '360924', '宜丰县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1317', '360925', '靖安县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1318', '360926', '铜鼓县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1319', '360981', '丰城市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1320', '360982', '樟树市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1321', '360983', '高安市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1322', '361000', '抚州市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1323', '361002', '临川区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1324', '361003', '东乡区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1325', '361021', '南城县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1326', '361022', '黎川县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1327', '361023', '南丰县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1328', '361024', '崇仁县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1329', '361025', '乐安县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1330', '361026', '宜黄县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1331', '361027', '金溪县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1332', '361028', '资溪县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1333', '361030', '广昌县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1334', '361100', '上饶市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1335', '361102', '信州区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1336', '361121', '上饶县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1337', '361103', '广丰区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1338', '361123', '玉山县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1339', '361124', '铅山县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1340', '361125', '横峰县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1341', '361126', '弋阳县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1342', '361127', '余干县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1343', '361128', '鄱阳县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1344', '361129', '万年县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1345', '361130', '婺源县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1346', '361181', '德兴市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1347', '370000', '山东省', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1348', '370100', '济南市', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1349', '370102', '历下区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1350', '370103', '市中区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1351', '370104', '槐荫区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1352', '370105', '天桥区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1353', '370112', '历城区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1354', '370113', '长清区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1355', '370114', '章丘区', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1356', '370124', '平阴县', '1', '0', '2017-07-07 18:02:55');
INSERT INTO `data_region` VALUES ('1357', '370125', '济阳县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1358', '370126', '商河县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1359', '370200', '青岛市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1360', '370202', '市南区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1361', '370203', '市北区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1362', '370211', '黄岛区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1363', '370212', '崂山区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1364', '370213', '李沧区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1365', '370214', '城阳区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1366', '370281', '胶州市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1367', '370282', '即墨市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1368', '370283', '平度市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1369', '370285', '莱西市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1370', '370300', '淄博市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1371', '370302', '淄川区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1372', '370303', '张店区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1373', '370304', '博山区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1374', '370305', '临淄区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1375', '370306', '周村区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1376', '370321', '桓台县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1377', '370322', '高青县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1378', '370323', '沂源县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1379', '370400', '枣庄市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1380', '370402', '市中区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1381', '370403', '薛城区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1382', '370404', '峄城区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1383', '370405', '台儿庄区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1384', '370406', '山亭区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1385', '370481', '滕州市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1386', '370500', '东营市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1387', '370502', '东营区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1388', '370503', '河口区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1389', '370505', '垦利区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1390', '370522', '利津县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1391', '370523', '广饶县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1392', '370600', '烟台市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1393', '370602', '芝罘区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1394', '370611', '福山区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1395', '370612', '牟平区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1396', '370613', '莱山区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1397', '370634', '长岛县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1398', '370681', '龙口市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1399', '370682', '莱阳市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1400', '370683', '莱州市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1401', '370684', '蓬莱市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1402', '370685', '招远市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1403', '370686', '栖霞市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1404', '370687', '海阳市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1405', '370700', '潍坊市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1406', '370702', '潍城区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1407', '370703', '寒亭区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1408', '370704', '坊子区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1409', '370705', '奎文区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1410', '370724', '临朐县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1411', '370725', '昌乐县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1412', '370781', '青州市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1413', '370782', '诸城市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1414', '370783', '寿光市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1415', '370784', '安丘市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1416', '370785', '高密市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1417', '370786', '昌邑市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1418', '370800', '济宁市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1419', '370811', '任城区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1420', '370812', '兖州区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1421', '370826', '微山县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1422', '370827', '鱼台县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1423', '370828', '金乡县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1424', '370829', '嘉祥县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1425', '370830', '汶上县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1426', '370831', '泗水县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1427', '370832', '梁山县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1428', '370881', '曲阜市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1429', '370883', '邹城市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1430', '370900', '泰安市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1431', '370902', '泰山区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1432', '370911', '岱岳区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1433', '370921', '宁阳县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1434', '370923', '东平县', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1435', '370982', '新泰市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1436', '370983', '肥城市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1437', '371000', '威海市', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1438', '371002', '环翠区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1439', '371003', '文登区', '1', '0', '2017-07-07 18:02:56');
INSERT INTO `data_region` VALUES ('1440', '371082', '荣成市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1441', '371083', '乳山市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1442', '371100', '日照市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1443', '371102', '东港区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1444', '371103', '岚山区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1445', '371121', '五莲县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1446', '371122', '莒县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1447', '371200', '莱芜市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1448', '371202', '莱城区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1449', '371203', '钢城区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1450', '371300', '临沂市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1451', '371302', '兰山区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1452', '371311', '罗庄区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1453', '371312', '河东区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1454', '371321', '沂南县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1455', '371322', '郯城县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1456', '371323', '沂水县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1457', '371324', '兰陵县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1458', '371325', '费县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1459', '371326', '平邑县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1460', '371327', '莒南县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1461', '371328', '蒙阴县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1462', '371329', '临沭县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1463', '371400', '德州市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1464', '371402', '德城区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1465', '371403', '陵城区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1466', '371422', '宁津县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1467', '371423', '庆云县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1468', '371424', '临邑县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1469', '371425', '齐河县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1470', '371426', '平原县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1471', '371427', '夏津县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1472', '371428', '武城县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1473', '371481', '乐陵市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1474', '371482', '禹城市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1475', '371500', '聊城市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1476', '371502', '东昌府区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1477', '371521', '阳谷县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1478', '371522', '莘县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1479', '371523', '茌平县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1480', '371524', '东阿县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1481', '371525', '冠县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1482', '371526', '高唐县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1483', '371581', '临清市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1484', '371600', '滨州市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1485', '371602', '滨城区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1486', '371603', '沾化区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1487', '371621', '惠民县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1488', '371622', '阳信县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1489', '371623', '无棣县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1490', '371625', '博兴县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1491', '371626', '邹平县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1492', '371700', '菏泽市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1493', '371702', '牡丹区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1494', '371703', '定陶区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1495', '371721', '曹县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1496', '371722', '单县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1497', '371723', '成武县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1498', '371724', '巨野县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1499', '371725', '郓城县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1500', '371726', '鄄城县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1501', '371728', '东明县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1502', '410000', '河南省', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1503', '410100', '郑州市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1504', '410102', '中原区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1505', '410103', '二七区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1506', '410104', '管城回族区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1507', '410105', '金水区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1508', '410106', '上街区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1509', '410108', '惠济区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1510', '410122', '中牟县', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1511', '410181', '巩义市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1512', '410182', '荥阳市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1513', '410183', '新密市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1514', '410184', '新郑市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1515', '410185', '登封市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1516', '410200', '开封市', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1517', '410202', '龙亭区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1518', '410203', '顺河回族区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1519', '410204', '鼓楼区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1520', '410205', '禹王台区', '1', '0', '2017-07-07 18:02:57');
INSERT INTO `data_region` VALUES ('1521', '410212', '祥符区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1522', '410221', '杞县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1523', '410222', '通许县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1524', '410223', '尉氏县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1525', '410225', '兰考县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1526', '410300', '洛阳市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1527', '410302', '老城区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1528', '410303', '西工区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1529', '410304', '瀍河回族区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1530', '410305', '涧西区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1531', '410306', '吉利区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1532', '410311', '洛龙区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1533', '410322', '孟津县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1534', '410323', '新安县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1535', '410324', '栾川县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1536', '410325', '嵩县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1537', '410326', '汝阳县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1538', '410327', '宜阳县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1539', '410328', '洛宁县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1540', '410329', '伊川县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1541', '410381', '偃师市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1542', '410400', '平顶山市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1543', '410402', '新华区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1544', '410403', '卫东区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1545', '410404', '石龙区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1546', '410411', '湛河区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1547', '410421', '宝丰县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1548', '410422', '叶县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1549', '410423', '鲁山县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1550', '410425', '郏县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1551', '410481', '舞钢市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1552', '410482', '汝州市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1553', '410500', '安阳市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1554', '410502', '文峰区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1555', '410503', '北关区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1556', '410505', '殷都区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1557', '410506', '龙安区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1558', '410522', '安阳县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1559', '410523', '汤阴县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1560', '410526', '滑县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1561', '410527', '内黄县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1562', '410581', '林州市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1563', '410600', '鹤壁市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1564', '410602', '鹤山区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1565', '410603', '山城区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1566', '410611', '淇滨区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1567', '410621', '浚县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1568', '410622', '淇县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1569', '410700', '新乡市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1570', '410702', '红旗区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1571', '410703', '卫滨区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1572', '410704', '凤泉区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1573', '410711', '牧野区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1574', '410721', '新乡县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1575', '410724', '获嘉县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1576', '410725', '原阳县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1577', '410726', '延津县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1578', '410727', '封丘县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1579', '410728', '长垣县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1580', '410781', '卫辉市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1581', '410782', '辉县市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1582', '410800', '焦作市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1583', '410802', '解放区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1584', '410803', '中站区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1585', '410804', '马村区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1586', '410811', '山阳区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1587', '410821', '修武县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1588', '410822', '博爱县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1589', '410823', '武陟县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1590', '410825', '温县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1591', '410882', '沁阳市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1592', '410883', '孟州市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1593', '410900', '濮阳市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1594', '410902', '华龙区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1595', '410922', '清丰县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1596', '410923', '南乐县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1597', '410926', '范县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1598', '410927', '台前县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1599', '410928', '濮阳县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1600', '411000', '许昌市', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1601', '411002', '魏都区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1602', '411003', '建安区', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1603', '411024', '鄢陵县', '1', '0', '2017-07-07 18:02:58');
INSERT INTO `data_region` VALUES ('1604', '411025', '襄城县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1605', '411081', '禹州市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1606', '411082', '长葛市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1607', '411100', '漯河市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1608', '411102', '源汇区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1609', '411103', '郾城区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1610', '411104', '召陵区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1611', '411121', '舞阳县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1612', '411122', '临颍县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1613', '411200', '三门峡市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1614', '411202', '湖滨区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1615', '411203', '陕州区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1616', '411221', '渑池县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1617', '411224', '卢氏县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1618', '411281', '义马市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1619', '411282', '灵宝市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1620', '411300', '南阳市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1621', '411302', '宛城区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1622', '411303', '卧龙区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1623', '411321', '南召县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1624', '411322', '方城县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1625', '411323', '西峡县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1626', '411324', '镇平县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1627', '411325', '内乡县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1628', '411326', '淅川县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1629', '411327', '社旗县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1630', '411328', '唐河县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1631', '411329', '新野县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1632', '411330', '桐柏县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1633', '411381', '邓州市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1634', '411400', '商丘市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1635', '411402', '梁园区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1636', '411403', '睢阳区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1637', '411421', '民权县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1638', '411422', '睢县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1639', '411423', '宁陵县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1640', '411424', '柘城县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1641', '411425', '虞城县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1642', '411426', '夏邑县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1643', '411481', '永城市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1644', '411500', '信阳市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1645', '411502', '浉河区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1646', '411503', '平桥区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1647', '411521', '罗山县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1648', '411522', '光山县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1649', '411523', '新县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1650', '411524', '商城县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1651', '411525', '固始县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1652', '411526', '潢川县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1653', '411527', '淮滨县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1654', '411528', '息县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1655', '411600', '周口市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1656', '411602', '川汇区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1657', '411621', '扶沟县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1658', '411622', '西华县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1659', '411623', '商水县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1660', '411624', '沈丘县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1661', '411625', '郸城县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1662', '411626', '淮阳县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1663', '411627', '太康县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1664', '411628', '鹿邑县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1665', '411681', '项城市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1666', '411700', '驻马店市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1667', '411702', '驿城区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1668', '411721', '西平县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1669', '411722', '上蔡县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1670', '411723', '平舆县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1671', '411724', '正阳县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1672', '411725', '确山县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1673', '411726', '泌阳县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1674', '411727', '汝南县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1675', '411728', '遂平县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1676', '411729', '新蔡县', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1677', '419001', '济源市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1678', '420000', '湖北省', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1679', '420100', '武汉市', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1680', '420102', '江岸区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1681', '420103', '江汉区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1682', '420104', '硚口区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1683', '420105', '汉阳区', '1', '0', '2017-07-07 18:02:59');
INSERT INTO `data_region` VALUES ('1684', '420106', '武昌区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1685', '420107', '青山区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1686', '420111', '洪山区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1687', '420112', '东西湖区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1688', '420113', '汉南区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1689', '420114', '蔡甸区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1690', '420115', '江夏区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1691', '420116', '黄陂区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1692', '420117', '新洲区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1693', '420200', '黄石市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1694', '420202', '黄石港区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1695', '420203', '西塞山区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1696', '420204', '下陆区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1697', '420205', '铁山区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1698', '420222', '阳新县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1699', '420281', '大冶市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1700', '420300', '十堰市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1701', '420302', '茅箭区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1702', '420303', '张湾区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1703', '420304', '郧阳区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1704', '420322', '郧西县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1705', '420323', '竹山县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1706', '420324', '竹溪县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1707', '420325', '房县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1708', '420381', '丹江口市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1709', '420500', '宜昌市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1710', '420502', '西陵区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1711', '420503', '伍家岗区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1712', '420504', '点军区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1713', '420505', '猇亭区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1714', '420506', '夷陵区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1715', '420525', '远安县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1716', '420526', '兴山县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1717', '420527', '秭归县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1718', '420528', '长阳土家族自治县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1719', '420529', '五峰土家族自治县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1720', '420581', '宜都市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1721', '420582', '当阳市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1722', '420583', '枝江市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1723', '420600', '襄阳市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1724', '420602', '襄城区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1725', '420606', '樊城区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1726', '420607', '襄州区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1727', '420624', '南漳县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1728', '420625', '谷城县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1729', '420626', '保康县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1730', '420682', '老河口市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1731', '420683', '枣阳市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1732', '420684', '宜城市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1733', '420700', '鄂州市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1734', '420702', '梁子湖区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1735', '420703', '华容区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1736', '420704', '鄂城区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1737', '420800', '荆门市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1738', '420802', '东宝区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1739', '420804', '掇刀区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1740', '420821', '京山县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1741', '420822', '沙洋县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1742', '420881', '钟祥市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1743', '420900', '孝感市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1744', '420902', '孝南区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1745', '420921', '孝昌县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1746', '420922', '大悟县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1747', '420923', '云梦县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1748', '420981', '应城市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1749', '420982', '安陆市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1750', '420984', '汉川市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1751', '421000', '荆州市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1752', '421002', '沙市区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1753', '421003', '荆州区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1754', '421022', '公安县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1755', '421023', '监利县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1756', '421024', '江陵县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1757', '421081', '石首市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1758', '421083', '洪湖市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1759', '421087', '松滋市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1760', '421100', '黄冈市', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1761', '421102', '黄州区', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1762', '421121', '团风县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1763', '421122', '红安县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1764', '421123', '罗田县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1765', '421124', '英山县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1766', '421125', '浠水县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1767', '421126', '蕲春县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1768', '421127', '黄梅县', '1', '0', '2017-07-07 18:03:00');
INSERT INTO `data_region` VALUES ('1769', '421181', '麻城市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1770', '421182', '武穴市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1771', '421200', '咸宁市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1772', '421202', '咸安区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1773', '421221', '嘉鱼县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1774', '421222', '通城县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1775', '421223', '崇阳县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1776', '421224', '通山县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1777', '421281', '赤壁市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1778', '421300', '随州市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1779', '421303', '曾都区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1780', '421321', '随县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1781', '421381', '广水市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1782', '422800', '恩施土家族苗族自治州', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1783', '422801', '恩施市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1784', '422802', '利川市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1785', '422822', '建始县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1786', '422823', '巴东县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1787', '422825', '宣恩县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1788', '422826', '咸丰县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1789', '422827', '来凤县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1790', '422828', '鹤峰县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1791', '429004', '仙桃市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1792', '429005', '潜江市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1793', '429006', '天门市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1794', '429021', '神农架林区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1795', '430000', '湖南省', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1796', '430100', '长沙市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1797', '430102', '芙蓉区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1798', '430103', '天心区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1799', '430104', '岳麓区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1800', '430105', '开福区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1801', '430111', '雨花区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1802', '430112', '望城区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1803', '430121', '长沙县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1804', '430124', '宁乡市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1805', '430181', '浏阳市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1806', '430200', '株洲市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1807', '430202', '荷塘区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1808', '430203', '芦淞区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1809', '430204', '石峰区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1810', '430211', '天元区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1811', '430221', '株洲县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1812', '430223', '攸县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1813', '430224', '茶陵县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1814', '430225', '炎陵县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1815', '430281', '醴陵市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1816', '430300', '湘潭市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1817', '430302', '雨湖区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1818', '430304', '岳塘区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1819', '430321', '湘潭县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1820', '430381', '湘乡市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1821', '430382', '韶山市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1822', '430400', '衡阳市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1823', '430405', '珠晖区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1824', '430406', '雁峰区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1825', '430407', '石鼓区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1826', '430408', '蒸湘区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1827', '430412', '南岳区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1828', '430421', '衡阳县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1829', '430422', '衡南县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1830', '430423', '衡山县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1831', '430424', '衡东县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1832', '430426', '祁东县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1833', '430481', '耒阳市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1834', '430482', '常宁市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1835', '430500', '邵阳市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1836', '430502', '双清区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1837', '430503', '大祥区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1838', '430511', '北塔区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1839', '430521', '邵东县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1840', '430522', '新邵县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1841', '430523', '邵阳县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1842', '430524', '隆回县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1843', '430525', '洞口县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1844', '430527', '绥宁县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1845', '430528', '新宁县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1846', '430529', '城步苗族自治县', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1847', '430581', '武冈市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1848', '430600', '岳阳市', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1849', '430602', '岳阳楼区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1850', '430603', '云溪区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1851', '430611', '君山区', '1', '0', '2017-07-07 18:03:01');
INSERT INTO `data_region` VALUES ('1852', '430621', '岳阳县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1853', '430623', '华容县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1854', '430624', '湘阴县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1855', '430626', '平江县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1856', '430681', '汨罗市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1857', '430682', '临湘市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1858', '430700', '常德市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1859', '430702', '武陵区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1860', '430703', '鼎城区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1861', '430721', '安乡县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1862', '430722', '汉寿县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1863', '430723', '澧县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1864', '430724', '临澧县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1865', '430725', '桃源县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1866', '430726', '石门县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1867', '430781', '津市市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1868', '430800', '张家界市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1869', '430802', '永定区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1870', '430811', '武陵源区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1871', '430821', '慈利县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1872', '430822', '桑植县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1873', '430900', '益阳市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1874', '430902', '资阳区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1875', '430903', '赫山区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1876', '430921', '南县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1877', '430922', '桃江县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1878', '430923', '安化县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1879', '430981', '沅江市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1880', '431000', '郴州市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1881', '431002', '北湖区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1882', '431003', '苏仙区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1883', '431021', '桂阳县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1884', '431022', '宜章县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1885', '431023', '永兴县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1886', '431024', '嘉禾县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1887', '431025', '临武县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1888', '431026', '汝城县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1889', '431027', '桂东县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1890', '431028', '安仁县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1891', '431081', '资兴市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1892', '431100', '永州市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1893', '431102', '零陵区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1894', '431103', '冷水滩区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1895', '431121', '祁阳县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1896', '431122', '东安县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1897', '431123', '双牌县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1898', '431124', '道县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1899', '431125', '江永县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1900', '431126', '宁远县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1901', '431127', '蓝山县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1902', '431128', '新田县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1903', '431129', '江华瑶族自治县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1904', '431200', '怀化市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1905', '431202', '鹤城区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1906', '431221', '中方县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1907', '431222', '沅陵县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1908', '431223', '辰溪县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1909', '431224', '溆浦县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1910', '431225', '会同县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1911', '431226', '麻阳苗族自治县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1912', '431227', '新晃侗族自治县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1913', '431228', '芷江侗族自治县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1914', '431229', '靖州苗族侗族自治县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1915', '431230', '通道侗族自治县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1916', '431281', '洪江市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1917', '431300', '娄底市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1918', '431302', '娄星区', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1919', '431321', '双峰县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1920', '431322', '新化县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1921', '431381', '冷水江市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1922', '431382', '涟源市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1923', '433100', '湘西土家族苗族自治州', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1924', '433101', '吉首市', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1925', '433122', '泸溪县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1926', '433123', '凤凰县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1927', '433124', '花垣县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1928', '433125', '保靖县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1929', '433126', '古丈县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1930', '433127', '永顺县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1931', '433130', '龙山县', '1', '0', '2017-07-07 18:03:02');
INSERT INTO `data_region` VALUES ('1932', '440000', '广东省', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1933', '440100', '广州市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1934', '440103', '荔湾区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1935', '440104', '越秀区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1936', '440105', '海珠区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1937', '440106', '天河区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1938', '440111', '白云区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1939', '440112', '黄埔区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1940', '440113', '番禺区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1941', '440114', '花都区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1942', '440115', '南沙区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1943', '440117', '从化区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1944', '440118', '增城区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1945', '440200', '韶关市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1946', '440203', '武江区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1947', '440204', '浈江区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1948', '440205', '曲江区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1949', '440222', '始兴县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1950', '440224', '仁化县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1951', '440229', '翁源县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1952', '440232', '乳源瑶族自治县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1953', '440233', '新丰县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1954', '440281', '乐昌市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1955', '440282', '南雄市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1956', '440300', '深圳市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1957', '440303', '罗湖区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1958', '440304', '福田区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1959', '440305', '南山区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1960', '440306', '宝安区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1961', '440307', '龙岗区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1962', '440308', '盐田区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1963', '440309', '龙华区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1964', '440310', '坪山区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1965', '440400', '珠海市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1966', '440402', '香洲区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1967', '440403', '斗门区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1968', '440404', '金湾区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1969', '440500', '汕头市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1970', '440507', '龙湖区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1971', '440511', '金平区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1972', '440512', '濠江区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1973', '440513', '潮阳区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1974', '440514', '潮南区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1975', '440515', '澄海区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1976', '440523', '南澳县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1977', '440600', '佛山市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1978', '440604', '禅城区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1979', '440605', '南海区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1980', '440606', '顺德区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1981', '440607', '三水区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1982', '440608', '高明区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1983', '440700', '江门市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1984', '440703', '蓬江区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1985', '440704', '江海区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1986', '440705', '新会区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1987', '440781', '台山市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1988', '440783', '开平市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1989', '440784', '鹤山市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1990', '440785', '恩平市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1991', '440800', '湛江市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1992', '440802', '赤坎区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1993', '440803', '霞山区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1994', '440804', '坡头区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1995', '440811', '麻章区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1996', '440823', '遂溪县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1997', '440825', '徐闻县', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1998', '440881', '廉江市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('1999', '440882', '雷州市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2000', '440883', '吴川市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2001', '440900', '茂名市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2002', '440902', '茂南区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2003', '440904', '电白区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2004', '440981', '高州市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2005', '440982', '化州市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2006', '440983', '信宜市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2007', '441200', '肇庆市', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2008', '441202', '端州区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2009', '441203', '鼎湖区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2010', '441204', '高要区', '1', '0', '2017-07-07 18:03:03');
INSERT INTO `data_region` VALUES ('2011', '441223', '广宁县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2012', '441224', '怀集县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2013', '441225', '封开县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2014', '441226', '德庆县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2015', '441284', '四会市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2016', '441300', '惠州市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2017', '441302', '惠城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2018', '441303', '惠阳区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2019', '441322', '博罗县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2020', '441323', '惠东县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2021', '441324', '龙门县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2022', '441400', '梅州市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2023', '441402', '梅江区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2024', '441403', '梅县区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2025', '441422', '大埔县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2026', '441423', '丰顺县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2027', '441424', '五华县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2028', '441426', '平远县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2029', '441427', '蕉岭县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2030', '441481', '兴宁市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2031', '441500', '汕尾市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2032', '441502', '城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2033', '441521', '海丰县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2034', '441523', '陆河县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2035', '441581', '陆丰市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2036', '441600', '河源市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2037', '441602', '源城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2038', '441621', '紫金县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2039', '441622', '龙川县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2040', '441623', '连平县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2041', '441624', '和平县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2042', '441625', '东源县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2043', '441700', '阳江市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2044', '441702', '江城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2045', '441704', '阳东区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2046', '441721', '阳西县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2047', '441781', '阳春市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2048', '441800', '清远市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2049', '441802', '清城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2050', '441803', '清新区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2051', '441821', '佛冈县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2052', '441823', '阳山县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2053', '441825', '连山壮族瑶族自治县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2054', '441826', '连南瑶族自治县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2055', '441881', '英德市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2056', '441882', '连州市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2057', '441900', '东莞市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2058', '442000', '中山市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2059', '445100', '潮州市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2060', '445102', '湘桥区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2061', '445103', '潮安区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2062', '445122', '饶平县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2063', '445200', '揭阳市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2064', '445202', '榕城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2065', '445203', '揭东区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2066', '445222', '揭西县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2067', '445224', '惠来县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2068', '445281', '普宁市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2069', '445300', '云浮市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2070', '445302', '云城区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2071', '445303', '云安区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2072', '445321', '新兴县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2073', '445322', '郁南县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2074', '445381', '罗定市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2075', '450000', '广西壮族自治区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2076', '450100', '南宁市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2077', '450102', '兴宁区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2078', '450103', '青秀区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2079', '450105', '江南区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2080', '450107', '西乡塘区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2081', '450108', '良庆区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2082', '450109', '邕宁区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2083', '450110', '武鸣区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2084', '450123', '隆安县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2085', '450124', '马山县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2086', '450125', '上林县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2087', '450126', '宾阳县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2088', '450127', '横县', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2089', '450200', '柳州市', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2090', '450202', '城中区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2091', '450203', '鱼峰区', '1', '0', '2017-07-07 18:03:04');
INSERT INTO `data_region` VALUES ('2092', '450204', '柳南区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2093', '450205', '柳北区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2094', '450206', '柳江区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2095', '450222', '柳城县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2096', '450223', '鹿寨县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2097', '450224', '融安县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2098', '450225', '融水苗族自治县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2099', '450226', '三江侗族自治县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2100', '450300', '桂林市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2101', '450302', '秀峰区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2102', '450303', '叠彩区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2103', '450304', '象山区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2104', '450305', '七星区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2105', '450311', '雁山区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2106', '450312', '临桂区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2107', '450321', '阳朔县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2108', '450323', '灵川县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2109', '450324', '全州县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2110', '450325', '兴安县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2111', '450326', '永福县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2112', '450327', '灌阳县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2113', '450328', '龙胜各族自治县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2114', '450329', '资源县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2115', '450330', '平乐县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2116', '450331', '荔浦县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2117', '450332', '恭城瑶族自治县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2118', '450400', '梧州市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2119', '450403', '万秀区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2120', '450405', '长洲区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2121', '450406', '龙圩区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2122', '450421', '苍梧县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2123', '450422', '藤县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2124', '450423', '蒙山县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2125', '450481', '岑溪市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2126', '450500', '北海市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2127', '450502', '海城区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2128', '450503', '银海区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2129', '450512', '铁山港区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2130', '450521', '合浦县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2131', '450600', '防城港市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2132', '450602', '港口区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2133', '450603', '防城区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2134', '450621', '上思县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2135', '450681', '东兴市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2136', '450700', '钦州市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2137', '450702', '钦南区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2138', '450703', '钦北区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2139', '450721', '灵山县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2140', '450722', '浦北县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2141', '450800', '贵港市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2142', '450802', '港北区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2143', '450803', '港南区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2144', '450804', '覃塘区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2145', '450821', '平南县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2146', '450881', '桂平市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2147', '450900', '玉林市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2148', '450902', '玉州区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2149', '450903', '福绵区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2150', '450921', '容县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2151', '450922', '陆川县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2152', '450923', '博白县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2153', '450924', '兴业县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2154', '450981', '北流市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2155', '451000', '百色市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2156', '451002', '右江区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2157', '451021', '田阳县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2158', '451022', '田东县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2159', '451023', '平果县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2160', '451024', '德保县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2161', '451026', '那坡县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2162', '451027', '凌云县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2163', '451028', '乐业县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2164', '451029', '田林县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2165', '451030', '西林县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2166', '451031', '隆林各族自治县', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2167', '451081', '靖西市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2168', '451100', '贺州市', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2169', '451102', '八步区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2170', '451103', '平桂区', '1', '0', '2017-07-07 18:03:05');
INSERT INTO `data_region` VALUES ('2171', '451121', '昭平县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2172', '451122', '钟山县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2173', '451123', '富川瑶族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2174', '451200', '河池市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2175', '451202', '金城江区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2176', '451203', '宜州区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2177', '451221', '南丹县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2178', '451222', '天峨县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2179', '451223', '凤山县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2180', '451224', '东兰县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2181', '451225', '罗城仫佬族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2182', '451226', '环江毛南族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2183', '451227', '巴马瑶族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2184', '451228', '都安瑶族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2185', '451229', '大化瑶族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2186', '451300', '来宾市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2187', '451302', '兴宾区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2188', '451321', '忻城县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2189', '451322', '象州县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2190', '451323', '武宣县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2191', '451324', '金秀瑶族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2192', '451381', '合山市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2193', '451400', '崇左市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2194', '451402', '江州区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2195', '451421', '扶绥县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2196', '451422', '宁明县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2197', '451423', '龙州县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2198', '451424', '大新县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2199', '451425', '天等县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2200', '451481', '凭祥市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2201', '460000', '海南省', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2202', '460100', '海口市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2203', '460105', '秀英区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2204', '460106', '龙华区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2205', '460107', '琼山区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2206', '460108', '美兰区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2207', '460200', '三亚市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2208', '460202', '海棠区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2209', '460203', '吉阳区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2210', '460204', '天涯区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2211', '460205', '崖州区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2212', '460300', '三沙市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2213', '460321', '西沙群岛', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2214', '460322', '南沙群岛', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2215', '460323', '中沙群岛', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2216', '460324', '永乐群岛', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2217', '460400', '儋州市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2218', '469001', '五指山市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2219', '469002', '琼海市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2220', '469005', '文昌市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2221', '469006', '万宁市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2222', '469007', '东方市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2223', '469021', '定安县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2224', '469022', '屯昌县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2225', '469023', '澄迈县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2226', '469024', '临高县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2227', '469025', '白沙黎族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2228', '469026', '昌江黎族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2229', '469027', '乐东黎族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2230', '469028', '陵水黎族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2231', '469029', '保亭黎族苗族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2232', '469030', '琼中黎族苗族自治县', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2233', '500000', '重庆市', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2234', '500101', '万州区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2235', '500102', '涪陵区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2236', '500103', '渝中区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2237', '500104', '大渡口区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2238', '500105', '江北区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2239', '500106', '沙坪坝区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2240', '500107', '九龙坡区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2241', '500108', '南岸区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2242', '500109', '北碚区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2243', '500110', '綦江区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2244', '500111', '大足区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2245', '500112', '渝北区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2246', '500113', '巴南区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2247', '500114', '黔江区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2248', '500115', '长寿区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2249', '500116', '江津区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2250', '500117', '合川区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2251', '500118', '永川区', '1', '0', '2017-07-07 18:03:06');
INSERT INTO `data_region` VALUES ('2252', '500119', '南川区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2253', '500120', '璧山区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2254', '500151', '铜梁区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2255', '500152', '潼南区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2256', '500153', '荣昌区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2257', '500154', '开州区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2258', '500155', '梁平区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2259', '500156', '武隆区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2260', '500229', '城口县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2261', '500230', '丰都县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2262', '500231', '垫江县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2263', '500233', '忠县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2264', '500235', '云阳县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2265', '500236', '奉节县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2266', '500237', '巫山县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2267', '500238', '巫溪县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2268', '500240', '石柱土家族自治县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2269', '500241', '秀山土家族苗族自治县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2270', '500242', '酉阳土家族苗族自治县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2271', '500243', '彭水苗族土家族自治县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2272', '510000', '四川省', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2273', '510100', '成都市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2274', '510104', '锦江区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2275', '510105', '青羊区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2276', '510106', '金牛区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2277', '510107', '武侯区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2278', '510108', '成华区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2279', '510112', '龙泉驿区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2280', '510113', '青白江区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2281', '510114', '新都区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2282', '510115', '温江区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2283', '510116', '双流区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2284', '510117', '郫都区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2285', '510121', '金堂县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2286', '510129', '大邑县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2287', '510131', '蒲江县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2288', '510132', '新津县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2289', '510181', '都江堰市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2290', '510182', '彭州市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2291', '510183', '邛崃市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2292', '510184', '崇州市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2293', '510185', '简阳市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2294', '510300', '自贡市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2295', '510302', '自流井区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2296', '510303', '贡井区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2297', '510304', '大安区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2298', '510311', '沿滩区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2299', '510321', '荣县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2300', '510322', '富顺县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2301', '510400', '攀枝花市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2302', '510402', '东区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2303', '510403', '西区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2304', '510411', '仁和区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2305', '510421', '米易县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2306', '510422', '盐边县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2307', '510500', '泸州市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2308', '510502', '江阳区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2309', '510503', '纳溪区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2310', '510504', '龙马潭区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2311', '510521', '泸县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2312', '510522', '合江县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2313', '510524', '叙永县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2314', '510525', '古蔺县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2315', '510600', '德阳市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2316', '510603', '旌阳区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2317', '510623', '中江县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2318', '510626', '罗江县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2319', '510681', '广汉市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2320', '510682', '什邡市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2321', '510683', '绵竹市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2322', '510700', '绵阳市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2323', '510703', '涪城区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2324', '510704', '游仙区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2325', '510705', '安州区', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2326', '510722', '三台县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2327', '510723', '盐亭县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2328', '510725', '梓潼县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2329', '510726', '北川羌族自治县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2330', '510727', '平武县', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2331', '510781', '江油市', '1', '0', '2017-07-07 18:03:07');
INSERT INTO `data_region` VALUES ('2332', '510800', '广元市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2333', '510802', '利州区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2334', '510811', '昭化区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2335', '510812', '朝天区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2336', '510821', '旺苍县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2337', '510822', '青川县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2338', '510823', '剑阁县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2339', '510824', '苍溪县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2340', '510900', '遂宁市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2341', '510903', '船山区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2342', '510904', '安居区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2343', '510921', '蓬溪县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2344', '510922', '射洪县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2345', '510923', '大英县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2346', '511000', '内江市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2347', '511002', '市中区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2348', '511011', '东兴区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2349', '511024', '威远县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2350', '511025', '资中县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2351', '511028', '隆昌市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2352', '511100', '乐山市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2353', '511102', '市中区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2354', '511111', '沙湾区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2355', '511112', '五通桥区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2356', '511113', '金口河区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2357', '511123', '犍为县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2358', '511124', '井研县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2359', '511126', '夹江县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2360', '511129', '沐川县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2361', '511132', '峨边彝族自治县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2362', '511133', '马边彝族自治县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2363', '511181', '峨眉山市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2364', '511300', '南充市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2365', '511302', '顺庆区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2366', '511303', '高坪区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2367', '511304', '嘉陵区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2368', '511321', '南部县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2369', '511322', '营山县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2370', '511323', '蓬安县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2371', '511324', '仪陇县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2372', '511325', '西充县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2373', '511381', '阆中市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2374', '511400', '眉山市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2375', '511402', '东坡区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2376', '511403', '彭山区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2377', '511421', '仁寿县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2378', '511423', '洪雅县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2379', '511424', '丹棱县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2380', '511425', '青神县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2381', '511500', '宜宾市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2382', '511502', '翠屏区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2383', '511503', '南溪区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2384', '511521', '宜宾县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2385', '511523', '江安县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2386', '511524', '长宁县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2387', '511525', '高县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2388', '511526', '珙县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2389', '511527', '筠连县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2390', '511528', '兴文县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2391', '511529', '屏山县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2392', '511600', '广安市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2393', '511602', '广安区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2394', '511603', '前锋区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2395', '511621', '岳池县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2396', '511622', '武胜县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2397', '511623', '邻水县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2398', '511681', '华蓥市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2399', '511700', '达州市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2400', '511702', '通川区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2401', '511703', '达川区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2402', '511722', '宣汉县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2403', '511723', '开江县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2404', '511724', '大竹县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2405', '511725', '渠县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2406', '511781', '万源市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2407', '511800', '雅安市', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2408', '511802', '雨城区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2409', '511803', '名山区', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2410', '511822', '荥经县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2411', '511823', '汉源县', '1', '0', '2017-07-07 18:03:08');
INSERT INTO `data_region` VALUES ('2412', '511824', '石棉县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2413', '511825', '天全县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2414', '511826', '芦山县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2415', '511827', '宝兴县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2416', '511900', '巴中市', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2417', '511902', '巴州区', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2418', '511903', '恩阳区', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2419', '511921', '通江县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2420', '511922', '南江县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2421', '511923', '平昌县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2422', '512000', '资阳市', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2423', '512002', '雁江区', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2424', '512021', '安岳县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2425', '512022', '乐至县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2426', '513200', '阿坝藏族羌族自治州', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2427', '513201', '马尔康市', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2428', '513221', '汶川县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2429', '513222', '理县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2430', '513223', '茂县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2431', '513224', '松潘县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2432', '513225', '九寨沟县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2433', '513226', '金川县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2434', '513227', '小金县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2435', '513228', '黑水县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2436', '513230', '壤塘县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2437', '513231', '阿坝县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2438', '513232', '若尔盖县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2439', '513233', '红原县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2440', '513300', '甘孜藏族自治州', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2441', '513301', '康定市', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2442', '513322', '泸定县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2443', '513323', '丹巴县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2444', '513324', '九龙县', '1', '0', '2017-07-07 18:03:09');
INSERT INTO `data_region` VALUES ('2445', '513325', '雅江县', '1', '0', '2017-07-07 18:03:09');

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
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='系统权限表';

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
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` varchar(500) DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`),
  KEY `index_system_config_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统参数配置';

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('148', 'site_name', 'Think.Admin Demo');
INSERT INTO `system_config` VALUES ('149', 'site_copy', '广州楚才信息科技有限公司 © 2014~2017');
INSERT INTO `system_config` VALUES ('164', 'storage_type', 'local');
INSERT INTO `system_config` VALUES ('165', 'storage_qiniu_is_https', '1');
INSERT INTO `system_config` VALUES ('166', 'storage_qiniu_bucket', 'static');
INSERT INTO `system_config` VALUES ('167', 'storage_qiniu_domain', 'static.ctolog.com');
INSERT INTO `system_config` VALUES ('168', 'storage_qiniu_access_key', 'OAFHGzCgZjod2-s4xr-g5ptkXsNbxDO_t2fozIEC');
INSERT INTO `system_config` VALUES ('169', 'storage_qiniu_secret_key', 'gy0aYdSFMSayQ4kMkgUeEeJRLThVjLpUJoPFxd-Z');
INSERT INTO `system_config` VALUES ('170', 'storage_qiniu_region', '华东');
INSERT INTO `system_config` VALUES ('173', 'app_name', 'Think.Admin');
INSERT INTO `system_config` VALUES ('174', 'app_version', '1.00 dev');
INSERT INTO `system_config` VALUES ('176', 'browser_icon', 'https://think.ctolog.com/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png');
INSERT INTO `system_config` VALUES ('184', 'wechat_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES ('185', 'wechat_appsecret', '062938ddcfe0d69786e4e3d9dcbb08aa');
INSERT INTO `system_config` VALUES ('186', 'wechat_token', 'mytoken');
INSERT INTO `system_config` VALUES ('187', 'wechat_encodingaeskey', 'KHyoWLoS7oLZYkB4PokMTfA5sm6Hrqc9Tzgn9iXc0YH');
INSERT INTO `system_config` VALUES ('188', 'wechat_mch_id', '1332187001');
INSERT INTO `system_config` VALUES ('189', 'wechat_partnerkey', 'A82DC5BD1F3359081049C568D8502BC5');
INSERT INTO `system_config` VALUES ('194', 'wechat_cert_key', '');
INSERT INTO `system_config` VALUES ('196', 'wechat_cert_cert', '');
INSERT INTO `system_config` VALUES ('197', 'tongji_baidu_key', 'aa2f9869e9b578122e4692de2bd9f80f');
INSERT INTO `system_config` VALUES ('198', 'tongji_cnzz_key', '1261854404');
INSERT INTO `system_config` VALUES ('199', 'storage_oss_bucket', 'think-oss');
INSERT INTO `system_config` VALUES ('200', 'storage_oss_keyid', 'WjeX0AYSfgy5VbXQ');
INSERT INTO `system_config` VALUES ('201', 'storage_oss_secret', 'hQTENHy6MYVUTgwjcgfOCq5gckm2Lp');
INSERT INTO `system_config` VALUES ('202', 'storage_oss_domain', 'think-oss.oss-cn-shanghai.aliyuncs.com');
INSERT INTO `system_config` VALUES ('203', 'storage_oss_is_https', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='系统操作日志表';

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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COMMENT='系统菜单表';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES ('2', '0', '系统管理', '', '', '#', '', '_self', '999', '1', '0', '2015-11-16 19:15:38');
INSERT INTO `system_menu` VALUES ('3', '4', '后台首页', '', 'fa fa-fw fa-tachometer', 'admin/index/main', '', '_self', '26', '1', '0', '2015-11-17 13:27:25');
INSERT INTO `system_menu` VALUES ('4', '2', '系统配置', '', '', '#', '', '_self', '205', '1', '0', '2016-03-14 18:12:55');
INSERT INTO `system_menu` VALUES ('5', '4', '网站参数', '', 'fa fa-apple', 'admin/config/index', '', '_self', '6', '1', '0', '2016-05-06 14:36:49');
INSERT INTO `system_menu` VALUES ('6', '4', '文件存储', '', 'fa fa-hdd-o', 'admin/config/file', '', '_self', '3', '1', '0', '2016-05-06 14:39:43');
INSERT INTO `system_menu` VALUES ('9', '20', '操作日志', '', 'glyphicon glyphicon-console', 'admin/log/index', '', '_self', '50', '1', '0', '2017-03-24 15:49:31');
INSERT INTO `system_menu` VALUES ('19', '20', '权限管理', '', 'fa fa-user-secret', 'admin/auth/index', '', '_self', '2', '1', '0', '2015-11-17 13:18:12');
INSERT INTO `system_menu` VALUES ('20', '2', '系统权限', '', '', '#', '', '_self', '20', '1', '0', '2016-03-14 18:11:41');
INSERT INTO `system_menu` VALUES ('21', '20', '系统菜单', '', 'glyphicon glyphicon-menu-hamburger', 'admin/menu/index', '', '_self', '30', '1', '0', '2015-11-16 19:16:16');
INSERT INTO `system_menu` VALUES ('22', '20', '节点管理', '', 'fa fa-ellipsis-v', 'admin/node/index', '', '_self', '21', '1', '0', '2015-11-16 19:16:16');
INSERT INTO `system_menu` VALUES ('29', '20', '系统用户', '', 'fa fa-users', 'admin/user/index', '', '_self', '40', '1', '0', '2016-10-31 14:31:40');
INSERT INTO `system_menu` VALUES ('61', '0', '微信管理', '', '', '#', '', '_self', '13', '1', '0', '2017-03-29 11:00:21');
INSERT INTO `system_menu` VALUES ('62', '61', '微信对接配置', '', '', '#', '', '_self', '22', '1', '0', '2017-03-29 11:03:38');
INSERT INTO `system_menu` VALUES ('63', '62', '微信接口配置\r\n', '', 'fa fa-usb', 'wechat/config/index', '', '_self', '3', '1', '0', '2017-03-29 11:04:44');
INSERT INTO `system_menu` VALUES ('64', '62', '微信支付配置', '', 'fa fa-paypal', 'wechat/config/pay', '', '_self', '5', '1', '0', '2017-03-29 11:05:29');
INSERT INTO `system_menu` VALUES ('65', '61', '微信粉丝管理', '', '', '#', '', '_self', '13', '1', '0', '2017-03-29 11:08:32');
INSERT INTO `system_menu` VALUES ('66', '65', '粉丝标签', '', 'fa fa-tags', 'wechat/tags/index', '', '_self', '0', '1', '0', '2017-03-29 11:09:41');
INSERT INTO `system_menu` VALUES ('67', '65', '已关注粉丝', '', 'fa fa-wechat', 'wechat/fans/index', '', '_self', '1', '1', '0', '2017-03-29 11:10:07');
INSERT INTO `system_menu` VALUES ('68', '61', '微信订制', '', '', '#', '', '_self', '13', '1', '0', '2017-03-29 11:10:39');
INSERT INTO `system_menu` VALUES ('69', '68', '微信菜单定制', '', 'glyphicon glyphicon-phone', 'wechat/menu/index', '', '_self', '12', '1', '0', '2017-03-29 11:11:08');
INSERT INTO `system_menu` VALUES ('70', '68', '关键字管理', '', 'fa fa-paw', 'wechat/keys/index', '', '_self', '0', '1', '0', '2017-03-29 11:11:49');
INSERT INTO `system_menu` VALUES ('71', '68', '关注自动回复', '', 'fa fa-commenting-o', 'wechat/keys/subscribe', '', '_self', '0', '1', '0', '2017-03-29 11:12:32');
INSERT INTO `system_menu` VALUES ('81', '68', '无配置默认回复', '', 'fa fa-commenting-o', 'wechat/keys/defaults', '', '_self', '0', '1', '0', '2017-04-21 14:48:25');
INSERT INTO `system_menu` VALUES ('82', '61', '素材资源管理', '', '', '#', '', '_self', '2', '1', '0', '2017-04-24 11:23:18');
INSERT INTO `system_menu` VALUES ('83', '82', '添加图文', '', 'fa fa-folder-open-o', 'wechat/news/add?id=1', '', '_self', '3', '1', '0', '2017-04-24 11:23:40');
INSERT INTO `system_menu` VALUES ('85', '82', '图文列表', '', 'fa fa-file-pdf-o', 'wechat/news/index', '', '_self', '0', '1', '0', '2017-04-24 11:25:45');
INSERT INTO `system_menu` VALUES ('86', '65', '粉丝黑名单', '', 'fa fa-reddit-alien', 'wechat/fans/back', '', '_self', '3', '1', '0', '2017-05-05 16:17:03');

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
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统节点表';

-- ----------------------------
-- Records of system_node
-- ----------------------------
INSERT INTO `system_node` VALUES ('3', 'admin', '', '0', '1', '2017-03-10 15:31:29');
INSERT INTO `system_node` VALUES ('4', 'admin/menu/add', '添加菜单', '1', '1', '2017-03-10 15:32:21');
INSERT INTO `system_node` VALUES ('5', 'admin/config', '系统配置', '0', '1', '2017-03-10 15:32:56');
INSERT INTO `system_node` VALUES ('6', 'admin/config/index', '网站配置', '1', '1', '2017-03-10 15:32:58');
INSERT INTO `system_node` VALUES ('7', 'admin/config/file', '文件配置', '1', '1', '2017-03-10 15:33:02');
INSERT INTO `system_node` VALUES ('8', 'admin/config/mail', '邮件配置', '0', '0', '2017-03-10 15:36:42');
INSERT INTO `system_node` VALUES ('9', 'admin/config/sms', '短信配置', '0', '0', '2017-03-10 15:36:43');
INSERT INTO `system_node` VALUES ('10', 'admin/menu/index', '菜单列表', '1', '0', '2017-03-10 15:36:50');
INSERT INTO `system_node` VALUES ('11', 'admin/node/index', '节点列表1', '1', '1', '2017-03-10 15:36:59');
INSERT INTO `system_node` VALUES ('12', 'admin/node/save', '节点更新', '1', '1', '2017-03-10 15:36:59');
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
INSERT INTO `system_node` VALUES ('40', 'admin/user/resume', '启用用户', '1', '1', '2017-03-14 17:53:03');
INSERT INTO `system_node` VALUES ('41', 'admin/user/forbid', '禁用用户', '1', '1', '2017-03-14 17:53:03');
INSERT INTO `system_node` VALUES ('42', 'admin/user/del', '', '1', '1', '2017-03-14 17:53:04');
INSERT INTO `system_node` VALUES ('43', 'admin/user/pass', '密码修改', '1', '1', '2017-03-14 17:53:04');
INSERT INTO `system_node` VALUES ('44', 'admin/user/edit', '编辑用户', '1', '1', '2017-03-14 17:53:05');
INSERT INTO `system_node` VALUES ('45', 'admin/user/index', '用户列表', '1', '1', '2017-03-14 17:53:07');
INSERT INTO `system_node` VALUES ('46', 'admin/user/auth', '用户授权', '1', '1', '2017-03-14 17:53:08');
INSERT INTO `system_node` VALUES ('47', 'admin/user/add', '新增用户', '1', '1', '2017-03-14 17:53:09');
INSERT INTO `system_node` VALUES ('48', 'admin/plugs/icon', null, '0', '1', '2017-03-14 17:53:09');
INSERT INTO `system_node` VALUES ('49', 'admin/plugs/upload', null, '0', '1', '2017-03-14 17:53:10');
INSERT INTO `system_node` VALUES ('50', 'admin/plugs/upfile', null, '0', '1', '2017-03-14 17:53:11');
INSERT INTO `system_node` VALUES ('51', 'admin/plugs/upstate', null, '0', '1', '2017-03-14 17:53:11');
INSERT INTO `system_node` VALUES ('52', 'admin/menu/resume', '菜单启用1', '1', '1', '2017-03-14 17:53:14');
INSERT INTO `system_node` VALUES ('53', 'admin/menu/forbid', '菜单禁用', '1', '1', '2017-03-14 17:53:15');
INSERT INTO `system_node` VALUES ('54', 'admin/login/index', null, '0', '1', '2017-03-14 17:53:17');
INSERT INTO `system_node` VALUES ('55', 'admin/login/out', '', '0', '1', '2017-03-14 17:53:18');
INSERT INTO `system_node` VALUES ('56', 'admin/menu/edit', '编辑菜单', '1', '1', '2017-03-14 17:53:20');
INSERT INTO `system_node` VALUES ('57', 'admin/menu/del', '菜单删除', '1', '1', '2017-03-14 17:53:21');
INSERT INTO `system_node` VALUES ('58', 'store/menu', '菜谱管理', '0', '1', '2017-03-14 17:57:47');
INSERT INTO `system_node` VALUES ('59', 'store/index', '店铺管理', '0', '1', '2017-03-14 17:58:28');
INSERT INTO `system_node` VALUES ('60', 'store', '店铺管理', '0', '1', '2017-03-14 17:58:29');
INSERT INTO `system_node` VALUES ('61', 'store/order', '订单管理', '0', '1', '2017-03-14 17:58:56');
INSERT INTO `system_node` VALUES ('62', 'admin/user', '用户管理', '0', '1', '2017-03-14 17:59:39');
INSERT INTO `system_node` VALUES ('63', 'admin/node', '节点管理', '0', '1', '2017-03-14 17:59:53');
INSERT INTO `system_node` VALUES ('64', 'admin/menu', '菜单管理', '0', '1', '2017-03-14 18:00:31');
INSERT INTO `system_node` VALUES ('65', 'admin/auth', ' fdsf', '0', '1', '2017-03-17 14:37:05');
INSERT INTO `system_node` VALUES ('66', 'admin/auth/index', '这是备忘的', '1', '1', '2017-03-17 14:37:14');
INSERT INTO `system_node` VALUES ('67', 'admin/auth/apply', '', '1', '1', '2017-03-17 14:37:29');
INSERT INTO `system_node` VALUES ('68', 'admin/auth/add', '', '1', '1', '2017-03-17 14:37:32');
INSERT INTO `system_node` VALUES ('69', 'admin/auth/edit', '权限编辑', '1', '1', '2017-03-17 14:37:36');
INSERT INTO `system_node` VALUES ('70', 'admin/auth/forbid', '禁用权限', '1', '1', '2017-03-17 14:37:38');
INSERT INTO `system_node` VALUES ('71', 'admin/auth/resume', '启用权限', '1', '1', '2017-03-17 14:37:41');
INSERT INTO `system_node` VALUES ('72', 'admin/auth/del', '删除', '1', '0', '2017-03-17 14:37:47');
INSERT INTO `system_node` VALUES ('73', 'admin/log/index', '日志列表', '1', '1', '2017-03-25 09:54:57');
INSERT INTO `system_node` VALUES ('74', 'admin/log/del', '删除日志', '1', '1', '2017-03-25 09:54:59');
INSERT INTO `system_node` VALUES ('75', 'admin/log', '系统日志1111q.', '0', '1', '2017-03-25 10:56:53');
INSERT INTO `system_node` VALUES ('76', 'wechat', '微信管理', '0', '1', '2017-04-05 10:52:31');
INSERT INTO `system_node` VALUES ('77', 'wechat/article', '微信文章', '0', '1', '2017-04-05 10:52:47');
INSERT INTO `system_node` VALUES ('78', 'wechat/article/index', '文章列表', '1', '1', '2017-04-05 10:52:54');
INSERT INTO `system_node` VALUES ('79', 'wechat/config', '微信配置', '0', '1', '2017-04-05 10:53:02');
INSERT INTO `system_node` VALUES ('80', 'wechat/config/index', '微信接口配置', '0', '1', '2017-04-05 10:53:16');
INSERT INTO `system_node` VALUES ('81', 'wechat/config/pay', '微信支付配置', '0', '1', '2017-04-05 10:53:18');
INSERT INTO `system_node` VALUES ('82', 'wechat/fans', '微信粉丝', '0', '1', '2017-04-05 10:53:34');
INSERT INTO `system_node` VALUES ('83', 'wechat/fans/index', '粉丝列表', '1', '1', '2017-04-05 10:53:39');
INSERT INTO `system_node` VALUES ('84', 'wechat/index', '微信主页', '0', '1', '2017-04-05 10:53:49');
INSERT INTO `system_node` VALUES ('85', 'wechat/index/index', '微信主页', '1', '1', '2017-04-05 10:53:49');
INSERT INTO `system_node` VALUES ('86', 'wechat/keys', '微信关键字', '0', '1', '2017-04-05 10:54:00');
INSERT INTO `system_node` VALUES ('87', 'wechat/keys/index', '关键字列表', '1', '1', '2017-04-05 10:54:14');
INSERT INTO `system_node` VALUES ('88', 'wechat/keys/subscribe', '关键自动回复', '0', '1', '2017-04-05 10:54:23');
INSERT INTO `system_node` VALUES ('89', 'wechat/keys/defaults', '默认自动回复', '0', '1', '2017-04-05 10:54:29');
INSERT INTO `system_node` VALUES ('90', 'wechat/menu', '微信菜单管理', '0', '1', '2017-04-05 10:54:34');
INSERT INTO `system_node` VALUES ('91', 'wechat/menu/index', '微信菜单', '0', '1', '2017-04-05 10:54:41');
INSERT INTO `system_node` VALUES ('92', 'wechat/news', '微信图文管理', '0', '1', '2017-04-05 10:54:51');
INSERT INTO `system_node` VALUES ('93', 'wechat/news/index', '图文列表', '0', '1', '2017-04-05 10:54:59');
INSERT INTO `system_node` VALUES ('94', 'wechat/notify/index', '', '0', '0', '2017-04-05 17:59:20');
INSERT INTO `system_node` VALUES ('95', 'wechat/api/index', '', '1', '1', '2017-04-06 09:30:28');
INSERT INTO `system_node` VALUES ('96', 'wechat/api', '', '0', '1', '2017-04-06 10:11:23');
INSERT INTO `system_node` VALUES ('97', 'wechat/notify', '', '0', '1', '2017-04-10 10:37:33');
INSERT INTO `system_node` VALUES ('98', 'wechat/fans/sync', '同步粉丝', '0', '0', '2017-04-13 16:30:29');
INSERT INTO `system_node` VALUES ('99', 'wechat/menu/edit', '编辑微信菜单', '0', '1', '2017-04-19 23:36:52');
INSERT INTO `system_node` VALUES ('100', 'wechat/menu/cancel', '取消微信菜单', '0', '1', '2017-04-19 23:36:54');
INSERT INTO `system_node` VALUES ('101', 'wechat/keys/edit', '编辑关键字', '1', '1', '2017-04-21 10:24:09');
INSERT INTO `system_node` VALUES ('102', 'wechat/keys/add', '添加关键字', '1', '1', '2017-04-21 10:24:09');
INSERT INTO `system_node` VALUES ('103', 'wechat/review/index', null, '0', '1', '2017-04-21 10:24:11');
INSERT INTO `system_node` VALUES ('104', 'wechat/review', '', '0', '1', '2017-04-21 10:24:18');
INSERT INTO `system_node` VALUES ('105', 'wechat/keys/del', '删除关键字', '0', '1', '2017-04-21 14:22:31');
INSERT INTO `system_node` VALUES ('106', 'wechat/news/add', '添加图文', '0', '1', '2017-04-22 22:17:29');
INSERT INTO `system_node` VALUES ('107', 'wechat/news/select', '图文选择器', '1', '1', '2017-04-22 22:17:31');
INSERT INTO `system_node` VALUES ('108', 'wechat/keys/resume', '启用关键字', '0', '1', '2017-04-25 11:03:52');
INSERT INTO `system_node` VALUES ('109', 'wechat/news/edit', '编辑', '0', '1', '2017-04-25 16:15:23');
INSERT INTO `system_node` VALUES ('110', 'wechat/news/push', '推送图文2', '0', '1', '2017-04-25 22:32:08');
INSERT INTO `system_node` VALUES ('111', 'wechat/news/del', '删除图文', '0', '1', '2017-04-26 10:48:24');
INSERT INTO `system_node` VALUES ('112', 'wechat/keys/forbid', '禁用关键字', '0', '1', '2017-04-26 10:48:28');
INSERT INTO `system_node` VALUES ('113', 'wechat/tags/index', '标签', '1', '1', '2017-05-04 16:03:37');
INSERT INTO `system_node` VALUES ('114', 'wechat/tags/add', '添加标签', '1', '1', '2017-05-05 12:48:28');
INSERT INTO `system_node` VALUES ('115', 'wechat/tags/edit', '编辑标签', '1', '1', '2017-05-05 12:48:29');
INSERT INTO `system_node` VALUES ('116', 'wechat/tags/sync', '同步标签', '0', '1', '2017-05-05 12:48:30');
INSERT INTO `system_node` VALUES ('117', 'wechat/tags', '粉丝标签管理', '0', '1', '2017-05-05 13:17:12');
INSERT INTO `system_node` VALUES ('118', 'wechat/fans/backdel', '移除粉丝黑名单', '1', '1', '2017-05-05 16:56:23');
INSERT INTO `system_node` VALUES ('119', 'wechat/fans/backadd', '移入粉丝黑名单', '1', '0', '2017-05-05 16:56:30');
INSERT INTO `system_node` VALUES ('120', 'wechat/fans/back', '粉丝黑名单列表', '1', '1', '2017-05-05 16:56:38');
INSERT INTO `system_node` VALUES ('121', 'wechat/fans/tagadd', '添加粉丝标签', '0', '1', '2017-05-08 14:46:13');
INSERT INTO `system_node` VALUES ('122', 'wechat/fans/tagdel', '删除粉丝标签', '0', '1', '2017-05-08 14:46:20');
INSERT INTO `system_node` VALUES ('123', 'wechat/fans/tagset', '', '1', '0', '2017-05-16 17:59:09');
INSERT INTO `system_node` VALUES ('124', 'wechat/news/image', '', '1', '1', '2017-05-22 15:24:41');

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
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='系统序号表';

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
INSERT INTO `system_user` VALUES ('10000', 'admin', '21232f297a57a5a743894a0e4a801fc3', '22222222', '11111@qq.com', '18916163635', 'ss5411111111111111111123123123123', '20686', '2017-07-07 18:26:59', '1', '196,198,200', '0', null, '2015-11-13 15:14:22');

-- ----------------------------
-- Table structure for wechat_fans
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans`;
CREATE TABLE `wechat_fans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '粉丝表ID',
  `appid` varchar(50) DEFAULT NULL COMMENT '公众号Appid',
  `groupid` bigint(20) unsigned DEFAULT NULL COMMENT '分组ID',
  `tagid_list` varchar(100) DEFAULT '' COMMENT '标签id',
  `is_back` tinyint(1) unsigned DEFAULT '0' COMMENT '是否为黑名单用户',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号，0：未关注，1：已关注',
  `openid` char(100) NOT NULL DEFAULT '' COMMENT '用户的标识，对当前公众号唯一',
  `spread_openid` char(100) DEFAULT NULL COMMENT '推荐人OPENID',
  `spread_at` datetime DEFAULT NULL,
  `nickname` varchar(20) DEFAULT NULL COMMENT '用户的昵称',
  `sex` tinyint(1) unsigned DEFAULT NULL COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `country` varchar(50) DEFAULT NULL COMMENT '用户所在国家',
  `province` varchar(50) DEFAULT NULL COMMENT '用户所在省份',
  `city` varchar(50) DEFAULT NULL COMMENT '用户所在城市',
  `language` varchar(50) DEFAULT NULL COMMENT '用户的语言，简体中文为zh_CN',
  `headimgurl` varchar(500) DEFAULT NULL COMMENT '用户头像',
  `subscribe_time` bigint(20) unsigned DEFAULT NULL COMMENT '用户关注时间',
  `subscribe_at` datetime DEFAULT NULL COMMENT '关注时间',
  `unionid` varchar(100) DEFAULT NULL COMMENT 'unionid',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注',
  `expires_in` bigint(20) unsigned DEFAULT '0' COMMENT '有效时间',
  `refresh_token` varchar(200) DEFAULT NULL COMMENT '刷新token',
  `access_token` varchar(200) DEFAULT NULL COMMENT '访问token',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_fans_spread_openid` (`spread_openid`) USING BTREE,
  KEY `index_wechat_fans_openid` (`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='微信粉丝';

-- ----------------------------
-- Table structure for wechat_fans_tags
-- ----------------------------
DROP TABLE IF EXISTS `wechat_fans_tags`;
CREATE TABLE `wechat_fans_tags` (
  `id` bigint(20) unsigned NOT NULL COMMENT '标签ID',
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `name` varchar(35) DEFAULT NULL COMMENT '标签名称',
  `count` int(11) unsigned DEFAULT NULL COMMENT '总数',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  KEY `index_wechat_fans_tags_id` (`id`) USING BTREE,
  KEY `index_wechat_fans_tags_appid` (`appid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信会员标签';

-- ----------------------------
-- Table structure for wechat_keys
-- ----------------------------
DROP TABLE IF EXISTS `wechat_keys`;
CREATE TABLE `wechat_keys` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `type` varchar(20) DEFAULT NULL COMMENT '类型，text 文件消息，image 图片消息，news 图文消息',
  `keys` varchar(100) DEFAULT NULL COMMENT '关键字',
  `content` text COMMENT '文本内容',
  `image_url` varchar(255) DEFAULT NULL COMMENT '图片链接',
  `voice_url` varchar(255) DEFAULT NULL COMMENT '语音链接',
  `music_title` varchar(100) DEFAULT NULL COMMENT '音乐标题',
  `music_url` varchar(255) DEFAULT NULL COMMENT '音乐链接',
  `music_image` varchar(255) DEFAULT NULL COMMENT '音乐缩略图链接',
  `music_desc` varchar(255) DEFAULT NULL COMMENT '音乐描述',
  `video_title` varchar(100) DEFAULT NULL COMMENT '视频标题',
  `video_url` varchar(255) DEFAULT NULL COMMENT '视频URL',
  `video_desc` varchar(255) DEFAULT NULL COMMENT '视频描述',
  `news_id` bigint(20) unsigned DEFAULT NULL COMMENT '图文ID',
  `sort` bigint(20) unsigned DEFAULT '0' COMMENT '排序字段',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '0 禁用，1 启用',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT=' 微信关键字';

-- ----------------------------
-- Table structure for wechat_menu
-- ----------------------------
DROP TABLE IF EXISTS `wechat_menu`;
CREATE TABLE `wechat_menu` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wechat_menu
-- ----------------------------
INSERT INTO `wechat_menu` VALUES ('1624', '1', '0', 'text', '关键字', '2234123413', '0', '1', '0', '2017-06-16 21:15:23');
INSERT INTO `wechat_menu` VALUES ('1625', '11', '1', 'keys', '图片', '图片', '0', '1', '0', '2017-06-16 21:15:23');
INSERT INTO `wechat_menu` VALUES ('1626', '12', '1', 'miniprogram', '小程序', '4123412341231,34123,412341', '1', '1', '0', '2017-06-16 21:15:23');
INSERT INTO `wechat_menu` VALUES ('1627', '2', '0', 'event', '事件类', 'pic_weixin', '1', '1', '0', '2017-06-16 21:15:23');
INSERT INTO `wechat_menu` VALUES ('1628', '3', '0', 'view', '微信支付', 'https://think.ctolog.com/index/wap/payjs', '2', '1', '0', '2017-06-16 21:15:23');

-- ----------------------------
-- Table structure for wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news`;
CREATE TABLE `wechat_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '永久素材显示URL',
  `article_id` varchar(60) DEFAULT NULL COMMENT '关联图文ID，用，号做分割',
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`),
  KEY `index_wechat_new_artcle_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='微信图文表';

-- ----------------------------
-- Table structure for wechat_news_article
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_article`;
CREATE TABLE `wechat_news_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '素材标题',
  `local_url` varchar(300) DEFAULT NULL COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) unsigned DEFAULT '0' COMMENT '是否显示封面 0不显示，1 显示',
  `author` varchar(20) DEFAULT NULL COMMENT '作者',
  `digest` varchar(300) DEFAULT NULL COMMENT '摘要内容',
  `content` longtext COMMENT '图文内容',
  `content_source_url` varchar(200) DEFAULT NULL COMMENT '图文消息原文地址',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='微信素材表';

-- ----------------------------
-- Table structure for wechat_news_image
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_image`;
CREATE TABLE `wechat_news_image` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `md5` varchar(32) DEFAULT NULL COMMENT '文件md5',
  `local_url` varchar(300) DEFAULT NULL COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT NULL COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_news_image_md5` (`md5`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='微信服务器图片';

-- ----------------------------
-- Table structure for wechat_news_media
-- ----------------------------
DROP TABLE IF EXISTS `wechat_news_media`;
CREATE TABLE `wechat_news_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) DEFAULT NULL COMMENT '公众号ID',
  `md5` varchar(32) DEFAULT NULL COMMENT '文件md5',
  `type` varchar(20) DEFAULT NULL COMMENT '媒体类型',
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT NULL COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='微信素材表';

-- ----------------------------
-- Table structure for wechat_pay_notify
-- ----------------------------
DROP TABLE IF EXISTS `wechat_pay_notify`;
CREATE TABLE `wechat_pay_notify` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) DEFAULT NULL COMMENT '公众号Appid',
  `bank_type` varchar(50) DEFAULT NULL COMMENT '银行类型',
  `cash_fee` bigint(20) DEFAULT NULL COMMENT '现金价',
  `fee_type` char(20) DEFAULT NULL COMMENT '币种，1人民币',
  `is_subscribe` char(1) DEFAULT 'N' COMMENT '是否关注，Y为关注，N为未关注',
  `mch_id` varchar(50) DEFAULT NULL COMMENT '商户MCH_ID',
  `nonce_str` varchar(32) DEFAULT NULL COMMENT '随机串',
  `openid` varchar(50) DEFAULT NULL COMMENT '微信用户openid',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '支付平台退款交易号',
  `sign` varchar(100) DEFAULT NULL COMMENT '签名',
  `time_end` datetime DEFAULT NULL COMMENT '结束时间',
  `result_code` varchar(10) DEFAULT NULL,
  `return_code` varchar(10) DEFAULT NULL,
  `total_fee` varchar(11) DEFAULT NULL COMMENT '支付总金额，单位为分',
  `trade_type` varchar(20) DEFAULT NULL COMMENT '支付方式',
  `transaction_id` varchar(64) DEFAULT NULL COMMENT '订单号',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '本地系统时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_pay_notify_openid` (`openid`) USING BTREE,
  KEY `index_wechat_pay_notify_out_trade_no` (`out_trade_no`) USING BTREE,
  KEY `index_wechat_pay_notify_transaction_id` (`transaction_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='支付日志表';

-- ----------------------------
-- Table structure for wechat_pay_prepayid
-- ----------------------------
DROP TABLE IF EXISTS `wechat_pay_prepayid`;
CREATE TABLE `wechat_pay_prepayid` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `from` char(32) DEFAULT 'shop' COMMENT '支付来源',
  `fee` bigint(20) unsigned DEFAULT NULL COMMENT '支付费用(分)',
  `trade_type` varchar(20) DEFAULT NULL COMMENT '订单类型',
  `order_no` varchar(50) DEFAULT NULL COMMENT '内部订单号',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '外部订单号',
  `prepayid` varchar(500) DEFAULT NULL COMMENT '预支付码',
  `expires_in` bigint(20) unsigned DEFAULT NULL COMMENT '有效时间',
  `transaction_id` varchar(64) DEFAULT NULL COMMENT '微信平台订单号',
  `is_pay` tinyint(1) unsigned DEFAULT '0' COMMENT '1已支付，0未支退款',
  `pay_at` datetime DEFAULT NULL COMMENT '支付时间',
  `is_refund` tinyint(1) unsigned DEFAULT '0' COMMENT '是否退款，退款单号(T+原来订单)',
  `refund_at` datetime DEFAULT NULL COMMENT '退款时间',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '本地系统时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_pay_prepayid_outer_no` (`out_trade_no`) USING BTREE,
  KEY `index_wechat_pay_prepayid_order_no` (`order_no`) USING BTREE,
  KEY `index_wechat_pay_is_pay` (`is_pay`) USING BTREE,
  KEY `index_wechat_pay_is_refund` (`is_refund`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='支付订单号对应表';