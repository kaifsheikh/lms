<?php include HEADER; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 p-6 sm:p-8 mb-8 text-white">
        <div class="relative z-10">
            <p class="text-indigo-300 text-sm font-medium"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-2xl sm:text-3xl font-semibold mt-1">Teacher Dashboard</h1>
            <p class="text-slate-300 text-sm mt-2 max-w-lg">Apne batches, students, quizzes aur classes ka ek nazar mein overview.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-indigo-500/10"></div>
        <div class="absolute -right-24 -bottom-16 w-56 h-56 rounded-full bg-indigo-500/10"></div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_batches; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Approved Batches</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_students; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Assigned Students</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Quizzes Created</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_classes; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Online Classes</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_attendance_records; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Attendance Records</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">Manage Quizzes</a>
            <a href="<?= BASE_URL ?>/teacher/controller/manage_classes.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">Online Classes</a>
            <a href="<?= BASE_URL ?>/teacher/controller/attendance.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">Mark Attendance</a>
            <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">Attendance Report</a>
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_results.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">Quiz Results</a>
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_history.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">Quiz History</a>
        </div>
    </div>

    <!-- Recent Quizzes and Classes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Quizzes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Recent Quizzes</h2>
            <?php if (empty($recent_quizzes)): ?>
                <p class="text-sm text-slate-500">No quizzes yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($recent_quizzes as $quiz): ?>
                        <li class="py-3 flex items-start justify-between gap-3">
                            <div>
                                <p class="font-medium text-slate-800 text-sm"><?php echo htmlspecialchars($quiz['title']); ?></p>
                                <p class="text-sm text-slate-500 mt-0.5">Batch: <?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></p>
                            </div>
                            <?php
                            $status = $quiz['status'];
                            $badge = 'bg-amber-50 text-amber-700';
                            if ($status === 'active') $badge = 'bg-green-50 text-green-700';
                            elseif ($status === 'closed') $badge = 'bg-slate-100 text-slate-600';
                            ?>
                            <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge; ?>"><?php echo htmlspecialchars($status); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Recent Classes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Recent / Upcoming Classes</h2>
            <?php if (empty($recent_classes)): ?>
                <p class="text-sm text-slate-500">No online classes yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php foreach ($recent_classes as $class): ?>
                        <li class="py-3">
                            <p class="font-medium text-slate-800 text-sm"><?php echo htmlspecialchars($class['title']); ?></p>
                            <p class="text-sm text-slate-500 mt-0.5">
                                Batch: <?php echo htmlspecialchars($class['batch_name']); ?> &middot;
                                Start: <?php echo htmlspecialchars($class['start_time']); ?>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>
