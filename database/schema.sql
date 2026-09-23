-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: sonnaclankaenterprises
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `advert`
--

DROP TABLE IF EXISTS `advert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advert` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_carsales` int(11) DEFAULT NULL,
  `fk_stock` int(11) DEFAULT 0,
  `fk_type` int(11) DEFAULT NULL,
  `fk_make` int(11) DEFAULT NULL,
  `fk_model` int(11) DEFAULT NULL,
  `fk_mileage` int(11) DEFAULT NULL,
  `modeltxt` varchar(255) DEFAULT NULL,
  `fk_body_type` int(11) DEFAULT NULL,
  `chasi` varchar(255) DEFAULT NULL,
  `eng_cap` varchar(100) DEFAULT NULL,
  `fk_transmission` int(11) DEFAULT NULL,
  `fk_fuel` int(11) DEFAULT NULL,
  `hybrid` tinyint(1) DEFAULT 0,
  `fk_color` int(11) DEFAULT NULL,
  `acolor` varchar(255) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `yearmonth` varchar(100) DEFAULT NULL,
  `mileage` varchar(100) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL,
  `highestoffer` tinyint(1) DEFAULT 0,
  `ac` tinyint(1) DEFAULT 0,
  `ps` tinyint(1) DEFAULT 0,
  `pw` tinyint(1) DEFAULT 0,
  `pm` tinyint(1) DEFAULT 0,
  `abs` tinyint(1) DEFAULT 0,
  `tv` tinyint(1) DEFAULT 0,
  `cd` tinyint(1) DEFAULT 0,
  `dvd` tinyint(1) DEFAULT 0,
  `aw` tinyint(1) DEFAULT 0,
  `airbag` tinyint(1) DEFAULT 0,
  `r_camera` tinyint(1) DEFAULT 0,
  `foglamp` tinyint(1) DEFAULT 0,
  `sunroof` tinyint(1) DEFAULT 0,
  `leather` tinyint(1) DEFAULT 0,
  `winkermirror` tinyint(1) DEFAULT 0,
  `rearwiper` tinyint(1) DEFAULT 0,
  `skey` tinyint(1) DEFAULT 0,
  `other_op` varchar(255) DEFAULT '',
  `imgpath` varchar(255) DEFAULT '/admincontent/vimg/',
  `image1` varchar(255) DEFAULT 'na.jpg',
  `image2` varchar(255) DEFAULT 'na.jpg',
  `image3` varchar(255) DEFAULT 'na.jpg',
  `image4` varchar(255) DEFAULT 'na.jpg',
  `available` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  `status` tinyint(4) DEFAULT NULL,
  `addu` varchar(255) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` varchar(20) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` varchar(255) DEFAULT NULL,
  `delt` timestamp NULL DEFAULT NULL,
  `delcomment` varchar(255) DEFAULT '',
  `search` tinytext DEFAULT NULL,
  `fk_customer` int(11) DEFAULT NULL,
  `flow` tinyint(4) DEFAULT 1,
  `selling_price` double(10,2) DEFAULT NULL,
  `invoice_price` double(10,2) DEFAULT NULL,
  `fk_admin_customeradded` int(11) DEFAULT NULL,
  `fk_admin_customeraddedtime` timestamp NULL DEFAULT NULL,
  `ref` bigint(20) DEFAULT NULL,
  `selected` tinyint(1) DEFAULT 0,
  `selectedtime` timestamp NULL DEFAULT NULL,
  `fk_category` int(11) DEFAULT NULL,
  `registed_number` varchar(255) DEFAULT NULL,
  `fk_price_type` int(11) DEFAULT NULL,
  `special_offer` tinyint(1) DEFAULT NULL,
  `special_offer_price` double(20,2) DEFAULT NULL,
  `courier` varchar(255) DEFAULT NULL,
  `ship_loding_date` date DEFAULT NULL,
  `ship_arriving_date` date DEFAULT NULL,
  `vesal_name` varchar(255) DEFAULT NULL,
  `shipment_added` tinyint(1) DEFAULT NULL,
  `fk_ports` int(11) DEFAULT NULL,
  `lc_comments` varchar(255) DEFAULT NULL,
  `balance_paid` tinyint(1) DEFAULT NULL,
  `shipmet_remove_date` timestamp NULL DEFAULT NULL,
  `fk_engine_capacity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fk_price_per` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advert_images`
