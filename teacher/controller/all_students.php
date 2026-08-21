<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

// Function to calculate course end date
function calculateCourseEndDate($joining_date, $duration_str) {
    if (empty($joining_date) || empty($duration_str)) return 'N/A';
    
    $duration_str = trim($duration_str);
    if (preg_match('/^\d+$/', $duration_str)) {
        $number = (int)$duration_str;
        $unit = 'month';
    } else {
        if (!preg_match('/(\d+)\s*(months?|years?|weeks?|days?)/i', $duration_str, $matches)) {
            return 'N/A';
        }
        $number = (int)$matches[1];
        $unit = rtrim(strtolower($matches[2]), 's');
    }

    $interval_spec = '';
    switch ($unit) {
        case 'day': $interval_spec = "P{$number}D"; break;
        case 'week': $interval_spec = "P{$number}W"; break;
        case 'month': $interval_spec = "P{$number}M"; break;
        case 'year': $interval_spec = "P{$number}Y"; break;
        default: return 'N/A';
    }

    try {
        $date = new DateTime($joining_date);
        $date->add(new DateInterval($interval_spec));
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        return 'Invalid Date';
    }
}

// Fetch all students for this teacher (no contact, email)
$students = [];
$stmt = $conn->prepare("
    SELECT s.student_id, s.full_name, s.father_name, 
           s.course_name, s.class_timing, s.course_duration, s.joining_date, s.status, s.created_at
    FROM students s
    WHERE s.teacher_id = ?
    ORDER BY s.created_at DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $row['course_end_date'] = calculateCourseEndDate($row['joining_date'], $row['course_duration']);
    $students[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/all_students.php';
?>