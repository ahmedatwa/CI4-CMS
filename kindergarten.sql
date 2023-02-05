-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 05, 2023 at 09:05 AM
-- Server version: 8.0.32
-- PHP Version: 8.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kindergarten`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_application`
--

CREATE TABLE `ci_application` (
  `application_id` int NOT NULL,
  `child_id` int NOT NULL,
  `sort_order` int NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `download_id` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_application_status`
--

CREATE TABLE `ci_application_status` (
  `status_id` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_application_status`
--

INSERT INTO `ci_application_status` (`status_id`, `name`) VALUES
(1, 'Canceled'),
(2, 'Completed'),
(3, 'Denied'),
(4, 'in Progress'),
(5, 'Expired'),
(6, 'Awarded'),
(7, 'Closed'),
(8, 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `ci_banner`
--

CREATE TABLE `ci_banner` (
  `banner_id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_banner`
--

INSERT INTO `ci_banner` (`banner_id`, `name`, `status`) VALUES
(1, 'Home Page Slideshow', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_banner_image`
--

CREATE TABLE `ci_banner_image` (
  `banner_image_id` int NOT NULL,
  `banner_id` int NOT NULL,
  `title` varchar(64) NOT NULL,
  `caption` varchar(225) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_banner_image`
--

INSERT INTO `ci_banner_image` (`banner_image_id`, `banner_id`, `title`, `caption`, `link`, `image`, `sort_order`) VALUES
(1, 1, 'image3', '', 'http://via.placeholder.com/1500x500', '', 2),
(2, 1, 'image', '', 'http://via.placeholder.com/1500x500', '', 1),
(3, 1, 'image2', '', 'http://via.placeholder.com/1500x500', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_category`
--

CREATE TABLE `ci_blog_category` (
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_comment`
--

CREATE TABLE `ci_blog_comment` (
  `comment_id` int NOT NULL,
  `post_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `website` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_post`
--

CREATE TABLE `ci_blog_post` (
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `tags` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `trending` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_category`
--

CREATE TABLE `ci_category` (
  `category_id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `column` int NOT NULL,
  `icon` varchar(64) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_category`
--

INSERT INTO `ci_category` (`category_id`, `image`, `parent_id`, `top`, `column`, `icon`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(3, NULL, 0, 0, 0, '', 0, 1, 1652390310, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_category_description`
--

CREATE TABLE `ci_category_description` (
  `category_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_category_description`
--

INSERT INTO `ci_category_description` (`category_id`, `language_id`, `name`, `keyword`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(3, 1, 'Cat1', 'cat1', '<p>Cat1<br></p>', 'Cat1', 'Cat1', ''),
(3, 2, 'Cat1', 'cat1', '<p>Cat1<br></p>', 'Cat1', 'Cat1', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_children`
--

CREATE TABLE `ci_children` (
  `child_id` int NOT NULL,
  `child_group_id` int NOT NULL,
  `scheme_id` int NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dob` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_children`
--

INSERT INTO `ci_children` (`child_id`, `child_group_id`, `scheme_id`, `firstname`, `lastname`, `dob`, `status`, `image`, `date_added`, `date_modified`, `date_deleted`) VALUES
(3, 1, 1, 'child', 'name', 10, 1, '', 1627982850, 1627982850, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_children_group`
--

CREATE TABLE `ci_children_group` (
  `child_group_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL,
  `date_modified` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_children_group`
--

INSERT INTO `ci_children_group` (`child_group_id`, `name`, `description`, `date_added`, `date_modified`) VALUES
(1, 'Default', 'Default', 1626816677, 1627936797);

-- --------------------------------------------------------

--
-- Table structure for table `ci_children_scheme`
--

CREATE TABLE `ci_children_scheme` (
  `scheme_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_children_scheme`
--

INSERT INTO `ci_children_scheme` (`scheme_id`, `name`, `description`, `date_added`, `date_modified`) VALUES
(1, 'NCS', 'It is the first ever statutory entitlement to financial support for childcare. It establishes an equitable and progressive system of universal and income-related subsidies for children up to the age of 15. It also provides an innovative and user-friendly online application process to access those subsidies. ', 1626815193, 1626815193),
(2, 'ECCE', 'free Early Childhood Care and Education ', 1626815371, 1633379574);

-- --------------------------------------------------------

--
-- Table structure for table `ci_currency`
--

CREATE TABLE `ci_currency` (
  `currency_id` int NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `fraction` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_currency`
--

INSERT INTO `ci_currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `fraction`, `value`, `status`, `date_added`, `date_modified`) VALUES
(1, 'US Dollar', 'USD', '$', '', '2', 1.03863600, 1, 0, 1655312395),
(2, 'Euro', 'EUR', '', '€', '2', 1.00000000, 1, 1631818068, 1655312395),
(3, 'Pound Sterling', 'GBP', '£', '', '2', 0.86149200, 1, 1631818111, 1655312395);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer`
--

CREATE TABLE `ci_customer` (
  `customer_id` int NOT NULL,
  `customer_group_id` int NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(96) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ip` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `two_step` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(40) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_customer`
--

INSERT INTO `ci_customer` (`customer_id`, `customer_group_id`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `ip`, `two_step`, `status`, `code`, `image`, `viewed`, `newsletter`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 1, 'test', 'test', '', 'test@test.com', '', '$2y$10$3SbNzQbaJiZNSro5FzVCUuIrVtHCVpn8bLBCrXFaO1plX2tGJ5HQe', '', 0, 1, '', '', 0, 0, 1645110461, 1645110461, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_activity`
--

CREATE TABLE `ci_customer_activity` (
  `customer_activity_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_group`
--

CREATE TABLE `ci_customer_group` (
  `customer_group_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL,
  `date_modified` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_customer_group`
--

INSERT INTO `ci_customer_group` (`customer_group_id`, `name`, `description`, `date_added`, `date_modified`) VALUES
(1, 'Default', 'Default', 1626814775, 1626814775);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_ip`
--

CREATE TABLE `ci_customer_ip` (
  `customer_ip_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_customer_ip`
--

INSERT INTO `ci_customer_ip` (`customer_ip_id`, `customer_id`, `ip`, `user_agent`, `date_added`) VALUES
(1, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(2, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(3, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(4, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(5, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(6, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(7, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(8, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(9, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(10, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(11, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(12, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(13, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(14, 0, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(15, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(16, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(17, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(18, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(19, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(20, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(21, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(22, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(23, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(24, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(25, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(26, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(27, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(28, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(29, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(30, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(31, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(32, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(33, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(34, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(35, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(36, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(37, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(38, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(39, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(40, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(41, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(42, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(43, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(44, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(45, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(46, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(47, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(48, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(49, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(50, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(51, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(52, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(53, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(54, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(55, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(56, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(57, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(58, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(59, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(60, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 4294967295),
(61, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:91.0) Gecko/20100101 Firefox/91.0', 1631043245),
(62, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631654875),
(63, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631655588),
(64, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631716389),
(65, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631740076),
(66, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631740144),
(67, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15', 1631794113),
(68, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15', 1631866566),
(69, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15', 1631866614),
(70, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631868085),
(71, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631895712),
(72, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631898680),
(73, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631901509),
(74, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631912228),
(75, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1631984073),
(76, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632011149),
(77, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632045674),
(78, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632046705),
(79, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632067833),
(80, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632073392),
(81, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632173139),
(82, 6, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0', 1632209712);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_login`
--

CREATE TABLE `ci_customer_login` (
  `customer_login_id` int NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_online`
--

CREATE TABLE `ci_customer_online` (
  `ip` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customer_id` int NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_customer_online`
--

INSERT INTO `ci_customer_online` (`ip`, `customer_id`, `url`, `referer`, `date_added`) VALUES
('127.0.0.1', 0, 'http://kindergarten.localhost/', 'http://kindergarten.localhost/', 1675587919);

-- --------------------------------------------------------

--
-- Table structure for table `ci_event`
--

CREATE TABLE `ci_event` (
  `event_id` int NOT NULL,
  `code` varchar(64) NOT NULL,
  `action` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `trigger` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_event`
--

INSERT INTO `ci_event` (`event_id`, `code`, `action`, `trigger`, `description`, `status`, `priority`, `date_added`) VALUES
(1, 'customer_login', '\\Catalog\\Events\\ActivityEvent::authenticate', '\\Catalog\\Controllers\\Account\\Login\\Authenticate\\after', 'Log Customer successful login event, triggered right after the method', 1, 0, 0),
(2, 'customer_register', '\\Catalog\\Events\\ActivityEvent::register', '\\Catalog\\Controllers\\Account\\Register\\Register\\after', 'Log New Customer register event, triggered right after the method', 1, 0, 0),
(3, 'user_login', '\\Admin\\Events\\ActivityEvent::authLogin', '\\Admin\\Controllers\\Common\\Login\\authLogin\\after', 'Log Admin successful login event, triggered right after the method', 1, 0, 0),
(4, 'customer_mail_forgotten', '\\Catalog\\Events\\MailEvent::forgotten', '\\Catalog\\Controllers\\Account\\Forgotten\\forgotten\\after', 'Log Catalog successful Forgotten Mail event, triggered right after the method', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_extension`
--

CREATE TABLE `ci_extension` (
  `extension_id` int NOT NULL,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_extension`
--

INSERT INTO `ci_extension` (`extension_id`, `type`, `code`) VALUES
(1, 'blog', 'comment'),
(2, 'module', 'carousel'),
(3, 'module', 'html'),
(4, 'module', 'video'),
(5, 'dashboard', 'customer_activity'),
(6, 'dashboard', 'customer_online'),
(7, 'module', 'account'),
(8, 'blog', 'post'),
(9, 'blog', 'category'),
(43, 'theme', 'basic'),
(11, 'report', 'user_activity'),
(12, 'module', 'menu'),
(13, 'analytics', 'google'),
(44, 'theme', 'dustrix');

-- --------------------------------------------------------

--
-- Table structure for table `ci_information`
--

CREATE TABLE `ci_information` (
  `information_id` int NOT NULL,
  `bottom` tinyint(1) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_information`
--

INSERT INTO `ci_information` (`information_id`, `bottom`, `top`, `sort_order`, `status`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 1, 0, 1, 1, 1653150351, 1653150351, NULL),
(2, 1, 0, 2, 1, 1653150351, 1653150351, NULL),
(3, 1, 0, 3, 1, 1663510644, 1663510681, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_information_description`
--

CREATE TABLE `ci_information_description` (
  `information_id` int NOT NULL,
  `language_id` int NOT NULL,
  `title` varchar(64) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_information_description`
--

INSERT INTO `ci_information_description` (`information_id`, `language_id`, `title`, `keyword`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'About Us', 'sp-about-us', '<p>About Us<br></p>', 'About Us', 'About Us', ''),
(1, 2, 'معلومات', 'sp-about-us', '<pre class=\"tw-data-text tw-text-large tw-ta\" data-placeholder=\"Translation\" id=\"tw-target-text\" dir=\"rtl\" style=\"unicode-bidi: isolate; font-size: 24px; line-height: 32px; background-color: rgb(48, 49, 52); border: none; padding: 2px 0.14em 2px 0px; position: relative; margin-top: -2px; margin-bottom: -2px; resize: none; font-family: inherit; overflow: hidden; text-align: right; width: 270px; white-space: pre-wrap; overflow-wrap: break-word; color: rgb(232, 234, 237);\"><span class=\"Y2IQFc\" lang=\"ar\">معلومات</span></pre>', 'معلومات', 'معلومات', ''),
(2, 1, 'Terms & Conditions', 'sp-terms-conditions', '<p>Terms & Conditions<br></p>', 'Terms & Conditions', 'Terms & Conditions', ''),
(2, 2, 'البنود و الظروف\r\n', 'sp-terms-conditions', '<p>Terms & Conditions<br></p>', 'Terms & Conditions', 'Terms & Conditions', ''),
(3, 1, 'Privacy Policy', 'sp-privacy-policy', '<h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px; color: rgb(0, 0, 0);\">What is Lorem Ipsum?</h2><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\"><strong style=\"margin: 0px; padding: 0px;\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\"><br></p><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px; color: rgb(0, 0, 0);\">Where does it come from?</h2><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\"><br></p><div style=\"margin: 0px 28.7969px 0px 14.3906px; padding: 0px; width: 436.797px; float: right; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">Why do we use it?</h2><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\"><br style=\"margin: 0px; padding: 0px; clear: both; font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: center;\"></p><div style=\"margin: 0px 14.3906px 0px 28.7969px; padding: 0px; width: 436.797px; float: left; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">Where does it come from?</h2><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p></div><div style=\"margin: 0px 28.7969px 0px 14.3906px; padding: 0px; width: 436.797px; float: right; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">Where can I get some?</h2><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div>', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy'),
(3, 2, 'سياسة الخصوصية', 'sp-سياسة-الخصوصية', '<div style=\"margin: 0px 14.3906px 0px 28.7969px; padding: 0px; width: 436.797px; text-align: right; float: left; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">ما فائدته ؟</h2><p dir=\"rtl\" style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p></div><div style=\"margin: 0px 28.7969px 0px 14.3906px; padding: 0px; width: 436.797px; text-align: right; float: right; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">ما هو \"لوريم إيبسوم\" ؟</h2><p dir=\"rtl\" style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p></div><p><br style=\"margin: 0px; padding: 0px; clear: both; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: center;\"></p><div style=\"margin: 0px 14.3906px 0px 28.7969px; padding: 0px; width: 436.797px; text-align: right; float: left; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">أين أجده ؟</h2><p dir=\"rtl\" style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><form method=\"post\" action=\"https://ar.lipsum.com/feed/html\" style=\"margin: 0px 0px 10px; padding: 0px;\"><table style=\"margin: 0px; padding: 0px; border-spacing: 0px; border: 0px; width: 436.797px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr style=\"margin: 0px; padding: 0px;\"><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle;\"><label for=\"start\" dir=\"rtl\" style=\"margin: 0px; padding: 0px; cursor: pointer;\">إبدأ بـ \'Lorem ipsum dolor sit amet...\'</label></td><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: center; width: 20px;\"><input type=\"checkbox\" name=\"start\" id=\"start\" value=\"yes\" checked=\"checked\" style=\"margin: 3px 6px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif;\"></td><td rowspan=\"2\" style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: center;\"><table style=\"margin: 0px; padding: 0px; border-spacing: 0px; border: 0px; text-align: right;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr style=\"margin: 0px; padding: 0px;\"><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left;\"><label for=\"paras\" style=\"margin: 0px; padding: 0px; cursor: pointer;\">فقرة</label></td><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left; width: 20px;\"><input type=\"radio\" name=\"what\" value=\"paras\" id=\"paras\" checked=\"checked\" style=\"margin: 3px 6px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif;\"></td></tr><tr style=\"margin: 0px; padding: 0px;\"><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left;\"><label for=\"words\" style=\"margin: 0px; padding: 0px; cursor: pointer;\">كلمة</label></td><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left; width: 20px;\"><input type=\"radio\" name=\"what\" value=\"words\" id=\"words\" style=\"margin: 3px 6px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif;\"></td></tr><tr style=\"margin: 0px; padding: 0px;\"><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left;\"><label for=\"bytes\" style=\"margin: 0px; padding: 0px; cursor: pointer;\">بايت</label></td><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left; width: 20px;\"><input type=\"radio\" name=\"what\" value=\"bytes\" id=\"bytes\" style=\"margin: 3px 6px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif;\"></td></tr><tr style=\"margin: 0px; padding: 0px;\"><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left;\"><label for=\"lists\" style=\"margin: 0px; padding: 0px; cursor: pointer;\">قائمة</label></td><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: left; width: 20px;\"><input type=\"radio\" name=\"what\" value=\"lists\" id=\"lists\" style=\"margin: 3px 6px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif;\"></td></tr></tbody></table></td><td rowspan=\"2\" style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: center;\"><input type=\"text\" name=\"amount\" value=\"5\" size=\"3\" id=\"amount\" style=\"margin: 3px 6px; padding: 3px 5px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif; width: 30px; text-align: center; border-width: 1px; border-style: solid; border-color: rgb(102, 102, 102) rgb(204, 204, 204) rgb(204, 204, 204) rgb(102, 102, 102);\"></td></tr><tr style=\"margin: 0px; padding: 0px;\"><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle;\"><input type=\"submit\" name=\"generate\" id=\"generate\" value=\"قم بتكوين نص لوريم إيبسوم\" dir=\"rtl\" style=\"margin-top: 10px; padding: 3px 10px; font-size: 14px; font-family: \"Open Sans\", Arial, sans-serif; border-width: 1px; border-style: solid; border-color: rgb(153, 153, 153); background: rgb(238, 238, 238); border-radius: 4px; appearance: none;\"></td><td style=\"margin: 0px; padding: 0px; border: 0px; vertical-align: middle; text-align: center;\"></td></tr></tbody></table></form></div><div style=\"margin: 0px 28.7969px 0px 14.3906px; padding: 0px; width: 436.797px; text-align: right; float: right; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-family: DauphinPlain; font-size: 24px; line-height: 24px;\">ما أصله ؟</h2><p dir=\"rtl\" style=\"margin-bottom: 15px; padding: 0px; text-align: justify;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p></div>', 'سياسة الخصوصية', 'سياسة الخصوصية', 'سياسة الخصوصية');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language`
--

CREATE TABLE `ci_language` (
  `language_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_language`
--

INSERT INTO `ci_language` (`language_id`, `name`, `code`, `locale`, `sort_order`, `status`) VALUES
(1, 'English', 'en', 'en-gb,en', 1, 1),
(2, 'العربية', 'ar', 'ar,ar_EG', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout`
--

CREATE TABLE `ci_layout` (
  `layout_id` int NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_layout`
--

INSERT INTO `ci_layout` (`layout_id`, `name`) VALUES
(1, 'Home'),
(2, 'Account'),
(3, 'Dashboard'),
(4, 'Information'),
(5, 'Contact Us');

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_module`
--

CREATE TABLE `ci_layout_module` (
  `layout_module_id` int NOT NULL,
  `layout_id` int NOT NULL,
  `code` varchar(64) NOT NULL,
  `position` varchar(14) NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_layout_module`
--

INSERT INTO `ci_layout_module` (`layout_module_id`, `layout_id`, `code`, `position`, `sort_order`) VALUES
(19, 5, 'html.8', 'content_top', 1),
(45, 1, 'html.18', 'content_top', 5),
(43, 1, 'html.16', 'content_top', 3),
(44, 1, 'html.17', 'content_top', 4),
(18, 3, 'account', 'column_left', 1),
(42, 1, 'html.15', 'content_top', 2),
(41, 1, 'carousel.1', 'content_top', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_route`
--

CREATE TABLE `ci_layout_route` (
  `layout_route_id` int NOT NULL,
  `layout_id` int NOT NULL,
  `site_id` int NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_layout_route`
--

INSERT INTO `ci_layout_route` (`layout_route_id`, `layout_id`, `site_id`, `route`) VALUES
(21, 1, 0, 'Common/Home'),
(22, 4, 0, 'Information/Information'),
(9, 5, 0, 'Information/Contact'),
(8, 3, 0, 'Account/Dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `ci_module`
--

CREATE TABLE `ci_module` (
  `module_id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(32) NOT NULL,
  `setting` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_module`
--

INSERT INTO `ci_module` (`module_id`, `name`, `code`, `setting`) VALUES
(1, 'Home Page SlideShow', 'carousel', '{\"name\":\"Home Page SlideShow\",\"banner_id\":\"1\",\"width\":\"1200\",\"height\":\"650\",\"autoplay\":\"1\",\"dots\":\"1\",\"infinite\":\"1\",\"arrows\":\"0\",\"status\":\"1\"}'),
(3, 'Home Page Video', 'video', '{\"name\":\"Home Page Video\",\"module_description\":{\"headline\":\"Welcome to Happy Days Cork <br \\/> Your Chidren are Safe With Us!\",\"mp4\":\"catalog\\/video\\/MVI_5540.mp4\",\"webm\":\"\",\"image\":\"catalog\\/video\\/MVI_5540.png\"},\"status\":\"1\"}'),
(15, 'About', 'html', '{\"name\":\"About\",\"module_description\":{\"title\":\"\",\"description\":\"<!-- About Start here -->\\r\\n  <section class=\\\"about about-two padding-120\\\">\\r\\n    <div class=\\\"container\\\">\\r\\n      <div class=\\\"row\\\">\\r\\n        <div class=\\\"col-lg-6\\\">\\r\\n          <div class=\\\"about-image\\\">\\r\\n            <img src=\\\"catalog\\/kidsacademy\\/images\\/about\\/about-3.png\\\" alt=\\\"about image\\\" class=\\\"img-responsive\\\">\\r\\n          <\\/div>\\r\\n        <\\/div>\\r\\n        <div class=\\\"col-lg-6\\\">\\r\\n          <div class=\\\"about-content\\\">\\r\\n            <h3>About Our KidsAcademy<\\/h3>\\r\\n            <p>Enthusiasticay diseminate competitive oportunitie through transparent an actions Compelngly seize viral\\r\\n              schemas through intermandated creative is adiea sources. Enthusiasticay plagiarize clientcentered\\r\\n              relationship for the covalent experiences. Distinctively architect 24\\/365 service for wireless is\\r\\n              ebusiness ahosfluorescently Efficiently comunicate coperative methods of empowerment awesome athrough\\r\\n              Monotonectaly myocardinate cross and functional niche markets and an functional.<\\/p>\\r\\n            <ul>\\r\\n              <li><a href=\\\"#\\\" class=\\\"button-default\\\">Read More<\\/a><\\/li>\\r\\n              <li><a href=\\\"#\\\" class=\\\"button-default\\\">Buy Now<\\/a><\\/li>\\r\\n            <\\/ul>\\r\\n          <\\/div><!-- about content -->\\r\\n        <\\/div>\\r\\n      <\\/div><!-- row -->\\r\\n    <\\/div><!-- container -->\\r\\n  <\\/section><!-- about -->\\r\\n  <!-- About End here -->\"},\"status\":\"1\"}'),
(16, 'facility', 'html', '{\"name\":\"facility\",\"module_description\":{\"title\":\"\",\"description\":\"  <!-- facility Start here -->\\r\\n  <section class=\\\"facility facility-three padding-120\\\">\\r\\n    <div class=\\\"container\\\">\\r\\n      <div class=\\\"section-header\\\">\\r\\n        <h3>Our School Fecilities<\\/h3>\\r\\n        <p>Rapidiously expedite granular imperatives before economically sound web services. Credibly actualize pandemic\\r\\n          strategic themeplatform.<\\/p>\\r\\n      <\\/div>\\r\\n      <div class=\\\"row\\\">\\r\\n        <div class=\\\"col-lg-3 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"facility-item\\\">\\r\\n            <span class=\\\"icon flaticon-symbols\\\"><\\/span>\\r\\n            <h4>Active Learning<\\/h4>\\r\\n            <p>Uniquely productivate real time collaboration idea-sharing after awesome quality vectors after<\\/p>\\r\\n          <\\/div><!-- facility item -->\\r\\n        <\\/div>\\r\\n        <div class=\\\"col-lg-3 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"facility-item\\\">\\r\\n            <span class=\\\"icon flaticon-avatar\\\"><\\/span>\\r\\n            <h4>Expert Teachers<\\/h4>\\r\\n            <p>Uniquely productivate real time collaboration idea-sharing after awesome quality vectors after<\\/p>\\r\\n          <\\/div><!-- facility item -->\\r\\n        <\\/div>\\r\\n        <div class=\\\"col-lg-3 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"facility-item\\\">\\r\\n            <span class=\\\"icon flaticon-world\\\"><\\/span>\\r\\n            <h4>Strategi Location<\\/h4>\\r\\n            <p>Uniquely productivate real time collaboration idea-sharing after awesome quality vectors after<\\/p>\\r\\n          <\\/div><!-- facility item -->\\r\\n        <\\/div>\\r\\n        <div class=\\\"col-lg-3 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"facility-item\\\">\\r\\n            <span class=\\\"icon flaticon-line-chart\\\"><\\/span>\\r\\n            <h4>Full Day Programs<\\/h4>\\r\\n            <p>Uniquely productivate real time collaboration idea-sharing after awesome quality vectors after<\\/p>\\r\\n          <\\/div><!-- facility item -->\\r\\n        <\\/div>\\r\\n      <\\/div><!-- row -->\\r\\n    <\\/div><!-- container -->\\r\\n  <\\/section><!-- facility -->\\r\\n  <!-- facility End here -->\"},\"status\":\"1\"}'),
(17, 'Classes', 'html', '{\"name\":\"Classes\",\"module_description\":{\"title\":\"\",\"description\":\"<!-- Classes Start here -->\\r\\n  <section class=\\\"classes padding-120\\\">\\r\\n    <div class=\\\"container\\\">\\r\\n      <div class=\\\"section-header\\\">\\r\\n        <h3>Our Popular Classes<\\/h3>\\r\\n        <p>Rapidiously expedite granular imperatives before economically sound web services. Credibly actualize pandemic\\r\\n          strategic themeplatform.<\\/p>\\r\\n      <\\/div>\\r\\n      <div class=\\\"row\\\">\\r\\n        <div class=\\\"col-lg-4 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"class-item\\\">\\r\\n            <div class=\\\"image\\\">\\r\\n              <img src=\\\"catalog\\/kidsacademy\\/images\\/classes\\/class_01.jpg\\\" alt=\\\"class image\\\" class=\\\"img-responsive\\\">\\r\\n            <\\/div>\\r\\n            <ul class=\\\"schedule\\\">\\r\\n              <li>\\r\\n                <span>Class Size<\\/span>\\r\\n                <span>30 - 40<\\/span>\\r\\n              <\\/li>\\r\\n              <li>\\r\\n                <span>Years Old<\\/span>\\r\\n                <span>5 - 6<\\/span>\\r\\n              <\\/li>\\r\\n              <li>\\r\\n                <span>Tution Fee<\\/span>\\r\\n                <span>$1500<\\/span>\\r\\n              <\\/li>\\r\\n            <\\/ul>\\r\\n            <div class=\\\"content\\\">\\r\\n              <h4><a href=\\\"class-single.html\\\">Imagination Classes<\\/a><\\/h4>\\r\\n              <p><span>Class Time<\\/span> : 08:00 am - 10:00 am<\\/p>\\r\\n              <p>Draticaly novate fuly rarched an plications awesome theme education<\\/p>\\r\\n            <\\/div>\\r\\n            <div class=\\\"address\\\">\\r\\n              <p><span><i class=\\\"fa fa-home\\\" aria-hidden=\\\"true\\\"><\\/i><\\/span> 218 New Newyork Road, USA- 1205<\\/p>\\r\\n            <\\/div>\\r\\n          <\\/div><!-- class item -->\\r\\n        <\\/div>\\r\\n        <div class=\\\"col-lg-4 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"class-item\\\">\\r\\n            <div class=\\\"image\\\">\\r\\n              <img src=\\\"catalog\\/kidsacademy\\/images\\/classes\\/class_02.jpg\\\" alt=\\\"class image\\\" class=\\\"img-responsive\\\">\\r\\n            <\\/div>\\r\\n            <ul class=\\\"schedule\\\">\\r\\n              <li>\\r\\n                <span>Class Size<\\/span>\\r\\n                <span>30 - 40<\\/span>\\r\\n              <\\/li>\\r\\n              <li>\\r\\n                <span>Years Old<\\/span>\\r\\n                <span>5 - 6<\\/span>\\r\\n              <\\/li>\\r\\n              <li>\\r\\n                <span>Tution Fee<\\/span>\\r\\n                <span>$1500<\\/span>\\r\\n              <\\/li>\\r\\n            <\\/ul>\\r\\n            <div class=\\\"content\\\">\\r\\n              <h4><a href=\\\"class-single.html\\\">Drawing Classes<\\/a><\\/h4>\\r\\n              <p><span>Class Time<\\/span> : 08:00 am - 10:00 am<\\/p>\\r\\n              <p>Draticaly novate fuly rarched an plications awesome theme education<\\/p>\\r\\n            <\\/div>\\r\\n            <div class=\\\"address\\\">\\r\\n              <p><span><i class=\\\"fa fa-home\\\" aria-hidden=\\\"true\\\"><\\/i><\\/span> 218 New Newyork Road, USA- 1205<\\/p>\\r\\n            <\\/div>\\r\\n          <\\/div><!-- class item -->\\r\\n        <\\/div>\\r\\n        <div class=\\\"col-lg-4 col-sm-6 col-xs-12\\\">\\r\\n          <div class=\\\"class-item\\\">\\r\\n            <div class=\\\"image\\\">\\r\\n              <img src=\\\"catalog\\/kidsacademy\\/images\\/classes\\/class_03.jpg\\\" alt=\\\"class image\\\" class=\\\"img-responsive\\\">\\r\\n            <\\/div>\\r\\n            <ul class=\\\"schedule\\\">\\r\\n              <li>\\r\\n                <span>Class Size<\\/span>\\r\\n                <span>30 - 40<\\/span>\\r\\n              <\\/li>\\r\\n              <li>\\r\\n                <span>Years Old<\\/span>\\r\\n                <span>5 - 6<\\/span>\\r\\n              <\\/li>\\r\\n              <li>\\r\\n                <span>Tution Fee<\\/span>\\r\\n                <span>$1500<\\/span>\\r\\n              <\\/li>\\r\\n            <\\/ul>\\r\\n            <div class=\\\"content\\\">\\r\\n              <h4><a href=\\\"class-single.html\\\">Learning Classes<\\/a><\\/h4>\\r\\n              <p><span>Class Time<\\/span> : 08:00 am - 10:00 am<\\/p>\\r\\n              <p>Draticaly novate fuly rarched an plications awesome theme education<\\/p>\\r\\n            <\\/div>\\r\\n            <div class=\\\"address\\\">\\r\\n              <p><span><i class=\\\"fa fa-home\\\" aria-hidden=\\\"true\\\"><\\/i><\\/span> 218 New Newyork Road, USA- 1205<\\/p>\\r\\n            <\\/div>\\r\\n          <\\/div><!-- class item -->\\r\\n        <\\/div>\\r\\n      <\\/div><!-- row -->\\r\\n      <div class=\\\"class-button\\\">\\r\\n        <a href=\\\"classes.html\\\" class=\\\"button-default\\\">See More Classes<\\/a>\\r\\n      <\\/div>\\r\\n    <\\/div><!-- container -->\\r\\n  <\\/section><!-- classes -->\\r\\n  <!-- Classes End here -->\"},\"status\":\"1\"}'),
(8, 'Google Maps', 'html', '{\"name\":\"Google Maps\",\"module_description\":{\"title\":\"\",\"description\":\"<iframe src=\\\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d2461.7357022267965!2d-8.4723965843174!3d51.9022871895744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4844900e7520086f%3A0xd77060c23b6081d1!2sHappy%20Days%20Montessori!5e0!3m2!1sen!2sie!4v1630965370582!5m2!1sen!2sie\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"true\\\" loading=\\\"lazy\\\" width=\\\"1437\\\" height=\\\"350\\\"><\\/iframe>\"},\"status\":\"1\"}'),
(9, 'Home Gallary', 'html', '{\"name\":\"Home Gallary\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"container-sm\\\">\\r\\n  <div class=\\\"row justify-content-center\\\">\\r\\n    <div class=\\\"col col-md-10\\\">\\r\\n      <div class=\\\"gallery-container\\\" id=\\\"animated-thumbnails-gallery\\\">\\r\\n        <a data-lg-size=\\\"1600-1067\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@tobbes_rd\' >Tobias Rademacher <\\/a><\\/h4><p> Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/puezgruppe%2C-wolkenstein-in-gr%C3%B6den%2C-s%C3%BCdtirol%2C-italien\'>Puezgruppe, Wolkenstein in Gr\\u00f6den, S\\u00fcdtirol, Italien<\\/a>layers of blue.<\\/p>\\\">\\r\\n          <img alt=\\\"layers of blue.\\\" class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it2\\\" data-tweet-text=\\\"lightGallery slide  2\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@therawhunter\' >Massimiliano Morosinotto <\\/a><\\/h4><p> Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/tre-cime-di-lavaredo%2C-italia\'>Tre Cime di Lavaredo, Italia<\\/a>This is the Way<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@thesaboo\' >Sascha Bosshard <\\/a><\\/h4><p> Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/pizol%2C-mels%2C-schweiz\'>Pizol, Mels, Schweiz<\\/a><\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2398\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@yusufevli\' >Yusuf Evli <\\/a><\\/h4><p> Foggy Road<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@flovayn\' >Jay Mantri<\\/a><\\/h4><p>  Misty shroud over a forest<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@flovayn\' >Florian van Duyn<\\/a><\\/h4><p>Location - <a href=\'Bled, Slovenia\'>Bled, Slovenia<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1126\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1477322524744-0eece9e79640?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@juanster\' >Juan Davila<\\/a><\\/h4><p>Location - <a href=\'Bled, Slovenia\'>Bled, Slovenia<\\/a> Wooded lake island <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1477322524744-0eece9e79640?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1063\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1469474968028-56623f02e42e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@davidmarcu\' >David Marcu<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/ciuca%C8%99-peak%2C-romania\'>Ciuca\\u0219 Peak, Romania<\\/a> Alone in the unspoilt wilderness <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1469474968028-56623f02e42e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1585338447937-7082f8fc763d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@whoisbenjamin\' >whoisbenjamin<\\/a><\\/h4>\\r\\n                <p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/ciuca%C8%99-peak%2C-romania\'>Snowdonia National Park, Blaenau Ffestiniog, UK<\\/a> \\r\\n                A swan on a calm misty lake in the mountains of Snowdonia, North Wales. <a href=\'https:\\/\\/unsplash.com\\/photos\\/9V6EkAoTWJM\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1585338447937-7082f8fc763d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1144\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1476842384041-a57a4f124e2e?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@aaronburden\' >Aaron Burden<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/grayling%2C-michigan%2C-united-states\'>Grayling, Michigan, United States<\\/a> Colorful trees near a lake. <a href=\'https:\\/\\/unsplash.com\\/photos\\/00QWN1J0g48\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1476842384041-a57a4f124e2e?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1465311530779-5241f5a29892?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@kalenemsley\' >Kalen Emsley<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/yukon-territory%2C-canada\'>Yukon Territory, Canada<\\/a> No captions. <a href=\'https:\\/\\/unsplash.com\\/photos\\/eHpYD4U5830\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1465311530779-5241f5a29892?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1461301214746-1e109215d6d3?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@kace\' >Kace Rodriguez<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/pfeiffer-beach%2C-united-states\'>Pfeiffer Beach, United States<\\/a> Pfeiffer Beach at Dusk. <a href=\'https:\\/\\/unsplash.com\\/photos\\/eHpYD4U5830\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1461301214746-1e109215d6d3?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1610448721566-47369c768e70?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@patwhelen\' >Pat Whelen<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/portsea-vic%2C-australia\'>Portsea VIC, Australia<\\/a> No caption <a href=\'https:\\/\\/unsplash.com\\/photos\\/EKLXDQ-dDRg\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1610448721566-47369c768e70?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510414842594-a61c69b5ae57?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@derekthomson\' >Derek Thomson<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/mcway-falls%2C-united-states\'>McWay Falls, United States<\\/a> No caption <a href=\'https:\\/\\/unsplash.com\\/photos\\/TWoL-QCZubY\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510414842594-a61c69b5ae57?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1539678050869-2b97c7c359fd?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@michaljaneck\' >Michal Janek<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/big-sur%2C-united-states\'>Big Sur, United States<\\/a> Coast  <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1539678050869-2b97c7c359fd?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1446630073557-fca43d580fbe?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@papillon\' >Iris Papillon<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/big-sur%2C-united-states\'>Big Sur, United States<\\/a> Big Sur drive  <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1446630073557-fca43d580fbe?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1065\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1596370743446-6a7ef43a36f9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@piyushh_dubeyy\' >piyush dubey<\\/a><\\/h4><p>Published on August 2, 2020<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1596370743446-6a7ef43a36f9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2134\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1464852045489-bccb7d17fe39?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@fynn_it\' >fynn<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/big-sur%2C-united-states\'>Big Sur, United States<\\/a> Wasserauen, Appenzell Innerrhoden, Schweiz  <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1464852045489-bccb7d17fe39?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1060\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1483728642387-6c3bdd6c93e5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@danielleone\' >Daniel Leone<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/poon-hill%2C-ghode-pani%2C-nepal\'>Poon Hill, Ghode Pani, Nepal<\\/a> Taken from the top of Poon Hill before sun rise <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1483728642387-6c3bdd6c93e5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1037\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510011560141-62c7e8fc7908?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@bboba\' >Boba Jovanovic<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/bay-of-kotor\'>Bay of Kotor<\\/a> Boka kotorska bay <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510011560141-62c7e8fc7908?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-899\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1586276393635-5ecd8a851acc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@svsdesigns\' >Surendra Vikram Singh<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/lachung%2C-sikkim%2C-india\'>Lachung, Sikkim, India<\\/a> Cloud covered mountain <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1586276393635-5ecd8a851acc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1471931452361-f5ff1faa15ad?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2252&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@camadams\' >Cam Adams<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/banff%2C-canada\'>Banff, Canada<\\/a> Lake along jagged mountains<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1471931452361-f5ff1faa15ad?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1536-2304\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1508766206392-8bd5cf550d1c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1536&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@rea_le\' >Andrea Ledda<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/lago-goillet%2C-italy\'>Lago Goillet, Italy<\\/a>  Goillet Lake at 2561 meters above Breuil-Cervinia<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1508766206392-8bd5cf550d1c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n      <\\/div>\\r\\n    <\\/div>\\r\\n  <\\/div>\\r\\n<\\/div>\"},\"status\":\"1\"}'),
(18, 'Teachers', 'html', '{\"name\":\"Teachers\",\"module_description\":{\"title\":\"\",\"description\":\"<!-- Teachers Start here -->\\r\\n  <section class=\\\"teachers teachers-three padding-120\\\">\\r\\n    <div class=\\\"container\\\">\\r\\n      <div class=\\\"section-header\\\">\\r\\n        <h3>Meet Our Teachers<\\/h3>\\r\\n        <p>Rapidiously expedite granular imperatives before economically sound web services. Credibly actualize pandemic\\r\\n          strategic themeplatform.<\\/p>\\r\\n      <\\/div>\\r\\n      <div class=\\\"teacher-items\\\">\\r\\n        <div class=\\\"teacher-slider swiper-container\\\">\\r\\n          <div class=\\\"swiper-wrapper\\\">\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_13.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Alex Jhonson<\\/a><\\/h4>\\r\\n                <span>Sains Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_14.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Paul Thomas<\\/a><\\/h4>\\r\\n                <span>Art Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_15.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Henry Jhonson<\\/a><\\/h4>\\r\\n                <span>English Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_16.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Alex kshe<\\/a><\\/h4>\\r\\n                <span>Math Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_09.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Alex Ude<\\/a><\\/h4>\\r\\n                <span>Sains Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_10.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Healex Jhonson<\\/a><\\/h4>\\r\\n                <span>Art Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_11.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Gary Jhonson<\\/a><\\/h4>\\r\\n                <span>English Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item -->\\r\\n            <div class=\\\"teacher-item swiper-slide\\\">\\r\\n              <div class=\\\"teacher-image\\\">\\r\\n                <img src=\\\"catalog\\/kidsacademy\\/images\\/teachers\\/teacher_12.jpg\\\" alt=\\\"teacher image\\\" class=\\\"img-responsive\\\">\\r\\n              <\\/div>\\r\\n              <div class=\\\"teacher-content\\\">\\r\\n                <h4><a href=\\\"teacher-details.html\\\">Robarto Jhonson<\\/a><\\/h4>\\r\\n                <span>Math Teacher<\\/span>\\r\\n              <\\/div>\\r\\n            <\\/div><!-- teacher-item --><\\/div><\\/div><\\/div><\\/div><\\/section>\"},\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `ci_routes`
--

CREATE TABLE `ci_routes` (
  `route_id` int NOT NULL,
  `site_id` int NOT NULL,
  `language_id` int NOT NULL,
  `keyword` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `segment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_routes`
--

INSERT INTO `ci_routes` (`route_id`, `site_id`, `language_id`, `keyword`, `segment`) VALUES
(1, 0, 1, 'about-us', 'information_id=1');

-- --------------------------------------------------------

--
-- Table structure for table `ci_schemes`
--

CREATE TABLE `ci_schemes` (
  `scheme_id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_schemes`
--

INSERT INTO `ci_schemes` (`scheme_id`, `name`, `description`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 'NCS Scheme', 'It is the first ever statutory entitlement to financial support for childcare. It establishes an equitable and progressive system of universal and income-related subsidies for children up to the age of 15. It also provides an innovative and user-friendly online application process to access those subsidies.', 1626598082, 1626598587, NULL),
(2, 'ECCE Scheme', 'If your child was born in 2017 or 2018 (between 1st Jan 2017 and 31 December 2018), your child will qualify for the ECCE preschool scheme from September 2020. This scheme provides for a subsidy of €2,451 per annum based on 5 days per week care (€64.50 over 38 weeks). Funding is pro rata for part time care. In order to register children for the scheme, Giraffe will require your child’s full name, pps number and date of birth. One registered, we will deduct the ECCE preschool grant off your fees.', 1626598665, 1626599168, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('07ao46puj19ti8nrtqlfp8qjtgm0k3pp', '::1', '2022-05-01 23:30:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434373830303b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('07g1ptd3dlc8nft8ko3q7b1frbuqh1th', '::1', '2022-05-04 23:21:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730363439343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('0934jtcdneprf1nccm2uqh7ojkkpguja', '::1', '2022-06-15 16:52:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635353331313735353b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31223b),
('0p28ue3op9fooab6pt278qrju4vll0u9', '::1', '2022-05-12 21:24:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339303635393b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('0peio9rr3bv73tgb6fmu4f58qm1rohj4', '::1', '2022-03-01 20:44:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136373439363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('0qcs5u7nbnranlo4f2gmj434lsbbf24f', '::1', '2022-09-18 13:29:02', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530373734323b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('0rjac04g98s6b8kmf1ra8d1pk7ke55r2', '127.0.0.1', '2021-10-15 10:40:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343239343336313b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d33223b),
('0t0ta9du2skff3ulbmu2u37tvcg99450', '::1', '2022-05-21 16:17:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333134393835323b5f63695f70726576696f75735f75726c7c733a35393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d707269766163792d706f6c696379223b),
('0t3nu56nraq7cqahkuen1scm4bmt19ok', '::1', '2022-04-08 00:19:54', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393337373139343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('0tq7dtrdj97hvsa79pfaacte407a4fc2', '::1', '2022-03-02 07:10:37', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363230353033373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('0vi18rqhstll6qsbpnmecjue33t4jpfp', '::1', '2022-05-05 00:07:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730393236323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('10a48hgf3t7njd3tpcq4t8brha0tsn9a', '::1', '2022-05-01 23:35:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434383130363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('11go82o4hd1gnp9m5cc15fs60rak06l5', '127.0.0.1', '2023-02-04 17:49:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533323939313b),
('11k2suq5rj6n6616rsf63vsvpslskv4j', '::1', '2022-09-17 20:06:03', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434353136333b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('1d8f8lfsolqji13u535u2e2f0kmmf96g', '::1', '2022-05-12 20:30:13', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323338373335313b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f61626f75742d7573223b),
('1hka9l2u2j6rtuc1ajah9e4s2e8uc81u', '::1', '2022-09-18 13:50:25', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530393032353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('1l4cjo281h828vsed0ubg821pr298d4p', '::1', '2022-09-16 22:27:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336373236353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('1pks87f01emeu8mnrugus1g2vsnhk8f5', '::1', '2022-03-03 07:21:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363239323036313b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('1su13apvu66v2gun7gbrn22rh3brc3j2', '::1', '2023-02-04 18:42:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533363132313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('1u78tr20a07s2cbsn06e9gmtdf8co092', '::1', '2022-03-02 08:51:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363231313036383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('1v2ac7h4i4dr6fd6hhj98rdkeefoatnl', '::1', '2022-02-28 15:30:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363036323231323b),
('20v6tvovtp84oa46i7f931tjmlc9uv2n', '::1', '2022-09-18 13:28:41', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530373732313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('21hcsr7uh1mhtr1temupd198cc838kkt', '::1', '2022-02-18 17:50:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353230363633363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('23daa51eakfjmnv0nt5qvi5928virkka', '::1', '2022-09-17 20:28:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434363532333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('255qa05ptssl15t8m7bd1hni9v8m2na0', '::1', '2022-03-01 08:03:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132313832333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('299e2vucmporabj7pc0t083rcgopnjrd', '::1', '2022-05-21 16:40:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333135313231383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2ajna4uhb4o4oce9dq485bpjvakafp91', '127.0.0.1', '2022-01-31 16:38:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634373132363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2cuv278o38mr9gahrahe62vv7brtovo5', '::1', '2022-03-01 07:37:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132303237383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2elbelk51iu6g0fqqo9up7sme2b7qr4p', '::1', '2022-02-16 09:10:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353030323539303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2gfiru5jq60q8frulouhl8v9ak6sbumn', '::1', '2022-02-14 09:51:21', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343833323237343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2mfbdk14eles6s9lutpi5tv9ejklrhu5', '::1', '2022-05-04 19:02:25', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313639303934313b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('2ucesha7j0rfk06fadbjis3ep6h5a5b6', '::1', '2022-09-16 22:33:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336373631343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2v440te1vh6mq50ro7reb22uefhmvajv', '::1', '2022-03-01 07:17:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363131393032303b),
('31p010i5dk0rf7cfcd1b956du2ltj9ek', '127.0.0.1', '2022-02-07 07:38:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343231393432383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('34eauvn3uu9cq0cfdsgf24g4saqvge83', '::1', '2021-12-21 18:35:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634303131313437363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('395k9rchj43k2rmikuqp633jlrfioorm', '127.0.0.1', '2022-01-31 18:45:05', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635343730353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('39bdpf0bl16ob4kvober19uqiinor70d', '::1', '2022-05-15 20:11:29', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634353230303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('3alep4j106kpdq76vdv07qb0ogrjum6h', '::1', '2022-05-04 23:11:11', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730353837313b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('3ap8bkasnevvpfdpnm0tdl4lhfp3l53u', '127.0.0.1', '2023-02-04 17:55:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533333330383b),
('3cjo16eu2j3t7as570tmvrpjqvujmtrv', '::1', '2022-05-18 13:14:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323837393633383b),
('3ck2fpoqt6402f3l9fkivdv7v9p0mfh1', '::1', '2022-05-02 00:25:15', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435313131353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('3k79p8lpb5p7cmdnmrvnimen1seavu53', '127.0.0.1', '2021-10-21 06:55:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343739393334323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('3oefj582ep8idqljpmio02scafet51l6', '::1', '2022-05-12 22:23:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339343233323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('3u96ep8q3a44v983b8bl0rqcevlta8cr', '::1', '2022-03-01 20:33:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136363738313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('463qnp257ojffja6p92tjledb5q6c2mj', '::1', '2022-03-01 08:40:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132343035393b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('469rf0imd86r8q1f6iipvkr1a1ij9f3v', '::1', '2022-02-18 09:27:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137363436363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('48igokp0mua9k086g4bp25fomocujb9p', '127.0.0.1', '2021-10-18 07:34:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343534323435383b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('4aemrpto1911t4e0vavmua1qu298euqr', '::1', '2022-02-18 08:09:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137313738373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('4at1gt6m58fgs47hqn4igesr42r9ogvq', '127.0.0.1', '2022-02-07 08:11:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343232313337383b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('4g8j6il23ff7ubuqhb32pi1fuk4l1iln', '::1', '2022-09-17 19:43:44', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434333832343b5f63695f70726576696f75735f75726c7c733a35323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f73702d7465726d732d636f6e646974696f6e73223b),
('4ics0ru96ipbvcfmnsqpdbp9eukbh95n', '::1', '2022-04-08 07:38:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393430333439303b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e2663757272656e63793d657572223b),
('4thtsshavrjc1kuj7ivfc9qni31jfhdp', '::1', '2022-03-01 20:11:41', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136353530313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('52hi4a6b9ma88n58csfpk5idqkbnahsh', '::1', '2022-09-18 15:20:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531343239343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('56idi6eg162mr0qq839et5tnmsrssm6c', '::1', '2022-02-18 08:01:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137313236363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('59vkcpjbsukmn8sbp4eupilmepmeia85', '::1', '2022-04-08 06:39:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393339393937343b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e2663757272656e63793d455552223b),
('5bbejnp3evr4a1b2oiu4o0s952u1r49k', '127.0.0.1', '2022-01-31 11:09:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373337363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('5cpfhkb1mthc68bsnt1fp7lvrnklavru', '::1', '2022-05-18 21:01:04', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323930373635303b5f63695f70726576696f75735f75726c7c733a35393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d707269766163792d706f6c696379223b),
('5fobsg312a9ct27ct9dv3a6ti8gg8h4e', '::1', '2022-03-25 12:16:31', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383231303539303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('5i10bpker1qdm81a8shraval43crjeoq', '::1', '2022-05-01 23:11:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434363638373b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d34266c6f63616c653d656e2663757272656e63793d676270223b),
('5l6glvkl63oqsm4gv0qce3euee0luvhe', '::1', '2022-05-15 19:55:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634343533343b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f7465726d732d616e642d636f6e646974696f6e73223b),
('5mouue040dlg1cgd4477ft9jdsc3g6ed', '127.0.0.1', '2022-02-07 08:09:38', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343232313337383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('5orc7ie880b39mf6m716ovpa2q1nfmuj', '::1', '2022-05-12 21:03:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323338393136333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f61626f75742d7573223b),
('5pp9sjuf5f8lcatmm7149fi7eioaojqn', '127.0.0.1', '2021-10-17 11:18:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343436393532303b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('5vs10ti7so91246hhraslhl4u0e10oug', '::1', '2022-05-12 21:37:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339313432303b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('63314hj1m6veepre1qvm5770gf1o348d', '::1', '2022-09-17 20:33:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434363832363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('684h7hf7ppe6b9aqj7dqfq08vhaio6b2', '::1', '2022-05-21 16:22:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333135303135353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('694bgk29mhf7u1rjan40cf2q9qj6kdmn', '::1', '2022-05-12 22:01:28', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339323838383b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('6dg4umpu5bq6b78t81b0hjrelf5u9pgf', '127.0.0.1', '2022-01-07 16:56:04', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634313537343536333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('6kegb1hlp6kg9sg1htss7tpvbnq7fnck', '::1', '2022-09-18 14:03:26', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530393830363b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('6oidtf5t8fcrhkkvs7j7sipib6v45mv3', '::1', '2022-05-01 22:40:07', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434343830373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('6qfsped0ssuuo5usu1hbo56jn0jrndv7', '127.0.0.1', '2021-10-17 11:44:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437313037363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('6rr1hqluu3v3slk7supesk0irescd447', '::1', '2021-10-25 20:13:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139323738303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('75qb0a78m0ucv148osk31gube64iqndm', '::1', '2022-05-12 22:30:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339343630393b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('77nf82cviovtnagcsu8sho806bhqi5qd', '::1', '2022-03-02 07:35:03', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363230363530333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('7a2aqlmugtof09tega34tuo143e248me', '::1', '2022-04-07 22:04:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393336393038303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('7eidqhhn011mgqr5npr3b8ht164u3mh5', '::1', '2022-03-02 09:16:13', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363231323537333b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('7fp9ikttocm0l5dja05rkkuo3v822gi6', '::1', '2022-09-18 14:41:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531323039363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('7t2fv8hvg6gnm598bq2qgcc6am9opifq', '127.0.0.1', '2021-10-09 16:56:54', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633333739383439363b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('7t906pel383h1lp1hgbs7j9jrv3sbint', '::1', '2022-03-01 07:32:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363131393937333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('80d0mdrde92bs0ke91jtacbpsfd7mb7e', '::1', '2022-03-25 12:18:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383231303733323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('83r07jkrp3sc1krbf9bsk1q8am8fo6ha', '127.0.0.1', '2021-10-17 12:04:02', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437323234323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('86l35um13uurvo3pe8cfseej42c1fbom', '::1', '2021-10-25 20:34:41', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139343038313b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('87ck3i7rk8fgfpvgkohj6k0b5fu7uddr', '127.0.0.1', '2021-10-15 06:32:55', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343237393431313b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d33223b),
('880auejnq62jsao40cm7dt06as73chsa', '::1', '2022-02-18 09:27:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137363436363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('88bit0ojdpscvvutjmdh64bfou6es6lo', '::1', '2022-05-05 10:04:20', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313734353036303b5f63695f70726576696f75735f75726c7c733a39363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f692f2544392538352544382542392544392538342544392538382544392538352544382541372544382541412d254438254239254439253836254438254137223b),
('88f36k5rmhgr501u4k8ndidiom6mbgpj', '::1', '2022-05-12 21:38:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339313432303b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('8ck84tdnr6ebvo0gb6b4ao86eaj7souk', '::1', '2022-03-01 07:27:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363131393636303b),
('8eoiptnkjcurvpb2vgvbethfq2kh2pse', '::1', '2022-05-01 23:54:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434393237343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('8f7ij1r97da6no81bf2vkk1avmm43ce8', '127.0.0.1', '2021-10-28 06:59:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353430343338353b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f61626f75742d7573223b),
('8fcu5c9f8ggbqb4prjqe8v3ocrnqsoq9', '::1', '2022-09-17 20:46:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434373438363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('8l0gj529aceneas9u9eif9vgm2melu83', '::1', '2022-05-05 00:02:30', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730383935303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('8m1ornlvjo29f3s0btu4gqctl71ehme3', '::1', '2022-02-18 07:47:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137303435353b5f63695f70726576696f75735f75726c7c733a34363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f7265676973746572223b),
('8meeamkh4dsh75hc4r5c3uqjs4f4mava', '::1', '2022-06-29 20:16:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363533333736343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('8qpcofb3n3bctd8gecbdp2ou3dddf37v', '::1', '2022-05-12 21:43:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339313831353b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('8uepgq4916r8bshg6uou56vplfegpuk3', '127.0.0.1', '2022-01-31 10:52:03', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632363332333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('8v651v2shvii3m8bugsf5viboot7bnv3', '::1', '2022-05-15 19:49:57', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634343139373b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f7465726d732d616e642d636f6e646974696f6e73223b),
('8vc3o8s73nr06ab8q46fih00e1pd55ii', '::1', '2022-09-17 19:54:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434343435343b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('9114oat7a2uh9gqkrda7gvutpeptbcb4', '::1', '2022-09-18 14:31:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531313438333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('911vtb87aqo4s89te4kr4ugl6rgpp31b', '::1', '2022-05-14 09:22:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323532303133323b5f63695f70726576696f75735f75726c7c733a34303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f67616c6c657279223b),
('9d2n967dp64bdlp32chmnrdpbstaco80', '::1', '2022-04-08 00:24:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393337373439383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9jv5iogqop9a4vd6g13c7dt5nqpfn9gl', '127.0.0.1', '2023-02-05 09:05:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353538373931323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9ks707vccookjjubnsvceefjhg8lutpi', '::1', '2022-09-18 14:14:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531303438353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9kucsf5fjgk608nl2kgjvotg7b85lmed', '::1', '2022-05-06 23:35:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313838303032363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9lu6thmrj7qa0g2vtqbsgt2vbcmq3mu7', '::1', '2022-05-12 20:29:11', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323338373335313b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f61626f75742d7573223b),
('9pqbno4t79ts1cto1njbla84k65aiekd', '127.0.0.1', '2022-01-29 11:31:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333435353839323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9r0ejpc9kkor1qqfp1vntj4vk9286dnb', '::1', '2022-02-18 20:24:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353231353834383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9s6oa9u97bas7f2ct6fdft2l82fk6phb', '::1', '2022-05-01 22:17:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434333433313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9t2hboc8e9n5a44i1at52f344k3e51l2', '::1', '2022-09-18 14:48:07', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531323437363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9v1sir7kq7qq3i6bh0st0bhpkg2lgjo8', '127.0.0.1', '2022-01-31 19:18:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635363733383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('a0u736bdbgv3oau3jbvoiorkabpoevrf', '::1', '2023-02-02 20:06:04', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353336383336343b),
('a3ba2sfpnunfur6i5lrijhnjejeimthr', '127.0.0.1', '2021-10-13 19:55:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343135343933333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('abjji8j42li3ilcqe4g9v33ec323vob7', '::1', '2022-09-18 14:47:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531323437363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ag7an3acsjoau6e0jv4be0ibbed8rgja', '::1', '2022-03-29 19:04:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383538303634363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('al4kugnd4t6e6ton8rcmg61gcpolhraq', '::1', '2022-05-12 22:18:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339333930373b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('amhlcdp7sst6bge1430b9hg8jq0j3ivu', '::1', '2022-03-01 20:50:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136373830313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('anrgamj9jrbkfclkcnd3uod61s9lcrt4', '::1', '2022-06-15 16:49:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635353331313735343b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31223b),
('aq3sask1ne75j5q8g7ong2tmjqflb6k4', '127.0.0.1', '2021-11-06 18:12:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633363232323336353b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f61626f75742d7573223b),
('at8btogg10hf44ac7p9m2ibac48q1pug', '::1', '2022-05-04 23:55:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730383532323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('at8tbee7u5bskro5f9498c05e868odnb', '::1', '2022-05-21 16:12:31', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333134393535313b5f63695f70726576696f75735f75726c7c733a35393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d707269766163792d706f6c696379223b),
('b03denj2jb2ml0lgt2vvngk2oih89c8t', '::1', '2022-05-02 00:43:02', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435323132363b5f63695f70726576696f75735f75726c7c733a34303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f636f6e746163742d7573223b),
('b05h1mjk1p5sc6i2dekgg77vffc81i4s', '127.0.0.1', '2021-10-20 16:36:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734373831313b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('b1hc47qmt2i393r6u2920ic1g586kk4l', '127.0.0.1', '2022-01-31 18:35:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635343135363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('b71dvijmi5be8s7nt6oun9l4rlt80jvr', '::1', '2022-03-02 09:02:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363231313737383b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('bfcbicjq1gl18t0eij02a3uqiet5h5qm', '::1', '2022-04-08 06:27:20', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393339393234303b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('bg81j74b4k6edrkv6v1co0abj5lodhpf', '::1', '2022-09-16 22:45:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336383332333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('bgjq8lg63l3ed6ss5058lj0mvhd3cfge', '127.0.0.1', '2021-10-24 22:03:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353131323739363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('bm3t1iahi98rp3u20vsbssl9572h8cge', '127.0.0.1', '2021-10-17 11:34:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437303434383b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('bpp29oa5esri8u4pm4bin93v5d2kcbv5', '::1', '2022-05-06 23:33:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313838303032363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('bq2kahr2e3k81dlcvvs5uv96vqbheq32', '::1', '2022-04-08 06:32:54', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393339393537343b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('bv1o7qjmeqn4uts1e1kn9undnlunpq35', '::1', '2022-04-08 07:38:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393430333439303b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d37266c6f63616c653d656e2663757272656e63793d657572223b),
('c4id2jh6pbhgioje8n78spssolh1care', '::1', '2022-05-21 16:35:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333135303931343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('c7bj8nhpqnnr8g1ps1ph39h8rgfng3pf', '::1', '2022-03-29 19:04:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383538303634363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('cbtf33a665enagkhu6edo0tpan7q2rvk', '127.0.0.1', '2022-01-31 11:04:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373036323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('cev1hscps9caeq5fojonlf7qsmd62lh1', '::1', '2022-05-12 21:31:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339313037363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('cjosoeejlm9stcjodq9lsod1op09dbi6', '::1', '2022-03-29 17:08:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383537333635363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('cqeee0d505h0rsqlgcgvcfhig01rjple', '127.0.0.1', '2023-02-04 18:31:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533353330353b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('cv5qnk3b5majnccd8nf6tm0731i48tnm', '127.0.0.1', '2023-02-05 08:55:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353538373335393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('d44ncvgncpc56bb4fe8vp5kb890a9t3e', '::1', '2022-02-18 17:34:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353230353635363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('d60odma48gl2osgjbmdmp5b80kdpvhg7', '::1', '2022-03-02 09:16:30', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363231323537333b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('d6bnq7a5k2h663d0bm8soi8bsq2r4b2s', '::1', '2022-05-15 20:06:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634353230303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('d8u6e9k3m4658bhqtkd7odltp7lju5ok', '::1', '2022-05-04 22:58:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730353133313b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('dej9nummp4nekh3p2oblq67j60etvac8', '127.0.0.1', '2021-10-12 09:36:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343033313336303b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('dgaeh68qh44ld8j47gsnfn57cqre8l47', '::1', '2022-09-17 20:12:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434353439393b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('dig57384cpa5cfm5eo1qi96q39064fl8', '::1', '2022-03-01 08:47:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132343436343b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('dkhbluf7mn72d9rub7a8cl1jibcir374', '127.0.0.1', '2022-01-31 11:15:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373735333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('dktldqd2i3g3k046kjo21d8ugp4phjrg', '::1', '2022-05-12 21:18:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339303331333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('doj2ginki84bttn38dq8kn8r4ed1ulb0', '::1', '2022-03-01 08:09:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132323134303b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('dpajllsjpc5i36p4kpt4jvqh998smkmh', '127.0.0.1', '2021-10-12 08:51:11', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343032383637313b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('drfthlqfu4727j99se8hs5k5b2h0800v', '127.0.0.1', '2022-01-31 15:56:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634343536313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ds22tjvbirf385oqkn073tg7h71eonr4', '::1', '2022-03-02 07:18:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363230353439363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('e3ol9i7lseiu91dca8eh6pbbdbandlfv', '::1', '2022-05-02 00:08:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435303038383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('e3olheld2ad8umner1kcm0glabv7tacd', '::1', '2022-05-23 22:26:28', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333334343638373b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31223b),
('ebkiu4a5jo43l6e15t78pj0qr1eikf9p', '::1', '2022-05-14 09:34:07', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323532303737333b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f672d332f63617431223b),
('ebqa1jl1v7rnh3bal8se0pn9m0tdo3m2', '::1', '2021-10-25 20:40:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139343430363b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f637573746f6d65722f6c6f67696e223b),
('ebuqrekc6ne576djh4os5266jethfhr2', '::1', '2022-05-02 00:50:17', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435323438393b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('edep36dtdm723b7878snrd556ad83h4n', '::1', '2022-05-23 22:24:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333334343638373b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31223b),
('egj9d5669ms56f3fcfqjmsjlri2mtntf', '::1', '2022-09-18 13:23:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530373432303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('egropt6uur99uolcd12ttpcckdgma8sc', '127.0.0.1', '2021-10-15 06:29:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343237393338323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('elekdmuqbhhh35snglpj5s41tr38h31d', '127.0.0.1', '2021-10-20 16:26:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734373138333b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('emjgt49c04b2fse2n1a8rn99k56udgcc', '::1', '2022-03-23 07:59:05', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383032323334343b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('eo56jh5t1pbb65hqvajvlv9dkbcjcc7j', '::1', '2022-05-15 19:31:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634333036393b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('eqe9as87goeb52aih92dbphh4j85qv2f', '::1', '2022-03-04 07:22:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363337383535323b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('eqoctkmkvqo45so6cubt8jidtr66kcer', '127.0.0.1', '2022-01-31 16:54:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634383034303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ev15lg5iag3hl2latlop5tknt7aie25f', '::1', '2022-09-16 22:38:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336373932303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('f12mm3r8sfjbtgdv26tfu3idk0g3tosp', '127.0.0.1', '2021-10-13 06:57:48', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343130383236363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('f135q9odfvftplikuekbsajir229urj8', '::1', '2022-05-12 22:35:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339343931383b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f702f63617431223b),
('f1rr26ccqdarr0ti3820f9tnlg9ueu59', '::1', '2021-10-27 07:09:44', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353331383538313b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f707269766163792d706f6c696379223b),
('f4g9c6ljt03jf4j5m3l9tg913iceekg2', '::1', '2022-05-02 00:13:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435303430333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('f4mibppbefh4et76esrsvjosm25vgtv4', '::1', '2022-02-17 11:50:37', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353039383633373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('f905jq5s54c8uhiudsjqmc4r0mq7q2qj', '127.0.0.1', '2021-10-26 19:03:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353237343938383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('fh60etpp5g4e7ci98j0d992mvctfqr5v', '::1', '2022-09-16 22:12:37', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336363335373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('fida1is9hr89es4m069mltovmkli7nc1', '::1', '2022-02-28 09:43:39', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363034313236373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('fjb4pdp5rsojd54gep0l4i1l71fng2up', '127.0.0.1', '2022-01-31 19:18:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635363733383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('frrneiuhk95bo33vormequkn72bipqh3', '::1', '2022-09-16 22:06:30', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336353939303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('fu5n954rud98ic6rq9otg3juqkg25f76', '::1', '2022-09-17 14:21:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333432343437373b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('g23k058esrtseuo2lqs96b4jf3ckovpk', '::1', '2022-09-17 20:00:02', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434343830323b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('gb9vphfpkeb67g1mfvb2n57mco0inbmf', '::1', '2022-09-18 15:18:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531343239343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('gk5q2s1le97ks9mpk7tcs35u6hu06ulu', '::1', '2022-05-18 20:29:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323930353739383b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d61626f75742d7573223b),
('grttihu514om4kuhcpctotd6ccgujm4q', '::1', '2022-02-16 17:51:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353033333836373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('gspdjb3b5hvqdlcbuicd1t32f5lm63pc', '127.0.0.1', '2021-10-20 16:43:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734383134343b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('h8hr50onubhef66mqhnjfmbr8ti073e9', '::1', '2022-03-01 19:57:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136343637333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('h96jgu66s8saqhucbpvbfm0s5donbng7', '127.0.0.1', '2023-02-04 18:12:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533343333303b),
('hau49ks22hq4fa1g1q7oebafgidqmmkt', '127.0.0.1', '2021-10-20 16:18:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734363731343b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('hql91hsvablj0l0raprhvg7vrq7jhd3a', '::1', '2022-05-02 00:30:30', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435313433303b5f63695f70726576696f75735f75726c7c733a34303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f636f6e746163742d7573223b),
('hrc89niku711mun1v2focdft2chaqgnb', '::1', '2022-03-01 14:01:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363134333236393b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('hs5a3mkhtaldq85f7dg1kjiafdppkiav', '127.0.0.1', '2022-01-31 08:19:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333631363832373b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('htmkstj3asl5is7777m2a2709ibk8kqr', '::1', '2022-09-18 15:07:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531333636363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b);
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('i3bfvp1crs1auqdd7gjplo1n5hh74uje', '::1', '2022-09-18 14:03:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530393739393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('i6oifmmeg1lhd926629fi46l3t1t42g7', '127.0.0.1', '2021-10-21 06:56:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343739393337363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('iiqgl23bsg949v41q2vt2vftguneatv8', '::1', '2022-09-17 20:11:39', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434353439393b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('inmqho727r4ui0kvts0k66fc6189mjmk', '::1', '2022-09-18 14:23:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531313032393b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d707269766163792d706f6c696379223b),
('iqho427l50mb6f9cpu4lal1cupg0jf65', '::1', '2022-05-21 16:40:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333135313231383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ivruqtfr1vo79tvl94oudnjts1s2nnpv', '::1', '2022-09-17 18:47:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434303437323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('jcohh1lgrq1c3u2j1qkf075eqdr8af99', '::1', '2022-04-06 09:35:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393233373732303b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('jloekb9go256cc68cbh12mv7jugotdo3', '::1', '2022-03-02 07:24:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363230353835393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('jmi4ooba8dsgsrp3hs3oc5bqla05cps9', '127.0.0.1', '2021-10-20 16:13:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734363339323b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('jnvh8clja1g8vfs91mp68bj5t5lvb34f', '127.0.0.1', '2022-01-31 15:49:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634343137353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('jp8a11i290fk060bjbaa4647i3g2dqod', '127.0.0.1', '2023-02-04 18:28:25', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533353330353b5f63695f70726576696f75735f75726c7c733a34363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f6163636f756e742f6c6f67696e223b),
('jpfvl6gj9g31r0cl0afciqk9lou6veka', '::1', '2021-12-21 18:31:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634303131313437363b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('jrs6uhj2cn7p3tkb58llv2am5nfb795f', '::1', '2022-04-08 00:24:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393337373439383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('jtcq9fm5kmsgt2fm9vi556d43iu7fsl6', '::1', '2021-10-25 21:33:57', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139373633373b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('ju37ug7ai1hesi6g22h57g8q66cu2gdi', '::1', '2022-05-06 23:22:15', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313837393333353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('k098dstt0nmth73ia0nlplsc7obo7rd2', '127.0.0.1', '2022-02-04 17:58:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333939373530363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('k0rgc4417gkc232qtpsmomsccldulahq', '::1', '2022-05-18 21:00:50', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323930373635303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('k79105869do16r9u8mucalj9s8m9lik3', '::1', '2022-09-17 20:11:13', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434353437333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('k84jedj88rhtgqt9qpkmj2p47b7maa2n', '127.0.0.1', '2022-02-02 07:38:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333738373437383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('kfov549vboko46lve5gnjo5i7uuijk0r', '::1', '2022-03-23 07:59:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383032323338363b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('kjc769plnshsj8o3sdr7u7ohsmicrk3f', '127.0.0.1', '2021-10-27 13:54:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353334323733333b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f61626f75742d7573223b),
('klkif5nvov81ic1apo2iqsr9cm7d671n', '127.0.0.1', '2021-10-12 09:36:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343033313336303b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('km6m6mi80t15fvgoh2nasefcdhpd2m44', '::1', '2022-09-18 14:03:26', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530393830363b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('krjvr7vrgc05u5usb16sclqm91iln8lm', '127.0.0.1', '2021-10-13 19:29:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343135333334383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('l3lihobftiof9n23ilh3st8911hfuneq', '127.0.0.1', '2021-10-17 11:39:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437303737333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('l5b2kk5of3vdpksadiir14acpsqcj2ov', '127.0.0.1', '2021-10-26 19:03:29', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353237353030393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('lia6rmu65asoir3dc6qummfpf703kdph', '::1', '2022-05-21 16:03:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333134383936323b5f63695f70726576696f75735f75726c7c733a35393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d707269766163792d706f6c696379223b),
('m33b1vic4ppv55g1g3i3i2m2sdmrcje8', '127.0.0.1', '2021-10-17 12:06:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437323234323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('ma21kspd3rsmfgvai0ofcsb1m9cb8glh', '::1', '2022-03-02 07:10:37', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363230353033373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('mcavmk5nljchdsrik3ngbsj5s3g6n23l', '::1', '2022-09-18 13:10:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530363633353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('mckec5de4f0j3p79a7uqjc73b73vaiem', '::1', '2022-05-02 00:35:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435313733323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('merg70utnqu5r0l5tkisqsm4il725mem', '::1', '2022-05-12 20:59:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323338393136333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f61626f75742d7573223b),
('mgatmlhght89dtroh0h33jterlm2aaev', '127.0.0.1', '2023-02-05 09:05:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353538373931323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('mhnm1cu0hfskmi3kn60rrfsbeip0hnac', '127.0.0.1', '2022-01-31 16:46:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634373631363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('mifshhtmurakaslamp8atjvg69mlkist', '::1', '2022-03-01 20:27:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136363436393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('mot8fvg7q0efeh68irkv9rirm2iip445', '::1', '2022-09-18 14:36:28', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531313738383b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('n2m6emgg9kg7et3cmuqcb3fbno200gn9', '::1', '2022-05-02 00:19:41', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435303738313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('nb0ilum22ae8ieq74bb20g6cs69a9t09', '::1', '2022-05-05 00:07:48', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730393236323b5f63695f70726576696f75735f75726c7c733a39363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f692f2544392538352544382542392544392538342544392538382544392538352544382541372544382541412d254438254239254439253836254438254137223b),
('ne9rgnkor85l4588k45iojt4ec9kmnft', '127.0.0.1', '2022-01-20 10:23:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634323637343138313b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('nfla42oioh31htp60fl2a3g5ea7uvr3u', '::1', '2022-05-21 16:28:31', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333135303531313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ni4mpmk341betpls1jq5t28a0fr9t33b', '127.0.0.1', '2021-10-13 10:49:21', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343132323135323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('nl41diavi6incvq2p1c7f7rtm2jg1he3', '127.0.0.1', '2022-02-03 07:50:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333837343634373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('nqhtt9e8st921k082g5n7isfab4m5uu8', '::1', '2022-03-03 09:56:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363330313430373b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('nr7672lqa461h3ipukiivvag00fo5nnh', '::1', '2022-09-17 19:49:03', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434343134333b5f63695f70726576696f75735f75726c7c733a34363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f6163636f756e742f6c6f67696e223b),
('nt2qmrlnhm6nntm1phfpi4qshu2vlf4g', '::1', '2021-10-25 21:21:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139363839323b5f63695f70726576696f75735f75726c7c733a3131383a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f636f6d6d6f6e2f6c616e67756167652f736176653f636f64653d61722672656469726563743d687474702533412532462532466b696e64657267617274656e2e6c6f63616c686f7374253246617225324667616c6c657279223b),
('o83n3bbph2ord42mil8d313j8sc8q3d2', '::1', '2022-09-17 18:53:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434303738363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('oefrectvfb7q7h6923tklbjtv5565ahl', '127.0.0.1', '2022-01-31 15:42:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634333732393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ohcf86l3488rftoia7rok912gp9in3pj', '::1', '2022-09-16 22:01:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336353638373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('omp6i43hhaeqhcbi0hl2tvj4pncvjjlu', '127.0.0.1', '2021-10-20 16:42:24', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734383134343b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('opqdmegjbipl5mfrphnhsgc4erk1q9n0', '::1', '2022-09-18 15:13:13', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333531333939333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ort2shihb1i5qesh5ji8gg0pf9blvoul', '::1', '2022-05-12 22:10:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339333434363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f636f6e746163742d7573223b),
('os2oob13eql22067sb85fbkj67am35k1', '::1', '2022-05-15 19:12:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634313935393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('p1728hbteoqeoeuf10vd6sl85r2pe1n9', '::1', '2022-03-03 09:56:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363330313430373b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('p556e4tu2uhud63in619e89lo5i6o4ca', '::1', '2022-03-01 07:43:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132303632363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('p9rteerm71r1bftcb440f866r7hv18mg', '::1', '2022-04-01 08:29:39', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383739383237353b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('pbcvabjopbgbin3p7r8ls4iqsre1r7jo', '::1', '2022-02-17 15:25:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353131313332303b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('pd5mfsg39vsc2vifme4nbuk6sgctcc7c', '::1', '2022-03-01 07:57:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132313432303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('pfm3295dkfplf6tm3tmk4pnc4bvqk94j', '::1', '2022-09-18 13:54:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530393238363b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f73702d61626f75742d7573223b),
('pg7v298029ha3iju7btl9d0pt41t7lic', '::1', '2022-05-12 20:53:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323338383831353b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f61626f75742d7573223b),
('ph6mabaqlm4kj6o1dcg959spm921ja2c', '127.0.0.1', '2022-01-29 11:32:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333435353839333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ph9p62m0jaidiaj4a61u6crnp909go00', '::1', '2021-10-25 20:18:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139333132323b5f63695f70726576696f75735f75726c7c733a34303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f70726976616379223b),
('phtn8dlu94bicln93a0i8o98d3bsicsi', '::1', '2022-05-15 20:01:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323634343836303b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f7465726d732d616e642d636f6e646974696f6e73223b),
('pm47sivohp9n277qf6r95hvruor7p165', '::1', '2022-03-01 14:02:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363134333236393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('pn0jt54ibljbfps65pb4vhs4pi7g08ri', '::1', '2022-05-18 20:55:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323930373334363b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d61626f75742d7573223b),
('pu5iog10obe55se1n23s5ncft1huovic', '::1', '2022-04-07 21:56:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393336383537393b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d37266c6f63616c653d656e223b),
('q1hsi2276vglpp66r7sldhke52ln4a73', '127.0.0.1', '2022-01-31 11:18:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373735333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('q4urjvnesbcea0ob5vav3frb2kf7oa1i', '::1', '2022-02-10 07:30:28', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343437383036393b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31223b),
('qip0lebmttvfl6ieuv6efci948982o7j', '127.0.0.1', '2022-01-31 15:33:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634323938303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('qk2p9gc7eemnpnodghqggummqf4ibm6h', '::1', '2022-01-20 10:22:48', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634323637343136383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('qlrm7h7t8oc3rnkkobc1p6h1d0upqbp8', '::1', '2022-05-01 23:23:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434373432323b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d33223b),
('qnrhfb8ps3hvukm5ep4d1lg0i6e3kqir', '::1', '2022-09-17 19:00:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434313234353b5f63695f70726576696f75735f75726c7c733a34343a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f73702d61626f75742d7573223b),
('qovt87vqt9aehvtslf6di0lbdjhg4l85', '127.0.0.1', '2021-10-24 15:18:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353038383730323b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('quo61dhvqmikmliv5hkiqkrcdt4gsvu2', '::1', '2022-05-02 00:42:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313435323132363b5f63695f70726576696f75735f75726c7c733a34303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f636f6e746163742d7573223b),
('r2ls9tt9rv3do2aruqlumvkoo42hhq3k', '::1', '2022-05-22 10:16:21', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635333231343433343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('r7avjnsg4lf24mk6igs7dhdfq7s8ttpo', '::1', '2021-10-25 21:37:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139373633373b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f707269766163792d706f6c696379223b),
('r9g3ddhp1gofpa8j9dptjn3tnvir5dkk', '::1', '2022-02-28 15:30:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363036323231323b),
('ramqjqgaufb080a2128b82chv9hhmgad', '::1', '2022-09-17 20:16:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434353830353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('rbrgum15hh8gp4p9f9qk2vf560dventa', '127.0.0.1', '2021-10-20 16:31:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734373530363b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('rf4412v660vqeabqt7bv8cje3q9727gi', '::1', '2022-02-18 17:50:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353230363633363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('rfm3t1gfouo2sqtib4i62fsv8b9nur56', '::1', '2022-03-01 20:19:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136353939313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('rh212iki107gqa0u8qe5p1krtrf65qbi', '::1', '2022-05-18 20:37:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323930363234323b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f73702d61626f75742d7573223b),
('rkc5mspo0ggtjovjfdrnc2q7j68fo2io', '::1', '2022-03-02 08:56:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363231313338333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('roagggudj31iuagl46p0dnnddddm7h6i', '::1', '2022-03-02 08:04:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363230383238323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('rofvnm802e8lro7939ir4oqq9lgb1iit', '127.0.0.1', '2021-10-13 19:55:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343135343933333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('rpu27bp1ci5jl1eoof3r23592ua2e1hd', '::1', '2021-10-25 20:29:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139333737323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('rub3bi9lp0fiq0vhjb4r24liv6id41qb', '::1', '2022-03-01 20:38:44', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136373132343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('s2o1m2f92jt0mhsj4klv5501ntnao7uu', '::1', '2022-02-18 09:02:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137343935333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('s8ca9h1l9gakptvjuv7cvcn9gfjmi1f4', '::1', '2022-03-02 09:08:04', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363231323038343b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('sc4ceipu9rt4o0jul920pj6dbova9svj', '::1', '2022-09-18 13:18:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530373131323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('sd9o6jpn74knebelvq4m8jio66v9jub1', '::1', '2021-10-25 21:27:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139373232393b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('srde4milve073d0a23atmiri79pdpp29', '::1', '2022-09-17 20:44:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333434373438363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('srmq4btbs8r4o0vh93qtabpvia5cn0kv', '::1', '2022-03-01 20:04:30', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136353037303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ss0pimp3rhuplfhfut2usn7agjvp2ija', '::1', '2022-03-01 08:14:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132323438303b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('st4hp51o9vbg7b42sbsvmusmnhfq8qkp', '::1', '2023-02-04 18:44:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533363132313b5f63695f70726576696f75735f75726c7c733a35323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f73702d7465726d732d636f6e646974696f6e73223b),
('t0fieeqiv6jejlhheuc420c17uu0n6n2', '::1', '2022-05-14 09:27:44', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323532303436343b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f672f63617431223b),
('t3gnlk75hq5fho8q98vitgmjhrbhl194', '::1', '2022-05-04 23:16:26', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313730363138363b5f63695f70726576696f75735f75726c7c733a34363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f6163636f756e742f6c6f67696e223b),
('t45g2fc4rg4587mhcco1klftqs6v7jj4', '127.0.0.1', '2021-10-13 07:06:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343130383831323b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('t4m90js9vlkfqck6g9rndssscieuccpr', '::1', '2022-05-01 23:11:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313434363638373b5f63695f70726576696f75735f75726c7c733a35303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f61626f75742d7573223b),
('tb1j3lrepo1mcte46mbr9ok23ob52khi', '::1', '2022-02-10 10:41:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343438393730353b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('thmjcqodne5vogpq01ahpvbet5rqats6', '::1', '2022-10-14 06:45:50', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636353732393934393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('tkfq914gdn76vl8d3pi3vhm1m61ecto0', '::1', '2022-02-17 11:50:38', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353039383633373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('tv5oajp5des8ijbu7l4ougm1oarkvrai', '127.0.0.1', '2022-01-31 10:57:39', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632363635393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('u3ifpbqscshkhc8atmu7a10819itjmi4', '::1', '2022-09-18 13:57:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333530393437323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('u43do189gfubncnkr5h39bs1dmf9dri5', '::1', '2022-03-01 08:47:44', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363132343436343b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('u570glhi757oqhknao6j73t8um86j01f', '::1', '2022-05-12 21:10:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323338393834323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f61626f75742d7573223b),
('u6hg8afd0e8hek2tuue3flahd1fdpdr5', '127.0.0.1', '2021-10-17 11:13:17', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343436393139353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('uac80q0lvgl6v2dft45nk4dmcrelmeoa', '::1', '2022-05-12 22:38:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323339343931383b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f692f7465616368657273223b),
('uae0b6hldl0p0kviva9jpdjnjhrjs976', '::1', '2022-02-28 09:41:07', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363034313236373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('uc75qbfm9nlpiijsj7aeiq0jmp6kprrb', '127.0.0.1', '2023-02-04 18:12:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353533343333303b),
('uf9at9rtod3or49pget4qbva8cuuvode', '::1', '2022-04-07 23:19:20', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634393337333536303b5f63695f70726576696f75735f75726c7c733a35303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f61626f75742d7573223b),
('uhgtfjm253e0fg4k8o9qml56h4nrm0sd', '::1', '2022-02-18 07:54:04', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353137303834343b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('uivchqj08oqr23kak35097mvcbt6ev5r', '::1', '2022-09-16 22:51:11', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336383637313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ukjv9mltfukjsh77qbsekh5uu0de1ec6', '::1', '2022-03-01 20:50:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363136373830313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('un71atld5jnpmg4f378hseqacbdsn1ki', '::1', '2022-03-03 07:34:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363239323634363b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('up4rd6ngt5rnj2a7pbovqqjcgjkhof56', '127.0.0.1', '2023-02-05 08:43:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353538363539343b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f6163636f756e742f7265676973746572223b),
('utc5r83ffo52jlt5frr4hkmikobbjslp', '::1', '2022-03-03 07:30:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363239323634363b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('uts4ui3tkg74inuuhdtd6induva70hb3', '127.0.0.1', '2023-02-05 08:43:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353538363539343b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f6163636f756e742f7265676973746572223b),
('v2bvs4gahodll46i9m6i89p81rsvnbs8', '::1', '2022-05-06 15:35:20', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635313835313138333b5f63695f70726576696f75735f75726c7c733a39363a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f692f2544392538352544382542392544392538342544392538382544392538352544382541372544382541412d254438254239254439253836254438254137223b),
('vf8u33hsmpmeksd4eddtm2sb4rtogbd6', '::1', '2022-09-16 22:22:29', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336363934393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('vhbhvvbfoovttsqbj4g4t8p7r1774jeb', '::1', '2022-03-01 07:11:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363131383731363b),
('vji35urbf17sjr3efr6s0et2k8mu7h79', '127.0.0.1', '2022-01-31 08:13:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333631363832373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('vpf3mae181n43s3pl2mfvrglc03bb50f', '::1', '2022-05-14 09:32:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313635323532303737333b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636174312f672d33223b),
('vsfcqo4s40gsas4arto2gtpg4g6rume0', '::1', '2022-09-16 22:53:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333336383637313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('vshhiqpfouesn45fi10jfflvoa2aq9o6', '::1', '2022-03-25 08:58:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634383139383732333b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d36266c6f63616c653d656e223b),
('vtrsn2fc258s5jpij9j3sbl8vgotrrcq', '127.0.0.1', '2023-02-05 08:50:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313637353538373034333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b);

-- --------------------------------------------------------

--
-- Table structure for table `ci_setting`
--

CREATE TABLE `ci_setting` (
  `setting_id` int NOT NULL,
  `site_id` int NOT NULL DEFAULT '0',
  `code` varchar(128) NOT NULL,
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_setting`
--

INSERT INTO `ci_setting` (`setting_id`, `site_id`, `code`, `key`, `value`, `serialized`) VALUES
(2209, 0, 'config', 'config_file_mime_allowed', 'text/plain\r\nimage/png\r\nimage/jpeg\r\nimage/gif\r\nimage/bmp\r\nimage/tiff\r\nimage/svg+xml\r\napplication/zip\r\n\"application/zip\"\r\napplication/x-zip\r\n\"application/x-zip\"\r\napplication/x-zip-compressed\r\n\"application/x-zip-compressed\"\r\napplication/rar\r\n\"application/rar\"\r\napplication/x-rar\r\n\"application/x-rar\"\r\napplication/x-rar-compressed\r\n\"application/x-rar-compressed\"\r\napplication/octet-stream\r\n\"application/octet-stream\"\r\naudio/mpeg\r\nvideo/quicktime\r\napplication/pdf', 0),
(1092, 0, 'module_account', 'module_account_status', '1', 0),
(2208, 0, 'config', 'config_file_ext_allowed', 'zip\r\ntxt\r\npng\r\njpe\r\njpeg\r\njpg\r\ngif\r\nbmp\r\nico\r\ntiff\r\ntif\r\nsvg\r\nsvgz\r\nzip\r\nrar\r\nmsi\r\ncab\r\nmp3\r\nmp4\r\nwebm\r\nqt\r\nmov\r\npdf\r\npsd\r\nai\r\neps\r\nps\r\ndoc', 0),
(2207, 0, 'config', 'config_global_alert', '', 0),
(2206, 0, 'config', 'config_maintenance', '0', 0),
(2204, 0, 'config', 'config_chat_widget', '', 0),
(2205, 0, 'config', 'config_social_networks', '[{\"name\":\"Facebook\",\"href\":\"https:\\/\\/www.facebook.com\\/pages\\/#\\/\"},{\"name\":\"Twitter\",\"href\":\"https:\\/\\/www.twitter.com\\/#\\/\"}]', 1),
(2203, 0, 'config', 'config_customer_online', '1', 0),
(2202, 0, 'config', 'config_customer_activity', '1', 0),
(2201, 0, 'config', 'config_login_attempts', '5', 0),
(2200, 0, 'config', 'config_admin_limit', '20', 0),
(2199, 0, 'config', 'config_currency', 'EUR', 0),
(2198, 0, 'config', 'config_admin_language', 'en', 0),
(453, 0, 'module_menu', 'module_menu_status', '1', 0),
(2197, 0, 'config', 'config_language', 'en', 0),
(447, 0, 'report_user_activity', 'report_user_activity', '{\"user_activity\":{\"status\":\"1\",\"sort_order\":\"1\"}}', 1),
(1157, 0, 'theme_basic', 'theme_basic', '{\"basic\":{\"status\":1}}', 1),
(1150, 0, 'dashboard_customer_activity', 'dashboard_customer_activity', '{\"customer_activity\":{\"width\":\"3\",\"status\":\"1\",\"sort_order\":\"1\"}}', 1),
(416, 0, 'blog_category', 'blog_category_status', '1', 0),
(410, 0, 'blog_post', 'blog_post_status', '1', 0),
(411, 0, 'blog_comment', 'blog_comment_status', '1', 0),
(446, 0, 'dashboard_customer_online', 'dashboard_customer_online', '{\"customer_online\":{\"width\":\"6\",\"status\":\"1\",\"sort_order\":\"2\"}}', 1),
(1149, 0, 'analytics_google', 'analytics_google', '{\"code\":\"<script>\\r\\n(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){\\r\\n  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\\r\\n  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\\r\\n  })(window,document,\'script\',\'\\/\\/www.google-analytics.com\\/analytics.js\',\'ga\');\\r\\n \\r\\n  ga(\'create\', \'UA-xxxxxx-1\', \'auto\');\\r\\n  ga(\'send\', \'pageview\');\\r\\n<\\/script>\",\"status\":\"1\"}', 1),
(1158, 0, 'theme_dustrix', 'theme_dustrix', '{\"dustrix\":{\"status\":1}}', 1),
(2196, 0, 'config', 'config_opening_times', '																																																																																																																																																																																																																												Monday: 8:30 am - 6:00 pm																																																																																																																																					\r\nTuesday: 8:30 am - 6:00 pm\r\nWednesday: 8:30 am - 6:00 pm\r\nThursday: 8:30 am - 6:00 pm\r\nFriday: 8:30 am - 6:00 pm\r\nSaturday: Closed\r\nSunday: Closed', 0),
(2195, 0, 'config', 'config_telephone', '000 000 0000', 0),
(2194, 0, 'config', 'config_email', 'email@email.com', 0),
(2193, 0, 'config', 'config_address', '24 St. Address, Country', 0),
(2192, 0, 'config', 'config_owner', 'Jonh Due', 0),
(2191, 0, 'config', 'config_name', 'ACME Limited', 0),
(2190, 0, 'config', 'config_logo', 'catalog/logo.png', 0),
(2185, 0, 'config', 'config_meta_title', 'ACME Limited', 0),
(2186, 0, 'config', 'config_meta_description', 'ACME Limited', 0),
(2187, 0, 'config', 'config_meta_keyword', 'keywords', 0),
(2188, 0, 'config', 'config_theme', 'default', 0),
(2189, 0, 'config', 'config_template_engine', 'twig', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_translation`
--

CREATE TABLE `ci_translation` (
  `translation_id` int NOT NULL,
  `site_id` int NOT NULL,
  `language_id` int NOT NULL,
  `route` varchar(64) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_upload`
--

CREATE TABLE `ci_upload` (
  `upload_id` int NOT NULL,
  `application_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `size` varchar(32) NOT NULL,
  `ext` varchar(32) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_user`
--

CREATE TABLE `ci_user` (
  `user_id` int NOT NULL,
  `user_group_id` tinyint NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_user`
--

INSERT INTO `ci_user` (`user_id`, `user_group_id`, `username`, `firstname`, `lastname`, `email`, `password`, `salt`, `status`, `image`, `code`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 1, 'admin', 'John', 'Duo', 'admin@admin.com', '$2y$10$V8WWHtf9gCRyhmAqM3IAoOu6OYoHqP1CS9sLQnYlsBu6FxVLYN1yi', '3c7dcb236', 1, '', '', 1627927402, 1627927402, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_activity`
--

CREATE TABLE `ci_user_activity` (
  `activity_id` int NOT NULL,
  `user_id` int NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_user_activity`
--

INSERT INTO `ci_user_activity` (`activity_id`, `user_id`, `key`, `data`, `ip`, `user_agent`, `date_added`) VALUES
(9, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 83.0.4254.27\"}', '::1', 'Opera 83.0.4254.27', 1646034397),
(10, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 83.0.4254.27\"}', '::1', 'Opera 83.0.4254.27', 1646061623),
(11, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646119935),
(12, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646143183),
(13, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646163776),
(14, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646205019),
(15, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646206364),
(16, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646292825),
(17, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646292953),
(18, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293002),
(19, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293099),
(20, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293198),
(21, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293212),
(22, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293561),
(23, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293562),
(24, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293574),
(25, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293772),
(26, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293847),
(27, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293938),
(28, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646293977),
(29, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294469),
(30, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294488),
(31, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294550),
(32, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294584),
(33, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294756),
(34, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294788),
(35, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294962),
(36, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294978),
(37, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646294984),
(38, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295038),
(39, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295182),
(40, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295320),
(41, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295405),
(42, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295469),
(43, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295677),
(44, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295734),
(45, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295737),
(46, 1, 'user_login', '{\"user_id\":1,\"username\":\"admin\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646295780),
(47, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646378579),
(48, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1646388938),
(49, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.21\"}', '::1', 'Opera 84.0.4316.21', 1648022505),
(50, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 84.0.4316.42\"}', '::1', 'Opera 84.0.4316.42', 1648573703),
(51, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 85.0.4341.28\"}', '::1', 'Opera 85.0.4341.28', 1648798324),
(52, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 85.0.4341.47\"}', '::1', 'Opera 85.0.4341.47', 1649369404),
(53, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.32\"}', '::1', 'Opera 86.0.4363.32', 1651451456),
(54, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.32\"}', '::1', 'Opera 86.0.4363.32', 1651452290),
(55, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.32\"}', '::1', 'Opera 86.0.4363.32', 1651703810),
(56, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.32\"}', '::1', 'Opera 86.0.4363.32', 1651875154),
(57, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.32\"}', '::1', 'Opera 86.0.4363.32', 1651875491),
(58, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.32\"}', '::1', 'Opera 86.0.4363.32', 1651875604),
(59, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.50\"}', '::1', 'Opera 86.0.4363.50', 1652387072),
(60, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.50\"}', '::1', 'Opera 86.0.4363.50', 1652390105),
(61, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.50\"}', '::1', 'Opera 86.0.4363.50', 1652391726),
(62, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 86.0.4363.59\"}', '::1', 'Opera 86.0.4363.59', 1652643150),
(63, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 87.0.4390.25\"}', '::1', 'Opera 87.0.4390.25', 1653149464),
(64, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 87.0.4390.25\"}', '::1', 'Opera 87.0.4390.25', 1655311792),
(65, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 88.0.4412.53\"}', '::1', 'Opera 88.0.4412.53', 1656533811),
(66, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 90.0.4480.84\"}', '::1', 'Opera 90.0.4480.84', 1663365449),
(67, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 91.0.4516.16\"}', '::1', 'Opera 91.0.4516.16', 1663447620),
(68, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 91.0.4516.16\"}', '::1', 'Opera 91.0.4516.16', 1663510505),
(69, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 91.0.4516.16\"}', '::1', 'Opera 91.0.4516.16', 1663512998),
(70, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"::1\",\"user_agent\":\"Opera 94.0.0.0\"}', '::1', 'Opera 94.0.0.0', 1675528398),
(71, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"127.0.0.1\",\"user_agent\":\"Safari 605.1.15\"}', '127.0.0.1', 'Safari 605.1.15', 1675531537),
(72, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"127.0.0.1\",\"user_agent\":\"Safari 605.1.15\"}', '127.0.0.1', 'Safari 605.1.15', 1675531579),
(73, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"127.0.0.1\",\"user_agent\":\"Safari 605.1.15\"}', '127.0.0.1', 'Safari 605.1.15', 1675534905),
(74, 1, 'user_login', '{\"user_id\":1,\"username\":\"john_duo\",\"ip\":\"127.0.0.1\",\"user_agent\":\"Safari 605.1.15\"}', '127.0.0.1', 'Safari 605.1.15', 1675586609);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_group`
--

CREATE TABLE `ci_user_group` (
  `user_group_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `permission` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_user_group`
--

INSERT INTO `ci_user_group` (`user_group_id`, `name`, `permission`, `date_added`, `date_modified`) VALUES
(2, 'Demonstration', '{\"access\":[\"catalog\\/information\",\"common\\/filemanager\",\"extension\\/dashboard\",\"module\\/carousel\",\"module\\/html\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"user\\/user\"],\"modify\":[\"catalog\\/information\",\"common\\/filemanager\",\"extension\\/dashboard\",\"module\\/carousel\",\"module\\/html\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"user\\/user\"]}', 1627475452, 1627475452),
(1, 'Administrator', '{\"access\":[\"catalog\\/application\",\"catalog\\/category\",\"catalog\\/information\",\"children\\/children\",\"children\\/children_group\",\"children\\/schemes\",\"common\\/filemanager\",\"common\\/profile\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/translation\",\"extension\\/analytics\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/report\",\"extension\\/theme\",\"localisation\\/currency\",\"localisation\\/language\",\"module\\/account\",\"module\\/carousel\",\"module\\/html\",\"module\\/menu\",\"module\\/video\",\"report\\/online\",\"report\\/report\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/analytics\\/google\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/customer_activity\",\"extensions\\/dashboard\\/customer_online\",\"extensions\\/report\\/user_activity\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\"],\"modify\":[\"catalog\\/application\",\"catalog\\/category\",\"catalog\\/information\",\"children\\/children\",\"children\\/children_group\",\"children\\/schemes\",\"common\\/filemanager\",\"common\\/profile\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/translation\",\"extension\\/analytics\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/report\",\"extension\\/theme\",\"localisation\\/currency\",\"localisation\\/language\",\"module\\/account\",\"module\\/carousel\",\"module\\/html\",\"module\\/menu\",\"module\\/video\",\"report\\/online\",\"report\\/report\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/analytics\\/google\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/customer_activity\",\"extensions\\/dashboard\\/customer_online\",\"extensions\\/report\\/user_activity\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\"]}', 1627475452, 1646041399);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_application`
--
ALTER TABLE `ci_application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `ci_application_status`
--
ALTER TABLE `ci_application_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ci_banner`
--
ALTER TABLE `ci_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `ci_banner_image`
--
ALTER TABLE `ci_banner_image`
  ADD PRIMARY KEY (`banner_image_id`);

--
-- Indexes for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ci_blog_comment`
--
ALTER TABLE `ci_blog_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ci_category`
--
ALTER TABLE `ci_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `ci_category_description`
--
ALTER TABLE `ci_category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_children`
--
ALTER TABLE `ci_children`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `ci_children_group`
--
ALTER TABLE `ci_children_group`
  ADD PRIMARY KEY (`child_group_id`);

--
-- Indexes for table `ci_children_scheme`
--
ALTER TABLE `ci_children_scheme`
  ADD PRIMARY KEY (`scheme_id`,`name`) USING BTREE;

--
-- Indexes for table `ci_currency`
--
ALTER TABLE `ci_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `ci_customer`
--
ALTER TABLE `ci_customer`
  ADD UNIQUE KEY `customer_id` (`customer_id`) USING BTREE;

--
-- Indexes for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  ADD PRIMARY KEY (`customer_activity_id`);

--
-- Indexes for table `ci_customer_group`
--
ALTER TABLE `ci_customer_group`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- Indexes for table `ci_customer_ip`
--
ALTER TABLE `ci_customer_ip`
  ADD PRIMARY KEY (`customer_ip_id`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `ci_customer_login`
--
ALTER TABLE `ci_customer_login`
  ADD PRIMARY KEY (`customer_login_id`),
  ADD KEY `email` (`email`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `ci_customer_online`
--
ALTER TABLE `ci_customer_online`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `ci_event`
--
ALTER TABLE `ci_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `ci_extension`
--
ALTER TABLE `ci_extension`
  ADD PRIMARY KEY (`extension_id`);

--
-- Indexes for table `ci_information`
--
ALTER TABLE `ci_information`
  ADD PRIMARY KEY (`information_id`);

--
-- Indexes for table `ci_information_description`
--
ALTER TABLE `ci_information_description`
  ADD PRIMARY KEY (`information_id`,`language_id`) USING BTREE;

--
-- Indexes for table `ci_language`
--
ALTER TABLE `ci_language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `ci_layout`
--
ALTER TABLE `ci_layout`
  ADD PRIMARY KEY (`layout_id`);

--
-- Indexes for table `ci_layout_module`
--
ALTER TABLE `ci_layout_module`
  ADD PRIMARY KEY (`layout_module_id`);

--
-- Indexes for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  ADD PRIMARY KEY (`layout_route_id`);

--
-- Indexes for table `ci_module`
--
ALTER TABLE `ci_module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `ci_routes`
--
ALTER TABLE `ci_routes`
  ADD PRIMARY KEY (`route_id`),
  ADD UNIQUE KEY `query` (`segment`),
  ADD UNIQUE KEY `keyword` (`keyword`) USING BTREE;

--
-- Indexes for table `ci_schemes`
--
ALTER TABLE `ci_schemes`
  ADD PRIMARY KEY (`scheme_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `ci_setting`
--
ALTER TABLE `ci_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `ci_translation`
--
ALTER TABLE `ci_translation`
  ADD PRIMARY KEY (`translation_id`);

--
-- Indexes for table `ci_upload`
--
ALTER TABLE `ci_upload`
  ADD PRIMARY KEY (`upload_id`);

--
-- Indexes for table `ci_user`
--
ALTER TABLE `ci_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_application`
--
ALTER TABLE `ci_application`
  MODIFY `application_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_application_status`
--
ALTER TABLE `ci_application_status`
  MODIFY `status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_banner`
--
ALTER TABLE `ci_banner`
  MODIFY `banner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_banner_image`
--
ALTER TABLE `ci_banner_image`
  MODIFY `banner_image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_blog_comment`
--
ALTER TABLE `ci_blog_comment`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_category`
--
ALTER TABLE `ci_category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_children`
--
ALTER TABLE `ci_children`
  MODIFY `child_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_children_group`
--
ALTER TABLE `ci_children_group`
  MODIFY `child_group_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_children_scheme`
--
ALTER TABLE `ci_children_scheme`
  MODIFY `scheme_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_currency`
--
ALTER TABLE `ci_currency`
  MODIFY `currency_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_customer`
--
ALTER TABLE `ci_customer`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  MODIFY `customer_activity_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_group`
--
ALTER TABLE `ci_customer_group`
  MODIFY `customer_group_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_customer_ip`
--
ALTER TABLE `ci_customer_ip`
  MODIFY `customer_ip_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `ci_customer_login`
--
ALTER TABLE `ci_customer_login`
  MODIFY `customer_login_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_event`
--
ALTER TABLE `ci_event`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_extension`
--
ALTER TABLE `ci_extension`
  MODIFY `extension_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `ci_information`
--
ALTER TABLE `ci_information`
  MODIFY `information_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_language`
--
ALTER TABLE `ci_language`
  MODIFY `language_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_layout`
--
ALTER TABLE `ci_layout`
  MODIFY `layout_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_layout_module`
--
ALTER TABLE `ci_layout_module`
  MODIFY `layout_module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  MODIFY `layout_route_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ci_module`
--
ALTER TABLE `ci_module`
  MODIFY `module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ci_routes`
--
ALTER TABLE `ci_routes`
  MODIFY `route_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_schemes`
--
ALTER TABLE `ci_schemes`
  MODIFY `scheme_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_setting`
--
ALTER TABLE `ci_setting`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2210;

--
-- AUTO_INCREMENT for table `ci_translation`
--
ALTER TABLE `ci_translation`
  MODIFY `translation_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_upload`
--
ALTER TABLE `ci_upload`
  MODIFY `upload_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  MODIFY `activity_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  MODIFY `user_group_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
