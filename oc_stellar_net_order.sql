-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2017 at 03:49 PM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opencart`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_stellar_net_order`
--

CREATE TABLE `oc_stellar_net_order` (
  `stellar_net_order_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `capture_status` tinyint(4) DEFAULT NULL,
  `currency_code` char(3) NOT NULL,
  `from_public_id` char(60) NOT NULL,
  `to_public_id` char(60) NOT NULL,
  `asset_code` char(20) NOT NULL,
  `issuer` char(60) NOT NULL,
  `memo` char(60) NOT NULL,
  `escrow_b64_tx` text NOT NULL,
  `escrow_publicId` text NOT NULL,
  `escrow_expire_ts` datetime NOT NULL,
  `escrow_collected` int(1) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `escrow_account_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_stellar_net_order`
--
ALTER TABLE `oc_stellar_net_order`
  ADD PRIMARY KEY (`stellar_net_order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_stellar_net_order`
--
ALTER TABLE `oc_stellar_net_order`
  MODIFY `stellar_net_order_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
