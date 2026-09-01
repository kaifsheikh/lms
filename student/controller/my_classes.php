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
        // Fetch class details
        $stmt = $conn->prepare("SELECT id, token, end_time, batch_id, meet_link FROM online_classes WHERE id = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $current_time = date('Y-m-d H:i:s');
            if ($token !== $row['token']) {
                $error = 'Invalid token.';
            } elseif ($current_time > $row['end_time']) {
                $error = 'This class has ended. Attendance is closed.';
            } else {
                // Verify student belongs to this batch
                $stmt2 = $conn->prepare("SELECT id FROM batch_students WHERE batch_id = ? AND student_id = ?");
                $stmt2->bind_param("ii", $row['batch_id'], $student_id);
                $stmt2->execute();
                $stmt2->store_result();
                if ($stmt2->num_rows === 0) {
                    $error = 'You are not in this batch.';
                } else {
                    // Insert attendance (ignore duplicate)
                    $stmt3 = $conn->prepare("INSERT IGNORE INTO class_attendance (class_id, student_id, status) VALUES (?, ?, 'present')");
                    $stmt3->bind_param("ii", $class_id, $student_id);
                    if ($stmt3->execute()) {
                        $message = 'Attendance marked successfully!';
                        $attendance_success_class_id = $class_id;
                        $attendance_success_meet_link = $row['meet_link'];
                    } else {
                        $error = 'Failed to mark attendance.';
                    }
                    $stmt3->close();
                }
                $stmt2->close();
            }
        } else {
            $error = 'Class not found.';
        }
        $stmt->close();
    }
}

// Fetch student's batches
$my_batch_ids = [];
$stmt = $conn->prepare("SELECT batch_id FROM batch_students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $my_batch_ids[] = $row['batch_id'];
}
$stmt->close();

$classes = [];
if (!empty($my_batch_ids)) {
    $placeholders = implode(',', array_fill(0, count($my_batch_ids), '?'));
    $types = str_repeat('i', count($my_batch_ids));
    $stmt = $conn->prepare("
        SELECT oc.id, oc.title, oc.meet_link, oc.start_time, oc.end_time, oc.token
        FROM online_classes oc
        WHERE oc.batch_id IN ($placeholders)
          AND oc.end_time >= NOW()
        ORDER BY oc.start_time DESC
    ");
    $stmt->bind_param($types, ...$my_batch_ids);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Check if already attended
        $stmt2 = $conn->prepare("SELECT id FROM class_attendance WHERE class_id = ? AND student_id = ?");
        $stmt2->bind_param("ii", $row['id'], $student_id);
        $stmt2->execute();
        $stmt2->store_result();
        $row['attended'] = $stmt2->num_rows > 0;
        $stmt2->close();
        $classes[] = $row;
    }
    $stmt->close();
}

include BASE_PATH . 'student/view/my_classes.php';
?>