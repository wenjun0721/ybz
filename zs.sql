/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : zs

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2019-06-05 14:15:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zs_adminuser
-- ----------------------------
DROP TABLE IF EXISTS `zs_adminuser`;
CREATE TABLE `zs_adminuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `loginTime` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_adminuser
-- ----------------------------
INSERT INTO `zs_adminuser` VALUES ('1', 'admin', '0192023a7bbd73250516f069df18b500', '1559535872', '1559535872');

-- ----------------------------
-- Table structure for zs_art
-- ----------------------------
DROP TABLE IF EXISTS `zs_art`;
CREATE TABLE `zs_art` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catId` int(11) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_art
-- ----------------------------
INSERT INTO `zs_art` VALUES ('1', '3', '<p>123asddas</p>', 'asdadas', 'upload/ads/20190531/1559289187.png', 'vest', '1598315860');

-- ----------------------------
-- Table structure for zs_banner
-- ----------------------------
DROP TABLE IF EXISTS `zs_banner`;
CREATE TABLE `zs_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `catId` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_banner
-- ----------------------------
INSERT INTO `zs_banner` VALUES ('1', 'upload/ads/20190531/1559289187.png', '123', '0', '广告1', '1523895210');
INSERT INTO `zs_banner` VALUES ('2', 'upload/ads/20190531/1559288811.png', '###', '0', '广告02', '1589532015');
INSERT INTO `zs_banner` VALUES ('8', 'upload/ads/20190605/1559708650.png', '###', '1', '首页中部轮播1', '1559708650');

-- ----------------------------
-- Table structure for zs_cat
-- ----------------------------
DROP TABLE IF EXISTS `zs_cat`;
CREATE TABLE `zs_cat` (
  `catId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catName` varchar(255) DEFAULT NULL,
  `catImg` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`catId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_cat
-- ----------------------------
INSERT INTO `zs_cat` VALUES ('1', '分类', 'upload/cat/20190531/1559289173.png', '1568932015');
INSERT INTO `zs_cat` VALUES ('3', '分类2', 'upload/cat/20190531/1559289231.png', '1559289231');

-- ----------------------------
-- Table structure for zs_msg
-- ----------------------------
DROP TABLE IF EXISTS `zs_msg`;
CREATE TABLE `zs_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `msgText` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `isRead` tinyint(1) DEFAULT '0' COMMENT '是否已读 1为已读',
  `isok` tinyint(1) DEFAULT '0' COMMENT '是否处理，1为已处理',
  `isdel` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  `add_time` int(11) DEFAULT NULL,
  `del_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_msg
-- ----------------------------
INSERT INTO `zs_msg` VALUES ('1', '测试', '问一下', '13726754755', '广东广州番禺', '1', '0', '0', '1532589305', null);
INSERT INTO `zs_msg` VALUES ('2', '测试2', '测试一下', '13726754755', '广东广州番禺', '1', '1', '0', '1589325861', null);

-- ----------------------------
-- Table structure for zs_web
-- ----------------------------
DROP TABLE IF EXISTS `zs_web`;
CREATE TABLE `zs_web` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_web
-- ----------------------------
INSERT INTO `zs_web` VALUES ('1', '网站介绍', '本公司的主营业务：各种工程');
INSERT INTO `zs_web` VALUES ('2', '留言内容', '屋面防水补漏维修\r\n外墙防水补漏维修');
