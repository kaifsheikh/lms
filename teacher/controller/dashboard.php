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
$total_classes = 0;
$total_attendance_records = 0;

// Total approved batches
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM batches WHERE teacher_id = ? AND status = 'approved'");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$total_batches = $result->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total students assigned to this teacher
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM students WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$total_students = $result->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total quizzes created by this teacher
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM quizzes WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$total_quizzes = $result->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total online classes created by this teacher
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM online_classes WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$total_classes = $result->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Total attendance records marked by this teacher
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM attendance WHERE marked_by = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$total_attendance_records = $result->fetch_assoc()['cnt'] ?? 0;
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

// ---------- LOAD VIEW ----------
include BASE_PATH . 'teacher/view/dashboard.php';
?>