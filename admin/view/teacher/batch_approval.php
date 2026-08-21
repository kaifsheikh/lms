<?php include HEADER; ?>

<h1>Batch Approval</h1>

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
            <th>Batch Name</th>
            <th>Teacher</th>
            <th>Starting Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Total Students</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($batches)): ?>
            <?php foreach ($batches as $batch): ?>
                <tr>
                    <td><?php echo $batch['id']; ?></td>
                    <td><?php echo htmlspecialchars($batch['batch_name']); ?></td>
                    <td><?php echo htmlspecialchars($batch['teacher_name']); ?></td>
                    <td><?php echo htmlspecialchars($batch['starting_date']); ?></td>
                    <td><?php echo htmlspecialchars($batch['batch_time']); ?></td>
                    <td>
                        <?php
                        $status = $batch['status'];
                        $color = 'orange';
                        if ($status === 'approved') $color = 'green';
                        if ($status === 'rejected') $color = 'red';
                        ?>
                        <span style="color: <?php echo $color; ?>;"><?php echo htmlspecialchars($status); ?></span>
                    </td>
                    <td><?php echo intval($batch['total_students']); ?></td>
                    <td><?php echo htmlspecialchars($batch['created_at']); ?></td>
                    <td>
                        <?php if ($status === 'pending'): ?>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                                <button type="submit" name="status" value="approved">Approve</button>
                            </form>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                                <button type="submit" name="status" value="rejected" style="color:red;">Reject</button>
                            </form>
                        <?php else: ?>
                            <span><?php echo ucfirst($status); ?></span>
                        <?php endif; ?>

                        <!-- Delete batch button (always available) -->
                        <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this batch?');">
                            <input type="hidden" name="action" value="delete_batch">
                            <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                            <button type="submit" style="color:white; background:red; border:none; padding:5px 10px; cursor:pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">No batches found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include FOOTER; ?>