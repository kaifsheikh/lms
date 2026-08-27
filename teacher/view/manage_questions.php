<?php include HEADER; ?>

<h1>Manage Questions</h1>
<h2>Quiz: <?php echo htmlspecialchars($quiz['title']); ?></h2>
<p><strong>Batch:</strong> <?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></p>
<p><strong>Due Date:</strong> <?php echo htmlspecialchars($quiz['due_date']); ?></p>

<?php if (!empty($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<hr>

<!-- ============ ADD QUESTION FORM ============ -->
<h3>Add New Question</h3>
<form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

    <label>Question Text:</label><br>
    <textarea name="question_text" rows="3" required></textarea><br><br>

    <label>Options (at least two):</label><br>
    <?php for ($i = 0; $i < 4; $i++): ?>
        Option <?php echo $i + 1; ?>:
        <input type="text" name="options[]" required>
        <input type="radio" name="correct_option" value="<?php echo $i; ?>" required>
        <small>Correct?</small><br>
    <?php endfor; ?>
    <br>
    <button type="submit">Add Question</button>
</form>

<hr>

<!-- ============ EXISTING QUESTIONS ============ -->
<h3>Existing Questions (<?php echo count($questions); ?>)</h3>
<?php if (empty($questions)): ?>
    <p>No questions yet.</p>
<?php else: ?>
    <ol>
        <?php foreach ($questions as $q): ?>
            <li>
                <strong><?php echo htmlspecialchars($q['question_text']); ?></strong>
                <ul>
                    <?php foreach ($q['options'] as $opt): ?>
                        <li style="<?php echo $opt['is_correct'] ? 'color:green; font-weight:bold;' : ''; ?>">
                            <?php echo htmlspecialchars($opt['option_text']); ?>
                            <?php if ($opt['is_correct']) echo ' ✅'; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<a href="<?php echo BASE_URL; ?>/teacher/controller/quiz_management.php">← Back to Quiz Management</a>

<?php include FOOTER; ?>