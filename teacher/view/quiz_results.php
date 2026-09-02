<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Quiz Results</h1>
</div>

<?php if (!empty($message)): ?>
    <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($message); ?>
    </p>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($error); ?>
    </p>
<?php endif; ?>

<!-- Quiz Selection Form -->
<form method="GET" action="" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-end gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-slate-700 mb-1">Select Quiz:</label>
            <select name="quiz_id" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select Quiz --</option>
                <?php foreach ($quizzes as $quiz): ?>
                    <option value="<?php echo $quiz['id']; ?>" <?php echo ($quiz_id == $quiz['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($quiz['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">View Results</button>
    </div>
</form>

<?php if ($selected_quiz): ?>
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                Quiz: <?php echo htmlspecialchars($selected_quiz['title']); ?>
                <?php if (!empty($selected_quiz['batch_name'])): ?>
                    <span class="text-slate-500 font-normal">- Batch: <?php echo htmlspecialchars($selected_quiz['batch_name']); ?></span>
                <?php endif; ?>
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Passing Percentage: <span class="font-medium text-slate-700"><?php echo $selected_quiz['passing_marks']; ?>%</span>
            </p>
        </div>
        <!-- Statistics Panel -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex gap-6">
            <div class="text-center">
                <p class="text-xl font-semibold text-slate-900"><?php echo $total_students; ?></p>
                <p class="text-xs text-slate-500 uppercase tracking-wide">Total</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-semibold text-green-600"><?php echo $passed_count; ?></p>
                <p class="text-xs text-slate-500 uppercase tracking-wide">Passed</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-semibold text-red-600"><?php echo $failed_count; ?></p>
                <p class="text-xs text-slate-500 uppercase tracking-wide">Failed</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-semibold text-slate-500"><?php echo $not_submitted_count; ?></p>
                <p class="text-xs text-slate-500 uppercase tracking-wide">Not Submitted</p>
            </div>
        </div>
    </div>

    <?php if (empty($attempts)): ?>
        <p class="text-slate-500">No students have attempted this quiz yet.</p>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Obtained Marks</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Marks</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Percentage</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($attempts as $attempt): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($attempt['student_id']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($attempt['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">
                                <?php echo $attempt['obtained_marks'] !== null ? $attempt['obtained_marks'] : '-'; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">
                                <?php echo $attempt['total_marks'] !== null ? $attempt['total_marks'] : '-'; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">
                                <?php echo $attempt['percentage'] !== null ? $attempt['percentage'] . '%' : '-'; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php if ($attempt['not_submitted']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Not Submitted</span>
                                <?php elseif ($attempt['passed']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Pass</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Fail</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php if (!$attempt['not_submitted'] && !$attempt['passed']): ?>
                                    <form method="POST" action="" onsubmit="return confirm('Allow retake for this student?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="retake_attempt">
                                        <input type="hidden" name="attempt_id" value="<?php echo $attempt['attempt_id']; ?>">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-800">Retake</button>
                                    </form>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include FOOTER; ?>
