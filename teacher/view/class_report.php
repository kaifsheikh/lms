<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Class Attendance Report</h1>

    <form method="GET" action="" class="bg-white shadow-md rounded-lg p-6 mb-6">
        <select name="class_id" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
            <option value="">-- Select Class --</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?php echo $class['id']; ?>" <?php echo ($class_id == $class['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['title']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">View Report</button>
    </form>

    <?php if ($selected_class): ?>
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Attendance for: <?php echo htmlspecialchars($selected_class['title']); ?></h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marked At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($attendance as $record): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($record['student_id']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($record['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php if ($record['status'] === 'present'): ?>
                                    <span class="text-green-600 font-medium">Present</span>
                                <?php else: ?>
                                    <span class="text-red-600 font-medium">Absent</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php echo $record['marked_at'] ? htmlspecialchars($record['marked_at']) : '-'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>