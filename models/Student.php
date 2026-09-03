<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class Student
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllStudents()
    {
        $students = [];
        $result = $this->conn->query(
            "SELECT id, full_name, student_id, email, contact_number AS contact, status, created_at
             FROM students
             ORDER BY created_at DESC"
        );
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }

    public function getStudentById($student_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
        return null;
    }

    public function updateStatus($student_id, $new_status)
    {
        $stmt = $this->conn->prepare("UPDATE students SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $student_id);
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return ['success' => $success, 'affected' => $affected];
    }

    public function getStudentFiles($student_id)
    {
        $files = ['student_pic' => null, 'cnic_pic' => null];
        $stmt = $this->conn->prepare("SELECT student_pic, cnic_pic FROM students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($files['student_pic'], $files['cnic_pic']);
            $stmt->fetch();
        }
        $stmt->close();
        return $files;
    }

    public function deleteStudent($student_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function emailExists($email, $exclude_student_id = null)
    {
        $stmt = $this->conn->prepare("SELECT id FROM students WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $exclude_student_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        }
        $stmt->close();

        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function updateStudent($student_id, $data, $student_pic_name, $cnic_pic_name, $password = null)
    {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE students SET 
                        full_name=?, father_name=?, contact_number=?, gender=?, dob=?, 
                        address=?, email=?, password=?, joining_date=?, course_name=?, 
                        class_timing=?, course_duration=?, student_pic=?, cnic_pic=?, 
                        highest_education=?, status=? 
                    WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssssssssi",
                $data['full_name'],
                $data['father_name'],
                $data['contact_number'],
                $data['gender'],
                $data['dob'],
                $data['address'],
                $data['email'],
                $hashed_password,
                $data['joining_date'],
                $data['course_name'],
                $data['class_timing'],
                $data['course_duration'],
                $student_pic_name,
                $cnic_pic_name,
                $data['highest_education'],
                $data['status'],
                $student_id
            );
        } else {
            $sql = "UPDATE students SET 
                        full_name=?, father_name=?, contact_number=?, gender=?, dob=?, 
                        address=?, email=?, joining_date=?, course_name=?, 
                        class_timing=?, course_duration=?, student_pic=?, cnic_pic=?, 
                        highest_education=?, status=? 
                    WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "sssssssssssssssi",
                $data['full_name'],
                $data['father_name'],
                $data['contact_number'],
                $data['gender'],
                $data['dob'],
                $data['address'],
                $data['email'],
                $data['joining_date'],
                $data['course_name'],
                $data['class_timing'],
                $data['course_duration'],
                $student_pic_name,
                $cnic_pic_name,
                $data['highest_education'],
                $data['status'],
                $student_id
            );
        }

        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getStudentsWithTeacher()
    {
        $students = [];
        $sql = "
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
        $result = $this->conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }

    public function getApprovedTeachers()
    {
        $teachers = [];
        $result = $this->conn->query(
            "SELECT id, full_name
             FROM users
             WHERE role = 'teacher' AND status = 'approved'
             ORDER BY full_name"
        );
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $teachers[] = $row;
            }
        }
        return $teachers;
    }

    public function getStudentByStudentId($student_id_str)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id_str);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
        return null;
    }

    public function assignTeacherToStudent($student_id, $teacher_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'message' => 'Student not found.'];
        }
        $stmt->close();

        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = ? AND role = 'teacher' AND status = 'approved'");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'message' => 'Selected teacher not found or not approved.'];
        }
        $stmt->close();

        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare("UPDATE students SET teacher_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $teacher_id, $student_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("DELETE FROM batch_students WHERE student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            $this->conn->commit();
            return ['success' => true, 'message' => 'Teacher assigned successfully. Student removed from previous batches if any.'];
        } catch (Throwable $e) {
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Failed to assign teacher. Please try again.'];
        }
    }

    public function generateStudentId()
    {
        do {
            $prefix = 'STU-';
            $random = strtoupper(substr(uniqid(), -6));
            $student_id = $prefix . $random;
            $stmt = $this->conn->prepare("SELECT id FROM students WHERE student_id = ?");
            $stmt->bind_param("s", $student_id);
            $stmt->execute();
            $stmt->store_result();
            $exists = $stmt->num_rows > 0;
            $stmt->close();
        } while ($exists);
        return $student_id;
    }

    public function createStudent($data, $student_pic_name, $cnic_pic_name, $password, $teacher_id, $status)
    {
        $student_id = $this->generateStudentId();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO students 
                (student_id, full_name, father_name, contact_number, gender, dob, address, email, password, joining_date, course_name, class_timing, course_duration, student_pic, cnic_pic, highest_education, status, teacher_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssssssssssi",
            $student_id,
            $data['full_name'],
            $data['father_name'],
            $data['contact_number'],
            $data['gender'],
            $data['dob'],
            $data['address'],
            $data['email'],
            $hashed_password,
            $data['joining_date'],
            $data['course_name'],
            $data['class_timing'],
            $data['course_duration'],
            $student_pic_name,
            $cnic_pic_name,
            $data['highest_education'],
            $status,
            $teacher_id
        );

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'student_id' => $student_id];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Database error: Unable to register student.'];
        }
    }

    public function getStudentsForTeacher($teacher_id)
    {
        $students = [];
        $stmt = $this->conn->prepare("
            SELECT s.student_id, s.full_name, s.father_name,
                   s.course_name, s.class_timing, s.course_duration,
                   s.joining_date, s.status, s.created_at
            FROM students s
            WHERE s.teacher_id = ?
            ORDER BY s.created_at DESC
        ");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row['course_end_date'] = $this->calculateCourseEndDate($row['joining_date'], $row['course_duration']);
            $students[] = $row;
        }
        $stmt->close();
        return $students;
    }

    private function calculateCourseEndDate($joining_date, $duration_str)
    {
        if (empty($joining_date) || empty($duration_str)) return 'N/A';

        $duration_str = trim($duration_str);
        if (preg_match('/^\d+$/', $duration_str)) {
            $number = (int)$duration_str;
            $unit = 'month';
        } else {
            if (!preg_match('/(\d+)\s*(months?|years?|weeks?|days?)/i', $duration_str, $matches)) {
                return 'N/A';
            }
            $number = (int)$matches[1];
            $unit = rtrim(strtolower($matches[2]), 's');
        }

        $interval_spec = '';
        switch ($unit) {
            case 'day': $interval_spec = "P{$number}D"; break;
            case 'week': $interval_spec = "P{$number}W"; break;
            case 'month': $interval_spec = "P{$number}M"; break;
            case 'year': $interval_spec = "P{$number}Y"; break;
            default: return 'N/A';
        }

        try {
            $date = new DateTime($joining_date);
            $date->add(new DateInterval($interval_spec));
            return $date->format('Y-m-d');
        } catch (Exception $e) {
            return 'Invalid Date';
        }
    }

    public function getUnassignedStudentsWithDetailsForTeacher($teacher_id)
    {
        $students = [];
        $stmt = $this->conn->prepare("
            SELECT 
                s.student_id,
                s.full_name,
                s.father_name,
                s.contact_number,
                s.email,
                s.course_name,
                s.class_timing,
                s.course_duration,
                s.joining_date,
                s.status,
                s.created_at
            FROM students s
            WHERE s.teacher_id = ?
              AND NOT EXISTS (
                  SELECT 1
                  FROM batch_students bs
                  WHERE bs.student_id = s.id
              )
            ORDER BY s.created_at DESC
        ");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row['course_end_date'] = $this->calculateCourseEndDate($row['joining_date'], $row['course_duration']);
            $students[] = $row;
        }
        $stmt->close();
        return $students;
    }

    public function getUnassignedStudents()
    {
        $students = [];
        $stmt = $this->conn->prepare("
            SELECT s.id, s.student_id, s.full_name, s.email, s.contact_number
            FROM students s
            LEFT JOIN batch_students bs ON s.id = bs.student_id
            WHERE bs.student_id IS NULL
            ORDER BY s.full_name ASC
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        $stmt->close();
        return $students;
    }

    public function searchStudentWithProgress($student_id_str, $teacher_id)
    {
        $stmt = $this->conn->prepare("
            SELECT id, student_id, full_name, course_name, class_timing,
                   course_duration, joining_date
            FROM students
            WHERE student_id = ? AND teacher_id = ?
        ");
        $stmt->bind_param("si", $student_id_str, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $stmt->close();

            $joining_date = $row['joining_date'];
            $duration_months = intval($row['course_duration']);
            $row['course_end_date'] = date('Y-m-d', strtotime("+$duration_months months", strtotime($joining_date)));

            $start = new DateTime($joining_date);
            $now = new DateTime();
            $interval = $start->diff($now);

            $days_elapsed = (int) $interval->format('%a');
            if ($days_elapsed < 0) $days_elapsed = 0;

            $months_elapsed = ($interval->y * 12) + $interval->m + 1;
            if ($months_elapsed < 1) $months_elapsed = 1;
            if ($months_elapsed > $duration_months) $months_elapsed = $duration_months;

            $row['current_course_month'] = $months_elapsed;
            $row['days_elapsed'] = $days_elapsed;

            return $row;
        }
        $stmt->close();
        return null;
    }
}