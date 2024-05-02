ALTER TABLE `brands`
ADD `thumbnail_image` varchar(255) COLLATE 'utf8mb4_general_ci' NULL AFTER `description`;
----------------------------------------------------------
ALTER TABLE `brands`
ADD UNIQUE `thumbnail_image` (`thumbnail_image`);
----------------------------------------------------------
ALTER TABLE `vendors`
CHANGE `owner_name` `owner_name` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `vendor_name`;
----------------------------------------------------------
ALTER TABLE `vendors`
CHANGE `district_id` `district_id` bigint(20) unsigned NULL AFTER `mobile_number`,
CHANGE `location_id` `location_id` bigint(20) NULL AFTER `district_id`;
----------------------------------------------------------
ALTER TABLE `locations`
ADD FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`);
ALTER TABLE `vendors`
ADD `mobile_number_cc` varchar(30) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '+91' AFTER `pan_number`;
----------------------------------------------------------
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
----------------------------------------------------------
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
----------------------------------------------------------
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
----------------------------------------------------------
ALTER TABLE `vendors`
DROP FOREIGN KEY `vendors_ibfk_2`
----------------------------------------------------------
ALTER TABLE `customers`
ADD `selected_address_id` bigint(20) unsigned NULL AFTER `default_address_id`,
ADD FOREIGN KEY (`selected_address_id`) REFERENCES `customer_addresses` (`id`);

ALTER TABLE `products`
ADD `maximum_retail_price` decimal(10,2) NOT NULL DEFAULT '0' AFTER `description`;
---------------------------------------------------------- DONE
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
----------------------------------------------------------
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
---------------------------------------------------------- DONE
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

ALTER TABLE `orders`
ADD `order_status_id` bigint(20) unsigned NOT NULL DEFAULT '1' AFTER `address_id`,
ADD FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`);

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
---------------------------------------------------------- DONE
ALTER TABLE `vendors`
ADD `home_delivery_status_id` tinyint NOT NULL DEFAULT '1' AFTER `blocked_at`;

ALTER TABLE `vendors`
CHANGE `password` `password` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `email_verified_at`,
CHANGE `username` `username` varchar(155) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `password`,
ADD `min_order_value` decimal(10,2) unsigned NOT NULL DEFAULT '100' AFTER `home_delivery_status_id`,
ADD `min_order_weight` int(11) unsigned NOT NULL DEFAULT '1000' AFTER `min_order_value`;