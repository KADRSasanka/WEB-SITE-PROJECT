-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 05:15 AM
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
-- Database: `xpressmart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@xpressmart.lk', '$2y$10$.GWfh0RPgG3a1OFL3J0LNO1scySXvAkd5XEOZbQ5AibzmtJ.dzMBq', '2025-09-17 03:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `status`, `created_at`) VALUES
(167, 'Household Materials', 'Images & Logos/s5.png', 'Cleaning supplies and household essentials', 'active', '2025-09-17 03:53:06'),
(194, 'Fruits & Vegetables', 'Images & Logos/s2.png', 'Fresh fruits and organic vegetables', 'active', '2025-09-17 03:55:40'),
(250, 'Dairy Products & Protein', 'Images & Logos/s4.png', 'Milk, cheese, yogurt and protein products', 'active', '2025-09-17 03:58:07'),
(255, 'Bakery Items & Cakes', 'Images & Logos/s3.png', 'Fresh baked goods and delicious cakes', 'active', '2025-09-17 04:01:42'),
(258, 'Processed Foods', 'Images & Logos/s6.png', 'Canned goods and processed food items', 'active', '2025-09-17 04:01:42'),
(277, 'Fish & Meat', 'Images & Logos/s1.png', 'Fresh fish and quality meat products', 'active', '2025-09-17 04:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(311, 'Salmon', 'Fish & Meat', 645.00, 50, 'Images & Logos/products/productPage/P1.png', '', 'active', '2025-09-17 18:05:10', '2025-09-17 18:05:10'),
(312, 'Chicken Breast', 'Fish & Meat', 1200.00, 50, 'Images & Logos/products/productPage/P2.png', '', 'active', '2025-09-17 18:06:16', '2025-09-17 18:06:16'),
(313, 'Mutton', 'Fish & Meat', 2300.00, 50, 'Images & Logos/products/productPage/P3.png', '', 'active', '2025-09-17 18:06:50', '2025-09-17 18:06:50'),
(314, 'Prawns', 'Fish & Meat', 1900.00, 50, 'Images & Logos/products/productPage/P4.png', '', 'active', '2025-09-17 18:07:17', '2025-09-17 18:07:17'),
(315, 'Beef Steak', 'Fish & Meat', 3200.00, 50, 'Images & Logos/products/productPage/P5.png', '', 'active', '2025-09-17 18:07:48', '2025-09-17 18:07:48'),
(317, 'Duck Meat', 'Fish & Meat', 4200.00, 50, 'Images & Logos/products/productPage/P7.png', '', 'active', '2025-09-17 18:09:22', '2025-09-17 18:09:22'),
(318, 'Crab', 'Fish & Meat', 2600.00, 50, 'Images & Logos/products/productPage/P8.png', '', 'active', '2025-09-17 18:09:46', '2025-09-17 18:09:46'),
(319, 'Strawberry', 'Fruits & Vegetables', 750.00, 50, 'Images & Logos/products/productPage/P9.png', '', 'active', '2025-09-17 18:10:14', '2025-09-17 18:10:14'),
(320, 'Grapes', 'Fruits & Vegetables', 1400.00, 50, 'Images & Logos/products/productPage/P10.png', '', 'active', '2025-09-17 18:10:39', '2025-09-17 18:10:39'),
(321, 'Apple', 'Fruits & Vegetables', 450.00, 50, 'Images & Logos/products/productPage/P11.png', '', 'active', '2025-09-17 18:11:57', '2025-09-17 18:11:57'),
(322, 'Banana', 'Fruits & Vegetables', 380.00, 50, 'Images & Logos/products/productPage/P12.png', '', 'active', '2025-09-17 18:12:37', '2025-09-17 18:12:37'),
(323, 'Pineapple', 'Fruits & Vegetables', 624.00, 50, 'Images & Logos/products/productPage/P13.png', '', 'active', '2025-09-17 18:13:07', '2025-09-17 18:13:07'),
(324, 'Pumkin', 'Fruits & Vegetables', 400.00, 50, 'Images & Logos/products/productPage/P14.png', '', 'active', '2025-09-17 18:13:31', '2025-09-17 18:13:31'),
(325, 'Tomato', 'Fruits & Vegetables', 140.00, 50, 'Images & Logos/products/productPage/P15.png', '', 'active', '2025-09-17 18:13:58', '2025-09-17 18:13:58'),
(326, 'Carrot', 'Fruits & Vegetables', 390.00, 50, 'Images & Logos/products/productPage/P16.png', '', 'active', '2025-09-17 18:14:29', '2025-09-17 18:14:29'),
(327, 'Muffin', 'Bakery Items & Cakes', 240.00, 50, 'Images & Logos/products/productPage/P17.png', '', 'active', '2025-09-17 18:14:58', '2025-09-17 18:14:58'),
(328, 'Cheese Cake', 'Bakery Items & Cakes', 620.00, 50, 'Images & Logos/products/productPage/P18.png', '', 'active', '2025-09-17 18:15:33', '2025-09-17 18:15:33'),
(329, 'Donut', 'Bakery Items & Cakes', 250.00, 50, 'Images & Logos/products/productPage/P19.png', '', 'active', '2025-09-17 18:15:58', '2025-09-17 18:15:58'),
(330, 'Chocolate Cake', 'Bakery Items & Cakes', 180.00, 50, 'Images & Logos/products/productPage/P20.png', '', 'active', '2025-09-17 18:16:22', '2025-09-17 18:16:22'),
(331, 'Mini Pizza', 'Bakery Items & Cakes', 300.00, 50, 'Images & Logos/products/productPage/P21.png', '', 'active', '2025-09-17 18:16:48', '2025-09-17 18:16:48'),
(332, 'Fish Roll', 'Bakery Items & Cakes', 120.00, 50, 'Images & Logos/products/productPage/P22.png', '', 'active', '2025-09-17 18:17:15', '2025-09-17 18:17:15'),
(333, 'Shawarma', 'Bakery Items & Cakes', 340.00, 50, 'Images & Logos/products/productPage/P23.png', '', 'active', '2025-09-17 18:17:45', '2025-09-17 18:17:45'),
(334, 'Hot Dog', 'Bakery Items & Cakes', 350.00, 50, 'Images & Logos/products/productPage/P24.png', '', 'active', '2025-09-17 18:18:16', '2025-09-17 18:18:16'),
(335, 'Cheese', 'Dairy Products & Protein', 1200.00, 50, 'Images & Logos/products/productPage/P25.png', '', 'active', '2025-09-17 18:18:42', '2025-09-17 18:18:42'),
(336, 'Yoghurt', 'Dairy Products & Protein', 70.00, 50, 'Images & Logos/products/productPage/P26.png', '', 'active', '2025-09-17 18:19:05', '2025-09-17 18:19:05'),
(337, 'Butter', 'Dairy Products & Protein', 960.00, 50, 'Images & Logos/products/productPage/P27.png', '', 'active', '2025-09-17 18:19:35', '2025-09-17 18:19:35'),
(338, 'Milk Powder', 'Dairy Products & Protein', 1200.00, 50, 'Images & Logos/products/productPage/P28.png', '', 'active', '2025-09-17 18:20:01', '2025-09-17 18:20:01'),
(339, 'Ice-Cream', 'Dairy Products & Protein', 495.00, 50, 'Images & Logos/products/productPage/P29.png', '', 'active', '2025-09-17 18:20:27', '2025-09-17 18:20:27'),
(340, 'Curd', 'Dairy Products & Protein', 680.00, 50, 'Images & Logos/products/productPage/P30.png', '', 'active', '2025-09-17 18:20:54', '2025-09-17 18:20:54'),
(341, 'Fresh Milk', 'Dairy Products & Protein', 600.00, 600, 'Images & Logos/products/productPage/P31.png', '', 'active', '2025-09-17 18:21:33', '2025-09-17 18:21:33'),
(342, 'Ghee', 'Dairy Products & Protein', 650.00, 50, 'Images & Logos/products/productPage/P32.png', '', 'active', '2025-09-17 18:21:58', '2025-09-17 18:21:58'),
(343, 'Dishwash Liquid', 'Household Materials', 425.00, 50, 'Images & Logos/products/productPage/P33.png', '', 'active', '2025-09-17 18:22:31', '2025-09-17 18:22:31'),
(344, 'Mop', 'Household Materials', 1300.00, 50, 'Images & Logos/products/productPage/P34.png', '', 'active', '2025-09-17 18:22:58', '2025-09-17 18:22:58'),
(345, 'Toilet Paper', 'Household Materials', 575.00, 50, 'Images & Logos/products/productPage/P35.png', '', 'active', '2025-09-17 18:23:31', '2025-09-17 18:23:31'),
(346, 'Broom', 'Household Materials', 950.00, 50, 'Images & Logos/products/productPage/P36.png', '', 'active', '2025-09-17 18:24:06', '2025-09-17 18:24:06'),
(347, 'Shampoo', 'Household Materials', 510.00, 50, 'Images & Logos/products/productPage/P37.png', '', 'active', '2025-09-17 18:24:32', '2025-09-17 18:24:32'),
(348, 'Soap Bar', 'Household Materials', 290.00, 50, 'Images & Logos/products/productPage/P38.png', '', 'active', '2025-09-17 18:24:58', '2025-09-17 18:24:58'),
(349, 'Toothpaste', 'Household Materials', 280.00, 50, 'Images & Logos/products/productPage/P39.png', '', 'active', '2025-09-17 18:25:25', '2025-09-17 18:25:25'),
(350, 'Washing Powder', 'Household Materials', 320.00, 50, 'Images & Logos/products/productPage/P40.png', '', 'active', '2025-09-17 18:25:54', '2025-09-17 18:25:54'),
(351, 'Energy Drink', 'Processed Foods', 750.00, 50, 'Images & Logos/products/productPage/P41.png', '', 'active', '2025-09-17 18:26:19', '2025-09-17 18:26:19'),
(352, 'Coca Cola', 'Processed Foods', 480.00, 50, 'Images & Logos/products/productPage/P42.png', '', 'active', '2025-09-17 18:26:54', '2025-09-17 18:26:54'),
(353, 'Iced Tea', 'Processed Foods', 230.00, 50, 'Images & Logos/products/productPage/P43.png', '', 'active', '2025-09-17 18:27:20', '2025-09-17 18:27:20'),
(354, 'Mineral Water', 'Processed Foods', 120.00, 50, 'Images & Logos/products/productPage/P44.png', '', 'active', '2025-09-17 18:27:48', '2025-09-17 18:27:48'),
(355, 'Corn Flakes', 'Processed Foods', 1250.00, 50, 'Images & Logos/products/productPage/P45.png', '', 'active', '2025-09-17 18:28:16', '2025-09-17 18:28:16'),
(356, 'Biscuit', 'Processed Foods', 130.00, 50, 'Images & Logos/products/productPage/P47.png', '', 'active', '2025-09-17 18:28:45', '2025-09-17 18:28:45'),
(357, 'Sugar', 'Processed Foods', 297.00, 50, 'Images & Logos/products/productPage/P48.png', '', 'active', '2025-09-17 18:29:07', '2025-09-17 18:29:22'),
(358, 'Tuna', 'Fish & Meat', 1990.00, 50, 'Images & Logos/products/productPage/P6.png', '', 'active', '2025-09-17 19:22:45', '2025-09-17 19:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_username` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_name`, `customer_username`, `rating`, `comment`, `profile_image`, `status`, `created_at`) VALUES
(4, 'Aseka Dissanayaka', '@dissanayakadman', 5, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam incidunt molestiae adipisci odio deleniti sapiente, totam praesentium in aut, commodi repellendus pariatur hic impedit numquam reprehenderit corrupti dolorum officiis consequatur!', '', 'active', '2025-09-17 18:32:51'),
(5, 'Manushi Athukorala', '@athukorlamp', 3, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam incidunt molestiae adipisci odio deleniti sapiente, totam praesentium in aut, commodi repellendus pariatur hic impedit numquam reprehenderit corrupti dolorum officiis consequatur!', '', 'active', '2025-09-17 18:33:14'),
(6, 'Geesith Kariyawasam', '@geesithkariyawasm', 4, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam incidunt molestiae adipisci odio deleniti sapiente, totam praesentium in aut, commodi repellendus pariatur hic impedit numquam reprehenderit corrupti dolorum officiis consequatur!', '', 'active', '2025-09-17 18:33:37'),
(7, 'Nisanasala Niroshani', '@niroshanidmn', 5, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam incidunt molestiae adipisci odio deleniti sapiente, totam praesentium in aut, commodi repellendus pariatur hic impedit numquam reprehenderit corrupti dolorum officiis consequatur!', '', 'active', '2025-09-17 18:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_name', 'Xpress Mart', '2025-09-17 03:44:06'),
(2, 'site_tagline', 'WHERE FRESHNESS MEETS VALUES', '2025-09-17 03:44:06'),
(3, 'site_description', 'We believe in bringing you the freshest ingredients and quality products. Explore our wide selection of farm-fresh fruits and vegetables, premium meats, and artisanal goods, all hand-picked for you.', '2025-09-17 03:44:06'),
(4, 'contact_email', 'info@xpressmart.lk', '2025-09-17 03:44:06'),
(5, 'contact_phone', '+94 77 123 4567', '2025-09-17 03:44:06'),
(6, 'store_address', 'Kandy, Central Province, Sri Lanka', '2025-09-17 03:44:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
