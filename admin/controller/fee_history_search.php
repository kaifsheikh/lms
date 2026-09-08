<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
require_once BASE_PATH . 'models/FeePayment.php';

requireRole(['admin']);

$search_results = null;
$search_error = '';
$summary = null;

$feeModel = new FeePayment($conn);

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