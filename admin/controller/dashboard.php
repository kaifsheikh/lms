<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

// ---------- COUNTS ----------
$total_teachers = 0;
$pending_teachers = 0;
$total_students = 0;
$active_students = 0;
$total_batches = 0;
$pending_batches = 0;
$total_quizzes = 0;
$total_classes = 0;
$total_attendance_records = 0;
$total_courses = 0;

// Teachers
$stmt = $conn->query("SELECT 
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending
    FROM users WHERE role = 'teacher'");
if ($row = $stmt->fetch_assoc()) {
    $total_teachers = $row['approved'] ?? 0;
    $pending_teachers = $row['pending'] ?? 0;
}
$stmt->close();

// Students
$stmt = $conn->query("SELECT 
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active
    FROM students");
if ($row = $stmt->fetch_assoc()) {
    $total_students = $row['total'] ?? 0;
    $active_students = $row['active'] ?? 0;
}
$stmt->close();

// Batches
$stmt = $conn->query("SELECT 
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending
    FROM batches");
if ($row = $stmt->fetch_assoc()) {
    $total_batches = $row['total'] ?? 0;
    $pending_batches = $row['pending'] ?? 0;
}
$stmt->close();

// Courses
$stmt = $conn->query("SELECT COUNT(*) AS cnt FROM courses");
$total_courses = $stmt->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Quizzes
$stmt = $conn->query("SELECT COUNT(*) AS cnt FROM quizzes");
$total_quizzes = $stmt->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Online Classes
$stmt = $conn->query("SELECT COUNT(*) AS cnt FROM online_classes");
$total_classes = $stmt->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// Attendance Records
$stmt = $conn->query("SELECT COUNT(*) AS cnt FROM attendance");
$total_attendance_records = $stmt->fetch_assoc()['cnt'] ?? 0;
$stmt->close();

// ---------- RECENT STUDENTS ----------
$recent_students = [];
$stmt = $conn->query("SELECT student_id, full_name, course_name, created_at FROM students ORDER BY created_at DESC LIMIT 5");
while ($row = $stmt->fetch_assoc()) {
    $recent_students[] = $row;
}
$stmt->close();

// ---------- RECENT TEACHERS ----------
$recent_teachers = [];
$stmt = $conn->query("SELECT full_name, email, created_at FROM users WHERE role = 'teacher' ORDER BY created_at DESC LIMIT 5");
while ($row = $stmt->fetch_assoc()) {
    $recent_teachers[] = $row;
}
$stmt->close();

include BASE_PATH . 'admin/view/dashboard.php';
?>