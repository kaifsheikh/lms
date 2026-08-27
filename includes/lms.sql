-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2026 at 12:02 PM
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
(6, 'Python batch 1', '2026-08-01', '5:00 - 7:00', 8, 'approved', '2026-08-25 09:02:21'),
(8, 'Web Development', '2026-08-18', '6:00 - 8:00', 8, 'approved', '2026-08-25 09:05:19'),
(9, 'Python batch 1', '2026-08-05', '5:00 - 7:00', 9, 'approved', '2026-08-25 09:09:15');

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
(3, 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime NOT NULL,
  `timer` int(11) NOT NULL COMMENT 'Duration in minutes',
  `passing_marks` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `teacher_id`, `batch_id`, `title`, `description`, `due_date`, `timer`, `passing_marks`, `created_at`) VALUES
(3, 9, 9, 'Loops', 'Sample', '2026-08-30 14:44:00', 20, 30, '2026-08-25 09:27:45');

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
(6, 'STU-B41A0D', 'Muhammad Dayan Shaikh', 'Muhammad Saeed', '34345445454', 'male', '2004-05-29', 'Pakistan Hyderabad , 17000', 'dayan@gmail.com', '$2y$10$rCkvVWZ.t0./CMiDXkr7redCBstfcNhTscToqsaNbzYwHRlbR.tYm', '2026-08-25', 'Python', '5-7', '3', 'stu_6a8d58db412271.36132280.png', 'cnic_6a8d58db417740.35716088.jpeg', 'intermediate', 'active', 9, '2026-08-25 08:56:59');

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
(6, 'Admin 1', 'admin1@gmail.com', '$2y$10$4X4skmN/IVbJ5EWy4QJkB.e4Q8Y/DYY0H4eRKXSrCosKeu2A0UMpS', '03108422790', 'admin', 'approved', '2026-08-25 08:23:30'),
(7, 'Admin 2', 'admin2@gmail.com', '$2y$10$g4X3nm6eidb7pDX/gUi/aeFFwVGcVENAc7s7zcjIfuavl7Mu0lLBe', '23457643', 'admin', 'rejected', '2026-08-25 08:24:21'),
(8, 'Muhammad Kaif Shaikh', 'shahkaif327@gmail.com', '$2y$10$5i22KxmLSQmqZrJVNyUIkOybU.9/WwEZUbTJ4kHP0XRv5AhsMhuSq', '03108422790', 'teacher', 'approved', '2026-08-25 08:29:11'),
(9, 'Arham', 'arham@gmail.com', '$2y$10$r6.KhCE0O0n7icZQVkqpC.6IN/gyW1.VtSNEFYR8MTPXOQpr2fs3y', '03108422790', 'teacher', 'approved', '2026-08-25 08:42:27'),
(10, 'Tahir Khan', 'hr@gmail.com', '$2y$10$TrcZ263D.bjkCDUaWn7PjOdmXSpyozwOW0L8BDB4jmLRVhwk6Q1ku', '3574584378', 'accountant', 'approved', '2026-08-25 08:45:23');

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
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `batch_id` (`batch_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `batch_students`
--
ALTER TABLE `batch_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
