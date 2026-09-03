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
                b.teacher_id,
                u.full_name AS teacher_name,
                COUNT(bs.student_id) AS total_students
            FROM batches b
            JOIN users u ON b.teacher_id = u.id
            LEFT JOIN batch_students bs ON bs.batch_id = b.id
            GROUP BY b.id, b.batch_name, b.starting_date, b.batch_time, b.status, b.created_at, b.teacher_id, u.full_name
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

    public function updateBatchStatus($batch_id, $new_status)
    {
        $stmt = $this->conn->prepare("UPDATE batches SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $batch_id);
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return ['success' => $success, 'affected' => $affected];
    }

    public function deleteBatch($batch_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM batches WHERE id = ?");
        $stmt->bind_param("i", $batch_id);
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return ['success' => $success, 'affected' => $affected];
    }

    // =====================================================
    // TEACHER METHODS (if ever needed)
    // =====================================================

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

        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $batch_id, $student_id);
            if (!$stmt->execute()) {
                throw new Exception('Insert failed');
            }
            $stmt->close();

            $this->conn->commit();
            return ['success' => true, 'message' => 'Student assigned to batch successfully.'];
        } catch (Throwable $e) {
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Failed to assign student to batch.'];
        }
    }

    // =====================================================
    // ADMIN SPECIFIC METHODS
    // =====================================================

    public function getStudentBatchMap()
    {
        $map = [];
        $stmt = $this->conn->query("SELECT bs.student_id, bs.batch_id, b.batch_name FROM batch_students bs JOIN batches b ON bs.batch_id = b.id");
        while ($row = $stmt->fetch_assoc()) {
            $map[$row['student_id']] = ['batch_id' => $row['batch_id'], 'batch_name' => $row['batch_name']];
        }
        return $map;
    }

    public function transferStudentToBatch($student_id, $new_batch_id, $teacher_id = 0)
    {
        // Destination batch ka teacher_id nikalo
        $stmt = $this->conn->prepare("SELECT teacher_id FROM batches WHERE id = ?");
        $stmt->bind_param("i", $new_batch_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $new_teacher_id = $result->fetch_assoc()['teacher_id'] ?? 0;
        $stmt->close();

        if ($new_teacher_id == 0) {
            return ['success' => false, 'message' => 'Destination batch not found.'];
        }

        $this->conn->begin_transaction();
        try {
            // Remove from all existing batches
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            // Add to new batch
            $stmt = $this->conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $new_batch_id, $student_id);
            if (!$stmt->execute()) {
                throw new Exception('Insert failed');
            }
            $stmt->close();

            // Update student's teacher_id
            $stmt = $this->conn->prepare("UPDATE students SET teacher_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_teacher_id, $student_id);
            $stmt->execute();
            $stmt->close();

            $this->conn->commit();
            return ['success' => true, 'message' => 'Student transferred successfully.'];
        } catch (Throwable $e) {
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Transfer failed.'];
        }
    }

    public function addStudentToBatch($batch_id, $student_id)
    {
        // Batch ka teacher_id nikalo
        $stmt = $this->conn->prepare("SELECT teacher_id FROM batches WHERE id = ?");
        $stmt->bind_param("i", $batch_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $teacher_id = $row['teacher_id'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Batch not found.'];
        }
        $stmt->close();

        $this->conn->begin_transaction();
        try {
            // Remove student from existing batches
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            // Add to new batch
            $stmt = $this->conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $batch_id, $student_id);
            if (!$stmt->execute()) {
                throw new Exception('Insert failed');
            }
            $stmt->close();

            // Update student's teacher_id
            $stmt = $this->conn->prepare("UPDATE students SET teacher_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $teacher_id, $student_id);
            $stmt->execute();
            $stmt->close();

            $this->conn->commit();
            return ['success' => true, 'message' => 'Student added to batch successfully.'];
        } catch (Throwable $e) {
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Failed to add student to batch.'];
        }
    }

    public function removeStudentFromBatch($batch_id, $student_id)
    {
        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE batch_id = ? AND student_id = ?");
            $stmt->bind_param("ii", $batch_id, $student_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("UPDATE students SET teacher_id = NULL WHERE id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getStudentsByBatchId($batch_id)
    {
        $students = [];
        $stmt = $this->conn->prepare("
            SELECT s.id, s.student_id, s.full_name
            FROM batch_students bs
            INNER JOIN students s ON bs.student_id = s.id
            WHERE bs.batch_id = ?
            ORDER BY s.full_name ASC
        ");
        $stmt->bind_param("i", $batch_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        $stmt->close();
        return $students;
    }

    // Duplicate checks
    public function batchNameExists($teacher_id, $batch_name, $exclude_id = 0)
    {
        $stmt = $this->conn->prepare("SELECT id FROM batches WHERE teacher_id = ? AND batch_name = ? AND id != ?");
        $stmt->bind_param("isi", $teacher_id, $batch_name, $exclude_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function batchTimeExists($teacher_id, $batch_time, $exclude_id = 0)
    {
        $stmt = $this->conn->prepare("SELECT id FROM batches WHERE teacher_id = ? AND batch_time = ? AND id != ?");
        $stmt->bind_param("isi", $teacher_id, $batch_time, $exclude_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function createBatchByAdmin($teacher_id, $batch_name, $starting_date, $batch_time)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO batches (batch_name, starting_date, batch_time, teacher_id, status)
            VALUES (?, ?, ?, ?, 'approved')
        ");
        $stmt->bind_param("sssi", $batch_name, $starting_date, $batch_time, $teacher_id);
        if ($stmt->execute()) {
            $id = $this->conn->insert_id;
            $stmt->close();
            return $id;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function updateBatchByAdmin($batch_id, $teacher_id, $batch_name, $starting_date, $batch_time)
    {
        $stmt = $this->conn->prepare("
            UPDATE batches SET 
                batch_name = ?,
                starting_date = ?,
                batch_time = ?,
                teacher_id = ?
            WHERE id = ?
        ");
        $stmt->bind_param("sssii", $batch_name, $starting_date, $batch_time, $teacher_id, $batch_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Teacher's batches with students (for my_batches page)
    public function getBatchesWithStudentsByTeacher($teacher_id)
    {
        $batches = [];
        $stmt = $this->conn->prepare("
            SELECT b.id, b.batch_name, b.starting_date, b.batch_time, b.status, b.created_at
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

        if (empty($batches)) return [];

        $batch_ids = array_keys($batches);
        $placeholders = implode(',', array_fill(0, count($batch_ids), '?'));
        $types = str_repeat('i', count($batch_ids));

        $sql = "
            SELECT bs.batch_id, s.student_id, s.full_name, s.email, s.course_name
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
            $bid = (int)$row['batch_id'];
            unset($row['batch_id']);
            $batches[$bid]['students'][] = $row;
        }
        $stmt->close();

        return array_values($batches);
    }

    public function assignStudentToTeacherAndBatch($student_id, $teacher_id, $batch_id = null)
{
    $this->conn->begin_transaction();
    try {
        // Student ka teacher_id update karo
        $stmt = $this->conn->prepare("UPDATE students SET teacher_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $teacher_id, $student_id);
        $stmt->execute();
        $stmt->close();

        // Agar batch_id hai to batch_students update, warna remove
        if ($batch_id && $batch_id > 0) {
            // Pehle saare batch_students remove
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            // Phir naya batch add
            $stmt = $this->conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $batch_id, $student_id);
            if (!$stmt->execute()) {
                throw new Exception('Batch add failed');
            }
            $stmt->close();
        } else {
            // Sirf remove from all batches
            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();
        }

        $this->conn->commit();
        return ['success' => true, 'message' => 'Assignment saved successfully.'];
    } catch (Throwable $e) {
        $this->conn->rollback();
        return ['success' => false, 'message' => 'Assignment failed.'];
    }
}

public function getBatchById($batch_id)
{
    $stmt = $this->conn->prepare("SELECT id, teacher_id, batch_name FROM batches WHERE id = ?");
    $stmt->bind_param("i", $batch_id);
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