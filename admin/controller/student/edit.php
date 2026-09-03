<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$error = '';
$success = '';
$old = [];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Student ID not provided.');
}

$student_db_id = intval($_GET['id']);

// Model objects (autoloader se load honge)
$studentModel = new Student($conn);
$courseModel = new Course($conn);

// Fetch student data via model
$student = $studentModel->getStudentById($student_db_id);
if (!$student) {
    die('Student not found.');
}

// Pre-fill $old with existing data
$old = $student;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $old = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'father_name' => trim($_POST['father_name'] ?? ''),
        'contact_number' => trim($_POST['contact_number'] ?? ''),
        'gender' => $_POST['gender'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'address' => trim($_POST['address'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'joining_date' => $_POST['joining_date'] ?? '',
        'class_timing' => trim($_POST['class_timing'] ?? ''),
        'highest_education' => $_POST['highest_education'] ?? ''
    ];
    $password = $_POST['password'] ?? '';
    $course_id = intval($_POST['course_id'] ?? 0);
    $old['course_id'] = $course_id;

    // Validation
    if (
        empty($old['full_name']) || empty($old['father_name']) || empty($old['contact_number']) ||
        empty($old['gender']) || empty($old['dob']) || empty($old['address']) ||
        empty($old['email']) || empty($old['joining_date']) ||
        empty($old['class_timing']) || empty($old['highest_education']) || $course_id <= 0
    ) {
        $error = 'All fields are required.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (!empty($password) && strlen($password) < 6) {
        $error = 'Password must be at least 6 characters if provided.';
    } elseif (!in_array($old['gender'], ['male', 'female', 'other'])) {
        $error = 'Invalid gender selected.';
    } elseif (!in_array($old['highest_education'], ['intermediate', 'undergraduate', 'postgraduate', 'matric'])) {
        $error = 'Invalid education selected.';
    } else {
        // Email uniqueness check via model
        if ($studentModel->emailExists($old['email'], $student_db_id)) {
            $error = 'Email already exists with another account.';
        } else {
            // Course ki info fetch karo
            $course = $courseModel->getCourseById($course_id);
            if (!$course) {
                $error = 'Selected course not found.';
            } else {
                $old['course_name'] = $course['course_name'];
                $old['course_duration'] = $course['duration'];

                // File uploads (waisa hi)
                $upload_dir = BASE_PATH . 'assets/uploads/students/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                $student_pic_name = $student['student_pic'];
                $cnic_pic_name = $student['cnic_pic'];

                // Student Picture upload
                if (isset($_FILES['student_pic']) && $_FILES['student_pic']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['student_pic'];
                    if ($file['size'] > 2 * 1024 * 1024) {
                        $error = 'Student picture must be less than 2MB.';
                    } else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if (!in_array($ext, $allowed_ext)) {
                            $error = 'Invalid image format for student picture.';
                        } else {
                            if (!empty($student['student_pic']) && file_exists($upload_dir . $student['student_pic'])) {
                                unlink($upload_dir . $student['student_pic']);
                            }
                            $new_name = uniqid('stu_', true) . '.' . $ext;
                            if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
                                $student_pic_name = $new_name;
                            } else {
                                $error = 'Failed to upload student picture.';
                            }
                        }
                    }
                }

                // CNIC Picture upload
                if (empty($error) && isset($_FILES['cnic_pic']) && $_FILES['cnic_pic']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['cnic_pic'];
                    if ($file['size'] > 2 * 1024 * 1024) {
                        $error = 'CNIC picture must be less than 2MB.';
                    } else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if (!in_array($ext, $allowed_ext)) {
                            $error = 'Invalid image format for CNIC picture.';
                        } else {
                            if (!empty($student['cnic_pic']) && file_exists($upload_dir . $student['cnic_pic'])) {
                                unlink($upload_dir . $student['cnic_pic']);
                            }
                            $new_name = uniqid('cnic_', true) . '.' . $ext;
                            if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
                                $cnic_pic_name = $new_name;
                            } else {
                                $error = 'Failed to upload CNIC picture.';
                            }
                        }
                    }
                }

                if (empty($error)) {
                    // Model se update karo - bina status change kiye
                    $data = $old;
                    if ($studentModel->updateStudent($student_db_id, $data, $student_pic_name, $cnic_pic_name, $password)) {
                        $success = 'Student updated successfully!';
                        // Refresh student data
                        $student = $studentModel->getStudentById($student_db_id);
                        $old = $student;
                    } else {
                        $error = 'Failed to update student.';
                    }
                }
            }
        }
    }
}

// View ke liye courses fetch karo
$courses = $courseModel->getAllCourses();

include BASE_PATH . 'admin/view/student/edit.php';
?>