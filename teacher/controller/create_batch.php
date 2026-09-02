<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Model object
$batchModel = new Batch($conn);

// CSRF Protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    // SECTION 1: CREATE NEW BATCH
    if ($action === 'create_batch') {
        $batch_name = trim($_POST['batch_name'] ?? '');
        $starting_date = $_POST['starting_date'] ?? '';
        $batch_time = trim($_POST['batch_time'] ?? '');

        if (empty($batch_name) || empty($starting_date) || empty($batch_time)) {
            $error = 'All batch fields are required.';
        } else {
            if ($batchModel->createBatch($teacher_id, $batch_name, $starting_date, $batch_time)) {
                $success = 'Batch created successfully and sent for admin approval.';
            } else {
                $error = 'Failed to create batch.';
            }
        }
    }

    // SECTION 2: ASSIGN STUDENT TO EXISTING BATCH
    elseif ($action === 'assign_to_batch') {
        $student_id = intval($_POST['student_id'] ?? 0);
        $batch_id = intval($_POST['batch_id'] ?? 0);

        if ($student_id <= 0 || $batch_id <= 0) {
            $error = 'Please select both student and batch.';
        } else {
            $result = $batchModel->assignStudentToBatch($student_id, $batch_id, $teacher_id);
            if ($result['success']) {
                $success = $result['message'];
            } else {
                $error = $result['message'];
            }
        }
    }

    // SECTION 3: TRANSFER STUDENT TO ANOTHER BATCH
    elseif ($action === 'transfer_student') {
        $student_id = intval($_POST['student_id'] ?? 0);
        $new_batch_id = intval($_POST['new_batch_id'] ?? 0);

        if ($student_id <= 0 || $new_batch_id <= 0) {
            $error = 'Please select both student and destination batch.';
        } else {
            $result = $batchModel->transferStudentToBatch($student_id, $new_batch_id, $teacher_id);
            if ($result['success']) {
                $success = $result['message'];
            } else {
                $error = $result['message'];
            }
        }
    }
}

// Fetch data for view
$unassigned_students = $batchModel->getUnassignedStudentsForTeacher($teacher_id);
$assigned_students = $batchModel->getAssignedStudentsForTeacher($teacher_id);
$batches = $batchModel->getApprovedBatchesForTeacher($teacher_id);

include BASE_PATH . 'teacher/view/create_batch.php';
?>