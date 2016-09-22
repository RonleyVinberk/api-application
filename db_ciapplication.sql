-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.14-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for db_apiapplication
CREATE DATABASE IF NOT EXISTS `db_apiapplication` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_apiapplication`;


-- Dumping structure for table db_apiapplication.google_users
CREATE TABLE IF NOT EXISTS `google_users` (
  `google_id` decimal(21,0) NOT NULL,
  `google_name` varchar(60) DEFAULT NULL,
  `google_email` varchar(32) DEFAULT NULL,
  `google_link` varchar(60) DEFAULT NULL,
  `google_picture_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`google_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_apiapplication.google_users: ~1 rows (approximately)
/*!40000 ALTER TABLE `google_users` DISABLE KEYS */;
INSERT INTO `google_users` (`google_id`, `google_name`, `google_email`, `google_link`, `google_picture_link`) VALUES
	(106673789107643737084, 'Ronley Vinberk', 'ronleyvinberk@gmail.com', NULL, 'https://lh6.googleusercontent.com/-2LevnN7s5Ro/AAAAAAAAAAI/AAAAAAAAABc/nCkYWH66rew/photo.jpg');
/*!40000 ALTER TABLE `google_users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
