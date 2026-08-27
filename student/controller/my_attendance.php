<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$attendance_records = [];

// Fetch attendance records
$stmt = $conn->prepare("
    SELECT a.date, a.status, b.batch_name
    FROM attendance a
    INNER JOIN batches b ON a.batch_id = b.id
    WHERE a.student_id = ?
    ORDER BY a.date DESC
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $attendance_records[] = $row;
}
$stmt->close();

// Summary counts
$summary = ['present' => 0, 'absent' => 0, 'late' => 0, 'leave' => 0];
foreach ($attendance_records as $rec) {
    if (isset($summary[$rec['status']])) {
        $summary[$rec['status']]++;
    }
}
$total_records = count($attendance_records);

// Attendance percentage (present + late ko present maan lo)
$present_like_count = $summary['present'] + $summary['late'];
$attendance_percentage = ($total_records > 0) ? round(($present_like_count / $total_records) * 100, 2) : 0;

include BASE_PATH . 'student/view/my_attendance.php';
?>