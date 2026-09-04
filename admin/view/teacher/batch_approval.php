<?php include HEADER; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Batch Management</h1>
            <p class="text-sm text-slate-500 mt-1">Create, manage, and organize student batches.</p>
        </div>
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                id="batch-search"
                placeholder="Search batches..."
                class="block w-full pl-11 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl shadow-sm text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            >
        </div>
    </div>

    <!-- Alerts -->
    <?php if (!empty($message)): ?>
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-xl">
            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Action Buttons Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6 flex flex-wrap items-center gap-3">
        <button type="button" onclick="openModal('createBatchModal')" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2.5 px-4 rounded-xl shadow-sm transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Create Batch
        </button>
        <button type="button" onclick="openModal('addStudentModal')" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium text-sm py-2.5 px-4 rounded-xl shadow-sm transition-colors">
            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Add Student
        </button>
        <button type="button" onclick="openModal('removeStudentModal')" class="inline-flex items-center gap-2 bg-white border border-red-200 hover:bg-red-50 text-red-600 font-medium text-sm py-2.5 px-4 rounded-xl shadow-sm transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h5m0 0l-1 4m1-4l-4 1M6 10h2m0 0L7 6m1 4l-4-1m4 9V11m0 10a2 2 0 01-2 2H6a2 2 0 01-2-2V11h10v9a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Remove Student
        </button>
        <button type="button" onclick="openModal('transferStudentModal')" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium text-sm py-2.5 px-4 rounded-xl shadow-sm transition-colors">
            <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Transfer Student
        </button>
    </div>

    <!-- ==================== MODALS ==================== -->
    
    <!-- 1. Create Batch Modal -->
    <div id="createBatchModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('createBatchModal')"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 transform transition-all">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Create New Batch</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Fill in the details below</p>
                    </div>
                    <button onclick="closeModal('createBatchModal')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="create_batch">
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Batch Name</label>
                        <input type="text" name="batch_name" required placeholder="e.g., Morning Batch 2024" class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Assign Teacher</label>
                        <select name="teacher_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Select Teacher --</option>
                            <?php foreach ($teachers as $teacher): ?>
                                <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['full_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Starting Date</label>
                            <input type="date" name="starting_date" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Batch Time</label>
                            <input type="text" name="batch_time" required placeholder="09:00 AM" class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('createBatchModal')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-sm transition-colors">Create Batch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. Add Student Modal -->
    <div id="addStudentModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('addStudentModal')"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 transform transition-all">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Add Student to Batch</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Assign an unassigned student</p>
                    </div>
                    <button onclick="closeModal('addStudentModal')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="add_student_to_existing">
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Select Batch</label>
                       <select name="batch_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
    <option value="">-- Select Batch --</option>
    <?php foreach ($batches as $batch): ?>
        <option value="<?php echo $batch['id']; ?>">
            <?php echo htmlspecialchars(
                $batch['batch_name'] . ' (' . $batch['batch_time'] . ') - Teacher: ' . $batch['teacher_name']
            ); ?>
        </option>
    <?php endforeach; ?>
</select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Select Student</label>
                        <select name="student_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
    <option value="">-- Select Student --</option>
    <?php foreach ($unassigned_students as $student): ?>
        <option value="<?php echo $student['id']; ?>">
            <?php echo htmlspecialchars(
                $student['full_name'] . ' (' . $student['student_id'] . ') - Teacher: ' . $student['teacher_name']
            ); ?>
        </option>
    <?php endforeach; ?>
</select>
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('addStudentModal')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-sm transition-colors">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. Remove Student Modal -->
    <div id="removeStudentModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('removeStudentModal')"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 transform transition-all">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Remove Student</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Remove from assigned batch</p>
                    </div>
                    <button onclick="closeModal('removeStudentModal')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="remove_student">
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Select Batch</label>
                        <select id="remove_batch_select" name="batch_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Select Batch --</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Select Student</label>
                        <select id="remove_student_select" name="student_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Select Student --</option>
                        </select>
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('removeStudentModal')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-sm transition-colors">Remove Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 4. Transfer Student Modal -->
    <div id="transferStudentModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('transferStudentModal')"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 transform transition-all">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Transfer Student</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Move to a different batch</p>
                    </div>
                    <button onclick="closeModal('transferStudentModal')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="transfer_student">
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Current Batch</label>
                        <select id="transfer_current_batch" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Select Current Batch --</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Select Student</label>
                        <select id="transfer_student_select" name="student_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Select Student --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Destination Batch</label>
                        <select name="new_batch_id" required class="block w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Select Batch --</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['batch_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('transferStudentModal')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-sm transition-colors">Transfer Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== BATCHES TABLE ==================== -->
    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200" id="batches-table">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Batch Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Starting Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <?php foreach ($batches as $batch): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900"><?php echo htmlspecialchars($batch['batch_name']); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($batch['teacher_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($batch['starting_date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($batch['batch_time']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    <?php echo $batch['total_students']; ?> Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this batch?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="action" value="delete_batch">
                                    <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-red-600 hover:text-white hover:bg-red-600 px-3 py-1.5 rounded-md border border-red-200 hover:border-red-600 transition-all text-xs font-medium">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- No results message -->
        <div id="no-results" class="hidden p-8 text-center text-slate-500 bg-white">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-medium text-slate-600">No matching batches found.</p>
            <p class="text-xs text-slate-400 mt-1">Try adjusting your search query.</p>
        </div>
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
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = '';
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

// Live search
(function() {
    const searchInput = document.getElementById('batch-search');
    const table = document.getElementById('batches-table');
    const noResults = document.getElementById('no-results');

    if (!searchInput || !table) return;

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
                table.querySelector('tbody').classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                table.querySelector('tbody').classList.remove('hidden');
            }
        }
    });
})();
</script>

<?php include FOOTER; ?>