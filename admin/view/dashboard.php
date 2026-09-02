<?php include HEADER; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 p-6 sm:p-8 mb-8 text-white">
        <div class="relative z-10">
            <p class="text-indigo-300 text-sm font-medium"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-2xl sm:text-3xl font-semibold mt-1">Admin Dashboard</h1>
            <p class="text-slate-300 text-sm mt-2 max-w-lg">Ek nazar mein aapke institute ki poori activity — students, teachers, batches aur quizzes.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-indigo-500/10"></div>
        <div class="absolute -right-24 -bottom-16 w-56 h-56 rounded-full bg-indigo-500/10"></div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_teachers; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Approved Teachers</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_students; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Total Students</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_accountants; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Approved Accountants</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_batches; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Total Batches</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $total_quizzes; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Total Quizzes</p>
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
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
            </div>
            <p class="text-2xl font-semibold text-slate-900"><?php echo $pending_teachers; ?> <span class="text-slate-300">/</span> <?php echo $pending_batches; ?></p>
            <p class="text-sm text-slate-500 mt-0.5">Pending (Teachers / Batches)</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Administrative Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                Teacher Approval
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/accountant/approval.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                Accountant Approval
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/student/register.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                Student Registration
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                Manage Students
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                Batch Approval
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
                Attendance Progress
            </a>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Students -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Recent Students</h2>
            <?php if (empty($recent_students)): ?>
                <p class="text-sm text-slate-500">No students registered yet.</p>
            <?php else: ?>
                <div class="overflow-x-auto -mx-6">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Name</th>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Course</th>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($recent_students as $student): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['student_id']); ?></td>
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($student['full_name']); ?></td>
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['course_name']); ?></td>
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm text-slate-500"><?php echo date('M j, Y', strtotime($student['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Teachers -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Recent Teachers</h2>
            <?php if (empty($recent_teachers)): ?>
                <p class="text-sm text-slate-500">No teachers registered yet.</p>
            <?php else: ?>
                <div class="overflow-x-auto -mx-6">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Name</th>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                                <th class="px-6 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($recent_teachers as $teacher): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($teacher['full_name']); ?></td>
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($teacher['email']); ?></td>
                                    <td class="px-6 py-2.5 whitespace-nowrap text-sm text-slate-500"><?php echo date('M j, Y', strtotime($teacher['created_at'])); ?></td>
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
