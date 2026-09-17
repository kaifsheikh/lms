<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Saare teachers fetch karo
    public function getTeachers()
    {
        $teachers = [];
        $sql = "SELECT id, full_name, email, contact, status, created_at
                FROM users
                WHERE role = 'teacher'
                ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $teachers[] = $row;
            }
        }
        return $teachers;
    }

    // Teacher ka status update karo
    public function updateTeacherStatus($user_id, $new_status)
    {
        $stmt = $this->conn->prepare(
            "UPDATE users SET status = ? WHERE id = ? AND role = 'teacher'"
        );
        $stmt->bind_param("si", $new_status, $user_id);
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return ['success' => $success, 'affected' => $affected];
    }

    // Login ke liye: users table se email se user dhundo
    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare(
            "SELECT id, full_name, password, role, status
             FROM users
             WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user; // null agar nahi mila
    }

    // Login ke liye: students table se email se student dhundo
    public function findStudentByEmail($email)
    {
        $stmt = $this->conn->prepare(
            "SELECT id, full_name, password, 'student' AS role, status
             FROM students
             WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        $stmt->close();
        return $student; // null agar nahi mila
    }
}