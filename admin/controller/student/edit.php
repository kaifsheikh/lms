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

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_db_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die('Student not found.');
}
$student = $result->fetch_assoc();
$stmt->close();

// Pre-fill $old with existing data
$old = $student;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update data
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
    $status = $_POST['status'] ?? $student['status'];

    // Validation
    if (empty($old['full_name']) || empty($old['father_name']) || empty($old['contact_number']) || empty($old['gender']) || empty($old['dob']) || empty($old['address']) || empty($old['email']) || empty($old['joining_date']) || empty($old['course_name']) || empty($old['class_timing']) || empty($old['course_duration']) || empty($old['highest_education'])) {
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
        // Check email uniqueness (exclude current student)
        $stmt = $conn->prepare("SELECT id FROM students WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $old['email'], $student_db_id);
        $stmt->execute();
        $stmt->store_result();
        $email_exists = $stmt->num_rows > 0;
        $stmt->close();

        if (!$email_exists) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $old['email']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) $email_exists = true;
            $stmt->close();
        }

        if ($email_exists) {
            $error = 'Email already exists with another account.';
        } else {
            // Handle file uploads
            $upload_dir = BASE_PATH . 'assets/uploads/students/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $student_pic_name = $student['student_pic'];
            $cnic_pic_name = $student['cnic_pic'];

            // Student Picture
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
                        // Delete old image
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

            // CNIC Picture
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
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE students SET full_name=?, father_name=?, contact_number=?, gender=?, dob=?, address=?, email=?, password=?, joining_date=?, course_name=?, class_timing=?, course_duration=?, student_pic=?, cnic_pic=?, highest_education=?, status=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssssssssssssssi", $old['full_name'], $old['father_name'], $old['contact_number'], $old['gender'], $old['dob'], $old['address'], $old['email'], $hashed_password, $old['joining_date'], $old['course_name'], $old['class_timing'], $old['course_duration'], $student_pic_name, $cnic_pic_name, $old['highest_education'], $status, $student_db_id);
                } else {
                    $sql = "UPDATE students SET full_name=?, father_name=?, contact_number=?, gender=?, dob=?, address=?, email=?, joining_date=?, course_name=?, class_timing=?, course_duration=?, student_pic=?, cnic_pic=?, highest_education=?, status=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssssssssssi", $old['full_name'], $old['father_name'], $old['contact_number'], $old['gender'], $old['dob'], $old['address'], $old['email'], $old['joining_date'], $old['course_name'], $old['class_timing'], $old['course_duration'], $student_pic_name, $cnic_pic_name, $old['highest_education'], $status, $student_db_id);
                }

                if ($stmt->execute()) {
                    $success = 'Student updated successfully!';
                    // Refresh student data
                    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
                    $stmt->bind_param("i", $student_db_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $student = $result->fetch_assoc();
                    $old = $student;
                } else {
                    $error = 'Failed to update student.';
                }
                $stmt->close();
            }
        }
    }
}

include BASE_PATH . 'admin/view/student/edit.php';
?>