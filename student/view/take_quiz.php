<?php include HEADER; ?>

<div class="max-w-3xl mx-auto">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900"><?php echo htmlspecialchars($quiz['title']); ?></h1>
            <p class="text-sm text-slate-500 mt-1">Passing Marks: <?php echo htmlspecialchars($quiz['passing_marks']); ?></p>
        </div>
        <div class="flex flex-col items-center bg-white border border-slate-200 rounded-xl shadow-sm px-4 py-2">
            <span class="text-xs text-slate-500 uppercase tracking-wide">Time Left</span>
            <div id="timer" class="text-xl font-semibold text-red-600">
                <?php echo $timer_seconds; ?>
            </div>
        </div>
    </div>

    <form id="quizForm" method="POST" action="<?php echo BASE_URL; ?>/student/controller/submit_quiz.php" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

        <?php if (empty($questions)): ?>
            <p class="text-slate-500">No questions available for this quiz.</p>
        <?php else: ?>
            <?php foreach ($questions as $index => $question): ?>
                <fieldset class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <legend class="text-sm font-semibold text-slate-800 mb-3">
                        Question <?php echo $index + 1; ?>:
                        <span class="font-normal text-slate-700"><?php echo htmlspecialchars($question['question_text']); ?></span>
                    </legend>
                    <div class="space-y-2">
                        <?php foreach ($question['options'] as $option): ?>
                            <label class="flex items-center gap-3 border border-slate-200 rounded-lg px-3 py-2 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $option['id']; ?>" required class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            <?php endforeach; ?>
            <button type="submit" id="submitBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">Submit Quiz</button>
        <?php endif; ?>
    </form>
</div>

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
