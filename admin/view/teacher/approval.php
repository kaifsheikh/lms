<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Teacher Approval</h1>

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

    <?php if (empty($teachers)): ?>
        <p class="text-gray-600">No teachers found.</p>
    <?php else: ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo $teacher['id']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($teacher['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($teacher['email']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($teacher['contact']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php
                                $status = $teacher['status'];
                                $badgeClass = 'bg-gray-100 text-gray-800';
                                if ($status === 'approved') $badgeClass = 'bg-green-100 text-green-800';
                                elseif ($status === 'pending') $badgeClass = 'bg-yellow-100 text-yellow-800';
                                elseif ($status === 'rejected') $badgeClass = 'bg-red-100 text-red-800';
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    <!-- Approve -->
                                    <form method="POST" action="" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $teacher['id']; ?>">
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                    </form>
                                    <!-- Reject -->
                                    <form method="POST" action="" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $teacher['id']; ?>">
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>