-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране: 15 дек 2024 в 16:37
-- Версия на сървъра: 10.4.28-MariaDB
-- Версия на PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `cosmetics_shop`
--

-- --------------------------------------------------------

--
-- Структура на таблица `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(12, 3, 3, 1),
(13, 3, 4, 1),
(14, 3, 5, 1),
(36, 4, 2, 1),
(48, 5, 4, 1),
(52, 5, 1, 1),
(53, 5, 2, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL COMMENT 'Първичен ключ',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `products`
--

INSERT INTO `products` (`id`, `title`, `image`, `price`) VALUES
(1, 'Хидратиращ крем', 'krem2.webp', 25.99),
(2, 'Шампоан с арганово масло', '\\31510-CHI-Argan-Oil-Shampoo-1000x1000-min-700x700.webp', 15.49),
(3, 'Балсам за устни', 's2743060-main-zoom.webp', 12.99),
(4, 'Анти-ейдж серум', '788870_1_20240212123551.webp', 45.00),
(5, 'Маска за коса', 'pdp_0006_HoliRoots-Hair-Mask.webp', 30.00);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `names`, `email`, `password`) VALUES
(1, 'Иван Иванов', 'ivan@example.com', '$argon2i$v=19$m=65536,t=4,p=1$randomhash$randomhash2'),
(2, 'Мария Петрова', 'maria@example.com', '$argon2i$v=19$m=65536,t=4,p=1$randomhash$randomhash3'),
(3, 'edno', 'edno@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$NEJrakdRdE15NE1GUm9qQw$UG7VciGRbm7g3oa+5K0CRtwn5HotsxOVCVNhmM8xHJ0'),
(4, 'edno', 'edno11@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$WkNobEcxSTl5dTBJMnJjaQ$Izht07YO4Jl8gosBj9PRleh/QTeRxSkI7zWmOBdUQ2Y'),
(5, 'p', 'p@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$UC42SXoxMS5OQVQuY2tGMQ$V4gB6Zu+jtQvM6Dm9DuRjVitLs4mNl5Q5EF+bupSbh8');

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`);

--
-- Индекси за таблица `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
