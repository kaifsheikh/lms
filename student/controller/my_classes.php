<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$message = '';
$error = '';
$attendance_success_class_id = null;
$attendance_success_meet_link = null;

// Model object
$onlineClassModel = new OnlineClass($conn);

// Handle attendance marking + token verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_attendance') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $class_id = intval($_POST['class_id'] ?? 0);
    $token = trim($_POST['token'] ?? '');

    if ($class_id <= 0 || empty($token)) {
        $error = 'Invalid class or token.';
    } else {
        // Class details fetch via model
        $class = $onlineClassModel->getClassDetails($class_id);

        if (!$class) {
            $error = 'Class not found.';
        } else {
            $current_time = date('Y-m-d H:i:s');

            if ($token !== $class['token']) {
                $error = 'Invalid token.';
            } elseif ($current_time > $class['end_time']) {
                $error = 'This class has ended. Attendance is closed.';
            } else {
                // Verify student belongs to this batch
                if (!$onlineClassModel->isStudentInBatch($class['batch_id'], $student_id)) {
                    $error = 'You are not in this batch.';
                } else {
                    // Mark attendance via model
                    if ($onlineClassModel->markClassAttendance($class_id, $student_id)) {
                        $message = 'Attendance marked successfully!';
                        $attendance_success_class_id = $class_id;
                        $attendance_success_meet_link = $class['meet_link'];
                    } else {
                        $error = 'Failed to mark attendance.';
                    }
                }
            }
        }
    }
}

// Fetch upcoming classes for this student via model
$classes = $onlineClassModel->getUpcomingClassesByStudent($student_id);

include BASE_PATH . 'student/view/my_classes.php';
?>