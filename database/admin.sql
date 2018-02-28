/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : zmzfang

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-03-17 18:33:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `controller_id` varchar(20) DEFAULT NULL COMMENT '控制器ID',
  `action_id` varchar(20) DEFAULT NULL COMMENT '方法ID',
  `url` varchar(200) DEFAULT NULL COMMENT '访问地址',
  `module_name` varchar(50) DEFAULT NULL COMMENT '模块',
  `func_name` varchar(50) DEFAULT NULL COMMENT '功能',
  `right_name` varchar(50) DEFAULT NULL COMMENT '方法',
  `client_ip` varchar(15) DEFAULT NULL COMMENT '客户端IP',
  `create_user` varchar(50) DEFAULT NULL COMMENT '用户',
  `create_date` datetime DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `index_create_date` (`create_date`),
  KEY `index_create_index` (`create_user`),
  KEY `index_url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_log
-- ----------------------------
INSERT INTO `admin_log` VALUES ('1', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-02-28 04:53:48');
INSERT INTO `admin_log` VALUES ('2', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-02-28 04:53:49');
INSERT INTO `admin_log` VALUES ('3', 'admin-role', 'index', 'admin-role/index', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-02-28 04:53:52');
INSERT INTO `admin_log` VALUES ('4', 'admin-user', 'index', 'admin-user/index', '菜单用户权限', '用户管理', '用户操作', '127.0.0.1', 'admin', '2017-02-28 04:53:59');
INSERT INTO `admin_log` VALUES ('5', 'admin-log', 'index', 'admin-log/index', '日志管理', '操作日志', '操作', '127.0.0.1', 'admin', '2017-02-28 04:54:08');
INSERT INTO `admin_log` VALUES ('6', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:22:08');
INSERT INTO `admin_log` VALUES ('7', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:25:25');
INSERT INTO `admin_log` VALUES ('8', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:25:26');
INSERT INTO `admin_log` VALUES ('9', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:25:27');
INSERT INTO `admin_log` VALUES ('10', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:25:30');
INSERT INTO `admin_log` VALUES ('11', 'admin-menu', 'index', 'admin-menu/index', '菜单用户权限', '菜单管理', '二级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:25:33');
INSERT INTO `admin_log` VALUES ('12', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:25:37');
INSERT INTO `admin_log` VALUES ('13', 'admin-right', 'right-action', 'admin-right/right-action', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:25:46');
INSERT INTO `admin_log` VALUES ('14', 'admin-right', 'right-action', 'admin-right/right-action', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:26:56');
INSERT INTO `admin_log` VALUES ('15', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:27:01');
INSERT INTO `admin_log` VALUES ('16', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:27:06');
INSERT INTO `admin_log` VALUES ('17', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:28:22');
INSERT INTO `admin_log` VALUES ('18', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:28:33');
INSERT INTO `admin_log` VALUES ('19', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:29:18');
INSERT INTO `admin_log` VALUES ('20', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:29:23');
INSERT INTO `admin_log` VALUES ('21', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:29:26');
INSERT INTO `admin_log` VALUES ('22', 'admin-menu', 'index', 'admin-menu/index', '菜单用户权限', '菜单管理', '二级菜单查看', '127.0.0.1', 'admin', '2017-03-17 06:29:31');
INSERT INTO `admin_log` VALUES ('23', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:29:36');
INSERT INTO `admin_log` VALUES ('24', 'admin-right', 'right-action', 'admin-right/right-action', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:29:40');
INSERT INTO `admin_log` VALUES ('25', 'admin-right', 'create', 'admin-right/create', '菜单用户权限', '菜单管理', '路由添加', '127.0.0.1', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_log` VALUES ('26', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 06:29:58');
INSERT INTO `admin_log` VALUES ('27', 'admin-user', 'index', 'admin-user/index', '菜单用户权限', '用户管理', '用户操作', '127.0.0.1', 'admin', '2017-03-17 06:30:03');
INSERT INTO `admin_log` VALUES ('28', 'admin-role', 'index', 'admin-role/index', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 06:30:06');
INSERT INTO `admin_log` VALUES ('29', 'admin-role', 'get-all-rights', 'admin-role/get-all-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 06:30:10');
INSERT INTO `admin_log` VALUES ('30', 'admin-role', 'save-rights', 'admin-role/save-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 06:30:13');
INSERT INTO `admin_log` VALUES ('31', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:30:33');
INSERT INTO `admin_log` VALUES ('32', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:31:15');
INSERT INTO `admin_log` VALUES ('33', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:32:00');
INSERT INTO `admin_log` VALUES ('34', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:36:17');
INSERT INTO `admin_log` VALUES ('35', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:36:21');
INSERT INTO `admin_log` VALUES ('36', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:37:57');
INSERT INTO `admin_log` VALUES ('37', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:39:34');
INSERT INTO `admin_log` VALUES ('38', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:40:44');
INSERT INTO `admin_log` VALUES ('39', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:40:51');
INSERT INTO `admin_log` VALUES ('40', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:40:57');
INSERT INTO `admin_log` VALUES ('41', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:41:54');
INSERT INTO `admin_log` VALUES ('42', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:41:57');
INSERT INTO `admin_log` VALUES ('43', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:42:13');
INSERT INTO `admin_log` VALUES ('44', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:42:36');
INSERT INTO `admin_log` VALUES ('45', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:43:39');
INSERT INTO `admin_log` VALUES ('46', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:43:44');
INSERT INTO `admin_log` VALUES ('47', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:44:26');
INSERT INTO `admin_log` VALUES ('48', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:44:34');
INSERT INTO `admin_log` VALUES ('49', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:44:35');
INSERT INTO `admin_log` VALUES ('50', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:44:39');
INSERT INTO `admin_log` VALUES ('51', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:44:55');
INSERT INTO `admin_log` VALUES ('52', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:45:03');
INSERT INTO `admin_log` VALUES ('53', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:45:15');
INSERT INTO `admin_log` VALUES ('54', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 06:45:19');
INSERT INTO `admin_log` VALUES ('55', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:11:09');
INSERT INTO `admin_log` VALUES ('56', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:11:17');
INSERT INTO `admin_log` VALUES ('57', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:11:48');
INSERT INTO `admin_log` VALUES ('58', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:14:53');
INSERT INTO `admin_log` VALUES ('59', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:15:02');
INSERT INTO `admin_log` VALUES ('60', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:15:04');
INSERT INTO `admin_log` VALUES ('61', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:15:13');
INSERT INTO `admin_log` VALUES ('62', 'help', 'delete', 'help/delete', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:15:19');
INSERT INTO `admin_log` VALUES ('63', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 07:18:21');
INSERT INTO `admin_log` VALUES ('64', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:28:00');
INSERT INTO `admin_log` VALUES ('65', 'help', 'view', 'help/view', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:35:33');
INSERT INTO `admin_log` VALUES ('66', 'help', 'view', 'help/view', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:35:43');
INSERT INTO `admin_log` VALUES ('67', 'help', 'view', 'help/view', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:35:52');
INSERT INTO `admin_log` VALUES ('68', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:36:22');
INSERT INTO `admin_log` VALUES ('69', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:40:16');
INSERT INTO `admin_log` VALUES ('70', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:41:28');
INSERT INTO `admin_log` VALUES ('71', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:57:03');
INSERT INTO `admin_log` VALUES ('72', 'help', 'view', 'help/view', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:57:13');
INSERT INTO `admin_log` VALUES ('73', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:57:36');
INSERT INTO `admin_log` VALUES ('74', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:57:54');
INSERT INTO `admin_log` VALUES ('75', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:58:20');
INSERT INTO `admin_log` VALUES ('76', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 08:59:00');
INSERT INTO `admin_log` VALUES ('77', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:04:06');
INSERT INTO `admin_log` VALUES ('78', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:04:11');
INSERT INTO `admin_log` VALUES ('79', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:04:28');
INSERT INTO `admin_log` VALUES ('80', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:06:30');
INSERT INTO `admin_log` VALUES ('81', 'help', 'create', 'help/create', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:06:39');
INSERT INTO `admin_log` VALUES ('82', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:06:50');
INSERT INTO `admin_log` VALUES ('83', 'help', 'update', 'help/update', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:06:54');
INSERT INTO `admin_log` VALUES ('84', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:07:01');
INSERT INTO `admin_log` VALUES ('85', 'help', 'update', 'help/update', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:07:06');
INSERT INTO `admin_log` VALUES ('86', 'help', 'update', 'help/update', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:07:10');
INSERT INTO `admin_log` VALUES ('87', 'help', 'update', 'help/update', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:07:24');
INSERT INTO `admin_log` VALUES ('88', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 09:08:58');
INSERT INTO `admin_log` VALUES ('89', 'admin-role', 'index', 'admin-role/index', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 09:09:02');
INSERT INTO `admin_log` VALUES ('90', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 09:09:04');
INSERT INTO `admin_log` VALUES ('91', 'admin-menu', 'index', 'admin-menu/index', '菜单用户权限', '菜单管理', '二级菜单查看', '127.0.0.1', 'admin', '2017-03-17 09:09:08');
INSERT INTO `admin_log` VALUES ('92', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 09:11:41');
INSERT INTO `admin_log` VALUES ('93', 'admin-menu', 'index', 'admin-menu/index', '菜单用户权限', '菜单管理', '二级菜单查看', '127.0.0.1', 'admin', '2017-03-17 09:11:47');
INSERT INTO `admin_log` VALUES ('94', 'admin-right', 'index', 'admin-right/index', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 09:11:50');
INSERT INTO `admin_log` VALUES ('95', 'admin-right', 'right-action', 'admin-right/right-action', '菜单用户权限', '菜单管理', '路由查看', '127.0.0.1', 'admin', '2017-03-17 09:11:53');
INSERT INTO `admin_log` VALUES ('96', 'admin-user', 'index', 'admin-user/index', '菜单用户权限', '用户管理', '用户操作', '127.0.0.1', 'admin', '2017-03-17 09:20:34');
INSERT INTO `admin_log` VALUES ('97', 'admin-user', 'view', 'admin-user/view', '菜单用户权限', '用户管理', '用户操作', '127.0.0.1', 'admin', '2017-03-17 09:20:40');
INSERT INTO `admin_log` VALUES ('98', 'admin-role', 'index', 'admin-role/index', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 09:20:44');
INSERT INTO `admin_log` VALUES ('99', 'admin-role', 'get-all-rights', 'admin-role/get-all-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 09:20:48');
INSERT INTO `admin_log` VALUES ('100', 'admin-role', 'save-rights', 'admin-role/save-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 09:21:09');
INSERT INTO `admin_log` VALUES ('101', 'admin-role', 'get-all-rights', 'admin-role/get-all-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 09:21:15');
INSERT INTO `admin_log` VALUES ('102', 'admin-role', 'index', 'admin-role/index', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 09:22:20');
INSERT INTO `admin_log` VALUES ('103', 'district', 'index', 'district/index', '模块管理', '小区管理', '小区管理', '127.0.0.1', 'admin', '2017-03-17 09:23:23');
INSERT INTO `admin_log` VALUES ('104', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 09:28:12');
INSERT INTO `admin_log` VALUES ('105', 'district', 'index', 'district/index', '模块管理', '小区管理', '小区管理', '127.0.0.1', 'admin', '2017-03-17 09:28:15');
INSERT INTO `admin_log` VALUES ('106', 'district', 'index', 'district/index', '模块管理', '小区管理', '小区管理', '127.0.0.1', 'admin', '2017-03-17 09:28:39');
INSERT INTO `admin_log` VALUES ('107', 'admin-module', 'index', 'admin-module/index', '菜单用户权限', '菜单管理', '一级菜单查看', '127.0.0.1', 'admin', '2017-03-17 10:17:34');
INSERT INTO `admin_log` VALUES ('108', 'admin-role', 'index', 'admin-role/index', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 10:17:51');
INSERT INTO `admin_log` VALUES ('109', 'admin-role', 'get-all-rights', 'admin-role/get-all-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 10:17:59');
INSERT INTO `admin_log` VALUES ('110', 'admin-role', 'save-rights', 'admin-role/save-rights', '菜单用户权限', '角色管理', '分配权限', '127.0.0.1', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_log` VALUES ('111', 'help', 'index', 'help/index', '模块管理', '求助管理', '求助管理', '127.0.0.1', 'admin', '2017-03-17 10:18:33');
INSERT INTO `admin_log` VALUES ('112', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:24:03');
INSERT INTO `admin_log` VALUES ('113', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:24:11');
INSERT INTO `admin_log` VALUES ('114', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:24:16');
INSERT INTO `admin_log` VALUES ('115', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:24:52');
INSERT INTO `admin_log` VALUES ('116', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:25:29');
INSERT INTO `admin_log` VALUES ('117', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:26:00');
INSERT INTO `admin_log` VALUES ('118', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:26:13');
INSERT INTO `admin_log` VALUES ('119', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:27:04');
INSERT INTO `admin_log` VALUES ('120', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:27:21');
INSERT INTO `admin_log` VALUES ('121', 'requirement', 'index', 'requirement/index', '模块管理', '求购管理', '求购管理', '127.0.0.1', 'admin', '2017-03-17 10:28:08');

-- ----------------------------
-- Table structure for `admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(50) NOT NULL COMMENT 'code',
  `menu_name` varchar(200) NOT NULL COMMENT '名称',
  `module_id` int(11) NOT NULL COMMENT '模块id',
  `display_label` varchar(200) DEFAULT NULL COMMENT '显示名',
  `des` varchar(400) DEFAULT NULL COMMENT '描述',
  `display_order` int(5) DEFAULT NULL COMMENT '显示顺序',
  `entry_right_name` varchar(50) DEFAULT NULL COMMENT '入口地址名称',
  `entry_url` varchar(200) NOT NULL COMMENT '入口地址',
  `action` varchar(50) NOT NULL COMMENT '操作ID',
  `controller` varchar(100) NOT NULL COMMENT '控制器ID',
  `has_lef` varchar(1) NOT NULL DEFAULT 'n' COMMENT '是否有子',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_code` (`code`),
  KEY `fk_module_id` (`module_id`),
  CONSTRAINT `fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `admin_module` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', 'menu_manger', '菜单管理', '1', '菜单管理', '菜单管理', '1', '菜单管理', 'admin-module/index', 'index', 'backend\\controllers\\AdminMenuController', 'n', 'admin', '2016-08-11 16:44:11', 'admin', '2016-08-11 16:44:11');
INSERT INTO `admin_menu` VALUES ('2', 'menu_role', '角色管理', '1', '角色管理', '角色管理', '2', '角色管理', 'admin-role/index', 'index', 'backend\\controllers\\AdminRoleController', 'n', 'admin', '2016-08-11 16:51:56', 'admin', '2016-08-11 16:51:56');
INSERT INTO `admin_menu` VALUES ('3', 'menu_user', '用户管理', '1', '用户管理', '用户管理', '3', '用户管理', 'admin-user/index', 'index', 'backend\\controllers\\AdminUserController', 'n', 'admin', '2016-08-11 16:58:43', 'admin', '2016-08-11 16:58:43');
INSERT INTO `admin_menu` VALUES ('4', 'coazaorizhi', '操作日志', '2', '操作日志', '操作日志', '1', '', 'admin-log/index', 'index', 'backend\\controllers\\AdminLogController', 'n', 'test', '2016-08-14 06:54:17', 'test', '2016-08-14 06:54:17');
INSERT INTO `admin_menu` VALUES ('5', 'help', '求助管理', '3', '求助管理', '求助管理', '1', '求助管理', 'help/index', 'index', 'backend\\controllers\\HelpController', 'n', 'admin', '2017-03-17 14:23:59', 'admin', '2017-03-17 14:24:14');
INSERT INTO `admin_menu` VALUES ('6', 'district', '小区管理', '3', '小区管理', '小区管理', '2', '小区管理', 'district/index', 'index', 'backend\\controllers\\DistrictController', 'n', 'admin', '2017-03-17 17:11:23', 'admin', '2017-03-17 17:11:29');
INSERT INTO `admin_menu` VALUES ('7', 'requirement', '求购管理', '3', '求购管理', '求购管理', '3', '求购管理', 'requirement/index', 'index', 'backendcontrllersRequirementController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('8', 'user', '用户管理', '3', '用户管理', '用户管理', '4', '用户管理', 'user/index', 'index', 'backendcontrllersUserController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('9', 'house', '房源管理', '3', '房源管理', '房源管理', '5', '房源管理', 'house/index', 'index', 'backendcontrllersHouseController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('10', 'bid', '投标管理', '3', '投标管理', '投标管理', '6', '投标管理', 'bid/index', 'index', 'backendcontrllersBidController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('11', 'metro', '地铁管理', '3', '地铁管理', '地铁管理', '7', '地铁管理', 'metro/index', 'index', 'backendcontrllersMetroController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('12', 'expert', '专家管理', '3', '专家管理', '专家管理', '8', '专家管理', 'expert/index', 'index', 'backendcontrllersExpertController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('13', 'appoint', '约见管理', '3', '约见管理', '约见管理', '9', '约见管理', 'appoint/index', 'index', 'backendcontrllersAppointController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('14', 'question', '快问管理', '3', '快问管理', '快问管理', '10', '快问管理', 'question/index', 'index', 'backendcontrllersQuestionController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('15', 'order', '支付管理', '3', '支付管理', '支付管理', '11', '支付管理', 'order/index', 'index', 'backendcontrllersOrderController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');
INSERT INTO `admin_menu` VALUES ('16', 'topic', '话题管理', '3', '话题管理', '话题管理', '12', '话题管理', 'topic/index', 'index', 'backendcontrllersTopicController', 'n', 'admin', '2017-03-17 09:59:01', 'admin', '2017-03-17 09:59:01');

-- ----------------------------
-- Table structure for `admin_message`
-- ----------------------------
DROP TABLE IF EXISTS `admin_message`;
CREATE TABLE `admin_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `msg` varchar(1000) DEFAULT NULL COMMENT '留言内容',
  `expiry_days` int(5) unsigned DEFAULT NULL COMMENT '有效天数',
  `create_user` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(50) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_message
-- ----------------------------
INSERT INTO `admin_message` VALUES ('1', '测试文本', '1', 'admin', '2014-11-21 18:47:20', 'admin', '2014-11-21 18:47:27');

-- ----------------------------
-- Table structure for `admin_module`
-- ----------------------------
DROP TABLE IF EXISTS `admin_module`;
CREATE TABLE `admin_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(50) NOT NULL COMMENT 'code',
  `display_label` varchar(200) NOT NULL COMMENT '显示名称',
  `has_lef` varchar(1) NOT NULL DEFAULT 'n' COMMENT '是否有子',
  `des` varchar(400) DEFAULT NULL COMMENT '描述',
  `entry_url` varchar(100) DEFAULT NULL COMMENT '入口地址',
  `display_order` int(5) DEFAULT NULL COMMENT '顺序',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_module
-- ----------------------------
INSERT INTO `admin_module` VALUES ('1', 'menu_manage', '菜单用户权限', 'n', '菜单管理', '', '1', 'admin', '2016-08-11 15:26:21', 'admin', '2016-08-11 16:31:08');
INSERT INTO `admin_module` VALUES ('2', 'rizhimaanage', '日志管理', 'n', '日志管理', '', '2', 'test', '2016-08-14 06:53:13', 'test', '2016-08-14 06:53:13');
INSERT INTO `admin_module` VALUES ('3', 'mokuaimanage', '模块管理', 'n', '模块管理', null, '3', 'admin', '2017-03-17 14:25:08', 'admin', '2017-03-17 14:25:14');

-- ----------------------------
-- Table structure for `admin_right`
-- ----------------------------
DROP TABLE IF EXISTS `admin_right`;
CREATE TABLE `admin_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `menu_id` int(11) NOT NULL COMMENT '功能主键',
  `right_name` varchar(200) NOT NULL COMMENT '名称',
  `display_label` varchar(200) DEFAULT NULL COMMENT '显示名',
  `des` varchar(200) DEFAULT NULL COMMENT '描述',
  `display_order` int(5) DEFAULT NULL COMMENT '显示顺序',
  `has_lef` varchar(1) NOT NULL DEFAULT 'n' COMMENT '是否有子',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `FK_admin_right` (`menu_id`),
  KEY `index_menu_id` (`menu_id`),
  CONSTRAINT `FK_admin_right` FOREIGN KEY (`menu_id`) REFERENCES `admin_menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_right
-- ----------------------------
INSERT INTO `admin_right` VALUES ('4', '2', '角色操作', '角色操作', '角色操作', '1', 'n', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right` VALUES ('5', '2', '分配用户', '分配用户', '分配用户', '2', 'n', 'admin', '2016-08-13 17:05:04', 'test', '2016-08-14 08:22:13');
INSERT INTO `admin_right` VALUES ('6', '2', '分配权限', '分配权限', '分配权限', '3', 'n', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right` VALUES ('7', '3', '用户操作', '用户操作', '用户操作', '1', 'n', 'admin', '2016-08-13 17:05:57', 'admin', '2016-08-13 17:05:57');
INSERT INTO `admin_right` VALUES ('8', '4', '操作', '操作', '操作', '1', 'n', 'test', '2016-08-14 06:54:38', 'test', '2016-08-14 06:54:38');
INSERT INTO `admin_right` VALUES ('13', '1', '一级菜单查看', '一级菜单查看', '一级菜单查看', '1', 'n', 'test', '2016-08-16 15:52:45', 'test', '2016-08-16 15:52:45');
INSERT INTO `admin_right` VALUES ('14', '1', '一级菜单添加', '一级菜单添加', '一级菜单添加', '2', 'n', 'test', '2016-08-16 15:53:10', 'test', '2016-08-16 15:58:30');
INSERT INTO `admin_right` VALUES ('15', '1', '一级菜单删除', '一级菜单删除', '一级菜单删除', '3', 'n', 'test', '2016-08-16 15:53:44', 'test', '2016-08-16 15:53:44');
INSERT INTO `admin_right` VALUES ('16', '1', '二级菜单查看', '二级菜单查看', '二级菜单查看', '4', 'n', 'test', '2016-08-16 15:55:02', 'test', '2016-08-16 15:55:02');
INSERT INTO `admin_right` VALUES ('17', '1', '二级菜单添加', '二级菜单修改', '二级菜单添加', '5', 'n', 'test', '2016-08-16 15:55:21', 'test', '2016-08-16 15:58:50');
INSERT INTO `admin_right` VALUES ('18', '1', '二级菜单删除', '二级菜单删除', '二级菜单删除', '6', 'n', 'test', '2016-08-16 15:55:58', 'test', '2016-08-16 15:55:58');
INSERT INTO `admin_right` VALUES ('19', '1', '路由查看', '路由查看', '路由查看', '7', 'n', 'test', '2016-08-16 15:56:32', 'test', '2016-08-16 15:57:14');
INSERT INTO `admin_right` VALUES ('20', '1', '路由添加', '路由添加', '路由添加', '8', 'n', 'test', '2016-08-16 15:57:46', 'test', '2016-08-16 15:57:46');
INSERT INTO `admin_right` VALUES ('21', '1', '路由删除', '路由删除', '路由删除', '9', 'n', 'test', '2016-08-16 15:58:05', 'test', '2016-08-16 15:58:05');
INSERT INTO `admin_right` VALUES ('22', '5', '求助管理', '求助管理', '求助管理', '1', 'n', 'admin', '2017-03-17 06:29:57', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right` VALUES ('23', '6', '小区管理', '小区管理', '小区管理', '2', 'n', 'admin', '2017-03-17 17:14:01', 'admin', '2017-03-17 17:14:05');
INSERT INTO `admin_right` VALUES ('24', '7', '求购管理', '求购管理', '求购管理', '3', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('25', '8', '用户管理', '用户管理', '用户管理', '4', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('26', '9', '房源管理', '房源管理', '房源管理', '5', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('27', '10', '投标管理', '投标管理', '投标管理', '6', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('28', '11', '地铁管理', '地铁管理', '地铁管理', '7', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('29', '12', '专家管理', '专家管理', '专家管理', '8', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('30', '13', '约见管理', '约见管理', '约见管理', '9', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('31', '14', '快问管理', '快问管理', '快问管理', '10', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('32', '15', '支付管理', '支付管理', '支付管理', '11', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');
INSERT INTO `admin_right` VALUES ('33', '16', '话题管理', '话题管理', '话题管理', '12', 'n', 'admin', '2017-03-17 10:06:52', 'admin', '2017-03-17 10:06:52');

-- ----------------------------
-- Table structure for `admin_right_url`
-- ----------------------------
DROP TABLE IF EXISTS `admin_right_url`;
CREATE TABLE `admin_right_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `right_id` int(11) NOT NULL COMMENT 'right主键',
  `url` varchar(200) DEFAULT NULL COMMENT 'url',
  `para_name` varchar(40) DEFAULT NULL COMMENT '参数名',
  `para_value` varchar(40) DEFAULT NULL COMMENT '参数值',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `FK_admin_right_url` (`right_id`),
  KEY `index_right_id` (`right_id`),
  CONSTRAINT `FK_admin_right_url` FOREIGN KEY (`right_id`) REFERENCES `admin_right` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_right_url
-- ----------------------------
INSERT INTO `admin_right_url` VALUES ('16', '4', 'admin-role/index', 'admin-role', 'index', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('17', '4', 'admin-role/view', 'admin-role', 'view', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('18', '4', 'admin-role/create', 'admin-role', 'create', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('19', '4', 'admin-role/update', 'admin-role', 'update', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('20', '4', 'admin-role/delete', 'admin-role', 'delete', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('21', '4', 'admin-role/get-all-rights', 'admin-role', 'get-all-rights', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('22', '4', 'admin-role/save-rights', 'admin-role', 'save-rights', 'admin', '2016-08-13 17:04:40', 'admin', '2016-08-13 17:04:40');
INSERT INTO `admin_right_url` VALUES ('30', '6', 'admin-role/index', 'admin-role', 'index', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('31', '6', 'admin-role/view', 'admin-role', 'view', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('32', '6', 'admin-role/create', 'admin-role', 'create', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('33', '6', 'admin-role/update', 'admin-role', 'update', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('34', '6', 'admin-role/delete', 'admin-role', 'delete', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('35', '6', 'admin-role/get-all-rights', 'admin-role', 'get-all-rights', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('36', '6', 'admin-role/save-rights', 'admin-role', 'save-rights', 'admin', '2016-08-13 17:05:24', 'admin', '2016-08-13 17:05:24');
INSERT INTO `admin_right_url` VALUES ('37', '7', 'admin-user/index', 'admin-user', 'index', 'admin', '2016-08-13 17:05:57', 'admin', '2016-08-13 17:05:57');
INSERT INTO `admin_right_url` VALUES ('38', '7', 'admin-user/view', 'admin-user', 'view', 'admin', '2016-08-13 17:05:57', 'admin', '2016-08-13 17:05:57');
INSERT INTO `admin_right_url` VALUES ('39', '7', 'admin-user/create', 'admin-user', 'create', 'admin', '2016-08-13 17:05:57', 'admin', '2016-08-13 17:05:57');
INSERT INTO `admin_right_url` VALUES ('40', '7', 'admin-user/update', 'admin-user', 'update', 'admin', '2016-08-13 17:05:57', 'admin', '2016-08-13 17:05:57');
INSERT INTO `admin_right_url` VALUES ('41', '7', 'admin-user/delete', 'admin-user', 'delete', 'admin', '2016-08-13 17:05:57', 'admin', '2016-08-13 17:05:57');
INSERT INTO `admin_right_url` VALUES ('42', '8', 'admin-log/index', 'admin-log', 'index', 'test', '2016-08-14 06:54:38', 'test', '2016-08-14 06:54:38');
INSERT INTO `admin_right_url` VALUES ('43', '8', 'admin-log/view', 'admin-log', 'view', 'test', '2016-08-14 06:54:38', 'test', '2016-08-14 06:54:38');
INSERT INTO `admin_right_url` VALUES ('44', '8', 'admin-log/create', 'admin-log', 'create', 'test', '2016-08-14 06:54:38', 'test', '2016-08-14 06:54:38');
INSERT INTO `admin_right_url` VALUES ('45', '8', 'admin-log/update', 'admin-log', 'update', 'test', '2016-08-14 06:54:38', 'test', '2016-08-14 06:54:38');
INSERT INTO `admin_right_url` VALUES ('46', '8', 'admin-log/delete', 'admin-log', 'delete', 'test', '2016-08-14 06:54:38', 'test', '2016-08-14 06:54:38');
INSERT INTO `admin_right_url` VALUES ('81', '5', 'admin-user-role/index', 'admin-user-role', 'index', 'test', '2016-08-14 08:22:13', 'test', '2016-08-14 08:22:13');
INSERT INTO `admin_right_url` VALUES ('82', '5', 'admin-user-role/view', 'admin-user-role', 'view', 'test', '2016-08-14 08:22:13', 'test', '2016-08-14 08:22:13');
INSERT INTO `admin_right_url` VALUES ('83', '5', 'admin-user-role/create', 'admin-user-role', 'create', 'test', '2016-08-14 08:22:13', 'test', '2016-08-14 08:22:13');
INSERT INTO `admin_right_url` VALUES ('84', '5', 'admin-user-role/update', 'admin-user-role', 'update', 'test', '2016-08-14 08:22:13', 'test', '2016-08-14 08:22:13');
INSERT INTO `admin_right_url` VALUES ('85', '5', 'admin-user-role/delete', 'admin-user-role', 'delete', 'test', '2016-08-14 08:22:13', 'test', '2016-08-14 08:22:13');
INSERT INTO `admin_right_url` VALUES ('112', '13', 'admin-module/index', 'admin-module', 'index', 'test', '2016-08-16 15:52:45', 'test', '2016-08-16 15:52:45');
INSERT INTO `admin_right_url` VALUES ('113', '13', 'admin-module/view', 'admin-module', 'view', 'test', '2016-08-16 15:52:45', 'test', '2016-08-16 15:52:45');
INSERT INTO `admin_right_url` VALUES ('115', '15', 'admin-module/delete', 'admin-module', 'delete', 'test', '2016-08-16 15:53:44', 'test', '2016-08-16 15:53:44');
INSERT INTO `admin_right_url` VALUES ('118', '16', 'admin-menu/index', 'admin-menu', 'index', 'test', '2016-08-16 15:55:02', 'test', '2016-08-16 15:55:02');
INSERT INTO `admin_right_url` VALUES ('119', '16', 'admin-menu/view', 'admin-menu', 'view', 'test', '2016-08-16 15:55:02', 'test', '2016-08-16 15:55:02');
INSERT INTO `admin_right_url` VALUES ('122', '18', 'admin-menu/delete', 'admin-menu', 'delete', 'test', '2016-08-16 15:55:58', 'test', '2016-08-16 15:55:58');
INSERT INTO `admin_right_url` VALUES ('125', '19', 'admin-right/index', 'admin-right', 'index', 'test', '2016-08-16 15:57:14', 'test', '2016-08-16 15:57:14');
INSERT INTO `admin_right_url` VALUES ('126', '19', 'admin-right/view', 'admin-right', 'view', 'test', '2016-08-16 15:57:14', 'test', '2016-08-16 15:57:14');
INSERT INTO `admin_right_url` VALUES ('127', '19', 'admin-right/right-action', 'admin-right', 'right-action', 'test', '2016-08-16 15:57:14', 'test', '2016-08-16 15:57:14');
INSERT INTO `admin_right_url` VALUES ('128', '20', 'admin-right/create', 'admin-right', 'create', 'test', '2016-08-16 15:57:46', 'test', '2016-08-16 15:57:46');
INSERT INTO `admin_right_url` VALUES ('129', '20', 'admin-right/update', 'admin-right', 'update', 'test', '2016-08-16 15:57:46', 'test', '2016-08-16 15:57:46');
INSERT INTO `admin_right_url` VALUES ('130', '21', 'admin-right/delete', 'admin-right', 'delete', 'test', '2016-08-16 15:58:05', 'test', '2016-08-16 15:58:05');
INSERT INTO `admin_right_url` VALUES ('131', '14', 'admin-module/create', 'admin-module', 'create', 'test', '2016-08-16 15:58:30', 'test', '2016-08-16 15:58:30');
INSERT INTO `admin_right_url` VALUES ('132', '14', 'admin-module/update', 'admin-module', 'update', 'test', '2016-08-16 15:58:30', 'test', '2016-08-16 15:58:30');
INSERT INTO `admin_right_url` VALUES ('133', '17', 'admin-menu/create', 'admin-menu', 'create', 'test', '2016-08-16 15:58:51', 'test', '2016-08-16 15:58:51');
INSERT INTO `admin_right_url` VALUES ('134', '17', 'admin-menu/update', 'admin-menu', 'update', 'test', '2016-08-16 15:58:51', 'test', '2016-08-16 15:58:51');
INSERT INTO `admin_right_url` VALUES ('135', '22', 'help/index', 'help', 'index', 'admin', '2017-03-17 06:29:57', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right_url` VALUES ('136', '22', 'help/view', 'help', 'view', 'admin', '2017-03-17 06:29:57', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right_url` VALUES ('137', '22', 'help/create', 'help', 'create', 'admin', '2017-03-17 06:29:57', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right_url` VALUES ('138', '22', 'help/update', 'help', 'update', 'admin', '2017-03-17 06:29:57', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right_url` VALUES ('139', '22', 'help/delete', 'help', 'delete', 'admin', '2017-03-17 06:29:57', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right_url` VALUES ('140', '23', 'district/index', 'district', 'index', 'admin', '2017-03-17 17:17:17', 'admin', '2017-03-17 06:29:57');
INSERT INTO `admin_right_url` VALUES ('141', '23', 'district/view', 'district', 'view', 'admin', '2017-03-17 17:18:36', 'admin', '2017-03-17 17:18:38');
INSERT INTO `admin_right_url` VALUES ('142', '23', 'district/create', 'district', 'create', 'admin', '2017-03-17 17:19:08', 'admin', '2017-03-17 17:19:13');
INSERT INTO `admin_right_url` VALUES ('143', '23', 'district/update', 'district', 'update', 'admin', '2017-03-17 17:19:38', 'admin', '2017-03-17 17:19:46');
INSERT INTO `admin_right_url` VALUES ('144', '23', 'district/delete', 'district', 'delete', 'admin', '2017-03-17 17:20:18', 'admin', '2017-03-17 17:20:22');
INSERT INTO `admin_right_url` VALUES ('145', '24', 'requirement/index', 'requirement', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('146', '24', 'requirement/view', 'requirement', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('147', '24', 'requirement/create', 'requirement', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('148', '24', 'requirement/update', 'requirement', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('149', '24', 'requirement/delete', 'requirement', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('150', '25', 'user/index', 'user', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('151', '25', 'user/view', 'user', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('152', '25', 'user/create', 'user', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('153', '25', 'user/update', 'user', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('154', '25', 'user/delete', 'user', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('155', '26', 'house/index', 'house', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('156', '26', 'house/view', 'house', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('157', '26', 'house/create', 'house', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('158', '26', 'house/update', 'house', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('159', '26', 'house/delete', 'house', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('160', '27', 'bid/index', 'bid', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('161', '27', 'bid/view', 'bid', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('162', '27', 'bid/create', 'bid', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('163', '27', 'bid/update', 'bid', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('164', '27', 'bid/delete', 'bid', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('165', '28', 'metro/index', 'metro', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('166', '28', 'metro/view', 'metro', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('167', '28', 'metro/create', 'metro', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('168', '28', 'metro/update', 'metro', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('169', '28', 'metro/delete', 'metro', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('170', '29', 'expert/index', 'expert', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('171', '29', 'expert/view', 'expert', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('172', '29', 'expert/create', 'expert', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('173', '29', 'expert/update', 'expert', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('174', '29', 'expert/delete', 'expert', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('175', '30', 'appoint/index', 'appoint', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('176', '30', 'appoint/view', 'appoint', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('177', '30', 'appoint/create', 'appoint', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('178', '30', 'appoint/update', 'appoint', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('179', '30', 'appoint/delete', 'appoint', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('180', '31', 'question/index', 'question', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('181', '31', 'question/view', 'question', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('182', '31', 'question/create', 'question', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('183', '31', 'question/update', 'question', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('184', '31', 'question/delete', 'question', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('185', '32', 'order/index', 'order', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('186', '32', 'order/view', 'order', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('187', '32', 'order/create', 'order', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('188', '32', 'order/update', 'order', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('189', '32', 'order/delete', 'order', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('190', '33', 'topic/index', 'topic', 'index', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('191', '33', 'topic/view', 'topic', 'view', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('192', '33', 'topic/create', 'topic', 'create', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('193', '33', 'topic/update', 'topic', 'update', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');
INSERT INTO `admin_right_url` VALUES ('194', '33', 'topic/delete', 'topic', 'delete', 'admin', '2017-03-17 10:16:09', 'admin', '2017-03-17 10:16:09');

-- ----------------------------
-- Table structure for `admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(50) NOT NULL COMMENT '角色编号',
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `des` varchar(400) DEFAULT NULL COMMENT '角色描述',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新人',
  `update_date` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('1', 'superadmin', '超级管理员', '拥有所有权限', 'test', '2016-08-12 15:33:01', 'test', '2016-08-12 15:33:01');
INSERT INTO `admin_role` VALUES ('2', 'testuser', '测试人员', '测试人员', 'test', '2016-08-12 15:33:45', 'test', '2016-08-12 15:33:45');

-- ----------------------------
-- Table structure for `admin_role_right`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_right`;
CREATE TABLE `admin_role_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `role_id` int(11) NOT NULL COMMENT '角色主键',
  `right_id` int(11) NOT NULL COMMENT '权限主键',
  `full_path` varchar(250) DEFAULT NULL COMMENT '全路径',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `index_role_id` (`role_id`),
  KEY `index_right_id` (`right_id`),
  CONSTRAINT `admin_role_right_ibfk_1` FOREIGN KEY (`right_id`) REFERENCES `admin_right` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role_right
-- ----------------------------
INSERT INTO `admin_role_right` VALUES ('112', '2', '13', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('113', '2', '14', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('114', '2', '15', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('115', '2', '16', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('116', '2', '17', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('117', '2', '18', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('118', '2', '19', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('119', '2', '20', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('120', '2', '21', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('121', '2', '4', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('122', '2', '5', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('123', '2', '6', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('124', '2', '7', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('125', '2', '8', null, 'test', '2016-08-16 16:02:57', 'test', '2016-08-16 16:02:57');
INSERT INTO `admin_role_right` VALUES ('157', '1', '13', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('158', '1', '14', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('159', '1', '15', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('160', '1', '16', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('161', '1', '17', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('162', '1', '18', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('163', '1', '19', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('164', '1', '20', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('165', '1', '21', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('166', '1', '4', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('167', '1', '5', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('168', '1', '6', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('169', '1', '7', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('170', '1', '8', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('171', '1', '22', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('172', '1', '23', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('173', '1', '24', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('174', '1', '25', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('175', '1', '26', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('176', '1', '27', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('177', '1', '28', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('178', '1', '29', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('179', '1', '30', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('180', '1', '31', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('181', '1', '32', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');
INSERT INTO `admin_role_right` VALUES ('182', '1', '33', null, 'admin', '2017-03-17 10:18:05', 'admin', '2017-03-17 10:18:05');

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(200) NOT NULL COMMENT '密码',
  `auth_key` varchar(50) DEFAULT NULL COMMENT '自动登录key',
  `last_ip` varchar(50) DEFAULT NULL COMMENT '最近一次登录ip',
  `is_online` char(1) DEFAULT 'n' COMMENT '是否在线',
  `domain_account` varchar(100) DEFAULT NULL COMMENT '域账号',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `create_user` varchar(100) NOT NULL COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` varchar(101) NOT NULL COMMENT '更新人',
  `update_date` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('156', 'admin', '$2y$13$9O6bKJieocg//oSax9fZOOuljAKarBXknqD8.RyYg60FfNjS7SoqK', null, '127.0.0.1', 'n', null, '10', 'admin', '2014-07-07 00:05:47', 'admin', '2014-09-03 12:19:12');
INSERT INTO `admin_user` VALUES ('158', 'test', '$2y$13$9O6bKJieocg//oSax9fZOOuljAKarBXknqD8.RyYg60FfNjS7SoqK', null, '', 'n', null, '10', 'admin', '2014-09-03 12:19:52', 'admin', '2014-11-21 19:19:22');

-- ----------------------------
-- Table structure for `admin_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_role`;
CREATE TABLE `admin_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `role_id` int(11) NOT NULL COMMENT '角色',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `index_user_id` (`user_id`),
  KEY `index_role_id` (`role_id`),
  CONSTRAINT `admin_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `admin_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `admin_role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user_role
-- ----------------------------
INSERT INTO `admin_user_role` VALUES ('1', '156', '1', 'admin', '2016-08-12 17:03:13', 'admin', '2016-08-12 17:03:13');
INSERT INTO `admin_user_role` VALUES ('2', '158', '2', 'test', '2016-08-13 16:34:20', 'test', '2016-08-13 16:34:20');

-- ----------------------------
-- View structure for `v_agent`
-- ----------------------------
DROP VIEW IF EXISTS `v_agent`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_agent` AS select `a`.`id` AS `userid`,`a`.`nickname` AS `nickname`,`a`.`phone` AS `phone`,`a`.`picture` AS `picture`,`a`.`password` AS `password`,`a`.`email` AS `email`,`a`.`sex` AS `sex`,`a`.`city` AS `city`,`a`.`realname` AS `realname`,`a`.`agentflag` AS `agentflag`,`a`.`identitycard` AS `identitycard`,`a`.`expertflag` AS `expertflag`,`a`.`srcflag` AS `srcflag`,`a`.`totaltimes` AS `totaltimes`,`a`.`logintime` AS `logintime`,`a`.`createtime` AS `createtime`,`a`.`wxopenid` AS `wxopenid`,`a`.`wxunionid` AS `wxunionid`,`a`.`tags` AS `tags`,`a`.`activeregion` AS `activeregion`,`b`.`organization` AS `organization`,`b`.`storeinfo` AS `storeinfo`,`b`.`workperiod` AS `workperiod`,`b`.`position` AS `position`,`b`.`businesscard` AS `businesscard`,`b`.`education` AS `education`,`b`.`schoolinfo` AS `schoolinfo`,`b`.`nativeplace` AS `nativeplace`,`b`.`zmcredit` AS `zmcredit`,`b`.`certificateflag` AS `certificateflag`,`b`.`certificateno` AS `certificateno`,`b`.`skill` AS `skill`,`b`.`addedservice` AS `addedservice`,`b`.`pushcity` AS `pushcity`,`b`.`majordistrict` AS `majordistrict`,`b`.`praisecnt` AS `praisecnt` from (`t_user` `a` left join `t_agent` `b` on((`a`.`id` = `b`.`userid`))) where ((`a`.`agentflag` = 1) and (`a`.`phone` <> '')) ;

-- ----------------------------
-- View structure for `v_estate`
-- ----------------------------
DROP VIEW IF EXISTS `v_estate`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_estate` AS select `a`.`estateid` AS `estateid`,`a`.`estatename` AS `estatename`,`a`.`province` AS `province`,`a`.`city` AS `city`,`a`.`region` AS `region`,`a`.`estateaddr` AS `estateaddr`,`a`.`longitude` AS `longitude`,`a`.`latitude` AS `latitude`,`a`.`averageprice` AS `averageprice`,`a`.`directorname` AS `directorname`,`a`.`directorphone` AS `directorphone`,`a`.`salesofficeaddr` AS `salesofficeaddr`,`a`.`salesofficephone` AS `salesofficephone`,`a`.`estatesubject` AS `estatesubject`,`a`.`estatetype` AS `estatetype`,`a`.`totalhouseholds` AS `totalhouseholds`,`a`.`parkingspacecnt` AS `parkingspacecnt`,`a`.`volumeratio` AS `volumeratio`,`a`.`greeningrate` AS `greeningrate`,`a`.`feature` AS `feature`,`a`.`openedsubject` AS `openedsubject`,`a`.`buildingno` AS `buildingno`,`a`.`households` AS `households`,`a`.`housetypeinfo` AS `housetypeinfo`,`a`.`discountinfo` AS `discountinfo`,`a`.`openeddate` AS `openeddate`,`a`.`logo` AS `logo`,`a`.`validflag` AS `validflag`,`b`.`rebates` AS `rebates`,`b`.`commission` AS `commission`,`b`.`paymenttime` AS `paymenttime`,`b`.`service` AS `service`,`b`.`schedule` AS `schedule`,`b`.`estatebusflag` AS `estatebusflag`,`b`.`gatheraddr` AS `gatheraddr`,`b`.`busnumber` AS `busnumber`,`b`.`trafficdetail` AS `trafficdetail`,`b`.`specialcarflag` AS `specialcarflag`,`b`.`remarks` AS `remarks` from (`t_estate_detail` `a` join `t_estate_distribution` `b`) where (`a`.`estateid` = `b`.`estateid`) ;

-- ----------------------------
-- View structure for `v_estate_agent`
-- ----------------------------
DROP VIEW IF EXISTS `v_estate_agent`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_estate_agent` AS select `a`.`estateid` AS `estateid`,`a`.`estatename` AS `estatename`,`a`.`province` AS `province`,`a`.`city` AS `city`,`a`.`region` AS `region`,`a`.`estateaddr` AS `estateaddr`,`a`.`longitude` AS `longitude`,`a`.`latitude` AS `latitude`,`a`.`averageprice` AS `averageprice`,`a`.`directorname` AS `directorname`,`a`.`directorphone` AS `directorphone`,`a`.`salesofficeaddr` AS `salesofficeaddr`,`a`.`salesofficephone` AS `salesofficephone`,`a`.`estatesubject` AS `estatesubject`,`a`.`estatetype` AS `estatetype`,`a`.`totalhouseholds` AS `totalhouseholds`,`a`.`parkingspacecnt` AS `parkingspacecnt`,`a`.`volumeratio` AS `volumeratio`,`a`.`greeningrate` AS `greeningrate`,`a`.`feature` AS `feature`,`a`.`openedsubject` AS `openedsubject`,`a`.`buildingno` AS `buildingno`,`a`.`households` AS `households`,`a`.`housetypeinfo` AS `housetypeinfo`,`a`.`discountinfo` AS `discountinfo`,`a`.`openeddate` AS `openeddate`,`a`.`logo` AS `logo`,`a`.`validflag` AS `validflag`,`b`.`agentname` AS `agentname`,`b`.`agentuserid` AS `agentuserid`,`b`.`agentcompany` AS `agentcompany`,`b`.`agentregion` AS `agentregion`,`b`.`agentphone` AS `agentphone`,`b`.`identitycard` AS `identitycard`,`b`.`status` AS `status`,`b`.`applytime` AS `applytime`,`b`.`accepttime` AS `accepttime`,`b`.`rejecttime` AS `rejecttime`,`b`.`rejectreason` AS `rejectreason` from (`t_estate_detail` `a` join `t_estate_agent` `b`) where (`a`.`estateid` = `b`.`estateid`) ;

-- ----------------------------
-- View structure for `v_estate_deal`
-- ----------------------------
DROP VIEW IF EXISTS `v_estate_deal`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_estate_deal` AS select `a`.`estateid` AS `estateid`,`a`.`estatename` AS `estatename`,`a`.`province` AS `province`,`a`.`city` AS `city`,`a`.`region` AS `region`,`a`.`estateaddr` AS `estateaddr`,`a`.`longitude` AS `longitude`,`a`.`latitude` AS `latitude`,`a`.`averageprice` AS `averageprice`,`a`.`directorname` AS `directorname`,`a`.`directorphone` AS `directorphone`,`a`.`salesofficeaddr` AS `salesofficeaddr`,`a`.`salesofficephone` AS `salesofficephone`,`a`.`estatesubject` AS `estatesubject`,`a`.`estatetype` AS `estatetype`,`a`.`totalhouseholds` AS `totalhouseholds`,`a`.`parkingspacecnt` AS `parkingspacecnt`,`a`.`volumeratio` AS `volumeratio`,`a`.`greeningrate` AS `greeningrate`,`a`.`feature` AS `feature`,`a`.`openedsubject` AS `openedsubject`,`a`.`buildingno` AS `buildingno`,`a`.`households` AS `households`,`a`.`housetypeinfo` AS `housetypeinfo`,`a`.`discountinfo` AS `discountinfo`,`a`.`openeddate` AS `openeddate`,`a`.`logo` AS `logo`,`a`.`validflag` AS `validflag`,`b`.`orderid` AS `orderid`,`b`.`customername` AS `customername`,`b`.`customerphone` AS `customerphone`,`b`.`customerregion` AS `customerregion`,`b`.`customeraddr` AS `customeraddr`,`b`.`roomaddr` AS `roomaddr`,`b`.`roominfo` AS `roominfo`,`b`.`depositstatus` AS `depositstatus`,`b`.`deposit` AS `deposit`,`b`.`depositsigntime` AS `depositsigntime`,`b`.`contractstatus` AS `contractstatus`,`b`.`payments` AS `payments`,`b`.`contracttime` AS `contracttime`,`b`.`agentuserid` AS `agentuserid`,`b`.`agentname` AS `agentname`,`b`.`agentcompany` AS `agentcompany`,`b`.`agentphone` AS `agentphone`,`b`.`commission` AS `commission`,`b`.`commissionstatus` AS `commissionstatus`,`b`.`commissionbegintime` AS `commissionbegintime`,`b`.`commissionendtime` AS `commissionendtime` from (`t_estate_detail` `a` join `t_estate_deal` `b`) where (`a`.`estateid` = `b`.`estateid`) ;

-- ----------------------------
-- View structure for `v_question_answer`
-- ----------------------------
DROP VIEW IF EXISTS `v_question_answer`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_question_answer` AS select `a`.`duration` AS `duration`,`a`.`id` AS `id`,`a`.`userid` AS `userid`,`a`.`questionsubject` AS `questionsubject`,`a`.`questiondetail` AS `questiondetail`,`a`.`expertid` AS `expertid`,`a`.`answer` AS `answer`,`a`.`openflag` AS `openflag`,`a`.`listenedcnt` AS `listenedcnt`,`a`.`questiondate` AS `questiondate`,`a`.`anserdate` AS `anserdate`,`a`.`priority` AS `priority`,`b`.`nickname` AS `usernickname`,`b`.`picture` AS `userpicture`,`b`.`logintime` AS `logintime`,`c`.`name` AS `expertname`,`c`.`headpicture` AS `expertpicture`,`c`.`organization` AS `organization`,`c`.`workperiod` AS `workperiod`,`c`.`position` AS `position`,`c`.`activeregion` AS `activeregion`,`c`.`domain` AS `domain`,`c`.`introduction` AS `introduction`,`c`.`expertisen` AS `expertisen`,`c`.`praisecnt` AS `praisecnt`,`c`.`userid` AS `expertuserid` from ((`t_question_answer` `a` join `t_user` `b`) join `t_expert` `c`) where ((`a`.`userid` = `b`.`id`) and (`a`.`expertid` = `c`.`id`)) ;

-- ----------------------------
-- View structure for `v_requirement`
-- ----------------------------
DROP VIEW IF EXISTS `v_requirement`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_requirement` AS select `a`.`id` AS `id`,`a`.`publishuserid` AS `publishuserid`,`a`.`publishusertype` AS `publishusertype`,`a`.`requirementtype` AS `requirementtype`,`a`.`region1` AS `region1`,`a`.`region2` AS `region2`,`a`.`region3` AS `region3`,`a`.`regions` AS `regions`,`a`.`districtid` AS `districtid`,`a`.`districtname` AS `districtname`,`a`.`budget` AS `budget`,`a`.`housetype` AS `housetype`,`a`.`storey` AS `storey`,`a`.`buildingtype` AS `buildingtype`,`a`.`detail` AS `detail`,`a`.`acceptagentflag` AS `acceptagentflag`,`a`.`agentfee` AS `agentfee`,`a`.`dividefeedescribe` AS `dividefeedescribe`,`a`.`updatetime` AS `updatetime`,`a`.`createtime` AS `createtime`,`a`.`dividerate` AS `dividerate`,`a`.`expectdividefee` AS `expectdividefee`,`a`.`subject` AS `subject`,`a`.`validflag` AS `validflag`,`b`.`agentflag` AS `agentflag`,`b`.`picture` AS `picture`,`b`.`nickname` AS `nickname`,`b`.`realname` AS `realname` from (`t_requirement` `a` left join `t_user` `b` on((`a`.`publishuserid` = `b`.`id`))) where ((`a`.`validflag` = 1) and (`b`.`validflag` = 1)) ;

-- ----------------------------
-- View structure for `v_requirement_help`
-- ----------------------------
DROP VIEW IF EXISTS `v_requirement_help`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_requirement_help` AS select `a`.`helpid` AS `helpid`,`a`.`publishuserid` AS `publishuserid`,`a`.`publishusertype` AS `publishusertype`,`a`.`requirementtype` AS `requirementtype`,`a`.`region` AS `region`,`a`.`forhelpsubject` AS `forhelpsubject`,`a`.`level` AS `level`,`a`.`forhelpdetail` AS `forhelpdetail`,`a`.`rewardflag` AS `rewardflag`,`a`.`rewardfee` AS `rewardfee`,`a`.`publishuserpaytime` AS `publishuserpaytime`,`a`.`status` AS `status`,`a`.`replycnt` AS `replycnt`,`a`.`adoptedreplyid` AS `adoptedreplyid`,`a`.`adoptedreplyuserid` AS `adoptedreplyuserid`,`a`.`adopttime` AS `adopttime`,`a`.`adoptpaytime` AS `adoptpaytime`,`a`.`updatetime` AS `updatetime`,`a`.`createtime` AS `createtime`,`a`.`validflag` AS `validflag`,`b`.`nickname` AS `nickname`,`b`.`realname` AS `realname`,`b`.`picture` AS `picture`,`b`.`agentflag` AS `agentflag`,`b`.`id` AS `id` from (`t_requirement_help` `a` left join `t_user` `b` on((`a`.`publishuserid` = `b`.`id`))) where ((`a`.`validflag` = 1) and (`b`.`validflag` = 1)) ;

-- ----------------------------
-- View structure for `v_requirement_rent`
-- ----------------------------
DROP VIEW IF EXISTS `v_requirement_rent`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_requirement_rent` AS select `zmzfang`.`t_requirement_rent`.`id` AS `id`,`zmzfang`.`t_requirement_rent`.`publishuserid` AS `publishuserid`,`zmzfang`.`t_requirement_rent`.`publishusertype` AS `publishusertype`,`zmzfang`.`t_requirement_rent`.`requirementtype` AS `requirementtype`,`zmzfang`.`t_requirement_rent`.`region1` AS `region1`,`zmzfang`.`t_requirement_rent`.`region2` AS `region2`,`zmzfang`.`t_requirement_rent`.`region3` AS `region3`,`zmzfang`.`t_requirement_rent`.`regions` AS `regions`,`zmzfang`.`t_requirement_rent`.`districtid` AS `districtid`,`zmzfang`.`t_requirement_rent`.`districtname` AS `districtname`,`zmzfang`.`t_requirement_rent`.`budget` AS `budget`,`zmzfang`.`t_requirement_rent`.`housetype` AS `housetype`,`zmzfang`.`t_requirement_rent`.`storey` AS `storey`,`zmzfang`.`t_requirement_rent`.`buildingtype` AS `buildingtype`,`zmzfang`.`t_requirement_rent`.`detail` AS `detail`,`zmzfang`.`t_requirement_rent`.`updatetime` AS `updatetime`,`zmzfang`.`t_requirement_rent`.`createtime` AS `createtime`,`zmzfang`.`t_requirement_rent`.`subject` AS `subject`,`zmzfang`.`t_requirement_rent`.`validflag` AS `validflag`,`zmzfang`.`t_user`.`picture` AS `publishuserpicture`,`zmzfang`.`t_user`.`nickname` AS `publishusername`,`zmzfang`.`t_user`.`realname` AS `realname` from (`t_requirement_rent` join `t_user`) where ((`zmzfang`.`t_requirement_rent`.`publishuserid` = `zmzfang`.`t_user`.`id`) and (`zmzfang`.`t_requirement_rent`.`validflag` = 1) and (`zmzfang`.`t_user`.`validflag` = 1)) ;
