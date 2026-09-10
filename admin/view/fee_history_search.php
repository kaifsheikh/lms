<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Student Fee History</h1>
        <p class="text-sm text-slate-500 mt-1">Search a student by ID to view their complete fee payment record.</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-lg mb-6 flex items-start gap-2">
            <svg class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span><?php echo htmlspecialchars($message); ?></span>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-6 flex items-start gap-2">
            <svg class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <!-- Search Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">
        <form method="GET" action="" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-XXXXXX)"
                       value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
                       class="w-full pl-11 border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Search
            </button>
        </form>

        <?php if (!empty($search_error)): ?>
            <p class="text-red-600 mt-3 text-sm flex items-center gap-1.5">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                </svg>
                <?php echo htmlspecialchars($search_error); ?>
            </p>
        <?php endif; ?>
    </div>

    <?php if ($search_results !== null && !empty($search_results)): ?>
        <!-- Student Info Banner -->
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl shadow-sm px-6 py-5 mb-6">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-indigo-100 uppercase tracking-wider">Fee History For</p>
                    <h2 class="text-xl font-bold text-white mt-0.5">
                        <?php echo htmlspecialchars($search_results[0]['full_name']) ?>
                    </h2>
                    <p class="text-sm text-indigo-100"><?php echo htmlspecialchars($search_results[0]['student_code']) ?></p>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <?php if ($summary): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Total Course Fee</p>
                            <p class="text-xl font-bold text-slate-800 mt-2">Rs. <?php echo number_format($summary['total_price'], 0); ?></p>
                        </div>
                        <div class="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Total Paid</p>
                            <p class="text-xl font-bold text-indigo-600 mt-2">Rs. <?php echo number_format($summary['total_paid'], 0); ?></p>
                        </div>
                        <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Overpaid Amount</p>
                            <p class="text-xl font-bold mt-2 <?php echo $summary['overpaid'] > 0 ? 'text-amber-600' : 'text-emerald-600'; ?>">
                                Rs. <?php echo number_format($summary['overpaid'], 0); ?>
                            </p>
                        </div>
                        <div class="h-10 w-10 rounded-lg <?php echo $summary['overpaid'] > 0 ? 'bg-amber-50' : 'bg-emerald-50'; ?> flex items-center justify-center">
                            <svg class="h-5 w-5 <?php echo $summary['overpaid'] > 0 ? 'text-amber-600' : 'text-emerald-600'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Months Paid</p>
                            <p class="text-xl font-bold text-slate-800 mt-2">
                                <?php echo $summary['months_paid']; ?> <span class="text-sm font-medium text-slate-400">/ <?php echo $summary['duration']; ?></span>
                            </p>
                        </div>
                        <div class="h-10 w-10 rounded-lg bg-violet-50 flex items-center justify-center">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Payment History Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-base font-semibold text-slate-800">Payment History</h3>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                    <?php echo count($search_results); ?> Records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Remarks</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($search_results as $payment): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <?php echo date('j M Y', strtotime($payment['payment_date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <?php echo htmlspecialchars($payment['payment_month']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                                    Rs. <?php echo number_format($payment['amount_paid'], 0); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">
                                    <?php echo htmlspecialchars($payment['remarks'] ?? '-'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <button type="button"
                                            onclick='openEditModal(<?php echo json_encode($payment); ?>)'
                                            class="inline-flex items-center gap-1.5 text-indigo-600 hover:text-indigo-800 font-medium">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Payment Modal -->
        <div id="editPaymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-slate-800">Edit Payment</h3>
                                <p class="text-xs text-slate-500">Update payment details</p>
                            </div>
                        </div>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-2xl leading-none transition">
                            &times;
                        </button>
                    </div>

                    <form method="POST" action="">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="action" value="edit_payment">
                        <input type="hidden" name="payment_id" id="edit_payment_id">
                        <input type="hidden" name="redirect_student_id" value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>">

                        <!-- Modal Body -->
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Amount Paid</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Rs.</span>
                                    <input type="number" step="0.01" name="amount_paid" id="edit_amount_paid" required
                                           class="w-full pl-10 border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Payment Date</label>
                                <input type="date" name="payment_date" id="edit_payment_date" required
                                       class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Payment Month</label>
                                <input type="text" name="payment_month" id="edit_payment_month" required
                                       class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Remarks <span class="text-slate-400 font-normal normal-case">(optional)</span></label>
                                <textarea name="remarks" id="edit_remarks" rows="3"
                                          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                                          placeholder="Add any additional notes..."></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-2">
                            <button type="button" onclick="closeEditModal()"
                                    class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-white transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
function openEditModal(payment) {
    document.getElementById('edit_payment_id').value = payment.id;
    document.getElementById('edit_amount_paid').value = payment.amount_paid;
    document.getElementById('edit_payment_date').value = payment.payment_date;
    document.getElementById('edit_payment_month').value = payment.payment_month;
    document.getElementById('edit_remarks').value = payment.remarks || '';
    document.getElementById('editPaymentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editPaymentModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Auto-fill month when date changes in edit modal
document.getElementById('edit_payment_date').addEventListener('change', function() {
    const dateVal = this.value;
    if (dateVal) {
        const date = new Date(dateVal + 'T00:00:00');
        if (!isNaN(date.getTime())) {
            const monthName = date.toLocaleString('en-US', { month: 'long' });
            const year = date.getFullYear();
            document.getElementById('edit_payment_month').value = monthName + ' ' + year;
        }
    }
});
</script>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>