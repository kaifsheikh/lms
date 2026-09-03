<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once DB;

class Course
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllCourses()
    {
        $courses = [];
        $result = $this->conn->query("SELECT * FROM courses ORDER BY created_at DESC");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
        }
        return $courses;
    }

    public function getCourseById($course_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
        return null;
    }

public function createCourse($data)
{
    $stmt = $this->conn->prepare("
        INSERT INTO courses 
        (course_name, duration, admission_fee, total_price, skill_level, schedule, class_hours, outline)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "siddssss",
        $data['course_name'],
        $data['duration'],
        $data['admission_fee'],
        $data['total_price'],
        $data['skill_level'],
        $data['schedule'],
        $data['class_hours'],
        $data['outline']
    );
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

public function updateCourse($course_id, $data)
{
    $stmt = $this->conn->prepare("
        UPDATE courses SET 
            course_name = ?,
            duration = ?,
            admission_fee = ?,
            total_price = ?,
            skill_level = ?,
            schedule = ?,
            class_hours = ?,
            outline = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        "siddssssi",
        $data['course_name'],
        $data['duration'],
        $data['admission_fee'],
        $data['total_price'],
        $data['skill_level'],
        $data['schedule'],
        $data['class_hours'],
        $data['outline'],
        $course_id
    );
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

    public function deleteCourse($course_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}