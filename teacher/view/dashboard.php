<?php include HEADER; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800 p-6 sm:p-8 mb-8 text-white shadow-lg">
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur px-2.5 py-1 rounded-full text-xs font-medium">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Teacher Panel
                </span>
            </div>
            <p class="text-indigo-200 text-sm font-medium"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-2xl sm:text-3xl font-bold mt-1">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Teacher'); ?></h1>
            <p class="text-indigo-100 text-sm mt-2 max-w-xl">Aap ke batches, students, quizzes aur online classes ka complete overview ek nazar mein.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-white/5"></div>
        <div class="absolute -right-24 -bottom-16 w-64 h-64 rounded-full bg-white/5"></div>
        <div class="absolute right-20 top-1/2 w-32 h-32 rounded-full bg-violet-400/10"></div>
    </div>

    <!-- Primary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
                <span class="text-xs font-medium text-violet-600 bg-violet-50 px-2 py-1 rounded-full">Active</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_batches; ?></p>
            <p class="text-sm text-slate-500 mt-1">Approved Batches</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Assigned</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_students; ?></p>
            <p class="text-sm text-slate-500 mt-1">Total Students</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M12 11h4"/><path d="M12 16h4"/></svg>
                </div>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full"><?php echo $active_quizzes; ?> active</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-1">Total Quizzes</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                </div>
                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full"><?php echo $upcoming_classes; ?> upcoming</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_classes; ?></p>
            <p class="text-sm text-slate-500 mt-1">Online Classes</p>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $total_attendance_records; ?></p>
                    <p class="text-xs text-slate-500">Attendance Records</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $total_quiz_attempts; ?></p>
                    <p class="text-xs text-slate-500">Quiz Attempts</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $total_students > 0 ? count(array_unique(array_column($recent_quizzes, 'id'))) : 0; ?></p>
                    <p class="text-xs text-slate-500">Recent Quizzes</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $upcoming_classes; ?></p>
                    <p class="text-xs text-slate-500">Upcoming Classes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Quick Actions</h2>
                <p class="text-xs text-slate-500 mt-0.5">Frequently used teacher tasks</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Quizzes</span>
            </a>

            <a href="<?= BASE_URL ?>/teacher/controller/manage_classes.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-sky-300 hover:bg-sky-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Online Classes</span>
            </a>

            <a href="<?= BASE_URL ?>/teacher/controller/attendance.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Attendance</span>
            </a>

            <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Reports</span>
            </a>

            <a href="<?= BASE_URL ?>/teacher/controller/quiz_results.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-violet-300 hover:bg-violet-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Quiz Results</span>
            </a>

            <a href="<?= BASE_URL ?>/teacher/controller/quiz_history.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-rose-300 hover:bg-rose-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Quiz History</span>
            </a>
        </div>
    </div>

    <!-- Recent Quizzes and Classes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Quizzes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Recent Quizzes</h2>
                        <p class="text-xs text-slate-500">Latest quizzes you created</p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
            </div>
            <?php if (empty($recent_quizzes)): ?>
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <p class="text-sm text-slate-500">No quizzes yet.</p>
                </div>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($recent_quizzes as $quiz): ?>
                        <li class="px-6 py-4 flex items-start justify-between gap-3 hover:bg-slate-50 transition-colors">
                            <div class="min-w-0">
                                <p class="font-medium text-slate-800 text-sm truncate"><?php echo htmlspecialchars($quiz['title']); ?></p>
                                <p class="text-xs text-slate-500 mt-0.5">Batch: <?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></p>
                            </div>
                            <?php
                            $status = $quiz['status'];
                            $badge = 'bg-amber-50 text-amber-700';
                            if ($status === 'active') $badge = 'bg-emerald-50 text-emerald-700';
                            elseif ($status === 'closed') $badge = 'bg-slate-100 text-slate-600';
                            ?>
                            <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge; ?>"><?php echo htmlspecialchars($status); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Recent Classes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Recent / Upcoming Classes</h2>
                        <p class="text-xs text-slate-500">Your scheduled online sessions</p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/teacher/controller/manage_classes.php" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
            </div>
            <?php if (empty($recent_classes)): ?>
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <p class="text-sm text-slate-500">No online classes yet.</p>
                </div>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($recent_classes as $class): ?>
                        <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                            <p class="font-medium text-slate-800 text-sm truncate"><?php echo htmlspecialchars($class['title']); ?></p>
                            <div class="flex items-center gap-2 mt-1 text-xs text-slate-500">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2 2 7l10 5 10-5-10-5Z"/></svg>
                                    <?php echo htmlspecialchars($class['batch_name']); ?>
                                </span>
                                <span class="text-slate-300">•</span>
                                <span><?php echo date('M j, g:i A', strtotime($class['start_time'])); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>