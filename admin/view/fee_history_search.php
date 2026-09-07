<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Student Fee History Search</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="" class="flex gap-2">
            <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)" 
                   value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">View</button>
        </form>

        <?php if (!empty($search_error)): ?>
            <p class="text-red-600 mt-3"><?php echo htmlspecialchars($search_error); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($search_results !== null && !empty($search_results)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Fee History for: <?php echo htmlspecialchars($search_results[0]['full_name']) ?> 
                (<?php echo htmlspecialchars($search_results[0]['student_code']) ?>)
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Month</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($search_results as $payment): ?>
                            <tr>
                                <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($payment['payment_month']); ?></td>
                                <td class="px-4 py-3 text-sm">Rs. <?php echo number_format($payment['amount_paid'], 2); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($payment['remarks'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>