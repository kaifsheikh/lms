<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Attendance Report</h1>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <!-- Filter Form -->
    <form method="GET" action="" class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Batch:</label>
                <select name="batch_id" required class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Batch --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?php echo $batch['id']; ?>" <?php echo ($batch_id == $batch['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($batch['batch_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date:</label>
                <input type="date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>" required class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">View Report</button>
        </div>
    </form>

    <!-- Report Table -->
    <?php if ($selected_batch): ?>
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Attendance for <?php echo htmlspecialchars($selected_batch['batch_name']); ?> on <?php echo htmlspecialchars($selected_date); ?>
        </h2>

        <?php if (empty($report_data)): ?>
            <p class="text-red-800">Attendance not found</p>
        <?php else: ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($report_data as $record): ?>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($record['student_id']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($record['full_name']); ?></td>
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
    <?php endif; ?>
</div>

<?php include FOOTER; ?>