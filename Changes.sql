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
---------------------------------------------------------- DONE