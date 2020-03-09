-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pkyrimg
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB-0+deb10u1

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
-- Table structure for table `assessment`
--

DROP TABLE IF EXISTS `assessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assessment` (
  `grade` tinyint(1) NOT NULL,
  `img` varchar(100) NOT NULL,
  `user` int(11) DEFAULT NULL,
  PRIMARY KEY (`grade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment`
--

LOCK TABLES `assessment` WRITE;
/*!40000 ALTER TABLE `assessment` DISABLE KEYS */;
/*!40000 ALTER TABLE `assessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `action` tinyint(1) DEFAULT NULL,
  `img` char(150) DEFAULT NULL,
  `favorite` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,1,219,0,'https://imgs.xkcd.com/comics/blanket_fort.png',NULL),(2,1,1231,1,'https://imgs.xkcd.com/comics/habitable_zone.png',0),(3,1,664,0,'https://imgs.xkcd.com/comics/academia_vs_business.png',NULL),(4,1,1116,0,'https://imgs.xkcd.com/comics/traffic_lights.gif',NULL),(5,1,1823,1,'https://imgs.xkcd.com/comics/hottest_editors.png',1),(6,1,1124,0,'https://imgs.xkcd.com/comics/law_of_drama.png',0),(7,1,54,0,'https://imgs.xkcd.com/comics/science.jpg',0),(8,1,981,0,'https://imgs.xkcd.com/comics/porn_folder.png',1),(9,1,1969,0,'https://imgs.xkcd.com/comics/not_available.png',0),(10,1,1912,NULL,NULL,0),(11,1,1847,0,'https://imgs.xkcd.com/comics/dubious_study.png',1),(12,1,1209,NULL,NULL,0),(13,1,932,NULL,'https://imgs.xkcd.com/comics/cia.png',0),(14,1,1497,NULL,'https://imgs.xkcd.com/comics/new_products.png',0),(15,1,1972,NULL,'https://imgs.xkcd.com/comics/autogyros.png',0),(16,1,1999,NULL,'https://imgs.xkcd.com/comics/selection_effect.png',0),(17,1,1089,NULL,'https://imgs.xkcd.com/comics/internal_monologue.png',0),(18,1,621,0,'https://imgs.xkcd.com/comics/superlative.png',1),(19,1,1956,NULL,'https://imgs.xkcd.com/comics/unification.png',0),(20,1,1357,0,'https://imgs.xkcd.com/comics/free_speech.png',NULL),(21,1,915,0,'https://imgs.xkcd.com/comics/connoisseur.png',NULL),(22,1,1100,1,'https://imgs.xkcd.com/comics/vows.png',0);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'demo','$2y$13$XC/lNejJ1c6zE6QW3nTtx.zWpGfTHPjSQ0/bGKA7P7MWXcVjB1BxC','user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-09 20:15:21
