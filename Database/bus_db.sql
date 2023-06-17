-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 11:23 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_number` varchar(20) NOT NULL,
  `route_id` int(11) NOT NULL,
  `num_tickets` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_email`, `user_name`, `user_number`, `route_id`, `num_tickets`, `total_price`, `status`) VALUES
(1, 'nas@gmail.com', 'nasir', '3176526827', 2, 1, '2.00', 'confirmed'),
(2, 'nas@gmail.com', 'nasir', '3176526827', 2, 1, '2.00', 'pending'),
(3, 'nas@gmail.com', 'nasir', '3176526827', 2, 1, '2.00', 'pending'),
(4, 'nas@gmail.com', 'nasir', '3176526827', 2, 1, '2.00', 'pending'),
(5, 'nas@gmail.com', 'nasir', '3176526827', 2, 4, '8.00', 'pending'),
(6, 'nas@gmail.com', 'nasir', '3176526827', 2, 5, '10.00', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `via_city` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `bus_name` varchar(255) NOT NULL,
  `bus_number` varchar(255) NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `ticket_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `via_city`, `destination`, `bus_name`, `bus_number`, `departure_date`, `departure_time`, `ticket_price`) VALUES
(2, 'Jampur', 'Multan', 'Daweoo', '48653', '2023-06-17', '12:38:00', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`) VALUES
(1, 'admin', '$2y$10$MSrnYWvKzKl8z1IB2MGdo.c6gxdyLrczNrRPEfuEtAZbGKfSkLbvG', 'nasiryt.827@gmail.com', '03176526827'),
(2, 'yoututbe', '$2y$10$1iWZmFU6hR.if3Nl44ZVGuv1p9.EbVohuuFcwLJUYuf.JrTA/2Ixa', 'yoututbe@gmail.com', '5423623'),
(3, 'nasir', '$2y$10$Fhtt/zJqR4nOVDy2l10nZuu4pAjq8Uj3GlToaHJpkS.BeeHbe8lX.', 'nas@gmail.com', '3176526827');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
