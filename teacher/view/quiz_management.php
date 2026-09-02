<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Quiz Management</h1>
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

<!-- ================= CREATE QUIZ SECTION ================= -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-8">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Create / Assign Quiz</h2>
    <form method="POST" action="" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="create_quiz">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Quiz Title:</label>
            <input type="text" name="title" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description:</label>
            <textarea name="description" rows="3"
                      class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Assign to Batch:</label>
            <select name="batch_id" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select Batch --</option>
                <?php foreach ($batches as $batch): ?>
                    <option value="<?php echo $batch['id']; ?>">
                        <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Due Date (datetime):</label>
            <input type="datetime-local" name="due_date" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Timer (in minutes):</label>
                <input type="number" name="timer" min="1" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Passing Marks:</label>
                <input type="number" name="passing_marks" min="1" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            Create Quiz
        </button>
    </form>
</div>

<!-- ================= QUIZZES TABLE ================= -->
<h2 class="text-lg font-semibold text-slate-900 mb-4">My Quizzes</h2>
<?php if (empty($quizzes)): ?>
    <p class="text-slate-500">No quizzes created yet.</p>
<?php else: ?>
<div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Title</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Description</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Batch</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Due Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Timer (min)</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Passing Marks</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Created At</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($quizzes as $quiz): ?>
                <?php $status = $quiz['status'] ?? 'draft'; ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($quiz['title']); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($quiz['description']); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($quiz['due_date']); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($quiz['timer']); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($quiz['passing_marks']); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        <?php
                        $statusClass = 'bg-slate-100 text-slate-600';
                        $statusText = ucfirst($status);
                        if ($status === 'draft') {
                            $statusClass = 'bg-amber-50 text-amber-700';
                        } elseif ($status === 'active') {
                            $statusClass = 'bg-green-50 text-green-700';
                        }
                        ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($quiz['created_at']); ?></td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium space-x-2">
                        <?php if ($status === 'draft'): ?>
                            <form method="POST" action="" class="inline" onsubmit="return confirm('Start this quiz? Students will be able to see it.');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="change_status">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                <input type="hidden" name="new_status" value="active">
                                <button type="submit" class="text-indigo-600 hover:text-indigo-800">Start</button>
                            </form>
                        <?php elseif ($status === 'active'): ?>
                            <form method="POST" action="" class="inline" onsubmit="return confirm('Close this quiz? Students will no longer see it.');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="change_status">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                <input type="hidden" name="new_status" value="closed">
                                <button type="submit" class="text-amber-600 hover:text-amber-800">Close</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="" class="inline" onsubmit="return confirm('Reopen this quiz?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="change_status">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                <input type="hidden" name="new_status" value="active">
                                <button type="submit" class="text-green-600 hover:text-green-800">Reopen</button>
                            </form>
                            <form method="POST" action="" class="inline" onsubmit="return confirm('Set as draft? Students will not see this quiz.');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="change_status">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                <input type="hidden" name="new_status" value="draft">
                                <button type="submit" class="text-slate-600 hover:text-slate-800">Set Draft</button>
                            </form>
                        <?php endif; ?>
                        <span class="text-slate-300">|</span>
                        <a href="<?php echo BASE_URL; ?>/teacher/controller/manage_questions.php?quiz_id=<?php echo $quiz['id']; ?>" class="text-indigo-600 hover:text-indigo-800">Questions</a>
                        <span class="text-slate-300">|</span>
                        <a href="<?php echo BASE_URL; ?>/teacher/controller/edit_quiz.php?id=<?php echo $quiz['id']; ?>" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                        <span class="text-slate-300">|</span>
                        <form method="POST" action="" class="inline" onsubmit="return confirm('Delete this quiz?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="action" value="delete_quiz">
                            <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php include FOOTER; ?>
