-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: db_nre
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ceding_broker`
--

DROP TABLE IF EXISTS `ceding_broker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceding_broker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `country` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ceding_broker_type_foreign` (`type`),
  KEY `ceding_broker_FK` (`country`),
  CONSTRAINT `ceding_broker_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `ceding_broker_type_foreign` FOREIGN KEY (`type`) REFERENCES `company_type` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceding_broker`
--

LOCK TABLES `ceding_broker` WRITE;
/*!40000 ALTER TABLE `ceding_broker` DISABLE KEYS */;
/*!40000 ALTER TABLE `ceding_broker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id_foreign` (`state_id`),
  CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classification`
--

DROP TABLE IF EXISTS `classification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classification`
--

LOCK TABLES `classification` WRITE;
/*!40000 ALTER TABLE `classification` DISABLE KEYS */;
/*!40000 ALTER TABLE `classification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cob`
--

DROP TABLE IF EXISTS `cob`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `form` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cob`
--

LOCK TABLES `cob` WRITE;
/*!40000 ALTER TABLE `cob` DISABLE KEYS */;
/*!40000 ALTER TABLE `cob` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_type`
--

DROP TABLE IF EXISTS `company_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_type`
--

LOCK TABLES `company_type` WRITE;
/*!40000 ALTER TABLE `company_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condition_needed`
--

DROP TABLE IF EXISTS `condition_needed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `condition_needed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cob_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_needed_cob_id_foreign` (`cob_id`),
  CONSTRAINT `condition_needed_cob_id_foreign` FOREIGN KEY (`cob_id`) REFERENCES `cob` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condition_needed`
--

LOCK TABLES `condition_needed` WRITE;
/*!40000 ALTER TABLE `condition_needed` DISABLE KEYS */;
/*!40000 ALTER TABLE `condition_needed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `construction`
--

DROP TABLE IF EXISTS `construction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `construction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `construction`
--

LOCK TABLES `construction` WRITE;
/*!40000 ALTER TABLE `construction` DISABLE KEYS */;
/*!40000 ALTER TABLE `construction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT 'male',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_customer_id_foreign` (`customer_id`),
  CONSTRAINT `contacts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `continent` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `symbol_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_base_currency` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `currencies_FK` (`country`),
  CONSTRAINT `currencies_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies_exc`
--

DROP TABLE IF EXISTS `currencies_exc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies_exc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` bigint(20) unsigned NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `kurs` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currencies_exc_FK` (`currency`),
  CONSTRAINT `currencies_exc_currency_foreign` FOREIGN KEY (`currency`) REFERENCES `currencies` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies_exc`
--

LOCK TABLES `currencies_exc` WRITE;
/*!40000 ALTER TABLE `currencies_exc` DISABLE KEYS */;
/*!40000 ALTER TABLE `currencies_exc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_prefix` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_suffix` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deductible_type`
--

DROP TABLE IF EXISTS `deductible_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deductible_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbreviation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deductible_type`
--

LOCK TABLES `deductible_type` WRITE;
/*!40000 ALTER TABLE `deductible_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `deductible_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `earthquake_zone`
--

DROP TABLE IF EXISTS `earthquake_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `earthquake_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `earthquake_zone_country_id_foreign` (`country_id`),
  CONSTRAINT `earthquake_zone_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `earthquake_zone`
--

LOCK TABLES `earthquake_zone` WRITE;
/*!40000 ALTER TABLE `earthquake_zone` DISABLE KEYS */;
/*!40000 ALTER TABLE `earthquake_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extended_coverage`
--

DROP TABLE IF EXISTS `extended_coverage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extended_coverage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cob_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `extended_coverage_cob_id_foreign` (`cob_id`),
  CONSTRAINT `extended_coverage_cob_id_foreign` FOREIGN KEY (`cob_id`) REFERENCES `cob` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extended_coverage`
--

LOCK TABLES `extended_coverage` WRITE;
/*!40000 ALTER TABLE `extended_coverage` DISABLE KEYS */;
/*!40000 ALTER TABLE `extended_coverage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_lookup_location`
--

DROP TABLE IF EXISTS `fe_lookup_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_lookup_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `longtitude` double NOT NULL,
  `latitude` double NOT NULL,
  `postal_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `eq_zone` int(11) DEFAULT NULL,
  `flood_zone` int(11) DEFAULT NULL,
  `insured` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fe_lookup_location_city_id_foreign` (`city_id`),
  KEY `fe_lookup_location_province_id_foreign` (`province_id`),
  KEY `fe_lookup_location_eq_zone_foreign` (`eq_zone`),
  KEY `fe_lookup_location_flood_zone_foreign` (`flood_zone`),
  KEY `fe_lookup_location_insured_foreign` (`insured`),
  KEY `fe_lookup_location_FK` (`country_id`),
  CONSTRAINT `fe_lookup_location_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fe_lookup_location_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fe_lookup_location_eq_zone_foreign` FOREIGN KEY (`eq_zone`) REFERENCES `earthquake_zone` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fe_lookup_location_flood_zone_foreign` FOREIGN KEY (`flood_zone`) REFERENCES `flood_zone` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fe_lookup_location_insured_foreign` FOREIGN KEY (`insured`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fe_lookup_location_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `states` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_lookup_location`
--

LOCK TABLES `fe_lookup_location` WRITE;
/*!40000 ALTER TABLE `fe_lookup_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `fe_lookup_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flood_zone`
--

DROP TABLE IF EXISTS `flood_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flood_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flood_zone_country_id_foreign` (`country_id`),
  CONSTRAINT `flood_zone_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flood_zone`
--

LOCK TABLES `flood_zone` WRITE;
/*!40000 ALTER TABLE `flood_zone` DISABLE KEYS */;
/*!40000 ALTER TABLE `flood_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `golf_field_hole`
--

DROP TABLE IF EXISTS `golf_field_hole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `golf_field_hole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `golf_field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hole_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `golf_field_hole`
--

LOCK TABLES `golf_field_hole` WRITE;
/*!40000 ALTER TABLE `golf_field_hole` DISABLE KEYS */;
/*!40000 ALTER TABLE `golf_field_hole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interest_insured`
--

DROP TABLE IF EXISTS `interest_insured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interest_insured` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cob_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interest_insured_cob_id_foreign` (`cob_id`),
  CONSTRAINT `interest_insured_cob_id_foreign` FOREIGN KEY (`cob_id`) REFERENCES `cob` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interest_insured`
--

LOCK TABLES `interest_insured` WRITE;
/*!40000 ALTER TABLE `interest_insured` DISABLE KEYS */;
/*!40000 ALTER TABLE `interest_insured` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `koc`
--

DROP TABLE IF EXISTS `koc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `koc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `parent_id` int(11) DEFAULT NULL,
  `abbreviation` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `koc`
--

LOCK TABLES `koc` WRITE;
/*!40000 ALTER TABLE `koc` DISABLE KEYS */;
/*!40000 ALTER TABLE `koc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marine_lookup`
--

DROP TABLE IF EXISTS `marine_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marine_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grt` int(11) NOT NULL DEFAULT '0',
  `dwt` int(11) NOT NULL DEFAULT '0',
  `nrt` int(11) NOT NULL DEFAULT '0',
  `power` int(11) NOT NULL DEFAULT '0',
  `ship_year` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repair_year` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `galangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_type_id` int(11) DEFAULT NULL,
  `classification_id` int(11) DEFAULT NULL,
  `construction_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marine_lookup_FK` (`ship_type_id`),
  KEY `marine_lookup_FK_1` (`classification_id`),
  KEY `marine_lookup_FK_2` (`construction_id`),
  KEY `marine_lookup_FK_3` (`country_id`),
  CONSTRAINT `marine_lookup_classification_id_foreign` FOREIGN KEY (`classification_id`) REFERENCES `classification` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `marine_lookup_construction_id_foreign` FOREIGN KEY (`construction_id`) REFERENCES `construction` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `marine_lookup_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `marine_lookup_ship_type_id_foreign` FOREIGN KEY (`ship_type_id`) REFERENCES `ship_type` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marine_lookup`
--

LOCK TABLES `marine_lookup` WRITE;
/*!40000 ALTER TABLE `marine_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `marine_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2021_05_25_141810_create_company_type_table',1),(5,'2021_05_25_141810_create_countries_table',1),(6,'2021_05_25_141810_create_currencies_table',1),(7,'2021_05_25_141810_create_customers_table',1),(8,'2021_05_25_141810_create_earthquake_zone_table',1),(9,'2021_05_25_141810_create_flood_zone_table',1),(10,'2021_05_25_141810_create_ship_type_table',1),(11,'2021_05_25_141810_create_states_table',1),(12,'2021_05_25_141810_create_users_table',1),(13,'2021_05_25_141811_create_cities_table',1),(14,'2021_05_25_141811_create_ship_port_table',1),(15,'2021_05_25_141812_create_ceding_broker_table',1),(16,'2021_05_25_141812_create_classification_table',1),(17,'2021_05_25_141812_create_cob_table',1),(18,'2021_05_25_141812_create_condition_needed_table',1),(19,'2021_05_25_141812_create_construction_table',1),(20,'2021_05_25_141812_create_contacts_table',1),(21,'2021_05_25_141812_create_currencies_exc_table',1),(22,'2021_05_25_141812_create_deductible_type_table',1),(23,'2021_05_25_141812_create_extended_coverage_table',1),(24,'2021_05_25_141812_create_fe_lookup_location_table',1),(25,'2021_05_25_141812_create_golf_field_hole_table',1),(26,'2021_05_25_141812_create_interest_insured_table',1),(27,'2021_05_25_141812_create_koc_table',1),(28,'2021_05_25_141812_create_marine_lookup_table',1),(29,'2021_05_25_141812_create_modules_table',1),(30,'2021_05_25_141812_create_occupation_table',1),(31,'2021_05_25_141812_create_property_type_table',1),(32,'2021_05_25_141812_create_roles_table',1),(33,'2021_05_25_141812_create_route_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) NOT NULL,
  `module_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `read` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `update` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `delete` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (7,1,'contact_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(9,1,'role_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(11,1,'user_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(13,1,'lead_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(15,1,'product_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(17,1,'office_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(26,1,'country_module','on','on','on','on','2021-01-02 12:59:13','2021-01-02 12:59:13'),(28,1,'occupation_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:03:38'),(29,1,'cob_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(30,1,'currency_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(31,1,'exchange_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(32,1,'koc_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(33,1,'golf_field_hole_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(34,1,'ceding_broker_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(35,1,'lookup_location_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(36,1,'city_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(37,1,'state_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(38,1,'earthquake_zone_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(39,1,'flood_zone_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(66,1,'ship_type_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(67,1,'classification_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(68,1,'construction_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(69,1,'marine_lookup_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(70,1,'property_type_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(71,1,'condition_needed_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(140,1,'financial_lines_slip_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(141,1,'marine_slip_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(142,1,'personal_accident_slip_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(143,1,'hole_in_one_slip_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(144,1,'he_and_motor_slip_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(145,1,'moveable_property_slip_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(162,1,'cause_of_loss_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(163,1,'company_type_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(164,1,'interest_insured_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(165,1,'prefix_insured_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(166,1,'route_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(167,1,'ship_port_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(168,1,'nature_of_loss_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(169,1,'surveyor_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(178,1,'location_master_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(179,1,'marine_master_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(180,1,'deductible_panel_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50'),(181,1,'extend_coverage_module','on','on','on','on','2021-01-08 08:02:50','2021-01-08 08:02:50');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `occupation`
--

DROP TABLE IF EXISTS `occupation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `occupation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(350) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbreviation` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `cob_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rate_batas_bawah_building_class_1` decimal(10,3) DEFAULT NULL,
  `rate_batas_atas_building_class_1` decimal(10,3) DEFAULT NULL,
  `rate_batas_bawah_building_class_2` decimal(10,3) DEFAULT NULL,
  `rate_batas_atas_building_class_2` decimal(10,3) DEFAULT NULL,
  `rate_batas_bawah_building_class_3` decimal(10,3) DEFAULT NULL,
  `rate_batas_atas_building_class_3` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `occupation_FK` (`cob_id`),
  CONSTRAINT `occupation_cob_id_foreign` FOREIGN KEY (`cob_id`) REFERENCES `cob` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `occupation`
--

LOCK TABLES `occupation` WRITE;
/*!40000 ALTER TABLE `occupation` DISABLE KEYS */;
/*!40000 ALTER TABLE `occupation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',4,'apiAccessToken','cd5153cba4f373c2cea89f95869c794f910e9d655956858dcbe798fd9ebefaad','[\"*\"]',NULL,'2021-05-26 04:13:25','2021-05-26 04:13:25'),(2,'App\\Models\\User',1,'apiAccessToken','8367cf55bb9a60b98053115cd07d3fcf03ff2298e44249e948ed8724d0ec40fa','[\"*\"]',NULL,'2021-05-26 04:48:52','2021-05-26 04:48:52');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_type`
--

DROP TABLE IF EXISTS `property_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_type`
--

LOCK TABLES `property_type` WRITE;
/*!40000 ALTER TABLE `property_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_role` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','no','active','2021-01-02 12:59:13','2021-01-02 12:59:13'),(2,'user','no','active','2021-01-02 12:59:13','2021-04-13 06:07:53'),(3,'salesperson','no','active','2021-01-02 12:59:13','2021-01-02 12:59:13'),(4,'Biro Humas','no','active','2021-01-08 07:36:43','2021-01-08 07:36:43'),(5,'nasre','no','active','2021-01-15 05:31:05','2021-01-15 05:31:05'),(6,'Facultative','no','active','2021-02-18 04:31:44','2021-02-18 04:31:44'),(7,'fire & engineering','yes','active','2021-02-18 08:48:20','2021-04-13 06:07:53');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `from` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `transit_1` int(11) DEFAULT NULL,
  `transit_2` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `route_from_foreign` (`from`),
  KEY `route_to_foreign` (`to`),
  KEY `route_transit_1_foreign` (`transit_1`),
  KEY `route_transit_2_foreign` (`transit_2`),
  CONSTRAINT `route_from_foreign` FOREIGN KEY (`from`) REFERENCES `ship_port` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `route_to_foreign` FOREIGN KEY (`to`) REFERENCES `ship_port` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `route_transit_1_foreign` FOREIGN KEY (`transit_1`) REFERENCES `ship_port` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `route_transit_2_foreign` FOREIGN KEY (`transit_2`) REFERENCES `ship_port` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
/*!40000 ALTER TABLE `route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ship_port`
--

DROP TABLE IF EXISTS `ship_port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_port` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `city_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ship_port`
--

LOCK TABLES `ship_port` WRITE;
/*!40000 ALTER TABLE `ship_port` DISABLE KEYS */;
/*!40000 ALTER TABLE `ship_port` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ship_type`
--

DROP TABLE IF EXISTS `ship_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ship_type`
--

LOCK TABLES `ship_type` WRITE;
/*!40000 ALTER TABLE `ship_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ship_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepulauan_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `states_country_id_foreign` (`country_id`),
  CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@mandaladwipantara.co.id','',1,'active',NULL,'$2y$10$r5BM0zOSyRuHftQ56mJXCuFzEXwyequWW9MzCiwDmjPF3ivFlLH.q','V8AnvxqDDJ89yHst4OVbWYaVsQvj5DpcR2f4WdoXGc9Mz8xHLS1fmJ8F7qgd','2021-01-02 12:59:29','2021-01-02 12:59:29');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_nre'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-26 13:55:50
