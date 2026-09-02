<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">My Batches</h1>
</div>

<?php if (empty($batches)): ?>
    <p class="text-slate-500">No batches created yet.</p>
<?php else: ?>
    <div class="space-y-6">
        <?php foreach ($batches as $batch): ?>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-3">
                    <?php echo htmlspecialchars($batch['batch_name']); ?>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Status</p>
                        <?php
                        $badge = 'bg-amber-50 text-amber-700';
                        if ($batch['status'] === 'approved') {
                            $badge = 'bg-green-50 text-green-700';
                        } elseif ($batch['status'] === 'rejected') {
                            $badge = 'bg-red-50 text-red-700';
                        }
                        ?>
                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge; ?>">
                            <?php echo htmlspecialchars($batch['status']); ?>
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Starting Date</p>
                        <p class="text-sm font-medium text-slate-800 mt-1"><?php echo htmlspecialchars($batch['starting_date']); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Time</p>
                        <p class="text-sm font-medium text-slate-800 mt-1"><?php echo htmlspecialchars($batch['batch_time']); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Created At</p>
                        <p class="text-sm font-medium text-slate-800 mt-1"><?php echo htmlspecialchars($batch['created_at']); ?></p>
                    </div>
                </div>

                <h3 class="text-sm font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-3">Students in this Batch</h3>
                <?php if (empty($batch['students'])): ?>
                    <p class="text-sm text-slate-500 italic">No students assigned.</p>
                <?php else: ?>
                    <div class="overflow-x-auto rounded-lg border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Course</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($batch['students'] as $student): ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['student_id']); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($student['full_name']); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['course_name']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include FOOTER; ?>
