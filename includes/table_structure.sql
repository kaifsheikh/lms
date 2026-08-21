-- =========================================================
-- DATABASE
-- =========================================================

CREATE DATABASE IF NOT EXISTS `lms`
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE `lms`;


-- =========================================================
-- TABLE: users
-- =========================================================

CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `full_name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `contact` varchar(20) NOT NULL,
    `role` enum('admin','teacher','accountant') NOT NULL,
    `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),

    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


-- =========================================================
-- TABLE: students
-- =========================================================

CREATE TABLE `students` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
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
    `highest_education` enum(
        'intermediate',
        'undergraduate',
        'postgraduate',
        'matric'
    ) NOT NULL,
    `status` enum('pending','process','active') NOT NULL DEFAULT 'pending',
    `teacher_id` int(11) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),

    PRIMARY KEY (`id`),
    UNIQUE KEY `student_id` (`student_id`),
    UNIQUE KEY `email` (`email`),
    KEY `teacher_id` (`teacher_id`),

    CONSTRAINT `students_ibfk_1`
        FOREIGN KEY (`teacher_id`)
        REFERENCES `users` (`id`)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


-- =========================================================
-- TABLE: batches
-- =========================================================

CREATE TABLE `batches` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `batch_name` varchar(100) NOT NULL,
    `starting_date` date NOT NULL,
    `batch_time` varchar(50) NOT NULL,
    `teacher_id` int(11) NOT NULL,
    `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),

    PRIMARY KEY (`id`),
    KEY `teacher_id` (`teacher_id`),

    CONSTRAINT `batches_ibfk_1`
        FOREIGN KEY (`teacher_id`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


-- =========================================================
-- TABLE: batch_students
-- =========================================================

CREATE TABLE `batch_students` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `batch_id` int(11) NOT NULL,
    `student_id` int(11) NOT NULL,

    PRIMARY KEY (`id`),
    KEY `batch_id` (`batch_id`),
    KEY `student_id` (`student_id`),

    CONSTRAINT `batch_students_ibfk_1`
        FOREIGN KEY (`batch_id`)
        REFERENCES `batches` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT `batch_students_ibfk_2`
        FOREIGN KEY (`student_id`)
        REFERENCES `students` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;