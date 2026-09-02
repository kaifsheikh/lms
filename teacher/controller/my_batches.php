<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lms/config.php';
require_once SESSION;
require_once DB;
 

requireRole(['teacher']);

$teacher_id = $_SESSION['user_id'];

// Model object
$batchModel = new Batch($conn);

// Saari batches with students fetch karo
$batches = $batchModel->getBatchesWithStudentsByTeacher($teacher_id);

// View load karo
include BASE_PATH . 'teacher/view/my_batches.php';
?>