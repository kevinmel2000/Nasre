-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2020 at 07:24 AM
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
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `user_id`, `title_id`, `language_id`, `first_name`, `last_name`, `company_name`, `website`, `email`, `email_opt_out`, `fax`, `fax_opt_out`, `phone`, `whatsapp`, `phone_opt_out`, `prospect_status`, `owner_id`, `last_owner_id`, `industry_id`, `last_transfer_date`, `lead_source_id`, `lead_status_id`, `lead_temprature`, `score`, `read_status`, `is_dead`, `is_poor_fit`, `created_at`, `updated_at`) VALUES
(1, NULL, '6', '3', 'Ashwani', 'Garg', 'Mandala', 'Mandala.com', 'akgarg007@gmail.com', 'no', NULL, 'no', '+919660025446', '919414508846', 'no', 'Prospect', '3', NULL, '4', NULL, '23', '4', 'Hot', '10', 'no', 'no', 'no', '2020-07-14 07:14:55', '2020-07-14 07:14:55');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
