<?php include HEADER; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Online Classes</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <!-- Create Class Form -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Create New Class</h2>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="create_class">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Title:</label>
                    <input type="text" name="title" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batch:</label>
                    <select name="batch_id" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                        <option value="">-- Select Batch --</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Google Meet Link:</label>
                    <input type="url" name="meet_link" required placeholder="https://meet.google.com/..." class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Time:</label>
                    <input type="datetime-local" name="start_time" id="start_time" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Time:</label>
                    <input type="datetime-local" name="end_time" id="end_time" required class="border border-gray-300 rounded-md px-3 py-2 w-full">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Create Class</button>
        </form>

        <!-- Duration Display -->
        <div id="durationInfo" class="mt-4 text-sm text-gray-700"></div>
    </div>

    <!-- Classes Table -->
    <h2 class="text-lg font-semibold text-gray-700 mb-4">My Classes</h2>
    <?php if (empty($classes)): ?>
        <p class="text-gray-600">No classes created yet.</p>
    <?php else: ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meet Link</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Token</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">End</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($classes as $class): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><?php echo htmlspecialchars($class['title']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($class['batch_name']); ?></td>
                            <td class="px-4 py-3 text-sm"><a href="<?php echo htmlspecialchars($class['meet_link']); ?>" target="_blank" class="text-blue-600">Join</a></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-mono"><?php echo htmlspecialchars($class['token']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($class['start_time']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm"><?php echo htmlspecialchars($class['end_time']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <form method="POST" action="" onsubmit="return confirm('Delete this class? Attendance records will also be deleted.');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="delete_class">
                                    <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

    function updateDuration() {
        const startVal = startInput.value;
        const endVal = endInput.value;

        if (startVal) {
            const startDate = new Date(startVal);
            const startFormatted = formatTime(startDate);
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
                durationInfo.innerHTML += ` | <strong>End:</strong> ${formatTime(endDate)} | <strong>Duration:</strong> ${durationText}`;
            } else {
                durationInfo.innerHTML += ' | <span style="color:red;">End time must be after start time.</span>';
            }
        }
    }

    startInput.addEventListener('change', updateDuration);
    endInput.addEventListener('change', updateDuration);
</script>

<?php include FOOTER; ?>