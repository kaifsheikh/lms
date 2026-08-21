<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

// Agar already login hai to dashboard bhejo
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/' . getRole() . '/controller/dashboard.php');
    exit;
}

$error = '';
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email'     => trim($_POST['email'] ?? ''),
        'contact'   => trim($_POST['contact'] ?? ''),
        'role'      => $_POST['role'] ?? ''
    ];
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($old['full_name']) || empty($old['email']) || empty($password) || empty($old['contact']) || empty($old['role'])) {
        $error = 'All fields are required.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (!in_array($old['role'], ['admin', 'teacher', 'accountant'])) {
        $error = 'Invalid role selected.';
    } else {
        // Email already registered check
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $old['email']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Email already registered.';
        } else {
            // Insert new user with pending status
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $status = 'pending'; // New user always pending
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, contact, role, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $old['full_name'], $old['email'], $hashed_password, $old['contact'], $old['role'], $status);

            if ($stmt->execute()) {
                // Registration successful - login page par bhejo
                $_SESSION['success'] = 'Registration successful! Please wait for admin approval before login.';
                header('Location: login.php'); // Relative path is okay, but can also use BASE_URL
                exit;
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
        $stmt->close();
    }
}

// View include karo
include BASE_PATH . 'accounts/view/register.php';
?>