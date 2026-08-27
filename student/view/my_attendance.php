<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Attendance</h1>

    <?php if (empty($attendance_records)): ?>
        <p class="text-gray-600">Abhi tak koi attendance record nahi hai.</p>
    <?php else: ?>
        <!-- Summary Cards -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-green-100 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-green-800"><?php echo $summary['present']; ?></p>
                <p class="text-sm text-green-700">Present</p>
            </div>
            <div class="bg-red-100 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-red-800"><?php echo $summary['absent']; ?></p>
                <p class="text-sm text-red-700">Absent</p>
            </div>
            <div class="bg-yellow-100 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-yellow-800"><?php echo $summary['late']; ?></p>
                <p class="text-sm text-yellow-700">Late</p>
            </div>
            <div class="bg-blue-100 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-blue-800"><?php echo $summary['leave']; ?></p>
                <p class="text-sm text-blue-700">Leave</p>
            </div>
        </div>

        <!-- Attendance Progress -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Attendance Progress</h2>
            <p class="text-3xl font-bold text-indigo-600"><?php echo $attendance_percentage; ?>%</p>
            <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                <div class="bg-indigo-600 h-4 rounded-full" style="width: <?php echo $attendance_percentage; ?>%;"></div>
            </div>
            <p class="text-sm text-gray-600 mt-2">
                Total Records: <?php echo $total_records; ?> | 
                Present (incl. Late): <?php echo $present_like_count; ?> | 
                Absent: <?php echo $summary['absent']; ?> | 
                Leave: <?php echo $summary['leave']; ?>
            </p>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($attendance_records as $record): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($record['date']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($record['batch_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php
                                $status = $record['status'];
                                $badgeClass = 'bg-gray-100 text-gray-800';
                                if ($status === 'present') $badgeClass = 'bg-green-100 text-green-800';
                                elseif ($status === 'absent') $badgeClass = 'bg-red-100 text-red-800';
                                elseif ($status === 'late') $badgeClass = 'bg-yellow-100 text-yellow-800';
                                elseif ($status === 'leave') $badgeClass = 'bg-blue-100 text-blue-800';
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
</div>

<?php include FOOTER; ?>