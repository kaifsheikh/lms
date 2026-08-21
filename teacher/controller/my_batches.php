<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

// Fetch all batches created by this teacher
$batches = [];
$stmt = $conn->prepare("
    SELECT b.id, b.batch_name, b.starting_date, b.batch_time, b.status, b.created_at
    FROM batches b
    WHERE b.teacher_id = ?
    ORDER BY b.created_at DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // Fetch students for this batch
    $batch_id = $row['id'];
    $students_stmt = $conn->prepare("
        SELECT s.student_id, s.full_name, s.email, s.course_name
        FROM batch_students bs
        JOIN students s ON bs.student_id = s.id
        WHERE bs.batch_id = ?
        ORDER BY s.full_name
    ");
    $students_stmt->bind_param("i", $batch_id);
    $students_stmt->execute();
    $students_result = $students_stmt->get_result();
    $students_list = [];
    while ($student = $students_result->fetch_assoc()) {
        $students_list[] = $student;
    }
    $students_stmt->close();

    $row['students'] = $students_list;
    $batches[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/my_batches.php';
?>