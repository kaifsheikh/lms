<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">My Results</h1>
</div>

<?php if (empty($results)): ?>
    <p class="text-slate-500">No quiz attempts yet.</p>
<?php else: ?>
    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Quiz Title</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Batch</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Teacher</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Obtained Marks</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Marks</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Percentage</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Submitted At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($results as $r): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($r['quiz_title']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($r['batch_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($r['teacher_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($r['obtained_marks']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($r['total_marks']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <?php
                            $percentage = floatval($r['percentage']);
                            $colorClass = 'text-slate-700';
                            if ($percentage >= 80) {
                                $colorClass = 'text-green-600';
                            } elseif ($percentage >= 60) {
                                $colorClass = 'text-blue-600';
                            } elseif ($percentage >= 40) {
                                $colorClass = 'text-amber-600';
                            } else {
                                $colorClass = 'text-red-600';
                            }
                            ?>
                            <span class="font-medium <?php echo $colorClass; ?>">
                                <?php echo htmlspecialchars($r['percentage']); ?>%
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($r['submitted_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="mt-6">
    <a href="<?php echo BASE_URL; ?>/student/controller/quizzes.php" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg text-sm transition-colors">
        ← Back to My Quizzes
    </a>
</div>

<?php include FOOTER; ?>
