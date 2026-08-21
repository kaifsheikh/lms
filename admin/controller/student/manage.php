<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['admin']);

$message = '';
$error = '';

// Flash messages from delete
if (isset($_SESSION['student_msg'])) {
    $message = $_SESSION['student_msg'];
    unset($_SESSION['student_msg']);
}
if (isset($_SESSION['student_error'])) {
    $error = $_SESSION['student_error'];
    unset($_SESSION['student_error']);
}

// Teacher assignment handle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assign_teacher') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $teacher_id = intval($_POST['teacher_id'] ?? 0);

    if ($student_id <= 0 || $teacher_id <= 0) {
        $error = 'Invalid student or teacher selected.';
    } else {
        // Validate teacher exists and is approved
        $stmt = $conn->prepare("SELECT id FROM users WHERE id = ? AND role = 'teacher' AND status = 'approved'");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $error = 'Selected teacher not found or not approved.';
        } else {
            $stmt->close();

            // Update teacher_id
            $stmt = $conn->prepare("UPDATE students SET teacher_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $teacher_id, $student_id);
            $stmt->execute();
            $stmt->close();

            // 🔥 IMPORTANT: Remove student from all existing batches (old teacher's batch)
            // Taki purane teacher ke portal par ye student kisi bhi batch mein na dikhe
            $stmt = $conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            $message = 'Teacher assigned successfully. Student removed from previous batches (if any).';
        }
    }
}

// Status update handle (same as before)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $new_status = $_POST['status'] ?? '';

    if (!in_array($new_status, ['pending', 'process', 'active'])) {
        $error = 'Invalid status selected.';
    } else {
        $stmt = $conn->prepare("UPDATE students SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $student_id);
        if ($stmt->execute()) {
            $message = "Student status updated to $new_status.";
        } else {
            $error = 'Failed to update student status.';
        }
        $stmt->close();
    }
}

// Fetch all students WITH teacher name using LEFT JOIN
$students_query = "
    SELECT s.id, s.student_id, s.full_name, s.father_name, s.contact_number, s.email, s.course_name, s.status, s.teacher_id, s.created_at,
           u.full_name AS teacher_name
    FROM students s
    LEFT JOIN users u ON s.teacher_id = u.id
    ORDER BY s.created_at DESC
";
$students_result = $conn->query($students_query);
$students = [];
while ($row = $students_result->fetch_assoc()) {
    $students[] = $row;
}

// Fetch all approved teachers for dropdown
$teachers_query = "SELECT id, full_name FROM users WHERE role='teacher' AND status='approved' ORDER BY full_name";
$teachers_result = $conn->query($teachers_query);
$teachers = [];
while ($teacher = $teachers_result->fetch_assoc()) {
    $teachers[] = $teacher;
}

include BASE_PATH . 'admin/view/student/manage.php';
?>