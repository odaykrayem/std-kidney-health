-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: scit_kidney_health
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB

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
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  `create_at` date DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `result_info` varchar(1000) DEFAULT NULL,
  `patientStatus` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `center_id` (`center_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `center` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` (`id`, `patient_id`, `center_id`, `create_at`, `status`, `result_info`, `patientStatus`) VALUES (1,7,1,'2022-04-10',2,NULL,'kkk'),(2,9,1,'2022-04-20',0,NULL,NULL);
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `center`
--

DROP TABLE IF EXISTS `center`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `center`
--

LOCK TABLES `center` WRITE;
/*!40000 ALTER TABLE `center` DISABLE KEYS */;
INSERT INTO `center` (`id`, `name`, `info`, `lat`, `lon`, `doctor_id`, `location`) VALUES (1,'center','alazeez dialysis center',24.568601608276367,46.7713737487793,5,'alriyadd');
/*!40000 ALTER TABLE `center` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_content`
--

DROP TABLE IF EXISTS `chat_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `sender_type` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_type`),
  KEY `chat_id` (`chat_id`),
  CONSTRAINT `chat_content_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chat_list` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_content`
--

LOCK TABLES `chat_content` WRITE;
/*!40000 ALTER TABLE `chat_content` DISABLE KEYS */;
INSERT INTO `chat_content` (`id`, `chat_id`, `content`, `sender_type`, `created_at`) VALUES (1,1,'ننن',2,'2022-04-19 23:27:15'),(2,1,'ff',2,'2022-04-19 23:27:15'),(3,1,'hh',2,'2022-04-19 23:27:15'),(4,1,'hhh',2,'2022-04-19 23:27:15'),(5,1,'nnn',2,'2022-04-19 23:27:15'),(6,1,'jjj',2,'2022-04-19 23:27:15'),(7,1,'nnn',2,'2022-04-19 23:51:10'),(8,1,'hh',1,'2022-04-21 21:41:44'),(9,1,'hii',1,'2022-04-21 21:42:01');
/*!40000 ALTER TABLE `chat_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_list`
--

DROP TABLE IF EXISTS `chat_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`),
  CONSTRAINT `chat_list_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_list`
--

LOCK TABLES `chat_list` WRITE;
/*!40000 ALTER TABLE `chat_list` DISABLE KEYS */;
INSERT INTO `chat_list` (`id`, `patient_id`, `doctor_id`) VALUES (1,7,5),(2,7,5),(3,7,5),(4,7,5),(7,7,6);
/*!40000 ALTER TABLE `chat_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_info`
--

DROP TABLE IF EXISTS `daily_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `water_quntity` int(11) DEFAULT NULL,
  `medicine_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `daily_info_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_info`
--

LOCK TABLES `daily_info` WRITE;
/*!40000 ALTER TABLE `daily_info` DISABLE KEYS */;
INSERT INTO `daily_info` (`id`, `patient_id`, `water_quntity`, `medicine_info`, `created_at`) VALUES (3,7,99,'jj','2022-04-19 23:49:26');
/*!40000 ALTER TABLE `daily_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `details`, `address`) VALUES (5,'0','0','doctor@gmail.com','$2y$10$TGZ0T5yQMtSRdWsHpfV.WO4/RaBqKXgAtczUsG3Vsfd4ZT/qZM9KK','o','Kidney disease specialist','oo'),(6,'Hind','Hak','hno18@gmail.com','$2y$10$7djVMR8IUcPqpcqBk6k4m.Bm/Ml7EyJcIRmK2y5xrCKZEPDHmMdO2','057','doctor',NULL);
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructions`
--

DROP TABLE IF EXISTS `instructions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `instructions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  CONSTRAINT `instructions_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructions`
--

LOCK TABLES `instructions` WRITE;
/*!40000 ALTER TABLE `instructions` DISABLE KEYS */;
INSERT INTO `instructions` (`id`, `doctor_id`, `patient_id`, `content`, `created_at`) VALUES (1,5,7,'ff','2022-04-25 18:19:53'),(2,5,7,'hhh','2022-04-25 18:19:53');
/*!40000 ALTER TABLE `instructions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `age`, `address`, `details`, `gender`) VALUES (7,'patientFirstName','LastName','patient1@gmail.com','$2y$10$XtR2e3WZg99SBWn4D9rSpuukL4W/YPbJUTfGkFdt1FM6Fgyefw4QS','0096698798772',50,'alriyad',NULL,1),(9,'hind','hakami','hind@gmail.com','$2y$10$/5O3tOmkan/68UsODjxoo.kWdOrb5vM6.gK2qTll1uu/biBy4v57q','09',25,'madinah',NULL,1),(10,'hind','h','hind1@gmail.com','$2y$10$NBpGjLVXPwYLuwXVp6B6CenNCpzm3p8ndSG88szBkDVq8409dUuIm','09',24,'madina',NULL,1);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'scit_kidney_health'
--

--
-- Dumping routines for database 'scit_kidney_health'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-25 16:46:34
