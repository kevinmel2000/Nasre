-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2020 at 08:40 AM
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
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `role_id`, `module_name`, `create`, `read`, `update`, `delete`, `created_at`, `updated_at`) VALUES
(1, 2, 'contact_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(2, 3, 'contact_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:39:39'),
(3, 2, 'role_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(4, 3, 'role_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(5, 2, 'user_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(6, 3, 'user_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(7, 2, 'lead_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(8, 3, 'lead_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:39:15'),
(9, 2, 'finance_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(10, 3, 'finance_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(11, 2, 'product_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(12, 3, 'product_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(13, 2, 'proposal_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(14, 3, 'proposal_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:39:25'),
(15, 2, 'invoice_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(16, 3, 'invoice_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:39:30'),
(17, 2, 'project_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(18, 3, 'project_module', 'off', 'off', 'off', 'off', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(19, 1, 'contact_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(20, 1, 'role_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(21, 1, 'user_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(22, 1, 'lead_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(23, 1, 'finance_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(24, 1, 'product_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(25, 1, 'proposal_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(26, 1, 'invoice_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51'),
(27, 1, 'project_module', 'on', 'on', 'on', 'on', '2020-07-06 08:32:51', '2020-07-06 08:32:51');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
