<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
require_once BASE_PATH . 'models/FeePayment.php';

requireRole(['student']);

$student_id = $_SESSION['user_id'];

$feeModel = new FeePayment($conn);
$summary = $feeModel->getStudentFeeSummary($student_id);
$history = $feeModel->getStudentFeeHistory($student_id);

include BASE_PATH . 'student/view/my_fees.php';
?>