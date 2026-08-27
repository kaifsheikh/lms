<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Mark your Attendance</h1>
    <p class="text-gray-600 mb-6">
        Batch: <strong><?php echo htmlspecialchars($batch['batch_name']); ?></strong> | 
        Date: <strong><?php echo htmlspecialchars($date); ?></strong>
    </p>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <?php if ($attendance_already_marked): ?>
        <p class="text-gray-600">Is date ki attendance pehle se mark ho chuki hai. Aap dobara mark nahi kar sakte.</p>
    <?php elseif (empty($students)): ?>
        <p class="text-gray-600">Is batch mein koi student nahi hai.</p>
    <?php else: ?>
        <!-- Form sirf tab dikhe jab attendance already marked nahi hai -->
        <form method="POST" action="<?php echo BASE_URL; ?>/teacher/controller/attendance_save.php" class="bg-white shadow-md rounded-lg p-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($student['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <label class="inline-flex items-center mr-3">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="present" checked class="mr-1"> Present
                                </label>
                                <label class="inline-flex items-center mr-3">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="absent" class="mr-1"> Absent
                                </label>
                                <label class="inline-flex items-center mr-3">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="late" class="mr-1"> Late
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="leave" class="mr-1"> Leave
                                </label>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">Save Attendance</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>