<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

// Flash messages read karo (attendance save ke baad aate hain)
$message = $_SESSION['attendance_msg'] ?? '';
$error = $_SESSION['attendance_error'] ?? '';

// Session se delete karo taake refresh par dobara na dikhe
unset($_SESSION['attendance_msg'], $_SESSION['attendance_error']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$batches = [];

// Sirf approved batches fetch karo jo is teacher ke hain
$stmt = $conn->prepare("
    SELECT id, batch_name, starting_date, batch_time
    FROM batches
    WHERE teacher_id = ? AND status = 'approved'
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}
$stmt->close();

// Agar koi batch nahi hai to error dikhayenge
if (empty($batches)) {
    $error = 'Aapke paas koi approved batch nahi hai. Attendance ke liye batch approved hona chahiye.';
}

// View load karo
include BASE_PATH . 'teacher/view/attendance.php';
?>