<?php include HEADER; ?>

<h1>Quiz Management</h1>

<?php if (!empty($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<!-- ================= CREATE QUIZ SECTION ================= -->
<h2>Create / Assign Quiz</h2>
<form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    
    <input type="hidden" name="action" value="create_quiz">
    <label>Quiz Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="3"></textarea><br><br>

    <label>Assign to Batch:</label><br>
    <select name="batch_id" required>
        <option value="">-- Select Batch --</option>
        <?php foreach ($batches as $batch): ?>
            <option value="<?php echo $batch['id']; ?>">
                <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Due Date (datetime):</label><br>
    <input type="datetime-local" name="due_date" required><br><br>

    <label>Timer (in minutes):</label><br>
    <input type="number" name="timer" min="1" required><br><br>

    <label>Passing Marks:</label><br>
    <input type="number" name="passing_marks" min="1" required><br><br>

    <button type="submit">Create Quiz</button>
</form>

<hr>

<!-- ================= QUIZZES TABLE ================= -->
<h2>My Quizzes</h2>
<?php if (empty($quizzes)): ?>
    <p>No quizzes created yet.</p>
<?php else: ?>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Batch</th>
            <th>Due Date</th>
            <th>Timer (min)</th>
            <th>Passing Marks</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($quizzes as $quiz): ?>
            <tr>
                <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                <td><?php echo htmlspecialchars($quiz['description']); ?></td>
                <td><?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($quiz['due_date']); ?></td>
                <td><?php echo htmlspecialchars($quiz['timer']); ?></td>
                <td><?php echo htmlspecialchars($quiz['passing_marks']); ?></td>
                <td><?php echo htmlspecialchars($quiz['created_at']); ?></td>
                <td>
                    <a href="#" onclick="alert('Quiz Start feature coming soon'); return false;">Start</a> |
                    <a href="#" onclick="alert('Questions feature coming soon'); return false;">Questions</a> |
                     <a href="<?php echo BASE_URL; ?>/teacher/controller/edit_quiz.php?id=<?php echo $quiz['id']; ?>">Edit</a> |
                    <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Delete this quiz?');">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                        <input type="hidden" name="action" value="delete_quiz">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                        <button type="submit" style="color:red;">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php include FOOTER; ?>