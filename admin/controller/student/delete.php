<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['admin']);

if (isset($_POST['student_id'])) {
    $student_db_id = intval($_POST['student_id']);

    // Fetch file names
    $stmt = $conn->prepare("SELECT student_pic, cnic_pic FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_db_id);
    $stmt->execute();
    $stmt->bind_result($student_pic, $cnic_pic);
    $stmt->fetch();
    $stmt->close();

    // Delete files
    $upload_dir = BASE_PATH . 'assets/uploads/students/';
    if (!empty($student_pic) && file_exists($upload_dir . $student_pic)) {
        unlink($upload_dir . $student_pic);
    }
    if (!empty($cnic_pic) && file_exists($upload_dir . $cnic_pic)) {
        unlink($upload_dir . $cnic_pic);
    }

    // Delete record
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_db_id);
    if ($stmt->execute()) {
        $_SESSION['student_msg'] = 'Student deleted successfully.';
    } else {
        $_SESSION['student_error'] = 'Failed to delete student.';
    }
    $stmt->close();
}

header('Location: ' . BASE_URL . '/admin/controller/student/manage.php');
exit;
?>