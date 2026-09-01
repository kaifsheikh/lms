<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Batch Approval</h1>
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

<div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Batch Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Teacher</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Starting Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Time</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Students</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Created At</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (!empty($batches)): ?>
                <?php foreach ($batches as $batch): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo $batch['id']; ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($batch['batch_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($batch['teacher_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($batch['starting_date']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($batch['batch_time']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <?php
                            $status = $batch['status'];
                            $badge = 'bg-amber-50 text-amber-700';
                            if ($status === 'approved') {
                                $badge = 'bg-green-50 text-green-700';
                            } elseif ($status === 'rejected') {
                                $badge = 'bg-red-50 text-red-700';
                            }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo intval($batch['total_students']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($batch['created_at']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium space-x-2">
                            <?php if ($status === 'pending'): ?>
                                <form method="POST" action="" class="inline">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="batch_id" value="<?= (int)$batch['id'] ?>">
                                    <button type="submit" name="status" value="approved" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-3 rounded-md text-sm transition-colors">Approve</button>
                                </form>
                                <form method="POST" action="" class="inline">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="batch_id" value="<?= (int)$batch['id'] ?>">
                                    <button type="submit" name="status" value="rejected" class="bg-white border border-red-200 hover:bg-red-50 text-red-600 font-medium py-1.5 px-3 rounded-md text-sm transition-colors">Reject</button>
                                </form>
                            <?php else: ?>
                                <span class="text-sm text-slate-500"><?php echo ucfirst($status); ?></span>
                            <?php endif; ?>

                            <!-- Delete batch button (always available) -->
                            <form method="POST" action="" class="inline" onsubmit="return confirm('Are you sure you want to delete this batch?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="delete_batch">
                                <input type="hidden" name="batch_id" value="<?= (int)$batch['id'] ?>">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-1.5 px-3 rounded-md text-sm transition-colors">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="px-4 py-6 text-center text-sm text-slate-500">No batches found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include FOOTER; ?>
