<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class Attendance
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Student ki attendance records fetch karo (with batch name)
    public function getStudentAttendance($student_id)
    {
        $records = [];
        $stmt = $this->conn->prepare("
            SELECT a.date, a.status, b.batch_name
            FROM attendance a
            INNER JOIN batches b ON a.batch_id = b.id
            WHERE a.student_id = ?
            ORDER BY a.date DESC
        ");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        $stmt->close();
        return $records;
    }

    // Attendance summary compute karo (present, absent, late, leave)
    public function getAttendanceSummary($records)
    {
        $summary = ['present' => 0, 'absent' => 0, 'late' => 0, 'leave' => 0];
        foreach ($records as $rec) {
            if (isset($summary[$rec['status']])) {
                $summary[$rec['status']]++;
            }
        }
        return $summary;
    }

    // Teacher ka approved batch fetch karo (verify ownership)
public function getApprovedBatchForTeacher($batch_id, $teacher_id)
{
    $stmt = $this->conn->prepare("
        SELECT id, batch_name
        FROM batches
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

// Check if attendance already marked for batch and date
public function isAttendanceMarked($batch_id, $date)
{
    $stmt = $this->conn->prepare("SELECT id FROM attendance WHERE batch_id = ? AND date = ?");
    $stmt->bind_param("is", $batch_id, $date);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Fetch students in a batch
public function getStudentsByBatch($batch_id)
{
    $students = [];
    $stmt = $this->conn->prepare("
        SELECT s.id, s.student_id, s.full_name
        FROM students s
        INNER JOIN batch_students bs ON s.id = bs.student_id
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

// Teacher ke approved batches fetch karo (dropdown ke liye)
public function getApprovedBatchesForTeacher($teacher_id)
{
    $batches = [];
    $stmt = $this->conn->prepare("SELECT id, batch_name FROM batches WHERE teacher_id = ? AND status = 'approved' ORDER BY batch_name");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
    $stmt->close();
    return $batches;
}

// Teacher ka approved batch fetch karo (with batch_name) - already exists but used for verification
// We'll reuse getApprovedBatchForTeacher if present, else add:
public function getBatchByIdAndTeacher($batch_id, $teacher_id)
{
    $stmt = $this->conn->prepare("SELECT id, batch_name FROM batches WHERE id = ? AND teacher_id = ? AND status = 'approved'");
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

// Attendance report for batch and date (with student info)
public function getAttendanceReportByBatchAndDate($batch_id, $date)
{
    $records = [];
    $stmt = $this->conn->prepare("
        SELECT a.id, a.status, s.student_id, s.full_name
        FROM attendance a
        INNER JOIN students s ON a.student_id = s.id
        WHERE a.batch_id = ? AND a.date = ?
        ORDER BY s.full_name ASC
    ");
    $stmt->bind_param("is", $batch_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    $stmt->close();
    return $records;
}

// Attendance save karo (with transaction, batch verify, duplicate check, student verify)
public function saveAttendance($batch_id, $date, $attendance_data, $teacher_id)
{
    // Verify batch belongs to teacher and is approved
    $batch = $this->getBatchByIdAndTeacher($batch_id, $teacher_id);
    if (!$batch) {
        return ['success' => false, 'message' => 'Batch not found or permission denied.'];
    }

    // Check if attendance already marked for this date
    if ($this->isAttendanceMarked($batch_id, $date)) {
        return ['success' => false, 'message' => 'Attendance already marked for this date.'];
    }

    // Allowed statuses
    $allowed_statuses = ['present', 'absent', 'late', 'leave'];

    // Transaction start
    $this->conn->begin_transaction();
    try {
        $insert_stmt = $this->conn->prepare("INSERT INTO attendance (batch_id, student_id, date, status, marked_by) VALUES (?, ?, ?, ?, ?)");
        if (!$insert_stmt) {
            throw new Exception('Database error.');
        }

        foreach ($attendance_data as $student_id => $status) {
            $student_id = intval($student_id);
            if ($student_id <= 0 || !in_array($status, $allowed_statuses, true)) {
                continue; // Ignore invalid entries
            }

            // Verify student belongs to this batch
            $student_check = $this->conn->prepare("SELECT id FROM batch_students WHERE batch_id = ? AND student_id = ?");
            $student_check->bind_param("ii", $batch_id, $student_id);
            $student_check->execute();
            $student_check->store_result();
            if ($student_check->num_rows === 0) {
                $student_check->close();
                continue; // Student not in this batch, skip
            }
            $student_check->close();

            // Insert record
            $insert_stmt->bind_param("iissi", $batch_id, $student_id, $date, $status, $teacher_id);
            if (!$insert_stmt->execute()) {
                throw new Exception('Failed to save attendance for student ID ' . $student_id);
            }
        }

        $insert_stmt->close();
        $this->conn->commit();
        return ['success' => true, 'message' => 'Attendance saved successfully.'];
    } catch (Throwable $e) {
        $this->conn->rollback();
        return ['success' => false, 'message' => 'Failed to save attendance. Please try again.'];
    }
}
}