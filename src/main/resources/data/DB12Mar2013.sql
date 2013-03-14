/*
Navicat MySQL Data Transfer

Source Server         : local-dbs
Source Server Version : 50529
Source Host           : localhost:3306
Source Database       : bibliothouris

Target Server Type    : MYSQL
Target Server Version : 50529
File Encoding         : 65001

Date: 2013-03-12 15:02:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `courses`
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '',
  `date_start` date DEFAULT '0000-00-00',
  `date_end` date DEFAULT '0000-00-00',
  `trainer_name` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maximum_participants` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `trainer_name` (`trainer_name`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of courses
-- ----------------------------
INSERT INTO `courses` VALUES ('1', 'Agile .NET Principles', '2013-04-10', '2013-04-30', 'Mihai Enescu', 'Technical cours with .NET Principles.', '1', '2013-03-12 11:34:26', '2013-03-12 11:34:26', '0');
INSERT INTO `courses` VALUES ('2', 'Course Java', '2013-03-12', '2013-03-13', 'Marius Anghel', 'Test test', '1', '2013-03-12 11:34:47', '2013-03-12 11:34:47', '0');
INSERT INTO `courses` VALUES ('3', 'PHP Engeneering', '2013-04-01', '2013-04-04', 'Ward Bryon', '', '1', '2013-03-12 11:35:11', '2013-03-12 11:35:11', '0');

-- ----------------------------
-- Table structure for `enrollments`
-- ----------------------------
DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE `enrollments` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of enrollments
-- ----------------------------

-- ----------------------------
-- Table structure for `members`
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL DEFAULT '',
  `lname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fname` (`fname`),
  KEY `lname` (`lname`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of members
-- ----------------------------