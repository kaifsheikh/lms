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

/* ---------------------------------------------------------------------
 * Sidebar navigation data (presentation only — no business logic here).
 * ------------------------------------------------------------------- */
function nav_icon_path($key) {
    $icons = [
        'home'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.122 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
        'check'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'book'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
        'users'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>',
        'clipboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.123.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
        'calendar'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>',
        'chart'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
        'video'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>',
        'login'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3"/>',
        'user-plus' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>',
    ];
    return $icons[$key] ?? $icons['book'];
}

if ($role === 'admin') {
    $nav_groups = [
        ['label' => null, 'items' => [
            ['label' => 'Dashboard', 'href' => BASE_URL . '/admin/controller/dashboard.php', 'icon' => 'home'],
        ]],
        ['label' => 'Teacher Management', 'items' => [
            ['label' => 'Teacher Management', 'href' => BASE_URL . '/admin/controller/teacher/approval.php', 'icon' => 'check'],
        ]],
        ['label' => 'Batch Management', 'items' => [
            ['label' => 'Batch Management', 'href' => BASE_URL . '/admin/controller/teacher/batch_approval.php', 'icon' => 'check'],
        ]],
        ['label' => 'Course Management', 'items' => [
            ['label' => 'Courses', 'href' => BASE_URL . '/admin/controller/course_management.php', 'icon' => 'book'],
            ['label' => 'Course List', 'href' => BASE_URL . '/admin/controller/courses_list.php', 'icon' => 'book'],
        ]],
        ['label' => 'Students', 'items' => [
            ['label' => 'Student Register', 'href' => BASE_URL . '/admin/controller/student/register.php', 'icon' => 'user-plus'],
            ['label' => 'Manage Students', 'href' => BASE_URL . '/admin/controller/student/manage.php', 'icon' => 'users'],
        ]],
        ['label' => 'Attendance', 'items' => [
            ['label' => 'Attendance Progress', 'href' => BASE_URL . '/admin/controller/attendance_progress.php', 'icon' => 'calendar'],
        ]],
        ['label' => 'Fees Management', 'items' => [
            ['label' => 'Fee Management', 'href' => BASE_URL . '/admin/controller/fee_management.php', 'icon' => 'chart'],

            ['label' => 'Fee History Search', 'href' => BASE_URL . '/admin/controller/fee_history_search.php', 'icon' => 'history'],
        ]],
        
    ];
} elseif ($role === 'teacher') {
    $nav_groups = [
        ['label' => null, 'items' => [
            ['label' => 'Dashboard', 'href' => BASE_URL . '/teacher/controller/dashboard.php', 'icon' => 'home'],
        ]],
        ['label' => 'Students', 'items' => [
            ['label' => 'All Students', 'href' => BASE_URL . '/teacher/controller/all_students.php', 'icon' => 'users'],
            ['label' => 'Student Info', 'href' => BASE_URL . '/teacher/controller/search_student.php', 'icon' => 'users'],
        ]],
        ['label' => 'Batches', 'items' => [
            ['label' => 'My Batches', 'href' => BASE_URL . '/teacher/controller/my_batches.php', 'icon' => 'clipboard'],
        ]],
        ['label' => 'Quiz', 'items' => [
            ['label' => 'Quiz Management', 'href' => BASE_URL . '/teacher/controller/quiz_management.php', 'icon' => 'clipboard'],
        ]],
        ['label' => 'Attendance', 'items' => [
            ['label' => 'Attendance', 'href' => BASE_URL . '/teacher/controller/attendance.php', 'icon' => 'calendar'],
            ['label' => 'Attendance Report', 'href' => BASE_URL . '/teacher/controller/attendance_report.php', 'icon' => 'calendar'],
        ]],
        ['label' => 'Students Result', 'items' => [
            ['label' => 'Quiz Result', 'href' => BASE_URL . '/teacher/controller/quiz_results.php', 'icon' => 'chart'],
            ['label' => 'Quiz History', 'href' => BASE_URL . '/teacher/controller/quiz_history.php', 'icon' => 'chart'],
        ]],
        ['label' => 'Online Classes', 'items' => [
            ['label' => 'Online Classes', 'href' => BASE_URL . '/teacher/controller/manage_classes.php', 'icon' => 'video'],
            ['label' => 'Class Report', 'href' => BASE_URL . '/teacher/controller/class_report.php', 'icon' => 'video'],
        ]],
    ];
} elseif ($role === 'student') {
    $nav_groups = [
        ['label' => null, 'items' => [
            ['label' => 'Dashboard', 'href' => BASE_URL . '/student/controller/dashboard.php', 'icon' => 'home'],
            ['label' => 'Upcoming Quizzes', 'href' => BASE_URL . '/student/controller/quizzes.php', 'icon' => 'clipboard'],
            ['label' => 'Results', 'href' => BASE_URL . '/student/controller/results.php', 'icon' => 'chart'],
            ['label' => 'My Attendance', 'href' => BASE_URL . '/student/controller/my_attendance.php', 'icon' => 'calendar'],
            ['label' => 'My Classes', 'href' => BASE_URL . '/student/controller/my_classes.php', 'icon' => 'video'],
            ['label' => 'My Fees', 'href' => BASE_URL . '/student/controller/my_fees.php', 'icon' => 'chart'],
        ]],
    ];
} else {
    $nav_groups = [
        ['label' => null, 'items' => [
            ['label' => 'Login', 'href' => BASE_URL . '/accounts/controller/login.php', 'icon' => 'login'],
            ['label' => 'Register', 'href' => BASE_URL . '/accounts/controller/register.php', 'icon' => 'user-plus'],
        ]],
    ];
}

