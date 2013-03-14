-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-07 17:59:02
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for bibliothouris
CREATE DATABASE IF NOT EXISTS `bibliothouris` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `bibliothouris`;


-- Dumping structure for table bibliothouris.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '',
  `date_start` date DEFAULT '0000-00-00',
  `date_end` date DEFAULT '0000-00-00',
  `trainer_name` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trainer_name` (`trainer_name`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.courses: ~0 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;


-- Dumping structure for table bibliothouris.members
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL DEFAULT '',
  `lname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fname` (`fname`),
  KEY `lname` (`lname`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table bibliothouris.members: ~1 rows (approximately)
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` (`id`, `fname`, `lname`, `email`, `password`, `status`, `created`, `modified`) VALUES
	(1, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47'),
	(2, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47'),
	(3, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47'),
	(4, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47'),
	(5, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47'),
	(6, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47'),
	(7, 'Marius', 'Anghel', 'araminu2000@yahoo.com', '1', 1, '0000-00-00 00:00:00', '2013-03-07 14:38:47');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
