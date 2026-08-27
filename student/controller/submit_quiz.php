<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['student']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// CSRF Protection
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}

$student_id = $_SESSION['user_id'];
$quiz_id = intval($_POST['quiz_id'] ?? 0);
$answers = $_POST['answers'] ?? []; // question_id => option_id

if ($quiz_id <= 0) {
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}

// Verify quiz is active and student belongs to its batch
$stmt = $conn->prepare("
    SELECT q.id
    FROM quizzes q
    INNER JOIN batch_students bs ON q.batch_id = bs.batch_id
    WHERE q.id = ? AND bs.student_id = ? AND q.status = 'active'
");
$stmt->bind_param("ii", $quiz_id, $student_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . '/student/controller/quizzes.php');
    exit;
}
$stmt->close();

// Check if already attempted (to prevent duplicate submission)
$stmt = $conn->prepare("SELECT id FROM quiz_attempts WHERE quiz_id = ? AND student_id = ?");
$stmt->bind_param("ii", $quiz_id, $student_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . '/student/controller/results.php');
    exit;
}
$stmt->close();

// Fetch all questions and correct options
$total_questions = 0;
$correct_answers = []; // question_id => correct_option_id

$stmt = $conn->prepare("SELECT id FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$question_ids = [];
while ($row = $result->fetch_assoc()) {
    $question_ids[] = $row['id'];
}
$stmt->close();

$total_questions = count($question_ids);

foreach ($question_ids as $qid) {
    $stmt = $conn->prepare("SELECT id FROM question_options WHERE question_id = ? AND is_correct = 1 LIMIT 1");
    $stmt->bind_param("i", $qid);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $correct_answers[$qid] = $row['id'];
    }
    $stmt->close();
}

// Calculate obtained marks (each correct answer = 1 mark)
$obtained_marks = 0;
foreach ($answers as $qid => $selected_option_id) {
    $qid = intval($qid);
    $selected_option_id = intval($selected_option_id);
    if (isset($correct_answers[$qid]) && $correct_answers[$qid] === $selected_option_id) {
        $obtained_marks++;
    }
}

$total_marks = $total_questions; // 1 mark per question
$percentage = ($total_marks > 0) ? ($obtained_marks / $total_marks) * 100 : 0;
$percentage = round($percentage, 2);

// Insert attempt with marks
$stmt = $conn->prepare("INSERT INTO quiz_attempts (quiz_id, student_id, obtained_marks, total_marks, percentage) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiidi", $quiz_id, $student_id, $obtained_marks, $total_marks, $percentage);
$stmt->execute();
$stmt->close();

// Redirect to results page
header('Location: ' . BASE_URL . '/student/controller/results.php');
exit;
?>