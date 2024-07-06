-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 05:32 PM
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
-- Database: `api_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ret`
--

CREATE TABLE `ret` (
  `id` int(11) NOT NULL,
  `ref` text NOT NULL,
  `exp_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ret`
--

INSERT INTO `ret` (`id`, `ref`, `exp_at`) VALUES
(5, '5db4c30f5d882fb5bf11ba14b6f669a9d134a02e362b4ad628c1629296830a79', 1720711653),
(6, '7ff39b4e09541834f8943e560c99cd07db27174d531b4d549ff15e4710e9eba8', 1720711689),
(9, 'ce6c06dba85b555191420b7e84218afd210a27cc6c3cb19d9a0b4766293a627a', 1720711923);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `month` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `age`, `month`, `user_id`) VALUES
(3, 'samy', 33, 1, 0),
(4, 'samy', NULL, 1, 0),
(5, 'samy', NULL, NULL, 1),
(6, 'jo', NULL, NULL, 0),
(7, 'jo', 4, NULL, 0),
(8, 'jo', 4, 0, 0),
(9, 'ss', 2, 0, 0),
(10, 'ddd', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` text NOT NULL,
  `api_key` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `api_key`, `name`) VALUES
(1, 'doc5', '$2y$10$NwDL77kOFs.xpuahMUt0M.UIYQZ1yDYfkU1UFh829b8/3JEUDHzma', '6280e73800a9bee9a62d577387214c16', 'yousef ahmed'),
(2, 'weas', '$2y$10$VVFwvRYPDhyvxV0ku4cLMOdokm76iTkrWos6LIxeQclctc/mf/0Y.', '6d07988fd4cce532ee7b7774bf208ce4', 'samy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ret`
--
ALTER TABLE `ret`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
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
-- AUTO_INCREMENT for table `ret`
--
ALTER TABLE `ret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
