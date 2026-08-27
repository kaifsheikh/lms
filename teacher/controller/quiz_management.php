<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$success = '';

// =====================================================
// HANDLE POST REQUESTS
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    // CREATE QUIZ
    if (isset($_POST['action']) && $_POST['action'] === 'create_quiz') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $due_date = $_POST['due_date'] ?? '';
        $timer = intval($_POST['timer'] ?? 0);
        $passing_marks = intval($_POST['passing_marks'] ?? 0);
        $batch_id = intval($_POST['batch_id'] ?? 0);

        if (empty($title) || empty($due_date) || $timer <= 0 || $passing_marks <= 0) {
            $error = 'All fields are required. Timer and passing marks must be positive.';
        } elseif ($batch_id <= 0) {
            $error = 'Please select a batch.';
        } else {
            $stmt = $conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $batch_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Selected batch not found or does not belong to you.';
                $stmt->close();
            } else {
                $stmt->close();
                $stmt = $conn->prepare("
                    INSERT INTO quizzes (teacher_id, batch_id, title, description, due_date, timer, passing_marks, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'draft')
                ");
                $stmt->bind_param("iisssii", $teacher_id, $batch_id, $title, $description, $due_date, $timer, $passing_marks);
                if ($stmt->execute()) {
                    $success = 'Quiz created successfully!';
                } else {
                    $error = 'Failed to create quiz.';
                }
                $stmt->close();
            }
        }
    }

    // DELETE QUIZ
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete_quiz') {
        $quiz_id = intval($_POST['quiz_id'] ?? 0);
        if ($quiz_id <= 0) {
            $error = 'Invalid quiz selected.';
        } else {
            $stmt = $conn->prepare("SELECT id FROM quizzes WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $quiz_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Quiz not found or does not belong to you.';
                $stmt->close();
            } else {
                $stmt->close();
                $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ? AND teacher_id = ?");
                $stmt->bind_param("ii", $quiz_id, $teacher_id);
                if ($stmt->execute()) {
                    $success = 'Quiz deleted successfully.';
                } else {
                    $error = 'Failed to delete quiz.';
                }
                $stmt->close();
            }
        }
    }

    // START QUIZ (backward compatibility)
    elseif (isset($_POST['action']) && $_POST['action'] === 'start_quiz') {
        $quiz_id = intval($_POST['quiz_id'] ?? 0);
        if ($quiz_id <= 0) {
            $error = 'Invalid quiz selected.';
        } else {
            $stmt = $conn->prepare("SELECT id FROM quizzes WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $quiz_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Quiz not found or does not belong to you.';
                $stmt->close();
            } else {
                $stmt->close();
                $stmt = $conn->prepare("UPDATE quizzes SET status = 'active' WHERE id = ? AND teacher_id = ?");
                $stmt->bind_param("ii", $quiz_id, $teacher_id);
                if ($stmt->execute()) {
                    $success = 'Quiz started successfully! Students can now see it.';
                } else {
                    $error = 'Failed to start quiz.';
                }
                $stmt->close();
            }
        }
    }

    // CHANGE STATUS (new: allow draft/active/closed)
    elseif (isset($_POST['action']) && $_POST['action'] === 'change_status') {
        $quiz_id = intval($_POST['quiz_id'] ?? 0);
        $new_status = $_POST['new_status'] ?? '';
        $allowed_statuses = ['draft', 'active', 'closed'];

        if ($quiz_id <= 0 || !in_array($new_status, $allowed_statuses, true)) {
            $error = 'Invalid status change request.';
        } else {
            $stmt = $conn->prepare("SELECT id FROM quizzes WHERE id = ? AND teacher_id = ?");
            $stmt->bind_param("ii", $quiz_id, $teacher_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $error = 'Quiz not found or does not belong to you.';
                $stmt->close();
            } else {
                $stmt->close();
                $stmt = $conn->prepare("UPDATE quizzes SET status = ? WHERE id = ? AND teacher_id = ?");
                $stmt->bind_param("sii", $new_status, $quiz_id, $teacher_id);
                if ($stmt->execute()) {
                    $status_labels = [
                        'draft' => 'set to draft',
                        'active' => 'activated',
                        'closed' => 'closed'
                    ];
                    $success = 'Quiz ' . ($status_labels[$new_status] ?? 'updated') . ' successfully.';
                } else {
                    $error = 'Failed to update quiz status.';
                }
                $stmt->close();
            }
        }
    }
}

// =====================================================
// FETCH ALL QUIZZES FOR THIS TEACHER
// =====================================================
$quizzes = [];
$stmt = $conn->prepare("
    SELECT q.id, q.title, q.description, q.due_date, q.timer, q.passing_marks, q.created_at, q.status, b.batch_name
    FROM quizzes q
    LEFT JOIN batches b ON q.batch_id = b.id
    WHERE q.teacher_id = ?
    ORDER BY q.created_at DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $quizzes[] = $row;
}
$stmt->close();

// =====================================================
// FETCH TEACHER'S BATCHES FOR DROPDOWN
// =====================================================
$batches = [];
$stmt = $conn->prepare("SELECT id, batch_name, starting_date, batch_time FROM batches WHERE teacher_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}
$stmt->close();

// =====================================================
// LOAD VIEW
// =====================================================
include BASE_PATH . 'teacher/view/quiz_management.php';
?>