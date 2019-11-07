-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.18 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dbscreens
CREATE DATABASE IF NOT EXISTS `dbscreens` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbscreens`;

-- Dumping structure for table dbscreens.screens
CREATE TABLE IF NOT EXISTS `screens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `authpath` varchar(50) DEFAULT NULL,
  `type` smallint(5) unsigned DEFAULT NULL,
  `revision` mediumint(8) unsigned DEFAULT '0',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table dbscreens.screens: ~0 rows (approximately)
/*!40000 ALTER TABLE `screens` DISABLE KEYS */;
REPLACE INTO `screens` (`id`, `name`, `authpath`, `type`, `revision`, `time`, `timeCreated`) VALUES
	(11, 'well-sa', '.2.', 1, 1, '2019-11-06 15:12:42', '2019-10-26 16:09:13'),
	(12, 'store-af', '.2.', 1, 1, '2019-11-06 15:12:45', '2019-10-26 16:09:13'),
	(13, 'lift-az', '.2.', 1, 1, '2019-11-06 15:12:46', '2019-10-26 16:09:13'),
	(14, 'waste-ks', '.2.', 1, 1, '2019-11-06 15:12:45', '2019-10-26 16:09:13');
/*!40000 ALTER TABLE `screens` ENABLE KEYS */;

-- Dumping structure for table dbscreens.screen_pages
CREATE TABLE IF NOT EXISTS `screen_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` smallint(5) unsigned DEFAULT NULL,
  `revision` mediumint(8) unsigned DEFAULT '0',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_screen_pageid` (`sid`),
  CONSTRAINT `FK_screen_pageid` FOREIGN KEY (`sid`) REFERENCES `screens` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- Dumping data for table dbscreens.screen_pages: ~0 rows (approximately)
/*!40000 ALTER TABLE `screen_pages` DISABLE KEYS */;
REPLACE INTO `screen_pages` (`id`, `sid`, `name`, `type`, `revision`, `time`, `timeCreated`) VALUES
	(101, 11, 'main', NULL, 0, '2019-11-06 15:26:49', '2019-11-06 15:26:49'),
	(102, 14, 'main', NULL, 0, '2019-11-06 15:26:49', '2019-11-06 15:26:49'),
	(103, 11, 'menu', NULL, 0, '2019-11-06 15:27:07', '2019-11-06 15:26:49'),
	(104, 11, 'settings', NULL, 0, '2019-11-06 15:27:07', '2019-11-06 15:26:49'),
	(105, 11, 'inverter', NULL, 0, '2019-11-06 15:27:07', '2019-11-06 15:26:49'),
	(106, 14, 'menu', NULL, 0, '2019-11-06 15:26:49', '2019-11-06 15:26:49'),
	(107, 14, 'settings', NULL, 0, '2019-11-06 15:26:49', '2019-11-06 15:26:49'),
	(108, 13, 'menu', NULL, 0, '2019-11-07 17:39:29', '2019-11-06 15:26:49');
/*!40000 ALTER TABLE `screen_pages` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
