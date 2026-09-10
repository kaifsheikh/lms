<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];

// ---------- QUICK COUNTS ----------
$available_quizzes = 0;
$attempted_quizzes = 0;
$upcoming_classes = 0;
$attendance_percentage = 0;

// Available quizzes
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT q.id) AS cnt
    FROM quizzes q
    INNER JOIN batch_students bs ON q.batch_id = bs.batch_id
    WHERE bs.student_id = ?
      AND q.status = 'active'
      AND NOT EXISTS (
          SELECT 1 FROM quiz_attempts qa
          WHERE qa.quiz_id = q.id AND qa.student_id = ?
      )
");
$stmt->bind_param("ii", $student_id, $student_id);
$stmt->execute();
$available_quizzes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Attempted quizzes
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM quiz_attempts WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$attempted_quizzes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Upcoming classes
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT oc.id) AS cnt
    FROM online_classes oc
    INNER JOIN batch_students bs ON oc.batch_id = bs.batch_id
    WHERE bs.student_id = ?
      AND oc.end_time >= NOW()
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$upcoming_classes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Attendance percentage
$attendance_records = [];
$stmt = $conn->prepare("SELECT status FROM attendance WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $attendance_records[] = $row['status'];
}
$stmt->close();

$total_attendance = count($attendance_records);
$present_like = 0;
foreach ($attendance_records as $status) {
    if ($status === 'present' || $status === 'late') {
        $present_like++;
    }
}
$attendance_percentage = ($total_attendance > 0) ? round(($present_like / $total_attendance) * 100, 2) : 0;

// ---------- RECENT QUIZ RESULTS ----------
$recent_results = [];
$stmt = $conn->prepare("
    SELECT q.title, qa.percentage, qa.submitted_at
    FROM quiz_attempts qa
    INNER JOIN quizzes q ON qa.quiz_id = q.id
    WHERE qa.student_id = ?
    ORDER BY qa.submitted_at DESC
    LIMIT 3
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recent_results[] = $row;
}
$stmt->close();

// ---------- UPCOMING CLASSES ----------
$upcoming_classes_list = [];
$stmt = $conn->prepare("
    SELECT oc.title, oc.start_time, oc.end_time, oc.token
    FROM online_classes oc
    INNER JOIN batch_students bs ON oc.batch_id = bs.batch_id
    WHERE bs.student_id = ?
      AND oc.end_time >= NOW()
    ORDER BY oc.start_time ASC
    LIMIT 3
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $upcoming_classes_list[] = $row;
}
$stmt->close();

include BASE_PATH . 'student/view/dashboard.php';
?>