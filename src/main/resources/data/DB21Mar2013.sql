-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-21 11:40:09
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table bibliothouris.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '',
  `date_start` date DEFAULT '0000-00-00',
  `date_end` date DEFAULT '0000-00-00',
  `trainer_name` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `maximum_participants` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `trainer_name` (`trainer_name`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.courses: ~0 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;


-- Dumping structure for table bibliothouris.courses_feedback
CREATE TABLE IF NOT EXISTS `courses_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `score_trainer` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `score_location_infrastructure` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `score_documentation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `score_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `score_content` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `FK_MEMBERID` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `FK_COURSEID` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.courses_feedback: ~0 rows (approximately)
/*!40000 ALTER TABLE `courses_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses_feedback` ENABLE KEYS */;


-- Dumping structure for table bibliothouris.enrollments
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `course_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_ENROLL_COURSEID` (`course_id`),
  KEY `FK_ENROLL_MEMBERID` (`member_id`),
  CONSTRAINT `FK_ENROLL_MEMBERID` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `FK_ENROLL_COURSEID` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.enrollments: ~0 rows (approximately)
/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;


-- Dumping structure for table bibliothouris.members
CREATE TABLE IF NOT EXISTS `members` (
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
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.members: ~0 rows (approximately)
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;


-- Dumping structure for table bibliothouris.session
CREATE TABLE IF NOT EXISTS `session` (
  `id` char(32) NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.session: ~0 rows (approximately)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
