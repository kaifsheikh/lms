<?php include HEADER; ?>

<h2>Login</h2>

<?php if (!empty($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p>Don't have account? <a href="register.php">Register</a></p>

<?php include FOOTER; ?>