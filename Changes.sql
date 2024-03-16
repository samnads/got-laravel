ALTER TABLE `brands`
ADD `thumbnail_image` varchar(255) COLLATE 'utf8mb4_general_ci' NULL AFTER `description`;
ALTER TABLE `brands`
ADD UNIQUE `thumbnail_image` (`thumbnail_image`);