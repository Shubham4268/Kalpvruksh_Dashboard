-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 07:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1410inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(3) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile1` varchar(15) NOT NULL,
  `mobile2` varchar(15) NOT NULL,
  `password` char(60) NOT NULL,
  `role` char(5) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `last_seen` datetime NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `account_status` char(1) NOT NULL DEFAULT '1',
  `deleted` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `mobile1`, `mobile2`, `password`, `role`, `created_on`, `last_login`, `last_seen`, `last_edited`, `account_status`, `deleted`) VALUES
(1, 'Admin', 'Demo', 'demo@1410inc.xyz', '08021111111', '07032222222', '$2y$10$xv9I14OlR36kPCjlTv.wEOX/6Dl7VMuWCl4vCxAVWP1JwYIaw4J2C', 'Super', '2017-01-04 22:19:16', '2025-04-07 18:23:33', '2025-04-07 18:53:49', '2025-04-07 13:23:49', '1', '0'),
(2, 'Jaypal', 'Koli', 'jk@gmail.com', '08275474818', '08275474818', '$2y$10$gq26DHdyq8sxChUPtVLGP.qIsH7elZnv490SUw6kLu/PFMgT0/Aw2', 'Basic', '2025-03-20 11:47:08', '2025-04-07 11:19:39', '2025-04-07 17:04:06', '2025-04-07 11:34:06', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_description` varchar(400) DEFAULT NULL,
  `mnfId` int(11) DEFAULT NULL,
  `IsActive` tinyint(1) DEFAULT 1,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `date_added` datetime DEFAULT current_timestamp(),
  `last_edited` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `adminId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_description`, `mnfId`, `IsActive`, `IsDeleted`, `date_added`, `last_edited`, `adminId`) VALUES
(11, 'Electronics', 'Devices and gadgets', 3, 1, 0, '2025-04-07 00:34:02', '2025-04-06 19:04:02', 1),
(12, 'Groceries', 'Everyday food items', 4, 1, 0, '2025-04-07 00:34:02', '2025-04-06 19:04:02', 1),
(13, 'Stationery', 'Office and school supplies', 3, 1, 0, '2025-04-07 00:34:02', '2025-04-06 19:04:02', 1),
(14, 'Furniture', 'Home and office furniture', 3, 1, 0, '2025-04-07 00:34:02', '2025-04-06 19:04:02', 1),
(15, 'Clothing', 'Men and Women apparel', 4, 1, 0, '2025-04-07 00:34:02', '2025-04-06 19:04:02', 1),
(16, 'Abcd', 'Adcd description', 4, 1, 1, '2025-04-07 11:19:18', '2025-04-07 06:21:12', 1),
(17, 'afnasldf', 'laksnflaksjdf', 4, 1, 1, '2025-04-07 11:19:57', '2025-04-07 06:07:59', 2),
(18, 'sadfj', 'aljsdf', 3, 1, 1, '2025-04-07 11:38:23', '2025-04-07 06:08:37', 2);

-- --------------------------------------------------------

--
-- Table structure for table `eventlog`
--

