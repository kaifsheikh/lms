<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Students</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Father Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Teacher</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assign Teacher</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $row): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo $row['id']; ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['student_id']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['father_name']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['course_name']); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <?php
                                    $status = $row['status'];
                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                    if ($status === 'active') {
                                        $badgeClass = 'bg-green-100 text-green-800';
                                    } elseif ($status === 'process') {
                                        $badgeClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($status === 'pending') {
                                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                                    }
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['teacher_name'] ?? 'Not Assigned'); ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <form method="POST" action="" class="flex items-center space-x-1">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="assign_teacher">
                                        <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                        <select name="teacher_id" class="border border-gray-300 rounded-md px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">-- Select --</option>
                                            <?php foreach ($teachers as $teacher): ?>
                                                <?php $selected = ($teacher['id'] == $row['teacher_id']) ? 'selected' : ''; ?>
                                                <option value="<?php echo $teacher['id']; ?>" <?php echo $selected; ?>>
                                                    <?php echo htmlspecialchars($teacher['full_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-2 rounded-md text-xs transition-colors">
                                            Assign
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <form method="POST" action="" class="flex items-center space-x-1">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="student_id" value="<?= (int) $row['id'] ?>">
                                        <select name="status" class="border border-gray-300 rounded-md px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/delete.php" class="inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="px-4 py-4 text-center text-sm text-gray-500">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= SEARCH STUDENT BY ID SECTION ================= -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Search Student by ID</h2>
        <form method="GET" action="" class="flex items-center space-x-2">
            <input type="text" name="student_id" placeholder="Enter Student ID (e.g., STU-xxxxx)" 
                   value="<?php echo htmlspecialchars($_GET['student_id'] ?? ''); ?>" 
                   class="border border-gray-300 rounded-md px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Search</button>
        </form>
        <?php if (!empty($search_error)): ?>
            <p class="text-red-600 mt-2"><?php echo htmlspecialchars($search_error); ?></p>
        <?php endif; ?>
        <?php if ($searched_student): ?>
            <div class="mt-4 border-t pt-4">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Student Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($searched_student['id']); ?></p>
                    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($searched_student['student_id']); ?></p>
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($searched_student['full_name']); ?></p>
                    <p><strong>Father Name:</strong> <?php echo htmlspecialchars($searched_student['father_name']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($searched_student['contact_number']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($searched_student['email']); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($searched_student['gender']); ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($searched_student['dob']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($searched_student['address']); ?></p>
                    <p><strong>Joining Date:</strong> <?php echo htmlspecialchars($searched_student['joining_date']); ?></p>
                    <p><strong>Course Name:</strong> <?php echo htmlspecialchars($searched_student['course_name']); ?></p>
                    <p><strong>Class Timing:</strong> <?php echo htmlspecialchars($searched_student['class_timing']); ?></p>
                    <p><strong>Course Duration:</strong> <?php echo htmlspecialchars($searched_student['course_duration']); ?></p>
                    <p><strong>Highest Education:</strong> <?php echo htmlspecialchars($searched_student['highest_education']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($searched_student['status']); ?></p>
                    <p><strong>Assigned Teacher ID:</strong> <?php echo htmlspecialchars($searched_student['teacher_id'] ?? 'N/A'); ?></p>
                   
                <?php if (!empty($searched_student['student_pic'])): ?>
                    <p><strong>Student Pic:</strong> 
                        <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo htmlspecialchars($searched_student['student_pic']); ?>" width="100">
                    </p>
                <?php endif; ?>
                <?php if (!empty($searched_student['cnic_pic'])): ?>
                    <p><strong>CNIC Pic:</strong> 
                        <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo htmlspecialchars($searched_student['cnic_pic']); ?>" width="100">
                    </p>
                <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>

    <div class="mt-4 flex items-center space-x-2">
    <a href="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $searched_student['id']; ?>" 
       class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
        Edit
    </a>
    <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/delete.php" 
          onsubmit="return confirm('Are you sure you want to delete this student?');">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="student_id" value="<?php echo $searched_student['id']; ?>">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
            Delete
        </button>
    </form>
</div>
    </div>
</div>

<?php include FOOTER; ?>