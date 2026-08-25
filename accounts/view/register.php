<?php include HEADER; ?>

<h2>Register</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="<?php echo BASE_URL; ?>/accounts/controller/register.php">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Contact:</label><br>
    <input type="text" name="contact" value="<?php echo htmlspecialchars($old['contact'] ?? ''); ?>" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="admin"    <?php echo (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="teacher"  <?php echo (isset($old['role']) && $old['role'] === 'teacher') ? 'selected' : ''; ?>>Teacher</option>
        <option value="accountant" <?php echo (isset($old['role']) && $old['role'] === 'accountant') ? 'selected' : ''; ?>>Accountant</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

<p>Already have account? <a href="<?php echo BASE_URL; ?>/accounts/controller/login.php">Login</a></p>

<?php include FOOTER; ?>