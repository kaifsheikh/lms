<?php include HEADER; ?>

<h1>Edit Quiz</h1>

<?php if (!empty($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    
    <label>Quiz Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($old['title'] ?? ''); ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="3"><?php echo htmlspecialchars($old['description'] ?? ''); ?></textarea><br><br>

    <label>Batch:</label><br>
    <select name="batch_id" required>
        <option value="">-- Select Batch --</option>
        <?php foreach ($batches as $batch): ?>
            <option value="<?php echo $batch['id']; ?>" <?php echo (isset($old['batch_id']) && $old['batch_id'] == $batch['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Due Date (datetime):</label><br>
    <input type="datetime-local" name="due_date" value="<?= htmlspecialchars(!empty($old['due_date']) ? date('Y-m-d\TH:i', strtotime($old['due_date'])) : '') ?>" required><br><br>

    <label>Timer (in minutes):</label><br>
    <input type="number" name="timer" min="1" value="<?php echo htmlspecialchars($old['timer'] ?? ''); ?>" required><br><br>

    <label>Passing Marks:</label><br>
    <input type="number" name="passing_marks" min="1" value="<?php echo htmlspecialchars($old['passing_marks'] ?? ''); ?>" required><br><br>

    <button type="submit">Update Quiz</button>
    <a href="<?php echo BASE_URL; ?>/teacher/controller/quiz_management.php">Cancel</a>
</form>

<?php include FOOTER; ?>