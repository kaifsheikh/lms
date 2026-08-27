<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

$student_id = $_SESSION['user_id'];
$error = '';

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Verify student is assigned to the batch of this quiz, and quiz is active
$stmt = $conn->prepare("
    SELECT q.id, q.title, q.timer, q.passing_marks, q.due_date
    FROM quizzes q
    INNER JOIN batch_students bs ON q.batch_id = bs.batch_id
    WHERE q.id = ?
      AND bs.student_id = ?
      AND q.status = 'active'
");
$stmt->bind_param("ii", $quiz_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

$quiz = $result->fetch_assoc();
$stmt->close();

// Check if the student has already attempted this quiz
$stmt = $conn->prepare("SELECT id FROM quiz_attempts WHERE quiz_id = ? AND student_id = ?");
$stmt->bind_param("ii", $quiz_id, $student_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}
$stmt->close();

// Fetch questions and options
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
    // Fetch options
    $opt_stmt = $conn->prepare("
        SELECT id, option_text
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

// Pass timer in seconds to view
$timer_seconds = $quiz['timer'] * 60;

// Load view
include BASE_PATH . 'student/view/take_quiz.php';
?>