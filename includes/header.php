<?php

require_once __DIR__ . '/../config.php';
require_once SESSION;

$role = getRole();

$user_name = htmlspecialchars(
    $_SESSION['user_name'] ?? 'Guest',
    ENT_QUOTES,
    'UTF-8'
);

$page_title = ucfirst($role ?: 'Home');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        LMS - <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
    </title>
</head>

<body>

<header>
    <nav>

        <!-- Home -->
        <a href="<?= BASE_URL ?>/index.php">Home</a><br>


        <?php if ($role === 'admin'): ?>

            <!-- Admin -->
            <a href="<?= BASE_URL ?>/admin/controller/dashboard.php">
                Admin Dashboard
            </a><br>

            <a href="<?= BASE_URL ?>/admin/controller/teacher/approval.php">
                Teacher Approval
            </a><br>

            <a href="<?= BASE_URL ?>/admin/controller/accountant/approval.php">
                Accountant Approval
            </a><br>

            <a href="<?= BASE_URL ?>/admin/controller/student/register.php">
                Student Register
            </a><br>

            <a href="<?= BASE_URL ?>/admin/controller/student/manage.php">
                Manage Students
            </a><br>

            <a href="<?= BASE_URL ?>/admin/controller/teacher/batch_approval.php">
                Batch Approval
            </a><br>


        <?php elseif ($role === 'teacher'): ?>

            <!-- Teacher -->
            <a href="<?= BASE_URL ?>/teacher/controller/dashboard.php">
                Teacher Dashboard
            </a><br>

            <a href="<?= BASE_URL ?>/teacher/controller/my_students.php">
                Unassigned Students
            </a><br>

            <a href="<?= BASE_URL ?>/teacher/controller/all_students.php">
                All Students
            </a><br>

            <a href="<?= BASE_URL ?>/teacher/controller/create_batch.php">
                Management Batch
            </a><br>

            <a href="<?= BASE_URL ?>/teacher/controller/my_batches.php">
                My Batches
            </a><br>

            <a href="<?= BASE_URL ?>/teacher/controller/quiz_management.php">
                Quiz Management
            </a><br>


        <?php elseif ($role === 'accountant'): ?>

            <!-- Accountant -->
            <a href="<?= BASE_URL ?>/accountant/controller/dashboard.php">
                Accountant Dashboard
            </a><br>


        <?php elseif ($role === 'student'): ?>

            <!-- Student -->
            <a href="<?= BASE_URL ?>/student/controller/dashboard.php">
                Student Dashboard
            </a><br>


        <?php else: ?>

            <!-- Guest -->
            <a href="<?= BASE_URL ?>/accounts/controller/login.php">
                Login
            </a><br>

            <a href="<?= BASE_URL ?>/accounts/controller/register.php">
                Register
            </a><br>

        <?php endif; ?>


        <?php if (isLoggedIn()): ?>

        <form action="<?= BASE_URL ?>/accounts/controller/logout.php" method="POST">
            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>"
            >

            <button type="submit">
                Logout (<?= $user_name ?>)
            </button>
        </form>

        <?php endif; ?>

    </nav>
</header>

<main>