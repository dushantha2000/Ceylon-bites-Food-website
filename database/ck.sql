-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2023 at 07:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ck`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(80) NOT NULL,
  `item_description` varchar(55) NOT NULL,
  `price` int(12) NOT NULL,
  `category` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`item_id`, `item_name`, `item_description`, `price`, `category`) VALUES
(1, 'Soup', 'Recipe uses variety of vegetables and vegetable stock t', 950, 'Soup'),
(5, 'Pizza', 'Pizza is a dish of Italian origin, made with an oven-ba', 2650, 'Italian'),
(6, 'Wine', 'Wine is an alcoholic drink made from fermented fruits a', 1250, 'Drinks'),
(7, 'Big Chicken Burger', 'Shortened in length, the term Burger is used to describ', 850, 'Fast Food'),
(8, 'Hot Coffee', 'Coffee is a beverage prepared from roasted coffee beans', 400, 'Cofee'),
(9, 'Fresh Salad', 'A salad is a dish consisting of mixed ingredients, freq', 500, 'Salad');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `total_payment` int(11) NOT NULL,
  `payment_type` enum('Cash','Card','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `user_id`, `cart_id`, `total_payment`, `payment_type`) VALUES
(71, 4, 10, 2650, 'Cash'),
(73, 4, 10, 5300, 'Cash'),
(74, 4, 12, 2650, 'Cash'),
(75, 4, 0, 0, 'Cash'),
(76, 4, 13, 4850, 'Cash'),
(77, 4, 16, 4400, 'Cash'),
(78, 4, 0, 0, 'Cash'),
(79, 4, 19, 5250, 'Cash'),
(80, 4, 23, 5350, 'Cash'),
(81, 4, 27, 4850, 'Cash'),
(82, 4, 30, 4850, 'Cash'),
(83, 4, 33, 8000, 'Cash'),
(84, 4, 37, 4000, 'Cash'),
(85, 4, 40, 3250, 'Cash'),
(86, 4, 44, 4500, 'Cash'),
(87, 4, 49, 1250, 'Cash'),
(88, 1, 51, 3900, 'Card'),
(89, 1, 54, 950, 'Cash'),
(90, 1, 56, 850, 'Cash'),
(91, 1, 57, 1700, 'Cash'),
(92, 1, 59, 9200, 'Cash'),
(93, 5, 61, 8900, 'Cash'),
(94, 1, 63, 9200, 'Cash'),
(95, 1, 65, 6100, 'Cash'),
(96, 1, 70, 8600, 'Card');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(55) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `number_of_guests` int(11) NOT NULL,
  `date_of_reservation` date NOT NULL,
  `time_of_reservation` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `name`, `email`, `phone_number`, `number_of_guests`, `date_of_reservation`, `time_of_reservation`) VALUES
(5, 'Sandeepa', 'sandeepa@gmail.com', 2147483647, 2, '2023-12-12', '22:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `table_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `availability` enum('Available','Not Available','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `address` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `address`, `email`, `phone_number`, `password`) VALUES
(1, 'Chamath', '', '87/T,Gampaha', 'chamath@gmail.com', 789122433, '123'),
(4, 'Chamara', 'Jayashan', '84/Paskjdaklsdjaojd,Galle', 'chamara@gmail.com', 765677852, '123'),
(5, 'test', 'test', '84/Paskjdaklsdjaojd,Galle', 'test@gmail.com', 751234895, '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`table_id`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
