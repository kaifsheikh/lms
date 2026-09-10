<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">My Attendance</h1>
            <p class="text-sm text-slate-500 mt-1">Aapki daily attendance ka poora record.</p>
        </div>
        <!-- Search Bar -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                id="attendance-search"
                placeholder="Search attendance..."
                class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-colors"
            >
        </div>
    </div>

    <?php if (empty($attendance_records)): ?>
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="w-14 h-14 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-4">
                <svg class="h-7 w-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <p class="text-slate-500">No attendance records yet.</p>
        </div>
    <?php else: ?>
        <!-- Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-emerald-200 transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Good</span>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $summary['present']; ?></p>
                <p class="text-sm text-slate-500 mt-1">Present Days</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-red-200 transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $summary['absent']; ?></p>
                <p class="text-sm text-slate-500 mt-1">Absent Days</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-amber-200 transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <circle cx="12" cy="12" r="10"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $summary['late']; ?></p>
                <p class="text-sm text-slate-500 mt-1">Late Arrivals</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-sky-200 transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-4"><?php echo $summary['leave']; ?></p>
                <p class="text-sm text-slate-500 mt-1">Leaves</p>
            </div>
        </div>

        <!-- Attendance Progress -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Attendance Progress</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Overall attendance rate</p>
                </div>
                <?php
                $attColor = 'text-emerald-600';
                $attBg = 'from-emerald-500 to-emerald-600';
                $attLabel = 'Excellent';
                if ($attendance_percentage < 75) { $attColor = 'text-amber-600'; $attBg = 'from-amber-500 to-amber-600'; $attLabel = 'Needs Improvement'; }
                if ($attendance_percentage < 50) { $attColor = 'text-red-600'; $attBg = 'from-red-500 to-red-600'; $attLabel = 'Low'; }
                ?>
                <div class="text-right">
                    <span class="text-3xl font-bold <?php echo $attColor; ?>"><?php echo $attendance_percentage; ?>%</span>
                    <p class="text-xs font-medium text-slate-500 mt-0.5"><?php echo $attLabel; ?></p>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r <?php echo $attBg; ?> h-3 rounded-full transition-all duration-700" style="width: <?php echo $attendance_percentage; ?>%;"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5 pt-5 border-t border-slate-100">
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Total Records</p>
                    <p class="text-base font-semibold text-slate-800 mt-1"><?php echo $total_records; ?></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Present (incl. Late)</p>
                    <p class="text-base font-semibold text-emerald-600 mt-1"><?php echo $present_like_count; ?></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Absent</p>
                    <p class="text-base font-semibold text-red-600 mt-1"><?php echo $summary['absent']; ?></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium tracking-wider">Leaves</p>
                    <p class="text-base font-semibold text-sky-600 mt-1"><?php echo $summary['leave']; ?></p>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Attendance Record</h2>
                        <p class="text-xs text-slate-500">Daily attendance details</p>
                    </div>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                    <?php echo count($attendance_records); ?> Records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200" id="attendance-table">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Batch</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($attendance_records as $record): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                                <path d="M16 2v4M8 2v4M3 10h18"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">
                                            <?php echo date('j F Y', strtotime($record['date'])); ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <?php echo htmlspecialchars($record['batch_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php
                                    $status = $record['status'];
                                    $badgeClass = 'bg-slate-100 text-slate-600';
                                    $dotClass = 'bg-slate-400';
                                    if ($status === 'present') { $badgeClass = 'bg-emerald-50 text-emerald-700'; $dotClass = 'bg-emerald-500'; }
                                    elseif ($status === 'absent') { $badgeClass = 'bg-red-50 text-red-700'; $dotClass = 'bg-red-500'; }
                                    elseif ($status === 'late') { $badgeClass = 'bg-amber-50 text-amber-700'; $dotClass = 'bg-amber-500'; }
                                    elseif ($status === 'leave') { $badgeClass = 'bg-sky-50 text-sky-700'; $dotClass = 'bg-sky-500'; }
                                    ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                        <span class="h-1.5 w-1.5 rounded-full <?php echo $dotClass; ?>"></span>
                                        <?php echo htmlspecialchars(ucfirst($status)); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="no-results" class="hidden p-8 text-center text-slate-500">
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