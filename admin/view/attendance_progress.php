<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Attendance Progress</h1>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <!-- Batch Selection Form -->
    <form method="GET" action="" class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex items-end space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Batch Select Karein:</label>
                <select name="batch_id" required class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Batch Chunein --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?php echo $batch['id']; ?>" <?php echo ($batch_id == $batch['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' (' . $batch['batch_time'] . ') - Teacher: ' . $batch['teacher_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">View Progress</button>
        </div>
    </form>

    <?php if ($selected_batch): ?>
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Attendance Progress for <?php echo htmlspecialchars($selected_batch['batch_name']); ?>
        </h2>

        <?php if (empty($students_progress)): ?>
            <p class="text-gray-600">Is batch mein koi student nahi hai.</p>
        <?php else: ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Present</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Late</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Absent</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Leave</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($students_progress as $sp): ?>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($sp['student_id']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($sp['full_name']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo $sp['present_count']; ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo $sp['late_count']; ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo $sp['absent_count']; ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo $sp['leave_count']; ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo $sp['total_records']; ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-2">
                                        <span><?php echo $sp['percentage']; ?>%</span>
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-600 h-2 rounded-full" style="width: <?php echo $sp['percentage']; ?>%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- ================= STUDENT SEARCH SECTION ================= -->
    <div class="bg-white shadow-md rounded-lg p-6 mt-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Student Progress Search</h2>
        <form method="GET" action="" class="flex items-center space-x-2 mb-4">
            <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)" 
                   value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>" 
                   class="border border-gray-300 rounded-md px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">Search</button>
        </form>

        <?php if (!empty($student_search_error)): ?>
            <p class="text-red-600"><?php echo htmlspecialchars($student_search_error); ?></p>
        <?php endif; ?>

        <?php if ($searched_student): ?>
            <div class="border-t pt-4">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Student Details</h3>
            <div class="mb-4">
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($searched_student['student_id']); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($searched_student['full_name']); ?></p>
            </div>

                <h4 class="text-md font-medium text-gray-600 mb-2">Attendance Summary</h4>
                <?php if ($student_summary): ?>
                    <div class="grid grid-cols-5 gap-4 mb-4">
                        <div class="bg-green-100 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-green-800"><?php echo $student_summary['present_count']; ?></p>
                            <p class="text-xs text-green-700">Present</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-yellow-800"><?php echo $student_summary['late_count']; ?></p>
                            <p class="text-xs text-yellow-700">Late</p>
                        </div>
                        <div class="bg-red-100 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-red-800"><?php echo $student_summary['absent_count']; ?></p>
                            <p class="text-xs text-red-700">Absent</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-blue-800"><?php echo $student_summary['leave_count']; ?></p>
                            <p class="text-xs text-blue-700">Leave</p>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-gray-800"><?php echo $student_summary['total_records']; ?></p>
                            <p class="text-xs text-gray-700">Total</p>
                        </div>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm font-medium">Attendance Percentage: </span>
                        <span class="text-sm font-bold"><?php echo $student_summary['percentage']; ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-indigo-600 h-4 rounded-full" style="width: <?php echo $student_summary['percentage']; ?>%;"></div>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">Koi attendance record nahi mila.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include FOOTER; ?>