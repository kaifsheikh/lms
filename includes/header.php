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
    <script>
        // Apply saved/preferred theme before paint to avoid a light-mode flash
        (function () {
            try {
                var theme = localStorage.getItem('lms-theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>
    <title>
        LMS - <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
    </title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/css/tailwind.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/theme-dark.css">
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased">

<header id="site-header" class="bg-white border-b border-slate-200 sticky top-0 z-50 transition-shadow duration-200">
    <div class="h-[3px] bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-600"></div>
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2.5 group">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-500 text-white text-sm font-bold shadow-sm group-hover:shadow-md transition-shadow">L</span>
                    <span class="text-lg font-semibold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors">LMS</span>
                </a>
                <?php if ($role): ?>
                    <span class="hidden sm:inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 capitalize">
                        <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-0.5 lg:min-w-0">
                <?php if ($role === 'admin'): ?>
                    <!-- Admin Dashboard -->
                    <a href="<?= BASE_URL ?>/admin/controller/dashboard.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        Dashboard
                    </a>

                    <!-- Approvals Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Approvals
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Dropdown with pt-2 to bridge gap -->
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Teacher Approval
                                </a>
                                <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Batch Approval
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Management -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Course Management
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Dropdown with pt-2 to bridge gap -->
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/admin/controller/course_management.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Courses
                                </a>
                                <a href="<?= BASE_URL ?>/admin/controller/courses_list.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Course List
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Students Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Students
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/admin/controller/student/register.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Student Register
                                </a>
                                <a href="<?= BASE_URL ?>/admin/controller/student/manage.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Manage Students
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Progress -->
                    <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        Attendance Progress
                    </a>

                <?php elseif ($role === 'teacher'): ?>
                    <!-- Teacher Dashboard -->
                    <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        Dashboard
                    </a>

                    <!-- Students Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Students
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/teacher/controller/all_students.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    All Students
                                </a>
                                <a href="<?= BASE_URL ?>/teacher/controller/search_student.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Student Info
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Batches Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Batches
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    My Batches
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Quiz
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Quiz Management
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Attendance
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/teacher/controller/attendance.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Attendance
                                </a>
                                <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Attendance Report
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Dropdown -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Students Result
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/teacher/controller/quiz_results.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Quiz Result
                                </a>
                                <a href="<?= BASE_URL ?>/teacher/controller/quiz_history.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Quiz History
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Online Classes -->
                    <div class="relative group">
                        <button class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors inline-flex items-center">
                            Online Classes
                            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 pt-2 w-56 z-50 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="bg-white rounded-lg shadow-lg ring-1 ring-slate-200 py-1.5">
                                <a href="<?= BASE_URL ?>/teacher/controller/manage_classes.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Online Classes
                                </a>
                                <a href="<?= BASE_URL ?>/teacher/controller/class_report.php"
                                   class="group/item flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover/item:bg-indigo-500 transition-colors"></span>
                                    Class Report
                                </a>
                            </div>
                        </div>
                    </div>

                <?php elseif ($role === 'student'): ?>
                    <a href="<?= BASE_URL ?>/student/controller/dashboard.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/student/controller/quizzes.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Upcoming Quizzes</a>
                    <a href="<?= BASE_URL ?>/student/controller/results.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Results</a>
                    <a href="<?= BASE_URL ?>/student/controller/my_attendance.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">My Attendance</a>
                    <a href="<?= BASE_URL ?>/student/controller/my_classes.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">My Classes</a>

                <?php else: ?>
                    <a href="<?= BASE_URL ?>/accounts/controller/login.php"
                       class="whitespace-nowrap px-2.5 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Login</a>
                    <a href="<?= BASE_URL ?>/accounts/controller/register.php"
                       class="whitespace-nowrap px-3 py-2 rounded-md text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">Register</a>

                <?php endif; ?>
            </div>

            <!-- Desktop Logout -->
            <div class="hidden lg:flex items-center gap-3 flex-shrink-0">
                <!-- Theme toggle -->
                <button type="button" aria-label="Toggle dark mode"
                        class="theme-toggle-btn inline-flex items-center justify-center h-9 w-9 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors">
                    <svg class="theme-icon-sun h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                    </svg>
                    <svg class="theme-icon-moon h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                </button>
                <?php if (isLoggedIn()): ?>
                    <div class="flex items-center gap-2 rounded-full border border-slate-200 pl-2.5 pr-1 py-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-slate-400 flex-shrink-0">
                            <path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span class="text-sm text-slate-600 whitespace-nowrap">
                            <?= $user_name ?>
                        </span>
                    </div>
                    <form action="<?= BASE_URL ?>/accounts/controller/logout.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="whitespace-nowrap inline-flex items-center gap-1.5 rounded-md border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center gap-2">
                <button type="button" aria-label="Toggle dark mode"
                        class="theme-toggle-btn inline-flex items-center justify-center h-9 w-9 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors">
                    <svg class="theme-icon-sun h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                    </svg>
                    <svg class="theme-icon-moon h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                </button>
                <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center h-9 w-9 rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors focus:outline-none" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 border-t border-slate-200">
                <a href="<?= BASE_URL ?>/index.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Home</a>

                <?php if ($role === 'admin'): ?>
                    <a href="<?= BASE_URL ?>/admin/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Teacher Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/student/register.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Student Register</a>
                    <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Manage Students</a>
                    <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Batch Approval</a>
                    <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Attendance Progress</a>

                <?php elseif ($role === 'teacher'): ?>
                    <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_students.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Unassigned Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/all_students.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">All Students</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/search_student.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Student Info</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Management Batch</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">My Batches</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Quiz Management</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/attendance.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Attendance</a>
                    <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Attendance Report</a>

                <?php elseif ($role === 'student'): ?>
                    <a href="<?= BASE_URL ?>/student/controller/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Dashboard</a>
                    <a href="<?= BASE_URL ?>/student/controller/quizzes.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Upcoming Quizzes</a>
                    <a href="<?= BASE_URL ?>/student/controller/results.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Results</a>
                    <a href="<?= BASE_URL ?>/student/controller/my_attendance.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">My Attendance</a>

                <?php else: ?>
                    <a href="<?= BASE_URL ?>/accounts/controller/login.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">Login</a>
                    <a href="<?= BASE_URL ?>/accounts/controller/register.php" class="block px-3 py-2 rounded-md text-base font-medium bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">Register</a>

                <?php endif; ?>

                <?php if (isLoggedIn()): ?>
                    <form action="<?= BASE_URL ?>/accounts/controller/logout.php" method="POST" class="pt-2">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="w-full text-left rounded-md border border-slate-200 px-3 py-2 text-base font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">
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

    // Dark mode toggle
    (function () {
        function updateIcons() {
            var isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-icon-sun').forEach(function (el) { el.classList.toggle('hidden', isDark); });
            document.querySelectorAll('.theme-icon-moon').forEach(function (el) { el.classList.toggle('hidden', !isDark); });
        }
        updateIcons();
        document.querySelectorAll('.theme-toggle-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.documentElement.classList.toggle('dark');
                try {
                    localStorage.setItem('lms-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                } catch (e) {}
                updateIcons();
            });
        });
    })();

    // Subtle shadow once the page scrolls, keeps the header feeling anchored
    (function () {
        var header = document.getElementById('site-header');
        function onScroll() {
            header.classList.toggle('shadow-md', window.scrollY > 4);
        }
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    })();
</script>

<main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
