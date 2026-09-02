<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class Batch
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // =====================================================
    // ADMIN METHODS
    // =====================================================

    // Saare batches fetch karo with teacher name and student count
    public function getAllBatchesWithDetails()
    {
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
        $result = $this->conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $batches[] = $row;
            }
        }
        return $batches;
    }

    // Batch status update karo (approved/rejected)
    public function updateBatchStatus($batch_id, $new_status)
    {
        $stmt = $this->conn->prepare("UPDATE batches SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $batch_id);
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return ['success' => $success, 'affected' => $affected];
    }

    // Batch delete karo (batch_students bhi delete honge via cascade ya manual)
    public function deleteBatch($batch_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE batch_id = ?");
        $stmt->bind_param("i", $batch_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $this->conn->prepare("DELETE FROM batches WHERE id = ?");
        $stmt->bind_param("i", $batch_id);
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return ['success' => $success, 'affected' => $affected];
    }

    // =====================================================
    // TEACHER METHODS (for create_batch.php)
    // =====================================================

    // Teacher ke approved batches fetch karo (dropdown ke liye)
    public function getApprovedBatchesForTeacher($teacher_id)
    {
        $batches = [];
        $stmt = $this->conn->prepare("
            SELECT id, batch_name, starting_date, batch_time, status
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

    // Naya batch create karo (pending status)
    public function createBatch($teacher_id, $batch_name, $starting_date, $batch_time)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO batches (batch_name, starting_date, batch_time, teacher_id, status)
            VALUES (?, ?, ?, ?, 'pending')
        ");
        $stmt->bind_param("sssi", $batch_name, $starting_date, $batch_time, $teacher_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Verify batch belongs to teacher and is approved
    public function getApprovedBatchById($batch_id, $teacher_id)
    {
        $stmt = $this->conn->prepare("
            SELECT id, batch_name FROM batches
            WHERE id = ? AND teacher_id = ? AND status = 'approved'
        ");
        $stmt->bind_param("ii", $batch_id, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
        return null;
    }

    // Student ko batch assign karo (remove old + insert new)
    public function assignStudentToBatch($student_id, $batch_id, $teacher_id)
    {
        // Verify student belongs to teacher
        $stmt = $this->conn->prepare("SELECT id FROM students WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $student_id, $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'message' => 'Student not found or does not belong to you.'];
        }
        $stmt->close();

        // Verify batch approved and belongs to teacher
        if (!$this->getApprovedBatchById($batch_id, $teacher_id)) {
            return ['success' => false, 'message' => 'Selected batch is not available or not approved.'];
        }

        // Transaction
        $this->conn->begin_transaction();
        try {
            // Remove from existing batches
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            // Add to new batch
            $stmt = $this->conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $batch_id, $student_id);
            if (!$stmt->execute()) {
                throw new Exception('Failed to insert batch student.');
            }
            $stmt->close();

            $this->conn->commit();
            return ['success' => true, 'message' => 'Student assigned to batch successfully.'];
        } catch (Throwable $e) {
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Failed to assign student to batch.'];
        }
    }

    // Student transfer karo (same as assign but with old check)
    public function transferStudentToBatch($student_id, $new_batch_id, $teacher_id)
    {
        // Verify student has a current batch and belongs to teacher
        $stmt = $this->conn->prepare("
            SELECT bs.batch_id
            FROM batch_students bs
            INNER JOIN students s ON bs.student_id = s.id
            WHERE s.id = ? AND s.teacher_id = ?
        ");
        $stmt->bind_param("ii", $student_id, $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'message' => 'Student not found or not assigned to any batch.'];
        }
        $stmt->close();

        // Verify new batch approved
        if (!$this->getApprovedBatchById($new_batch_id, $teacher_id)) {
            return ['success' => false, 'message' => 'Destination batch is not available or not approved.'];
        }

        // Transaction: remove old, add new
        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $new_batch_id, $student_id);
            if (!$stmt->execute()) {
                throw new Exception('Failed to insert batch student.');
            }
            $stmt->close();

            $this->conn->commit();
            return ['success' => true, 'message' => 'Student transferred to new batch successfully.'];
        } catch (Throwable $e) {
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Failed to transfer student.'];
        }
    }

    // Unassigned students for teacher
    public function getUnassignedStudentsForTeacher($teacher_id)
    {
        $students = [];
        $stmt = $this->conn->prepare("
            SELECT s.id, s.full_name, s.student_id
            FROM students s
            LEFT JOIN batch_students bs ON s.id = bs.student_id
            WHERE s.teacher_id = ? AND bs.student_id IS NULL
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

    // Assigned students with batch info for teacher
    public function getAssignedStudentsForTeacher($teacher_id)
    {
        $students = [];
        $stmt = $this->conn->prepare("
            SELECT s.id, s.full_name, s.student_id, bs.batch_id, b.batch_name
            FROM students s
            JOIN batch_students bs ON s.id = bs.student_id
            JOIN batches b ON bs.batch_id = b.id
            WHERE s.teacher_id = ? AND b.teacher_id = ?
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

    // Teacher ki saari batches with students list fetch karo
public function getBatchesWithStudentsByTeacher($teacher_id)
{
    // Pehle saari batches fetch karo
    $batches = [];
    $stmt = $this->conn->prepare("
        SELECT
            b.id,
            b.batch_name,
            b.starting_date,
            b.batch_time,
            b.status,
            b.created_at
        FROM batches b
        WHERE b.teacher_id = ?
        ORDER BY b.created_at DESC
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row['students'] = [];
        $batches[$row['id']] = $row;
    }
    $stmt->close();

    // Agar koi batch nahi hai to return karo
    if (empty($batches)) {
        return [];
    }

    // Saare batch IDs collect karo
    $batch_ids = array_keys($batches);
    $placeholders = implode(',', array_fill(0, count($batch_ids), '?'));
    $types = str_repeat('i', count($batch_ids));

    // Ek hi query mein saare students fetch karo
    $sql = "
        SELECT
            bs.batch_id,
            s.student_id,
            s.full_name,
            s.email,
            s.course_name
        FROM batch_students bs
        INNER JOIN students s ON bs.student_id = s.id
        WHERE bs.batch_id IN ($placeholders)
        ORDER BY s.full_name
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param($types, ...$batch_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $batch_id = (int) $row['batch_id'];
        unset($row['batch_id']);
        $batches[$batch_id]['students'][] = $row;
    }
    $stmt->close();

    // Associative array ko simple list mein convert karo
    return array_values($batches);
}
}