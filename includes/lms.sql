-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2026 at 10:37 AM
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
(2, 29, 39, '2026-09-04', 'absent', 13, '2026-09-05 11:20:55'),
(3, 29, 41, '2026-09-04', 'present', 13, '2026-09-05 11:20:55'),
(4, 29, 40, '2026-09-04', 'present', 13, '2026-09-05 11:20:55'),
(5, 29, 39, '2026-09-03', 'present', 13, '2026-09-05 11:21:12'),
(6, 29, 41, '2026-09-03', 'present', 13, '2026-09-05 11:21:12'),
(7, 29, 40, '2026-09-03', 'present', 13, '2026-09-05 11:21:12'),
(8, 29, 39, '2026-09-01', 'late', 13, '2026-09-05 11:21:28'),
(9, 29, 41, '2026-09-01', 'late', 13, '2026-09-05 11:21:28'),
(10, 29, 40, '2026-09-01', 'present', 13, '2026-09-05 11:21:28'),
(11, 29, 39, '2026-09-02', 'leave', 13, '2026-09-05 11:22:07'),
(12, 29, 41, '2026-09-02', 'leave', 13, '2026-09-05 11:22:07'),
(13, 29, 40, '2026-09-02', 'leave', 13, '2026-09-05 11:22:07'),
(14, 29, 39, '2026-08-03', 'present', 13, '2026-09-05 11:26:12'),
(15, 29, 41, '2026-08-03', 'present', 13, '2026-09-05 11:26:12'),
(16, 29, 40, '2026-08-03', 'present', 13, '2026-09-05 11:26:12');

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
(29, 'Web Development', '2026-09-04', '5:00 - 7:00', 13, 'approved', '2026-09-04 18:33:59'),
(30, 'Web Development', '2026-09-04', '5:00 - 7:00', 11, 'approved', '2026-09-04 18:34:10');

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
(31, 29, 41),
(33, 29, 39),
(35, 29, 40);

-- --------------------------------------------------------

--
-- Table structure for table `class_attendance`
--

CREATE TABLE `class_attendance` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('present','absent','late') DEFAULT 'present',
  `marked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_attendance`
--

INSERT INTO `class_attendance` (`id`, `class_id`, `student_id`, `status`, `marked_at`) VALUES
(5, 12, 40, 'present', '2026-09-05 12:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in months',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admission_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `skill_level` varchar(50) NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `class_hours` varchar(50) NOT NULL,
  `outline` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `duration`, `created_at`, `admission_fee`, `total_price`, `skill_level`, `schedule`, `class_hours`, `outline`) VALUES
(7, 'Web Development', 6, '2026-09-04 18:22:25', '3000.00', '50000.00', 'Intermediate', 'Monday - Friday', '2', 'Your query \"html css or js outlines\" can mean two entirely different things depending on your current context. Because of this ambiguity, both possibilities are outlined below so you can find exactly what you need.\r\n\r\nOption 1: The technical CSS outline property (how to visually draw lines around elements).\r\n\r\nOption 2: A learning/course curriculum outline for HTML, CSS, and JavaScript.\r\n\r\ndo not take up space in the layout. They sit on top of the content and do not change the width or height of the element. [1] (https://www.w3schools.com/css/css_outline.asp)'),
(8, 'AI', 3, '2026-09-04 18:25:15', '3000.00', '20000.00', 'Intermediate', 'Monday - Friday', '2', 'Get perfectly structured outlines with clear argument progression and smooth transitions. Manus creates logical flow from introduction to conclusion, ensuring each point builds naturally toward your thesis with coherent reasoning and persuasive organization.\r\n\r\nManus automatically searches and integrates credible academic sources into your outline. Our AI identifies relevant research papers, statistics, and expert opinions, then seamlessly weaves evidence into your structure for stronger, fact-based arguments.'),
(9, 'Trading', 1, '2026-09-07 12:35:34', '10000.00', '10000.00', 'Intermediate', 'Monday - Friday', '2', 'A trading outline is a structured blueprint that defines your trading style, risk rules, market analysis methods, and personal goals. [1] (https://www.scribd.com/document/849560848/Trading-Plan-Outline-SAM)');

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_month` varchar(50) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `student_id`, `amount_paid`, `payment_date`, `payment_month`, `remarks`, `created_at`) VALUES
(1, 41, '6000.00', '2026-09-07', 'September', 'Late Fee', '2026-09-07 11:06:43'),
(2, 39, '6000.00', '2026-08-14', 'August 2026', 'late', '2026-09-07 11:16:55'),
(3, 40, '7000.00', '2026-07-15', 'July 2026', 'Paid', '2026-09-07 11:28:55'),
(4, 40, '5000.00', '2026-10-07', 'October 2026', 'Extra Paid', '2026-09-07 11:30:02'),
(5, 40, '8000.00', '2026-09-07', 'September 2026', 'Complete paid', '2026-09-07 11:32:23'),
(6, 40, '5000.00', '2026-09-10', 'September 2026', 'asdf', '2026-09-07 11:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `online_classes`
--

CREATE TABLE `online_classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meet_link` text NOT NULL,
  `token` varchar(20) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('scheduled','live','completed','cancelled') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_classes`
