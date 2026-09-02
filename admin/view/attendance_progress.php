<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Attendance Progress</h1>
</div>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($error); ?>
    </p>
<?php endif; ?>

<!-- Batch Selection Form -->
<form method="GET" action="" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-end gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Batch Select:</label>
            <select name="batch_id" required class="border border-slate-300 rounded-lg px-3 py-2 w-full text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="" disabled selected>-- Select Batch --</option>
                <?php foreach ($batches as $batch): ?>
                    <option value="<?php echo $batch['id']; ?>" <?php echo ($batch_id == $batch['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' (' . $batch['batch_time'] . ') - Teacher: ' . $batch['teacher_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">View Progress</button>
    </div>
</form>

<?php if ($selected_batch): ?>
    <h2 class="text-lg font-semibold text-slate-800 mb-4">
        Attendance Progress for <?php echo htmlspecialchars($selected_batch['batch_name']); ?>
    </h2>

    <?php if (empty($students_progress)): ?>
        <p class="text-slate-500">Is batch mein koi student nahi hai.</p>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Present</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Late</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Absent</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Leave</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($students_progress as $sp): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($sp['student_id']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($sp['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo $sp['present_count']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo $sp['late_count']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo $sp['absent_count']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo $sp['leave_count']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo $sp['total_records']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-700 font-medium"><?php echo $sp['percentage']; ?>%</span>
                                    <div class="w-24 bg-slate-200 rounded-full h-1.5">
                                        <div class="bg-indigo-600 h-1.5 rounded-full" style="width: <?php echo $sp['percentage']; ?>%;"></div>
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
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mt-8">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Student Progress Search</h2>
    <form method="GET" action="" class="flex flex-col sm:flex-row items-start sm:items-center gap-2 mb-4">
        <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)"
               value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
               class="border border-slate-300 rounded-lg px-3 py-2 w-full sm:w-64 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">Search</button>
    </form>

    <?php if (!empty($student_search_error)): ?>
        <p class="text-red-600 text-sm"><?php echo htmlspecialchars($student_search_error); ?></p>
    <?php endif; ?>

    <?php if ($searched_student): ?>
        <div class="border-t border-slate-200 pt-4">
            <h3 class="text-base font-semibold text-slate-800 mb-2">Student Details</h3>
            <div class="mb-4 text-sm text-slate-600 space-y-1">
                <p><span class="font-medium text-slate-700">Student ID:</span> <?php echo htmlspecialchars($searched_student['student_id']); ?></p>
                <p><span class="font-medium text-slate-700">Full Name:</span> <?php echo htmlspecialchars($searched_student['full_name']); ?></p>
            </div>

            <h4 class="text-sm font-semibold text-slate-700 mb-2">Attendance Summary</h4>
            <?php if ($student_summary): ?>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-4">
                    <div class="bg-green-50 border border-green-100 rounded-lg p-3 text-center">
                        <p class="text-xl font-semibold text-green-700"><?php echo $student_summary['present_count']; ?></p>
                        <p class="text-xs text-green-700">Present</p>
                    </div>
                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-3 text-center">
                        <p class="text-xl font-semibold text-amber-700"><?php echo $student_summary['late_count']; ?></p>
                        <p class="text-xs text-amber-700">Late</p>
                    </div>
                    <div class="bg-red-50 border border-red-100 rounded-lg p-3 text-center">
                        <p class="text-xl font-semibold text-red-700"><?php echo $student_summary['absent_count']; ?></p>
                        <p class="text-xs text-red-700">Absent</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 text-center">
                        <p class="text-xl font-semibold text-blue-700"><?php echo $student_summary['leave_count']; ?></p>
                        <p class="text-xs text-blue-700">Leave</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-center">
                        <p class="text-xl font-semibold text-slate-700"><?php echo $student_summary['total_records']; ?></p>
                        <p class="text-xs text-slate-600">Total</p>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="text-sm font-medium text-slate-600">Attendance Percentage: </span>
                    <span class="text-sm font-semibold text-slate-800"><?php echo $student_summary['percentage']; ?>%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2.5">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: <?php echo $student_summary['percentage']; ?>%;"></div>
                </div>
            <?php else: ?>
                <p class="text-slate-500">Koi attendance record nahi mila.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>
