<?php include HEADER; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 p-6 sm:p-8 mb-8 text-white">
        <div class="relative z-10">
            <p class="text-indigo-300 text-sm font-medium"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-2xl sm:text-3xl font-semibold mt-1">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Student'); ?></h1>
            <p class="text-slate-300 text-sm mt-2 max-w-lg">Apne quizzes, results, classes aur attendance ka ek nazar mein overview.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-indigo-500/10"></div>
        <div class="absolute -right-24 -bottom-16 w-56 h-56 rounded-full bg-indigo-500/10"></div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $available_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Available Quizzes</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $attempted_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Quizzes Attempted</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $upcoming_classes; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Upcoming Classes</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $attendance_percentage; ?>%</p>
            <p class="text-sm text-slate-500 mt-0.5">Attendance</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="<?= BASE_URL ?>/student/controller/quizzes.php" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                Take Quiz
            </a>
            <a href="<?= BASE_URL ?>/student/controller/results.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                My Results
            </a>
            <a href="<?= BASE_URL ?>/student/controller/my_classes.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                My Classes
            </a>
            <a href="<?= BASE_URL ?>/student/controller/my_attendance.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                My Attendance
            </a>
        </div>
    </div>

    <!-- Recent Results and Upcoming Classes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Results -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Recent Quiz Results</h2>
            <?php if (empty($recent_results)): ?>
                <p class="text-sm text-slate-500">No quiz results yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($recent_results as $result): ?>
                        <li class="py-3 flex items-center justify-between gap-3">
                            <p class="font-medium text-slate-800 text-sm"><?php echo htmlspecialchars($result['title']); ?></p>
                            <div class="shrink-0 flex items-center gap-2 text-sm">
                                <?php
                                $pct = floatval($result['percentage']);
                                $pctClass = $pct >= 80 ? 'text-green-600' : ($pct >= 60 ? 'text-blue-600' : ($pct >= 40 ? 'text-amber-600' : 'text-red-600'));
                                ?>
                                <span class="font-semibold <?php echo $pctClass; ?>"><?php echo $result['percentage']; ?>%</span>
                                <span class="text-slate-400">&middot;</span>
                                <span class="text-slate-500"><?php echo date('M j, Y', strtotime($result['submitted_at'])); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Upcoming Classes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Upcoming Classes</h2>
            <?php if (empty($upcoming_classes_list)): ?>
                <p class="text-sm text-slate-500">No upcoming classes.</p>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($upcoming_classes_list as $class): ?>
                        <li class="py-3">
                            <p class="font-medium text-slate-800 text-sm"><?php echo htmlspecialchars($class['title']); ?></p>
                            <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
                                <span><?php echo date('M j, g:i A', strtotime($class['start_time'])); ?></span>
                                <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full text-xs">Token: <?php echo htmlspecialchars($class['token']); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>
