<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Manage Students</h1>
</div>

<?php if (!empty($message)): ?>
    <p class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($message); ?>
    </p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
        <?php echo htmlspecialchars($error); ?>
    </p>
<?php endif; ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Full Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Father Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Contact</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Course</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Assigned Teacher</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Change Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $row): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500"><?php echo $row['id']; ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['father_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['contact_number']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php
                                $status = $row['status'];
                                $badgeClass = 'bg-slate-100 text-slate-600';
                                if ($status === 'active') {
                                    $badgeClass = 'bg-green-50 text-green-700';
                                } elseif ($status === 'process') {
                                    $badgeClass = 'bg-blue-50 text-blue-700';
                                } elseif ($status === 'pending') {
                                    $badgeClass = 'bg-amber-50 text-amber-700';
                                }
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">
                                <?php echo htmlspecialchars($row['teacher_name'] ?? 'Not Assigned'); ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <form method="POST" action="" class="flex items-center gap-1">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="student_id" value="<?= (int) $row['id'] ?>">
                                    <select name="status" class="border border-slate-300 rounded-md px-2 py-1 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        <option value="pending"  <?php echo ($status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="process"  <?php echo ($status === 'process') ? 'selected' : ''; ?>>Process</option>
                                        <option value="active"   <?php echo ($status === 'active') ? 'selected' : ''; ?>>Active</option>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-1 px-2 rounded-md text-xs transition-colors">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3">
                                    <a href="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/delete.php" class="inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="px-4 py-6 text-center text-sm text-slate-500">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ================= SEARCH STUDENT BY ID SECTION ================= -->
<div class="mt-8">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Search Student by ID</h2>
        <form method="GET" action="" class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
            <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)"
                   value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>"
                   class="border border-slate-300 rounded-lg px-3 py-2 w-full sm:w-64 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">Search</button>
        </form>
        <?php if (!empty($search_error)): ?>
            <p class="text-red-600 text-sm mt-2"><?php echo htmlspecialchars($search_error); ?></p>
        <?php endif; ?>
        <?php if ($searched_student): ?>
            <div class="mt-4 border-t border-slate-200 pt-4">
                <h3 class="text-base font-semibold text-slate-800 mb-3">Student Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm text-slate-600">
                    <p><span class="font-medium text-slate-700">ID:</span> <?php echo htmlspecialchars($searched_student['id']); ?></p>
                    <p><span class="font-medium text-slate-700">Student ID:</span> <?php echo htmlspecialchars($searched_student['student_id']); ?></p>
                    <p><span class="font-medium text-slate-700">Full Name:</span> <?php echo htmlspecialchars($searched_student['full_name']); ?></p>
                    <p><span class="font-medium text-slate-700">Father Name:</span> <?php echo htmlspecialchars($searched_student['father_name']); ?></p>
                    <p><span class="font-medium text-slate-700">Contact:</span> <?php echo htmlspecialchars($searched_student['contact_number']); ?></p>
                    <p><span class="font-medium text-slate-700">Email:</span> <?php echo htmlspecialchars($searched_student['email']); ?></p>
                    <p><span class="font-medium text-slate-700">Gender:</span> <?php echo htmlspecialchars($searched_student['gender']); ?></p>
                    <p><span class="font-medium text-slate-700">Date of Birth:</span> <?php echo htmlspecialchars($searched_student['dob']); ?></p>
                    <p><span class="font-medium text-slate-700">Address:</span> <?php echo htmlspecialchars($searched_student['address']); ?></p>
                    <p><span class="font-medium text-slate-700">Joining Date:</span> <?php echo htmlspecialchars($searched_student['joining_date']); ?></p>
                    <p><span class="font-medium text-slate-700">Course Name:</span> <?php echo htmlspecialchars($searched_student['course_name']); ?></p>
                    <p><span class="font-medium text-slate-700">Class Timing:</span> <?php echo htmlspecialchars($searched_student['class_timing']); ?></p>
                    <p><span class="font-medium text-slate-700">Course Duration:</span> <?php echo htmlspecialchars($searched_student['course_duration']); ?></p>
                    <p><span class="font-medium text-slate-700">Highest Education:</span> <?php echo htmlspecialchars($searched_student['highest_education']); ?></p>
                    <p><span class="font-medium text-slate-700">Status:</span> <?php echo htmlspecialchars($searched_student['status']); ?></p>
                    <p><span class="font-medium text-slate-700">Assigned Teacher ID:</span> <?php echo htmlspecialchars($searched_student['teacher_id'] ?? 'N/A'); ?></p>

                    <?php if (!empty($searched_student['student_pic'])): ?>
                        <p class="flex items-center gap-2"><span class="font-medium text-slate-700">Student Pic:</span>
                            <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo htmlspecialchars($searched_student['student_pic']); ?>" width="100" class="rounded-lg border border-slate-200">
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($searched_student['cnic_pic'])): ?>
                        <p class="flex items-center gap-2"><span class="font-medium text-slate-700">CNIC Pic:</span>
                            <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo htmlspecialchars($searched_student['cnic_pic']); ?>" width="100" class="rounded-lg border border-slate-200">
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-4 flex items-center gap-2">
            <a href="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $searched_student['id']; ?>"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                Edit
            </a>
            <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/delete.php"
                  onsubmit="return confirm('Are you sure you want to delete this student?');">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="student_id" value="<?php echo $searched_student['id']; ?>">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<?php include FOOTER; ?>
