-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2017 at 11:31 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `street_1` varchar(255) NOT NULL,
  `street_2` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` smallint(5) NOT NULL,
  `other_address_details` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `customer_phone` varchar(10) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `other_customer_details` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `products_id` int(10) UNSIGNED NOT NULL,
  `order_status_id` int(10) UNSIGNED NOT NULL COMMENT '0 = not-finished, 1 = processing, 2 = approved',
  `date_order_placed` datetime NOT NULL,
  `date_order_paid` datetime NOT NULL,
  `total_price_paid_with_taxes` double NOT NULL,
  `total_taxes_paid` double NOT NULL,
  `customer_payment_id` int(10) UNSIGNED NOT NULL,
  `other_order_details` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_status_codes`
--

CREATE TABLE `customer_order_status_codes` (
  `customer_order_status_codes_id` int(10) UNSIGNED NOT NULL,
  `order_status_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order_status_codes`
--

INSERT INTO `customer_order_status_codes` (`customer_order_status_codes_id`, `order_status_name`) VALUES
(1, 'Not Finished'),
(2, 'Processing'),
(3, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_credit_card`
--

CREATE TABLE `customer_payment_credit_card` (
  `customer_payment_credit_card_id` int(10) UNSIGNED NOT NULL,
  `card_number` smallint(5) UNSIGNED NOT NULL,
  `card_security` smallint(5) UNSIGNED NOT NULL,
  `card_exp_month` tinyint(3) UNSIGNED NOT NULL,
  `card_exp_year` smallint(4) UNSIGNED NOT NULL,
  `card_type_id` tinyint(3) UNSIGNED NOT NULL,
  `card_first_name` varchar(255) NOT NULL,
  `card_last_name` varchar(255) NOT NULL,
  `customers_id` int(10) UNSIGNED NOT NULL,
  `card_billing_address_id` int(10) UNSIGNED NOT NULL COMMENT 'Points to addresses_id'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_credit_card_third_party`
--

CREATE TABLE `customer_payment_credit_card_third_party` (
  `customer_payment_credit_card_third_party_id` int(10) UNSIGNED NOT NULL,
  `cc_third_party_transaction_number` varchar(255) NOT NULL,
  `cc_third_party_vendor_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_credit_card_third_party_vendors`
--

CREATE TABLE `customer_payment_credit_card_third_party_vendors` (
  `customer_payment_credit_card_third_party_vendors_id` int(10) UNSIGNED NOT NULL,
  `cc_third_party_vendor_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_payment_credit_card_third_party_vendors`
--

INSERT INTO `customer_payment_credit_card_third_party_vendors` (`customer_payment_credit_card_third_party_vendors_id`, `cc_third_party_vendor_name`) VALUES
(1, 'Discover'),
(2, 'Visa'),
(3, 'MasterCard'),
(4, 'American Express');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_credit_card_types`
--

CREATE TABLE `customer_payment_credit_card_types` (
  `customer_payment_credit_card_types_id` int(10) UNSIGNED NOT NULL,
  `credit_card_type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_methods`
--

CREATE TABLE `customer_payment_methods` (
  `customer_payment_methods_id` int(10) UNSIGNED NOT NULL,
  `customer_orders_id` int(10) UNSIGNED NOT NULL,
  `payment_method_code` int(10) UNSIGNED NOT NULL COMMENT 'References the appropriate payment table',
  `payment_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_method_codes`
--

CREATE TABLE `customer_payment_method_codes` (
  `customer_payment_method_codes_id` int(10) UNSIGNED NOT NULL,
  `payment_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `products_id` int(10) UNSIGNED NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `make` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `engine` varchar(255) NOT NULL,
  `horsepower` varchar(100) NOT NULL,
  `torque` varchar(100) NOT NULL,
  `zero_to_sixty_time` varchar(100) NOT NULL,
  `quarter_mile_time` varchar(100) NOT NULL,
  `daily_cost` decimal(7,0) NOT NULL,
  `vehicle_description` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `year`, `make`, `model`, `engine`, `horsepower`, `torque`, `zero_to_sixty_time`, `quarter_mile_time`, `daily_cost`, `vehicle_description`) VALUES
(1, 1991, 'Acura', 'NSX', '3179 cc, V6 VTEC', '290 bhp @ 7100rpm', '304 Nm @ 5500rpm', '4.5', '13.4 sec @ 106mph', '120', 'This NSX became the world\'s first mass-produced car to feature an all-aluminium body. It was powered by an all-aluminium 3.0 L V6 engine, which featured Honda\'s VTEC system developed in the 1980s, a 5-speed manual or 4-speed Sports Shift automatic transmissions.'),
(2, 2016, 'Aston Martin', 'DB9', '5.935 L V12', '540 hp', '569 Nm @ 5,000 rpm', '4.7', '12.8 sec @ 127mph', '200', 'The DB9, designed by Marek Reichman and Henrik Fisker, is made largely of aluminium. The chassis is the VH platform whilst the engine is the 6.0L V12 from the Aston Martin V12 Vanquish. It has a top speed of 295 km/h (183 mph) and a 0 to 97 km/h (60 mph) time of 4.1 seconds.'),
(3, 2007, 'Audi', 'R8', '5.2 L FSI V10, 2×DOHC', '414 hp', '430 Nm @ 5,000 rpm', '3.9', '10.8 sec @ 140mph', '250', 'The R8 is exclusively designed, developed, and manufactured by Audi AG\'s high performance private subsidiary company, Audi Sport GmbH, and is based on the Lamborghini Gallardo platform. The fundamental construction of the R8 is based on the Audi Space Frame.'),
(4, 2009, 'Ferrari', '458', '4.5 L V8', '562 hp @ 9,000rpm', '540 Nm @ 6,000 rpm', '2.9', '8.8 sec @ 180mph', '650', 'The Ferrari 458 Italia is a mid-engined sports car produced by the Italian sports car manufacturer Ferrari. The 458 replaced the F430, and was first unveiled at the 2009 Frankfurt Motor Show. It is replaced by the 488, which was unveiled at the Geneva Motor Show 2015.'),
(5, 2003, 'Lamborghini', 'Murcielago', '6.5 L V12', '650hp @ 8,000rpm', '660 Nm @ 6,500 rpm', '3.3', '10.9 sec @ 129.4mph', '600', 'The Lamborghini Murciélago is a supercar produced by Italian automaker Lamborghini between 2001 and 2010. Successor to the Diablo and flagship of the automaker\'s lineup, the Murciélago was introduced as a coupé in 2001.');

-- --------------------------------------------------------

--
-- Table structure for table `products_availability`
--

CREATE TABLE `products_availability` (
  `products_availability_id` int(10) UNSIGNED NOT NULL,
  `products_id` int(10) UNSIGNED NOT NULL,
  `reserved_from` datetime NOT NULL,
  `reserved_to` datetime NOT NULL,
  `reserved_by` int(10) UNSIGNED NOT NULL COMMENT 'customers_id',
  `customer_orders_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_availability`
--

INSERT INTO `products_availability` (`products_availability_id`, `products_id`, `reserved_from`, `reserved_to`, `reserved_by`, `customer_orders_id`) VALUES
(1, 1, '2017-07-27 15:03:33', '2017-07-28 15:03:33', 3, 1),
(2, 2, '2017-07-25 00:00:00', '2017-07-28 00:00:00', 4, 5),
(3, 2, '2017-07-25 00:00:00', '2017-07-28 00:00:00', 4, 6),
(4, 2, '2017-07-25 00:00:00', '2017-07-28 00:00:00', 3, 7),
(5, 2, '2017-07-25 00:00:00', '2017-07-28 00:00:00', 4, 8),
(6, 1, '2017-08-25 00:00:00', '2017-08-26 00:00:00', 4, 9),
(7, 2, '2017-07-25 00:00:00', '2017-07-28 00:00:00', 4, 10),
(8, 1, '2017-08-25 00:00:00', '2017-08-26 00:00:00', 4, 11),
(9, 1, '2017-09-25 00:00:00', '2017-09-28 00:00:00', 3, 12),
(10, 1, '2017-09-25 00:00:00', '2017-09-28 00:00:00', 5, 13),
(11, 1, '2017-09-25 00:00:00', '2017-09-28 00:00:00', 5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `access_level` smallint(5) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `joined` datetime NOT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_order_status_codes`
--
ALTER TABLE `customer_order_status_codes`
  ADD PRIMARY KEY (`customer_order_status_codes_id`);

--
-- Indexes for table `customer_payment_credit_card`
--
ALTER TABLE `customer_payment_credit_card`
  ADD PRIMARY KEY (`customer_payment_credit_card_id`);

--
-- Indexes for table `customer_payment_credit_card_third_party`
--
ALTER TABLE `customer_payment_credit_card_third_party`
  ADD PRIMARY KEY (`customer_payment_credit_card_third_party_id`);

--
-- Indexes for table `customer_payment_credit_card_third_party_vendors`
--
ALTER TABLE `customer_payment_credit_card_third_party_vendors`
  ADD PRIMARY KEY (`customer_payment_credit_card_third_party_vendors_id`);

--
-- Indexes for table `customer_payment_credit_card_types`
--
ALTER TABLE `customer_payment_credit_card_types`
  ADD PRIMARY KEY (`customer_payment_credit_card_types_id`);

--
-- Indexes for table `customer_payment_methods`
--
ALTER TABLE `customer_payment_methods`
  ADD PRIMARY KEY (`customer_payment_methods_id`);

--
-- Indexes for table `customer_payment_method_codes`
--
ALTER TABLE `customer_payment_method_codes`
  ADD PRIMARY KEY (`customer_payment_method_codes_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`products_id`);

--
-- Indexes for table `products_availability`
--
ALTER TABLE `products_availability`
  ADD PRIMARY KEY (`products_availability_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `customer_order_status_codes`
--
ALTER TABLE `customer_order_status_codes`
  MODIFY `customer_order_status_codes_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_payment_credit_card`
--
ALTER TABLE `customer_payment_credit_card`
  MODIFY `customer_payment_credit_card_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customer_payment_credit_card_third_party`
--
ALTER TABLE `customer_payment_credit_card_third_party`
  MODIFY `customer_payment_credit_card_third_party_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_payment_credit_card_third_party_vendors`
--
ALTER TABLE `customer_payment_credit_card_third_party_vendors`
  MODIFY `customer_payment_credit_card_third_party_vendors_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_payment_credit_card_types`
--
ALTER TABLE `customer_payment_credit_card_types`
  MODIFY `customer_payment_credit_card_types_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_payment_methods`
--
ALTER TABLE `customer_payment_methods`
  MODIFY `customer_payment_methods_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_payment_method_codes`
--
ALTER TABLE `customer_payment_method_codes`
  MODIFY `customer_payment_method_codes_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `products_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `products_availability`
--
ALTER TABLE `products_availability`
  MODIFY `products_availability_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
