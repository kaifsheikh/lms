<?php include HEADER; ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-slate-900 mb-6">Edit Quiz</h1>

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

    <form method="POST" action="" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Quiz Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($old['title'] ?? ''); ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description:</label>
            <textarea name="description" rows="3"
                      class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"><?php echo htmlspecialchars($old['description'] ?? ''); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Batch:</label>
            <select name="batch_id" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select Batch --</option>
                <?php foreach ($batches as $batch): ?>
                    <option value="<?php echo $batch['id']; ?>" <?php echo (isset($old['batch_id']) && $old['batch_id'] == $batch['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Due Date (datetime):</label>
            <input type="datetime-local" name="due_date" value="<?= htmlspecialchars(!empty($old['due_date']) ? date('Y-m-d\TH:i', strtotime($old['due_date'])) : '') ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Timer (in minutes):</label>
                <input type="number" name="timer" min="1" value="<?php echo htmlspecialchars($old['timer'] ?? ''); ?>" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Passing Marks:</label>
                <input type="number" name="passing_marks" min="1" value="<?php echo htmlspecialchars($old['passing_marks'] ?? ''); ?>" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                Update Quiz
            </button>
            <a href="<?php echo BASE_URL; ?>/teacher/controller/quiz_management.php" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium py-2 px-4 rounded-lg transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php include FOOTER; ?>
