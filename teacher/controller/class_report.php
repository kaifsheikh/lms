<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$selected_class = null;
$attendance = [];

// Fetch teacher's classes for dropdown
$classes = [];
$stmt = $conn->prepare("SELECT id, title FROM online_classes WHERE teacher_id = ? ORDER BY start_time DESC");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $classes[] = $row;
}
$stmt->close();

$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

if ($class_id > 0) {
    // Verify class belongs to teacher
    $stmt = $conn->prepare("SELECT id, title, batch_id FROM online_classes WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $class_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $selected_class = $row;
    }
    $stmt->close();

    if ($selected_class) {
        // Get all students in that batch with attendance status and marked_at
        $stmt = $conn->prepare("
            SELECT s.id, s.student_id, s.full_name,
                CASE WHEN ca.id IS NOT NULL THEN 'present' ELSE 'absent' END AS status,
                ca.marked_at
            FROM batch_students bs
            INNER JOIN students s ON bs.student_id = s.id
            LEFT JOIN class_attendance ca ON ca.class_id = ? AND ca.student_id = s.id
            WHERE bs.batch_id = ?
            ORDER BY s.full_name ASC
        ");
        $stmt->bind_param("ii", $class_id, $selected_class['batch_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }
        $stmt->close();
    }
}

include BASE_PATH . 'teacher/view/class_report.php';
?>