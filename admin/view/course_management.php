<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Course</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Name:</label>
                    <input type="text" name="course_name" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (months):</label>
                    <input type="number" name="duration" min="1" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admission Fee:</label>
                    <input type="number" step="0.01" name="admission_fee" min="0" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Price:</label>
                    <input type="number" step="0.01" name="total_price" min="0" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skill Level:</label>
                    <select name="skill_level" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Schedule:</label>
                    <input type="text" name="schedule" required class="border border-gray-300 rounded-md px-3 py-2 w-full" placeholder="Monday - Friday">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Hours:</label>
                    <input type="text" name="class_hours" required class="border border-gray-300 rounded-md px-3 py-2 w-full" placeholder="2 Hours">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Add Course</button>
        </form>
    </div>

    <p class="mt-4">
        <a href="<?php echo BASE_URL; ?>/admin/controller/courses_list.php" class="text-indigo-600 hover:text-indigo-800">All Course List</a>
    </p>
</div>

<?php include FOOTER; ?>