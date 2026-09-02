<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">All Courses</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (empty($courses)): ?>
        <p class="text-gray-600">کوئی کورس موجود نہیں۔</p>
    <?php else: ?>
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admission</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skill Level</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Schedule</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class Hours</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($course['course_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($course['duration']); ?> months</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($course['admission_fee']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($course['total_price']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($course['skill_level']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($course['schedule']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($course['class_hours']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <!-- Edit Form (inline) -->
                                <form method="POST" action="" class="inline-block mr-2">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="update_course">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" class="border border-gray-300 rounded-md px-2 py-1 text-sm mb-1" required>
                                    <input type="number" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>" class="border border-gray-300 rounded-md px-2 py-1 text-sm w-20 mb-1" min="1" required>
                                    <input type="number" step="0.01" name="admission_fee" value="<?php echo htmlspecialchars($course['admission_fee']); ?>" class="border border-gray-300 rounded-md px-2 py-1 text-sm w-24 mb-1" min="0" required>
                                    <input type="number" step="0.01" name="total_price" value="<?php echo htmlspecialchars($course['total_price']); ?>" class="border border-gray-300 rounded-md px-2 py-1 text-sm w-24 mb-1" min="0" required>
                                    <select name="skill_level" class="border border-gray-300 rounded-md px-2 py-1 text-sm mb-1">
                                        <option value="Beginner" <?php echo ($course['skill_level'] === 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                                        <option value="Intermediate" <?php echo ($course['skill_level'] === 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                        <option value="Advanced" <?php echo ($course['skill_level'] === 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                                    </select>
                                    <input type="text" name="schedule" value="<?php echo htmlspecialchars($course['schedule']); ?>" class="border border-gray-300 rounded-md px-2 py-1 text-sm mb-1" required>
                                    <input type="text" name="class_hours" value="<?php echo htmlspecialchars($course['class_hours']); ?>" class="border border-gray-300 rounded-md px-2 py-1 text-sm mb-1" required>
                                    <button type="submit" class="text-blue-600 hover:text-blue-900">Update</button>
                                </form>
                                <!-- Delete Form -->
                                <form method="POST" action="" class="inline-block" onsubmit="return confirm('کیا آپ واقعی اس کورس کو ڈیلیٹ کرنا چاہتے ہیں؟');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="delete_course">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
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