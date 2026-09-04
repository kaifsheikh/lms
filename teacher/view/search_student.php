<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-8">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </span>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Student Info</h1>
            <p class="text-sm text-gray-500">Search for a student by their ID to view details</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-600"></div>
        <div class="p-6">
            <form method="GET" action="" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)"
                           value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm hover:shadow-md">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
            </form>
            <?php if (!empty($error)): ?>
                <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                    <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Result Display -->
    <?php if ($searched_student): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Student Details</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                        <?php echo htmlspecialchars($searched_student['student_id']); ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <!-- Full Name -->
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Full Name</p>
                            <p class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($searched_student['full_name']); ?></p>
                        </div>
                    </div>

                    <!-- Course Name -->
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Course Name</p>
                            <p class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($searched_student['course_name']); ?></p>
                        </div>
                    </div>

                    <!-- Class Timing -->
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Class Timing</p>
                            <p class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($searched_student['class_timing']); ?></p>
                        </div>
                    </div>

                    <!-- Course Duration -->
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Course Duration</p>
                            <p class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($searched_student['course_duration']); ?> months</p>
                        </div>
                    </div>

                    <!-- Course End Date -->
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Course End Date</p>
                            <p class="text-sm font-semibold text-gray-800"><?php echo date('j F Y', strtotime($searched_student['course_end_date'])); ?></p>
                        </div>
                    </div>

                    <!-- Current Progress -->
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Current Progress</p>
                            <p class="text-sm font-semibold text-gray-800">
                                Month <?php echo $searched_student['current_course_month']; ?>, Day <?php echo $searched_student['days_elapsed']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>