<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quiz Results</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <!-- Quiz Selection Form -->
    <form method="GET" action="" class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex items-end space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Quiz:</label>
                <select name="quiz_id" required class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Quiz --</option>
                    <?php foreach ($quizzes as $quiz): ?>
                        <option value="<?php echo $quiz['id']; ?>" <?php echo ($quiz_id == $quiz['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($quiz['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">View Results</button>
        </div>
    </form>

    <?php if ($selected_quiz): ?>
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">
                    Quiz: <?php echo htmlspecialchars($selected_quiz['title']); ?>
                    <?php if (!empty($selected_quiz['batch_name'])): ?>
                        <span class="text-gray-500">- Batch: <?php echo htmlspecialchars($selected_quiz['batch_name']); ?></span>
                    <?php endif; ?>
                </h2>
                <p class="text-sm text-gray-600">
                    Passing Percentage: <strong><?php echo $selected_quiz['passing_marks']; ?>%</strong>
                </p>
            </div>
            <!-- Statistics Panel -->
            <div class="bg-white shadow-sm rounded-lg p-4 flex space-x-4">
                <div class="text-center">
                    <p class="text-xl font-bold text-gray-800"><?php echo $total_students; ?></p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-green-600"><?php echo $passed_count; ?></p>
                    <p class="text-xs text-gray-500">Passed</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-red-600"><?php echo $failed_count; ?></p>
                    <p class="text-xs text-gray-500">Failed</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-gray-500"><?php echo $not_submitted_count; ?></p>
                    <p class="text-xs text-gray-500">Not Submitted</p>
                </div>
            </div>
        </div>

        <?php if (empty($attempts)): ?>
            <p class="text-gray-600">No students have attempted this quiz yet.</p>
        <?php else: ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Obtained Marks</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Marks</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Percentage</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($attempts as $attempt): ?>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($attempt['student_id']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($attempt['full_name']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <?php echo $attempt['obtained_marks'] !== null ? $attempt['obtained_marks'] : '-'; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <?php echo $attempt['total_marks'] !== null ? $attempt['total_marks'] : '-'; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <?php echo $attempt['percentage'] !== null ? $attempt['percentage'] . '%' : '-'; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <?php if ($attempt['not_submitted']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Not Submitted</span>
                                    <?php elseif ($attempt['passed']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Pass</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Fail</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <?php if (!$attempt['not_submitted'] && !$attempt['passed']): ?>
                                        <form method="POST" action="" onsubmit="return confirm('Allow retake for this student?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="action" value="retake_attempt">
                                            <input type="hidden" name="attempt_id" value="<?php echo $attempt['attempt_id']; ?>">
                                            <button type="submit" class="text-indigo-600 hover:text-indigo-900">Retake</button>
                                        </form>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
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