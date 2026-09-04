<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Page heading -->
    <div class="flex items-center gap-3 mb-8">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </span>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Add New Course</h1>
            <p class="text-sm text-gray-500 mt-1">Fill in the details to create a new course.</p>
        </div>
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

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <!-- Top gradient bar -->
        <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>
        <div class="p-6 sm:p-8">
            <form method="POST" action="" id="addCourseForm" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Course Name -->
                    <div class="form-group">
                        <label for="course_name" class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </span>
                            <input type="text" id="course_name" name="course_name" 
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="e.g., Web Development"
                                   data-validate="required|min:3">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Duration -->
                    <div class="form-group">
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (months)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <input type="number" id="duration" name="duration" min="1" 
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="e.g., 6"
                                   data-validate="required|numeric|min:1">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Admission Fee -->
                    <div class="form-group">
                        <label for="admission_fee" class="block text-sm font-medium text-gray-700 mb-1">Admission Fee</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <input type="number" id="admission_fee" step="0.01" name="admission_fee" min="0" 
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="0.00"
                                   data-validate="required|numeric|min:0">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Total Price -->
                    <div class="form-group">
                        <label for="total_price" class="block text-sm font-medium text-gray-700 mb-1">Total Price</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <input type="number" id="total_price" step="0.01" name="total_price" min="0" 
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="0.00"
                                   data-validate="required|numeric|min:0">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Skill Level -->
                    <div class="form-group">
                        <label for="skill_level" class="block text-sm font-medium text-gray-700 mb-1">Skill Level</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <select id="skill_level" name="skill_level" 
                                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all appearance-none"
                                    data-validate="required">
                                <option value="">Select Skill Level</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Schedule -->
                    <div class="form-group">
                        <label for="schedule" class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="text" id="schedule" name="schedule" 
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="Monday - Friday"
                                   data-validate="required">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Class Hours -->
                    <div class="form-group">
                        <label for="class_hours" class="block text-sm font-medium text-gray-700 mb-1">Class Hours</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <input type="text" id="class_hours" name="class_hours" 
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="2 Hours"
                                   data-validate="required">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                    </div>

                    <!-- Course Outline (full width) -->
                    <div class="md:col-span-2 form-group">
                        <label for="outline" class="block text-sm font-medium text-gray-700 mb-1">Course Outline <span class="text-gray-400 text-xs">(one point per line)</span></label>
                        <textarea id="outline" name="outline" rows="6" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-y"
                                  placeholder="HTML & CSS&#10;JavaScript Basics&#10;React Fundamentals"
                                  data-validate="required"></textarea>
                        <p class="error-message hidden text-red-500 text-xs mt-1"></p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addCourseForm');

    // Real-time validation on blur
    form.querySelectorAll('[data-validate]').forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        form.querySelectorAll('[data-validate]').forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        if (isValid) {
            form.submit();
        }
    });

    function validateField(field) {
        const rules = field.dataset.validate.split('|');
        const value = field.value.trim();
        const errorElement = field.closest('.form-group').querySelector('.error-message');
        let errorMessage = '';

        // Required
        if (rules.includes('required') && !value) {
            errorMessage = 'This field is required';
        }

        // Numeric
        if (!errorMessage && rules.includes('numeric') && value && isNaN(value)) {
            errorMessage = 'Please enter a valid number';
        }

        // Min value
        if (!errorMessage && rules.includes('min')) {
            const minRule = rules.find(r => r.startsWith('min:'));
            if (minRule) {
                const minVal = parseFloat(minRule.split(':')[1]);
                if (value && parseFloat(value) < minVal) {
                    errorMessage = `Minimum value is ${minVal}`;
                }
            }
        }

        // Min length
        if (!errorMessage && rules.includes('min-length')) {
            const minLenRule = rules.find(r => r.startsWith('min-length:'));
            if (minLenRule) {
                const minLen = parseInt(minLenRule.split(':')[1]);
                if (value && value.length < minLen) {
                    errorMessage = `Minimum ${minLen} characters required`;
                }
            }
        }

        // Show/hide error
        if (errorMessage) {
            field.classList.add('border-red-500');
            field.classList.remove('border-gray-300');
            errorElement.textContent = errorMessage;
            errorElement.classList.remove('hidden');
            return false;
        } else {
            field.classList.remove('border-red-500');
            field.classList.add('border-gray-300');
            errorElement.classList.add('hidden');
            return true;
        }
    }
});
</script>

<?php include FOOTER; ?>