$current_path = $_SERVER['PHP_SELF'] ?? '';
function nav_is_active($href, $current_path) {
    $rel = preg_replace('#^' . preg_quote(BASE_URL, '#') . '#', '', $href);
    return $rel !== '' && strpos($current_path, $rel) !== false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/tailwind.css">
    <style>
        /* Sidebar transition and collapse styles */
        #app-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        body.sidebar-collapsed #app-sidebar {
            transform: translateX(-100%);
        }
        .main-content-wrapper {
            transition: margin-left 0.3s ease-in-out;
        }
        body.sidebar-collapsed .main-content-wrapper {
            margin-left: 0 !important;
        }
        @media (min-width: 1024px) {
            body.sidebar-collapsed #app-sidebar {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<!-- Sidebar -->
<aside id="app-sidebar"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col shadow-xl lg:shadow-none -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="h-[3px] bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-600 flex-shrink-0"></div>

    <!-- Brand + close/collapse buttons -->
    <div class="flex items-center justify-between gap-2 px-4 h-16 flex-shrink-0 border-b border-slate-100">
        <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2.5 group min-w-0">
            <span class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-500 text-white text-sm font-bold shadow-sm group-hover:shadow-md transition-shadow">L</span>
            <span class="flex flex-col min-w-0">
                <span class="text-base font-semibold text-slate-900 tracking-tight leading-tight group-hover:text-indigo-600 transition-colors truncate">LMS</span>
                <?php if ($role): ?>
                    <span class="text-[11px] font-medium text-indigo-600 capitalize leading-tight"><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </span>
        </a>
        <div class="flex items-center gap-1">
            <!-- Mobile close -->
            <button id="sidebar-close-btn" type="button" aria-label="Close menu"
                    class="lg:hidden inline-flex items-center justify-center h-8 w-8 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors flex-shrink-0">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Desktop collapse toggle -->
            <button id="sidebar-collapse-btn" type="button" aria-label="Toggle sidebar"
                    class="hidden lg:inline-flex items-center justify-center h-8 w-8 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors flex-shrink-0">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <?php foreach ($nav_groups as $group): ?>
            <?php if (!empty($group['label'])): ?>
                <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400 first:pt-0">
                    <?= htmlspecialchars($group['label'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>
            <?php foreach ($group['items'] as $item): ?>
                <?php $active = nav_is_active($item['href'], $current_path); ?>
                <a href="<?= $item['href'] ?>"
                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors <?= $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
                    <svg class="h-[18px] w-[18px] flex-shrink-0 <?= $active ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <?= nav_icon_path($item['icon'] ?? 'book') ?>
                    </svg>
                    <span class="truncate"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                    <?php if ($active): ?>
                        <span class="ml-auto h-1.5 w-1.5 rounded-full bg-indigo-600 flex-shrink-0"></span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </nav>

    <!-- Bottom user info / logout -->
    <div class="flex-shrink-0 border-t border-slate-100 p-3 space-y-2">
        <?php if (isLoggedIn()): ?>
            <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 px-3 py-2">
                <span class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <span class="text-sm text-slate-700 font-medium truncate min-w-0"><?= $user_name ?></span>
            </div>
            <form action="<?= BASE_URL ?>/accounts/controller/logout.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        <?php endif; ?>
    </div>
</aside>

<!-- Mobile overlay -->
<div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

<!-- Mobile top bar -->
<div id="mobile-topbar" class="lg:hidden sticky top-0 z-30 bg-white border-b border-slate-200 transition-shadow duration-200">
    <div class="h-[3px] bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-600"></div>
    <div class="flex items-center justify-between px-4 h-14">
        <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-500 text-white text-xs font-bold">L</span>
            <span class="text-sm font-semibold text-slate-900">LMS</span>
        </a>
        <button id="sidebar-open-btn" type="button" aria-label="Open menu"
                class="inline-flex items-center justify-center h-9 w-9 rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
</div>

<!-- Desktop floating toggle button (appears when sidebar collapsed) -->
<button id="desktop-open-btn" type="button" aria-label="Open sidebar"
        class="hidden fixed top-4 left-4 z-30 lg:flex items-center justify-center h-10 w-10 bg-white border border-slate-200 rounded-full shadow-md hover:bg-slate-50 transition-colors">
    <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<script>
    // Sidebar open/close (mobile) and collapse (desktop)
    (function () {
        var sidebar = document.getElementById('app-sidebar');
        var overlay = document.getElementById('sidebar-overlay');
        var openBtnMobile = document.getElementById('sidebar-open-btn');
        var closeBtnMobile = document.getElementById('sidebar-close-btn');
        var collapseBtn = document.getElementById('sidebar-collapse-btn');
        var desktopOpenBtn = document.getElementById('desktop-open-btn');
        var body = document.body;

        function openSidebarMobile() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
        }
        function closeSidebarMobile() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
        }
        function toggleSidebarCollapse() {
            body.classList.toggle('sidebar-collapsed');
            // Toggle visibility of floating open button
            if (body.classList.contains('sidebar-collapsed')) {
                desktopOpenBtn.classList.remove('hidden');
                desktopOpenBtn.classList.add('flex');
            } else {
                desktopOpenBtn.classList.add('hidden');
                desktopOpenBtn.classList.remove('flex');
            }
        }
        function openSidebarFromFloating() {
            body.classList.remove('sidebar-collapsed');
            desktopOpenBtn.classList.add('hidden');
            desktopOpenBtn.classList.remove('flex');
        }

        if (openBtnMobile) openBtnMobile.addEventListener('click', openSidebarMobile);
        if (closeBtnMobile) closeBtnMobile.addEventListener('click', closeSidebarMobile);
        if (overlay) overlay.addEventListener('click', closeSidebarMobile);
        if (collapseBtn) collapseBtn.addEventListener('click', toggleSidebarCollapse);
        if (desktopOpenBtn) desktopOpenBtn.addEventListener('click', openSidebarFromFloating);

        // Initialize floating button state
        if (body.classList.contains('sidebar-collapsed')) {
            desktopOpenBtn.classList.remove('hidden');
            desktopOpenBtn.classList.add('flex');
        }
    })();

    // Subtle shadow on mobile top bar on scroll
    (function () {
        var bar = document.getElementById('mobile-topbar');
        function onScroll() {
            bar.classList.toggle('shadow-md', window.scrollY > 4);
        }
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    })();
</script>

<!-- Page content wrapper -->
<div class="main-content-wrapper flex flex-col min-h-screen lg:ml-64">
<main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">