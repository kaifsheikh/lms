<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Student Info</h1>
</div>

<!-- Search Form -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <form method="GET" action="" class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
        <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)"
               value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
               class="border border-slate-300 rounded-lg px-3 py-2 w-full sm:w-64 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            Search
        </button>
    </form>
    <?php if (!empty($error)): ?>
        <p class="text-red-600 text-sm mt-2"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</div>

<!-- Result Display -->
<?php if ($searched_student): ?>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Student Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm text-slate-600">
            <p><span class="font-medium text-slate-700">Full Name:</span> <?php echo htmlspecialchars($searched_student['full_name']); ?></p>
            <p><span class="font-medium text-slate-700">Course Name:</span> <?php echo htmlspecialchars($searched_student['course_name']); ?></p>
            <p><span class="font-medium text-slate-700">Class Timing:</span> <?php echo htmlspecialchars($searched_student['class_timing']); ?></p>
            <p><span class="font-medium text-slate-700">Course Duration:</span> <?php echo htmlspecialchars($searched_student['course_duration']); ?> months</p>
            <p><span class="font-medium text-slate-700">Course End Date:</span> <?php echo date('j F Y', strtotime($searched_student['course_end_date'])); ?></p>
            <p><span class="font-medium text-slate-700">Current Progress:</span> Month <?php echo $searched_student['current_course_month']; ?>, Day <?php echo $searched_student['days_elapsed']; ?></p>
        </div>
    </div>
<?php endif; ?>

<?php include FOOTER; ?>
