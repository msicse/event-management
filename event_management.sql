-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 01, 2025 at 01:44 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

DROP TABLE IF EXISTS `attendees`;
CREATE TABLE IF NOT EXISTS `attendees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registered_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `event_id`, `name`, `email`, `registered_at`) VALUES
(1, 1, 'John Doe', 'john.doe@example.com', '2025-02-01 13:43:19'),
(2, 1, 'Jane Smith', 'jane.smith@example.com', '2025-02-01 13:43:19'),
(3, 1, 'Alice Johnson', 'alice.johnson@example.com', '2025-02-01 13:43:19'),
(4, 2, 'Bob Brown', 'bob.brown@example.com', '2025-02-01 13:43:19'),
(5, 2, 'Charlie Davis', 'charlie.davis@example.com', '2025-02-01 13:43:19'),
(6, 2, 'Emily White', 'emily.white@example.com', '2025-02-01 13:43:19'),
(7, 3, 'Michael Green', 'michael.green@example.com', '2025-02-01 13:43:19'),
(8, 3, 'Sophia Black', 'sophia.black@example.com', '2025-02-01 13:43:19'),
(9, 3, 'Daniel Gray', 'daniel.gray@example.com', '2025-02-01 13:43:19'),
(10, 1, 'Olivia Blue', 'olivia.blue@example.com', '2025-02-01 13:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(100) NOT NULL,
  `capacity` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `event_date`, `location`, `capacity`, `created_by`, `created_at`) VALUES
(1, 'Tech Conference 2025', 'Annual technology conference', '2025-05-10', 'New York', 100, 1, '2025-02-01 13:31:08'),
(2, 'Business Expo', 'Networking and business opportunities', '2025-06-15', 'Los Angeles', 200, 1, '2025-02-01 13:31:08'),
(3, 'Music Festival', 'Live music event', '2025-07-20', 'Chicago', 500, 2, '2025-02-01 13:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@test.com', '$2y$10$IupgBI7N9TdSZahpHTSvrevUH13Huy0WxGxuSW3PYJO6SGivu8rpq', 'admin', '2025-02-01 13:14:10'),
(2, 'User', 'user@test.com', '$2y$10$cJKS9U4Ac7uAZRMhGirz..6IuOyldNlIr04M1HgfICXCN6H6UzzJC', 'user', '2025-02-01 13:14:44');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
