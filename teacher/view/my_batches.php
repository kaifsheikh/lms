<?php include HEADER; ?>

<h1>My Batches</h1>

<?php if (empty($batches)): ?>
    <p>No batches created yet.</p>
<?php else: ?>
    <?php foreach ($batches as $batch): ?>
        <div style="border:1px solid #ccc; margin-bottom:20px; padding:15px;">
            <h2><?php echo htmlspecialchars($batch['batch_name']); ?></h2>
            <p><strong>Status:</strong> 
                <span style="color: <?php echo $batch['status'] === 'approved' ? 'green' : ($batch['status'] === 'rejected' ? 'red' : 'orange'); ?>;">
                    <?php echo htmlspecialchars($batch['status']); ?>
                </span>
            </p>
            <p><strong>Starting Date:</strong> <?php echo htmlspecialchars($batch['starting_date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($batch['batch_time']); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($batch['created_at']); ?></p>

            <h3>Students in this Batch</h3>
            <?php if (empty($batch['students'])): ?>
                <p>No students assigned.</p>
            <?php else: ?>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Course</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($batch['students'] as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['course_name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include FOOTER; ?>