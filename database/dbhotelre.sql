-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 05:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbhotelre`
--

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `review_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `reservation_id`, `user_id`, `rating`, `comment`, `review_date`) VALUES
(1, 7, 3, 3, 'Absolutely liked everything about this hotel. From delicious dining options to cozy rooms with stunning views, everything exceeded my expectations.', '2025-05-25'),
(3, 1, 3, 4, 'This room kinda good', '2025-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer`
--

CREATE TABLE `tblcustomer` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `nic_number` varchar(50) NOT NULL,
  `tel_number` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`user_id`, `full_name`, `nic_number`, `tel_number`, `address`, `created_at`) VALUES
(3, 'poorna', '1234567890', '0987654321', '726/c, Nawagamuwa, Ranala', '2025-05-10 17:30:43'),
(4, 'Arosha Bandara', '09876543', '0761234567', '32/F,Gampaha', '2025-05-18 13:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblreservation`
--

CREATE TABLE `tblreservation` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `num_guest` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid','Cancelled') DEFAULT 'Pending',
  `reservation_status` enum('Booked','CheckedIn','CheckedOut','Cancelled') DEFAULT 'Booked',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `has_reviewed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreservation`
--

INSERT INTO `tblreservation` (`id`, `customer_id`, `room_id`, `check_in_date`, `check_out_date`, `num_guest`, `total_amount`, `payment_status`, `reservation_status`, `created_at`, `updated_at`, `has_reviewed`) VALUES
(1, 3, 3, '2025-05-16', '2025-05-17', 4, 26400.00, 'Pending', 'Booked', '2025-05-15 13:26:34', '2025-05-25 17:04:47', 1),
(2, 3, 3, '2025-05-15', '2025-05-16', 2, 13200.00, 'Pending', 'Booked', '2025-05-15 14:34:37', '2025-05-25 17:48:51', 0),
(7, 4, 8, '2025-06-19', '2025-06-21', 5, 8500.00, 'Paid', 'Booked', '2025-05-19 09:37:26', '2025-05-19 09:57:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblroom`
--

CREATE TABLE `tblroom` (
  `id` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `type` enum('Deluxe','Standard','Suite','Family') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `bed_type` enum('Single','Double','Twin','Queen','King') NOT NULL,
  `max_occupancy` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `image_01` varchar(255) DEFAULT NULL,
  `image_02` varchar(255) DEFAULT NULL,
  `image_03` varchar(255) DEFAULT NULL,
  `status` enum('Available','Booked','Repair') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblroom`
--

INSERT INTO `tblroom` (`id`, `room_name`, `type`, `price`, `bed_type`, `max_occupancy`, `description`, `short_description`, `image_01`, `image_02`, `image_03`, `status`, `created_at`) VALUES
(1, 'Sunflower - 01', 'Deluxe', 12500.00, 'Double', 4, 'qweqweq eqeqweqweqew qeqweqeqeqeqeqe qeqweqw eqeqeqeqeq eqewqeqeqewqweqweq eqwewqqe  qeqeqeqeq eqeqeqeqwe', 'This deluxe double room offers a luxurious stay with elegant decor and modern amenities. Perfect for couples or friends, it provides a comfortable and spacious environment for relaxation. Price: Rs. 12,500 per night.', '../assets/images/room1/living.avif', '../assets/images/room1/kitchen.avif', '', 'Repair', '2025-05-11 08:47:11'),
(2, 'Rose - 01', 'Standard', 6700.00, 'Single', 1, 'pew pew pew pew pew pew pew pew pew pew pew pew pew pew pew pew pew pewpew pew pewpew pew pewpew pew pew pew pew pew', 'A cozy standard single room ideal for solo travelers. It features all essential amenities to ensure a pleasant stay, with a warm and inviting atmosphere. Price: Rs. 6,700 per night.', '../assets/images/rose1/living.avif', '../assets/images/rose1/out.avif', NULL, 'Booked', '2025-05-11 16:18:05'),
(3, 'Orchid - 02', 'Family', 13200.00, 'King', 6, 'Orchid - 02 is designed to provide a relaxing and enjoyable stay for families. The room is equipped with a plush king-sized bed, modern amenities, and tasteful decor. Guests can unwind in the tranquil atmosphere and enjoy the comfort and convenience offered by this well-appointed room. Ideal for families seeking a blend of luxury and comfort during their stay.', 'This family king room is designed for families seeking comfort and space. It boasts a king-sized bed and ample room for everyone to unwind. Price: Rs. 13,200 per night.', '../assets/images/orchid2/front.avif', '../assets/images/orchid2/bed.avif', '../assets/images/orchid2/bath.avif', 'Available', '2025-05-13 16:17:02'),
(8, 'Jasmin - 01', 'Family', 9300.00, 'King', 7, 'This is a long description', 'This is a short description', '', '', '', 'Booked', '2025-05-18 18:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `is_activated` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `email`, `password`, `role`, `is_activated`, `created_at`) VALUES
(3, 'poorna@gmail.com', '$2y$10$0spdyAr6JpOtXZ9Fdr2LwOfM9/JoYm6CtTpRZjPc0qE.sSpO2e15C', 'customer', 1, '2025-05-10 17:30:43'),
(4, 'arosha@gmail.com', '$2y$10$fsu0KRESjuYkDSJzpsl1OOpXRd9LJt5JjTLDLwxR/AD/oiSUM3dQy', 'customer', 1, '2025-05-18 13:30:00'),
(12, 'admin1234@gmail.com', '$2y$10$pyp12zSpeGgQEmNJa9NjoeBwG/ir3MEsaharaWJUIWeL643cxyYhS', 'admin', 1, '2025-05-26 17:44:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nic_number` (`nic_number`);

--
-- Indexes for table `tblreservation`
--
ALTER TABLE `tblreservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cus_id` (`customer_id`),
  ADD KEY `fk_room_id` (`room_id`);

--
-- Indexes for table `tblroom`
--
ALTER TABLE `tblroom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_name` (`room_name`) USING BTREE;

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblreservation`
--
ALTER TABLE `tblreservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblroom`
--
ALTER TABLE `tblroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `tblreservation` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`id`);

--
-- Constraints for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tblreservation`
--
ALTER TABLE `tblreservation`
  ADD CONSTRAINT `fk_cus_id` FOREIGN KEY (`customer_id`) REFERENCES `tblcustomer` (`user_id`),
  ADD CONSTRAINT `fk_room_id` FOREIGN KEY (`room_id`) REFERENCES `tblroom` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
