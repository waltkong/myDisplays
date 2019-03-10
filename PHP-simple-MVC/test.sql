CREATE DATABASE `fastmvc` CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use 'fastmvc';
CREATE TABLE `item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
