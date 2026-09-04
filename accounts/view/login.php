<?php include HEADER; ?>

<div class="w-full max-w-md mx-auto py-8 px-4 sm:px-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
        <!-- Top gradient bar -->
        <div class="h-2 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>

        <div class="p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-3.517-1.009-6.799-2.753-9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11c0 2.331.476 4.548 1.34 6.562M12 11c0-3.517 1.009-6.799 2.753-9.571m3.44-2.04l-.054-.09A13.916 13.916 0 0116 11c0 2.331-.476 4.548-1.34 6.562M12 11a4 4 0 110 8 4 4 0 010-8z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Welcome back</h2>
                <p class="text-sm text-slate-500 mt-1">Sign in to continue to your dashboard</p>
            </div>

            <!-- Flash messages -->
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

            <form method="POST" action="login.php" id="loginForm" class="space-y-5" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" 
                               class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               placeholder="you@example.com"
                               data-validate="required|email">
                    </div>
                    <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" 
                               class="w-full pl-10 pr-10 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               placeholder="••••••••"
                               data-validate="required">
                        <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="error-message hidden text-red-500 text-xs mt-1"></p>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition-colors shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Don't have an account? 
                <a href="register.php" class="text-indigo-600 font-medium hover:text-indigo-700 transition-colors">Register</a>
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const toggleBtn = document.querySelector('.password-toggle');
    const passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            // Change icon
            const eyeIcon = toggleBtn.querySelector('svg');
            if (type === 'text') {
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        });
    }

    // Validation
    const form = document.getElementById('loginForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Email validation
        const emailField = document.getElementById('email');
        const emailError = emailField.closest('.form-group').querySelector('.error-message');
        if (!emailField.value.trim()) {
            emailField.classList.add('border-red-500');
            emailField.classList.remove('border-slate-300');
            emailError.textContent = 'Email is required';
            emailError.classList.remove('hidden');
            isValid = false;
        } else if (!isValidEmail(emailField.value.trim())) {
            emailField.classList.add('border-red-500');
            emailField.classList.remove('border-slate-300');
            emailError.textContent = 'Please enter a valid email';
            emailError.classList.remove('hidden');
            isValid = false;
        } else {
            emailField.classList.remove('border-red-500');
            emailField.classList.add('border-slate-300');
            emailError.classList.add('hidden');
        }

        // Password validation
        const passwordField = document.getElementById('password');
        const passwordError = passwordField.closest('.form-group').querySelector('.error-message');
        if (!passwordField.value) {
            passwordField.classList.add('border-red-500');
            passwordField.classList.remove('border-slate-300');
            passwordError.textContent = 'Password is required';
            passwordError.classList.remove('hidden');
            isValid = false;
        } else {
            passwordField.classList.remove('border-red-500');
            passwordField.classList.add('border-slate-300');
            passwordError.classList.add('hidden');
        }

        if (isValid) {
            form.submit();
        }
    });

    // Real-time validation on blur
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');

    emailField.addEventListener('blur', function() {
        const errorElement = this.closest('.form-group').querySelector('.error-message');
        if (!this.value.trim()) {
            this.classList.add('border-red-500');
            this.classList.remove('border-slate-300');
            errorElement.textContent = 'Email is required';
            errorElement.classList.remove('hidden');
        } else if (!isValidEmail(this.value.trim())) {
            this.classList.add('border-red-500');
            this.classList.remove('border-slate-300');
            errorElement.textContent = 'Please enter a valid email';
            errorElement.classList.remove('hidden');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-slate-300');
            errorElement.classList.add('hidden');
        }
    });

    passwordField.addEventListener('blur', function() {
        const errorElement = this.closest('.form-group').querySelector('.error-message');
        if (!this.value) {
            this.classList.add('border-red-500');
            this.classList.remove('border-slate-300');
            errorElement.textContent = 'Password is required';
            errorElement.classList.remove('hidden');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-slate-300');
            errorElement.classList.add('hidden');
        }
    });

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>

<?php include FOOTER; ?>