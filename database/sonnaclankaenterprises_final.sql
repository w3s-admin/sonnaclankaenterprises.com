
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `advert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advert` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_carsales` int DEFAULT NULL,
  `fk_stock` int DEFAULT '0',
  `fk_type` int DEFAULT NULL,
  `fk_make` int DEFAULT NULL,
  `fk_model` int DEFAULT NULL,
  `fk_mileage` int DEFAULT NULL,
  `modeltxt` varchar(255) DEFAULT NULL,
  `fk_body_type` int DEFAULT NULL,
  `chasi` varchar(255) DEFAULT NULL,
  `eng_cap` varchar(100) DEFAULT NULL,
  `fk_transmission` int DEFAULT NULL,
  `fk_fuel` int DEFAULT NULL,
  `hybrid` tinyint(1) DEFAULT '0',
  `fk_color` int DEFAULT NULL,
  `acolor` varchar(255) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `yearmonth` varchar(100) DEFAULT NULL,
  `mileage` varchar(100) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL,
  `highestoffer` tinyint(1) DEFAULT '0',
  `ac` tinyint(1) DEFAULT '0',
  `ps` tinyint(1) DEFAULT '0',
  `pw` tinyint(1) DEFAULT '0',
  `pm` tinyint(1) DEFAULT '0',
  `abs` tinyint(1) DEFAULT '0',
  `tv` tinyint(1) DEFAULT '0',
  `cd` tinyint(1) DEFAULT '0',
  `dvd` tinyint(1) DEFAULT '0',
  `aw` tinyint(1) DEFAULT '0',
  `airbag` tinyint(1) DEFAULT '0',
  `r_camera` tinyint(1) DEFAULT '0',
  `foglamp` tinyint(1) DEFAULT '0',
  `sunroof` tinyint(1) DEFAULT '0',
  `leather` tinyint(1) DEFAULT '0',
  `winkermirror` tinyint(1) DEFAULT '0',
  `rearwiper` tinyint(1) DEFAULT '0',
  `skey` tinyint(1) DEFAULT '0',
  `other_op` varchar(255) DEFAULT '',
  `imgpath` varchar(255) DEFAULT '/admincontent/vimg/',
  `image1` varchar(255) DEFAULT 'na.jpg',
  `image2` varchar(255) DEFAULT 'na.jpg',
  `image3` varchar(255) DEFAULT 'na.jpg',
  `image4` varchar(255) DEFAULT 'na.jpg',
  `available` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `status` tinyint DEFAULT NULL,
  `addu` varchar(255) DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` varchar(20) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` varchar(255) DEFAULT NULL,
  `delt` timestamp NULL DEFAULT NULL,
  `delcomment` varchar(255) DEFAULT '',
  `search` tinytext,
  `fk_customer` int DEFAULT NULL,
  `flow` tinyint DEFAULT '1',
  `selling_price` double(10,2) DEFAULT NULL,
  `invoice_price` double(10,2) DEFAULT NULL,
  `fk_admin_customeradded` int DEFAULT NULL,
  `fk_admin_customeraddedtime` timestamp NULL DEFAULT NULL,
  `ref` bigint DEFAULT NULL,
  `selected` tinyint(1) DEFAULT '0',
  `selectedtime` timestamp NULL DEFAULT NULL,
  `fk_category` int DEFAULT NULL,
  `registed_number` varchar(255) DEFAULT NULL,
  `fk_price_type` int DEFAULT NULL,
  `special_offer` tinyint(1) DEFAULT NULL,
  `special_offer_price` double(20,2) DEFAULT NULL,
  `courier` varchar(255) DEFAULT NULL,
  `ship_loding_date` date DEFAULT NULL,
  `ship_arriving_date` date DEFAULT NULL,
  `vesal_name` varchar(255) DEFAULT NULL,
  `shipment_added` tinyint(1) DEFAULT NULL,
  `fk_ports` int DEFAULT NULL,
  `lc_comments` varchar(255) DEFAULT NULL,
  `balance_paid` tinyint(1) DEFAULT NULL,
  `shipmet_remove_date` timestamp NULL DEFAULT NULL,
  `fk_engine_capacity` int DEFAULT NULL,
  `description` text,
  `fk_price_per` int DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `advert` WRITE;
/*!40000 ALTER TABLE `advert` DISABLE KEYS */;
INSERT INTO `advert` VALUES (1,0,1,1,1,1,1,'Z Grade',1,'MXPK11-2041785','1500',1,3,1,1,'Super White II','Z','2022-03','18500',11450000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,'Toyota Safety Sense, LED headlamps, 7\" display audio','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-10-04 11:56:20',NULL,NULL,NULL,NULL,'','Car, Toyota, Aqua, Hatchback ,Automatic, White ',NULL,1,NULL,NULL,NULL,NULL,1791114980,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Fresh import, auction grade 4.5. Second-generation Aqua with excellent fuel economy, one owner in Japan, full service history.',NULL),(2,0,1,1,1,1,1,'G Grade',1,'MXPK10-2019634','1500',1,3,1,3,'Emotional Red II','G','2021-11','24300',10950000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,'Smart entry, push start, cruise control','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-09-27 11:56:20',NULL,NULL,NULL,NULL,'','Car, Toyota, Aqua, Hatchback ,Automatic, Red ',NULL,1,NULL,NULL,NULL,NULL,1790510180,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Striking Emotional Red Aqua G with clean fabric interior front and rear. Auction grade 4.5, unregistered.',NULL),(3,0,1,1,1,1,1,'S Grade',1,'NHP10-6712458','1500',1,3,1,1,'Super White II','S','2018-06','52000',8250000.00,0,1,1,1,1,1,0,1,0,0,1,1,0,0,0,1,1,1,'','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-09-19 11:56:20',NULL,NULL,NULL,NULL,'','Car, Toyota, Aqua, Hatchback ,Automatic, White ',NULL,1,NULL,NULL,NULL,NULL,1789818980,0,NULL,3,'CAQ-7812',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Single owner, company maintained. Hybrid battery health checked, new tyres fitted last month.',NULL),(4,0,2,1,3,9,1,'LXi',1,'MA3EUA61S00284517','800',2,1,0,3,'Fire Brick Red','LXi','2018-02','61000',3850000.00,0,1,1,1,0,0,0,1,0,0,1,0,0,0,0,0,0,0,'','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-09-04 11:56:20',NULL,NULL,NULL,NULL,'','Car, Suzuki, Alto, Hatchback ,Manual, Red ',NULL,1,NULL,NULL,NULL,NULL,1788522980,0,NULL,3,'CAJ-3365',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,'Economical city car, ideal first vehicle. Agent maintained with service records, very low running cost.',NULL),(5,0,1,2,6,15,1,'xDrive40 Sport',3,'WBY21CF0X0CK41275','Electric',1,4,0,6,'Oxide Grey Metallic','Sport','2023-04','9800',64500000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,1,1,1,1,1,'Panoramic sky lounge roof, Harman Kardon, Driving Assistant Professional','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-10-06 11:56:20',NULL,NULL,NULL,NULL,'','SUV / Jeep, BMW, iX, SUV ,Automatic, Grey ',NULL,1,NULL,NULL,NULL,NULL,1791287780,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,'Flagship all-electric SUV with approx. 425 km range. Under manufacturer battery warranty.',NULL),(6,0,3,2,2,6,1,'Z Hybrid Honda Sensing',3,'RV5-1029384','1500',1,3,1,2,'Platinum White Pearl','Z','2021-07','21000',13650000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,0,1,1,1,1,'Honda Sensing, power tailgate','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-10-01 11:56:20',NULL,NULL,NULL,NULL,'','SUV / Jeep, Honda, Vezel, SUV ,Automatic, Pearl White ',NULL,1,NULL,NULL,NULL,NULL,1790855780,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Shipped from Yokohama, arriving Colombo port soon. Reserve now with an advance payment.',NULL),(7,0,2,1,1,2,1,'S Touring Selection',1,'ZVW51-6123457','1800',1,3,1,4,'Attitude Black Mica','S','2019-09','38000',12800000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,'17\" alloys, LED fog lamps','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-09-12 11:56:20',NULL,NULL,NULL,NULL,'','Car, Toyota, Prius, Hatchback ,Automatic, Black ',NULL,1,NULL,NULL,NULL,NULL,1789214180,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7,'Touring Selection with sport-tuned suspension. Auction grade 4, excellent condition inside and out.',NULL),(8,0,1,1,1,4,1,'1.5 F EX Package',2,'NZT260-3217754','1500',1,1,0,5,'Silver Metallic','F EX','2018-12','46000',14900000.00,0,1,1,1,1,1,1,1,0,1,1,1,0,0,0,1,0,1,'','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-08-25 11:56:20',NULL,NULL,NULL,NULL,'','Car, Toyota, Premio, Sedan ,Automatic, Silver ',NULL,1,NULL,NULL,NULL,NULL,1787658980,0,NULL,3,'CAU-9021',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Comfortable family sedan, doctor owned. Leasing facilities available up to 60%.',NULL),(9,0,1,2,1,5,1,'TX L Package',3,'GDJ150-0045821','2800',1,2,0,4,'Black','TX L','2020-05','32000',48500000.00,0,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,'7 seats, 4WD, rear entertainment','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-08-10 11:56:20',NULL,NULL,NULL,NULL,'','SUV / Jeep, Toyota, Land Cruiser Prado, SUV ,Automatic, Black ',NULL,1,NULL,NULL,NULL,NULL,1786362980,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11,'2.8L turbo diesel Prado with sunroof and leather. Unregistered, auction grade 4.5.',NULL),(10,0,2,2,4,12,1,'20Xi Hybrid',3,'HNT32-178234','2000',1,3,1,1,'Brilliant White Pearl','20Xi','2019-03','41000',15400000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,'ProPilot, around-view monitor','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-07-26 11:56:20',NULL,NULL,NULL,NULL,'','SUV / Jeep, Nissan, X-Trail, SUV ,Automatic, White ',NULL,1,NULL,NULL,NULL,NULL,1785066980,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8,'Hybrid X-Trail with 360-degree camera and ProPilot assist. Spacious boot, perfect for long trips.',NULL),(11,0,1,1,4,13,1,'X',1,'ZE1-045712','Electric',1,4,0,7,'Vivid Blue','X','2018-10','36000',7750000.00,0,1,1,1,1,1,1,0,0,0,1,1,0,0,0,1,1,1,'40 kWh battery, CHAdeMO fast charge','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-07-11 11:56:20',NULL,NULL,NULL,NULL,'','Car, Nissan, Leaf, Hatchback ,Automatic, Blue ',NULL,1,NULL,NULL,NULL,NULL,1783770980,0,NULL,3,'CBA-1187',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,'Battery state of health 11 bars. Home charger included in the price.',NULL),(12,0,2,2,5,14,1,'GLS Premium 4WD',3,'MMBGUKS10JH012345','2400',1,2,0,5,'Sterling Silver','GLS','2018-08','68000',19750000.00,0,1,1,1,1,1,1,1,0,1,1,1,1,0,1,1,1,1,'Super Select 4WD-II','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-06-21 11:56:20',NULL,NULL,NULL,NULL,'','SUV / Jeep, Mitsubishi, Montero Sport, SUV ,Automatic, Silver ',NULL,1,NULL,NULL,NULL,NULL,1782042980,0,NULL,3,'CAW-5520',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10,'Agent-maintained Montero Sport, 7 seater with leather interior. Tow bar fitted.',NULL),(13,0,1,1,3,10,1,'FX Safety Package',1,'MH55S-214578','660',1,3,1,2,'Pure White Pearl','FX','2019-04','29000',6450000.00,0,1,1,1,1,1,0,0,0,0,1,1,0,0,0,1,1,1,'Dual camera brake support','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-06-01 11:56:20',NULL,NULL,NULL,NULL,'','Car, Suzuki, Wagon R, Hatchback ,Automatic, Pearl White ',NULL,1,NULL,NULL,NULL,NULL,1780314980,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'Mild hybrid kei car, very easy to park and extremely fuel efficient.',NULL),(14,0,3,1,3,11,1,'RS',1,'ZC83S-112456','1200',1,1,0,7,'Speedy Blue Metallic','RS','2020-02','33000',7250000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,'RS body kit, 16\" alloys','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-05-12 11:56:20',NULL,NULL,NULL,NULL,'','Car, Suzuki, Swift, Hatchback ,Automatic, Blue ',NULL,1,NULL,NULL,NULL,NULL,1778586980,0,NULL,2,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,'Sporty Swift RS, currently on the way from Japan.',NULL),(15,0,1,1,2,7,1,'e:HEV Home',1,'GR3-1045821','1500',1,3,1,1,'Platinum White Pearl','Home','2020-10','27000',8950000.00,0,1,1,1,1,1,1,0,0,0,1,1,0,0,0,1,1,1,'Honda Sensing, 9\" Honda Connect display','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-05-02 11:56:20',NULL,NULL,NULL,NULL,'','Car, Honda, Fit, Hatchback ,Automatic, White ',NULL,1,NULL,NULL,NULL,NULL,1777722980,0,NULL,2,NULL,1,1,8650000.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Special offer this month. Fourth-generation Fit with two-motor hybrid system.',NULL),(16,0,1,1,2,8,1,'EX',2,'FC1-1102457','1500',1,1,0,6,'Lunar Silver','EX','2019-06','41000',14200000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,1,0,1,0,1,'1.5L VTEC Turbo','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-07-01 11:56:20',NULL,NULL,NULL,NULL,'','Car, Honda, Civic, Sedan ,Automatic, Grey ',NULL,2,13950000.00,NULL,NULL,NULL,1782906980,0,NULL,3,'CAV-4410',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,'Sold.',NULL),(17,0,2,1,1,3,1,'F Safety Edition',1,'KSP130-2219874','1000',1,1,0,3,'Red Mica','F','2018-01','55000',6850000.00,0,1,1,1,1,1,0,1,0,0,1,0,0,0,0,1,1,1,'','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-05-22 11:56:20',NULL,NULL,NULL,NULL,'','Car, Toyota, Vitz, Hatchback ,Automatic, Red ',NULL,2,6700000.00,NULL,NULL,NULL,1779450980,0,NULL,3,'CAH-8812',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,'Sold.',NULL),(18,0,1,2,7,16,1,'XD L Package',3,'KF2P-301245','2200',1,2,0,3,'Soul Red Crystal','XD L','2018-05','62000',16800000.00,0,1,1,1,1,1,1,0,0,1,1,1,1,1,1,1,1,1,'BOSE audio, leather, power tailgate','admincontent/v_img/','na.jpg','na.jpg','na.jpg','na.jpg',1,1,1,'6','2026-04-22 11:56:20',NULL,NULL,NULL,NULL,'','SUV / Jeep, Mazda, CX-5, SUV ,Automatic, Red ',NULL,2,16500000.00,NULL,NULL,NULL,1776858980,0,NULL,3,'CAT-2290',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9,'Sold.',NULL);
/*!40000 ALTER TABLE `advert` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `advert_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advert_images` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_advert` int DEFAULT NULL,
  `image_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mpath` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tpath` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `_status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `advert_images` WRITE;
