# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.34)
# Database: nerdygadgets
# Generation Time: 2021-12-02 20:20:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bestelling_lines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bestelling_lines`;

CREATE TABLE `bestelling_lines` (
  `BestellingLineID` int(11) NOT NULL AUTO_INCREMENT,
  `BestellingID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`BestellingLineID`),
  KEY `BestellingID` (`BestellingID`),
  CONSTRAINT `bestelling_lines_ibfk_1` FOREIGN KEY (`BestellingID`) REFERENCES `bestellingen` (`BestellingID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `bestelling_lines` WRITE;
/*!40000 ALTER TABLE `bestelling_lines` DISABLE KEYS */;

INSERT INTO `bestelling_lines` (`BestellingLineID`, `BestellingID`, `ProductID`, `quantity`)
VALUES
	(1,30,100,3),
	(2,81,138,2),
	(3,81,220,1),
	(4,82,138,3);

/*!40000 ALTER TABLE `bestelling_lines` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table bestellingen
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bestellingen`;

CREATE TABLE `bestellingen` (
  `BestellingID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonID` int(11) NOT NULL,
  PRIMARY KEY (`BestellingID`),
  KEY `PersonID` (`PersonID`),
  CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`PersonID`) REFERENCES `people` (`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `bestellingen` WRITE;
/*!40000 ALTER TABLE `bestellingen` DISABLE KEYS */;

INSERT INTO `bestellingen` (`BestellingID`, `PersonID`)
VALUES
	(15,10),
	(16,10),
	(17,10),
	(18,10),
	(19,10),
	(20,10),
	(21,10),
	(22,10),
	(23,10),
	(24,10),
	(25,10),
	(26,10),
	(27,10),
	(28,10),
	(29,10),
	(30,10),
	(31,10),
	(32,10),
	(33,10),
	(34,10),
	(35,10),
	(36,10),
	(37,10),
	(38,10),
	(39,10),
	(40,10),
	(41,10),
	(42,10),
	(43,10),
	(44,10),
	(45,10),
	(46,10),
	(47,10),
	(48,10),
	(49,10),
	(50,10),
	(51,10),
	(52,10),
	(53,10),
	(54,10),
	(55,10),
	(56,10),
	(57,10),
	(58,10),
	(59,10),
	(60,10),
	(61,10),
	(62,10),
	(63,10),
	(64,10),
	(65,10),
	(66,10),
	(67,10),
	(68,10),
	(69,10),
	(70,10),
	(71,10),
	(72,10),
	(73,10),
	(74,10),
	(75,10),
	(76,10),
	(77,10),
	(78,10),
	(79,10),
	(80,10),
	(81,10),
	(82,10);

/*!40000 ALTER TABLE `bestellingen` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
