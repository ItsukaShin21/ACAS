-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for acas
CREATE DATABASE IF NOT EXISTS `acas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `acas`;

-- Dumping structure for table acas.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `accountID` int NOT NULL AUTO_INCREMENT,
  `rfiduid` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`accountID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table acas.attendancerecord
CREATE TABLE IF NOT EXISTS `attendancerecord` (
  `attendanceid` int NOT NULL AUTO_INCREMENT,
  `eventname` varchar(255) DEFAULT NULL,
  `studentid` int NOT NULL,
  `timein` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '-',
  `timeout` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '-',
  `status` varchar(50) DEFAULT '-',
  PRIMARY KEY (`attendanceid`),
  KEY `FK_attendancerecord_events` (`eventname`),
  CONSTRAINT `FK_attendancerecord_events` FOREIGN KEY (`eventname`) REFERENCES `events` (`eventname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table acas.events
CREATE TABLE IF NOT EXISTS `events` (
  `eventID` int NOT NULL AUTO_INCREMENT,
  `eventname` varchar(255) DEFAULT NULL,
  `eventdate` date DEFAULT NULL,
  `eventstart` time DEFAULT NULL,
  `eventend` time DEFAULT NULL,
  PRIMARY KEY (`eventID`),
  UNIQUE KEY `eventname` (`eventname`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table acas.students
CREATE TABLE IF NOT EXISTS `students` (
  `studentid` int NOT NULL AUTO_INCREMENT,
  `rfiduid` int(10) unsigned zerofill NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `section` varchar(50) NOT NULL DEFAULT '',
  `program` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`studentid`)
) ENGINE=InnoDB AUTO_INCREMENT=3481874570 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