/*!40000 ALTER TABLE `advert_images` DISABLE KEYS */;
INSERT INTO `advert_images` VALUES (1,1,'mock-aqua-white-front.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(2,1,'mock-aqua-white-rear.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(3,2,'mock-aqua-red-front.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(4,2,'mock-aqua-red-rear.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(5,2,'mock-aqua-red-front-seats.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(6,2,'mock-aqua-red-rear-seats.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(7,3,'mock-aqua-2018-white.webp','admincontent/v_img/','admincontent/v_img/thumb/','1'),(8,4,'mock-alto-800-red.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1'),(9,5,'mock-bmw-ix-grey.jpg','admincontent/v_img/','admincontent/v_img/thumb/','1');
/*!40000 ALTER TABLE `advert_images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_config` (
  `key` varchar(255) NOT NULL DEFAULT '',
  `val` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `app_config` WRITE;
/*!40000 ALTER TABLE `app_config` DISABLE KEYS */;
INSERT INTO `app_config` VALUES ('admin_path','systemadmin/'),('img_watermark',''),('img_watermark_thumb',''),('main_admin_logo_name','systemadmin/images/new/logo/sonnac_logo.png'),('main_company_name','Sonnac Lanka Enterprises'),('no_image_mpath','admincontent/v_img/'),('no_image_name','not_available.jpg'),('no_image_tpath','admincontent/v_img/thumb/'),('powered_logo','systemadmin/images/w3s_logo.png'),('powered_name','W3S Solutions'),('powered_url','#'),('session_head','sonnac_'),('sys_name','Admin Panel'),('sys_title','Sonnac Lanka Enterprises | Admin');
/*!40000 ALTER TABLE `app_config` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `availability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `availability` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `availability` WRITE;
/*!40000 ALTER TABLE `availability` DISABLE KEYS */;
/*!40000 ALTER TABLE `availability` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `body_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `body_type` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT 'images/vcolors',
  `imgname` varchar(255) DEFAULT NULL,
  `vehicle_group` enum('car','motorcycle') NOT NULL DEFAULT 'car',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `body_type` WRITE;
/*!40000 ALTER TABLE `body_type` DISABLE KEYS */;
INSERT INTO `body_type` VALUES (1,'Hatchback','1','images/vcolors',NULL,'car'),(2,'Sedan','1','images/vcolors',NULL,'car'),(3,'SUV','1','images/vcolors',NULL,'car'),(4,'Station Wagon','1','images/vcolors',NULL,'car'),(5,'Van','1','images/vcolors',NULL,'car'),(6,'Double Cab','1','images/vcolors',NULL,'car');
/*!40000 ALTER TABLE `body_type` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `carsale_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carsale_users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_carsales` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastLogin` datetime DEFAULT NULL,
  `lastIp` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `carsale_users` WRITE;
/*!40000 ALTER TABLE `carsale_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `carsale_users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `carsales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carsales` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contactperson` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contactpersonemail` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_validation` tinyint(1) DEFAULT '0',
  `lastLogin` datetime DEFAULT NULL,
  `lastIp` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `carsales` WRITE;
/*!40000 ALTER TABLE `carsales` DISABLE KEYS */;
/*!40000 ALTER TABLE `carsales` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `carsales_component_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carsales_component_price` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `carsales_component_price` WRITE;
/*!40000 ALTER TABLE `carsales_component_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `carsales_component_price` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `carsales_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carsales_payments` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_carsales` int DEFAULT NULL,
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
  `number_of_months` int DEFAULT NULL,
  `number_of_days` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `activate` tinyint(1) DEFAULT '0',
  `free_trial` tinyint(1) DEFAULT '0',
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `carsales_payments` WRITE;
/*!40000 ALTER TABLE `carsales_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `carsales_payments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Brand New','1'),(2,'Reconditioned','1'),(3,'Used (Registered)','1');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `chasicode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chasicode` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_model` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `chasicode` WRITE;
/*!40000 ALTER TABLE `chasicode` DISABLE KEYS */;
/*!40000 ALTER TABLE `chasicode` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `othername` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fk_province` int DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `colour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colour` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT 'images/vcolors',
  `imgname` varchar(255) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `colour` WRITE;
/*!40000 ALTER TABLE `colour` DISABLE KEYS */;
INSERT INTO `colour` VALUES (1,'White','images/vcolors',NULL,'1'),(2,'Pearl White','images/vcolors',NULL,'1'),(3,'Red','images/vcolors',NULL,'1'),(4,'Black','images/vcolors',NULL,'1'),(5,'Silver','images/vcolors',NULL,'1'),(6,'Grey','images/vcolors',NULL,'1'),(7,'Blue','images/vcolors',NULL,'1');
/*!40000 ALTER TABLE `colour` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_advert` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `filepath` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  `addu` int DEFAULT NULL,
  `addt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `txtSMTPUserName` varchar(255) DEFAULT NULL,
  `txtSMTPServer` varchar(255) DEFAULT NULL,
  `txtSMTPPassword` varchar(255) DEFAULT NULL,
  `adminEmials` text,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `emailadress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emailadress` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `addu` bigint DEFAULT NULL,
  `updateu` bigint DEFAULT NULL,
  `delu` bigint DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delt` timestamp NULL DEFAULT NULL,
  `delcomment` text,
  `selected` tinyint(1) DEFAULT '0',
  `selectedtime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `emailadress` WRITE;
/*!40000 ALTER TABLE `emailadress` DISABLE KEYS */;
INSERT INTO `emailadress` VALUES (1,'nuwan.perera@example.com','Nuwan Perera',1,6,NULL,NULL,'2026-10-06 11:56:20',NULL,NULL,NULL,0,NULL),(2,'dilani.f@example.com','Dilani Fernando',1,6,NULL,NULL,'2026-09-29 11:56:20',NULL,NULL,NULL,0,NULL),(3,'ruwan.j@example.com','Ruwan Jayasinghe',1,6,NULL,NULL,'2026-09-24 11:56:20',NULL,NULL,NULL,0,NULL),(4,'ishara.w@example.com','Ishara Wijesekara',1,6,NULL,NULL,'2026-09-09 11:56:20',NULL,NULL,NULL,0,NULL),(5,'kasun.bandara@example.com','Kasun Bandara',1,6,NULL,NULL,'2026-08-25 11:56:20',NULL,NULL,NULL,0,NULL),(6,'sachini.silva@example.com','Sachini Silva',1,6,NULL,NULL,'2026-08-10 11:56:20',NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `emailadress` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `engine_capacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `engine_capacity` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `_status` varchar(255) DEFAULT NULL,
  `fk_carsale` int NOT NULL DEFAULT '0',
  `addu` int DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `engine_capacity` WRITE;
/*!40000 ALTER TABLE `engine_capacity` DISABLE KEYS */;
INSERT INTO `engine_capacity` VALUES (1,'660 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(2,'800 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(3,'1000 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(4,'1200 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(5,'1300 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(6,'1500 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(7,'1800 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(8,'2000 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(9,'2200 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(10,'2400 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(11,'2800 cc','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(12,'Electric','1',0,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `engine_capacity` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `extra_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extra_images` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_advert` int DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `extra_images` WRITE;
/*!40000 ALTER TABLE `extra_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `extra_images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `fuel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fuel` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fuel` WRITE;
/*!40000 ALTER TABLE `fuel` DISABLE KEYS */;
INSERT INTO `fuel` VALUES (1,'Petrol',1),(2,'Diesel',1),(3,'Hybrid',1),(4,'Electric',1);
/*!40000 ALTER TABLE `fuel` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inquiries` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_advert` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `addt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `fk_advert` (`fk_advert`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `inquiries` WRITE;
/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
INSERT INTO `inquiries` VALUES (1,1,'Nuwan Perera','nuwan.perera@example.com','0771234567','Is the white Aqua Z still available? Can I come for a test drive this Saturday?',0,'127.0.0.1','2026-10-09 09:56:20'),(2,5,'Dilani Fernando','dilani.f@example.com','0712345678','What is the real-world range of the iX and do you provide a wall charger?',0,'127.0.0.1','2026-10-08 11:56:20'),(3,9,'Ruwan Jayasinghe','ruwan.j@example.com','0763456789','Interested in the Prado. Is leasing possible and what is the minimum down payment?',0,'127.0.0.1','2026-10-07 11:56:20'),(4,6,'Ishara Wijesekara','ishara.w@example.com','0754567890','When will the Vezel arrive in Colombo? I would like to reserve it.',1,'127.0.0.1','2026-10-05 11:56:20'),(5,2,'Kasun Bandara','kasun.bandara@example.com','0705678901','Can you send more photos of the red Aqua, especially the engine bay?',1,'127.0.0.1','2026-10-03 11:56:20'),(6,15,'Sachini Silva','sachini.silva@example.com','0726789012','Is the special offer price on the Fit negotiable for a cash buyer?',0,'127.0.0.1','2026-09-30 11:56:20'),(7,4,'Mohamed Rizwan','m.rizwan@example.com','0777890123','Would you accept my 2014 Wagon R as a trade-in for the Alto?',1,'127.0.0.1','2026-09-25 11:56:20'),(8,NULL,'Tharindu Rathnayake','tharindu.r@example.com','0718901234','Do you import vehicles on order? Looking for a 2022 Toyota Raize.',1,'127.0.0.1','2026-09-19 11:56:20');
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `dist_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_user` int DEFAULT NULL,
  `firtlogedintime` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `main` WRITE;
/*!40000 ALTER TABLE `main` DISABLE KEYS */;
/*!40000 ALTER TABLE `main` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `make`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `make` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'images\\logos',
  `img_name` varchar(255) DEFAULT NULL,
  `addu` int DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  `vehicle_group` enum('car','motorcycle') NOT NULL DEFAULT 'car',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `make` WRITE;
/*!40000 ALTER TABLE `make` DISABLE KEYS */;
INSERT INTO `make` VALUES (1,'Toyota',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car'),(2,'Honda',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car'),(3,'Suzuki',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car'),(4,'Nissan',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car'),(5,'Mitsubishi',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car'),(6,'BMW',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car'),(7,'Mazda',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','','car');
/*!40000 ALTER TABLE `make` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `mileage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mileage` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'images\\logos',
  `img_name` varchar(255) DEFAULT NULL,
  `addu` int DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `mileage` WRITE;
/*!40000 ALTER TABLE `mileage` DISABLE KEYS */;
INSERT INTO `mileage` VALUES (1,' km',1,'images\\logos',NULL,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `mileage` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `fk_make` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `addu` int DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `updateu` int DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` int DEFAULT NULL,
  `delt` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delcomment` varchar(255) DEFAULT '',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (1,'Aqua','1',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(2,'Prius','1',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(3,'Vitz','1',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(4,'Premio','1',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(5,'Land Cruiser Prado','1',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(6,'Vezel','2',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(7,'Fit','2',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(8,'Civic','2',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(9,'Alto','3',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(10,'Wagon R','3',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(11,'Swift','3',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(12,'X-Trail','4',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(13,'Leaf','4',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(14,'Montero Sport','5',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(15,'iX','6',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00',''),(16,'CX-5','7',1,6,'2026-10-09 11:56:20',NULL,NULL,NULL,'0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `price_per`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_per` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `price_per` WRITE;
/*!40000 ALTER TABLE `price_per` DISABLE KEYS */;
/*!40000 ALTER TABLE `price_per` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `price_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_type` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `price_type` WRITE;
/*!40000 ALTER TABLE `price_type` DISABLE KEYS */;
INSERT INTO `price_type` VALUES (1,'Rs.','1');
/*!40000 ALTER TABLE `price_type` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `price_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_types` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `price_types` WRITE;
/*!40000 ALTER TABLE `price_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `price_types` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prices` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastlapcif` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `prices` WRITE;
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `property_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_type` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `property_type` WRITE;
/*!40000 ALTER TABLE `property_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_type` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `province` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `fullname` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (1,'Chaminda Herath','Toyota Aqua owner','Sri Lanka','Smooth buying experience from start to finish. The team explained the auction sheet clearly and the car was exactly as described.','admincontent/review/','',1,'Chaminda Herath'),(2,'Nadeesha Kumari','Honda Vezel owner','Sri Lanka','They helped me arrange leasing within a week. Very honest about the vehicle history and very responsive on WhatsApp.','admincontent/review/','',1,'Nadeesha Kumari'),(3,'Asanka Gunawardena','Mitsubishi Montero owner','Sri Lanka','Second vehicle I have bought from Sonnac Lanka. Great after-sales support and fair trade-in value.','admincontent/review/','',1,'Asanka Gunawardena'),(4,'Priyanka Dissanayake','Suzuki Wagon R owner','Sri Lanka','Perfect first car for me. Paperwork was handled quickly and the registration was done without any hassle.','admincontent/review/','',1,'Priyanka Dissanayake');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (1,'Colombo Showroom','1'),(2,'Kandy Branch','1'),(3,'In Transit (Japan)','1');
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `system_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_admin` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL DEFAULT '',
  `sales` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `_status` varchar(200) NOT NULL DEFAULT '1',
  `lastLogin` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastIp` varchar(255) NOT NULL DEFAULT '0',
  `super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `addu` bigint DEFAULT NULL,
  `addt` timestamp NULL DEFAULT NULL,
  `addu_type` varchar(255) NOT NULL DEFAULT '',
  `updateu` bigint DEFAULT NULL,
  `updateu_type` varchar(255) DEFAULT NULL,
  `updatet` timestamp NULL DEFAULT NULL,
  `delu` bigint DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_admin` WRITE;
/*!40000 ALTER TABLE `system_admin` DISABLE KEYS */;
INSERT INTO `system_admin` VALUES (6,'Local','Admin','admin','$2y$10$cFuhGQP39M0F6UKLeKId0u2rvUaNYTmWwwOvb7HicN1ZeaY2aDCVO',NULL,'admin@localhost',NULL,'1','2026-10-09 11:57:10','::1',1,NULL,'2026-10-09 11:45:04','seed',NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL,NULL,'','','',NULL,NULL);
/*!40000 ALTER TABLE `system_admin` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `system_admin_privilage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_admin_privilage` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `fk_system_admin` varchar(200) NOT NULL DEFAULT '',
  `fk_system_admin_privilage_property` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_admin_privilage` WRITE;
/*!40000 ALTER TABLE `system_admin_privilage` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_admin_privilage` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `system_admin_privilage_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_admin_privilage_property` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `property_name` varchar(200) NOT NULL DEFAULT '',
  `_status` tinyint(1) DEFAULT '0',
  `fk_system_admin_privilage_type` int DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_admin_privilage_property` WRITE;
/*!40000 ALTER TABLE `system_admin_privilage_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_admin_privilage_property` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `system_admin_privilage_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_admin_privilage_type` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_admin_privilage_type` WRITE;
/*!40000 ALTER TABLE `system_admin_privilage_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_admin_privilage_type` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `transmission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transmission` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `transmission` WRITE;
/*!40000 ALTER TABLE `transmission` DISABLE KEYS */;
INSERT INTO `transmission` VALUES (1,'Automatic',1),(2,'Manual',1),(3,'Tiptronic',1);
/*!40000 ALTER TABLE `transmission` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT 'images/vcolors',
  `imgname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'Car','1','images/vcolors',NULL),(2,'SUV / Jeep','1','images/vcolors',NULL),(3,'Van','1','images/vcolors',NULL);
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `types` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagepath` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `lastLogin` datetime DEFAULT NULL,
  `sales` tinyint(1) DEFAULT '0',
  `bidding` tinyint(1) DEFAULT '0',
  `account` tinyint(1) DEFAULT '0',
  `lc` tinyint(1) DEFAULT '0',
  `uv` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `regNo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fk_seller` int DEFAULT NULL,
  `fk_buyer` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `ins2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `vtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vtype` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagepath` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `vtype` WRITE;
/*!40000 ALTER TABLE `vtype` DISABLE KEYS */;
/*!40000 ALTER TABLE `vtype` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `year` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `year` WRITE;
/*!40000 ALTER TABLE `year` DISABLE KEYS */;
/*!40000 ALTER TABLE `year` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `yenrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `yenrate` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `yenrate` double DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `yenrate` WRITE;
/*!40000 ALTER TABLE `yenrate` DISABLE KEYS */;
/*!40000 ALTER TABLE `yenrate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

