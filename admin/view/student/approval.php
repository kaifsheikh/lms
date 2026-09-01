<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Student Approval</h1>
</div>

<?php if (!empty($message)): ?>
    <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-x-auto">
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
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo $row['id']; ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <?php
                            $status = $row['status'];
                            $badge = 'bg-amber-50 text-amber-700';
                            if ($status === 'approved') $badge = 'bg-green-50 text-green-700';
                            if ($status === 'rejected') $badge = 'bg-red-50 text-red-700';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge; ?>"><?php echo htmlspecialchars($status); ?></span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <form method="POST" action="" class="flex items-center gap-2">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="user_id" value="<?= (int) $row['id'] ?>">
                                <select name="status" class="border border-slate-300 rounded-md text-sm px-2 py-1.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    <option value="pending"  <?php echo ($status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo ($status === 'approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?php echo ($status === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-3 py-1.5 rounded-md transition-colors">Update</button>
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
