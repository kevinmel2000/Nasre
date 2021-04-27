-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2019 at 12:37 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_city_location`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Albania', 'AL'),
(3, 'Algeria', 'DZ'),
(4, 'American Samoa', 'AS'),
(5, 'Andorra', 'AD'),
(6, 'Angola', 'AO'),
(7, 'Anguilla', 'AI'),
(8, 'Antarctica', 'AQ'),
(9, 'Antigua And Barbuda', 'AG'),
(10, 'Argentina', 'AR'),
(11, 'Armenia', 'AM'),
(12, 'Aruba', 'AW'),
(13, 'Australia', 'AU'),
(14, 'Austria', 'AT'),
(15, 'Azerbaijan', 'AZ'),
(16, 'Bahamas The', 'BS'),
(17, 'Bahrain', 'BH'),
(18, 'Bangladesh', 'BD'),
(19, 'Barbados', 'BB'),
(20, 'Belarus', 'BY'),
(21, 'Belgium', 'BE'),
(22, 'Belize', 'BZ'),
(23, 'Benin', 'BJ'),
(24, 'Bermuda', 'BM'),
(25, 'Bhutan', 'BT'),
(26, 'Bolivia', 'BO'),
(27, 'Bosnia and Herzegovina', 'BA'),
(28, 'Botswana', 'BW'),
(29, 'Bouvet Island', 'BV'),
(30, 'Brazil', 'BR'),
(31, 'British Indian Ocean Territory', 'IO'),
(32, 'Brunei', 'BN'),
(33, 'Bulgaria', 'BG'),
(34, 'Burkina Faso', 'BF'),
(35, 'Burundi', 'BI'),
(36, 'Cambodia', 'KH'),
(37, 'Cameroon', 'CM'),
(38, 'Canada', 'CA'),
(39, 'Cape Verde', 'CV'),
(40, 'Cayman Islands', 'KY'),
(41, 'Central African Republic', 'CF'),
(42, 'Chad', 'TD'),
(43, 'Chile', 'CL'),
(44, 'China', 'CN'),
(45, 'Christmas Island', 'CX'),
(46, 'Cocos (Keeling) Islands', 'CC'),
(47, 'Colombia', 'CO'),
(48, 'Comoros', 'KM'),
(49, 'Congo', 'CG'),
(50, 'Congo The Democratic Republic Of The', 'CD'),
(51, 'Cook Islands', 'CK'),
(52, 'Costa Rica', 'CR'),
(53, 'Cote D\'Ivoire (Ivory Coast)', 'CI'),
(54, 'Croatia (Hrvatska)', 'HR'),
(55, 'Cuba', 'CU'),
(56, 'Cyprus', 'CY'),
(57, 'Czech Republic', 'CZ'),
(58, 'Denmark', 'DK'),
(59, 'Djibouti', 'DJ'),
(60, 'Dominica', 'DM'),
(61, 'Dominican Republic', 'DO'),
(62, 'East Timor', 'TP'),
(63, 'Ecuador', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'External Territories of Australia', 'XA'),
(71, 'Falkland Islands', 'FK'),
(72, 'Faroe Islands', 'FO'),
(73, 'Fiji Islands', 'FJ'),
(74, 'Finland', 'FI'),
(75, 'France', 'FR'),
(76, 'French Guiana', 'GF'),
(77, 'French Polynesia', 'PF'),
(78, 'French Southern Territories', 'TF'),
(79, 'Gabon', 'GA'),
(80, 'Gambia The', 'GM'),
(81, 'Georgia', 'GE'),
(82, 'Germany', 'DE'),
(83, 'Ghana', 'GH'),
(84, 'Gibraltar', 'GI'),
(85, 'Greece', 'GR'),
(86, 'Greenland', 'GL'),
(87, 'Grenada', 'GD'),
(88, 'Guadeloupe', 'GP'),
(89, 'Guam', 'GU'),
(90, 'Guatemala', 'GT'),
(91, 'Guernsey and Alderney', 'XU'),
(92, 'Guinea', 'GN'),
(93, 'Guinea-Bissau', 'GW'),
(94, 'Guyana', 'GY'),
(95, 'Haiti', 'HT'),
(96, 'Heard and McDonald Islands', 'HM'),
(97, 'Honduras', 'HN'),
(98, 'Hong Kong S.A.R.', 'HK'),
(99, 'Hungary', 'HU'),
(100, 'Iceland', 'IS'),
(101, 'India', 'IN'),
(102, 'Indonesia', 'ID'),
(103, 'Iran', 'IR'),
(104, 'Iraq', 'IQ'),
(105, 'Ireland', 'IE'),
(106, 'Israel', 'IL'),
(107, 'Italy', 'IT'),
(108, 'Jamaica', 'JM'),
(109, 'Japan', 'JP'),
(110, 'Jersey', 'XJ'),
(111, 'Jordan', 'JO'),
(112, 'Kazakhstan', 'KZ'),
(113, 'Kenya', 'KE'),
(114, 'Kiribati', 'KI'),
(115, 'Korea North', 'KP'),
(116, 'Korea South', 'KR'),
(117, 'Kuwait', 'KW'),
(118, 'Kyrgyzstan', 'KG'),
(119, 'Laos', 'LA'),
(120, 'Latvia', 'LV'),
(121, 'Lebanon', 'LB'),
(122, 'Lesotho', 'LS'),
(123, 'Liberia', 'LR'),
(124, 'Libya', 'LY'),
(125, 'Liechtenstein', 'LI'),
(126, 'Lithuania', 'LT'),
(127, 'Luxembourg', 'LU'),
(128, 'Macau S.A.R.', 'MO'),
(129, 'Macedonia', 'MK'),
(130, 'Madagascar', 'MG'),
(131, 'Malawi', 'MW'),
(132, 'Malaysia', 'MY'),
(133, 'Maldives', 'MV'),
(134, 'Mali', 'ML'),
(135, 'Malta', 'MT'),
(136, 'Man (Isle of)', 'XM'),
(137, 'Marshall Islands', 'MH'),
(138, 'Martinique', 'MQ'),
(139, 'Mauritania', 'MR'),
(140, 'Mauritius', 'MU'),
(141, 'Mayotte', 'YT'),
(142, 'Mexico', 'MX'),
(143, 'Micronesia', 'FM'),
(144, 'Moldova', 'MD'),
(145, 'Monaco', 'MC'),
(146, 'Mongolia', 'MN'),
(147, 'Montserrat', 'MS'),
(148, 'Morocco', 'MA'),
(149, 'Mozambique', 'MZ'),
(150, 'Myanmar', 'MM'),
(151, 'Namibia', 'NA'),
(152, 'Nauru', 'NR'),
(153, 'Nepal', 'NP'),
(154, 'Netherlands Antilles', 'AN'),
(155, 'Netherlands The', 'NL'),
(156, 'New Caledonia', 'NC'),
(157, 'New Zealand', 'NZ'),
(158, 'Nicaragua', 'NI'),
(159, 'Niger', 'NE'),
(160, 'Nigeria', 'NG'),
(161, 'Niue', 'NU'),
(162, 'Norfolk Island', 'NF'),
(163, 'Northern Mariana Islands', 'MP'),
(164, 'Norway', 'NO'),
(165, 'Oman', 'OM'),
(166, 'Pakistan', 'PK'),
(167, 'Palau', 'PW'),
(168, 'Palestinian Territory Occupied', 'PS'),
(169, 'Panama', 'PA'),
(170, 'Papua new Guinea', 'PG'),
(171, 'Paraguay', 'PY'),
(172, 'Peru', 'PE'),
(173, 'Philippines', 'PH'),
(174, 'Pitcairn Island', 'PN'),
(175, 'Poland', 'PL'),
(176, 'Portugal', 'PT'),
(177, 'Puerto Rico', 'PR'),
(178, 'Qatar', 'QA'),
(179, 'Reunion', 'RE'),
(180, 'Romania', 'RO'),
(181, 'Russia', 'RU'),
(182, 'Rwanda', 'RW'),
(183, 'Saint Helena', 'SH'),
(184, 'Saint Kitts And Nevis', 'KN'),
(185, 'Saint Lucia', 'LC'),
(186, 'Saint Pierre and Miquelon', 'PM'),
(187, 'Saint Vincent And The Grenadines', 'VC'),
(188, 'Samoa', 'WS'),
(189, 'San Marino', 'SM'),
(190, 'Sao Tome and Principe', 'ST'),
(191, 'Saudi Arabia', 'SA'),
(192, 'Senegal', 'SN'),
(193, 'Serbia', 'RS'),
(194, 'Seychelles', 'SC'),
(195, 'Sierra Leone', 'SL'),
(196, 'Singapore', 'SG'),
(197, 'Slovakia', 'SK'),
(198, 'Slovenia', 'SI'),
(199, 'Smaller Territories of the UK', 'XG'),
(200, 'Solomon Islands', 'SB'),
(201, 'Somalia', 'SO'),
(202, 'South Africa', 'ZA'),
(203, 'South Georgia', 'GS'),
(204, 'South Sudan', 'SS'),
(205, 'Spain', 'ES'),
(206, 'Sri Lanka', 'LK'),
(207, 'Sudan', 'SD'),
(208, 'Suriname', 'SR'),
(209, 'Svalbard And Jan Mayen Islands', 'SJ'),
(210, 'Swaziland', 'SZ'),
(211, 'Sweden', 'SE'),
(212, 'Switzerland', 'CH'),
(213, 'Syria', 'SY'),
(214, 'Taiwan', 'TW'),
(215, 'Tajikistan', 'TJ'),
(216, 'Tanzania', 'TZ'),
(217, 'Thailand', 'TH'),
(218, 'Togo', 'TG'),
(219, 'Tokelau', 'TK'),
(220, 'Tonga', 'TO'),
(221, 'Trinidad And Tobago', 'TT'),
(222, 'Tunisia', 'TN'),
(223, 'Turkey', 'TR'),
(224, 'Turkmenistan', 'TM'),
(225, 'Turks And Caicos Islands', 'TC'),
(226, 'Tuvalu', 'TV'),
(227, 'Uganda', 'UG'),
(228, 'Ukraine', 'UA'),
(229, 'United Arab Emirates', 'AE'),
(230, 'United Kingdom', 'GB'),
(231, 'United States', 'US'),
(232, 'United States Minor Outlying Islands', 'UM'),
(233, 'Uruguay', 'UY'),
(234, 'Uzbekistan', 'UZ'),
(235, 'Vanuatu', 'VU'),
(236, 'Vatican City State (Holy See)', 'VA'),
(237, 'Venezuela', 'VE'),
(238, 'Vietnam', 'VN'),
(239, 'Virgin Islands (British)', 'VG'),
(240, 'Virgin Islands (US)', 'VI'),
(241, 'Wallis And Futuna Islands', 'WF'),
(242, 'Western Sahara', 'EH'),
(243, 'Yemen', 'YE'),
(244, 'Yugoslavia', 'YU'),
(245, 'Zambia', 'ZM'),
(246, 'Zimbabwe', 'ZW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
