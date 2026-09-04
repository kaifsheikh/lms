<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Page heading and search bar in a flex container -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Teacher Approval</h1>

        <!-- Live search input -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                id="teacher-search"
                placeholder="Search by name, email..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>
    </div>

    <!-- Flash messages -->
    <?php if (!empty($message)): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
            <p class="text-green-700"><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($teachers)): ?>
        <div class="bg-white shadow rounded-lg p-8 text-center">
            <p class="text-gray-500">No teachers found.</p>
        </div>
    <?php else: ?>
        <!-- Table container with horizontal scroll for mobile -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="teachers-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($teachers as $teacher): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $teacher['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($teacher['full_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($teacher['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($teacher['contact']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $status = $teacher['status'];
                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                    if ($status === 'approved') $badgeClass = 'bg-green-100 text-green-800';
                                    elseif ($status === 'pending') $badgeClass = 'bg-yellow-100 text-yellow-800';
                                    elseif ($status === 'rejected') $badgeClass = 'bg-red-100 text-red-800';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <form method="POST" action="" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $teacher['id']; ?>">
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="text-green-600 hover:text-white hover:bg-green-600 px-3 py-1 rounded-md border border-green-600 transition-colors text-xs font-medium">Approve</button>
                                        </form>
                                        <form method="POST" action="" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $teacher['id']; ?>">
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="text-red-600 hover:text-white hover:bg-red-600 px-3 py-1 rounded-md border border-red-600 transition-colors text-xs font-medium">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Empty state for no search results (hidden by default) -->
            <div id="no-results" class="hidden p-8 text-center text-gray-500">
                No matching teachers found.
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    (function() {
        const searchInput = document.getElementById('teacher-search');
        const table = document.getElementById('teachers-table');
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

            // Show/hide empty state message
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