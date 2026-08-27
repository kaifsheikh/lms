<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$error = '';
$quizzes = [];

// =====================================================
// FETCH ACTIVE QUIZZES FOR STUDENT'S BATCHES
// =====================================================
$stmt = $conn->prepare("
    SELECT DISTINCT q.id, q.title, q.description, q.due_date, q.timer, q.passing_marks,
           q.created_at, b.batch_name, u.full_name AS teacher_name
    FROM quizzes q
    INNER JOIN batch_students bs ON q.batch_id = bs.batch_id
    INNER JOIN batches b ON q.batch_id = b.id
    INNER JOIN users u ON q.teacher_id = u.id
    WHERE bs.student_id = ?
      AND q.status = 'active'
      AND NOT EXISTS (
          SELECT 1 FROM quiz_attempts qa
          WHERE qa.quiz_id = q.id AND qa.student_id = ?
      )
    ORDER BY q.due_date ASC
");
$stmt->bind_param("ii", $student_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $quizzes[] = $row;
}
$stmt->close();

// =====================================================
// LOAD VIEW
// =====================================================
include BASE_PATH . 'student/view/quizzes.php';
?>