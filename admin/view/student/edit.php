<?php include HEADER; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Student</h1>

    <?php if (!empty($success)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $student['id']; ?>" enctype="multipart/form-data" class="space-y-6 bg-white shadow-md rounded-lg p-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Personal Information</h3>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Father Name:</label>
            <input type="text" name="father_name" value="<?php echo htmlspecialchars($old['father_name'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number:</label>
            <input type="text" name="contact_number" value="<?php echo htmlspecialchars($old['contact_number'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gender:</label>
            <select name="gender" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select --</option>
                <option value="male"   <?php echo (isset($old['gender']) && $old['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo (isset($old['gender']) && $old['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                <option value="other"  <?php echo (isset($old['gender']) && $old['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address:</label>
            <textarea name="address" required
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($old['address'] ?? ''); ?></textarea>
        </div>

        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Login Details</h3>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password (leave blank to keep current):</label>
            <input type="password" name="password" placeholder="Leave blank to keep unchanged"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Course Details</h3>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date:</label>
            <input type="date" name="joining_date" value="<?php echo htmlspecialchars($old['joining_date'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Course Name:</label>
            <input type="text" name="course_name" value="<?php echo htmlspecialchars($old['course_name'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class Timing:</label>
            <input type="text" name="class_timing" value="<?php echo htmlspecialchars($old['class_timing'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Course Duration:</label>
            <input type="text" name="course_duration" value="<?php echo htmlspecialchars($old['course_duration'] ?? ''); ?>" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Highest Education:</label>
            <select name="highest_education" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select --</option>
                <option value="matric"         <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'matric') ? 'selected' : ''; ?>>Matric</option>
                <option value="intermediate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="undergraduate"  <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'undergraduate') ? 'selected' : ''; ?>>Undergraduate</option>
                <option value="postgraduate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'postgraduate') ? 'selected' : ''; ?>>Postgraduate</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
            <select name="status" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="pending" <?php echo ($old['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="process" <?php echo ($old['status'] === 'process') ? 'selected' : ''; ?>>Process</option>
                <option value="active"  <?php echo ($old['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
            </select>
        </div>

        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Documents</h3>

        <?php if (!empty($student['student_pic'])): ?>
            <div class="mb-2">
                <p class="text-sm text-gray-600">Current Student Picture:</p>
                <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo $student['student_pic']; ?>" width="100" class="rounded-md mt-1">
            </div>
        <?php endif; ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Student Picture (leave blank to keep existing, max 2MB):</label>
            <input type="file" name="student_pic" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <?php if (!empty($student['cnic_pic'])): ?>
            <div class="mb-2">
                <p class="text-sm text-gray-600">Current CNIC Picture:</p>
                <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo $student['cnic_pic']; ?>" width="100" class="rounded-md mt-1">
            </div>
        <?php endif; ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">CNIC Picture (leave blank to keep existing, max 2MB):</label>
            <input type="file" name="cnic_pic" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
            Update Student
        </button>
    </form>
</div>

<?php include FOOTER; ?>