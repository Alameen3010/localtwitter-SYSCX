-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 05:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12


CREATE DATABASE IF NOT EXISTS alameen_alliu_syscx;
USE alameen_alliu_syscx;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alameen_alliu_syscx`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_address`
--

CREATE TABLE `users_address` (
  `student_id` int(10) NOT NULL,
  `street_number` int(5) DEFAULT NULL,
  `street_name` varchar(150) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `province` char(2) DEFAULT NULL,
  `postal_code` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_address`
--

INSERT INTO `users_address` (`student_id`, `street_number`, `street_name`, `city`, `province`, `postal_code`) VALUES
(100100, 0, NULL, NULL, NULL, NULL),
(100101, 0, NULL, NULL, NULL, NULL),
(100102, 0, NULL, NULL, NULL, NULL),
(100103, 0, NULL, NULL, NULL, NULL),
(100104, 0, NULL, NULL, NULL, NULL),
(100105, 0, NULL, NULL, NULL, NULL),
(100106, 0, NULL, NULL, NULL, NULL),
(100107, 0, NULL, NULL, NULL, NULL),
(100108, 0, NULL, NULL, NULL, NULL),
(100109, 0, NULL, NULL, NULL, NULL),
(100110, 0, NULL, NULL, NULL, NULL),
(100117, 0, NULL, NULL, NULL, NULL),
(100118, 101, 'Champagne Avenue South', 'Ottawa', 'ON', 'K1S4P3'),
(100119, 1, 'cham', 'Toronto', 'ON', 'K235GT'),
(100120, 0, NULL, NULL, NULL, NULL),
(100121, 101, 'Champagne Avenue', 'Ottawa', 'On', 'K1S4P3');

-- --------------------------------------------------------

--
-- Table structure for table `users_avatar`
--

CREATE TABLE `users_avatar` (
  `student_id` int(10) NOT NULL,
  `avatar` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_avatar`
--

INSERT INTO `users_avatar` (`student_id`, `avatar`) VALUES
(100100, 0),
(100101, 0),
(100102, 0),
(100103, 0),
(100104, 0),
(100105, 0),
(100106, 0),
(100107, 0),
(100108, 0),
(100109, 0),
(100110, 0),
(100111, 0),
(100112, 0),
(100117, 0),
(100118, 1),
(100119, 5),
(100120, 0),
(100121, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `student_id` int(10) NOT NULL,
  `student_email` varchar(150) DEFAULT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`student_id`, `student_email`, `first_name`, `last_name`, `dob`) VALUES
(100100, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100101, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100102, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100103, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100104, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100105, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100106, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100107, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100108, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100109, 'alameenalliu@cmail.carleton.ca', 'Alliu\'s', 'Profile', '2008-07-09'),
(100110, 'alameenalliu@cmail.carleton.ca', 'Alliu\'s', 'Profile', '2008-07-09'),
(100111, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100112, 'newdazn786@gmail.com', 'Alameen', 'Alliu', '2008-01-02'),
(100113, 'alameenalliu@cmail.carleton.ca', 'Al-ameen', 'Olaolu Alliu', '2002-07-06'),
(100114, 'newdazn786@gmail.com', 'Alameen', 'Alliu', '2004-09-08'),
(100115, 'newdazn786@gmail.com', 'Alameen', 'Alliu', '2004-09-08'),
(100116, 'newdazn786@gmail.com', 'Alameen', 'Alliu', '2004-09-08'),
(100117, 'alameenalliu@cmail.carleton.ca', 'Alameen', 'Alliu', '2024-03-04'),
(100118, 'alliujunior02@gmail.com', 'Alameen', 'Alliu', '2002-06-07'),
(100119, 'alameenalliu@carleton.ca', 'Alameen', 'Alliu', '2024-03-30'),
(100120, 'alameenalliu@carleton.ca', 'Alameen', 'Alliu', '2024-03-01'),
(100121, 'alameenalliu@cmail.carleton.ca', 'Al-ameen ', 'Alliu', '2002-06-07');

-- --------------------------------------------------------

--
-- Table structure for table `users_posts`
--

CREATE TABLE `users_posts` (
  `post_id` int(11) NOT NULL,
  `student_id` int(10) DEFAULT NULL,
  `new_post` text DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_posts`
--

INSERT INTO `users_posts` (`post_id`, `student_id`, `new_post`, `post_date`) VALUES
(1, 100120, 'This is for testing purposes', '2024-03-25 15:46:40'),
(2, 100120, 'Another testing ', '2024-03-25 15:46:59'),
(3, 100121, 'My first post\r\n', '2024-03-25 16:27:05'),
(4, 100121, 'My 4th post', '2024-03-25 16:27:15'),
(5, 100121, 'This is the 5th\r\n', '2024-03-25 16:27:23'),
(6, 100121, 'What happening?\r\n', '2024-03-25 16:27:26'),
(7, 100121, 'Displaying just 5 ?', '2024-03-25 16:38:08'),
(8, 100121, 'What happening?', '2024-03-25 16:38:10'),
(9, 100121, 'What happening?', '2024-03-25 16:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_program`
--

CREATE TABLE `users_program` (
  `student_id` int(10) NOT NULL,
  `program` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_program`
--

INSERT INTO `users_program` (`student_id`, `program`) VALUES
(100100, 'Computer Systems Engineering'),
(100101, 'Special'),
(100102, 'Electrical Engineering'),
(100103, 'Electrical Engineering'),
(100104, 'Electrical Engineering'),
(100105, 'Electrical Engineering'),
(100106, 'Electrical Engineering'),
(100107, 'Special'),
(100108, 'Software Engineering'),
(100109, 'Software Engineering'),
(100110, 'Software Engineering'),
(100111, 'Software Engineering'),
(100112, 'Special'),
(100113, 'Computer Systems Engineering'),
(100114, 'Special'),
(100115, 'Special'),
(100116, 'Special'),
(100117, 'Software Engineering'),
(100118, 'Special'),
(100119, 'Computer Systems Engineering'),
(100120, 'Special'),
(100121, 'Computer Systems Engineering');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_address`
--
ALTER TABLE `users_address`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users_avatar`
--
ALTER TABLE `users_avatar`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users_posts`
--
ALTER TABLE `users_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users_program`
--
ALTER TABLE `users_program`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_info`
--
ALTER TABLE `users_info`
  MODIFY `student_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100122;

--
-- AUTO_INCREMENT for table `users_posts`
--
ALTER TABLE `users_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_address`
--
ALTER TABLE `users_address`
  ADD CONSTRAINT `users_address_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

--
-- Constraints for table `users_avatar`
--
ALTER TABLE `users_avatar`
  ADD CONSTRAINT `users_avatar_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

--
-- Constraints for table `users_posts`
--
ALTER TABLE `users_posts`
  ADD CONSTRAINT `users_posts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);

--
-- Constraints for table `users_program`
--
ALTER TABLE `users_program`
  ADD CONSTRAINT `users_program_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users_info` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
