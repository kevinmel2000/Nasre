-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2020 at 03:01 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(255) NOT NULL,
  `name` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'Mandarin'),
(2, 'Spanish'),
(3, 'English'),
(4, 'Hindi'),
(5, 'Arabic'),
(6, 'Portuguese'),
(7, 'Bengali'),
(8, 'Russian'),
(9, 'Japanese'),
(10, 'Punjabi'),
(11, 'German'),
(12, 'Javanese'),
(13, 'Wu'),
(14, 'Malay'),
(15, 'Telugu'),
(16, 'Vietnamese'),
(17, 'Korean'),
(18, 'French'),
(19, 'Marathi'),
(20, 'Tamil'),
(21, 'Urdu'),
(22, 'Turkish'),
(23, 'Italian'),
(24, 'Yue'),
(25, 'Thai'),
(26, 'Gujarati'),
(27, 'Jin'),
(28, 'Southern Min'),
(29, 'Persian'),
(30, 'Polish'),
(31, 'Pashto'),
(32, 'Kannada'),
(33, 'Xiang'),
(34, 'Malayalam'),
(35, 'Sundanese'),
(36, 'Hausa'),
(37, 'Odia'),
(38, 'Burmese'),
(39, 'Hakka'),
(40, 'Ukrainian'),
(41, 'Bhojpuri'),
(42, 'Tagalog'),
(43, 'Yoruba'),
(44, 'Maithili'),
(45, 'Uzbek'),
(46, 'Sindhi'),
(47, 'Amharic'),
(48, 'Fula'),
(49, 'Romanian'),
(50, 'Oromo'),
(51, 'Igbo'),
(52, 'Azerbaijani'),
(53, 'Awadhi'),
(54, 'Gan'),
(55, 'Cebuano'),
(56, 'Dutch'),
(57, 'Kurdish'),
(58, 'Serbo-Croatian'),
(59, 'Malagasy'),
(60, 'Saraiki'),
(61, 'Nepali'),
(62, 'Sinhala'),
(63, 'Chittagonian'),
(64, 'Zhuang'),
(65, 'Khmer'),
(66, 'Turkmen'),
(67, 'Assamese'),
(68, 'Madurese'),
(69, 'Somali'),
(70, 'Marwari'),
(71, 'Magahi'),
(72, 'Haryanvi'),
(73, 'Hungarian'),
(74, 'Chhattisgarhi'),
(75, 'Greek'),
(76, 'Chewa'),
(77, 'Deccan'),
(78, 'Akan'),
(79, 'Kazakh'),
(80, 'Sylheti'),
(81, 'Zulu'),
(82, 'Czech'),
(83, 'Kinyarwanda'),
(84, 'Dhundhari'),
(85, 'Haitian Creole'),
(86, 'Eastern Min'),
(87, 'Ilocano'),
(88, 'Quechua'),
(89, 'Kirundi'),
(90, 'Swedish'),
(91, 'Hmong'),
(92, 'Shona'),
(93, 'Uyghur'),
(94, 'Hiligaynon/Ilonggo'),
(95, 'Mossi'),
(96, 'Xhosa'),
(97, 'Belarusian'),
(98, 'Balochi'),
(99, 'Konkani');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
