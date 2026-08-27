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

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex md:items-center md:space-x-1">
                <!-- <a href="<?= BASE_URL ?>/index.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Home</a> -->

                <?php if ($role === 'admin'): ?>
                    <a href="<?= BASE_URL ?>/admin/controller/dashboard.php" class="px-3 py-2 rounded-md text-sm font-medium bg-blue-600 hover:bg-blue-700 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Teacher Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/accountant/approval.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Accountant Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/student/register.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Student Register</a>
                    <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Manage Students</a>
                    <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Batch Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors"> Attendance Progress</a>

                <?php elseif ($role === 'teacher'): ?>
                    <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php" class="px-3 py-2 rounded-md text-sm font-medium bg-green-600 hover:bg-green-700 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_students.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Unassigned Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/all_students.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">All Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Management Batch</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">My Batches</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Quiz Management</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/search_student.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Student Info</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/attendance.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Attendance</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Attendance Report</a>

                <?php elseif ($role === 'accountant'): ?>
                    <a href="<?= BASE_URL ?>/accountant/controller/dashboard.php" class="px-3 py-2 rounded-md text-sm font-medium bg-purple-600 hover:bg-purple-700 transition-colors">Dashboard</a>

                <?php elseif ($role === 'student'): ?>
                    <a href="<?= BASE_URL ?>/student/controller/dashboard.php" class="px-3 py-2 rounded-md text-sm font-medium bg-yellow-600 hover:bg-yellow-700 transition-colors">Dashboard</a>

                     <a href="<?= BASE_URL ?>/student/controller/quizzes.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Upcoming Quizzes</a>

                     <a href="<?= BASE_URL ?>/student/controller/results.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">Results</a>

                     <a href="<?= BASE_URL ?>/student/controller/my_attendance.php" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-800 hover:text-white transition-colors">My Attendance</a>

                <?php else: ?>
                    <a href="<?= BASE_URL ?>/accounts/controller/login.php" class="px-3 py-2 rounded-md text-sm font-medium bg-blue-600 hover:bg-blue-700 transition-colors">Login</a>
                    <a href="<?= BASE_URL ?>/accounts/controller/register.php" class="px-3 py-2 rounded-md text-sm font-medium bg-green-600 hover:bg-green-700 transition-colors">Register</a>

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

        <!-- Mobile Menu (hidden by default) -->
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

                <?php elseif ($role === 'teacher'): ?>
                    <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-green-600 hover:bg-green-700 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_students.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Unassigned Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/all_students.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">All Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Management Batch</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">My Batches</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:text-white transition-colors">Quiz Management</a>

                <?php elseif ($role === 'accountant'): ?>
                    <a href="<?= BASE_URL ?>/accountant/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-purple-600 hover:bg-purple-700 transition-colors">Dashboard</a>

                <?php elseif ($role === 'student'): ?>
                    <a href="<?= BASE_URL ?>/student/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium bg-yellow-600 hover:bg-yellow-700 transition-colors">Dashboard</a>

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