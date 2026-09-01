<?php include HEADER; ?>

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Admin Dashboard</h1>
    <p class="mt-1 text-sm text-slate-500">Welcome back, <span class="font-medium text-slate-700"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></p>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <p class="text-slate-600">Use the navigation above to manage approvals, students, teachers, and attendance.</p>
</div>

<?php include FOOTER; ?>
