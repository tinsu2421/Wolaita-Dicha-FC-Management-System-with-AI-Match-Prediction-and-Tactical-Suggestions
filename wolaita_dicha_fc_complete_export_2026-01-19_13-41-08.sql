-- =====================================================
-- Wolaita Dicha FC - Complete Database Export
-- Generated on: 2026-01-19 13:41:08
-- Database: wolaita_dichafcdb
-- Project: Football Club Management System
-- Features: Fan Registration, Payment System, Admin Panel
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `wolaita_dichafcdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wolaita_dichafcdb`;

-- --------------------------------------------------------
-- Table structure for table `club`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `club`;
CREATE TABLE `club` (
  `club_id` int(11) NOT NULL AUTO_INCREMENT,
  `club_name` varchar(100) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `founded_year` year(4) DEFAULT NULL,
  PRIMARY KEY (`club_id`),
  UNIQUE KEY `club_name` (`club_name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `club`
-- Records: 19

INSERT INTO `club` (`club_id`, `club_name`, `city`, `country`, `founded_year`) VALUES
('1', 'Ethiopian Insurance', 'Addis Ababa', 'Ethiopia', NULL),
('2', 'Ethiopian Coffee', 'Addis Ababa', 'Ethiopia', '1976'),
('3', 'Bahir Dar City', 'Bahir Dar', 'Ethiopia', '1973'),
('4', 'Awassa City', 'Hawassa', 'Ethiopia', '1970'),
('5', 'Sidama Coffee', 'Hawassa / Sidama Region', 'Ethiopia', '2006'),
('6', 'Wolaitta Dicha', 'Sodo', 'Ethiopia', NULL),
('7', 'Arba Minch City', 'Arba Minch', 'Ethiopia', '1971'),
('8', 'Saint George', 'Addis Ababa', 'Ethiopia', '1935'),
('9', 'Defence', 'Addis Ababa', 'Ethiopia', NULL),
('10', 'Commercial Bank of Ethiopia', 'Addis Ababa', 'Ethiopia', '1982'),
('11', 'EEPCO', 'Addis Ababa', 'Ethiopia', NULL),
('12', 'Dire Dawa City', 'Dire Dawa', 'Ethiopia', NULL),
('13', 'Fasil Kenema', 'Gondar', 'Ethiopia', '1968'),
('14', 'Hadiya Hossana', 'Hosaena', 'Ethiopia', '2006'),
('15', 'Hawassa City', 'Hawassa', 'Ethiopia', '1977'),
('16', 'Mekelle???70???Enderta', 'Mekelle', 'Ethiopia', '2007'),
('17', 'Shire Endaselassie', 'Mekelle', 'Ethiopia', NULL),
('18', 'Welwalo Adigrat University', 'Adigrat', 'Ethiopia', '1948'),
('19', 'Negele Arsi FC', 'Arsi Negele', 'Ethiopia', NULL);

-- --------------------------------------------------------
-- Table structure for table `club_match_results`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `club_match_results`;
CREATE TABLE `club_match_results` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_date` date NOT NULL,
  `home_club_id` varchar(100) NOT NULL,
  `away_club_id` varchar(100) NOT NULL,
  `home_score` int(11) DEFAULT 0,
  `away_score` int(11) DEFAULT 0,
  `competition` varchar(100) DEFAULT 'League',
  `match_week` varchar(50) NOT NULL,
  `venue` varchar(100) DEFAULT NULL,
  `status` enum('Scheduled','Completed','Postponed') DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `club_match_results`
-- Records: 3

INSERT INTO `club_match_results` (`match_id`, `match_date`, `home_club_id`, `away_club_id`, `home_score`, `away_score`, `competition`, `match_week`, `venue`, `status`, `created_at`, `updated_at`) VALUES
('1', '2026-01-20', 'Arba Minch City', 'Welwalo Adigrat University', '3', '2', 'Ethiopian Premier League', '10', 'Addis Ababa Stadium', 'Completed', '2025-12-15 23:23:23', '2026-01-18 21:26:25'),
('2', '2026-01-18', 'Hawassa City', 'Jimma Aba Jifar', '4', '5', 'Ethiopian Premier League', '17', 'Addis Ababa Stadium', 'Completed', '2026-01-18 21:05:07', '2026-01-18 21:05:07'),
('3', '2026-01-16', 'Hawassa City', 'Wolaita Dicha', '0', '0', 'Ethiopian Premier League', '15', 'Addis Ababa Stadium', 'Completed', '2026-01-19 03:57:28', '2026-01-19 03:57:56');

-- --------------------------------------------------------
-- Table structure for table `club_training_schedule`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `club_training_schedule`;
CREATE TABLE `club_training_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_date` date NOT NULL,
  `training_time` time NOT NULL,
  `training_type` varchar(100) NOT NULL,
  `focus_area` varchar(150) DEFAULT NULL,
  `location` varchar(150) NOT NULL,
  `coach` varchar(100) DEFAULT NULL,
  `squad` varchar(50) DEFAULT 'First Team',
  `intensity` enum('Low','Medium','High') DEFAULT 'Medium',
  `duration_minutes` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `sckedule_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `club_training_schedule`
-- Records: 6

INSERT INTO `club_training_schedule` (`id`, `training_date`, `training_time`, `training_type`, `focus_area`, `location`, `coach`, `squad`, `intensity`, `duration_minutes`, `notes`, `status`, `sckedule_status`, `created_at`, `updated_at`) VALUES
('1', '2025-01-10', '16:00:00', 'Tactical', 'Defensive Shape', 'Sodo Training Ground', 'Head Coach', 'First Team', 'High', '90', NULL, 'Scheduled', '0', '2025-12-16 02:02:13', '2025-12-16 23:44:10'),
('3', '2026-12-25', '10:00:00', 'Technical Training', 'Passing', 'Main Training Ground', 'John Doe Coach', 'First Team', 'Medium', '90', NULL, 'Scheduled', '0', '2026-01-18 22:19:51', '2026-01-18 22:19:51'),
('4', '2026-06-09', '14:20:00', 'Technical Training', 'Passing', 'Main Training Ground', 'deeeeeeeeee', 'First Team', 'Medium', '60', NULL, 'Scheduled', '0', '2026-01-18 22:21:09', '2026-01-18 22:21:09'),
('5', '2026-06-15', '10:00:00', 'Technical Training', 'Passing', 'Main Training Ground', 'John Doe', 'First Team', 'Medium', '90', NULL, 'Scheduled', '0', '2026-01-18 22:23:46', '2026-01-18 22:23:46'),
('6', '2026-01-29', '14:29:00', 'Physical Training', 'Defending', 'Gym', 'deeeeeeeeee', 'Midfielders', 'Medium', '30', NULL, 'Scheduled', '0', '2026-01-18 22:25:07', '2026-01-18 22:25:07'),
('7', '2026-01-30', '10:08:00', 'Technical Training', 'Shooting', 'Main Training Ground', 'abera', 'First Team', 'Medium', '50', NULL, 'Scheduled', '0', '2026-01-19 04:03:01', '2026-01-19 04:03:01');

-- --------------------------------------------------------
-- Table structure for table `club_upcoming_matches`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `club_upcoming_matches`;
CREATE TABLE `club_upcoming_matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_date` date NOT NULL,
  `home_club` varchar(100) NOT NULL,
  `away_club` varchar(100) NOT NULL,
  `competition` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `match_week` int(10) unsigned NOT NULL,
  `status` enum('Scheduled','Postponed') NOT NULL DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `club_upcoming_matches`
-- Records: 5

INSERT INTO `club_upcoming_matches` (`id`, `match_date`, `home_club`, `away_club`, `competition`, `venue`, `match_week`, `status`, `created_at`, `updated_at`) VALUES
('5', '2025-12-18', 'Wolaita Dicha', 'Ethiopian Coffee', 'Ethiopian Cup', 'Addis Ababa Stadium', '8', 'Scheduled', '2025-12-16 00:33:27', '2025-12-16 00:33:27'),
('6', '2025-12-04', 'Saint George', 'Wolaita Dicha', 'CAF Champions League', 'Addis Ababa Stadium', '2', 'Scheduled', '2025-12-16 00:34:48', '2025-12-16 00:34:48'),
('8', '2025-12-19', 'Defence Force', 'Wolaita Dicha', 'Ethiopian Premier League', 'Addis Ababa Stadium', '12', 'Scheduled', '2025-12-17 00:16:41', '2025-12-17 00:16:41'),
('9', '2025-12-29', 'Shire Endaselassie', 'Jimma Aba Jifar', 'Ethiopian Premier League', 'Addis Ababa Stadium', '17', 'Scheduled', '2026-01-18 21:10:33', '2026-01-18 21:10:33'),
('11', '2026-01-20', 'Wolaita Dicha', 'Jimma Aba Jifar', 'Ethiopian Premier League', 'Addis Ababa Stadium', '17', 'Scheduled', '2026-01-19 03:59:28', '2026-01-19 04:00:02');

-- --------------------------------------------------------
-- Table structure for table `fake_chapa_transactions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `fake_chapa_transactions`;
CREATE TABLE `fake_chapa_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_ref` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'ETB',
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','success','failed','cancelled') DEFAULT 'pending',
  `checkout_url` varchar(500) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `meta_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `tx_ref` (`tx_ref`),
  KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `fake_chapa_transactions`
-- Records: 9

INSERT INTO `fake_chapa_transactions` (`id`, `tx_ref`, `amount`, `currency`, `email`, `first_name`, `last_name`, `phone_number`, `description`, `status`, `checkout_url`, `reference`, `meta_data`, `created_at`, `updated_at`) VALUES
('1', 'FAKE_WDFC_1768811047_7421', '500.00', 'ETB', 'test@example.com', 'Test', 'User', '0912345678', 'Test Standard Membership', 'pending', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811047_7421', 'CH_FAKE_1768811047_8422', '{\"membership_type\":\"standard\",\"fan_label\":\"supporter\",\"payment_method\":\"chapa\"}', '2026-01-19 00:24:07', '2026-01-19 00:24:07'),
('2', 'FAKE_WDFC_1768811520_9593', '1250.00', 'ETB', 'john.doe@example.com', 'John', 'Doe', '0912345678', 'Wolaita Dicha FC Premium Membership', 'pending', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811520_9593', 'CH_FAKE_1768811520_8456', '{\"membership_type\":\"premium\",\"fan_label\":\"supporter\",\"payment_method\":\"chapa\"}', '2026-01-19 00:32:00', '2026-01-19 00:32:00'),
('3', 'FAKE_WDFC_1768811576_5440', '500.00', 'ETB', 'tinsaeteklu037@gmail.com', 'tinsae', 'teklu', '919 315 685', 'Wolaita Dicha FC Standard Membership', 'success', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811576_5440', 'CH_FAKE_1768811576_3953', '{\"membership_type\":\"standard\",\"fan_label\":\"Super Fan\",\"payment_method\":\"chapa\"}', '2026-01-19 00:32:56', '2026-01-19 00:33:09'),
('4', 'FAKE_WDFC_1768812112_1138', '1250.00', 'ETB', 'testcomplete@example.com', 'Test', 'User Complete', '0987654321', 'Wolaita Dicha FC Premium Membership', 'success', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812112_1138', 'CH_FAKE_1768812112_5479', '{\"membership_type\":\"premium\",\"fan_label\":\"supporter\",\"payment_method\":\"chapa\"}', '2026-01-19 00:41:52', '2026-01-19 00:41:52'),
('5', 'FAKE_WDFC_TEST_1768812153', '1250.00', 'ETB', 'test@example.com', 'Test', 'User Success', '0912345678', 'Test Premium Membership', 'success', 'fake_chapa_checkout.php?tx_ref=FAKE_WDFC_TEST_1768812153', 'CH_TEST_1768812153', '{\"membership_type\":\"premium\",\"fan_label\":\"supporter\",\"payment_method\":\"chapa\"}', '2026-01-19 00:42:33', '2026-01-19 00:42:33'),
('6', 'FAKE_WDFC_1768812245_1859', '500.00', 'ETB', 'tinsaeteklu037@gmail.com', 'tinsae', 'teklu', '919 315 685', 'Wolaita Dicha FC Standard Membership', 'success', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812245_1859', 'CH_FAKE_1768812245_8430', '{\"membership_type\":\"standard\",\"fan_label\":\"Basic Fan\",\"payment_method\":\"chapa\"}', '2026-01-19 00:44:05', '2026-01-19 00:44:09'),
('7', 'FAKE_WDFC_FIX_1768812440', '500.00', 'ETB', 'testfix@example.com', 'Test', 'Fix User', '0912345678', 'Test Standard Membership', 'success', 'fake_chapa_checkout.php?tx_ref=FAKE_WDFC_FIX_1768812440', 'CH_FIX_1768812440', '{\"membership_type\":\"standard\",\"fan_label\":\"supporter\",\"payment_method\":\"chapa\"}', '2026-01-19 00:47:20', '2026-01-19 00:47:20'),
('8', 'FAKE_WDFC_1768812516_4143', '1250.00', 'ETB', 'completetest@example.com', 'Complete', 'Test User', '0987654321', 'Wolaita Dicha FC Premium Membership', 'success', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812516_4143', 'CH_FAKE_1768812516_9481', '{\"membership_type\":\"premium\",\"fan_label\":\"supporter\",\"payment_method\":\"chapa\"}', '2026-01-19 00:48:36', '2026-01-19 00:48:36'),
('9', 'FAKE_WDFC_1768823423_3372', '500.00', 'ETB', 'rediettesfaye09@gmail.com', 'rediet', 'tesfaye', '919 315 687', 'Wolaita Dicha FC Standard Membership', 'success', 'http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768823423_3372', 'CH_FAKE_1768823423_7332', '{\"membership_type\":\"standard\",\"fan_label\":\"Basic Fan\",\"payment_method\":\"chapa\"}', '2026-01-19 03:50:23', '2026-01-19 03:50:30');

-- --------------------------------------------------------
-- Table structure for table `fake_payment_responses`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `fake_payment_responses`;
CREATE TABLE `fake_payment_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_ref` varchar(100) NOT NULL,
  `gateway` enum('chapa','telebirr') NOT NULL,
  `response_type` enum('initialize','verify','callback') NOT NULL,
  `response_data` text NOT NULL,
  `http_code` int(11) DEFAULT 200,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tx_ref` (`tx_ref`),
  KEY `gateway` (`gateway`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `fake_payment_responses`
-- Records: 7

INSERT INTO `fake_payment_responses` (`id`, `tx_ref`, `gateway`, `response_type`, `response_data`, `http_code`, `created_at`) VALUES
('1', 'FAKE_WDFC_1768811047_7421', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811047_7421\"}}', '200', '2026-01-19 00:24:07'),
('2', 'FAKE_WDFC_1768811520_9593', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811520_9593\"}}', '200', '2026-01-19 00:32:00'),
('3', 'FAKE_WDFC_1768811576_5440', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811576_5440\"}}', '200', '2026-01-19 00:32:56'),
('4', 'FAKE_WDFC_1768812112_1138', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812112_1138\"}}', '200', '2026-01-19 00:41:52'),
('5', 'FAKE_WDFC_1768812245_1859', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812245_1859\"}}', '200', '2026-01-19 00:44:05'),
('6', 'FAKE_WDFC_1768812516_4143', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812516_4143\"}}', '200', '2026-01-19 00:48:36'),
('7', 'FAKE_WDFC_1768823423_3372', 'chapa', 'initialize', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768823423_3372\"}}', '200', '2026-01-19 03:50:23');

-- --------------------------------------------------------
-- Table structure for table `fake_telebirr_transactions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `fake_telebirr_transactions`;
CREATE TABLE `fake_telebirr_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_ref` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'ETB',
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','success','failed','cancelled') DEFAULT 'pending',
  `checkout_url` varchar(500) NOT NULL,
  `prepay_id` varchar(100) DEFAULT NULL,
  `trade_no` varchar(100) DEFAULT NULL,
  `meta_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `tx_ref` (`tx_ref`),
  KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- No data for table `fake_telebirr_transactions`

-- --------------------------------------------------------
-- Table structure for table `fans`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `fans`;
CREATE TABLE `fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `favorite_team` int(11) DEFAULT NULL,
  `membership_type` varchar(50) NOT NULL,
  `fan_label` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` enum('free','paid','pending','failed') DEFAULT 'free',
  `payment_date` timestamp NULL DEFAULT NULL,
  `tx_ref` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `fans`
-- Records: 2

INSERT INTO `fans` (`id`, `full_name`, `username`, `email`, `phone`, `password`, `dob`, `gender`, `address`, `profile_image`, `favorite_team`, `membership_type`, `fan_label`, `is_verified`, `status`, `created_at`, `updated_at`, `payment_status`, `payment_date`, `tx_ref`) VALUES
('13', 'tinsae teklu', NULL, 'tinsaeteklu037@gmail.com', '919 315 685', 'afe56fc83bd8ca6fb6572250a143b5907b9943c5', NULL, NULL, NULL, NULL, NULL, 'digital', 'Basic Fan', '0', '', '2026-01-19 03:48:46', '2026-01-19 03:48:46', 'free', NULL, NULL),
('14', 'rediet tesfaye', NULL, 'rediettesfaye09@gmail.com', '919 315 687', '2a95a5371ea626ed81ac3327e84b4c69dee29cba', NULL, NULL, NULL, NULL, NULL, 'standard', 'Basic Fan', '0', 'active', '2026-01-19 03:50:30', '2026-01-19 03:50:30', 'paid', '2026-01-19 03:50:30', 'FAKE_WDFC_1768823423_3372');

-- --------------------------------------------------------
-- Table structure for table `payment_transactions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `payment_transactions`;
CREATE TABLE `payment_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_ref` varchar(100) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'ETB',
  `payment_method` varchar(50) DEFAULT 'chapa',
  `payment_status` enum('pending','success','failed','cancelled') DEFAULT 'pending',
  `gateway_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `payment_transactions`
-- Records: 3

INSERT INTO `payment_transactions` (`id`, `tx_ref`, `user_email`, `amount`, `currency`, `payment_method`, `payment_status`, `gateway_response`, `created_at`) VALUES
('1', 'FAKE_WDFC_1768811576_5440', 'tinsaeteklu037@gmail.com', '500.00', 'ETB', 'chapa', 'pending', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768811576_5440\"}}', '2026-01-19 00:32:56'),
('2', 'FAKE_WDFC_1768812245_1859', 'tinsaeteklu037@gmail.com', '500.00', 'ETB', 'chapa', 'pending', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768812245_1859\"}}', '2026-01-19 00:44:05'),
('3', 'FAKE_WDFC_1768823423_3372', 'rediettesfaye09@gmail.com', '500.00', 'ETB', 'chapa', 'pending', '{\"status\":\"success\",\"message\":\"Hosted Link\",\"data\":{\"checkout_url\":\"http:\\/\\/localhost\\/Wolaita-Dicha-Fc\\/fake_chapa_checkout.php?tx_ref=FAKE_WDFC_1768823423_3372\"}}', '2026-01-19 03:50:23');

-- --------------------------------------------------------
-- Table structure for table `pending_registrations`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `pending_registrations`;
CREATE TABLE `pending_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_ref` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `membership_type` varchar(50) DEFAULT NULL,
  `fan_label` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(20) DEFAULT 'chapa',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tx_ref` (`tx_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `pending_registrations`
-- Records: 15

INSERT INTO `pending_registrations` (`id`, `tx_ref`, `full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `amount`, `status`, `created_at`, `payment_method`) VALUES
('4', 'WDFC_1768623369_5771', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-16 20:16:09', 'chapa'),
('5', 'WDFC_1768623376_6560', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-16 20:16:16', 'chapa'),
('6', 'WDFC_1768756729_4516', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '976 546 666', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-18 09:18:49', 'chapa'),
('7', 'WDFC_1768809499_5689', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', 'a6ddda1e0f116b06f1b2211ca3167173c25df15b', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-18 23:58:19', 'chapa'),
('8', 'WDFC_1768809506_3109', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', 'a6ddda1e0f116b06f1b2211ca3167173c25df15b', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-18 23:58:26', 'chapa'),
('9', 'WDFC_1768809555_7115', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', '258650714896696f383f0939e7a858d1d0ba8133', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-18 23:59:15', 'chapa'),
('10', 'WDFC_1768809558_1274', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', '258650714896696f383f0939e7a858d1d0ba8133', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-18 23:59:18', 'chapa'),
('11', 'FAKE_WDFC_1768811520_9593', 'John Doe', 'john.doe@example.com', '0912345678', '$2y$10$2h9VehoVEc.EDvyTThQhLumXVvZoBT92.UOv4mxguzRSeEGAaqMJq', 'premium', 'supporter', '1250.00', 'pending', '2026-01-19 00:32:00', 'chapa'),
('12', 'FAKE_WDFC_1768811576_5440', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', '258650714896696f383f0939e7a858d1d0ba8133', 'standard', 'Super Fan', '500.00', 'pending', '2026-01-19 00:32:56', 'chapa'),
('13', 'FAKE_WDFC_1768812112_1138', 'Test User Complete', 'testcomplete@example.com', '0987654321', '$2y$10$73BUpizFy4bykNRdKsaqAe.HlwSUpVFj1xq.KVPShsjY075aERsXK', 'premium', 'supporter', '1250.00', 'pending', '2026-01-19 00:41:52', 'chapa'),
('14', 'FAKE_WDFC_TEST_1768812153', 'Test User Success', 'test@example.com', '0912345678', '$2y$10$xfeUEXRqYqncAA3B3lBGSu5MDFtPySh8qm1UT2RZVtEPKhVWO8E/.', 'premium', 'supporter', '1250.00', 'pending', '2026-01-19 00:42:33', 'chapa'),
('15', 'FAKE_WDFC_1768812245_1859', 'tinsae teklu', 'tinsaeteklu037@gmail.com', '919 315 685', '4cdb70294f4bc9b1b872545f5a25c01dfab6890c', 'standard', 'Basic Fan', '500.00', 'completed', '2026-01-19 00:44:05', 'chapa'),
('16', 'FAKE_WDFC_FIX_1768812440', 'Test Fix User', 'testfix@example.com', '0912345678', '$2y$10$uvpFh2VlEjUvCFs7aa7PYeYm3DpjmnlQoEtMhWxd22DjiZ7gWKOOy', 'standard', 'supporter', '500.00', 'pending', '2026-01-19 00:47:21', 'chapa'),
('17', 'FAKE_WDFC_1768812516_4143', 'Complete Test User', 'completetest@example.com', '0987654321', '$2y$10$dxnoTSAOyBifg1ymDEMW9e0k.0DDffLMcs4CzF5jtUHrK/Tx7xt5y', 'premium', 'supporter', '1250.00', 'pending', '2026-01-19 00:48:36', 'chapa'),
('18', 'FAKE_WDFC_1768823423_3372', 'rediet tesfaye', 'rediettesfaye09@gmail.com', '919 315 687', '2a95a5371ea626ed81ac3327e84b4c69dee29cba', 'standard', 'Basic Fan', '500.00', 'completed', '2026-01-19 03:50:23', 'chapa');

-- --------------------------------------------------------
-- Table structure for table `player_injuries`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `player_injuries`;
CREATE TABLE `player_injuries` (
  `injury_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_effid` varchar(100) NOT NULL,
  `player_name` varchar(100) NOT NULL,
  `injury_type` varchar(100) NOT NULL,
  `injury_description` text DEFAULT NULL,
  `injury_date` date NOT NULL,
  `expected_return` date DEFAULT NULL,
  `severity` enum('Minor','Moderate','Severe') NOT NULL,
  `treatment_status` enum('Ongoing','Recovered','Rehabilitation') DEFAULT 'Ongoing',
  `doctor_name` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`injury_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `player_injuries`
-- Records: 5

INSERT INTO `player_injuries` (`injury_id`, `player_effid`, `player_name`, `injury_type`, `injury_description`, `injury_date`, `expected_return`, `severity`, `treatment_status`, `doctor_name`, `remarks`, `created_at`) VALUES
('1', 'EFF-18 49', 'tinsae ', 'Knee Injury', 'Scheduled preventive treatment for knee condition', '2026-01-19', '2027-01-15', 'Moderate', 'Ongoing', NULL, '', '2025-12-16 05:17:07'),
('2', 'EFF-18 49', 'tinsae ', 'Hamstring', 'Player sustained hamstring injury during training session', '2026-01-15', '2026-02-15', 'Minor', 'Ongoing', NULL, 'Initial assessment completed', '2026-01-18 21:36:06'),
('3', 'EFF-18 49', 'tinsae ', 'Hamstring', 'Scheduled medical examination for potential injury risk', '2026-12-31', '2027-01-15', 'Minor', 'Ongoing', NULL, '', '2026-01-18 21:41:39'),
('4', 'EFF-18 49', 'tinsae ', 'Hamstring', 'ffvvvvvvfgggggggggg', '2026-01-13', '2026-02-07', 'Minor', 'Ongoing', NULL, 'gdssssssssssssssskkkkkkkkkk', '2026-01-18 21:43:14'),
('5', 'EFF-18 4', 'carlos damtew', 'Knee Injury', 'iti s hard knee injury', '2026-01-28', '2026-10-21', 'Minor', 'Ongoing', NULL, 'it is hard knee injury', '2026-01-19 04:05:57');

-- --------------------------------------------------------
-- Table structure for table `playerregistration`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `playerregistration`;
CREATE TABLE `playerregistration` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `effid` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `current_club` varchar(50) NOT NULL DEFAULT 'Wolaita Dicha FC',
  `former_club` varchar(50) NOT NULL,
  `position` enum('Goalkeeper','Defender','Midfielder','Forward') NOT NULL,
  `height_cm` int(11) DEFAULT NULL,
  `weight_kg` int(11) DEFAULT NULL,
  `preferred_foot` enum('Left','Right','Both') DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `skill_level` enum('Beginner','Intermediate','Advanced','Professional') DEFAULT 'Beginner',
  `avatar` text NOT NULL,
  `contract_start` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `range_format` varchar(50) NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `email` (`email`),
  KEY `club_id` (`club_id`),
  CONSTRAINT `playerregistration_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `playerregistration`
-- Records: 2

INSERT INTO `playerregistration` (`player_id`, `fullname`, `date_of_birth`, `gender`, `nationality`, `email`, `effid`, `phone`, `club_id`, `current_club`, `former_club`, `position`, `height_cm`, `weight_kg`, `preferred_foot`, `experience_years`, `skill_level`, `avatar`, `contract_start`, `contract_end`, `range_format`, `registration_date`, `status`) VALUES
('8', 'carlos damtew', '2002-09-01', 'Male', 'Ethiopian', 'carlosdamtew@gmail.com', 'EFF-18 4', '0987654321', NULL, 'Wolaita Dicha FC', '', 'Forward', '2', '80', 'Right', '5', 'Intermediate', '', '2026-09-01', '2028-08-30', '', '2026-01-19 02:48:04', '1'),
('9', 'Mesay nikola', '2000-02-23', 'Male', 'Ethiopian', 'mesaynikola1@gmail.com', 'EFF-18 49', '0998245675', NULL, 'Wolaita Dicha FC', 'Choose', 'Midfielder', '2', '75', 'Right', '5', 'Advanced', '', '2026-01-19', '2029-05-17', '', '2026-01-19 03:54:43', '1');

-- --------------------------------------------------------
-- Table structure for table `players`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `full_name` varchar(100) GENERATED ALWAYS AS (concat(`first_name`,' ',`last_name`)) STORED,
  `dob` date NOT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `nationality` varchar(50) DEFAULT NULL,
  `position` enum('Goalkeeper','Defender','Midfielder','Forward') NOT NULL,
  `jersey_number` int(2) DEFAULT NULL,
  `height_cm` int(3) DEFAULT NULL,
  `weight_kg` int(3) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `status` enum('active','injured','suspended','retired') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- No data for table `players`

-- --------------------------------------------------------
-- Table structure for table `tbl_user_attempts`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `tbl_user_attempts`;
CREATE TABLE `tbl_user_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `user_agent` varchar(20) NOT NULL,
  `os_version` varchar(50) NOT NULL,
  `browser_name` varchar(20) NOT NULL,
  `attempt_type` enum('login','password_reset','otp','other') DEFAULT 'login',
  `status` enum('success','failed') DEFAULT 'failed',
  `message` varchar(255) DEFAULT NULL,
  `attempt_time` varchar(50) NOT NULL DEFAULT current_timestamp(),
  `notified_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tbl_user_attempts`
-- Records: 50

INSERT INTO `tbl_user_attempts` (`id`, `email`, `ip_address`, `device_name`, `location`, `user_agent`, `os_version`, `browser_name`, `attempt_type`, `status`, `message`, `attempt_time`, `notified_admin`) VALUES
('1', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('65', 'rediettesfaye08@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('66', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('67', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('68', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('69', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('70', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('71', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('72', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('73', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('74', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('75', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('76', 'reediet7@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('77', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('78', 'tinsaeteklu037@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('79', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('80', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('81', 'reediet7@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('82', 'klukaku4309@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('83', 'kluka4309@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('84', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('85', 'klukaku4309@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('86', 'kluka4309@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('87', 'tinsaeteklu037@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('88', 'melekotmesfin00@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('89', 'melekotmesfin00@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('90', 'melekotmesfin55@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('91', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('92', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('93', 'tinsaeteklu037@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('94', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('95', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('96', 'melekot@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('97', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('98', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('99', 'melat@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('100', 'rediettesfaye09@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('101', 'Mitkuhaile@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('102', 'Mitkuhaile@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('103', 'Meseretufaysa@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('104', 'carlosdamtew@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('105', 'Carlosdamtew@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'failed', 'Incorrect password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('106', 'Carlosdamtew@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('107', 'Mitkuhaile@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('108', 'Mitkuhaile@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('109', 'Meseretufaysa@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('110', 'aberamena@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('111', 'BarkaBakalo@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('112', 'GizachewGetachew@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0'),
('113', 'Carlosdamtew@gmail.com', '127.0.0.1', 'Windows PC', 'Unknown', 'Mozilla/5.0 (Windows', 'Windows 10', 'Chrome', 'login', 'success', 'Correct Password', 'Thursday, 01 January 1970 at 01:00 AM', '0');

-- --------------------------------------------------------
-- Table structure for table `user_account`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `user_account`;
CREATE TABLE `user_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `passwordhash` varchar(50) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `account_status` varchar(100) NOT NULL,
  `congrats_status` int(11) NOT NULL DEFAULT 0,
  `account_level` varchar(50) NOT NULL,
  `last_login_time` varchar(50) NOT NULL,
  `last_login_date` varchar(50) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `user_account`
-- Records: 7

INSERT INTO `user_account` (`account_id`, `fullname`, `full_name`, `username`, `email`, `phone_number`, `password`, `passwordhash`, `otp`, `role`, `created_at`, `updated_at`, `account_status`, `congrats_status`, `account_level`, `last_login_time`, `last_login_date`) VALUES
('15', 'carlos damtew', '', '', 'carlosdamtew@gmail.com', '0987654321', 'b2ba3c74657140499eb5a130b42a1648a0069467', '', '839829', 'Player', '2026-01-19', '', '1', '0', '', 'Mon, 01:07: 14pm', 'Jan 19 2026 Mon, 01:07: 14pm'),
('16', 'Barka Bakalo ', '', '', 'BarkaBakalo@gmail.com', '0987654323', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '368745', 'Coach', '2026-01-19', '', '1', '0', '', 'Mon, 01:01: 27pm', 'Jan 19 2026 Mon, 01:01: 27pm'),
('17', 'Gizachew Getachew ', '', '', 'GizachewGetachew@gmail.com', '0987654325', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '208452', 'Medical Staff', '2026-01-19', '', '1', '0', '', 'Mon, 01:03: 49pm', 'Jan 19 2026 Mon, 01:03: 49pm'),
('18', 'Mitku haile ', '', '', 'Mitkuhaile@gmail.com', '0987654355', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '872666', 'System administrator', '2026-01-19', '', '1', '1', '', 'Mon, 12:46: 03pm', 'Jan 19 2026 Mon, 12:46: 03pm'),
('19', 'Meseret Ufaysa ', '', '', 'Meseretufaysa@gmail.com', '0987623377', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '659656', 'Secretary', '2026-01-19', '', '1', '1', '', 'Mon, 12:51: 36pm', 'Jan 19 2026 Mon, 12:51: 36pm'),
('20', 'abera mena', '', '', 'aberamena@gmail.com', '0922223232', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '998514', 'Technical Director', '2026-01-19', '', '1', '0', '', 'Mon, 01:00: 35pm', 'Jan 19 2026 Mon, 01:00: 35pm'),
('21', 'Mesay nikola', '', '', 'mesaynikola@gmail.com', '0998245675', 'b2ba3c74657140499eb5a130b42a1648a0069467', '', '984912', 'Player', '2026-01-19', '', '0', '0', '', '', '');

-- --------------------------------------------------------
-- Table structure for table `user_details`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details` (
  `user_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `date_of_birth` varchar(50) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `profile_picture_url` varchar(255) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` text NOT NULL,
  `bio` varchar(50) NOT NULL,
  `url` varchar(200) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`user_detail_id`),
  KEY `user_details_ibfk_1` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `user_details`
-- Records: 17

INSERT INTO `user_details` (`user_detail_id`, `account_id`, `fullname`, `age`, `gender`, `date_of_birth`, `nationality`, `profile_picture_url`, `city`, `state`, `bio`, `url`, `address`) VALUES
('1', '1', 'Rediet Tesfaye', '23', 'Female', '1994-11-17', 'Ethiopia', '../assets/img/avatar/1.jpg', 'Sodo', 'Wolaita', 'Software engineering student and football manageme', 'https://wolaitadichafc.com', 'Sodo City, Wolaita Zone, Southern Ethiopia'),
('6', '6', 'melat', '', '', '', 'ETH', '', '', '', '', '', ''),
('7', '7', 'tinsae teklu', '', '', '', 'ETH', '', '', '', '', '', ''),
('8', '8', 'melekot', '', '', '', 'ETH', '', '', '', '', '', ''),
('9', '9', 'rediet', '', '', '', 'ETH', '', '', '', '', '', ''),
('10', '10', 'tinsae tekluq', '', 'Male', '2008-12-30', 'Ethiopian', '../files/playerprofile/avatar_696cda872b0f3.jpg', '', '', '', '', ''),
('11', '11', 'tinsae teklu', '', '', '', 'ETH', '', '', '', '', '', ''),
('12', '12', 'tinsae teklu', '', '', '', 'ETH', '', '', '', '', '', ''),
('13', '13', 'tinsae teklu', '', '', '', 'ETH', '', '', '', '', '', ''),
('14', '14', 'tinsae ', '', 'Male', '2006-10-24', 'Ethiopian', '', '', '', '', '', ''),
('15', '15', 'carlos damtew', '', 'Male', '2002-09-01', 'Ethiopian', '', '', '', '', '', ''),
('16', '16', 'Barka Bakalo', '', '', '', 'ETH', '', '', '', '', '', ''),
('17', '17', 'Gizachew Getachew', '', '', '', 'ETH', '', '', '', '', '', ''),
('18', '18', 'Mitku haile', '', '', '', 'ETH', '../assets/img/avatar/avatar_696e0e36c7094.jpg', '', '', '', '', ''),
('19', '19', 'Meseret Ufaysa', '', '', '', 'ETH', '', '', '', '', '', ''),
('20', '20', 'abera mena', '', '', '', 'ETH', '', '', '', '', '', ''),
('21', '21', 'Mesay nikola', '', 'Male', '2000-02-23', 'Ethiopian', '', '', '', '', '', '');

COMMIT;

-- Export completed on 2026-01-19 13:41:08
