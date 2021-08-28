-- MySQL dump 10.19  Distrib 10.3.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: eb_v1_0_2
-- ------------------------------------------------------
-- Server version	10.3.29-MariaDB-0+deb10u1

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
-- Current Database: `eb_v1_0_2`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `eb_v1_0_2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `eb_v1_0_2`;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (5,'Clavos'),(1,'Repuestos'),(2,'Tornillos'),(3,'Tuercas');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(25,2) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomes`
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'filter.jpg','image/jpeg'),(3,'tuerca.png','image/png'),(4,'tornillo1.jpg','image/jpeg'),(5,'tornillo2.jpg','image/jpeg'),(6,'torx-1.jpeg','image/jpeg'),(7,'torx-2.jpeg','image/jpeg'),(8,'torx-3.jpeg','image/jpeg');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `partNo` varchar(60) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT 0.00,
  `sale_price` decimal(25,2) DEFAULT 0.00,
  `categorie_id` int(10) unsigned NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `media_id` int(10) unsigned DEFAULT 0,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partNo` (`partNo`),
  KEY `categorie_id` (`categorie_id`),
  KEY `media_id` (`media_id`),
  CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_products2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Filtro de gasolina','FILT_AB0F01',94,15.00,25.00,1,'X1',1,'2017-06-16 07:03:16'),(2,'Tornillo hexagonal 10mm x 50mm','TOR_HEX_001',23,2.00,3.40,2,'A1',4,'2019-03-01 07:03:16'),(3,'Tornillo hexagonal 8mm x 45mm','TOR_HEX_002',25,2.00,3.00,2,'A2',4,'2019-03-01 07:03:16'),(4,'Tornillo hexagonal 8mm x 50mm','TOR_HEX_003',94,2.00,3.00,2,'X2',4,'2019-03-01 07:03:16'),(5,'Tornillo Phillips1 70mm','TOR_PHI_170',83,2.50,5.10,2,'A1',5,'2019-03-02 07:05:23'),(6,'Tornillo Phillips1 80mm','TOR_PHI_180',90,2.50,4.50,2,'A2',5,'2019-03-02 07:05:34'),(7,'Tornillo Phillips1 90mm','TOR_PHI_190',89,2.50,4.50,2,'X2',5,'2019-03-02 07:06:02'),(8,'Tornillo Phillips2 70mm','TOR_PHI_270',85,2.50,4.50,2,'X4',5,'2019-03-02 07:06:10'),(9,'Tornillo Phillips2 80mm','TOR_PHI_280',86,2.50,4.50,2,'X4',5,'2019-03-02 07:06:15'),(10,'Tornillo Phillips2 90mm','TOR_PHI_290',101,2.50,4.50,2,'X4',5,'2019-03-02 07:06:21'),(11,'Tornillo Phillips3 80mm','TOR_PHI_380',80,3.00,5.20,2,'A1',5,'2020-06-05 17:04:14'),(14,'Tornillo Phillips1 80mm','TOR_PHI_180_2',50,2.90,5.30,2,'A1',5,'2020-06-11 14:20:26'),(21,'Tornillo_5','TOR_HEX_005',102,1.00,1.30,2,'AA2',4,'2021-03-31 12:30:06');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `buy_price` decimal(25,2) DEFAULT 0.00,
  `sale_price` decimal(25,2) DEFAULT 0.00,
  `total_sale` decimal(25,2) DEFAULT 0.00,
  `profit` decimal(25,2) DEFAULT 0.00,
  `destination` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,7,6,2.50,4.50,27.00,12.00,'Pedro','2020-06-10 00:00:00'),(30,3,4,2.00,3.00,11.00,3.00,'Pedro','2020-06-11 02:26:05'),(32,3,7,2.00,3.00,21.00,7.00,'Juan','2020-06-04 00:00:00'),(33,3,5,2.00,3.00,15.00,5.00,'Almacen La Felicidad','2020-06-08 00:00:00'),(34,2,2,2.00,3.00,5.00,1.00,'Juan P.','2020-06-09 00:00:00'),(35,2,2,2.00,3.00,6.00,2.00,'Jose Martinez','2020-06-03 00:00:00'),(37,2,3,2.00,3.00,9.00,3.00,'Pedro Perez','2020-06-01 00:00:00'),(38,1,10,15.00,25.00,250.00,100.00,'Almacen La Felicidad','2020-06-11 00:00:00'),(39,3,1,2.00,3.00,3.00,1.00,'Almacen La Felicidad','2020-06-08 00:00:00'),(40,7,2,2.50,4.50,9.00,4.00,'Jesus','2020-05-27 00:00:00'),(41,6,10,2.50,4.50,45.00,20.00,'Pedro Perez','2020-05-28 00:00:00'),(45,9,14,2.50,4.20,58.80,23.80,'Pedro Perez','2020-06-08 00:00:00'),(46,5,10,2.50,5.30,53.00,28.00,'Juan Hernandez','2020-06-11 00:00:00'),(47,2,5,2.00,3.40,17.00,7.00,'Pedro','2021-04-01 00:00:00'),(48,7,10,2.50,4.50,45.00,20.00,'Distribuidora XXY','2021-04-03 00:00:00'),(49,2,2,2.00,3.40,6.80,2.80,'Distribuidora XXY','2021-04-01 00:00:00'),(50,5,10,2.50,5.10,51.00,26.00,'Pedro Perez','2021-03-30 00:00:00'),(51,8,10,2.50,4.50,45.00,20.00,'Cliente XYZ','2021-04-05 00:00:00');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_level` (`group_level`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Admin',1,1),(2,'Special',2,1),(3,'User',3,1);
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `user_level` (`user_level`),
  CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',1,'lnizqp31.jpg',1,'2021-08-28 15:47:11'),(3,'Normal User','user','b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2',3,'no_image.jpg',1,'2021-07-27 17:04:51'),(17,'Special User','special','98d5f28f0c604d7e34ea730e8dd61a644cf839bd1a56539bbaba0bba78c5529e3eb7002c3985ac7ad5ada28651fa88532b45717729c7cd9958e0e17415e1fcea',2,'no_image.jpg',1,'2021-07-27 17:04:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-28 16:59:18
