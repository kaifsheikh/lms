<?php include HEADER; ?>

<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-semibold text-slate-900 mb-6">Attendance</h1>

    <?php if (!empty($error)): ?>
        <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($batches)): ?>
        <form method="GET" action="<?php echo BASE_URL; ?>/teacher/controller/attendance_mark.php" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Select Batch:</label>
                <select name="batch_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="" selected disabled>-- Select Batch --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?php echo $batch['id']; ?>">
                            <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' (' . $batch['batch_time'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Date:</label>
                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">Attendance Mark Karein</button>
        </form>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>
