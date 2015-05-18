CREATE TABLE users (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `email` VARCHAR(128) NOT NULL,
    `phone` VARCHAR(128) NOT NULL,
    `active` tinyint(1) default 1,
     PRIMARY KEY (`id`),
     KEY `id` (`id`),
     KEY `username` (`username`),
     KEY `email` (`email`)
);

CREATE TABLE `category`(
 `category_id` INT NOT NULL AUTO_INCREMENT ,
 `title` VARCHAR( 255 ) NOT NULL,
 `parent_id` INT NOT NULL default 0,
 `disabled` tinyint(1) default 0,
PRIMARY KEY (  `category_id` ) ,
KEY  `parent_id` (  `parent_id` ) ,
KEY  `disabled` (  `disabled` )
);

CREATE TABLE `product` (
 `product_id` int(11) NOT NULL AUTO_INCREMENT,
 `model` varchar(64) NOT NULL,
 `sku` varchar(150) NOT NULL, 
 `quantity` int(4) NOT NULL,
 `image` varchar(255) DEFAULT NULL,
 `price` decimal(15,4) NOT NULL DEFAULT '0.0000', 
 `status` tinyint(1) NOT NULL,
 `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `viewed` int(5) NOT NULL,
 PRIMARY KEY (`product_id`)
) ;

CREATE TABLE `order` (
 `order_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `comment` text NOT NULL,
 `order_status_id` int(11) NOT NULL,
 `ip` varchar(40) NOT NULL,
 `date` datetime NOT NULL,
 PRIMARY KEY (`order_id`),
 KEY `user_id`(`user_id`),
 KEY `order_status_id`(`order_status_id`)
);

CREATE TABLE `order_product` (
 `order_product_id` int(11) NOT NULL AUTO_INCREMENT,
 `order_id` int(11) NOT NULL,
 `product_id` int(11) NOT NULL,
 `quantity` int(4) NOT NULL,
 PRIMARY KEY (`order_product_id`),
 KEY `order_id` (`order_id`),
 KEY `product_id`(`product_id`)
) ;