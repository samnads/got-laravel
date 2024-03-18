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