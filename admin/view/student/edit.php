<?php include HEADER; ?>

<h1>Edit Student</h1>

<?php if (!empty($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="<?php echo BASE_URL; ?>/admin/controller/student/edit.php?id=<?php echo $student['id']; ?>" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <h3>Personal Information</h3>
    <label>Full Name:</label><br>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>" required><br><br>

    <label>Father Name:</label><br>
    <input type="text" name="father_name" value="<?php echo htmlspecialchars($old['father_name'] ?? ''); ?>" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number" value="<?php echo htmlspecialchars($old['contact_number'] ?? ''); ?>" required><br><br>

    <label>Gender:</label><br>
    <select name="gender" required>
        <option value="">-- Select --</option>
        <option value="male"   <?php echo (isset($old['gender']) && $old['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
        <option value="female" <?php echo (isset($old['gender']) && $old['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
        <option value="other"  <?php echo (isset($old['gender']) && $old['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
    </select><br><br>

    <label>Date of Birth:</label><br>
    <input type="date" name="dob" value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>" required><br><br>

    <label>Address:</label><br>
    <textarea name="address" required><?php echo htmlspecialchars($old['address'] ?? ''); ?></textarea><br><br>

    <h3>Login Details</h3>
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required><br><br>

    <label>Password (leave blank to keep current):</label><br>
    <input type="password" name="password" placeholder="Leave blank to keep unchanged"><br><br>

    <h3>Course Details</h3>
    <label>Joining Date:</label><br>
    <input type="date" name="joining_date" value="<?php echo htmlspecialchars($old['joining_date'] ?? ''); ?>" required><br><br>

    <label>Course Name:</label><br>
    <input type="text" name="course_name" value="<?php echo htmlspecialchars($old['course_name'] ?? ''); ?>" required><br><br>

    <label>Class Timing:</label><br>
    <input type="text" name="class_timing" value="<?php echo htmlspecialchars($old['class_timing'] ?? ''); ?>" required><br><br>

    <label>Course Duration:</label><br>
    <input type="text" name="course_duration" value="<?php echo htmlspecialchars($old['course_duration'] ?? ''); ?>" required><br><br>

    <label>Highest Education:</label><br>
    <select name="highest_education" required>
        <option value="">-- Select --</option>
        <option value="matric"         <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'matric') ? 'selected' : ''; ?>>Matric</option>
        <option value="intermediate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
        <option value="undergraduate"  <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'undergraduate') ? 'selected' : ''; ?>>Undergraduate</option>
        <option value="postgraduate"   <?php echo (isset($old['highest_education']) && $old['highest_education'] === 'postgraduate') ? 'selected' : ''; ?>>Postgraduate</option>
    </select><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="pending" <?php echo ($old['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="process" <?php echo ($old['status'] === 'process') ? 'selected' : ''; ?>>Process</option>
        <option value="active"  <?php echo ($old['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
    </select><br><br>

    <h3>Documents</h3>
    <?php if (!empty($student['student_pic'])): ?>
        <p>Current Student Picture: <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo $student['student_pic']; ?>" width="100"></p>
    <?php endif; ?>
    <label>Student Picture (leave blank to keep existing, max 2MB):</label><br>
    <input type="file" name="student_pic" accept="image/*"><br><br>

    <?php if (!empty($student['cnic_pic'])): ?>
        <p>Current CNIC Picture: <img src="<?php echo BASE_URL; ?>/assets/uploads/students/<?php echo $student['cnic_pic']; ?>" width="100"></p>
    <?php endif; ?>
    <label>CNIC Picture (leave blank to keep existing, max 2MB):</label><br>
    <input type="file" name="cnic_pic" accept="image/*"><br><br>

    <button type="submit">Update Student</button>
</form>

<?php include FOOTER; ?>