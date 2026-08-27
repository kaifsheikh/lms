<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$results = [];

// Fetch all quiz attempts for this student with quiz details
$stmt = $conn->prepare("
    SELECT qa.quiz_id, qa.obtained_marks, qa.total_marks, qa.percentage, qa.submitted_at,
           q.title AS quiz_title, b.batch_name, u.full_name AS teacher_name
    FROM quiz_attempts qa
    INNER JOIN quizzes q ON qa.quiz_id = q.id
    INNER JOIN batches b ON q.batch_id = b.id
    INNER JOIN users u ON q.teacher_id = u.id
    WHERE qa.student_id = ?
    ORDER BY qa.submitted_at DESC
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}
$stmt->close();

include BASE_PATH . 'student/view/results.php';
?>