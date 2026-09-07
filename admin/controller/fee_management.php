<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
require_once BASE_PATH . 'models/FeePayment.php';

requireRole(['admin']);

$message = '';
$error = '';

$feeModel = new FeePayment($conn);

// AJAX handler
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    $ajax = $_GET['ajax'] ?? '';

    if ($ajax === 'get_batches' && isset($_GET['teacher_id'])) {
        $teacher_id = intval($_GET['teacher_id']);
        $batches = $feeModel->getBatchesByTeacher($teacher_id);
        echo json_encode($batches);
        exit;
    }

    if ($ajax === 'get_students' && isset($_GET['batch_id'])) {
        $batch_id = intval($_GET['batch_id']);
        $students = $feeModel->getStudentsByBatch($batch_id);
        echo json_encode($students);
        exit;
    }

    echo json_encode([]);
    exit;
}

if (isset($_SESSION['fee_msg'])) {
    $message = $_SESSION['fee_msg'];
    unset($_SESSION['fee_msg']);
}
if (isset($_SESSION['fee_error'])) {
    $error = $_SESSION['fee_error'];
    unset($_SESSION['fee_error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add_payment') {
        $student_id = intval($_POST['student_id'] ?? 0);
        $amount_paid = floatval($_POST['amount_paid'] ?? 0);
        $payment_date = $_POST['payment_date'] ?? date('Y-m-d');
        $payment_month = trim($_POST['payment_month'] ?? '');
        $remarks = trim($_POST['remarks'] ?? '');

        if ($student_id <= 0 || $amount_paid <= 0 || empty($payment_date) || empty($payment_month)) {
            $error = 'All fields are required.';
        } else {
            if ($feeModel->addPayment($student_id, $amount_paid, $payment_date, $payment_month, $remarks)) {
                $_SESSION['fee_msg'] = 'Payment added successfully.';
            } else {
                $_SESSION['fee_error'] = 'Failed to add payment.';
            }
            header('Location: ' . BASE_URL . '/admin/controller/fee_management.php');
            exit;
        }
    }
}

$students_with_fee = $feeModel->getStudentsWithFeeSummary();
$teachers = $feeModel->getApprovedTeachers();

include BASE_PATH . 'admin/view/fee_management.php';
?>