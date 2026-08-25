<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;

requireRole(['admin']);

$message = '';
$error = '';


// ============================================================
// HANDLE POST REQUESTS
// ============================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Protection
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }


    // ========================================================
    // APPROVE / REJECT BATCH
    // ========================================================

    if (
        isset($_POST['batch_id']) &&
        isset($_POST['status'])
    ) {

        $batch_id = filter_input(
            INPUT_POST,
            'batch_id',
            FILTER_VALIDATE_INT
        );

        $new_status = $_POST['status'];


        // Validate batch ID
        if ($batch_id === false || $batch_id <= 0) {

            $error = 'Invalid batch ID.';

        }

        // Validate status
        elseif (!in_array(
            $new_status,
            ['approved', 'rejected'],
            true
        )) {

            $error = 'Invalid status.';

        }

        else {

            $stmt = $conn->prepare(
                "UPDATE batches
                 SET status = ?
                 WHERE id = ?"
            );

            $stmt->bind_param(
                "si",
                $new_status,
                $batch_id
            );

            if ($stmt->execute()) {

                if ($stmt->affected_rows > 0) {
                    $message = "Batch $new_status successfully.";
                } else {
                    $error = 'Batch not found or status is already the same.';
                }

            } else {

                $error = 'Failed to update batch status.';
            }

            $stmt->close();
        }
    }


    // ========================================================
    // DELETE BATCH
    // ========================================================

    elseif (
        isset($_POST['action']) &&
        $_POST['action'] === 'delete_batch'
    ) {

        $batch_id = filter_input(
            INPUT_POST,
            'batch_id',
            FILTER_VALIDATE_INT
        );


        // Validate batch ID
        if ($batch_id === false || $batch_id <= 0) {

            $error = 'Invalid batch selected.';

        } else {

            /*
             * Delete batch_students first.
             *
             * Agar database mein ON DELETE CASCADE properly
             * configured hai to technically zaroori nahi,
             * lekin manually delete karna bhi okay hai.
             */

            $stmt = $conn->prepare(
                "DELETE FROM batch_students
                 WHERE batch_id = ?"
            );

            $stmt->bind_param("i", $batch_id);
            $stmt->execute();
            $stmt->close();


            // Delete batch
            $stmt = $conn->prepare(
                "DELETE FROM batches
                 WHERE id = ?"
            );

            $stmt->bind_param("i", $batch_id);

            if ($stmt->execute()) {

                if ($stmt->affected_rows > 0) {
                    $message = 'Batch deleted successfully.';
                } else {
                    $error = 'Batch not found.';
                }

            } else {

                $error = 'Failed to delete batch.';
            }

            $stmt->close();
        }
    }
}


// ============================================================
// FETCH ALL BATCHES
// ============================================================

$batches = [];

$sql = "
    SELECT
        b.id,
        b.batch_name,
        b.starting_date,
        b.batch_time,
        b.status,
        b.created_at,
        u.full_name AS teacher_name,
        COUNT(bs.student_id) AS total_students

    FROM batches b

    JOIN users u
        ON b.teacher_id = u.id

    LEFT JOIN batch_students bs
        ON bs.batch_id = b.id

    GROUP BY
        b.id,
        b.batch_name,
        b.starting_date,
        b.batch_time,
        b.status,
        b.created_at,
        u.full_name

    ORDER BY b.created_at DESC
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}


include BASE_PATH . 'admin/view/teacher/batch_approval.php';

?>