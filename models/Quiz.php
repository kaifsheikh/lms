<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class Quiz
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Teacher ke saare quizzes fetch karo
    public function getQuizzesByTeacher($teacher_id)
    {
        $quizzes = [];
        $stmt = $this->conn->prepare("
            SELECT q.id, q.title, q.description, q.due_date, q.timer, q.passing_marks,
                   q.created_at, q.status, b.batch_name
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
        return $quizzes;
    }

    // Naya quiz create karo
    public function createQuiz($teacher_id, $batch_id, $title, $description, $due_date, $timer, $passing_marks)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO quizzes (teacher_id, batch_id, title, description, due_date, timer, passing_marks, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'draft')
        ");
        $stmt->bind_param("iisssii", $teacher_id, $batch_id, $title, $description, $due_date, $timer, $passing_marks);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Quiz delete karo
    public function deleteQuiz($quiz_id, $teacher_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM quizzes WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $quiz_id, $teacher_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Batch ownership check
    public function verifyBatchOwnership($batch_id, $teacher_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $batch_id, $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }


    // Student ke liye active quizzes (not attempted) fetch karo
    public function getActiveQuizzesForStudent($student_id)
    {
        $quizzes = [];
        $stmt = $this->conn->prepare("
            SELECT DISTINCT q.id, q.title, q.description, q.due_date, q.timer, q.passing_marks,
                   q.created_at, b.batch_name, u.full_name AS teacher_name
            FROM quizzes q
            INNER JOIN batch_students bs ON q.batch_id = bs.batch_id
            INNER JOIN batches b ON q.batch_id = b.id
            INNER JOIN users u ON q.teacher_id = u.id
            WHERE bs.student_id = ?
              AND q.status = 'active'
              AND NOT EXISTS (
                  SELECT 1 FROM quiz_attempts qa
                  WHERE qa.quiz_id = q.id AND qa.student_id = ?
              )
            ORDER BY q.due_date ASC
        ");
        $stmt->bind_param("ii", $student_id, $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $quizzes[] = $row;
        }
        $stmt->close();
        return $quizzes;
    }

    // Student ke quiz results fetch karo
    public function getStudentResults($student_id)
    {
        $results = [];
        $stmt = $this->conn->prepare("
            SELECT qa.quiz_id, qa.obtained_marks, qa.total_marks, qa.percentage, qa.submitted_at,
                q.title AS quiz_title, b.batch_name, u.full_name AS teacher_name
            FROM quiz_attempts qa
            INNER JOIN quizzes q ON qa.quiz_id = q.id
            INNER JOIN batches b ON q.batch_id = b.id
            INNER JOIN users u ON q.teacher_id = u.id
            WHERE qa.student_id = ?
            ORDER BY qa.submitted_at DESC
        ");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        $stmt->close();
        return $results;
    }

    // Check if quiz is active and student belongs to its batch
    public function isQuizActiveForStudent($quiz_id, $student_id)
    {
        $stmt = $this->conn->prepare("
            SELECT q.id
            FROM quizzes q
            INNER JOIN batch_students bs ON q.batch_id = bs.batch_id
            WHERE q.id = ? AND bs.student_id = ? AND q.status = 'active'
        ");
        $stmt->bind_param("ii", $quiz_id, $student_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Check if student has already attempted the quiz
    public function hasStudentAttempted($quiz_id, $student_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM quiz_attempts WHERE quiz_id = ? AND student_id = ?");
        $stmt->bind_param("ii", $quiz_id, $student_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Fetch all question IDs and correct option IDs for a quiz
    public function getQuestionsAndCorrectAnswers($quiz_id)
    {
        $question_ids = [];
        $correct_answers = []; // question_id => correct_option_id

        $stmt = $this->conn->prepare("SELECT id FROM questions WHERE quiz_id = ?");
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $question_ids[] = $row['id'];
        }
        $stmt->close();

        foreach ($question_ids as $qid) {
            $stmt = $this->conn->prepare("SELECT id FROM question_options WHERE question_id = ? AND is_correct = 1 LIMIT 1");
            $stmt->bind_param("i", $qid);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $correct_answers[$qid] = $row['id'];
            }
            $stmt->close();
        }

        return ['question_ids' => $question_ids, 'correct_answers' => $correct_answers];
    }

    // Insert quiz attempt
    public function insertQuizAttempt($quiz_id, $student_id, $obtained_marks, $total_marks, $percentage)
    {
        $stmt = $this->conn->prepare("INSERT INTO quiz_attempts (quiz_id, student_id, obtained_marks, total_marks, percentage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidi", $quiz_id, $student_id, $obtained_marks, $total_marks, $percentage);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Get quiz info for history (title, teacher_id, passing_marks)
    public function getQuizInfoForHistory($quiz_id)
    {
        $info = ['title' => 'Unknown', 'teacher_id' => 0, 'passing_marks' => 0];
        $stmt = $this->conn->prepare("SELECT title, teacher_id, passing_marks FROM quizzes WHERE id = ?");
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $info = $row;
        }
        $stmt->close();
        return $info;
    }

    // Insert permanent quiz attempt history
    public function insertQuizAttemptHistory($teacher_id, $student_id, $student_name, $quiz_title, $percentage, $status)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO quiz_attempt_history 
            (teacher_id, student_id, student_name, quiz_title, attempt_date, percentage, status)
            VALUES (?, ?, ?, ?, NOW(), ?, ?)
        ");
        $stmt->bind_param("iissss", $teacher_id, $student_id, $student_name, $quiz_title, $percentage, $status);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Get student name by ID (optional, can be moved to Student model)
    public function getStudentName($student_id)
    {
        $name = 'Unknown';
        $stmt = $this->conn->prepare("SELECT full_name FROM students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $name = $row['full_name'];
        }
        $stmt->close();
        return $name;
    }

    // Student ke liye active quiz details fetch karo (verify batch membership)
    public function getQuizForStudent($quiz_id, $student_id)
    {
        $stmt = $this->conn->prepare("
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
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
        return null;
    }

public function getQuestionsWithOptions($quiz_id)
{
    $questions = [];
    $stmt = $this->conn->prepare("
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

        // Options fetch karo - is_correct bhi select karo
        $opt_stmt = $this->conn->prepare("
            SELECT id, option_text, is_correct
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
    return $questions;
}

    // Teacher ke liye quiz fetch karo (ownership check ke saath)
public function getQuizByIdAndTeacher($quiz_id, $teacher_id)
{
    $stmt = $this->conn->prepare("
        SELECT id, title, description, batch_id, due_date, timer, passing_marks
        FROM quizzes
        WHERE id = ? AND teacher_id = ?
    ");
    $stmt->bind_param("ii", $quiz_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    }
    $stmt->close();
    return null;
}

// Quiz update karo
public function updateQuiz($quiz_id, $teacher_id, $title, $description, $batch_id, $due_date, $timer, $passing_marks)
{
    $stmt = $this->conn->prepare("
        UPDATE quizzes
        SET title = ?, description = ?, batch_id = ?, due_date = ?, timer = ?, passing_marks = ?
        WHERE id = ? AND teacher_id = ?
    ");
    $stmt->bind_param("ssisiiii", $title, $description, $batch_id, $due_date, $timer, $passing_marks, $quiz_id, $teacher_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Teacher ke approved batches fetch karo (dropdown ke liye)
public function getApprovedBatchesForTeacher($teacher_id)
{
    $batches = [];
    $stmt = $this->conn->prepare("
        SELECT id, batch_name, starting_date, batch_time
        FROM batches
        WHERE teacher_id = ? AND status = 'approved'
        ORDER BY created_at DESC
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
    $stmt->close();
    return $batches;
}

// Teacher ke liye quiz fetch karo (with batch name)
public function getQuizWithBatchForTeacher($quiz_id, $teacher_id)
{
    $stmt = $this->conn->prepare("
        SELECT q.id, q.title, q.description, q.due_date, b.batch_name
        FROM quizzes q
        LEFT JOIN batches b ON q.batch_id = b.id
        WHERE q.id = ? AND q.teacher_id = ?
    ");
    $stmt->bind_param("ii", $quiz_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    }
    $stmt->close();
    return null;
}

// Naya question add karo with options
public function addQuestion($quiz_id, $question_text, $options, $correct_index)
{
    $stmt = $this->conn->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)");
    $stmt->bind_param("is", $quiz_id, $question_text);
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }
    $question_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $this->conn->prepare("INSERT INTO question_options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
    foreach ($options as $index => $option_text) {
        $option_text = trim($option_text);
        if (empty($option_text)) continue;
        $is_correct = ($index == $correct_index) ? 1 : 0;
        $stmt->bind_param("isi", $question_id, $option_text, $is_correct);
        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }
    }
    $stmt->close();
    return true;
}

// Teacher ki quiz attempt history fetch karo
public function getQuizHistoryByTeacher($teacher_id)
{
    $history = [];
    $stmt = $this->conn->prepare("
        SELECT id, student_name, quiz_title, attempt_date, percentage, status
        FROM quiz_attempt_history
        WHERE teacher_id = ?
        ORDER BY attempt_date DESC
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    $stmt->close();
    return $history;
}

// Quiz history record delete karo (teacher ownership ke saath)
public function deleteQuizHistory($history_id, $teacher_id)
{
    $stmt = $this->conn->prepare("DELETE FROM quiz_attempt_history WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $history_id, $teacher_id);
    $success = $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    return ['success' => $success, 'affected' => $affected];
}



// Quiz ownership check
public function verifyQuizOwnership($quiz_id, $teacher_id)
{
    $stmt = $this->conn->prepare("SELECT id FROM quizzes WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $quiz_id, $teacher_id);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Quiz status change karo (draft/active/closed)
public function changeQuizStatus($quiz_id, $teacher_id, $new_status)
{
    $allowed = ['draft', 'active', 'closed'];
    if (!in_array($new_status, $allowed)) return false;
    $stmt = $this->conn->prepare("UPDATE quizzes SET status = ? WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("sii", $new_status, $quiz_id, $teacher_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Quiz start karo (status active)
public function startQuiz($quiz_id, $teacher_id)
{
    return $this->changeQuizStatus($quiz_id, $teacher_id, 'active');
}

// Teacher ke batches fetch karo (dropdown ke liye)
public function getBatchesForTeacher($teacher_id)
{
    $batches = [];
    $stmt = $this->conn->prepare("
        SELECT id, batch_name, starting_date, batch_time
        FROM batches
        WHERE teacher_id = ?
        ORDER BY created_at DESC
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
    $stmt->close();
    return $batches;
}

// Teacher ke saare quizzes with batch name fetch karo
public function getQuizzesWithBatchByTeacher($teacher_id)
{
    $quizzes = [];
    $stmt = $this->conn->prepare("
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
    return $quizzes;
}

// Teacher ke liye quiz result details fetch karo (with batch name)
public function getQuizResultDetailsForTeacher($quiz_id, $teacher_id)
{
    $stmt = $this->conn->prepare("
        SELECT q.id, q.title, q.passing_marks, b.batch_name, q.batch_id
        FROM quizzes q
        LEFT JOIN batches b ON q.batch_id = b.id
        WHERE q.id = ? AND q.teacher_id = ?
    ");
    $stmt->bind_param("ii", $quiz_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    }
    $stmt->close();
    return null;
}

// Batch ke students fetch karo (basic info)
public function getStudentsByBatch($batch_id)
{
    $students = [];
    $stmt = $this->conn->prepare("
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
        $students[$row['student_db_id']] = $row; // keyed by student_db_id
    }
    $stmt->close();
    return $students;
}

// Quiz attempts fetch karo with student info
public function getAttemptsForQuiz($quiz_id)
{
    $attempts = [];
    $stmt = $this->conn->prepare("
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
        $attempts[$row['student_db_id']] = $row; // keyed by student_db_id
    }
    $stmt->close();
    return $attempts;
}

// Quiz attempt delete karo
public function deleteQuizAttempt($attempt_id)
{
    $stmt = $this->conn->prepare("DELETE FROM quiz_attempts WHERE id = ?");
    $stmt->bind_param("i", $attempt_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Quiz attempt details fetch karo (for retake verification)
public function getQuizAttemptByIdAndTeacher($attempt_id, $teacher_id)
{
    $stmt = $this->conn->prepare("
        SELECT qa.id, qa.percentage, q.passing_marks
        FROM quiz_attempts qa
        INNER JOIN quizzes q ON qa.quiz_id = q.id
        WHERE qa.id = ? AND q.teacher_id = ?
    ");
    $stmt->bind_param("ii", $attempt_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    }
    $stmt->close();
    return null;
}

}