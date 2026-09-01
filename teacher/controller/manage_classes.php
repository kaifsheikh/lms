<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$message = '';
$error = '';

// ---------- HANDLE POST REQUESTS ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    // CREATE CLASS
    if ($action === 'create_class') {
        $title = trim($_POST['title'] ?? '');
        $meet_link = trim($_POST['meet_link'] ?? '');
        $batch_id = intval($_POST['batch_id'] ?? 0);
        $start_time = $_POST['start_time'] ?? '';
        $end_time = $_POST['end_time'] ?? '';

        if (empty($title) || empty($meet_link) || empty($start_time) || empty($end_time) || $batch_id <= 0) {
            $error = 'All fields are required.';
        } else {
            // Verify batch belongs to teacher
            $stmt = $conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $batch_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Batch not found or does not belong to you.';
                $stmt->close();
            } else {
                $stmt->close();

                // Generate token
                $token = strtoupper(bin2hex(random_bytes(4))); // 8 characters

                $stmt = $conn->prepare("
                    INSERT INTO online_classes (teacher_id, batch_id, title, meet_link, token, start_time, end_time)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("iisssss", $teacher_id, $batch_id, $title, $meet_link, $token, $start_time, $end_time);
                if ($stmt->execute()) {
                    $message = 'Class created successfully! Token: ' . $token;
                } else {
                    $error = 'Failed to create class.';
                }
                $stmt->close();
            }
        }
    }

    // DELETE CLASS
    elseif ($action === 'delete_class') {
        $class_id = intval($_POST['class_id'] ?? 0);
        if ($class_id <= 0) {
            $error = 'Invalid class selected.';
        } else {
            // Verify class belongs to this teacher
            $stmt = $conn->prepare("SELECT id FROM online_classes WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $class_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Class not found or you do not have permission.';
                $stmt->close();
            } else {
                $stmt->close();
                // Delete class (attendance records will be deleted automatically due to foreign key ON DELETE CASCADE)
                $stmt = $conn->prepare("DELETE FROM online_classes WHERE id = ? AND teacher_id = ?");
                $stmt->bind_param("ii", $class_id, $teacher_id);
                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $message = 'Class deleted successfully.';
                } else {
                    $error = 'Failed to delete class.';
                }
                $stmt->close();
            }
        }
    }
}

// ---------- FETCH TEACHER'S BATCHES ----------
$batches = [];
$stmt = $conn->prepare("SELECT id, batch_name FROM batches WHERE teacher_id = ? AND status = 'approved'");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}
$stmt->close();

// ---------- FETCH TEACHER'S CLASSES ----------
$classes = [];
$stmt = $conn->prepare("
    SELECT oc.id, oc.title, oc.meet_link, oc.token, oc.start_time, oc.end_time, oc.status, b.batch_name
    FROM online_classes oc
    INNER JOIN batches b ON oc.batch_id = b.id
    WHERE oc.teacher_id = ?
    ORDER BY oc.start_time DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $classes[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/manage_classes.php';
?>