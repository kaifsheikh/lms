<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

$error = '';
$success = '';


// ==========================================================
// CSRF PROTECTION
// ==========================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
}


// ==========================================================
// HELPER: FETCH UNASSIGNED STUDENTS
// ==========================================================

function getUnassignedStudents($conn, $teacher_id)
{
    $students = [];

    $stmt = $conn->prepare("
        SELECT s.id, s.full_name, s.student_id
        FROM students s
        LEFT JOIN batch_students bs
            ON s.id = bs.student_id
        WHERE s.teacher_id = ?
          AND bs.student_id IS NULL
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


// ==========================================================
// HELPER: FETCH ASSIGNED STUDENTS
// ==========================================================

function getAssignedStudents($conn, $teacher_id)
{
    $students = [];

    $stmt = $conn->prepare("
        SELECT
            s.id,
            s.full_name,
            s.student_id,
            bs.batch_id,
            b.batch_name
        FROM students s
        JOIN batch_students bs
            ON s.id = bs.student_id
        JOIN batches b
            ON bs.batch_id = b.id
        WHERE s.teacher_id = ?
          AND b.teacher_id = ?
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


// ==========================================================
// SECTION 1: CREATE NEW BATCH
// ==========================================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'create_batch'
) {

    $batch_name = trim($_POST['batch_name'] ?? '');
    $starting_date = $_POST['starting_date'] ?? '';
    $batch_time = trim($_POST['batch_time'] ?? '');

    if (
        empty($batch_name) ||
        empty($starting_date) ||
        empty($batch_time)
    ) {

        $error = 'All batch fields are required.';

    } else {

        $stmt = $conn->prepare("
            INSERT INTO batches
            (
                batch_name,
                starting_date,
                batch_time,
                teacher_id,
                status
            )
            VALUES (?, ?, ?, ?, 'pending')
        ");

        $stmt->bind_param(
            "sssi",
            $batch_name,
            $starting_date,
            $batch_time,
            $teacher_id
        );

        if ($stmt->execute()) {

            $success = 'Batch created successfully and sent for admin approval.';

        } else {

            $error = 'Failed to create batch.';
        }

        $stmt->close();
    }
}


// ==========================================================
// SECTION 2: ASSIGN STUDENT TO EXISTING BATCH
// ==========================================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'assign_to_batch'
) {

    $student_id = intval($_POST['student_id'] ?? 0);
    $batch_id = intval($_POST['batch_id'] ?? 0);

    if ($student_id <= 0 || $batch_id <= 0) {

        $error = 'Please select both student and batch.';

    } else {

        // --------------------------------------------------
        // Verify student belongs to this teacher
        // --------------------------------------------------

        $stmt = $conn->prepare("
            SELECT id
            FROM students
            WHERE id = ?
              AND teacher_id = ?
        ");

        $stmt->bind_param(
            "ii",
            $student_id,
            $teacher_id
        );

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {

            $error = 'Student not found or does not belong to you.';

            $stmt->close();

        } else {

            $stmt->close();

            // ----------------------------------------------
            // Verify batch belongs to teacher AND approved
            // ----------------------------------------------

            $stmt = $conn->prepare("
                SELECT id
                FROM batches
                WHERE id = ?
                  AND teacher_id = ?
                  AND status = 'approved'
            ");

            $stmt->bind_param(
                "ii",
                $batch_id,
                $teacher_id
            );

            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {

                $error = 'Selected batch is not available or not approved.';

                $stmt->close();

            } else {

                $stmt->close();

                // ------------------------------------------
                // Remove student from any existing batch
                // ------------------------------------------

                $stmt = $conn->prepare("
                    DELETE FROM batch_students
                    WHERE student_id = ?
                ");

                $stmt->bind_param(
                    "i",
                    $student_id
                );

                $stmt->execute();
                $stmt->close();


                // ------------------------------------------
                // Add student to selected batch
                // ------------------------------------------

                $stmt = $conn->prepare("
                    INSERT INTO batch_students
                    (
                        batch_id,
                        student_id
                    )
                    VALUES (?, ?)
                ");

                $stmt->bind_param(
                    "ii",
                    $batch_id,
                    $student_id
                );

                if ($stmt->execute()) {

                    $success = 'Student assigned to batch successfully.';

                } else {

                    $error = 'Failed to assign student to batch.';
                }

                $stmt->close();
            }
        }
    }
}


// ==========================================================
// SECTION 3: TRANSFER STUDENT TO ANOTHER BATCH
// ==========================================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'transfer_student'
) {

    $student_id = intval($_POST['student_id'] ?? 0);
    $new_batch_id = intval($_POST['new_batch_id'] ?? 0);

    if ($student_id <= 0 || $new_batch_id <= 0) {

        $error = 'Please select both student and destination batch.';

    } else {

        // --------------------------------------------------
        // Verify student belongs to this teacher
        // AND is currently assigned to a batch
        // --------------------------------------------------

        $stmt = $conn->prepare("
            SELECT bs.batch_id
            FROM batch_students bs
            INNER JOIN students s
                ON bs.student_id = s.id
            WHERE s.id = ?
              AND s.teacher_id = ?
        ");

        $stmt->bind_param(
            "ii",
            $student_id,
            $teacher_id
        );

        $stmt->execute();

        $stmt->bind_result($current_batch_id);

        if (!$stmt->fetch()) {

            $error = 'Student not found or not assigned to any batch.';

            $stmt->close();

        } else {

            $stmt->close();

            // ----------------------------------------------
            // Verify destination batch belongs to teacher
            // AND is approved
            // ----------------------------------------------

            $stmt = $conn->prepare("
                SELECT id
                FROM batches
                WHERE id = ?
                  AND teacher_id = ?
                  AND status = 'approved'
            ");

            $stmt->bind_param(
                "ii",
                $new_batch_id,
                $teacher_id
            );

            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {

                $error = 'Destination batch is not available or not approved.';

                $stmt->close();

            } else {

                $stmt->close();

                // ------------------------------------------
                // Remove old batch association
                // ------------------------------------------

                $stmt = $conn->prepare("
                    DELETE FROM batch_students
                    WHERE student_id = ?
                ");

                $stmt->bind_param(
                    "i",
                    $student_id
                );

                $stmt->execute();
                $stmt->close();


                // ------------------------------------------
                // Add new batch association
                // ------------------------------------------

                $stmt = $conn->prepare("
                    INSERT INTO batch_students
                    (
                        batch_id,
                        student_id
                    )
                    VALUES (?, ?)
                ");

                $stmt->bind_param(
                    "ii",
                    $new_batch_id,
                    $student_id
                );

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


// ==========================================================
// FETCH UNASSIGNED STUDENTS
// ==========================================================

$unassigned_students = getUnassignedStudents(
    $conn,
    $teacher_id
);


// ==========================================================
// FETCH ASSIGNED STUDENTS
// ==========================================================

$assigned_students = getAssignedStudents(
    $conn,
    $teacher_id
);


// ==========================================================
// FETCH TEACHER'S BATCHES
// ==========================================================

$batches = [];

$stmt = $conn->prepare("
    SELECT
        id,
        batch_name,
        starting_date,
        batch_time,
        status
    FROM batches
    WHERE teacher_id = ?
      AND status = 'approved'
    ORDER BY created_at DESC
");

$stmt->bind_param(
    "i",
    $teacher_id
);

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}

$stmt->close();


// ==========================================================
// LOAD VIEW
// ==========================================================

include BASE_PATH . 'teacher/view/create_batch.php';

?>