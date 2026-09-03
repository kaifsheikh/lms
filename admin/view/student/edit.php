<?php include HEADER; ?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold text-slate-900 mb-6">Edit Student</h1>

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

    <form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $student['id']; ?>" enctype="multipart/form-data" class="space-y-4 bg-white rounded-xl border border-slate-200 shadow-sm p-8">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">

        <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2">Personal Information</h3>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Father Name:</label>
            <input type="text" name="father_name" value="<?php echo htmlspecialchars($old['father_name'] ?? ''); ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Contact Number:</label>
            <input type="text" name="contact_number" value="<?php echo htmlspecialchars($old['contact_number'] ?? ''); ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Gender:</label>
            <select name="gender" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select --</option>
                <option value="male"   <?php echo (isset($old['gender']) && $old['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo (isset($old['gender']) && $old['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                <option value="other"  <?php echo (isset($old['gender']) && $old['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Address:</label>
            <textarea name="address" required
                      class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"><?php echo htmlspecialchars($old['address'] ?? ''); ?></textarea>
        </div>

        <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 pt-2">Login Details</h3>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password (leave blank to keep current):</label>
            <input type="password" name="password" placeholder="Leave blank to keep unchanged"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

<h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 pt-2">Course Details</h3>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Joining Date:</label>
    <input type="date" name="joining_date" value="<?php echo htmlspecialchars($old['joining_date'] ?? ''); ?>" required
           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Course:</label>
    <select name="course_id" required
            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): 
            $selected = '';
            // Agar POST se course_id aya hai to usay prefer karo
            if (isset($old['course_id']) && $old['course_id'] == $course['id']) {
                $selected = 'selected';
            } 
            // Agar pehli dafa load ho raha hai to student ke current course se match karo
            elseif (isset($old['course_name']) && isset($old['course_duration']) && $old['course_name'] == $course['course_name'] && $old['course_duration'] == $course['duration']) {
                $selected = 'selected';
            }
        ?>
        <option value="<?php echo $course['id']; ?>" <?php echo $selected; ?>>
            <?php echo htmlspecialchars($course['course_name']) . ' - ' . $course['duration'] . ' months'; ?>
        </option>
        <?php endforeach; ?>
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Class Timing:</label>
    <input type="text" name="class_timing" value="<?php echo htmlspecialchars($old['class_timing'] ?? ''); ?>" required
           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
</div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Highest Education:</label>
            <select name="highest_education" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">-- Select --</option>
                <option value="matric"         <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'matric') ? 'selected' : ''; ?>>Matric</option>
                <option value="intermediate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="undergraduate"  <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'undergraduate') ? 'selected' : ''; ?>>Undergraduate</option>
                <option value="postgraduate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'postgraduate') ? 'selected' : ''; ?>>Postgraduate</option>
            </select>
        </div>



        <h3 class="text-base font-semibold text-slate-800 border-b border-slate-200 pb-2 pt-2">Documents</h3>

        <?php if (!empty($student['student_pic'])): ?>
            <div class="mb-2">
                <p class="text-sm text-slate-500 mb-1">Current Student Picture:</p>
                <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo $student['student_pic']; ?>" width="100" class="rounded-lg border border-slate-200">
            </div>
        <?php endif; ?>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Student Picture (leave blank to keep existing, max 2MB):</label>
            <input type="file" name="student_pic" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        </div>

        <?php if (!empty($student['cnic_pic'])): ?>
            <div class="mb-2">
                <p class="text-sm text-slate-500 mb-1">Current CNIC Picture:</p>
                <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo $student['cnic_pic']; ?>" width="100" class="rounded-lg border border-slate-200">
            </div>
        <?php endif; ?>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">CNIC Picture (leave blank to keep existing, max 2MB):</label>
            <input type="file" name="cnic_pic" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
            Update Student
        </button>
    </form>
</div>

<?php include FOOTER; ?>
