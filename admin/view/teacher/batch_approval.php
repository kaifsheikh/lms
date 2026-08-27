<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Batch Approval</h1>

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

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Starting Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Students</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($batches)): ?>
                    <?php foreach ($batches as $batch): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $batch['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($batch['batch_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($batch['teacher_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($batch['starting_date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($batch['batch_time']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php
                                $status = $batch['status'];
                                $statusClass = 'text-orange-600';
                                if ($status === 'approved') {
                                    $statusClass = 'text-green-600';
                                } elseif ($status === 'rejected') {
                                    $statusClass = 'text-red-600';
                                }
                                ?>
                                <span class="font-medium <?php echo $statusClass; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo intval($batch['total_students']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($batch['created_at']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <?php if ($status === 'pending'): ?>
                                    <form method="POST" action="" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="batch_id" value="<?= (int)$batch['id'] ?>">
                                        <button type="submit" name="status" value="approved" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded-md text-sm transition-colors">Approve</button>
                                    </form>
                                    <form method="POST" action="" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="batch_id" value="<?= (int)$batch['id'] ?>">
                                        <button type="submit" name="status" value="rejected" class="bg-red-600 hover:bg-red-700 text-white font-medium py-1 px-3 rounded-md text-sm transition-colors">Reject</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-sm text-gray-600"><?php echo ucfirst($status); ?></span>
                                <?php endif; ?>

                                <!-- Delete batch button (always available) -->
                                <form method="POST" action="" class="inline" onsubmit="return confirm('Are you sure you want to delete this batch?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="delete_batch">
                                    <input type="hidden" name="batch_id" value="<?= (int)$batch['id'] ?>">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-1 px-3 rounded-md text-sm transition-colors">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">No batches found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include FOOTER; ?>