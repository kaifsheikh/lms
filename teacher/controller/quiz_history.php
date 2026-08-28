<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_history') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
    $history_id = intval($_POST['history_id'] ?? 0);
    if ($history_id <= 0) {
        $error = 'Invalid record.';
    } else {
        $stmt = $conn->prepare("DELETE FROM quiz_attempt_history WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $history_id, $teacher_id);
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $message = 'Record deleted successfully.';
        } else {
            $error = 'Record not found or you do not have permission.';
        }
        $stmt->close();
    }
}

// Fetch all history records for this teacher
$history = [];
$stmt = $conn->prepare("
    SELECT id, student_name, quiz_title, attempt_date, percentage, status
    FROM quiz_attempt_history
    WHERE teacher_id = ?
    ORDER BY attempt_date DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/quiz_history.php';
?>