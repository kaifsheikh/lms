<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    header('Location: ' . BASE_URL . '/teacher/controller/quiz_management.php');
    exit;
}

// Verify quiz belongs to this teacher
$stmt = $conn->prepare("
    SELECT q.id, q.title, q.description, q.due_date, b.batch_name
    FROM quizzes q
    LEFT JOIN batches b ON q.batch_id = b.id
    WHERE q.id = ? AND q.teacher_id = ?
");
$stmt->bind_param("ii", $quiz_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . '/teacher/controller/quiz_management.php');
    exit;
}

$quiz = $result->fetch_assoc();
$stmt->close();

// =====================================================
// HANDLE POST: ADD QUESTION
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $question_text = trim($_POST['question_text'] ?? '');
    $options = $_POST['options'] ?? [];
    $correct_index = intval($_POST['correct_option'] ?? -1);

    // Validate
    if (empty($question_text)) {
        $error = 'Question text is required.';
    } elseif (count($options) < 2) {
        $error = 'At least two options are required.';
    } elseif ($correct_index < 0 || $correct_index >= count($options)) {
        $error = 'Please select a correct answer.';
    } else {
        // Insert question
        $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)");
        $stmt->bind_param("is", $quiz_id, $question_text);
        if ($stmt->execute()) {
            $question_id = $stmt->insert_id;
            $stmt->close();

            // Insert options
            $stmt = $conn->prepare("INSERT INTO question_options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
            foreach ($options as $index => $option_text) {
                $option_text = trim($option_text);
                if (empty($option_text)) continue;
                $is_correct = ($index == $correct_index) ? 1 : 0;
                $stmt->bind_param("isi", $question_id, $option_text, $is_correct);
                $stmt->execute();
            }
            $stmt->close();
            $success = 'Question added successfully!';
        } else {
            $error = 'Failed to add question.';
            $stmt->close();
        }
    }
}

// =====================================================
// FETCH EXISTING QUESTIONS FOR THIS QUIZ
// =====================================================
$questions = [];
$stmt = $conn->prepare("
    SELECT id, question_text
    FROM questions
    WHERE quiz_id = ?
    ORDER BY id ASC
");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $question_id = $row['id'];
    // Fetch options for this question
    $opt_stmt = $conn->prepare("
        SELECT option_text, is_correct
        FROM question_options
        WHERE question_id = ?
        ORDER BY id ASC
    ");
    $opt_stmt->bind_param("i", $question_id);
    $opt_stmt->execute();
    $opt_result = $opt_stmt->get_result();
    $options = [];
    while ($opt_row = $opt_result->fetch_assoc()) {
        $options[] = $opt_row;
    }
    $opt_stmt->close();

    $row['options'] = $options;
    $questions[] = $row;
}
$stmt->close();

// =====================================================
// LOAD VIEW
// =====================================================
include BASE_PATH . 'teacher/view/manage_questions.php';
?>