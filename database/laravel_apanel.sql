-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2016 at 11:31 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.15-1+deb.sury.org~trusty+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel_apanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE IF NOT EXISTS `careers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `attributes` text COLLATE utf8_unicode_ci,
  `options` text COLLATE utf8_unicode_ci,
  `end_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2014_07_02_230147_migration_cartalyst_sentinel', 4),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_10_09_194502_create_users_table', 1),
('2015_10_26_155821_create_tasks_table', 2),
('2015_10_28_165713_create_user_groups_table', 3),
('2014_07_02_230147_migration_cartalyst_sentinel', 4),
('2015_11_11_183239_create_settings', 5),
('2015_11_24_124648_migration_cartalyst_sentinel', 7),
('2015_11_24_142038_migration_cartalyst_sentinel', 8),
('2015_12_01_223306_create_pages_table', 9),
('2015_12_03_144553_create_participants_table', 10),
('2016_01_20_141221_create_careers_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email',
  `profile_url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_home` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(214) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urban_district` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_urban` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(72) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` tinyint(3) unsigned DEFAULT NULL,
  `nationality` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `completed` tinyint(3) unsigned DEFAULT NULL,
  `logged_in` tinyint(3) unsigned DEFAULT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `join_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `participants_provider_id_unique` (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `provider_id`, `provider`, `profile_url`, `photo_url`, `name`, `username`, `email`, `password`, `avatar`, `about`, `phone_number`, `phone_home`, `address`, `region`, `province`, `urban_district`, `sub_urban`, `zip_code`, `website`, `gender`, `age`, `nationality`, `id_number`, `file_name`, `verify`, `completed`, `logged_in`, `last_login`, `session_id`, `join_date`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '101905163943989356331', 'Google', 'https://plus.google.com/+DefrianYarfi', NULL, 'Defrian Yarfi', 'dyarfi', 'defrian.yarfi@gmail.com', NULL, NULL, 'Web Developer', '081807244697', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, NULL, NULL, NULL, '2015-12-31 00:00:00', 0, NULL, '2015-12-31 00:00:00', NULL, NULL),
(3, '101905163943989356332', 'Google', 'https://plus.google.com/+DefrianYarfi', NULL, 'Defrian Yarfi', 'dyarfi', 'defrian.yarfi@gmail.com', NULL, NULL, 'Senior Web Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, NULL, NULL, NULL, '2015-12-31 00:00:00', 0, NULL, '2015-12-31 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persistences`
--

CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=84 ;

--
-- Dumping data for table `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(6, 1, 'flRdcX3E2hHr8JKYm63WEBCApFCcCq6T', NULL, '2015-11-24 14:38:55', '2015-11-24 14:38:55'),
(7, 1, 'IvLSkYhxkpfRqaYKu70Z16tRixF6zERo', NULL, '2015-11-25 11:49:26', '2015-11-25 11:49:26'),
(10, 1, 'IHAscdrDlQDuNfw8CYtUYFS4C0QmGjWs', NULL, '2015-11-25 19:28:28', '2015-11-25 19:28:28'),
(11, 1, 'kman6Vdpn6WGBpPmnuj7jlERPumtm3z5', NULL, '2015-11-26 17:09:47', '2015-11-26 17:09:47'),
(16, 20, '4ax1VZuDHCYwV8StmYopOtU910HXq6Uo', NULL, '2015-11-27 16:38:19', '2015-11-27 16:38:19'),
(17, 20, 'pQc34wsW6XEOY7uMgPj5CuLE3lCvm32r', NULL, '2015-11-30 11:29:53', '2015-11-30 11:29:53'),
(24, 20, 'eBpn2rTE5eZHBJZNvJu32KIWOuQLd5P3', NULL, '2015-12-01 13:52:06', '2015-12-01 13:52:06'),
(25, 20, 'O009YLJtJF1byePOXUzrGFm1S19F8tkO', NULL, '2015-12-02 11:52:03', '2015-12-02 11:52:03'),
(26, 20, 'VOFXZMDpyUVpQ0tTF62RSYf28SsGstez', NULL, '2015-12-02 17:37:41', '2015-12-02 17:37:41'),
(27, 20, 'TteCPjQhASMS0dBBng2ltOL3q53tcH0L', NULL, '2015-12-03 13:44:17', '2015-12-03 13:44:17'),
(28, 20, 'qTN69itNvDGmyHDvXyyBUErOLWD2YhyF', NULL, '2015-12-03 16:22:14', '2015-12-03 16:22:14'),
(32, 20, '7B6JHlsofwQjiMGrbKKN4n4SiEfotJ1g', NULL, '2015-12-04 20:05:25', '2015-12-04 20:05:25'),
(33, 20, 'qKTpW50SCAI2SmKkIL1G5xWp9hDxINrP', NULL, '2015-12-07 12:32:54', '2015-12-07 12:32:54'),
(34, 20, 'WvkmHtEVMX3YVA0TO9BVG03lEXFp54Uj', NULL, '2015-12-08 12:26:50', '2015-12-08 12:26:50'),
(35, 20, 'Z78qiaBN6lIdLZtz8Dcx0jkTvTO3C92S', NULL, '2015-12-08 17:05:19', '2015-12-08 17:05:19'),
(36, 20, 'zVXPlUXPf0Jx2ySvOVrnDxRj7cjC8pUY', NULL, '2015-12-09 03:58:40', '2015-12-09 03:58:40'),
(37, 20, 'dik07ITENI5ZnKEdJS5DFCRHACYvRjOS', NULL, '2015-12-09 14:33:55', '2015-12-09 14:33:55'),
(38, 20, '84waxKwDPRvTGgbdaX7BrDnBi4441biS', NULL, '2015-12-10 15:46:44', '2015-12-10 15:46:44'),
(40, 20, 'y2lsFF1sfW4o14xXDjWXdmZGNJjchSsQ', NULL, '2015-12-10 21:09:46', '2015-12-10 21:09:46'),
(41, 20, 'r5QWBZTAJoLoFbgsPMn37iwZgQBQ4FLO', NULL, '2015-12-11 13:03:32', '2015-12-11 13:03:32'),
(42, 20, '94uns1ZCCZvBYiXzede3BDxSrASAL3xY', NULL, '2015-12-12 01:13:31', '2015-12-12 01:13:31'),
(43, 20, '1K6tdEYCLSGe1pEym7mZTRKfwIDtein7', NULL, '2015-12-15 16:45:55', '2015-12-15 16:45:55'),
(44, 20, 'AShJCcvLIERIAlHgdWg0HqUdUQvo6Qjm', NULL, '2015-12-15 16:58:32', '2015-12-15 16:58:32'),
(45, 20, 'LPkRWkpVUT3fl3Uu9ke7E7m4BTDyOx6p', NULL, '2015-12-15 23:35:13', '2015-12-15 23:35:13'),
(46, 20, 'Ex38oF7wXlQ63gW0rLFa0FT24jhT3jRS', NULL, '2015-12-16 14:28:41', '2015-12-16 14:28:41'),
(47, 20, 'sU8Dqw4SrHTdtU6lsFstsf5Zg4K9j9YR', NULL, '2015-12-16 17:12:26', '2015-12-16 17:12:26'),
(48, 20, 'cX76BvV59LOUQjN18X1xUKnIoew1XwG0', NULL, '2015-12-17 13:06:54', '2015-12-17 13:06:54'),
(49, 20, 'RGYOlurQOK5wQGJQd825elXJJC1rIl1Z', NULL, '2015-12-17 15:22:58', '2015-12-17 15:22:58'),
(50, 20, 'mbvbOLKytKVPWbf47TaIqa0FwqV8MkNo', NULL, '2015-12-17 16:12:21', '2015-12-17 16:12:21'),
(51, 20, 'O3JdvwmUKV63xyQ2MSvx8IIKsDp8lPtJ', NULL, '2015-12-18 15:13:50', '2015-12-18 15:13:50'),
(52, 20, 'xzF6y3mnHJ4TQWmfe9OsSlTVBUDimTkP', NULL, '2015-12-21 14:45:57', '2015-12-21 14:45:57'),
(53, 20, 'oXUF9TIpDMhCG07RDotHd6PuIUn44X8Q', NULL, '2015-12-21 21:20:43', '2015-12-21 21:20:43'),
(54, 20, 'WD0pJKdLFZ1SwVXCaqFBOMDctOW2aV4i', NULL, '2015-12-22 17:10:34', '2015-12-22 17:10:34'),
(55, 20, 'X2u4ej7tBwrY7P6ljxMc94ekawO9tXZ0', NULL, '2015-12-23 12:02:53', '2015-12-23 12:02:53'),
(56, 20, 'L7ajOuocMvZrZ5nnjBagkTvg4VZDlpQ2', NULL, '2015-12-23 21:49:53', '2015-12-23 21:49:53'),
(58, 21, '44CJ44Y3CgKVimNnGlyOeoz2n0GkZyB2', NULL, '2015-12-24 01:46:37', '2015-12-24 01:46:37'),
(60, 21, 'fVUeEXyrDqVFWFQNr9XIXZ3BNk6vNmcY', NULL, '2015-12-24 20:53:54', '2015-12-24 20:53:54'),
(63, 20, 'zgQ2uQl8J6sovqZ1UxFZafj1EhhWPIa5', NULL, '2015-12-25 23:45:53', '2015-12-25 23:45:53'),
(65, 20, '4Zba0sJnUuvZ2mJgDIpqZS3m1mo5eYZl', NULL, '2015-12-27 02:36:39', '2015-12-27 02:36:39'),
(67, 20, 'ER1XNoqN1jxMjOlIDofPrSQR2WhqhBjQ', NULL, '2015-12-28 00:56:29', '2015-12-28 00:56:29'),
(68, 20, 'UUzmm4CPPKhOrY6BfOaY0D4hTK4g2siu', NULL, '2015-12-31 17:33:45', '2015-12-31 17:33:45'),
(69, 20, 'CxBwtehhVuXzQn9RwbUFV7jbGSb1iXcQ', NULL, '2016-01-01 10:59:13', '2016-01-01 10:59:13'),
(70, 20, 'Yfv2M4dUKI7xYVqSjh7T4cTYxXpzJshu', NULL, '2016-01-04 12:14:12', '2016-01-04 12:14:12'),
(71, 20, 'YoyasOGny5vZJMF0I86AxWEf24U348UT', NULL, '2016-01-05 11:41:18', '2016-01-05 11:41:18'),
(72, 20, '9sOGioSiSOvuqgV12Ig5LdqXkVn7y4jv', NULL, '2016-01-05 15:55:55', '2016-01-05 15:55:55'),
(73, 20, 'M0Kqa6b3FFYfQoQkEHKhRs62eFJnv79u', NULL, '2016-01-06 10:34:31', '2016-01-06 10:34:31'),
(74, 20, 'JJWowR0gO5RlLbCEw4OWQoq5R7Mspw14', NULL, '2016-01-07 21:02:20', '2016-01-07 21:02:20'),
(75, 20, 'WJ77xIW8S8lGZArpBS1182dJiuetgJMA', NULL, '2016-01-08 14:24:42', '2016-01-08 14:24:42'),
(76, 20, 'Y3vorN7O3vkQSnGf4szSQaBdKDBFhUza', NULL, '2016-01-09 21:27:42', '2016-01-09 21:27:42'),
(77, 20, 'AZHbKOXd5L7EpmHfWOi4csMc7y6hC8Nt', NULL, '2016-01-11 16:16:27', '2016-01-11 16:16:27'),
(78, 20, 'y7souXCWwwj6gWA2AW6a6wVViQiIDrmm', NULL, '2016-01-12 16:29:03', '2016-01-12 16:29:03'),
(79, 20, 'KAEKIYiDpX9zNlgE9SwZ6mMTuqLAMOCu', NULL, '2016-01-19 11:05:40', '2016-01-19 11:05:40'),
(80, 20, 'Sk1retqoH7cAaahYgishMdghn0UaL2rC', NULL, '2016-01-19 17:40:58', '2016-01-19 17:40:58'),
(81, 20, 'OkEaOIr316Adc0iqgbnkV7CwzE9izGi2', NULL, '2016-01-19 17:54:43', '2016-01-19 17:54:43'),
(82, 20, '7VsOCOnfSsYYnaXOg5n36bp2g3aKT7Nf', NULL, '2016-01-20 14:21:00', '2016-01-20 14:21:00'),
(83, 20, '8JsqTTQjbpG6rjR3BeVnAakFBXrNpv34', NULL, '2016-01-21 17:30:52', '2016-01-21 17:30:52');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '{"admin":true,"career":true,"page":true,"participant":true,"task":true}', NULL, '2015-11-24 14:30:56', '2016-01-20 14:31:36'),
(2, 'publisher', 'Publisher', '{"admin":true,"page":true}', NULL, '2015-11-24 14:59:15', '2016-01-01 11:19:09'),
(3, 'mechanic', 'Mechanic', '{"admin":true,"page":true}', NULL, '2015-11-25 19:22:27', '2016-01-04 13:52:41'),
(4, 'supervisor', 'Supervisor', '{"admin":false,"page":true,"participant":true,"task":true}', NULL, '2015-11-25 19:25:18', '2016-01-01 11:37:10'),
(6, 'country-admin', 'Country Admin', '{"admin":false}', NULL, '2015-11-27 17:56:06', '2015-12-24 22:49:09'),
(7, 'country-manager', 'Country Manager', '{"admin":false,"page":true,"participant":true,"task":true}', NULL, '2015-12-24 22:51:05', '2016-01-05 16:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 1, '2015-11-27 16:34:56', '2015-11-27 16:34:56', NULL),
(21, 3, '2015-11-27 17:45:56', '2015-11-27 17:45:56', NULL),
(22, 3, '2015-12-01 16:08:03', '2015-12-01 16:08:03', NULL),
(23, 2, '2015-12-02 12:33:04', '2015-12-02 12:33:04', NULL),
(24, 4, '2015-12-02 12:32:54', '2015-12-02 12:32:54', NULL),
(41, 1, '2015-12-10 17:43:54', '2015-12-10 17:43:54', NULL),
(42, 1, '2015-12-10 17:50:56', '2015-12-10 17:50:56', NULL),
(43, 1, '2015-12-10 17:52:27', '2015-12-10 17:52:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `value` text COLLATE utf8_unicode_ci,
  `help_text` text COLLATE utf8_unicode_ci,
  `input_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `weight` int(11) DEFAULT NULL,
  `attributes` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group`, `key`, `name`, `slug`, `description`, `value`, `help_text`, `input_type`, `editable`, `weight`, `attributes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'email', 'contact', 'Email Contact', 'email-contact', 'Official Email Contact for the Company', 'contact@apanel.app', 'This email must be a valid company contact', NULL, 1, NULL, NULL, 1, '2015-11-24 12:54:41', '2015-11-24 12:54:41', NULL),
(2, 'email', 'info', 'Email Info', 'email-info', 'Email for the company information', 'info@apanel.app', 'Valid Email for the company information', NULL, 1, NULL, NULL, 1, '2015-11-24 12:55:36', '2015-11-24 12:55:36', NULL),
(3, 'site', 'name', 'Site Name', 'site-name', 'Apanel', 'Apanel', 'Apanel', NULL, 1, NULL, NULL, 1, '2015-11-24 13:12:18', '2015-11-24 22:34:49', NULL),
(4, 'site', 'maintenance', 'Maintenance Mode', 'maintenance-mode', 'Maintenance Mode', 'false', 'Maintenance Mode', NULL, 1, NULL, NULL, 1, '2015-11-24 22:14:19', '2015-11-24 22:30:58', NULL),
(5, 'site', 'locale', 'Site Locale', 'site-locale', 'Site Default Locale Language', 'en', 'Site Locale Language', NULL, 1, NULL, NULL, 1, '2015-11-25 19:26:44', '2016-01-04 13:46:41', NULL),
(6, 'email', 'administrator', 'Email Administrator', 'email-administrator', 'Default Email Administrator', 'administrator@apanel.app', 'This is used for contacting Email Administrator', NULL, 1, NULL, NULL, 1, '2015-12-02 12:30:14', '2015-12-02 12:30:14', NULL),
(7, 'socmed', 'facebook', 'Socmed Facebook', 'socmed-facebook', 'Social Media link for Facebook Company', 'facebook.com/apanel', 'This is the link for facebook page', NULL, 1, NULL, NULL, 1, '2015-12-07 12:57:37', '2015-12-16 00:07:04', NULL),
(8, 'socmed', 'twitter', 'Socmed Twitter', 'socmed-twitter', 'The Social media link for the Twitter account company', 'twitter.com/apanel', 'This is the link for Twitter account', NULL, 1, NULL, NULL, 1, '2015-12-07 12:58:46', '2015-12-15 23:38:56', NULL),
(9, 'email', 'smtp.server', 'SMTP Server', 'smtp-server', 'SMTP server setting for sending email from website server', '127.0.0.1', 'Default setting for SMTP', NULL, 1, NULL, NULL, 1, '2015-12-16 00:13:54', '2015-12-16 17:42:40', NULL),
(10, 'image', 'logo', 'Image Logo', 'image-logo', 'Image logo for the Company Profiling', 'logo.png', NULL, NULL, 1, NULL, NULL, 1, '2015-12-28 01:33:23', '2015-12-28 01:33:23', NULL),
(11, 'meta', 'robots', 'Meta Robots', 'meta-robots', 'Meta Robots', 'index, follow', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:28:39', '2016-01-04 13:28:39', NULL),
(12, 'meta', 'keywords', 'Meta Keywords', 'meta-keywords', 'Meta keywords for the website', 'Company Website', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:29:14', '2016-01-04 13:29:14', NULL),
(13, 'meta', 'description', 'Meta Description', 'meta-description', 'Meta Description for Website', 'Description for the website', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:30:02', '2016-01-04 13:30:02', NULL),
(14, 'meta', 'generator', 'Meta Generator', 'meta-generator', 'Meta Generator for the website', 'Apanel Application 1.0', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:30:51', '2016-01-04 13:30:51', NULL),
(15, 'site', 'default.theme', 'Site Theme', 'site-theme', 'Site Theme default', 'default', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:34:27', '2016-01-04 13:34:27', NULL),
(16, 'site', 'admin.theme', 'Site Admin Theme', 'site-admin-theme', 'Site Admin Theme', 'default', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:34:59', '2016-01-04 13:34:59', NULL),
(17, 'site', 'tagline', 'Site Tagline', 'site-tagline', 'Site Tagline', 'Site Tagline', NULL, NULL, 1, NULL, NULL, 1, '2016-01-04 13:40:47', '2016-01-04 13:40:47', NULL),
(18, 'site', 'timezone', 'Site Timezone', 'site-timezone', 'Timezone for website, related with content publishing', 'Asia/Jakarta', 'Timezone for website, related with content publishing', NULL, 1, NULL, NULL, 1, '2016-01-05 15:57:33', '2016-01-05 18:28:13', NULL),
(19, 'site', 'country', 'Site Country', 'site-country', 'Website country', 'Indonesia', NULL, NULL, 1, NULL, NULL, 1, '2016-01-05 16:38:53', '2016-01-05 16:38:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `slug`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 20, 'What is lorem ipsum ?', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '38080.jpg', '2015-10-26 11:52:29', '2015-12-27 01:46:43', NULL),
(3, 20, 'Where does it come from ? Lorem Ipsum', NULL, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '', '2015-10-26 11:52:57', '2015-10-27 10:45:49', NULL),
(4, 20, 'Where can I get some ?', NULL, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '', '2015-10-26 11:53:25', '2015-10-26 11:53:25', NULL),
(5, 21, 'Why do we use it ?', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '2015-10-26 11:56:17', '2015-10-26 11:56:17', NULL),
(6, 21, 'Does anyone know how I can modify the data a form request object', NULL, 'Does anyone know how I can modify the data a form request object contains before it is used in any way? That is, before the request if validated and before the form request data is used in any way?\r\nAs an example scenario:\r\nI have a form where a user can update their date of birth, by changing 3 fields representing the day, month and year of birth. I have created an UpdateSettingsRequest class that extends App\\Http\\Requests to represent this request.\r\nBefore this data is validated and consumed, I need to modify my request object to contain a field date_of_birth by joining the year, month and day fields together with hyphen separators like yyyy-mm-dd.\r\nHaving a dig around I have found that I could override the all method on the form request class and place my logic there. But that doesn''t modify the object''s data.\r\nMy initial though was to provide my own constructor, but I''m not sure how I would go about doing this.\r\nAny help would be appreciated.', '', '2015-10-27 04:02:17', '2015-10-27 04:02:17', NULL),
(7, 21, 'I want to modify the input value of a form before it is passed', NULL, 'I want to modify the input value of a form before it is passed to the validator using the new Request validation in Laravel 5.\r\nSo the question is, where can I modify (for example trim the input or encode the input) before it is passed to the validator?\r\nIn L4 I would do this before passing the values to Validator::make(), but that step is Handled by a Request validator in L5', '', '2015-10-27 04:12:03', '2016-01-19 13:35:36', '2016-01-19 13:35:36'),
(8, 21, 'You must assign it to a variable and then you can perform operations on the variable', NULL, 'You must assign it to a variable and then you can perform operations on the variable. The function get of the single pattern Input accepts a string argument and then perform''s internal operations on the HTTP request to bring the data back to you, which is why you cannot treat it as a string. However, if you assign the value of that to a variable, then the variable can be manipulated thussly.', '', '2015-10-27 04:13:01', '2015-10-27 08:42:51', NULL),
(14, 21, 'Laravel 5.0', NULL, 'Laravel 5.0 is coming out in November, and there are a lot of features that have folks excited. The New Directory structure is, in my mind, a lot more in line with how most developers work; Flysystem integration will make working with files endlessly more flexible and powerful; Contracts is a great step towards making Laravel-friendly packages that aren’t Laravel-dependent; and Socialite looks about 100x easier than Opauth. Also, Method Injection opens up a lot of really exciting opportunities.\r\n\r\nOne of the most valuable aspects of Laravel for me is that it allows for rapid app development. Laravel, and other frameworks like it, automate out the repetitive work that you have to do on every project. And a lot of newer features have been focusing on this. Cashier, and now Socialite and Form Requests.', '', '2015-10-27 05:36:34', '2015-12-27 02:27:37', NULL),
(16, 20, 'Task One Two Three', 'task-one-two-three', 'Task One Two Three Description', '', '2016-01-19 18:22:33', '2016-01-19 19:50:41', NULL),
(17, 20, 'The object returned by the file method is an instance of the', 'the-object-returned-by-the-file-method-is-an-instance-of-the', 'The object returned by the file method is an instance of the', '', '2016-01-19 19:41:55', '2016-01-19 19:50:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email',
  `provider_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attributes` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_provider_id_unique` (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `avatar`, `provider`, `provider_id`, `about`, `attributes`, `deleted_at`, `created_at`, `updated_at`) VALUES
(20, 'dyarfi', 'defrian.yarfi@gmail.com', '$2y$10$MgLIFp.aln//QNCuWKA98.DghURQqOtBLgLQF22MEJemlfRz5e9iq', '{"users.index":true,"users.edit":true,"users.update":true,"users.create":true,"users.trash":true,"users.delete":true,"users.restored":true,"users.store":true,"users.show":true,"users.dashboard":true,"roles.index":true,"roles.edit":true,"roles.update":true,"roles.create":true,"roles.trash":true,"roles.delete":true,"roles.restored":true,"roles.store":true,"roles.show":true,"permissions.index":true,"permissions.edit":true,"permissions.create":true,"permissions.store":true,"permissions.change":true,"permissions.show":true,"settings.index":true,"settings.edit":true,"settings.update":true,"settings.create":true,"settings.store":true,"settings.trash":true,"settings.delete":true,"settings.restored":true,"settings.show":true,"logs.index":true,"logs.edit":true,"logs.create":true,"logs.store":true,"logs.show":true,"pages.index":true,"pages.edit":true,"pages.update":true,"pages.create":true,"pages.store":true,"pages.show":true,"menus.index":true,"menus.edit":true,"menus.update":true,"menus.create":true,"menus.store":true,"menus.show":true,"tasks.index":true,"tasks.edit":true,"tasks.update":true,"tasks.create":true,"tasks.store":true,"tasks.trash":true,"tasks.delete":true,"tasks.restored":true,"tasks.show":true,"careers.index":true,"careers.edit":true,"careers.update":true,"careers.create":true,"careers.store":true,"careers.trash":true,"careers.delete":true,"careers.restored":true,"careers.show":true,"participants.index":true,"participants.edit":true,"participants.update":true,"participants.create":true,"participants.store":true,"participants.trash":true,"participants.delete":true,"participants.restored":true,"participants.show":true}', '2016-01-21 17:30:52', 'Defrian', 'Yarfi', 'http://gravatar.com/dyarfi', 'email', NULL, 'About My Profile Description', '{"skins":"#438EB9"}', NULL, '2015-11-27 16:34:56', '2016-01-21 17:30:52'),
(21, 'defrian20', 'dyarfi20@gmail.com', '$2y$10$.J3cMG6RZbGEx/eoAEb6Se9X2mamcdxkSDqRzpOqVkOTgOON7MQgS', '{"pages.index":true}', '2015-12-25 01:10:39', 'Nairfred', 'Ifray', NULL, 'email', NULL, NULL, '{"skins":"#438EB9"}', NULL, '2015-11-27 17:45:56', '2015-12-25 01:10:39'),
(22, NULL, 'defrian.yarfi@yahoo.com', '$2y$10$EwfWl7QpS9rM/eE/0ihc0OsH8l3DcXGuQjCzZeqU8KchlPqvQaBz2', NULL, NULL, 'Emeraldi', 'Octavian', NULL, 'email', NULL, NULL, NULL, NULL, '2015-12-01 16:08:03', '2015-12-16 17:36:20'),
(23, NULL, 'deffsidefry@ymail.com', '$2y$10$zmSx2zI1lONqDAVMc8VXR.D3BAkVTlqbF3bkR2yA6DugqqclQC556', NULL, NULL, 'Zmael', 'Milajovic', NULL, 'email', NULL, NULL, NULL, NULL, '2015-12-02 12:32:20', '2015-12-16 17:41:48'),
(24, NULL, 'defrian.yarfi@d3.dentsu.co.id', '$2y$10$DGxOR9TQVX2RRxFXUK.LKON4iX3x4uYjLICnluVfNDIMoUTGTvO.W', '{"pages.index":true,"pages.edit":true,"pages.update":true,"pages.create":true,"pages.store":true,"pages.show":true,"pages.dashboard":true,"menus.index":true,"menus.edit":true,"menus.update":true,"menus.create":true,"menus.store":true,"menus.show":true,"menus.dashboard":true}', NULL, 'Yudhay', 'Kendricks', NULL, 'email', NULL, NULL, NULL, NULL, '2015-12-02 12:32:54', '2015-12-16 17:40:07'),
(43, NULL, 'defrian.yarfi@facebook.com', '$2y$10$Ky4GJjugVDkm5T8Oth//.Oc.DUrO7bWMR7xFH0mR3H.b677Nbqn8m', '{"users.index":true,"users.edit":true,"users.update":true,"users.create":true,"users.trash":true,"users.delete":true,"users.restored":true,"users.store":true,"users.show":true,"users.dashboard":true,"roles.index":true,"roles.edit":true,"roles.update":true,"roles.create":true,"roles.trash":true,"roles.delete":true,"roles.restored":true,"roles.store":true,"roles.show":true,"permissions.index":true,"permissions.edit":true,"permissions.create":true,"permissions.store":true,"permissions.change":true,"permissions.show":true,"settings.index":true,"settings.edit":true,"settings.update":true,"settings.create":true,"settings.store":true,"settings.trash":true,"settings.delete":true,"settings.restored":true,"settings.show":true,"logs.index":true,"logs.edit":true,"logs.create":true,"logs.store":true,"logs.show":true}', '2015-12-10 17:53:34', 'Valent', 'Schemaichel', NULL, 'email', NULL, NULL, NULL, NULL, '2015-12-10 17:52:27', '2015-12-16 17:37:51'),
(44, 'Defrian Yarfi', 'admin@admin.com', '$2y$10$CNsYxdwKHVD3ijfCJv8yS.X/RI9Vcnw0Wg12mONbcEHPkEMHe.Ybq', NULL, NULL, NULL, NULL, NULL, 'email', NULL, NULL, NULL, NULL, '2015-12-30 22:19:23', '2015-12-30 22:19:23');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
