-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2020 at 04:33 AM
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
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `lead_id`, `address_line_1`, `address_line_2`, `city_id`, `state_id`, `country_id`, `zip`, `phone_1`, `phone_2`, `email_1`, `email_2`, `is_billing_address`, `is_shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '59457 Nolan Canyon Suite 252Hermanstad, RI 23912-3867', 'Apt. 856', NULL, '545', '33', NULL, NULL, NULL, NULL, NULL, 'no', 'no', '2020-07-22 04:26:26', '2020-07-22 04:31:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
