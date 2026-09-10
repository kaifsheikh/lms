<?php include HEADER; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">My Fees</h1>
        <p class="text-sm text-slate-500 mt-1">Apni fee payment history aur outstanding balance dekhein.</p>
    </div>

    <?php if ($summary): ?>
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 uppercase font-medium tracking-wider mt-4">Total Fee</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">Rs. <?php echo number_format($summary['total_price'], 0); ?></p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 uppercase font-medium tracking-wider mt-4">Paid Amount</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">Rs. <?php echo number_format($summary['total_paid'], 0); ?></p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/></svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 uppercase font-medium tracking-wider mt-4">Remaining</p>
                <p class="text-2xl font-bold text-red-600 mt-1">Rs. <?php echo number_format($summary['remaining'], 0); ?></p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-start justify-between">
                    <?php
                    $statusColors = [
                        'paid' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'partial' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'overpaid' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                        'unpaid' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'icon' => 'M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                    $sc = $statusColors[$summary['status']] ?? $statusColors['unpaid'];
                    ?>
                    <div class="w-10 h-10 rounded-lg <?php echo $sc['bg']; ?> <?php echo $sc['text']; ?> flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="<?php echo $sc['icon']; ?>"/></svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 uppercase font-medium tracking-wider mt-4">Status</p>
                <div class="mt-1">
                    <?php if ($summary['status'] === 'paid'): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800 rounded-full">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Paid
                        </span>
                    <?php elseif ($summary['status'] === 'partial'): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold bg-amber-100 text-amber-800 rounded-full">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            Partial
                        </span>
                    <?php elseif ($summary['status'] === 'overpaid'): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                            Overpaid
                        </span>
                        <p class="text-xs text-blue-600 mt-1.5 font-medium">Credit: Rs. <?php echo number_format($summary['overpaid_amount'], 0); ?></p>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                            Unpaid
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm text-slate-500">No fee information found.</p>
        </div>
    <?php endif; ?>

    <!-- Payment History -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Payment History</h2>
                    <p class="text-xs text-slate-500">Aap ki saari payments</p>
                </div>
            </div>
            <?php if (!empty($history)): ?>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                    <?php echo count($history); ?> Records
                </span>
            <?php endif; ?>
        </div>

        <?php if (empty($history)): ?>
            <div class="px-6 py-12 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <p class="text-sm text-slate-500">Abhi tak koi payment nahi hui.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($history as $pay): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                                <path d="M16 2v4M8 2v4M3 10h18"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-slate-700 font-medium">
                                            <?php echo date('j F Y', strtotime($pay['payment_date'])); ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <?php echo htmlspecialchars($pay['payment_month']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-emerald-600">
                                        Rs. <?php echo number_format($pay['amount_paid'], 0); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include FOOTER; ?>