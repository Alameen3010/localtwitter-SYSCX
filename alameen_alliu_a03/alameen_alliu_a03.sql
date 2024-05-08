SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS alameen_alliu_syscx;
CREATE DATABASE IF NOT EXISTS alameen_alliu_syscx;
USE alameen_alliu_syscx;

CREATE TABLE IF NOT EXISTS `users_address` (
  `student_id` int(10) NOT NULL,
  `street_number` int(5) DEFAULT NULL,
  `street_name` varchar(150) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `province` varchar(2) DEFAULT NULL,
  `postal_code` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_avatar` (
  `student_id` int(10) NOT NULL,
  `avatar` int(1) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_info` (
  `student_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_email` varchar(150) DEFAULT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_email` (`student_email`)
) ENGINE=InnoDB AUTO_INCREMENT=100100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_passwords` (
  `student_id` int(10) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_permissions` (
  `student_id` int(10) NOT NULL,
  `account_type` int(1) DEFAULT 1,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_posts` (
  `post_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) DEFAULT NULL,
  `new_post` text DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_program` (
  `student_id` int(10) NOT NULL,
  `program` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `users_address`
  ADD CONSTRAINT `users_address_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

ALTER TABLE `users_avatar`
  ADD CONSTRAINT `users_avatar_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

ALTER TABLE `users_passwords`
  ADD CONSTRAINT `users_passwords_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

ALTER TABLE `users_permissions`
  ADD CONSTRAINT `users_permissions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

ALTER TABLE `users_posts`
  ADD CONSTRAINT `users_posts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

ALTER TABLE `users_program`
  ADD CONSTRAINT `users_program_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
