<?php include HEADER; ?>

<h1>My Unassigned Students</h1>

<?php if (empty($students)): ?>
    <p>No unassigned students found.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Father Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Course</th>
                <th>Class Timing</th>
                <th>Duration</th>
                <th>Joining Date</th>
                <th>Status</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['father_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td><?php echo htmlspecialchars($student['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['class_timing']); ?></td>
                    <td><?php echo htmlspecialchars($student['course_duration']); ?></td>
                    <td><?php echo htmlspecialchars($student['joining_date']); ?></td>
                    <td>
                        <?php
                        $status = $student['status'];
                        $color = 'orange';
                        if ($status === 'active') $color = 'green';
                        if ($status === 'process') $color = 'blue';
                        ?>
                        <span style="color: <?php echo $color; ?>;"><?php echo htmlspecialchars($status); ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($student['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include FOOTER; ?>