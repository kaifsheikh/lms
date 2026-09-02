<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$selected_class = null;
$attendance = [];

// Model object
$onlineClassModel = new OnlineClass($conn);

// Teacher ke classes fetch karo
$classes = $onlineClassModel->getClassesByTeacher($teacher_id);

$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

if ($class_id > 0) {
    // Verify class belongs to teacher
    $selected_class = $onlineClassModel->getClassByIdAndTeacher($class_id, $teacher_id);

    if ($selected_class) {
        // Fetch attendance report
        $attendance = $onlineClassModel->getClassAttendanceReport($class_id, $selected_class['batch_id']);
    }
}

include BASE_PATH . 'teacher/view/class_report.php';
?>