<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">My Attendance</h1>
</div>

<?php if (empty($attendance_records)): ?>
    <p class="text-slate-500">Abhi tak koi attendance record nahi hai.</p>
<?php else: ?>
    <!-- Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-center">
            <p class="text-2xl font-semibold text-green-700"><?php echo $summary['present']; ?></p>
            <p class="text-sm text-green-700">Present</p>
        </div>
        <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
            <p class="text-2xl font-semibold text-red-700"><?php echo $summary['absent']; ?></p>
            <p class="text-sm text-red-700">Absent</p>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-center">
            <p class="text-2xl font-semibold text-amber-700"><?php echo $summary['late']; ?></p>
            <p class="text-sm text-amber-700">Late</p>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-center">
            <p class="text-2xl font-semibold text-blue-700"><?php echo $summary['leave']; ?></p>
            <p class="text-sm text-blue-700">Leave</p>
        </div>
    </div>

    <!-- Attendance Progress -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-2">Attendance Progress</h2>
        <p class="text-3xl font-semibold text-indigo-600"><?php echo $attendance_percentage; ?>%</p>
        <div class="w-full bg-slate-200 rounded-full h-2.5 mt-3">
            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: <?php echo $attendance_percentage; ?>%;"></div>
        </div>
        <p class="text-sm text-slate-500 mt-3">
            Total Records: <?php echo $total_records; ?> |
            Present (incl. Late): <?php echo $present_like_count; ?> |
            Absent: <?php echo $summary['absent']; ?> |
            Leave: <?php echo $summary['leave']; ?>
        </p>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Batch</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($attendance_records as $record): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($record['date']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($record['batch_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <?php
                            $status = $record['status'];
                            $badgeClass = 'bg-slate-100 text-slate-600';
                            if ($status === 'present') $badgeClass = 'bg-green-50 text-green-700';
                            elseif ($status === 'absent') $badgeClass = 'bg-red-50 text-red-700';
                            elseif ($status === 'late') $badgeClass = 'bg-amber-50 text-amber-700';
                            elseif ($status === 'leave') $badgeClass = 'bg-blue-50 text-blue-700';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include FOOTER; ?>
