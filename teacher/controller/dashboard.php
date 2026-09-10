<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

// ---------- COUNTS ----------
$total_batches = 0;
$total_students = 0;
$total_quizzes = 0;
$active_quizzes = 0;
$total_classes = 0;
$upcoming_classes = 0;
$total_attendance_records = 0;
$total_quiz_attempts = 0;

// Total approved batches
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM batches WHERE teacher_id = ? AND status = 'approved'");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$total_batches = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total students assigned
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM students WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$total_students = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total quizzes
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM quizzes WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$total_quizzes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Active quizzes
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM quizzes WHERE teacher_id = ? AND status = 'active'");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$active_quizzes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total online classes
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM online_classes WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$total_classes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Upcoming classes
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM online_classes WHERE teacher_id = ? AND end_time >= NOW()");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$upcoming_classes = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Attendance records
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM attendance WHERE marked_by = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$total_attendance_records = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total quiz attempts by students in teacher's quizzes
$stmt = $conn->prepare("
    SELECT COUNT(*) AS cnt 
    FROM quiz_attempts qa
    INNER JOIN quizzes q ON qa.quiz_id = q.id
    WHERE q.teacher_id = ?
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$total_quiz_attempts = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// ---------- RECENT QUIZZES ----------
$recent_quizzes = [];
$stmt = $conn->prepare("
    SELECT q.id, q.title, q.created_at, q.status, b.batch_name
    FROM quizzes q
    LEFT JOIN batches b ON q.batch_id = b.id
    WHERE q.teacher_id = ?
    ORDER BY q.created_at DESC
    LIMIT 5
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recent_quizzes[] = $row;
}
$stmt->close();

// ---------- UPCOMING / RECENT CLASSES ----------
$recent_classes = [];
$stmt = $conn->prepare("
    SELECT oc.id, oc.title, oc.start_time, oc.end_time, b.batch_name
    FROM online_classes oc
    INNER JOIN batches b ON oc.batch_id = b.id
    WHERE oc.teacher_id = ?
    ORDER BY oc.start_time DESC
    LIMIT 5
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recent_classes[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/dashboard.php';
?>