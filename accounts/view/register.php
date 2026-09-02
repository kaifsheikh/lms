<?php include HEADER; ?>

<div class="max-w-md mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-slate-900 mb-1 text-center">Create an account</h2>
        <p class="text-sm text-slate-500 mb-6 text-center">Register to get access to the LMS</p>

        <?php if (!empty($error)): ?>
            <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>/accounts/controller/register.php" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>

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

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contact</label>
                <input type="text" name="contact" value="<?php echo htmlspecialchars($old['contact'] ?? ''); ?>" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>

           <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
            <select name="role" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select Role --</option>
                <option value="admin"    <?php echo (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="teacher"  <?php echo (isset($old['role']) && $old['role'] === 'teacher') ? 'selected' : ''; ?>>Teacher</option>
            </select>
        </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                Register
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">
            Already have an account? <a href="<?php echo BASE_URL; ?>/accounts/controller/login.php" class="text-indigo-600 font-medium hover:text-indigo-700">Login</a>
        </p>
    </div>
</div>

<?php include FOOTER; ?>
