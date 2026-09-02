<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Model object
$onlineClassModel = new OnlineClass($conn);

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
            // Verify batch belongs to teacher (using model method from earlier)
            if (!$onlineClassModel->isBatchBelongsToTeacher($batch_id, $teacher_id)) {
                $error = 'Batch not found or does not belong to you.';
            } else {
                // Create class via model
                $result = $onlineClassModel->createClass($teacher_id, $batch_id, $title, $meet_link, $start_time, $end_time);
                if ($result['success']) {
                    $message = 'Class created successfully! Token: ' . $result['token'];
                } else {
                    $error = 'Failed to create class.';
                }
            }
        }
    }

    // DELETE CLASS
    elseif ($action === 'delete_class') {
        $class_id = intval($_POST['class_id'] ?? 0);
        if ($class_id <= 0) {
            $error = 'Invalid class selected.';
        } else {
            $result = $onlineClassModel->deleteClass($class_id, $teacher_id);
            if ($result['success']) {
                if ($result['affected'] > 0) {
                    $message = 'Class deleted successfully.';
                } else {
                    $error = 'Class not found or you do not have permission.';
                }
            } else {
                $error = 'Failed to delete class.';
            }
        }
    }
}

// ---------- FETCH TEACHER'S BATCHES ----------
// Assume model has getApprovedBatchesForTeacher (already in OnlineClass model or Batch model)
// We'll add method in model if missing, but here direct query is replaced with model call
$batches = $onlineClassModel->getApprovedBatchesForTeacher($teacher_id);

// ---------- FETCH TEACHER'S CLASSES ----------
$classes = $onlineClassModel->getClassesWithBatchByTeacher($teacher_id);

include BASE_PATH . 'teacher/view/manage_classes.php';
?>