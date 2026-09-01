<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Online Classes</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (empty($classes)): ?>
        <p class="text-gray-600">No upcoming or ongoing classes available.</p>
    <?php else: ?>
        <?php foreach ($classes as $class): ?>
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                <h2 class="text-lg font-semibold text-gray-700"><?php echo htmlspecialchars($class['title']); ?></h2>
                <p class="text-sm text-gray-600">Start: <?php echo htmlspecialchars($class['start_time']); ?></p>
                <p class="text-sm text-gray-600">End: <?php echo htmlspecialchars($class['end_time']); ?></p>
                <p class="text-sm text-gray-600 mt-1">
                    Attendance Token: <span class="font-mono font-bold"><?php echo htmlspecialchars($class['token']); ?></span>
                </p>

                <?php if ($class['attended'] || $attendance_success_class_id == $class['id']): ?>
                    <p class="text-green-600 mt-2">Attendance marked.</p>
                    <a href="<?php echo htmlspecialchars($class['meet_link']); ?>" target="_blank" class="inline-block mt-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Join Google Meet</a>
                <?php else: ?>
                    <form method="POST" action="" class="mt-4">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="action" value="mark_attendance">
                        <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Enter Attendance Token to Reveal Meet Link:</label>
                        <input type="text" name="token" required class="border border-gray-300 rounded-md px-3 py-2 w-64">
                        <button type="submit" class="ml-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">Verify & Join</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>