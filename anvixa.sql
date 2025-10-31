-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2025 at 02:03 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anvixa`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `iCategoryId` int NOT NULL AUTO_INCREMENT,
  `strCategoryName` varchar(50) NOT NULL,
  `strSlug` varchar(50) NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `strIP` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iCategoryId`),
  UNIQUE KEY `uniq_category_name` (`strCategoryName`),
  UNIQUE KEY `uniq_category_slug` (`strSlug`),
  UNIQUE KEY `category_strslug_unique` (`strSlug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`iCategoryId`, `strCategoryName`, `strSlug`, `iStatus`, `isDelete`, `strIP`, `created_at`, `updated_at`) VALUES
(1, 'Document', 'document', 1, 0, '127.0.0.1', '2025-07-15 12:02:27', '2025-10-30 09:45:05'),
(2, 'Gallary', 'gallary', 1, 0, '127.0.0.1', '2025-07-15 12:02:38', '2025-10-30 09:44:49'),
(3, 'Podcast', 'podcast', 1, 0, '127.0.0.1', '2025-07-15 12:41:45', '2025-10-30 09:44:28'),
(4, 'Video', 'video', 1, 0, '127.0.0.1', '2025-07-16 09:43:55', '2025-10-30 09:38:40'),
(5, 'ksjkgjj', 'kfjkfj', 1, 1, '127.0.0.1', '2025-07-16 09:44:01', '2025-07-16 10:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `document_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `document` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `category_id` int NOT NULL,
  `subcategory_id` int NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`document_id`, `title`, `slug`, `document`, `category_id`, `subcategory_id`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'kjglkjglkjgj', 'kjglkjglkjgj', 'galleries/QVPynoIe61TYgko9yamIgbUkWwvsLYeM9nxUK8Js.png', 2, 4, 1, 0, '2025-10-30 17:21:24', '2025-10-30 17:21:24'),
(2, 'test document', 'test-document', 'uploads/documents/69036e808baae-ancd.pdf', 1, 5, 1, 0, '2025-10-30 17:41:50', '2025-10-30 19:26:16'),
(3, 'ksjlkj', 'ksjlkj', 'uploads/documents/69036dfd5100d-ancd.pdf', 1, 5, 1, 0, '2025-10-30 19:24:05', '2025-10-30 19:24:05');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `gallery_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `image` varchar(100) NOT NULL,
  `category_id` int NOT NULL,
  `subcategory_id` int NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gallery_id`, `title`, `slug`, `image`, `category_id`, `subcategory_id`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'kjglkjglkjgj', 'kjglkjglkjgj', 'uploads/gallery/69036260a5511-image2.png', 2, 4, 1, 0, '2025-10-30 17:21:24', '2025-10-30 18:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

