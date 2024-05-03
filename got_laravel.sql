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
(1,	'Apple',	'rtrtrt',	'8xLWcVCdB69E1x6cwTQja98hQ8sgmsPuv14U2h0C.png',	1,	'2024-03-12 22:40:46',	'2024-04-27 18:57:38',	NULL),
(2,	'Pepsico',	'hj',	'NdfFgniogVuh8sr38KTpFMQ1wozW8lRrsVIeYw6b.png',	1,	'2024-03-12 22:40:46',	'2024-04-27 18:59:36',	NULL),
(8,	'tt',	'g',	'0uY49oKnP2lxiQXcJNzpupJahBmu8mHa6hyH7C2L.png',	0,	'2024-03-16 17:44:46',	'2024-04-27 18:59:39',	NULL),
(9,	'ghg',	'ghgh',	'OBM42MqGmPcrO24mWC1JgBMYoWWbvxppLJ0JKNFH.png',	0,	'2024-03-16 17:48:02',	'2024-04-27 18:59:38',	NULL),
(14,	'Hello',	'f',	'QaWU4kLbZ8hSlibtGDpevzXqOanDFltTnFjCb8WU.jpg',	0,	'2024-03-16 17:52:26',	'2024-04-27 19:09:51',	NULL),
(15,	'df',	'fdf',	'sjAyOCDm40aML0urp8dNmu3CcIQR2WVb5TvxcJpC.jpg',	0,	'2024-04-27 19:13:04',	'2024-04-27 19:15:13',	NULL),
(16,	'sds',	'dsd',	'A6t5tdThTh0NPWaGFp6zMTrwYkmgpO6Ee7ygnWc1.jpg',	0,	'2024-04-27 19:13:10',	'2024-04-27 19:13:10',	NULL),
(17,	'er',	'erer',	'7A6GhsoeOYaeDCWILe4YsLvlw9najBkQrpDHy338.jpg',	0,	'2024-04-27 19:13:15',	'2024-04-27 19:15:08',	NULL),
(18,	'56564',	'545',	'NpwmQx5NQsbuibsVabL7SoTx0GJdeQBeJ7yfYnnH.jpg',	0,	'2024-04-27 19:13:40',	'2024-04-27 19:14:19',	'2024-04-27 19:14:19'),
(19,	'yt',	'yty',	'yfElMZ5IqmEeL2mm44Rs0ZEh3xc7DLLiDQWwXrzC.jpg',	0,	'2024-04-27 19:14:01',	'2024-04-27 19:14:01',	NULL);

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
(10,	7,	10,	2.00,	'2024-04-18 00:37:58',	'2024-04-20 19:29:59',	'2024-04-20 19:29:59'),
(11,	7,	1,	1.00,	'2024-04-20 19:28:43',	'2024-04-22 18:18:07',	'2024-04-22 18:18:07'),
(12,	7,	4,	3.00,	'2024-04-20 19:28:50',	'2024-04-20 19:29:59',	'2024-04-20 19:29:59'),
(13,	7,	8,	1.00,	'2024-04-20 19:28:56',	'2024-04-20 19:51:43',	'2024-04-20 19:51:43');

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
  `selected_address_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_number_1_cc_mobile_number_1` (`mobile_number_1_cc`,`mobile_number_1`),
  KEY `default_address_id` (`default_address_id`),
  KEY `selected_address_id` (`selected_address_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`default_address_id`) REFERENCES `customer_addresses` (`id`),
  CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`selected_address_id`) REFERENCES `customer_addresses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customers` (`id`, `name`, `email`, `mobile_number_1_cc`, `mobile_number_1`, `mobile_number_1_otp`, `mobile_number_1_otp_expired_at`, `mobile_number_1_verified_at`, `password`, `token`, `device_type`, `push_token`, `default_address_id`, `selected_address_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7,	'CloudVeins Test',	'hr@example.com',	'+91',	'9745451448',	NULL,	'2024-04-29 18:22:37',	NULL,	NULL,	'$2y$12$uVKPajf.E33y5yRj.wpcqu1xUHV4UbjEf.WrO0MgQPHpqf5d2LkFq',	NULL,	NULL,	49,	49,	'2024-03-10 12:55:24',	'2024-04-29 18:22:00',	NULL),
