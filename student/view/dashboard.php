<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-md p-6 mb-8 text-white">
        <h1 class="text-2xl font-semibold mb-1">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Student'); ?></h1>
        <p class="text-blue-200 text-sm"><?php echo date('l, F j, Y'); ?></p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-blue-600"><?php echo $available_quizzes; ?></p>
            <p class="text-sm text-gray-500 mt-1">Available Quizzes</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-blue-600"><?php echo $attempted_quizzes; ?></p>
            <p class="text-sm text-gray-500 mt-1">Quizzes Attempted</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-blue-600"><?php echo $upcoming_classes; ?></p>
            <p class="text-sm text-gray-500 mt-1">Upcoming Classes</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <p class="text-3xl font-bold text-blue-600"><?php echo $attendance_percentage; ?>%</p>
            <p class="text-sm text-gray-500 mt-1">Attendance</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/student/controller/quizzes.php" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                Take Quiz
            </a>
            <a href="<?= BASE_URL ?>/student/controller/results.php" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                My Results
            </a>
            <a href="<?= BASE_URL ?>/student/controller/my_classes.php" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-md transition-colors">
                My Classes
            </a>
            <a href="<?= BASE_URL ?>/student/controller/my_attendance.php" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-md transition-colors">
                My Attendance
            </a>
        </div>
    </div>

    <!-- Recent Results and Upcoming Classes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Results -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Quiz Results</h2>
            <?php if (empty($recent_results)): ?>
                <p class="text-gray-500">No quiz results yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-100">
                    <?php foreach ($recent_results as $result): ?>
                        <li class="py-3">
                            <p class="font-medium text-gray-800"><?php echo htmlspecialchars($result['title']); ?></p>
                            <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                <span class="font-semibold"><?php echo $result['percentage']; ?>%</span>
                                <span><?php echo date('M j, Y', strtotime($result['submitted_at'])); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Upcoming Classes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Classes</h2>
            <?php if (empty($upcoming_classes_list)): ?>
                <p class="text-gray-500">No upcoming classes.</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-100">
                    <?php foreach ($upcoming_classes_list as $class): ?>
                        <li class="py-3">
                            <p class="font-medium text-gray-800"><?php echo htmlspecialchars($class['title']); ?></p>
                            <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                <span><?php echo date('M j, g:i A', strtotime($class['start_time'])); ?></span>
                                <span class="bg-gray-100 px-2 py-1 rounded-full text-xs">Token: <?php echo htmlspecialchars($class['token']); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>