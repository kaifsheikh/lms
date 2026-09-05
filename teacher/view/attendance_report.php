<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-8">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </span>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Attendance Report</h1>
            <p class="text-sm text-gray-500 mt-1">View daily or monthly attendance for your batches</p>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- ==================== DAILY REPORT SECTION ==================== -->
    <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden mb-8">
        <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daily Report</h2>
            <form method="GET" action="" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="batch_id_daily" class="block text-sm font-medium text-gray-700 mb-1">Batch</label>
                    <select name="batch_id" id="batch_id_daily" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Select Batch --</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?php echo $batch['id']; ?>" <?php echo ($batch_id == $batch['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($batch['batch_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="date_daily" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" id="date_daily" value="<?php echo htmlspecialchars($selected_date); ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        View Daily Report
                    </button>
                </div>
            </form>

            <?php if ($selected_batch && !empty($report_data)): ?>
                <div class="mt-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">
                        Attendance for <?php echo htmlspecialchars($selected_batch['batch_name']); ?> on <?php echo date('M d, Y', strtotime($selected_date)); ?>
                    </h3>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($report_data as $record): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($record['student_id']); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo htmlspecialchars($record['full_name']); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <?php
                                            $status = $record['status'];
                                            $badgeClass = 'bg-gray-100 text-gray-600';
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
                </div>
            <?php elseif ($selected_batch && empty($report_data)): ?>
                <p class="text-sm text-gray-500 mt-4">No attendance found for this date.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- ==================== MONTHLY REPORT SECTION ==================== -->
    <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Report</h2>
            <form method="GET" action="" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="batch_id_monthly" class="block text-sm font-medium text-gray-700 mb-1">Batch</label>
                    <select name="batch_id" id="batch_id_monthly" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Select Batch --</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?php echo $batch['id']; ?>" <?php echo ($batch_id == $batch['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($batch['batch_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <input type="month" name="month" id="month" value="<?php echo htmlspecialchars($month); ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        View Monthly Report
                    </button>
                </div>
            </form>

            <?php if ($selected_batch && !empty($monthly_data)): ?>
                <?php
                // Group monthly data by date
                $grouped_monthly = [];
                foreach ($monthly_data as $record) {
                    $dateKey = $record['date'];
                    if (!isset($grouped_monthly[$dateKey])) {
                        $grouped_monthly[$dateKey] = [];
                    }
                    $grouped_monthly[$dateKey][] = $record;
                }
                ksort($grouped_monthly); // Sort dates ascending

                // Calculate monthly summary
                $monthly_summary = ['present' => 0, 'absent' => 0, 'late' => 0, 'leave' => 0];
                foreach ($monthly_data as $rec) {
                    if (isset($monthly_summary[$rec['status']])) {
                        $monthly_summary[$rec['status']]++;
                    }
                }
                ?>

                <div class="mt-6">
                    <!-- Heading with summary on the right -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <h3 class="text-base font-semibold text-gray-800">
                            Monthly Attendance for <?php echo htmlspecialchars($selected_batch['batch_name']); ?> – <?php echo date('F Y', strtotime($month . '-01')); ?>
                        </h3>
                        <!-- Summary badges -->
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                Present: <?php echo $monthly_summary['present']; ?>
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                Absent: <?php echo $monthly_summary['absent']; ?>
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                Late: <?php echo $monthly_summary['late']; ?>
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                Leave: <?php echo $monthly_summary['leave']; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Date groups -->
                    <div class="space-y-6">
                        <?php foreach ($grouped_monthly as $date => $records): ?>
                            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                                <div class="bg-gray-100 px-4 py-2 border-b border-gray-200">
                                    <h4 class="text-sm font-semibold text-gray-700">
                                        <?php echo date('M d, Y', strtotime($date)); ?>
                                    </h4>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student ID</th>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</th>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            <?php foreach ($records as $record): ?>
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($record['student_id']); ?></td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo htmlspecialchars($record['full_name']); ?></td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                        <?php
                                                        $status = $record['status'];
                                                        $badgeClass = 'bg-gray-100 text-gray-600';
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
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php elseif ($selected_batch && empty($monthly_data)): ?>
                <p class="text-sm text-gray-500 mt-4">No attendance found for this month.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include FOOTER; ?>