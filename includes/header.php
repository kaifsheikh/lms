<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/session.php';

$role = getRole();
$user_name = $_SESSION['user_name'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - <?php echo ucfirst($role) ?: 'Home'; ?></title>
</head>
<body>

<header>
    <nav>
        <a href="<?php echo BASE_URL; ?>/index.php">Home</a> <br>

        <?php if ($role === 'admin'): ?>
            <a href="<?php echo BASE_URL; ?>/admin/controller/dashboard.php">Admin Dashboard</a> <br>
            <a href="<?php echo BASE_URL; ?>/admin/controller/teacher/approval.php">Teacher Approval</a> <br>
            <a href="<?php echo BASE_URL; ?>/admin/controller/accountant/approval.php">Accountant Approval</a> <br>
            <a href="<?php echo BASE_URL; ?>/admin/controller/student/register.php">Student Register</a> <br>
            <a href="<?php echo BASE_URL; ?>/admin/controller/student/manage.php">Manage Students</a> <br>
            <a href="<?php echo BASE_URL; ?>/admin/controller/teacher/batch_approval.php">Batch Approval</a> <br>

        <?php elseif ($role === 'teacher'): ?>
            <a href="<?php echo BASE_URL; ?>/teacher/controller/dashboard.php">Teacher Dashboard</a> <br>
            <a href="<?php echo BASE_URL; ?>/teacher/controller/my_students.php">Unassigned Students</a> <br>
            <a href="<?php echo BASE_URL; ?>/teacher/controller/all_students.php">All Students</a> <br>
            <a href="<?php echo BASE_URL; ?>/teacher/controller/create_batch.php">Management Batch</a> <br>
            <a href="<?php echo BASE_URL; ?>/teacher/controller/my_batches.php">My Batches</a> <br>

        <?php elseif ($role === 'accountant'): ?>
            <a href="<?php echo BASE_URL; ?>/accountant/controller/dashboard.php">Accountant Dashboard</a> <br>
        
        <?php elseif ($role === 'student'): ?> 
            <a href="<?php echo BASE_URL; ?>/student/controller/dashboard.php">Student Dashboard</a> <br>

        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/accounts/controller/login.php">Login</a> <br>
            <a href="<?php echo BASE_URL; ?>/accounts/controller/register.php">Register</a> <br>

        <?php endif; ?>

        <?php if (isLoggedIn()): ?>
            <a href="<?php echo BASE_URL; ?>/accounts/controller/logout.php">Logout (<?php echo htmlspecialchars($user_name); ?>)</a> <br>
        <?php endif; ?>
    </nav>
</header>

<main>