/*
SQLyog Ultimate v8.53 
MySQL - 5.1.53-community-log : Database - shrtrs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`shrtrs` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `shrtrs`;

/*Table structure for table `hash` */

CREATE TABLE `hash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(10) COLLATE utf8_bin NOT NULL,
  `in_use` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `in_use` (`in_use`)
) ENGINE=MyISAM AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `hashify` */

CREATE TABLE `hashify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(10) COLLATE utf8_bin NOT NULL,
  `full_url` text COLLATE utf8_bin NOT NULL,
  `sha1_url` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `sessions` */

CREATE TABLE `sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
