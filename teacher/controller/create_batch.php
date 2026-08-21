<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$success = '';

// ========== Helper: Fetch unassigned students for this teacher ==========
function getUnassignedStudents($conn, $teacher_id) {
    $students = [];
    $stmt = $conn->prepare("
        SELECT s.id, s.full_name, s.student_id
        FROM students s
        LEFT JOIN batch_students bs ON s.id = bs.student_id
        WHERE s.teacher_id = ? AND bs.student_id IS NULL
        ORDER BY s.full_name
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
    return $students;
}

// ========== Helper: Fetch assigned students (already in a batch) for this teacher ==========
function getAssignedStudents($conn, $teacher_id) {
    $students = [];
    $stmt = $conn->prepare("
        SELECT s.id, s.full_name, s.student_id, bs.batch_id, b.batch_name
        FROM students s
        JOIN batch_students bs ON s.id = bs.student_id
        JOIN batches b ON bs.batch_id = b.id
        WHERE s.teacher_id = ? AND b.teacher_id = ?
        ORDER BY s.full_name
    ");
    $stmt->bind_param("ii", $teacher_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
    return $students;
}

// ========== SECTION 1: Create New Batch (ONLY batch info, no students) ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_batch') {
    $batch_name = trim($_POST['batch_name'] ?? '');
    $starting_date = $_POST['starting_date'] ?? '';
    $batch_time = trim($_POST['batch_time'] ?? '');

    if (empty($batch_name) || empty($starting_date) || empty($batch_time)) {
        $error = 'All batch fields are required.';
    } else {
        // Insert batch with pending status
        $stmt = $conn->prepare("INSERT INTO batches (batch_name, starting_date, batch_time, teacher_id, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssi", $batch_name, $starting_date, $batch_time, $teacher_id);
        if ($stmt->execute()) {
            $success = 'Batch created successfully and sent for admin approval.';
        } else {
            $error = 'Failed to create batch.';
        }
        $stmt->close();
    }
}

// ========== SECTION 2: Assign Student to Existing Batch (unassigned students only) ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assign_to_batch') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $batch_id = intval($_POST['batch_id'] ?? 0);

    if ($student_id <= 0 || $batch_id <= 0) {
        $error = 'Please select both student and batch.';
    } else {
        // Verify batch belongs to this teacher
        $stmt = $conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $batch_id, $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $error = 'Selected batch not found or does not belong to you.';
        } else {
            // Remove student from any existing batch (safety, though should be none)
            $stmt->close();
            $stmt = $conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            // Add to selected batch
            $stmt = $conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $batch_id, $student_id);
            if ($stmt->execute()) {
                $success = 'Student assigned to batch successfully.';
            } else {
                $error = 'Failed to assign student to batch.';
            }
            $stmt->close();
        }
    }
}

// ========== SECTION 3: Transfer Student to Another Batch (assigned students only) ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'transfer_student') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $new_batch_id = intval($_POST['new_batch_id'] ?? 0);

    if ($student_id <= 0 || $new_batch_id <= 0) {
        $error = 'Please select both student and destination batch.';
    } else {
        // Verify student belongs to this teacher and currently in a batch
        $stmt = $conn->prepare("
            SELECT bs.batch_id 
            FROM batch_students bs 
            JOIN students s ON bs.student_id = s.id 
            WHERE s.id = ? AND s.teacher_id = ?
        ");
        $stmt->bind_param("ii", $student_id, $teacher_id);
        $stmt->execute();
        $stmt->bind_result($current_batch_id);
        if (!$stmt->fetch()) {
            $error = 'Student not found or not in any batch.';
        } else {
            $stmt->close();

            // Verify destination batch belongs to this teacher
            $stmt = $conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $new_batch_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Destination batch not found or does not belong to you.';
            } else {
                // Delete old batch association
                $stmt->close();
                $stmt = $conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $stmt->close();

                // Insert new batch association
                $stmt = $conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $new_batch_id, $student_id);
                if ($stmt->execute()) {
                    $success = 'Student transferred to new batch successfully.';
                } else {
                    $error = 'Failed to transfer student.';
                }
                $stmt->close();
            }
        }
    }
}

// ========== FETCH DATA FOR VIEW ==========
$unassigned_students = getUnassignedStudents($conn, $teacher_id);
$assigned_students = getAssignedStudents($conn, $teacher_id);

// Fetch teacher's batches
$batches = [];
$stmt = $conn->prepare("SELECT id, batch_name, starting_date, batch_time, status FROM batches WHERE teacher_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}
$stmt->close();

include BASE_PATH . 'teacher/view/create_batch.php';
?>