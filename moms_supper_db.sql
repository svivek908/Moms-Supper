-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2020 at 07:24 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moms_supper_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `mid` int(11) NOT NULL,
  `item_quty` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `price` double NOT NULL,
  `tax` double NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `roll` enum('1','2') NOT NULL COMMENT '''1'' use for super admin and ''2'' used for admin',
  `password` varchar(300) NOT NULL,
  `mobile` varchar(13) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `email`, `roll`, `password`, `mobile`, `create_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2', '$2y$10$y8.To1HWn.EX7F31eUhDwubTXJ8RWDfSDcFtHqDyU.TelrpcqTfCy', '9999999999', '2019-07-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `food_timing`
--

CREATE TABLE `food_timing` (
  `id` int(11) NOT NULL,
  `food_category` varchar(10) NOT NULL,
  `timing` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `food_timing`
--

INSERT INTO `food_timing` (`id`, `food_category`, `timing`) VALUES
(1, 'Breakfast', '8am to 9am'),
(2, 'Breakfast', '9am to 10am'),
(3, 'Breakfast', '10am to 11am'),
(4, 'Lunch', '12pm to 5pm'),
(5, 'Lunch', '2pm to 6pm'),
(6, 'Lunch', '3pm to 6pm'),
(7, 'Dinner', '7pm to 9pm'),
(8, 'Dinner', '8pm to 10pm'),
(9, 'Dinner', '8pm to 10pm');

-- --------------------------------------------------------

--
-- Table structure for table `moms_rating`
--

CREATE TABLE `moms_rating` (
  `id` int(11) NOT NULL,
  `mom_id` varchar(1024) NOT NULL,
  `user_id` varchar(1024) NOT NULL,
  `rating` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moms_rating`
--

INSERT INTO `moms_rating` (`id`, `mom_id`, `user_id`, `rating`) VALUES
(5, '1', '1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `moms_weekdays`
--

CREATE TABLE `moms_weekdays` (
  `id` int(11) NOT NULL,
  `mom_id` int(11) NOT NULL,
  `days` varchar(11) NOT NULL,
  `food_type` varchar(30) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moms_weekdays`
--

INSERT INTO `moms_weekdays` (`id`, `mom_id`, `days`, `food_type`, `created_date`) VALUES
(1, 1, 'M', 'Breakfast', '2020-05-22 08:29:35'),
(2, 1, 'T', 'Breakfast', '2020-05-25 07:45:32'),
(3, 1, 'W', 'Breakfast', '2020-05-22 08:30:03'),
(4, 1, 'Th', 'Breakfast', '2020-05-25 07:45:40'),
(5, 1, 'M', 'Lunch', '2020-05-22 08:30:43'),
(6, 1, 'T', 'Lunch', '2020-05-22 08:52:14'),
(7, 1, 'M', 'Dinner', '2020-05-22 08:31:40'),
(8, 1, 'F', 'Dinner', '2020-05-22 08:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_item`
--

CREATE TABLE `ordered_item` (
  `id` int(11) NOT NULL,
  `item_id` varchar(1024) NOT NULL,
  `item_quty` int(11) NOT NULL,
  `user_id` varchar(1024) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `order_id` varchar(1024) NOT NULL DEFAULT '0',
  `alernative_item_id` varchar(1024) NOT NULL DEFAULT 'NA',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = ordered, 2 = alternate, 3 = suggested, 4 = cancelled, 5 = In review after suggestion',
  `item_found_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = To-do, 1 = Suggested Alternate, 2 = Item found',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordered_item`
--

INSERT INTO `ordered_item` (`id`, `item_id`, `item_quty`, `user_id`, `price`, `tax`, `order_id`, `alernative_item_id`, `status`, `item_found_status`, `created_at`) VALUES
(3, '1', 1, '1', 100, 10, 'ORD15901321478323', 'NA', 1, 0, '2020-05-22 07:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `txn_id` varchar(50) NOT NULL,
  `mom_id` varchar(10) NOT NULL,
  `total_price` double NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `tax` double NOT NULL,
  `dlv_charge` double NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dlv_date` date NOT NULL,
  `payerID` varchar(50) NOT NULL,
  `is_payment_done` int(11) NOT NULL DEFAULT '0' COMMENT '0 for payment not done,1 means payment done',
  `status` int(11) NOT NULL COMMENT '0for new order,1 for prepare,2 for packed,3 for go for delivery,4 dileverd,5reject,6 for cancle',
  `order_from` varchar(50) NOT NULL,
  `lunch_time` varchar(30) NOT NULL,
  `breakfast_time` varchar(30) NOT NULL,
  `dinner_time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`id`, `order_id`, `user_id`, `txn_id`, `mom_id`, `total_price`, `payment_type`, `tax`, `dlv_charge`, `date_time`, `dlv_date`, `payerID`, `is_payment_done`, `status`, `order_from`, `lunch_time`, `breakfast_time`, `dinner_time`) VALUES
(6, 'ORD15901321478323', '1', '123456', '1', 110, 'cod', 0, 0, '2020-05-22 07:22:27', '0000-00-00', 'p1234', 0, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_address`
--

CREATE TABLE `shipping_address` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `ship_mobile_no` varchar(20) NOT NULL,
  `email_id` varchar(20) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping_address`
--

INSERT INTO `shipping_address` (`id`, `order_id`, `user_id`, `name`, `address`, `ship_mobile_no`, `email_id`, `country_id`, `city_id`, `pincode`) VALUES
(4, 'ORD15901321478323', '1', 'priyank', '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', '9575780165', 'priyank@gmail.com', 1, 1, 477557);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL,
  `city_name` varchar(20) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `city_name`, `country_id`) VALUES
(1, 'Delhi', 1),
(2, 'Indore', 1),
(3, 'Bhopal', 1),
(4, 'Gwalior', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food_type`
--

CREATE TABLE `tbl_food_type` (
  `id` int(11) NOT NULL,
  `mom_id` int(11) NOT NULL,
  `meal_type_id` int(11) NOT NULL,
  `food_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_food_type`
--

INSERT INTO `tbl_food_type` (`id`, `mom_id`, `meal_type_id`, `food_type`) VALUES
(1, 1, 1, 'Dinner'),
(2, 2, 1, 'lunch');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(11) NOT NULL,
  `thali_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category` enum('Veg','Nonveg') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `description` text NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `thali_id`, `name`, `image`, `category`, `status`, `description`, `create_at`, `update_at`) VALUES
(1, 0, 'Aalu paratha', 'public/upload/item_img/alparatha.jpg', 'Nonveg', 'Inactive', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(2, 0, 'Dal Bati', 'public/upload/item_img/dal bati.jpg', 'Veg', 'Active', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(3, 0, 'Kheer puri', 'public/upload/item_img/kheer.jpg', 'Veg', 'Active', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(4, 0, 'Dal bafla', 'public/upload/item_img/easy-dal.jpg', 'Veg', 'Active', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL,
  `mom_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `meal_type` enum('Breakfast','Lunch','Dinner') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `time_duration` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `mom_id`, `item_id`, `meal_type`, `status`, `time_duration`, `create_at`, `update_at`) VALUES
(1, 1, 1, 'Breakfast', 'Active', '2', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(2, 1, 2, 'Lunch', 'Active', '2', '2020-04-10 00:00:00', '2020-03-10 00:00:00'),
(3, 1, 3, 'Dinner', 'Active', '2', '2020-03-10 00:00:00', '2020-03-10 00:00:00'),
(4, 2, 1, 'Breakfast', 'Active', '2', '2020-04-10 00:00:00', '2020-04-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_moms`
--

CREATE TABLE `tbl_moms` (
  `mid` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `moms_image` varchar(100) NOT NULL,
  `kitchen_name` varchar(100) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` enum('Female','Male','Other') NOT NULL,
  `zipcodes` text NOT NULL COMMENT 'mom delevery zipcode areas comma separated zipcodes',
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `kitchen_type` enum('Veg','Non-veg','Veg and Non-Veg') NOT NULL,
  `is_deleted` enum('0','1') NOT NULL COMMENT '''0''  for not delete and ''1'' for deleted',
  `oauth_provider` varchar(50) NOT NULL,
  `oauth_uid` varchar(100) NOT NULL,
  `profile_img` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `forgot_pass_identity` varchar(50) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `link` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Moms table';

