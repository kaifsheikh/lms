<?php include HEADER; ?>

<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-slate-900 mb-1">Manage Questions</h1>
    <h2 class="text-base text-slate-500 mb-4">Quiz: <?php echo htmlspecialchars($quiz['title']); ?></h2>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-6 space-y-1 text-sm">
        <p><span class="font-medium text-slate-700">Batch:</span> <span class="text-slate-600"><?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></span></p>
        <p><span class="font-medium text-slate-700">Due Date:</span> <span class="text-slate-600"><?php echo htmlspecialchars($quiz['due_date']); ?></span></p>
    </div>

    <?php if (!empty($success)): ?>
        <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <!-- ============ ADD QUESTION FORM ============ -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
        <h3 class="text-base font-semibold text-slate-900 mb-4">Add New Question</h3>
        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Question Text:</label>
                <textarea name="question_text" rows="3" required
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Options (at least two):</label>
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-sm text-slate-500 w-20">Option <?php echo $i + 1; ?>:</span>
                        <input type="text" name="options[]" required
                               class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <input type="radio" name="correct_option" value="<?php echo $i; ?>" required class="h-4 w-4 text-indigo-600 border-slate-300 focus:ring-indigo-500">
                        <small class="text-xs text-slate-500">Correct?</small>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                Add Question
            </button>
        </form>
    </div>

    <!-- ============ EXISTING QUESTIONS ============ -->
    <h3 class="text-base font-semibold text-slate-900 mb-4">Existing Questions (<?php echo count($questions); ?>)</h3>
    <?php if (empty($questions)): ?>
        <p class="text-slate-500">No questions yet.</p>
    <?php else: ?>
        <ol class="space-y-3 list-decimal pl-5">
            <?php foreach ($questions as $q): ?>
                <li class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                    <span class="font-medium text-slate-900"><?php echo htmlspecialchars($q['question_text']); ?></span>
                    <ul class="mt-2 space-y-1">
                        <?php foreach ($q['options'] as $opt): ?>
                            <li class="flex items-center gap-2 text-sm <?php echo $opt['is_correct'] ? 'text-green-700 font-medium' : 'text-slate-600'; ?>">
                                <span><?php echo htmlspecialchars($opt['option_text']); ?></span>
                                <?php if ($opt['is_correct']): ?>
                                    <span>✅</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <div class="mt-8">
        <a href="<?php echo BASE_URL; ?>/teacher/controller/quiz_management.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
            ← Back to Quiz Management
        </a>
    </div>
</div>

<?php include FOOTER; ?>
