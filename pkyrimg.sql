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
-- Current Database: `pkyrimg`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `pkyrimg` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pkyrimg`;

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
-- Table structure for table `like`
--

DROP TABLE IF EXISTS `like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `action` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like`
--

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
INSERT INTO `like` VALUES (1,123,321,NULL),(2,1,111,NULL),(3,1,222,NULL),(4,1,333,NULL),(5,16,111,NULL),(6,16,222,NULL),(7,16,333,NULL),(8,16,444,NULL),(9,16,98,NULL),(10,16,98,NULL),(11,16,98,NULL),(12,16,98,NULL),(13,16,98,NULL),(14,16,98,NULL),(15,16,98,NULL),(16,16,98,NULL),(17,16,98,NULL),(18,16,98,NULL),(19,16,98,NULL),(20,16,98,NULL),(21,16,98,NULL),(22,16,98,NULL),(23,16,98,NULL),(24,16,369,0),(25,16,1861,1),(26,16,22,1),(27,16,1603,0),(28,16,1603,0),(29,16,1603,1),(30,16,1603,1);
/*!40000 ALTER TABLE `like` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'123','$2y$13$0OW8A85O8Op6spE/RgaEaeuyPrHlNXaAYAaeouST0iKkCgV8FE3Xq','user'),(8,'tester','$2y$13$SVBUCLRvGLxKmSc2AZo/aerGKDKonXQWUDyGFVMcREhcYKmnBYvx2','user'),(9,'pew','$2y$13$LQ2vmQTXxlC1Gqv7nF.GeOg87k/Ma5bg37/jKNePpl0SZJe4Xo736','user'),(11,'ow','$2y$13$2chxep9rG1q3HpRpjvcSpuithfbhOPfaCjgkiJF2zCK5VzYqm1Cpm','user'),(13,'TESTY','$2y$13$RmtOm4g5HajxyNonxtJdh.1x0jWEy4bUCrdigKLR/4NORuAivVV7e','user'),(14,'тест','$2y$13$iCfPMldwO.uHTmFHo3DKWO8lKLTCD0SrvSqBdu71cY.GNtWyPUqqe','user'),(15,'test123','$2y$13$lJLaZoSxEzUZrV4QjU8L7ePNqwehgphkT.PQNY81bYqaw0HfGHpxu','user'),(16,'demo','$2y$13$QNcKmOZtpN62twgACMfFaOD6B3qEYnv4170WbJfw7muJ3q0SpUzv6','user');
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

-- Dump completed on 2020-02-14 12:17:28
