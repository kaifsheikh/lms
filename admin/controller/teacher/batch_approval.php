<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';

$batchModel = new Batch($conn);
$studentModel = new Student($conn);

// Flash messages
if (isset($_SESSION['batch_msg'])) {
    $message = $_SESSION['batch_msg'];
    unset($_SESSION['batch_msg']);
}
if (isset($_SESSION['batch_error'])) {
    $error = $_SESSION['batch_error'];
    unset($_SESSION['batch_error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create_batch') {
        $batch_name = trim($_POST['batch_name'] ?? '');
        $starting_date = $_POST['starting_date'] ?? '';
        $batch_time = trim($_POST['batch_time'] ?? '');
        $teacher_id = intval($_POST['teacher_id'] ?? 0);

        if (empty($batch_name) || empty($starting_date) || empty($batch_time) || $teacher_id <= 0) {
            $error = 'All fields are required.';
        } elseif ($batchModel->batchNameExists($teacher_id, $batch_name)) {
            $error = 'Batch name pehle se mojood hai is teacher ke paas.';
        } elseif ($batchModel->batchTimeExists($teacher_id, $batch_time)) {
            $error = 'Batch time pehle se mojood hai is teacher ke paas.';
        } else {
            if ($batchModel->createBatchByAdmin($teacher_id, $batch_name, $starting_date, $batch_time)) {
                $_SESSION['batch_msg'] = 'Batch create ho gaya.';
            } else {
                $_SESSION['batch_error'] = 'Batch create nahi hua.';
            }
            header('Location: ' . BASE_URL . '/admin/controller/teacher/batch_approval.php');
            exit;
        }
    }

    // ADD UNASSIGNED STUDENT TO EXISTING BATCH
    elseif ($action === 'add_student_to_existing') {
        $batch_id = intval($_POST['batch_id'] ?? 0);
        $student_id = intval($_POST['student_id'] ?? 0);

        // Batch ka teacher_id nikalo
        $batch = $batchModel->getBatchById($batch_id); // is method ko model mein add karna hoga
        if (!$batch) {
            $error = 'Batch not found.';
        } else {
            $teacher_id = $batch['teacher_id'];
            $result = $batchModel->assignStudentToTeacherAndBatch($student_id, $teacher_id, $batch_id);
            if ($result['success']) {
                $_SESSION['batch_msg'] = $result['message'];
            } else {
                $_SESSION['batch_error'] = $result['message'];
            }
            header('Location: ' . BASE_URL . '/admin/controller/teacher/batch_approval.php');
            exit;
        }
    }

    // REMOVE STUDENT FROM BATCH
    elseif ($action === 'remove_student') {
        $batch_id = intval($_POST['batch_id'] ?? 0);
        $student_id = intval($_POST['student_id'] ?? 0);

        if ($batch_id <= 0 || $student_id <= 0) {
            $error = 'Batch aur student select karo.';
        } else {
            if ($batchModel->removeStudentFromBatch($batch_id, $student_id)) {
                $_SESSION['batch_msg'] = 'Student batch se remove ho gaya.';
            } else {
                $_SESSION['batch_error'] = 'Student remove nahi hua.';
            }
            header('Location: ' . BASE_URL . '/admin/controller/teacher/batch_approval.php');
            exit;
        }
    }

elseif ($action === 'transfer_student') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $new_batch_id = intval($_POST['new_batch_id'] ?? 0);

    // Destination batch ka teacher_id nikalo
    $batch = $batchModel->getBatchById($new_batch_id);
    if (!$batch) {
        $error = 'Destination batch not found.';
    } else {
        $teacher_id = $batch['teacher_id'];
        $result = $batchModel->assignStudentToTeacherAndBatch($student_id, $teacher_id, $new_batch_id);
        if ($result['success']) {
            $_SESSION['batch_msg'] = $result['message'];
        } else {
            $_SESSION['batch_error'] = $result['message'];
        }
        header('Location: ' . BASE_URL . '/admin/controller/teacher/batch_approval.php');
        exit;
    }
}

    // DELETE BATCH
    elseif ($action === 'delete_batch') {
        $batch_id = intval($_POST['batch_id'] ?? 0);
        if ($batch_id <= 0) {
            $error = 'Invalid batch.';
        } else {
            $result = $batchModel->deleteBatch($batch_id);
            if ($result['success'] && $result['affected'] > 0) {
                $_SESSION['batch_msg'] = 'Batch deleted successfully.';
            } else {
                $_SESSION['batch_error'] = 'Failed to delete batch.';
            }
            header('Location: ' . BASE_URL . '/admin/controller/teacher/batch_approval.php');
            exit;
        }
    }
}

// Data fetch
$batches = $batchModel->getAllBatchesWithDetails();
$teachers = $studentModel->getApprovedTeachers();
$unassigned_students = $studentModel->getUnassignedStudents();
$student_batch_map = $batchModel->getStudentBatchMap();
$all_students = $studentModel->getAllStudents();

include BASE_PATH . 'admin/view/teacher/batch_approval.php';
?>