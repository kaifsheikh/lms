-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2026 at 12:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `starting_date` date NOT NULL,
  `batch_time` varchar(50) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `batch_name`, `starting_date`, `batch_time`, `teacher_id`, `status`, `created_at`) VALUES
(2, 'Python batch 1', '2026-08-11', '5:00 - 7:00', 2, 'approved', '2026-08-20 09:40:11'),
(3, 'Python batch 2', '2026-08-10', '3:00 - 5:00', 2, 'approved', '2026-08-20 09:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `batch_students`
--

CREATE TABLE `batch_students` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_students`
--

INSERT INTO `batch_students` (`id`, `batch_id`, `student_id`) VALUES
(9, 3, 3),
(10, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joining_date` date NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `class_timing` varchar(100) NOT NULL,
  `course_duration` varchar(50) NOT NULL,
  `student_pic` varchar(255) DEFAULT NULL,
  `cnic_pic` varchar(255) DEFAULT NULL,
  `highest_education` enum('intermediate','undergraduate','postgraduate','matric') NOT NULL,
  `status` enum('pending','process','active') NOT NULL DEFAULT 'pending',
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `full_name`, `father_name`, `contact_number`, `gender`, `dob`, `address`, `email`, `password`, `joining_date`, `course_name`, `class_timing`, `course_duration`, `student_pic`, `cnic_pic`, `highest_education`, `status`, `teacher_id`, `created_at`) VALUES
(2, 'STU-252F07', 'humza', 'asghar', '314352454', 'male', '2007-07-19', 'ISLAMABAD YUSRUB COLONY GULSHAN-E-QADIR SOCIETY HYDERABAD', 'hamza@gmail.com', '$2y$10$Q/2DPJEs1lXvYPEITvTreeCVo5IBeXexAgNAgaXZgLZ7OPilzOb/e', '2026-08-19', 'Python', '4-6', '3', 'stu_6a85bf3252cb14.66947807.webp', 'cnic_6a85bf3252dab1.05169370.jpeg', 'intermediate', 'active', 2, '2026-08-19 14:35:30'),
(3, 'STU-74CE4F', 'Muhammad Dayan', 'Muhammad Saeed', '1234567654', 'male', '2013-02-20', 'ISLAMABAD YUSRUB COLONY GULSHAN-E-QADIR SOCIETY HYDERABAD', 'dayan@gmail.com', '$2y$10$xqOXIVnR.9ylCe0dbM4pIe6WmY2POozwyhhXfIXAwjfYf/MAg0AYe', '2026-08-12', 'Python', '4-6', '3', 'stu_6a86bf574c9061.25881331.png', 'cnic_6a86bf574cbd98.68704077.webp', 'matric', 'active', 2, '2026-08-20 08:48:23'),
(4, 'STU-23DCBA', 'Muhammad Ahmed', 'Saleem', '234594835', 'male', '1995-03-02', 'Pakistan Hyderabad , 17000', 'ahmed@gmail.com', '$2y$10$ARZ5FeH4CCZMvfvEJrtmouTPMUyH6cNgf0uy0e0mDdRrue7eIYos.', '2026-08-11', 'Web Development', '5-7', '10', 'stu_6a86d1623d73c9.69891770.jpeg', 'cnic_6a86d1623da041.22007601.jpeg', 'undergraduate', 'active', 4, '2026-08-20 10:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `role` enum('admin','teacher','accountant') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `contact`, `role`, `status`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$RZS87u6Sl47o/qVTssQThui65O/9SnNMXDa.eJLdwHAD262OX5dSa', '03108422790', 'admin', 'approved', '2026-08-19 08:13:52'),
(2, 'Kaif Shaikh', 'kaif@gmail.com', '$2y$10$ZfiVEvspdBjV3C/rAbQLJOjgvT6d8wBtP7k7MMoSvUUQoaq68JmY2', '03108422790', 'teacher', 'approved', '2026-08-19 09:13:17'),
(3, 'Tahir', 'hr@gmail.com', '$2y$10$uXIHvvg9mEjPNBQmVGDtuuoWNkE648CRie50opgS8M7OFF4aft.8O', '3574584378', 'accountant', 'approved', '2026-08-19 13:02:34'),
(4, 'arham', 'arham@gmail.com', '$2y$10$IeaRxuX1xKhJ.rQHjZwwcuJ4Rbnsxod/Ku4EKjaUBN4bAKxndLTjy', '23457643', 'teacher', 'approved', '2026-08-19 14:36:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `batch_students`
--
ALTER TABLE `batch_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batch_students`
--
ALTER TABLE `batch_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `batch_students`
--
ALTER TABLE `batch_students`
  ADD CONSTRAINT `batch_students_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `batch_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
