<?php include HEADER; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800 p-6 sm:p-8 mb-8 text-white shadow-lg">
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur px-2.5 py-1 rounded-full text-xs font-medium">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Student Panel
                </span>
            </div>
            <p class="text-indigo-200 text-sm font-medium"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-2xl sm:text-3xl font-bold mt-1">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Student'); ?></h1>
            <p class="text-indigo-100 text-sm mt-2 max-w-xl">Aap ke quizzes, results, online classes aur attendance ka complete overview ek nazar mein.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-white/5"></div>
        <div class="absolute -right-24 -bottom-16 w-64 h-64 rounded-full bg-white/5"></div>
        <div class="absolute right-20 top-1/2 w-32 h-32 rounded-full bg-violet-400/10"></div>
    </div>

    <!-- Primary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                </div>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">Available</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $available_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-1">Available Quizzes</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Done</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $attempted_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-1">Quizzes Attempted</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                </div>
                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">Upcoming</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $upcoming_classes; ?></p>
            <p class="text-sm text-slate-500 mt-1">Upcoming Classes</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
                </div>
                <?php
                $attBadge = 'bg-teal-50 text-teal-600';
                if ($attendance_percentage >= 75) $attBadge = 'bg-emerald-50 text-emerald-600';
                elseif ($attendance_percentage < 50) $attBadge = 'bg-red-50 text-red-600';
                ?>
                <span class="text-xs font-medium <?php echo $attBadge; ?> px-2 py-1 rounded-full">
                    <?php echo $attendance_percentage >= 75 ? 'Good' : ($attendance_percentage >= 50 ? 'Fair' : 'Low'); ?>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $attendance_percentage; ?>%</p>
            <p class="text-sm text-slate-500 mt-1">Attendance Rate</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Quick Actions</h2>
                <p class="text-xs text-slate-500 mt-0.5">Frequently used student tasks</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <a href="<?= BASE_URL ?>/student/controller/quizzes.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Take Quiz</span>
            </a>

            <a href="<?= BASE_URL ?>/student/controller/results.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">My Results</span>
            </a>

            <a href="<?= BASE_URL ?>/student/controller/my_classes.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-sky-300 hover:bg-sky-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">My Classes</span>
            </a>

            <a href="<?= BASE_URL ?>/student/controller/my_attendance.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-teal-300 hover:bg-teal-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">My Attendance</span>
            </a>

            <a href="<?= BASE_URL ?>/student/controller/my_fees.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">My Fees</span>
            </a>
        </div>
    </div>

    <!-- Recent Results and Upcoming Classes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Results -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Recent Quiz Results</h2>
                        <p class="text-xs text-slate-500">Your latest performance</p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/student/controller/results.php" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
            </div>
            <?php if (empty($recent_results)): ?>
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                    </div>
                    <p class="text-sm text-slate-500">No quiz results yet.</p>
                </div>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($recent_results as $result): 
                        $pct = floatval($result['percentage']);
                        $pctClass = $pct >= 80 ? 'text-emerald-600 bg-emerald-50' : ($pct >= 60 ? 'text-indigo-600 bg-indigo-50' : ($pct >= 40 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50'));
                    ?>
                        <li class="px-6 py-4 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors">
                            <div class="min-w-0">
                                <p class="font-medium text-slate-800 text-sm truncate"><?php echo htmlspecialchars($result['title']); ?></p>
                                <p class="text-xs text-slate-500 mt-0.5"><?php echo date('M j, Y', strtotime($result['submitted_at'])); ?></p>
                            </div>
                            <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold <?php echo $pctClass; ?>">
                                <?php echo $result['percentage']; ?>%
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Upcoming Classes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Upcoming Classes</h2>
                        <p class="text-xs text-slate-500">Your scheduled sessions</p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/student/controller/my_classes.php" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
            </div>
            <?php if (empty($upcoming_classes_list)): ?>
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                    </div>
                    <p class="text-sm text-slate-500">No upcoming classes.</p>
                </div>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($upcoming_classes_list as $class): ?>
                        <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 text-sm truncate"><?php echo htmlspecialchars($class['title']); ?></p>
                                    <div class="flex items-center gap-2 mt-1 text-xs text-slate-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                                        <?php echo date('M j, g:i A', strtotime($class['start_time'])); ?>
                                    </div>
                                </div>
                                <span class="shrink-0 inline-flex items-center gap-1 bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full text-xs font-mono font-medium">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    <?php echo htmlspecialchars($class['token']); ?>
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>