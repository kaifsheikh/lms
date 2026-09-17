<?php include AUTH_HEADER; ?>

<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">

        <!-- Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white text-xl font-bold shadow-lg shadow-indigo-500/25 mb-5">
                L
            </div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Welcome back</h1>
            <p class="text-slate-500 text-sm mt-2">Sign in to continue to your dashboard</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500"></div>

            <div class="p-8">
                <!-- Flash messages -->
                <?php if (!empty($success)): ?>
                    <div class="flex items-start gap-2.5 bg-emerald-50 border border-emerald-200 p-3.5 mb-5 rounded-lg">
                        <svg class="h-5 w-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-emerald-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="flex items-start gap-2.5 bg-red-50 border border-red-200 p-3.5 mb-5 rounded-lg">
                        <svg class="h-5 w-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php" id="loginForm" class="space-y-5" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                    <!-- Email -->
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
                                   autocomplete="email">
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                    </div>

                    <!-- Password -->
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
                                   autocomplete="current-password">
                            <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-indigo-600 transition-colors" aria-label="Toggle password visibility">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="error-message hidden text-red-500 text-xs mt-1.5"></p>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0">
                            <span class="text-xs text-slate-600 group-hover:text-slate-800 transition-colors">Remember me</span>
                        </label>
                        <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Forgot password?</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 active:from-indigo-800 active:to-violet-800 text-white font-semibold py-3 px-4 rounded-xl transition-all shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm">
                        <span class="inline-flex items-center justify-center gap-2">
                            Sign In
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-3 text-slate-400 font-medium tracking-wider">New here?</span>
                    </div>
                </div>

                <!-- Register -->
                <a href="register.php" 
                   class="block w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                    Create an Account
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
    const toggleBtn = document.querySelector('.password-toggle');
    const passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
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

    const form = document.getElementById('loginForm');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showError(field, message) {
        const errorElement = field.closest('.form-group').querySelector('.error-message');
        field.classList.add('border-red-500');
        field.classList.remove('border-slate-300');
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }

    function clearError(field) {
        const errorElement = field.closest('.form-group').querySelector('.error-message');
        field.classList.remove('border-red-500');
        field.classList.add('border-slate-300');
        errorElement.classList.add('hidden');
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        if (!emailField.value.trim()) {
            showError(emailField, 'Email is required');
            isValid = false;
        } else if (!isValidEmail(emailField.value.trim())) {
            showError(emailField, 'Please enter a valid email');
            isValid = false;
        } else {
            clearError(emailField);
        }

        if (!passwordField.value) {
            showError(passwordField, 'Password is required');
            isValid = false;
        } else {
            clearError(passwordField);
        }

        if (isValid) form.submit();
    });

    emailField.addEventListener('blur', function() {
        if (!this.value.trim()) showError(this, 'Email is required');
        else if (!isValidEmail(this.value.trim())) showError(this, 'Please enter a valid email');
        else clearError(this);
    });

    passwordField.addEventListener('blur', function() {
        if (!this.value) showError(this, 'Password is required');
        else clearError(this);
    });
});
</script>

</body>
</html>