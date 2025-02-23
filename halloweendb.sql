-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 12:33 AM
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
-- Database: `halloweendb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `type` varchar(50) NOT NULL,
  `is_safe` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `user_id`, `name`, `address`, `latitude`, `longitude`, `type`, `is_safe`, `created_at`) VALUES
(1, 1, 'Test Location', '1234 Pumpkin St, Halloween Town', 41.87810000, -87.62980000, '', 1, '2025-02-17 22:10:51'),
(2, 3, 'Testing', '3028 N. Albany Ave. Chicago, Il, 60618', 41.93659150, -87.70538796, 'hotspot', 1, '2025-02-19 21:05:34'),
(3, 3, 'TEst', '3028 n albany ave. Chicago, Il, 60618', 41.93659150, -87.70538796, 'haunted', 1, '2025-02-19 21:10:08'),
(4, 3, 'TEst', '3028 n albany ave. Chicago, Il, 60618', 41.93659150, -87.70538796, 'decorations', 1, '2025-02-19 21:16:31'),
(5, 3, 'Testing', '3028 n albany ave. Chicago, Il, 60618', 41.93659150, -87.70538796, 'haunted', 1, '2025-02-21 01:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_type` enum('text','image','text_image','video') NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_type`, `content`, `image_url`, `video_url`, `created_at`) VALUES
(1, 1, 'text', 'wdsdw', NULL, '', '2025-02-15 21:34:05'),
(2, 1, 'image', '', 'uploads/img_67b109a071b720.30744905.jpeg', '', '2025-02-15 21:39:44'),
(3, 1, 'text', '', '', '', '2025-02-15 21:47:44'),
(4, 1, 'text', '', '', '', '2025-02-15 21:47:47'),
(5, 1, 'text', 'test post', '', '', '2025-02-15 21:51:10'),
(6, 1, 'image', '', 'uploads/img_67b10c5643002.png', '', '2025-02-15 21:51:18'),
(7, 1, 'text_image', 'text and pic', 'uploads/img_67b10c725741b.jpeg', '', '2025-02-15 21:51:46'),
(8, 1, 'video', '', '', 'http://link.com', '2025-02-15 21:51:54'),
(9, 1, 'text', 'test', '', '', '2025-02-15 21:56:11'),
(10, 1, 'text', 'post test!', '', '', '2025-02-16 02:08:44'),
(11, 1, 'image', '', 'uploads/img_67b148b71562b.jpeg', '', '2025-02-16 02:08:55'),
(12, 1, 'text', 'qwertrewq', '', '', '2025-02-16 02:10:49'),
(13, 1, 'image', '', 'uploads/img_67b14dcb34141.png', '', '2025-02-16 02:30:35'),
(14, 2, 'video', '', '', 'https://www.youtube.com/watch?v=jj6vu7sG3XE', '2025-02-16 02:32:21'),
(15, 1, 'video', '', '', 'https://www.youtube.com/watch?v=jj6vu7sG3XE', '2025-02-16 04:41:29'),
(16, 1, 'image', '', 'uploads/img_67b16c99a947a.png', '', '2025-02-16 04:42:01'),
(17, 1, 'image', '', 'uploads/img_67b173c807a4e.jpeg', '', '2025-02-16 05:12:40'),
(18, 1, 'image', '', 'uploads/img_67b175233de1f.png', '', '2025-02-16 05:18:27'),
(20, 1, 'text', 'wwdwdwd', '', '', '2025-02-16 06:02:41'),
(21, 1, 'image', '', 'uploads/img_67b1816e85e96.png', '', '2025-02-16 06:10:54'),
(40, 1, 'text', 'wasdwwa', '', '', '2025-02-17 04:53:20'),
(41, 1, 'text', '', 'uploads/1739768065_5_banner_1739598332_background.png', '', '2025-02-17 04:54:25'),
(42, 1, 'text', '', 'uploads/1739769893_5_banner_1739598301_default-banner.jpg', '', '2025-02-17 05:24:53'),
(43, 3, 'text', 'testing', '', '', '2025-02-17 16:39:27'),
(44, 3, 'text', 'testing', '', '', '2025-02-17 16:39:30'),
(45, 3, 'image', 'testing', 'uploads/img_67b3664929b0f.png', '', '2025-02-17 16:39:37'),
(46, 3, 'image', 'testing', 'uploads/img_67b36649dd50c.png', '', '2025-02-17 16:39:37'),
(47, 3, 'image', 'testing', 'uploads/img_67b3664a2a78f.png', '', '2025-02-17 16:39:38'),
(48, 3, 'image', 'testing', 'uploads/img_67b3664a6cdfa.png', '', '2025-02-17 16:39:38'),
(49, 3, 'image', 'testing', 'uploads/img_67b3664aa5b8c.png', '', '2025-02-17 16:39:38'),
(50, 3, 'image', 'testing', 'uploads/img_67b3664adc8ad.png', '', '2025-02-17 16:39:38'),
(51, 3, 'image', 'testing', 'uploads/img_67b3664b29991.png', '', '2025-02-17 16:39:39'),
(52, 3, 'image', 'testing', 'uploads/img_67b3664b5a329.png', '', '2025-02-17 16:39:39'),
(53, 3, 'image', 'testing', 'uploads/img_67b3664cb7334.png', '', '2025-02-17 16:39:40'),
(54, 3, 'text', 'wwdwa', '', '', '2025-02-17 16:40:23'),
(55, 3, 'text', '', 'uploads/1739810467_5_banner_1739604671_anguiano-family-staten-island-over-the-top-halloween-decor-4 copy.png', '', '2025-02-17 16:41:07'),
(56, 3, 'text', 'wdwasdwasdw', 'uploads/1740013761_BistecConPapas.jpg', '', '2025-02-20 01:09:21'),
(58, 3, 'text', 'wdasdw', '', '', '2025-02-20 02:29:47'),
(59, 3, 'text', '', 'uploads/1740018593_beverages.jpg', '', '2025-02-20 02:29:53'),
(100, 3, 'text', 'This is a test post.', NULL, NULL, '2025-02-22 21:42:00'),
(101, 3, 'text', 'TEst', '', '', '2025-02-22 22:02:32'),
(102, 3, 'text', '', 'uploads/1740261764_anguiano-family-staten-island-over-the-top-halloween-decor-4 copy.png', '', '2025-02-22 22:02:44'),
(103, 3, 'text', '', '', 'https://www.youtube.com/watch?v=jj6vu7sG3XE', '2025-02-22 22:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`, `created_at`) VALUES
(2, 8, 1, '2025-02-15 22:11:10'),
(3, 7, 1, '2025-02-15 22:14:43'),
(4, 6, 1, '2025-02-15 22:15:40'),
(5, 5, 1, '2025-02-15 22:17:57'),
(6, 4, 1, '2025-02-15 22:30:08'),
(7, 3, 1, '2025-02-15 22:40:38'),
(9, 1, 1, '2025-02-16 02:08:28'),
(21, 12, 2, '2025-02-16 02:32:11'),
(24, 9, 2, '2025-02-16 02:33:18'),
(27, 12, 1, '2025-02-16 02:37:53'),
(30, 10, 1, '2025-02-16 03:21:29'),
(32, 14, 1, '2025-02-16 04:22:27'),
(34, 11, 1, '2025-02-16 04:29:10'),
(35, 13, 1, '2025-02-16 04:40:38'),
(36, 15, 1, '2025-02-16 04:41:30'),
(39, 18, 1, '2025-02-16 06:02:07'),
(40, 17, 1, '2025-02-16 06:02:33'),
(41, 20, 1, '2025-02-16 06:02:43'),
(42, 21, 1, '2025-02-16 06:10:57'),
(97, 41, 1, '2025-02-17 05:16:44'),
(98, 42, 1, '2025-02-17 16:27:41'),
(99, 53, 3, '2025-02-17 16:40:04'),
(101, 54, 3, '2025-02-20 01:02:45'),
(102, 56, 3, '2025-02-20 01:29:26'),
(103, 55, 3, '2025-02-20 01:49:16'),
(104, 59, 3, '2025-02-20 02:29:56'),
(105, 58, 3, '2025-02-20 02:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` text NOT NULL,
  `type` enum('post','comment') NOT NULL,
  `target_id` int(11) NOT NULL,
  `status` enum('pending','reviewed','resolved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `post_id`, `user_id`, `report_time`, `created_at`, `reason`, `type`, `target_id`, `status`) VALUES
(26, 47, 3, '2025-02-22 21:44:56', '2025-02-22 21:44:56', 'This is a test post', 'post', 0, 'pending'),
(29, 47, 3, '2025-02-22 21:57:00', '2025-02-22 21:57:00', 'This post is offensive.', 'post', 0, 'reviewed'),
(30, 42, 3, '2025-02-22 22:01:34', '2025-02-22 22:01:34', 'pic report', 'post', 0, 'reviewed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'assets/images/default-profile.png',
  `is_admin` tinyint(1) DEFAULT 0,
  `pumpkins` int(11) DEFAULT 0,
  `friends` int(11) DEFAULT 0,
  `passing_out_candy` tinyint(1) DEFAULT 0,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 1,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `banner` varchar(255) DEFAULT NULL,
  `banner_position` int(11) DEFAULT 0,
  `badges` text DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `profile_pic`, `is_admin`, `pumpkins`, `friends`, `passing_out_candy`, `avatar`, `bio`, `location`, `is_public`, `joined_at`, `banner`, `banner_position`, `badges`, `role`) VALUES
(1, 'MogaPapi', 'ramirez.moses81@gmail.com', '$2y$10$bKC21nnkZpsIPHvT.WSie.p1EOXD6CHF3c3EvGxzsh5inbQA.YhM.', '2025-02-15 21:33:49', 'uploads/1739765741_1_avatar_1739655532_Screenshot 2024-12-27 222507.png', 0, 0, 0, 1, '1_avatar_1739674791_Screenshot 2024-12-27 222507.png', 'This is a TEst Bio!', 'Chi-Town', 1, '2025-02-15 21:33:49', '1_banner_1739655532_anguiano-family-staten-island-over-the-top-halloween-decor-4 copy.png', 0, NULL, 'user'),
(2, 'Rambobrid', 'mogabienation@gmail.com', '$2y$10$snGZZrk72kzzRVSnpA6Gbujc0zxGHT..HpUFK1IwqU.Wm6WvGHbyC', '2025-02-16 02:31:59', 'assets/images/default-profile.png', 0, 0, 0, 0, NULL, NULL, NULL, 1, '2025-02-16 02:31:59', NULL, 0, NULL, 'user'),
(3, 'Monica', 'test@site.com', '$2y$10$G3orFxdXNkPTNlx6V6NVbu3v3tloAhj16uNnP.DJ.fuLMCz/hg9fS', '2025-02-17 16:39:17', '1739810969_5_avatar_Papis Kitchen Logo copy.png', 1, 0, 0, 1, NULL, 'This is a test Bio!', 'Chi-Town', 1, '2025-02-17 16:39:17', 'banner_3_1740264999.png', 50, NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`followed_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