DROP TABLE IF EXISTS `inquiry`;
CREATE TABLE IF NOT EXISTS `inquiry` (
  `inquiry_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `mobileNumber` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text,
  `strIp` varchar(50) NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`inquiry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `podcast_episode`
--

DROP TABLE IF EXISTS `podcast_episode`;
CREATE TABLE IF NOT EXISTS `podcast_episode` (
  `podcast_id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `category_id` int NOT NULL,
  `subcategory_id` int NOT NULL,
  `podcast_title` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `video_link` varchar(200) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`podcast_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `podcast_episode`
--

INSERT INTO `podcast_episode` (`podcast_id`, `slug`, `category_id`, `subcategory_id`, `podcast_title`, `video_link`, `image`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, '', 4, 1, 'test master video', 'https://youtu.be/QN1ITp74Kkw?si=hpFxQn9aDU-0EfiG', NULL, 1, 0, '2025-10-30 15:53:25', '2025-10-30 15:53:25'),
(2, 'test-podcast-video', 4, 1, 'test podcast video', 'https://youtu.be/E9SffEsFyaw?si=wc3f7B3ij8Ex-Iha', NULL, 1, 0, '2025-10-30 16:17:30', '2025-10-30 16:17:30'),
(3, 'test-podcast-video-21', 4, 1, 'test podcast video 21', 'https://youtu.be/xeXV1KoX034?si=JQNjRKnKzKnWu1ci-kjafhkfhf', 'videos/jK8nsL1qhXUsU0F5ZKULx9elZpKl5VJxxcULLGV2.webp', 1, 0, '2025-10-30 16:34:14', '2025-10-30 16:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06'),
(2, 'Employee', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06'),
(3, 'Vendor', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sendemaildetails`
--

DROP TABLE IF EXISTS `sendemaildetails`;
CREATE TABLE IF NOT EXISTS `sendemaildetails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `strSubject` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strTitle` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strFromMail` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ToMail` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strCC` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strBCC` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sendemaildetails`
--

INSERT INTO `sendemaildetails` (`id`, `strSubject`, `strTitle`, `strFromMail`, `ToMail`, `strCC`, `strBCC`) VALUES
(4, 'Contact Inquiry', 'Sukti', 'support@sukti.in', NULL, '', ''),
(8, 'Forget Password', 'Sukti', 'support@sukti.in', NULL, NULL, NULL),
(9, 'sign_up', 'Sukti', 'support@sukti.in', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sitename` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `strIP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `logo`, `email`, `iStatus`, `isDelete`, `created_at`, `updated_at`, `strIP`) VALUES
(1, 'Jewellery crm', '1746446528.png', 'dev5.apolloinfotech@gmail.com', 1, 0, '2025-05-05 12:02:08', NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE IF NOT EXISTS `sub_category` (
  `iSubCategoryId` int NOT NULL AUTO_INCREMENT,
  `strSubCategoryName` varchar(50) NOT NULL,
  `strSlug` varchar(50) NOT NULL,
  `iCategoryId` int NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `strIP` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iSubCategoryId`),
  KEY `fk_sub_category_category` (`iCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`iSubCategoryId`, `strSubCategoryName`, `strSlug`, `iCategoryId`, `iStatus`, `isDelete`, `strIP`, `created_at`, `updated_at`) VALUES
(1, 'Master Video1', 'master-video1', 4, 1, 0, '127.0.0.1', '2025-10-30 09:49:47', '2025-10-30 10:04:27'),
(2, 'test', 'test', 3, 1, 0, '127.0.0.1', '2025-10-30 10:02:31', '2025-10-30 10:02:31'),
(3, 'test podcast', 'test-podcast', 3, 1, 0, '127.0.0.1', '2025-10-30 10:03:01', '2025-10-30 10:03:01'),
(4, 'test gallery', 'test-gallery', 2, 1, 0, '127.0.0.1', '2025-10-30 11:46:36', '2025-10-30 11:46:36'),
(5, 'test document', 'test-document', 1, 1, 0, '127.0.0.1', '2025-10-30 12:10:56', '2025-10-30 12:10:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '2' COMMENT '1=Admin, 2=TA/TP',
  `otp` int DEFAULT NULL,
  `otpTimeOut` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `email_verified_at`, `password`, `role_id`, `otp`, `otpTimeOut`, `status`, `remember_token`, `device_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'admin', 'admin@admin.com', '9876543210', NULL, '$2y$10$sPrSb4x/ajMNN4OAnT6pLe4jQXOovPn.05aQ9HlpTA5faYqRTUilO', 1, NULL, NULL, 1, NULL, NULL, '2022-09-12 04:33:06', '2025-07-14 09:48:46'),
(3, 'test user', NULL, 'user123@gmail.com', '9874569878', NULL, '$2y$10$RZ.83m0wM81MfbOkP2iZo.sBTQV/ibcZW80ObuuahAfcrIEAj/a8C', 2, NULL, NULL, 1, NULL, NULL, '2024-03-07 12:24:52', '2024-03-13 16:20:41'),
(4, 'sweta panchal', NULL, 'swetapanchal@gmail.com', '6353143092', NULL, '$2y$10$nWG.apkCeb27rHsao9PnWOPhsshV5cp5OVQzdEPLTiSE7SbZlqAXi', 2, 618888, NULL, 1, NULL, NULL, '2024-03-07 13:29:04', '2024-03-12 14:56:44'),
(5, 'abc', NULL, 'abc@gmail.com', '9532355555', NULL, '$2y$10$mWRzBa9NkHc2RsYTtglZBuro0G0IWMUMqzSazlLLI.kUb2u8I//Xm', 2, NULL, NULL, 1, NULL, NULL, '2024-03-07 13:32:41', '2024-03-07 13:32:41'),
(7, 'prerna parekh', NULL, 'angelrathod96@gmail.com', '8888888888', NULL, '$2y$10$yt/eN588jx3TpGIAOVbMaeE9BJmoovlqNv7pP7FMG2RuBAW2UwJuO', 2, 909478, '2024-04-05 16:22:12', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMxOTM2MCwiZXhwIjoxNzEyMzYyNTYwLCJuYmYiOjE3MTIzMTkzNjAsImp0aSI6ImJZVlZhNVFPcVlDS2xBcUIiLCJzdWIiOiI3IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.l3W9OibG37GsHysAOeL_R62t_p_GECll24DdvPu1MWk', '2024-03-07 13:32:41', '2024-04-05 17:46:00'),
(10, 'swetarth', NULL, 'swetapanchal.96@gmail.com', '6353143098', NULL, '$2y$10$b1s38zJWzTlo8bf2H5fQA.KyZOfYDPAHuhLqa5V1R.I1avp1Wfb5G', 2, 385334, '2024-04-04 19:02:41', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMyMDUyOCwiZXhwIjoxNzEyMzYzNzI4LCJuYmYiOjE3MTIzMjA1MjgsImp0aSI6IkNhWm9JVDR4ZmpNSExjZU8iLCJzdWIiOiIxMCIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Hf7nxxJcS0KpoIzNDE1yR-4Jpt8LWGy2YIpHUNdhSm4', '2024-03-12 16:17:25', '2024-04-05 18:05:28'),
(11, 'Tarang Parmar', NULL, 'dev2.apolloinfotech@gmail.com', '9987654321', NULL, '$2y$10$M.RzcoelvicT5EnwUo/koOAWvEipC44sK9lma6qEIsmmfkxZ/NOFm', 2, NULL, NULL, 1, NULL, NULL, '2024-03-14 12:33:18', '2024-03-14 12:33:18'),
(13, 'Ms.Pushti Shah', NULL, 'pushtishah12345@gmail.com', '7896453110', NULL, '$2y$10$1RvHQynWwIiCzC19k8m8tuuEc5pAs4DOI8Nb6K20pEuZj2N2swQDy', 2, NULL, NULL, 1, NULL, NULL, '2024-03-15 14:58:37', '2024-03-26 12:37:24'),
(14, 'Pushti Shah', NULL, 'pushtishah140403@gmail.com', '9328200153', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-18 18:50:39', '2024-03-18 18:50:39'),
(15, 'prerna parekh', NULL, 'angelprathod96@gmail.com', '4564654564', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-18 21:58:57', '2024-03-18 21:58:57'),
(16, 'Pushti Shah', NULL, 'shahpushti12345@gmail.com', '9876541230', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-19 11:11:50', '2024-03-19 11:11:50'),
(17, 'Patel Krushi', NULL, 'patelkrushi242@gmail.com', '6353595756', NULL, '$2y$10$LfRwWwa6DU2o/HBwqfncI.9veFvdConOGX44yqSM.8yr8OQMF8rCO', 2, NULL, NULL, 1, NULL, NULL, '2024-03-20 15:01:04', '2024-03-23 10:33:51'),
(18, 'Bansari Patel', NULL, 'bansaripatel1830@gmail.com', '7866541230', NULL, '$2y$10$6HPDDFe3IIbL2c930mJOweRNlAljYZmWeDUvJQd0SNcK2l.yVAIYy', 2, 842093, '2024-04-05 10:45:31', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMxNDA5NCwiZXhwIjoxNzEyMzE3Njk0LCJuYmYiOjE3MTIzMTQwOTQsImp0aSI6IllyU3N3a3JNRzFJeUprZU0iLCJzdWIiOiIxOCIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.EA8fVKKUKmVqK0yqf38MtFS7VSBsMea3LSTvOXQ1DjQ', '2024-03-26 12:48:34', '2024-04-05 16:18:14'),
(19, 'Pushti Shah', NULL, 'pushtishah1234@gmail.com', '9898289098', NULL, '$2y$10$rQgBL8JCtXELLP.fbn7/TuQ88EUOA3a3gd6grcTKjUe/jPbOrdDle', 2, NULL, NULL, 1, NULL, NULL, '2024-03-26 17:20:38', '2024-03-26 17:20:56'),
(20, 'Sandip Travedi', NULL, 'sahassolutions@gmail.com', '8000498000', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-28 18:04:12', '2024-03-28 18:04:12'),
(21, 'mignesh', NULL, 'migneshpatel202@gmail.com', '9904500629', NULL, '$2y$10$/n/6BWBhXMWY2w3bo2li5eZgLIBqMZuRdhjw4CRFE73gkpr0u6E.S', 2, NULL, NULL, 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjI5NTQwNCwiZXhwIjoxNzEyMjk5MDA0LCJuYmYiOjE3MTIyOTU0MDQsImp0aSI6IlhNYURFMmRQU2JSNTg3SE4iLCJzdWIiOiIyMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PRDAJYAOxqQdoG6kbDjTFtdOhDo1WY9sPI1XOoDk62M', '2024-04-03 12:44:12', '2024-04-05 11:06:44'),
(22, 'pinal', NULL, 'pinal@gmail.com', '9696532854', NULL, '$2y$10$GJBcC4hfKy45573yMUhureyx7PN2V28TSeKvv7TbwLNDxorifKcuO', 2, NULL, NULL, 1, NULL, NULL, '2024-04-05 14:39:13', '2024-04-05 14:39:13'),
(23, 'Ms.Patel', NULL, 'bansipatel4041@gmail.com', '9924509080', NULL, '$2y$10$fn1FLF78yQcX6eVoKwDkI.CfIbJ7nHLNC1Qqegftt.YGCJH2jW0am', 2, 842989, '2024-04-05 17:30:59', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMxOTM1NCwiZXhwIjoxNzEyMzYyNTU0LCJuYmYiOjE3MTIzMTkzNTQsImp0aSI6ImNBUXJSMTloVGRtd1BpVDkiLCJzdWIiOiIyMyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.KFnLuFtKkkQ3InJEGjEBlaxuScG1tsAWKs1cT5NZh9c', NULL, '2024-04-05 17:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `subcategory_id` int NOT NULL,
  `video_title` varchar(200) NOT NULL,
  `video_link` varchar(200) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `category_id`, `subcategory_id`, `video_title`, `video_link`, `image`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'test master video', 'https://youtu.be/QN1ITp74Kkw?si=hpFxQn9aDU-0EfiG', NULL, 1, 0, '2025-10-30 15:53:25', '2025-10-30 15:53:25');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `fk_sub_category_category` FOREIGN KEY (`iCategoryId`) REFERENCES `category` (`iCategoryId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
