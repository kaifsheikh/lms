<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$message = '';
$error = '';

// ---------- HANDLE RETake POST ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'retake_attempt') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $attempt_id = intval($_POST['attempt_id'] ?? 0);
    if ($attempt_id <= 0) {
        $error = 'Invalid attempt.';
    } else {
        $stmt = $conn->prepare("
            SELECT qa.id, qa.percentage, q.passing_marks
            FROM quiz_attempts qa
            INNER JOIN quizzes q ON qa.quiz_id = q.id
            WHERE qa.id = ? AND q.teacher_id = ?
        ");
        $stmt->bind_param("ii", $attempt_id, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($row['percentage'] < $row['passing_marks']) {
                $del_stmt = $conn->prepare("DELETE FROM quiz_attempts WHERE id = ?");
                $del_stmt->bind_param("i", $attempt_id);
                if ($del_stmt->execute()) {
                    $message = 'Attempt deleted. Student can retake the quiz now.';
                } else {
                    $error = 'Failed to delete attempt.';
                }
                $del_stmt->close();
            } else {
                $error = 'This attempt is not failed. Retake not allowed.';
            }
        } else {
            $error = 'Attempt not found or does not belong to you.';
        }
        $stmt->close();
    }
}

// ---------- FETCH TEACHER'S QUIZZES FOR DROPDOWN ----------
$quizzes = [];
$stmt = $conn->prepare("SELECT id, title FROM quizzes WHERE teacher_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $quizzes[] = $row;
}
$stmt->close();

// ---------- FETCH ATTEMPTS IF QUIZ SELECTED ----------
$selected_quiz = null;
$attempts = [];
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id > 0) {
    $stmt = $conn->prepare("
        SELECT q.id, q.title, q.passing_marks, b.batch_name, q.batch_id
        FROM quizzes q
        LEFT JOIN batches b ON q.batch_id = b.id
        WHERE q.id = ? AND q.teacher_id = ?
    ");
    $stmt->bind_param("ii", $quiz_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $selected_quiz = $row;
    } else {
        $error = 'Quiz not found or permission denied.';
    }
    $stmt->close();

    if ($selected_quiz) {
        $batch_id = $selected_quiz['batch_id'] ?? 0;

        // Fetch all students in that batch
        $batch_students = [];
        if ($batch_id > 0) {
            $stmt = $conn->prepare("
                SELECT s.id AS student_db_id, s.student_id, s.full_name
                FROM batch_students bs
                INNER JOIN students s ON bs.student_id = s.id
                WHERE bs.batch_id = ?
                ORDER BY s.full_name ASC
            ");
            $stmt->bind_param("i", $batch_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $batch_students[$row['student_db_id']] = $row;
            }
            $stmt->close();
        }

        // Fetch attempts for this quiz
        $attempt_map = [];
        $stmt = $conn->prepare("
            SELECT qa.id AS attempt_id, qa.obtained_marks, qa.total_marks, qa.percentage, qa.submitted_at,
                   s.student_id, s.full_name, s.id AS student_db_id
            FROM quiz_attempts qa
            INNER JOIN students s ON qa.student_id = s.id
            WHERE qa.quiz_id = ?
        ");
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row['passed'] = ($row['percentage'] >= $selected_quiz['passing_marks']);
            $attempt_map[$row['student_db_id']] = $row;
        }
        $stmt->close();

        // Combine batch students with attempts
        $attempts = [];
        foreach ($batch_students as $student_id => $student) {
            if (isset($attempt_map[$student_id])) {
                $combined = $attempt_map[$student_id];
                $combined['student_id'] = $student['student_id'];
                $combined['full_name'] = $student['full_name'];
                $combined['not_submitted'] = false;
                $attempts[] = $combined;
            } else {
                $attempts[] = [
                    'attempt_id' => null,
                    'obtained_marks' => null,
                    'total_marks' => null,
                    'percentage' => null,
                    'submitted_at' => null,
                    'student_id' => $student['student_id'],
                    'full_name' => $student['full_name'],
                    'not_submitted' => true,
                    'passed' => false
                ];
            }
        }

        // If no batch students (maybe quiz has no batch) fallback to just attempts
        if (empty($attempts) && !empty($attempt_map)) {
            $attempts = array_values($attempt_map);
            foreach ($attempts as &$a) {
                $a['not_submitted'] = false;
            }
            unset($a);
        }

        // ===== COMPUTE STATISTICS =====
        $total_students = count($attempts);
        $passed_count = 0;
        $failed_count = 0;
        $not_submitted_count = 0;

        foreach ($attempts as $a) {
            if ($a['not_submitted']) {
                $not_submitted_count++;
            } elseif ($a['passed']) {
                $passed_count++;
            } else {
                $failed_count++;
            }
        }
        // ===== END STATISTICS =====
    }
}

include BASE_PATH . 'teacher/view/quiz_results.php';
?>