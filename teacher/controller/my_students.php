<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

// Sirf teacher access
requireRole(['teacher']);

$teacher_id = $_SESSION['user_id']; // logged in teacher ki id

function calculateCourseEndDate($joining_date, $duration_str) {
    if (empty($joining_date) || empty($duration_str)) {
        return 'N/A';
    }

    // Clean duration string: trim spaces
    $duration_str = trim($duration_str);

    // Agar duration sirf number hai (e.g., "6") to assume months
    if (preg_match('/^\d+$/', $duration_str)) {
        $number = (int)$duration_str;
        $unit = 'month';
    } else {
        // Match number and unit (allow optional 's', case insensitive)
        if (!preg_match('/(\d+)\s*(months?|years?|weeks?|days?)/i', $duration_str, $matches)) {
            return 'N/A'; // format not recognized
        }
        $number = (int)$matches[1];
        $unit = strtolower($matches[2]);
        // Remove trailing 's' if present (months -> month, weeks -> week, etc.)
        $unit = rtrim($unit, 's');
    }

    // DateInterval spec
    $interval_spec = '';
    switch ($unit) {
        case 'day':
            $interval_spec = "P{$number}D";
            break;
        case 'week':
            $interval_spec = "P{$number}W";
            break;
        case 'month':
            $interval_spec = "P{$number}M";
            break;
        case 'year':
            $interval_spec = "P{$number}Y";
            break;
        default:
            return 'N/A';
    }

    try {
        $date = new DateTime($joining_date);
        $date->add(new DateInterval($interval_spec));
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        return 'Invalid Date';
    }
}

// Fetch students assigned to this teacher (including joining_date, course_duration)
$stmt = $conn->prepare("
    SELECT 
        s.student_id,
        s.full_name,
        s.father_name,
        s.contact_number,
        s.email,
        s.course_name,
        s.class_timing,
        s.course_duration,
        s.joining_date,
        s.status,
        s.created_at
    FROM students s
    WHERE s.teacher_id = ?
      AND NOT EXISTS (
          SELECT 1
          FROM batch_students bs
          WHERE bs.student_id = s.id
      )
    ORDER BY s.created_at DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$students = [];
while ($row = $result->fetch_assoc()) {
    $row['course_end_date'] = calculateCourseEndDate($row['joining_date'], $row['course_duration']);
    $students[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/my_students.php';
?>