<?php include HEADER; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Accountant Approval</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $status = $row['status'];
                        $color = 'orange';
                        if ($status === 'approved') {
                            $color = 'green';
                        } elseif ($status === 'rejected') {
                            $color = 'red';
                        }
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= (int)$row['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php
                                $statusClass = 'text-orange-600';
                                if ($status === 'approved') {
                                    $statusClass = 'text-green-600';
                                } elseif ($status === 'rejected') {
                                    $statusClass = 'text-red-600';
                                }
                                ?>
                                <span class="font-medium <?= $statusClass; ?>">
                                    <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form method="POST" action="" class="flex items-center space-x-2">
                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>"
                                    >
                                    <input
                                        type="hidden"
                                        name="user_id"
                                        value="<?= (int)$row['id']; ?>"
                                    >
                                    <select name="status" class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="pending" <?= ($status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="approved" <?= ($status === 'approved') ? 'selected' : ''; ?>>Approved</option>
                                        <option value="rejected" <?= ($status === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md text-sm transition-colors">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No accountants found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include FOOTER; ?>