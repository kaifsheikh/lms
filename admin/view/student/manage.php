<?php include HEADER; ?>

<h1>Manage Students</h1>

<?php if (!empty($message)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Full Name</th>
            <th>Father Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Course</th>
            <th>Status</th>
            <th>Assigned Teacher</th>
            <th>Assign Teacher</th>
            <th>Change Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['father_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                    <td>
                        <?php
                        $status = $row['status'];
                        $color = 'orange';
                        if ($status === 'active') $color = 'green';
                        if ($status === 'process') $color = 'blue';
                        ?>
                        <span style="color: <?php echo $color; ?>;"><?php echo htmlspecialchars($status); ?></span>
                    </td>
                    <td>
                        <?php
                        // Directly use teacher_name from JOIN (null handle)
                        $teacher_name = $row['teacher_name'] ?? 'Not Assigned';
                        echo htmlspecialchars($teacher_name);
                        ?>
                    </td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="action" value="assign_teacher">
                            <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                            <select name="teacher_id">
                                <option value="">-- Select Teacher --</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <?php
                                    $selected = ($teacher['id'] == $row['teacher_id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $teacher['id']; ?>" <?php echo $selected; ?>>
                                        <?php echo htmlspecialchars($teacher['full_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">Assign</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="pending"  <?php echo ($status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="process"  <?php echo ($status === 'process') ? 'selected' : ''; ?>>Process</option>
                                <option value="active"   <?php echo ($status === 'active') ? 'selected' : ''; ?>>Active</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/delete.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                            <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" style="color:red;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="12">No students found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include FOOTER; ?>