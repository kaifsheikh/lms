<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Page heading -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Add New Course</h1>
        <p class="text-sm text-gray-500 mt-1">Fill in the details to create a new course.</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
            <p class="text-green-700"><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
        <div class="p-6 sm:p-8">
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Course Name -->
                    <div>
                        <label for="course_name" class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                        <input type="text" id="course_name" name="course_name" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="e.g., Web Development">
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (months)</label>
                        <input type="number" id="duration" name="duration" min="1" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="e.g., 6">
                    </div>

                    <!-- Admission Fee -->
                    <div>
                        <label for="admission_fee" class="block text-sm font-medium text-gray-700 mb-1">Admission Fee</label>
                        <input type="number" id="admission_fee" step="0.01" name="admission_fee" min="0" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="0.00">
                    </div>

                    <!-- Total Price -->
                    <div>
                        <label for="total_price" class="block text-sm font-medium text-gray-700 mb-1">Total Price</label>
                        <input type="number" id="total_price" step="0.01" name="total_price" min="0" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="0.00">
                    </div>

                    <!-- Skill Level -->
                    <div>
                        <label for="skill_level" class="block text-sm font-medium text-gray-700 mb-1">Skill Level</label>
                        <select id="skill_level" name="skill_level" required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <label for="schedule" class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
                        <input type="text" id="schedule" name="schedule" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="Monday - Friday">
                    </div>

                    <!-- Class Hours -->
                    <div>
                        <label for="class_hours" class="block text-sm font-medium text-gray-700 mb-1">Class Hours</label>
                        <input type="text" id="class_hours" name="class_hours" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="2 Hours">
                    </div>

                    <!-- Course Outline (full width) -->
                    <div class="md:col-span-2">
                        <label for="outline" class="block text-sm font-medium text-gray-700 mb-1">Course Outline <span class="text-gray-400 text-xs">(one point per line)</span></label>
                        <textarea id="outline" name="outline" rows="6" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-y"
                                  placeholder="HTML & CSS&#10;JavaScript Basics&#10;React Fundamentals"></textarea>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="mt-8 flex items-center justify-end">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm hover:shadow-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Course
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Back link -->
    <p class="mt-6">
        <a href="<?php echo BASE_URL; ?>/admin/controller/courses_list.php" 
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Course List
        </a>
    </p>
</div>

<?php include FOOTER; ?>