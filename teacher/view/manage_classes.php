<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-8">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
        </span>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Online Classes</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage your virtual classes</p>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
            <p class="text-green-700 text-sm"><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- Create Class Form -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100 mb-8">
        <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600"></div>
        <div class="p-6 sm:p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Create New Class</h2>
            <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="create_class">
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Class Title</label>
                    <input type="text" id="title" name="title" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="e.g., Algebra Basics">
                </div>
                
                <div>
                    <label for="batch_id" class="block text-sm font-medium text-gray-700 mb-1">Batch</label>
                    <select name="batch_id" id="batch_id" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Select Batch --</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label for="meet_link" class="block text-sm font-medium text-gray-700 mb-1">Google Meet Link</label>
                    <input type="url" id="meet_link" name="meet_link" required 
                           placeholder="https://meet.google.com/..." 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="datetime-local" id="start_time" name="start_time" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="datetime-local" id="end_time" name="end_time" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                
                <div class="md:col-span-2 flex items-center justify-between gap-4 mt-2">
                    <div id="durationInfo" class="text-sm text-gray-700 font-medium"></div>
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm hover:shadow-md">
                        Create Class
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Classes Table -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">My Classes</h2>
    <?php if (empty($classes)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            <p class="mt-4 text-gray-500 text-lg">No classes created yet.</p>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Batch</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Meet Link</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Token</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Start</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">End</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($classes as $class): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($class['title']); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?php echo htmlspecialchars($class['batch_name']); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="<?php echo htmlspecialchars($class['meet_link']); ?>" target="_blank" 
                                       class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                        Join
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono text-gray-600"><?php echo htmlspecialchars($class['token']); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <?php echo date('M d, Y g:i A', strtotime($class['start_time'])); ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <?php echo date('M d, Y g:i A', strtotime($class['end_time'])); ?>
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium">
                                    <form method="POST" action="" onsubmit="return confirm('Delete this class? Attendance records will also be deleted.');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="delete_class">
                                        <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    const startInput = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');
    const durationInfo = document.getElementById('durationInfo');

    function formatTime(date) {
        if (isNaN(date.getTime())) return '';
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }

    function formatDate(date) {
        if (isNaN(date.getTime())) return '';
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function updateDuration() {
        const startVal = startInput.value;
        const endVal = endInput.value;

        if (startVal) {
            const startDate = new Date(startVal);
            const startFormatted = formatDate(startDate) + ' ' + formatTime(startDate);
            durationInfo.innerHTML = `<strong>Start:</strong> ${startFormatted}`;
        }

        if (startVal && endVal) {
            const startDate = new Date(startVal);
            const endDate = new Date(endVal);

            if (endDate > startDate) {
                const diffMs = endDate - startDate;
                const totalMinutes = Math.floor(diffMs / 60000);
                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;
                let durationText = '';
                if (hours > 0) {
                    durationText += hours + ' hour' + (hours > 1 ? 's' : '');
                }
                if (minutes > 0) {
                    if (durationText) durationText += ' ';
                    durationText += minutes + ' minute' + (minutes > 1 ? 's' : '');
                }
                if (!durationText) durationText = '0 minutes';
                durationInfo.innerHTML += ` | <strong>End:</strong> ${formatDate(endDate)} ${formatTime(endDate)} | <strong>Duration:</strong> ${durationText}`;
            } else {
                durationInfo.innerHTML += ' | <span style="color:red;">End time must be after start time.</span>';
            }
        }
    }

    startInput.addEventListener('change', updateDuration);
    endInput.addEventListener('change', updateDuration);
</script>

<?php include FOOTER; ?>