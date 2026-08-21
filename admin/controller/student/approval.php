<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['status'])) {
    $user_id = intval($_POST['user_id']);
    $new_status = $_POST['status'];

    if (!in_array($new_status, ['pending', 'approved', 'rejected'])) {
        $error = 'Invalid status selected.';
    } else {
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'student'");
        $stmt->bind_param("si", $new_status, $user_id);
        if ($stmt->execute()) {
            $message = "Student status updated to $new_status.";
        } else {
            $error = 'Failed to update student status.';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT id, full_name, email, contact, status, created_at FROM users WHERE role='student' ORDER BY created_at DESC");

include BASE_PATH . 'admin/view/student/approval.php';

?>