CREATE TABLE `eventlog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event` varchar(200) NOT NULL,
  `eventRowIdOrRef` varchar(20) DEFAULT NULL,
  `eventDesc` text DEFAULT NULL,
  `eventTable` varchar(20) DEFAULT NULL,
  `staffInCharge` bigint(20) UNSIGNED NOT NULL,
  `eventTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `eventlog`
--

INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES
(1, 'Creation of new item', '1', 'Addition of 50 quantities of a new item \'Bottle\' with a unit price of &#8358;40.00 to stock', 'items', 1, '2025-03-20 05:48:04'),
(2, 'New Transaction', '1096614', '1 items totalling &#8358;167.78 with reference number 1096614 was purchased', 'transactions', 1, '2025-03-20 06:00:07'),
(3, 'New Transaction', '045603', '1 items totalling &#8358;40.40 with reference number 045603 was purchased', 'transactions', 1, '2025-03-20 06:02:40'),
(4, 'Stock Update (New Stock)', '1', '<p>60 quantities of Bottle was added to stock</p>\n                Reason: <p>New items were purchased</p>', 'items', 1, '2025-03-20 06:55:09'),
(5, 'Creation of new item', '2', 'Addition of 30 quantities of a new item \'Pot\' with a unit price of &#8377;60.00 to stock', 'items', 1, '2025-03-21 09:51:25'),
(6, 'Stock Update (New Stock)', '2', '<p>20 quantities of Pot was added to stock</p>\n                Reason: <p>New items were purchased</p>', 'items', 1, '2025-03-21 09:51:43'),
(7, 'New Transaction', '01203617', '1 items totalling &#8377;60.00 with reference number 01203617 was purchased', 'transactions', 1, '2025-03-21 09:52:34'),
(8, 'New Transaction', '7690583', '1 items totalling &#8377;1,000.00 with reference number 7690583 was purchased', 'transactions', 1, '2025-03-21 11:46:14'),
(9, 'Stock Update (New Stock)', '1', '<p>-50 quantities of Bottle was added to stock</p>\n                Reason: <p>New items were purchased</p>', 'items', 1, '2025-04-02 09:47:33'),
(10, 'Stock Update (New Stock)', '1', '<p>10 quantities of Bottle was added to stock</p>\n                Reason: <p>New items were purchased</p>', 'items', 1, '2025-04-02 09:48:01'),
(11, 'Creation of new item', '3', 'Addition of 234 quantities of a new item \'wqrqwr\' with a unit price of &#8377;32.00 to stock', 'items', 2, '2025-04-07 09:09:25'),
(12, 'New Transaction', '8625037', '1 items totalling &#8377;124.16 with reference number 8625037 was purchased', 'transactions', 2, '2025-04-07 09:14:43'),
(13, 'Stock Update (New Stock)', '3', '<p>20 quantities of wqrqwr was added to stock</p>\n                Reason: <p>New items were purchased</p>', 'items', 2, '2025-04-07 09:15:35'),
(14, 'Creation of new item', '4', 'Addition of 344 quantities of a new item \'sfkdl\' with a unit price of &#8377;43.00 to stock', 'items', 2, '2025-04-07 09:17:11'),
(15, 'Creation of new item', '5', 'Addition of 23 quantities of a new item \'sdfa\' with a unit price of &#8377;31.00 to stock', 'items', 2, '2025-04-07 09:17:59'),
(16, 'Item Update', '5', 'Details of item with code \'4324\' was updated', 'items', 2, '2025-04-07 09:18:39'),
(17, 'Creation of new item', '6', 'Addition of 321 quantities of a new item \'erqwfe\' with a unit price of &#8377;34.00 to stock', 'items', 2, '2025-04-07 09:19:15'),
(18, 'Creation of new item', '7', 'Addition of 23 quantities of a new item \'asdklf\' with a unit price of &#8377;32.00 to stock', 'items', 2, '2025-04-07 09:28:33'),
(19, 'Item Update', '1', 'Item with code \'12345\' was updated.', 'items', 2, '2025-04-07 10:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `quantity` int(6) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `mnfId` int(11) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `isDeleted` tinyint(1) DEFAULT 0,
  `adminId` int(11) DEFAULT NULL,
  `dateAdded` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `categoryId`, `mnfId`, `isActive`, `isDeleted`, `adminId`, `dateAdded`, `lastUpdated`) VALUES
(1, 'Bottle', '12345', 'Bottle made up of clay using pottery', 40.00, 40, 13, 4, 1, 0, NULL, '2025-03-20 11:18:04', '2025-04-07 10:18:39'),
(2, 'Pot', '123', 'POtPOtPOtPOtPOt POtPOtPOt POtPOtPOt', 60.00, 49, NULL, NULL, 1, 0, NULL, '2025-03-21 15:21:25', '2025-03-21 09:52:34'),
(5, 'sdfa', '4324', 'fwsdf', 35.00, 23, 14, 3, 1, 0, NULL, '2025-04-07 14:47:59', '2025-04-07 09:18:39'),
(7, 'asdklf', '432', 'sklg', 32.00, 23, 15, 3, 1, 0, 2, '2025-04-07 14:58:33', '2025-04-07 09:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `lk_sess`
--

CREATE TABLE `lk_sess` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `mnf_name` varchar(100) NOT NULL,
  `mnf_address` varchar(500) NOT NULL,
  `dist` varchar(100) DEFAULT NULL,
  `tal` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `pincode` int(10) DEFAULT NULL,
  `contact` int(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `isDeleted` tinyint(1) DEFAULT 0,
  `date_added` datetime DEFAULT current_timestamp(),
  `last_edited` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `adminId` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `mnf_name`, `mnf_address`, `dist`, `tal`, `town`, `pincode`, `contact`, `email`, `isActive`, `isDeleted`, `date_added`, `last_edited`, `adminId`) VALUES
(1, 'test manf', 'address of the manufacturer', 'district', 'taluka', 'town', 432114, 1235456987, 'test@test.com', 1, 1, '2025-04-04 16:06:12', '2025-04-06 17:22:33', 1),
(3, 'Joshi', 'Sector 18', 'Navi Mumbai', 'Thane', 'Kopar Khairane', 431455, 2147483632, 'shub@gmail.com', 1, 0, '2025-04-06 19:04:19', '2025-04-06 17:32:18', 1),
(4, 'Shubham', 'Sector 18', 'Navi Mumbai', 'Thane', 'Kopar khairane', 431008, 2147483647, 'shubhiamjoshi@gmail.com', 1, 0, '2025-04-06 22:54:12', '2025-04-06 17:24:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transId` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(10) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `itemCode` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(6) NOT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `totalMoneySpent` decimal(10,2) NOT NULL,
  `amountTendered` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `vatPercentage` decimal(10,2) NOT NULL,
  `vatAmount` decimal(10,2) NOT NULL,
  `changeDue` decimal(10,2) NOT NULL,
  `modeOfPayment` varchar(20) NOT NULL,
  `cust_name` varchar(20) DEFAULT NULL,
  `cust_phone` varchar(15) DEFAULT NULL,
  `cust_email` varchar(50) DEFAULT NULL,
  `transType` char(1) NOT NULL,
  `staffId` bigint(20) UNSIGNED NOT NULL,
  `transDate` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cancelled` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`) VALUES
