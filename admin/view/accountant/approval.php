<?php include HEADER; ?>

<h1>Accountant Approval</h1>

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
            <th>Full Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Current Status</th>
            <th>Registered At</th>
            <th>Change Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact']); ?></td>
                    <td>
                        <?php
                        $status = $row['status'];
                        $color = 'orange';
                        if ($status === 'approved') $color = 'green';
                        if ($status === 'rejected') $color = 'red';
                        ?>
                        <span style="color: <?php echo $color; ?>;"><?php echo htmlspecialchars($status); ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="pending"  <?php echo ($status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="approved" <?php echo ($status === 'approved') ? 'selected' : ''; ?>>Approved</option>
                                <option value="rejected" <?php echo ($status === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No accountants found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include FOOTER; ?>
