<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);


// ---------------------------------------------------------
// Only POST requests allowed
// ---------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}


// ---------------------------------------------------------
// CSRF Protection
// ---------------------------------------------------------

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}


// ---------------------------------------------------------
// Validate Student ID
// ---------------------------------------------------------

$student_db_id = filter_input(
    INPUT_POST,
    'student_id',
    FILTER_VALIDATE_INT
);

if (!$student_db_id || $student_db_id <= 0) {
    $_SESSION['student_error'] = 'Invalid student ID.';

    header(
        'Location: ' .
        BASE_URL .
        '/admin/controller/student/manage.php'
    );
    exit;
}


// ---------------------------------------------------------
// Fetch student file names
// ---------------------------------------------------------

$stmt = $conn->prepare(
    "SELECT student_pic, cnic_pic
     FROM students
     WHERE id = ?"
);

if (!$stmt) {
    http_response_code(500);
    exit('Database error.');
}

$stmt->bind_param("i", $student_db_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {

    $stmt->close();

    $_SESSION['student_error'] = 'Student not found.';

    header(
        'Location: ' .
        BASE_URL .
        '/admin/controller/student/manage.php'
    );
    exit;
}

$stmt->bind_result($student_pic, $cnic_pic);
$stmt->fetch();
$stmt->close();


// ---------------------------------------------------------
// Delete student record FIRST
// ---------------------------------------------------------

$stmt = $conn->prepare(
    "DELETE FROM students
     WHERE id = ?"
);

if (!$stmt) {
    http_response_code(500);
    exit('Database error.');
}

$stmt->bind_param("i", $student_db_id);

if (!$stmt->execute()) {

    $stmt->close();

    $_SESSION['student_error'] =
        'Failed to delete student.';

    header(
        'Location: ' .
        BASE_URL .
        '/admin/controller/student/manage.php'
    );
    exit;
}

$stmt->close();


// ---------------------------------------------------------
// Delete uploaded files
// ---------------------------------------------------------

$upload_dir = BASE_PATH . 'assets/uploads/students/';


// Student picture
if (!empty($student_pic)) {

    $student_file = basename($student_pic);
    $student_path = $upload_dir . $student_file;

    if (is_file($student_path)) {
        unlink($student_path);
    }
}


// CNIC picture
if (!empty($cnic_pic)) {

    $cnic_file = basename($cnic_pic);
    $cnic_path = $upload_dir . $cnic_file;

    if (is_file($cnic_path)) {
        unlink($cnic_path);
    }
}


// ---------------------------------------------------------
// Success
// ---------------------------------------------------------

$_SESSION['student_msg'] =
    'Student deleted successfully.';


// ---------------------------------------------------------
// Redirect
// ---------------------------------------------------------

header(
    'Location: ' .
    BASE_URL .
    '/admin/controller/student/manage.php'
);

exit;

?>