<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Manage Questions</h1>
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Quiz: <?php echo htmlspecialchars($quiz['title']); ?></h2>
    <div class="bg-white shadow-md rounded-lg p-4 mb-6 space-y-1">
        <p><strong class="text-gray-700">Batch:</strong> <span class="text-gray-900"><?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></span></p>
        <p><strong class="text-gray-700">Due Date:</strong> <span class="text-gray-900"><?php echo htmlspecialchars($quiz['due_date']); ?></span></p>
    </div>

    <?php if (!empty($success)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <hr class="my-6">

    <!-- ============ ADD QUESTION FORM ============ -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Question</h3>
        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Question Text:</label>
                <textarea name="question_text" rows="3" required
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Options (at least two):</label>
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="text-sm text-gray-600 w-20">Option <?php echo $i + 1; ?>:</span>
                        <input type="text" name="options[]" required
                               class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="radio" name="correct_option" value="<?php echo $i; ?>" required class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <small class="text-xs text-gray-500">Correct?</small>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                Add Question
            </button>
        </form>
    </div>

    <hr class="my-6">

    <!-- ============ EXISTING QUESTIONS ============ -->
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Existing Questions (<?php echo count($questions); ?>)</h3>
    <?php if (empty($questions)): ?>
        <p class="text-gray-600">No questions yet.</p>
    <?php else: ?>
        <ol class="space-y-4 list-decimal pl-6">
            <?php foreach ($questions as $q): ?>
                <li class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                    <strong class="text-gray-900"><?php echo htmlspecialchars($q['question_text']); ?></strong>
                    <ul class="mt-2 space-y-1">
                        <?php foreach ($q['options'] as $opt): ?>
                            <li class="flex items-center space-x-2 text-sm <?php echo $opt['is_correct'] ? 'text-green-700 font-bold' : 'text-gray-700'; ?>">
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
        <a href="<?php echo BASE_URL; ?>/teacher/controller/quiz_management.php" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition-colors">
            ← Back to Quiz Management
        </a>
    </div>
</div>

<?php include FOOTER; ?>