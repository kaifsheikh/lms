<?php include HEADER; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Batches</h1>

    <?php if (empty($batches)): ?>
        <p class="text-gray-600">No batches created yet.</p>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($batches as $batch): ?>
                <div class="bg-white shadow-md rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">
                        <?php echo htmlspecialchars($batch['batch_name']); ?>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <?php
                            $statusClass = 'text-orange-600';
                            if ($batch['status'] === 'approved') {
                                $statusClass = 'text-green-600';
                            } elseif ($batch['status'] === 'rejected') {
                                $statusClass = 'text-red-600';
                            }
                            ?>
                            <p class="font-medium <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($batch['status']); ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Starting Date</p>
                            <p class="font-medium text-gray-900"><?php echo htmlspecialchars($batch['starting_date']); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Time</p>
                            <p class="font-medium text-gray-900"><?php echo htmlspecialchars($batch['batch_time']); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Created At</p>
                            <p class="font-medium text-gray-900"><?php echo htmlspecialchars($batch['created_at']); ?></p>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">Students in this Batch</h3>
                    <?php if (empty($batch['students'])): ?>
                        <p class="text-gray-600 italic">No students assigned.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-gray-50 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Student ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Full Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Course</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($batch['students'] as $student): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($student['student_id']); ?></td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($student['full_name']); ?></td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($student['email']); ?></td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($student['course_name']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>