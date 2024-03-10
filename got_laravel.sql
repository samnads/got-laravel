-- Adminer 4.8.1 MySQL 10.10.2-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `address_types`;
CREATE TABLE `address_types` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `address_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Home',	'2024-03-10 16:52:56',	'2024-03-10 16:52:56',	NULL),
(2,	'Office',	'2024-03-10 16:52:56',	'2024-03-10 16:52:56',	NULL),
(3,	'Other',	'2024-03-10 16:52:56',	'2024-03-10 16:52:56',	NULL);

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `brand_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number_1_cc` varchar(10) NOT NULL DEFAULT '+91',
  `mobile_number_1` varchar(100) NOT NULL,
  `mobile_number_1_otp` int(20) DEFAULT NULL,
  `mobile_number_1_otp_expired_at` datetime DEFAULT NULL,
  `mobile_number_1_verified_at` datetime DEFAULT NULL COMMENT 'is otp verified ?',
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `device_type` varchar(100) DEFAULT NULL COMMENT 'android | ios',
  `push_token` varchar(255) DEFAULT NULL,
  `default_address_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_number_1_cc_mobile_number_1` (`mobile_number_1_cc`,`mobile_number_1`),
  KEY `default_address_id` (`default_address_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`default_address_id`) REFERENCES `customer_addresses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customers` (`id`, `name`, `email`, `mobile_number_1_cc`, `mobile_number_1`, `mobile_number_1_otp`, `mobile_number_1_otp_expired_at`, `mobile_number_1_verified_at`, `password`, `token`, `device_type`, `push_token`, `default_address_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7,	'CloudVeins Test',	'hr@example.com',	'+91',	'9745451448',	NULL,	'2024-03-10 18:05:57',	NULL,	NULL,	'$2y$12$u9XSwTBuY5nO0VV3.fAREuCxJpL0RueJyZuVCwzuDcMJfrE/i7n7.',	NULL,	NULL,	49,	'2024-03-10 12:55:24',	'2024-03-10 18:06:06',	NULL);

DROP TABLE IF EXISTS `customer_addresses`;
CREATE TABLE `customer_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `latitude` varchar(150) DEFAULT NULL,
  `longitude` varchar(150) DEFAULT NULL,
  `apartment_no` varchar(255) DEFAULT NULL,
  `apartment_name` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `pin_code` varchar(15) DEFAULT NULL,
  `mobile_no` varchar(100) DEFAULT NULL,
  `address_type` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_type` (`address_type`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_addresses_ibfk_1` FOREIGN KEY (`address_type`) REFERENCES `address_types` (`id`),
  CONSTRAINT `customer_addresses_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customer_addresses` (`id`, `customer_id`, `name`, `address`, `latitude`, `longitude`, `apartment_no`, `apartment_name`, `street`, `landmark`, `pin_code`, `mobile_no`, `address_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(34,	7,	'ghghgh',	'addressssssss',	'245454545',	'4545454545',	'103',	'nameeeeee',	NULL,	'Near 5th milestone',	NULL,	'855256454',	1,	'2024-03-10 13:32:50',	'2024-03-10 13:50:07',	'2024-03-10 13:50:07'),
(35,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 13:34:46',	'2024-03-10 13:34:46',	NULL),
(36,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 13:34:54',	'2024-03-10 13:50:50',	'2024-03-10 13:50:50'),
(37,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 13:36:35',	'2024-03-10 13:36:35',	NULL),
(38,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 13:36:40',	'2024-03-10 13:36:40',	NULL),
(39,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 13:36:44',	'2024-03-10 13:49:49',	'2024-03-10 13:49:49'),
(40,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 13:49:31',	'2024-03-10 15:42:51',	'2024-03-10 15:42:51'),
(41,	7,	'ghghgh',	'addressssssss',	'245454545',	'4545454545',	'103',	'nameeeeee',	NULL,	'Near 5th milestone',	NULL,	'855256454',	1,	'2024-03-10 13:52:23',	'2024-03-10 13:52:43',	NULL),
(42,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 14:18:01',	'2024-03-10 14:18:01',	NULL),
(43,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 15:42:25',	'2024-03-10 15:42:25',	NULL),
(44,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:25:24',	'2024-03-10 16:25:24',	NULL),
(45,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:25:27',	'2024-03-10 16:25:27',	NULL),
(46,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:25:49',	'2024-03-10 16:25:49',	NULL),
(47,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:25:55',	'2024-03-10 16:25:55',	NULL),
(48,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:25:58',	'2024-03-10 16:27:20',	'2024-03-10 16:27:20'),
(49,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:26:51',	'2024-03-10 16:26:51',	NULL),
(50,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 17:50:38',	'2024-03-10 17:50:38',	NULL),
(51,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 18:06:00',	'2024-03-10 18:06:00',	NULL);

DROP TABLE IF EXISTS `districts`;
CREATE TABLE `districts` (
  `district_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`district_id`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `districts` (`district_id`, `state_id`, `name`, `visibility`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'Trivandrum',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(2,	1,	'Kollam',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(3,	1,	'Pathanamthitta',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(4,	2,	'Kanniyakumari',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(5,	2,	'Salem',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(6,	2,	'Trichirappalli',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(7,	3,	'Bengaluru (Bangalore) Rural',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(8,	3,	'Bengaluru (Bangalore) Urban',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(9,	3,	'Kodagu',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL);

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_reset_tokens_table',	1),
(3,	'2014_10_12_100000_create_password_resets_table',	1),
(4,	'2019_08_19_000000_create_failed_jobs_table',	1),
(5,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(6,	'2024_03_06_185128_create_product_categories_table',	1),
(7,	'2024_03_07_160040_create_vendors_table',	1),
(8,	'2024_03_07_172422_create_roles_table',	2);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_parent_name_unique` (`parent_id`,`name`),
  UNIQUE KEY `product_categories_image_unique` (`image`),
  CONSTRAINT `product_categories_parent_foreign` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_categories` (`id`, `parent_id`, `name`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(81,	NULL,	'Cakes',	'dfdfdf',	NULL,	'2024-03-09 03:13:33',	'2024-03-09 03:21:58',	NULL),
(82,	NULL,	'Grocery',	'er',	NULL,	'2024-03-09 03:13:41',	'2024-03-09 03:42:04',	NULL),
(83,	82,	'dsd',	'dfdfdf',	NULL,	'2024-03-09 03:13:33',	'2024-03-09 03:13:33',	NULL),
(84,	82,	'sdsd',	'er',	NULL,	'2024-03-09 03:13:41',	'2024-03-09 03:13:41',	NULL),
(88,	82,	'sdsdghgh',	'er',	NULL,	'2024-03-09 03:13:41',	'2024-03-09 03:13:41',	NULL),
(90,	82,	'sdsdghghgh',	'erghgh',	NULL,	'2024-03-09 03:13:41',	'2024-03-09 03:13:41',	NULL),
(91,	81,	'sdsdghgh',	'er',	NULL,	'2024-03-09 03:13:41',	'2024-03-09 03:13:41',	NULL),
(92,	81,	'sdsdghghgh',	'erghgh',	NULL,	'2024-03-09 03:13:41',	'2024-03-09 03:13:41',	NULL),
(94,	NULL,	'dfdf',	'dfdf',	NULL,	'2024-03-09 03:37:07',	'2024-03-09 03:42:25',	NULL),
(95,	81,	'sub cake',	'ssdsd',	NULL,	'2024-03-09 03:39:44',	'2024-03-09 03:39:44',	NULL),
(96,	NULL,	'pp',	'trtrrrrrrrrr',	NULL,	'2024-03-09 05:15:54',	'2024-03-09 05:16:12',	NULL),
(97,	82,	'cake 1',	'vvvdffd',	NULL,	'2024-03-09 05:21:22',	'2024-03-09 05:45:29',	NULL),
(98,	81,	'eeeeeee',	'ererwerwe',	NULL,	'2024-03-09 05:47:02',	'2024-03-09 05:48:02',	NULL),
(99,	NULL,	'5656',	'56',	NULL,	'2024-03-09 05:47:46',	'2024-03-09 05:47:46',	NULL),
(100,	96,	'56',	'5656',	NULL,	'2024-03-09 05:47:55',	'2024-03-09 05:47:55',	NULL);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Every user role has thier own rights.';


DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `state_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `states` (`state_id`, `name`, `visibility`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Kerala',	1,	'2024-03-09 16:58:06',	'2024-03-09 16:58:06',	NULL),
(2,	'Tamilnadu',	1,	'2024-03-09 16:58:06',	'2024-03-09 16:58:06',	NULL),
(3,	'Karnataka',	1,	'2024-03-09 16:58:31',	'2024-03-09 16:58:31',	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Admin',	'admin@example.com',	'admin@example.com',	'2024-03-07 10:49:50',	'$2y$12$SjmwFDIffWTH4X84sgvv/.VFWHJdaCOH9i0P3s/mx.p8cqWSRHvIm',	'tzuOJJpa6co6LK9DvedtTcFNPSyH7Tq0XLNlNLBcoP4mODz5z7npcxNSUfYR',	'2024-03-07 10:49:50',	'2024-03-07 10:49:50',	NULL);

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(191) NOT NULL,
  `owner_name` varchar(191) NOT NULL,
  `gst_number` varchar(191) NOT NULL,
  `pan_number` varchar(191) NOT NULL,
  `mobile_number` varchar(191) NOT NULL,
  `country_id` varchar(191) NOT NULL,
  `state_id` varchar(191) NOT NULL,
  `district_id` varchar(191) NOT NULL,
  `location_id` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `latitude` varchar(191) NOT NULL,
  `longitude` varchar(191) NOT NULL,
  `accuracy` varchar(191) NOT NULL,
  `shop_thumbnail` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_username_unique` (`username`),
  UNIQUE KEY `vendors_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vendors` (`id`, `vendor_name`, `owner_name`, `gst_number`, `pan_number`, `mobile_number`, `country_id`, `state_id`, `district_id`, `location_id`, `address`, `latitude`, `longitude`, `accuracy`, `shop_thumbnail`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Vendor XYZ',	'rer',	'erer',	'f',	're',	'ff',	'ds',	'df',	'd',	'sds',	'8.472742112160745',	'77.18957241385607',	'sds',	'dsd',	'vendor@example.com',	'vendor@example.com',	'2024-03-07 19:50:15',	'$2y$12$SjmwFDIffWTH4X84sgvv/.VFWHJdaCOH9i0P3s/mx.p8cqWSRHvIm',	'fPL7iVuEHEwppGsoeWPcuEjiiBbgJx2y4Twe2rTcqUTmQ4ITsiuXKGK3bfIv',	NULL,	NULL,	NULL);

-- 2024-03-10 18:15:58
