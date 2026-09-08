<?php include HEADER; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Student Fee History Search</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)" 
                       value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
                       class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>
            <button type="submit" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors">
                View
            </button>
        </form>

        <?php if (!empty($search_error)): ?>
            <p class="text-red-600 mt-3 text-sm"><?php echo htmlspecialchars($search_error); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($search_results !== null && !empty($search_results)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-5 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">
                    Fee History for: <?php echo htmlspecialchars($search_results[0]['full_name']) ?> 
                    <span class="text-gray-600 font-medium">(<?php echo htmlspecialchars($search_results[0]['student_code']) ?>)</span>
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($search_results as $payment): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?php echo date('j F Y', strtotime($payment['payment_date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?php echo htmlspecialchars($payment['payment_month']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    Rs. <?php echo number_format($payment['amount_paid'], 2); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?php echo htmlspecialchars($payment['remarks'] ?? '-'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Section: 4 Cards -->
            <?php if ($summary): ?>
                <div class="px-6 py-5 border-t border-gray-200 bg-gray-50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase font-medium tracking-wider">Total Course Fee</p>
                            <p class="text-lg font-bold text-gray-800 mt-1">Rs. <?php echo number_format($summary['total_price'], 2); ?></p>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase font-medium tracking-wider">Total Paid</p>
                            <p class="text-lg font-bold text-indigo-600 mt-1">Rs. <?php echo number_format($summary['total_paid'], 2); ?></p>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase font-medium tracking-wider">Overpaid Amount</p>
                            <p class="text-lg font-bold <?php echo $summary['overpaid'] > 0 ? 'text-red-600' : 'text-green-600'; ?> mt-1">
                                Rs. <?php echo number_format($summary['overpaid'], 2); ?>
                            </p>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase font-medium tracking-wider">Months Paid</p>
                            <p class="text-lg font-bold text-gray-800 mt-1">
                                <?php echo $summary['months_paid']; ?> / <?php echo $summary['duration']; ?> months
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>