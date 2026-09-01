-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2026 at 09:28 AM
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
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','leave') NOT NULL,
  `marked_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `batch_id`, `student_id`, `date`, `status`, `marked_by`, `created_at`) VALUES
(1, 6, 6, '2026-08-27', 'present', 8, '2026-08-27 10:42:55'),
(4, 6, 6, '2026-08-26', 'absent', 8, '2026-08-27 11:11:24');

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
(9, 'Python batch 1', '2026-08-05', '5:00 - 7:00', 9, 'approved', '2026-08-25 09:09:15'),
(10, 'Web Development', '2026-08-19', '5:00 - 7:00', 9, 'pending', '2026-08-27 09:43:33'),
(11, 'Web Development', '2026-08-19', '5:00 - 7:00', 9, 'approved', '2026-08-27 09:43:56');

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
(7, 9, 6),
(8, 9, 7);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `status` enum('draft','active','closed') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `obtained_marks` int(11) NOT NULL DEFAULT 0,
  `total_marks` int(11) NOT NULL DEFAULT 0,
  `percentage` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt_history`
--

CREATE TABLE `quiz_attempt_history` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `attempt_date` datetime NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `status` enum('pass','fail') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_attempt_history`
--

INSERT INTO `quiz_attempt_history` (`id`, `teacher_id`, `student_id`, `student_name`, `quiz_title`, `attempt_date`, `percentage`, `status`, `created_at`) VALUES
(1, 9, 7, 'Ayesha', 'Functions and loops', '2026-08-28 13:33:21', '33.33', 'pass', '2026-08-28 08:33:21'),
(2, 9, 6, 'Muhammad Dayan Shaikh', 'Functions and loops', '2026-08-28 13:34:02', '100.00', 'pass', '2026-08-28 08:34:02');

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
(6, 'STU-B41A0D', 'Muhammad Dayan Shaikh', 'Muhammad Saeed', '34345445454', 'male', '2004-05-29', 'Pakistan Hyderabad , 17000', 'dayan@gmail.com', '$2y$10$rCkvVWZ.t0./CMiDXkr7redCBstfcNhTscToqsaNbzYwHRlbR.tYm', '2026-08-25', 'Python', '5-7', '3', 'stu_6a8d58db412271.36132280.png', 'cnic_6a8d58db417740.35716088.jpeg', 'intermediate', 'active', 9, '2026-08-25 08:56:59'),
(7, 'STU-1E6FE3', 'Ayesha', 'Bilal', '3295834', 'female', '2003-10-28', 'Pakistan Hyderabad , 17000', 'ayesha@gmail.com', '$2y$10$H..2wiV1CsDGsFwwhpwuIOBjZic6nk.cKN4AvK/LEBmp7DST6G8SS', '2026-08-26', 'Python', '5-7', '3', 'stu_6a913f81e691c5.68604419.png', 'cnic_6a913f81e6ce33.35960239.png', 'intermediate', 'active', 9, '2026-08-28 07:57:53');

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
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`batch_id`,`student_id`,`date`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `marked_by` (`marked_by`);

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
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attempt` (`quiz_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `quiz_attempt_history`
--
ALTER TABLE `quiz_attempt_history`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `batch_students`
--
ALTER TABLE `batch_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_attempt_history`
--
ALTER TABLE `quiz_attempt_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`marked_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
