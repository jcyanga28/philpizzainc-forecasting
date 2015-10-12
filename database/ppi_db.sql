-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2014 at 12:05 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ppi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(150) NOT NULL,
  `sap_code` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `location_code`, `sap_code`, `description`) VALUES
(1, '1', '', 'RSC - HEAD OFFICE'),
(2, '2', '', 'DAIRY QUEEN - FOOD EXPRESS'),
(3, '3', 'SAP002', 'DAIRY QUEEN - MAIN'),
(4, '4', 'SAP01', 'PH GATEWAY - RR');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_dayfive`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_dayfive` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_dayfive`
--

INSERT INTO `dailysale_forecast_dayfive` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_dayfour`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_dayfour` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_dayfour`
--

INSERT INTO `dailysale_forecast_dayfour` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_dayone`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_dayone` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_dayone`
--

INSERT INTO `dailysale_forecast_dayone` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '136', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '220', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '-40', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '24', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '300', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '500', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '-25', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '1', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '-1', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '-10', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_dayseven`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_dayseven` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_dayseven`
--

INSERT INTO `dailysale_forecast_dayseven` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_daysix`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_daysix` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_daysix`
--

INSERT INTO `dailysale_forecast_daysix` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_daythree`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_daythree` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_daythree`
--

INSERT INTO `dailysale_forecast_daythree` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `dailysale_forecast_daytwo`
--

CREATE TABLE IF NOT EXISTS `dailysale_forecast_daytwo` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `fg` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `need` varchar(100) NOT NULL,
  `adjustment` varchar(100) NOT NULL,
  `final_order` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date_sale` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dailysale_forecast_daytwo`
--

INSERT INTO `dailysale_forecast_daytwo` (`id`, `code`, `fg`, `size`, `need`, `adjustment`, `final_order`, `branch_id`, `date_sale`) VALUES
(1, '1234', 'Super Supreme 1', 'S', '38', '', '38', 1, '2014-11-09'),
(2, '1234', 'Super Supreme 2', 'S', '38', '', '38', 1, '2014-11-09'),
(3, '1234', 'Super Supreme 3', 'S', '24', '', '-16', 1, '2014-11-09'),
(4, '1234', 'Super Supreme 4', 'S', '24', '', '24', 1, '2014-11-09'),
(5, '1234', 'Super Supreme 5', 'S', '38', '', '38', 1, '2014-11-09'),
(6, '1234', 'Super Supreme 6', 'S', '46', '', '46', 1, '2014-11-09'),
(7, '1234', 'Super Supreme 7', 'S', '64', '', '64', 1, '2014-11-09'),
(8, '1234', 'Super Supreme 8', 'S', '42', '', '42', 1, '2014-11-09'),
(9, '1234', 'Super Supreme 9', 'S', '2', '', '2', 1, '2014-11-09'),
(10, '1234', 'Super Supreme 10', 'S', '2', '', '2', 1, '2014-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(150) NOT NULL,
  `barcode` varchar(150) NOT NULL,
  `sap_code` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  `size` varchar(150) NOT NULL,
  `price` double(10,2) NOT NULL,
  `branch_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `item_code`, `barcode`, `sap_code`, `description`, `size`, `price`, `branch_id`) VALUES
(1, 'FG001', 'PB01', 'SAP001', 'HAWAIIAN SUPREME PAN FAM', 'NONE                          ', 480.00, 2),
(2, 'FG002', 'PB02', '', 'VEGGIE SUP PAN FAM', 'NONE                          ', 480.00, 2),
(3, 'FG00002HAWAIIAN-SU', 'FG00002HAWAIIAN-SA', '', 'HAWAIIAN PAN', 'NONE                          ', 100.00, 2),
(4, '2210', 'C01', 'SAP001', 'NEOPOLITAN DARK', 'NONE                          ', 0.00, 2),
(5, '2210', 'C01', 'SAP001', 'NEOPOLITAN DARK', 'NONE                          ', 0.00, 4),
(6, 'FG002', 'PB02', '', 'VEGGIE SUP PAN FAM', 'NONE                          ', 480.00, 3),
(7, 'FG00002HAWAIIAN-SU', 'FG00002HAWAIIAN-SA', '', 'HAWAIIAN PAN', 'NONE                          ', 100.00, 3),
(8, '2210', 'C01', 'SAP001', 'NEOPOLITAN DARK', 'NONE                          ', 0.00, 3),
(9, 'FG0001', 'FG0001', '', 'SAMPLE SS', 'NONE                          ', 100.00, 2),
(10, 'FG0001', 'FG0001', '', 'SAMPLE SS', 'NONE                          ', 100.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `module_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `module` varchar(150) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module`) VALUES
(1, 'ITEM MAINTENANCE'),
(2, 'BRANCH MAINTENANCE'),
(3, 'MODULE MAINTENANCE'),
(4, 'MODULE ACCESS MAINTENANCE'),
(5, 'ROLE MAINTENANCE'),
(6, 'USER MAINTENANCE'),
(7, 'DAILY FORECASTING'),
(8, 'WEEKLY/MONTHLY FORECASTING');

-- --------------------------------------------------------

--
-- Table structure for table `module_access`
--

CREATE TABLE IF NOT EXISTS `module_access` (
  `module_access_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(50) NOT NULL,
  `role_id` int(50) NOT NULL,
  PRIMARY KEY (`module_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `module_access`
--

INSERT INTO `module_access` (`module_access_id`, `module_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(11, 1, 2),
(12, 7, 2),
(13, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `role` varchar(150) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Store Manager'),
(3, 'WAREHOUSE MANAGER');

-- --------------------------------------------------------

--
-- Table structure for table `usage_template`
--

CREATE TABLE IF NOT EXISTS `usage_template` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `fg` varchar(150) NOT NULL,
  `need` varchar(150) NOT NULL,
  `size` varchar(50) NOT NULL,
  `total` varchar(100) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `datetime_sale_update` datetime NOT NULL,
  `date_forecast` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `role_id` int(50) NOT NULL,
  `status` int(50) NOT NULL,
  `branch_id` int(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `fullname`, `role_id`, `status`, `branch_id`) VALUES
(5, 'SHEY', '4d0dd661d84a482676ff8c9258f5fce6', 'SHEY', 6, 1, 1),
(6, 'RENEE', 'b6436d939c7426657c51bd36eaaf1684', 'RENEE', 6, 1, 2),
(9, 'CATHY', '8d5e9f10c9d93c358476d7790c300e4f', 'CATHY', 5, 1, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
