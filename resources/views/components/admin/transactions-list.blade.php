<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subscription;

new class extends Component {
    use WithPagination;

    public $start_date = '';
    public $end_date = '';
    public $status = '';

    public function getFilteredQuery()
    {
        $query = Subscription::with('user');

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query;
    }

    public function with(): array
    {
        return [
            'transactions' => $this->getFilteredQuery()->latest()->paginate(10)
        ];
    }

    public function exportPdf()
    {
        $transactions = $this->getFilteredQuery()->latest()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.transactions', ['transactions' => $transactions]);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'transactions.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function exportCsv()
    {
        $transactions = $this->getFilteredQuery()->latest()->get();
        $csvFileName = 'transactions.csv';

        return response()->streamDownload(function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, ['ID', 'User Name', 'Payment Method', 'Sender Account', 'Transaction ID', 'Status', 'Date']);
            
            foreach ($transactions as $tx) {
                fputcsv($file, [
                    $tx->id,
                    optional($tx->user)->name,
                    ucfirst($tx->payment_method),
                    $tx->sender_account,
                    $tx->transaction_id,
                    ucfirst($tx->status),
                    $tx->created_at ? $tx->created_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }
            fclose($file);
        }, $csvFileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ]);
    }

    public function updateStatus($id, $status)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->status = $status;
        
        if ($status === 'approved') {
            // Set expires_at to 30 days from now if it's a monthly subscription
            $subscription->expires_at = now()->addDays(30);
        }
        
        $subscription->save();
        
        session()->flash('success', 'Transaction status updated successfully.');
    }
}; ?>

<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden mt-6">
    <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Recent Transactions</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Monitor payments and subscriptions</p>
                </div>
            </div>

            <div class="flex items-center bg-zinc-100 dark:bg-zinc-800/50 rounded-lg p-1">
                <button wire:click="exportPdf" class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-md text-red-600 hover:bg-white dark:hover:bg-zinc-700 hover:shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    PDF
                </button>
                <button wire:click="exportCsv" class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-md text-emerald-600 hover:bg-white dark:hover:bg-zinc-700 hover:shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="p-6 bg-zinc-50/50 dark:bg-zinc-800/20 border-b border-zinc-200 dark:border-zinc-800">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <flux:input wire:model.live="start_date" type="date" :label="__('Start Date')" />
            </div>
            <div>
                <flux:input wire:model.live="end_date" type="date" :label="__('End Date')" />
            </div>
            <div>
                <flux:select wire:model.live="status" :label="__('Status')">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 text-xs uppercase tracking-wider text-zinc-500 dark:text-zinc-400 font-semibold">
                    <th scope="col" class="px-6 py-4">User</th>
                    <th scope="col" class="px-6 py-4">Method</th>
                    <th scope="col" class="px-6 py-4">Transaction ID</th>
                    <th scope="col" class="px-6 py-4">Date</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-sm shrink-0">
                                {{ substr(optional($transaction->user)->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ optional($transaction->user)->name }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ optional($transaction->user)->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                            {{ ucfirst($transaction->payment_method) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-zinc-600 dark:text-zinc-400">
                        #{{ $transaction->transaction_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $transaction->created_at->format('M d, Y h:i A') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($transaction->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                Pending
                            </span>
                        @elseif($transaction->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                Approved
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-200 dark:border-red-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                Rejected
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        @if($transaction->status === 'pending')
                            <div class="flex justify-end gap-2">
                                <button wire:click="updateStatus({{ $transaction->id }}, 'approved')" class="p-1.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-lg transition-colors tooltip" title="Approve">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button wire:click="updateStatus({{ $transaction->id }}, 'rejected')" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors tooltip" title="Reject">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-zinc-500 dark:text-zinc-400">
                            <svg class="w-12 h-12 mb-3 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <p class="text-base font-medium">No transactions found</p>
                            <p class="text-sm">No transactions match your current filters.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/20">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
