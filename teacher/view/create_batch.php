<?php include HEADER; ?>

<h1>Batch Management</h1>

<?php if (!empty($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<!-- ================= SECTION 1: CREATE NEW BATCH (no student selection) ================= -->
<h2>Create New Batch</h2>
<form method="POST" action="">
    <input type="hidden" name="action" value="create_batch">
    <label>Batch Name:</label><br>
    <input type="text" name="batch_name" required><br><br>

    <label>Starting Date:</label><br>
    <input type="date" name="starting_date" required><br><br>

    <label>Batch Time:</label><br>
    <input type="text" name="batch_time" placeholder="e.g., 9:00 AM - 11:00 AM" required><br><br>

    <button type="submit">Create Batch</button>
</form>

<hr>

<!-- ================= SECTION 2: ASSIGN STUDENT TO EXISTING BATCH ================= -->
<h2>Assign Student to Existing Batch</h2>
<?php if (empty($unassigned_students) || empty($batches)): ?>
    <p style="color: orange;">Either no unassigned students or no batches available.</p>
<?php else: ?>
<form method="POST" action="">
    <input type="hidden" name="action" value="assign_to_batch">
    <label>Student:</label><br>
    <select name="student_id" required>
        <option value="">-- Select Student --</option>
        <?php foreach ($unassigned_students as $student): ?>
            <option value="<?php echo $student['id']; ?>">
                <?php echo htmlspecialchars($student['full_name'] . ' (' . $student['student_id'] . ')'); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Batch:</label><br>
    <select name="batch_id" required>
        <option value="">-- Select Batch --</option>
        <?php foreach ($batches as $batch): ?>
            <option value="<?php echo $batch['id']; ?>">
                <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Assign to Batch</button>
</form>
<?php endif; ?>

<hr>

<!-- ================= SECTION 3: TRANSFER STUDENT TO ANOTHER BATCH ================= -->
<h2>Transfer Student to Another Batch</h2>
<?php if (empty($assigned_students) || empty($batches)): ?>
    <p style="color: orange;">No assigned students or no batches available for transfer.</p>
<?php else: ?>
<form method="POST" action="">
    <input type="hidden" name="action" value="transfer_student">
    <label>Student (currently in a batch):</label><br>
    <select name="student_id" required>
        <option value="">-- Select Student --</option>
        <?php foreach ($assigned_students as $student): ?>
            <option value="<?php echo $student['id']; ?>">
                <?php echo htmlspecialchars($student['full_name'] . ' (' . $student['student_id'] . ') - Current Batch: ' . $student['batch_name']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Destination Batch:</label><br>
    <select name="new_batch_id" required>
        <option value="">-- Select Batch --</option>
        <?php foreach ($batches as $batch): ?>
            <option value="<?php echo $batch['id']; ?>">
                <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Transfer Student</button>
</form>
<?php endif; ?>

<?php include FOOTER; ?>