--

DROP TABLE IF EXISTS `advert_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advert_images` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_advert` int(11) DEFAULT NULL,
  `image_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mpath` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tpath` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `_status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_config`
--

DROP TABLE IF EXISTS `app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_config` (
  `key` varchar(255) NOT NULL DEFAULT '',
  `val` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquiries` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_advert` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `ip` varchar(45) DEFAULT NULL,
  `addt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`),
  KEY `fk_advert` (`fk_advert`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `availability`
--

DROP TABLE IF EXISTS `availability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `body_type`
--

DROP TABLE IF EXISTS `body_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `body_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT 'images/vcolors',
  `imgname` varchar(255) DEFAULT NULL,
  `vehicle_group` enum('car','motorcycle') NOT NULL DEFAULT 'car',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `carsale_users`
--

DROP TABLE IF EXISTS `carsale_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carsale_users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_carsales` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `lastLogin` datetime DEFAULT NULL,
  `lastIp` varchar(64) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `carsales`
--

DROP TABLE IF EXISTS `carsales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carsales` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `contactpersonemail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_validation` tinyint(1) DEFAULT 0,
  `lastLogin` datetime DEFAULT NULL,
  `lastIp` varchar(64) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `carsales_component_price`
--

DROP TABLE IF EXISTS `carsales_component_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carsales_component_price` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `carsales_payments`
--

DROP TABLE IF EXISTS `carsales_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carsales_payments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_carsales` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `default_price` double DEFAULT NULL,
  `site_price` double DEFAULT NULL,
  `stock_price` double DEFAULT NULL,
  `adminuser_price` double DEFAULT NULL,
  `reg_user_price` double DEFAULT NULL,
  `stock_location_price` double DEFAULT NULL,
  `news_price` double DEFAULT NULL,
  `newsletter_price` double DEFAULT NULL,
  `invoice_price` double DEFAULT NULL,
  `inquiry_price` double DEFAULT NULL,
  `payment_price` double DEFAULT NULL,
  `exporter_payment_price` double DEFAULT NULL,
  `employee_price` double DEFAULT NULL,
  `without_adv_price` double DEFAULT NULL,
  `monthy_price` double DEFAULT NULL,
  `number_of_months` int(11) DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `activate` tinyint(1) DEFAULT 0,
  `free_trial` tinyint(1) DEFAULT 0,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chasicode`
--

DROP TABLE IF EXISTS `chasicode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chasicode` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_model` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `othername` varchar(255) DEFAULT NULL,
  `fk_province` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `colour`
--

DROP TABLE IF EXISTS `colour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colour` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT 'images/vcolors',
  `imgname` varchar(255) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_advert` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  `addu` int(11) DEFAULT NULL,
  `addt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `txtSMTPUserName` varchar(255) DEFAULT NULL,
  `txtSMTPServer` varchar(255) DEFAULT NULL,
  `txtSMTPPassword` varchar(255) DEFAULT NULL,
  `adminEmials` text DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emailadress`
--

DROP TABLE IF EXISTS `emailadress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emailadress` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `addu` bigint(20) DEFAULT NULL,
  `updateu` bigint(20) DEFAULT NULL,
  `delu` bigint(20) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delt` timestamp NULL DEFAULT NULL,
  `delcomment` text DEFAULT NULL,
  `selected` tinyint(1) DEFAULT 0,
  `selectedtime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1091 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `engine_capacity`
--

DROP TABLE IF EXISTS `engine_capacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine_capacity` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `_status` varchar(255) DEFAULT NULL,
  `fk_carsale` int(11) NOT NULL DEFAULT 0,
  `addu` int(11) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int(11) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int(11) DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `extra_images`
--

DROP TABLE IF EXISTS `extra_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extra_images` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_advert` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fuel`
--

DROP TABLE IF EXISTS `fuel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fuel` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_user` int(11) DEFAULT NULL,
  `firtlogedintime` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `main`
--

DROP TABLE IF EXISTS `main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `main` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `make`
--

DROP TABLE IF EXISTS `make`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `make` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'images\\logos',
  `img_name` varchar(255) DEFAULT NULL,
  `addu` int(11) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int(11) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int(11) DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  `vehicle_group` enum('car','motorcycle') NOT NULL DEFAULT 'car',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mileage`
--

DROP TABLE IF EXISTS `mileage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mileage` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'images\\logos',
  `img_name` varchar(255) DEFAULT NULL,
  `addu` int(11) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int(11) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int(11) DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `fk_make` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `addu` int(11) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int(11) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int(11) DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=765 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `price_per`
--

DROP TABLE IF EXISTS `price_per`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_per` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `price_type`
--

DROP TABLE IF EXISTS `price_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `price_types`
--

DROP TABLE IF EXISTS `price_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `imagename` varchar(255) DEFAULT NULL,
  `lastlapcif` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `property_type`
--

DROP TABLE IF EXISTS `property_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `province` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `fullname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_admin`
--

DROP TABLE IF EXISTS `system_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_admin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL DEFAULT '',
  `sales` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `_status` varchar(200) NOT NULL DEFAULT '1',
  `lastLogin` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lastIp` varchar(255) NOT NULL DEFAULT '0',
  `super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `addu` bigint(20) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `addu_type` varchar(255) NOT NULL DEFAULT '',
  `updateu` bigint(20) DEFAULT NULL,
  `updateu_type` varchar(255) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` bigint(20) DEFAULT NULL,
  `delu_type` varchar(255) DEFAULT NULL,
  `delt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `skype` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `viber` varchar(255) NOT NULL,
  `white_ip` varchar(255) DEFAULT NULL,
  `send_cmnt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_admin_privilage`
--

DROP TABLE IF EXISTS `system_admin_privilage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_admin_privilage` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_system_admin` varchar(200) NOT NULL DEFAULT '',
  `fk_system_admin_privilage_property` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_admin_privilage_property`
--

DROP TABLE IF EXISTS `system_admin_privilage_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_admin_privilage_property` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `property_name` varchar(200) NOT NULL DEFAULT '',
  `_status` tinyint(1) DEFAULT 0,
  `fk_system_admin_privilage_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_admin_privilage_type`
--

DROP TABLE IF EXISTS `system_admin_privilage_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_admin_privilage_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `_status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transmission`
--

DROP TABLE IF EXISTS `transmission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transmission` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT 'images/vcolors',
  `imgname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `imagepath` varchar(255) DEFAULT NULL,
  `imagename` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `lastLogin` datetime DEFAULT NULL,
  `sales` tinyint(1) DEFAULT 0,
  `bidding` tinyint(1) DEFAULT 0,
  `account` tinyint(1) DEFAULT 0,
  `lc` tinyint(1) DEFAULT 0,
  `uv` tinyint(1) DEFAULT 0,
  `admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `regNo` varchar(255) DEFAULT NULL,
  `fk_seller` int(11) DEFAULT NULL,
  `fk_buyer` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `ins2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vtype`
--

DROP TABLE IF EXISTS `vtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vtype` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `imagepath` varchar(255) DEFAULT NULL,
  `imagename` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `year`
--

DROP TABLE IF EXISTS `year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `year` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `yenrate`
--

DROP TABLE IF EXISTS `yenrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yenrate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `yenrate` double DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'sonnaclankaenterprises'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-22 18:24:06
