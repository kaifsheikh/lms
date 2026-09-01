<?php include HEADER; ?>

<div class="max-w-md mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-slate-900 mb-1 text-center">Welcome back</h2>
        <p class="text-sm text-slate-500 mb-6 text-center">Sign in to continue to your dashboard</p>

        <?php if (!empty($success)): ?>
            <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
                <?php echo htmlspecialchars($success); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">
            Don't have an account? <a href="register.php" class="text-indigo-600 font-medium hover:text-indigo-700">Register</a>
        </p>
    </div>
</div>

<?php include FOOTER; ?>
