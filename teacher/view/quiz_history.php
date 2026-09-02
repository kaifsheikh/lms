<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Quiz Attempt History</h1>
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

<?php if (empty($history)): ?>
    <p class="text-slate-500">No quiz attempt records found.</p>
<?php else: ?>
    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Quiz Title</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Attempt Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Percentage</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($history as $record): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($record['student_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($record['quiz_title']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($record['attempt_date']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo $record['percentage']; ?>%</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <?php if ($record['status'] === 'pass'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Pass</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Fail</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <form method="POST" action="" onsubmit="return confirm('Delete this record? This cannot be undone.');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="delete_history">
                                <input type="hidden" name="history_id" value="<?php echo $record['id']; ?>">
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
