-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2022 at 01:33 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `modulehub_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `returned` int(1) DEFAULT 0,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `user_id`, `subject_id`, `returned`, `section_id`) VALUES
(1, 6, 1, 0, 1),
(2, 6, 2, 0, 1),
(3, 6, 3, 0, 1),
(4, 8, 1, 0, 1),
(5, 8, 1, 0, 1),
(6, 8, 1, 0, 1),
(7, 9, 1, 0, 1),
(8, 9, 2, 0, 1),
(9, 9, 3, 0, 1),
(10, 14, 3, 0, 1),
(11, NULL, 3, 0, 1),
(12, NULL, 3, 0, 1),
(13, 13, 1, 0, 1),
(14, 13, 2, 0, 1),
(15, 13, 3, 0, 1),
(16, 13, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `code`, `description`) VALUES
(1, 'admin', 'admin for the whole app that over see everything'),
(2, 'student', 'student role'),
(3, 'teacher', 'teacher role');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `grade` int(3) NOT NULL,
  `section` varchar(32) NOT NULL,
  `teacher_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `grade`, `section`, `teacher_id`) VALUES
(1, 0, 'Section A', 3),
(2, 0, 'Section B', 15),
(3, 0, 'Section A', 3),
(4, 0, 'Section D', 15);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `grade` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `description`, `grade`) VALUES
(1, 'colors', 'Colors', 0),
(2, 'numbers', 'Numbers', 0),
(3, 'alphabets', 'Alphabets', 0),
(4, 'shapes', 'Shapes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(256) DEFAULT NULL,
  `lastname` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone_number` varchar(12) DEFAULT '09000000000',
  `password` varchar(128) DEFAULT NULL,
  `role` int(12) DEFAULT NULL,
  `validated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone_number`, `password`, `role`, `validated`) VALUES
(2, 'Customer', 'Customer', 'customer@customer.com', '09000000000', '$2y$10$BdUqRZaToAd9wzkoRyNJXeAY0N0loJLk4GKFnBMaXaXa7/mXCjMKW', 1, 1),
(3, 'Teacher', 'Teacher', 'teacher', '09000000000', '$2y$10$7MzU5dDzh3gAHL8cY9lCeeT8sHtxSnXk5VmnGidIDWa76k2J.kUfq', 3, 1),
(6, 'Chris', 'Tian', 'tian@tian.com', '09000000000', '$2y$10$5xxKAXXvHSjwP3chIEZzY.1QeEpkHfBFCmvs9ZYvznSA6aIQSuohS', 2, 1),
(7, 'admin', 'admin', 'admin', '3123213', '$2y$10$7MzU5dDzh3gAHL8cY9lCeeT8sHtxSnXk5VmnGidIDWa76k2J.kUfq', 1, 1),
(8, 'Karlo', 'Sotto', 'karlo@sotto.com', 'phone_number', '$2y$10$7MzU5dDzh3gAHL8cY9lCeeT8sHtxSnXk5VmnGidIDWa76k2J.kUfq', 2, 1),
(9, 'Another', 'Student', 'another@another.com', 'phone_number', '$2y$10$S2BGUfYt5y6qrYz7suVSueNM9BMI.8.A6/jV4Lrn4o3KWageq1xsu', 2, 0),
(13, '123', '123', 'sample@sample.com123123123', 'phone_number', '$2y$10$61kvljnpXWwz2fVlkPkwMOwv4HRnnmwa/hRSZ0Obk5WpvdnLZkCA2', 2, 0),
(14, 'Student', 'Student', 'student', 'phone_number', '$2y$10$VHfUT8f.0iQvFxiLgpVj1OaWD7vr0QcwcTeOpP8P/pBeJCEpvhtYa', 2, 1),
(15, 'Dave', 'Bacad', 'dave@bacad.com', 'phone_number', '$2y$10$5ZX4bs9fk.dlswpIbj6xPOFmzyoyOj0bn3GgXHZ2HQdm6RmEgKvey', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_index` (`user_id`,`subject_id`) USING BTREE,
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