(1, '1096614', 'Bottle', '12345', '', 4, 40.00, 160.00, 167.78, 200.00, 3.20, 2.00, 7.00, 10.98, 32.22, 'Cash', 'Jaypal', '8275474818', 'shubhiamjoshi@gmail.com', '1', 1, '2025-03-20 11:30:07', '2025-03-20 06:00:07', '0'),
(2, '045603', 'Bottle', '12345', '', 1, 40.00, 40.00, 40.40, 40.40, 0.00, 0.00, 1.00, 0.40, 0.00, 'POS', 'Shubham', '08275474818', 'shubhiamjoshi@gmail.com', '1', 1, '2025-03-20 11:32:40', '2025-03-20 06:02:40', '0'),
(3, '01203617', 'Pot', '123', '', 1, 60.00, 60.00, 60.00, 100.00, 0.00, 0.00, 0.00, 0.00, 40.00, 'Cash', 'Shubham', '1234567891', 'shubhiamjoshi@gmail.com', '1', 1, '2025-03-21 15:22:34', '2025-03-21 09:52:34', '0'),
(4, '7690583', 'Bottle', '12345', '', 25, 40.00, 1000.00, 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'POS', 'Shubham', '8275474818', 'shubhiamjoshi@gmail.com', '1', 1, '2025-03-21 17:16:14', '2025-03-21 11:46:14', '0'),
(5, '8625037', 'wqrqwr', '324', '', 4, 32.00, 128.00, 124.16, 130.00, 3.84, 3.00, 0.00, 0.00, 5.84, 'Cash', 'Shubham', '8275474818', 'shubhiamjoshi@gmail.com', '1', 2, '2025-04-07 14:44:43', '2025-04-07 09:14:43', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile1` (`mobile1`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mnfId` (`mnfId`),
  ADD KEY `adminId` (`adminId`);

--
-- Indexes for table `eventlog`
--
ALTER TABLE `eventlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `fk_items_category` (`categoryId`),
  ADD KEY `fk_items_manufacturer` (`mnfId`),
  ADD KEY `fk_items_admin` (`adminId`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminId` (`adminId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `eventlog`
--
ALTER TABLE `eventlog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`mnfId`) REFERENCES `manufacturers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`adminId`) REFERENCES `admin` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_admin` FOREIGN KEY (`adminId`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_items_category` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_items_manufacturer` FOREIGN KEY (`mnfId`) REFERENCES `manufacturers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD CONSTRAINT `manufacturers_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admin` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
