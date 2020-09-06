-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 07:20 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

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
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(11) NOT NULL,
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

INSERT INTO `tbl_items` (`id`, `name`, `image`, `category`, `status`, `description`, `create_at`, `update_at`) VALUES
(1, 'Aalu paratha', 'public/upload/item_img/alparatha.jpg', 'Nonveg', 'Inactive', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(2, 'Dal Bati', 'public/upload/item_img/dal bati.jpg', 'Veg', 'Active', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(3, 'Kheer puri', 'public/upload/item_img/kheer.jpg', 'Veg', 'Active', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00'),
(4, 'Dal bafla', 'public/upload/item_img/easy-dal.jpg', 'Veg', 'Active', '', '2020-04-10 00:00:00', '2020-04-10 00:00:00');

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
  `mobile` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` enum('Female','Male','Other') NOT NULL,
  `zipcodes` text NOT NULL COMMENT 'mom delevery zipcode areas comma separated zipcodes',
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
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

INSERT INTO `tbl_moms` (`mid`, `full_name`, `mobile`, `email`, `gender`, `zipcodes`, `city_id`, `state_id`, `country_id`, `status`, `is_deleted`, `oauth_provider`, `oauth_uid`, `profile_img`, `password`, `forgot_pass_identity`, `create_at`, `update_at`, `link`) VALUES
(1, 'Mom 1', '9999999999', 'mom1@gmail.com', 'Female', '452005', 0, 0, 0, 'Active', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(2, 'Mom 2', '8888888888', 'mom2@gmail.com', 'Female', '452005', 0, 0, 0, 'Active', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(3, 'Mom 3', '1111111111', 'mom3@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(4, 'Mom 4', '2222222222', 'mom4@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(5, 'Mom 5', '5555555555', 'mom5@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(6, 'Mom 6', '8888888888', 'mom6@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(7, 'Mom 7', '9999999999', 'mom7@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(8, 'Mom 8', '8888888888', 'mom8@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(9, 'Mom 9', '8888888888', 'mom9@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(10, 'Mom 10', '9999999999', 'mom10@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(11, 'Mom 11', '8888888888', 'mom11@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(12, 'Mom 12', '1111111111', 'mom12@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(13, 'Mom 13', '2222222222', 'mom13@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(14, 'Mom 14', '5555555555', 'mom14@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(15, 'Mom 15', '8888888888', 'mom15@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(16, 'Mom 16', '9999999999', 'mom16@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(17, 'Mom 17', '8888888888', 'mom17@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', ''),
(18, 'Mom 18', '8888888888', 'mom18@gmail.com', 'Female', '452005', 0, 0, 0, 'Inactive', '', '', '', '', '', '', '2020-04-09 00:00:00', '2020-04-09 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `uid` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `zipcode` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `is_deleted` enum('0','1') NOT NULL COMMENT '''0'' for not delete and ''1'' for deleted',
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
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
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
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
