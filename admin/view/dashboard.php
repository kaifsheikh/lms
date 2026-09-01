<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-md p-6 mb-8 text-white">
        <h1 class="text-2xl font-semibold mb-1">Admin Dashboard</h1>
        <p class="text-gray-300 text-sm"><?php echo date('l, F j, Y'); ?></p>
    </div>

    <!-- Quick Stats Cards (Main) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_teachers; ?></p>
            <p class="text-sm text-gray-500 mt-1">Approved Teachers</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_students; ?></p>
            <p class="text-sm text-gray-500 mt-1">Total Students</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_accountants; ?></p>
            <p class="text-sm text-gray-500 mt-1">Approved Accountants</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_batches; ?></p>
            <p class="text-sm text-gray-500 mt-1">Total Batches</p>
        </div>
    </div>

    <!-- Additional Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-green-600"><?php echo $total_quizzes; ?></p>
            <p class="text-sm text-gray-500 mt-1">Total Quizzes</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-purple-600"><?php echo $total_classes; ?></p>
            <p class="text-sm text-gray-500 mt-1">Online Classes</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-yellow-600"><?php echo $total_attendance_records; ?></p>
            <p class="text-sm text-gray-500 mt-1">Attendance Records</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-bold text-red-600"><?php echo $pending_teachers; ?></p>
                <p class="text-3xl font-bold text-red-600"><?php echo $pending_batches; ?></p>
            </div>
            <p class="text-sm text-gray-500 mt-1">Pending (Teachers / Batches)</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Administrative Actions</h2>
        <div class="flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                Teacher Approval
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/accountant/approval.php" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                Accountant Approval
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/student/register.php" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                Student Registration
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/student/manage.php" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-md transition-colors">
                Manage Students
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-md transition-colors">
                Batch Approval
            </a>
            <a href="<?= BASE_URL ?>/admin/controller/attendance_progress.php" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                Attendance Progress
            </a>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Students -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Students</h2>
            <?php if (empty($recent_students)): ?>
                <p class="text-gray-500">No students registered yet.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($recent_students as $student): ?>
                                <tr>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($student['student_id']); ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($student['full_name']); ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm"><?php echo htmlspecialchars($student['course_name']); ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo date('M j, Y', strtotime($student['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Teachers -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Teachers</h2>
            <?php if (empty($recent_teachers)): ?>
                <p class="text-gray-500">No teachers registered yet.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($recent_teachers as $teacher): ?>
                                <tr>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($teacher['full_name']); ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm"><?php echo htmlspecialchars($teacher['email']); ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo date('M j, Y', strtotime($teacher['created_at'])); ?></td>
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