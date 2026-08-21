<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
requireRole(['admin']);

$message = '';
$error = '';

// Handle approve/reject (existing)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['batch_id']) && isset($_POST['status'])) {
    $batch_id = intval($_POST['batch_id']);
    $new_status = $_POST['status'];

    if (!in_array($new_status, ['approved', 'rejected'])) {
        $error = 'Invalid status.';
    } else {
        $stmt = $conn->prepare("UPDATE batches SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $batch_id);
        if ($stmt->execute()) {
            $message = "Batch $new_status successfully.";
        } else {
            $error = 'Failed to update batch status.';
        }
        $stmt->close();
    }
}

// Handle delete batch (new)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_batch') {
    $batch_id = intval($_POST['batch_id'] ?? 0);

    if ($batch_id <= 0) {
        $error = 'Invalid batch selected.';
    } else {
        // Delete batch_students first (even though ON DELETE CASCADE exists, do explicitly)
        $stmt = $conn->prepare("DELETE FROM batch_students WHERE batch_id = ?");
        $stmt->bind_param("i", $batch_id);
        $stmt->execute();
        $stmt->close();

        // Delete batch
        $stmt = $conn->prepare("DELETE FROM batches WHERE id = ?");
        $stmt->bind_param("i", $batch_id);
        if ($stmt->execute()) {
            $message = 'Batch deleted successfully.';
        } else {
            $error = 'Failed to delete batch.';
        }
        $stmt->close();
    }
}

// Fetch all batches with teacher name and student count
$batches = [];
$sql = "SELECT b.id, b.batch_name, b.starting_date, b.batch_time, b.status, b.created_at, 
               u.full_name as teacher_name,
               COUNT(bs.student_id) as total_students
        FROM batches b
        JOIN users u ON b.teacher_id = u.id
        LEFT JOIN batch_students bs ON bs.batch_id = b.id
        GROUP BY b.id, u.full_name
        ORDER BY b.created_at DESC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}

include BASE_PATH . 'admin/view/teacher/batch_approval.php';
?>