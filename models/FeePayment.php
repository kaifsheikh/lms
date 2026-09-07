<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class FeePayment
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getApprovedTeachers()
    {
        $teachers = [];
        $result = $this->conn->query("SELECT id, full_name FROM users WHERE role = 'teacher' AND status = 'approved' ORDER BY full_name");
        while ($row = $result->fetch_assoc()) {
            $teachers[] = $row;
        }
        return $teachers;
    }

    public function getBatchesByTeacher($teacher_id)
    {
        $batches = [];
        $stmt = $this->conn->prepare("SELECT id, batch_name, batch_time FROM batches WHERE teacher_id = ? AND status = 'approved' ORDER BY batch_name");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $batches[] = $row;
        }
        $stmt->close();
        return $batches;
    }

    public function getStudentsByBatch($batch_id)
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

    public function addPayment($student_id, $amount_paid, $payment_date, $payment_month, $remarks = '')
    {
        $stmt = $this->conn->prepare("INSERT INTO fee_payments (student_id, amount_paid, payment_date, payment_month, remarks) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $student_id, $amount_paid, $payment_date, $payment_month, $remarks);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getStudentsWithFeeSummary()
    {
        $students = [];
        $sql = "
            SELECT 
                s.id AS student_id,
                s.student_id AS student_code,
                s.full_name,
                c.course_name,
                c.total_price,
                c.admission_fee,
                COALESCE(SUM(fp.amount_paid), 0) AS total_paid
            FROM students s
            LEFT JOIN courses c ON s.course_name = c.course_name
            LEFT JOIN fee_payments fp ON fp.student_id = s.id
            GROUP BY s.id, s.student_id, s.full_name, c.course_name, c.total_price, c.admission_fee
            ORDER BY s.created_at DESC
        ";
        $result = $this->conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['remaining'] = max(0, $row['total_price'] - $row['total_paid']);
                if ($row['total_paid'] <= 0) $row['status'] = 'unpaid';
                elseif ($row['total_paid'] >= $row['total_price']) $row['status'] = 'paid';
                else $row['status'] = 'partial';
                $students[] = $row;
            }
        }
        return $students;
    }

    public function getStudentFeeSummary($student_id)
    {
        $stmt = $this->conn->prepare("
            SELECT 
                s.id AS student_id,
                s.student_id AS student_code,
                s.full_name,
                c.course_name,
                c.total_price,
                c.admission_fee,
                COALESCE(SUM(fp.amount_paid), 0) AS total_paid
            FROM students s
            LEFT JOIN courses c ON s.course_name = c.course_name
            LEFT JOIN fee_payments fp ON fp.student_id = s.id
            WHERE s.id = ?
            GROUP BY s.id, s.student_id, s.full_name, c.course_name, c.total_price, c.admission_fee
        ");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            $row['remaining'] = max(0, $row['total_price'] - $row['total_paid']);
            if ($row['total_paid'] <= 0) $row['status'] = 'unpaid';
            elseif ($row['total_paid'] >= $row['total_price']) $row['status'] = 'paid';
            else $row['status'] = 'partial';
        }
        return $row;
    }

    public function getStudentFeeHistory($student_id)
    {
        $payments = [];
        $stmt = $this->conn->prepare("
            SELECT fp.*, s.full_name, s.student_id AS student_code
            FROM fee_payments fp
            INNER JOIN students s ON fp.student_id = s.id
            WHERE fp.student_id = ?
            ORDER BY fp.payment_date DESC
        ");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
        $stmt->close();
        return $payments;
    }

    public function getStudentFeeHistoryByStudentId($student_id_str)
{
    $payments = [];
    $stmt = $this->conn->prepare("
        SELECT fp.*, s.full_name, s.student_id AS student_code
        FROM fee_payments fp
        INNER JOIN students s ON fp.student_id = s.id
        WHERE s.student_id = ?
        ORDER BY fp.payment_date DESC
    ");
    $stmt->bind_param("s", $student_id_str);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    $stmt->close();
    return $payments;
}
}