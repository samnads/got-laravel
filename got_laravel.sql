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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `thumbnail_image` varchar(255) DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `thumbnail_image` (`thumbnail_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `brands` (`id`, `name`, `description`, `thumbnail_image`, `visibility`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Apple',	'rtrtrt',	'8xLWcVCdB69E1x6cwTQja98hQ8sgmsPuv14U2h0C.png',	1,	'2024-03-12 22:40:46',	'2024-03-16 17:52:49',	'2024-03-16 17:52:49'),
(2,	'Pepsico',	'hj',	'NdfFgniogVuh8sr38KTpFMQ1wozW8lRrsVIeYw6b.png',	1,	'2024-03-12 22:40:46',	'2024-03-16 18:40:43',	NULL),
(8,	'tt',	'g',	'0uY49oKnP2lxiQXcJNzpupJahBmu8mHa6hyH7C2L.png',	0,	'2024-03-16 17:44:46',	'2024-03-16 17:52:16',	NULL),
(9,	'ghg',	'ghgh',	'OBM42MqGmPcrO24mWC1JgBMYoWWbvxppLJ0JKNFH.png',	0,	'2024-03-16 17:48:02',	'2024-03-16 17:48:02',	NULL),
(14,	'Hello',	'ff',	'Zo8yMRgwluGzuUwpUwxeOBSYDh88xIGaNbP7vsyl.png',	0,	'2024-03-16 17:52:26',	'2024-03-16 17:52:26',	NULL);

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `vendor_product_id` bigint(20) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id_vendor_product_id` (`customer_id`,`vendor_product_id`),
  KEY `vendor_product_id` (`vendor_product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`vendor_product_id`) REFERENCES `vendor_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart` (`id`, `customer_id`, `vendor_product_id`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3,	7,	1,	4.00,	'2024-03-20 15:32:27',	'2024-03-20 18:16:55',	'2024-03-20 18:16:55'),
(4,	7,	2,	5.00,	'2024-03-20 16:53:55',	'2024-03-20 18:16:55',	'2024-03-20 18:16:55'),
(5,	7,	3,	4.00,	'2024-03-20 16:54:00',	'2024-03-20 18:16:55',	'2024-03-20 18:16:55'),
(6,	7,	24,	4.00,	'2024-03-20 16:54:00',	'2024-03-20 17:31:50',	NULL);

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
(7,	'CloudVeins Test',	'hr@example.com',	'+91',	'9745451448',	NULL,	'2024-03-20 17:50:59',	NULL,	NULL,	'$2y$12$J9t9azobJXGBUUwDQq8J0uDU92tD3pWqWwzI6EsQEJeTq1/vLazje',	NULL,	NULL,	49,	'2024-03-10 12:55:24',	'2024-03-20 17:50:51',	NULL),
(8,	'kannsn',	'kannansk172@gmail.com',	'+91',	'9188778069',	NULL,	'2024-03-15 18:09:11',	NULL,	NULL,	'$2y$12$IKyZ1Daao3ZL9TSZXpqlQugZcG7D374pdzfRXZseKQ3ecENXSlCLC',	NULL,	NULL,	NULL,	'2024-03-15 16:07:05',	'2024-03-15 18:32:33',	NULL),
(9,	'venu',	'venu@gmail.com',	'+91',	'9154564646',	NULL,	'2024-03-15 16:27:38',	NULL,	NULL,	'$2y$12$HpKa807PL/7kXH8UoCK35uJc35DPPQ1NPKkx66HEgwIlsemF2mBvG',	NULL,	NULL,	NULL,	'2024-03-15 16:27:28',	'2024-03-15 16:27:54',	NULL);

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
(51,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 18:06:00',	'2024-03-10 18:06:00',	NULL),
(52,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-11 20:08:05',	'2024-03-11 20:08:05',	NULL),
(53,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-11 20:08:07',	'2024-03-11 20:08:07',	NULL),
(54,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-11 20:08:10',	'2024-03-11 20:08:10',	NULL),
(55,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-11 20:08:11',	'2024-03-11 20:08:11',	NULL),
(56,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-11 20:08:14',	'2024-03-11 20:08:14',	NULL);

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


DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `district_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `district_id` (`district_id`),
  CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `locations` (`id`, `district_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'Neyyattinkara',	'2024-03-11 23:34:05',	'2024-03-11 23:34:05',	NULL);

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

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_reference` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `address_id` bigint(20) unsigned NOT NULL,
  `total_payable` decimal(10,2) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_reference` (`order_reference`),
  KEY `customer_id` (`customer_id`),
  KEY `address_id` (`address_id`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `customer_addresses` (`id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`id`, `order_reference`, `customer_id`, `vendor_id`, `address_id`, `total_payable`, `created_at`, `updated_at`, `deleted_at`) VALUES
(30,	'GOT-OR-LOCAL-000030',	7,	1,	34,	468.00,	'2024-03-20 17:58:13',	'2024-03-20 17:58:14',	NULL),
(31,	'GOT-OR-LOCAL-000031',	7,	1,	35,	468.00,	'2024-03-20 18:12:08',	'2024-03-20 18:12:08',	NULL),
(32,	'GOT-OR-LOCAL-000032',	7,	1,	35,	468.00,	'2024-03-20 18:16:55',	'2024-03-20 18:16:55',	NULL);

DROP TABLE IF EXISTS `order_customer_addresses`;
CREATE TABLE `order_customer_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
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
  UNIQUE KEY `order_id` (`order_id`),
  KEY `address_type` (`address_type`),
  CONSTRAINT `order_customer_addresses_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_customer_addresses_ibfk_2` FOREIGN KEY (`address_type`) REFERENCES `address_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_customer_addresses` (`id`, `order_id`, `name`, `address`, `latitude`, `longitude`, `apartment_no`, `apartment_name`, `street`, `landmark`, `pin_code`, `mobile_no`, `address_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(57,	31,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-20 18:12:08',	'2024-03-20 18:12:08',	NULL),
(58,	32,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-20 18:16:55',	'2024-03-20 18:16:55',	NULL);

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE `order_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `vendor_product_id` bigint(20) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT 1.00,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `vendor_product_id` (`vendor_product_id`),
  CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`vendor_product_id`) REFERENCES `vendor_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_products` (`id`, `order_id`, `vendor_product_id`, `unit_price`, `quantity`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(53,	30,	1,	40.00,	4.00,	160.00,	'2024-03-20 17:58:13',	'2024-03-20 17:58:13',	NULL),
(54,	30,	2,	20.00,	5.00,	100.00,	'2024-03-20 17:58:13',	'2024-03-20 17:58:13',	NULL),
(55,	30,	3,	52.00,	4.00,	208.00,	'2024-03-20 17:58:14',	'2024-03-20 17:58:14',	NULL),
(56,	31,	1,	40.00,	4.00,	160.00,	'2024-03-20 18:12:08',	'2024-03-20 18:12:08',	NULL),
(57,	31,	2,	20.00,	5.00,	100.00,	'2024-03-20 18:12:08',	'2024-03-20 18:12:08',	NULL),
(58,	31,	3,	52.00,	4.00,	208.00,	'2024-03-20 18:12:08',	'2024-03-20 18:12:08',	NULL),
(59,	32,	1,	40.00,	4.00,	160.00,	'2024-03-20 18:16:55',	'2024-03-20 18:16:55',	NULL),
(60,	32,	2,	20.00,	5.00,	100.00,	'2024-03-20 18:16:55',	'2024-03-20 18:16:55',	NULL),
(61,	32,	3,	52.00,	4.00,	208.00,	'2024-03-20 18:16:55',	'2024-03-20 18:16:55',	NULL);

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


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(155) DEFAULT NULL,
  `item_size` decimal(10,2) NOT NULL,
  `unit_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail_image` varchar(155) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `thumbnail_image` (`thumbnail_image`),
  KEY `brand_id` (`brand_id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `code`, `item_size`, `unit_id`, `brand_id`, `name`, `description`, `thumbnail_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'FFDF445',	50.00,	2,	NULL,	'Chilly Powder',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-16 02:52:23',	NULL),
(2,	'FFSDF4',	1.00,	3,	NULL,	'Salt',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:48',	NULL),
(4,	'4535EW',	100.00,	2,	NULL,	'Turmeric Powder',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:41',	NULL),
(5,	'COL3343',	75.00,	2,	NULL,	'Colgate',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:40',	NULL),
(7,	'5345BJ',	1.00,	6,	NULL,	'Band Aid',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:39',	NULL),
(9,	'53543',	1.00,	3,	NULL,	'Tomato',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:38',	NULL),
(11,	'DFP244',	500.00,	2,	NULL,	'Ginger',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(13,	'CAR45343',	250.00,	2,	NULL,	'Carrot',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(14,	'FDFSFSF',	600.00,	4,	NULL,	'Pepsi',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(15,	'MFD64',	600.00,	4,	NULL,	'Mirinda',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(16,	'7UPDFSFSdf',	600.00,	4,	NULL,	'7 Up',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(17,	'63535435',	1.00,	5,	NULL,	'7 Up',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(18,	'45465464',	1.00,	5,	NULL,	'7 Up',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(20,	'45634564',	5.00,	3,	NULL,	'BRAND1 - 5 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(21,	'45454',	10.00,	3,	NULL,	'BRAND1 - 10 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'7RwxPhqT5ooZxeHz7h5LaU9TKoHpkv1IvZGFTbwR.jpg',	'2024-03-14 23:18:15',	'2024-03-16 18:36:59',	NULL),
(22,	'466664F',	10.00,	3,	NULL,	'BRAND2 - 10 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'4o6wZVIsTOgjkaevPmZOaLHFfMegTPtCGfNx5KXM.png',	'2024-03-14 23:18:15',	'2024-03-16 18:35:34',	NULL),
(23,	'NBJN454',	5.00,	3,	NULL,	'BRAND2 - 5 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'jhJPFV5v5bKeOxgiE1RwwkiATqOL6hNkUhhUFUn2.png',	'2024-03-14 23:18:15',	'2024-03-16 18:33:08',	NULL),
(26,	'DF45GF76',	350.00,	2,	NULL,	'Ponds Powder',	'Ponds.........',	'HnG3BJ9imhtQKfVwofW25EGFCj7M1Hx2tOty4s32.jpg',	'2024-03-16 03:10:58',	'2024-03-16 18:37:55',	NULL);

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `thumbnail_image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_parent_name_unique` (`parent_id`,`name`),
  UNIQUE KEY `product_categories_image_unique` (`thumbnail_image`),
  CONSTRAINT `product_categories_parent_foreign` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_categories` (`id`, `parent_id`, `name`, `description`, `thumbnail_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	'Grocery',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'fZllvdNgmD4yUXHLZ3wTULi7sGY1TIzI0Bj70OIH.jpg',	'2024-03-14 17:44:23',	'2024-03-15 19:54:23',	NULL),
(2,	NULL,	'Health Care',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'wyEYeQvnPZpdgLQXJQaX3VHpn8Umpero5SRwuOfy.jpg',	'2024-03-14 17:44:23',	'2024-03-15 19:53:38',	NULL),
(3,	NULL,	'Vegetables',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'GdIp1UNewSVKuIOVAAJiXZNUQlxmKAN6q5dp62VJ.webp',	'2024-03-14 17:44:23',	'2024-03-15 19:53:01',	NULL),
(4,	NULL,	'Soft Drinks',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'10QpkgFHa64bQW9mUVIbT1OMblj78yuGRUTDT4GU.jpg',	'2024-03-14 17:44:23',	'2024-03-15 19:51:08',	NULL),
(5,	NULL,	'Rice Kits',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'9qxy2G5LHCCTVjWaui5kOePIMAYPdiiLPSZBEWiH.jpg',	'2024-03-14 17:44:23',	'2024-03-15 20:49:19',	NULL),
(17,	NULL,	'Cosmetics',	'Cosmetic products',	'0ZPia9SYJeL3q0lfTYezBvR2cC87RT2LpAOuAxwJ.webp',	'2024-03-15 21:38:28',	'2024-03-16 12:10:25',	NULL);

DROP TABLE IF EXISTS `product_category_mappings`;
CREATE TABLE `product_category_mappings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_category_id` (`product_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_category_mappings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_category_mappings_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_category_mappings` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	1,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(2,	2,	1,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(3,	4,	1,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(4,	5,	2,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(5,	7,	2,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(6,	9,	3,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(7,	11,	3,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(8,	13,	3,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(9,	14,	4,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(10,	15,	4,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(11,	16,	4,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(12,	17,	4,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(13,	18,	4,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(14,	20,	5,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(15,	21,	5,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(16,	22,	5,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(17,	23,	5,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(18,	26,	17,	'2024-03-16 03:10:58',	'2024-03-16 03:10:58',	NULL),
(20,	22,	1,	'2024-03-16 18:35:34',	'2024-03-16 18:35:34',	NULL),
(21,	21,	4,	'2024-03-16 18:36:59',	'2024-03-16 18:36:59',	NULL);

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

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `units` (`id`, `name`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Piece',	'Pc',	'2024-03-14 21:39:07',	'2024-03-14 21:39:07',	NULL),
(2,	'Gram',	'Gm',	'2024-03-14 21:39:07',	'2024-03-14 21:39:07',	NULL),
(3,	'Kilo Gram',	'Kg',	'2024-03-14 21:39:07',	'2024-03-14 21:39:07',	NULL),
(4,	'Milli Litre',	'Ml',	'2024-03-14 21:39:07',	'2024-03-14 21:39:07',	NULL),
(5,	'Litre',	'Ltr',	'2024-03-14 21:39:07',	'2024-03-14 21:39:07',	NULL),
(6,	'Box',	'Bx',	'2024-03-14 21:39:07',	'2024-03-14 21:39:07',	NULL);

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
(1,	'Admin',	'admin@example.com',	'admin@example.com',	'2024-03-07 10:49:50',	'$2y$12$SjmwFDIffWTH4X84sgvv/.VFWHJdaCOH9i0P3s/mx.p8cqWSRHvIm',	'WlrDm6wWVdfH7eUdVunYRfCSCJXkvELkPyk4ZqeS2Jm13rG9nrKU598GVTDq',	'2024-03-07 10:49:50',	'2024-03-07 10:49:50',	NULL);

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `gst_number` varchar(150) DEFAULT NULL,
  `pan_number` varchar(150) DEFAULT NULL,
  `mobile_number_cc` varchar(30) NOT NULL DEFAULT '+91',
  `mobile_number` varchar(100) NOT NULL,
  `district_id` bigint(20) unsigned DEFAULT NULL,
  `location_id` bigint(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `accuracy` varchar(5) DEFAULT NULL,
  `shop_thumbnail` varchar(255) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(155) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `blocked_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_username_unique` (`username`),
  UNIQUE KEY `vendors_email_unique` (`email`),
  KEY `district_id` (`district_id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`),
  CONSTRAINT `vendors_ibfk_2` FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`),
  CONSTRAINT `vendors_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vendors` (`id`, `vendor_name`, `owner_name`, `gst_number`, `pan_number`, `mobile_number_cc`, `mobile_number`, `district_id`, `location_id`, `address`, `latitude`, `longitude`, `accuracy`, `shop_thumbnail`, `email`, `email_verified_at`, `username`, `password`, `remember_token`, `blocked_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Vendor ABC',	'Owner 1',	'GST1',	'',	'+91',	'123451',	1,	1,	'address1',	'455',	'3545',	NULL,	NULL,	'vendor1@example.com',	NULL,	'vendor1@example.com',	'$2y$12$SjmwFDIffWTH4X84sgvv/.VFWHJdaCOH9i0P3s/mx.p8cqWSRHvIm',	NULL,	NULL,	'2024-03-11 18:04:08',	'2024-03-19 13:42:20',	NULL),
(2,	'Vendor XYZ',	'Owner 2',	'GST2',	'',	'+91',	'123456',	1,	1,	'address1',	'455',	'3545',	NULL,	NULL,	'vendor2@example.com',	NULL,	'vendor2@example.com',	'$2y$12$SjmwFDIffWTH4X84sgvv/.VFWHJdaCOH9i0P3s/mx.p8cqWSRHvIm',	NULL,	NULL,	'2024-03-11 18:04:08',	'2024-03-19 13:42:16',	NULL),
(26,	'Vendor Name',	'Owner Name',	'GST Number',	NULL,	'+91',	'355564654646',	NULL,	NULL,	'Address',	'4535353',	'53535',	NULL,	NULL,	'sdsdsd@sas.hg',	NULL,	'dsds@sd.df',	'$2y$12$PqQbBgjUQI0SGLcivKc/rea62H0NXF.3VMGOtzrAfIxZVqNtW/vU2',	NULL,	NULL,	'2024-03-18 16:01:40',	'2024-03-19 14:08:46',	NULL),
(34,	'test name',	NULL,	NULL,	NULL,	'+91',	'123456789',	NULL,	NULL,	'sdsdsdsdsdsdsds',	'3.45454545',	'2.45454546',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-03-20 10:11:54',	'2024-03-20 10:11:54',	NULL);

DROP TABLE IF EXISTS `vendor_fssai`;
CREATE TABLE `vendor_fssai` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `licence_number` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `vendor_fssai_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `vendor_products`;
CREATE TABLE `vendor_products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `min_cart_quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `max_cart_quantity` int(10) unsigned NOT NULL,
  `maximum_retail_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendor_id_product_id` (`vendor_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `vendor_products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`),
  CONSTRAINT `vendor_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `vendor_products` (`id`, `vendor_id`, `product_id`, `min_cart_quantity`, `max_cart_quantity`, `maximum_retail_price`, `retail_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	1,	1,	5,	50.00,	40.00,	'2024-03-14 23:36:51',	'2024-03-19 19:39:52',	NULL),
(2,	1,	2,	1,	5,	25.00,	20.00,	'2024-03-14 23:36:51',	'2024-03-15 19:46:51',	NULL),
(3,	1,	4,	1,	5,	55.00,	52.00,	'2024-03-14 23:36:51',	'2024-03-15 19:46:51',	NULL),
(4,	1,	5,	1,	5,	85.00,	78.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(5,	1,	7,	1,	5,	150.00,	100.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(6,	1,	9,	1,	5,	80.00,	80.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(7,	1,	11,	1,	5,	80.00,	75.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(8,	1,	13,	1,	5,	100.00,	90.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(10,	1,	15,	1,	5,	45.00,	40.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(11,	1,	16,	1,	5,	50.00,	48.00,	'2024-03-14 23:36:51',	'2024-03-15 20:12:33',	NULL),
(12,	1,	17,	1,	5,	80.00,	78.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(13,	1,	18,	1,	5,	150.00,	99.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(14,	1,	20,	1,	5,	180.00,	150.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(24,	2,	20,	1,	5,	180.00,	150.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL);

-- 2024-03-20 18:21:19
