-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2020 at 05:10 AM
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
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `name`, `rate`, `created_at`, `updated_at`) VALUES
(1, 'CGST', 12.50, '2020-06-29 05:08:54', '2020-06-29 05:08:54'),
(2, 'SGST', 12.50, '2020-06-29 05:09:02', '2020-06-29 05:09:02'),
(3, 'GST', 25.00, '2020-06-29 05:09:09', '2020-06-29 05:09:09'),
(4, 'Tax Rate 5', 5.00, '2020-06-29 05:09:21', '2020-06-29 05:09:41'),
(5, 'Tax Rate 10', 10.00, '2020-06-29 05:09:35', '2020-06-29 05:09:35'),
(6, 'Tax Rate 15', 15.00, '2020-06-29 05:09:51', '2020-06-29 05:09:51');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
