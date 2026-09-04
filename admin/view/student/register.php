<?php include HEADER; ?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden">
        <!-- Top gradient bar -->
        <div class="h-2 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>

        <div class="p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-2 text-center">Register New Student</h1>
            <p class="text-sm text-slate-500 mb-6 text-center">Complete the steps below to add a student</p>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-indigo-600 text-white" data-step-indicator="1">1</div>
                        <span class="text-xs mt-2 font-medium text-indigo-600 step-label" data-step-label="1">Personal Info</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-slate-200 mx-2 progress-line" data-progress-line="1"></div>
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-slate-200 text-slate-500" data-step-indicator="2">2</div>
                        <span class="text-xs mt-2 font-medium text-slate-400 step-label" data-step-label="2">Login Details</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-slate-200 mx-2 progress-line" data-progress-line="2"></div>
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-slate-200 text-slate-500" data-step-indicator="3">3</div>
                        <span class="text-xs mt-2 font-medium text-slate-400 step-label" data-step-label="3">Course Details</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-slate-200 mx-2 progress-line" data-progress-line="3"></div>
                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-slate-200 text-slate-500" data-step-indicator="4">4</div>
                        <span class="text-xs mt-2 font-medium text-slate-400 step-label" data-step-label="4">Documents</span>
                    </div>
                </div>
                <!-- Progress fill -->
                <div class="mt-4 h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div id="progressFill" class="h-full bg-indigo-600 transition-all duration-500" style="width: 25%"></div>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (!empty($success)): ?>
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                    <p class="text-green-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                </div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                    <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/register.php" enctype="multipart/form-data" id="studentRegisterForm" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                <!-- Step 1: Personal Information -->
                <div class="step-panel" data-step="1">
                    <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-4">Personal Information</h3>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="full_name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="John Doe">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="block text-sm font-medium text-slate-700 mb-1">Father Name</label>
                            <input type="text" id="father_name" name="father_name" value="<?php echo htmlspecialchars($old['father_name'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="Robert Doe">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-1">Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($old['contact_number'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="+92 300 1234567">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="block text-sm font-medium text-slate-700 mb-1">Gender</label>
                            <select id="gender" name="gender" required
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="">-- Select --</option>
                                <option value="male"   <?php echo (isset($old['gender']) && $old['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo (isset($old['gender']) && $old['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                                <option value="other"  <?php echo (isset($old['gender']) && $old['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="block text-sm font-medium text-slate-700 mb-1">Date of Birth</label>
                            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Address</label>
                            <textarea id="address" name="address" required rows="3"
                                      class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                      placeholder="Street, City, State"><?php echo htmlspecialchars($old['address'] ?? ''); ?></textarea>
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Login Details -->
                <div class="step-panel hidden" data-step="2">
                    <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-4">Login Details</h3>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="student@example.com">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <input type="password" id="password" name="password" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="••••••••">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Course Details -->
                <div class="step-panel hidden" data-step="3">
                    <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-4">Course Details</h3>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="joining_date" class="block text-sm font-medium text-slate-700 mb-1">Joining Date</label>
                            <input type="date" id="joining_date" name="joining_date" value="<?php echo htmlspecialchars($old['joining_date'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="course_id" class="block text-sm font-medium text-slate-700 mb-1">Course</label>
                            <select id="course_id" name="course_id" required
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="">-- Select Course --</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo $course['id']; ?>"
                                        <?php echo (isset($old['course_id']) && $old['course_id'] == $course['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($course['course_name']) . ' - ' . $course['duration'] . ' months'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="teacher_id" class="block text-sm font-medium text-slate-700 mb-1">Assign Teacher</label>
                            <select id="teacher_id" name="teacher_id" required
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="">-- Select Teacher --</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?php echo $teacher['id']; ?>"
                                        <?php echo (isset($old['teacher_id']) && $old['teacher_id'] == $teacher['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($teacher['full_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select id="status" name="status" required
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="pending" <?php echo (isset($old['status']) && $old['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="process" <?php echo (isset($old['status']) && $old['status'] === 'process') ? 'selected' : ''; ?>>Process</option>
                                <option value="active"  <?php echo (isset($old['status']) && $old['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                            </select>
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="class_timing" class="block text-sm font-medium text-slate-700 mb-1">Class Timing (Desired)</label>
                            <input type="text" id="class_timing" name="class_timing" value="<?php echo htmlspecialchars($old['class_timing'] ?? ''); ?>" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="e.g., Morning 9-11, Evening 6-8">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="highest_education" class="block text-sm font-medium text-slate-700 mb-1">Highest Education</label>
                            <select id="highest_education" name="highest_education" required
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="">-- Select --</option>
                                <option value="matric"         <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'matric') ? 'selected' : ''; ?>>Matric</option>
                                <option value="intermediate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                <option value="undergraduate"  <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'undergraduate') ? 'selected' : ''; ?>>Undergraduate</option>
                                <option value="postgraduate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'postgraduate') ? 'selected' : ''; ?>>Postgraduate</option>
                            </select>
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Documents -->
                <div class="step-panel hidden" data-step="4">
                    <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-4">Documents</h3>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="student_pic" class="block text-sm font-medium text-slate-700 mb-1">Student Picture (Max 2MB)</label>
                            <input type="file" id="student_pic" name="student_pic" accept="image/jpeg, image/png, image/gif, image/webp" required
                                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                        <div class="form-group">
                            <label for="cnic_pic" class="block text-sm font-medium text-slate-700 mb-1">CNIC Picture (Max 2MB)</label>
                            <input type="file" id="cnic_pic" name="cnic_pic" accept="image/jpeg, image/png, image/gif, image/webp" required
                                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="prevBtn"
                            class="px-6 py-2.5 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Back
                    </button>
                    <button type="button" id="nextBtn"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        Next
                    </button>
                    <button type="submit" id="submitBtn"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors hidden">
                        Register Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentRegisterForm');
    const stepPanels = form.querySelectorAll('.step-panel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const stepIndicators = document.querySelectorAll('.step-indicator');
    const stepLabels = document.querySelectorAll('.step-label');
    const progressLines = document.querySelectorAll('.progress-line');
    const progressFill = document.getElementById('progressFill');
    let currentStep = 1;
    const totalSteps = 4;

    function updateStepUI() {
        // Hide all panels
        stepPanels.forEach(panel => panel.classList.add('hidden'));
        // Show current panel
        form.querySelector(`.step-panel[data-step="${currentStep}"]`).classList.remove('hidden');

        // Update buttons
        prevBtn.disabled = currentStep === 1;
        prevBtn.classList.toggle('opacity-50', currentStep === 1);
        nextBtn.classList.toggle('hidden', currentStep === totalSteps);
        submitBtn.classList.toggle('hidden', currentStep !== totalSteps);

        // Update step indicators
        stepIndicators.forEach((indicator, index) => {
            const step = index + 1;
            indicator.classList.remove('bg-indigo-600', 'text-white', 'bg-slate-200', 'text-slate-500');
            if (step === currentStep) {
                indicator.classList.add('bg-indigo-600', 'text-white');
            } else if (step < currentStep) {
                indicator.classList.add('bg-indigo-600', 'text-white');
            } else {
                indicator.classList.add('bg-slate-200', 'text-slate-500');
            }
        });

        // Update labels
        stepLabels.forEach((label, index) => {
            const step = index + 1;
            label.classList.remove('text-indigo-600', 'text-slate-400');
            if (step <= currentStep) {
                label.classList.add('text-indigo-600');
            } else {
                label.classList.add('text-slate-400');
            }
        });

        // Update progress lines
        progressLines.forEach((line, index) => {
            if (index < currentStep - 1) {
                line.classList.add('bg-indigo-600');
                line.classList.remove('bg-slate-200');
            } else {
                line.classList.remove('bg-indigo-600');
                line.classList.add('bg-slate-200');
            }
        });

        // Update progress fill width
        const fillPercent = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressFill.style.width = fillPercent + '%';
    }

    function validateStep(step) {
        const panel = form.querySelector(`.step-panel[data-step="${step}"]`);
        const fields = panel.querySelectorAll('input, select, textarea');
        let isValid = true;

        fields.forEach(field => {
            // Skip file inputs for simple validation (they are required but we can check if file selected)
            if (field.type === 'file') {
                if (field.hasAttribute('required') && !field.files.length) {
                    isValid = false;
                    showError(field, 'This file is required');
                } else {
                    clearError(field);
                }
                return;
            }

            if (field.hasAttribute('required') && !field.value.trim()) {
                isValid = false;
                showError(field, 'This field is required');
            } else if (field.type === 'email' && field.value.trim() && !isValidEmail(field.value.trim())) {
                isValid = false;
                showError(field, 'Please enter a valid email');
            } else {
                clearError(field);
            }
        });

        return isValid;
    }

    function showError(field, message) {
        field.classList.add('border-red-500');
        field.classList.remove('border-slate-300');
        const errorElement = field.parentElement.querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    }

    function clearError(field) {
        field.classList.remove('border-red-500');
        field.classList.add('border-slate-300');
        const errorElement = field.parentElement.querySelector('.error-message');
        if (errorElement) {
            errorElement.classList.add('hidden');
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            updateStepUI();
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepUI();
        }
    });

    // Final submit validation: ensure all steps valid
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let allValid = true;
        for (let i = 1; i <= totalSteps; i++) {
            if (!validateStep(i)) {
                allValid = false;
                currentStep = i;
                updateStepUI();
                break;
            }
        }
        if (allValid) {
            form.submit();
        }
    });

    // Initialize
    updateStepUI();
});
</script>

<?php include FOOTER; ?>