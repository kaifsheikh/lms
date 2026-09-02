<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Model object
$quizModel = new Quiz($conn);

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
        $attempt = $quizModel->getQuizAttemptByIdAndTeacher($attempt_id, $teacher_id);
        if (!$attempt) {
            $error = 'Attempt not found or does not belong to you.';
        } elseif ($attempt['percentage'] >= $attempt['passing_marks']) {
            $error = 'This attempt is not failed. Retake not allowed.';
        } else {
            if ($quizModel->deleteQuizAttempt($attempt_id)) {
                $message = 'Attempt deleted. Student can retake the quiz now.';
            } else {
                $error = 'Failed to delete attempt.';
            }
        }
    }
}

// ---------- FETCH TEACHER'S QUIZZES FOR DROPDOWN ----------
$quizzes = $quizModel->getQuizzesByTeacher($teacher_id); // Assumes this method exists (returns id, title)

// ---------- FETCH ATTEMPTS IF QUIZ SELECTED ----------
$selected_quiz = null;
$attempts = [];
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id > 0) {
    $selected_quiz = $quizModel->getQuizResultDetailsForTeacher($quiz_id, $teacher_id);

    if (!$selected_quiz) {
        $error = 'Quiz not found or permission denied.';
    } else {
        $batch_id = $selected_quiz['batch_id'] ?? 0;

        // Fetch all students in that batch (if batch exists)
        $batch_students = [];
        if ($batch_id > 0) {
            $batch_students = $quizModel->getStudentsByBatch($batch_id);
        }

        // Fetch attempts for this quiz
        $attempt_map = $quizModel->getAttemptsForQuiz($quiz_id);

        // Add passed flag to attempts
        foreach ($attempt_map as &$attempt) {
            $attempt['passed'] = ($attempt['percentage'] >= $selected_quiz['passing_marks']);
        }
        unset($attempt);

        // Combine batch students with attempts
        $attempts = [];
        foreach ($batch_students as $student_db_id => $student) {
            if (isset($attempt_map[$student_db_id])) {
                $combined = $attempt_map[$student_db_id];
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

        // Fallback if no batch students (e.g., quiz has no batch)
        if (empty($attempts) && !empty($attempt_map)) {
            $attempts = array_values($attempt_map);
            foreach ($attempts as &$a) {
                $a['not_submitted'] = false;
            }
            unset($a);
        }

        // Compute statistics
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
    }
}

include BASE_PATH . 'teacher/view/quiz_results.php';
?>