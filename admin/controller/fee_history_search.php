<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
require_once BASE_PATH . 'models/FeePayment.php';

requireRole(['admin']);

$search_results = null;
$search_error = '';
$summary = null;
$message = '';
$error = '';

$feeModel = new FeePayment($conn);

// Flash messages
if (isset($_SESSION['fee_msg'])) {
    $message = $_SESSION['fee_msg'];
    unset($_SESSION['fee_msg']);
}
if (isset($_SESSION['fee_error'])) {
    $error = $_SESSION['fee_error'];
    unset($_SESSION['fee_error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit_payment') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $payment_id = intval($_POST['payment_id'] ?? 0);
    $amount_paid = floatval($_POST['amount_paid'] ?? 0);
    $payment_date = trim($_POST['payment_date'] ?? '');
    $payment_month = trim($_POST['payment_month'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    // Validate date format YYYY-MM-DD
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $payment_date)) {
        $_SESSION['fee_error'] = 'Invalid date format.';
    } elseif ($payment_id <= 0 || $amount_paid <= 0 || empty($payment_month)) {
        $_SESSION['fee_error'] = 'All fields are required.';
    } else {
        if ($feeModel->updatePayment($payment_id, $amount_paid, $payment_date, $payment_month, $remarks)) {
            $_SESSION['fee_msg'] = 'Payment updated successfully.';
        } else {
            $_SESSION['fee_error'] = 'Failed to update payment.';
        }
    }

    $redirect_id = $_POST['redirect_student_id'] ?? '';
    header('Location: ' . BASE_URL . '/admin/controller/fee_history_search.php?student_id=' . urlencode($redirect_id));
    exit;
}

if (isset($_GET['student_id']) && trim($_GET['student_id']) !== '') {
    $search_term = trim($_GET['student_id']);
    $search_results = $feeModel->getStudentFeeHistoryByStudentId($search_term);
    $summary = $feeModel->getStudentFeeSummaryByStudentId($search_term);
    if (empty($search_results)) {
        $search_error = 'No fee records found for this Student ID.';
    }
}

include BASE_PATH . 'admin/view/fee_history_search.php';
?>