--

INSERT INTO `online_classes` (`id`, `teacher_id`, `batch_id`, `title`, `meet_link`, `token`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(12, 13, 29, 'asdf', 'https://meet.google.com/byr-ysua-tjc', '22594C3C', '2026-09-05 17:14:00', '2026-09-05 17:17:00', 'scheduled', '2026-09-05 12:14:48');

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
(39, 'STU-34099B', 'Dayan', 'Saaed', '938495843', 'male', '2010-10-04', 'Pakistan Hyderabad , 17000', 'dayan@gmail.com', '$2y$10$X2Vsehw4lRwfe8bVSX7Caelq.68TeKm.TJpQ50vhGYiJ/2YQzeFki', '2026-09-04', 'AI', '5-7', '3', 'stu_6a9b10634069e9.41854669.jpg', 'cnic_6a9b1063407ec8.86186328.jpg', 'matric', 'active', 13, '2026-09-04 18:39:31'),
(40, 'STU-38C0B1', 'hamza', 'saleem', '23456754', 'male', '1998-10-13', 'Pakistan Hyderabad , 17000', 'hamza@gmail.com', '$2y$10$CvCQDo./BytYp7RA.7E9Nex/jwjm6sCWHm/EDzU46HOjKegbs3DTy', '2026-09-08', 'AI', '6-8', '3', 'stu_6a9b10a38bc843.27053424.jpg', 'cnic_6a9b10a38be5e3.86839255.jpeg', 'undergraduate', 'active', 13, '2026-09-04 18:40:35'),
(41, 'STU-D5DBD4', 'faizan', 'kaleem', '4567654356', 'male', '2003-10-13', 'Pakistan Hyderabad , 17000', 'faizan@gmail.com', '$2y$10$Is6Inv.VIYeVQ/udaeSep.pX5.sMSKTnvZHZZZPsuAScLWNhD.n5i', '2026-08-11', 'AI', '4-6', '3', 'stu_6a9b10ed5d8263.21729326.jpg', 'cnic_6a9b10ed5d9d90.26112328.jpeg', 'postgraduate', 'active', 13, '2026-09-04 18:41:49');

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
(11, 'Muhammd Kaif Shaikh', 'shahkaif327@gmail.com', '$2y$10$6bti8Kvi16DZHOTIB.wTI.ybSl/c9nOTVlfO3ZV9xupESG/5PExDm', '03108422790', 'teacher', 'approved', '2026-09-02 01:48:42'),
(12, 'Admin', 'admin@gmail.com', '$2y$10$sh4NJSR6AjTN17nDL.WVEu3UpiJPGsnNBt0o1tZ45UQ3laTb0LzDS', '03108422790', 'admin', 'approved', '2026-09-02 01:49:38'),
(13, 'Arham', 'arham@gmail.com', '$2y$10$HfLjlU5awgQk48bZiIbyourpZaYd1M2PaCDrVU0qEva5ecOClVFDS', '23457643', 'teacher', 'approved', '2026-09-03 07:23:49');

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
-- Indexes for table `class_attendance`
--
ALTER TABLE `class_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_class_student` (`class_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `online_classes`
--
ALTER TABLE `online_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `batch_id` (`batch_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `batch_students`
--
ALTER TABLE `batch_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `class_attendance`
--
ALTER TABLE `class_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `online_classes`
--
ALTER TABLE `online_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_attempt_history`
--
ALTER TABLE `quiz_attempt_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- Constraints for table `class_attendance`
--
ALTER TABLE `class_attendance`
  ADD CONSTRAINT `class_attendance_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `online_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD CONSTRAINT `fee_payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `online_classes`
--
ALTER TABLE `online_classes`
  ADD CONSTRAINT `online_classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_classes_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE;

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
