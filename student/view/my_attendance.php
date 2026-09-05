<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Attendance</h1>
        <!-- Search Bar -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                id="attendance-search"
                placeholder="Search attendance..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
            >
        </div>
    </div>

    <?php if (empty($attendance_records)): ?>
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <p class="mt-4 text-gray-500 text-lg">No attendance records yet.</p>
        </div>
    <?php else: ?>
        <!-- Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-green-100 shadow-sm p-5 flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
                <div>
                    <p class="text-2xl font-bold text-green-700"><?php echo $summary['present']; ?></p>
                    <p class="text-sm text-green-600">Present</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-red-100 shadow-sm p-5 flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-2xl font-bold text-red-700"><?php echo $summary['absent']; ?></p>
                    <p class="text-sm text-red-600">Absent</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-5 flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-2xl font-bold text-amber-700"><?php echo $summary['late']; ?></p>
                    <p class="text-sm text-amber-600">Late</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-blue-100 shadow-sm p-5 flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
                <div>
                    <p class="text-2xl font-bold text-blue-700"><?php echo $summary['leave']; ?></p>
                    <p class="text-sm text-blue-600">Leave</p>
                </div>
            </div>
        </div>

        <!-- Attendance Progress -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-semibold text-gray-800">Attendance Progress</h2>
                <span class="text-2xl font-bold text-indigo-600"><?php echo $attendance_percentage; ?>%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-3 rounded-full transition-all duration-500" style="width: <?php echo $attendance_percentage; ?>%;"></div>
            </div>
            <p class="text-sm text-gray-500 mt-3">
                Total Records: <?php echo $total_records; ?> |
                Present (incl. Late): <?php echo $present_like_count; ?> |
                Absent: <?php echo $summary['absent']; ?> |
                Leave: <?php echo $summary['leave']; ?>
            </p>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="attendance-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Batch</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($attendance_records as $record): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo date('M d, Y', strtotime($record['date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo htmlspecialchars($record['batch_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php
                                    $status = $record['status'];
                                    $badgeClass = 'bg-gray-100 text-gray-600';
                                    if ($status === 'present') $badgeClass = 'bg-green-50 text-green-700';
                                    elseif ($status === 'absent') $badgeClass = 'bg-red-50 text-red-700';
                                    elseif ($status === 'late') $badgeClass = 'bg-amber-50 text-amber-700';
                                    elseif ($status === 'leave') $badgeClass = 'bg-blue-50 text-blue-700';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- No results message -->
            <div id="no-results" class="hidden p-8 text-center text-gray-500">
                No matching records found.
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Live search functionality
(function() {
    const searchInput = document.getElementById('attendance-search');
    const table = document.getElementById('attendance-table');
    const noResults = document.getElementById('no-results');

    if (!searchInput || !table) return;

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const rows = table.querySelectorAll('tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResults) {
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
    });
})();
</script>

<?php include FOOTER; ?>