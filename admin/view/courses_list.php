<?php include HEADER; ?>

<!-- Detail Modal (existing, outline ke liye bhi inline style add) -->
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6">
            <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-900" id="detailModalTitle">Course Details</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-medium">Duration</p>
                    <p class="text-sm text-gray-900 font-medium" id="detailDuration"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-medium">Admission Fee</p>
                    <p class="text-sm text-gray-900 font-medium" id="detailAdmission"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-medium">Total Price</p>
                    <p class="text-sm text-gray-900 font-medium" id="detailTotal"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-medium">Skill Level</p>
                    <p class="text-sm text-gray-900 font-medium" id="detailSkill"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-medium">Schedule</p>
                    <p class="text-sm text-gray-900 font-medium" id="detailSchedule"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-medium">Class Hours</p>
                    <p class="text-sm text-gray-900 font-medium" id="detailClassHours"></p>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <p class="text-xs text-gray-500 uppercase font-medium mb-2">Course Outline</p>
                <div id="detailOutline" class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 rounded-lg p-4" style="white-space: pre-line;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal (existing) -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full p-6">
            <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Course</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>
            
            <form method="POST" action="" id="editCourseForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="update_course">
                <input type="hidden" name="course_id" id="editCourseId">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course Name:</label>
                        <input type="text" name="course_name" id="editCourseName" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (months):</label>
                        <input type="number" name="duration" id="editDuration" min="1" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Admission Fee:</label>
                        <input type="number" step="0.01" name="admission_fee" id="editAdmission" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Price:</label>
                        <input type="number" step="0.01" name="total_price" id="editTotal" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skill Level:</label>
                        <select name="skill_level" id="editSkill" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Schedule:</label>
                        <input type="text" name="schedule" id="editSchedule" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Class Hours:</label>
                        <input type="text" name="class_hours" id="editClassHours" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Outline:</label>
                    <textarea name="outline" id="editOutline" rows="6" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Har line par ek point likhein..."></textarea>
                </div>
                
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions (existing)
function showDetail(data) {
    document.getElementById('detailModalTitle').textContent = data.course_name;
    document.getElementById('detailDuration').textContent = data.duration + ' months';
    document.getElementById('detailAdmission').textContent = data.admission_fee;
    document.getElementById('detailTotal').textContent = data.total_price;
    document.getElementById('detailSkill').textContent = data.skill_level;
    document.getElementById('detailSchedule').textContent = data.schedule;
    document.getElementById('detailClassHours').textContent = data.class_hours;
    document.getElementById('detailOutline').textContent = data.outline || 'No outline provided.';
    document.getElementById('detailModal').classList.remove('hidden');
}
function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

function showEdit(data) {
    document.getElementById('editCourseId').value = data.id;
    document.getElementById('editCourseName').value = data.course_name;
    document.getElementById('editDuration').value = data.duration;
    document.getElementById('editAdmission').value = data.admission_fee;
    document.getElementById('editTotal').value = data.total_price;
    document.getElementById('editSkill').value = data.skill_level;
    document.getElementById('editSchedule').value = data.schedule;
    document.getElementById('editClassHours').value = data.class_hours;
    document.getElementById('editOutline').value = data.outline || '';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Dropdown se course details show karne ke liye
const coursesData = <?php echo json_encode($courses); ?>;
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('courseSelect');
    if (select) {
        select.addEventListener('change', function() {
            const selectedId = parseInt(this.value);
            const detailsDiv = document.getElementById('courseDetails');
            if (selectedId && coursesData) {
                const course = coursesData.find(c => c.id == selectedId);
                if (course) {
                    document.getElementById('detailDuration2').textContent = course.duration + ' months';
                    document.getElementById('detailAdmission2').textContent = course.admission_fee;
                    document.getElementById('detailTotal2').textContent = course.total_price;
                    document.getElementById('detailSkill2').textContent = course.skill_level;
                    document.getElementById('detailSchedule2').textContent = course.schedule;
                    document.getElementById('detailClassHours2').textContent = course.class_hours;
                    document.getElementById('detailOutline2').textContent = course.outline || 'No outline provided.';
                    detailsDiv.classList.remove('hidden');
                }
            } else {
                detailsDiv.classList.add('hidden');
            }
        });
    }
});
</script>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">All Courses</h1>
        <a href="<?php echo BASE_URL; ?>/admin/controller/course_management.php" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
            + Add Course
        </a>
    </div>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (empty($courses)): ?>
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">کوئی کورس موجود نہیں۔</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fees</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Skill</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class Hours</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($courses as $course): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($course['course_name']); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($course['duration']); ?> months
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <p>Admission: Rs. <?php echo number_format($course['admission_fee']); ?></p>
                                <p class="text-xs text-gray-400">Total: Rs. <?php echo number_format($course['total_price']); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?php echo ($course['skill_level'] === 'Advanced') ? 'bg-purple-100 text-purple-800' : (($course['skill_level'] === 'Intermediate') ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                    <?php echo htmlspecialchars($course['skill_level']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($course['schedule']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($course['class_hours']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Detail button removed from here -->
                                <button type="button" 
                                        onclick='showEdit(<?php echo json_encode($course); ?>)'
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </button>
                                <form method="POST" action="" class="inline-block" onsubmit="return confirm('Delete this course?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="delete_course">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Dropdown section for course details -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Course Details</h2>
            <div class="max-w-md">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Course:</label>
                <select id="courseSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Course --</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="courseDetails" class="mt-6 hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="font-medium" id="detailDuration2"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Admission Fee</p>
                        <p class="font-medium" id="detailAdmission2"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Price</p>
                        <p class="font-medium" id="detailTotal2"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Skill Level</p>
                        <p class="font-medium" id="detailSkill2"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Schedule</p>
                        <p class="font-medium" id="detailSchedule2"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Class Hours</p>
                        <p class="font-medium" id="detailClassHours2"></p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Outline</p>
                    <div id="detailOutline2" class="mt-1 whitespace-pre-line bg-gray-50 rounded-lg p-4 text-sm" style="white-space: pre-line;"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>