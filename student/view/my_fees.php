<?php include HEADER; ?>

<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Fees</h1>

    <?php if ($summary): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Total Fee</p>
                    <p class="text-lg font-semibold">Rs. <?php echo number_format($summary['total_price'], 2); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Paid Amount</p>
                    <p class="text-lg font-semibold text-green-600">Rs. <?php echo number_format($summary['total_paid'], 2); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Remaining Amount</p>
                    <p class="text-lg font-semibold text-red-600">Rs. <?php echo number_format($summary['remaining'], 2); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
               <?php if ($summary['status'] === 'paid'): ?>
    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
<?php elseif ($summary['status'] === 'partial'): ?>
    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Partial</span>
<?php elseif ($summary['status'] === 'overpaid'): ?>
    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Overpaid (Credit: Rs. <?php echo number_format($summary['overpaid_amount'], 2); ?>)</span>
<?php else: ?>
    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Unpaid</span>
<?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>No fee information found.</p>
    <?php endif; ?>

    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment History</h2>
    <?php if (empty($history)): ?>
        <p class="text-gray-600">No payments yet.</p>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Month</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($history as $pay): ?>
                        <tr>
                            <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($pay['payment_date']); ?></td>
                            <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($pay['payment_month']); ?></td>
                            <td class="px-4 py-3 text-sm">Rs. <?php echo number_format($pay['amount_paid'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>