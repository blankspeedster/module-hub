-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2022 at 01:22 AM
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
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `user_id`, `subject_id`, `section_id`) VALUES
(10, 6, 1, 3),
(11, 6, 2, 3),
(12, 6, 3, 3),
(13, 9, 1, 3),
(14, 9, 2, 3),
(15, 9, 3, 3),
(16, 8, 1, 3),
(17, 8, 2, 3),
(18, 8, 3, 3),
(19, 10, 1, 1),
(20, 10, 2, 1),
(21, 10, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(12) NOT NULL,
  `module_name` varchar(128) NOT NULL,
  `user_id` int(12) NOT NULL,
  `subject_id` int(12) NOT NULL,
  `section_id` int(11) NOT NULL,
  `teacher_id` int(12) NOT NULL,
  `count_week` int(12) NOT NULL,
  `returned` tinyint(1) NOT NULL DEFAULT 0,
  `code_unique` text DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `module_name`, `user_id`, `subject_id`, `section_id`, `teacher_id`, `count_week`, `returned`, `code_unique`, `updated_at`) VALUES
(121, 'Sample Module', 6, 1, 3, 3, 1, 1, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(122, 'Sample Module', 6, 2, 3, 3, 1, 1, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(123, 'Sample Module', 6, 3, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(124, 'Sample Module', 9, 1, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(125, 'Sample Module', 9, 2, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(126, 'Sample Module', 9, 3, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(127, 'Sample Module', 8, 1, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(128, 'Sample Module', 8, 2, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(129, 'Sample Module', 8, 3, 3, 3, 1, 0, 'SampleModule-3-3', '2022-03-23 22:52:25'),
(139, ' Sample Module naman itong isa', 10, 1, 1, 3, 1, 0, 'SampleModulenamanitongisa-3-1', '2022-03-23 23:23:40'),
(140, ' Sample Module naman itong isa', 10, 2, 1, 3, 1, 0, 'SampleModulenamanitongisa-3-1', '2022-03-23 23:23:40'),
(141, ' Sample Module naman itong isa', 10, 3, 1, 3, 1, 0, 'SampleModulenamanitongisa-3-1', '2022-03-23 23:23:40'),
(151, ' Sample Module for week 2', 6, 1, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(152, ' Sample Module for week 2', 6, 2, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(153, ' Sample Module for week 2', 6, 3, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(154, ' Sample Module for week 2', 9, 1, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(155, ' Sample Module for week 2', 9, 2, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(156, ' Sample Module for week 2', 9, 3, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(157, ' Sample Module for week 2', 8, 1, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(158, ' Sample Module for week 2', 8, 2, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23'),
(159, ' Sample Module for week 2', 8, 3, 3, 3, 2, 0, 'SampleModuleforweek2-3-3', '2022-03-24 07:51:23');

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
  `teacher_id` int(12) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `grade`, `section`, `teacher_id`) VALUES
(1, 1, 'Section A', 3),
(2, 1, 'Section B', 3),
(3, 1, 'Section C', 3),
(4, 1, 'Section D', 2);

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
(1, 'math', 'Mathematics', 1),
(2, 'science', 'Science', 1),
(3, 'english', 'English', 1);

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
(6, 'Chris', 'Tian', 'student', '09000000000', '$2y$10$7MzU5dDzh3gAHL8cY9lCeeT8sHtxSnXk5VmnGidIDWa76k2J.kUfq', 2, 1),
(7, 'admin', 'admin', 'admin', '3123213', '$2y$10$7MzU5dDzh3gAHL8cY9lCeeT8sHtxSnXk5VmnGidIDWa76k2J.kUfq', 1, 1),
(8, 'Karlo', 'Sotto', 'karlo@sotto.com', 'phone_number', '$2y$10$sKrez0puwDGOGiVXsghNFebNysBrBVAmqT5A2/lSm7gyS0YizxN1O', 2, 1),
(9, 'Another', 'Student', 'another@another.com', 'phone_number', '$2y$10$S2BGUfYt5y6qrYz7suVSueNM9BMI.8.A6/jV4Lrn4o3KWageq1xsu', 2, 1),
(10, 'Eilela', 'Vergara', 'eilela@gmail.com', 'phone_number', '$2y$10$AQ/yMMnWSRcnrvd7fVHLVe5mq86/wTBFTdCA9NNxctFuM1AfColGy', 2, 1);

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
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
