<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Teacher Dashboard</h1>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_batches; ?></p>
            <p class="text-sm text-gray-500">Approved Batches</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_students; ?></p>
            <p class="text-sm text-gray-500">Assigned Students</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_quizzes; ?></p>
            <p class="text-sm text-gray-500">Quizzes Created</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_classes; ?></p>
            <p class="text-sm text-gray-500">Online Classes</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
            <p class="text-3xl font-bold text-indigo-600"><?php echo $total_attendance_records; ?></p>
            <p class="text-sm text-gray-500">Attendance Records</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Create Batch</a>
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">Manage Quizzes</a>
            <a href="<?= BASE_URL ?>/teacher/controller/manage_classes.php" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md">Online Classes</a>
            <a href="<?= BASE_URL ?>/teacher/controller/attendance.php" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md">Mark Attendance</a>
            <a href="<?= BASE_URL ?>/teacher/controller/attendance_report.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">Attendance Report</a>
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_results.php" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">Quiz Results</a>
            <a href="<?= BASE_URL ?>/teacher/controller/quiz_history.php" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md">Quiz History</a>
        </div>
    </div>

    <!-- Recent Quizzes and Classes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Quizzes -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Quizzes</h2>
            <?php if (empty($recent_quizzes)): ?>
                <p class="text-gray-600">No quizzes yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($recent_quizzes as $quiz): ?>
                        <li class="py-2">
                            <p class="font-medium"><?php echo htmlspecialchars($quiz['title']); ?></p>
                            <p class="text-sm text-gray-500">
                                Batch: <?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?> |
                                Status: <?php echo htmlspecialchars($quiz['status']); ?>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Recent Classes -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent / Upcoming Classes</h2>
            <?php if (empty($recent_classes)): ?>
                <p class="text-gray-600">No online classes yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($recent_classes as $class): ?>
                        <li class="py-2">
                            <p class="font-medium"><?php echo htmlspecialchars($class['title']); ?></p>
                            <p class="text-sm text-gray-500">
                                Batch: <?php echo htmlspecialchars($class['batch_name']); ?> |
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