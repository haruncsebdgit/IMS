-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql-ims-iu
-- Generation Time: Feb 27, 2025 at 12:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iu_ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_logs`
--

CREATE TABLE `access_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `login_ip` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `login_datetime` datetime NOT NULL,
  `logout_datetime` datetime DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `access_logs`
--

INSERT INTO `access_logs` (`id`, `user_id`, `login_ip`, `login_datetime`, `logout_datetime`, `user_agent`) VALUES
(219, 1, '59.153.100.197', '2021-07-08 12:54:46', '2021-07-08 13:04:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'),
(225, 1, '103.133.207.254', '2021-07-08 13:15:04', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36 Edg/91.0.864.64'),
(226, 1, '43.250.83.73', '2021-07-08 13:28:26', '2021-07-08 13:30:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(229, 1, '116.58.200.191', '2021-07-08 14:57:02', '2021-07-08 15:13:55', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(231, 1, '59.153.100.197', '2021-07-08 15:32:27', '2021-07-08 15:40:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'),
(234, 1, '103.67.157.125', '2021-07-08 15:52:38', '2021-07-08 15:54:36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(236, 1, '103.67.157.125', '2021-07-08 16:02:56', '2021-07-08 19:18:50', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(237, 1, '59.153.100.197', '2021-07-08 16:14:53', '2021-07-08 16:18:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'),
(245, 1, '59.153.100.197', '2021-07-08 16:58:16', '2021-07-08 18:07:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'),
(248, 1, '103.133.134.255', '2021-07-08 17:12:03', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'),
(262, 1, '103.133.207.222', '2021-07-08 19:19:34', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(263, 1, '103.133.207.222', '2021-07-08 19:20:33', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(265, 1, '103.133.134.253', '2021-07-08 19:31:10', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'),
(266, 1, '127.0.0.1', '2021-07-24 13:27:43', '2021-07-24 13:48:28', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(267, 1, '127.0.0.1', '2021-07-24 13:48:53', '2021-07-24 13:55:22', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(268, 1, '127.0.0.1', '2021-07-24 16:38:14', '2021-07-24 18:10:38', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(269, 1, '127.0.0.1', '2021-07-24 18:13:15', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(270, 1, '127.0.0.1', '2021-07-26 20:34:55', '2021-07-26 21:38:07', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(271, 2, '127.0.0.1', '2021-07-26 21:38:15', '2021-07-26 21:51:41', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(272, 1, '127.0.0.1', '2021-07-26 21:42:48', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(273, 1, '127.0.0.1', '2021-07-26 21:51:45', '2021-07-26 22:03:23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(274, 1, '127.0.0.1', '2021-07-26 22:10:31', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(275, 1, '127.0.0.1', '2021-07-27 20:09:51', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(276, 1, '127.0.0.1', '2021-07-27 22:26:02', '2021-07-27 23:06:36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(277, 1, '127.0.0.1', '2021-07-27 23:08:38', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(278, 1, '127.0.0.1', '2021-07-30 10:29:04', '2021-07-30 11:27:52', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(279, 2, '127.0.0.1', '2021-07-30 10:49:19', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(280, 1, '127.0.0.1', '2021-07-30 11:36:06', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(281, 1, '127.0.0.1', '2021-07-30 15:21:08', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(282, 2, '127.0.0.1', '2021-07-30 15:51:37', '2021-07-30 18:24:30', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(283, 3, '127.0.0.1', '2021-07-30 18:24:37', '2021-07-30 18:29:31', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(284, 2, '127.0.0.1', '2021-07-30 18:29:34', '2021-07-30 18:34:21', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(285, 3, '127.0.0.1', '2021-07-30 18:34:25', '2021-07-30 18:44:25', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(286, 2, '127.0.0.1', '2021-07-30 18:44:29', '2021-07-30 18:52:21', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(287, 3, '127.0.0.1', '2021-07-30 18:52:24', '2021-07-30 18:52:53', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(288, 2, '127.0.0.1', '2021-07-30 18:52:56', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(289, 1, '127.0.0.1', '2021-07-30 22:27:19', '2021-07-30 22:32:22', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(290, 1, '127.0.0.1', '2021-07-30 22:35:02', '2021-07-31 00:06:18', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(291, 2, '127.0.0.1', '2021-07-30 23:01:25', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(292, 1, '127.0.0.1', '2021-07-31 00:06:59', '2021-07-31 00:40:10', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(293, 3, '127.0.0.1', '2021-07-31 00:40:23', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(294, 2, '127.0.0.1', '2021-07-31 11:10:13', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(295, 1, '127.0.0.1', '2021-07-31 11:12:15', '2021-07-31 11:21:11', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(296, 3, '127.0.0.1', '2021-07-31 11:21:15', '2021-07-31 11:32:19', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(297, 1, '127.0.0.1', '2021-07-31 11:32:26', '2021-07-31 11:51:38', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(298, 3, '127.0.0.1', '2021-07-31 11:51:42', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(299, 1, '127.0.0.1', '2021-07-31 14:59:01', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(300, 1, '127.0.0.1', '2021-07-31 23:23:23', '2021-07-31 23:50:36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(301, 1, '127.0.0.1', '2021-07-31 23:54:31', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(302, 1, '127.0.0.1', '2021-08-01 19:46:26', '2021-08-01 20:54:06', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(303, 1, '127.0.0.1', '2021-08-01 20:57:03', '2021-08-01 22:21:43', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(304, 2, '127.0.0.1', '2021-08-01 21:30:28', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0'),
(305, 1, '127.0.0.1', '2021-08-01 22:24:51', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(306, 1, '127.0.0.1', '2021-08-02 01:33:02', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(307, 1, '127.0.0.1', '2021-08-02 20:53:39', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(308, 1, '127.0.0.1', '2021-08-04 20:37:20', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36'),
(309, 1, '127.0.0.1', '2025-02-13 18:41:32', '2025-02-13 21:24:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36'),
(310, 1, '127.0.0.1', '2025-02-13 22:38:27', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36'),
(311, 1, '103.149.60.8', '2025-02-14 19:19:06', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'),
(312, 1, '103.91.128.103', '2025-02-16 23:15:30', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36'),
(313, 1, '103.100.234.67', '2025-02-17 09:55:46', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'),
(314, 1, '103.115.242.113', '2025-02-26 19:00:40', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `common_labels`
--

CREATE TABLE `common_labels` (
  `id` bigint UNSIGNED NOT NULL,
  `data_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'type of data used to categorize content',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_delatable` tinyint(1) DEFAULT '1',
  `organization_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Organization Id',
  `order` int UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Code',
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `common_labels`
--

INSERT INTO `common_labels` (`id`, `data_type`, `name_en`, `name_bn`, `is_delatable`, `organization_id`, `order`, `status`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'education-degrees', 'Masters', 'মাস্টার্স', 1, NULL, 0, 1, NULL, 1, 1, NULL, NULL),
(2, 'education-degrees', 'Honors', 'অনার্স', 1, NULL, 0, 1, NULL, 1, 1, NULL, NULL),
(3, 'countries', 'Bangladesh', 'বাংলাদেশ', 1, NULL, 0, 1, NULL, 1, 1, NULL, NULL),
(4, 'countries', 'India', 'ভারত', 1, NULL, 0, 1, NULL, 1, 1, NULL, NULL),
(5, 'designations', 'Associate Professor', 'Associate Professor', 1, NULL, 2, 1, NULL, 1, 1, NULL, '2021-07-23 18:21:33'),
(6, 'designations', 'Professor', 'Professor', 1, NULL, 1, 1, NULL, 1, 1, NULL, '2021-07-23 18:21:09'),
(9, 'cig-designation', 'EC Member', 'EC Member', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(10, 'trainee-type', 'CIG', 'CIG', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(11, 'trainee-type', 'CIG Leader', 'CIG Leader', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(12, 'trainee-type', 'Nursery Operator', 'Nursery Operator', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(13, 'trainee-type', 'Hatchery Operator', 'Hatchery Operator', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(14, 'trainee-type', 'LEAF', 'LEAF', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(15, 'trainee-type', 'CEAL', 'CEAL', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(16, 'trainee-type', 'SAAO', 'SAAO', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(17, 'trainer-type', 'LEAF', 'LEAF', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(18, 'trainer-type', 'CEAL', 'CEAL', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(19, 'trainer-type', 'SAAO', 'SAAO', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(20, 'trainer-type', 'Officer', 'Officer', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(21, 'trainer-type', 'Staff', 'Staff', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(22, 'trainer-type', 'Outside Trainer', 'Outside Trainer', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(23, 'employee-type', 'Officer ', 'Officer', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(24, 'employee-type', 'Staff', 'Staff', 0, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(25, 'po-income-head', 'Crate Rent', 'Crate Rent', 1, NULL, 1, 1, NULL, 1, 1, NULL, NULL),
(26, 'po-income-head', 'Van Rent', 'রিক্সা ভ্যান', 1, NULL, 2, 1, NULL, 1, 1, NULL, NULL),
(27, 'po-income-head', 'Beneficiary Businessman', 'Beneficiary Businessman', 1, NULL, 3, 1, NULL, 1, 1, NULL, NULL),
(28, 'po-income-head', 'Others', 'Others', 1, NULL, 4, 1, NULL, 1, 1, NULL, NULL),
(53, 'designations', 'Dept Chairman', 'Dept Chairman', 1, NULL, 3, 1, NULL, 1, 1, '2021-07-11 18:24:17', '2021-07-23 18:20:49'),
(54, 'designations', 'Lecturer', 'Lecturer', 1, NULL, 4, 1, NULL, 1, 1, '2021-07-11 18:24:29', '2021-07-24 11:16:35'),
(55, 'employee-category', 'Contractual', 'Contractual', 1, NULL, 1, 1, NULL, 1, NULL, '2021-07-23 18:26:02', '2021-07-23 18:26:02'),
(56, 'employee-category', 'Permanent', 'Permanent', 1, NULL, 2, 1, NULL, 1, NULL, '2021-07-23 18:26:19', '2021-07-23 18:26:19'),
(57, 'employee-class', 'First', 'First', 1, NULL, 1, 1, NULL, 1, NULL, '2021-07-23 18:27:04', '2021-07-23 18:27:04'),
(58, 'employee-class', 'Second', 'Second', 1, NULL, 2, 1, NULL, 1, NULL, '2021-07-23 18:27:16', '2021-07-23 18:27:16'),
(59, 'units', 'PCs', 'PCs', 1, NULL, 1, 1, NULL, 1, NULL, '2021-07-23 18:39:32', '2021-07-23 18:39:32'),
(60, 'designations', 'Assistant Professor', 'Assistant Professor', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-24 11:22:50', '2021-07-24 11:22:50'),
(61, 'designations', 'Inventory Manager', 'Inventory Manager', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-24 12:26:46', '2021-07-24 12:26:46'),
(62, 'manufacturer', 'HP', 'HP', 1, NULL, 1, 1, NULL, 1, NULL, '2021-07-27 22:28:48', '2021-07-27 22:28:48'),
(63, 'manufacturer', 'Otobi', 'Otobi', 1, NULL, 2, 1, NULL, 1, 1, '2021-07-27 22:29:50', '2021-07-27 22:33:54'),
(64, 'units', 'KG', 'KG', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-30 11:44:15', '2021-07-30 11:44:15'),
(65, 'asset-location', 'Room No 22', 'Room No 22', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-30 15:21:33', '2021-07-30 15:21:33'),
(66, 'asset-location', 'Room No 10', 'Room No 10', 1, NULL, 2, 1, NULL, 1, NULL, '2021-07-30 15:21:45', '2021-07-30 15:21:45'),
(67, 'asset-location', 'Room No 1', 'Room No 1', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-30 22:44:43', '2021-07-30 22:44:43'),
(68, 'asset-location', 'Room No 2', 'Room No 2', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-30 22:44:53', '2021-07-30 22:44:53'),
(69, 'asset-location', 'Room No 3', 'Room No 3', 1, NULL, 0, 1, NULL, 1, NULL, '2021-07-30 22:45:05', '2021-07-30 22:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` bigint UNSIGNED DEFAULT NULL COMMENT 'From Common Labels: Designation',
  `father_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `retirement_date` date DEFAULT NULL,
  `employee_type_id` bigint UNSIGNED DEFAULT NULL COMMENT 'From Common Labels: Employee Type',
  `employee_category_id` bigint UNSIGNED DEFAULT NULL COMMENT 'From Common Labels: Employee Category',
  `employee_class_id` bigint UNSIGNED DEFAULT NULL COMMENT 'From Common Labels: Employee Class',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name_en`, `name_bn`, `employee_image`, `designation_id`, `father_name`, `mother_name`, `date_of_birth`, `mobile`, `nid`, `email`, `gender`, `religion`, `joining_date`, `retirement_date`, `employee_type_id`, `employee_category_id`, `employee_class_id`, `is_active`, `address`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Md. Habibur Rahman', 'Dr. Md. Habibur Rahman', NULL, 6, 'Aba baka', 'aaa', '2021-07-23', '01254874587', '1254785455', 'test@gamil.com', 'male', 'islam', '2021-07-23', NULL, 23, 55, 57, 1, 'House-4, Road No-9/B, Nikunja-1', 1, 1, '2021-07-23 18:35:18', '2025-02-13 23:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_allocations`
--

CREATE TABLE `inv_item_allocations` (
  `id` bigint UNSIGNED NOT NULL,
  `allocation_date` date NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `is_received` tinyint NOT NULL DEFAULT '0',
  `approved_by` bigint DEFAULT NULL,
  `received_by` bigint DEFAULT NULL,
  `forwarded_user_id` bigint UNSIGNED DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_item_allocations`
--

INSERT INTO `inv_item_allocations` (`id`, `allocation_date`, `user_id`, `location_id`, `approved_date`, `received_date`, `is_approved`, `is_received`, `approved_by`, `received_by`, `forwarded_user_id`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(23, '2025-02-27', 1, 65, NULL, NULL, 0, 0, NULL, NULL, NULL, 'সাধারণত এটি পরীক্ষামূলক ব্যবহার করা হচ্ছে', 1, NULL, '2025-02-27 08:31:34', '2025-02-27 08:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_allocation_details`
--

CREATE TABLE `inv_item_allocation_details` (
  `id` bigint UNSIGNED NOT NULL,
  `allocation_item_master_id` bigint UNSIGNED NOT NULL,
  `item_category_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` bigint UNSIGNED NOT NULL,
  `serial_no` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_category_sub_category_information`
--

CREATE TABLE `inv_item_category_sub_category_information` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `name_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_en` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_bn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_item_category_sub_category_information`
--

INSERT INTO `inv_item_category_sub_category_information` (`id`, `organization_id`, `name_en`, `name_bn`, `code_en`, `code_bn`, `parent_id`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Computer', 'Computer', '154', '154', NULL, NULL, 1, NULL, '2021-07-17 12:58:15', '2021-07-17 12:58:15'),
(2, NULL, 'Furniture', 'Furniture', '1254', NULL, NULL, NULL, 1, NULL, '2021-07-23 17:53:38', '2021-07-23 17:53:38'),
(3, NULL, 'Computer Accessories', 'Computer Accessories', '5487', NULL, NULL, NULL, 1, NULL, '2021-07-23 17:54:19', '2021-07-23 17:54:19'),
(4, NULL, 'Software', 'Software', '5897', NULL, NULL, NULL, 1, NULL, '2021-07-23 17:55:13', '2021-07-23 17:55:13'),
(5, NULL, 'Book', 'Book', '2547', NULL, NULL, NULL, 1, 1, '2021-07-24 12:25:09', '2021-07-24 16:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_information`
--

CREATE TABLE `inv_item_information` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `name_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_en` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_bn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_type` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `uom_id` int DEFAULT NULL,
  `manufacturer_id` int DEFAULT NULL,
  `model` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `part_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `min_re_order_qty` int DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_serialized` int DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_item_information`
--

INSERT INTO `inv_item_information` (`id`, `organization_id`, `name_en`, `name_bn`, `code_en`, `code_bn`, `asset_type`, `category_id`, `uom_id`, `manufacturer_id`, `model`, `part_number`, `min_re_order_qty`, `remarks`, `is_serialized`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Apple Mackbook', 'Apple Mackbook', '12545', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2021-07-20 11:03:39', '2021-07-20 11:03:39'),
(2, NULL, 'Chair', 'Chair', '547', '587', 1, 2, NULL, NULL, 'Consequuntur dolorum', '459', 553, 'Vel alias magna even', 0, 1, 1, NULL, '2021-07-23 17:55:55', '2021-07-23 17:55:55'),
(3, NULL, 'Table', 'Table', '6987', '659', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2021-07-23 17:56:22', '2021-07-23 17:56:22'),
(4, NULL, 'Mouse', 'Mouse', '987', '968', 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2021-07-23 17:57:00', '2021-07-23 17:57:00'),
(5, NULL, 'Inventory Management System', 'Inventory Management System', '6325', NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2021-07-23 17:57:49', '2021-07-23 17:57:49'),
(6, NULL, 'Introduction to Software Testing', 'Introduction to Software Testing', '254', NULL, 1, 5, 59, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2021-07-26 22:16:37', '2021-07-26 22:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_on_support_return_from_supplier_vendor_information`
--

CREATE TABLE `inv_item_on_support_return_from_supplier_vendor_information` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `on_support_id` int DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `inventory_cost_center` int DEFAULT NULL,
  `supplier_vendor` int DEFAULT NULL,
  `return_from_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_on_support_return_to_supplier_vendor_information`
--

CREATE TABLE `inv_item_on_support_return_to_supplier_vendor_information` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `inventory_cost_center` int DEFAULT NULL,
  `supplier_vendor` int DEFAULT NULL,
  `return_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_receive_from_supplier_information`
--

CREATE TABLE `inv_item_receive_from_supplier_information` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `upazila_id` bigint UNSIGNED DEFAULT NULL,
  `union_id` bigint UNSIGNED DEFAULT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `inventory_center_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `package_lot_id` int DEFAULT NULL,
  `po_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `invoice_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `supplier_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_item_receive_from_supplier_information`
--

INSERT INTO `inv_item_receive_from_supplier_information` (`id`, `division_id`, `district_id`, `upazila_id`, `union_id`, `organization_id`, `inventory_center_id`, `supplier_id`, `package_lot_id`, `po_number`, `receive_date`, `invoice_no`, `invoice_date`, `supplier_remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '233', '2021-07-20', '1254', '2021-07-20', NULL, 1, 1, '2021-07-20 12:43:26', '2021-07-23 11:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_return_on_supports`
--

CREATE TABLE `inv_item_return_on_supports` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `inventory_cost_center` bigint UNSIGNED DEFAULT NULL,
  `supplier_vendor` bigint UNSIGNED DEFAULT NULL,
  `return_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_transfer_information`
--

CREATE TABLE `inv_item_transfer_information` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `inventory_cost_center_from` int DEFAULT NULL,
  `inventory_cost_center_to` int DEFAULT NULL,
  `transfer_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_transfer_information_item_information`
--

CREATE TABLE `inv_item_transfer_information_item_information` (
  `id` bigint UNSIGNED NOT NULL,
  `transfer_item_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `item_status_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_asset_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_transfer_receive_information`
--

CREATE TABLE `inv_item_transfer_receive_information` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `inventory_cost_center_from` int DEFAULT NULL,
  `inventory_cost_center_to` int DEFAULT NULL,
  `transfer_receive_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_transfer_receive_information_item_information`
--

CREATE TABLE `inv_item_transfer_receive_information_item_information` (
  `id` bigint UNSIGNED NOT NULL,
  `transfer_receive_item_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `item_status_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_asset_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_request_items`
--

CREATE TABLE `inv_request_items` (
  `id` bigint UNSIGNED NOT NULL,
  `requested_date` date NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `is_requested` tinyint NOT NULL DEFAULT '0',
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `is_received` tinyint NOT NULL DEFAULT '0',
  `requested_by` bigint NOT NULL,
  `approved_by` bigint DEFAULT NULL,
  `received_by` bigint DEFAULT NULL,
  `forwarded_user_id` bigint UNSIGNED DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_request_items`
--

INSERT INTO `inv_request_items` (`id`, `requested_date`, `location_id`, `approved_date`, `received_date`, `is_requested`, `is_approved`, `is_received`, `requested_by`, `approved_by`, `received_by`, `forwarded_user_id`, `remarks`, `created_at`, `updated_at`) VALUES
(17, '2021-07-31', 65, '2021-07-31', '2021-07-31', 1, 1, 1, 2, 3, 2, 3, NULL, '2021-07-31 11:20:28', '2021-07-31 11:21:53'),
(18, '2021-07-31', 65, '2021-07-31', NULL, 1, 1, 0, 2, 3, NULL, 3, NULL, '2021-07-31 11:43:46', '2021-07-31 11:52:27'),
(19, '2021-08-01', 65, '2021-08-01', '2025-02-26', 1, 1, 1, 2, 1, 1, 3, NULL, '2021-08-01 21:30:41', '2025-02-26 19:12:59'),
(20, '2025-02-26', 67, '2025-02-26', NULL, 1, 1, 0, 1, 1, NULL, 1, NULL, '2025-02-26 19:17:00', '2025-02-26 19:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `inv_request_item_approval_history`
--

CREATE TABLE `inv_request_item_approval_history` (
  `id` int UNSIGNED NOT NULL,
  `request_item_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` enum('forwarded','approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_request_item_approval_history`
--

INSERT INTO `inv_request_item_approval_history` (`id`, `request_item_id`, `user_id`, `type`, `comments`, `created_at`, `updated_at`) VALUES
(11, 17, 1, 'forwarded', 'Please sir approve', '2021-07-31 11:21:07', '2021-07-31 11:21:07'),
(12, 17, 3, 'approved', NULL, '2021-07-31 11:21:41', '2021-07-31 11:21:41'),
(13, 18, 1, 'forwarded', 'Please sir approve', '2021-07-31 11:51:34', '2021-07-31 11:51:34'),
(14, 18, 3, 'approved', NULL, '2021-07-31 11:52:27', '2021-07-31 11:52:27'),
(15, 19, 1, 'approved', 'Please sir approve', '2021-08-01 21:32:06', '2021-08-01 21:32:06'),
(16, 19, 1, 'forwarded', 'Please sir approve', '2021-08-01 21:32:17', '2021-08-01 21:32:17'),
(17, 20, 1, 'approved', 'Please Approved', '2025-02-26 19:18:11', '2025-02-26 19:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `inv_request_item_details`
--

CREATE TABLE `inv_request_item_details` (
  `id` bigint UNSIGNED NOT NULL,
  `request_item_master_id` bigint UNSIGNED NOT NULL,
  `item_category_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` bigint UNSIGNED NOT NULL,
  `serial_no` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_request_item_details`
--

INSERT INTO `inv_request_item_details` (`id`, `request_item_master_id`, `item_category_id`, `item_id`, `quantity`, `serial_no`, `remarks`, `created_at`, `updated_at`) VALUES
(25, 17, 1, 1, 1, '1254555', NULL, '2021-07-31 11:20:28', '2021-07-31 11:21:07'),
(26, 18, 1, 1, 1, '45555-aa-add', NULL, '2021-07-31 11:43:46', '2021-07-31 11:51:34'),
(27, 19, 1, 1, 1, NULL, 'aa', '2021-08-01 21:30:41', '2021-08-01 21:30:41'),
(28, 20, 1, 1, 1, NULL, NULL, '2025-02-26 19:17:00', '2025-02-26 19:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `inv_return_from_item_infos`
--

CREATE TABLE `inv_return_from_item_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `return_from_item_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `item_status_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_asset_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_return_items`
--

CREATE TABLE `inv_return_items` (
  `id` bigint UNSIGNED NOT NULL,
  `return_date` date NOT NULL,
  `approved_date` date DEFAULT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `approved_by` bigint DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_return_items`
--

INSERT INTO `inv_return_items` (`id`, `return_date`, `approved_date`, `is_approved`, `approved_by`, `remarks`, `created_at`, `updated_at`) VALUES
(1, '2025-02-26', NULL, 0, NULL, NULL, '2025-02-26 19:20:12', '2025-02-26 19:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `inv_return_item_details`
--

CREATE TABLE `inv_return_item_details` (
  `id` bigint UNSIGNED NOT NULL,
  `return_item_master_id` bigint UNSIGNED NOT NULL,
  `item_category_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` bigint UNSIGNED NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_return_item_details`
--

INSERT INTO `inv_return_item_details` (`id`, `return_item_master_id`, `item_category_id`, `item_id`, `quantity`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 3, 10, NULL, '2025-02-26 19:20:12', '2025-02-26 19:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `inv_return_item_infos`
--

CREATE TABLE `inv_return_item_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `return_item_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `item_status_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_asset_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_stocks`
--

CREATE TABLE `inv_stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `dept` enum('dept_cse') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `item_status_id` int NOT NULL,
  `asset_location_id` bigint UNSIGNED DEFAULT NULL,
  `stock_quantity` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_stocks`
--

INSERT INTO `inv_stocks` (`id`, `dept`, `user_id`, `item_id`, `item_status_id`, `asset_location_id`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(1, 'dept_cse', NULL, 1, 1, NULL, 2, '2021-07-23 11:52:19', '2025-02-26 19:12:59'),
(8, 'dept_cse', 2, 1, 1, 65, 2, '2021-07-31 11:21:53', '2025-02-26 19:12:59'),
(9, 'dept_cse', NULL, 3, 1, NULL, 10, '2025-02-26 19:20:12', '2025-02-26 19:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `inv_suppliers`
--

CREATE TABLE `inv_suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `name_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `organogram_id` int DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tender_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_suppliers`
--

INSERT INTO `inv_suppliers` (`id`, `organization_id`, `name_en`, `name_bn`, `contact_no`, `email`, `website`, `address`, `remarks`, `is_active`, `organogram_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `tender_id`) VALUES
(1, NULL, 'Smart Technologies', 'Smart Technologies', '01945874587', 'haruncsebd@gmail.com', NULL, 'DHK', NULL, 1, NULL, 1, 1, '2021-07-20 12:41:05', '2021-07-23 20:36:12', NULL),
(2, NULL, 'Musa kalimullah', 'মুসা কালিমুল্লাহ', '18265736200', 'mkmmusa1995@gmail.com', NULL, 'South Mirpur', 'সাধারণত এটি পরীক্ষামূলক ব্যবহার করা হচ্ছে', 1, NULL, 1, NULL, '2025-02-27 08:26:34', '2025-02-27 08:26:34', NULL),
(3, NULL, 'Md. Abu Bakar Siddik', 'আবু বকর সিদ্দিক', '1926323382', 'absiddik75@gmail.com', NULL, 'Kulia, Gurugram, Debhata, Satkhira', 'সাধারণত এটি পরীক্ষামূলক ব্যবহার করা হচ্ছে', 1, NULL, 1, NULL, '2025-02-27 08:28:13', '2025-02-27 08:28:13', NULL),
(4, NULL, 'Arif Hossen', 'আরিফ হোসেন', '0125699852216', 'arifsqldeveloper@gmail.com', NULL, 'Jatarabari, Dhaka', 'সাধারণত এটি পরীক্ষামূলক ব্যবহার করা হচ্ছে', 1, NULL, 1, NULL, '2025-02-27 08:29:38', '2025-02-27 08:29:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_supplier_item_infos`
--

CREATE TABLE `inv_supplier_item_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `supplier_item_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `item_status_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_asset_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_supplier_item_infos`
--

INSERT INTO `inv_supplier_item_infos` (`id`, `supplier_item_id`, `item_id`, `item_status_id`, `quantity`, `serial`, `fixed_asset_id`, `remarks`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 1, 4, '322dd', 'asd', NULL, '2021-07-23 11:58:58', '2021-07-23 11:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_07_25_124535_create_divisions_table', 1),
(4, '2016_07_28_113245_create_districts_table', 1),
(5, '2016_07_28_172141_create_thana_upazila_table', 1),
(6, '2016_07_29_115707_create_union_wards_table', 1),
(7, '2017_08_03_182328_create_common_labels_table', 1),
(8, '2019_02_04_124658_create_user_meta_table', 1),
(9, '2019_02_06_174811_create_roles_permissions_table', 1),
(10, '2019_06_18_122249_create_options_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2020_05_03_095515_rename_name_column_in_divisions_table', 1),
(13, '2020_05_03_122844_rename_name_column_in_districts_table', 1),
(14, '2020_05_03_182105_add_cascade_delete_with_users_in_all_table', 1),
(15, '2020_05_04_134814_rename_name_column_in_thana_upazila_table', 1),
(16, '2020_05_04_153925_rename_name_column_in_common_labels_table', 1),
(17, '2020_05_06_104213_create_financial_years_table', 1),
(18, '2020_05_13_123856_add_new_columns_to_users_table', 1),
(19, '2020_05_31_190831_make_user_level_column_nullable_in_users_table', 1),
(20, '2020_08_17_183854_add_user_image_column_in_users_table', 1),
(21, '2020_10_21_163426_add_new_field_in_financial_years_table', 1),
(22, '2021_01_27_150512_add_column_division_id_to_users_table', 1),
(23, '2021_01_27_163115_create_access_logs_table', 1),
(24, '2021_01_27_170457_add_column_url_to_thana_upazilas_table', 1),
(25, '2021_01_28_124441_create_organizations_table', 1),
(26, '2021_02_18_144415_add_column_code_to_organizations_table', 1),
(27, '2021_02_23_154022_create_organograms_table', 1),
(28, '2021_03_03_120441_create_regions_table', 1),
(29, '2021_03_03_130253_add_column_organogram_id_to_users_table', 1),
(30, '2021_03_03_142756_add_column_region_id_to_districts_table', 1),
(31, '2021_03_03_182908_add_column_code_to_common_labels_table', 1),
(32, '2021_03_04_105331_add_column_union_id_to_organograms_table', 1),
(33, '2021_03_04_110813_create_employees_table', 1),
(34, '2021_03_04_160119_create_projects_table', 1),
(35, '2021_03_04_162446_create_project_source_of_funds_table', 1),
(36, '2021_03_08_185857_alter_column_logout_datetime_to_access_logs_table', 1),
(37, '2021_03_10_144947_create_project_cost_centers_table', 1),
(38, '2021_03_11_161813_create_cigs_table', 1),
(39, '2021_03_14_173835_create_cig_members_table', 1),
(40, '2021_03_15_153016_create_cig_member_details_table', 1),
(41, '2021_03_16_161251_create_cig_account_transactions_table', 1),
(42, '2021_03_18_110929_create_cig_productions_table', 1),
(43, '2021_03_18_172508_create_fish_stock_details_table', 1),
(44, '2021_03_22_095415_create_organogram_user_table', 1),
(45, '2021_03_22_112152_add_column_users_table', 1),
(46, '2021_03_22_170937_drop_column_organogram_id_from_users', 1),
(47, '2021_03_23_142507_create_project_user_table', 1),
(48, '2021_03_23_170214_add_organization_id_to_organogram_table', 1),
(49, '2021_03_24_124747_add_organization_id_to_roles_permissions_table', 1),
(50, '2021_03_25_103125_add_column_organization_id_to_common_labels_table', 1),
(51, '2021_03_25_163708_create_cig_microplans_table', 1),
(52, '2021_03_29_105859_create_employee_organograms_table', 1),
(53, '2021_03_29_141404_drop_and_add_field_in_employees_table', 1),
(54, '2021_03_29_144812_create_technologies_table', 1),
(55, '2021_03_29_144813_create_demonstrations_table', 1),
(56, '2021_03_29_144814_create_demonstration_ponds_table', 1),
(57, '2021_03_31_102336_add_organization_id_to_cigs_table', 1),
(58, '2021_03_31_105143_add_organization_id_to_cig_members_table', 1),
(59, '2021_03_31_110447_add_organization_id_to_cig_account_transactions_table', 1),
(60, '2021_03_31_120409_add_organization_id_to_cig_productions_table', 1),
(61, '2021_03_31_121019_add_organization_id_to_cig_microplans_table', 1),
(62, '2021_03_31_142019_add_cig_type_to_cigs_table', 1),
(63, '2021_03_31_151515_create_grades_table', 1),
(64, '2021_03_31_165352_create_indicators_table', 1),
(65, '2021_03_31_165750_create_indicator_answers_table', 1),
(66, '2021_03_31_170748_create_performance_evaluations_table', 1),
(67, '2021_03_31_171157_create_evaluations_user_answers_table', 1),
(68, '2021_03_31_190635_create_demonstration_dae_equipments_table', 1),
(69, '2021_04_04_111806_add_column_to_cig_members_table', 1),
(70, '2021_04_05_155253_create_producer_organizations_table', 1),
(71, '2021_04_06_084904_create_saaos_table', 1),
(72, '2021_04_06_104857_create_fiac_functionalities_table', 1),
(73, '2021_04_06_173934_add_column_to_producer_organizations_table', 1),
(74, '2021_04_07_125141_create_po_mmc_members_table', 1),
(75, '2021_04_07_151907_create_fiacs_table', 1),
(76, '2021_04_07_171247_create_demo_productions_table', 1),
(77, '2021_04_07_184059_create_cig_transaction_setups_table', 1),
(78, '2021_04_07_224454_create_po_mmc_meetings_table', 1),
(79, '2021_04_08_091058_create_fiac_dof_work_date_time_table', 1),
(80, '2021_04_08_114913_create_farmers_table', 1),
(81, '2021_04_08_151232_create_po_mmc_meeting_details_table', 1),
(82, '2021_04_08_174400_create_seed_preservations_table', 1),
(83, '2021_04_09_080203_create_cig_noncig_gathering_information_table', 1),
(84, '2021_04_10_233036_create_trader_distributer_buyers_table', 1),
(85, '2021_04_11_125848_add_organization_id_to_trader_distributer_buyers_table', 1),
(86, '2021_04_11_130223_add_organization_id_to_po_mmc_meetings_table', 1),
(87, '2021_04_11_132320_create_item_trader_distributer_buyers_table', 1),
(88, '2021_04_11_132709_create_agent_trader_distributer_buyer_table', 1),
(89, '2021_04_11_144855_create_necc_decc_uecc_meeting_information_table', 1),
(90, '2021_04_11_152027_add_column_to_trader_distributer_buyers_tablee', 1),
(91, '2021_04_12_080256_add_number_of_participants_to_necc_decc_uecc_meeting_information', 1),
(92, '2021_04_12_081645_remove_number_of_participants_from_necc_decc_uecc_meeting_information', 1),
(93, '2021_04_12_082243_rename_number_of_participant_column', 1),
(94, '2021_04_12_100213_create_implemented_visit_info_table', 1),
(95, '2021_04_12_122031_create_implemented_visit_info_dae_participant_details_table', 1),
(96, '2021_04_12_145225_create_p_o_m_m_c_sales_informations_table', 1),
(97, '2021_04_13_093537_add_column_cig_member_id_to_demo_productions_table', 1),
(98, '2021_04_13_113245_create_po_sales_collections_table', 1),
(99, '2021_04_13_131405_create_de_worming_campaigns_table', 1),
(100, '2021_04_13_141922_create_field_days_table', 1),
(101, '2021_04_14_145935_create_vaccination_campaign_information_table', 1),
(102, '2021_04_14_194815_create_po_sales_details_table', 1),
(103, '2021_04_15_091941_create_adopting_farmers_table', 1),
(104, '2021_04_15_111502_create_po_sales_detail_items_table', 1),
(105, '2021_04_15_112029_create_infertility_campaigns_table', 1),
(106, '2021_04_15_121813_create_environmental_lea_information_table', 1),
(107, '2021_04_15_125843_create_fiac_equipment_information_table', 1),
(108, '2021_04_15_212148_create_adopting_technologies_table', 1),
(109, '2021_04_16_153212_add_created_by_to_fiac_equipment_information_table', 1),
(110, '2021_04_17_082806_add_updated_by_to_fiac_equipment_information_table', 1),
(111, '2021_04_18_095952_create_environmental_lea_negative_impacts_table', 1),
(112, '2021_04_18_112009_create_crops_table', 1),
(113, '2021_04_18_112039_create_crop_season_table', 1),
(114, '2021_04_18_120058_create_seed_multiplication_farm_information_table', 1),
(115, '2021_04_18_144413_add_column_for_dls_to_producer_organizations_table', 1),
(116, '2021_04_18_161702_create_soil_healths_table', 1),
(117, '2021_04_18_161756_create_soil_health_details_table', 1),
(118, '2021_04_18_171322_create_fish_species_trader_dis_buyers_table', 1),
(119, '2021_04_18_230524_create_hathery_nurseries_table', 1),
(120, '2021_04_19_112000_create_brood_development_seed_multiplication_activities_table', 1),
(121, '2021_04_19_115411_create_hathery_nurseries_fishes_table', 1),
(122, '2021_04_19_124821_create_crop_productions_table', 1),
(123, '2021_04_19_131143_create_environmental_aqua_practice_info', 1),
(124, '2021_04_19_143252_create_environmental_aqua_prac_instruct_table', 1),
(125, '2021_04_19_154711_create_indicator_categories_table', 1),
(126, '2021_04_19_154838_create_indicator_sub_categories_table', 1),
(127, '2021_04_19_154839_create_indicator_setups_table', 1),
(128, '2021_04_20_111746_add_column_to_po_mmc_members_table', 1),
(129, '2021_04_20_170128_create_crop_production_details_table', 1),
(130, '2021_04_21_074805_create_brood_development_received_infos_table', 1),
(131, '2021_04_21_074930_create_brood_development_monitoring_infos_table', 1),
(132, '2021_04_21_075030_create_brood_development_fingerlings_production_infos_table', 1),
(133, '2021_04_21_114247_create_environmental_waste_management_table', 1),
(134, '2021_04_21_131727_add_column_to_po_sales_table', 1),
(135, '2021_04_21_140714_create_environmental_waste_produced_product_table', 1),
(136, '2021_04_21_141237_create_monitoring_indicators_table', 1),
(137, '2021_04_21_141507_create_monitoring_indicator_details_table', 1),
(138, '2021_04_21_152746_create_sales_with_buyer_information_table', 1),
(139, '2021_04_21_175522_create_po_sales_fish_details_table', 1),
(140, '2021_04_22_115609_create_pond_water_quality_table', 1),
(141, '2021_04_22_120312_create_po_product_informations_table', 1),
(142, '2021_04_22_120547_create_environmental_pond_water_quality_table', 1),
(143, '2021_04_22_144331_create_po_sales_details_dls_table', 1),
(144, '2021_04_22_145321_create_environmental_pond_parameter_info_table', 1),
(145, '2021_04_22_150040_add_po_member_id_to_po_sales_table', 1),
(146, '2021_04_23_103939_create_sales_infos_table', 1),
(147, '2021_04_25_144102_create_fund_types_table', 1),
(148, '2021_04_25_161014_create_fiac_functionality_details_table', 1),
(149, '2021_04_25_171935_create_grievance_redress_info_table', 1),
(150, '2021_04_26_094045_create_satisfaction_evaluations_table', 1),
(151, '2021_04_26_094100_create_satisfaction_evaluation_details_table', 1),
(152, '2021_04_26_130650_create_grievance_history_table', 1),
(153, '2021_04_27_105855_create_organization_type_fund_types_table', 1),
(154, '2021_04_27_123739_create_aif_tools_technologies_table', 1),
(155, '2021_04_27_145320_create_aif_tools_technology_details_table', 1),
(156, '2021_04_28_132146_create_cig_used_technologies_table', 1),
(157, '2021_04_28_132242_create_cig_problem_details_table', 1),
(158, '2021_04_28_132332_create_cig_problem_resolve_plans_table', 1),
(159, '2021_04_28_144958_add_column_to_cig_microplans_table', 1),
(160, '2021_04_28_145759_create_fund_allocations_table', 1),
(161, '2021_04_29_125848_create_aif_fund_alloc_tools_technologies_table', 1),
(162, '2021_04_29_131455_create_aif_fund_alloc_tools_technology_usages_table', 1),
(163, '2021_04_29_141903_create_procuring_entities_table', 1),
(164, '2021_04_30_161303_create_training_categories_table', 1),
(165, '2021_05_01_205003_create_technology_training_categories_table', 1),
(166, '2021_05_02_060701_create_micro_plan_technology_trainings_table', 1),
(167, '2021_05_02_064151_create_identified_problems_table', 1),
(168, '2021_05_02_104424_create_training_titles_table', 1),
(169, '2021_05_02_110029_create_procurement_types_table', 1),
(170, '2021_05_02_113010_add_new_column_to_cig_microplans_table', 1),
(171, '2021_05_02_121418_remove_total_cost_from_cig_microplans', 1),
(172, '2021_05_02_125148_rename_identified_problem_column', 1),
(173, '2021_05_02_132853_create_training_venue_info_table', 1),
(174, '2021_05_02_140552_create_training_informations_table', 1),
(175, '2021_05_02_161431_create_procurement_methods', 1),
(176, '2021_05_02_170207_create_aif_fa_project_progress_table', 1),
(177, '2021_05_02_174348_create_trainee_info_table', 1),
(178, '2021_05_03_064942_rename_total_cost_column', 1),
(179, '2021_05_03_090844_add_new_column_to_micro_plan_technology_trainings_table', 1),
(180, '2021_05_03_114435_create_tenderers_table', 1),
(181, '2021_05_03_164041_create_committees_table', 1),
(182, '2021_05_03_175010_create_trainer_information_table', 1),
(183, '2021_05_04_090455_create_micro_plan_input_table_setups_table', 1),
(184, '2021_05_04_092707_create_training_trainee_details_table', 1),
(185, '2021_05_04_092725_create_training_venue_details_table', 1),
(186, '2021_05_04_092742_create_training_trainers_details_table', 1),
(187, '2021_05_04_122718_create_training_opening_info_table', 1),
(188, '2021_05_04_145333_create_aif_assessment_indicators_table', 1),
(189, '2021_05_04_153044_create_aif_assessment_indicator_answers_table', 1),
(190, '2021_05_04_163412_create_packages_table', 1),
(191, '2021_05_04_232435_create_micro_plan_input_table_categories_table', 1),
(192, '2021_05_05_014059_create_micro_plan_inputs_table', 1),
(193, '2021_05_05_110202_create_training_trainees_table', 1),
(194, '2021_05_05_110307_create_training_trainers_table', 1),
(195, '2021_05_05_115629_create_procurement_planned_dates_table', 1),
(196, '2021_05_05_120739_create_indicator_configurations_table', 1),
(197, '2021_05_05_162352_create_procurement_planned_date_archives_table', 1),
(198, '2021_05_05_164027_create_training_opeining_info_details_table', 1),
(199, '2021_05_06_113702_create_aif_indicator_config_details_table', 1),
(200, '2021_05_09_094019_create_training_schedules_table', 1),
(201, '2021_05_09_094149_create_schedule_details_table', 1),
(202, '2021_05_09_103243_create_schedule_details_topic_table', 1),
(203, '2021_05_09_160757_create_impact_assessments_table', 1),
(204, '2021_05_11_143522_add_new_column_to_sales_with_buyer_information_table', 1),
(205, '2021_05_11_211412_create_impact_assessment_details_table', 1),
(206, '2021_05_12_113005_add_column_is_deletable_commonlabels_table', 1),
(207, '2021_05_16_102153_add_column_project_and_organogram_in_training_informations_table', 1),
(208, '2021_05_16_132535_add_column_to_aif_fund_allocations_table', 1),
(209, '2021_05_16_185948_add_column_to_aif_impact_assessments_table', 1),
(210, '2021_05_17_111950_create_maintaining_record_of_procurements_table', 1),
(211, '2021_05_17_202402_create_inv_item_category_sub_category_information_table', 1),
(212, '2021_05_18_125905_create_beel_baselines_table', 1),
(213, '2021_05_19_090431_create_inv_item_information_table', 1),
(214, '2021_05_19_124927_create_fishing_gear_table', 1),
(215, '2021_05_19_154614_create_fish_species_info_table', 1),
(216, '2021_05_19_195450_create_beel_aquatic_species_or_weed_table', 1),
(217, '2021_05_20_091520_add_column_to_procuring_entities_table', 1),
(218, '2021_05_20_100035_add_column_to_maintaining_record_of_procurements_table', 1),
(219, '2021_05_20_101809_add_organogram_column_to_producer_organizations_table', 1),
(220, '2021_05_20_165149_add_organization_id_project_id_table', 1),
(221, '2021_05_20_174119_add_column_organogram_id_and_project_id_to_procuring_entities', 1),
(222, '2021_05_20_183816_add_column_organogram_id_and_project_id_to_procurement_types', 1),
(223, '2021_05_21_200344_create_inv_item_receive_from_supplier_information_table', 1),
(224, '2021_05_22_211929_create_inv_supplier_item_infos_table', 1),
(225, '2021_05_23_092913_add_column_organogram_id_and_project_id_to_procurement_methods', 1),
(226, '2021_05_23_100022_add_column_organogram_id_and_project_id_to_tenderers', 1),
(227, '2021_05_23_101944_add_column_organogram_id_and_project_id_to_committees', 1),
(228, '2021_05_23_112843_add_column_organogram_id_and_project_id_to_packages', 1),
(229, '2021_05_23_112850_add_column_to_technology_fiac_table', 1),
(230, '2021_05_23_121052_add_column_organogram_id_and_project_id_to_procurement_planned_dates', 1),
(231, '2021_05_23_121317_add_column_organogram_id_and_project_id_to_procurement_planned_date_archives', 1),
(232, '2021_05_23_131304_add_column_to_po_mmc_meetings_table', 1),
(233, '2021_05_23_135043_create_beel_baselines_fish_species_details_table', 1),
(234, '2021_05_23_135144_create_beel_baselines_fish_aquatic_details_table', 1),
(235, '2021_05_23_135204_create_beel_baselines_fishing_gear_details_table', 1),
(236, '2021_05_23_135219_create_beel_baselines_fish_production_details_table', 1),
(237, '2021_05_23_135242_create_beel_baselines_problems_details_table', 1),
(238, '2021_05_23_164848_alter_hatchery_nursey_fish_table', 1),
(239, '2021_05_23_170427_alter_po_sales_fish_details_table', 1),
(240, '2021_05_24_103714_alter_seed_multiplication_farm_info_table', 1),
(241, '2021_05_24_114037_alter_sales_info_table', 1),
(242, '2021_05_24_124032_alter_brood_development_receive_info_table', 1),
(243, '2021_05_24_125517_alter_brood_development_monitoring_info_table', 1),
(244, '2021_05_24_132922_alter_brood_development_fingerlings_table', 1),
(245, '2021_05_24_183259_create_crop_varieties_table', 1),
(246, '2021_05_25_095342_add_column_is_pooled_to_packages', 1),
(247, '2021_05_25_162529_alter_implemented_visit_info_table', 1),
(248, '2021_05_25_191811_add_unit_id_column_to_po_sales_collections_table', 1),
(249, '2021_05_26_111541_create_inv_item_transfer_information_table', 1),
(250, '2021_05_26_112326_create_inv_item_transfer_information_item_information_table', 1),
(251, '2021_05_26_211037_add_column_to_po_sales_collections_table', 1),
(252, '2021_05_26_213251_remove_column_from_po_sales_collections_table', 1),
(253, '2021_05_27_134857_create_inv_item_transfer_receive_information_table', 1),
(254, '2021_05_27_145030_create_inv_item_transfer_receive_information_item_information_table', 1),
(255, '2021_05_27_182417_add_column_buyer_name_to_po_sales_collections_table', 1),
(256, '2021_05_29_192506_create_inv_item_on_support_return_to_supplier_vendor_information_table', 1),
(257, '2021_05_29_211637_create_inv_return_item_infos_table', 1),
(258, '2021_05_31_134334_create_inv_item_on_support_return_from_supplier_vendor_information_table', 1),
(259, '2021_05_31_151942_create_inv_return_from_item_infos_table', 1),
(260, '2021_05_31_163343_create_inv_suppliers_table', 1),
(261, '2021_06_01_170640_add_new_column_fiac_name_to_fiacs', 1),
(262, '2021_06_02_104335_create_inv_item_return_on_supports_table', 1),
(263, '2021_06_02_162226_add_new_column_to_saaos', 1),
(264, '2021_06_03_095843_column_type_change_to_saaos_table', 1),
(265, '2021_06_03_160044_add_new_column_to_fiac_functionalities_table', 1),
(266, '2021_06_03_165744_add_column_to_fiac_functionalities_table', 1),
(267, '2021_06_06_122357_create_fiac_functionality_registers_table', 1),
(268, '2021_06_06_161626_create_fiac_functionality_equipments_table', 1),
(269, '2021_06_08_123734_create_beel_catch_data_table', 1),
(270, '2021_06_08_223453_change_column_type_reporting_month_to_fiac_functionalities_table', 1),
(271, '2021_06_09_114530_create_beel_table', 1),
(272, '2021_06_09_115236_create_alter_beel_related_migration_tabel', 1),
(273, '2021_06_09_162633_add_column_beel_id_in_beel_details_table', 1),
(274, '2021_06_10_130742_create_beel_catch_gear_number_table', 1),
(275, '2021_06_13_132507_create_beel_gear_type_details_table', 1),
(276, '2021_06_13_132600_create_beel_sample_catch_data_details_table', 1),
(277, '2021_06_13_132615_create_beel_sample_sales_data_details_table', 1),
(278, '2021_06_13_132708_create_beel_other_fishing_sample_data_table', 1),
(279, '2021_06_13_132731_create_beel_katta_fishing_sample_data_table', 1),
(280, '2021_06_13_143234_add_columns_to_beel_details_for_impact_assessment_table', 1),
(281, '2021_06_13_182810_create_beel_details_stocking_for_impact_table', 1),
(282, '2021_06_13_182827_create_beel_details_production_for_impact_table', 1),
(283, '2021_06_14_120552_add_columns_to_beel_details_fish_species_table', 1),
(284, '2021_06_14_135724_create_beel_sample_consumption_table', 1),
(285, '2021_06_14_140957_add_columns_to_beel_details_fish_aquatics_table', 1),
(286, '2021_06_15_130053_create_project_progress_activities_table', 1),
(287, '2021_06_15_164925_create_project_progress_summary_table', 1),
(288, '2021_06_15_172422_create_beel_activities_table', 1),
(289, '2021_06_15_193751_create_project_progress_summary_details_table', 1),
(290, '2021_06_16_135306_create_beel_activities_details_table', 1),
(291, '2021_06_22_165417_create_beel_activities_details_indegenus_table', 1),
(292, '2021_06_22_165430_create_beel_activities_details_spawn_table', 1),
(293, '2021_07_06_135829_delete_parent_id_and_add_category_column_in_procurement_types_table', 1),
(294, '2021_07_06_190508_alter_procurement_related_migration_table', 1),
(295, '2021_07_07_000640_add_foreign_key_in_procurement_maintaining_records_table', 1),
(296, '2021_07_07_002818_drop_column_and_add_foreign_key_in_procurement_planned_date_archives_table', 1),
(297, '2021_07_07_004036_add_foreign_key_in_procurement_packages_table', 1),
(298, '2021_07_07_004521_add_foreign_key_in_procurement_planned_dates_table', 1),
(299, '2021_07_07_095412_add_advertise_tender_days_column_in_procurement_methods_table', 1),
(300, '2021_07_07_102439_alter_column_to_cig_productions_table', 1),
(301, '2021_07_08_100507_add_new_column_to_de_worming_campaigns', 2),
(302, '2021_07_08_115011_add_new_column_to_infertility_campaigns', 3),
(303, '2021_07_11_195522_drop_foreign_of_planned_date_id_in_procurement_planned_date_archives_table', 4),
(304, '2021_07_12_124207_add_column_to_cigs_table', 5),
(305, '2021_07_12_152505_add_main_occupation_column_to_cig_members_table', 5),
(306, '2021_07_12_172907_add_column_to_cig_account_transactions_table', 5),
(307, '2021_07_13_184154_add_project_id_organogram_id_in_all_cig_scope_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int UNSIGNED NOT NULL,
  `option_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `option_name`, `option_value`) VALUES
(1, 'attachments_max_file_size', '5000000'),
(2, 'attachments_file_types', 'jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx'),
(3, 'facebook', ''),
(4, 'twitter', ''),
(5, 'linkedin', '');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` enum('BARC','DAE','DOF','DLS','PMU') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name_en`, `name_bn`, `short_name`, `code`, `address`, `phone`, `fax`, `email`, `web_address`, `comment`, `logo`, `banner`, `is_active`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Department of Agricultural Extension', 'Department of Agricultural Extension', 'DAE', 'DAE', 'Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 4, '2021-04-05 09:51:28', '2021-07-11 12:41:18'),
(3, 'Department of Fisheries', 'Department of Fisheries', 'DoF', 'DOF', 'Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, '2021-04-05 09:49:03', '2021-04-05 09:49:03'),
(4, 'Department of Livestock Services', 'Department of Livestock Services', 'DLS', 'DLS', 'Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 4, '2021-04-05 09:50:15', '2021-07-11 12:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `organograms`
--

CREATE TABLE `organograms` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Organization Id',
  `parent_id` int NOT NULL,
  `name_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_region_id` bigint UNSIGNED DEFAULT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `upazila_id` bigint UNSIGNED DEFAULT NULL,
  `union_id` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL,
  `is_inventory_center` tinyint NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL COMMENT 'author',
  `updated_by` bigint UNSIGNED DEFAULT NULL COMMENT 'modifier',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organograms`
--

INSERT INTO `organograms` (`id`, `organization_id`, `parent_id`, `name_en`, `name_bn`, `office_type`, `division_region_id`, `district_id`, `upazila_id`, `union_id`, `code`, `address`, `phone`, `fax`, `is_active`, `is_inventory_center`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 0, 'Government of the People’s Republic of Bangladesh', 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকার', '3', 0, NULL, NULL, NULL, '24951', '926 Kellie Trace Apt. 747\nModestomouth, AR 51760-9430', '+14864378046', '+1.896.935.8584', 1, 0, 4, NULL, '1986-08-22 07:16:30', NULL),
(2, 2, 1, 'DAE', 'DAE', 'pmu_office', NULL, NULL, NULL, NULL, '1', 'https://dae.gov.bd/', '1', NULL, 1, 0, 8, 4, '1987-12-11 18:18:04', '2021-07-08 16:46:05'),
(3, 2, 2, 'PIU-NATP2_DAE', 'PIU-NATP2_DAE', 'pmu_office', NULL, NULL, NULL, NULL, '82972', 'PIU-NATP2_DAE', '(797) 738-1523', '1-871-644-1071', 1, 1, 4, 4, '1971-09-25 06:19:59', '2021-07-08 16:47:43'),
(4, 2, 2, 'Dhaka Region Office', 'Dhaka Region Office', 'regional_office', 3, NULL, NULL, NULL, '101', 'Dhaka Region Office, DAE', '1', NULL, 1, 1, 4, 4, '1986-08-23 23:02:56', '2021-07-08 16:46:48'),
(5, 2, 4, 'Narsingdi District Office', 'Narsingdi District Office', 'district_office', 3, 68, NULL, NULL, '1001', 'Narsingdi District Office, DAE', '1', '+', 1, 1, 8, 4, '1979-08-30 20:57:59', '2021-07-08 16:22:57'),
(6, 2, 4, 'District Office 6', 'District Office 6', '9', 5, 1, 11006, NULL, '489', '7074 Ward Hollow Suite 925\nEast Hallie, NC 28569', '(750) 819-3976', '+1.426.414.6789', 1, 0, 5, NULL, '1975-07-02 03:39:35', NULL),
(7, 2, 4, 'District Office 7', 'District Office 7', '4', 4, 1, 11006, NULL, '94819', '21127 Clementina Trail Suite 338\nNorth Judyview, ID 62525-5272', '913.494.5788', '+1 (413) 216-5046', 1, 1, 2, NULL, '1977-05-24 06:13:07', NULL),
(8, 2, 4, 'District Office 8', 'District Office 8', '2', 7, 1, 11006, NULL, '5809', '91914 Satterfield Lane Suite 744\nJaysonville, SC 35584-3791', '+1-792-926-1341', '1-773-927-9802', 1, 1, 9, NULL, '1978-06-23 01:26:38', NULL),
(9, 2, 4, 'District Office 9', 'District Office 9', '0', 0, 1, 11006, NULL, '5484', '642 Morissette Mountain Apt. 018\nSouth Derick, AL 19172', '367-801-2370', '+1-914-412-4720', 1, 0, 5, NULL, '1970-09-11 09:57:06', NULL),
(10, 2, 4, 'District Office 10', 'District Office 10', '8', 9, 1, 11006, NULL, '885', '95369 Romaine Rest\nCarrollton, AK 81940-3807', '+1.912.319.3314', '1-278-783-5124', 1, 0, 7, NULL, '1982-02-06 23:43:27', NULL),
(11, 2, 4, 'District Office 11', 'District Office 11', '9', 3, 1, 11006, NULL, '6240', '715 Bergstrom Branch\nNew Faustinofurt, ME 50523-3549', '+1 (269) 242-7367', '217.328.8775', 1, 1, 4, NULL, '2004-12-12 09:01:35', NULL),
(12, 2, 4, 'District Office 12', 'District Office 12', '9', 1, 1, 11006, NULL, '3518', '11459 Sally Cove Suite 565\nIdaview, FL 94289-8995', '901.301.8261', '+1.463.905.7999', 1, 1, 9, NULL, '1980-06-05 00:53:36', NULL),
(13, 2, 4, 'District Office 13', 'District Office 13', '7', 9, 1, 11006, NULL, '86600', '273 Harvey Tunnel\nNew Gerard, TN 10032', '686-697-8249', '+1-309-564-6921', 1, 1, 8, NULL, '2010-07-13 21:08:11', NULL),
(14, 2, 4, 'District Office 14', 'District Office 14', '8', 1, 1, 11006, NULL, '1074', '720 Kellen Mall Apt. 534\nCummeratashire, NV 05685', '1-354-259-9738', '764-479-1388', 1, 0, 4, NULL, '1976-11-15 06:12:32', NULL),
(15, 2, 4, 'District Office 15', 'District Office 15', '6', 7, 1, 11006, NULL, '547', '45683 Howe Meadow\nWehnerport, ME 56706-9856', '454.680.1454', '979.384.7490', 1, 0, 7, NULL, '1989-07-25 13:59:16', NULL),
(16, 2, 5, 'Narsingdi Sadar Upazila', 'Narsingdi Sadar Upazila', 'upazila_office', 3, 68, 36860, NULL, '10001', 'Narsingdi Sadar Upazila, DAE', '1', NULL, 1, 1, 9, 4, '2006-02-02 06:26:53', '2021-07-08 16:23:50'),
(17, 2, 5, 'Upazila Office 17', 'Upazila Office 17', '3', 8, 1, 11006, NULL, '30728', '67203 Parker Turnpike Suite 597\nSierraton, MS 71619', '208.843.1691', '+1.268.764.2413', 1, 1, 7, NULL, '1984-04-06 18:26:22', NULL),
(18, 2, 5, 'Upazila Office 18', 'Upazila Office 18', '4', 0, 1, 11006, NULL, '885', '74133 Chanel Causeway Suite 326\nWest Myles, LA 35897', '(620) 240-8460', '+1-682-671-2169', 1, 1, 2, NULL, '1982-11-04 03:55:44', NULL),
(19, 2, 5, 'Upazila Office 19', 'Upazila Office 19', '7', 3, 1, 11006, NULL, '53887', '35514 Jaime Motorway\nDorrisshire, WA 33781', '(293) 577-2146', '(593) 615-3054', 1, 0, 8, NULL, '1984-02-09 13:22:54', NULL),
(20, 2, 5, 'Upazila Office 20', 'Upazila Office 20', '3', 4, 1, 11006, NULL, '665', '87046 Gaylord View\nSouth Cordia, IL 78779-6571', '+1-323-953-3238', '(810) 349-8823', 1, 1, 5, NULL, '1971-01-16 00:47:14', NULL),
(21, 2, 5, 'Upazila Office 21', 'Upazila Office 21', '8', 8, 1, 11006, NULL, '635', '462 Ansley Crescent Suite 157\nVerdaburgh, MO 40246', '819.709.5217', '+1.761.435.3366', 1, 1, 3, NULL, '1975-11-16 17:42:35', NULL),
(22, 2, 5, 'Upazila Office 22', 'Upazila Office 22', '8', 7, 1, 11006, NULL, '4780', '712 Weimann Causeway\nHeaneyfurt, AZ 01055-7526', '(958) 695-5731', '1-397-369-7144', 1, 0, 3, NULL, '1971-05-05 12:13:37', NULL),
(23, 2, 5, 'Upazila Office 23', 'Upazila Office 23', '7', 3, 1, 11006, NULL, '9340', '272 Hahn Common\nEast Lupe, FL 38878', '1-360-609-2670', '(213) 809-2013', 1, 1, 8, NULL, '1972-05-22 18:08:50', NULL),
(24, 2, 5, 'Upazila Office 24', 'Upazila Office 24', '7', 3, 1, 11006, NULL, '307', '68455 Marlee Station\nSouth Lindsaybury, AR 53363-0387', '+1 (593) 296-1477', '1-629-416-2084', 1, 1, 8, NULL, '1970-01-13 05:37:03', NULL),
(25, 2, 16, 'Panchdona Union Office', 'পাঁচদোনা ইউনিয়ন', 'union_office', 3, 68, 36860, 3686089, '100001', 'Panchdona Union Office', '1', NULL, 1, 0, 4, 4, '2021-05-21 00:31:25', '2021-07-08 16:25:01'),
(26, 3, 1, 'DOF', 'DOF', 'pmu_office', NULL, NULL, NULL, NULL, '2', 'https://mofl.gov.bd/', '1', NULL, 1, 0, 2, 2, '2021-07-08 16:26:27', '2021-07-08 16:45:31'),
(27, 3, 26, 'PIU-NATP2_DOF', 'PIU-NATP2_DOF', 'pmu_office', NULL, NULL, NULL, NULL, '201', 'https://natp2dof.portal.gov.bd/', '1', NULL, 1, 1, 2, 2, '2021-07-08 16:27:17', '2021-07-08 16:48:45'),
(28, 3, 26, 'Dhaka Division Office', 'Dhaka Division Office', 'regional_office', 3, NULL, NULL, NULL, '201', 'Dhaka Division Office, DOF', '1', NULL, 1, 1, 2, 2, '2021-07-08 16:33:24', '2021-07-08 16:48:18'),
(29, 3, 28, 'Narsingdi District Office', 'Narsingdi District Office', 'district_office', 3, 68, NULL, NULL, '2001', 'Narsingdi District Office, DOF', '1', NULL, 1, 1, 2, NULL, '2021-07-08 16:34:58', '2021-07-08 16:34:58'),
(30, 3, 29, 'Narsingdi Sadar Upazila', 'Narsingdi Sadar Upazila', 'upazila_office', 3, 68, NULL, NULL, '2001', 'Narsingdi Sadar Upazila', '1', NULL, 1, 1, 2, NULL, '2021-07-08 16:35:32', '2021-07-08 16:35:32'),
(31, 4, 1, 'PIU-NATP2-DLS', 'PIU-NATP2-DLS', 'pmu_office', NULL, NULL, NULL, NULL, '301', 'PIU-NATP2-DLS', '1', NULL, 1, 1, 3, NULL, '2021-07-08 16:50:07', '2021-07-08 16:50:07'),
(32, 4, 31, 'Dhaka Division Office', 'Dhaka Division Office', 'regional_office', 3, NULL, NULL, NULL, '3001', 'Dhaka Division Office, DLS', '1', NULL, 1, 1, 3, NULL, '2021-07-08 16:51:09', '2021-07-08 16:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('dls@natp.com', '$2y$10$ymDf.lTuHRorX60NGVMXIOwDpIpYm8sjduaCkXvvz2BGdWCs3GP9a', '2021-07-06 20:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Organization Id',
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `organization_id`, `slug`, `name`, `name_bn`, `permissions`, `created_at`, `updated_at`) VALUES
(1, NULL, 'administrator', 'Administrator', 'প্রশাসক', 'a:49:{i:0;s:10:\"view_users\";i:1;s:9:\"add_users\";i:2;s:10:\"edit_users\";i:3;s:12:\"delete_users\";i:4;s:17:\"user_capabilities\";i:5;s:16:\"view_users_group\";i:6;s:15:\"add_users_group\";i:7;s:16:\"edit_users_group\";i:8;s:18:\"delete_users_group\";i:9;s:22:\"view_roles_permissions\";i:10;s:21:\"add_roles_permissions\";i:11;s:22:\"edit_roles_permissions\";i:12;s:24:\"delete_roles_permissions\";i:13;s:14:\"manage_reports\";i:14;s:30:\"view_user_activity_log_reports\";i:15;s:36:\"view_item_category_sub_category_info\";i:16;s:35:\"add_item_category_sub_category_info\";i:17;s:36:\"edit_item_category_sub_category_info\";i:18;s:38:\"delete_item_category_sub_category_info\";i:19;s:14:\"view_item_info\";i:20;s:13:\"add_item_info\";i:21;s:14:\"edit_item_info\";i:22;s:16:\"delete_item_info\";i:23;s:43:\"view_item_receive_from_supplier_information\";i:24;s:42:\"add_item_receive_from_supplier_information\";i:25;s:43:\"edit_item_receive_from_supplier_information\";i:26;s:45:\"delete_item_receive_from_supplier_information\";i:27;s:29:\"view_item_request_information\";i:28;s:28:\"add_item_request_information\";i:29;s:29:\"edit_item_request_information\";i:30;s:31:\"delete_item_request_information\";i:31;s:32:\"approve_item_request_information\";i:32;s:18:\"view_supplier_info\";i:33;s:17:\"add_supplier_info\";i:34;s:18:\"edit_supplier_info\";i:35;s:20:\"delete_supplier_info\";i:36;s:14:\"manage_reports\";i:37;s:14:\"view_dashboard\";i:38;s:18:\"view_common_labels\";i:39;s:18:\"edit_common_labels\";i:40;s:20:\"delete_common_labels\";i:41;s:19:\"view_financial_year\";i:42;s:18:\"add_financial_year\";i:43;s:19:\"edit_financial_year\";i:44;s:21:\"delete_financial_year\";i:45;s:14:\"view_employees\";i:46;s:13:\"add_employees\";i:47;s:14:\"edit_employees\";i:48;s:16:\"delete_employees\";}', '2021-04-05 05:34:33', '2021-07-24 10:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL COMMENT 'employee Id',
  `user_type` enum('internal','external') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Serve as a login ID',
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `blood_group` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` bigint UNSIGNED DEFAULT NULL COMMENT 'From Common Labels: Designation',
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `user_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `user_type`, `name_en`, `name_bn`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `phone`, `address`, `blood_group`, `designation_id`, `location_id`, `user_level`, `user_image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'external', 'Inventory Manager', 'Inventory Manager', 'admin', 'admin@mail.com', NULL, '$2y$10$bggGuSSSrrAHGt8iLbrqcekAculoPNSIwBzqoTUmsni1psmzMpaDG', 'PR6ccK8AS3MdUV5x0C2TcGvWd3BAPHaAm4fzJxkuk9afgkQSWN5ynC5aXAIY', NULL, 'House-4, Road No-9/B, Nikunja-1', NULL, NULL, NULL, 'super_admin', 'user/2025-02/user-avatar-1739539239.png', 1, '2021-04-05 05:35:53', '2025-02-14 19:20:39'),
(2, NULL, NULL, 'Dr. Md. Habibur Rahman', 'Dr. Md. Habibur Rahman', 'kamal', 'habibiucse@iu.ac.bd', NULL, '$2y$10$U4SHsO3patrvoLg6WTXR1eOtqYfPKI6uQF7dA89Z.l1yg7OxtPqLG', NULL, NULL, 'House-4, Road No-9/B, Nikunja-2', NULL, 6, 65, NULL, 'user/2025-02/user-avatar-1739539277.png', 1, '2021-07-24 11:26:55', '2025-02-14 19:21:17'),
(3, NULL, NULL, 'Department Chairman', 'Department Chairman', 'dept_chairman', 'cseiu@iu.ac.bd', NULL, '$2y$10$0MSUCbfVFv2aceYdMm6dJujm/4MSp.rK4Xwy0NxWr2hPjABBUhYka', NULL, NULL, NULL, NULL, 53, 66, NULL, 'user/2025-02/user-avatar-1739539260.png', 1, '2021-07-30 18:23:32', '2025-02-14 19:21:00'),
(4, NULL, NULL, 'Musa', 'মুসা', 'abumusa', 'mkmmusas1995@gmail.com', NULL, '$2y$10$ZLVbZvnNIwDBRGxWpsNemuPr4VQwxf4XLh4dL65u6ItHEZQD5WJme', NULL, '01826573620', 'Sonirakhra, jatarabari, Dhaka', 'O+', 61, 69, NULL, NULL, 1, '2025-02-17 10:03:46', '2025-02-17 10:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id` int UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`id`, `user_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 1, '_role', 'a:1:{i:0;s:13:\"administrator\";}', NULL, NULL),
(2, 2, '_role', 'a:1:{i:0;s:13:\"administrator\";}', NULL, NULL),
(3, 2, '_capabilities', 'a:7:{i:0;s:36:\"view_item_category_sub_category_info\";i:1;s:14:\"view_item_info\";i:2;s:29:\"view_item_request_information\";i:3;s:28:\"add_item_request_information\";i:4;s:29:\"edit_item_request_information\";i:5;s:31:\"delete_item_request_information\";i:6;s:14:\"view_dashboard\";}', NULL, NULL),
(4, 3, '_role', 'a:1:{i:0;s:13:\"administrator\";}', NULL, NULL),
(7, 4, '_role', 'a:1:{i:0;s:13:\"administrator\";}', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_logs`
--
ALTER TABLE `access_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `common_labels`
--
ALTER TABLE `common_labels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_status_date` (`data_type`,`status`,`created_at`,`id`),
  ADD KEY `common_labels_created_by_foreign` (`created_by`),
  ADD KEY `common_labels_updated_by_foreign` (`updated_by`),
  ADD KEY `common_labels_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_designation_id_foreign` (`designation_id`),
  ADD KEY `employees_employee_type_id_foreign` (`employee_type_id`),
  ADD KEY `employees_employee_category_id_foreign` (`employee_category_id`),
  ADD KEY `employees_employee_class_id_foreign` (`employee_class_id`),
  ADD KEY `employees_updated_by_foreign` (`updated_by`),
  ADD KEY `employees_created_by_index` (`created_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inv_item_allocations`
--
ALTER TABLE `inv_item_allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_allocation_details`
--
ALTER TABLE `inv_item_allocation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_category_sub_category_information`
--
ALTER TABLE `inv_item_category_sub_category_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_information`
--
ALTER TABLE `inv_item_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_on_support_return_from_supplier_vendor_information`
--
ALTER TABLE `inv_item_on_support_return_from_supplier_vendor_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_on_support_return_to_supplier_vendor_information`
--
ALTER TABLE `inv_item_on_support_return_to_supplier_vendor_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_receive_from_supplier_information`
--
ALTER TABLE `inv_item_receive_from_supplier_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_return_on_supports`
--
ALTER TABLE `inv_item_return_on_supports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_item_return_on_supports_supplier_vendor_foreign` (`supplier_vendor`);

--
-- Indexes for table `inv_item_transfer_information`
--
ALTER TABLE `inv_item_transfer_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_transfer_information_item_information`
--
ALTER TABLE `inv_item_transfer_information_item_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_transfer_receive_information`
--
ALTER TABLE `inv_item_transfer_receive_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_item_transfer_receive_information_item_information`
--
ALTER TABLE `inv_item_transfer_receive_information_item_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_request_items`
--
ALTER TABLE `inv_request_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_request_item_approval_history`
--
ALTER TABLE `inv_request_item_approval_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_request_item_details`
--
ALTER TABLE `inv_request_item_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_return_from_item_infos`
--
ALTER TABLE `inv_return_from_item_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_return_items`
--
ALTER TABLE `inv_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_return_item_details`
--
ALTER TABLE `inv_return_item_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_return_item_infos`
--
ALTER TABLE `inv_return_item_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_stocks`
--
ALTER TABLE `inv_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_suppliers`
--
ALTER TABLE `inv_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_suppliers_organization_id_foreign` (`organization_id`),
  ADD KEY `inv_suppliers_tender_id_foreign` (`tender_id`);

--
-- Indexes for table `inv_supplier_item_infos`
--
ALTER TABLE `inv_supplier_item_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_option_name_index` (`option_name`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_permissions_slug_unique` (`slug`),
  ADD KEY `roles_permissions_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD KEY `users_designation_id_foreign` (`designation_id`),
  ADD KEY `users_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_meta_user_id_index` (`user_id`),
  ADD KEY `user_meta_meta_key_index` (`meta_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_logs`
--
ALTER TABLE `access_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `common_labels`
--
ALTER TABLE `common_labels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_allocations`
--
ALTER TABLE `inv_item_allocations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `inv_item_allocation_details`
--
ALTER TABLE `inv_item_allocation_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `inv_item_category_sub_category_information`
--
ALTER TABLE `inv_item_category_sub_category_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inv_item_information`
--
ALTER TABLE `inv_item_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inv_item_on_support_return_from_supplier_vendor_information`
--
ALTER TABLE `inv_item_on_support_return_from_supplier_vendor_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_on_support_return_to_supplier_vendor_information`
--
ALTER TABLE `inv_item_on_support_return_to_supplier_vendor_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_receive_from_supplier_information`
--
ALTER TABLE `inv_item_receive_from_supplier_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_item_return_on_supports`
--
ALTER TABLE `inv_item_return_on_supports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_transfer_information`
--
ALTER TABLE `inv_item_transfer_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_transfer_information_item_information`
--
ALTER TABLE `inv_item_transfer_information_item_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_transfer_receive_information`
--
ALTER TABLE `inv_item_transfer_receive_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_transfer_receive_information_item_information`
--
ALTER TABLE `inv_item_transfer_receive_information_item_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_request_items`
--
ALTER TABLE `inv_request_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `inv_request_item_approval_history`
--
ALTER TABLE `inv_request_item_approval_history`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inv_request_item_details`
--
ALTER TABLE `inv_request_item_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `inv_return_from_item_infos`
--
ALTER TABLE `inv_return_from_item_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_return_items`
--
ALTER TABLE `inv_return_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_return_item_details`
--
ALTER TABLE `inv_return_item_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_return_item_infos`
--
ALTER TABLE `inv_return_item_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_stocks`
--
ALTER TABLE `inv_stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inv_suppliers`
--
ALTER TABLE `inv_suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inv_supplier_item_infos`
--
ALTER TABLE `inv_supplier_item_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `common_labels`
--
ALTER TABLE `common_labels`
  ADD CONSTRAINT `common_labels_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `common_labels_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `common_labels` (`id`),
  ADD CONSTRAINT `employees_employee_category_id_foreign` FOREIGN KEY (`employee_category_id`) REFERENCES `common_labels` (`id`),
  ADD CONSTRAINT `employees_employee_class_id_foreign` FOREIGN KEY (`employee_class_id`) REFERENCES `common_labels` (`id`),
  ADD CONSTRAINT `employees_employee_type_id_foreign` FOREIGN KEY (`employee_type_id`) REFERENCES `common_labels` (`id`),
  ADD CONSTRAINT `employees_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inv_item_return_on_supports`
--
ALTER TABLE `inv_item_return_on_supports`
  ADD CONSTRAINT `inv_item_return_on_supports_supplier_vendor_foreign` FOREIGN KEY (`supplier_vendor`) REFERENCES `inv_suppliers` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `common_labels` (`id`);

--
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD CONSTRAINT `user_meta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
