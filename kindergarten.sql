-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 16, 2022 at 09:47 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.27

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_application_status`
--

CREATE TABLE `ci_application_status` (
  `status_id` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_children`
--

CREATE TABLE `ci_children` (
  `child_id` int NOT NULL,
  `child_group_id` int NOT NULL,
  `scheme_id` int NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dob` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
  `fraction` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_currency`
--

INSERT INTO `ci_currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `fraction`, `value`, `status`, `date_added`, `date_modified`) VALUES
(1, 'US Dollar', 'USD', '$', '', '2', 1.16076400, 1, 0, 1634279608),
(2, 'Euro', 'EUR', '', '€', '2', 1.00000000, 1, 1631818068, 1634279608),
(3, 'Pound Sterling', 'GBP', '£', '', '2', 0.84832700, 1, 1631818111, 1634279608);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer`
--

CREATE TABLE `ci_customer` (
  `customer_id` int NOT NULL,
  `customer_group_id` int NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `two_step` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(40) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_deleted` int UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_customer`
--

INSERT INTO `ci_customer` (`customer_id`, `customer_group_id`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `ip`, `two_step`, `status`, `code`, `image`, `viewed`, `newsletter`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 0, 'John', 'Duo', 'john_duo', 'admin@admin.com', '', '$2y$10$V8WWHtf9gCRyhmAqM3IAoOu6OYoHqP1CS9sLQnYlsBu6FxVLYN1yi', '127.0.0.1', 0, 1, 'nlcL4ImuVo6sQZxbEzXaTG3YkFd2NjCpKWitfJHM', '', 0, 1, 1630697132, 1630697132, NULL);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_online`
--

CREATE TABLE `ci_customer_online` (
  `customer_online_id` int NOT NULL,
  `ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_id` int NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_event`
--

CREATE TABLE `ci_event` (
  `event_id` int NOT NULL,
  `code` varchar(64) NOT NULL,
  `action` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `trigger` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_information`
--

INSERT INTO `ci_information` (`information_id`, `bottom`, `top`, `sort_order`, `status`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 1, 1, 1, 1, 4294967295, 1635197687, NULL),
(2, 1, 0, 3, 1, 4294967295, 1635197707, NULL),
(3, 1, 0, 2, 1, 4294967295, 1635197701, NULL),
(4, 0, 1, 2, 1, 1632550883, 1635197694, NULL),
(5, 0, 0, 0, 1, 1632576138, 1632576138, NULL);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_information_description`
--

INSERT INTO `ci_information_description` (`information_id`, `language_id`, `title`, `keyword`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 2, 'ما هو ', 'about-us', '<p dir=\"rtl\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ \r\nعشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل \r\nالميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد \r\nماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة \r\nهامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم \r\nإيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني \r\nاكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من\r\n الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus \r\nBonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل \r\nالميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان \r\nله شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum \r\ndolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.  </p><p dir=\"rtl\">للمهتمين\r\n قمنا بوضع نص  لوريم إبسوم القياسي والمُستخدم منذ القرن الخامس عشر في \r\nالأسفل. وتم أيضاً توفير الأقسام 1.10.32 و 1.10.33 من \"حول أقاصي الخير \r\nوالشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) بصيغها \r\nالأصلية، مرفقة بالنسخ الإنكليزية لها والتي قام بترجمتها هـ.راكهام (H. \r\nRackham) في عام 1914. </p>\r\n', 'ما هو ', '', ''),
(3, 1, 'Privacy Policy', 'privacy-policy', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and \r\ntypesetting industry. Lorem Ipsum has been the industry\'s standard dummy\r\n text ever since the 1500s, when an unknown printer took a galley of \r\ntype and scrambled it to make a type specimen book. It has survived not \r\nonly five centuries, but also the leap into electronic typesetting, \r\nremaining essentially unchanged. It was popularised in the 1960s with \r\nthe release of Letraset sheets containing Lorem Ipsum passages, and more\r\n recently with desktop publishing software like Aldus PageMaker \r\nincluding versions of Lorem Ipsum.</p><p><br></p><p>It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using \'Content here, content here\', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for \'lorem ipsum\' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).</p>', 'Privacy Policy', '', ''),
(3, 2, 'سياسة خاصة', 'privacy-policy', '<p dir=\"rtl\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، \r\nبل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما \r\nيجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" \r\n(Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني \r\nفي فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \r\n\"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر \r\nالغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام \r\n1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et\r\n Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا \r\nالكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة\r\n في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit \r\namet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.  </p><p dir=\"rtl\">للمهتمين\r\n قمنا بوضع نص  لوريم إبسوم القياسي والمُستخدم منذ القرن الخامس عشر في \r\nالأسفل. وتم أيضاً توفير الأقسام 1.10.32 و 1.10.33 من \"حول أقاصي الخير \r\nوالشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) بصيغها \r\nالأصلية، مرفقة بالنسخ الإنكليزية لها والتي قام بترجمتها هـ.راكهام (H. \r\nRackham) في عام 1914. </p>', 'سياسة خاصة', '', ''),
(2, 1, 'Terms and Conditions', 'terms-and-conditions', '<p>There are many variations of passages of Lorem Ipsum available, but the \r\nmajority have suffered alteration in some form, by injected humour, or \r\nrandomised words which don\'t look even slightly believable. If you are \r\ngoing to use a passage of Lorem Ipsum, you need to be sure there isn\'t \r\nanything embarrassing hidden in the middle of text. All the Lorem Ipsum \r\ngenerators on the Internet tend to repeat predefined chunks as \r\nnecessary, making this the first true generator on the Internet. It uses\r\n a dictionary of over 200 Latin words, combined with a handful of model \r\nsentence structures, to generate Lorem Ipsum which looks reasonable. The\r\n generated Lorem Ipsum is therefore always free from repetition, \r\ninjected humour, or non-characteristic words etc.</p><p><br></p><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and \r\ntypesetting industry. Lorem Ipsum has been the industry\'s standard dummy\r\n text ever since the 1500s, when an unknown printer took a galley of \r\ntype and scrambled it to make a type specimen book. It has survived not \r\nonly five centuries, but also the leap into electronic typesetting, \r\nremaining essentially unchanged. It was popularised in the 1960s with \r\nthe release of Letraset sheets containing Lorem Ipsum passages, and more\r\n recently with desktop publishing software like Aldus PageMaker \r\nincluding versions of Lorem Ipsum.</p>', 'Terms and Conditions', '', ''),
(2, 2, 'الأحكام والشروط', 'terms-and-conditions', '<p dir=\"rtl\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، \r\nبل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما \r\nيجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" \r\n(Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني \r\nفي فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \r\n\"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر \r\nالغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام \r\n1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et\r\n Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا \r\nالكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة\r\n في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit \r\namet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.  </p><p dir=\"rtl\">للمهتمين\r\n قمنا بوضع نص  لوريم إبسوم القياسي والمُستخدم منذ القرن الخامس عشر في \r\nالأسفل. وتم أيضاً توفير الأقسام 1.10.32 و 1.10.33 من \"حول أقاصي الخير \r\nوالشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) بصيغها \r\nالأصلية، مرفقة بالنسخ الإنكليزية لها والتي قام بترجمتها هـ.راكهام (H. \r\nRackham) في عام 1914. </p>', 'الأحكام والشروط', '', ''),
(4, 2, 'Gallery', 'gallery', '<p>Gallery<br></p>', 'Gallery', '', ''),
(1, 1, 'About Us', 'about-us', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It\r\n has roots in a piece of classical Latin literature from 45 BC, making \r\nit over 2000 years old. Richard McClintock, a Latin professor at \r\nHampden-Sydney College in Virginia, looked up one of the more obscure \r\nLatin words, consectetur, from a Lorem Ipsum passage, and going through \r\nthe cites of the word in classical literature, discovered the \r\nundoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 \r\nof \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by \r\nCicero, written in 45 BC. This book is a treatise on the theory of \r\nethics, very popular during the Renaissance. The first line of Lorem \r\nIpsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section \r\n1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is\r\n reproduced below for those interested. Sections 1.10.32 and 1.10.33 \r\nfrom \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in \r\ntheir exact original form, accompanied by English versions from the 1914\r\n translation by H. Rackham.</p><p><br></p><p>There are many variations of passages of Lorem Ipsum available, but the \r\nmajority have suffered alteration in some form, by injected humour, or \r\nrandomised words which don\'t look even slightly believable. If you are \r\ngoing to use a passage of Lorem Ipsum, you need to be sure there isn\'t \r\nanything embarrassing hidden in the middle of text. All the Lorem Ipsum \r\ngenerators on the Internet tend to repeat predefined chunks as \r\nnecessary, making this the first true generator on the Internet. It uses\r\n a dictionary of over 200 Latin words, combined with a handful of model \r\nsentence structures, to generate Lorem Ipsum which looks reasonable. The\r\n generated Lorem Ipsum is therefore always free from repetition, \r\ninjected humour, or non-characteristic words etc.</p>', 'about us', '', ''),
(4, 1, 'Gallery', 'gallery', '<link type=\"text/css\" rel=\"stylesheet\" href=\"catalog/default/vendor/lightGallery/css/lightgallery-bundle.css\">\r\n<script src=\"catalog/default/vendor/lightGallery/lightgallery.min.js\"></script>\r\n<!-- lightgallery plugins -->\r\n<script src=\"catalog/default/vendor/lightGallery/plugins/thumbnail/lg-thumbnail.umd.js\"></script>\r\n<script src=\"catalog/default/vendor/lightGallery/plugins/zoom/lg-zoom.umd.js\"></script>\r\n<script src=\"catalog/default/vendor/justifiedGallery.min/jquery.justifiedGallery.min.js\"></script>\r\n\r\n<div class=\"container-sm\">\r\n  <div class=\"row justify-content-center\">\r\n    <div class=\"col col-md-10\">\r\n      <div class=\"gallery-container\" id=\"animated-thumbnails-gallery\">\r\n        <a data-lg-size=\"1600-1067\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@tobbes_rd\' >Tobias Rademacher </a></h4><p> Location - <a href=\'https://unsplash.com/s/photos/puezgruppe%2C-wolkenstein-in-gr%C3%B6den%2C-s%C3%BCdtirol%2C-italien\'>Puezgruppe, Wolkenstein in Gröden, Südtirol, Italien</a>layers of blue.</p>\">\r\n          <img alt=\"layers of blue.\" class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2400\" data-pinterest-text=\"Pin it2\" data-tweet-text=\"lightGallery slide  2\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@therawhunter\' >Massimiliano Morosinotto </a></h4><p> Location - <a href=\'https://unsplash.com/s/photos/tre-cime-di-lavaredo%2C-italia\'>Tre Cime di Lavaredo, Italia</a>This is the Way</p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2400\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@thesaboo\' >Sascha Bosshard </a></h4><p> Location - <a href=\'https://unsplash.com/s/photos/pizol%2C-mels%2C-schweiz\'>Pizol, Mels, Schweiz</a></p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2398\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@yusufevli\' >Yusuf Evli </a></h4><p> Foggy Road</p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1067\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@flovayn\' >Jay Mantri</a></h4><p>  Misty shroud over a forest</p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1067\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@flovayn\' >Florian van Duyn</a></h4><p>Location - <a href=\'Bled, Slovenia\'>Bled, Slovenia</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1126\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1477322524744-0eece9e79640?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@juanster\' >Juan Davila</a></h4><p>Location - <a href=\'Bled, Slovenia\'>Bled, Slovenia</a> Wooded lake island </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1477322524744-0eece9e79640?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1063\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@davidmarcu\' >David Marcu</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/ciuca%C8%99-peak%2C-romania\'>Ciucaș Peak, Romania</a> Alone in the unspoilt wilderness </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2400\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1585338447937-7082f8fc763d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@whoisbenjamin\' >whoisbenjamin</a></h4>\r\n                <p>Location - <a href=\'https://unsplash.com/s/photos/ciuca%C8%99-peak%2C-romania\'>Snowdonia National Park, Blaenau Ffestiniog, UK</a> \r\n                A swan on a calm misty lake in the mountains of Snowdonia, North Wales. <a href=\'https://unsplash.com/photos/9V6EkAoTWJM\'>Link</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1585338447937-7082f8fc763d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1144\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1476842384041-a57a4f124e2e?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@aaronburden\' >Aaron Burden</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/grayling%2C-michigan%2C-united-states\'>Grayling, Michigan, United States</a> Colorful trees near a lake. <a href=\'https://unsplash.com/photos/00QWN1J0g48\'>Link</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1476842384041-a57a4f124e2e?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1067\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1465311530779-5241f5a29892?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@kalenemsley\' >Kalen Emsley</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/yukon-territory%2C-canada\'>Yukon Territory, Canada</a> No captions. <a href=\'https://unsplash.com/photos/eHpYD4U5830\'>Link</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1465311530779-5241f5a29892?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1067\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1461301214746-1e109215d6d3?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@kace\' >Kace Rodriguez</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/pfeiffer-beach%2C-united-states\'>Pfeiffer Beach, United States</a> Pfeiffer Beach at Dusk. <a href=\'https://unsplash.com/photos/eHpYD4U5830\'>Link</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1461301214746-1e109215d6d3?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2400\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1610448721566-47369c768e70?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@patwhelen\' >Pat Whelen</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/portsea-vic%2C-australia\'>Portsea VIC, Australia</a> No caption <a href=\'https://unsplash.com/photos/EKLXDQ-dDRg\'>Link</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1610448721566-47369c768e70?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1067\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@derekthomson\' >Derek Thomson</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/mcway-falls%2C-united-states\'>McWay Falls, United States</a> No caption <a href=\'https://unsplash.com/photos/TWoL-QCZubY\'>Link</a> </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2400\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1539678050869-2b97c7c359fd?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@michaljaneck\' >Michal Janek</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/big-sur%2C-united-states\'>Big Sur, United States</a> Coast  </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1539678050869-2b97c7c359fd?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2400\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1446630073557-fca43d580fbe?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@papillon\' >Iris Papillon</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/big-sur%2C-united-states\'>Big Sur, United States</a> Big Sur drive  </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1446630073557-fca43d580fbe?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1065\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1596370743446-6a7ef43a36f9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@piyushh_dubeyy\' >piyush dubey</a></h4><p>Published on August 2, 2020</p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1596370743446-6a7ef43a36f9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-2134\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1464852045489-bccb7d17fe39?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@fynn_it\' >fynn</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/big-sur%2C-united-states\'>Big Sur, United States</a> Wasserauen, Appenzell Innerrhoden, Schweiz  </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1464852045489-bccb7d17fe39?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1060\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1483728642387-6c3bdd6c93e5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@danielleone\' >Daniel Leone</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/poon-hill%2C-ghode-pani%2C-nepal\'>Poon Hill, Ghode Pani, Nepal</a> Taken from the top of Poon Hill before sun rise </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1483728642387-6c3bdd6c93e5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1037\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1510011560141-62c7e8fc7908?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@bboba\' >Boba Jovanovic</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/bay-of-kotor\'>Bay of Kotor</a> Boka kotorska bay </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1510011560141-62c7e8fc7908?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-899\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1586276393635-5ecd8a851acc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@svsdesigns\' >Surendra Vikram Singh</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/lachung%2C-sikkim%2C-india\'>Lachung, Sikkim, India</a> Cloud covered mountain </p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1586276393635-5ecd8a851acc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1600-1067\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1471931452361-f5ff1faa15ad?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2252&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@camadams\' >Cam Adams</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/banff%2C-canada\'>Banff, Canada</a> Lake along jagged mountains</p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1471931452361-f5ff1faa15ad?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n        <a data-lg-size=\"1536-2304\" data-pinterest-text=\"Pin it3\" data-tweet-text=\"lightGallery slide  4\" class=\"gallery-item\" data-src=\"https://images.unsplash.com/photo-1508766206392-8bd5cf550d1c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1536&q=80\" data-sub-html=\"<h4>Photo by - <a href=\'https://unsplash.com/@rea_le\' >Andrea Ledda</a></h4><p>Location - <a href=\'https://unsplash.com/s/photos/lago-goillet%2C-italy\'>Lago Goillet, Italy</a>  Goillet Lake at 2561 meters above Breuil-Cervinia</p>\">\r\n          <img class=\"img-responsive\" src=\"https://images.unsplash.com/photo-1508766206392-8bd5cf550d1c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=240&q=80\">\r\n        </a>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>\r\n\r\n\r\n\r\n<script>\r\njQuery(\"#animated-thumbnails-gallery\")\r\n  .justifiedGallery({\r\n    captions: false,\r\n    lastRow: \"hide\",\r\n    rowHeight: 180,\r\n    margins: 5\r\n  })\r\n  .on(\"jg.complete\", function () {\r\n    window.lightGallery(\r\n      document.getElementById(\"animated-thumbnails-gallery\"),\r\n      {\r\n        autoplayFirstVideo: false,\r\n        pager: false,\r\n        galleryId: \"nature\",\r\n        plugins: [lgZoom, lgThumbnail],\r\n        mobileSettings: {\r\n          controls: false,\r\n          showCloseIcon: false,\r\n          download: false,\r\n          rotate: false\r\n        }\r\n      }\r\n    );\r\n  });\r\n\r\n</script>', 'Gallery', '', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_layout_module`
--

INSERT INTO `ci_layout_module` (`layout_module_id`, `layout_id`, `code`, `position`, `sort_order`) VALUES
(19, 5, 'html.8', 'content_top', 1),
(17, 4, 'account', 'column_right', 1),
(4, 2, 'html.14', 'column_left', 1),
(34, 1, 'html.11', 'content_top', 4),
(32, 1, 'html.10', 'content_top', 2),
(18, 3, 'account', 'column_left', 1),
(33, 1, 'html.12', 'content_top', 3),
(31, 1, 'carousel.1', 'content_top', 1),
(35, 1, 'html.13', 'content_top', 5);

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_route`
--

CREATE TABLE `ci_layout_route` (
  `layout_route_id` int NOT NULL,
  `layout_id` int NOT NULL,
  `site_id` int NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_layout_route`
--

INSERT INTO `ci_layout_route` (`layout_route_id`, `layout_id`, `site_id`, `route`) VALUES
(18, 1, 0, 'Common/Home'),
(7, 4, 0, 'Information/Information'),
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_module`
--

INSERT INTO `ci_module` (`module_id`, `name`, `code`, `setting`) VALUES
(1, 'Home Page SlideShow', 'carousel', '{\"name\":\"Home Page SlideShow\",\"banner_id\":\"1\",\"width\":\"1200\",\"height\":\"450\",\"autoplay\":\"1\",\"dots\":\"1\",\"infinite\":\"1\",\"arrows\":\"0\",\"status\":\"1\"}'),
(2, 'Archives', 'html', '{\"name\":\"Archives\",\"module_description\":{\"title\":\"Archives\",\"description\":\"<div class=\\\"p-4\\\">\\r\\n        <h4 class=\\\"font-italic\\\">Archives<\\/h4>\\r\\n        <ol class=\\\"list-unstyled mb-0\\\">\\r\\n          <li><a href=\\\"#\\\">March 2014<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">February 2014<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">January 2014<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">December 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">November 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">October 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">September 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">August 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">July 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">June 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">May 2013<\\/a><\\/li>\\r\\n          <li><a href=\\\"#\\\">April 2013<\\/a><\\/li>\\r\\n        <\\/ol>\\r\\n      <\\/div>\"},\"status\":\"1\"}'),
(3, 'Home Page Video', 'video', '{\"name\":\"Home Page Video\",\"module_description\":{\"headline\":\"Welcome to Happy Days Cork <br \\/> Your Chidren are Safe With Us!\",\"mp4\":\"catalog\\/video\\/MVI_5540.mp4\",\"webm\":\"\",\"image\":\"catalog\\/video\\/MVI_5540.png\"},\"status\":\"1\"}'),
(4, 'About', 'html', '{\"name\":\"About\",\"module_description\":{\"title\":\"About\",\"description\":\"<div class=\\\"p-4 mb-3 bg-light rounded\\\">\\r\\n        <h4 class=\\\"font-italic\\\">About<\\/h4>\\r\\n        <p class=\\\"mb-0\\\">Saw you downtown singing the Blues. Watch you circle the drain. Why don\'t you let me stop by? Heavy is the head that <em>wears the crown<\\/em>. Yes, we make angels cry, raining down on earth from up above.<\\/p>\\r\\n      <\\/div>\"},\"status\":\"1\"}'),
(5, 'Our Team', 'html', '{\"name\":\"Our Team\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"container\\\">\\r\\n<div class=\\\"card-deck my-3\\\">\\r\\n  <div class=\\\"card\\\">\\r\\n    <img src=\\\"https:\\/\\/i.imgur.com\\/uppKNuF.jpg\\\" class=\\\"card-img-top\\\" alt=\\\"...\\\">\\r\\n    <div class=\\\"card-body\\\">\\r\\n      <h5 class=\\\"card-title\\\">Card title<\\/h5>\\r\\n      <p class=\\\"card-text\\\">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.<\\/p>\\r\\n    <\\/div>\\r\\n  <\\/div>\\r\\n  <div class=\\\"card\\\">\\r\\n    <img src=\\\"https:\\/\\/i.imgur.com\\/HFpxxJz.jpg\\\" class=\\\"card-img-top\\\" alt=\\\"...\\\">\\r\\n    <div class=\\\"card-body\\\">\\r\\n      <h5 class=\\\"card-title\\\">Card title<\\/h5>\\r\\n      <p class=\\\"card-text\\\">This card has supporting text below as a natural lead-in to additional content.<\\/p>\\r\\n    <\\/div>\\r\\n  <\\/div>\\r\\n  <div class=\\\"card\\\">\\r\\n    <img src=\\\"https:\\/\\/i.imgur.com\\/oJmLthK.jpg\\\" class=\\\"card-img-top\\\" alt=\\\"...\\\">\\r\\n    <div class=\\\"card-body\\\">\\r\\n      <h5 class=\\\"card-title\\\">Card title<\\/h5>\\r\\n      <p class=\\\"card-text\\\">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.<\\/p>\\r\\n    <\\/div>\\r\\n  <\\/div>\\r\\n<\\/div>\\r\\n<\\/div>\"},\"status\":\"1\"}'),
(6, 'happy parents say', 'html', '{\"name\":\"happy parents say\",\"module_description\":{\"title\":\"\",\"description\":\"    <section class=\\\"pt-4\\\">\\r\\n                <div class=\\\"sc_parallax\\\" data-parallax=\\\"scroll\\\" data-image-src=\\\"images\\/parallax\\/parallax1.jpg\\\">\\r\\n                    <div class=\\\"sc_parallax_content\\\"> \\r\\n                        <div class=\\\"sc_content container\\\"> \\r\\n                            <div class=\\\"sc_section col-sm-6\\\"> \\r\\n                                <h1 class=\\\"text-white\\\">\\r\\n                                    What our<br>\\r\\n                                    <strong> happy<\\/strong> parents say\\r\\n                                <\\/h1> \\r\\n                                <blockquote class=\\\"sc_quote margin_top_big text-white\\\">\\r\\n                                    <p>Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do.<\\/p>\\r\\n                                 \\r\\n                                <\\/blockquote> \\r\\n                            <\\/div>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n    <\\/section>\"},\"status\":\"1\"}'),
(7, 'products', 'html', '{\"name\":\"products\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"d-md-flex flex-md-equal w-100 my-md-3 pl-md-3\\\">\\r\\n  <div class=\\\"bg-dark mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden\\\">\\r\\n    <div class=\\\"my-3 py-3\\\">\\r\\n      <h2 class=\\\"display-5\\\">Another headline<\\/h2>\\r\\n      <p class=\\\"lead\\\">And an even wittier subheading.<\\/p>\\r\\n    <\\/div>\\r\\n    <div class=\\\"bg-light shadow-sm mx-auto\\\" style=\\\"width: 80%; height: 300px; border-radius: 21px 21px 0 0;\\\"><\\/div>\\r\\n  <\\/div>\\r\\n  <div class=\\\"bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden\\\">\\r\\n    <div class=\\\"my-3 p-3\\\">\\r\\n      <h2 class=\\\"display-5\\\">Another headline<\\/h2>\\r\\n      <p class=\\\"lead\\\">And an even wittier subheading.<\\/p>\\r\\n    <\\/div>\\r\\n    <div class=\\\"bg-dark shadow-sm mx-auto\\\" style=\\\"width: 80%; height: 300px; border-radius: 21px 21px 0 0;\\\"><\\/div>\\r\\n  <\\/div>\\r\\n<\\/div>\\r\\n<div class=\\\"d-md-flex flex-md-equal w-100 my-md-3 pl-md-3\\\">\\r\\n  <div class=\\\"bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden\\\">\\r\\n    <div class=\\\"my-3 p-3\\\">\\r\\n      <h2 class=\\\"display-5\\\">Another headline<\\/h2>\\r\\n      <p class=\\\"lead\\\">And an even wittier subheading.<\\/p>\\r\\n    <\\/div>\\r\\n    <div class=\\\"bg-dark shadow-sm mx-auto\\\" style=\\\"width: 80%; height: 300px; border-radius: 21px 21px 0 0;\\\"><\\/div>\\r\\n  <\\/div>\\r\\n  <div class=\\\"bg-primary mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden\\\">\\r\\n    <div class=\\\"my-3 py-3\\\">\\r\\n      <h2 class=\\\"display-5\\\">Another headline<\\/h2>\\r\\n      <p class=\\\"lead\\\">And an even wittier subheading.<\\/p>\\r\\n    <\\/div>\\r\\n    <div class=\\\"bg-light shadow-sm mx-auto\\\" style=\\\"width: 80%; height: 300px; border-radius: 21px 21px 0 0;\\\"><\\/div>\\r\\n  <\\/div>\\r\\n<\\/div>\"},\"status\":\"1\"}'),
(8, 'Google Maps', 'html', '{\"name\":\"Google Maps\",\"module_description\":{\"title\":\"\",\"description\":\"<iframe src=\\\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d2461.7357022267965!2d-8.4723965843174!3d51.9022871895744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4844900e7520086f%3A0xd77060c23b6081d1!2sHappy%20Days%20Montessori!5e0!3m2!1sen!2sie!4v1630965370582!5m2!1sen!2sie\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"true\\\" loading=\\\"lazy\\\" width=\\\"1437\\\" height=\\\"350\\\"><\\/iframe>\"},\"status\":\"1\"}'),
(9, 'Home Gallary', 'html', '{\"name\":\"Home Gallary\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"container-sm\\\">\\r\\n  <div class=\\\"row justify-content-center\\\">\\r\\n    <div class=\\\"col col-md-10\\\">\\r\\n      <div class=\\\"gallery-container\\\" id=\\\"animated-thumbnails-gallery\\\">\\r\\n        <a data-lg-size=\\\"1600-1067\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@tobbes_rd\' >Tobias Rademacher <\\/a><\\/h4><p> Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/puezgruppe%2C-wolkenstein-in-gr%C3%B6den%2C-s%C3%BCdtirol%2C-italien\'>Puezgruppe, Wolkenstein in Gr\\u00f6den, S\\u00fcdtirol, Italien<\\/a>layers of blue.<\\/p>\\\">\\r\\n          <img alt=\\\"layers of blue.\\\" class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it2\\\" data-tweet-text=\\\"lightGallery slide  2\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@therawhunter\' >Massimiliano Morosinotto <\\/a><\\/h4><p> Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/tre-cime-di-lavaredo%2C-italia\'>Tre Cime di Lavaredo, Italia<\\/a>This is the Way<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1608481337062-4093bf3ed404?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@thesaboo\' >Sascha Bosshard <\\/a><\\/h4><p> Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/pizol%2C-mels%2C-schweiz\'>Pizol, Mels, Schweiz<\\/a><\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1605973029521-8154da591bd7?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2398\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@yusufevli\' >Yusuf Evli <\\/a><\\/h4><p> Foggy Road<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1526281216101-e55f00f0db7a?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@flovayn\' >Jay Mantri<\\/a><\\/h4><p>  Misty shroud over a forest<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1418065460487-3e41a6c84dc5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@flovayn\' >Florian van Duyn<\\/a><\\/h4><p>Location - <a href=\'Bled, Slovenia\'>Bled, Slovenia<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1505820013142-f86a3439c5b2?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1126\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1477322524744-0eece9e79640?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@juanster\' >Juan Davila<\\/a><\\/h4><p>Location - <a href=\'Bled, Slovenia\'>Bled, Slovenia<\\/a> Wooded lake island <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1477322524744-0eece9e79640?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1063\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1469474968028-56623f02e42e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@davidmarcu\' >David Marcu<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/ciuca%C8%99-peak%2C-romania\'>Ciuca\\u0219 Peak, Romania<\\/a> Alone in the unspoilt wilderness <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1469474968028-56623f02e42e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1585338447937-7082f8fc763d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@whoisbenjamin\' >whoisbenjamin<\\/a><\\/h4>\\r\\n                <p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/ciuca%C8%99-peak%2C-romania\'>Snowdonia National Park, Blaenau Ffestiniog, UK<\\/a> \\r\\n                A swan on a calm misty lake in the mountains of Snowdonia, North Wales. <a href=\'https:\\/\\/unsplash.com\\/photos\\/9V6EkAoTWJM\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1585338447937-7082f8fc763d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1144\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1476842384041-a57a4f124e2e?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@aaronburden\' >Aaron Burden<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/grayling%2C-michigan%2C-united-states\'>Grayling, Michigan, United States<\\/a> Colorful trees near a lake. <a href=\'https:\\/\\/unsplash.com\\/photos\\/00QWN1J0g48\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1476842384041-a57a4f124e2e?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1465311530779-5241f5a29892?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@kalenemsley\' >Kalen Emsley<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/yukon-territory%2C-canada\'>Yukon Territory, Canada<\\/a> No captions. <a href=\'https:\\/\\/unsplash.com\\/photos\\/eHpYD4U5830\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1465311530779-5241f5a29892?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1461301214746-1e109215d6d3?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@kace\' >Kace Rodriguez<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/pfeiffer-beach%2C-united-states\'>Pfeiffer Beach, United States<\\/a> Pfeiffer Beach at Dusk. <a href=\'https:\\/\\/unsplash.com\\/photos\\/eHpYD4U5830\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1461301214746-1e109215d6d3?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1610448721566-47369c768e70?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@patwhelen\' >Pat Whelen<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/portsea-vic%2C-australia\'>Portsea VIC, Australia<\\/a> No caption <a href=\'https:\\/\\/unsplash.com\\/photos\\/EKLXDQ-dDRg\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1610448721566-47369c768e70?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510414842594-a61c69b5ae57?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@derekthomson\' >Derek Thomson<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/mcway-falls%2C-united-states\'>McWay Falls, United States<\\/a> No caption <a href=\'https:\\/\\/unsplash.com\\/photos\\/TWoL-QCZubY\'>Link<\\/a> <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510414842594-a61c69b5ae57?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1539678050869-2b97c7c359fd?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@michaljaneck\' >Michal Janek<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/big-sur%2C-united-states\'>Big Sur, United States<\\/a> Coast  <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1539678050869-2b97c7c359fd?ixlib=rb-1.2.1&amp;ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2400\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1446630073557-fca43d580fbe?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@papillon\' >Iris Papillon<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/big-sur%2C-united-states\'>Big Sur, United States<\\/a> Big Sur drive  <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1446630073557-fca43d580fbe?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1065\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1596370743446-6a7ef43a36f9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@piyushh_dubeyy\' >piyush dubey<\\/a><\\/h4><p>Published on August 2, 2020<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1596370743446-6a7ef43a36f9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-2134\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1464852045489-bccb7d17fe39?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@fynn_it\' >fynn<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/big-sur%2C-united-states\'>Big Sur, United States<\\/a> Wasserauen, Appenzell Innerrhoden, Schweiz  <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1464852045489-bccb7d17fe39?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1060\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1483728642387-6c3bdd6c93e5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@danielleone\' >Daniel Leone<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/poon-hill%2C-ghode-pani%2C-nepal\'>Poon Hill, Ghode Pani, Nepal<\\/a> Taken from the top of Poon Hill before sun rise <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1483728642387-6c3bdd6c93e5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1037\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510011560141-62c7e8fc7908?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@bboba\' >Boba Jovanovic<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/bay-of-kotor\'>Bay of Kotor<\\/a> Boka kotorska bay <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1510011560141-62c7e8fc7908?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-899\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1586276393635-5ecd8a851acc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1600&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@svsdesigns\' >Surendra Vikram Singh<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/lachung%2C-sikkim%2C-india\'>Lachung, Sikkim, India<\\/a> Cloud covered mountain <\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1586276393635-5ecd8a851acc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1600-1067\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1471931452361-f5ff1faa15ad?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2252&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@camadams\' >Cam Adams<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/banff%2C-canada\'>Banff, Canada<\\/a> Lake along jagged mountains<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1471931452361-f5ff1faa15ad?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n        <a data-lg-size=\\\"1536-2304\\\" data-pinterest-text=\\\"Pin it3\\\" data-tweet-text=\\\"lightGallery slide  4\\\" class=\\\"gallery-item\\\" data-src=\\\"https:\\/\\/images.unsplash.com\\/photo-1508766206392-8bd5cf550d1c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1536&amp;q=80\\\" data-sub-html=\\\"<h4>Photo by - <a href=\'https:\\/\\/unsplash.com\\/@rea_le\' >Andrea Ledda<\\/a><\\/h4><p>Location - <a href=\'https:\\/\\/unsplash.com\\/s\\/photos\\/lago-goillet%2C-italy\'>Lago Goillet, Italy<\\/a>  Goillet Lake at 2561 meters above Breuil-Cervinia<\\/p>\\\">\\r\\n          <img class=\\\"img-responsive\\\" src=\\\"https:\\/\\/images.unsplash.com\\/photo-1508766206392-8bd5cf550d1c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=240&amp;q=80\\\">\\r\\n        <\\/a>\\r\\n      <\\/div>\\r\\n    <\\/div>\\r\\n  <\\/div>\\r\\n<\\/div>\"},\"status\":\"1\"}'),
(10, 'promo-service', 'html', '{\"name\":\"promo-service\",\"module_description\":{\"title\":\"\",\"description\":\"<section class=\\\"promo-service-box-wrap\\\">\\r\\n        <div class=\\\"container\\\">\\r\\n            <div class=\\\"row no-padding\\\">\\r\\n                <div class=\\\"col-lg-4 col-12\\\">\\r\\n                    <div class=\\\"single-service-box\\\">\\r\\n                        <h3>Electrical Engineering<\\/h3>\\r\\n                        <p>We have experience serving as a clients\\u2019 single point of contact under a design build delivery format.<\\/p>\\r\\n                        <a href=\\\"services-details.html\\\" class=\\\"\\\">Learn More <i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-12\\\">\\r\\n                    <div class=\\\"single-service-box\\\">\\r\\n                        <h3>Industrial Automation<\\/h3>\\r\\n                        <p>We have experience serving as a clients\\u2019 single point of contact under a design build delivery format.<\\/p>\\r\\n                        <a href=\\\"services-details.html\\\" class=\\\"\\\">Learn More <i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-12\\\">\\r\\n                    <div class=\\\"single-service-box\\\">\\r\\n                        <h3>Mechanical Engineering<\\/h3>\\r\\n                        <p>We have experience serving as a clients\\u2019 single point of contact under a design build delivery format.<\\/p>\\r\\n                        <a href=\\\"services-details.html\\\" class=\\\"\\\">Learn More <i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/section>\"},\"status\":\"1\"}'),
(11, 'about-us-wrapper', 'html', '{\"name\":\"about-us-wrapper\",\"module_description\":{\"title\":\"\",\"description\":\"<section class=\\\"about-us-wrapper about-shape section-padding\\\">\\r\\n        <div class=\\\"container\\\">\\r\\n            <div class=\\\"row align-items-center\\\">\\r\\n                <div class=\\\"col-lg-5 pr-lg-0 col-12\\\">\\r\\n                    <div class=\\\"about-featured-carousel owl-theme owl-carousel\\\">\\r\\n                        <div class=\\\"single-about-img bg-cover\\\" style=\\\"background-image: url(\'assets\\/img\\/home4\\/ab1.jpg\')\\\"><\\/div>\\r\\n                        <div class=\\\"single-about-img bg-cover\\\" style=\\\"background-image: url(\'assets\\/img\\/home4\\/ab2.jpg\')\\\"><\\/div>\\r\\n                        <div class=\\\"single-about-img bg-cover\\\" style=\\\"background-image: url(\'assets\\/img\\/subscribe_left_bg.jpg\')\\\"><\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-6 offset-lg-1 pl-lg-0 col-12\\\">\\r\\n                    <div class=\\\"block-contents p-0 mt-5 mt-lg-0\\\">\\r\\n                        <h1>Dustrix manufactures high-quality products<\\/h1>\\r\\n                        <h4>We\\u2019re a company leader in manufacturing, exporting, international trading and local supplying services of various commodities.<\\/h4>\\r\\n                        <ul>\\r\\n                            <li>Our goal is manufacture good quality products.<\\/li>\\r\\n                            <li>Review functions of equipments and tools.<\\/li>\\r\\n                            <li>Innovative manufacturing methods.<\\/li>\\r\\n                            <li>A solid experience in iron and steel plants.<\\/li>\\r\\n                        <\\/ul>\\r\\n                        <a href=\\\"contact.html\\\" class=\\\"theme-btn\\\">Get In Touch <i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/section>\\r\\n\"},\"status\":\"1\"}'),
(12, 'services-wrapper', 'html', '{\"name\":\"services-wrapper\",\"module_description\":{\"title\":\"\",\"description\":\"<section class=\\\"services-wrapper section-bg section-padding\\\">\\r\\n        <div class=\\\"container\\\">\\r\\n            <div class=\\\"row\\\">\\r\\n                <div class=\\\"col-12 col-lg-12 mb-20\\\">\\r\\n                    <div class=\\\"section-title text-center\\\">\\r\\n                        <span>Services<\\/span>\\r\\n                        <p>What we do<\\/p>\\r\\n                        <h1>We specialize in the areas<\\/h1>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n\\r\\n            <div class=\\\"row\\\">\\r\\n                <div class=\\\"col-lg-4 col-md-6 col-12\\\">\\r\\n                    <div class=\\\"single-service-icon-box\\\">\\r\\n                        <div class=\\\"icon\\\">\\r\\n                            <i class=\\\"fal fa-user-hard-hat\\\"><\\/i>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"contents\\\">\\r\\n                            <h3>Engineering<\\/h3>\\r\\n                            <p>Construction is a general term meaning the art and science to form objects systems organizations<\\/p>\\r\\n                            <a href=\\\"services-details.html\\\">learn more<i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-md-6 col-12\\\">\\r\\n                    <div class=\\\"single-service-icon-box\\\">\\r\\n                        <div class=\\\"icon\\\">\\r\\n                            <i class=\\\"fal fa-charging-station\\\"><\\/i>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"contents\\\">\\r\\n                            <h3>Power &amp; Energy<\\/h3>\\r\\n                            <p>Construction is a general term meaning the art and science to form objects systems organizations<\\/p>\\r\\n                            <a href=\\\"services-details.html\\\">learn more<i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-md-6 col-12\\\">\\r\\n                    <div class=\\\"single-service-icon-box\\\">\\r\\n                        <div class=\\\"icon\\\">\\r\\n                            <i class=\\\"far fa-tint\\\"><\\/i>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"contents\\\">\\r\\n                            <h3>Oil &amp; Gas<\\/h3>\\r\\n                            <p>Construction is a general term meaning the art and science to form objects systems organizations<\\/p>\\r\\n                            <a href=\\\"services-details.html\\\">learn more<i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-md-6 col-12\\\">\\r\\n                    <div class=\\\"single-service-icon-box\\\">\\r\\n                        <div class=\\\"icon\\\">\\r\\n                            <i class=\\\"fal fa-building\\\"><\\/i>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"contents\\\">\\r\\n                            <h3>Industrial<\\/h3>\\r\\n                            <p>Construction is a general term meaning the art and science to form objects systems organizations<\\/p>\\r\\n                            <a href=\\\"services-details.html\\\">learn more<i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-md-6 col-12\\\">\\r\\n                    <div class=\\\"single-service-icon-box\\\">\\r\\n                        <div class=\\\"icon\\\">\\r\\n                            <i class=\\\"far fa-car\\\"><\\/i>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"contents\\\">\\r\\n                            <h3>Automotive<\\/h3>\\r\\n                            <p>Construction is a general term meaning the art and science to form objects systems organizations<\\/p>\\r\\n                            <a href=\\\"services-details.html\\\">learn more<i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-lg-4 col-md-6 col-12\\\">\\r\\n                    <div class=\\\"single-service-icon-box\\\">\\r\\n                        <div class=\\\"icon\\\">\\r\\n                            <i class=\\\"fal fa-hard-hat\\\"><\\/i>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"contents\\\">\\r\\n                            <h3>Construction<\\/h3>\\r\\n                            <p>Construction is a general term meaning the art and science to form objects systems organizations<\\/p>\\r\\n                            <a href=\\\"services-details.html\\\">learn more<i class=\\\"fal fa-long-arrow-right\\\"><\\/i><\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/section>\\r\\n\"},\"status\":\"1\"}'),
(13, 'funfact-wrapper', 'html', '{\"name\":\"funfact-wrapper\",\"module_description\":{\"title\":\"\",\"description\":\"<section class=\\\"funfact-wrapper text-white\\\">\\r\\n        <div class=\\\"container\\\">\\r\\n            <div class=\\\"funfact-content-grid bg-cover bg-center\\\" style=\\\"background-image: url(\'assets\\/img\\/home4\\/cta-bg.png\')\\\">\\r\\n                <div class=\\\"single-funfact-item\\\">\\r\\n                    <div class=\\\"icon\\\">\\r\\n                        <i class=\\\"fal fa-gem\\\"><\\/i>\\r\\n                    <\\/div>\\r\\n                    <h3>368<\\/h3>\\r\\n                    <p>Project Completed<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"single-funfact-item\\\">\\r\\n                    <div class=\\\"icon\\\">\\r\\n                        <i class=\\\"fal fa-drafting-compass\\\"><\\/i>\\r\\n                    <\\/div>\\r\\n                    <h3>785<\\/h3>\\r\\n                    <p>Expert Consultants<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"single-funfact-item\\\">\\r\\n                    <div class=\\\"icon\\\">\\r\\n                        <i class=\\\"fal fa-stars\\\"><\\/i>\\r\\n                    <\\/div>\\r\\n                    <h3>896<\\/h3>\\r\\n                    <p>5 Stars Rating<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"single-funfact-item\\\">\\r\\n                    <div class=\\\"icon\\\">\\r\\n                        <i class=\\\"fal fa-trophy-alt\\\"><\\/i>\\r\\n                    <\\/div>\\r\\n                    <h3>125<\\/h3>\\r\\n                    <p>Awards Winning<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/section> \\r\\n\\r\\n    <section class=\\\"analytis-wrapper section-padding\\\">\\r\\n        <div class=\\\"container\\\">\\r\\n            <div class=\\\"row align-center\\\">\\r\\n                <div class=\\\"col-xl-6 col-12\\\">\\r\\n                    <div class=\\\"block-contents\\\">\\r\\n                        <span>Business Analytics<\\/span>\\r\\n                        <h2>Solutions to the challenges of the evolving and industry<\\/h2>\\r\\n                        <h4>Capitalise on low hanging fruit to identify a ballpark value added activity to beta test.<\\/h4>\\r\\n                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<\\/p>\\r\\n                    <\\/div>\\r\\n                    <div class=\\\"user-data mr-lg-5 d-flex align-items-center\\\">\\r\\n                        <div class=\\\"user-img bg-cover\\\" style=\\\"background-image: url(\'assets\\/img\\/blog\\/author2.jpg\')\\\"><\\/div>\\r\\n                        <div class=\\\"user-info\\\">\\r\\n                            <h5>Miranda H.<\\/h5>\\r\\n                            <span>Founder<\\/span>\\r\\n                        <\\/div>\\r\\n                        <div class=\\\"phone-info\\\">\\r\\n                            <a href=\\\"#\\\">963. 369. 265. 56<\\/a>\\r\\n                            <span>Make An Call<\\/span>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-xl-6 col-12 mt-5 mt-xl-0\\\">\\r\\n                    <div class=\\\"chart-wrapper ml-xl-3\\\">\\r\\n                        <img src=\\\"assets\\/img\\/chart.png\\\" alt=\\\"\\\">\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/section>\"},\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `ci_routes`
--

CREATE TABLE `ci_routes` (
  `route_id` int NOT NULL,
  `site_id` int NOT NULL,
  `language_id` int NOT NULL,
  `keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `segment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0rjac04g98s6b8kmf1ra8d1pk7ke55r2', '127.0.0.1', '2021-10-15 10:40:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343239343336313b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d33223b),
('2ajna4uhb4o4oce9dq485bpjvakafp91', '127.0.0.1', '2022-01-31 16:38:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634373132363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2elbelk51iu6g0fqqo9up7sme2b7qr4p', '::1', '2022-02-16 09:10:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353030323539303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('2gfiru5jq60q8frulouhl8v9ak6sbumn', '::1', '2022-02-14 09:51:21', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343833323237343b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('31p010i5dk0rf7cfcd1b956du2ltj9ek', '127.0.0.1', '2022-02-07 07:38:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343231393432383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('34eauvn3uu9cq0cfdsgf24g4saqvge83', '::1', '2021-12-21 18:35:18', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634303131313437363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('395k9rchj43k2rmikuqp633jlrfioorm', '127.0.0.1', '2022-01-31 18:45:05', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635343730353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('3k79p8lpb5p7cmdnmrvnimen1seavu53', '127.0.0.1', '2021-10-21 06:55:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343739393334323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('48igokp0mua9k086g4bp25fomocujb9p', '127.0.0.1', '2021-10-18 07:34:19', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343534323435383b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('4at1gt6m58fgs47hqn4igesr42r9ogvq', '127.0.0.1', '2022-02-07 08:11:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343232313337383b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('5bbejnp3evr4a1b2oiu4o0s952u1r49k', '127.0.0.1', '2022-01-31 11:09:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373337363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('5mouue040dlg1cgd4477ft9jdsc3g6ed', '127.0.0.1', '2022-02-07 08:09:38', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343232313337383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('5pp9sjuf5f8lcatmm7149fi7eioaojqn', '127.0.0.1', '2021-10-17 11:18:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343436393532303b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('6dg4umpu5bq6b78t81b0hjrelf5u9pgf', '127.0.0.1', '2022-01-07 16:56:04', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634313537343536333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('6qfsped0ssuuo5usu1hbo56jn0jrndv7', '127.0.0.1', '2021-10-17 11:44:36', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437313037363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('6rr1hqluu3v3slk7supesk0irescd447', '::1', '2021-10-25 20:13:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139323738303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('7t2fv8hvg6gnm598bq2qgcc6am9opifq', '127.0.0.1', '2021-10-09 16:56:54', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633333739383439363b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('83r07jkrp3sc1krbf9bsk1q8am8fo6ha', '127.0.0.1', '2021-10-17 12:04:02', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437323234323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('86l35um13uurvo3pe8cfseej42c1fbom', '::1', '2021-10-25 20:34:41', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139343038313b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('87ck3i7rk8fgfpvgkohj6k0b5fu7uddr', '127.0.0.1', '2021-10-15 06:32:55', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343237393431313b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d33223b),
('8f7ij1r97da6no81bf2vkk1avmm43ce8', '127.0.0.1', '2021-10-28 06:59:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353430343338353b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f61626f75742d7573223b),
('8uepgq4916r8bshg6uou56vplfegpuk3', '127.0.0.1', '2022-01-31 10:52:03', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632363332333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9pqbno4t79ts1cto1njbla84k65aiekd', '127.0.0.1', '2022-01-29 11:31:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333435353839323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('9v1sir7kq7qq3i6bh0st0bhpkg2lgjo8', '127.0.0.1', '2022-01-31 19:18:59', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635363733383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('a3ba2sfpnunfur6i5lrijhnjejeimthr', '127.0.0.1', '2021-10-13 19:55:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343135343933333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('aq3sask1ne75j5q8g7ong2tmjqflb6k4', '127.0.0.1', '2021-11-06 18:12:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633363232323336353b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f61626f75742d7573223b),
('b05h1mjk1p5sc6i2dekgg77vffc81i4s', '127.0.0.1', '2021-10-20 16:36:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734373831313b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('b1hc47qmt2i393r6u2920ic1g586kk4l', '127.0.0.1', '2022-01-31 18:35:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635343135363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('bgjq8lg63l3ed6ss5058lj0mvhd3cfge', '127.0.0.1', '2021-10-24 22:03:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353131323739363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('bm3t1iahi98rp3u20vsbssl9572h8cge', '127.0.0.1', '2021-10-17 11:34:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437303434383b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f666f72676f7474656e223b),
('cbtf33a665enagkhu6edo0tpan7q2rvk', '127.0.0.1', '2022-01-31 11:04:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373036323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('dej9nummp4nekh3p2oblq67j60etvac8', '127.0.0.1', '2021-10-12 09:36:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343033313336303b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('dkhbluf7mn72d9rub7a8cl1jibcir374', '127.0.0.1', '2022-01-31 11:15:53', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373735333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('dpajllsjpc5i36p4kpt4jvqh998smkmh', '127.0.0.1', '2021-10-12 08:51:11', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343032383637313b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('drfthlqfu4727j99se8hs5k5b2h0800v', '127.0.0.1', '2022-01-31 15:56:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634343536313b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ebqa1jl1v7rnh3bal8se0pn9m0tdo3m2', '::1', '2021-10-25 20:40:06', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139343430363b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f637573746f6d65722f6c6f67696e223b),
('egropt6uur99uolcd12ttpcckdgma8sc', '127.0.0.1', '2021-10-15 06:29:43', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343237393338323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('elekdmuqbhhh35snglpj5s41tr38h31d', '127.0.0.1', '2021-10-20 16:26:23', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734373138333b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('eqoctkmkvqo45so6cubt8jidtr66kcer', '127.0.0.1', '2022-01-31 16:54:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634383034303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('f12mm3r8sfjbtgdv26tfu3idk0g3tosp', '127.0.0.1', '2021-10-13 06:57:48', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343130383236363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('f1rr26ccqdarr0ti3820f9tnlg9ueu59', '::1', '2021-10-27 07:09:44', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353331383538313b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f707269766163792d706f6c696379223b),
('f905jq5s54c8uhiudsjqmc4r0mq7q2qj', '127.0.0.1', '2021-10-26 19:03:10', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353237343938383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('fjb4pdp5rsojd54gep0l4i1l71fng2up', '127.0.0.1', '2022-01-31 19:18:58', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333635363733383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('gspdjb3b5hvqdlcbuicd1t32f5lm63pc', '127.0.0.1', '2021-10-20 16:43:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734383134343b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('hau49ks22hq4fa1g1q7oebafgidqmmkt', '127.0.0.1', '2021-10-20 16:18:34', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734363731343b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('hs5a3mkhtaldq85f7dg1kjiafdppkiav', '127.0.0.1', '2022-01-31 08:19:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333631363832373b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('i6oifmmeg1lhd926629fi46l3t1t42g7', '127.0.0.1', '2021-10-21 06:56:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343739393337363b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('jmi4ooba8dsgsrp3hs3oc5bqla05cps9', '127.0.0.1', '2021-10-20 16:13:12', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734363339323b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('jnvh8clja1g8vfs91mp68bj5t5lvb34f', '127.0.0.1', '2022-01-31 15:49:35', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634343137353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('jpfvl6gj9g31r0cl0afciqk9lou6veka', '::1', '2021-12-21 18:31:16', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634303131313437363b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('jtcq9fm5kmsgt2fm9vi556d43iu7fsl6', '::1', '2021-10-25 21:33:57', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139373633373b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('k098dstt0nmth73ia0nlplsc7obo7rd2', '127.0.0.1', '2022-02-04 17:58:27', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333939373530363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('k84jedj88rhtgqt9qpkmj2p47b7maa2n', '127.0.0.1', '2022-02-02 07:38:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333738373437383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('kjc769plnshsj8o3sdr7u7ohsmicrk3f', '127.0.0.1', '2021-10-27 13:54:49', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353334323733333b5f63695f70726576696f75735f75726c7c733a34313a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f61626f75742d7573223b),
('klkif5nvov81ic1apo2iqsr9cm7d671n', '127.0.0.1', '2021-10-12 09:36:00', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343033313336303b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('krjvr7vrgc05u5usb16sclqm91iln8lm', '127.0.0.1', '2021-10-13 19:29:08', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343135333334383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('l3lihobftiof9n23ilh3st8911hfuneq', '127.0.0.1', '2021-10-17 11:39:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437303737333b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('l5b2kk5of3vdpksadiir14acpsqcj2ov', '127.0.0.1', '2021-10-26 19:03:29', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353237353030393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('m33b1vic4ppv55g1g3i3i2m2sdmrcje8', '127.0.0.1', '2021-10-17 12:06:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343437323234323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('mhnm1cu0hfskmi3kn60rrfsbeip0hnac', '127.0.0.1', '2022-01-31 16:46:56', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634373631363b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ne9rgnkor85l4588k45iojt4ec9kmnft', '127.0.0.1', '2022-01-20 10:23:01', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634323637343138313b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('ni4mpmk341betpls1jq5t28a0fr9t33b', '127.0.0.1', '2021-10-13 10:49:21', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343132323135323b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('nl41diavi6incvq2p1c7f7rtm2jg1he3', '127.0.0.1', '2022-02-03 07:50:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333837343634373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('nt2qmrlnhm6nntm1phfpi4qshu2vlf4g', '::1', '2021-10-25 21:21:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139363839323b5f63695f70726576696f75735f75726c7c733a3131383a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f636f6d6d6f6e2f6c616e67756167652f736176653f636f64653d61722672656469726563743d687474702533412532462532466b696e64657267617274656e2e6c6f63616c686f7374253246617225324667616c6c657279223b),
('oefrectvfb7q7h6923tklbjtv5565ahl', '127.0.0.1', '2022-01-31 15:42:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634333732393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('omp6i43hhaeqhcbi0hl2tvj4pncvjjlu', '127.0.0.1', '2021-10-20 16:42:24', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734383134343b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f6c6f67696e223b),
('ph6mabaqlm4kj6o1dcg959spm921ja2c', '127.0.0.1', '2022-01-29 11:32:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333435353839333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('ph9p62m0jaidiaj4a61u6crnp909go00', '::1', '2021-10-25 20:18:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139333132323b5f63695f70726576696f75735f75726c7c733a34303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f70726976616379223b),
('q1hsi2276vglpp66r7sldhke52ln4a73', '127.0.0.1', '2022-01-31 11:18:51', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632373735333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('q4urjvnesbcea0ob5vav3frb2kf7oa1i', '::1', '2022-02-10 07:30:28', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343437383036393b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31223b),
('qip0lebmttvfl6ieuv6efci948982o7j', '127.0.0.1', '2022-01-31 15:33:40', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333634323938303b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('qk2p9gc7eemnpnodghqggummqf4ibm6h', '::1', '2022-01-20 10:22:48', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634323637343136383b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('qovt87vqt9aehvtslf6di0lbdjhg4l85', '127.0.0.1', '2021-10-24 15:18:22', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353038383730323b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('r7avjnsg4lf24mk6igs7dhdfq7s8ttpo', '::1', '2021-10-25 21:37:14', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139373633373b5f63695f70726576696f75735f75726c7c733a34373a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f707269766163792d706f6c696379223b),
('rbrgum15hh8gp4p9f9qk2vf560dventa', '127.0.0.1', '2021-10-20 16:31:46', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343734373530363b5f63695f70726576696f75735f75726c7c733a37323a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f6163636f756e742f72656769737465723f656d61696c3d2670617373776f72643d26636f6e6669726d3d223b),
('rofvnm802e8lro7939ir4oqq9lgb1iit', '127.0.0.1', '2021-10-13 19:55:33', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343135343933333b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('rpu27bp1ci5jl1eoof3r23592ua2e1hd', '::1', '2021-10-25 20:29:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139333737323b5f63695f70726576696f75735f75726c7c733a34333a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f656e2f636f6e746163742d7573223b),
('sd9o6jpn74knebelvq4m8jio66v9jub1', '::1', '2021-10-25 21:27:09', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353139373232393b5f63695f70726576696f75735f75726c7c733a35353a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f61722f637573746f6d65722f6163636f756e742f6c6f67696e223b),
('t45g2fc4rg4587mhcco1klftqs6v7jj4', '127.0.0.1', '2021-10-13 07:06:52', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343130383831323b5f63695f70726576696f75735f75726c7c733a34393a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f636f6e74616374223b),
('tb1j3lrepo1mcte46mbr9ok23ob52khi', '::1', '2022-02-10 10:41:45', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343438393730353b5f63695f70726576696f75735f75726c7c733a38303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f696e666f726d6174696f6e2f696e666f726d6174696f6e3f696e666f726d6174696f6e5f69643d31266c6f63616c653d656e223b),
('tv5oajp5des8ijbu7l4ougm1oarkvrai', '127.0.0.1', '2022-01-31 10:57:39', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333632363635393b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('u6hg8afd0e8hek2tuue3flahd1fdpdr5', '127.0.0.1', '2021-10-17 11:13:17', 0x5f5f63695f6c6173745f726567656e65726174657c693a313633343436393139353b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b),
('vji35urbf17sjr3efr6s0et2k8mu7h79', '127.0.0.1', '2022-01-31 08:13:47', 0x5f5f63695f6c6173745f726567656e65726174657c693a313634333631363832373b5f63695f70726576696f75735f75726c7c733a33303a22687474703a2f2f6b696e64657267617274656e2e6c6f63616c686f73742f223b);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_setting`
--

INSERT INTO `ci_setting` (`setting_id`, `site_id`, `code`, `key`, `value`, `serialized`) VALUES
(1092, 0, 'module_account', 'module_account_status', '1', 0),
(1354, 0, 'config', 'config_social_networks', '[{\"name\":\"Facebook\",\"href\":\"https:\\/\\/www.facebook.com\\/pages\\/#\\/\"},{\"name\":\"Twitter\",\"href\":\"https:\\/\\/www.twitter.com\\/#\\/\"}]', 1),
(1357, 0, 'config', 'config_file_ext_allowed', 'zip\r\ntxt\r\npng\r\njpe\r\njpeg\r\njpg\r\ngif\r\nbmp\r\nico\r\ntiff\r\ntif\r\nsvg\r\nsvgz\r\nzip\r\nrar\r\nmsi\r\ncab\r\nmp3\r\nmp4\r\nwebm\r\nqt\r\nmov\r\npdf\r\npsd\r\nai\r\neps\r\nps\r\ndoc', 0),
(1358, 0, 'config', 'config_file_mime_allowed', 'text/plain\r\nimage/png\r\nimage/jpeg\r\nimage/gif\r\nimage/bmp\r\nimage/tiff\r\nimage/svg+xml\r\napplication/zip\r\n\"application/zip\"\r\napplication/x-zip\r\n\"application/x-zip\"\r\napplication/x-zip-compressed\r\n\"application/x-zip-compressed\"\r\napplication/rar\r\n\"application/rar\"\r\napplication/x-rar\r\n\"application/x-rar\"\r\napplication/x-rar-compressed\r\n\"application/x-rar-compressed\"\r\napplication/octet-stream\r\n\"application/octet-stream\"\r\naudio/mpeg\r\nvideo/quicktime\r\napplication/pdf', 0),
(1356, 0, 'config', 'config_global_alert', '', 0),
(1355, 0, 'config', 'config_maintenance', '0', 0),
(1353, 0, 'config', 'config_chat_widget', '', 0),
(1345, 0, 'config', 'config_opening_times', '																				', 0),
(453, 0, 'module_menu', 'module_menu_status', '1', 0),
(1352, 0, 'config', 'config_customer_online', '1', 0),
(1351, 0, 'config', 'config_customer_activity', '1', 0),
(1350, 0, 'config', 'config_login_attempts', '5', 0),
(1349, 0, 'config', 'config_admin_limit', '20', 0),
(1348, 0, 'config', 'config_currency', 'EUR', 0),
(1347, 0, 'config', 'config_admin_language', 'en', 0),
(447, 0, 'report_user_activity', 'report_user_activity', '{\"user_activity\":{\"status\":\"1\",\"sort_order\":\"1\"}}', 1),
(1346, 0, 'config', 'config_language', 'en', 0),
(1157, 0, 'theme_basic', 'theme_basic', '{\"basic\":{\"status\":1}}', 1),
(1150, 0, 'dashboard_customer_activity', 'dashboard_customer_activity', '{\"customer_activity\":{\"width\":\"3\",\"status\":\"1\",\"sort_order\":\"1\"}}', 1),
(416, 0, 'blog_category', 'blog_category_status', '1', 0),
(410, 0, 'blog_post', 'blog_post_status', '1', 0),
(411, 0, 'blog_comment', 'blog_comment_status', '1', 0),
(446, 0, 'dashboard_customer_online', 'dashboard_customer_online', '{\"customer_online\":{\"width\":\"6\",\"status\":\"1\",\"sort_order\":\"2\"}}', 1),
(1344, 0, 'config', 'config_telephone', '000 000 0000', 0),
(1343, 0, 'config', 'config_email', 'email@email.com', 0),
(1149, 0, 'analytics_google', 'analytics_google', '{\"code\":\"<script>\\r\\n(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){\\r\\n  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\\r\\n  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\\r\\n  })(window,document,\'script\',\'\\/\\/www.google-analytics.com\\/analytics.js\',\'ga\');\\r\\n \\r\\n  ga(\'create\', \'UA-xxxxxx-1\', \'auto\');\\r\\n  ga(\'send\', \'pageview\');\\r\\n<\\/script>\",\"status\":\"1\"}', 1),
(1158, 0, 'theme_dustrix', 'theme_dustrix', '{\"dustrix\":{\"status\":1}}', 1),
(1342, 0, 'config', 'config_address', '24 St. Address,, Country', 0),
(1341, 0, 'config', 'config_owner', 'Jonh Due', 0),
(1339, 0, 'config', 'config_logo', 'catalog/logo.png', 0),
(1340, 0, 'config', 'config_name', 'ACME Limited', 0),
(1338, 0, 'config', 'config_template_engine', 'twig', 0),
(1337, 0, 'config', 'config_theme', 'default', 0),
(1336, 0, 'config', 'config_meta_keyword', 'keywords', 0),
(1335, 0, 'config', 'config_meta_description', 'ACME Limited', 0),
(1334, 0, 'config', 'config_meta_title', 'ACME Limited', 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8_general_ci;

--
-- Dumping data for table `ci_user_group`
--

INSERT INTO `ci_user_group` (`user_group_id`, `name`, `permission`, `date_added`, `date_modified`) VALUES
(2, 'Demonstration', '{\"access\":[\"catalog\\/information\",\"common\\/filemanager\",\"extension\\/dashboard\",\"module\\/carousel\",\"module\\/html\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"user\\/user\"],\"modify\":[\"catalog\\/information\",\"common\\/filemanager\",\"extension\\/dashboard\",\"module\\/carousel\",\"module\\/html\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"user\\/user\"]}', 1627475452, 1627475452),
(1, 'Administrator', '{\"access\":[\"catalog\\/application\",\"catalog\\/category\",\"catalog\\/information\",\"children\\/children\",\"children\\/children_group\",\"children\\/schemes\",\"common\\/filemanager\",\"common\\/profile\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/translation\",\"extension\\/analytics\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/report\",\"extension\\/theme\",\"localisation\\/currency\",\"localisation\\/language\",\"module\\/account\",\"module\\/carousel\",\"module\\/html\",\"module\\/menu\",\"module\\/video\",\"report\\/online\",\"report\\/report\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/analytics\\/google\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/customer_activity\",\"extensions\\/report\\/user_activity\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\"],\"modify\":[\"catalog\\/application\",\"catalog\\/category\",\"catalog\\/information\",\"children\\/children\",\"children\\/children_group\",\"children\\/schemes\",\"common\\/filemanager\",\"common\\/profile\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/translation\",\"extension\\/analytics\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/report\",\"extension\\/theme\",\"localisation\\/currency\",\"localisation\\/language\",\"module\\/account\",\"module\\/carousel\",\"module\\/html\",\"module\\/menu\",\"module\\/video\",\"report\\/online\",\"report\\/report\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/analytics\\/google\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/customer_activity\",\"extensions\\/report\\/user_activity\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/dustrix\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/basic\",\"extensions\\/theme\\/dustrix\"]}', 1627475452, 1633595997);

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
  ADD PRIMARY KEY (`customer_id`);

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
  ADD PRIMARY KEY (`customer_online_id`);

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
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `ci_customer_online`
--
ALTER TABLE `ci_customer_online`
  MODIFY `customer_online_id` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `information_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `layout_module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  MODIFY `layout_route_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ci_module`
--
ALTER TABLE `ci_module`
  MODIFY `module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1359;

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
  MODIFY `activity_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  MODIFY `user_group_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
