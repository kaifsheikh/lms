<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Student Info</h1>

    <!-- Search Form -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form method="GET" action="" class="flex items-center space-x-2">
            <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)"
                   value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
                   class="border border-gray-300 rounded-md px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Search
            </button>
        </form>
        <?php if (!empty($error)): ?>
            <p class="text-red-600 mt-2"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>

    <!-- Result Display -->
    <?php if ($searched_student): ?>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Student Details</h2>
            <div class="grid grid-cols-2 gap-4">
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($searched_student['full_name']); ?></p>
                <p><strong>Course Name:</strong> <?php echo htmlspecialchars($searched_student['course_name']); ?></p>
                <p><strong>Class Timing:</strong> <?php echo htmlspecialchars($searched_student['class_timing']); ?></p>
                <p><strong>Course Duration:</strong> <?php echo htmlspecialchars($searched_student['course_duration']); ?> months</p>
                <p><strong>Course End Date:</strong> <?php echo date('j F Y', strtotime($searched_student['course_end_date'])); ?></p>
                <p><strong>Current Progress:</strong> Month <?php echo $searched_student['current_course_month']; ?>, Day <?php echo $searched_student['days_elapsed']; ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>