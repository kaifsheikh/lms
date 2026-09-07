<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Fee Management</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <div class="mb-6">
        <button onclick="openModal('addPaymentModal')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Add Payment</button>
    </div>

    <!-- Add Payment Modal -->
    <div id="addPaymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Add Payment</h3>
                    <button onclick="closeModal('addPaymentModal')" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="add_payment">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teacher:</label>
                            <select id="teacher_select" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Teacher --</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['full_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batch:</label>
                            <select id="batch_select" required disabled class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:bg-gray-100">
                                <option value="">-- Select Teacher First --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Student:</label>
                            <select id="student_select" name="student_id" required disabled class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:bg-gray-100">
                                <option value="">-- Select Batch First --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount Paid:</label>
                            <input type="number" step="0.01" name="amount_paid" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date:</label>
                            <input type="date" id="payment_date" name="payment_date" value="<?php echo date('Y-m-d'); ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Month:</label>
                            <input type="text" id="payment_month" name="payment_month" readonly required class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Remarks (optional):</label>
                            <textarea name="remarks" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fee Summary Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Student ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Course</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total Fee</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Paid</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Remaining</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($students_with_fee as $sf): ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($sf['student_code']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($sf['full_name']); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($sf['course_name'] ?? 'N/A'); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo number_format($sf['total_price'] ?? 0, 2); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo number_format($sf['total_paid'] ?? 0, 2); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo number_format($sf['remaining'], 2); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <?php if ($sf['status'] === 'paid'): ?>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                            <?php elseif ($sf['status'] === 'partial'): ?>
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Partial</span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Unpaid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
</script>

<?php include FOOTER; ?>