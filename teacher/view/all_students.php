<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">All Students</h1>
</div>

<?php if (empty($students)): ?>
    <p class="text-slate-500">No students assigned to you yet.</p>
<?php else: ?>
    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Father Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Course</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Class Timing</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Duration</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Joining Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Course End Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Registered At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($students as $student): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($student['full_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['father_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['course_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['class_timing']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['course_duration']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['joining_date']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['course_end_date']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <?php
                            $status = $student['status'];
                            $badge = 'bg-amber-50 text-amber-700';
                            if ($status === 'active') {
                                $badge = 'bg-green-50 text-green-700';
                            } elseif ($status === 'process') {
                                $badge = 'bg-blue-50 text-blue-700';
                            }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($student['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include FOOTER; ?>