-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2017 at 07:35 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `picraffle`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contest`
--

CREATE TABLE `tbl_contest` (
  `contest_id` int(11) NOT NULL,
  `prize` int(11) NOT NULL,
  `t30_tickets_price` int(11) NOT NULL,
  `t70_tickets_price` int(11) NOT NULL,
  `t120_tickets_price` int(11) NOT NULL,
  `t200_tickets_price` int(11) NOT NULL,
  `contest_date` date NOT NULL,
  `owner` int(11) NOT NULL,
  `owner_ticket` int(11) NOT NULL,
  `recommended_by` int(11) NOT NULL,
  `price_one_ticket` int(11) NOT NULL DEFAULT '1',
  `duration` time NOT NULL DEFAULT '23:59:59',
  `pending_status` enum('owned','pending','pended') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contest`
--

INSERT INTO `tbl_contest` (`contest_id`, `prize`, `t30_tickets_price`, `t70_tickets_price`, `t120_tickets_price`, `t200_tickets_price`, `contest_date`, `owner`, `owner_ticket`, `recommended_by`, `price_one_ticket`, `duration`, `pending_status`, `updated`) VALUES
(1, 500, 101, 150, 200, 151, '2017-10-17', 0, 0, 0, 1, '00:00:00', 'owned', '2017-10-17 06:24:02'),
(2, 500, 100, 151, 200, 150, '2017-10-21', 0, 0, 0, 1, '00:00:00', 'owned', '2017-10-21 15:08:50'),
(4, 500, 100, 150, 200, 150, '2017-10-22', 4, 8, 0, 1, '00:00:00', 'owned', '2017-10-23 01:15:56'),
(5, 500, 100, 150, 200, 150, '2017-10-23', 4, 14, 0, 1, '00:00:00', 'owned', '2017-12-09 06:14:22'),
(6, 500, 100, 150, 200, 150, '2017-10-26', 0, 0, 0, 1, '00:00:00', 'owned', '2017-10-25 22:30:19'),
(7, 500, 100, 150, 200, 150, '2017-10-27', 0, 0, 0, 2, '00:00:00', 'owned', '2017-10-27 18:18:32'),
(8, 493, 100, 150, 200, 150, '2017-11-18', 0, 0, 0, 1, '00:00:00', 'owned', '2017-11-18 16:06:19'),
(10, 500, 100, 150, 200, 150, '2017-11-24', 5, 28, 0, 1, '00:00:00', 'pending', '2017-12-09 06:14:28'),
(11, 500, 100, 150, 200, 150, '2017-12-05', 0, 0, 0, 1, '00:00:00', 'owned', '2017-12-05 15:31:04'),
(12, 500, 100, 150, 200, 150, '2017-12-06', 6, 36, 0, 1, '00:00:00', 'owned', '2017-12-06 04:14:59'),
(14, 500, 5, 10, 20, 30, '2017-12-08', 5, 43, 0, 1, '21:54:59', 'owned', '2017-12-08 20:20:14'),
(15, 500, 100, 150, 200, 150, '2017-12-09', 0, 0, 0, 1, '18:53:34', 'owned', '2017-12-09 05:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device`
--

CREATE TABLE `tbl_device` (
  `dev_id` int(11) NOT NULL,
  `dev_token` varchar(256) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_device`
--

INSERT INTO `tbl_device` (`dev_id`, `dev_token`, `updated`) VALUES
(8, '85acc6b710d74b20054d5c9e10e32d92a666c77df2d002d5b25b8b1a92ce6f25', '2017-12-06 02:32:21'),
(9, '468a50aa32c685d4fe51bc8f25ee8a55f53d95be5145a5ec92385431317635db', '2017-12-08 19:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `itemId` int(11) NOT NULL,
  `itemHeader` varchar(512) NOT NULL COMMENT 'Heading',
  `itemSub` varchar(1021) NOT NULL COMMENT 'sub heading',
  `itemDesc` text COMMENT 'content or description',
  `itemImage` varchar(80) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`itemId`, `itemHeader`, `itemSub`, `itemDesc`, `itemImage`, `isDeleted`, `createdBy`, `createdDtm`, `updatedDtm`, `updatedBy`) VALUES
(1, 'jquery.validation.js', 'Contribution towards jquery.validation.js', 'jquery.validation.js is the client side javascript validation library authored by Jörn Zaefferer hosted on github for us and we are trying to contribute to it. Working on localization now', 'validation.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL),
(2, 'CodeIgniter User Management', 'Demo for user management system', 'This the demo of User Management System (Admin Panel) using CodeIgniter PHP MVC Framework and AdminLTE bootstrap theme. You can download the code from the repository or forked it to contribute. Usage and installation instructions are provided in ReadMe.MD', 'cias.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `noti_id` int(11) NOT NULL,
  `noti_content` text NOT NULL,
  `noti_type` enum('create_contest','change_contest','picked_winner','other') NOT NULL,
  `noti_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`noti_id`, `noti_content`, `noti_type`, `noti_date`) VALUES
(1, 'test', 'create_contest', '2017-11-18 20:54:07'),
(2, 'Hello\r\n', 'create_contest', '2017-11-19 19:18:31'),
(3, 'Hello', 'other', '2017-11-20 23:28:52'),
(4, 'test', 'create_contest', '2017-11-20 20:47:03'),
(5, 'test notification', 'create_contest', '2017-11-20 20:47:38'),
(6, 'hello notificationhellohellohello\r\n', 'other', '2017-11-20 23:37:31'),
(7, 'add\r\n', 'other', '2017-11-24 03:49:56'),
(8, 'testaaaaaahfhgfuhgjhgjk', 'other', '2017-11-24 04:58:28'),
(9, 'adfasdfaaakjhkjhkh', 'other', '2017-11-24 04:59:09'),
(10, 'jhgjhgkjjhfhgfuygiugiuhkjnlk\r\n', 'other', '2017-11-24 04:57:49'),
(11, 'Today contest is created.', 'create_contest', '2017-11-24 04:21:28'),
(12, 'jkgikhkkjlj;', 'other', '2017-11-24 04:59:51'),
(13, 'jkgikhkkjlj;', 'other', '2017-11-24 04:59:51'),
(14, 'Today contest is created.', 'create_contest', '2017-12-05 15:31:04'),
(15, 'Today contest is created.', 'create_contest', '2017-12-05 23:10:42'),
(16, 'test', 'other', '2017-12-06 02:11:29'),
(17, 'testtest', 'other', '2017-12-06 02:25:14'),
(18, 'test', 'other', '2017-12-06 02:27:32'),
(19, 'test', 'other', '2017-12-06 02:28:28'),
(20, 'Today contest is created.', 'create_contest', '2017-12-08 13:20:59'),
(21, 'Today contest is created.', 'create_contest', '2017-12-08 14:05:03'),
(22, 'Today contest is created.', 'create_contest', '2017-12-08 23:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reset_password`
--

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` bigint(20) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Manager'),
(3, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tickets`
--

CREATE TABLE `tbl_tickets` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `image_name` varchar(256) NOT NULL,
  `location` varchar(256) DEFAULT NULL,
  `is_owned` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tickets`
--

INSERT INTO `tbl_tickets` (`ticket_id`, `user_id`, `contest_id`, `image_name`, `location`, `is_owned`, `updated`) VALUES
(1, 4, 2, '3f1156d182e4a153706c9a61ad68314d.jpg', NULL, 0, '2017-10-21 16:03:32'),
(2, 4, 4, '81cfeb2739d71fe9d8c49e42da4561f7.jpg', NULL, 0, '2017-10-22 20:30:25'),
(3, 4, 4, '8d0fcf78cfff3873cb6e4b8e1e48c3e2.jpg', NULL, 0, '2017-10-22 20:46:02'),
(4, 4, 4, '85c7d7b593459d029d654c5391838f68.jpg', NULL, 0, '2017-10-22 21:00:04'),
(5, 4, 4, 'c37d6015d872a658d6fe6ac1d34d4d67.jpg', NULL, 0, '2017-10-22 21:00:17'),
(6, 4, 4, '3bb49931ed7126bf18b70565e734cb4a.jpg', NULL, 0, '2017-10-22 21:00:23'),
(7, 4, 4, '8043bf1b079e4e4206187714f444b04f.jpg', NULL, 0, '2017-10-22 21:00:32'),
(8, 4, 4, '6dde4d0c70c3e264f5fb44f5f67e85ee.png', NULL, 1, '2017-10-23 01:15:11'),
(9, 5, 4, 'a6dbf7e76c814f8f95961fd20b6a1f34.jpg', NULL, 0, '2017-10-22 21:04:47'),
(10, 5, 5, '0fd483cab3a485e14d2a1b3be21d8b7a.jpg', NULL, 0, '2017-10-23 00:49:45'),
(11, 5, 5, '56405f1edb0b446eba57fedb375cce0c.jpg', NULL, 0, '2017-10-23 06:39:49'),
(12, 5, 5, '054f36a77f1d21822167b97c8700727a.jpg', NULL, 0, '2017-10-23 02:31:28'),
(13, 5, 5, '6c488798b7cfe44bb460f382f53f22e9.jpg', NULL, 0, '2017-10-23 01:16:55'),
(14, 4, 5, '9c589db2bf215cb10f476ce69ed0cff7.png', NULL, 1, '2017-10-23 06:39:49'),
(15, 4, 6, 'f0615b12cda0fc349e6127502b145a58.jpg', NULL, 0, '2017-10-25 22:38:56'),
(16, 4, 7, 'bf0df7e4ec8e2e90ed5b284838bde6f1.jpg', NULL, 0, '2017-10-27 21:54:15'),
(17, 5, 9, 'afb227a9c78b204d7c847b0d86a8785a.jpg', NULL, 0, '2017-11-24 03:56:46'),
(18, 5, 9, '9d41d754d45336d53e59082df6f44af6.jpg', NULL, 0, '2017-11-24 02:32:25'),
(19, 5, 9, 'f4181719b52f7ae479760ee8da6feaa2.jpg', NULL, 0, '2017-11-24 04:05:26'),
(20, 5, 9, '8fa878b4f76e80ccbfa08e14bcac0243.jpg', NULL, 0, '2017-11-24 02:55:13'),
(21, 5, 9, '0af29037e6b27a893af44517716dc9b8.jpg', NULL, 1, '2017-11-24 04:05:26'),
(22, 5, 9, 'f082906f6fb17bf6a3914a874f01d0de.jpg', NULL, 0, '2017-11-24 04:03:54'),
(23, 5, 9, 'fcba79bcf064611528f1464ba455cc3b.jpg', NULL, 0, '2017-11-24 03:06:56'),
(24, 5, 9, '897fc08d9b96cf4ac87b520ae374a7a9.jpg', NULL, 0, '2017-11-24 03:12:31'),
(25, 5, 9, '4d8ed9bac36a2c1f6fa41a19dea64793.jpeg', NULL, 0, '2017-11-24 03:47:58'),
(26, 5, 9, 'f51550cc869db03c05224d3b01ea4985.png', NULL, 0, '2017-11-24 03:48:33'),
(27, 5, 9, '451920dc6c396bbee2934636de6d06cd.gif', NULL, 0, '2017-11-24 03:48:46'),
(28, 5, 10, 'b5cc81154498c1384bd174376ac0c8d6.png', NULL, 1, '2017-11-24 05:10:24'),
(29, 5, 10, '5603303d91c6d3665770cba21a02a772.jpeg', NULL, 0, '2017-11-24 05:04:05'),
(30, 5, 10, 'e89d47931bc908d3f0ed4b85c9bea683.gif', NULL, 0, '2017-11-24 05:10:24'),
(31, 5, 10, '6d463be493c962da87e8ad1cee7a6cae.png', NULL, 0, '2017-11-24 05:01:37'),
(32, 5, 11, '0d8e8ce7041db65330ab627fa60956d5.jpg', 'shenyang, china', 0, '2017-12-05 21:58:41'),
(33, 5, 11, 'e3a3afa881f05a498633be3c4dc1814c.jpg', 'Shenyang, China', 0, '2017-12-05 22:22:00'),
(34, 5, 11, '2bf05cf0ab624f64cc48391f16fd7f28.jpg', 'Shenyang, China', 0, '2017-12-05 22:39:03'),
(35, 5, 12, '58b16a674f422a92cb9ebb8ab5605a43.jpg', 'Shenyang, China', 0, '2017-12-06 03:59:39'),
(36, 6, 12, '3bf163f520a3a2060e8cdcde7c45a7d9.jpg', 'Shenyang, China', 1, '2017-12-06 04:14:59'),
(37, 6, 12, '1518b8088df35c78c6aaf5a583dbfb3d.jpg', 'Shenyang, China', 0, '2017-12-06 01:44:49'),
(38, 6, 12, 'ebb5a7219cb6bd3c634f1baead5b7516.jpg', 'Shenyang, China', 0, '2017-12-06 03:59:03'),
(39, 6, 12, '27d5d81b041257fd22ffb42abe77df62.jpg', 'Shenyang, China', 0, '2017-12-06 03:54:25'),
(40, 5, 12, '09848f85439aa098b07fccf2234b4737.jpg', 'Shenyang, China', 0, '2017-12-06 04:14:59'),
(41, 5, 13, '76aef2983ba06c2f2e451a34fc116549.jpg', 'Shenyang, China', 0, '2017-12-08 13:23:10'),
(42, 5, 13, '86e28275a5f71536337021daa34050f4.jpg', 'Shenyang, China', 0, '2017-12-08 13:53:01'),
(43, 5, 14, '64aef3d6a4e27478de88a2ae40d0d0a7.jpg', '(null), (null)', 1, '2017-12-08 20:07:31'),
(44, 5, 14, '3c77c75484f19138000b4893a983cfd0.jpg', 'Shenyang, China', 0, '2017-12-08 20:07:31'),
(45, 5, 14, '4c4880466a1ad9c08d84b51e2cf754e0.jpg', 'Shenyang, China', 0, '2017-12-08 20:52:58'),
(46, 5, 14, 'c764bf3954143a67e92776f72f933514.jpg', 'Shenyang, China', 0, '2017-12-08 20:54:39'),
(47, 5, 15, 'e60176d6d0ff73d908772005d7af6949.jpg', 'Shenyang, China', 0, '2017-12-09 01:06:50'),
(48, 5, 15, '88cc02d2ccb73923a575da5c6e8de45c.jpg', 'Shenyang, China', 0, '2017-12-09 01:07:16'),
(49, 5, 15, '3e1f96cec96aeee9a2182ef2919e611a.jpg', 'Shenyang, China', 0, '2017-12-09 01:07:34'),
(50, 5, 15, '217fec794161bffdc6c4b9cc9bc63a70.jpg', 'Shenyang, China', 0, '2017-12-09 05:55:55'),
(51, 5, 15, 'c15df11e41782221c4a3aafbdc343401.jpg', 'Shenyang, China', 0, '2017-12-09 05:55:57'),
(52, 5, 15, '8450b402982675494eeb8aa1a544f756.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:00'),
(53, 5, 15, 'ef31d3f00450afa116e40bb57e1f50bd.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:02'),
(54, 5, 15, '36405cf618e016ba665d620c4bb72c96.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:11'),
(55, 5, 15, 'ac6c058c38e3b7a82f53724924ce6074.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:24'),
(56, 5, 15, '597808411f6e53003b472a0f0a4265ce.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:28'),
(57, 5, 15, 'e8e770497a0e287c8534df110a83fc41.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:32'),
(58, 5, 15, '4003e436634a6e960a19bca128bcdcc9.jpg', 'Shenyang, China', 0, '2017-12-09 05:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transact_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`id`, `user_id`, `amount`, `transact_datetime`) VALUES
(1, 5, '100', '2017-11-24 05:43:29'),
(2, 5, '1', '2017-12-08 21:21:13'),
(3, 5, '5', '2017-12-08 21:22:09'),
(4, 5, '5', '2017-12-08 21:32:15'),
(5, 5, '5', '2017-12-08 21:36:26'),
(6, 5, '150', '2017-12-09 00:25:59'),
(7, 5, '150', '2017-12-09 00:26:46'),
(8, 5, '150', '2017-12-09 00:29:50'),
(9, 5, '100', '2017-12-09 00:40:57'),
(10, 5, '100', '2017-12-09 00:43:09'),
(11, 5, '100', '2017-12-09 00:44:40'),
(12, 5, '100', '2017-12-09 00:49:01'),
(13, 5, '100', '2017-12-09 00:49:33'),
(14, 5, '100', '2017-12-09 00:54:31'),
(15, 5, '100', '2017-12-09 00:59:16'),
(16, 5, '100', '2017-12-09 01:01:41'),
(17, 5, '100', '2017-12-09 01:03:03'),
(18, 5, '100', '2017-12-09 01:32:19'),
(19, 5, '100', '2017-12-09 01:33:46'),
(20, 5, '100', '2017-12-09 01:34:59'),
(21, 5, '100', '2017-12-09 01:35:41'),
(22, 5, '100', '2017-12-09 01:36:15'),
(23, 5, '100', '2017-12-09 01:36:51'),
(24, 5, '100', '2017-12-09 01:45:42'),
(25, 5, '100', '2017-12-09 01:59:00'),
(26, 5, '100', '2017-12-09 02:00:06'),
(27, 5, '100', '2017-12-09 02:06:29'),
(28, 5, '100', '2017-12-09 06:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `account_image_name` varchar(256) DEFAULT NULL,
  `tickets` int(11) NOT NULL DEFAULT '0',
  `paypal_email` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `email`, `password`, `name`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`, `account_image_name`, `tickets`, `paypal_email`) VALUES
(1, 'admin@codeinsect.com', '$2y$10$J8lh9TQT.vqgng7MPOXUwOE2KVY2F.Mc0HjKxIn6jJ5F6c4EEcGTa', 'System Administrator', '9890098900', 1, 0, 0, '2015-07-01 18:56:49', 1, '2017-10-08 04:17:44', NULL, 0, NULL),
(2, 'manager@codeinsect.com', '$2y$10$quODe6vkNma30rcxbAHbYuKYAZQqUaflBgc4YpV9/90ywd.5Koklm', 'Manager', '9890098900', 2, 0, 1, '2016-12-09 17:49:56', 1, '2017-02-10 17:23:53', NULL, 0, NULL),
(3, 'employee@codeinsect.com', '$2y$10$M3ttjnzOV2lZSigBtP0NxuCtKRte70nc8TY5vIczYAQvfG/8syRze', 'Employee', '9890098900', 3, 0, 1, '2016-12-09 17:50:22', NULL, NULL, NULL, 0, NULL),
(4, 'test@gmail.com', '$2y$10$DAtFdumz7cZrS3gNImU21.1EMHz4BR7g94q4zzE6rDvdInwzE1uNe', 'test', '1234567890', 3, 1, -1, '2017-10-11 07:45:43', 4, '2017-10-26 00:38:25', 'cd4c5b0bd39d7564fc1597abbd686750.jpg', 0, ''),
(5, 'test@mail.com', '$2y$10$ub9o.2lpYPC1w2HUaNkuyui18OOoYEXGiqzOFxyd7QEEB0/sqbhra', 'Test', '1234567890', 3, 0, 1, '2017-10-22 23:03:59', 1, '2017-12-08 14:21:40', '43630d235664b5b4ec340f36af6cdbca.jpg', 137, 'payer@example.com'),
(6, 'test1@test.com', '$2y$10$uCAC7fQs/l8EZSIi1/L0a.bDkcMOZoy5rceXStmnV8.qiPSsNokGy', 'Test1', '1234567890', 3, 0, -1, '2017-10-25 05:49:22', 1, '2017-12-06 01:37:09', 'd38b2e8a09e975c1bfbb85f6a50cf25d.jpg', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_contest`
--
ALTER TABLE `tbl_contest`
  ADD PRIMARY KEY (`contest_id`);

--
-- Indexes for table `tbl_device`
--
ALTER TABLE `tbl_device`
  ADD PRIMARY KEY (`dev_id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `tbl_tickets`
--
ALTER TABLE `tbl_tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_contest`
--
ALTER TABLE `tbl_contest`
  MODIFY `contest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_device`
--
ALTER TABLE `tbl_device`
  MODIFY `dev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_tickets`
--
ALTER TABLE `tbl_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
