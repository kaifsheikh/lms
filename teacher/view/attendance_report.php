<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Attendance Report</h1>
</div>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($error); ?>
    </p>
<?php endif; ?>

<!-- Filter Form -->
<form method="GET" action="" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Batch:</label>
            <select name="batch_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select Batch --</option>
                <?php foreach ($batches as $batch): ?>
                    <option value="<?php echo $batch['id']; ?>" <?php echo ($batch_id == $batch['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($batch['batch_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Date:</label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">View Report</button>
    </div>
</form>

<!-- Report Table -->
<?php if ($selected_batch): ?>
    <h2 class="text-lg font-semibold text-slate-800 mb-4">
        Attendance for <?php echo htmlspecialchars($selected_batch['batch_name']); ?> on <?php echo htmlspecialchars($selected_date); ?>
    </h2>

    <?php if (empty($report_data)): ?>
        <p class="text-red-600 text-sm">Attendance not found</p>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($report_data as $record): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($record['student_id']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($record['full_name']); ?></td>
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
<?php endif; ?>

<?php include FOOTER; ?>
