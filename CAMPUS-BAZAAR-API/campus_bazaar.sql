-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 01:57 AM
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
-- Database: `campus_bazaar`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `username`, `password`, `token`) VALUES
(1, 1, 'johndoe', 'hashed_password_1', NULL),
(2, 2, 'janedoe', 'hashed_password_2', NULL),
(3, 3, 'alice123', 'hashed_password_3', NULL),
(4, 4, 'bob456', 'hashed_password_4', NULL),
(5, 5, 'charlie789', 'hashed_password_5', NULL),
(7, 1, 'jhohndoe', '$2y$10$NTM5NDk0NGMwMWM3YWRiZeDxNYq2wy9skx/O7X2Lkkhln99PXb/fy', 'NmNjZDg5ODY4ZGM3M2U5MTE0MjFhMTVmNjBmM2M0MmE4YmZjNzdjMzFlMjdjZTVkYzg0ZDQ5OTgyZWUwOWY3Ng=='),
(8, 6, 'newuser', '$2y$10$ZjM0YWIxZjE3ZWYxM2IyZOkbFy.iJsp.PqiostvL5CnHlpMXpEphi', 'YWM0OTVjMjE4OTRiYjFkNmQxODExZWFlYWZkZDRiMDI3OGVhNmE2Y2I0OTBiYTFkZTk4YzdhYzYzNjVjMzJiNQ=='),
(10, 6, 'testing', '$2y$10$NTA4MTA4M2Y5ZmU5NjkyMe5Nll7SNVvdUIKc7Xa2DYS4CPAaBluMu', 'NzBjYjIyODYwYjNkZTcwYTY5NzVmM2I5MGFmMjg0OTU3Yjc4YTk2MWFjNDNiMTRmMzIxMWU4NmEyMDQyMWI1NQ=='),
(12, 6, 'testing222', '$2y$10$YzVmMjRlNjBmODE3ODAwYOJ1tcALUB7J2kUXF42a0KmXrHDy96Dyq', 'YjZmMjRkNjExNGMzNzIzOTkwYjg4NTVkOThiOGRjYTA2ZmRjZjc0OGVjZmMwMmQ1YTk2NWM5NmJjM2NkN2VjOQ=='),
(13, 6, 'ivan', '$2y$10$MmE0NzJjMGViZDYyYmQ4M.8OMP8KyVngFjxyUD99DcHaZERpgVlOS', 'OGM0MzlmZGUxMDJhM2Y0MzdjMDhiZGJmOWU3ZmQyMWYzMDk0MGE1YTI0NDIwMjYyYTlmNDI4ZGJkNzkxNjRmYQ==');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(337, ''),
(9, 'Books'),
(4, 'Clothing'),
(7, 'Dorm Supplies'),
(123, 'Elect'),
(2, 'Electronics'),
(3, 'Furniture'),
(333, 'gegib11berish'),
(33, 'gib11berish'),
(32, 'gibberish'),
(6, 'Home Appliances'),
(8, 'Sports Equipment'),
(53, 'test'),
(11, 'type'),
(336, 'Updated Category Name'),
(12, 'ysler');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `category`, `price`, `description`, `user_id`, `date_posted`) VALUES
(1, 'Introduction to Programming', 'Textbooks', 300.00, 'A textbook for beginner programming courses.', 2, '2024-12-09 05:39:44'),
(2, 'Laptop - Dell Inspiron', 'Electronics', 5000.00, 'Used Dell laptop in good condition, ideal for students.', 1, '2024-12-09 05:39:44'),
(3, 'Wooden Desk', 'Furniture', 1500.00, 'A solid wooden desk perfect for a dorm room.', 3, '2024-12-09 05:39:44'),
(4, 'Graphic Hoodie', 'Clothing', 800.00, 'Comfortable hoodie with a cool graphic design.', 4, '2024-12-09 05:39:44'),
(5, 'Notebook & Pen Set', 'Stationery', 100.00, 'A set of high-quality notebooks and pens for note-taking.', 5, '2024-12-09 05:39:44'),
(6, 'Microwave Oven', 'Home Appliances', 2500.00, 'A small microwave suitable for dorms.', 3, '2024-12-09 05:39:44'),
(7, 'Bed Sheet Set', 'Dorm Supplies', 500.00, 'A comfy bed sheet set for college dorm living.', 2, '2024-12-09 05:39:44'),
(8, 'Yoga Mat', 'Sports Equipment', 500.00, 'A high-quality yoga mat for your workout routine.', 1, '2024-12-09 05:39:44'),
(9, 'pencil', 'clothing', 33.00, 'hahahaha', NULL, '2024-12-09 22:37:55'),
(10, 'hotdog', 'essentials', 100.00, 'hehehehe', NULL, '2024-12-09 22:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `image_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`image_id`, `item_id`, `image_url`) VALUES
(1, 1, 'https://example.com/images/book.jpg'),
(2, 2, 'https://example.com/images/laptop.jpg'),
(3, 3, 'https://example.com/images/desk.jpg'),
(4, 4, 'https://example.com/images/hoodie.jpg'),
(5, 5, 'https://example.com/images/notebook.jpg'),
(6, 6, 'https://example.com/images/microwave.jpg'),
(7, 7, 'https://example.com/images/sheets.jpg'),
(8, 8, 'https://example.com/images/yoga_mat.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `recipient_id`, `content`, `date_sent`) VALUES
(1, 1, 2, 'Hi, is the laptop still available for sale?', '2024-12-09 05:40:00'),
(2, 3, 1, 'I am interested in buying the desk. Is it still available?', '2024-12-09 05:40:00'),
(3, 4, 5, 'Hey, I have some textbooks I want to sell. Are you interested?', '2024-12-09 05:40:00'),
(4, 2, 3, 'Could you send me more pictures of the bed sheet set?', '2024-12-09 05:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `item_id`, `buyer_id`, `seller_id`, `price`, `status`, `transaction_date`) VALUES
(1, 1, 4, 2, 300.00, 'completed', '2024-12-09 05:40:06'),
(2, 2, 3, 1, 5000.00, 'pending', '2024-12-09 05:40:06'),
(3, 3, 5, 3, 1500.00, 'completed', '2024-12-09 05:40:06'),
(4, 6, 4, 3, 2500.00, 'cancelled', '2024-12-09 05:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password_hash`, `date_joined`, `bio`, `is_active`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', 'hashed_password_1', '2024-12-09 05:39:37', 'I sell gadgets and textbooks.', 1),
(2, 'Jane', 'Smith', 'jane.12smith@gmail.com', 'hashed_password_123', '2024-12-09 05:39:37', 'An avid reader and book collector.', 1),
(3, 'Alice', 'Johnson', 'alice.johnson@example.com', 'hashed_password_3', '2024-12-09 05:39:37', 'Selling furniture for dorms and apartments.', 1),
(4, 'Bob', 'Brown', 'bob.brown@example.com', 'hashed_password_4', '2024-12-09 05:39:37', 'Looking for good deals on electronics and textbooks.', 1),
(5, 'Charlie', 'Adams', 'charlie.adams@example.com', 'hashed_password_5', '2024-12-09 05:39:37', 'Admin of the platform. Always available to help.', 1),
(9, 'John', 'Doe', 'johndoe@example.com', 'hashed_password_123', '2024-12-10 06:18:03', 'I sell electronics and gadgets.', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `items_ibfk_1` (`user_id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_images`
--
ALTER TABLE `item_images`
  ADD CONSTRAINT `item_images_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
