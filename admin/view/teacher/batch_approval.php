<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Batch Management</h1>

    <?php if (!empty($message)): ?>
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <!-- Top Action Buttons -->
    <div class="flex flex-wrap gap-2 mb-6">
        <button type="button" onclick="openModal('createBatchModal')" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
            Create Batch
        </button>
        <button type="button" onclick="openModal('addStudentModal')" 
                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">
            Add Student
        </button>
        <button type="button" onclick="openModal('removeStudentModal')" 
                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">
            Remove Student
        </button>
        <button type="button" onclick="openModal('transferStudentModal')" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
            Transfer Student
        </button>
    </div>

    <!-- ==================== MODALS ==================== -->
    
    <!-- 1. Create Batch Modal -->
    <div id="createBatchModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Create New Batch</h3>
                    <button onclick="closeModal('createBatchModal')" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="create_batch">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batch Name:</label>
                            <input type="text" name="batch_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teacher:</label>
                            <select name="teacher_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Teacher --</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['full_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Starting Date:</label>
                            <input type="date" name="starting_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batch Time:</label>
                            <input type="text" name="batch_time" required placeholder="e.g., 9:00 AM - 11:00 AM" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Create Batch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. Add Student Modal -->
    <div id="addStudentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Add Student to Existing Batch</h3>
                    <button onclick="closeModal('addStudentModal')" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="add_student_to_existing">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Batch:</label>
                            <select name="batch_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Batch --</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name'] . ' - ' . $batch['batch_time'] . ' (Teacher: ' . $batch['teacher_name'] . ')'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Unassigned Student:</label>
                            <select name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Student --</option>
                                <?php foreach ($unassigned_students as $student): ?>
                                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['full_name'] . ' (' . $student['student_id'] . ')'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. Remove Student Modal -->
    <div id="removeStudentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Remove Student from Batch</h3>
                    <button onclick="closeModal('removeStudentModal')" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="remove_student">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Batch:</label>
                            <select id="remove_batch_select" name="batch_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Batch --</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name'] . ' - Teacher: ' . $batch['teacher_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Student:</label>
                            <select id="remove_student_select" name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Student --</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">Remove Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 4. Transfer Student Modal -->
    <div id="transferStudentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Transfer Student to Another Batch</h3>
                    <button onclick="closeModal('transferStudentModal')" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="transfer_student">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Batch:</label>
                            <select id="transfer_current_batch" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Current Batch --</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name'] . ' - Teacher: ' . $batch['teacher_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Student:</label>
                            <select id="transfer_student_select" name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Student --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Destination Batch:</label>
                            <select name="new_batch_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Batch --</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name'] . ' - Teacher: ' . $batch['teacher_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Transfer Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== BATCHES TABLE ==================== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Batch Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Teacher</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Starting Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total Students</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Delete</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($batches as $batch): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($batch['batch_name']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($batch['teacher_name']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($batch['starting_date']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($batch['batch_time']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo $batch['total_students']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form method="POST" action="" onsubmit="return confirm('Kya aap waqai is batch ko delete karna chahte hain?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="action" value="delete_batch">
                                <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript -->
<script>
const allModals = ['createBatchModal', 'addStudentModal', 'removeStudentModal', 'transferStudentModal'];
const studentBatchMap = <?php echo json_encode($student_batch_map); ?>;
const allStudents = <?php echo json_encode($all_students); ?>;

function openModal(modalId) {
    allModals.forEach(id => document.getElementById(id).classList.add('hidden'));
    document.getElementById(modalId).classList.remove('hidden');
}
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
function populateStudentSelect(selectElement, studentsArray) {
    selectElement.innerHTML = '<option value="">-- Select Student --</option>';
    studentsArray.forEach(student => {
        const opt = document.createElement('option');
        opt.value = student.id;
        opt.textContent = student.full_name + ' (' + student.student_id + ')';
        selectElement.appendChild(opt);
    });
}
document.getElementById('remove_batch_select').addEventListener('change', function() {
    const batchId = this.value;
    const filtered = allStudents.filter(student => studentBatchMap[student.id] && studentBatchMap[student.id].batch_id == batchId);
    populateStudentSelect(document.getElementById('remove_student_select'), filtered);
});
document.getElementById('transfer_current_batch').addEventListener('change', function() {
    const batchId = this.value;
    const filtered = allStudents.filter(student => studentBatchMap[student.id] && studentBatchMap[student.id].batch_id == batchId);
    populateStudentSelect(document.getElementById('transfer_student_select'), filtered);
});
</script>

<?php include FOOTER; ?>