<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';


// ---------------------------------------------------------
// Flash messages
// ---------------------------------------------------------

if (isset($_SESSION['student_msg'])) {
    $message = $_SESSION['student_msg'];
    unset($_SESSION['student_msg']);
}

if (isset($_SESSION['student_error'])) {
    $error = $_SESSION['student_error'];
    unset($_SESSION['student_error']);
}


// ---------------------------------------------------------
// Handle POST requests
// ---------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // -----------------------------------------------------
    // CSRF Protection
    // -----------------------------------------------------

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }


    $action = $_POST['action'] ?? '';


    // =====================================================
    // ASSIGN TEACHER
    // =====================================================

    if ($action === 'assign_teacher') {

        $student_id = filter_input(
            INPUT_POST,
            'student_id',
            FILTER_VALIDATE_INT
        );

        $teacher_id = filter_input(
            INPUT_POST,
            'teacher_id',
            FILTER_VALIDATE_INT
        );


        if (
            !$student_id ||
            $student_id <= 0 ||
            !$teacher_id ||
            $teacher_id <= 0
        ) {

            $error = 'Invalid student or teacher selected.';

        } else {

            // -------------------------------------------------
            // Verify student exists
            // -------------------------------------------------

            $stmt = $conn->prepare(
                "SELECT id
                 FROM students
                 WHERE id = ?"
            );

            if (!$stmt) {
                http_response_code(500);
                exit('Database error.');
            }

            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->store_result();

            $student_exists = $stmt->num_rows > 0;

            $stmt->close();


            if (!$student_exists) {

                $error = 'Student not found.';

            } else {

                // -------------------------------------------------
                // Verify approved teacher
                // -------------------------------------------------

                $stmt = $conn->prepare(
                    "SELECT id
                     FROM users
                     WHERE id = ?
                     AND role = 'teacher'
                     AND status = 'approved'"
                );

                if (!$stmt) {
                    http_response_code(500);
                    exit('Database error.');
                }

                $stmt->bind_param("i", $teacher_id);
                $stmt->execute();
                $stmt->store_result();

                $teacher_exists = $stmt->num_rows > 0;

                $stmt->close();


                if (!$teacher_exists) {

                    $error =
                        'Selected teacher not found or not approved.';

                } else {

                    // -------------------------------------------------
                    // Transaction
                    // -------------------------------------------------

                    $conn->begin_transaction();

                    try {

                        // Assign teacher
                        $stmt = $conn->prepare(
                            "UPDATE students
                             SET teacher_id = ?
                             WHERE id = ?"
                        );

                        if (!$stmt) {
                            throw new Exception('Database error.');
                        }

                        $stmt->bind_param(
                            "ii",
                            $teacher_id,
                            $student_id
                        );

                        if (!$stmt->execute()) {
                            throw new Exception(
                                'Failed to assign teacher.'
                            );
                        }

                        $stmt->close();


                        // Remove student from previous batches
                        $stmt = $conn->prepare(
                            "DELETE FROM batch_students
                             WHERE student_id = ?"
                        );

                        if (!$stmt) {
                            throw new Exception('Database error.');
                        }

                        $stmt->bind_param(
                            "i",
                            $student_id
                        );

                        if (!$stmt->execute()) {
                            throw new Exception(
                                'Failed to remove student from previous batches.'
                            );
                        }

                        $stmt->close();


                        // Commit
                        $conn->commit();

                        $message =
                            'Teacher assigned successfully. ' .
                            'Student removed from previous batches if any.';

                    } catch (Throwable $e) {

                        $conn->rollback();

                        $error =
                            'Failed to assign teacher. Please try again.';
                    }
                }
            }
        }


    // =====================================================
    // UPDATE STUDENT STATUS
    // =====================================================

    } elseif ($action === 'update_status') {

        $student_id = filter_input(
            INPUT_POST,
            'student_id',
            FILTER_VALIDATE_INT
        );

        $new_status = $_POST['status'] ?? '';


        // Validate student ID
        if (!$student_id || $student_id <= 0) {

            $error = 'Invalid student ID.';

        // Validate status
        } elseif (!in_array(
            $new_status,
            ['pending', 'process', 'active'],
            true
        )) {

            $error = 'Invalid status selected.';

        } else {

            // -------------------------------------------------
            // Update status
            // -------------------------------------------------

            $stmt = $conn->prepare(
                "UPDATE students
                 SET status = ?
                 WHERE id = ?"
            );

            if (!$stmt) {
                http_response_code(500);
                exit('Database error.');
            }

            $stmt->bind_param(
                "si",
                $new_status,
                $student_id
            );

            if ($stmt->execute()) {

                if ($stmt->affected_rows > 0) {

                    $message =
                        'Student status updated to ' .
                        $new_status .
                        '.';

                } else {

                    $error =
                        'Student not found or status is already the same.';
                }

            } else {

                $error =
                    'Failed to update student status.';
            }

            $stmt->close();
        }
    }
}


// ---------------------------------------------------------
// Fetch students with teacher name
// ---------------------------------------------------------

$students_query = "
    SELECT
        s.id,
        s.student_id,
        s.full_name,
        s.father_name,
        s.contact_number,
        s.email,
        s.course_name,
        s.status,
        s.teacher_id,
        s.created_at,
        u.full_name AS teacher_name

    FROM students s

    LEFT JOIN users u
        ON s.teacher_id = u.id
        AND u.role = 'teacher'

    ORDER BY s.created_at DESC
";


$students_result = $conn->query($students_query);

if (!$students_result) {
    http_response_code(500);
    exit('Database error.');
}


$students = [];

while ($row = $students_result->fetch_assoc()) {
    $students[] = $row;
}


// ---------------------------------------------------------
// Fetch approved teachers
// ---------------------------------------------------------

$teachers_query = "
    SELECT
        id,
        full_name

    FROM users

    WHERE role = 'teacher'
    AND status = 'approved'

    ORDER BY full_name
";


$teachers_result = $conn->query($teachers_query);

if (!$teachers_result) {
    http_response_code(500);
    exit('Database error.');
}


$teachers = [];

while ($teacher = $teachers_result->fetch_assoc()) {
    $teachers[] = $teacher;
}

// ---------------------------------------------------------
// Search Student by Student ID (GET request)
// ---------------------------------------------------------
$searched_student = null;
$search_error = '';

if (isset($_GET['student_id']) && trim($_GET['student_id']) !== '') {
    $search_term = trim($_GET['student_id']);

    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $searched_student = $row;
    } else {
        $search_error = 'No student found with that Student ID.';
    }
    $stmt->close();
}

// ---------------------------------------------------------
// Load view
// ---------------------------------------------------------

include BASE_PATH . 'admin/view/student/manage.php';

?>