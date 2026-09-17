<?php include AUTH_HEADER; ?>

<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-2xl">

        <!-- Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white text-xl font-bold shadow-lg shadow-indigo-500/25 mb-5">
                L
            </div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Create your account</h1>
            <p class="text-slate-500 text-sm mt-2">Complete the steps below to register</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500"></div>

            <div class="p-8">

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col items-center">
                            <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-indigo-600 text-white shadow-lg shadow-indigo-500/30" id="stepIndicator1">1</div>
                            <span class="text-[11px] mt-2 font-semibold uppercase tracking-wider text-indigo-600">Personal</span>
                        </div>
                        <div class="flex-1 h-0.5 bg-slate-200 mx-3 progress-line" id="progressLine1"></div>
                        <div class="flex flex-col items-center">
                            <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-slate-200 text-slate-500" id="stepIndicator2">2</div>
                            <span class="text-[11px] mt-2 font-semibold uppercase tracking-wider text-slate-400">Account</span>
                        </div>
                        <div class="flex-1 h-0.5 bg-slate-200 mx-3 progress-line" id="progressLine2"></div>
                        <div class="flex flex-col items-center">
                            <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 bg-slate-200 text-slate-500" id="stepIndicator3">3</div>
                            <span class="text-[11px] mt-2 font-semibold uppercase tracking-wider text-slate-400">Role</span>
                        </div>
                    </div>
                    <div class="mt-5 h-1 w-full bg-slate-200 rounded-full overflow-hidden">
                        <div id="progressFill" class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Flash messages -->
                <?php if (!empty($error)): ?>
                    <div class="flex items-start gap-2.5 bg-red-50 border border-red-200 p-3.5 mb-5 rounded-lg">
                        <svg class="h-5 w-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>/accounts/controller/register.php" 
                      id="registerForm" class="relative overflow-hidden" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                    <!-- Step 1 -->
                    <div class="step-panel" data-step="1">
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="full_name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Full Name</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="full_name" name="full_name" 
                                           value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" 
                                           class="w-full pl-11 pr-3 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all text-sm bg-slate-50/50 focus:bg-white"
                                           placeholder="John Doe"
                                           data-validate="required|min:3">
                                </div>
                                <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                            </div>

                            <div class="form-group">
                                <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Email Address</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <input type="email" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" 
                                           class="w-full pl-11 pr-3 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all text-sm bg-slate-50/50 focus:bg-white"
                                           placeholder="you@example.com"
                                           data-validate="required|email">
                                </div>
                                <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step-panel hidden" data-step="2">
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Password</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </span>
                                    <input type="password" id="password" name="password" 
                                           class="w-full pl-11 pr-11 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all text-sm bg-slate-50/50 focus:bg-white"
                                           placeholder="••••••••"
                                           data-validate="required|min:8">
                                    <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-indigo-600 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                                <div class="mt-2.5">
                                    <div class="h-1 w-full bg-slate-200 rounded-full overflow-hidden">
                                        <div id="password-strength-bar" class="h-full bg-red-500 transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <p id="password-strength-text" class="text-[11px] text-slate-500 mt-1.5">Password strength: <span class="font-medium">Too short</span></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contact" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Contact Number</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="contact" name="contact" 
                                           value="<?php echo htmlspecialchars($old['contact'] ?? ''); ?>" 
                                           class="w-full pl-11 pr-3 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all text-sm bg-slate-50/50 focus:bg-white"
                                           placeholder="+92 300 1234567"
                                           data-validate="required|min:10">
                                </div>
                                <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step-panel hidden" data-step="3">
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="role" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Select Your Role</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </span>
                                    <select name="role" id="role" 
                                            class="w-full pl-11 pr-10 py-3 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all text-sm appearance-none bg-slate-50/50 focus:bg-white cursor-pointer"
                                            data-validate="required">
                                        <option value="">-- Select Role --</option>
                                        <option value="admin"    <?php echo (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="teacher"  <?php echo (isset($old['role']) && $old['role'] === 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </div>
                                <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                            </div>

                            <div class="bg-indigo-50/50 border border-indigo-100 rounded-lg p-3.5 flex items-start gap-2.5">
                                <svg class="h-5 w-5 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-indigo-700">Your account will require admin approval before you can login.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between gap-3 mt-8">
                        <button type="button" id="prevBtn" 
                                class="px-5 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium text-sm hover:bg-slate-50 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                            Back
                        </button>
                        <button type="button" id="nextBtn" 
                                class="flex-1 px-5 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-indigo-500/25">
                            Continue
                        </button>
                        <button type="submit" id="submitBtn" 
                                class="flex-1 px-5 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-indigo-500/25 hidden">
                            Create Account
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-3 text-slate-400 font-medium tracking-wider">Already have an account?</span>
                    </div>
                </div>

                <a href="<?php echo BASE_URL; ?>/accounts/controller/login.php" 
                   class="block w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                    Sign In
                </a>
            </div>
        </div>

        <!-- Footer text -->
        <p class="text-center text-xs text-slate-500 mt-8">
            &copy; <?php echo date('Y'); ?> LMS. All rights reserved.
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const stepPanels = form.querySelectorAll('.step-panel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const stepIndicators = document.querySelectorAll('.step-indicator');
    const progressFill = document.getElementById('progressFill');
    const progressLines = document.querySelectorAll('.progress-line');
    let currentStep = 1;

    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');

    function updatePasswordStrength() {
        const password = passwordInput.value;
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/\d/)) strength++;
        if (password.match(/[^a-zA-Z\d]/)) strength++;

        const width = (strength / 4) * 100;
        strengthBar.style.width = width + '%';

        if (strength <= 1) {
            strengthBar.className = 'h-full bg-red-500 transition-all duration-300';
            strengthText.innerHTML = 'Password strength: <span class="font-medium text-red-600">Weak</span>';
        } else if (strength === 2) {
            strengthBar.className = 'h-full bg-amber-500 transition-all duration-300';
            strengthText.innerHTML = 'Password strength: <span class="font-medium text-amber-600">Fair</span>';
        } else if (strength === 3) {
            strengthBar.className = 'h-full bg-blue-500 transition-all duration-300';
            strengthText.innerHTML = 'Password strength: <span class="font-medium text-blue-600">Good</span>';
        } else {
            strengthBar.className = 'h-full bg-emerald-500 transition-all duration-300';
            strengthText.innerHTML = 'Password strength: <span class="font-medium text-emerald-600">Strong</span>';
        }
    }

    passwordInput.addEventListener('input', updatePasswordStrength);
    updatePasswordStrength();

    const toggleBtn = document.querySelector('.password-toggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            const eyeIcon = toggleBtn.querySelector('svg');
            if (type === 'text') {
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        });
    }

    function validateStep(step) {
        const panel = form.querySelector(`.step-panel[data-step="${step}"]`);
        const fields = panel.querySelectorAll('[data-validate]');
        let isValid = true;

        fields.forEach(field => {
            const rules = field.dataset.validate.split('|');
            const value = field.value.trim();
            const errorElement = field.closest('.form-group').querySelector('.error-message');
            let errorMessage = '';

            if (rules.includes('required') && !value) {
                errorMessage = 'This field is required';
            }

            if (!errorMessage && rules.includes('email') && !isValidEmail(value)) {
                errorMessage = 'Please enter a valid email address';
            }

            if (!errorMessage) {
                const minRule = rules.find(r => r.startsWith('min:'));
                if (minRule) {
                    const minLength = parseInt(minRule.split(':')[1]);
                    if (value.length < minLength) {
                        errorMessage = `Minimum ${minLength} characters required`;
                    }
                }
            }

            if (errorMessage) {
                isValid = false;
                field.classList.add('border-red-500');
                field.classList.remove('border-slate-300');
                errorElement.textContent = errorMessage;
                errorElement.classList.remove('hidden');
            } else {
                field.classList.remove('border-red-500');
                field.classList.add('border-slate-300');
                errorElement.classList.add('hidden');
            }
        });

        return isValid;
    }

    function updateStepUI() {
        stepPanels.forEach(panel => panel.classList.add('hidden'));
        form.querySelector(`.step-panel[data-step="${currentStep}"]`).classList.remove('hidden');

        prevBtn.disabled = currentStep === 1;
        prevBtn.classList.toggle('opacity-40', currentStep === 1);
        nextBtn.classList.toggle('hidden', currentStep === 3);
        submitBtn.classList.toggle('hidden', currentStep !== 3);

        stepIndicators.forEach((indicator, index) => {
            const step = index + 1;
            indicator.classList.remove('bg-indigo-600', 'text-white', 'bg-slate-200', 'text-slate-500', 'shadow-lg', 'shadow-indigo-500/30');
            if (step <= currentStep) {
                indicator.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
            } else {
                indicator.classList.add('bg-slate-200', 'text-slate-500');
            }
        });

        const labels = document.querySelectorAll('.step-indicator + span');
        labels.forEach((label, index) => {
            const step = index + 1;
            label.classList.remove('text-indigo-600', 'text-slate-400');
            label.classList.add(step <= currentStep ? 'text-indigo-600' : 'text-slate-400');
        });

        progressLines.forEach((line, index) => {
            if (index < currentStep - 1) {
                line.classList.add('bg-indigo-600');
                line.classList.remove('bg-slate-200');
            } else {
                line.classList.remove('bg-indigo-600');
                line.classList.add('bg-slate-200');
            }
        });

        const fillPercent = ((currentStep - 1) / 2) * 100;
        progressFill.style.width = fillPercent + '%';
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

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let allValid = true;
        for (let i = 1; i <= 3; i++) {
            if (!validateStep(i)) {
                allValid = false;
                currentStep = i;
                updateStepUI();
                break;
            }
        }
        if (allValid) form.submit();
    });

    updateStepUI();

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>

</body>
</html>