<?php

require_once __DIR__ . '/../config.php';
require_once SESSION;

$role = getRole();

$user_name = htmlspecialchars(
    $_SESSION['user_name'] ?? 'Guest',
    ENT_QUOTES,
    'UTF-8'
);

$page_title = ucfirst($role ?: 'Home');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        LMS - <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
    </title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/css/tailwind.css">
</head>
<body class="bg-gray-100">

<header class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?= BASE_URL ?>/index.php" class="text-xl font-bold text-white hover:text-gray-300 transition-colors">
                    LMS
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-1">
                <?php if ($role === 'admin'): ?>
                    <!-- Admin Dashboard -->
                    <a href="<?= BASE_URL ?>/admin/controller/dashboard.php"
                       class="px-3 py-2 rounded-md text-sm font-medium bg-blue-600 hover:bg-blue-700 transition-colors">
                        Dashboard
                    </a>

                    <!-- Approvals Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Approvals
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Dropdown with pt-2 to bridge gap -->
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Teacher Approval</a>
                                <a href="<?= BASE_URL ?>/admin/controller/accountant/approval.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Accountant Approval</a>
                                <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Batch Approval</a>
                            </div>
                        </div>
                    </div>

                    <!-- Students Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Students
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/admin/controller/student/register.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Student Register</a>
                                <a href="<?= BASE_URL ?>/admin/controller/student/manage.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage Students</a>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Progress -->
                    <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php"
                       class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">
                        Attendance Progress
                    </a>

                <?php elseif ($role === 'teacher'): ?>
                    <!-- Teacher Dashboard -->
                    <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php"
                       class="px-3 py-2 rounded-md text-sm font-medium bg-green-600 hover:bg-green-700 transition-colors">
                        Dashboard
                    </a>

                    <!-- Students Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Students
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/teacher/controller/my_students.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Unassigned Students</a>
                                <a href="<?= BASE_URL ?>/teacher/controller/all_students.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Students</a>
                                <a href="<?= BASE_URL ?>/teacher/controller/search_student.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Student Info</a>
                            </div>
                        </div>
                    </div>

                    <!-- Batches Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Batches
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Management Batch</a>
                                <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Batches</a>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Quiz
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Quiz Management</a>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Attendance
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/teacher/controller/attendance.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Attendance</a>
                                <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Attendance Report</a>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors inline-flex items-center">
                            Students Result
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/teacher/controller/quiz_results.php"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Quiz Result</a>
                            </div>
                        </div>
                    </div>

                <?php elseif ($role === 'accountant'): ?>
                    <a href="<?= BASE_URL ?>/accountant/controller/dashboard.php"
                       class="px-3 py-2 rounded-md text-sm font-medium bg-purple-600 hover:bg-purple-700 transition-colors">
                        Dashboard
                    </a>

                <?php elseif ($role === 'student'): ?>
                    <a href="<?= BASE_URL ?>/student/controller/dashboard.php"
                       class="px-3 py-2 rounded-md text-sm font-medium bg-yellow-600 hover:bg-yellow-700 transition-colors">
                        Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/student/controller/quizzes.php"
                       class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Upcoming Quizzes</a>
                    <a href="<?= BASE_URL ?>/student/controller/results.php"
                       class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Results</a>
                    <a href="<?= BASE_URL ?>/student/controller/my_attendance.php"
                       class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">My Attendance</a>

                <?php else: ?>
                    <a href="<?= BASE_URL ?>/accounts/controller/login.php"
                       class="px-3 py-2 rounded-md text-sm font-medium bg-blue-600 hover:bg-blue-700 transition-colors">Login</a>
                    <a href="<?= BASE_URL ?>/accounts/controller/register.php"
                       class="px-3 py-2 rounded-md text-sm font-medium bg-green-600 hover:bg-green-700 transition-colors">Register</a>

                <?php endif; ?>
            </div>

            <!-- Desktop Logout -->
            <div class="hidden md:flex items-center space-x-3">
                <?php if (isLoggedIn()): ?>
                    <form action="<?= BASE_URL ?>/accounts/controller/logout.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Logout (<?= $user_name ?>)
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" type="button" class="text-gray-400 hover:text-white focus:outline-none focus:text-white" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-700">
                <a href="<?= BASE_URL ?>/index.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Home</a>

                <?php if ($role === 'admin'): ?>
                    <a href="<?= BASE_URL ?>/admin/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 hover:bg-blue-700 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Teacher Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/accountant/approval.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Accountant Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/student/register.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Student Register</a>
                    <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Manage Students</a>
                    <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Batch Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Attendance Progress</a>

                <?php elseif ($role === 'teacher'): ?>
                    <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-green-600 hover:bg-green-700 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_students.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Unassigned Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/all_students.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">All Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/search_student.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Student Info</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Management Batch</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">My Batches</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Quiz Management</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/attendance.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Attendance</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Attendance Report</a>

                <?php elseif ($role === 'accountant'): ?>
                    <a href="<?= BASE_URL ?>/accountant/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-purple-600 hover:bg-purple-700 transition-colors">Dashboard</a>

                <?php elseif ($role === 'student'): ?>
                    <a href="<?= BASE_URL ?>/student/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-yellow-600 hover:bg-yellow-700 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/student/controller/quizzes.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Upcoming Quizzes</a>
                    <a href="<?= BASE_URL ?>/student/controller/results.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Results</a>
                    <a href="<?= BASE_URL ?>/student/controller/my_attendance.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">My Attendance</a>

                <?php else: ?>
                    <a href="<?= BASE_URL ?>/accounts/controller/login.php" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 hover:bg-blue-700 transition-colors">Login</a>
                    <a href="<?= BASE_URL ?>/accounts/controller/register.php" class="block px-3 py-2 rounded-md text-base font-medium bg-green-600 hover:bg-green-700 transition-colors">Register</a>

                <?php endif; ?>

                <?php if (isLoggedIn()): ?>
                    <form action="<?= BASE_URL ?>/accounts/controller/logout.php" method="POST" class="pt-2">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="w-full text-left bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-base font-medium transition-colors">
                            Logout (<?= $user_name ?>)
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">