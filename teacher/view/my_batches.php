<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Batches</h1>
        <!-- Search Bar -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                id="batch-search"
                placeholder="Search batches..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
            >
        </div>
    </div>

    <?php if (empty($batches)): ?>
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="mt-4 text-gray-500 text-lg">No batches created yet.</p>
        </div>
    <?php else: ?>
        <div id="batches-container" class="space-y-6">
            <?php foreach ($batches as $batch): ?>
                <div class="batch-card bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                    <!-- Top gradient bar -->
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500"></div>
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <!-- Batch icon -->
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </span>
                                <h2 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($batch['batch_name']); ?></h2>
                            </div>
                            <?php
                            $badge = 'bg-amber-50 text-amber-700';
                            if ($batch['status'] === 'approved') {
                                $badge = 'bg-green-50 text-green-700';
                            } elseif ($batch['status'] === 'rejected') {
                                $badge = 'bg-red-50 text-red-700';
                            }
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $badge; ?>">
                                <span class="h-2 w-2 rounded-full mr-2 bg-current"></span>
                                <?php echo htmlspecialchars($batch['status']); ?>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-5">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Starting Date</p>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($batch['starting_date']); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Time</p>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($batch['batch_time']); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-10a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Students</p>
                                    <p class="text-sm font-medium text-gray-800"><?php echo count($batch['students']); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Created At</p>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($batch['created_at']); ?></p>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-sm font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-3">Students in this Batch</h3>
                        <?php if (empty($batch['students'])): ?>
                            <p class="text-sm text-gray-500 italic">No students assigned.</p>
                        <?php else: ?>
                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student ID</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Course</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <?php foreach ($batch['students'] as $student): ?>
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($student['student_id']); ?></td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo htmlspecialchars($student['full_name']); ?></td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($student['email']); ?></td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($student['course_name']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- No results message for search -->
        <div id="no-results" class="hidden p-8 text-center text-gray-500 mt-6">
            No matching batches found.
        </div>
    <?php endif; ?>
</div>

<script>
// Live search for batches
(function() {
    const searchInput = document.getElementById('batch-search');
    const batchesContainer = document.getElementById('batches-container');
    const noResults = document.getElementById('no-results');

    if (!searchInput || !batchesContainer) return;

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const batchCards = batchesContainer.querySelectorAll('.batch-card');
        let visibleCount = 0;

        batchCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(query)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
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