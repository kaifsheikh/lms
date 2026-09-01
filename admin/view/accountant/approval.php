<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Accountant Approval</h1>
</div>

<?php if (!empty($message)): ?>
    <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </p>
<?php endif; ?>

<div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Contact</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Current Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Registered At</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Change Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $status = $row['status'];
                    $badge = 'bg-amber-50 text-amber-700';
                    if ($status === 'approved') {
                        $badge = 'bg-green-50 text-green-700';
                    } elseif ($status === 'rejected') {
                        $badge = 'bg-red-50 text-red-700';
                    }
                    ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?= (int)$row['id']; ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?= htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?= htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badge; ?>">
                                <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?= htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <form method="POST" action="" class="flex items-center gap-2">
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
                                <select name="status" class="border border-slate-300 rounded-md px-2 py-1.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    <option value="pending" <?= ($status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?= ($status === 'approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?= ($status === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-1.5 px-3 rounded-md text-sm transition-colors">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">No accountants found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include FOOTER; ?>
