-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2020 at 01:29 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swadesh`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(96) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL,
  `email` varchar(96) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_items_id` int(10) NOT NULL,
  `cart_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_title` varchar(30) NOT NULL,
  `icon_url` varchar(50) NOT NULL,
  `cat_desc` text,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login_access` tinyint(1) NOT NULL DEFAULT '1',
  `verify_key` text,
  `isVerified` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_contact`
--

CREATE TABLE `customer_contact` (
  `address_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `address_line_1` varchar(50) NOT NULL,
  `address_line_2` varchar(50) NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `pin` bigint(6) NOT NULL,
  `contact_number` bigint(10) NOT NULL,
  `alternative_contact_number` bigint(10) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(10) NOT NULL,
  `icon_title` varchar(20) NOT NULL,
  `icon_url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(12) NOT NULL,
  `item_title` varchar(50) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT '1',
  `cat_id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `item_image` varchar(100) NOT NULL DEFAULT 'img/items/noimage.jpg',
  `item_price` double(6,2) NOT NULL,
  `item_limit` bigint(5) NOT NULL DEFAULT '10',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_info`
--

CREATE TABLE `login_info` (
  `email` varchar(96) NOT NULL,
  `password` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_user_ip`
--

CREATE TABLE `login_user_ip` (
  `id` int(10) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` text NOT NULL,
  `user_agent` text NOT NULL,
  `page_accessed` text,
  `date_accessed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `op_id` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders_received`
--

CREATE TABLE `orders_received` (
  `order_id` bigint(20) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `amount` double(6,2) NOT NULL,
  `order_status` text NOT NULL,
  `order_date` datetime NOT NULL,
  `order_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_type` text NOT NULL,
  `address_id` int(10) NOT NULL,
  `cust_instructions` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_payment`
--

CREATE TABLE `order_payment` (
  `order_payment_id` int(10) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `txnid` varchar(100) NOT NULL,
  `txnstatus` varchar(15) NOT NULL,
  `banktxnid` varchar(110) NOT NULL,
  `bankname` varchar(30) NOT NULL,
  `checksumhash` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pincodes`
--

CREATE TABLE `pincodes` (
  `pin_codes` bigint(6) NOT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(96) NOT NULL,
  `login_access` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `sub_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `sub_cat_title` varchar(30) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `ADMIN_EMAIL_FK` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `email` (`email`,`session_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_items_id`),
  ADD UNIQUE KEY `cart_id` (`cart_id`,`item_id`),
  ADD KEY `CART_ITEMS_ITEMID_FK` (`item_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`) USING BTREE,
  ADD UNIQUE KEY `cat_title` (`cat_title`),
  ADD KEY `CAT_ICON_URL_FK` (`icon_url`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `CUST_EMAIL_FK` (`email`);

--
-- Indexes for table `customer_contact`
--
ALTER TABLE `customer_contact`
  ADD PRIMARY KEY (`address_id`),
  ADD UNIQUE KEY `contact_number` (`contact_number`),
  ADD KEY `CUST_CONTACT_FK` (`customer_id`);

--
-- Indexes for table `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `icon_url` (`icon_url`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `ITEM_CATID_FK` (`cat_id`),
  ADD KEY `ITEM_SUB_CATID_FK` (`sub_cat_id`);

--
-- Indexes for table `login_info`
--
ALTER TABLE `login_info`
  ADD PRIMARY KEY (`email`) USING BTREE;

--
-- Indexes for table `login_user_ip`
--
ALTER TABLE `login_user_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`op_id`),
  ADD KEY `product_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders_received`
--
ALTER TABLE `orders_received`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `ORD_REC_CUSTID_FK` (`customer_id`);

--
-- Indexes for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD PRIMARY KEY (`order_payment_id`,`checksumhash`,`txnid`) USING BTREE,
  ADD KEY `ORD_PAY_ORDID_FK` (`order_id`);

--
-- Indexes for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD PRIMARY KEY (`pin_codes`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `STAFF_EMAIL_FK` (`email`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`sub_cat_id`) USING BTREE,
  ADD UNIQUE KEY `sub_cat_title` (`sub_cat_title`,`cat_id`) USING BTREE,
  ADD KEY `SUBCAT_PK` (`cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_items_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_contact`
--
ALTER TABLE `customer_contact`
  MODIFY `address_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_user_ip`
--
ALTER TABLE `login_user_ip`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_received`
--
ALTER TABLE `orders_received`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payment`
--
ALTER TABLE `order_payment`
  MODIFY `order_payment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `sub_cat_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `ADMIN_EMAIL_FK` FOREIGN KEY (`email`) REFERENCES `login_info` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `CART_EMAIL_FK` FOREIGN KEY (`email`) REFERENCES `customers` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `CART_ITEMS_CARTID_FK` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CART_ITEMS_ITEMID_FK` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `CAT_ICON_URL_FK` FOREIGN KEY (`icon_url`) REFERENCES `icons` (`icon_url`) ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `CUST_EMAIL_FK` FOREIGN KEY (`email`) REFERENCES `login_info` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_contact`
--
ALTER TABLE `customer_contact`
  ADD CONSTRAINT `CUST_CONTACT_FK` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `ITEM_CATID_FK` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`),
  ADD CONSTRAINT `ITEM_SUB_CATID_FK` FOREIGN KEY (`sub_cat_id`) REFERENCES `subcategories` (`sub_cat_id`);

--
-- Constraints for table `login_user_ip`
--
ALTER TABLE `login_user_ip`
  ADD CONSTRAINT `USERIP_EMAIL_FK` FOREIGN KEY (`email`) REFERENCES `login_info` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD CONSTRAINT `ORD_PROD_ITEMID_FK` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ORD_PROD_ORDID_FK` FOREIGN KEY (`order_id`) REFERENCES `orders_received` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_received`
--
ALTER TABLE `orders_received`
  ADD CONSTRAINT `ORD_REC_ADDRID_FK` FOREIGN KEY (`address_id`) REFERENCES `customer_contact` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ORD_REC_CUSTID_FK` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD CONSTRAINT `ORD_PAY_ORDID_FK` FOREIGN KEY (`order_id`) REFERENCES `orders_received` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `STAFF_EMAIL_FK` FOREIGN KEY (`email`) REFERENCES `login_info` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `SUBCAT_PK` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