--
-- Dumping data for table `tbl_moms`
--

INSERT INTO `tbl_moms` (`mid`, `full_name`, `moms_image`, `kitchen_name`, `mobile`, `email`, `gender`, `zipcodes`, `city_id`, `state_id`, `country_id`, `status`, `kitchen_type`, `is_deleted`, `oauth_provider`, `oauth_uid`, `profile_img`, `password`, `forgot_pass_identity`, `create_at`, `update_at`, `link`) VALUES
(1, 'Mom 1', '/uploads/image_1167542193.jpg', 'Zomato Mess', '9999999999', 'mom1@gmail.com', 'Female', '452005', 0, 0, 0, 'Active', 'Non-veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(2, 'Mom 2', '', '', '8888888888', 'mom2@gmail.com', 'Female', '452005', 0, 0, 0, 'Active', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(3, 'Mom 3', '', '', '1111111111', 'mom3@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(4, 'Mom 4', '', '', '2222222222', 'mom4@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(5, 'Mom 5', '', '', '5555555555', 'mom5@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(6, 'Mom 6', '', '', '8888888888', 'mom6@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(7, 'Mom 7', '', '', '9999999999', 'mom7@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(8, 'Mom 8', '', '', '8888888888', 'mom8@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(9, 'Mom 9', '', '', '8888888888', 'mom9@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(10, 'Mom 10', '', '', '9999999999', 'mom10@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(11, 'Mom 11', '', '', '8888888888', 'mom11@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(12, 'Mom 12', '', '', '1111111111', 'mom12@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(13, 'Mom 13', '', '', '2222222222', 'mom13@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(14, 'Mom 14', '', '', '5555555555', 'mom14@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(15, 'Mom 15', '', '', '8888888888', 'mom15@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(16, 'Mom 16', '', '', '9999999999', 'mom16@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(17, 'Mom 17', '', '', '8888888888', 'mom17@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(18, 'Mom 18', '', '', '8888888888', 'mom18@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', 'Veg', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mom_list`
--

CREATE TABLE `tbl_mom_list` (
  `id` int(11) NOT NULL,
  `moms_name` varchar(50) NOT NULL,
  `moms_image` varchar(100) NOT NULL,
  `moms_kitchen_name` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thali`
--

CREATE TABLE `tbl_thali` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `thali_name` varchar(20) NOT NULL,
  `thali_image` varchar(100) NOT NULL,
  `food_type` enum('Veg','Non-veg','Veg and Non-veg') NOT NULL,
  `food_category` enum('Breakfast','Lunch','Dinner') NOT NULL,
  `days` varchar(10) NOT NULL,
  `price` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_thali`
--

INSERT INTO `tbl_thali` (`id`, `mid`, `thali_name`, `thali_image`, `food_type`, `food_category`, `days`, `price`) VALUES
(1, 1, 'Punjabi veg', '', 'Veg', 'Lunch', '1', '100'),
(2, 1, 'non veg', '', 'Non-veg', 'Dinner', '1', '200');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usergcm`
--

CREATE TABLE `tbl_usergcm` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `gcm_id` varchar(500) NOT NULL,
  `uid` varchar(500) NOT NULL,
  `divicetype` varchar(100) NOT NULL,
  `unitime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_usergcm`
--

INSERT INTO `tbl_usergcm` (`id`, `user_id`, `gcm_id`, `uid`, `divicetype`, `unitime`) VALUES
(1, '1', '12245555455', '', 'vfjfdbffdkdjfdj', '2020-04-24 11:07:44'),
(2, '2', '12245555455', '', 'vfjfdbffdkdjfdj', '2020-04-24 11:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `uid` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `zipcode` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `api_key` varchar(1024) NOT NULL,
  `forgot_pass_otp` int(11) NOT NULL,
  `gst_no` int(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `is_deleted` enum('0','1') NOT NULL COMMENT '''0'' for not delete and ''1'' for deleted',
  `oauth_provider` varchar(50) NOT NULL,
  `oauth_uid` varchar(100) NOT NULL,
  `profile_img` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `forgot_pass_identity` varchar(50) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL,
  `link` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Moms table';

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`uid`, `full_name`, `user_image`, `mobile`, `email`, `gender`, `zipcode`, `city_id`, `api_key`, `forgot_pass_otp`, `gst_no`, `country_id`, `status`, `is_deleted`, `oauth_provider`, `oauth_uid`, `profile_img`, `password`, `forgot_pass_identity`, `create_at`, `update_at`, `link`) VALUES
(1, 'vivek', '/uploads/image_1393954198.jpg', '9575780165', 'svivek908@gmail.com', 'Male', 474020, 12, '3552bea73739ba452ccbebf0bce1a8bd', 410006, 0, 1, 'Active', '0', '', '', '', '$2y$10$CvgZJ/z13iWX.Tb7KHF9i.F43.vup9XeNsDUVMB0vcEc33D.zqQAG', '', '2020-05-08 07:25:20', '0000-00-00 00:00:00', ''),
(3, 'vivek', '/uploads/image_1167542193.jpg', '95735780165', 'vivekddd@gmail.com', 'Male', 474020, 12, '149e7b6f1f97138cefb0644b8df0d99c', 0, 0, 1, 'Active', '0', '', '', '', '$2y$10$7OYITPNCQBLz8qCqWqqe.e08/eRkNB0MYeisnADq1oP3OGHXhrD/u', '', '2020-05-01 09:49:49', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `add_type` varchar(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`address_id`, `user_id`, `address`, `add_type`, `created_date`) VALUES
(2, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:24:42'),
(3, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:30:22'),
(4, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:30:58'),
(5, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:33:50'),
(6, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:34:55'),
(7, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:35:27'),
(8, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:35:29'),
(9, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:35:47'),
(10, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:35:59'),
(11, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:36:44'),
(12, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:37:04'),
(13, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:37:52'),
(14, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:38:04'),
(15, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:39:36'),
(16, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:40:17'),
(17, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:42:36'),
(18, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:44:07'),
(19, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:44:13'),
(20, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:45:20'),
(21, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:48:24'),
(22, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:52:07'),
(23, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 11:52:33'),
(24, 1, '\"\"', 'home', '2020-05-20 12:13:00'),
(25, 1, '{\"street_address\":\"DSD Trucking, Santa Fe Avenue, Redondo Beach, CA, USA\",\"apt_no\":\"hfghfg fgh f\",\"complex_name\":\"sd d asd2 2e \",\"latitude\":\"\",\"longitude\":\"\"}', 'home', '2020-05-20 12:17:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_timing`
--
ALTER TABLE `food_timing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moms_rating`
--
ALTER TABLE `moms_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`mom_id`(767)),
  ADD KEY `user_id` (`user_id`(767)),
  ADD KEY `rating` (`rating`);

--
-- Indexes for table `moms_weekdays`
--
ALTER TABLE `moms_weekdays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordered_item`
--
ALTER TABLE `ordered_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`(767)),
  ADD KEY `user_id` (`user_id`(767)),
  ADD KEY `order_id` (`order_id`(767)),
  ADD KEY `status` (`status`);

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_address`
--
ALTER TABLE `shipping_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_food_type`
--
ALTER TABLE `tbl_food_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_moms`
--
ALTER TABLE `tbl_moms`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `tbl_mom_list`
--
ALTER TABLE `tbl_mom_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_thali`
--
ALTER TABLE `tbl_thali`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_usergcm`
--
ALTER TABLE `tbl_usergcm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food_timing`
--
ALTER TABLE `food_timing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `moms_rating`
--
ALTER TABLE `moms_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `moms_weekdays`
--
ALTER TABLE `moms_weekdays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ordered_item`
--
ALTER TABLE `ordered_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_table`
--
ALTER TABLE `order_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shipping_address`
--
ALTER TABLE `shipping_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_food_type`
--
ALTER TABLE `tbl_food_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_moms`
--
ALTER TABLE `tbl_moms`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_mom_list`
--
ALTER TABLE `tbl_mom_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_thali`
--
ALTER TABLE `tbl_thali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_usergcm`
--
ALTER TABLE `tbl_usergcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
