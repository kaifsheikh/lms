<?php include HEADER; ?>

<h1>Quiz: <?php echo htmlspecialchars($quiz['title']); ?></h1>
<p><strong>Timer:</strong> <?php echo htmlspecialchars($quiz['timer']); ?> minutes</p>
<p><strong>Passing Marks:</strong> <?php echo htmlspecialchars($quiz['passing_marks']); ?></p>

<div id="timer" style="font-size: 24px; font-weight: bold; color: red;">
    <?php echo $timer_seconds; ?>
</div>

<form id="quizForm" method="POST" action="<?php echo BASE_URL; ?>/student/controller/submit_quiz.php">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

    <?php if (empty($questions)): ?>
        <p>No questions available for this quiz.</p>
    <?php else: ?>
        <?php foreach ($questions as $index => $question): ?>
            <fieldset style="margin-bottom: 20px;">
                <legend>
                    <strong>Question <?php echo $index + 1; ?>:</strong>
                    <?php echo htmlspecialchars($question['question_text']); ?>
                </legend>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $option['id']; ?>" required>
                        <?php echo htmlspecialchars($option['option_text']); ?>
                    </label><br>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach; ?>
        <button type="submit" id="submitBtn">Submit Quiz</button>
    <?php endif; ?>
</form>

<script>
    // Timer logic
    var timeLeft = <?php echo $timer_seconds; ?>;
    var timerDisplay = document.getElementById('timer');

    function formatTime(seconds) {
        var mins = Math.floor(seconds / 60);
        var secs = seconds % 60;
        return mins + ":" + (secs < 10 ? "0" : "") + secs;
    }

    var countdown = setInterval(function() {
        timeLeft--;
        timerDisplay.textContent = formatTime(timeLeft);
        if (timeLeft <= 0) {
            clearInterval(countdown);
            // Auto-submit form
            document.getElementById('quizForm').submit();
        }
    }, 1000);

    // Prevent manual submit if timer is zero? But submit button still works.
    document.getElementById('quizForm').addEventListener('submit', function(e) {
        // Optional: disable further actions, but no need here.
    });
</script>

<?php include FOOTER; ?>