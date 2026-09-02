<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class OnlineClass
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Class details fetch karo
    public function getClassDetails($class_id)
    {
        $stmt = $this->conn->prepare("SELECT id, token, end_time, batch_id, meet_link FROM online_classes WHERE id = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
        return null;
    }

    // Student ka batch membership check karo
    public function isStudentInBatch($batch_id, $student_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM batch_students WHERE batch_id = ? AND student_id = ?");
        $stmt->bind_param("ii", $batch_id, $student_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Class attendance mark karo (duplicate ignore)
    public function markClassAttendance($class_id, $student_id)
    {
        $stmt = $this->conn->prepare("INSERT IGNORE INTO class_attendance (class_id, student_id, status) VALUES (?, ?, 'present')");
        $stmt->bind_param("ii", $class_id, $student_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Student ke saare batch IDs fetch karo
    public function getStudentBatchIds($student_id)
    {
        $batch_ids = [];
        $stmt = $this->conn->prepare("SELECT batch_id FROM batch_students WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $batch_ids[] = $row['batch_id'];
        }
        $stmt->close();
        return $batch_ids;
    }

    // Upcoming classes fetch karo (end_time >= now) with attended flag
    public function getUpcomingClassesByStudent($student_id)
    {
        $batch_ids = $this->getStudentBatchIds($student_id);
        $classes = [];

        if (empty($batch_ids)) {
            return $classes;
        }

        $placeholders = implode(',', array_fill(0, count($batch_ids), '?'));
        $types = str_repeat('i', count($batch_ids));
        $stmt = $this->conn->prepare("
            SELECT oc.id, oc.title, oc.meet_link, oc.start_time, oc.end_time, oc.token
            FROM online_classes oc
            WHERE oc.batch_id IN ($placeholders)
              AND oc.end_time >= NOW()
            ORDER BY oc.start_time DESC
        ");
        $stmt->bind_param($types, ...$batch_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Check if already attended
            $attended = $this->isStudentAttended($row['id'], $student_id);
            $row['attended'] = $attended;
            $classes[] = $row;
        }
        $stmt->close();
        return $classes;
    }

    // Check if student already attended class
    private function isStudentAttended($class_id, $student_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM class_attendance WHERE class_id = ? AND student_id = ?");
        $stmt->bind_param("ii", $class_id, $student_id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Teacher ke saare classes fetch karo (dropdown ke liye)
public function getClassesByTeacher($teacher_id)
{
    $classes = [];
    $stmt = $this->conn->prepare("SELECT id, title FROM online_classes WHERE teacher_id = ? ORDER BY start_time DESC");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
    $stmt->close();
    return $classes;
}

// Teacher ke class ki details fetch karo (verify ownership)
public function getClassByIdAndTeacher($class_id, $teacher_id)
{
    $stmt = $this->conn->prepare("SELECT id, title, batch_id FROM online_classes WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $class_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row;
    }
    $stmt->close();
    return null;
}

// Class attendance report fetch karo (present/absent with marked_at)
public function getClassAttendanceReport($class_id, $batch_id)
{
    $attendance = [];
    $stmt = $this->conn->prepare("
        SELECT s.id, s.student_id, s.full_name,
               CASE WHEN ca.id IS NOT NULL THEN 'present' ELSE 'absent' END AS status,
               ca.marked_at
        FROM batch_students bs
        INNER JOIN students s ON bs.student_id = s.id
        LEFT JOIN class_attendance ca ON ca.class_id = ? AND ca.student_id = s.id
        WHERE bs.batch_id = ?
        ORDER BY s.full_name ASC
    ");
    $stmt->bind_param("ii", $class_id, $batch_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
    $stmt->close();
    return $attendance;
}

// Teacher ke liye class create karo
public function createClass($teacher_id, $batch_id, $title, $meet_link, $start_time, $end_time)
{
    $token = strtoupper(bin2hex(random_bytes(4))); // 8 characters
    $stmt = $this->conn->prepare("
        INSERT INTO online_classes (teacher_id, batch_id, title, meet_link, token, start_time, end_time)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisssss", $teacher_id, $batch_id, $title, $meet_link, $token, $start_time, $end_time);
    if ($stmt->execute()) {
        $stmt->close();
        return ['success' => true, 'token' => $token];
    }
    $stmt->close();
    return ['success' => false];
}

// Teacher ki class delete karo (verify ownership)
public function deleteClass($class_id, $teacher_id)
{
    $stmt = $this->conn->prepare("DELETE FROM online_classes WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $class_id, $teacher_id);
    $success = $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    return ['success' => $success, 'affected' => $affected];
}

// Teacher ke saare classes fetch karo (with batch name)
public function getClassesWithBatchByTeacher($teacher_id)
{
    $classes = [];
    $stmt = $this->conn->prepare("
        SELECT oc.id, oc.title, oc.meet_link, oc.token, oc.start_time, oc.end_time, oc.status, b.batch_name
        FROM online_classes oc
        INNER JOIN batches b ON oc.batch_id = b.id
        WHERE oc.teacher_id = ?
        ORDER BY oc.start_time DESC
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
    $stmt->close();
    return $classes;
}

// Get approved batches for teacher (dropdown ke liye)
public function getApprovedBatchesForTeacher($teacher_id)
{
    $batches = [];
    $stmt = $this->conn->prepare("SELECT id, batch_name FROM batches WHERE teacher_id = ? AND status = 'approved'");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
    $stmt->close();
    return $batches;
}

// Check if batch belongs to teacher
public function isBatchBelongsToTeacher($batch_id, $teacher_id)
{
    $stmt = $this->conn->prepare("SELECT id FROM batches WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $batch_id, $teacher_id);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

}