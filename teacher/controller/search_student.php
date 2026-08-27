<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$searched_student = null;
$error = '';

// Agar GET mein student_id hai to search karo
if (isset($_GET['student_id']) && trim($_GET['student_id']) !== '') {
    $search_term = trim($_GET['student_id']);

    // Student ko search karo jo is teacher ko assign hai
    $stmt = $conn->prepare("
        SELECT id, student_id, full_name, course_name, class_timing,
               course_duration, joining_date
        FROM students
        WHERE student_id = ? AND teacher_id = ?
    ");
    $stmt->bind_param("si", $search_term, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $searched_student = $row;

        // Course end date calculate karo
        $joining_date = $row['joining_date'];
        $duration_months = intval($row['course_duration']);
        $end_date = date('Y-m-d', strtotime("+$duration_months months", strtotime($joining_date)));
        $searched_student['course_end_date'] = $end_date;
        
        // Current month and days elapsed calculate karo
        $start = new DateTime($joining_date);
        $now = new DateTime();
        $interval = $start->diff($now);

        // Total days elapsed
        $days_elapsed = (int) $interval->format('%a'); // total days
        if ($days_elapsed < 0) $days_elapsed = 0;

        // Month number (1-based)
        $months_elapsed = ($interval->y * 12) + $interval->m + 1;
        if ($months_elapsed < 1) $months_elapsed = 1;
        if ($months_elapsed > $duration_months) $months_elapsed = $duration_months;

        $searched_student['current_course_month'] = $months_elapsed;
        $searched_student['days_elapsed'] = $days_elapsed;

    } else {
        $error = 'No student found with this ID under your supervision.';
    }
    $stmt->close();
}

// View load karo
include BASE_PATH . 'teacher/view/search_student.php';
?>