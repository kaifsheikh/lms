<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$error = '';
$batches = [];
$students_progress = [];
$selected_batch = null;

// Fetch all batches with teacher name
$stmt = $conn->query("
    SELECT b.id, b.batch_name, b.starting_date, b.batch_time, u.full_name AS teacher_name
    FROM batches b
    LEFT JOIN users u ON b.teacher_id = u.id
    ORDER BY b.created_at DESC
");
if ($stmt) {
    while ($row = $stmt->fetch_assoc()) {
        $batches[] = $row;
    }
    $stmt->close();
}

$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;

if ($batch_id > 0) {
    // Verify batch exists
    $stmt = $conn->prepare("SELECT id, batch_name FROM batches WHERE id = ?");
    $stmt->bind_param("i", $batch_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $selected_batch = $row;
    } else {
        $error = 'Batch not found.';
    }
    $stmt->close();

    if ($selected_batch) {
        $stmt = $conn->prepare("
            SELECT s.id, s.student_id, s.full_name,
                SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS present_count,
                SUM(CASE WHEN a.status = 'absent' THEN 1 ELSE 0 END) AS absent_count,
                SUM(CASE WHEN a.status = 'late' THEN 1 ELSE 0 END) AS late_count,
                SUM(CASE WHEN a.status = 'leave' THEN 1 ELSE 0 END) AS leave_count,
                COUNT(a.id) AS total_records
            FROM batch_students bs
            INNER JOIN students s ON bs.student_id = s.id
            LEFT JOIN attendance a ON a.batch_id = bs.batch_id AND a.student_id = s.id
            WHERE bs.batch_id = ?
            GROUP BY s.id, s.student_id, s.full_name
            ORDER BY s.full_name ASC
        ");
        $stmt->bind_param("i", $batch_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $total = $row['total_records'] ?? 0;
            $present_like = $row['present_count'] + $row['late_count'];
            $row['percentage'] = ($total > 0) ? round(($present_like / $total) * 100, 2) : 0;
            $students_progress[] = $row;
        }
        $stmt->close();
    }
}

// ---------- STUDENT SEARCH SECTION ----------
$searched_student = null;
$student_summary = null;
$student_search_error = '';

if (isset($_GET['student_id']) && trim($_GET['student_id']) !== '') {
    $search_id = trim($_GET['student_id']);

    // Fetch student basic info
    $stmt = $conn->prepare("SELECT id, student_id, full_name, course_name, class_timing, course_duration, joining_date FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $searched_student = $row;
    } else {
        $student_search_error = 'No student found with that ID.';
    }
    $stmt->close();

    if ($searched_student) {
        // Fetch attendance summary for this student
        $stmt = $conn->prepare("
            SELECT
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present_count,
                SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) AS absent_count,
                SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) AS late_count,
                SUM(CASE WHEN status = 'leave' THEN 1 ELSE 0 END) AS leave_count,
                COUNT(*) AS total_records
            FROM attendance
            WHERE student_id = ?
        ");
        $stmt->bind_param("i", $searched_student['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $student_summary = $row;
            $total = $row['total_records'] ?? 0;
            $present_like = $row['present_count'] + $row['late_count'];
            $student_summary['percentage'] = ($total > 0) ? round(($present_like / $total) * 100, 2) : 0;
        }
        $stmt->close();
    }
}

include BASE_PATH . 'admin/view/attendance_progress.php';
?>