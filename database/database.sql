-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 12:36 AM
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
-- Database: `storemaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_05_195859_add_api_token_to_users', 1),
(5, '2025_12_05_204842_add_reset_code_to_users', 1),
(6, '2025_12_07_193345_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `description`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 14', 'Smartphones', 3999.00, 'Latest Apple smartphone.', 'https://share.google/y5mateUIHdt9KbzXc', NULL, '2025-12-07 19:52:10'),
(2, 'Samsung Galaxy S23', 'Smartphones', 3599.00, 'High-end Samsung smartphone.', 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcShrEMVGT7r6sjtpDN5P32vPPRXR_ceU4ksWHqRz6RZqQ3Q-WeGbnpy0SPxQwOgC1fWNxlcDJJGU12xiUm6Bzxunkt0PGZsdd8vPHMGD0jQlIxthYHs5hAm6A', NULL, '2025-12-07 19:53:11'),
(3, 'Sony WH-1000XM5', 'Headphones', 1499.00, 'Noise-canceling premium headphones.', 'https://example.com/sony.jpg', NULL, NULL),
(4, 'MacBook Air M2', 'Laptops', 4999.00, 'Apple MacBook with M2 chip.', 'https://example.com/macbook.jpg', NULL, NULL),
(5, 'Lenovo IdeaPad 3', 'Laptops', 2299.00, 'Affordable and powerful laptop.', 'https://example.com/lenovo.jpg', NULL, NULL),
(6, 'Canon EOS 250D', 'Cameras', 2899.00, 'DSLR camera for beginners.', 'https://example.com/canon.jpg', NULL, NULL),
(7, 'Apple AirPods Pro', 'Earbuds', 899.00, 'Noise-canceling wireless earbuds.', 'https://cdn.salla.sa/oRmZv/xe0p1Nw7F9tGJM0a49eVKgseDONkCv1WunzmI8ys.jpg', NULL, '2025-12-07 19:50:55'),
(8, 'Samsung 55\\\" 4K TV', 'Televisions', 2499.00, 'Smart 4K UHD TV.', 'https://example.com/samsungtv.jpg', NULL, NULL),
(9, 'JBL Charge 5', 'Speakers', 699.00, 'Portable Bluetooth speaker.', 'https://example.com/jbl.jpg', NULL, NULL),
(10, 'Dell UltraSharp Monitor', 'Monitors', 1599.00, '27-inch professional display.', 'https://example.com/dell.jpg', NULL, NULL),
(11, 'Logitech MX Master 3', 'Accessories', 399.00, 'Advanced wireless mouse.', 'https://example.com/logitech.jpg', NULL, NULL),
(12, 'Razer BlackWidow V3', 'Keyboards', 599.00, 'Mechanical gaming keyboard.', 'https://example.com/razer.jpg', NULL, NULL),
(13, 'Huawei Watch GT 3', 'Wearables', 899.00, 'Smart watch with health tracking.', 'https://example.com/huawei.jpg', NULL, NULL),
(14, 'Xiaomi Mi Band 7', 'Wearables', 199.00, 'Affordable fitness tracker.', 'https://example.com/miband.jpg', NULL, NULL),
(15, 'HP Smart Printer', 'Printers', 499.00, 'Wireless home printer.', 'https://example.com/hp.jpg', NULL, NULL),
(16, 'PlayStation 5', 'Gaming', 2499.00, 'Sony next-gen gaming console.', 'https://example.com/ps5.jpg', NULL, NULL),
(17, 'Xbox Series X', 'Gaming', 2399.00, 'Powerful Microsoft gaming console.', 'https://example.com/xbox.jpg', NULL, NULL),
(18, 'Nintendo Switch', 'Gaming', 1599.00, 'Portable + home gaming console.', 'https://example.com/switch.jpg', NULL, NULL),
(19, 'GoPro HERO 10', 'Cameras', 1699.00, 'Action camera for adventures.', 'https://example.com/gopro.jpg', NULL, NULL),
(20, 'Dyson V11 Vacuum', 'Home Appliances', 2199.00, 'Premium cordless vacuum cleaner.', 'https://example.com/dyson.jpg', NULL, NULL),
(23, 'iPhone 15', 'Smartphones', 4922.00, '128gb', 'https://imgs.dev-almanea.com/media//catalog/product/a/p/apple-iphone-15-1.jpg', '2025-12-07 20:30:36', '2025-12-07 20:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7mMJTzGYMhWcouYPk1yjx08oMP1u2mM3gB9zBpBQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlhLNU1wMW16azVpclBpR1JHVVpMMVZwek5KdzM0dWx3czR1YzlOTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3Jnb3QiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765150278);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reset_code` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `reset_code`, `api_token`) VALUES
(1, 'latifah', 'latifah@gmail.com', NULL, '$2y$12$6ueEwnFrEp9a1uHFwchmXuQX5ZZkoFjljceNLYiryP2.esHE5A2/C', NULL, '2025-12-07 16:52:44', '2025-12-07 20:29:38', NULL, '4dd2f649f95c59a58ac3c3072b0ceb929674e14d8b9b4372c1357d2fb8cafa52'),
(2, 'Nora', 'nora@gmail.com', NULL, '$2y$12$2.DlR.XStj2BImzvN2OOd.0fhgPAR7849hGf5Gt/5ha5qEYJY6W7a', NULL, '2025-12-07 19:30:36', '2025-12-07 19:45:34', NULL, 'c5693e9eda32e436b9e1f8ccb84373b5ed8114e86f49f4475030da4484826726'),
(3, 'lama', 'lama@gmail.com', NULL, '$2y$12$H5o.aoT.2dZYitaXI4OEYuFQrZiB4F02ClSR6MVnvfJ.CEHml9MAK', NULL, '2025-12-07 19:36:21', '2025-12-07 19:36:21', NULL, '53a9289dcc5edc1298ee59a9374638a037cad952129b61af0db1b610a44c8b8a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
