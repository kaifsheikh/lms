<?php include HEADER; ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-6">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </span>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Mark your Attendance</h1>
            <div class="flex flex-wrap items-center gap-2 mt-1 text-sm text-gray-500">
                <span class="inline-flex items-center gap-1">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Batch: <span class="font-medium text-gray-700"><?php echo htmlspecialchars($batch['batch_name']); ?></span>
                </span>
                <span class="inline-flex items-center gap-1">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Date: <span class="font-medium text-gray-700"><?php echo date('M d, Y', strtotime($date)); ?></span>
                </span>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($attendance_already_marked): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <p class="mt-4 text-gray-500 text-lg">Is date ki attendance pehle se mark ho chuki hai. Aap dobara mark nahi kar sakte.</p>
        </div>
    <?php elseif (empty($students)): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="mt-4 text-gray-500 text-lg">Is batch mein koi student nahi hai.</p>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
            <!-- Top gradient bar -->
            <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>

            <form method="POST" action="<?php echo BASE_URL; ?>/teacher/controller/attendance_save.php">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Attendance</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($students as $student): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($student['student_id']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo htmlspecialchars($student['full_name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="present" checked
                                                       class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                                <span class="text-green-700 font-medium">Present</span>
                                            </label>
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="absent"
                                                       class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                                <span class="text-red-700 font-medium">Absent</span>
                                            </label>
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="late"
                                                       class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                                <span class="text-amber-700 font-medium">Late</span>
                                            </label>
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="leave"
                                                       class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                                <span class="text-blue-700 font-medium">Leave</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 px-6 py-4 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm hover:shadow-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>