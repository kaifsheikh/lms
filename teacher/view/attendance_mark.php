<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Mark your Attendance</h1>
    <p class="text-sm text-slate-500 mt-1">
        Batch: <span class="font-medium text-slate-700"><?php echo htmlspecialchars($batch['batch_name']); ?></span> &middot;
        Date: <span class="font-medium text-slate-700"><?php echo htmlspecialchars($date); ?></span>
    </p>
</div>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($error); ?>
    </p>
<?php endif; ?>

<?php if ($attendance_already_marked): ?>
    <p class="text-slate-500">Is date ki attendance pehle se mark ho chuki hai. Aap dobara mark nahi kar sakte.</p>
<?php elseif (empty($students)): ?>
    <p class="text-slate-500">Is batch mein koi student nahi hai.</p>
<?php else: ?>
    <!-- Form sirf tab dikhe jab attendance already marked nahi hai -->
    <form method="POST" action="<?php echo BASE_URL; ?>/teacher/controller/attendance_save.php" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">
        <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">

        <div class="overflow-x-auto -mx-6">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Attendance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($students as $student): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($student['full_name']); ?></td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                <div class="flex flex-wrap items-center gap-4">
                                    <label class="inline-flex items-center gap-1.5 text-sm text-slate-600">
                                        <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="present" checked class="text-indigo-600 focus:ring-indigo-500"> Present
                                    </label>
                                    <label class="inline-flex items-center gap-1.5 text-sm text-slate-600">
                                        <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="absent" class="text-indigo-600 focus:ring-indigo-500"> Absent
                                    </label>
                                    <label class="inline-flex items-center gap-1.5 text-sm text-slate-600">
                                        <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="late" class="text-indigo-600 focus:ring-indigo-500"> Late
                                    </label>
                                    <label class="inline-flex items-center gap-1.5 text-sm text-slate-600">
                                        <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="leave" class="text-indigo-600 focus:ring-indigo-500"> Leave
                                    </label>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">Save Attendance</button>
        </div>
    </form>
<?php endif; ?>

<?php include FOOTER; ?>