(8,	'kannsn',	'kannansk172@gmail.com',	'+91',	'9188778069',	NULL,	'2024-03-15 18:09:11',	NULL,	NULL,	'$2y$12$IKyZ1Daao3ZL9TSZXpqlQugZcG7D374pdzfRXZseKQ3ecENXSlCLC',	NULL,	NULL,	NULL,	NULL,	'2024-03-15 16:07:05',	'2024-03-15 18:32:33',	NULL),
(9,	'venu',	'venu@gmail.com',	'+91',	'9154564646',	NULL,	'2024-03-15 16:27:38',	NULL,	NULL,	'$2y$12$HpKa807PL/7kXH8UoCK35uJc35DPPQ1NPKkx66HEgwIlsemF2mBvG',	NULL,	NULL,	NULL,	NULL,	'2024-03-15 16:27:28',	'2024-03-15 16:27:54',	NULL);

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
(43,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 15:42:25',	'2024-03-10 15:42:25',	NULL),
(49,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 16:26:51',	'2024-03-10 16:26:51',	NULL),
(50,	7,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-03-10 17:50:38',	'2024-03-10 17:50:38',	NULL);

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
(9,	3,	'Kodagu',	1,	'2024-03-09 17:04:06',	'2024-03-09 17:04:06',	NULL),
(10,	1,	'sdsd',	0,	'2024-04-28 08:39:26',	'2024-04-28 08:39:26',	NULL),
(11,	1,	'ooo',	0,	'2024-04-28 09:02:25',	'2024-04-28 09:02:25',	NULL),
(12,	1,	'dsd',	0,	'2024-04-28 09:05:49',	'2024-04-28 09:05:49',	NULL),
(13,	10,	'a',	0,	'2024-04-28 09:07:30',	'2024-04-28 09:07:30',	NULL);

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
(1,	1,	'Neyyattinkara',	'2024-03-11 23:34:05',	'2024-03-11 23:34:05',	NULL),
(2,	1,	'Kattakada',	'2024-03-21 17:50:28',	'2024-03-21 17:50:28',	NULL),
(3,	1,	'Parassala',	'2024-03-21 17:50:44',	'2024-03-21 17:50:44',	NULL),
(4,	1,	'Balaramapuram',	'2024-03-21 17:51:01',	'2024-03-21 17:51:01',	NULL),
(5,	4,	'Test',	'2024-03-21 18:09:43',	'2024-03-21 18:29:40',	NULL),
(6,	1,	'TTT (Sub Area)',	'2024-03-21 18:31:10',	'2024-03-21 18:31:30',	NULL),
(7,	1,	'tsdsd',	'2024-04-28 08:21:55',	'2024-04-28 08:21:55',	NULL),
(8,	1,	'asas',	'2024-04-28 08:23:09',	'2024-04-28 08:23:09',	NULL),
(9,	1,	'dfdf',	'2024-04-28 08:23:39',	'2024-04-28 08:23:39',	NULL),
(10,	1,	'gfg',	'2024-04-28 08:24:30',	'2024-04-28 08:24:30',	NULL),
(11,	1,	'gfg',	'2024-04-28 08:24:50',	'2024-04-28 08:24:50',	NULL),
(12,	1,	'uuu',	'2024-04-28 08:25:12',	'2024-04-28 08:25:12',	NULL),
(13,	1,	'gffga',	'2024-04-28 08:25:46',	'2024-04-28 08:25:46',	NULL),
(14,	1,	'kk',	'2024-04-28 08:25:58',	'2024-04-28 08:25:58',	NULL),
(15,	1,	'rt',	'2024-04-28 08:28:51',	'2024-04-28 08:28:51',	NULL),
(16,	1,	'fdffd',	'2024-04-28 08:29:41',	'2024-04-28 08:29:41',	NULL),
(17,	4,	'Marthandam',	'2024-04-28 08:43:09',	'2024-04-28 08:43:09',	NULL),
(18,	13,	'f',	'2024-04-28 09:07:33',	'2024-04-28 09:07:33',	NULL),
(19,	5,	'rt',	'2024-04-28 09:27:22',	'2024-04-28 09:27:22',	NULL),
(20,	2,	's',	'2024-04-28 09:34:07',	'2024-04-28 09:34:07',	NULL);

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
  `order_status_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `total_payable` decimal(10,2) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_reference` (`order_reference`),
  KEY `customer_id` (`customer_id`),
  KEY `address_id` (`address_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `order_status_id` (`order_status_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `customer_addresses` (`id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`),
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`id`, `order_reference`, `customer_id`, `vendor_id`, `address_id`, `order_status_id`, `total_payable`, `created_at`, `updated_at`, `deleted_at`) VALUES
(40,	'GOT-OR-LOCAL-000040',	7,	1,	43,	1,	469.00,	'2024-04-20 19:29:59',	'2024-04-20 19:29:59',	NULL),
(41,	'GOT-OR-LOCAL-000041',	7,	1,	43,	2,	90.00,	'2024-04-20 19:51:43',	'2024-04-20 19:51:43',	NULL),
(42,	'GOT-OR-LOCAL-0000042',	7,	1,	49,	3,	55.00,	'2024-04-22 18:09:15',	'2024-04-22 18:09:15',	NULL),
(43,	'GOT-OR-LOCAL-0000043',	7,	1,	49,	4,	55.00,	'2024-04-22 18:09:25',	'2024-04-22 18:09:25',	NULL),
(44,	'GOT-OR-LOCAL-0000044',	7,	1,	49,	2,	55.00,	'2024-04-22 18:09:29',	'2024-04-30 21:12:42',	NULL),
(45,	'GOT-OR-LOCAL-0000045',	7,	1,	49,	5,	55.00,	'2024-04-22 18:09:35',	'2024-04-22 18:09:35',	NULL),
(46,	'GOT-OR-LOCAL-0000046',	7,	1,	49,	1,	55.00,	'2024-04-22 18:18:00',	'2024-04-22 18:18:00',	NULL),
(47,	'GOT-OR-LOCAL-0000047',	7,	1,	49,	1,	55.00,	'2024-04-22 18:18:03',	'2024-04-22 18:18:03',	NULL),
(48,	'GOT-OR-LOCAL-0000048',	7,	1,	49,	2,	55.00,	'2024-04-22 18:18:07',	'2024-05-02 19:42:12',	NULL);

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
(66,	40,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-20 19:29:59',	'2024-04-20 19:29:59',	NULL),
(67,	41,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-20 19:51:43',	'2024-04-20 19:51:43',	NULL),
(68,	42,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:09:15',	'2024-04-22 18:09:15',	NULL),
(69,	43,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:09:25',	'2024-04-22 18:09:25',	NULL),
(70,	44,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:09:29',	'2024-04-22 18:09:29',	NULL),
(71,	45,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:09:35',	'2024-04-22 18:09:35',	NULL),
(72,	46,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:18:00',	'2024-04-22 18:18:00',	NULL),
(73,	47,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:18:03',	'2024-04-22 18:18:03',	NULL),
(74,	48,	'trtrt',	'Test Address',	'245454545',	'4545454545',	'103',	'Cyber Zone',	NULL,	'Near 5th milestone',	NULL,	'8552564545',	1,	'2024-04-22 18:18:07',	'2024-04-22 18:18:07',	NULL);

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
(70,	40,	10,	45.00,	2.00,	90.00,	'2024-04-20 19:29:59',	'2024-04-20 19:29:59',	NULL),
(71,	40,	1,	55.00,	1.00,	55.00,	'2024-04-20 19:29:59',	'2024-04-20 19:29:59',	NULL),
(72,	40,	4,	78.00,	3.00,	234.00,	'2024-04-20 19:29:59',	'2024-04-20 19:29:59',	NULL),
(73,	40,	8,	90.00,	1.00,	90.00,	'2024-04-20 19:29:59',	'2024-04-20 19:29:59',	NULL),
(74,	41,	8,	90.00,	1.00,	90.00,	'2024-04-20 19:51:43',	'2024-04-20 19:51:43',	NULL),
(75,	42,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:09:15',	'2024-04-22 18:09:15',	NULL),
(76,	43,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:09:25',	'2024-04-22 18:09:25',	NULL),
(77,	44,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:09:29',	'2024-04-22 18:09:29',	NULL),
(78,	45,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:09:35',	'2024-04-22 18:09:35',	NULL),
(79,	46,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:18:00',	'2024-04-22 18:18:00',	NULL),
(80,	47,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:18:03',	'2024-04-22 18:18:03',	NULL),
(81,	48,	1,	55.00,	1.00,	55.00,	'2024-04-22 18:18:07',	'2024-04-22 18:18:07',	NULL);

DROP TABLE IF EXISTS `order_statuses`;
CREATE TABLE `order_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `label` varchar(100) NOT NULL,
  `labelled` varchar(100) NOT NULL,
  `bg_color` varchar(30) NOT NULL DEFAULT '#000',
  `text_color` varchar(30) NOT NULL DEFAULT '#fff',
  `css_class` varchar(50) DEFAULT NULL,
  `css_inline` varchar(50) DEFAULT NULL,
  `vendor` tinyint(1) NOT NULL,
  `progress` int(3) NOT NULL DEFAULT 1,
  `comment` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_statuses` (`id`, `code`, `label`, `labelled`, `bg_color`, `text_color`, `css_class`, `css_inline`, `vendor`, `progress`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'created',	'Pending',	'Pending',	'#34a6ff',	'#ffffff',	NULL,	NULL,	0,	25,	'For new order, this is default for new order',	'2024-04-22 23:26:00',	'2024-04-22 23:26:00',	NULL),
(2,	'confirmed',	'Accept',	'Accepted',	'#544ef3',	'#ffffff',	NULL,	NULL,	1,	75,	'Ooder is accepted by vendor',	'2024-04-22 23:26:00',	'2024-04-22 23:26:00',	NULL),
(3,	'rejected',	'Reject',	'Rejected',	'#F34E4E',	'#ffffff',	NULL,	NULL,	1,	100,	'Oder is rejected by vendor',	'2024-04-22 23:26:00',	'2024-04-22 23:26:00',	NULL),
(4,	'delayed',	'Delay',	'Delayed',	'#f3d94e',	'#020000',	NULL,	NULL,	1,	50,	'Oder is delayed',	'2024-04-22 23:26:00',	'2024-04-22 23:26:00',	NULL),
(5,	'completed',	'Complete',	'Completed',	'#1fb52f',	'#ffffff',	NULL,	NULL,	1,	100,	'Oder is completed',	'2024-04-22 23:26:00',	'2024-04-22 23:26:00',	NULL);

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
  `parent_product_id` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(155) DEFAULT NULL,
  `item_size` decimal(10,2) NOT NULL,
  `unit_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `maximum_retail_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `thumbnail_image` varchar(155) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `thumbnail_image` (`thumbnail_image`),
  KEY `brand_id` (`brand_id`),
  KEY `unit_id` (`unit_id`),
  KEY `parent_product_id` (`parent_product_id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `products_ibfk_4` FOREIGN KEY (`parent_product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `parent_product_id`, `code`, `item_size`, `unit_id`, `brand_id`, `name`, `description`, `maximum_retail_price`, `thumbnail_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	'FFDF445',	50.00,	2,	NULL,	'Chilly Powder',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-16 02:52:23',	NULL),
(2,	NULL,	'FFSDF4',	1.00,	3,	NULL,	'Salt',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:48',	NULL),
(4,	NULL,	'4535EW',	100.00,	2,	NULL,	'Turmeric Powder',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:41',	NULL),
(5,	NULL,	'COL3343',	75.00,	2,	NULL,	'Colgate',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:40',	NULL),
(7,	NULL,	'5345BJ',	1.00,	6,	NULL,	'Band Aid',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:39',	NULL),
(9,	NULL,	'53543',	1.00,	3,	NULL,	'Tomato',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-15 16:49:38',	NULL),
(11,	NULL,	'DFP244',	500.00,	2,	NULL,	'Ginger',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(13,	NULL,	'CAR45343',	250.00,	2,	NULL,	'Carrot',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(14,	NULL,	'FDFSFSF',	600.00,	4,	NULL,	'Pepsi',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(15,	NULL,	'MFD64',	600.00,	4,	NULL,	'Mirinda',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(16,	NULL,	'7UPDFSFSdf',	600.00,	4,	NULL,	'7 Up',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(17,	NULL,	'63535435',	1.00,	5,	NULL,	'7 Up',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-04-28 17:38:28',	NULL),
(18,	NULL,	'45465464',	1.00,	5,	NULL,	'7 Up',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.	',	0.00,	NULL,	'2024-03-14 23:18:15',	'2024-03-14 23:18:15',	NULL),
(20,	NULL,	'45634564',	5.00,	3,	NULL,	'BRAND1 - 5 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	0.00,	'm1C2wU49Pgcm9v2owf1UkRdkG2QWYcpjSCy2eq66.png',	'2024-03-14 23:18:15',	'2024-04-28 17:37:21',	NULL),
(21,	NULL,	'45454',	10.00,	3,	NULL,	'BRAND1 - 10 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	0.00,	'7RwxPhqT5ooZxeHz7h5LaU9TKoHpkv1IvZGFTbwR.jpg',	'2024-03-14 23:18:15',	'2024-04-28 17:38:20',	NULL),
(22,	NULL,	'466664F',	10.00,	3,	NULL,	'BRAND2 - 10 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	0.00,	'4o6wZVIsTOgjkaevPmZOaLHFfMegTPtCGfNx5KXM.png',	'2024-03-14 23:18:15',	'2024-04-28 17:38:17',	NULL),
(23,	NULL,	'NBJN454',	5.00,	3,	NULL,	'BRAND2 - 5 Kg Kit',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	0.00,	'jhJPFV5v5bKeOxgiE1RwwkiATqOL6hNkUhhUFUn2.png',	'2024-03-14 23:18:15',	'2024-03-16 18:33:08',	NULL),
(26,	NULL,	'DF45GF76',	350.00,	2,	NULL,	'Ponds Powder',	'Ponds.........',	0.00,	'HnG3BJ9imhtQKfVwofW25EGFCj7M1Hx2tOty4s32.jpg',	'2024-03-16 03:10:58',	'2024-04-28 17:39:18',	NULL),
(27,	NULL,	'UUU',	55.00,	5,	8,	'TTT',	'dff',	0.00,	'GDjwkltBoTihhU7hD6QWkYfLOBiynC3V2QSBvHnh.png',	'2024-03-22 18:32:12',	'2024-04-28 17:39:33',	NULL),
(28,	NULL,	'f554545',	100.00,	2,	2,	'test brand',	'ere',	0.00,	'kQr82MjukBv8Dsl8YMYt1RaWKPYpkGAUX8l2sSxZ.png',	'2024-04-16 16:39:01',	'2024-04-16 16:45:12',	NULL),
(29,	NULL,	'dfgfg',	101.00,	2,	14,	'RRR',	'fdf',	15.00,	'MyuozMOqCFxAztMAtxCZ8uM7QQM3EJyfUEOhdk6r.jpg',	'2024-04-16 17:00:34',	'2024-04-28 17:39:46',	NULL),
(30,	NULL,	'fsf',	434.00,	1,	2,	'tyry',	'dfdf',	53.00,	NULL,	'2024-04-28 18:03:36',	'2024-04-28 18:03:36',	NULL),
(31,	NULL,	'yty',	12.00,	6,	1,	'Fish',	'tyty',	12.00,	NULL,	'2024-04-28 18:04:32',	'2024-04-28 18:04:32',	NULL),
(32,	NULL,	'dssd',	2.00,	2,	1,	'dsd',	'dsd',	453.05,	'52kFyPjd3gLJwJ3xsaZMV3uvVJPINnVkaKGCtjwH.jpg',	'2024-04-28 18:05:06',	'2024-04-28 20:58:07',	NULL),
(33,	NULL,	'fdfd',	12.00,	1,	1,	'df',	'dfdf',	12.00,	NULL,	'2024-04-29 17:18:37',	'2024-04-29 17:18:37',	NULL),
(34,	NULL,	'fsfdfdf',	34.00,	1,	NULL,	'sdsd',	'fdf',	43.00,	NULL,	'2024-04-29 17:19:17',	'2024-04-29 17:19:31',	NULL),
(35,	NULL,	'deddf',	43.00,	1,	1,	'fgfg',	'dfdf',	3.00,	NULL,	'2024-04-29 17:23:48',	'2024-04-29 17:23:48',	NULL),
(36,	NULL,	'fdf',	34.00,	1,	1,	'sds',	'dfdfdf',	33.00,	NULL,	'2024-04-29 17:25:10',	'2024-04-29 17:25:10',	NULL),
(37,	NULL,	'fdffdf',	545.00,	3,	1,	'dfdf',	'dfdfdf',	54.00,	NULL,	'2024-04-29 17:25:28',	'2024-04-29 17:25:28',	NULL),
(38,	NULL,	'sdxccxc',	323.00,	1,	1,	'dff',	'cxc',	23.00,	NULL,	'2024-04-29 17:41:56',	'2024-04-29 19:25:15',	NULL),
(39,	NULL,	'sf',	2.00,	1,	2,	'trtr',	'dfsdf',	34.00,	'CPLsw9XpO6VVXBYi2NgD63ApfJtYjWczcXZc1LFL.jpg',	'2024-04-30 17:38:23',	'2024-04-30 17:38:23',	NULL),
(40,	NULL,	'xx',	5.00,	1,	1,	'fgf',	'ddff',	45.00,	'UsL4lSOobht8BIUDkZjbp39Vric5dHz0BpODPQb9.jpg',	'2024-04-30 17:53:19',	'2024-04-30 17:53:19',	NULL),
(41,	NULL,	'dfdf',	4.00,	2,	2,	'fdsd',	'dfdf',	3.00,	'C3Rexev41GGNavvbBbDUcJZpaDVYSHWMLkaNZ0u9.jpg',	'2024-04-30 17:55:14',	'2024-04-30 17:56:42',	NULL),
(42,	NULL,	'4',	43.00,	1,	1,	'd',	'dfdf',	43.00,	'42-sWeVPREggvrLMitTkNsHbRsl4mWjy1ji63ITMKtm.jpg',	'2024-04-30 17:56:15',	'2024-04-30 18:34:52',	'2024-04-30 18:33:44'),
(43,	NULL,	'gfg',	1.00,	3,	1,	'Sugar',	'qw',	12.00,	'43-WXSF8HL3eLJgOCtEyMweab5nK55sdtFgedF68trM.jpg',	'2024-04-30 19:21:00',	'2024-04-30 19:21:00',	NULL),
(44,	NULL,	'fsd',	2.00,	3,	1,	'Sugar',	'df',	50.00,	'44-dKKp3hseRwyXhPyA6u9UebEXruNmwagctFoFMpgk.jpg',	'2024-04-30 19:21:24',	'2024-04-30 19:21:24',	NULL);

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
(1,	NULL,	'Grocery',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'fZllvdNgmD4yUXHLZ3wTULi7sGY1TIzI0Bj70OIH.jpg',	'2024-03-14 17:44:23',	'2024-04-27 11:51:32',	NULL),
(2,	NULL,	'Health Care',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'wyEYeQvnPZpdgLQXJQaX3VHpn8Umpero5SRwuOfy.jpg',	'2024-03-14 17:44:23',	'2024-04-26 13:17:03',	NULL),
(3,	NULL,	'Vegetables',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'GdIp1UNewSVKuIOVAAJiXZNUQlxmKAN6q5dp62VJ.webp',	'2024-03-14 17:44:23',	'2024-04-26 13:27:34',	NULL),
(4,	NULL,	'Soft Drinks',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'10QpkgFHa64bQW9mUVIbT1OMblj78yuGRUTDT4GU.jpg',	'2024-03-14 17:44:23',	'2024-04-27 11:53:56',	NULL),
(5,	NULL,	'Rice Kits',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',	'9qxy2G5LHCCTVjWaui5kOePIMAYPdiiLPSZBEWiH.jpg',	'2024-03-14 17:44:23',	'2024-04-27 11:53:24',	'2024-04-27 11:53:24'),
(17,	NULL,	'Cosmetics',	'Test',	'eqafyUTPFLFg7g0TxGlBwazrAKYmWWtYWmy6kfKe.jpg',	'2024-03-15 21:38:28',	'2024-04-27 11:53:53',	NULL),
(18,	NULL,	'ry',	't',	NULL,	'2024-04-27 12:29:15',	'2024-04-27 12:29:15',	NULL),
(19,	NULL,	'rrtrtrrrrrrrrr',	'rrrrrrrrrrrrrrrrrrrrrr',	NULL,	'2024-04-27 12:29:40',	'2024-04-27 12:29:40',	NULL),
(20,	NULL,	'fg',	'dfa',	'eTdDH6JJNOodlRizjns7l0jfSpRfJiwHciry3wmC.jpg',	'2024-04-27 12:29:50',	'2024-04-27 13:00:41',	NULL),
(21,	NULL,	'erer',	'er',	'g6V5mbV5t6TOEl7HKW6ucmLLaPv0ZGcINYSJEE9w.jpg',	'2024-04-27 12:30:54',	'2024-04-27 13:00:35',	NULL),
(22,	NULL,	'ere',	're',	'deGkz1zO0zTmvAc4FnLXnvwlzQJZRuPPs3mODCBG.jpg',	'2024-04-27 12:32:06',	'2024-04-27 12:32:06',	NULL),
(23,	NULL,	'rtrt',	'rtrt',	'B9oIFokjr3G3iX3ZJUehY5FEULJBawjBLyECRzhk.png',	'2024-04-27 12:41:33',	'2024-04-27 13:00:50',	NULL),
(24,	NULL,	'rer',	'f',	'7Gdadgfs45uDl3tEj6xkw8xXNSb9IZQvgL3ZDeTE.jpg',	'2024-04-27 12:41:54',	'2024-04-27 12:56:41',	NULL),
(25,	NULL,	'sds',	'sdsd',	'JpOI4akXZLZyjMO1AlkJbMBP5xCFd5M5zcAWNkQk.jpg',	'2024-04-27 12:44:22',	'2024-04-27 12:52:44',	NULL),
(26,	NULL,	'uu',	'uyu',	'EnFi9Fc631M1niyTyx7VT78EDM8vNtEwv8JeAw1n.jpg',	'2024-04-27 13:01:03',	'2024-04-27 13:02:02',	'2024-04-27 13:02:02'),
(27,	NULL,	'yuy',	'uyuyu',	NULL,	'2024-04-27 13:01:08',	'2024-04-27 13:02:51',	NULL),
(28,	NULL,	'56',	'5656',	NULL,	'2024-04-27 13:04:19',	'2024-04-27 13:04:19',	NULL),
(29,	NULL,	'tyty',	'ty',	NULL,	'2024-04-27 13:08:18',	'2024-04-27 13:08:18',	NULL),
(30,	NULL,	'rt',	'rtrt',	NULL,	'2024-04-27 13:08:42',	'2024-04-27 13:08:42',	NULL),
(31,	NULL,	'fg',	'fgfg',	NULL,	'2024-04-27 13:28:00',	'2024-04-27 13:28:00',	NULL),
(32,	NULL,	'ty',	'tyty',	NULL,	'2024-04-27 13:42:43',	'2024-04-27 15:00:04',	NULL);

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
(17,	23,	5,	'2024-03-14 23:27:43',	'2024-03-14 23:27:43',	NULL),
(18,	26,	1,	'2024-03-16 03:10:58',	'2024-04-28 17:39:18',	NULL),
(20,	22,	1,	'2024-03-16 18:35:34',	'2024-03-16 18:35:34',	NULL),
(21,	21,	4,	'2024-03-16 18:36:59',	'2024-03-16 18:36:59',	NULL),
(22,	27,	25,	'2024-03-22 18:32:12',	'2024-04-28 17:39:33',	NULL),
(23,	28,	2,	'2024-04-16 16:39:01',	'2024-04-16 16:39:01',	NULL),
(24,	29,	2,	'2024-04-16 17:00:34',	'2024-04-28 17:39:04',	NULL),
(25,	30,	3,	'2024-04-28 18:03:36',	'2024-04-28 18:03:36',	NULL),
(26,	31,	2,	'2024-04-28 18:04:32',	'2024-04-28 18:04:32',	NULL),
(27,	32,	4,	'2024-04-28 18:05:06',	'2024-04-28 18:05:06',	NULL),
(28,	33,	3,	'2024-04-29 17:18:37',	'2024-04-29 17:18:37',	NULL),
(29,	34,	3,	'2024-04-29 17:19:17',	'2024-04-29 17:19:17',	NULL),
(30,	35,	3,	'2024-04-29 17:23:48',	'2024-04-29 17:23:48',	NULL),
(31,	36,	2,	'2024-04-29 17:25:10',	'2024-04-29 17:25:10',	NULL),
(32,	37,	3,	'2024-04-29 17:25:28',	'2024-04-29 17:25:28',	NULL),
(33,	38,	2,	'2024-04-29 17:41:56',	'2024-04-29 17:41:56',	NULL),
(34,	39,	22,	'2024-04-30 17:38:23',	'2024-04-30 17:38:23',	NULL),
(35,	40,	21,	'2024-04-30 17:53:19',	'2024-04-30 17:53:19',	NULL),
(36,	41,	4,	'2024-04-30 17:55:14',	'2024-04-30 17:55:14',	NULL),
(37,	42,	4,	'2024-04-30 17:56:15',	'2024-04-30 17:56:15',	NULL),
(38,	43,	1,	'2024-04-30 19:21:00',	'2024-04-30 19:21:00',	NULL),
(39,	44,	1,	'2024-04-30 19:21:24',	'2024-04-30 19:21:24',	NULL);

DROP TABLE IF EXISTS `product_requests`;
CREATE TABLE `product_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_request_reference` varchar(155) DEFAULT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL COMMENT 'Requested vendor',
  `product_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Product created based on this request',
  `code` varchar(155) DEFAULT NULL,
  `item_size` decimal(10,2) NOT NULL,
  `unit_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `product_category_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `maximum_retail_price` decimal(10,2) NOT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `thumbnail_image` varchar(155) DEFAULT NULL,
  `product_request_status_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `product_request_status_user_id` bigint(20) unsigned DEFAULT NULL,
  `product_request_status_changed_at` datetime DEFAULT NULL,
  `additional_information` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`),
  UNIQUE KEY `product_request_reference` (`product_request_reference`),
  KEY `unit_id` (`unit_id`),
  KEY `brand_id` (`brand_id`),
  KEY `approved_user_id` (`product_request_status_user_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `product_request_status_id` (`product_request_status_id`),
  KEY `product_category_id` (`product_category_id`),
  CONSTRAINT `product_requests_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `product_requests_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `product_requests_ibfk_4` FOREIGN KEY (`product_request_status_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `product_requests_ibfk_5` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_requests_ibfk_6` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`),
  CONSTRAINT `product_requests_ibfk_7` FOREIGN KEY (`product_request_status_id`) REFERENCES `product_request_statuses` (`id`),
  CONSTRAINT `product_requests_ibfk_8` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_requests` (`id`, `product_request_reference`, `vendor_id`, `product_id`, `code`, `item_size`, `unit_id`, `brand_id`, `product_category_id`, `name`, `description`, `maximum_retail_price`, `retail_price`, `thumbnail_image`, `product_request_status_id`, `product_request_status_user_id`, `product_request_status_changed_at`, `additional_information`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'FHFGHGF',	1,	NULL,	NULL,	3.00,	3,	8,	NULL,	'fdf',	NULL,	43.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 12:02:15',	'2024-04-21 12:02:15',	NULL),
(2,	'GFDGHG',	1,	NULL,	NULL,	3.00,	3,	9,	NULL,	'rer',	NULL,	343.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 12:03:34',	'2024-04-21 12:03:34',	NULL),
(3,	'GFG',	1,	NULL,	NULL,	3.00,	2,	8,	NULL,	'sdsd',	NULL,	3.00,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2024-04-21 12:25:21',	'2024-04-21 12:25:21',	NULL),
(4,	'FGDGDG',	1,	NULL,	NULL,	2.00,	3,	9,	NULL,	'wewe',	NULL,	3.00,	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2024-04-21 12:25:57',	'2024-04-21 12:25:57',	NULL),
(5,	'RTE5T',	1,	NULL,	NULL,	3.00,	5,	8,	NULL,	'5455',	NULL,	55.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 12:26:25',	'2024-04-21 12:26:25',	NULL),
(6,	'T54545',	1,	NULL,	NULL,	3.00,	3,	8,	NULL,	'trtrt',	NULL,	4.00,	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2024-04-21 13:48:55',	'2024-04-21 13:48:55',	NULL),
(7,	'TRTRT',	1,	NULL,	'ere',	2.00,	4,	8,	NULL,	'rrtrt',	NULL,	55.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 13:49:39',	'2024-04-21 13:49:39',	NULL),
(8,	'545DGDGFDG',	1,	NULL,	't',	3.00,	4,	8,	NULL,	'dfd',	NULL,	3434.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 13:50:37',	'2024-04-21 13:50:37',	NULL),
(9,	'DFGFGFDG',	1,	NULL,	NULL,	4.00,	5,	8,	NULL,	'fdf',	NULL,	343.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 13:51:36',	'2024-04-21 13:51:36',	NULL),
(10,	'DFG',	1,	NULL,	'sd',	3.00,	3,	2,	NULL,	'sdsd',	NULL,	4343.00,	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'2024-04-21 13:52:20',	'2024-04-21 13:52:20',	NULL),
(11,	'FDGFD',	1,	NULL,	NULL,	3.00,	3,	9,	NULL,	'sdsd',	NULL,	3434.00,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	'2024-04-21 13:54:54',	'2024-04-21 13:54:54',	NULL),
(12,	'GDFGDFG',	1,	NULL,	NULL,	2.00,	3,	8,	NULL,	'dfdf',	NULL,	3434.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 13:55:36',	'2024-04-21 13:55:36',	NULL),
(13,	'FDGRTE',	1,	NULL,	NULL,	3.00,	2,	8,	NULL,	'sd',	NULL,	3434.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 13:55:53',	'2024-04-21 13:55:53',	NULL),
(14,	'FDGDFG',	1,	NULL,	NULL,	3.00,	4,	8,	NULL,	'gfg',	NULL,	343434.00,	NULL,	NULL,	4,	NULL,	NULL,	NULL,	'2024-04-21 13:56:41',	'2024-04-21 13:56:41',	NULL),
(15,	'GDGDF',	1,	NULL,	NULL,	3.00,	3,	NULL,	NULL,	'f',	NULL,	34.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 14:03:13',	'2024-04-21 14:03:13',	NULL),
(16,	'GRETET',	1,	NULL,	'SDSDS',	3.00,	4,	NULL,	NULL,	'dgdfg',	NULL,	3434.00,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 14:04:49',	'2024-04-21 14:04:49',	NULL),
(17,	'454545',	1,	NULL,	'fdsfdf',	3.00,	4,	8,	NULL,	'fsdzfd',	'zfzsfsd',	454545.00,	34.00,	NULL,	5,	NULL,	NULL,	'sdff  ree',	'2024-04-21 14:10:14',	'2024-04-21 14:10:14',	NULL),
(18,	'JSK3434',	1,	NULL,	NULL,	4.00,	3,	NULL,	2,	'fdf',	NULL,	34.00,	3.00,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 15:09:08',	'2024-04-21 15:09:08',	NULL),
(19,	'GOT-PR-LOCAL-19',	1,	NULL,	NULL,	3.00,	3,	2,	2,	'dfdfdf',	NULL,	43.00,	3.00,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 16:29:42',	'2024-04-21 16:29:42',	NULL),
(20,	'GOT-PR-LOCAL-000020',	1,	NULL,	'3',	3.00,	2,	8,	4,	'ere',	NULL,	534.00,	54.00,	NULL,	1,	NULL,	NULL,	NULL,	'2024-04-21 16:31:11',	'2024-04-21 16:31:11',	NULL);

DROP TABLE IF EXISTS `product_request_statuses`;
CREATE TABLE `product_request_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `label` varchar(100) NOT NULL,
  `bg_color` varchar(30) NOT NULL DEFAULT '#000',
  `text_color` varchar(30) NOT NULL DEFAULT '#fff',
  `css_class` varchar(50) DEFAULT NULL,
  `css_inline` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_request_statuses` (`id`, `code`, `label`, `bg_color`, `text_color`, `css_class`, `css_inline`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'requested',	'Requested',	'#f7f75c',	'#121212',	NULL,	NULL,	'2024-04-21 14:32:38',	'2024-04-21 14:32:38',	NULL),
(2,	'pending',	'Pending',	'#5ba9bb',	'#f7ebeb',	NULL,	NULL,	'2024-04-21 14:32:38',	'2024-04-21 14:32:38',	NULL),
(3,	'approved',	'Approved',	'#8af361',	'#190b0b',	NULL,	NULL,	'2024-04-21 14:32:38',	'2024-04-21 14:32:38',	NULL),
(4,	'rejected',	'Rejected',	'#e04747',	'#f5f3f3',	NULL,	NULL,	'2024-04-21 14:32:38',	'2024-04-21 14:32:38',	NULL),
(5,	'cancelled',	'Cancelled',	'#5f5757',	'#e5e1e1',	NULL,	NULL,	'2024-04-21 14:32:38',	'2024-04-21 14:32:38',	NULL);

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `variant_option_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_variant_option_id` (`product_id`,`variant_option_id`),
  KEY `variant_option_id` (`variant_option_id`),
  CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`variant_option_id`) REFERENCES `variant_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `review_levels`;
CREATE TABLE `review_levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `review_levels` (`id`, `name`, `level`) VALUES
(1,	'Very Poor',	1),
(2,	'Poor',	2),
(3,	'Average',	3),
(4,	'Good',	4),
(5,	'Excellent',	5);

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
(3,	'Karnataka',	1,	'2024-03-09 16:58:31',	'2024-03-09 16:58:31',	NULL),
(4,	'Hariyana',	0,	'2024-04-28 09:04:41',	'2024-04-28 09:04:41',	NULL),
(5,	'Goa',	0,	'2024-04-28 09:05:30',	'2024-04-28 09:05:30',	NULL),
(6,	'dsd',	0,	'2024-04-28 09:05:53',	'2024-04-28 09:05:53',	NULL),
(7,	'dsd',	0,	'2024-04-28 09:06:09',	'2024-04-28 09:06:09',	NULL),
(8,	'Madya Pradhesh',	0,	'2024-04-28 09:06:46',	'2024-04-28 09:06:46',	NULL),
(9,	'test',	0,	'2024-04-28 09:07:18',	'2024-04-28 09:07:18',	NULL),
(10,	'wewe',	0,	'2024-04-28 09:07:27',	'2024-04-28 09:07:27',	NULL);

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
(1,	'Admin',	'admin',	'admin@example.com',	'2024-03-07 10:49:50',	'$2y$12$SjmwFDIffWTH4X84sgvv/.VFWHJdaCOH9i0P3s/mx.p8cqWSRHvIm',	'giVObMfx8hdheb9eU6mjlwd8sH8GAyiR3U66hoQd5AitcJPw3woTaell0dZD',	'2024-03-07 10:49:50',	'2024-03-07 10:49:50',	NULL);

DROP TABLE IF EXISTS `variants`;
CREATE TABLE `variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `variant_name` varchar(155) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variant_name` (`variant_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `variants` (`id`, `variant_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Size',	'2024-05-03 23:58:45',	'2024-05-03 23:58:45',	NULL),
(2,	'Flavour',	'2024-05-04 00:58:39',	'2024-05-04 00:58:39',	NULL);

DROP TABLE IF EXISTS `variant_options`;
CREATE TABLE `variant_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `variant_id` bigint(20) unsigned NOT NULL,
  `variant_option_name` varchar(155) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variant_id_variant_option_name` (`variant_id`,`variant_option_name`),
  CONSTRAINT `variant_options_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `variant_options` (`id`, `variant_id`, `variant_option_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'1 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(2,	1,	'2 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(3,	1,	'3 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(4,	1,	'4 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(5,	1,	'5 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(6,	1,	'6 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(7,	1,	'7 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(8,	1,	'8 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(9,	1,	'9 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(10,	1,	'10 kg',	'2024-05-04 01:00:18',	'2024-05-04 01:00:18',	NULL),
(11,	1,	'10 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(12,	1,	'25 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(13,	1,	'50 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(14,	1,	'100 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(15,	1,	'150 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(16,	1,	'175 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(17,	1,	'200 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(18,	1,	'250 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(19,	1,	'275 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(20,	1,	'300 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(21,	1,	'400 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(22,	1,	'500 g',	'2024-05-04 01:01:53',	'2024-05-04 01:01:53',	NULL),
(23,	2,	'Chocolate',	'2024-05-04 01:03:30',	'2024-05-04 01:03:30',	NULL),
(24,	2,	'Strawberry',	'2024-05-04 01:03:30',	'2024-05-04 01:03:30',	NULL),
(25,	2,	'Pista',	'2024-05-04 01:03:30',	'2024-05-04 01:03:30',	NULL),
(26,	1,	'100 ml',	'2024-05-04 01:05:03',	'2024-05-04 01:05:03',	NULL),
(27,	1,	'200 ml',	'2024-05-04 01:05:03',	'2024-05-04 01:05:03',	NULL),
(28,	1,	'500 ml',	'2024-05-04 01:05:03',	'2024-05-04 01:05:03',	NULL),
(29,	1,	'650 ml',	'2024-05-04 01:05:03',	'2024-05-04 01:05:03',	NULL);

DROP TABLE IF EXISTS `variation_themes`;
CREATE TABLE `variation_themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `variation_theme_name` varchar(180) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variation_theme_name` (`variation_theme_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `variation_themes` (`id`, `variation_theme_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Size',	'2024-05-04 01:13:35',	'2024-05-04 01:13:35',	NULL);

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
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(155) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `blocked_at` datetime DEFAULT NULL,
  `home_delivery_status_id` tinyint(4) NOT NULL DEFAULT 1,
  `min_order_value` decimal(10,2) unsigned NOT NULL DEFAULT 100.00,
  `min_order_weight` int(11) unsigned NOT NULL DEFAULT 1000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_username_unique` (`username`),
  UNIQUE KEY `vendors_email_unique` (`email`),
  KEY `district_id` (`district_id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`),
  CONSTRAINT `vendors_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vendors` (`id`, `vendor_name`, `owner_name`, `gst_number`, `pan_number`, `mobile_number_cc`, `mobile_number`, `district_id`, `location_id`, `address`, `latitude`, `longitude`, `accuracy`, `shop_thumbnail`, `email`, `email_verified_at`, `password`, `username`, `remember_token`, `blocked_at`, `home_delivery_status_id`, `min_order_value`, `min_order_weight`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Vendor ABC',	'Owner 1',	'GST1',	'',	'+91',	'42452445',	1,	17,	'address1',	'455',	'3545',	NULL,	NULL,	'vendor@example.com',	NULL,	'$2y$12$U/Ec779muT2CnJDaCzm0Ku3zzUHQbLpbQZBO9BbclVo.Twz5Pb/SG',	'vendor',	'9rlreK814HTnFUwEWFUdKFODumg3N4u5Dg5OmIPX6vcdKWaPvkomAMNfWwtS',	NULL,	1,	199.00,	1,	'2024-03-11 18:04:08',	'2024-05-02 14:10:42',	NULL),
(2,	'Vendor XYZ',	'Owner 2',	'GST2',	'',	'+91',	'123456',	1,	5,	'address1',	'455',	'3545',	NULL,	NULL,	'vendor2@example.com',	NULL,	'$2y$12$fR9TPk/c5V3iBCWu1OWpNeisOi38XWW7fuGA4pI3xld3jGKyy4tQa',	'vendor2@example.com',	NULL,	NULL,	1,	100.00,	1,	'2024-03-11 18:04:08',	'2024-04-28 04:14:45',	NULL),
(35,	'Test',	'dffdf',	'434334',	NULL,	'+91',	'343434',	NULL,	3,	'dsdsd',	'656',	'5656',	NULL,	NULL,	NULL,	NULL,	'$2y$12$IFC1D3s1YoUN8v81wHMJJ.TNiIDUU/0jKQ99RpoFellbDbu3Ev22m',	'samnads',	NULL,	NULL,	1,	100.00,	1,	'2024-03-21 14:01:45',	'2024-04-30 13:05:05',	'2024-04-30 13:05:05');

DROP TABLE IF EXISTS `vendor_delivery_persons`;
CREATE TABLE `vendor_delivery_persons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(155) NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_number_1_cc` varchar(10) NOT NULL DEFAULT '+91',
  `mobile_number_1` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `vendor_delivery_persons_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `vendor_delivery_persons` (`id`, `code`, `vendor_id`, `name`, `mobile_number_1_cc`, `mobile_number_1`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7,	'GOT-DP-LOCAL-0000007',	1,	'dfdf',	'+91',	'5454545455',	'2024-04-23 18:43:39',	'2024-04-23 18:43:39',	NULL),
(8,	'GOT-DP-LOCAL-0000008',	1,	'rrtrt',	'+91',	'5645453434',	'2024-04-23 18:44:31',	'2024-04-23 18:44:31',	NULL),
(9,	'GOT-DP-LOCAL-0000009',	1,	'dfd',	'+91',	'4535343434',	'2024-04-23 18:45:44',	'2024-04-23 18:45:44',	NULL),
(10,	'GOT-DP-LOCAL-0000010',	1,	'www',	'+91',	'4334343434',	'2024-04-23 18:45:59',	'2024-04-23 19:29:31',	NULL);

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
(1,	1,	1,	1,	1,	100.00,	50.00,	'2024-03-14 23:36:51',	'2024-04-30 18:39:40',	'2024-04-30 18:38:07'),
(2,	1,	2,	1,	5,	25.00,	22.00,	'2024-03-14 23:36:51',	'2024-04-25 17:56:56',	NULL),
(3,	1,	4,	1,	5,	55.00,	52.00,	'2024-03-14 23:36:51',	'2024-04-25 17:56:43',	NULL),
(4,	1,	5,	1,	5,	85.00,	78.00,	'2024-03-14 23:36:51',	'2024-04-19 18:17:08',	NULL),
(5,	1,	7,	1,	5,	150.00,	100.00,	'2024-03-14 23:36:51',	'2024-04-25 17:56:54',	NULL),
(6,	1,	9,	1,	5,	80.00,	80.00,	'2024-03-14 23:36:51',	'2024-04-25 17:56:47',	NULL),
(7,	1,	11,	1,	5,	80.00,	75.00,	'2024-03-14 23:36:51',	'2024-04-25 17:56:52',	NULL),
(8,	1,	13,	1,	5,	100.00,	90.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(10,	1,	15,	1,	5,	45.00,	45.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(11,	1,	16,	1,	5,	50.00,	48.00,	'2024-03-14 23:36:51',	'2024-04-25 17:56:50',	NULL),
(12,	1,	17,	1,	5,	80.00,	78.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(13,	1,	18,	1,	5,	150.00,	99.00,	'2024-03-14 23:36:51',	'2024-04-18 20:19:52',	NULL),
(14,	1,	20,	1,	5,	180.00,	150.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(24,	2,	20,	1,	5,	180.00,	150.00,	'2024-03-14 23:36:51',	'2024-03-14 23:36:51',	NULL),
(27,	1,	27,	1,	1,	50.00,	40.00,	'2024-04-21 08:04:45',	'2024-04-21 08:04:45',	NULL);

DROP TABLE IF EXISTS `vendor_reviews`;
CREATE TABLE `vendor_reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `review_level_id` bigint(20) unsigned NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `review_level_id` (`review_level_id`),
  CONSTRAINT `vendor_reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `vendor_reviews_ibfk_2` FOREIGN KEY (`review_level_id`) REFERENCES `review_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2024-05-03 20:28:38
