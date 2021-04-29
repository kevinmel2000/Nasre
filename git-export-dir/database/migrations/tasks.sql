-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2020 at 05:09 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shinoycrm`
--

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `start_date`, `owner_id`, `type`, `status`, `description`, `relation`, `customer_id`, `contact_id`, `lead_id`, `priority`, `send_notifications`, `is_all_day`, `start_time`, `end_time`, `task_time`, `billable`, `estimated_time`, `repeat_task`, `repeat_every`, `repeat_day_month`, `end_date`, `created_at`, `updated_at`) VALUES
(1, '2020-07-14', 3, 'Email', 'Waiting', 'new task for lead 1', 'Customer', 2, NULL, NULL, 'High', 'yes', 'no', NULL, NULL, '10:00', 'yes', NULL, 'yes', 'day', NULL, '2020-07-31', '2020-07-14 07:17:34', '2020-07-22 04:43:51');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
