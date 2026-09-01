<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Batch Management</h1>
</div>

<?php if (!empty($success)): ?>
    <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($success); ?>
    </p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($error); ?>
    </p>
<?php endif; ?>

<!-- ================= SECTION 1: CREATE NEW BATCH ================= -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Create New Batch</h2>
    <form method="POST" action="" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="create_batch">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Batch Name:</label>
            <input type="text" name="batch_name" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Starting Date:</label>
            <input type="date" name="starting_date" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Batch Time:</label>
            <input type="text" name="batch_time" placeholder="e.g., 9:00 AM - 11:00 AM" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            Create Batch
        </button>
    </form>
</div>

<!-- ================= SECTION 2: ASSIGN STUDENT TO EXISTING BATCH ================= -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Assign Student to Existing Batch</h2>
    <?php if (empty($unassigned_students) || empty($batches)): ?>
        <p class="bg-amber-50 border border-amber-200 text-amber-700 text-sm px-4 py-3 rounded-lg">
            Either no unassigned students or no batches available.
        </p>
    <?php else: ?>
        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="assign_to_batch">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Student:</label>
                <select name="student_id" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="">-- Select Student --</option>
                    <?php foreach ($unassigned_students as $student): ?>
                        <option value="<?php echo $student['id']; ?>">
                            <?php echo htmlspecialchars($student['full_name'] . ' (' . $student['student_id'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Batch:</label>
                <select name="batch_id" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="">-- Select Batch --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?php echo $batch['id']; ?>">
                            <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                Assign to Batch
            </button>
        </form>
    <?php endif; ?>
</div>

<!-- ================= SECTION 3: TRANSFER STUDENT TO ANOTHER BATCH ================= -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Transfer Student to Another Batch</h2>
    <?php if (empty($assigned_students) || empty($batches)): ?>
        <p class="bg-amber-50 border border-amber-200 text-amber-700 text-sm px-4 py-3 rounded-lg">
            No assigned students or no batches available for transfer.
        </p>
    <?php else: ?>
        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="transfer_student">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Student (currently in a batch):</label>
                <select name="student_id" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="">-- Select Student --</option>
                    <?php foreach ($assigned_students as $student): ?>
                        <option value="<?php echo $student['id']; ?>">
                            <?php echo htmlspecialchars($student['full_name'] . ' (' . $student['student_id'] . ') - Current Batch: ' . $student['batch_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Destination Batch:</label>
                <select name="new_batch_id" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="">-- Select Batch --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?php echo $batch['id']; ?>">
                            <?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['starting_date'] . ' ' . $batch['batch_time']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                Transfer Student
            </button>
        </form>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>
