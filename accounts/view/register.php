<?php include HEADER; ?>

<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Register</h2>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>/accounts/controller/register.php" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password:</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contact:</label>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($old['contact'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role:</label>
            <select name="role" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Role --</option>
                <option value="admin"    <?php echo (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="teacher"  <?php echo (isset($old['role']) && $old['role'] === 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                <option value="accountant" <?php echo (isset($old['role']) && $old['role'] === 'accountant') ? 'selected' : ''; ?>>Accountant</option>
            </select>
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
            Register
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Already have account? <a href="<?php echo BASE_URL; ?>/accounts/controller/login.php" class="text-blue-600 hover:underline">Login</a>
    </p>
</div>

<?php include FOOTER; ?>