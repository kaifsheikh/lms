<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quiz Attempt History</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <?php if (empty($history)): ?>
        <p class="text-gray-600">No quiz attempt records found.</p>
    <?php else: ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quiz Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attempt Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Percentage</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($history as $record): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($record['student_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($record['quiz_title']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($record['attempt_date']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo $record['percentage']; ?>%</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php if ($record['status'] === 'pass'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Pass</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Fail</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <form method="POST" action="" onsubmit="return confirm('Delete this record? This cannot be undone.');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="delete_history">
                                    <input type="hidden" name="history_id" value="<?php echo $record['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>