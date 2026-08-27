<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quiz Management</h1>

    <?php if (!empty($success)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <!-- ================= CREATE QUIZ SECTION ================= -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Create / Assign Quiz</h2>
        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="create_quiz">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quiz Title:</label>
                <input type="text" name="title" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Assign to Batch:</label>
                <select name="batch_id" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Batch --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?php echo $batch['id']; ?>">
                            <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Date (datetime):</label>
                <input type="datetime-local" name="due_date" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Timer (in minutes):</label>
                    <input type="number" name="timer" min="1" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Passing Marks:</label>
                    <input type="number" name="passing_marks" min="1" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                Create Quiz
            </button>
        </form>
    </div>

    <!-- ================= QUIZZES TABLE ================= -->
    <h2 class="text-xl font-semibold text-gray-800 mb-4">My Quizzes</h2>
    <?php if (empty($quizzes)): ?>
        <p class="text-gray-600">No quizzes created yet.</p>
    <?php else: ?>
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timer (min)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passing Marks</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($quizzes as $quiz): ?>
                    <?php $status = $quiz['status'] ?? 'draft'; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['title']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['description']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['batch_name'] ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['due_date']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['timer']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['passing_marks']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php
                            $statusClass = 'bg-gray-100 text-gray-800';
                            $statusText = ucfirst($status);
                            if ($status === 'draft') {
                                $statusClass = 'bg-orange-100 text-orange-800';
                            } elseif ($status === 'active') {
                                $statusClass = 'bg-green-100 text-green-800';
                            }
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass; ?>">
                                <?php echo $statusText; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($quiz['created_at']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <?php if ($status === 'draft'): ?>
                                <form method="POST" action="" class="inline" onsubmit="return confirm('Start this quiz? Students will be able to see it.');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="change_status">
                                    <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                    <input type="hidden" name="new_status" value="active">
                                    <button type="submit" class="text-blue-600 hover:text-blue-900">Start</button>
                                </form>
                            <?php elseif ($status === 'active'): ?>
                                <form method="POST" action="" class="inline" onsubmit="return confirm('Close this quiz? Students will no longer see it.');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="change_status">
                                    <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                    <input type="hidden" name="new_status" value="closed">
                                    <button type="submit" class="text-orange-600 hover:text-orange-900">Close</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="" class="inline" onsubmit="return confirm('Reopen this quiz?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="change_status">
                                    <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                    <input type="hidden" name="new_status" value="active">
                                    <button type="submit" class="text-green-600 hover:text-green-900">Reopen</button>
                                </form>
                                <form method="POST" action="" class="inline" onsubmit="return confirm('Set as draft? Students will not see this quiz.');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="change_status">
                                    <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                    <input type="hidden" name="new_status" value="draft">
                                    <button type="submit" class="text-gray-600 hover:text-gray-900">Set Draft</button>
                                </form>
                            <?php endif; ?>
                            <span class="text-gray-400">|</span>
                            <a href="<?php echo BASE_URL; ?>/teacher/controller/manage_questions.php?quiz_id=<?php echo $quiz['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Questions</a>
                            <span class="text-gray-400">|</span>
                            <a href="<?php echo BASE_URL; ?>/teacher/controller/edit_quiz.php?id=<?php echo $quiz['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <span class="text-gray-400">|</span>
                            <form method="POST" action="" class="inline" onsubmit="return confirm('Delete this quiz?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="delete_quiz">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>