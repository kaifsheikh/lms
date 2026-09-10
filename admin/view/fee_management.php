<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Fee Management</h1>
            <p class="text-sm text-slate-500 mt-1">Track student fee payments and outstanding balances.</p>
        </div>
        <button onclick="openModal('addPaymentModal')" 
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Payment
        </button>
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

    <!-- Add Payment Modal -->
    <div id="addPaymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">Add Payment</h3>
                            <p class="text-xs text-slate-500">Record a new fee payment</p>
                        </div>
                    </div>
                    <button onclick="closeModal('addPaymentModal')" class="text-slate-400 hover:text-slate-600 text-2xl leading-none transition">&times;</button>
                </div>

                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="add_payment">
                    
                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Teacher</label>
                            <select id="teacher_select" required 
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">-- Select Teacher --</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['full_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Batch</label>
                            <select id="batch_select" required disabled 
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition disabled:bg-slate-100 disabled:text-slate-400">
                                <option value="">-- Select Teacher First --</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Student</label>
                            <select id="student_select" name="student_id" required disabled 
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition disabled:bg-slate-100 disabled:text-slate-400">
                                <option value="">-- Select Batch First --</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Amount Paid</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Rs.</span>
                                <input type="number" step="0.01" name="amount_paid" required 
                                       class="w-full pl-10 border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Payment Date</label>
                            <input type="date" id="payment_date" name="payment_date" value="<?php echo date('Y-m-d'); ?>" required 
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Payment Month</label>
                            <input type="text" id="payment_month" name="payment_month" readonly required 
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-700 bg-slate-50 focus:outline-none cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Remarks <span class="text-slate-400 font-normal normal-case">(optional)</span></label>
                            <textarea name="remarks" rows="3" 
                                      class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                                      placeholder="Add any additional notes..."></textarea>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-2">
                        <button type="button" onclick="closeModal('addPaymentModal')" 
                                class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-white transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                            Save Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Search -->
    <div class="mb-5 relative">
        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="feeSearch" placeholder="Search by student name or ID..."
               class="w-full pl-11 border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
    </div>

    <!-- Fee Summary Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Course</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Fee</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Paid</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Remaining</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100" id="feeTableBody">
                    <?php foreach ($students_with_fee as $sf): ?>
                        <tr class="fee-row hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($sf['student_code']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($sf['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($sf['course_name'] ?? 'N/A'); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-700">Rs. <?php echo number_format($sf['total_price'] ?? 0, 0); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-indigo-600">Rs. <?php echo number_format($sf['total_paid'] ?? 0, 0); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php
                                    if ($sf['status'] === 'overpaid') {
                                        echo '<span class="text-amber-600 font-semibold">+Rs. ' . number_format($sf['overpaid_amount'], 0) . '</span>';
                                    } else {
                                        echo '<span class="text-slate-700">Rs. ' . number_format($sf['remaining'], 0) . '</span>';
                                    }
                                ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <?php if ($sf['status'] === 'paid'): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Paid
                                    </span>
                                <?php elseif ($sf['status'] === 'partial'): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Partial
                                    </span>
                                <?php elseif ($sf['status'] === 'overpaid'): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                        Overpaid
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Unpaid
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function () {
    const teacherSelect = document.getElementById('teacher_select');
    const batchSelect = document.getElementById('batch_select');
    const studentSelect = document.getElementById('student_select');
    const paymentDate = document.getElementById('payment_date');
    const paymentMonth = document.getElementById('payment_month');

    teacherSelect.addEventListener('change', function () {
        const teacherId = this.value;
        batchSelect.innerHTML = '<option value="">-- Select Batch --</option>';
        studentSelect.innerHTML = '<option value="">-- Select Batch First --</option>';
        batchSelect.disabled = true;
        studentSelect.disabled = true;

        if (teacherId) {
            fetch('<?= BASE_URL ?>/admin/controller/fee_management.php?ajax=get_batches&teacher_id=' + teacherId)
                .then(res => res.json())
                .then(data => {
                    data.forEach(batch => {
                        const opt = document.createElement('option');
                        opt.value = batch.id;
                        opt.textContent = batch.batch_name + ' (' + batch.batch_time + ')';
                        batchSelect.appendChild(opt);
                    });
                    batchSelect.disabled = false;
                });
        }
    });

    batchSelect.addEventListener('change', function () {
        const batchId = this.value;
        studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
        studentSelect.disabled = true;

        if (batchId) {
            fetch('<?= BASE_URL ?>/admin/controller/fee_management.php?ajax=get_students&batch_id=' + batchId)
                .then(res => res.json())
                .then(data => {
                    data.forEach(student => {
                        const opt = document.createElement('option');
                        opt.value = student.id;
                        opt.textContent = student.full_name + ' (' + student.student_id + ')';
                        studentSelect.appendChild(opt);
                    });
                    studentSelect.disabled = false;
                });
        }
    });

    function updateMonth() {
        const date = new Date(paymentDate.value);
        if (!isNaN(date.getTime())) {
            const monthName = date.toLocaleString('en-US', { month: 'long' });
            const year = date.getFullYear();
            paymentMonth.value = monthName + ' ' + year;
        } else {
            paymentMonth.value = '';
        }
    }
    paymentDate.addEventListener('change', updateMonth);
    updateMonth();
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('feeSearch');
    const tableBody = document.getElementById('feeTableBody');
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            tableBody.querySelectorAll('.fee-row').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    }
});
</script>

<?php include FOOTER; ?>