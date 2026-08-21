<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

// Sirf admin access
requireRole(['admin']);

$error = '';
$success = '';
$old = [];

// Random unique student ID generator
function generateStudentId($conn) {
    do {
        $prefix = 'STU-';
        $random = strtoupper(substr(uniqid(), -6));
        $student_id = $prefix . $random;
        $stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($exists);
    return $student_id;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data capture (actual code, not placeholder)
    $old = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'father_name' => trim($_POST['father_name'] ?? ''),
        'contact_number' => trim($_POST['contact_number'] ?? ''),
        'gender' => $_POST['gender'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'address' => trim($_POST['address'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'joining_date' => $_POST['joining_date'] ?? '',
        'course_name' => trim($_POST['course_name'] ?? ''),
        'class_timing' => trim($_POST['class_timing'] ?? ''),
        'course_duration' => trim($_POST['course_duration'] ?? ''),
        'highest_education' => $_POST['highest_education'] ?? ''
    ];
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($old['full_name']) || empty($old['father_name']) || empty($old['contact_number']) || empty($old['gender']) || empty($old['dob']) || empty($old['address']) || empty($old['email']) || empty($password) || empty($old['joining_date']) || empty($old['course_name']) || empty($old['class_timing']) || empty($old['course_duration']) || empty($old['highest_education'])) {
        $error = 'All fields are required.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (!in_array($old['gender'], ['male', 'female', 'other'])) {
        $error = 'Invalid gender selected.';
    } elseif (!in_array($old['highest_education'], ['intermediate', 'undergraduate', 'postgraduate', 'matric'])) {
        $error = 'Invalid education selected.';
    } else {
        // Check email uniqueness in users and students
        $email_check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? UNION SELECT id FROM students WHERE email = ?");
        $email_check_stmt->bind_param("ss", $old['email'], $old['email']);
        $email_check_stmt->execute();
        $email_check_stmt->store_result();
        $email_exists = $email_check_stmt->num_rows > 0;
        $email_check_stmt->close();

        if ($email_exists) {
            $error = 'Email already exists.';
        } else {
            // Handle file uploads (student_pic and cnic_pic)
            $upload_dir = BASE_PATH . 'assets/uploads/students/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $student_pic_name = '';
            $cnic_pic_name = '';

            // Student Picture upload
            if (isset($_FILES['student_pic']) && $_FILES['student_pic']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['student_pic'];
                if ($file['size'] > 2 * 1024 * 1024) {
                    $error = 'Student picture must be less than 2MB.';
                } else {
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($ext, $allowed_ext)) {
                        $error = 'Student picture must be an image (jpg, jpeg, png, gif, webp).';
                    } else {
                        $new_name = uniqid('stu_', true) . '.' . $ext;
                        if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
                            $student_pic_name = $new_name;
                        } else {
                            $error = 'Failed to upload student picture.';
                        }
                    }
                }
            } else {
                $error = 'Student picture is required.';
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
                        $error = 'CNIC picture must be an image (jpg, jpeg, png, gif, webp).';
                    } else {
                        $new_name = uniqid('cnic_', true) . '.' . $ext;
                        if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
                            $cnic_pic_name = $new_name;
                        } else {
                            $error = 'Failed to upload CNIC picture.';
                        }
                    }
                }
            } else {
                $error = 'CNIC picture is required.';
            }

            // If no errors, proceed to insert
            if (empty($error)) {
                $student_id = generateStudentId($conn);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $status = 'pending';

                $insert_stmt = $conn->prepare("INSERT INTO students 
                    (student_id, full_name, father_name, contact_number, gender, dob, address, email, password, joining_date, course_name, class_timing, course_duration, student_pic, cnic_pic, highest_education, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("sssssssssssssssss", 
                    $student_id, $old['full_name'], $old['father_name'], $old['contact_number'], 
                    $old['gender'], $old['dob'], $old['address'], $old['email'], $hashed_password, 
                    $old['joining_date'], $old['course_name'], $old['class_timing'], $old['course_duration'], 
                    $student_pic_name, $cnic_pic_name, $old['highest_education'], $status);

                if ($insert_stmt->execute()) {
                    $success = "Student registered successfully! Student ID: $student_id";
                    $old = []; // clear form
                } else {
                    $error = 'Database error: Unable to register student.';
                }
                $insert_stmt->close();
            }
        }
    }
}

include BASE_PATH . 'admin/view/student/register.php';
?>