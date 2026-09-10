<?php include HEADER; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800 p-6 sm:p-8 mb-8 text-white shadow-lg">
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur px-2.5 py-1 rounded-full text-xs font-medium">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Live Dashboard
                </span>
            </div>
            <p class="text-indigo-200 text-sm font-medium"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-2xl sm:text-3xl font-bold mt-1">Welcome back, Admin</h1>
            <p class="text-indigo-100 text-sm mt-2 max-w-xl">A complete overview of your institute — students, teachers, batches, courses and daily activity in one glance.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-white/5"></div>
        <div class="absolute -right-24 -bottom-16 w-64 h-64 rounded-full bg-white/5"></div>
        <div class="absolute right-20 top-1/2 w-32 h-32 rounded-full bg-violet-400/10"></div>
    </div>

    <!-- Primary Stats (4 cards) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Active</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_teachers; ?></p>
            <p class="text-sm text-slate-500 mt-1">Approved Teachers</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full"><?php echo $active_students; ?> active</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_students; ?></p>
            <p class="text-sm text-slate-500 mt-1">Total Students</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
                <span class="text-xs font-medium text-violet-600 bg-violet-50 px-2 py-1 rounded-full">Running</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_batches; ?></p>
            <p class="text-sm text-slate-500 mt-1">Total Batches</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">Offered</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $total_courses; ?></p>
            <p class="text-sm text-slate-500 mt-1">Total Courses</p>
        </div>
    </div>

    <!-- Secondary Stats (4 cards smaller) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M12 11h4"/><path d="M12 16h4"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $total_quizzes; ?></p>
                    <p class="text-xs text-slate-500">Quizzes</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $total_classes; ?></p>
                    <p class="text-xs text-slate-500">Online Classes</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $total_attendance_records; ?></p>
                    <p class="text-xs text-slate-500">Attendance</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-slate-900"><?php echo $pending_teachers + $pending_batches; ?></p>
                    <p class="text-xs text-slate-500">Pending Approvals</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Quick Actions</h2>
                <p class="text-xs text-slate-500 mt-0.5">Frequently used admin tasks</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Teacher Approval</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-violet-300 hover:bg-violet-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2 2 7l10 5 10-5-10-5Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12l10 5 10-5"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Batch Management</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/controller/student/register.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Register Student</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-sky-300 hover:bg-sky-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Manage Students</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/controller/courses_list.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Courses</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/controller/fee_management.php" 
               class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-slate-200 hover:border-teal-300 hover:bg-teal-50/50 transition-all">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Fee Management</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Students -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M22 10v6M2 10l10-5 10 5-10 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Recent Students</h2>
                        <p class="text-xs text-slate-500">Latest registrations</p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
            </div>
            <?php if (empty($recent_students)): ?>
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <p class="text-sm text-slate-500">No students registered yet.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($recent_students as $student): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 text-white text-xs font-semibold flex items-center justify-center flex-shrink-0">
                                                <?php echo strtoupper(substr($student['full_name'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-800"><?php echo htmlspecialchars($student['full_name']); ?></p>
                                                <p class="text-xs text-slate-500"><?php echo htmlspecialchars($student['student_id']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['course_name']); ?></td>
                                    <td class="px-6 py-3 whitespace-nowrap text-xs text-slate-500"><?php echo date('M j, Y', strtotime($student['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Teachers -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Recent Teachers</h2>
                        <p class="text-xs text-slate-500">Latest registrations</p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
            </div>
            <?php if (empty($recent_teachers)): ?>
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <p class="text-sm text-slate-500">No teachers registered yet.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Teacher</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($recent_teachers as $teacher): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 text-white text-xs font-semibold flex items-center justify-center flex-shrink-0">
                                                <?php echo strtoupper(substr($teacher['full_name'], 0, 1)); ?>
                                            </div>
                                            <p class="text-sm font-medium text-slate-800"><?php echo htmlspecialchars($teacher['full_name']); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($teacher['email']); ?></td>
                                    <td class="px-6 py-3 whitespace-nowrap text-xs text-slate-500"><?php echo date('M j, Y', strtotime($teacher['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>