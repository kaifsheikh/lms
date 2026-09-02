<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['admin']);

$message = '';
$error = '';

// Model object
$batchModel = new Batch($conn);

// ============================================================
// HANDLE POST REQUESTS
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // APPROVE / REJECT BATCH
    if (isset($_POST['batch_id']) && isset($_POST['status'])) {

        $batch_id = filter_input(INPUT_POST, 'batch_id', FILTER_VALIDATE_INT);
        $new_status = $_POST['status'];

        if ($batch_id === false || $batch_id <= 0) {
            $error = 'Invalid batch ID.';
        } elseif (!in_array($new_status, ['approved', 'rejected'], true)) {
            $error = 'Invalid status.';
        } else {
            $result = $batchModel->updateBatchStatus($batch_id, $new_status);
            if ($result['success']) {
                if ($result['affected'] > 0) {
                    $message = "Batch $new_status successfully.";
                } else {
                    $error = 'Batch not found or status is already the same.';
                }
            } else {
                $error = 'Failed to update batch status.';
            }
        }
    }

    // DELETE BATCH
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete_batch') {

        $batch_id = filter_input(INPUT_POST, 'batch_id', FILTER_VALIDATE_INT);

        if ($batch_id === false || $batch_id <= 0) {
            $error = 'Invalid batch selected.';
        } else {
            $result = $batchModel->deleteBatch($batch_id);
            if ($result['success']) {
                if ($result['affected'] > 0) {
                    $message = 'Batch deleted successfully.';
                } else {
                    $error = 'Batch not found.';
                }
            } else {
                $error = 'Failed to delete batch.';
            }
        }
    }
}

// ============================================================
// FETCH ALL BATCHES
// ============================================================
$batches = $batchModel->getAllBatchesWithDetails();

include BASE_PATH . 'admin/view/teacher/batch_approval.php';
?>