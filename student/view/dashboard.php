<?php include HEADER; ?>

<h1>Student Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
<p>Your student account is active.</p>

<?php include FOOTER; ?>