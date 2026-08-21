<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/' . getRole() . '/controller/dashboard.php');
    exit;
}

$error = '';
$old = [];
$success = '';

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['email'] = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($old['email']) || empty($password)) {
        $error = 'Email and password are required.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        $role = '';
        $user_id = null;
        $full_name = '';
        $hashed_password = '';
        $status = '';

        // First check users table (admin, teacher, accountant)
        $stmt = $conn->prepare("SELECT id, full_name, password, role, status FROM users WHERE email = ?");
        $stmt->bind_param("s", $old['email']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $full_name, $hashed_password, $role, $status);
            $stmt->fetch();
        } else {
            $stmt->close();

            // Check students table
            $stmt = $conn->prepare("SELECT id, full_name, password, 'student' as role, status FROM students WHERE email = ?");
            $stmt->bind_param("s", $old['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $full_name, $hashed_password, $role, $status);
                $stmt->fetch();
            } else {
                $error = 'No account found with this email.';
            }
        }

        if (empty($error)) {
            if (password_verify($password, $hashed_password)) {
                // Status check
                if ($role === 'student') {
                    // Student status: pending, process, active
                    if ($status === 'pending') {
                        $error = 'Your student account is pending approval.';
                    } elseif ($status === 'process') {
                        $error = 'Your student application is under process.';
                    } elseif ($status === 'active') {
                        // Allow login
                        $_SESSION['user_id']   = $user_id;
                        $_SESSION['user_name'] = $full_name;
                        $_SESSION['role']      = $role;
                        header('Location: ' . BASE_URL . '/student/controller/dashboard.php');
                        exit;
                    } else {
                        $error = 'Invalid student status.';
                    }
                } else {
                    // Users table (admin, teacher, accountant)
                    if ($status === 'pending') {
                        $error = 'Your account is pending approval by admin.';
                    } elseif ($status === 'rejected') {
                        $error = 'Your account has been rejected by admin.';
                    } else {
                        $_SESSION['user_id']   = $user_id;
                        $_SESSION['user_name'] = $full_name;
                        $_SESSION['role']      = $role;
                        header('Location: ' . BASE_URL . '/' . $role . '/controller/dashboard.php');
                        exit;
                    }
                }
            } else {
                $error = 'Incorrect password.';
            }
        }
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

include BASE_PATH . 'accounts/view/login.php';
?>