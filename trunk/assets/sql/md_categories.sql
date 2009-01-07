/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.0.67 : Database - december2008
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `december2008`;

USE `december2008`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Data for the table `md_categories` */

insert  into `md_categories`(`cat_id`,`cat_name`,`cat_order`,`created`) values (1,'General',1,'2009-01-06 10:20:45'),(2,'Buy/Sell (Used Stuff)',2,'2009-01-06 10:23:38'),(3,'Cars/Bikes',3,'2009-01-06 10:23:46'),(4,'Real Estate',4,'2009-01-06 10:24:02'),(5,'Rentals',5,'2009-01-06 10:24:20'),(6,'PG/Roommates',6,'2009-01-06 10:24:30'),(7,'Coaching/Training',7,'2009-01-06 10:24:42'),(8,'Home Services',8,'2009-01-06 10:26:15'),(9,'Personal Finance',9,'2009-01-06 10:26:36'),(10,'Computers Stores',10,'2009-01-06 10:26:57'),(11,'Mobile Stores',11,'2009-01-06 10:27:05'),(12,'Tours/Travels',12,'2009-01-06 10:27:19'),(13,'Business Services',13,'2009-01-06 10:27:32'),(14,'Free Quotes',14,'2009-01-06 10:27:54'),(15,'Health',15,'2009-01-06 10:28:16'),(16,'Friendship',16,'2009-01-06 10:28:41');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
