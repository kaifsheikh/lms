<?php include HEADER; ?>

<!-- Detail Modal (improved) -->
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 transform transition-all">
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
                <div id="detailOutline" class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 rounded-lg p-4"></div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal (improved) -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 transform transition-all">
            <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Course</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>
            
            <form method="POST" action="" id="editCourseForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="update_course">
                <input type="hidden" name="course_id" id="editCourseId">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                        <input type="text" name="course_name" id="editCourseName" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (months)</label>
                        <input type="number" name="duration" id="editDuration" min="1" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Admission Fee</label>
                        <input type="number" step="0.01" name="admission_fee" id="editAdmission" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Price</label>
                        <input type="number" step="0.01" name="total_price" id="editTotal" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skill Level</label>
                        <select name="skill_level" id="editSkill" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
                        <input type="text" name="schedule" id="editSchedule" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Class Hours</label>
                        <input type="text" name="class_hours" id="editClassHours" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                </div>
                
                <div class="mt-4 form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Outline</label>
                    <textarea name="outline" id="editOutline" rows="6" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-y"
                              placeholder="One point per line..."></textarea>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors shadow-sm hover:shadow-md">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
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

// Live search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('course-search');
    const table = document.getElementById('courses-table');
    const noResults = document.getElementById('no-results');

    if (searchInput && table) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResults) {
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }
        });
    }
});
</script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h1 class="text-2xl font-bold text-gray-800">All Courses</h1>
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    id="course-search"
                    placeholder="Search courses..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                >
            </div>
            <a href="<?php echo BASE_URL; ?>/admin/controller/course_management.php" 
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm hover:shadow-md">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Course
            </a>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
            <p class="text-green-700"><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($courses)): ?>
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="mt-4 text-gray-500 text-lg">No courses available.</p>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="courses-table">
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
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </span>
                                        <p class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($course['course_name']); ?></p>
                                    </div>
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
                                        <?php 
                                        if ($course['skill_level'] === 'Advanced') echo 'bg-purple-100 text-purple-800';
                                        elseif ($course['skill_level'] === 'Intermediate') echo 'bg-blue-100 text-blue-800';
                                        else echo 'bg-green-100 text-green-800';
                                        ?>">
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
                                    <button type="button" 
                                            onclick='showDetail(<?php echo json_encode($course); ?>)'
                                            class="text-gray-400 hover:text-indigo-600 mr-3 transition-colors" title="View Details">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            onclick='showEdit(<?php echo json_encode($course); ?>)'
                                            class="text-indigo-600 hover:text-indigo-900 mr-3 transition-colors">
                                        Edit
                                    </button>
                                    <form method="POST" action="" class="inline-block" onsubmit="return confirm('Delete this course?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="delete_course">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- No results message -->
            <div id="no-results" class="hidden p-8 text-center text-gray-500">
                No matching courses found.
            </div>
        </div>

        <!-- Dropdown section for course details (improved) -->
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-600"></div>
            <div class="p-6 sm:p-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Course Details</h2>
                <div class="max-w-md">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select a Course</label>
                    <select id="courseSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <option value="">-- Select Course --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="courseDetails" class="mt-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 uppercase font-medium">Duration</p>
                            <p class="font-medium text-gray-900 mt-1" id="detailDuration2"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 uppercase font-medium">Admission Fee</p>
                            <p class="font-medium text-gray-900 mt-1" id="detailAdmission2"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 uppercase font-medium">Total Price</p>
                            <p class="font-medium text-gray-900 mt-1" id="detailTotal2"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 uppercase font-medium">Skill Level</p>
                            <p class="font-medium text-gray-900 mt-1" id="detailSkill2"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 uppercase font-medium">Schedule</p>
                            <p class="font-medium text-gray-900 mt-1" id="detailSchedule2"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 uppercase font-medium">Class Hours</p>
                            <p class="font-medium text-gray-900 mt-1" id="detailClassHours2"></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 uppercase font-medium">Outline</p>
                        <div id="detailOutline2" class="mt-2 bg-gray-50 rounded-lg p-4 text-sm text-gray-700 whitespace-pre-line"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include FOOTER; ?>